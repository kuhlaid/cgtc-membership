<?php
	/**
	 * The abstract TagGen class defined here is
	 * code-generated and contains all the basic CRUD-type functionality as well as
	 * basic methods to handle relationships and index-based loading.
	 *
	 * To use, you should use the Tag subclass which
	 * extends this TagGen class.
	 *
	 * Because subsequent re-code generations will overwrite any changes to this
	 * file, you should leave this file unaltered to prevent yourself from losing
	 * any information or code changes.  All customizations should be done by
	 * overriding existing or implementing new methods, properties and variables
	 * in the Tag class.
	 * 
	 * @package My Application
	 * @subpackage GeneratedDataObjects
	 * 
	 */
	class TagGen extends QBaseClass {
		///////////////////////////////
		// COMMON LOAD METHODS
		///////////////////////////////

		/**
		 * Load a Tag from PK Info
		 * @param integer $intId
		 * @return Tag
		 */
		public static function Load($intId) {
			// Use QuerySingle to Perform the Query
			return Tag::QuerySingle(
				QQ::Equal(QQN::Tag()->Id, $intId)
			);
		}

		/**
		 * Load all Tags
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return Tag[]
		 */
		public static function LoadAll($objOptionalClauses = null) {
			// Call Tag::QueryArray to perform the LoadAll query
			try {
				return Tag::QueryArray(QQ::All(), $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count all Tags
		 * @return int
		 */
		public static function CountAll() {
			// Call Tag::QueryCount to perform the CountAll query
			return Tag::QueryCount(QQ::All());
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
			$objDatabase = Tag::GetDatabase();

			// Create/Build out the QueryBuilder object with Tag-specific SELET and FROM fields
			$objQueryBuilder = new QQueryBuilder($objDatabase, 'Tag');
			Tag::GetSelectFields($objQueryBuilder,null,$selectionArray);
			$objQueryBuilder->AddFromItem('`Tag` AS `Tag`');

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
		 * Static Qcodo Query method to query for a single Tag object.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return Tag the queried object
		 */
		public static function QuerySingle(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = Tag::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query, Get the First Row, and Instantiate a new Tag object
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return Tag::InstantiateDbRow($objDbResult->GetNextRow());
		}

		/**
		 * Static Qcodo Query method to query for an array of Tag objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return Tag[] the queried objects as an array
		 */
		public static function QueryArray(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = Tag::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query and Instantiate the Array Result
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return Tag::InstantiateDbResult($objDbResult, $objQueryBuilder->ExpandAsArrayNodes);
		}

		/**
		 * Static Qcodo Query method to query for a count of Tag objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return integer the count of queried objects as an integer
		 */
		public static function QueryCount(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = Tag::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, true,$selectionArray);
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
			$objDatabase = Tag::GetDatabase();

			// Lookup the QCache for This Query Statement
			$objCache = new QCache('query', 'Tag_' . serialize($strConditions));
			if (!($strQuery = $objCache->GetData())) {
				// Not Found -- Go ahead and Create/Build out a new QueryBuilder object with Tag-specific fields
				$objQueryBuilder = new QQueryBuilder($objDatabase);
				Tag::GetSelectFields($objQueryBuilder);
				Tag::GetFromFields($objQueryBuilder);

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
			return Tag::InstantiateDbResult($objDbResult);
		}*/

		/**
		 * Updates a QQueryBuilder with the SELECT fields for this Tag
		 * @param QQueryBuilder $objBuilder the Query Builder object to update
		 * @param string $strPrefix optional prefix to add to the SELECT fields
		 * @param array $selectionArray optional array of SELECT field items (wpg - added Sept 2012)
		 */
		public static function GetSelectFields(QQueryBuilder $objBuilder, $strPrefix = null, $selectionArray = null) {
			if ($strPrefix) {
				$strTableName = '`' . $strPrefix . '`';
				$strAliasPrefix = '`' . $strPrefix . '__';
			} else {
				$strTableName = '`Tag`';
				$strAliasPrefix = '`';
			}

			// wpg - if we are not passing in an array of participant fields we want then get them all
			if (!$selectionArray){
				$objBuilder->AddSelectItem($strTableName . '.`Id` AS ' . $strAliasPrefix . 'Id`');
				$objBuilder->AddSelectItem($strTableName . '.`Name` AS ' . $strAliasPrefix . 'Name`');
				$objBuilder->AddSelectItem($strTableName . '.`Description` AS ' . $strAliasPrefix . 'Description`');
				$objBuilder->AddSelectItem($strTableName . '.`Created` AS ' . $strAliasPrefix . 'Created`');
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
		 * Instantiate a Tag from a Database Row.
		 * Takes in an optional strAliasPrefix, used in case another Object::InstantiateDbRow
		 * is calling this Tag::InstantiateDbRow in order to perform
		 * early binding on referenced objects.
		 * @param DatabaseRowBase $objDbRow
		 * @param string $strAliasPrefix
		 * @return Tag
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
					$strAliasPrefix = 'Tag__';


				if ((array_key_exists($strAliasPrefix . 'membertagassocasid__MemberId', $strExpandAsArrayNodes)) &&
					(!is_null($objDbRow->GetColumn($strAliasPrefix . 'membertagassocasid__MemberId')))) {
					if ($intPreviousChildItemCount = count($objPreviousItem->_objMemberTagAssocAsIdArray)) {
						$objPreviousChildItem = $objPreviousItem->_objMemberTagAssocAsIdArray[$intPreviousChildItemCount - 1];
						$objChildItem = MemberTagAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membertagassocasid__', $strExpandAsArrayNodes, $objPreviousChildItem);
						if ($objChildItem)
							array_push($objPreviousItem->_objMemberTagAssocAsIdArray, $objChildItem);
					} else
						array_push($objPreviousItem->_objMemberTagAssocAsIdArray, MemberTagAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membertagassocasid__', $strExpandAsArrayNodes));
					$blnExpandedViaArray = true;
				}

				// Either return false to signal array expansion, or check-to-reset the Alias prefix and move on
				if ($blnExpandedViaArray)
					return false;
				else if ($strAliasPrefix == 'Tag__')
					$strAliasPrefix = null;
			}

			// Create a new instance of the Tag object
			$objToReturn = new Tag();
			$objToReturn->__blnRestored = true;

			$objToReturn->intId = $objDbRow->GetColumn($strAliasPrefix . 'Id', 'Integer');
			$objToReturn->strName = $objDbRow->GetColumn($strAliasPrefix . 'Name', 'VarChar');
			$objToReturn->strDescription = $objDbRow->GetColumn($strAliasPrefix . 'Description', 'VarChar');
			$objToReturn->dttCreated = $objDbRow->GetColumn($strAliasPrefix . 'Created', 'Date');

			// Instantiate Virtual Attributes
			foreach ($objDbRow->GetColumnNameArray() as $strColumnName => $mixValue) {
				$strVirtualPrefix = $strAliasPrefix . '__';
				$strVirtualPrefixLength = strlen($strVirtualPrefix ?? '');
				if (substr($strColumnName, 0, $strVirtualPrefixLength) == $strVirtualPrefix)
					$objToReturn->__strVirtualAttributeArray[substr($strColumnName, $strVirtualPrefixLength)] = $mixValue;
			}

			// Prepare to Check for Early/Virtual Binding
			if (!$strAliasPrefix)
				$strAliasPrefix = 'Tag__';




			// Check for MemberTagAssocAsId Virtual Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'membertagassocasid__MemberId'))) {
				if (($strExpandAsArrayNodes) && (array_key_exists($strAliasPrefix . 'membertagassocasid__MemberId', $strExpandAsArrayNodes)))
					array_push($objToReturn->_objMemberTagAssocAsIdArray, MemberTagAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membertagassocasid__', $strExpandAsArrayNodes));
				else
					$objToReturn->_objMemberTagAssocAsId = MemberTagAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membertagassocasid__', $strExpandAsArrayNodes);
			}

			return $objToReturn;
		}

		/**
		 * Instantiate an array of Tags from a Database Result
		 * @param DatabaseResultBase $objDbResult
		 * @return Tag[]
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
					$objItem = Tag::InstantiateDbRow($objDbRow, null, $strExpandAsArrayNodes, $objLastRowItem);
					if ($objItem) {
						array_push($objToReturn, $objItem);
						$objLastRowItem = $objItem;
					}
				}
			} else {
				while ($objDbRow = $objDbResult->GetNextRow())
					array_push($objToReturn, Tag::InstantiateDbRow($objDbRow));
			}

			return $objToReturn;
		}



		///////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Single Load and Array)
		///////////////////////////////////////////////////
			
		/**
		 * Load a single Tag object,
		 * by Id Index(es)
		 * @param integer $intId
		 * @return Tag
		*/
		public static function LoadById($intId) {
			return Tag::QuerySingle(
				QQ::Equal(QQN::Tag()->Id, $intId)
			);
		}



		////////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Array via Many to Many)
		////////////////////////////////////////////////////



		//////////////////
		// SAVE AND DELETE
		//////////////////

		/**
		 * Save this Tag
		 * @param bool $blnForceInsert
		 * @param bool $blnForceUpdate
		 * @return int
		*/
		public function Save($blnForceInsert = false, $blnForceUpdate = false) {
			// Get the Database Object for this Class
			$objDatabase = Tag::GetDatabase();

			$mixToReturn = null;

			try {
				if ((!$this->__blnRestored) || ($blnForceInsert)) {
					// Perform an INSERT query
					$objDatabase->NonQuery('
						INSERT INTO `Tag` (
							`Name`,
							`Description`,
							`Created`
						) VALUES (
							' . $objDatabase->SqlVariable($this->strName) . ',
							' . $objDatabase->SqlVariable($this->strDescription) . ',
							' . $objDatabase->SqlVariable($this->dttCreated) . '
						)
					');

					// Update Identity column and return its value
					$mixToReturn = $this->intId = $objDatabase->InsertId('Tag', 'Id');
				} else {
					// Perform an UPDATE query

					// First checking for Optimistic Locking constraints (if applicable)

					// Perform the UPDATE query
					$objDatabase->NonQuery('
						UPDATE
							`Tag`
						SET
							`Name` = ' . $objDatabase->SqlVariable($this->strName) . ',
							`Description` = ' . $objDatabase->SqlVariable($this->strDescription) . ',
							`Created` = ' . $objDatabase->SqlVariable($this->dttCreated) . '
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
		 * Delete this Tag
		 * @return void
		*/
		public function Delete() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Cannot delete this Tag with an unset primary key.');

			// Get the Database Object for this Class
			$objDatabase = Tag::GetDatabase();


			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`Tag`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($this->intId) . '');
		}

		/**
		 * Delete all Tags
		 * @return void
		*/
		public static function DeleteAll() {
			// Get the Database Object for this Class
			$objDatabase = Tag::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				DELETE FROM
					`Tag`');
		}

		/**
		 * Truncate Tag table
		 * @return void
		*/
		public static function Truncate() {
			// Get the Database Object for this Class
			$objDatabase = Tag::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				TRUNCATE `Tag`');
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

				case 'Description':
					/**
					 * Gets the value for strDescription (Not Null)
					 * @return string
					 */
					return $this->strDescription;

				case 'Created':
					/**
					 * Gets the value for dttCreated 
					 * @return QDateTime
					 */
					return $this->dttCreated;


				///////////////////
				// Member Objects
				///////////////////

				////////////////////////////
				// Virtual Object References (Many to Many and Reverse References)
				// (If restored via a "Many-to" expansion)
				////////////////////////////

				case '_MemberTagAssocAsId':
					/**
					 * Gets the value for the private _objMemberTagAssocAsId (Read-Only)
					 * if set due to an expansion on the MemberTagAssoc.TagId reverse relationship
					 * @return MemberTagAssoc
					 */
					return $this->_objMemberTagAssocAsId;

				case '_MemberTagAssocAsIdArray':
					/**
					 * Gets the value for the private _objMemberTagAssocAsIdArray (Read-Only)
					 * if set due to an ExpandAsArray on the MemberTagAssoc.TagId reverse relationship
					 * @return MemberTagAssoc[]
					 */
					return (array) $this->_objMemberTagAssocAsIdArray;

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

				case 'Description':
					/**
					 * Sets the value for strDescription (Not Null)
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strDescription = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'Created':
					/**
					 * Sets the value for dttCreated 
					 * @param QDateTime $mixValue
					 * @return QDateTime
					 */
					try {
						return ($this->dttCreated = QType::Cast($mixValue, QType::DateTime));
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

			
		
		// Related Objects' Methods for MemberTagAssocAsId
		//-------------------------------------------------------------------

		/**
		 * Gets all associated MemberTagAssocsAsId as an array of MemberTagAssoc objects
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return MemberTagAssoc[]
		*/ 
		public function GetMemberTagAssocAsIdArray($objOptionalClauses = null) {
			if ((is_null($this->intId)))
				return array();

			try {
				return MemberTagAssoc::LoadArrayByTagId($this->intId, $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Counts all associated MemberTagAssocsAsId
		 * @return int
		*/ 
		public function CountMemberTagAssocsAsId() {
			if ((is_null($this->intId)))
				return 0;

			return MemberTagAssoc::CountByTagId($this->intId);
		}

		/**
		 * Associates a MemberTagAssocAsId
		 * @param MemberTagAssoc $objMemberTagAssoc
		 * @return void
		*/ 
		public function AssociateMemberTagAssocAsId(MemberTagAssoc $objMemberTagAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateMemberTagAssocAsId on this unsaved Tag.');
			if ((is_null($objMemberTagAssoc->MemberId)) || (is_null($objMemberTagAssoc->TagId)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateMemberTagAssocAsId on this Tag with an unsaved MemberTagAssoc.');

			// Get the Database Object for this Class
			$objDatabase = Tag::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MemberTagAssoc`
				SET
					`TagId` = ' . $objDatabase->SqlVariable($this->intId) . '
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($objMemberTagAssoc->MemberId) . ' AND
					`TagId` = ' . $objDatabase->SqlVariable($objMemberTagAssoc->TagId) . '
			');
		}

		/**
		 * Unassociates a MemberTagAssocAsId
		 * @param MemberTagAssoc $objMemberTagAssoc
		 * @return void
		*/ 
		public function UnassociateMemberTagAssocAsId(MemberTagAssoc $objMemberTagAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberTagAssocAsId on this unsaved Tag.');
			if ((is_null($objMemberTagAssoc->MemberId)) || (is_null($objMemberTagAssoc->TagId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberTagAssocAsId on this Tag with an unsaved MemberTagAssoc.');

			// Get the Database Object for this Class
			$objDatabase = Tag::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MemberTagAssoc`
				SET
					`TagId` = null
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($objMemberTagAssoc->MemberId) . ' AND
					`TagId` = ' . $objDatabase->SqlVariable($objMemberTagAssoc->TagId) . ' AND
					`TagId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Unassociates all MemberTagAssocsAsId
		 * @return void
		*/ 
		public function UnassociateAllMemberTagAssocsAsId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberTagAssocAsId on this unsaved Tag.');

			// Get the Database Object for this Class
			$objDatabase = Tag::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MemberTagAssoc`
				SET
					`TagId` = null
				WHERE
					`TagId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes an associated MemberTagAssocAsId
		 * @param MemberTagAssoc $objMemberTagAssoc
		 * @return void
		*/ 
		public function DeleteAssociatedMemberTagAssocAsId(MemberTagAssoc $objMemberTagAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberTagAssocAsId on this unsaved Tag.');
			if ((is_null($objMemberTagAssoc->MemberId)) || (is_null($objMemberTagAssoc->TagId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberTagAssocAsId on this Tag with an unsaved MemberTagAssoc.');

			// Get the Database Object for this Class
			$objDatabase = Tag::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MemberTagAssoc`
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($objMemberTagAssoc->MemberId) . ' AND
					`TagId` = ' . $objDatabase->SqlVariable($objMemberTagAssoc->TagId) . ' AND
					`TagId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes all associated MemberTagAssocsAsId
		 * @return void
		*/ 
		public function DeleteAllMemberTagAssocsAsId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberTagAssocAsId on this unsaved Tag.');

			// Get the Database Object for this Class
			$objDatabase = Tag::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MemberTagAssoc`
				WHERE
					`TagId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}




		///////////////////////////////////////////////////////////////////////
		// PROTECTED MEMBER VARIABLES and TEXT FIELD MAXLENGTHS (if applicable)
		///////////////////////////////////////////////////////////////////////
		
		/**
		 * Protected member variable that maps to the database PK Identity column Tag.Id
		 * @var integer intId
		 */
		protected $intId;
		const IdDefault = null;


		/**
		 * Protected member variable that maps to the database column Tag.Name
		 * @var string strName
		 */
		protected $strName;
		const NameMaxLength = 50;
		const NameDefault = null;


		/**
		 * Protected member variable that maps to the database column Tag.Description
		 * @var string strDescription
		 */
		protected $strDescription;
		const DescriptionMaxLength = 500;
		const DescriptionDefault = null;


		/**
		 * Protected member variable that maps to the database column Tag.Created
		 * @var QDateTime dttCreated
		 */
		protected $dttCreated;
		const CreatedDefault = null;


		/**
		 * Private member variable that stores a reference to a single MemberTagAssocAsId object
		 * (of type MemberTagAssoc), if this Tag object was restored with
		 * an expansion on the MemberTagAssoc association table.
		 * @var MemberTagAssoc _objMemberTagAssocAsId;
		 */
		private $_objMemberTagAssocAsId;

		/**
		 * Private member variable that stores a reference to an array of MemberTagAssocAsId objects
		 * (of type MemberTagAssoc[]), if this Tag object was restored with
		 * an ExpandAsArray on the MemberTagAssoc association table.
		 * @var MemberTagAssoc[] _objMemberTagAssocAsIdArray;
		 */
		private $_objMemberTagAssocAsIdArray = array();

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
			$strToReturn = '<complexType name="Tag"><sequence>';
			$strToReturn .= '<element name="Id" type="xsd:int"/>';
			$strToReturn .= '<element name="Name" type="xsd:string"/>';
			$strToReturn .= '<element name="Description" type="xsd:string"/>';
			$strToReturn .= '<element name="Created" type="xsd:dateTime"/>';
			$strToReturn .= '<element name="__blnRestored" type="xsd:boolean"/>';
			$strToReturn .= '</sequence></complexType>';
			return $strToReturn;
		}

		public static function AlterSoapComplexTypeArray(&$strComplexTypeArray) {
			if (!array_key_exists('Tag', $strComplexTypeArray)) {
				$strComplexTypeArray['Tag'] = Tag::GetSoapComplexTypeXml();
			}
		}

		public static function GetArrayFromSoapArray($objSoapArray) {
			$objArrayToReturn = array();

			foreach ($objSoapArray as $objSoapObject)
				array_push($objArrayToReturn, Tag::GetObjectFromSoapObject($objSoapObject));

			return $objArrayToReturn;
		}

		public static function GetObjectFromSoapObject($objSoapObject) {
			$objToReturn = new Tag();
			if (property_exists($objSoapObject, 'Id'))
				$objToReturn->intId = $objSoapObject->Id;
			if (property_exists($objSoapObject, 'Name'))
				$objToReturn->strName = $objSoapObject->Name;
			if (property_exists($objSoapObject, 'Description'))
				$objToReturn->strDescription = $objSoapObject->Description;
			if (property_exists($objSoapObject, 'Created'))
				$objToReturn->dttCreated = new QDateTime($objSoapObject->Created);
			if (property_exists($objSoapObject, '__blnRestored'))
				$objToReturn->__blnRestored = $objSoapObject->__blnRestored;
			return $objToReturn;
		}

		public static function GetSoapArrayFromArray($objArray) {
			if (!$objArray)
				return null;

			$objArrayToReturn = array();

			foreach ($objArray as $objObject)
				array_push($objArrayToReturn, Tag::GetSoapObjectFromObject($objObject, true));

			return unserialize(serialize($objArrayToReturn ?? '') ?? '');
		}

		public static function GetSoapObjectFromObject($objObject, $blnBindRelatedObjects) {
			if ($objObject->dttCreated)
				$objObject->dttCreated = $objObject->dttCreated->toString(QDateTime::FormatSoap);
			return $objObject;
		}
	}





	/////////////////////////////////////
	// ADDITIONAL CLASSES for QCODO QUERY
	/////////////////////////////////////

	class QQNodeTag extends QQNode {
		protected $strTableName = 'Tag';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'Tag';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'Name':
					return new QQNode('Name', 'string', $this);
				case 'Description':
					return new QQNode('Description', 'string', $this);
				case 'Created':
					return new QQNode('Created', 'QDateTime', $this);
				case 'MemberTagAssocAsId':
					return new QQReverseReferenceNodeMemberTagAssoc($this, 'membertagassocasid', 'reverse_reference', 'TagId');

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

	class QQReverseReferenceNodeTag extends QQReverseReferenceNode {
		protected $strTableName = 'Tag';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'Tag';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'Name':
					return new QQNode('Name', 'string', $this);
				case 'Description':
					return new QQNode('Description', 'string', $this);
				case 'Created':
					return new QQNode('Created', 'QDateTime', $this);
				case 'MemberTagAssocAsId':
					return new QQReverseReferenceNodeMemberTagAssoc($this, 'membertagassocasid', 'reverse_reference', 'TagId');

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