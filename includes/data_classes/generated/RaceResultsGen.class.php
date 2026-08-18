<?php
	/**
	 * The abstract RaceResultsGen class defined here is
	 * code-generated and contains all the basic CRUD-type functionality as well as
	 * basic methods to handle relationships and index-based loading.
	 *
	 * To use, you should use the RaceResults subclass which
	 * extends this RaceResultsGen class.
	 *
	 * Because subsequent re-code generations will overwrite any changes to this
	 * file, you should leave this file unaltered to prevent yourself from losing
	 * any information or code changes.  All customizations should be done by
	 * overriding existing or implementing new methods, properties and variables
	 * in the RaceResults class.
	 * 
	 * @package My Application
	 * @subpackage GeneratedDataObjects
	 * 
	 */
	class RaceResultsGen extends QBaseClass {
		///////////////////////////////
		// COMMON LOAD METHODS
		///////////////////////////////

		/**
		 * Load a RaceResults from PK Info
		 * @param integer $intId
		 * @return RaceResults
		 */
		public static function Load($intId) {
			// Use QuerySingle to Perform the Query
			return RaceResults::QuerySingle(
				QQ::Equal(QQN::RaceResults()->Id, $intId)
			);
		}

		/**
		 * Load all RaceResultses
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return RaceResults[]
		 */
		public static function LoadAll($objOptionalClauses = null) {
			// Call RaceResults::QueryArray to perform the LoadAll query
			try {
				return RaceResults::QueryArray(QQ::All(), $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count all RaceResultses
		 * @return int
		 */
		public static function CountAll() {
			// Call RaceResults::QueryCount to perform the CountAll query
			return RaceResults::QueryCount(QQ::All());
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
			$objDatabase = RaceResults::GetDatabase();

			// Create/Build out the QueryBuilder object with RaceResults-specific SELET and FROM fields
			$objQueryBuilder = new QQueryBuilder($objDatabase, 'RaceResults');
			RaceResults::GetSelectFields($objQueryBuilder,null,$selectionArray);
			$objQueryBuilder->AddFromItem('`RaceResults` AS `RaceResults`');

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
		 * Static Qcodo Query method to query for a single RaceResults object.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return RaceResults the queried object
		 */
		public static function QuerySingle(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = RaceResults::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query, Get the First Row, and Instantiate a new RaceResults object
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return RaceResults::InstantiateDbRow($objDbResult->GetNextRow());
		}

		/**
		 * Static Qcodo Query method to query for an array of RaceResults objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return RaceResults[] the queried objects as an array
		 */
		public static function QueryArray(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = RaceResults::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query and Instantiate the Array Result
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return RaceResults::InstantiateDbResult($objDbResult, $objQueryBuilder->ExpandAsArrayNodes);
		}

		/**
		 * Static Qcodo Query method to query for a count of RaceResults objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return integer the count of queried objects as an integer
		 */
		public static function QueryCount(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = RaceResults::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, true,$selectionArray);
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
			$objDatabase = RaceResults::GetDatabase();

			// Lookup the QCache for This Query Statement
			$objCache = new QCache('query', 'RaceResults_' . serialize($strConditions));
			if (!($strQuery = $objCache->GetData())) {
				// Not Found -- Go ahead and Create/Build out a new QueryBuilder object with RaceResults-specific fields
				$objQueryBuilder = new QQueryBuilder($objDatabase);
				RaceResults::GetSelectFields($objQueryBuilder);
				RaceResults::GetFromFields($objQueryBuilder);

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
			return RaceResults::InstantiateDbResult($objDbResult);
		}*/

		/**
		 * Updates a QQueryBuilder with the SELECT fields for this RaceResults
		 * @param QQueryBuilder $objBuilder the Query Builder object to update
		 * @param string $strPrefix optional prefix to add to the SELECT fields
		 * @param array $selectionArray optional array of SELECT field items (wpg - added Sept 2012)
		 */
		public static function GetSelectFields(QQueryBuilder $objBuilder, $strPrefix = null, $selectionArray = null) {
			if ($strPrefix) {
				$strTableName = '`' . $strPrefix . '`';
				$strAliasPrefix = '`' . $strPrefix . '__';
			} else {
				$strTableName = '`RaceResults`';
				$strAliasPrefix = '`';
			}

			// wpg - if we are not passing in an array of participant fields we want then get them all
			if (!$selectionArray){
				$objBuilder->AddSelectItem($strTableName . '.`Id` AS ' . $strAliasPrefix . 'Id`');
				$objBuilder->AddSelectItem($strTableName . '.`RaceDate` AS ' . $strAliasPrefix . 'RaceDate`');
				$objBuilder->AddSelectItem($strTableName . '.`Placement` AS ' . $strAliasPrefix . 'Placement`');
				$objBuilder->AddSelectItem($strTableName . '.`Race` AS ' . $strAliasPrefix . 'Race`');
				$objBuilder->AddSelectItem($strTableName . '.`HeaderLine` AS ' . $strAliasPrefix . 'HeaderLine`');
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
		 * Instantiate a RaceResults from a Database Row.
		 * Takes in an optional strAliasPrefix, used in case another Object::InstantiateDbRow
		 * is calling this RaceResults::InstantiateDbRow in order to perform
		 * early binding on referenced objects.
		 * @param DatabaseRowBase $objDbRow
		 * @param string $strAliasPrefix
		 * @return RaceResults
		*/
		public static function InstantiateDbRow($objDbRow, $strAliasPrefix = null, $strExpandAsArrayNodes = null, $objPreviousItem = null) {
			// If blank row, return null
			if (!$objDbRow)
				return null;

			// See if we're doing an array expansion on the previous item
			if (($strExpandAsArrayNodes) && ($objPreviousItem) &&
				($objPreviousItem->intId == $objDbRow->GetColumn($strAliasPrefix . 'Id', 'Integer'))) {

				// We are.  Now, prepare to check for ExpandAsArray clauses
				$blnExpandedViaArray = false;
				if (!$strAliasPrefix)
					$strAliasPrefix = 'RaceResults__';


				if ((array_key_exists($strAliasPrefix . 'memberraceresultasraceresultid__Id', $strExpandAsArrayNodes)) &&
					(!is_null($objDbRow->GetColumn($strAliasPrefix . 'memberraceresultasraceresultid__Id')))) {
					if ($intPreviousChildItemCount = count($objPreviousItem->_objMemberRaceResultAsRaceResultIdArray)) {
						$objPreviousChildItem = $objPreviousItem->_objMemberRaceResultAsRaceResultIdArray[$intPreviousChildItemCount - 1];
						$objChildItem = MemberRaceResult::InstantiateDbRow($objDbRow, $strAliasPrefix . 'memberraceresultasraceresultid__', $strExpandAsArrayNodes, $objPreviousChildItem);
						if ($objChildItem)
							array_push($objPreviousItem->_objMemberRaceResultAsRaceResultIdArray, $objChildItem);
					} else
						array_push($objPreviousItem->_objMemberRaceResultAsRaceResultIdArray, MemberRaceResult::InstantiateDbRow($objDbRow, $strAliasPrefix . 'memberraceresultasraceresultid__', $strExpandAsArrayNodes));
					$blnExpandedViaArray = true;
				}

				// Either return false to signal array expansion, or check-to-reset the Alias prefix and move on
				if ($blnExpandedViaArray)
					return false;
				else if ($strAliasPrefix == 'RaceResults__')
					$strAliasPrefix = null;
			}

			// Create a new instance of the RaceResults object
			$objToReturn = new RaceResults();
			$objToReturn->__blnRestored = true;

			$objToReturn->intId = $objDbRow->GetColumn($strAliasPrefix . 'Id', 'Integer');
			$objToReturn->dttRaceDate = $objDbRow->GetColumn($strAliasPrefix . 'RaceDate', 'Date');
			$objToReturn->strPlacement = $objDbRow->GetColumn($strAliasPrefix . 'Placement', 'Blob');
			$objToReturn->intRace = $objDbRow->GetColumn($strAliasPrefix . 'Race', 'Integer');
			$objToReturn->intHeaderLine = $objDbRow->GetColumn($strAliasPrefix . 'HeaderLine', 'Integer');

			// Instantiate Virtual Attributes
			foreach ($objDbRow->GetColumnNameArray() as $strColumnName => $mixValue) {
				$strVirtualPrefix = $strAliasPrefix . '__';
				$strVirtualPrefixLength = strlen($strVirtualPrefix ?? '');
				if (substr($strColumnName, 0, $strVirtualPrefixLength) == $strVirtualPrefix)
					$objToReturn->__strVirtualAttributeArray[substr($strColumnName, $strVirtualPrefixLength)] = $mixValue;
			}

			// Prepare to Check for Early/Virtual Binding
			if (!$strAliasPrefix)
				$strAliasPrefix = 'RaceResults__';

			// Check for RaceObject Early Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'Race__Id')))
				$objToReturn->objRaceObject = Race::InstantiateDbRow($objDbRow, $strAliasPrefix . 'Race__', $strExpandAsArrayNodes);




			// Check for MemberRaceResultAsRaceResultId Virtual Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'memberraceresultasraceresultid__Id'))) {
				if (($strExpandAsArrayNodes) && (array_key_exists($strAliasPrefix . 'memberraceresultasraceresultid__Id', $strExpandAsArrayNodes)))
					array_push($objToReturn->_objMemberRaceResultAsRaceResultIdArray, MemberRaceResult::InstantiateDbRow($objDbRow, $strAliasPrefix . 'memberraceresultasraceresultid__', $strExpandAsArrayNodes));
				else
					$objToReturn->_objMemberRaceResultAsRaceResultId = MemberRaceResult::InstantiateDbRow($objDbRow, $strAliasPrefix . 'memberraceresultasraceresultid__', $strExpandAsArrayNodes);
			}

			return $objToReturn;
		}

		/**
		 * Instantiate an array of RaceResultses from a Database Result
		 * @param DatabaseResultBase $objDbResult
		 * @return RaceResults[]
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
					$objItem = RaceResults::InstantiateDbRow($objDbRow, null, $strExpandAsArrayNodes, $objLastRowItem);
					if ($objItem) {
						array_push($objToReturn, $objItem);
						$objLastRowItem = $objItem;
					}
				}
			} else {
				while ($objDbRow = $objDbResult->GetNextRow())
					array_push($objToReturn, RaceResults::InstantiateDbRow($objDbRow));
			}

			return $objToReturn;
		}



		///////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Single Load and Array)
		///////////////////////////////////////////////////
			
		/**
		 * Load a single RaceResults object,
		 * by Id Index(es)
		 * @param integer $intId
		 * @return RaceResults
		*/
		public static function LoadById($intId) {
			return RaceResults::QuerySingle(
				QQ::Equal(QQN::RaceResults()->Id, $intId)
			);
		}
			
		/**
		 * Load an array of RaceResults objects,
		 * by Race Index(es)
		 * @param integer $intRace
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return RaceResults[]
		*/
		public static function LoadArrayByRace($intRace, $objOptionalClauses = null) {
			// Call RaceResults::QueryArray to perform the LoadArrayByRace query
			try {
				return RaceResults::QueryArray(
					QQ::Equal(QQN::RaceResults()->Race, $intRace),
					$objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count RaceResultses
		 * by Race Index(es)
		 * @param integer $intRace
		 * @return int
		*/
		public static function CountByRace($intRace) {
			// Call RaceResults::QueryCount to perform the CountByRace query
			return RaceResults::QueryCount(
				QQ::Equal(QQN::RaceResults()->Race, $intRace)
			);
		}



		////////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Array via Many to Many)
		////////////////////////////////////////////////////



		//////////////////
		// SAVE AND DELETE
		//////////////////

		/**
		 * Save this RaceResults
		 * @param bool $blnForceInsert
		 * @param bool $blnForceUpdate
		 * @return int
		*/
		public function Save($blnForceInsert = false, $blnForceUpdate = false) {
			// Get the Database Object for this Class
			$objDatabase = RaceResults::GetDatabase();

			$mixToReturn = null;

			try {
				if ((!$this->__blnRestored) || ($blnForceInsert)) {
					// Perform an INSERT query
					$objDatabase->NonQuery('
						INSERT INTO `RaceResults` (
							`RaceDate`,
							`Placement`,
							`Race`,
							`HeaderLine`
						) VALUES (
							' . $objDatabase->SqlVariable($this->dttRaceDate) . ',
							' . $objDatabase->SqlVariable($this->strPlacement) . ',
							' . $objDatabase->SqlVariable($this->intRace) . ',
							' . $objDatabase->SqlVariable($this->intHeaderLine) . '
						)
					');

					// Update Identity column and return its value
					$mixToReturn = $this->intId = $objDatabase->InsertId('RaceResults', 'Id');
				} else {
					// Perform an UPDATE query

					// First checking for Optimistic Locking constraints (if applicable)

					// Perform the UPDATE query
					$objDatabase->NonQuery('
						UPDATE
							`RaceResults`
						SET
							`RaceDate` = ' . $objDatabase->SqlVariable($this->dttRaceDate) . ',
							`Placement` = ' . $objDatabase->SqlVariable($this->strPlacement) . ',
							`Race` = ' . $objDatabase->SqlVariable($this->intRace) . ',
							`HeaderLine` = ' . $objDatabase->SqlVariable($this->intHeaderLine) . '
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
		 * Delete this RaceResults
		 * @return void
		*/
		public function Delete() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Cannot delete this RaceResults with an unset primary key.');

			// Get the Database Object for this Class
			$objDatabase = RaceResults::GetDatabase();


			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`RaceResults`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($this->intId) . '');
		}

		/**
		 * Delete all RaceResultses
		 * @return void
		*/
		public static function DeleteAll() {
			// Get the Database Object for this Class
			$objDatabase = RaceResults::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				DELETE FROM
					`RaceResults`');
		}

		/**
		 * Truncate RaceResults table
		 * @return void
		*/
		public static function Truncate() {
			// Get the Database Object for this Class
			$objDatabase = RaceResults::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				TRUNCATE `RaceResults`');
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

				case 'RaceDate':
					/**
					 * Gets the value for dttRaceDate (Not Null)
					 * @return QDateTime
					 */
					return $this->dttRaceDate;

				case 'Placement':
					/**
					 * Gets the value for strPlacement (Not Null)
					 * @return string
					 */
					return $this->strPlacement;

				case 'Race':
					/**
					 * Gets the value for intRace (Not Null)
					 * @return integer
					 */
					return $this->intRace;

				case 'HeaderLine':
					/**
					 * Gets the value for intHeaderLine (Not Null)
					 * @return integer
					 */
					return $this->intHeaderLine;


				///////////////////
				// Member Objects
				///////////////////
				case 'RaceObject':
					/**
					 * Gets the value for the Race object referenced by intRace (Not Null)
					 * @return Race
					 */
					try {
						if ((!$this->objRaceObject) && (!is_null($this->intRace)))
							$this->objRaceObject = Race::Load($this->intRace);
						return $this->objRaceObject;
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}


				////////////////////////////
				// Virtual Object References (Many to Many and Reverse References)
				// (If restored via a "Many-to" expansion)
				////////////////////////////

				case '_MemberRaceResultAsRaceResultId':
					/**
					 * Gets the value for the private _objMemberRaceResultAsRaceResultId (Read-Only)
					 * if set due to an expansion on the MemberRaceResult.RaceResultId reverse relationship
					 * @return MemberRaceResult
					 */
					return $this->_objMemberRaceResultAsRaceResultId;

				case '_MemberRaceResultAsRaceResultIdArray':
					/**
					 * Gets the value for the private _objMemberRaceResultAsRaceResultIdArray (Read-Only)
					 * if set due to an ExpandAsArray on the MemberRaceResult.RaceResultId reverse relationship
					 * @return MemberRaceResult[]
					 */
					return (array) $this->_objMemberRaceResultAsRaceResultIdArray;

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
				case 'RaceDate':
					/**
					 * Sets the value for dttRaceDate (Not Null)
					 * @param QDateTime $mixValue
					 * @return QDateTime
					 */
					try {
						return ($this->dttRaceDate = QType::Cast($mixValue, QType::DateTime));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'Placement':
					/**
					 * Sets the value for strPlacement (Not Null)
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strPlacement = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'Race':
					/**
					 * Sets the value for intRace (Not Null)
					 * @param integer $mixValue
					 * @return integer
					 */
					try {
						$this->objRaceObject = null;
						return ($this->intRace = QType::Cast($mixValue, QType::Integer));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'HeaderLine':
					/**
					 * Sets the value for intHeaderLine (Not Null)
					 * @param integer $mixValue
					 * @return integer
					 */
					try {
						return ($this->intHeaderLine = QType::Cast($mixValue, QType::Integer));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}


				///////////////////
				// Member Objects
				///////////////////
				case 'RaceObject':
					/**
					 * Sets the value for the Race object referenced by intRace (Not Null)
					 * @param Race $mixValue
					 * @return Race
					 */
					if (is_null($mixValue)) {
						$this->intRace = null;
						$this->objRaceObject = null;
						return null;
					} else {
						// Make sure $mixValue actually is a Race object
						try {
							$mixValue = QType::Cast($mixValue, 'Race');
						} catch (QInvalidCastException $objExc) {
							$objExc->IncrementOffset();
							throw $objExc;
						} 

						// Make sure $mixValue is a SAVED Race object
						if (is_null($mixValue->Id))
							throw new QCallerException('Unable to set an unsaved RaceObject for this RaceResults');

						// Update Local Member Variables
						$this->objRaceObject = $mixValue;
						$this->intRace = $mixValue->Id;

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

			
		
		// Related Objects' Methods for MemberRaceResultAsRaceResultId
		//-------------------------------------------------------------------

		/**
		 * Gets all associated MemberRaceResultsAsRaceResultId as an array of MemberRaceResult objects
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return MemberRaceResult[]
		*/ 
		public function GetMemberRaceResultAsRaceResultIdArray($objOptionalClauses = null) {
			if ((is_null($this->intId)))
				return array();

			try {
				return MemberRaceResult::LoadArrayByRaceResultId($this->intId, $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Counts all associated MemberRaceResultsAsRaceResultId
		 * @return int
		*/ 
		public function CountMemberRaceResultsAsRaceResultId() {
			if ((is_null($this->intId)))
				return 0;

			return MemberRaceResult::CountByRaceResultId($this->intId);
		}

		/**
		 * Associates a MemberRaceResultAsRaceResultId
		 * @param MemberRaceResult $objMemberRaceResult
		 * @return void
		*/ 
		public function AssociateMemberRaceResultAsRaceResultId(MemberRaceResult $objMemberRaceResult) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateMemberRaceResultAsRaceResultId on this unsaved RaceResults.');
			if ((is_null($objMemberRaceResult->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateMemberRaceResultAsRaceResultId on this RaceResults with an unsaved MemberRaceResult.');

			// Get the Database Object for this Class
			$objDatabase = RaceResults::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MemberRaceResult`
				SET
					`RaceResultId` = ' . $objDatabase->SqlVariable($this->intId) . '
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMemberRaceResult->Id) . '
			');
		}

		/**
		 * Unassociates a MemberRaceResultAsRaceResultId
		 * @param MemberRaceResult $objMemberRaceResult
		 * @return void
		*/ 
		public function UnassociateMemberRaceResultAsRaceResultId(MemberRaceResult $objMemberRaceResult) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberRaceResultAsRaceResultId on this unsaved RaceResults.');
			if ((is_null($objMemberRaceResult->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberRaceResultAsRaceResultId on this RaceResults with an unsaved MemberRaceResult.');

			// Get the Database Object for this Class
			$objDatabase = RaceResults::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MemberRaceResult`
				SET
					`RaceResultId` = null
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMemberRaceResult->Id) . ' AND
					`RaceResultId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Unassociates all MemberRaceResultsAsRaceResultId
		 * @return void
		*/ 
		public function UnassociateAllMemberRaceResultsAsRaceResultId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberRaceResultAsRaceResultId on this unsaved RaceResults.');

			// Get the Database Object for this Class
			$objDatabase = RaceResults::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MemberRaceResult`
				SET
					`RaceResultId` = null
				WHERE
					`RaceResultId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes an associated MemberRaceResultAsRaceResultId
		 * @param MemberRaceResult $objMemberRaceResult
		 * @return void
		*/ 
		public function DeleteAssociatedMemberRaceResultAsRaceResultId(MemberRaceResult $objMemberRaceResult) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberRaceResultAsRaceResultId on this unsaved RaceResults.');
			if ((is_null($objMemberRaceResult->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberRaceResultAsRaceResultId on this RaceResults with an unsaved MemberRaceResult.');

			// Get the Database Object for this Class
			$objDatabase = RaceResults::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MemberRaceResult`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMemberRaceResult->Id) . ' AND
					`RaceResultId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes all associated MemberRaceResultsAsRaceResultId
		 * @return void
		*/ 
		public function DeleteAllMemberRaceResultsAsRaceResultId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberRaceResultAsRaceResultId on this unsaved RaceResults.');

			// Get the Database Object for this Class
			$objDatabase = RaceResults::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MemberRaceResult`
				WHERE
					`RaceResultId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}




		///////////////////////////////////////////////////////////////////////
		// PROTECTED MEMBER VARIABLES and TEXT FIELD MAXLENGTHS (if applicable)
		///////////////////////////////////////////////////////////////////////
		
		/**
		 * Protected member variable that maps to the database PK Identity column RaceResults.Id
		 * @var integer intId
		 */
		protected $intId;
		const IdDefault = null;


		/**
		 * Protected member variable that maps to the database column RaceResults.RaceDate
		 * @var QDateTime dttRaceDate
		 */
		protected $dttRaceDate;
		const RaceDateDefault = null;


		/**
		 * Protected member variable that maps to the database column RaceResults.Placement
		 * @var string strPlacement
		 */
		protected $strPlacement;
		const PlacementDefault = null;


		/**
		 * Protected member variable that maps to the database column RaceResults.Race
		 * @var integer intRace
		 */
		protected $intRace;
		const RaceDefault = null;


		/**
		 * Protected member variable that maps to the database column RaceResults.HeaderLine
		 * @var integer intHeaderLine
		 */
		protected $intHeaderLine;
		const HeaderLineDefault = null;


		/**
		 * Private member variable that stores a reference to a single MemberRaceResultAsRaceResultId object
		 * (of type MemberRaceResult), if this RaceResults object was restored with
		 * an expansion on the MemberRaceResult association table.
		 * @var MemberRaceResult _objMemberRaceResultAsRaceResultId;
		 */
		private $_objMemberRaceResultAsRaceResultId;

		/**
		 * Private member variable that stores a reference to an array of MemberRaceResultAsRaceResultId objects
		 * (of type MemberRaceResult[]), if this RaceResults object was restored with
		 * an ExpandAsArray on the MemberRaceResult association table.
		 * @var MemberRaceResult[] _objMemberRaceResultAsRaceResultIdArray;
		 */
		private $_objMemberRaceResultAsRaceResultIdArray = array();

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
		 * in the database column RaceResults.Race.
		 *
		 * NOTE: Always use the RaceObject property getter to correctly retrieve this Race object.
		 * (Because this class implements late binding, this variable reference MAY be null.)
		 * @var Race objRaceObject
		 */
		protected $objRaceObject;






		////////////////////////////////////////
		// METHODS for WEB SERVICES
		////////////////////////////////////////

		public static function GetSoapComplexTypeXml() {
			$strToReturn = '<complexType name="RaceResults"><sequence>';
			$strToReturn .= '<element name="Id" type="xsd:int"/>';
			$strToReturn .= '<element name="RaceDate" type="xsd:dateTime"/>';
			$strToReturn .= '<element name="Placement" type="xsd:string"/>';
			$strToReturn .= '<element name="RaceObject" type="xsd1:Race"/>';
			$strToReturn .= '<element name="HeaderLine" type="xsd:int"/>';
			$strToReturn .= '<element name="__blnRestored" type="xsd:boolean"/>';
			$strToReturn .= '</sequence></complexType>';
			return $strToReturn;
		}

		public static function AlterSoapComplexTypeArray(&$strComplexTypeArray) {
			if (!array_key_exists('RaceResults', $strComplexTypeArray)) {
				$strComplexTypeArray['RaceResults'] = RaceResults::GetSoapComplexTypeXml();
				Race::AlterSoapComplexTypeArray($strComplexTypeArray);
			}
		}

		public static function GetArrayFromSoapArray($objSoapArray) {
			$objArrayToReturn = array();

			foreach ($objSoapArray as $objSoapObject)
				array_push($objArrayToReturn, RaceResults::GetObjectFromSoapObject($objSoapObject));

			return $objArrayToReturn;
		}

		public static function GetObjectFromSoapObject($objSoapObject) {
			$objToReturn = new RaceResults();
			if (property_exists($objSoapObject, 'Id'))
				$objToReturn->intId = $objSoapObject->Id;
			if (property_exists($objSoapObject, 'RaceDate'))
				$objToReturn->dttRaceDate = new QDateTime($objSoapObject->RaceDate);
			if (property_exists($objSoapObject, 'Placement'))
				$objToReturn->strPlacement = $objSoapObject->Placement;
			if ((property_exists($objSoapObject, 'RaceObject')) &&
				($objSoapObject->RaceObject))
				$objToReturn->RaceObject = Race::GetObjectFromSoapObject($objSoapObject->RaceObject);
			if (property_exists($objSoapObject, 'HeaderLine'))
				$objToReturn->intHeaderLine = $objSoapObject->HeaderLine;
			if (property_exists($objSoapObject, '__blnRestored'))
				$objToReturn->__blnRestored = $objSoapObject->__blnRestored;
			return $objToReturn;
		}

		public static function GetSoapArrayFromArray($objArray) {
			if (!$objArray)
				return null;

			$objArrayToReturn = array();

			foreach ($objArray as $objObject)
				array_push($objArrayToReturn, RaceResults::GetSoapObjectFromObject($objObject, true));

			return unserialize(serialize($objArrayToReturn ?? '') ?? '');
		}

		public static function GetSoapObjectFromObject($objObject, $blnBindRelatedObjects) {
			if ($objObject->dttRaceDate)
				$objObject->dttRaceDate = $objObject->dttRaceDate->toString(QDateTime::FormatSoap);
			if ($objObject->objRaceObject)
				$objObject->objRaceObject = Race::GetSoapObjectFromObject($objObject->objRaceObject, false);
			else if (!$blnBindRelatedObjects)
				$objObject->intRace = null;
			return $objObject;
		}
	}





	/////////////////////////////////////
	// ADDITIONAL CLASSES for QCODO QUERY
	/////////////////////////////////////

	class QQNodeRaceResults extends QQNode {
		protected $strTableName = 'RaceResults';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'RaceResults';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'RaceDate':
					return new QQNode('RaceDate', 'QDateTime', $this);
				case 'Placement':
					return new QQNode('Placement', 'string', $this);
				case 'Race':
					return new QQNode('Race', 'integer', $this);
				case 'RaceObject':
					return new QQNodeRace('Race', 'integer', $this);
				case 'HeaderLine':
					return new QQNode('HeaderLine', 'integer', $this);
				case 'MemberRaceResultAsRaceResultId':
					return new QQReverseReferenceNodeMemberRaceResult($this, 'memberraceresultasraceresultid', 'reverse_reference', 'RaceResultId');

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

	class QQReverseReferenceNodeRaceResults extends QQReverseReferenceNode {
		protected $strTableName = 'RaceResults';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'RaceResults';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'RaceDate':
					return new QQNode('RaceDate', 'QDateTime', $this);
				case 'Placement':
					return new QQNode('Placement', 'string', $this);
				case 'Race':
					return new QQNode('Race', 'integer', $this);
				case 'RaceObject':
					return new QQNodeRace('Race', 'integer', $this);
				case 'HeaderLine':
					return new QQNode('HeaderLine', 'integer', $this);
				case 'MemberRaceResultAsRaceResultId':
					return new QQReverseReferenceNodeMemberRaceResult($this, 'memberraceresultasraceresultid', 'reverse_reference', 'RaceResultId');

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