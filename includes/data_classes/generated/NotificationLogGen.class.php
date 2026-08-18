<?php
	/**
	 * The abstract NotificationLogGen class defined here is
	 * code-generated and contains all the basic CRUD-type functionality as well as
	 * basic methods to handle relationships and index-based loading.
	 *
	 * To use, you should use the NotificationLog subclass which
	 * extends this NotificationLogGen class.
	 *
	 * Because subsequent re-code generations will overwrite any changes to this
	 * file, you should leave this file unaltered to prevent yourself from losing
	 * any information or code changes.  All customizations should be done by
	 * overriding existing or implementing new methods, properties and variables
	 * in the NotificationLog class.
	 * 
	 * @package My Application
	 * @subpackage GeneratedDataObjects
	 * 
	 */
	class NotificationLogGen extends QBaseClass {
		///////////////////////////////
		// COMMON LOAD METHODS
		///////////////////////////////

		/**
		 * Load a NotificationLog from PK Info
		 * @param integer $intId
		 * @return NotificationLog
		 */
		public static function Load($intId) {
			// Use QuerySingle to Perform the Query
			return NotificationLog::QuerySingle(
				QQ::Equal(QQN::NotificationLog()->Id, $intId)
			);
		}

		/**
		 * Load all NotificationLogs
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return NotificationLog[]
		 */
		public static function LoadAll($objOptionalClauses = null) {
			// Call NotificationLog::QueryArray to perform the LoadAll query
			try {
				return NotificationLog::QueryArray(QQ::All(), $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count all NotificationLogs
		 * @return int
		 */
		public static function CountAll() {
			// Call NotificationLog::QueryCount to perform the CountAll query
			return NotificationLog::QueryCount(QQ::All());
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
			$objDatabase = NotificationLog::GetDatabase();

			// Create/Build out the QueryBuilder object with NotificationLog-specific SELET and FROM fields
			$objQueryBuilder = new QQueryBuilder($objDatabase, 'NotificationLog');
			NotificationLog::GetSelectFields($objQueryBuilder,null,$selectionArray);
			$objQueryBuilder->AddFromItem('`NotificationLog` AS `NotificationLog`');

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
		 * Static Qcodo Query method to query for a single NotificationLog object.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return NotificationLog the queried object
		 */
		public static function QuerySingle(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = NotificationLog::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query, Get the First Row, and Instantiate a new NotificationLog object
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return NotificationLog::InstantiateDbRow($objDbResult->GetNextRow());
		}

		/**
		 * Static Qcodo Query method to query for an array of NotificationLog objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return NotificationLog[] the queried objects as an array
		 */
		public static function QueryArray(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = NotificationLog::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query and Instantiate the Array Result
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return NotificationLog::InstantiateDbResult($objDbResult, $objQueryBuilder->ExpandAsArrayNodes);
		}

		/**
		 * Static Qcodo Query method to query for a count of NotificationLog objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return integer the count of queried objects as an integer
		 */
		public static function QueryCount(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = NotificationLog::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, true,$selectionArray);
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
			$objDatabase = NotificationLog::GetDatabase();

			// Lookup the QCache for This Query Statement
			$objCache = new QCache('query', 'NotificationLog_' . serialize($strConditions));
			if (!($strQuery = $objCache->GetData())) {
				// Not Found -- Go ahead and Create/Build out a new QueryBuilder object with NotificationLog-specific fields
				$objQueryBuilder = new QQueryBuilder($objDatabase);
				NotificationLog::GetSelectFields($objQueryBuilder);
				NotificationLog::GetFromFields($objQueryBuilder);

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
			return NotificationLog::InstantiateDbResult($objDbResult);
		}*/

		/**
		 * Updates a QQueryBuilder with the SELECT fields for this NotificationLog
		 * @param QQueryBuilder $objBuilder the Query Builder object to update
		 * @param string $strPrefix optional prefix to add to the SELECT fields
		 * @param array $selectionArray optional array of SELECT field items (wpg - added Sept 2012)
		 */
		public static function GetSelectFields(QQueryBuilder $objBuilder, $strPrefix = null, $selectionArray = null) {
			if ($strPrefix) {
				$strTableName = '`' . $strPrefix . '`';
				$strAliasPrefix = '`' . $strPrefix . '__';
			} else {
				$strTableName = '`NotificationLog`';
				$strAliasPrefix = '`';
			}

			// wpg - if we are not passing in an array of participant fields we want then get them all
			if (!$selectionArray){
				$objBuilder->AddSelectItem($strTableName . '.`Id` AS ' . $strAliasPrefix . 'Id`');
				$objBuilder->AddSelectItem($strTableName . '.`MemberId` AS ' . $strAliasPrefix . 'MemberId`');
				$objBuilder->AddSelectItem($strTableName . '.`NotificationType` AS ' . $strAliasPrefix . 'NotificationType`');
				$objBuilder->AddSelectItem($strTableName . '.`NotificationDate` AS ' . $strAliasPrefix . 'NotificationDate`');
				$objBuilder->AddSelectItem($strTableName . '.`NotificationSubject` AS ' . $strAliasPrefix . 'NotificationSubject`');
				$objBuilder->AddSelectItem($strTableName . '.`NotificationBody` AS ' . $strAliasPrefix . 'NotificationBody`');
				$objBuilder->AddSelectItem($strTableName . '.`MembershipLogId` AS ' . $strAliasPrefix . 'MembershipLogId`');
				$objBuilder->AddSelectItem($strTableName . '.`NotificationConfirmed` AS ' . $strAliasPrefix . 'NotificationConfirmed`');
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
		 * Instantiate a NotificationLog from a Database Row.
		 * Takes in an optional strAliasPrefix, used in case another Object::InstantiateDbRow
		 * is calling this NotificationLog::InstantiateDbRow in order to perform
		 * early binding on referenced objects.
		 * @param DatabaseRowBase $objDbRow
		 * @param string $strAliasPrefix
		 * @return NotificationLog
		*/
		public static function InstantiateDbRow($objDbRow, $strAliasPrefix = null, $strExpandAsArrayNodes = null, $objPreviousItem = null) {
			// If blank row, return null
			if (!$objDbRow)
				return null;


			// Create a new instance of the NotificationLog object
			$objToReturn = new NotificationLog();
			$objToReturn->__blnRestored = true;

			$objToReturn->intId = $objDbRow->GetColumn($strAliasPrefix . 'Id', 'Integer');
			$objToReturn->intMemberId = $objDbRow->GetColumn($strAliasPrefix . 'MemberId', 'Integer');
			$objToReturn->intNotificationType = $objDbRow->GetColumn($strAliasPrefix . 'NotificationType', 'Integer');
			$objToReturn->dttNotificationDate = $objDbRow->GetColumn($strAliasPrefix . 'NotificationDate', 'DateTime');
			$objToReturn->strNotificationSubject = $objDbRow->GetColumn($strAliasPrefix . 'NotificationSubject', 'VarChar');
			$objToReturn->strNotificationBody = $objDbRow->GetColumn($strAliasPrefix . 'NotificationBody', 'Blob');
			$objToReturn->intMembershipLogId = $objDbRow->GetColumn($strAliasPrefix . 'MembershipLogId', 'Integer');
			$objToReturn->blnNotificationConfirmed = $objDbRow->GetColumn($strAliasPrefix . 'NotificationConfirmed', 'Bit');

			// Instantiate Virtual Attributes
			foreach ($objDbRow->GetColumnNameArray() as $strColumnName => $mixValue) {
				$strVirtualPrefix = $strAliasPrefix . '__';
				$strVirtualPrefixLength = strlen($strVirtualPrefix ?? '');
				if (substr($strColumnName, 0, $strVirtualPrefixLength) == $strVirtualPrefix)
					$objToReturn->__strVirtualAttributeArray[substr($strColumnName, $strVirtualPrefixLength)] = $mixValue;
			}

			// Prepare to Check for Early/Virtual Binding
			if (!$strAliasPrefix)
				$strAliasPrefix = 'NotificationLog__';

			// Check for MemberIdObject Early Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'MemberId__Id')))
				$objToReturn->objMemberIdObject = MemberContact::InstantiateDbRow($objDbRow, $strAliasPrefix . 'MemberId__', $strExpandAsArrayNodes);

			// Check for MembershipLogIdObject Early Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'MembershipLogId__Id')))
				$objToReturn->objMembershipLogIdObject = MembershipLog::InstantiateDbRow($objDbRow, $strAliasPrefix . 'MembershipLogId__', $strExpandAsArrayNodes);




			return $objToReturn;
		}

		/**
		 * Instantiate an array of NotificationLogs from a Database Result
		 * @param DatabaseResultBase $objDbResult
		 * @return NotificationLog[]
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
					$objItem = NotificationLog::InstantiateDbRow($objDbRow, null, $strExpandAsArrayNodes, $objLastRowItem);
					if ($objItem) {
						array_push($objToReturn, $objItem);
						$objLastRowItem = $objItem;
					}
				}
			} else {
				while ($objDbRow = $objDbResult->GetNextRow())
					array_push($objToReturn, NotificationLog::InstantiateDbRow($objDbRow));
			}

			return $objToReturn;
		}



		///////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Single Load and Array)
		///////////////////////////////////////////////////
			
		/**
		 * Load a single NotificationLog object,
		 * by Id Index(es)
		 * @param integer $intId
		 * @return NotificationLog
		*/
		public static function LoadById($intId) {
			return NotificationLog::QuerySingle(
				QQ::Equal(QQN::NotificationLog()->Id, $intId)
			);
		}
			
		/**
		 * Load an array of NotificationLog objects,
		 * by MemberId Index(es)
		 * @param integer $intMemberId
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return NotificationLog[]
		*/
		public static function LoadArrayByMemberId($intMemberId, $objOptionalClauses = null) {
			// Call NotificationLog::QueryArray to perform the LoadArrayByMemberId query
			try {
				return NotificationLog::QueryArray(
					QQ::Equal(QQN::NotificationLog()->MemberId, $intMemberId),
					$objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count NotificationLogs
		 * by MemberId Index(es)
		 * @param integer $intMemberId
		 * @return int
		*/
		public static function CountByMemberId($intMemberId) {
			// Call NotificationLog::QueryCount to perform the CountByMemberId query
			return NotificationLog::QueryCount(
				QQ::Equal(QQN::NotificationLog()->MemberId, $intMemberId)
			);
		}
			
		/**
		 * Load an array of NotificationLog objects,
		 * by MembershipLogId Index(es)
		 * @param integer $intMembershipLogId
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return NotificationLog[]
		*/
		public static function LoadArrayByMembershipLogId($intMembershipLogId, $objOptionalClauses = null) {
			// Call NotificationLog::QueryArray to perform the LoadArrayByMembershipLogId query
			try {
				return NotificationLog::QueryArray(
					QQ::Equal(QQN::NotificationLog()->MembershipLogId, $intMembershipLogId),
					$objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count NotificationLogs
		 * by MembershipLogId Index(es)
		 * @param integer $intMembershipLogId
		 * @return int
		*/
		public static function CountByMembershipLogId($intMembershipLogId) {
			// Call NotificationLog::QueryCount to perform the CountByMembershipLogId query
			return NotificationLog::QueryCount(
				QQ::Equal(QQN::NotificationLog()->MembershipLogId, $intMembershipLogId)
			);
		}



		////////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Array via Many to Many)
		////////////////////////////////////////////////////



		//////////////////
		// SAVE AND DELETE
		//////////////////

		/**
		 * Save this NotificationLog
		 * @param bool $blnForceInsert
		 * @param bool $blnForceUpdate
		 * @return int
		*/
		public function Save($blnForceInsert = false, $blnForceUpdate = false) {
			// Get the Database Object for this Class
			$objDatabase = NotificationLog::GetDatabase();

			$mixToReturn = null;

			try {
				if ((!$this->__blnRestored) || ($blnForceInsert)) {
					// Perform an INSERT query
					$objDatabase->NonQuery('
						INSERT INTO `NotificationLog` (
							`MemberId`,
							`NotificationType`,
							`NotificationDate`,
							`NotificationSubject`,
							`NotificationBody`,
							`MembershipLogId`,
							`NotificationConfirmed`
						) VALUES (
							' . $objDatabase->SqlVariable($this->intMemberId) . ',
							' . $objDatabase->SqlVariable($this->intNotificationType) . ',
							' . $objDatabase->SqlVariable($this->dttNotificationDate) . ',
							' . $objDatabase->SqlVariable($this->strNotificationSubject) . ',
							' . $objDatabase->SqlVariable($this->strNotificationBody) . ',
							' . $objDatabase->SqlVariable($this->intMembershipLogId) . ',
							' . $objDatabase->SqlVariable($this->blnNotificationConfirmed) . '
						)
					');

					// Update Identity column and return its value
					$mixToReturn = $this->intId = $objDatabase->InsertId('NotificationLog', 'Id');
				} else {
					// Perform an UPDATE query

					// First checking for Optimistic Locking constraints (if applicable)

					// Perform the UPDATE query
					$objDatabase->NonQuery('
						UPDATE
							`NotificationLog`
						SET
							`MemberId` = ' . $objDatabase->SqlVariable($this->intMemberId) . ',
							`NotificationType` = ' . $objDatabase->SqlVariable($this->intNotificationType) . ',
							`NotificationDate` = ' . $objDatabase->SqlVariable($this->dttNotificationDate) . ',
							`NotificationSubject` = ' . $objDatabase->SqlVariable($this->strNotificationSubject) . ',
							`NotificationBody` = ' . $objDatabase->SqlVariable($this->strNotificationBody) . ',
							`MembershipLogId` = ' . $objDatabase->SqlVariable($this->intMembershipLogId) . ',
							`NotificationConfirmed` = ' . $objDatabase->SqlVariable($this->blnNotificationConfirmed) . '
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
		 * Delete this NotificationLog
		 * @return void
		*/
		public function Delete() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Cannot delete this NotificationLog with an unset primary key.');

			// Get the Database Object for this Class
			$objDatabase = NotificationLog::GetDatabase();


			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`NotificationLog`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($this->intId) . '');
		}

		/**
		 * Delete all NotificationLogs
		 * @return void
		*/
		public static function DeleteAll() {
			// Get the Database Object for this Class
			$objDatabase = NotificationLog::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				DELETE FROM
					`NotificationLog`');
		}

		/**
		 * Truncate NotificationLog table
		 * @return void
		*/
		public static function Truncate() {
			// Get the Database Object for this Class
			$objDatabase = NotificationLog::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				TRUNCATE `NotificationLog`');
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

				case 'MemberId':
					/**
					 * Gets the value for intMemberId (Not Null)
					 * @return integer
					 */
					return $this->intMemberId;

				case 'NotificationType':
					/**
					 * Gets the value for intNotificationType (Not Null)
					 * @return integer
					 */
					return $this->intNotificationType;

				case 'NotificationDate':
					/**
					 * Gets the value for dttNotificationDate 
					 * @return QDateTime
					 */
					return $this->dttNotificationDate;

				case 'NotificationSubject':
					/**
					 * Gets the value for strNotificationSubject 
					 * @return string
					 */
					return $this->strNotificationSubject;

				case 'NotificationBody':
					/**
					 * Gets the value for strNotificationBody 
					 * @return string
					 */
					return $this->strNotificationBody;

				case 'MembershipLogId':
					/**
					 * Gets the value for intMembershipLogId 
					 * @return integer
					 */
					return $this->intMembershipLogId;

				case 'NotificationConfirmed':
					/**
					 * Gets the value for blnNotificationConfirmed 
					 * @return boolean
					 */
					return $this->blnNotificationConfirmed;


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

				case 'MembershipLogIdObject':
					/**
					 * Gets the value for the MembershipLog object referenced by intMembershipLogId 
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

				case 'NotificationType':
					/**
					 * Sets the value for intNotificationType (Not Null)
					 * @param integer $mixValue
					 * @return integer
					 */
					try {
						return ($this->intNotificationType = QType::Cast($mixValue, QType::Integer));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'NotificationDate':
					/**
					 * Sets the value for dttNotificationDate 
					 * @param QDateTime $mixValue
					 * @return QDateTime
					 */
					try {
						return ($this->dttNotificationDate = QType::Cast($mixValue, QType::DateTime));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'NotificationSubject':
					/**
					 * Sets the value for strNotificationSubject 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strNotificationSubject = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'NotificationBody':
					/**
					 * Sets the value for strNotificationBody 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strNotificationBody = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'MembershipLogId':
					/**
					 * Sets the value for intMembershipLogId 
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

				case 'NotificationConfirmed':
					/**
					 * Sets the value for blnNotificationConfirmed 
					 * @param boolean $mixValue
					 * @return boolean
					 */
					try {
						return ($this->blnNotificationConfirmed = QType::Cast($mixValue, QType::Boolean));
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
							throw new QCallerException('Unable to set an unsaved MemberIdObject for this NotificationLog');

						// Update Local Member Variables
						$this->objMemberIdObject = $mixValue;
						$this->intMemberId = $mixValue->Id;

						// Return $mixValue
						return $mixValue;
					}
					break;

				case 'MembershipLogIdObject':
					/**
					 * Sets the value for the MembershipLog object referenced by intMembershipLogId 
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
							throw new QCallerException('Unable to set an unsaved MembershipLogIdObject for this NotificationLog');

						// Update Local Member Variables
						$this->objMembershipLogIdObject = $mixValue;
						$this->intMembershipLogId = $mixValue->Id;

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
		 * Protected member variable that maps to the database PK Identity column NotificationLog.Id
		 * @var integer intId
		 */
		protected $intId;
		const IdDefault = null;


		/**
		 * Protected member variable that maps to the database column NotificationLog.MemberId
		 * @var integer intMemberId
		 */
		protected $intMemberId;
		const MemberIdDefault = null;


		/**
		 * Protected member variable that maps to the database column NotificationLog.NotificationType
		 * @var integer intNotificationType
		 */
		protected $intNotificationType;
		const NotificationTypeDefault = null;


		/**
		 * Protected member variable that maps to the database column NotificationLog.NotificationDate
		 * @var QDateTime dttNotificationDate
		 */
		protected $dttNotificationDate;
		const NotificationDateDefault = null;


		/**
		 * Protected member variable that maps to the database column NotificationLog.NotificationSubject
		 * @var string strNotificationSubject
		 */
		protected $strNotificationSubject;
		const NotificationSubjectMaxLength = 255;
		const NotificationSubjectDefault = null;


		/**
		 * Protected member variable that maps to the database column NotificationLog.NotificationBody
		 * @var string strNotificationBody
		 */
		protected $strNotificationBody;
		const NotificationBodyDefault = null;


		/**
		 * Protected member variable that maps to the database column NotificationLog.MembershipLogId
		 * @var integer intMembershipLogId
		 */
		protected $intMembershipLogId;
		const MembershipLogIdDefault = null;


		/**
		 * Protected member variable that maps to the database column NotificationLog.NotificationConfirmed
		 * @var boolean blnNotificationConfirmed
		 */
		protected $blnNotificationConfirmed;
		const NotificationConfirmedDefault = null;


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
		 * in the database column NotificationLog.MemberId.
		 *
		 * NOTE: Always use the MemberIdObject property getter to correctly retrieve this MemberContact object.
		 * (Because this class implements late binding, this variable reference MAY be null.)
		 * @var MemberContact objMemberIdObject
		 */
		protected $objMemberIdObject;

		/**
		 * Protected member variable that contains the object pointed by the reference
		 * in the database column NotificationLog.MembershipLogId.
		 *
		 * NOTE: Always use the MembershipLogIdObject property getter to correctly retrieve this MembershipLog object.
		 * (Because this class implements late binding, this variable reference MAY be null.)
		 * @var MembershipLog objMembershipLogIdObject
		 */
		protected $objMembershipLogIdObject;






		////////////////////////////////////////
		// METHODS for WEB SERVICES
		////////////////////////////////////////

		public static function GetSoapComplexTypeXml() {
			$strToReturn = '<complexType name="NotificationLog"><sequence>';
			$strToReturn .= '<element name="Id" type="xsd:int"/>';
			$strToReturn .= '<element name="MemberIdObject" type="xsd1:MemberContact"/>';
			$strToReturn .= '<element name="NotificationType" type="xsd:int"/>';
			$strToReturn .= '<element name="NotificationDate" type="xsd:dateTime"/>';
			$strToReturn .= '<element name="NotificationSubject" type="xsd:string"/>';
			$strToReturn .= '<element name="NotificationBody" type="xsd:string"/>';
			$strToReturn .= '<element name="MembershipLogIdObject" type="xsd1:MembershipLog"/>';
			$strToReturn .= '<element name="NotificationConfirmed" type="xsd:boolean"/>';
			$strToReturn .= '<element name="__blnRestored" type="xsd:boolean"/>';
			$strToReturn .= '</sequence></complexType>';
			return $strToReturn;
		}

		public static function AlterSoapComplexTypeArray(&$strComplexTypeArray) {
			if (!array_key_exists('NotificationLog', $strComplexTypeArray)) {
				$strComplexTypeArray['NotificationLog'] = NotificationLog::GetSoapComplexTypeXml();
				MemberContact::AlterSoapComplexTypeArray($strComplexTypeArray);
				MembershipLog::AlterSoapComplexTypeArray($strComplexTypeArray);
			}
		}

		public static function GetArrayFromSoapArray($objSoapArray) {
			$objArrayToReturn = array();

			foreach ($objSoapArray as $objSoapObject)
				array_push($objArrayToReturn, NotificationLog::GetObjectFromSoapObject($objSoapObject));

			return $objArrayToReturn;
		}

		public static function GetObjectFromSoapObject($objSoapObject) {
			$objToReturn = new NotificationLog();
			if (property_exists($objSoapObject, 'Id'))
				$objToReturn->intId = $objSoapObject->Id;
			if ((property_exists($objSoapObject, 'MemberIdObject')) &&
				($objSoapObject->MemberIdObject))
				$objToReturn->MemberIdObject = MemberContact::GetObjectFromSoapObject($objSoapObject->MemberIdObject);
			if (property_exists($objSoapObject, 'NotificationType'))
				$objToReturn->intNotificationType = $objSoapObject->NotificationType;
			if (property_exists($objSoapObject, 'NotificationDate'))
				$objToReturn->dttNotificationDate = new QDateTime($objSoapObject->NotificationDate);
			if (property_exists($objSoapObject, 'NotificationSubject'))
				$objToReturn->strNotificationSubject = $objSoapObject->NotificationSubject;
			if (property_exists($objSoapObject, 'NotificationBody'))
				$objToReturn->strNotificationBody = $objSoapObject->NotificationBody;
			if ((property_exists($objSoapObject, 'MembershipLogIdObject')) &&
				($objSoapObject->MembershipLogIdObject))
				$objToReturn->MembershipLogIdObject = MembershipLog::GetObjectFromSoapObject($objSoapObject->MembershipLogIdObject);
			if (property_exists($objSoapObject, 'NotificationConfirmed'))
				$objToReturn->blnNotificationConfirmed = $objSoapObject->NotificationConfirmed;
			if (property_exists($objSoapObject, '__blnRestored'))
				$objToReturn->__blnRestored = $objSoapObject->__blnRestored;
			return $objToReturn;
		}

		public static function GetSoapArrayFromArray($objArray) {
			if (!$objArray)
				return null;

			$objArrayToReturn = array();

			foreach ($objArray as $objObject)
				array_push($objArrayToReturn, NotificationLog::GetSoapObjectFromObject($objObject, true));

			return unserialize(serialize($objArrayToReturn ?? '') ?? '');
		}

		public static function GetSoapObjectFromObject($objObject, $blnBindRelatedObjects) {
			if ($objObject->objMemberIdObject)
				$objObject->objMemberIdObject = MemberContact::GetSoapObjectFromObject($objObject->objMemberIdObject, false);
			else if (!$blnBindRelatedObjects)
				$objObject->intMemberId = null;
			if ($objObject->dttNotificationDate)
				$objObject->dttNotificationDate = $objObject->dttNotificationDate->toString(QDateTime::FormatSoap);
			if ($objObject->objMembershipLogIdObject)
				$objObject->objMembershipLogIdObject = MembershipLog::GetSoapObjectFromObject($objObject->objMembershipLogIdObject, false);
			else if (!$blnBindRelatedObjects)
				$objObject->intMembershipLogId = null;
			return $objObject;
		}
	}





	/////////////////////////////////////
	// ADDITIONAL CLASSES for QCODO QUERY
	/////////////////////////////////////

	class QQNodeNotificationLog extends QQNode {
		protected $strTableName = 'NotificationLog';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'NotificationLog';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'MemberId':
					return new QQNode('MemberId', 'integer', $this);
				case 'MemberIdObject':
					return new QQNodeMemberContact('MemberId', 'integer', $this);
				case 'NotificationType':
					return new QQNode('NotificationType', 'integer', $this);
				case 'NotificationDate':
					return new QQNode('NotificationDate', 'QDateTime', $this);
				case 'NotificationSubject':
					return new QQNode('NotificationSubject', 'string', $this);
				case 'NotificationBody':
					return new QQNode('NotificationBody', 'string', $this);
				case 'MembershipLogId':
					return new QQNode('MembershipLogId', 'integer', $this);
				case 'MembershipLogIdObject':
					return new QQNodeMembershipLog('MembershipLogId', 'integer', $this);
				case 'NotificationConfirmed':
					return new QQNode('NotificationConfirmed', 'boolean', $this);

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

	class QQReverseReferenceNodeNotificationLog extends QQReverseReferenceNode {
		protected $strTableName = 'NotificationLog';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'NotificationLog';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'MemberId':
					return new QQNode('MemberId', 'integer', $this);
				case 'MemberIdObject':
					return new QQNodeMemberContact('MemberId', 'integer', $this);
				case 'NotificationType':
					return new QQNode('NotificationType', 'integer', $this);
				case 'NotificationDate':
					return new QQNode('NotificationDate', 'QDateTime', $this);
				case 'NotificationSubject':
					return new QQNode('NotificationSubject', 'string', $this);
				case 'NotificationBody':
					return new QQNode('NotificationBody', 'string', $this);
				case 'MembershipLogId':
					return new QQNode('MembershipLogId', 'integer', $this);
				case 'MembershipLogIdObject':
					return new QQNodeMembershipLog('MembershipLogId', 'integer', $this);
				case 'NotificationConfirmed':
					return new QQNode('NotificationConfirmed', 'boolean', $this);

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