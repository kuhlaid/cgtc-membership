<?php
	/**
	 * The abstract MemberRaceResultGen class defined here is
	 * code-generated and contains all the basic CRUD-type functionality as well as
	 * basic methods to handle relationships and index-based loading.
	 *
	 * To use, you should use the MemberRaceResult subclass which
	 * extends this MemberRaceResultGen class.
	 *
	 * Because subsequent re-code generations will overwrite any changes to this
	 * file, you should leave this file unaltered to prevent yourself from losing
	 * any information or code changes.  All customizations should be done by
	 * overriding existing or implementing new methods, properties and variables
	 * in the MemberRaceResult class.
	 * 
	 * @package My Application
	 * @subpackage GeneratedDataObjects
	 * 
	 */
	class MemberRaceResultGen extends QBaseClass {
		///////////////////////////////
		// COMMON LOAD METHODS
		///////////////////////////////

		/**
		 * Load a MemberRaceResult from PK Info
		 * @param integer $intId
		 * @return MemberRaceResult
		 */
		public static function Load($intId) {
			// Use QuerySingle to Perform the Query
			return MemberRaceResult::QuerySingle(
				QQ::Equal(QQN::MemberRaceResult()->Id, $intId)
			);
		}

		/**
		 * Load all MemberRaceResults
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return MemberRaceResult[]
		 */
		public static function LoadAll($objOptionalClauses = null) {
			// Call MemberRaceResult::QueryArray to perform the LoadAll query
			try {
				return MemberRaceResult::QueryArray(QQ::All(), $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count all MemberRaceResults
		 * @return int
		 */
		public static function CountAll() {
			// Call MemberRaceResult::QueryCount to perform the CountAll query
			return MemberRaceResult::QueryCount(QQ::All());
		}



		///////////////////////////////
		// QCODO QUERY-RELATED METHODS
		///////////////////////////////

		/**
		 * Static method to retrieve the Database object that owns this class.
		 * @return QDatabaseBase reference to the Database object that can query this class
		 */
		public static function GetDatabase() {
			return QApplication::$Database[1];
		}

		/**
		 * Internally called method to assist with calling Qcodo Query for this class
		 * on load methods.
		 * @param QQueryBuilder &$objQueryBuilder the QueryBuilder object that will be created
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with (sending in null will skip the PrepareStatement step)
		 * @param boolean $blnCountOnly only select a rowcount
		 * @return string the query statement
		 */
		protected static function BuildQueryStatement(&$objQueryBuilder, QQCondition $objConditions, $objOptionalClauses, $mixParameterArray, $blnCountOnly,$selectionArray = null) {
			// Get the Database Object for this Class
			$objDatabase = MemberRaceResult::GetDatabase();

			// Create/Build out the QueryBuilder object with MemberRaceResult-specific SELET and FROM fields
			$objQueryBuilder = new QQueryBuilder($objDatabase, 'MemberRaceResult');
			MemberRaceResult::GetSelectFields($objQueryBuilder,null,$selectionArray);
			$objQueryBuilder->AddFromItem('`MemberRaceResult` AS `MemberRaceResult`');

			// Set "CountOnly" option (if applicable)
			if ($blnCountOnly)
				$objQueryBuilder->SetCountOnlyFlag();
				// wpg - added to specify that we want a select field to count
				if ($selectionArray)
					$objQueryBuilder->SetCountSingle($selectionArray[0]);

			// Apply Any Conditions
			if ($objConditions)
				$objConditions->UpdateQueryBuilder($objQueryBuilder);

			// Iterate through all the Optional Clauses (if any) and perform accordingly
			if ($objOptionalClauses) {
				if (!is_array($objOptionalClauses))
					throw new QCallerException('Optional Clauses must be a QQ::Clause() or an array of QQClause objects');
				foreach ($objOptionalClauses as $objClause)
					$objClause->UpdateQueryBuilder($objQueryBuilder);
			}

			// Get the SQL Statement
			$strQuery = $objQueryBuilder->GetStatement();

			// Prepare the Statement with the Query Parameters (if applicable)
			if ($mixParameterArray) {
				if (is_array($mixParameterArray)) {
					if (count($mixParameterArray))
						$strQuery = $objDatabase->PrepareStatement($strQuery, $mixParameterArray);

					// Ensure that there are no other Unresolved Named Parameters
					if (strpos($strQuery, chr(QQNamedValue::DelimiterCode) . '{') !== false)
						throw new QCallerException('Unresolved named parameters in the query');
				} else
					throw new QCallerException('Parameter Array must be an array of name-value parameter pairs');
			}

			// Return the Objects
			return $strQuery;
		}

		/**
		 * Static Qcodo Query method to query for a single MemberRaceResult object.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return MemberRaceResult the queried object
		 */
		public static function QuerySingle(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = MemberRaceResult::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query, Get the First Row, and Instantiate a new MemberRaceResult object
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return MemberRaceResult::InstantiateDbRow($objDbResult->GetNextRow());
		}

		/**
		 * Static Qcodo Query method to query for an array of MemberRaceResult objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return MemberRaceResult[] the queried objects as an array
		 */
		public static function QueryArray(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = MemberRaceResult::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query and Instantiate the Array Result
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return MemberRaceResult::InstantiateDbResult($objDbResult, $objQueryBuilder->ExpandAsArrayNodes);
		}

		/**
		 * Static Qcodo Query method to query for a count of MemberRaceResult objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return integer the count of queried objects as an integer
		 */
		public static function QueryCount(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = MemberRaceResult::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, true,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query and return the row_count
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);

			// Figure out if the query is using GroupBy
			$blnGrouped = false;

			if ($objOptionalClauses) foreach ($objOptionalClauses as $objClause) {
				if ($objClause instanceof QQGroupBy) {
					$blnGrouped = true;
					break;
				}
			}

			if ($blnGrouped)
				// Groups in this query - return the count of Groups (which is the count of all rows)
				return $objDbResult->CountRows();
			else {
				// No Groups - return the sql-calculated count(*) value
				$strDbRow = $objDbResult->FetchRow();
				return QType::Cast($strDbRow[0], QType::Integer);
			}
		}

/*		public static function QueryArrayCached($strConditions, $mixParameterArray = null) {
			// Get the Database Object for this Class
			$objDatabase = MemberRaceResult::GetDatabase();

			// Lookup the QCache for This Query Statement
			$objCache = new QCache('query', 'MemberRaceResult_' . serialize($strConditions));
			if (!($strQuery = $objCache->GetData())) {
				// Not Found -- Go ahead and Create/Build out a new QueryBuilder object with MemberRaceResult-specific fields
				$objQueryBuilder = new QQueryBuilder($objDatabase);
				MemberRaceResult::GetSelectFields($objQueryBuilder);
				MemberRaceResult::GetFromFields($objQueryBuilder);

				// Ensure the Passed-in Conditions is a string
				try {
					$strConditions = QType::Cast($strConditions, QType::String);
				} catch (QCallerException $objExc) {
					$objExc->IncrementOffset();
					throw $objExc;
				}

				// Create the Conditions object, and apply it
				$objConditions = eval('return ' . $strConditions . ';');

				// Apply Any Conditions
				if ($objConditions)
					$objConditions->UpdateQueryBuilder($objQueryBuilder);

				// Get the SQL Statement
				$strQuery = $objQueryBuilder->GetStatement();

				// Save the SQL Statement in the Cache
				$objCache->SaveData($strQuery);
			}

			// Prepare the Statement with the Parameters
			if ($mixParameterArray)
				$strQuery = $objDatabase->PrepareStatement($strQuery, $mixParameterArray);

			// Perform the Query and Instantiate the Array Result
			$objDbResult = $objDatabase->Query($strQuery);
			return MemberRaceResult::InstantiateDbResult($objDbResult);
		}*/

		/**
		 * Updates a QQueryBuilder with the SELECT fields for this MemberRaceResult
		 * @param QQueryBuilder $objBuilder the Query Builder object to update
		 * @param string $strPrefix optional prefix to add to the SELECT fields
		 * @param array $selectionArray optional array of SELECT field items (wpg - added Sept 2012)
		 */
		public static function GetSelectFields(QQueryBuilder $objBuilder, $strPrefix = null, $selectionArray = null) {
			if ($strPrefix) {
				$strTableName = '`' . $strPrefix . '`';
				$strAliasPrefix = '`' . $strPrefix . '__';
			} else {
				$strTableName = '`MemberRaceResult`';
				$strAliasPrefix = '`';
			}

			// wpg - if we are not passing in an array of participant fields we want then get them all
			if (!$selectionArray){
				$objBuilder->AddSelectItem($strTableName . '.`Id` AS ' . $strAliasPrefix . 'Id`');
				$objBuilder->AddSelectItem($strTableName . '.`RaceResultId` AS ' . $strAliasPrefix . 'RaceResultId`');
				$objBuilder->AddSelectItem($strTableName . '.`ResultLine` AS ' . $strAliasPrefix . 'ResultLine`');
				$objBuilder->AddSelectItem($strTableName . '.`MemberContactId` AS ' . $strAliasPrefix . 'MemberContactId`');
				$objBuilder->AddSelectItem($strTableName . '.`FinishTime` AS ' . $strAliasPrefix . 'FinishTime`');
			}
			else {
				foreach($selectionArray AS $field){
					$objBuilder->AddSelectItem($strTableName . '.`'.$field.'` AS ' . $strAliasPrefix . $field.'`');
				}
			}
		}



		///////////////////////////////
		// INSTANTIATION-RELATED METHODS
		///////////////////////////////

		/**
		 * Instantiate a MemberRaceResult from a Database Row.
		 * Takes in an optional strAliasPrefix, used in case another Object::InstantiateDbRow
		 * is calling this MemberRaceResult::InstantiateDbRow in order to perform
		 * early binding on referenced objects.
		 * @param DatabaseRowBase $objDbRow
		 * @param string $strAliasPrefix
		 * @return MemberRaceResult
		*/
		public static function InstantiateDbRow($objDbRow, $strAliasPrefix = null, $strExpandAsArrayNodes = null, $objPreviousItem = null) {
			// If blank row, return null
			if (!$objDbRow)
				return null;


			// Create a new instance of the MemberRaceResult object
			$objToReturn = new MemberRaceResult();
			$objToReturn->__blnRestored = true;

			$objToReturn->intId = $objDbRow->GetColumn($strAliasPrefix . 'Id', 'Integer');
			$objToReturn->intRaceResultId = $objDbRow->GetColumn($strAliasPrefix . 'RaceResultId', 'Integer');
			$objToReturn->intResultLine = $objDbRow->GetColumn($strAliasPrefix . 'ResultLine', 'Integer');
			$objToReturn->intMemberContactId = $objDbRow->GetColumn($strAliasPrefix . 'MemberContactId', 'Integer');
			$objToReturn->strFinishTime = $objDbRow->GetColumn($strAliasPrefix . 'FinishTime', 'VarChar');

			// Instantiate Virtual Attributes
			foreach ($objDbRow->GetColumnNameArray() as $strColumnName => $mixValue) {
				$strVirtualPrefix = $strAliasPrefix . '__';
				$strVirtualPrefixLength = strlen($strVirtualPrefix ?? '');
				if (substr($strColumnName, 0, $strVirtualPrefixLength) == $strVirtualPrefix)
					$objToReturn->__strVirtualAttributeArray[substr($strColumnName, $strVirtualPrefixLength)] = $mixValue;
			}

			// Prepare to Check for Early/Virtual Binding
			if (!$strAliasPrefix)
				$strAliasPrefix = 'MemberRaceResult__';

			// Check for RaceResultIdObject Early Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'RaceResultId__Id')))
				$objToReturn->objRaceResultIdObject = RaceResults::InstantiateDbRow($objDbRow, $strAliasPrefix . 'RaceResultId__', $strExpandAsArrayNodes);

			// Check for MemberContactIdObject Early Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'MemberContactId__Id')))
				$objToReturn->objMemberContactIdObject = MemberContact::InstantiateDbRow($objDbRow, $strAliasPrefix . 'MemberContactId__', $strExpandAsArrayNodes);




			return $objToReturn;
		}

		/**
		 * Instantiate an array of MemberRaceResults from a Database Result
		 * @param DatabaseResultBase $objDbResult
		 * @return MemberRaceResult[]
		 */
		public static function InstantiateDbResult(QDatabaseResultBase $objDbResult, $strExpandAsArrayNodes = null) {
			$objToReturn = array();

			// If blank resultset, then return empty array
			if (!$objDbResult)
				return $objToReturn;

			// Load up the return array with each row
			if ($strExpandAsArrayNodes) {
				$objLastRowItem = null;
				while ($objDbRow = $objDbResult->GetNextRow()) {
					$objItem = MemberRaceResult::InstantiateDbRow($objDbRow, null, $strExpandAsArrayNodes, $objLastRowItem);
					if ($objItem) {
						array_push($objToReturn, $objItem);
						$objLastRowItem = $objItem;
					}
				}
			} else {
				while ($objDbRow = $objDbResult->GetNextRow())
					array_push($objToReturn, MemberRaceResult::InstantiateDbRow($objDbRow));
			}

			return $objToReturn;
		}



		///////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Single Load and Array)
		///////////////////////////////////////////////////
			
		/**
		 * Load a single MemberRaceResult object,
		 * by Id Index(es)
		 * @param integer $intId
		 * @return MemberRaceResult
		*/
		public static function LoadById($intId) {
			return MemberRaceResult::QuerySingle(
				QQ::Equal(QQN::MemberRaceResult()->Id, $intId)
			);
		}
			
		/**
		 * Load an array of MemberRaceResult objects,
		 * by RaceResultId Index(es)
		 * @param integer $intRaceResultId
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return MemberRaceResult[]
		*/
		public static function LoadArrayByRaceResultId($intRaceResultId, $objOptionalClauses = null) {
			// Call MemberRaceResult::QueryArray to perform the LoadArrayByRaceResultId query
			try {
				return MemberRaceResult::QueryArray(
					QQ::Equal(QQN::MemberRaceResult()->RaceResultId, $intRaceResultId),
					$objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count MemberRaceResults
		 * by RaceResultId Index(es)
		 * @param integer $intRaceResultId
		 * @return int
		*/
		public static function CountByRaceResultId($intRaceResultId) {
			// Call MemberRaceResult::QueryCount to perform the CountByRaceResultId query
			return MemberRaceResult::QueryCount(
				QQ::Equal(QQN::MemberRaceResult()->RaceResultId, $intRaceResultId)
			);
		}
			
		/**
		 * Load an array of MemberRaceResult objects,
		 * by MemberContactId Index(es)
		 * @param integer $intMemberContactId
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return MemberRaceResult[]
		*/
		public static function LoadArrayByMemberContactId($intMemberContactId, $objOptionalClauses = null) {
			// Call MemberRaceResult::QueryArray to perform the LoadArrayByMemberContactId query
			try {
				return MemberRaceResult::QueryArray(
					QQ::Equal(QQN::MemberRaceResult()->MemberContactId, $intMemberContactId),
					$objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count MemberRaceResults
		 * by MemberContactId Index(es)
		 * @param integer $intMemberContactId
		 * @return int
		*/
		public static function CountByMemberContactId($intMemberContactId) {
			// Call MemberRaceResult::QueryCount to perform the CountByMemberContactId query
			return MemberRaceResult::QueryCount(
				QQ::Equal(QQN::MemberRaceResult()->MemberContactId, $intMemberContactId)
			);
		}



		////////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Array via Many to Many)
		////////////////////////////////////////////////////



		//////////////////
		// SAVE AND DELETE
		//////////////////

		/**
		 * Save this MemberRaceResult
		 * @param bool $blnForceInsert
		 * @param bool $blnForceUpdate
		 * @return int
		*/
		public function Save($blnForceInsert = false, $blnForceUpdate = false) {
			// Get the Database Object for this Class
			$objDatabase = MemberRaceResult::GetDatabase();

			$mixToReturn = null;

			try {
				if ((!$this->__blnRestored) || ($blnForceInsert)) {
					// Perform an INSERT query
					$objDatabase->NonQuery('
						INSERT INTO `MemberRaceResult` (
							`RaceResultId`,
							`ResultLine`,
							`MemberContactId`,
							`FinishTime`
						) VALUES (
							' . $objDatabase->SqlVariable($this->intRaceResultId) . ',
							' . $objDatabase->SqlVariable($this->intResultLine) . ',
							' . $objDatabase->SqlVariable($this->intMemberContactId) . ',
							' . $objDatabase->SqlVariable($this->strFinishTime) . '
						)
					');

					// Update Identity column and return its value
					$mixToReturn = $this->intId = $objDatabase->InsertId('MemberRaceResult', 'Id');
				} else {
					// Perform an UPDATE query

					// First checking for Optimistic Locking constraints (if applicable)

					// Perform the UPDATE query
					$objDatabase->NonQuery('
						UPDATE
							`MemberRaceResult`
						SET
							`RaceResultId` = ' . $objDatabase->SqlVariable($this->intRaceResultId) . ',
							`ResultLine` = ' . $objDatabase->SqlVariable($this->intResultLine) . ',
							`MemberContactId` = ' . $objDatabase->SqlVariable($this->intMemberContactId) . ',
							`FinishTime` = ' . $objDatabase->SqlVariable($this->strFinishTime) . '
						WHERE
							`Id` = ' . $objDatabase->SqlVariable($this->intId) . '
					');
				}

			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Update __blnRestored and any Non-Identity PK Columns (if applicable)
			$this->__blnRestored = true;


			// Return 
			return $mixToReturn;
		}

				/**
		 * Delete this MemberRaceResult
		 * @return void
		*/
		public function Delete() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Cannot delete this MemberRaceResult with an unset primary key.');

			// Get the Database Object for this Class
			$objDatabase = MemberRaceResult::GetDatabase();


			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MemberRaceResult`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($this->intId) . '');
		}

		/**
		 * Delete all MemberRaceResults
		 * @return void
		*/
		public static function DeleteAll() {
			// Get the Database Object for this Class
			$objDatabase = MemberRaceResult::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MemberRaceResult`');
		}

		/**
		 * Truncate MemberRaceResult table
		 * @return void
		*/
		public static function Truncate() {
			// Get the Database Object for this Class
			$objDatabase = MemberRaceResult::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				TRUNCATE `MemberRaceResult`');
		}



		////////////////////
		// PUBLIC OVERRIDERS
		////////////////////

				/**
		 * Override method to perform a property "Get"
		 * This will get the value of $strName
		 *
		 * @param string $strName Name of the property to get
		 * @return mixed
		 */
		public function __get($strName) {
			switch ($strName) {
				///////////////////
				// Member Variables
				///////////////////
				case 'Id':
					/**
					 * Gets the value for intId (Read-Only PK)
					 * @return integer
					 */
					return $this->intId;

				case 'RaceResultId':
					/**
					 * Gets the value for intRaceResultId (Not Null)
					 * @return integer
					 */
					return $this->intRaceResultId;

				case 'ResultLine':
					/**
					 * Gets the value for intResultLine (Not Null)
					 * @return integer
					 */
					return $this->intResultLine;

				case 'MemberContactId':
					/**
					 * Gets the value for intMemberContactId (Not Null)
					 * @return integer
					 */
					return $this->intMemberContactId;

				case 'FinishTime':
					/**
					 * Gets the value for strFinishTime 
					 * @return string
					 */
					return $this->strFinishTime;


				///////////////////
				// Member Objects
				///////////////////
				case 'RaceResultIdObject':
					/**
					 * Gets the value for the RaceResults object referenced by intRaceResultId (Not Null)
					 * @return RaceResults
					 */
					try {
						if ((!$this->objRaceResultIdObject) && (!is_null($this->intRaceResultId)))
							$this->objRaceResultIdObject = RaceResults::Load($this->intRaceResultId);
						return $this->objRaceResultIdObject;
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'MemberContactIdObject':
					/**
					 * Gets the value for the MemberContact object referenced by intMemberContactId (Not Null)
					 * @return MemberContact
					 */
					try {
						if ((!$this->objMemberContactIdObject) && (!is_null($this->intMemberContactId)))
							$this->objMemberContactIdObject = MemberContact::Load($this->intMemberContactId);
						return $this->objMemberContactIdObject;
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}


				////////////////////////////
				// Virtual Object References (Many to Many and Reverse References)
				// (If restored via a "Many-to" expansion)
				////////////////////////////

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
		 * Override method to perform a property "Set"
		 * This will set the property $strName to be $mixValue
		 *
		 * @param string $strName Name of the property to set
		 * @param string $mixValue New value of the property
		 * @return mixed
		 */
		public function __set($strName, $mixValue) {
			switch ($strName) {
				///////////////////
				// Member Variables
				///////////////////
				case 'RaceResultId':
					/**
					 * Sets the value for intRaceResultId (Not Null)
					 * @param integer $mixValue
					 * @return integer
					 */
					try {
						$this->objRaceResultIdObject = null;
						return ($this->intRaceResultId = QType::Cast($mixValue, QType::Integer));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'ResultLine':
					/**
					 * Sets the value for intResultLine (Not Null)
					 * @param integer $mixValue
					 * @return integer
					 */
					try {
						return ($this->intResultLine = QType::Cast($mixValue, QType::Integer));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'MemberContactId':
					/**
					 * Sets the value for intMemberContactId (Not Null)
					 * @param integer $mixValue
					 * @return integer
					 */
					try {
						$this->objMemberContactIdObject = null;
						return ($this->intMemberContactId = QType::Cast($mixValue, QType::Integer));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'FinishTime':
					/**
					 * Sets the value for strFinishTime 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strFinishTime = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}


				///////////////////
				// Member Objects
				///////////////////
				case 'RaceResultIdObject':
					/**
					 * Sets the value for the RaceResults object referenced by intRaceResultId (Not Null)
					 * @param RaceResults $mixValue
					 * @return RaceResults
					 */
					if (is_null($mixValue)) {
						$this->intRaceResultId = null;
						$this->objRaceResultIdObject = null;
						return null;
					} else {
						// Make sure $mixValue actually is a RaceResults object
						try {
							$mixValue = QType::Cast($mixValue, 'RaceResults');
						} catch (QInvalidCastException $objExc) {
							$objExc->IncrementOffset();
							throw $objExc;
						} 

						// Make sure $mixValue is a SAVED RaceResults object
						if (is_null($mixValue->Id))
							throw new QCallerException('Unable to set an unsaved RaceResultIdObject for this MemberRaceResult');

						// Update Local Member Variables
						$this->objRaceResultIdObject = $mixValue;
						$this->intRaceResultId = $mixValue->Id;

						// Return $mixValue
						return $mixValue;
					}
					break;

				case 'MemberContactIdObject':
					/**
					 * Sets the value for the MemberContact object referenced by intMemberContactId (Not Null)
					 * @param MemberContact $mixValue
					 * @return MemberContact
					 */
					if (is_null($mixValue)) {
						$this->intMemberContactId = null;
						$this->objMemberContactIdObject = null;
						return null;
					} else {
						// Make sure $mixValue actually is a MemberContact object
						try {
							$mixValue = QType::Cast($mixValue, 'MemberContact');
						} catch (QInvalidCastException $objExc) {
							$objExc->IncrementOffset();
							throw $objExc;
						} 

						// Make sure $mixValue is a SAVED MemberContact object
						if (is_null($mixValue->Id))
							throw new QCallerException('Unable to set an unsaved MemberContactIdObject for this MemberRaceResult');

						// Update Local Member Variables
						$this->objMemberContactIdObject = $mixValue;
						$this->intMemberContactId = $mixValue->Id;

						// Return $mixValue
						return $mixValue;
					}
					break;

				default:
					try {
						return parent::__set($strName, $mixValue);
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}

		/**
		 * Lookup a VirtualAttribute value (if applicable).  Returns NULL if none found.
		 * @param string $strName
		 * @return string
		 */
		public function GetVirtualAttribute($strName) {
			if (array_key_exists($strName, $this->__strVirtualAttributeArray))
				return $this->__strVirtualAttributeArray[$strName];
			return null;
		}



		///////////////////////////////
		// ASSOCIATED OBJECTS
		///////////////////////////////




		///////////////////////////////////////////////////////////////////////
		// PROTECTED MEMBER VARIABLES and TEXT FIELD MAXLENGTHS (if applicable)
		///////////////////////////////////////////////////////////////////////
		
		/**
		 * Protected member variable that maps to the database PK Identity column MemberRaceResult.Id
		 * @var integer intId
		 */
		protected $intId;
		const IdDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberRaceResult.RaceResultId
		 * @var integer intRaceResultId
		 */
		protected $intRaceResultId;
		const RaceResultIdDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberRaceResult.ResultLine
		 * @var integer intResultLine
		 */
		protected $intResultLine;
		const ResultLineDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberRaceResult.MemberContactId
		 * @var integer intMemberContactId
		 */
		protected $intMemberContactId;
		const MemberContactIdDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberRaceResult.FinishTime
		 * @var string strFinishTime
		 */
		protected $strFinishTime;
		const FinishTimeMaxLength = 50;
		const FinishTimeDefault = null;


		/**
		 * Protected array of virtual attributes for this object (e.g. extra/other calculated and/or non-object bound
		 * columns from the run-time database query result for this object).  Used by InstantiateDbRow and
		 * GetVirtualAttribute.
		 * @var string[] $__strVirtualAttributeArray
		 */
		protected $__strVirtualAttributeArray = array();

		/**
		 * Protected internal member variable that specifies whether or not this object is Restored from the database.
		 * Used by Save() to determine if Save() should perform a db UPDATE or INSERT.
		 * @var bool __blnRestored;
		 */
		protected $__blnRestored;



		///////////////////////////////
		// PROTECTED MEMBER OBJECTS
		///////////////////////////////

		/**
		 * Protected member variable that contains the object pointed by the reference
		 * in the database column MemberRaceResult.RaceResultId.
		 *
		 * NOTE: Always use the RaceResultIdObject property getter to correctly retrieve this RaceResults object.
		 * (Because this class implements late binding, this variable reference MAY be null.)
		 * @var RaceResults objRaceResultIdObject
		 */
		protected $objRaceResultIdObject;

		/**
		 * Protected member variable that contains the object pointed by the reference
		 * in the database column MemberRaceResult.MemberContactId.
		 *
		 * NOTE: Always use the MemberContactIdObject property getter to correctly retrieve this MemberContact object.
		 * (Because this class implements late binding, this variable reference MAY be null.)
		 * @var MemberContact objMemberContactIdObject
		 */
		protected $objMemberContactIdObject;






		////////////////////////////////////////
		// METHODS for WEB SERVICES
		////////////////////////////////////////

		public static function GetSoapComplexTypeXml() {
			$strToReturn = '<complexType name="MemberRaceResult"><sequence>';
			$strToReturn .= '<element name="Id" type="xsd:int"/>';
			$strToReturn .= '<element name="RaceResultIdObject" type="xsd1:RaceResults"/>';
			$strToReturn .= '<element name="ResultLine" type="xsd:int"/>';
			$strToReturn .= '<element name="MemberContactIdObject" type="xsd1:MemberContact"/>';
			$strToReturn .= '<element name="FinishTime" type="xsd:string"/>';
			$strToReturn .= '<element name="__blnRestored" type="xsd:boolean"/>';
			$strToReturn .= '</sequence></complexType>';
			return $strToReturn;
		}

		public static function AlterSoapComplexTypeArray(&$strComplexTypeArray) {
			if (!array_key_exists('MemberRaceResult', $strComplexTypeArray)) {
				$strComplexTypeArray['MemberRaceResult'] = MemberRaceResult::GetSoapComplexTypeXml();
				RaceResults::AlterSoapComplexTypeArray($strComplexTypeArray);
				MemberContact::AlterSoapComplexTypeArray($strComplexTypeArray);
			}
		}

		public static function GetArrayFromSoapArray($objSoapArray) {
			$objArrayToReturn = array();

			foreach ($objSoapArray as $objSoapObject)
				array_push($objArrayToReturn, MemberRaceResult::GetObjectFromSoapObject($objSoapObject));

			return $objArrayToReturn;
		}

		public static function GetObjectFromSoapObject($objSoapObject) {
			$objToReturn = new MemberRaceResult();
			if (property_exists($objSoapObject, 'Id'))
				$objToReturn->intId = $objSoapObject->Id;
			if ((property_exists($objSoapObject, 'RaceResultIdObject')) &&
				($objSoapObject->RaceResultIdObject))
				$objToReturn->RaceResultIdObject = RaceResults::GetObjectFromSoapObject($objSoapObject->RaceResultIdObject);
			if (property_exists($objSoapObject, 'ResultLine'))
				$objToReturn->intResultLine = $objSoapObject->ResultLine;
			if ((property_exists($objSoapObject, 'MemberContactIdObject')) &&
				($objSoapObject->MemberContactIdObject))
				$objToReturn->MemberContactIdObject = MemberContact::GetObjectFromSoapObject($objSoapObject->MemberContactIdObject);
			if (property_exists($objSoapObject, 'FinishTime'))
				$objToReturn->strFinishTime = $objSoapObject->FinishTime;
			if (property_exists($objSoapObject, '__blnRestored'))
				$objToReturn->__blnRestored = $objSoapObject->__blnRestored;
			return $objToReturn;
		}

		public static function GetSoapArrayFromArray($objArray) {
			if (!$objArray)
				return null;

			$objArrayToReturn = array();

			foreach ($objArray as $objObject)
				array_push($objArrayToReturn, MemberRaceResult::GetSoapObjectFromObject($objObject, true));

			return unserialize(serialize($objArrayToReturn ?? '') ?? '');
		}

		public static function GetSoapObjectFromObject($objObject, $blnBindRelatedObjects) {
			if ($objObject->objRaceResultIdObject)
				$objObject->objRaceResultIdObject = RaceResults::GetSoapObjectFromObject($objObject->objRaceResultIdObject, false);
			else if (!$blnBindRelatedObjects)
				$objObject->intRaceResultId = null;
			if ($objObject->objMemberContactIdObject)
				$objObject->objMemberContactIdObject = MemberContact::GetSoapObjectFromObject($objObject->objMemberContactIdObject, false);
			else if (!$blnBindRelatedObjects)
				$objObject->intMemberContactId = null;
			return $objObject;
		}
	}





	/////////////////////////////////////
	// ADDITIONAL CLASSES for QCODO QUERY
	/////////////////////////////////////

	class QQNodeMemberRaceResult extends QQNode {
		protected $strTableName = 'MemberRaceResult';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'MemberRaceResult';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'RaceResultId':
					return new QQNode('RaceResultId', 'integer', $this);
				case 'RaceResultIdObject':
					return new QQNodeRaceResults('RaceResultId', 'integer', $this);
				case 'ResultLine':
					return new QQNode('ResultLine', 'integer', $this);
				case 'MemberContactId':
					return new QQNode('MemberContactId', 'integer', $this);
				case 'MemberContactIdObject':
					return new QQNodeMemberContact('MemberContactId', 'integer', $this);
				case 'FinishTime':
					return new QQNode('FinishTime', 'string', $this);

				case '_PrimaryKeyNode':
					return new QQNode('Id', 'integer', $this);
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

	class QQReverseReferenceNodeMemberRaceResult extends QQReverseReferenceNode {
		protected $strTableName = 'MemberRaceResult';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'MemberRaceResult';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'RaceResultId':
					return new QQNode('RaceResultId', 'integer', $this);
				case 'RaceResultIdObject':
					return new QQNodeRaceResults('RaceResultId', 'integer', $this);
				case 'ResultLine':
					return new QQNode('ResultLine', 'integer', $this);
				case 'MemberContactId':
					return new QQNode('MemberContactId', 'integer', $this);
				case 'MemberContactIdObject':
					return new QQNodeMemberContact('MemberContactId', 'integer', $this);
				case 'FinishTime':
					return new QQNode('FinishTime', 'string', $this);

				case '_PrimaryKeyNode':
					return new QQNode('Id', 'integer', $this);
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
?>