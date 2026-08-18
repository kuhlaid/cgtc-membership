<?php
	/**
	 * Database Adapter for Microsoft SQL Server
	 * Utilizes the Microsoft SQL Server extension php_mssql.dll (win) or the freetds extension (*nix)
	 * 
	 * Oct. 11, 2019 - wpg
	 * - updated to remove the QCODO_OFFSET option of old and take advantage of SQL Server 2012 > pagination queries
	 */



	class QSqlServerDatabase extends QDatabaseBase {
		const Adapter = 'Microsoft SQL Server Database Adapter';

		protected $objMsSql;

		protected $strEscapeIdentifierBegin = '[';
		protected $strEscapeIdentifierEnd = ']';

		/**
		 * Properly escapes $mixData to be used as a SQL query parameter.
		 * If IncludeEquality is set (usually not), then include an equality operator.
		 * So for most data, it would just be "=".  But, for example,
		 * if $mixData is NULL, then most RDBMS's require the use of "IS".
		 *
		 * @param mixed $mixData
		 * @param boolean $blnIncludeEquality whether or not to include an equality operator
		 * @return string the properly formatted SQL variable
		 */
		public function SqlVariable($mixData, $blnIncludeEquality = false, $blnReverseEquality = false) {
			// Are we SqlVariabling a BOOLEAN value?
			if (is_bool($mixData)) {
				// Yes
				if ($blnIncludeEquality) {
					// We must include the inequality

					// Check against NULL, True then False
					if (is_null($mixData))
						return 'IS NULL';
					else if ($mixData)
						return '!= 0';
					else
						return '= 0';
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
				if (is_null($mixData))
					$strToReturn = 'IS ';
				else
					$strToReturn = '= ';
			} else
				$strToReturn = '';

			// Check for NULL Value
			if (is_null($mixData))
				return $strToReturn . 'NULL';

			// Check for NUMERIC Value
			if (is_integer($mixData) || is_float($mixData))
				return $strToReturn . sprintf('%s', $mixData);

			// Check for DATE Value
			if ($mixData instanceof QDateTime)
				return $strToReturn . sprintf("'%s'", $mixData->toString(QDateTime::FormatIso));

			// Assume it's some kind of string value
			// wpg - we need to double up on any single (BUT NOT double quotes) in the data
			$mixData = str_replace("'", "''", $mixData);
			return $strToReturn . sprintf('\'%s\'', $mixData);
		}

		public function SqlLimitVariablePrefix($strLimitInfo) {
			// Setup limit suffix (if applicable) via a TOP clause 
			// Add QCODO_OFFSET tag if applicable

			if (strlen($strLimitInfo ?? '')) {
				if (strpos($strLimitInfo, ';') !== false)
					throw new Exception('Invalid Semicolon in LIMIT Info');
				if (strpos($strLimitInfo, '`') !== false)
					throw new Exception('Invalid Backtick in LIMIT Info');

				// First figure out if we HAVE an offset
				$strArray = explode(',', $strLimitInfo);

				if (count($strArray) == 2) {
					// Yep -- there's an offset
					return sprintf(
						'OFFSET %s ROWS 
						FETCH NEXT %s ROWS ONLY',
						($strArray[0]),
						$strArray[1]);
				} else if (count($strArray) == 1) {
					// we are starting at the beginning
					return 'OFFSET 0 ROWS 
					FETCH NEXT '.$strArray[0].' ROWS ONLY';
				} else {
					throw new QSqlServerDatabaseException('Invalid Limit Info: ' . $strLimitInfo, 0, null);
				}
			}

			return null;
		}

		public function SqlLimitVariableSuffix($strLimitInfo) {
			return null;
		}

		public function SqlSortByVariable($strSortByInfo) {
			// Setup sorting information (if applicable) via a ORDER BY clause
			if (strlen($strSortByInfo ?? '')) {
				if (strpos($strSortByInfo, ';') !== false)
					throw new Exception('Invalid Semicolon in ORDER BY Info');
				if (strpos($strSortByInfo, '`') !== false)
					throw new Exception('Invalid Backtick in ORDER BY Info');

				return "ORDER BY $strSortByInfo";
			}
			
			return null;
		}

		public function Connect() {
			// Lookup Adapter-Specific Connection Properties
			$strServer = $this->Server;
			$strName = $this->Database;
			$strUsername = $this->Username;
			$strPassword = $this->Password;
			$strPort = $this->Port;
			$strDbSchema = $this->DbSchema;
			
			if ($strPort) {
				// Windows Servers
				if (array_key_exists('OS', $_SERVER) && stristr($_SERVER['OS'], 'Win') !== false)
					$strServer .= ',' . $strPort;

				// All Other Servers
				else
					$strServer .= ':' . $strPort;
			}

			// Connect to the Database Server

			// Because the MSSQL extension throws warnings, we want to avoid them
			set_error_handler('QcodoHandleError', 0);

			// wpg - check to see if we are using the old php_mssql PHP plugin or newer php_sqlsrv plugin
			if (function_exists('mssql_connect'))
				$this->objMsSql = mssql_connect($strServer, $strUsername, $strPassword, true);
			else {
				$connectionInfo = array("Database"=>$this->Database, "UID"=>$strUsername, "PWD"=>$strPassword);
				$this->objMsSql = sqlsrv_connect($strServer, $connectionInfo);
			}
			
			if (!$this->objMsSql) {
				if (function_exists('mssql_connect'))
					$objException = new QSqlServerDatabaseException('Unable to connect to Database: ' . mssql_get_last_message(), -1, null);
				else {
				    if( ($errors = sqlsrv_errors() ) != null) {
				        foreach( $errors as $error ) {
				            $err = "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
				            $err .= "code: ".$error[ 'code']."<br />";
				            $err .= "message: ".$error[ 'message']."<br />";
				        }
				    }
					$objException = new QSqlServerDatabaseException('Unable to connect to Database: ' . $err, -1, null);
				}
				$objException->IncrementOffset();
				throw $objException;
			}

			if (function_exists('mssql_connect')) {
				if (!mssql_select_db($strName, $this->objMsSql)) {
					$objException = new QSqlServerDatabaseException('Unable to connect to Database: ' . mssql_get_last_message(), -1, null);
					$objException->IncrementOffset();
					throw $objException;
				}
			}
				
			
			// Restore the error handler to the original
			restore_error_handler();

			// Update Connected Flag
			$this->blnConnectedFlag = true;
		}

		public function __get($strName) {
			switch ($strName) {
				case 'AffectedRows':
					if (function_exists('mssql_connect'))
						return mssql_affected_rows($this->objMsSql);
					else
						return sqlsrv_num_rows($this->objMsSql);
				default:
					try {
						return parent::__get($strName);
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}

		public function Query($strQuery, $params=array(), $options=array()) {
			// Connect if Applicable
			if (!$this->blnConnectedFlag) $this->Connect();

			// Log Query (for Profiling, if applicable)
			$this->LogQuery($strQuery);
//error_log($strQuery);

			// First, check for QCODO_OFFSET<#> for LIMIT INFO Offseting
			// if ( ($intPosition = strpos($strQuery, 'QCODO_OFFSET<')) !== false) {
			// 	$intEndPosition = strpos($strQuery, '>', $intPosition);
			// 	if ($intEndPosition === false)
			// 		throw new QSqlServerDatabaseException('Invalid QCODO_OFFSET', 0, $strQuery);
			// 	$intOffset = QType::Cast(substr($strQuery,
			// 		$intPosition + 13 /* len of QCODO_OFFSET< */,
			// 		$intEndPosition - $intPosition - 13), QType::Integer);
			// 	$strQuery = substr($strQuery, 0, $intPosition) . substr($strQuery, $intEndPosition + 1);
			// } else
			// 	$intOffset = 0;

			// Perform the Query

			// Because the MSSQL extension throws warnings, we want to make our mssql_query
			// call around no error handler
			set_error_handler('QcodoHandleError', 0);
			// To Avoid Long String Truncation (wpg - removing restriction on query so data is not truncated at 65536; need to have php.ini settings set to 2147483647)
			//mssql_query('SET TEXTSIZE 65536', $this->objMsSql);
			//$objResult = mssql_query($strQuery, $this->objMsSql);
			if (function_exists('mssql_connect'))
				$objResult = mssql_query($strQuery, $this->objMsSql);
			else
				$objResult = sqlsrv_query($this->objMsSql, $strQuery, $params, $options);
			
			// wpg test
			//$_SESSION['test'] = $strQuery." (".$objResult.")<hr>";
			restore_error_handler();
			if (!$objResult){
				if (function_exists('mssql_connect')) {
					//error_log( new QSqlServerDatabaseException(mssql_get_last_message(), 0, null));
					// wpg (July 2013) - changed the way the errors were reported (now saving to error log) since I needed to perform queries on tables that do not exist but have the code keep executing
					//throw new QSqlServerDatabaseException(mssql_get_last_message(), 0, null);
				}
				else {
					if( ($errors = sqlsrv_errors() ) != null) {
				        foreach( $errors as $error ) {
				            $err = "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
				            $err .= "code: ".$error[ 'code']."<br />";
				            $err .= "message: ".$error[ 'message']."<br />";
				        }
				    }
					throw new QSqlServerDatabaseException($err, 0, null);
				}
			}

			// Return the Result
			$objSqlServerDatabaseResult = new QSqlServerDatabaseResult($objResult, $this);

			// Perform Offsetting (if applicable)
			// for ($intIndex = 0; $intIndex < $intOffset; $intIndex++) {
			// 	$objRow = $objSqlServerDatabaseResult->FetchRow();
			// 	if (!$objRow)
			// 		return $objSqlServerDatabaseResult;
			// }
			
			return $objSqlServerDatabaseResult;
		}

		public function NonQuery($strNonQuery) {
			// Connect if Applicable
			if (!$this->blnConnectedFlag) $this->Connect();

			// Log Query (for Profiling, if applicable)
			$this->LogQuery($strNonQuery);

			// Perform the Query

			// Because the MSSQL extension throws warnings, we want to make our mssql_query
			// call around no error handler
			set_error_handler('QcodoHandleError', 0);
			if (function_exists('mssql_connect'))
				$objResult = mssql_query($strNonQuery, $this->objMsSql);
			else
				$objResult = sqlsrv_query($this->objMsSql, $strNonQuery);
			restore_error_handler();

			if (!$objResult){
				if (function_exists('mssql_connect'))
					throw new QSqlServerDatabaseException(mssql_get_last_message(), 0, $strNonQuery);
				else {
					if( ($errors = sqlsrv_errors() ) != null) {
				        foreach( $errors as $error ) {
				            $err = "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
				            $err .= "code: ".$error[ 'code']."<br />";
				            $err .= "message: ".$error[ 'message']."<br />";
				        }
				    }
					throw new QSqlServerDatabaseException($err, 0, $strNonQuery);
				}
			}
		}

		public function GetTables() {
			
			//print "USE ".$this->Database.";SELECT name FROM sysobjects WHERE (OBJECTPROPERTY(id, N'IsTable') = 1) AND (name NOT LIKE N'#%') AND (OBJECTPROPERTY(id, N'IsMSShipped') = 0) AND (OBJECTPROPERTY(id, N'IsSystemTable') = 0) ORDER BY name ASC";
			

//			$objResult = $this->Query("SELECT name FROM sysobjects WHERE xtype='U' ORDER BY name ASC");
			$objResult = $this->Query("SELECT name FROM sysobjects WHERE (OBJECTPROPERTY(id, N'IsTable') = 1) AND (name NOT LIKE N'#%') AND (OBJECTPROPERTY(id, N'IsMSShipped') = 0) AND (OBJECTPROPERTY(id, N'IsSystemTable') = 0) ORDER BY name ASC");
			$strToReturn = array();
			while ($strRowArray = $objResult->FetchRow())
				array_push($strToReturn, $strRowArray[0]);
			return $strToReturn;
		}
		
		public function GetTableForId($intTableId) {
			$intTableId = $this->SqlVariable($intTableId);
			// wpg - had to add a USE statement at the beginning or else we get an 'invalid sql display size' error
			$strQuery = sprintf('
				USE %s;
				SELECT
					name
				FROM
					sysobjects
				WHERE
					id = %s
			', $this->Database, $intTableId);
			
			$objResult = $this->Query($strQuery);
			$objRow = $objResult->FetchRow();
			return $objRow[0];
		}

		public function GetFieldsForTable($strTableName) {
			$strTableName = $this->SqlVariable($strTableName);

			// wpg - had to add a USE statement at the beginning or else we get an 'invalid sql display size' error
			$strQuery = sprintf('
				USE %s;
				SELECT
					syscolumns.*
				FROM
					syscolumns,
					sysobjects
				WHERE
					sysobjects.name = %s	AND
					sysobjects.id = syscolumns.id
				ORDER BY
					colorder ASC
			', $this->Database,$strTableName);

			$objResult = $this->Query($strQuery);

			$objFields = array();

			while ($objRow = $objResult->GetNextRow()) {
				array_push($objFields, new QSqlServerDatabaseField($objRow, $this));
			}

			return $objFields;
		}
		// wpg - modified GetFieldsForTable function to capture Comment for each field (only created this for MySQL and not SQL Server)
		public function GetFullFieldsForTable($strTableName) {
			// Connect if Applicable
			if (!$this->blnConnectedFlag) $this->Connect();

			// gets one of the rows from the table so the fields can be extracted using the fetch_field method
			$objResult = $this->Query(sprintf('USE %s;
			SELECT * FROM %s%s%s LIMIT 1', $this->Database, $this->strEscapeIdentifierBegin, $strTableName, $this->strEscapeIdentifierEnd));

			$missingCommentsResultsArray = $objResult->FetchFullFields();

			// now we look for comments in each field using the FULL COLUMNS
			foreach ($missingCommentsResultsArray as $missingCommentsResults){
				$objResult2 = $this->Query("SHOW FULL COLUMNS FROM ".$strTableName." IN ".$this->Database." WHERE Field='".$missingCommentsResults->Name."'");
				$objRow = $objResult2->FetchRow();
				// if we have a comment then add it
				if ($objRow && $objRow[8])
					$missingCommentsResults->Comment = $objRow[8];
			}
			return $missingCommentsResultsArray;
		}

		public function InsertId($strTableName = null, $strColumnName = null) {
			$strQuery = 'SELECT @@identity';
			$objResult = $this->Query($strQuery);
			$objRow = $objResult->FetchRow();
			return $objRow[0];
		}

		public function Close() {
			if (function_exists('mssql_connect'))
				mssql_close($this->objMsSql);
			else
				sqlsrv_close($this->objMsSql);
		}
	
		public function TransactionBegin() {
			$this->NonQuery('BEGIN TRANSACTION;');
		}

		public function TransactionCommit() {
			$this->NonQuery('COMMIT;');
		}

		public function TransactionRollback() {
			$this->NonQuery('ROLLBACK;');
		}

		public function GetIndexesForTable($strTableName) {
			$objIndexArray = array();

			// Use sp_helpindex to pull the indexes
			// $objResult = $this->Query(sprintf('USE %s;
			// exec sp_helpindex %s', $this->Database, $this->SqlVariable($strTableName)));
			$objResult = $this->Query(sprintf('exec sp_helpindex %s', $this->SqlVariable($strTableName)));
			while ($objRow = $objResult->GetNextRow()) {
				$strIndexDescription = $objRow->GetColumn('index_description');
				//print "wpg stuff".$strIndexDescription;
				$strKeyName = $objRow->GetColumn('index_name');
				$blnPrimaryKey = (strpos($strIndexDescription, 'primary key') !== false);
				$blnUnique = (strpos($strIndexDescription, 'unique') !== false);
				$strColumnNameArray = explode(', ', $objRow->GetColumn('index_keys'));
				
				$objIndex = new QDatabaseIndex($strKeyName, $blnPrimaryKey, $blnUnique, $strColumnNameArray);
				array_push($objIndexArray, $objIndex);
			}
			
			return $objIndexArray;
		}

		public function GetForeignKeysForTable($strTableName) {
			$objForeignKeyArray = array();
			
			// Use Query to pull the FKs
			$strQuery = sprintf('
				USE %s;
				SELECT 
				    fk_table  = FK.TABLE_NAME, 
				    fk_column = CU.COLUMN_NAME, 
				    pk_table  = PK.TABLE_NAME, 
				    pk_column = PT.COLUMN_NAME, 
				    constraint_name = C.CONSTRAINT_NAME 
				FROM 
				    INFORMATION_SCHEMA.REFERENTIAL_CONSTRAINTS C 
				    INNER JOIN 
				    INFORMATION_SCHEMA.TABLE_CONSTRAINTS FK 
				        ON C.CONSTRAINT_NAME = FK.CONSTRAINT_NAME 
				    INNER JOIN 
				    INFORMATION_SCHEMA.TABLE_CONSTRAINTS PK 
				        ON C.UNIQUE_CONSTRAINT_NAME = PK.CONSTRAINT_NAME 
				    INNER JOIN 
				    INFORMATION_SCHEMA.KEY_COLUMN_USAGE CU 
				        ON C.CONSTRAINT_NAME = CU.CONSTRAINT_NAME 
				    INNER JOIN 
				    ( 
				        SELECT 
				            i1.TABLE_NAME, i2.COLUMN_NAME 
				        FROM 
				            INFORMATION_SCHEMA.TABLE_CONSTRAINTS i1 
				            INNER JOIN 
				            INFORMATION_SCHEMA.KEY_COLUMN_USAGE i2 
				            ON i1.CONSTRAINT_NAME = i2.CONSTRAINT_NAME 
				            WHERE i1.CONSTRAINT_TYPE = \'PRIMARY KEY\' 
				    ) PT 
				    ON PT.TABLE_NAME = PK.TABLE_NAME 
				WHERE
				    FK.TABLE_NAME = %s
				ORDER BY 
				    constraint_name', $this->Database,
				$this->SqlVariable($strTableName));
			$objResult = $this->Query($strQuery);

			$strKeyName = '';
			while ($objRow = $objResult->GetNextRow()) {
				if ($strKeyName != $objRow->GetColumn('constraint_name')) {
					if ($strKeyName) {
						$objForeignKey = new QDatabaseForeignKey(
							$strKeyName,
							$strColumnNameArray,
							$strReferenceTableName,
							$strReferenceColumnNameArray);
						array_push($objForeignKeyArray, $objForeignKey);
					}

					$strKeyName = $objRow->GetColumn('constraint_name');
					$strReferenceTableName = $objRow->GetColumn('pk_table');
					$strColumnNameArray = array();
					$strReferenceColumnNameArray = array();
				}

				if (!array_search($objRow->GetColumn('fk_column'), $strColumnNameArray)) {
					array_push($strColumnNameArray, $objRow->GetColumn('fk_column'));
				}

				if (!array_search($objRow->GetColumn('pk_column'), $strReferenceColumnNameArray)) {
					array_push($strReferenceColumnNameArray, $objRow->GetColumn('pk_column'));
				}
			}
			
			if ($strKeyName) {
				$objForeignKey = new QDatabaseForeignKey(
					$strKeyName,
					$strColumnNameArray,
					$strReferenceTableName,
					$strReferenceColumnNameArray);
				array_push($objForeignKeyArray, $objForeignKey);
			}

			// Return the Array of Foreign Keys
			return $objForeignKeyArray;
		}
	}

	class QSqlServerDatabaseException extends QDatabaseExceptionBase {
		public function __construct($strMessage, $intNumber, $strQuery) {
			parent::__construct(sprintf("MS SQL Server Error: %s", $strMessage), 2);
			$this->intErrorNumber = $intNumber;
			$this->strQuery = $strQuery;
		}
	}

	class QSqlServerDatabaseResult extends QDatabaseResultBase {
		protected $objMsSqlResult;
		protected $objDb;

		public function __construct($objResult, QSqlServerDatabase $objDb) {
			$this->objMsSqlResult = $objResult;
			$this->objDb = $objDb;
		}

		public function FetchArray() {
			
			// wpg - added this condition for return otherwise you can get an error that the argument is not a valid resultset
			if (is_resource($this->objMsSqlResult)){
				if (function_exists('mssql_connect'))
					return mssql_fetch_array($this->objMsSqlResult);	//mssql result
				else {
					//print 'else';
					return sqlsrv_fetch_array($this->objMsSqlResult);
				}
			}
		}

		public function FetchFields() {
			$objArrayToReturn = array();
			while ($objSqlServerDatabaseField = $this->FetchField())
				array_push($objArrayToReturn, $objSqlServerDatabaseField);
			return $objArrayToReturn;
		}

		// wpg - used to pull comments since you must perform a FULL COLUMNS query
		public function FetchFullFields() {
			$objArrayToReturn = array();
			if (is_resource($this->objMsSqlResult))
			while ($objField = $this->objMsSqlResult->mssql_fetch_field())
				array_push($objArrayToReturn, new QSqlServerDatabaseField($objField, $this->objDb));
			return $objArrayToReturn;
		}
		public function FetchField() {
			if (function_exists('mssql_connect'))
				if ($objField = mssql_fetch_field($this->objMsSqlResult))
					return new QSqlServerDatabaseField($objField, $this->objDb);
			else
				if ($objField = sqlsrv_get_field($this->objMsSqlResult))
					return new QSqlServerDatabaseField($objField, $this->objDb);
		}

		public function FetchRow() {
			if (function_exists('mssql_connect'))
				return mssql_fetch_row($this->objMsSqlResult);
			else
				return sqlsrv_fetch_array($this->objMsSqlResult);
		}

		public function CountRows() {
			if (function_exists('mssql_connect'))
				return mssql_num_rows($this->objMsSqlResult);
			else
				return sqlsrv_num_rows($this->objMsSqlResult);
		}

		public function CountFields() {
			if (function_exists('mssql_connect'))
				return mssql_num_fields($this->objMsSqlResult);
			else
				return sqlsrv_num_fields($this->objMsSqlResult);
		}

		public function Close() {
			if (function_exists('mssql_connect'))
				mssql_free_result($this->objMsSqlResult);
			else
				sqlsrv_free_stmt($this->objMsSqlResult);
		}
		
		public function GetNextRow() {
			$strColumnArray = $this->FetchArray();
			// print 'GetNextRow';
			if ($strColumnArray)
				return new QSqlServerDatabaseRow($strColumnArray);
			else
				return null;
		}

		public function GetRows() {
			$objDbRowArray = array();
			while ($objDbRow = $this->GetNextRow())
				array_push($objDbRowArray, $objDbRow);
			return $objDbRowArray;
		}
	}

	class QSqlServerDatabaseRow extends QDatabaseRowBase {
		protected $strColumnArray;

		public function __construct($strColumnArray) {
			$this->strColumnArray = $strColumnArray;
		}

		public function GetColumn($strColumnName, $strColumnType = null) {
			if (array_key_exists($strColumnName, $this->strColumnArray)) {
				if (is_null($this->strColumnArray[$strColumnName]))
					return null;

				$columnTrimmed = $this->strColumnArray[$strColumnName];
				
				// wpg - mssql_query seems to return whitespaces so we will trim these
				if (isset($columnTrimmed) && is_string($columnTrimmed) && strlen($columnTrimmed ?? '')>0)
					$columnTrimmed = trim($this->strColumnArray[$strColumnName] ?? '');
				
				switch ($strColumnType) {
					case QDatabaseFieldType::Bit:
						return ($columnTrimmed) ? true : false;

					case QDatabaseFieldType::Blob:
					case QDatabaseFieldType::Char:
					case QDatabaseFieldType::VarChar:
						return QType::Cast($columnTrimmed, QType::String);

					case QDatabaseFieldType::Date:
					case QDatabaseFieldType::DateTime:
					case QDatabaseFieldType::Time:
						return new QDateTime($columnTrimmed);

					case QDatabaseFieldType::Float:
						return QType::Cast($columnTrimmed, QType::Float);

					case QDatabaseFieldType::Integer:
						return QType::Cast($columnTrimmed, QType::Integer);

					default:
						return $columnTrimmed;
				}
			} else
				return null;
		}

		public function ColumnExists($strColumnName) {
			return array_key_exists($strColumnName, $this->strColumnArray);
		}

		public function GetColumnNameArray() {
			return $this->strColumnArray;
		}
	}

	class QSqlServerDatabaseField extends QDatabaseFieldBase {
		public function __construct($mixFieldData, $objDb = null) {
			$objDatabaseRow = null;
			try {
				$objDatabaseRow = QType::Cast($mixFieldData, 'QSqlServerDatabaseRow');
			} catch (QInvalidCastException $objExc) {
			}

			//print 'QDatabaseFieldBase';
			if ($objDatabaseRow) {
				// wpg - never makes it into this 

				// Passed in field data is a row from select * from syscolumns for this table
				$intTableId = $objDatabaseRow->GetColumn('id');
				$this->strName = $objDatabaseRow->GetColumn('name');
				$this->strOriginalName = $this->strName;
				$this->strTable = $objDb->GetTableForId($intTableId);
				$this->strOriginalTable = $this->strTable;
				$this->strDefault = null; /* Not Supported */
				$this->intMaxLength = $objDatabaseRow->GetColumn('length', QDatabaseFieldType::Integer);
				$this->blnNotNull = ($objDatabaseRow->GetColumn('isnullable')) ? false : true;

				
				// Determine Primary Key
				// $objResult = $objDb->Query(sprintf("USE %s;
				// EXEC sp_pkeys @table_name='%s'", $this->Database, $this->strTable));
				//print sprintf("EXEC sp_pkeys @table_name='%s'", $this->strTable);
				$objResult = $objDb->Query(sprintf("EXEC sp_pkeys @table_name='%s'", $this->strTable));
				while ($objRow = $objResult->GetNextRow()) {
					//print 'GetNextRow';
					if ($objRow->GetColumn('COLUMN_NAME') == $this->strName)
						$this->blnPrimaryKey = true;
				}				
				if (!$this->blnPrimaryKey)
					$this->blnPrimaryKey = false;

				// UNIQUE
				// First, we assume we're NOT unique
				$this->blnUnique = false;
				
				// Now, get all the single-column indexes for this table (by indid)
				$strQuery = sprintf('
					USE %s;
					SELECT
						indid,
						count(indid) AS column_count
					FROM
						sysindexkeys
					WHERE
						id = %s
					GROUP BY
						indid', $this->Database, $intTableId);
				$objResult = $objDb->Query($strQuery);
				$intIndIdArray = array();
				while ($objRow = $objResult->GetNextRow())
					if ($objRow->GetColumn('column_count') == 1) {
						// We have a single-column index -- add it to the indid array
						array_push($intIndIdArray, $objRow->GetColumn('indid', QDatabasefieldtype::Integer));
					}
				
				if (count($intIndIdArray) > 0) {
					// Get all the single-column index that indexes this column
					$strQuery = sprintf('
						USE %s;
						SELECT
							sysindexes.name
						FROM
							sysindexes,
							sysindexkeys,
							syscolumns
						WHERE
							syscolumns.colid = sysindexkeys.colid	AND
							sysindexes.indid = sysindexkeys.indid	AND
							sysindexkeys.indid IN (%s)				AND
							syscolumns.name = %s					AND
							syscolumns.id = %s						AND
							sysindexkeys.id = %s					AND
							sysindexes.id = %s
					', $this->Database,
						implode(',', $intIndIdArray),
						$objDb->SqlVariable($this->strName),
						$intTableId,
						$intTableId,
						$intTableId);
					
					$objResult = $objDb->Query($strQuery);
					
					while ($objRow = $objResult->FetchRow()) {
						$strQuery = sprintf("SELECT indexproperty(%s, %s, 'IsUnique')",
							$intTableId, $objDb->SqlVariable($objRow[0]));
						$objIndexPropertyResult = $objDb->Query($strQuery);
						$objRow = $objIndexPropertyResult->FetchRow();
						if ($objRow[0])
							$this->blnUnique = true;
					}
				}


				// Figure out Type and Identity by using sp_columns
				$objResult = $objDb->Query(sprintf("USE %s;
				EXEC sp_columns @table_name='%s', @column_name='%s'", $this->Database, $this->strTable, $this->strName));
				$objRow = $objResult->GetNextRow();

				$strTypeName = $objRow->GetColumn('TYPE_NAME');
				$intScale = $objRow->GetColumn('SCALE');
				$this->blnIdentity = (strpos($strTypeName, 'identity') !== false) ? true : false;

				// We're only going to use the first word of the TYPE_NAME
				if (strpos($strTypeName, ' ') !== false)
					$strTypeName = substr($strTypeName, 0, strpos($strTypeName, ' '));
				$this->strType = $strTypeName;

				switch ($strTypeName) {
					case 'numeric':
					case 'numeric()':
					case 'decimal':
					case 'decimal()':
						if ($intScale == 0)
							$this->strType = QDatabaseFieldType::Integer;
						else
							$this->strType = QDatabaseFieldType::Float;
						break;
					case 'bigint':
						$this->strType = QDatabaseFieldType::BigInt;
						break;
					case 'int':
					case 'tinyint':
					case 'smallint':
						$this->strType = QDatabaseFieldType::Integer;
						break;
					case 'money':
					case 'real':
					case 'float':
					case 'smallmoney':
						$this->strType = QDatabaseFieldType::Float;
						break;
					case 'bit':
						$this->strType = QDatabaseFieldType::Bit;
						break;
					case 'char':
					case 'nchar':
						$this->strType = QDatabaseFieldType::Char;
						break;
					case 'varchar':
					case 'nvarchar':
						$this->strType = QDatabaseFieldType::VarChar;
						break;
					case 'text':
					case 'ntext':
					case 'binary':
					case 'image':
					case 'varbinary':
					case 'uniqueidentifier':
					case 'unique_identifier':
						$this->strType = QDatabaseFieldType::Blob;
						$this->intMaxLength = null;
						break;
					case 'datetime':
					// wpg - had to add 'datetime2' to codegen against latest MS SQL server
					case 'datetime2':
					case 'smalldatetime':
						$this->strType = QDatabaseFieldType::DateTime;
						break;
					case 'date':
						$this->strType = QDatabaseFieldType::Date;
						break;
					case 'time':
						$this->strType = QDatabaseFieldType::Time;
						break;
					case 'timestamp':
						// System-generated Timestamp values need to be treated as plain text
						$this->strType = QDatabaseFieldType::VarChar;
						$this->blnTimestamp = true;
						break;
					default:
						throw new QSqlServerDatabaseException('Unsupported Field Type: ' . $strTypeName, 0, null);
				}
			} else {
				// Passed in fielddata is a mssql_fetch_field field result
				$this->strName = $mixFieldData->name;
				$this->strOriginalName = $mixFieldData->name;
				$this->strTable = $mixFieldData->column_source;
				$this->strOriginalTable = $mixFieldData->column_source;
				$this->intMaxLength = $mixFieldData->max_length;
			}
		}
	}
?>