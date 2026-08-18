<?php
	/**
	 * The abstract FamilyMemberAssocGen class defined here is
	 * code-generated and contains all the basic CRUD-type functionality as well as
	 * basic methods to handle relationships and index-based loading.
	 *
	 * To use, you should use the FamilyMemberAssoc subclass which
	 * extends this FamilyMemberAssocGen class.
	 *
	 * Because subsequent re-code generations will overwrite any changes to this
	 * file, you should leave this file unaltered to prevent yourself from losing
	 * any information or code changes.  All customizations should be done by
	 * overriding existing or implementing new methods, properties and variables
	 * in the FamilyMemberAssoc class.
	 * 
	 * @package My Application
	 * @subpackage GeneratedDataObjects
	 * 
	 */
	class FamilyMemberAssocGen extends QBaseClass {
		///////////////////////////////
		// COMMON LOAD METHODS
		///////////////////////////////

		/**
		 * Load a FamilyMemberAssoc from PK Info
		 * @param integer $intId
		 * @return FamilyMemberAssoc
		 */
		public static function Load($intId) {
			// Use QuerySingle to Perform the Query
			return FamilyMemberAssoc::QuerySingle(
				QQ::Equal(QQN::FamilyMemberAssoc()->Id, $intId)
			);
		}

		/**
		 * Load all FamilyMemberAssocs
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return FamilyMemberAssoc[]
		 */
		public static function LoadAll($objOptionalClauses = null) {
			// Call FamilyMemberAssoc::QueryArray to perform the LoadAll query
			try {
				return FamilyMemberAssoc::QueryArray(QQ::All(), $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count all FamilyMemberAssocs
		 * @return int
		 */
		public static function CountAll() {
			// Call FamilyMemberAssoc::QueryCount to perform the CountAll query
			return FamilyMemberAssoc::QueryCount(QQ::All());
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
			$objDatabase = FamilyMemberAssoc::GetDatabase();

			// Create/Build out the QueryBuilder object with FamilyMemberAssoc-specific SELET and FROM fields
			$objQueryBuilder = new QQueryBuilder($objDatabase, 'FamilyMemberAssoc');
			FamilyMemberAssoc::GetSelectFields($objQueryBuilder,null,$selectionArray);
			$objQueryBuilder->AddFromItem('`FamilyMemberAssoc` AS `FamilyMemberAssoc`');

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
		 * Static Qcodo Query method to query for a single FamilyMemberAssoc object.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return FamilyMemberAssoc the queried object
		 */
		public static function QuerySingle(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = FamilyMemberAssoc::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query, Get the First Row, and Instantiate a new FamilyMemberAssoc object
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return FamilyMemberAssoc::InstantiateDbRow($objDbResult->GetNextRow());
		}

		/**
		 * Static Qcodo Query method to query for an array of FamilyMemberAssoc objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return FamilyMemberAssoc[] the queried objects as an array
		 */
		public static function QueryArray(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = FamilyMemberAssoc::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query and Instantiate the Array Result
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return FamilyMemberAssoc::InstantiateDbResult($objDbResult, $objQueryBuilder->ExpandAsArrayNodes);
		}

		/**
		 * Static Qcodo Query method to query for a count of FamilyMemberAssoc objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return integer the count of queried objects as an integer
		 */
		public static function QueryCount(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = FamilyMemberAssoc::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, true,$selectionArray);
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
			$objDatabase = FamilyMemberAssoc::GetDatabase();

			// Lookup the QCache for This Query Statement
			$objCache = new QCache('query', 'FamilyMemberAssoc_' . serialize($strConditions));
			if (!($strQuery = $objCache->GetData())) {
				// Not Found -- Go ahead and Create/Build out a new QueryBuilder object with FamilyMemberAssoc-specific fields
				$objQueryBuilder = new QQueryBuilder($objDatabase);
				FamilyMemberAssoc::GetSelectFields($objQueryBuilder);
				FamilyMemberAssoc::GetFromFields($objQueryBuilder);

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
			return FamilyMemberAssoc::InstantiateDbResult($objDbResult);
		}*/

		/**
		 * Updates a QQueryBuilder with the SELECT fields for this FamilyMemberAssoc
		 * @param QQueryBuilder $objBuilder the Query Builder object to update
		 * @param string $strPrefix optional prefix to add to the SELECT fields
		 * @param array $selectionArray optional array of SELECT field items (wpg - added Sept 2012)
		 */
		public static function GetSelectFields(QQueryBuilder $objBuilder, $strPrefix = null, $selectionArray = null) {
			if ($strPrefix) {
				$strTableName = '`' . $strPrefix . '`';
				$strAliasPrefix = '`' . $strPrefix . '__';
			} else {
				$strTableName = '`FamilyMemberAssoc`';
				$strAliasPrefix = '`';
			}

			// wpg - if we are not passing in an array of participant fields we want then get them all
			if (!$selectionArray){
				$objBuilder->AddSelectItem($strTableName . '.`Id` AS ' . $strAliasPrefix . 'Id`');
				$objBuilder->AddSelectItem($strTableName . '.`MembershipLogId` AS ' . $strAliasPrefix . 'MembershipLogId`');
				$objBuilder->AddSelectItem($strTableName . '.`PrimaryMember` AS ' . $strAliasPrefix . 'PrimaryMember`');
				$objBuilder->AddSelectItem($strTableName . '.`FamilyMemberId` AS ' . $strAliasPrefix . 'FamilyMemberId`');
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
		 * Instantiate a FamilyMemberAssoc from a Database Row.
		 * Takes in an optional strAliasPrefix, used in case another Object::InstantiateDbRow
		 * is calling this FamilyMemberAssoc::InstantiateDbRow in order to perform
		 * early binding on referenced objects.
		 * @param DatabaseRowBase $objDbRow
		 * @param string $strAliasPrefix
		 * @return FamilyMemberAssoc
		*/
		public static function InstantiateDbRow($objDbRow, $strAliasPrefix = null, $strExpandAsArrayNodes = null, $objPreviousItem = null) {
			// If blank row, return null
			if (!$objDbRow)
				return null;


			// Create a new instance of the FamilyMemberAssoc object
			$objToReturn = new FamilyMemberAssoc();
			$objToReturn->__blnRestored = true;

			$objToReturn->intId = $objDbRow->GetColumn($strAliasPrefix . 'Id', 'Integer');
			$objToReturn->intMembershipLogId = $objDbRow->GetColumn($strAliasPrefix . 'MembershipLogId', 'Integer');
			$objToReturn->blnPrimaryMember = $objDbRow->GetColumn($strAliasPrefix . 'PrimaryMember', 'Bit');
			$objToReturn->intFamilyMemberId = $objDbRow->GetColumn($strAliasPrefix . 'FamilyMemberId', 'Integer');

			// Instantiate Virtual Attributes
			foreach ($objDbRow->GetColumnNameArray() as $strColumnName => $mixValue) {
				$strVirtualPrefix = $strAliasPrefix . '__';
				$strVirtualPrefixLength = strlen($strVirtualPrefix ?? '');
				if (substr($strColumnName, 0, $strVirtualPrefixLength) == $strVirtualPrefix)
					$objToReturn->__strVirtualAttributeArray[substr($strColumnName, $strVirtualPrefixLength)] = $mixValue;
			}

			// Prepare to Check for Early/Virtual Binding
			if (!$strAliasPrefix)
				$strAliasPrefix = 'FamilyMemberAssoc__';

			// Check for MembershipLogIdObject Early Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'MembershipLogId__Id')))
				$objToReturn->objMembershipLogIdObject = MembershipLog::InstantiateDbRow($objDbRow, $strAliasPrefix . 'MembershipLogId__', $strExpandAsArrayNodes);

			// Check for FamilyMemberIdObject Early Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'FamilyMemberId__Id')))
				$objToReturn->objFamilyMemberIdObject = MemberContact::InstantiateDbRow($objDbRow, $strAliasPrefix . 'FamilyMemberId__', $strExpandAsArrayNodes);




			return $objToReturn;
		}

		/**
		 * Instantiate an array of FamilyMemberAssocs from a Database Result
		 * @param DatabaseResultBase $objDbResult
		 * @return FamilyMemberAssoc[]
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
					$objItem = FamilyMemberAssoc::InstantiateDbRow($objDbRow, null, $strExpandAsArrayNodes, $objLastRowItem);
					if ($objItem) {
						array_push($objToReturn, $objItem);
						$objLastRowItem = $objItem;
					}
				}
			} else {
				while ($objDbRow = $objDbResult->GetNextRow())
					array_push($objToReturn, FamilyMemberAssoc::InstantiateDbRow($objDbRow));
			}

			return $objToReturn;
		}



		///////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Single Load and Array)
		///////////////////////////////////////////////////
			
		/**
		 * Load a single FamilyMemberAssoc object,
		 * by Id Index(es)
		 * @param integer $intId
		 * @return FamilyMemberAssoc
		*/
		public static function LoadById($intId) {
			return FamilyMemberAssoc::QuerySingle(
				QQ::Equal(QQN::FamilyMemberAssoc()->Id, $intId)
			);
		}
			
		/**
		 * Load an array of FamilyMemberAssoc objects,
		 * by MembershipLogId Index(es)
		 * @param integer $intMembershipLogId
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return FamilyMemberAssoc[]
		*/
		public static function LoadArrayByMembershipLogId($intMembershipLogId, $objOptionalClauses = null) {
			// Call FamilyMemberAssoc::QueryArray to perform the LoadArrayByMembershipLogId query
			try {
				return FamilyMemberAssoc::QueryArray(
					QQ::Equal(QQN::FamilyMemberAssoc()->MembershipLogId, $intMembershipLogId),
					$objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count FamilyMemberAssocs
		 * by MembershipLogId Index(es)
		 * @param integer $intMembershipLogId
		 * @return int
		*/
		public static function CountByMembershipLogId($intMembershipLogId) {
			// Call FamilyMemberAssoc::QueryCount to perform the CountByMembershipLogId query
			return FamilyMemberAssoc::QueryCount(
				QQ::Equal(QQN::FamilyMemberAssoc()->MembershipLogId, $intMembershipLogId)
			);
		}
			
		/**
		 * Load an array of FamilyMemberAssoc objects,
		 * by PrimaryMember Index(es)
		 * @param boolean $blnPrimaryMember
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return FamilyMemberAssoc[]
		*/
		public static function LoadArrayByPrimaryMember($blnPrimaryMember, $objOptionalClauses = null) {
			// Call FamilyMemberAssoc::QueryArray to perform the LoadArrayByPrimaryMember query
			try {
				return FamilyMemberAssoc::QueryArray(
					QQ::Equal(QQN::FamilyMemberAssoc()->PrimaryMember, $blnPrimaryMember),
					$objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count FamilyMemberAssocs
		 * by PrimaryMember Index(es)
		 * @param boolean $blnPrimaryMember
		 * @return int
		*/
		public static function CountByPrimaryMember($blnPrimaryMember) {
			// Call FamilyMemberAssoc::QueryCount to perform the CountByPrimaryMember query
			return FamilyMemberAssoc::QueryCount(
				QQ::Equal(QQN::FamilyMemberAssoc()->PrimaryMember, $blnPrimaryMember)
			);
		}
			
		/**
		 * Load an array of FamilyMemberAssoc objects,
		 * by FamilyMemberId Index(es)
		 * @param integer $intFamilyMemberId
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return FamilyMemberAssoc[]
		*/
		public static function LoadArrayByFamilyMemberId($intFamilyMemberId, $objOptionalClauses = null) {
			// Call FamilyMemberAssoc::QueryArray to perform the LoadArrayByFamilyMemberId query
			try {
				return FamilyMemberAssoc::QueryArray(
					QQ::Equal(QQN::FamilyMemberAssoc()->FamilyMemberId, $intFamilyMemberId),
					$objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count FamilyMemberAssocs
		 * by FamilyMemberId Index(es)
		 * @param integer $intFamilyMemberId
		 * @return int
		*/
		public static function CountByFamilyMemberId($intFamilyMemberId) {
			// Call FamilyMemberAssoc::QueryCount to perform the CountByFamilyMemberId query
			return FamilyMemberAssoc::QueryCount(
				QQ::Equal(QQN::FamilyMemberAssoc()->FamilyMemberId, $intFamilyMemberId)
			);
		}



		////////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Array via Many to Many)
		////////////////////////////////////////////////////



		//////////////////
		// SAVE AND DELETE
		//////////////////

		/**
		 * Save this FamilyMemberAssoc
		 * @param bool $blnForceInsert
		 * @param bool $blnForceUpdate
		 * @return int
		*/
		public function Save($blnForceInsert = false, $blnForceUpdate = false) {
			// Get the Database Object for this Class
			$objDatabase = FamilyMemberAssoc::GetDatabase();

			$mixToReturn = null;

			try {
				if ((!$this->__blnRestored) || ($blnForceInsert)) {
					// Perform an INSERT query
					$objDatabase->NonQuery('
						INSERT INTO `FamilyMemberAssoc` (
							`MembershipLogId`,
							`PrimaryMember`,
							`FamilyMemberId`
						) VALUES (
							' . $objDatabase->SqlVariable($this->intMembershipLogId) . ',
							' . $objDatabase->SqlVariable($this->blnPrimaryMember) . ',
							' . $objDatabase->SqlVariable($this->intFamilyMemberId) . '
						)
					');

					// Update Identity column and return its value
					$mixToReturn = $this->intId = $objDatabase->InsertId('FamilyMemberAssoc', 'Id');
				} else {
					// Perform an UPDATE query

					// First checking for Optimistic Locking constraints (if applicable)

					// Perform the UPDATE query
					$objDatabase->NonQuery('
						UPDATE
							`FamilyMemberAssoc`
						SET
							`MembershipLogId` = ' . $objDatabase->SqlVariable($this->intMembershipLogId) . ',
							`PrimaryMember` = ' . $objDatabase->SqlVariable($this->blnPrimaryMember) . ',
							`FamilyMemberId` = ' . $objDatabase->SqlVariable($this->intFamilyMemberId) . '
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
		 * Delete this FamilyMemberAssoc
		 * @return void
		*/
		public function Delete() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Cannot delete this FamilyMemberAssoc with an unset primary key.');

			// Get the Database Object for this Class
			$objDatabase = FamilyMemberAssoc::GetDatabase();


			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`FamilyMemberAssoc`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($this->intId) . '');
		}

		/**
		 * Delete all FamilyMemberAssocs
		 * @return void
		*/
		public static function DeleteAll() {
			// Get the Database Object for this Class
			$objDatabase = FamilyMemberAssoc::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				DELETE FROM
					`FamilyMemberAssoc`');
		}

		/**
		 * Truncate FamilyMemberAssoc table
		 * @return void
		*/
		public static function Truncate() {
			// Get the Database Object for this Class
			$objDatabase = FamilyMemberAssoc::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				TRUNCATE `FamilyMemberAssoc`');
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

				case 'MembershipLogId':
					/**
					 * Gets the value for intMembershipLogId (Not Null)
					 * @return integer
					 */
					return $this->intMembershipLogId;

				case 'PrimaryMember':
					/**
					 * Gets the value for blnPrimaryMember 
					 * @return boolean
					 */
					return $this->blnPrimaryMember;

				case 'FamilyMemberId':
					/**
					 * Gets the value for intFamilyMemberId 
					 * @return integer
					 */
					return $this->intFamilyMemberId;


				///////////////////
				// Member Objects
				///////////////////
				case 'MembershipLogIdObject':
					/**
					 * Gets the value for the MembershipLog object referenced by intMembershipLogId (Not Null)
					 * @return MembershipLog
					 */
					try {
						if ((!$this->objMembershipLogIdObject) && (!is_null($this->intMembershipLogId)))
							$this->objMembershipLogIdObject = MembershipLog::Load($this->intMembershipLogId);
						return $this->objMembershipLogIdObject;
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'FamilyMemberIdObject':
					/**
					 * Gets the value for the MemberContact object referenced by intFamilyMemberId 
					 * @return MemberContact
					 */
					try {
						if ((!$this->objFamilyMemberIdObject) && (!is_null($this->intFamilyMemberId)))
							$this->objFamilyMemberIdObject = MemberContact::Load($this->intFamilyMemberId);
						return $this->objFamilyMemberIdObject;
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
				case 'MembershipLogId':
					/**
					 * Sets the value for intMembershipLogId (Not Null)
					 * @param integer $mixValue
					 * @return integer
					 */
					try {
						$this->objMembershipLogIdObject = null;
						return ($this->intMembershipLogId = QType::Cast($mixValue, QType::Integer));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'PrimaryMember':
					/**
					 * Sets the value for blnPrimaryMember 
					 * @param boolean $mixValue
					 * @return boolean
					 */
					try {
						return ($this->blnPrimaryMember = QType::Cast($mixValue, QType::Boolean));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'FamilyMemberId':
					/**
					 * Sets the value for intFamilyMemberId 
					 * @param integer $mixValue
					 * @return integer
					 */
					try {
						$this->objFamilyMemberIdObject = null;
						return ($this->intFamilyMemberId = QType::Cast($mixValue, QType::Integer));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}


				///////////////////
				// Member Objects
				///////////////////
				case 'MembershipLogIdObject':
					/**
					 * Sets the value for the MembershipLog object referenced by intMembershipLogId (Not Null)
					 * @param MembershipLog $mixValue
					 * @return MembershipLog
					 */
					if (is_null($mixValue)) {
						$this->intMembershipLogId = null;
						$this->objMembershipLogIdObject = null;
						return null;
					} else {
						// Make sure $mixValue actually is a MembershipLog object
						try {
							$mixValue = QType::Cast($mixValue, 'MembershipLog');
						} catch (QInvalidCastException $objExc) {
							$objExc->IncrementOffset();
							throw $objExc;
						} 

						// Make sure $mixValue is a SAVED MembershipLog object
						if (is_null($mixValue->Id))
							throw new QCallerException('Unable to set an unsaved MembershipLogIdObject for this FamilyMemberAssoc');

						// Update Local Member Variables
						$this->objMembershipLogIdObject = $mixValue;
						$this->intMembershipLogId = $mixValue->Id;

						// Return $mixValue
						return $mixValue;
					}
					break;

				case 'FamilyMemberIdObject':
					/**
					 * Sets the value for the MemberContact object referenced by intFamilyMemberId 
					 * @param MemberContact $mixValue
					 * @return MemberContact
					 */
					if (is_null($mixValue)) {
						$this->intFamilyMemberId = null;
						$this->objFamilyMemberIdObject = null;
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
							throw new QCallerException('Unable to set an unsaved FamilyMemberIdObject for this FamilyMemberAssoc');

						// Update Local Member Variables
						$this->objFamilyMemberIdObject = $mixValue;
						$this->intFamilyMemberId = $mixValue->Id;

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
		 * Protected member variable that maps to the database PK Identity column FamilyMemberAssoc.Id
		 * @var integer intId
		 */
		protected $intId;
		const IdDefault = null;


		/**
		 * Protected member variable that maps to the database column FamilyMemberAssoc.MembershipLogId
		 * @var integer intMembershipLogId
		 */
		protected $intMembershipLogId;
		const MembershipLogIdDefault = null;


		/**
		 * Protected member variable that maps to the database column FamilyMemberAssoc.PrimaryMember
		 * @var boolean blnPrimaryMember
		 */
		protected $blnPrimaryMember;
		const PrimaryMemberDefault = null;


		/**
		 * Protected member variable that maps to the database column FamilyMemberAssoc.FamilyMemberId
		 * @var integer intFamilyMemberId
		 */
		protected $intFamilyMemberId;
		const FamilyMemberIdDefault = null;


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
		 * in the database column FamilyMemberAssoc.MembershipLogId.
		 *
		 * NOTE: Always use the MembershipLogIdObject property getter to correctly retrieve this MembershipLog object.
		 * (Because this class implements late binding, this variable reference MAY be null.)
		 * @var MembershipLog objMembershipLogIdObject
		 */
		protected $objMembershipLogIdObject;

		/**
		 * Protected member variable that contains the object pointed by the reference
		 * in the database column FamilyMemberAssoc.FamilyMemberId.
		 *
		 * NOTE: Always use the FamilyMemberIdObject property getter to correctly retrieve this MemberContact object.
		 * (Because this class implements late binding, this variable reference MAY be null.)
		 * @var MemberContact objFamilyMemberIdObject
		 */
		protected $objFamilyMemberIdObject;






		////////////////////////////////////////
		// METHODS for WEB SERVICES
		////////////////////////////////////////

		public static function GetSoapComplexTypeXml() {
			$strToReturn = '<complexType name="FamilyMemberAssoc"><sequence>';
			$strToReturn .= '<element name="Id" type="xsd:int"/>';
			$strToReturn .= '<element name="MembershipLogIdObject" type="xsd1:MembershipLog"/>';
			$strToReturn .= '<element name="PrimaryMember" type="xsd:boolean"/>';
			$strToReturn .= '<element name="FamilyMemberIdObject" type="xsd1:MemberContact"/>';
			$strToReturn .= '<element name="__blnRestored" type="xsd:boolean"/>';
			$strToReturn .= '</sequence></complexType>';
			return $strToReturn;
		}

		public static function AlterSoapComplexTypeArray(&$strComplexTypeArray) {
			if (!array_key_exists('FamilyMemberAssoc', $strComplexTypeArray)) {
				$strComplexTypeArray['FamilyMemberAssoc'] = FamilyMemberAssoc::GetSoapComplexTypeXml();
				MembershipLog::AlterSoapComplexTypeArray($strComplexTypeArray);
				MemberContact::AlterSoapComplexTypeArray($strComplexTypeArray);
			}
		}

		public static function GetArrayFromSoapArray($objSoapArray) {
			$objArrayToReturn = array();

			foreach ($objSoapArray as $objSoapObject)
				array_push($objArrayToReturn, FamilyMemberAssoc::GetObjectFromSoapObject($objSoapObject));

			return $objArrayToReturn;
		}

		public static function GetObjectFromSoapObject($objSoapObject) {
			$objToReturn = new FamilyMemberAssoc();
			if (property_exists($objSoapObject, 'Id'))
				$objToReturn->intId = $objSoapObject->Id;
			if ((property_exists($objSoapObject, 'MembershipLogIdObject')) &&
				($objSoapObject->MembershipLogIdObject))
				$objToReturn->MembershipLogIdObject = MembershipLog::GetObjectFromSoapObject($objSoapObject->MembershipLogIdObject);
			if (property_exists($objSoapObject, 'PrimaryMember'))
				$objToReturn->blnPrimaryMember = $objSoapObject->PrimaryMember;
			if ((property_exists($objSoapObject, 'FamilyMemberIdObject')) &&
				($objSoapObject->FamilyMemberIdObject))
				$objToReturn->FamilyMemberIdObject = MemberContact::GetObjectFromSoapObject($objSoapObject->FamilyMemberIdObject);
			if (property_exists($objSoapObject, '__blnRestored'))
				$objToReturn->__blnRestored = $objSoapObject->__blnRestored;
			return $objToReturn;
		}

		public static function GetSoapArrayFromArray($objArray) {
			if (!$objArray)
				return null;

			$objArrayToReturn = array();

			foreach ($objArray as $objObject)
				array_push($objArrayToReturn, FamilyMemberAssoc::GetSoapObjectFromObject($objObject, true));

			return unserialize(serialize($objArrayToReturn) ?? '');
		}

		public static function GetSoapObjectFromObject($objObject, $blnBindRelatedObjects) {
			if ($objObject->objMembershipLogIdObject)
				$objObject->objMembershipLogIdObject = MembershipLog::GetSoapObjectFromObject($objObject->objMembershipLogIdObject, false);
			else if (!$blnBindRelatedObjects)
				$objObject->intMembershipLogId = null;
			if ($objObject->objFamilyMemberIdObject)
				$objObject->objFamilyMemberIdObject = MemberContact::GetSoapObjectFromObject($objObject->objFamilyMemberIdObject, false);
			else if (!$blnBindRelatedObjects)
				$objObject->intFamilyMemberId = null;
			return $objObject;
		}
	}





	/////////////////////////////////////
	// ADDITIONAL CLASSES for QCODO QUERY
	/////////////////////////////////////

	class QQNodeFamilyMemberAssoc extends QQNode {
		protected $strTableName = 'FamilyMemberAssoc';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'FamilyMemberAssoc';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'MembershipLogId':
					return new QQNode('MembershipLogId', 'integer', $this);
				case 'MembershipLogIdObject':
					return new QQNodeMembershipLog('MembershipLogId', 'integer', $this);
				case 'PrimaryMember':
					return new QQNode('PrimaryMember', 'boolean', $this);
				case 'FamilyMemberId':
					return new QQNode('FamilyMemberId', 'integer', $this);
				case 'FamilyMemberIdObject':
					return new QQNodeMemberContact('FamilyMemberId', 'integer', $this);

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

	class QQReverseReferenceNodeFamilyMemberAssoc extends QQReverseReferenceNode {
		protected $strTableName = 'FamilyMemberAssoc';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'FamilyMemberAssoc';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'MembershipLogId':
					return new QQNode('MembershipLogId', 'integer', $this);
				case 'MembershipLogIdObject':
					return new QQNodeMembershipLog('MembershipLogId', 'integer', $this);
				case 'PrimaryMember':
					return new QQNode('PrimaryMember', 'boolean', $this);
				case 'FamilyMemberId':
					return new QQNode('FamilyMemberId', 'integer', $this);
				case 'FamilyMemberIdObject':
					return new QQNodeMemberContact('FamilyMemberId', 'integer', $this);

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