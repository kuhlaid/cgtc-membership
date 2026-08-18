<?php
	/**
	 * Every database adapter must implement the following 5 classes (all which are abstract):
	 * * DatabaseBase
	 * * DatabaseFieldBase
	 * * DatabaseResultBase
	 * * DatabaseRowBase
	 * * DatabaseExceptionBase
	 *
	 * This Database library also has the following classes already defined, and 
	 * Database adapters are assumed to use them internally:
	 * * DatabaseIndex
	 * * DatabaseForeignKey
	 * * DatabaseFieldType (which is an abstract class that solely contains constants)
	 */

	abstract class QDatabaseBase extends QBaseClass {
		// Must be updated for all Adapters
		const Adapter = 'Generic Database Adapter (Abstract)';

		// Protected Member Variables for ALL Database Adapters
		protected $intDatabaseIndex;
		protected $blnEnableProfiling;
		protected $strProfileArray;

		protected $objConfigArray;
		protected $blnConnectedFlag = false;

		protected $strEscapeIdentifierBegin = '"';
		protected $strEscapeIdentifierEnd = '"';
		// wpg - added so we can append any database schema to queries being generated
		protected $strDbSchema = '';

		// Abstract Methods that ALL Database Adapters MUST implement
		abstract public function Connect();
		abstract public function Query($strQuery);
		abstract public function NonQuery($strNonQuery);

		abstract public function GetTables();
		abstract public function InsertId($strTableName = null, $strColumnName = null);

		abstract public function GetFieldsForTable($strTableName);
		abstract public function GetIndexesForTable($strTableName);
		abstract public function GetForeignKeysForTable($strTableName);

		abstract public function TransactionBegin();
		abstract public function TransactionCommit();
		abstract public function TransactionRollBack();

		abstract public function SqlLimitVariablePrefix($strLimitInfo);
		abstract public function SqlLimitVariableSuffix($strLimitInfo);
		abstract public function SqlSortByVariable($strSortByInfo);

		abstract public function Close();

		public function __get($strName) {
			switch ($strName) {
				case 'EscapeIdentifierBegin':
					return $this->strEscapeIdentifierBegin;
				case 'EscapeIdentifierEnd':
					return $this->strEscapeIdentifierEnd;
				case 'EnableProfiling':
					return $this->blnEnableProfiling;
				case 'AffectedRows':
					return -1;

				case 'Adapter':
					$strConstantName = get_class($this) . '::Adapter';
					return constant($strConstantName) . ' (' . $this->objConfigArray['adapter'] . ')';
				case 'Server':
				case 'Port':
				case 'Database':
				case 'Username':
				case 'Password':
					return $this->objConfigArray[strtolower($strName)];

				// wpg - added so we can append database schemas to the generated code
				case 'DbSchema':
					return $this->strDbSchema;
						
				default:
					try {
						return parent::__get($strName);
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}

		/**
		 * Constructs a Database Adapter based on the database index and the configuration array of properties for this particular adapter
		 * Sets up the base-level configuration properties for this database,
		 * namely DB Profiling and Database Index
		 *
		 * @param integer $intDatabaseIndex
		 * @param string[] $objConfigArray configuration array as passed in to the constructor by QApplicationBase::InitializeDatabaseConnections();
		 * @return void
		 */
		public function __construct($intDatabaseIndex, $objConfigArray) {
			// Setup DatabaseIndex
			$this->intDatabaseIndex = $intDatabaseIndex;

			// Save the ConfigArray
			$this->objConfigArray = $objConfigArray;

			// Setup Profiling Array (if applicable)
			$this->blnEnableProfiling = QType::Cast($objConfigArray['profiling'], QType::Boolean);
			if ($this->blnEnableProfiling)
				$this->strProfileArray = array();
				
			
			if (array_key_exists("dbschema",$objConfigArray))
				$this->strDbSchema = $objConfigArray['dbschema'];
		}


		/**
		 * Allows for the enabling of DB profiling while in middle of the script
		 *
		 * @return void
		 */
		public function EnableProfiling() {
			// Only perform profiling initialization if profiling is not yet enabled
			if (!$this->blnEnableProfiling) {
				$this->blnEnableProfiling = true;
				$this->strProfileArray = array();
			}
		}

		/**
		 * If EnableProfiling is on, then log the query to the profile array
		 *
		 * @param string $strQuery
		 * @return void
		 */
		protected function LogQuery($strQuery) {
			// simply push the queries to the error logs for easier profiling and less memory consumption
			//error_log('QDatabaseBase.class.php LogQuery: '.$strQuery); return;
			if ($this->blnEnableProfiling) {
				// Dereference-ize Backtrace Information
				$objDebugBacktrace = debug_backtrace();
				$objDebugBacktrace = unserialize(serialize($objDebugBacktrace) ?? '');

				// Get Rid of Unnecessary Backtrace Info
				$intLength = count($objDebugBacktrace);
				for ($intIndex = 0; $intIndex < $intLength; $intIndex++) {
					if (($intIndex < 2) || ($intIndex > 3))
						$objDebugBacktrace[$intIndex] = 'BackTrace ' . $intIndex;
					else {
						if (array_key_exists('args', $objDebugBacktrace[$intIndex])) {
							$intInnerLength = count($objDebugBacktrace[$intIndex]['args']);
							for ($intInnerIndex = 0; $intInnerIndex < $intInnerLength; $intInnerIndex++)
								if (($objDebugBacktrace[$intIndex]['args'][$intInnerIndex] instanceof QQClause) ||
									($objDebugBacktrace[$intIndex]['args'][$intInnerIndex] instanceof QQCondition))
									$objDebugBacktrace[$intIndex]['args'][$intInnerIndex] = sprintf("[%s]", $objDebugBacktrace[$intIndex]['args'][$intInnerIndex]->__toString());
								else if (is_null($objDebugBacktrace[$intIndex]['args'][$intInnerIndex]))
									$objDebugBacktrace[$intIndex]['args'][$intInnerIndex] = 'null';
								else if (gettype($objDebugBacktrace[$intIndex]['args'][$intInnerIndex]) == 'integer')
									$objDebugBacktrace[$intIndex]['args'][$intInnerIndex] = $objDebugBacktrace[$intIndex]['args'][$intInnerIndex];
								else if (gettype($objDebugBacktrace[$intIndex]['args'][$intInnerIndex]) == 'object')
									$objDebugBacktrace[$intIndex]['args'][$intInnerIndex] = 'Object';
								// changed this statement to an elseif since we will get errors if the type is an array - Oct. 2019 - wpg)
								else if (gettype($objDebugBacktrace[$intIndex]['args'][$intInnerIndex]) == 'string')
									$objDebugBacktrace[$intIndex]['args'][$intInnerIndex] = sprintf("'%s'", $objDebugBacktrace[$intIndex]['args'][$intInnerIndex]);
						}
					}
				}

				// Push it onto the profiling information array
				array_push($this->strProfileArray, $objDebugBacktrace);
				array_push($this->strProfileArray, $strQuery);
			}
		}

		/**
		 * Properly escapes $mixData to be used as a SQL query parameter.
		 * If IncludeEquality is set (usually not), then include an equality operator.
		 * So for most data, it would just be "=".  But, for example,
		 * if $mixData is NULL, then most RDBMS's require the use of "IS".
		 *
		 * @param mixed $mixData
		 * @param boolean $blnIncludeEquality whether or not to include an equality operator
		 * @param boolean $blnReverseEquality whether the included equality operator should be a "NOT EQUAL", e.g. "!="
		 * @return string the properly formatted SQL variable
		 */
		public function SqlVariable($mixData, $blnIncludeEquality = false, $blnReverseEquality = false) {
			// Are we SqlVariabling a BOOLEAN value?
			if (is_bool($mixData)) {
				// Yes
				if ($blnIncludeEquality) {
					// We must include the inequality

					if ($blnReverseEquality) {
						// Do a "Reverse Equality"

						// Check against NULL, True then False
						if (is_null($mixData))
							return 'IS NOT NULL';
						else if ($mixData)
							return '= 0';
						else
							return '!= 0';
					} else {
						// Check against NULL, True then False
						if (is_null($mixData))
							return 'IS NULL';
						else if ($mixData)
							return '!= 0';
						else
							return '= 0';
					}
				} else {
					// Check against NULL, True then False
					if (is_null($mixData))
						return 'NULL';
					else if ($mixData)
						return '1';
					else
						return '0';
				}
			}

			// Check for Equality Inclusion
			if ($blnIncludeEquality) {
				if ($blnReverseEquality) {
					if (is_null($mixData))
						$strToReturn = 'IS NOT ';
					else
						$strToReturn = '!= ';
				} else {
					if (is_null($mixData))
						$strToReturn = 'IS ';
					else
						$strToReturn = '= ';
				}
			} else
				$strToReturn = '';

			// Check for NULL Value
			if (is_null($mixData))
				return $strToReturn . 'NULL';

			// Check for NUMERIC Value
			if (is_integer($mixData) || is_float($mixData))
				return $strToReturn . sprintf('%s', $mixData);

			// Check for DATE Value
			if ($mixData instanceof QDateTime) {
				if ($mixData->IsTimeNull())
					return $strToReturn . sprintf("'%s'", $mixData->toString('YYYY-MM-DD'));
				else
					return $strToReturn . sprintf("'%s'", $mixData->toString(QDateTime::FormatIso));
			}
			
            // wpg - Check for array Value
            if (is_array($mixData)) {
            	$strToReturn = '';
            	// check to see if we are performing an equal or notequal statement
				if ($blnIncludeEquality) {
					// not equal
					// else equal
					if ($blnReverseEquality) {
						$strToReturn = 'NOT IN ';
					}
					else $strToReturn = 'IN ';
				}
            	return $strToReturn. " (" . implode(",", $mixData) . ")";
            }


			// Assume it's some kind of string value
			return $strToReturn . sprintf("'%s'", addslashes($mixData ?? ''));
		}

		public function PrepareStatement($strQuery, $mixParameterArray) {
			foreach ($mixParameterArray as $strKey => $mixValue) {
				if (is_array($mixValue)) {
					$strParameters = array();
					foreach ($mixValue as $mixParameter)
						array_push($strParameters, $this->Database->SqlVariable($mixParameter));
					$strQuery = str_replace(chr(QQNamedValue::DelimiterCode) . '{' . $strKey . '}', implode(',', $strParameters) . ')', $strQuery);
				} else {
					$strQuery = str_replace(chr(QQNamedValue::DelimiterCode) . '{=' . $strKey . '=}', $this->SqlVariable($mixValue, true, false), $strQuery);
					$strQuery = str_replace(chr(QQNamedValue::DelimiterCode) . '{!' . $strKey . '!}', $this->SqlVariable($mixValue, true, true), $strQuery);
					$strQuery = str_replace(chr(QQNamedValue::DelimiterCode) . '{' . $strKey . '}', $this->SqlVariable($mixValue), $strQuery);
				}
			}

			return $strQuery;
		}

		/**
		 * Displays the OutputProfiling results, plus a link which will popup the details of the profiling.
		 *
		 * @return void
		 */
		public function OutputProfiling() {
			if ($this->blnEnableProfiling) {
				printf('<form method="post" id="frmDbProfile%s" action="%s/_core/profile.php"><div>',
					$this->intDatabaseIndex, __VIRTUAL_DIRECTORY__ . __PHP_ASSETS__);
				printf('<input type="hidden" name="strProfileData" value="%s" />',
					base64_encode(serialize($this->strProfileArray)));
				printf('<input type="hidden" name="intDatabaseIndex" value="%s" />', $this->intDatabaseIndex);
				printf('<input type="hidden" name="strReferrer" value="%s" /></div></form>', QApplication::HtmlEntities(QApplication::$RequestUri));

				$intCount = round(count($this->strProfileArray) / 2);
				if ($intCount == 0)
					printf('<b>PROFILING INFORMATION FOR DATABASE CONNECTION #%s</b>: No queries performed.  Please <a href="#" onclick="var frmDbProfile = document.getElementById(\'frmDbProfile%s\'); frmDbProfile.target = \'_blank\'; frmDbProfile.submit(); return false;">click here to view profiling detail</a><br />',
						$this->intDatabaseIndex, $this->intDatabaseIndex);
				else if ($intCount == 1)
					printf('<b>PROFILING INFORMATION FOR DATABASE CONNECTION #%s</b>: 1 query performed.  Please <a href="#" onclick="var frmDbProfile = document.getElementById(\'frmDbProfile%s\'); frmDbProfile.target = \'_blank\'; frmDbProfile.submit(); return false;">click here to view profiling detail</a><br />',
						$this->intDatabaseIndex, $this->intDatabaseIndex);
				else
					printf('<b>PROFILING INFORMATION FOR DATABASE CONNECTION #%s</b>: %s queries performed.  Please <a href="#" onclick="var frmDbProfile = document.getElementById(\'frmDbProfile%s\'); frmDbProfile.target = \'_blank\'; frmDbProfile.submit(); return false;">click here to view profiling detail</a><br />',
						$this->intDatabaseIndex, $intCount, $this->intDatabaseIndex);
			} else {
				_p('<form></form><b>Profiling was not enabled for this database connection (#' . $this->intDatabaseIndex . ').</b>  To enable, ensure that ENABLE_PROFILING is set to TRUE.', false);
			}
		}
	}

	abstract class QDatabaseFieldBase extends QBaseClass {
		protected $strName;
		protected $strComment;
		protected $strOriginalName;
		protected $strTable;
		protected $strOriginalTable;
		protected $strDefault;
		protected $intMaxLength;

		// Bool
		protected $blnIdentity;
		protected $blnNotNull;
		protected $blnPrimaryKey;
		protected $blnUnique;
		protected $blnTimestamp;

		protected $strType;

		public function __get($strName) {
			switch ($strName) {
				case "Name":
					return $this->strName;
				case "OriginalName":
					return $this->strOriginalName;
				case "Comment":
					return $this->strComment;
				case "Table":
					return $this->strTable;
				case "OriginalTable":
					return $this->strOriginalTable;
				case "Default":
					return $this->strDefault;
				case "MaxLength":
					return $this->intMaxLength;
				case "Identity":
					return $this->blnIdentity;
				case "NotNull":
					return $this->blnNotNull;
				case "PrimaryKey":
					return $this->blnPrimaryKey;
				case "Unique":
					return $this->blnUnique;
				case "Timestamp":
					return $this->blnTimestamp;
				case "Type":
					return $this->strType;
				default:
					try {
						return parent::__get($strName);
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}
		
		// wpg - added this set function since we want to add comments into the mix
		public function __set($strName, $mixValue) {
			try {
				switch ($strName) {
					// wpg added to handle comments in the database
					case 'Comment':
						return $this->strComment = QType::Cast($mixValue, QType::String);
				}
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}
						
	}

	abstract class QDatabaseResultBase extends QBaseClass {
		abstract public function FetchArray();
		abstract public function FetchRow();
		abstract public function FetchField();
		abstract public function FetchFields();
		abstract public function CountRows();
		abstract public function CountFields();

		abstract public function GetNextRow();
		abstract public function GetRows();

		abstract public function Close();
	}
	
	abstract class QDatabaseRowBase extends QBaseClass {
		abstract public function GetColumn($strColumnName, $strColumnType = null);
		abstract public function ColumnExists($strColumnName);
		abstract public function GetColumnNameArray();
	}

	abstract class QDatabaseExceptionBase extends QCallerException {
		protected $intErrorNumber;
		protected $strQuery;

		public function __get($strName) {
			switch ($strName) {
				case "ErrorNumber":
					return $this->intErrorNumber;
				case "Query";
					return $this->strQuery;
				default:
					return parent::__get($strName);
			}
		}
	}

	class QDatabaseForeignKey extends QBaseClass {
		protected $strKeyName;
		protected $strColumnNameArray;
		protected $strReferenceTableName;
		protected $strReferenceColumnNameArray;

		public function __construct($strKeyName, $strColumnNameArray, $strReferenceTableName, $strReferenceColumnNameArray) {
			$this->strKeyName = $strKeyName;
			$this->strColumnNameArray = $strColumnNameArray;
			$this->strReferenceTableName = $strReferenceTableName;
			$this->strReferenceColumnNameArray = $strReferenceColumnNameArray;
		}

		public function __get($strName) {
			switch ($strName) {
				case "KeyName":
					return $this->strKeyName;
				case "ColumnNameArray":
					return $this->strColumnNameArray;
				case "ReferenceTableName":
					return $this->strReferenceTableName;
				case "ReferenceColumnNameArray":
					return $this->strReferenceColumnNameArray;
				default:
					try {
						return parent::__get($strName);
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}
	}

	class QDatabaseIndex extends QBaseClass {
		protected $strKeyName;
		protected $blnPrimaryKey;
		protected $blnUnique;
		protected $strColumnNameArray;
		
		public function __construct($strKeyName, $blnPrimaryKey, $blnUnique, $strColumnNameArray) {
			$this->strKeyName = $strKeyName;
			$this->blnPrimaryKey = $blnPrimaryKey;
			$this->blnUnique = $blnUnique;
			$this->strColumnNameArray = $strColumnNameArray;
		}
		
		public function __get($strName) {
			switch ($strName) {
				case "KeyName":
					return $this->strKeyName;
				case "PrimaryKey":
					return $this->blnPrimaryKey;
				case "Unique":
					return $this->blnUnique;
				case "ColumnNameArray":
					return $this->strColumnNameArray;
				default:
					try {
						return parent::__get($strName);
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}
	}

	abstract class QDatabaseFieldType {
		const Blob = "Blob";
		const VarChar = "VarChar";
		const BigInt = "BigInt";
		const Char = "Char";
		const Integer = "Integer";
		const DateTime = "DateTime";
		const Date = "Date";
		const Time = "Time";
		const Float = "Float";
		const Bit = "Bit";
	}
?>