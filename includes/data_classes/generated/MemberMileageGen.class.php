<?php
	/**
	 * The abstract MemberMileageGen class defined here is
	 * code-generated and contains all the basic CRUD-type functionality as well as
	 * basic methods to handle relationships and index-based loading.
	 *
	 * To use, you should use the MemberMileage subclass which
	 * extends this MemberMileageGen class.
	 *
	 * Because subsequent re-code generations will overwrite any changes to this
	 * file, you should leave this file unaltered to prevent yourself from losing
	 * any information or code changes.  All customizations should be done by
	 * overriding existing or implementing new methods, properties and variables
	 * in the MemberMileage class.
	 * 
	 * @package My Application
	 * @subpackage GeneratedDataObjects
	 * 
	 */
	class MemberMileageGen extends QBaseClass {
		///////////////////////////////
		// COMMON LOAD METHODS
		///////////////////////////////

		/**
		 * Load a MemberMileage from PK Info
		 * @param integer $intId
		 * @return MemberMileage
		 */
		public static function Load($intId) {
			// Use QuerySingle to Perform the Query
			return MemberMileage::QuerySingle(
				QQ::Equal(QQN::MemberMileage()->Id, $intId)
			);
		}

		/**
		 * Load all MemberMileages
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return MemberMileage[]
		 */
		public static function LoadAll($objOptionalClauses = null) {
			// Call MemberMileage::QueryArray to perform the LoadAll query
			try {
				return MemberMileage::QueryArray(QQ::All(), $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count all MemberMileages
		 * @return int
		 */
		public static function CountAll() {
			// Call MemberMileage::QueryCount to perform the CountAll query
			return MemberMileage::QueryCount(QQ::All());
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
			$objDatabase = MemberMileage::GetDatabase();

			// Create/Build out the QueryBuilder object with MemberMileage-specific SELET and FROM fields
			$objQueryBuilder = new QQueryBuilder($objDatabase, 'MemberMileage');
			MemberMileage::GetSelectFields($objQueryBuilder,null,$selectionArray);
			$objQueryBuilder->AddFromItem('`MemberMileage` AS `MemberMileage`');

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
		 * Static Qcodo Query method to query for a single MemberMileage object.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return MemberMileage the queried object
		 */
		public static function QuerySingle(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = MemberMileage::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query, Get the First Row, and Instantiate a new MemberMileage object
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return MemberMileage::InstantiateDbRow($objDbResult->GetNextRow());
		}

		/**
		 * Static Qcodo Query method to query for an array of MemberMileage objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return MemberMileage[] the queried objects as an array
		 */
		public static function QueryArray(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = MemberMileage::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query and Instantiate the Array Result
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return MemberMileage::InstantiateDbResult($objDbResult, $objQueryBuilder->ExpandAsArrayNodes);
		}

		/**
		 * Static Qcodo Query method to query for a count of MemberMileage objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return integer the count of queried objects as an integer
		 */
		public static function QueryCount(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = MemberMileage::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, true,$selectionArray);
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
			$objDatabase = MemberMileage::GetDatabase();

			// Lookup the QCache for This Query Statement
			$objCache = new QCache('query', 'MemberMileage_' . serialize($strConditions));
			if (!($strQuery = $objCache->GetData())) {
				// Not Found -- Go ahead and Create/Build out a new QueryBuilder object with MemberMileage-specific fields
				$objQueryBuilder = new QQueryBuilder($objDatabase);
				MemberMileage::GetSelectFields($objQueryBuilder);
				MemberMileage::GetFromFields($objQueryBuilder);

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
			return MemberMileage::InstantiateDbResult($objDbResult);
		}*/

		/**
		 * Updates a QQueryBuilder with the SELECT fields for this MemberMileage
		 * @param QQueryBuilder $objBuilder the Query Builder object to update
		 * @param string $strPrefix optional prefix to add to the SELECT fields
		 * @param array $selectionArray optional array of SELECT field items (wpg - added Sept 2012)
		 */
		public static function GetSelectFields(QQueryBuilder $objBuilder, $strPrefix = null, $selectionArray = null) {
			if ($strPrefix) {
				$strTableName = '`' . $strPrefix . '`';
				$strAliasPrefix = '`' . $strPrefix . '__';
			} else {
				$strTableName = '`MemberMileage`';
				$strAliasPrefix = '`';
			}

			// wpg - if we are not passing in an array of participant fields we want then get them all
			if (!$selectionArray){
				$objBuilder->AddSelectItem($strTableName . '.`Id` AS ' . $strAliasPrefix . 'Id`');
				$objBuilder->AddSelectItem($strTableName . '.`MemberId` AS ' . $strAliasPrefix . 'MemberId`');
				$objBuilder->AddSelectItem($strTableName . '.`Miles` AS ' . $strAliasPrefix . 'Miles`');
				$objBuilder->AddSelectItem($strTableName . '.`LoggedOn` AS ' . $strAliasPrefix . 'LoggedOn`');
				$objBuilder->AddSelectItem($strTableName . '.`Notes` AS ' . $strAliasPrefix . 'Notes`');
				$objBuilder->AddSelectItem($strTableName . '.`Year` AS ' . $strAliasPrefix . 'Year`');
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
		 * Instantiate a MemberMileage from a Database Row.
		 * Takes in an optional strAliasPrefix, used in case another Object::InstantiateDbRow
		 * is calling this MemberMileage::InstantiateDbRow in order to perform
		 * early binding on referenced objects.
		 * @param DatabaseRowBase $objDbRow
		 * @param string $strAliasPrefix
		 * @return MemberMileage
		*/
		public static function InstantiateDbRow($objDbRow, $strAliasPrefix = null, $strExpandAsArrayNodes = null, $objPreviousItem = null) {
			// If blank row, return null
			if (!$objDbRow)
				return null;


			// Create a new instance of the MemberMileage object
			$objToReturn = new MemberMileage();
			$objToReturn->__blnRestored = true;

			$objToReturn->intId = $objDbRow->GetColumn($strAliasPrefix . 'Id', 'Integer');
			$objToReturn->__intId = $objDbRow->GetColumn($strAliasPrefix . 'Id', 'Integer');
			$objToReturn->intMemberId = $objDbRow->GetColumn($strAliasPrefix . 'MemberId', 'Integer');
			$objToReturn->fltMiles = $objDbRow->GetColumn($strAliasPrefix . 'Miles', 'Float');
			$objToReturn->dttLoggedOn = $objDbRow->GetColumn($strAliasPrefix . 'LoggedOn', 'Date');
			$objToReturn->strNotes = $objDbRow->GetColumn($strAliasPrefix . 'Notes', 'VarChar');
			$objToReturn->intYear = $objDbRow->GetColumn($strAliasPrefix . 'Year', 'Integer');

			// Instantiate Virtual Attributes
			foreach ($objDbRow->GetColumnNameArray() as $strColumnName => $mixValue) {
				$strVirtualPrefix = $strAliasPrefix . '__';
				$strVirtualPrefixLength = strlen($strVirtualPrefix ?? '');
				if (substr($strColumnName, 0, $strVirtualPrefixLength) == $strVirtualPrefix)
					$objToReturn->__strVirtualAttributeArray[substr($strColumnName, $strVirtualPrefixLength)] = $mixValue;
			}

			// Prepare to Check for Early/Virtual Binding
			if (!$strAliasPrefix)
				$strAliasPrefix = 'MemberMileage__';

			// Check for MemberIdObject Early Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'MemberId__Id')))
				$objToReturn->objMemberIdObject = MemberContact::InstantiateDbRow($objDbRow, $strAliasPrefix . 'MemberId__', $strExpandAsArrayNodes);




			return $objToReturn;
		}

		/**
		 * Instantiate an array of MemberMileages from a Database Result
		 * @param DatabaseResultBase $objDbResult
		 * @return MemberMileage[]
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
					$objItem = MemberMileage::InstantiateDbRow($objDbRow, null, $strExpandAsArrayNodes, $objLastRowItem);
					if ($objItem) {
						array_push($objToReturn, $objItem);
						$objLastRowItem = $objItem;
					}
				}
			} else {
				while ($objDbRow = $objDbResult->GetNextRow())
					array_push($objToReturn, MemberMileage::InstantiateDbRow($objDbRow));
			}

			return $objToReturn;
		}



		///////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Single Load and Array)
		///////////////////////////////////////////////////
			
		/**
		 * Load a single MemberMileage object,
		 * by Id Index(es)
		 * @param integer $intId
		 * @return MemberMileage
		*/
		public static function LoadById($intId) {
			return MemberMileage::QuerySingle(
				QQ::Equal(QQN::MemberMileage()->Id, $intId)
			);
		}
			
		/**
		 * Load an array of MemberMileage objects,
		 * by MemberId Index(es)
		 * @param integer $intMemberId
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return MemberMileage[]
		*/
		public static function LoadArrayByMemberId($intMemberId, $objOptionalClauses = null) {
			// Call MemberMileage::QueryArray to perform the LoadArrayByMemberId query
			try {
				return MemberMileage::QueryArray(
					QQ::Equal(QQN::MemberMileage()->MemberId, $intMemberId),
					$objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count MemberMileages
		 * by MemberId Index(es)
		 * @param integer $intMemberId
		 * @return int
		*/
		public static function CountByMemberId($intMemberId) {
			// Call MemberMileage::QueryCount to perform the CountByMemberId query
			return MemberMileage::QueryCount(
				QQ::Equal(QQN::MemberMileage()->MemberId, $intMemberId)
			);
		}



		////////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Array via Many to Many)
		////////////////////////////////////////////////////



		//////////////////
		// SAVE AND DELETE
		//////////////////

		/**
		 * Save this MemberMileage
		 * @param bool $blnForceInsert
		 * @param bool $blnForceUpdate
		 * @return void
		*/
		public function Save($blnForceInsert = false, $blnForceUpdate = false) {
			// Get the Database Object for this Class
			$objDatabase = MemberMileage::GetDatabase();

			$mixToReturn = null;

			try {
				if ((!$this->__blnRestored) || ($blnForceInsert)) {
					// Perform an INSERT query
					$objDatabase->NonQuery('
						INSERT INTO `MemberMileage` (
							`Id`,
							`MemberId`,
							`Miles`,
							`LoggedOn`,
							`Notes`,
							`Year`
						) VALUES (
							' . $objDatabase->SqlVariable($this->intId) . ',
							' . $objDatabase->SqlVariable($this->intMemberId) . ',
							' . $objDatabase->SqlVariable($this->fltMiles) . ',
							' . $objDatabase->SqlVariable($this->dttLoggedOn) . ',
							' . $objDatabase->SqlVariable($this->strNotes) . ',
							' . $objDatabase->SqlVariable($this->intYear) . '
						)
					');


				} else {
					// Perform an UPDATE query

					// First checking for Optimistic Locking constraints (if applicable)

					// Perform the UPDATE query
					$objDatabase->NonQuery('
						UPDATE
							`MemberMileage`
						SET
							`Id` = ' . $objDatabase->SqlVariable($this->intId) . ',
							`MemberId` = ' . $objDatabase->SqlVariable($this->intMemberId) . ',
							`Miles` = ' . $objDatabase->SqlVariable($this->fltMiles) . ',
							`LoggedOn` = ' . $objDatabase->SqlVariable($this->dttLoggedOn) . ',
							`Notes` = ' . $objDatabase->SqlVariable($this->strNotes) . ',
							`Year` = ' . $objDatabase->SqlVariable($this->intYear) . '
						WHERE
							`Id` = ' . $objDatabase->SqlVariable($this->__intId) . '
					');
				}

			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Update __blnRestored and any Non-Identity PK Columns (if applicable)
			$this->__blnRestored = true;
			$this->__intId = $this->intId;


			// Return 
			return $mixToReturn;
		}

				/**
		 * Delete this MemberMileage
		 * @return void
		*/
		public function Delete() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Cannot delete this MemberMileage with an unset primary key.');

			// Get the Database Object for this Class
			$objDatabase = MemberMileage::GetDatabase();


			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MemberMileage`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($this->intId) . '');
		}

		/**
		 * Delete all MemberMileages
		 * @return void
		*/
		public static function DeleteAll() {
			// Get the Database Object for this Class
			$objDatabase = MemberMileage::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MemberMileage`');
		}

		/**
		 * Truncate MemberMileage table
		 * @return void
		*/
		public static function Truncate() {
			// Get the Database Object for this Class
			$objDatabase = MemberMileage::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				TRUNCATE `MemberMileage`');
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
					 * Gets the value for intId (PK)
					 * @return integer
					 */
					return $this->intId;

				case 'MemberId':
					/**
					 * Gets the value for intMemberId (Not Null)
					 * @return integer
					 */
					return $this->intMemberId;

				case 'Miles':
					/**
					 * Gets the value for fltMiles (Not Null)
					 * @return double
					 */
					return $this->fltMiles;

				case 'LoggedOn':
					/**
					 * Gets the value for dttLoggedOn (Not Null)
					 * @return QDateTime
					 */
					return $this->dttLoggedOn;

				case 'Notes':
					/**
					 * Gets the value for strNotes 
					 * @return string
					 */
					return $this->strNotes;

				case 'Year':
					/**
					 * Gets the value for intYear (Not Null)
					 * @return integer
					 */
					return $this->intYear;


				///////////////////
				// Member Objects
				///////////////////
				case 'MemberIdObject':
					/**
					 * Gets the value for the MemberContact object referenced by intMemberId (Not Null)
					 * @return MemberContact
					 */
					try {
						if ((!$this->objMemberIdObject) && (!is_null($this->intMemberId)))
							$this->objMemberIdObject = MemberContact::Load($this->intMemberId);
						return $this->objMemberIdObject;
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
				case 'Id':
					/**
					 * Sets the value for intId (PK)
					 * @param integer $mixValue
					 * @return integer
					 */
					try {
						return ($this->intId = QType::Cast($mixValue, QType::Integer));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'MemberId':
					/**
					 * Sets the value for intMemberId (Not Null)
					 * @param integer $mixValue
					 * @return integer
					 */
					try {
						$this->objMemberIdObject = null;
						return ($this->intMemberId = QType::Cast($mixValue, QType::Integer));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'Miles':
					/**
					 * Sets the value for fltMiles (Not Null)
					 * @param double $mixValue
					 * @return double
					 */
					try {
						return ($this->fltMiles = QType::Cast($mixValue, QType::Float));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'LoggedOn':
					/**
					 * Sets the value for dttLoggedOn (Not Null)
					 * @param QDateTime $mixValue
					 * @return QDateTime
					 */
					try {
						return ($this->dttLoggedOn = QType::Cast($mixValue, QType::DateTime));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'Notes':
					/**
					 * Sets the value for strNotes 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strNotes = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'Year':
					/**
					 * Sets the value for intYear (Not Null)
					 * @param integer $mixValue
					 * @return integer
					 */
					try {
						return ($this->intYear = QType::Cast($mixValue, QType::Integer));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}


				///////////////////
				// Member Objects
				///////////////////
				case 'MemberIdObject':
					/**
					 * Sets the value for the MemberContact object referenced by intMemberId (Not Null)
					 * @param MemberContact $mixValue
					 * @return MemberContact
					 */
					if (is_null($mixValue)) {
						$this->intMemberId = null;
						$this->objMemberIdObject = null;
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
							throw new QCallerException('Unable to set an unsaved MemberIdObject for this MemberMileage');

						// Update Local Member Variables
						$this->objMemberIdObject = $mixValue;
						$this->intMemberId = $mixValue->Id;

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
		 * Protected member variable that maps to the database PK column MemberMileage.Id
		 * @var integer intId
		 */
		protected $intId;
		const IdDefault = null;


		/**
		 * Protected internal member variable that stores the original version of the PK column value (if restored)
		 * Used by Save() to update a PK column during UPDATE
		 * @var integer __intId;
		 */
		protected $__intId;

		/**
		 * Protected member variable that maps to the database column MemberMileage.MemberId
		 * @var integer intMemberId
		 */
		protected $intMemberId;
		const MemberIdDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberMileage.Miles
		 * @var double fltMiles
		 */
		protected $fltMiles;
		const MilesDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberMileage.LoggedOn
		 * @var QDateTime dttLoggedOn
		 */
		protected $dttLoggedOn;
		const LoggedOnDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberMileage.Notes
		 * @var string strNotes
		 */
		protected $strNotes;
		const NotesMaxLength = 500;
		const NotesDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberMileage.Year
		 * @var integer intYear
		 */
		protected $intYear;
		const YearDefault = null;


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
		 * in the database column MemberMileage.MemberId.
		 *
		 * NOTE: Always use the MemberIdObject property getter to correctly retrieve this MemberContact object.
		 * (Because this class implements late binding, this variable reference MAY be null.)
		 * @var MemberContact objMemberIdObject
		 */
		protected $objMemberIdObject;






		////////////////////////////////////////
		// METHODS for WEB SERVICES
		////////////////////////////////////////

		public static function GetSoapComplexTypeXml() {
			$strToReturn = '<complexType name="MemberMileage"><sequence>';
			$strToReturn .= '<element name="Id" type="xsd:int"/>';
			$strToReturn .= '<element name="MemberIdObject" type="xsd1:MemberContact"/>';
			$strToReturn .= '<element name="Miles" type="xsd:float"/>';
			$strToReturn .= '<element name="LoggedOn" type="xsd:dateTime"/>';
			$strToReturn .= '<element name="Notes" type="xsd:string"/>';
			$strToReturn .= '<element name="Year" type="xsd:int"/>';
			$strToReturn .= '<element name="__blnRestored" type="xsd:boolean"/>';
			$strToReturn .= '</sequence></complexType>';
			return $strToReturn;
		}

		public static function AlterSoapComplexTypeArray(&$strComplexTypeArray) {
			if (!array_key_exists('MemberMileage', $strComplexTypeArray)) {
				$strComplexTypeArray['MemberMileage'] = MemberMileage::GetSoapComplexTypeXml();
				MemberContact::AlterSoapComplexTypeArray($strComplexTypeArray);
			}
		}

		public static function GetArrayFromSoapArray($objSoapArray) {
			$objArrayToReturn = array();

			foreach ($objSoapArray as $objSoapObject)
				array_push($objArrayToReturn, MemberMileage::GetObjectFromSoapObject($objSoapObject));

			return $objArrayToReturn;
		}

		public static function GetObjectFromSoapObject($objSoapObject) {
			$objToReturn = new MemberMileage();
			if (property_exists($objSoapObject, 'Id'))
				$objToReturn->intId = $objSoapObject->Id;
			if ((property_exists($objSoapObject, 'MemberIdObject')) &&
				($objSoapObject->MemberIdObject))
				$objToReturn->MemberIdObject = MemberContact::GetObjectFromSoapObject($objSoapObject->MemberIdObject);
			if (property_exists($objSoapObject, 'Miles'))
				$objToReturn->fltMiles = $objSoapObject->Miles;
			if (property_exists($objSoapObject, 'LoggedOn'))
				$objToReturn->dttLoggedOn = new QDateTime($objSoapObject->LoggedOn);
			if (property_exists($objSoapObject, 'Notes'))
				$objToReturn->strNotes = $objSoapObject->Notes;
			if (property_exists($objSoapObject, 'Year'))
				$objToReturn->intYear = $objSoapObject->Year;
			if (property_exists($objSoapObject, '__blnRestored'))
				$objToReturn->__blnRestored = $objSoapObject->__blnRestored;
			return $objToReturn;
		}

		public static function GetSoapArrayFromArray($objArray) {
			if (!$objArray)
				return null;

			$objArrayToReturn = array();

			foreach ($objArray as $objObject)
				array_push($objArrayToReturn, MemberMileage::GetSoapObjectFromObject($objObject, true));

			return unserialize(serialize($objArrayToReturn ?? '') ?? '');
		}

		public static function GetSoapObjectFromObject($objObject, $blnBindRelatedObjects) {
			if ($objObject->objMemberIdObject)
				$objObject->objMemberIdObject = MemberContact::GetSoapObjectFromObject($objObject->objMemberIdObject, false);
			else if (!$blnBindRelatedObjects)
				$objObject->intMemberId = null;
			if ($objObject->dttLoggedOn)
				$objObject->dttLoggedOn = $objObject->dttLoggedOn->toString(QDateTime::FormatSoap);
			return $objObject;
		}
	}





	/////////////////////////////////////
	// ADDITIONAL CLASSES for QCODO QUERY
	/////////////////////////////////////

	class QQNodeMemberMileage extends QQNode {
		protected $strTableName = 'MemberMileage';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'MemberMileage';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'MemberId':
					return new QQNode('MemberId', 'integer', $this);
				case 'MemberIdObject':
					return new QQNodeMemberContact('MemberId', 'integer', $this);
				case 'Miles':
					return new QQNode('Miles', 'double', $this);
				case 'LoggedOn':
					return new QQNode('LoggedOn', 'QDateTime', $this);
				case 'Notes':
					return new QQNode('Notes', 'string', $this);
				case 'Year':
					return new QQNode('Year', 'integer', $this);

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

	class QQReverseReferenceNodeMemberMileage extends QQReverseReferenceNode {
		protected $strTableName = 'MemberMileage';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'MemberMileage';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'MemberId':
					return new QQNode('MemberId', 'integer', $this);
				case 'MemberIdObject':
					return new QQNodeMemberContact('MemberId', 'integer', $this);
				case 'Miles':
					return new QQNode('Miles', 'double', $this);
				case 'LoggedOn':
					return new QQNode('LoggedOn', 'QDateTime', $this);
				case 'Notes':
					return new QQNode('Notes', 'string', $this);
				case 'Year':
					return new QQNode('Year', 'integer', $this);

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