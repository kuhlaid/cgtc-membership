<?php
	/**
	 * The abstract PartnerBusinessGen class defined here is
	 * code-generated and contains all the basic CRUD-type functionality as well as
	 * basic methods to handle relationships and index-based loading.
	 *
	 * To use, you should use the PartnerBusiness subclass which
	 * extends this PartnerBusinessGen class.
	 *
	 * Because subsequent re-code generations will overwrite any changes to this
	 * file, you should leave this file unaltered to prevent yourself from losing
	 * any information or code changes.  All customizations should be done by
	 * overriding existing or implementing new methods, properties and variables
	 * in the PartnerBusiness class.
	 * 
	 * @package My Application
	 * @subpackage GeneratedDataObjects
	 * 
	 */
	class PartnerBusinessGen extends QBaseClass {
		///////////////////////////////
		// COMMON LOAD METHODS
		///////////////////////////////

		/**
		 * Load a PartnerBusiness from PK Info
		 * @param integer $intId
		 * @return PartnerBusiness
		 */
		public static function Load($intId) {
			// Use QuerySingle to Perform the Query
			return PartnerBusiness::QuerySingle(
				QQ::Equal(QQN::PartnerBusiness()->Id, $intId)
			);
		}

		/**
		 * Load all PartnerBusinesses
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return PartnerBusiness[]
		 */
		public static function LoadAll($objOptionalClauses = null) {
			// Call PartnerBusiness::QueryArray to perform the LoadAll query
			try {
				return PartnerBusiness::QueryArray(QQ::All(), $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count all PartnerBusinesses
		 * @return int
		 */
		public static function CountAll() {
			// Call PartnerBusiness::QueryCount to perform the CountAll query
			return PartnerBusiness::QueryCount(QQ::All());
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
			$objDatabase = PartnerBusiness::GetDatabase();

			// Create/Build out the QueryBuilder object with PartnerBusiness-specific SELET and FROM fields
			$objQueryBuilder = new QQueryBuilder($objDatabase, 'PartnerBusiness');
			PartnerBusiness::GetSelectFields($objQueryBuilder,null,$selectionArray);
			$objQueryBuilder->AddFromItem('`PartnerBusiness` AS `PartnerBusiness`');

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
		 * Static Qcodo Query method to query for a single PartnerBusiness object.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return PartnerBusiness the queried object
		 */
		public static function QuerySingle(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = PartnerBusiness::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query, Get the First Row, and Instantiate a new PartnerBusiness object
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return PartnerBusiness::InstantiateDbRow($objDbResult->GetNextRow());
		}

		/**
		 * Static Qcodo Query method to query for an array of PartnerBusiness objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return PartnerBusiness[] the queried objects as an array
		 */
		public static function QueryArray(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = PartnerBusiness::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query and Instantiate the Array Result
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return PartnerBusiness::InstantiateDbResult($objDbResult, $objQueryBuilder->ExpandAsArrayNodes);
		}

		/**
		 * Static Qcodo Query method to query for a count of PartnerBusiness objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return integer the count of queried objects as an integer
		 */
		public static function QueryCount(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = PartnerBusiness::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, true,$selectionArray);
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
			$objDatabase = PartnerBusiness::GetDatabase();

			// Lookup the QCache for This Query Statement
			$objCache = new QCache('query', 'PartnerBusiness_' . serialize($strConditions));
			if (!($strQuery = $objCache->GetData())) {
				// Not Found -- Go ahead and Create/Build out a new QueryBuilder object with PartnerBusiness-specific fields
				$objQueryBuilder = new QQueryBuilder($objDatabase);
				PartnerBusiness::GetSelectFields($objQueryBuilder);
				PartnerBusiness::GetFromFields($objQueryBuilder);

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
			return PartnerBusiness::InstantiateDbResult($objDbResult);
		}*/

		/**
		 * Updates a QQueryBuilder with the SELECT fields for this PartnerBusiness
		 * @param QQueryBuilder $objBuilder the Query Builder object to update
		 * @param string $strPrefix optional prefix to add to the SELECT fields
		 * @param array $selectionArray optional array of SELECT field items (wpg - added Sept 2012)
		 */
		public static function GetSelectFields(QQueryBuilder $objBuilder, $strPrefix = null, $selectionArray = null) {
			if ($strPrefix) {
				$strTableName = '`' . $strPrefix . '`';
				$strAliasPrefix = '`' . $strPrefix . '__';
			} else {
				$strTableName = '`PartnerBusiness`';
				$strAliasPrefix = '`';
			}

			// wpg - if we are not passing in an array of participant fields we want then get them all
			if (!$selectionArray){
				$objBuilder->AddSelectItem($strTableName . '.`Id` AS ' . $strAliasPrefix . 'Id`');
				$objBuilder->AddSelectItem($strTableName . '.`Active` AS ' . $strAliasPrefix . 'Active`');
				$objBuilder->AddSelectItem($strTableName . '.`VerifiedDiscountDate` AS ' . $strAliasPrefix . 'VerifiedDiscountDate`');
				$objBuilder->AddSelectItem($strTableName . '.`Name` AS ' . $strAliasPrefix . 'Name`');
				$objBuilder->AddSelectItem($strTableName . '.`Discount` AS ' . $strAliasPrefix . 'Discount`');
				$objBuilder->AddSelectItem($strTableName . '.`Phone` AS ' . $strAliasPrefix . 'Phone`');
				$objBuilder->AddSelectItem($strTableName . '.`Address` AS ' . $strAliasPrefix . 'Address`');
				$objBuilder->AddSelectItem($strTableName . '.`Hours` AS ' . $strAliasPrefix . 'Hours`');
				$objBuilder->AddSelectItem($strTableName . '.`Website` AS ' . $strAliasPrefix . 'Website`');
				$objBuilder->AddSelectItem($strTableName . '.`UpdateResponse` AS ' . $strAliasPrefix . 'UpdateResponse`');
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
		 * Instantiate a PartnerBusiness from a Database Row.
		 * Takes in an optional strAliasPrefix, used in case another Object::InstantiateDbRow
		 * is calling this PartnerBusiness::InstantiateDbRow in order to perform
		 * early binding on referenced objects.
		 * @param DatabaseRowBase $objDbRow
		 * @param string $strAliasPrefix
		 * @return PartnerBusiness
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
					$strAliasPrefix = 'PartnerBusiness__';


				if ((array_key_exists($strAliasPrefix . 'businessmemberassocasid__Id', $strExpandAsArrayNodes)) &&
					(!is_null($objDbRow->GetColumn($strAliasPrefix . 'businessmemberassocasid__Id')))) {
					if ($intPreviousChildItemCount = count($objPreviousItem->_objBusinessMemberAssocAsIdArray)) {
						$objPreviousChildItem = $objPreviousItem->_objBusinessMemberAssocAsIdArray[$intPreviousChildItemCount - 1];
						$objChildItem = BusinessMemberAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'businessmemberassocasid__', $strExpandAsArrayNodes, $objPreviousChildItem);
						if ($objChildItem)
							array_push($objPreviousItem->_objBusinessMemberAssocAsIdArray, $objChildItem);
					} else
						array_push($objPreviousItem->_objBusinessMemberAssocAsIdArray, BusinessMemberAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'businessmemberassocasid__', $strExpandAsArrayNodes));
					$blnExpandedViaArray = true;
				}

				// Either return false to signal array expansion, or check-to-reset the Alias prefix and move on
				if ($blnExpandedViaArray)
					return false;
				else if ($strAliasPrefix == 'PartnerBusiness__')
					$strAliasPrefix = null;
			}

			// Create a new instance of the PartnerBusiness object
			$objToReturn = new PartnerBusiness();
			$objToReturn->__blnRestored = true;

			$objToReturn->intId = $objDbRow->GetColumn($strAliasPrefix . 'Id', 'Integer');
			$objToReturn->blnActive = $objDbRow->GetColumn($strAliasPrefix . 'Active', 'Bit');
			$objToReturn->dttVerifiedDiscountDate = $objDbRow->GetColumn($strAliasPrefix . 'VerifiedDiscountDate', 'Date');
			$objToReturn->strName = $objDbRow->GetColumn($strAliasPrefix . 'Name', 'VarChar');
			$objToReturn->strDiscount = $objDbRow->GetColumn($strAliasPrefix . 'Discount', 'VarChar');
			$objToReturn->strPhone = $objDbRow->GetColumn($strAliasPrefix . 'Phone', 'VarChar');
			$objToReturn->strAddress = $objDbRow->GetColumn($strAliasPrefix . 'Address', 'VarChar');
			$objToReturn->strHours = $objDbRow->GetColumn($strAliasPrefix . 'Hours', 'VarChar');
			$objToReturn->strWebsite = $objDbRow->GetColumn($strAliasPrefix . 'Website', 'VarChar');
			$objToReturn->strUpdateResponse = $objDbRow->GetColumn($strAliasPrefix . 'UpdateResponse', 'VarChar');

			// Instantiate Virtual Attributes
			foreach ($objDbRow->GetColumnNameArray() as $strColumnName => $mixValue) {
				$strVirtualPrefix = $strAliasPrefix . '__';
				$strVirtualPrefixLength = strlen($strVirtualPrefix ?? '');
				if (substr($strColumnName, 0, $strVirtualPrefixLength) == $strVirtualPrefix)
					$objToReturn->__strVirtualAttributeArray[substr($strColumnName, $strVirtualPrefixLength)] = $mixValue;
			}

			// Prepare to Check for Early/Virtual Binding
			if (!$strAliasPrefix)
				$strAliasPrefix = 'PartnerBusiness__';




			// Check for BusinessMemberAssocAsId Virtual Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'businessmemberassocasid__Id'))) {
				if (($strExpandAsArrayNodes) && (array_key_exists($strAliasPrefix . 'businessmemberassocasid__Id', $strExpandAsArrayNodes)))
					array_push($objToReturn->_objBusinessMemberAssocAsIdArray, BusinessMemberAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'businessmemberassocasid__', $strExpandAsArrayNodes));
				else
					$objToReturn->_objBusinessMemberAssocAsId = BusinessMemberAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'businessmemberassocasid__', $strExpandAsArrayNodes);
			}

			return $objToReturn;
		}

		/**
		 * Instantiate an array of PartnerBusinesses from a Database Result
		 * @param DatabaseResultBase $objDbResult
		 * @return PartnerBusiness[]
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
					$objItem = PartnerBusiness::InstantiateDbRow($objDbRow, null, $strExpandAsArrayNodes, $objLastRowItem);
					if ($objItem) {
						array_push($objToReturn, $objItem);
						$objLastRowItem = $objItem;
					}
				}
			} else {
				while ($objDbRow = $objDbResult->GetNextRow())
					array_push($objToReturn, PartnerBusiness::InstantiateDbRow($objDbRow));
			}

			return $objToReturn;
		}



		///////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Single Load and Array)
		///////////////////////////////////////////////////
			
		/**
		 * Load a single PartnerBusiness object,
		 * by Id Index(es)
		 * @param integer $intId
		 * @return PartnerBusiness
		*/
		public static function LoadById($intId) {
			return PartnerBusiness::QuerySingle(
				QQ::Equal(QQN::PartnerBusiness()->Id, $intId)
			);
		}



		////////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Array via Many to Many)
		////////////////////////////////////////////////////



		//////////////////
		// SAVE AND DELETE
		//////////////////

		/**
		 * Save this PartnerBusiness
		 * @param bool $blnForceInsert
		 * @param bool $blnForceUpdate
		 * @return int
		*/
		public function Save($blnForceInsert = false, $blnForceUpdate = false) {
			// Get the Database Object for this Class
			$objDatabase = PartnerBusiness::GetDatabase();

			$mixToReturn = null;

			try {
				if ((!$this->__blnRestored) || ($blnForceInsert)) {
					// Perform an INSERT query
					$objDatabase->NonQuery('
						INSERT INTO `PartnerBusiness` (
							`Active`,
							`VerifiedDiscountDate`,
							`Name`,
							`Discount`,
							`Phone`,
							`Address`,
							`Hours`,
							`Website`,
							`UpdateResponse`
						) VALUES (
							' . $objDatabase->SqlVariable($this->blnActive) . ',
							' . $objDatabase->SqlVariable($this->dttVerifiedDiscountDate) . ',
							' . $objDatabase->SqlVariable($this->strName) . ',
							' . $objDatabase->SqlVariable($this->strDiscount) . ',
							' . $objDatabase->SqlVariable($this->strPhone) . ',
							' . $objDatabase->SqlVariable($this->strAddress) . ',
							' . $objDatabase->SqlVariable($this->strHours) . ',
							' . $objDatabase->SqlVariable($this->strWebsite) . ',
							' . $objDatabase->SqlVariable($this->strUpdateResponse) . '
						)
					');

					// Update Identity column and return its value
					$mixToReturn = $this->intId = $objDatabase->InsertId('PartnerBusiness', 'Id');
				} else {
					// Perform an UPDATE query

					// First checking for Optimistic Locking constraints (if applicable)

					// Perform the UPDATE query
					$objDatabase->NonQuery('
						UPDATE
							`PartnerBusiness`
						SET
							`Active` = ' . $objDatabase->SqlVariable($this->blnActive) . ',
							`VerifiedDiscountDate` = ' . $objDatabase->SqlVariable($this->dttVerifiedDiscountDate) . ',
							`Name` = ' . $objDatabase->SqlVariable($this->strName) . ',
							`Discount` = ' . $objDatabase->SqlVariable($this->strDiscount) . ',
							`Phone` = ' . $objDatabase->SqlVariable($this->strPhone) . ',
							`Address` = ' . $objDatabase->SqlVariable($this->strAddress) . ',
							`Hours` = ' . $objDatabase->SqlVariable($this->strHours) . ',
							`Website` = ' . $objDatabase->SqlVariable($this->strWebsite) . ',
							`UpdateResponse` = ' . $objDatabase->SqlVariable($this->strUpdateResponse) . '
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
		 * Delete this PartnerBusiness
		 * @return void
		*/
		public function Delete() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Cannot delete this PartnerBusiness with an unset primary key.');

			// Get the Database Object for this Class
			$objDatabase = PartnerBusiness::GetDatabase();


			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`PartnerBusiness`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($this->intId) . '');
		}

		/**
		 * Delete all PartnerBusinesses
		 * @return void
		*/
		public static function DeleteAll() {
			// Get the Database Object for this Class
			$objDatabase = PartnerBusiness::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				DELETE FROM
					`PartnerBusiness`');
		}

		/**
		 * Truncate PartnerBusiness table
		 * @return void
		*/
		public static function Truncate() {
			// Get the Database Object for this Class
			$objDatabase = PartnerBusiness::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				TRUNCATE `PartnerBusiness`');
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

				case 'Active':
					/**
					 * Gets the value for blnActive 
					 * @return boolean
					 */
					return $this->blnActive;

				case 'VerifiedDiscountDate':
					/**
					 * Gets the value for dttVerifiedDiscountDate 
					 * @return QDateTime
					 */
					return $this->dttVerifiedDiscountDate;

				case 'Name':
					/**
					 * Gets the value for strName (Not Null)
					 * @return string
					 */
					return $this->strName;

				case 'Discount':
					/**
					 * Gets the value for strDiscount 
					 * @return string
					 */
					return $this->strDiscount;

				case 'Phone':
					/**
					 * Gets the value for strPhone 
					 * @return string
					 */
					return $this->strPhone;

				case 'Address':
					/**
					 * Gets the value for strAddress 
					 * @return string
					 */
					return $this->strAddress;

				case 'Hours':
					/**
					 * Gets the value for strHours 
					 * @return string
					 */
					return $this->strHours;

				case 'Website':
					/**
					 * Gets the value for strWebsite 
					 * @return string
					 */
					return $this->strWebsite;

				case 'UpdateResponse':
					/**
					 * Gets the value for strUpdateResponse 
					 * @return string
					 */
					return $this->strUpdateResponse;


				///////////////////
				// Member Objects
				///////////////////

				////////////////////////////
				// Virtual Object References (Many to Many and Reverse References)
				// (If restored via a "Many-to" expansion)
				////////////////////////////

				case '_BusinessMemberAssocAsId':
					/**
					 * Gets the value for the private _objBusinessMemberAssocAsId (Read-Only)
					 * if set due to an expansion on the BusinessMemberAssoc.PartnerBusinessId reverse relationship
					 * @return BusinessMemberAssoc
					 */
					return $this->_objBusinessMemberAssocAsId;

				case '_BusinessMemberAssocAsIdArray':
					/**
					 * Gets the value for the private _objBusinessMemberAssocAsIdArray (Read-Only)
					 * if set due to an ExpandAsArray on the BusinessMemberAssoc.PartnerBusinessId reverse relationship
					 * @return BusinessMemberAssoc[]
					 */
					return (array) $this->_objBusinessMemberAssocAsIdArray;

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
				case 'Active':
					/**
					 * Sets the value for blnActive 
					 * @param boolean $mixValue
					 * @return boolean
					 */
					try {
						return ($this->blnActive = QType::Cast($mixValue, QType::Boolean));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'VerifiedDiscountDate':
					/**
					 * Sets the value for dttVerifiedDiscountDate 
					 * @param QDateTime $mixValue
					 * @return QDateTime
					 */
					try {
						return ($this->dttVerifiedDiscountDate = QType::Cast($mixValue, QType::DateTime));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

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

				case 'Discount':
					/**
					 * Sets the value for strDiscount 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strDiscount = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'Phone':
					/**
					 * Sets the value for strPhone 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strPhone = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'Address':
					/**
					 * Sets the value for strAddress 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strAddress = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'Hours':
					/**
					 * Sets the value for strHours 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strHours = QType::Cast($mixValue, QType::String));
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

				case 'UpdateResponse':
					/**
					 * Sets the value for strUpdateResponse 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strUpdateResponse = QType::Cast($mixValue, QType::String));
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

			
		
		// Related Objects' Methods for BusinessMemberAssocAsId
		//-------------------------------------------------------------------

		/**
		 * Gets all associated BusinessMemberAssocsAsId as an array of BusinessMemberAssoc objects
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return BusinessMemberAssoc[]
		*/ 
		public function GetBusinessMemberAssocAsIdArray($objOptionalClauses = null) {
			if ((is_null($this->intId)))
				return array();

			try {
				return BusinessMemberAssoc::LoadArrayByPartnerBusinessId($this->intId, $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Counts all associated BusinessMemberAssocsAsId
		 * @return int
		*/ 
		public function CountBusinessMemberAssocsAsId() {
			if ((is_null($this->intId)))
				return 0;

			return BusinessMemberAssoc::CountByPartnerBusinessId($this->intId);
		}

		/**
		 * Associates a BusinessMemberAssocAsId
		 * @param BusinessMemberAssoc $objBusinessMemberAssoc
		 * @return void
		*/ 
		public function AssociateBusinessMemberAssocAsId(BusinessMemberAssoc $objBusinessMemberAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateBusinessMemberAssocAsId on this unsaved PartnerBusiness.');
			if ((is_null($objBusinessMemberAssoc->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateBusinessMemberAssocAsId on this PartnerBusiness with an unsaved BusinessMemberAssoc.');

			// Get the Database Object for this Class
			$objDatabase = PartnerBusiness::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`BusinessMemberAssoc`
				SET
					`PartnerBusinessId` = ' . $objDatabase->SqlVariable($this->intId) . '
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objBusinessMemberAssoc->Id) . '
			');
		}

		/**
		 * Unassociates a BusinessMemberAssocAsId
		 * @param BusinessMemberAssoc $objBusinessMemberAssoc
		 * @return void
		*/ 
		public function UnassociateBusinessMemberAssocAsId(BusinessMemberAssoc $objBusinessMemberAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateBusinessMemberAssocAsId on this unsaved PartnerBusiness.');
			if ((is_null($objBusinessMemberAssoc->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateBusinessMemberAssocAsId on this PartnerBusiness with an unsaved BusinessMemberAssoc.');

			// Get the Database Object for this Class
			$objDatabase = PartnerBusiness::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`BusinessMemberAssoc`
				SET
					`PartnerBusinessId` = null
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objBusinessMemberAssoc->Id) . ' AND
					`PartnerBusinessId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Unassociates all BusinessMemberAssocsAsId
		 * @return void
		*/ 
		public function UnassociateAllBusinessMemberAssocsAsId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateBusinessMemberAssocAsId on this unsaved PartnerBusiness.');

			// Get the Database Object for this Class
			$objDatabase = PartnerBusiness::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`BusinessMemberAssoc`
				SET
					`PartnerBusinessId` = null
				WHERE
					`PartnerBusinessId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes an associated BusinessMemberAssocAsId
		 * @param BusinessMemberAssoc $objBusinessMemberAssoc
		 * @return void
		*/ 
		public function DeleteAssociatedBusinessMemberAssocAsId(BusinessMemberAssoc $objBusinessMemberAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateBusinessMemberAssocAsId on this unsaved PartnerBusiness.');
			if ((is_null($objBusinessMemberAssoc->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateBusinessMemberAssocAsId on this PartnerBusiness with an unsaved BusinessMemberAssoc.');

			// Get the Database Object for this Class
			$objDatabase = PartnerBusiness::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`BusinessMemberAssoc`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objBusinessMemberAssoc->Id) . ' AND
					`PartnerBusinessId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes all associated BusinessMemberAssocsAsId
		 * @return void
		*/ 
		public function DeleteAllBusinessMemberAssocsAsId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateBusinessMemberAssocAsId on this unsaved PartnerBusiness.');

			// Get the Database Object for this Class
			$objDatabase = PartnerBusiness::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`BusinessMemberAssoc`
				WHERE
					`PartnerBusinessId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}




		///////////////////////////////////////////////////////////////////////
		// PROTECTED MEMBER VARIABLES and TEXT FIELD MAXLENGTHS (if applicable)
		///////////////////////////////////////////////////////////////////////
		
		/**
		 * Protected member variable that maps to the database PK Identity column PartnerBusiness.Id
		 * @var integer intId
		 */
		protected $intId;
		const IdDefault = null;


		/**
		 * Protected member variable that maps to the database column PartnerBusiness.Active
		 * @var boolean blnActive
		 */
		protected $blnActive;
		const ActiveDefault = null;


		/**
		 * Protected member variable that maps to the database column PartnerBusiness.VerifiedDiscountDate
		 * @var QDateTime dttVerifiedDiscountDate
		 */
		protected $dttVerifiedDiscountDate;
		const VerifiedDiscountDateDefault = null;


		/**
		 * Protected member variable that maps to the database column PartnerBusiness.Name
		 * @var string strName
		 */
		protected $strName;
		const NameMaxLength = 250;
		const NameDefault = null;


		/**
		 * Protected member variable that maps to the database column PartnerBusiness.Discount
		 * @var string strDiscount
		 */
		protected $strDiscount;
		const DiscountMaxLength = 500;
		const DiscountDefault = null;


		/**
		 * Protected member variable that maps to the database column PartnerBusiness.Phone
		 * @var string strPhone
		 */
		protected $strPhone;
		const PhoneMaxLength = 250;
		const PhoneDefault = null;


		/**
		 * Protected member variable that maps to the database column PartnerBusiness.Address
		 * @var string strAddress
		 */
		protected $strAddress;
		const AddressMaxLength = 500;
		const AddressDefault = null;


		/**
		 * Protected member variable that maps to the database column PartnerBusiness.Hours
		 * @var string strHours
		 */
		protected $strHours;
		const HoursMaxLength = 500;
		const HoursDefault = null;


		/**
		 * Protected member variable that maps to the database column PartnerBusiness.Website
		 * @var string strWebsite
		 */
		protected $strWebsite;
		const WebsiteMaxLength = 500;
		const WebsiteDefault = null;


		/**
		 * Protected member variable that maps to the database column PartnerBusiness.UpdateResponse
		 * @var string strUpdateResponse
		 */
		protected $strUpdateResponse;
		const UpdateResponseMaxLength = 2000;
		const UpdateResponseDefault = null;


		/**
		 * Private member variable that stores a reference to a single BusinessMemberAssocAsId object
		 * (of type BusinessMemberAssoc), if this PartnerBusiness object was restored with
		 * an expansion on the BusinessMemberAssoc association table.
		 * @var BusinessMemberAssoc _objBusinessMemberAssocAsId;
		 */
		private $_objBusinessMemberAssocAsId;

		/**
		 * Private member variable that stores a reference to an array of BusinessMemberAssocAsId objects
		 * (of type BusinessMemberAssoc[]), if this PartnerBusiness object was restored with
		 * an ExpandAsArray on the BusinessMemberAssoc association table.
		 * @var BusinessMemberAssoc[] _objBusinessMemberAssocAsIdArray;
		 */
		private $_objBusinessMemberAssocAsIdArray = array();

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
			$strToReturn = '<complexType name="PartnerBusiness"><sequence>';
			$strToReturn .= '<element name="Id" type="xsd:int"/>';
			$strToReturn .= '<element name="Active" type="xsd:boolean"/>';
			$strToReturn .= '<element name="VerifiedDiscountDate" type="xsd:dateTime"/>';
			$strToReturn .= '<element name="Name" type="xsd:string"/>';
			$strToReturn .= '<element name="Discount" type="xsd:string"/>';
			$strToReturn .= '<element name="Phone" type="xsd:string"/>';
			$strToReturn .= '<element name="Address" type="xsd:string"/>';
			$strToReturn .= '<element name="Hours" type="xsd:string"/>';
			$strToReturn .= '<element name="Website" type="xsd:string"/>';
			$strToReturn .= '<element name="UpdateResponse" type="xsd:string"/>';
			$strToReturn .= '<element name="__blnRestored" type="xsd:boolean"/>';
			$strToReturn .= '</sequence></complexType>';
			return $strToReturn;
		}

		public static function AlterSoapComplexTypeArray(&$strComplexTypeArray) {
			if (!array_key_exists('PartnerBusiness', $strComplexTypeArray)) {
				$strComplexTypeArray['PartnerBusiness'] = PartnerBusiness::GetSoapComplexTypeXml();
			}
		}

		public static function GetArrayFromSoapArray($objSoapArray) {
			$objArrayToReturn = array();

			foreach ($objSoapArray as $objSoapObject)
				array_push($objArrayToReturn, PartnerBusiness::GetObjectFromSoapObject($objSoapObject));

			return $objArrayToReturn;
		}

		public static function GetObjectFromSoapObject($objSoapObject) {
			$objToReturn = new PartnerBusiness();
			if (property_exists($objSoapObject, 'Id'))
				$objToReturn->intId = $objSoapObject->Id;
			if (property_exists($objSoapObject, 'Active'))
				$objToReturn->blnActive = $objSoapObject->Active;
			if (property_exists($objSoapObject, 'VerifiedDiscountDate'))
				$objToReturn->dttVerifiedDiscountDate = new QDateTime($objSoapObject->VerifiedDiscountDate);
			if (property_exists($objSoapObject, 'Name'))
				$objToReturn->strName = $objSoapObject->Name;
			if (property_exists($objSoapObject, 'Discount'))
				$objToReturn->strDiscount = $objSoapObject->Discount;
			if (property_exists($objSoapObject, 'Phone'))
				$objToReturn->strPhone = $objSoapObject->Phone;
			if (property_exists($objSoapObject, 'Address'))
				$objToReturn->strAddress = $objSoapObject->Address;
			if (property_exists($objSoapObject, 'Hours'))
				$objToReturn->strHours = $objSoapObject->Hours;
			if (property_exists($objSoapObject, 'Website'))
				$objToReturn->strWebsite = $objSoapObject->Website;
			if (property_exists($objSoapObject, 'UpdateResponse'))
				$objToReturn->strUpdateResponse = $objSoapObject->UpdateResponse;
			if (property_exists($objSoapObject, '__blnRestored'))
				$objToReturn->__blnRestored = $objSoapObject->__blnRestored;
			return $objToReturn;
		}

		public static function GetSoapArrayFromArray($objArray) {
			if (!$objArray)
				return null;

			$objArrayToReturn = array();

			foreach ($objArray as $objObject)
				array_push($objArrayToReturn, PartnerBusiness::GetSoapObjectFromObject($objObject, true));

			return unserialize(serialize($objArrayToReturn ?? '') ?? '');
		}

		public static function GetSoapObjectFromObject($objObject, $blnBindRelatedObjects) {
			if ($objObject->dttVerifiedDiscountDate)
				$objObject->dttVerifiedDiscountDate = $objObject->dttVerifiedDiscountDate->toString(QDateTime::FormatSoap);
			return $objObject;
		}
	}





	/////////////////////////////////////
	// ADDITIONAL CLASSES for QCODO QUERY
	/////////////////////////////////////

	class QQNodePartnerBusiness extends QQNode {
		protected $strTableName = 'PartnerBusiness';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'PartnerBusiness';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'Active':
					return new QQNode('Active', 'boolean', $this);
				case 'VerifiedDiscountDate':
					return new QQNode('VerifiedDiscountDate', 'QDateTime', $this);
				case 'Name':
					return new QQNode('Name', 'string', $this);
				case 'Discount':
					return new QQNode('Discount', 'string', $this);
				case 'Phone':
					return new QQNode('Phone', 'string', $this);
				case 'Address':
					return new QQNode('Address', 'string', $this);
				case 'Hours':
					return new QQNode('Hours', 'string', $this);
				case 'Website':
					return new QQNode('Website', 'string', $this);
				case 'UpdateResponse':
					return new QQNode('UpdateResponse', 'string', $this);
				case 'BusinessMemberAssocAsId':
					return new QQReverseReferenceNodeBusinessMemberAssoc($this, 'businessmemberassocasid', 'reverse_reference', 'PartnerBusinessId');

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

	class QQReverseReferenceNodePartnerBusiness extends QQReverseReferenceNode {
		protected $strTableName = 'PartnerBusiness';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'PartnerBusiness';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'Active':
					return new QQNode('Active', 'boolean', $this);
				case 'VerifiedDiscountDate':
					return new QQNode('VerifiedDiscountDate', 'QDateTime', $this);
				case 'Name':
					return new QQNode('Name', 'string', $this);
				case 'Discount':
					return new QQNode('Discount', 'string', $this);
				case 'Phone':
					return new QQNode('Phone', 'string', $this);
				case 'Address':
					return new QQNode('Address', 'string', $this);
				case 'Hours':
					return new QQNode('Hours', 'string', $this);
				case 'Website':
					return new QQNode('Website', 'string', $this);
				case 'UpdateResponse':
					return new QQNode('UpdateResponse', 'string', $this);
				case 'BusinessMemberAssocAsId':
					return new QQReverseReferenceNodeBusinessMemberAssoc($this, 'businessmemberassocasid', 'reverse_reference', 'PartnerBusinessId');

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