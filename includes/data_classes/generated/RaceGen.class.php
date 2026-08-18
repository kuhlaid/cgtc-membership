<?php
	/**
	 * The abstract RaceGen class defined here is
	 * code-generated and contains all the basic CRUD-type functionality as well as
	 * basic methods to handle relationships and index-based loading.
	 *
	 * To use, you should use the Race subclass which
	 * extends this RaceGen class.
	 *
	 * Because subsequent re-code generations will overwrite any changes to this
	 * file, you should leave this file unaltered to prevent yourself from losing
	 * any information or code changes.  All customizations should be done by
	 * overriding existing or implementing new methods, properties and variables
	 * in the Race class.
	 * 
	 * @package My Application
	 * @subpackage GeneratedDataObjects
	 * 
	 */
	class RaceGen extends QBaseClass {
		///////////////////////////////
		// COMMON LOAD METHODS
		///////////////////////////////

		/**
		 * Load a Race from PK Info
		 * @param integer $intId
		 * @return Race
		 */
		public static function Load($intId) {
			// Use QuerySingle to Perform the Query
			return Race::QuerySingle(
				QQ::Equal(QQN::Race()->Id, $intId)
			);
		}

		/**
		 * Load all Races
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return Race[]
		 */
		public static function LoadAll($objOptionalClauses = null) {
			// Call Race::QueryArray to perform the LoadAll query
			try {
				return Race::QueryArray(QQ::All(), $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count all Races
		 * @return int
		 */
		public static function CountAll() {
			// Call Race::QueryCount to perform the CountAll query
			return Race::QueryCount(QQ::All());
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
			$objDatabase = Race::GetDatabase();

			// Create/Build out the QueryBuilder object with Race-specific SELET and FROM fields
			$objQueryBuilder = new QQueryBuilder($objDatabase, 'Race');
			Race::GetSelectFields($objQueryBuilder,null,$selectionArray);
			$objQueryBuilder->AddFromItem('`Race` AS `Race`');

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
		 * Static Qcodo Query method to query for a single Race object.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return Race the queried object
		 */
		public static function QuerySingle(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = Race::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query, Get the First Row, and Instantiate a new Race object
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return Race::InstantiateDbRow($objDbResult->GetNextRow());
		}

		/**
		 * Static Qcodo Query method to query for an array of Race objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return Race[] the queried objects as an array
		 */
		public static function QueryArray(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = Race::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query and Instantiate the Array Result
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return Race::InstantiateDbResult($objDbResult, $objQueryBuilder->ExpandAsArrayNodes);
		}

		/**
		 * Static Qcodo Query method to query for a count of Race objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return integer the count of queried objects as an integer
		 */
		public static function QueryCount(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = Race::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, true,$selectionArray);
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
			$objDatabase = Race::GetDatabase();

			// Lookup the QCache for This Query Statement
			$objCache = new QCache('query', 'Race_' . serialize($strConditions));
			if (!($strQuery = $objCache->GetData())) {
				// Not Found -- Go ahead and Create/Build out a new QueryBuilder object with Race-specific fields
				$objQueryBuilder = new QQueryBuilder($objDatabase);
				Race::GetSelectFields($objQueryBuilder);
				Race::GetFromFields($objQueryBuilder);

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
			return Race::InstantiateDbResult($objDbResult);
		}*/

		/**
		 * Updates a QQueryBuilder with the SELECT fields for this Race
		 * @param QQueryBuilder $objBuilder the Query Builder object to update
		 * @param string $strPrefix optional prefix to add to the SELECT fields
		 * @param array $selectionArray optional array of SELECT field items (wpg - added Sept 2012)
		 */
		public static function GetSelectFields(QQueryBuilder $objBuilder, $strPrefix = null, $selectionArray = null) {
			if ($strPrefix) {
				$strTableName = '`' . $strPrefix . '`';
				$strAliasPrefix = '`' . $strPrefix . '__';
			} else {
				$strTableName = '`Race`';
				$strAliasPrefix = '`';
			}

			// wpg - if we are not passing in an array of participant fields we want then get them all
			if (!$selectionArray){
				$objBuilder->AddSelectItem($strTableName . '.`Id` AS ' . $strAliasPrefix . 'Id`');
				$objBuilder->AddSelectItem($strTableName . '.`Name` AS ' . $strAliasPrefix . 'Name`');
				$objBuilder->AddSelectItem($strTableName . '.`Distance` AS ' . $strAliasPrefix . 'Distance`');
				$objBuilder->AddSelectItem($strTableName . '.`DistanceUnit` AS ' . $strAliasPrefix . 'DistanceUnit`');
				$objBuilder->AddSelectItem($strTableName . '.`Website` AS ' . $strAliasPrefix . 'Website`');
				$objBuilder->AddSelectItem($strTableName . '.`RaceLocation` AS ' . $strAliasPrefix . 'RaceLocation`');
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
		 * Instantiate a Race from a Database Row.
		 * Takes in an optional strAliasPrefix, used in case another Object::InstantiateDbRow
		 * is calling this Race::InstantiateDbRow in order to perform
		 * early binding on referenced objects.
		 * @param DatabaseRowBase $objDbRow
		 * @param string $strAliasPrefix
		 * @return Race
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
					$strAliasPrefix = 'Race__';


				if ((array_key_exists($strAliasPrefix . 'raceresults__Id', $strExpandAsArrayNodes)) &&
					(!is_null($objDbRow->GetColumn($strAliasPrefix . 'raceresults__Id')))) {
					if ($intPreviousChildItemCount = count($objPreviousItem->_objRaceResultsArray)) {
						$objPreviousChildItem = $objPreviousItem->_objRaceResultsArray[$intPreviousChildItemCount - 1];
						$objChildItem = RaceResults::InstantiateDbRow($objDbRow, $strAliasPrefix . 'raceresults__', $strExpandAsArrayNodes, $objPreviousChildItem);
						if ($objChildItem)
							array_push($objPreviousItem->_objRaceResultsArray, $objChildItem);
					} else
						array_push($objPreviousItem->_objRaceResultsArray, RaceResults::InstantiateDbRow($objDbRow, $strAliasPrefix . 'raceresults__', $strExpandAsArrayNodes));
					$blnExpandedViaArray = true;
				}

				// Either return false to signal array expansion, or check-to-reset the Alias prefix and move on
				if ($blnExpandedViaArray)
					return false;
				else if ($strAliasPrefix == 'Race__')
					$strAliasPrefix = null;
			}

			// Create a new instance of the Race object
			$objToReturn = new Race();
			$objToReturn->__blnRestored = true;

			$objToReturn->intId = $objDbRow->GetColumn($strAliasPrefix . 'Id', 'Integer');
			$objToReturn->strName = $objDbRow->GetColumn($strAliasPrefix . 'Name', 'VarChar');
			$objToReturn->fltDistance = $objDbRow->GetColumn($strAliasPrefix . 'Distance', 'Float');
			$objToReturn->intDistanceUnit = $objDbRow->GetColumn($strAliasPrefix . 'DistanceUnit', 'Integer');
			$objToReturn->strWebsite = $objDbRow->GetColumn($strAliasPrefix . 'Website', 'VarChar');
			$objToReturn->strRaceLocation = $objDbRow->GetColumn($strAliasPrefix . 'RaceLocation', 'VarChar');

			// Instantiate Virtual Attributes
			foreach ($objDbRow->GetColumnNameArray() as $strColumnName => $mixValue) {
				$strVirtualPrefix = $strAliasPrefix . '__';
				$strVirtualPrefixLength = strlen($strVirtualPrefix ?? '');
				if (substr($strColumnName, 0, $strVirtualPrefixLength) == $strVirtualPrefix)
					$objToReturn->__strVirtualAttributeArray[substr($strColumnName, $strVirtualPrefixLength)] = $mixValue;
			}

			// Prepare to Check for Early/Virtual Binding
			if (!$strAliasPrefix)
				$strAliasPrefix = 'Race__';




			// Check for RaceResults Virtual Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'raceresults__Id'))) {
				if (($strExpandAsArrayNodes) && (array_key_exists($strAliasPrefix . 'raceresults__Id', $strExpandAsArrayNodes)))
					array_push($objToReturn->_objRaceResultsArray, RaceResults::InstantiateDbRow($objDbRow, $strAliasPrefix . 'raceresults__', $strExpandAsArrayNodes));
				else
					$objToReturn->_objRaceResults = RaceResults::InstantiateDbRow($objDbRow, $strAliasPrefix . 'raceresults__', $strExpandAsArrayNodes);
			}

			return $objToReturn;
		}

		/**
		 * Instantiate an array of Races from a Database Result
		 * @param DatabaseResultBase $objDbResult
		 * @return Race[]
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
					$objItem = Race::InstantiateDbRow($objDbRow, null, $strExpandAsArrayNodes, $objLastRowItem);
					if ($objItem) {
						array_push($objToReturn, $objItem);
						$objLastRowItem = $objItem;
					}
				}
			} else {
				while ($objDbRow = $objDbResult->GetNextRow())
					array_push($objToReturn, Race::InstantiateDbRow($objDbRow));
			}

			return $objToReturn;
		}



		///////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Single Load and Array)
		///////////////////////////////////////////////////
			
		/**
		 * Load a single Race object,
		 * by Id Index(es)
		 * @param integer $intId
		 * @return Race
		*/
		public static function LoadById($intId) {
			return Race::QuerySingle(
				QQ::Equal(QQN::Race()->Id, $intId)
			);
		}



		////////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Array via Many to Many)
		////////////////////////////////////////////////////



		//////////////////
		// SAVE AND DELETE
		//////////////////

		/**
		 * Save this Race
		 * @param bool $blnForceInsert
		 * @param bool $blnForceUpdate
		 * @return int
		*/
		public function Save($blnForceInsert = false, $blnForceUpdate = false) {
			// Get the Database Object for this Class
			$objDatabase = Race::GetDatabase();

			$mixToReturn = null;

			try {
				if ((!$this->__blnRestored) || ($blnForceInsert)) {
					// Perform an INSERT query
					$objDatabase->NonQuery('
						INSERT INTO `Race` (
							`Name`,
							`Distance`,
							`DistanceUnit`,
							`Website`,
							`RaceLocation`
						) VALUES (
							' . $objDatabase->SqlVariable($this->strName) . ',
							' . $objDatabase->SqlVariable($this->fltDistance) . ',
							' . $objDatabase->SqlVariable($this->intDistanceUnit) . ',
							' . $objDatabase->SqlVariable($this->strWebsite) . ',
							' . $objDatabase->SqlVariable($this->strRaceLocation) . '
						)
					');

					// Update Identity column and return its value
					$mixToReturn = $this->intId = $objDatabase->InsertId('Race', 'Id');
				} else {
					// Perform an UPDATE query

					// First checking for Optimistic Locking constraints (if applicable)

					// Perform the UPDATE query
					$objDatabase->NonQuery('
						UPDATE
							`Race`
						SET
							`Name` = ' . $objDatabase->SqlVariable($this->strName) . ',
							`Distance` = ' . $objDatabase->SqlVariable($this->fltDistance) . ',
							`DistanceUnit` = ' . $objDatabase->SqlVariable($this->intDistanceUnit) . ',
							`Website` = ' . $objDatabase->SqlVariable($this->strWebsite) . ',
							`RaceLocation` = ' . $objDatabase->SqlVariable($this->strRaceLocation) . '
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
		 * Delete this Race
		 * @return void
		*/
		public function Delete() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Cannot delete this Race with an unset primary key.');

			// Get the Database Object for this Class
			$objDatabase = Race::GetDatabase();


			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`Race`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($this->intId) . '');
		}

		/**
		 * Delete all Races
		 * @return void
		*/
		public static function DeleteAll() {
			// Get the Database Object for this Class
			$objDatabase = Race::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				DELETE FROM
					`Race`');
		}

		/**
		 * Truncate Race table
		 * @return void
		*/
		public static function Truncate() {
			// Get the Database Object for this Class
			$objDatabase = Race::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				TRUNCATE `Race`');
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

				case 'Name':
					/**
					 * Gets the value for strName (Not Null)
					 * @return string
					 */
					return $this->strName;

				case 'Distance':
					/**
					 * Gets the value for fltDistance (Not Null)
					 * @return double
					 */
					return $this->fltDistance;

				case 'DistanceUnit':
					/**
					 * Gets the value for intDistanceUnit (Not Null)
					 * @return integer
					 */
					return $this->intDistanceUnit;

				case 'Website':
					/**
					 * Gets the value for strWebsite 
					 * @return string
					 */
					return $this->strWebsite;

				case 'RaceLocation':
					/**
					 * Gets the value for strRaceLocation 
					 * @return string
					 */
					return $this->strRaceLocation;


				///////////////////
				// Member Objects
				///////////////////

				////////////////////////////
				// Virtual Object References (Many to Many and Reverse References)
				// (If restored via a "Many-to" expansion)
				////////////////////////////

				case '_RaceResults':
					/**
					 * Gets the value for the private _objRaceResults (Read-Only)
					 * if set due to an expansion on the RaceResults.Race reverse relationship
					 * @return RaceResults
					 */
					return $this->_objRaceResults;

				case '_RaceResultsArray':
					/**
					 * Gets the value for the private _objRaceResultsArray (Read-Only)
					 * if set due to an ExpandAsArray on the RaceResults.Race reverse relationship
					 * @return RaceResults[]
					 */
					return (array) $this->_objRaceResultsArray;

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
				case 'Name':
					/**
					 * Sets the value for strName (Not Null)
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strName = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'Distance':
					/**
					 * Sets the value for fltDistance (Not Null)
					 * @param double $mixValue
					 * @return double
					 */
					try {
						return ($this->fltDistance = QType::Cast($mixValue, QType::Float));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'DistanceUnit':
					/**
					 * Sets the value for intDistanceUnit (Not Null)
					 * @param integer $mixValue
					 * @return integer
					 */
					try {
						return ($this->intDistanceUnit = QType::Cast($mixValue, QType::Integer));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'Website':
					/**
					 * Sets the value for strWebsite 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strWebsite = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'RaceLocation':
					/**
					 * Sets the value for strRaceLocation 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strRaceLocation = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}


				///////////////////
				// Member Objects
				///////////////////
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

			
		
		// Related Objects' Methods for RaceResults
		//-------------------------------------------------------------------

		/**
		 * Gets all associated RaceResultses as an array of RaceResults objects
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return RaceResults[]
		*/ 
		public function GetRaceResultsArray($objOptionalClauses = null) {
			if ((is_null($this->intId)))
				return array();

			try {
				return RaceResults::LoadArrayByRace($this->intId, $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Counts all associated RaceResultses
		 * @return int
		*/ 
		public function CountRaceResultses() {
			if ((is_null($this->intId)))
				return 0;

			return RaceResults::CountByRace($this->intId);
		}

		/**
		 * Associates a RaceResults
		 * @param RaceResults $objRaceResults
		 * @return void
		*/ 
		public function AssociateRaceResults(RaceResults $objRaceResults) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateRaceResults on this unsaved Race.');
			if ((is_null($objRaceResults->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateRaceResults on this Race with an unsaved RaceResults.');

			// Get the Database Object for this Class
			$objDatabase = Race::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`RaceResults`
				SET
					`Race` = ' . $objDatabase->SqlVariable($this->intId) . '
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objRaceResults->Id) . '
			');
		}

		/**
		 * Unassociates a RaceResults
		 * @param RaceResults $objRaceResults
		 * @return void
		*/ 
		public function UnassociateRaceResults(RaceResults $objRaceResults) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateRaceResults on this unsaved Race.');
			if ((is_null($objRaceResults->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateRaceResults on this Race with an unsaved RaceResults.');

			// Get the Database Object for this Class
			$objDatabase = Race::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`RaceResults`
				SET
					`Race` = null
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objRaceResults->Id) . ' AND
					`Race` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Unassociates all RaceResultses
		 * @return void
		*/ 
		public function UnassociateAllRaceResultses() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateRaceResults on this unsaved Race.');

			// Get the Database Object for this Class
			$objDatabase = Race::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`RaceResults`
				SET
					`Race` = null
				WHERE
					`Race` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes an associated RaceResults
		 * @param RaceResults $objRaceResults
		 * @return void
		*/ 
		public function DeleteAssociatedRaceResults(RaceResults $objRaceResults) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateRaceResults on this unsaved Race.');
			if ((is_null($objRaceResults->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateRaceResults on this Race with an unsaved RaceResults.');

			// Get the Database Object for this Class
			$objDatabase = Race::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`RaceResults`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objRaceResults->Id) . ' AND
					`Race` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes all associated RaceResultses
		 * @return void
		*/ 
		public function DeleteAllRaceResultses() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateRaceResults on this unsaved Race.');

			// Get the Database Object for this Class
			$objDatabase = Race::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`RaceResults`
				WHERE
					`Race` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}




		///////////////////////////////////////////////////////////////////////
		// PROTECTED MEMBER VARIABLES and TEXT FIELD MAXLENGTHS (if applicable)
		///////////////////////////////////////////////////////////////////////
		
		/**
		 * Protected member variable that maps to the database PK Identity column Race.Id
		 * @var integer intId
		 */
		protected $intId;
		const IdDefault = null;


		/**
		 * Protected member variable that maps to the database column Race.Name
		 * @var string strName
		 */
		protected $strName;
		const NameMaxLength = 200;
		const NameDefault = null;


		/**
		 * Protected member variable that maps to the database column Race.Distance
		 * @var double fltDistance
		 */
		protected $fltDistance;
		const DistanceDefault = null;


		/**
		 * Protected member variable that maps to the database column Race.DistanceUnit
		 * @var integer intDistanceUnit
		 */
		protected $intDistanceUnit;
		const DistanceUnitDefault = null;


		/**
		 * Protected member variable that maps to the database column Race.Website
		 * @var string strWebsite
		 */
		protected $strWebsite;
		const WebsiteMaxLength = 250;
		const WebsiteDefault = null;


		/**
		 * Protected member variable that maps to the database column Race.RaceLocation
		 * @var string strRaceLocation
		 */
		protected $strRaceLocation;
		const RaceLocationMaxLength = 250;
		const RaceLocationDefault = null;


		/**
		 * Private member variable that stores a reference to a single RaceResults object
		 * (of type RaceResults), if this Race object was restored with
		 * an expansion on the RaceResults association table.
		 * @var RaceResults _objRaceResults;
		 */
		private $_objRaceResults;

		/**
		 * Private member variable that stores a reference to an array of RaceResults objects
		 * (of type RaceResults[]), if this Race object was restored with
		 * an ExpandAsArray on the RaceResults association table.
		 * @var RaceResults[] _objRaceResultsArray;
		 */
		private $_objRaceResultsArray = array();

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






		////////////////////////////////////////
		// METHODS for WEB SERVICES
		////////////////////////////////////////

		public static function GetSoapComplexTypeXml() {
			$strToReturn = '<complexType name="Race"><sequence>';
			$strToReturn .= '<element name="Id" type="xsd:int"/>';
			$strToReturn .= '<element name="Name" type="xsd:string"/>';
			$strToReturn .= '<element name="Distance" type="xsd:float"/>';
			$strToReturn .= '<element name="DistanceUnit" type="xsd:int"/>';
			$strToReturn .= '<element name="Website" type="xsd:string"/>';
			$strToReturn .= '<element name="RaceLocation" type="xsd:string"/>';
			$strToReturn .= '<element name="__blnRestored" type="xsd:boolean"/>';
			$strToReturn .= '</sequence></complexType>';
			return $strToReturn;
		}

		public static function AlterSoapComplexTypeArray(&$strComplexTypeArray) {
			if (!array_key_exists('Race', $strComplexTypeArray)) {
				$strComplexTypeArray['Race'] = Race::GetSoapComplexTypeXml();
			}
		}

		public static function GetArrayFromSoapArray($objSoapArray) {
			$objArrayToReturn = array();

			foreach ($objSoapArray as $objSoapObject)
				array_push($objArrayToReturn, Race::GetObjectFromSoapObject($objSoapObject));

			return $objArrayToReturn;
		}

		public static function GetObjectFromSoapObject($objSoapObject) {
			$objToReturn = new Race();
			if (property_exists($objSoapObject, 'Id'))
				$objToReturn->intId = $objSoapObject->Id;
			if (property_exists($objSoapObject, 'Name'))
				$objToReturn->strName = $objSoapObject->Name;
			if (property_exists($objSoapObject, 'Distance'))
				$objToReturn->fltDistance = $objSoapObject->Distance;
			if (property_exists($objSoapObject, 'DistanceUnit'))
				$objToReturn->intDistanceUnit = $objSoapObject->DistanceUnit;
			if (property_exists($objSoapObject, 'Website'))
				$objToReturn->strWebsite = $objSoapObject->Website;
			if (property_exists($objSoapObject, 'RaceLocation'))
				$objToReturn->strRaceLocation = $objSoapObject->RaceLocation;
			if (property_exists($objSoapObject, '__blnRestored'))
				$objToReturn->__blnRestored = $objSoapObject->__blnRestored;
			return $objToReturn;
		}

		public static function GetSoapArrayFromArray($objArray) {
			if (!$objArray)
				return null;

			$objArrayToReturn = array();

			foreach ($objArray as $objObject)
				array_push($objArrayToReturn, Race::GetSoapObjectFromObject($objObject, true));

			return unserialize(serialize($objArrayToReturn ?? '') ?? '');
		}

		public static function GetSoapObjectFromObject($objObject, $blnBindRelatedObjects) {
			return $objObject;
		}
	}





	/////////////////////////////////////
	// ADDITIONAL CLASSES for QCODO QUERY
	/////////////////////////////////////

	class QQNodeRace extends QQNode {
		protected $strTableName = 'Race';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'Race';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'Name':
					return new QQNode('Name', 'string', $this);
				case 'Distance':
					return new QQNode('Distance', 'double', $this);
				case 'DistanceUnit':
					return new QQNode('DistanceUnit', 'integer', $this);
				case 'Website':
					return new QQNode('Website', 'string', $this);
				case 'RaceLocation':
					return new QQNode('RaceLocation', 'string', $this);
				case 'RaceResults':
					return new QQReverseReferenceNodeRaceResults($this, 'raceresults', 'reverse_reference', 'Race');

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

	class QQReverseReferenceNodeRace extends QQReverseReferenceNode {
		protected $strTableName = 'Race';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'Race';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'Name':
					return new QQNode('Name', 'string', $this);
				case 'Distance':
					return new QQNode('Distance', 'double', $this);
				case 'DistanceUnit':
					return new QQNode('DistanceUnit', 'integer', $this);
				case 'Website':
					return new QQNode('Website', 'string', $this);
				case 'RaceLocation':
					return new QQNode('RaceLocation', 'string', $this);
				case 'RaceResults':
					return new QQReverseReferenceNodeRaceResults($this, 'raceresults', 'reverse_reference', 'Race');

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