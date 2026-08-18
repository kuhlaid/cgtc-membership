<?php
	/**
	 * The abstract MembershipLogGen class defined here is
	 * code-generated and contains all the basic CRUD-type functionality as well as
	 * basic methods to handle relationships and index-based loading.
	 *
	 * To use, you should use the MembershipLog subclass which
	 * extends this MembershipLogGen class.
	 *
	 * Because subsequent re-code generations will overwrite any changes to this
	 * file, you should leave this file unaltered to prevent yourself from losing
	 * any information or code changes.  All customizations should be done by
	 * overriding existing or implementing new methods, properties and variables
	 * in the MembershipLog class.
	 * 
	 * @package My Application
	 * @subpackage GeneratedDataObjects
	 * 
	 */
	class MembershipLogGen extends QBaseClass {
		///////////////////////////////
		// COMMON LOAD METHODS
		///////////////////////////////

		/**
		 * Load a MembershipLog from PK Info
		 * @param integer $intId
		 * @return MembershipLog
		 */
		public static function Load($intId) {
			// Use QuerySingle to Perform the Query
			return MembershipLog::QuerySingle(
				QQ::Equal(QQN::MembershipLog()->Id, $intId)
			);
		}

		/**
		 * Load all MembershipLogs
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return MembershipLog[]
		 */
		public static function LoadAll($objOptionalClauses = null) {
			// Call MembershipLog::QueryArray to perform the LoadAll query
			try {
				return MembershipLog::QueryArray(QQ::All(), $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count all MembershipLogs
		 * @return int
		 */
		public static function CountAll() {
			// Call MembershipLog::QueryCount to perform the CountAll query
			return MembershipLog::QueryCount(QQ::All());
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
			$objDatabase = MembershipLog::GetDatabase();

			// Create/Build out the QueryBuilder object with MembershipLog-specific SELET and FROM fields
			$objQueryBuilder = new QQueryBuilder($objDatabase, 'MembershipLog');
			MembershipLog::GetSelectFields($objQueryBuilder,null,$selectionArray);
			$objQueryBuilder->AddFromItem('`MembershipLog` AS `MembershipLog`');

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
		 * Static Qcodo Query method to query for a single MembershipLog object.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return MembershipLog the queried object
		 */
		public static function QuerySingle(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = MembershipLog::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query, Get the First Row, and Instantiate a new MembershipLog object
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return MembershipLog::InstantiateDbRow($objDbResult->GetNextRow());
		}

		/**
		 * Static Qcodo Query method to query for an array of MembershipLog objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return MembershipLog[] the queried objects as an array
		 */
		public static function QueryArray(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = MembershipLog::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query and Instantiate the Array Result
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return MembershipLog::InstantiateDbResult($objDbResult, $objQueryBuilder->ExpandAsArrayNodes);
		}

		/**
		 * Static Qcodo Query method to query for a count of MembershipLog objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return integer the count of queried objects as an integer
		 */
		public static function QueryCount(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = MembershipLog::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, true,$selectionArray);
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
			$objDatabase = MembershipLog::GetDatabase();

			// Lookup the QCache for This Query Statement
			$objCache = new QCache('query', 'MembershipLog_' . serialize($strConditions));
			if (!($strQuery = $objCache->GetData())) {
				// Not Found -- Go ahead and Create/Build out a new QueryBuilder object with MembershipLog-specific fields
				$objQueryBuilder = new QQueryBuilder($objDatabase);
				MembershipLog::GetSelectFields($objQueryBuilder);
				MembershipLog::GetFromFields($objQueryBuilder);

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
			return MembershipLog::InstantiateDbResult($objDbResult);
		}*/

		/**
		 * Updates a QQueryBuilder with the SELECT fields for this MembershipLog
		 * @param QQueryBuilder $objBuilder the Query Builder object to update
		 * @param string $strPrefix optional prefix to add to the SELECT fields
		 * @param array $selectionArray optional array of SELECT field items (wpg - added Sept 2012)
		 */
		public static function GetSelectFields(QQueryBuilder $objBuilder, $strPrefix = null, $selectionArray = null) {
			if ($strPrefix) {
				$strTableName = '`' . $strPrefix . '`';
				$strAliasPrefix = '`' . $strPrefix . '__';
			} else {
				$strTableName = '`MembershipLog`';
				$strAliasPrefix = '`';
			}

			// wpg - if we are not passing in an array of participant fields we want then get them all
			if (!$selectionArray){
				$objBuilder->AddSelectItem($strTableName . '.`Id` AS ' . $strAliasPrefix . 'Id`');
				$objBuilder->AddSelectItem($strTableName . '.`LogType` AS ' . $strAliasPrefix . 'LogType`');
				$objBuilder->AddSelectItem($strTableName . '.`StartDate` AS ' . $strAliasPrefix . 'StartDate`');
				$objBuilder->AddSelectItem($strTableName . '.`ExpireDate` AS ' . $strAliasPrefix . 'ExpireDate`');
				$objBuilder->AddSelectItem($strTableName . '.`PaymentType` AS ' . $strAliasPrefix . 'PaymentType`');
				$objBuilder->AddSelectItem($strTableName . '.`PaymentAmount` AS ' . $strAliasPrefix . 'PaymentAmount`');
				$objBuilder->AddSelectItem($strTableName . '.`PaidOn` AS ' . $strAliasPrefix . 'PaidOn`');
				$objBuilder->AddSelectItem($strTableName . '.`Note` AS ' . $strAliasPrefix . 'Note`');
				$objBuilder->AddSelectItem($strTableName . '.`MemberId` AS ' . $strAliasPrefix . 'MemberId`');
				$objBuilder->AddSelectItem($strTableName . '.`transferId` AS ' . $strAliasPrefix . 'transferId`');
				$objBuilder->AddSelectItem($strTableName . '.`LogDate` AS ' . $strAliasPrefix . 'LogDate`');
				$objBuilder->AddSelectItem($strTableName . '.`NewMembership` AS ' . $strAliasPrefix . 'NewMembership`');
				$objBuilder->AddSelectItem($strTableName . '.`MedTrainingType` AS ' . $strAliasPrefix . 'MedTrainingType`');
				$objBuilder->AddSelectItem($strTableName . '.`WillingMedVolunteer` AS ' . $strAliasPrefix . 'WillingMedVolunteer`');
				$objBuilder->AddSelectItem($strTableName . '.`PayPalTransactionId` AS ' . $strAliasPrefix . 'PayPalTransactionId`');
				$objBuilder->AddSelectItem($strTableName . '.`MembershipConsent` AS ' . $strAliasPrefix . 'MembershipConsent`');
				$objBuilder->AddSelectItem($strTableName . '.`ConsentSignature` AS ' . $strAliasPrefix . 'ConsentSignature`');
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
		 * Instantiate a MembershipLog from a Database Row.
		 * Takes in an optional strAliasPrefix, used in case another Object::InstantiateDbRow
		 * is calling this MembershipLog::InstantiateDbRow in order to perform
		 * early binding on referenced objects.
		 * @param DatabaseRowBase $objDbRow
		 * @param string $strAliasPrefix
		 * @return MembershipLog
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
					$strAliasPrefix = 'MembershipLog__';


				if ((array_key_exists($strAliasPrefix . 'familymemberassocasid__Id', $strExpandAsArrayNodes)) &&
					(!is_null($objDbRow->GetColumn($strAliasPrefix . 'familymemberassocasid__Id')))) {
					if ($intPreviousChildItemCount = count($objPreviousItem->_objFamilyMemberAssocAsIdArray)) {
						$objPreviousChildItem = $objPreviousItem->_objFamilyMemberAssocAsIdArray[$intPreviousChildItemCount - 1];
						$objChildItem = FamilyMemberAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'familymemberassocasid__', $strExpandAsArrayNodes, $objPreviousChildItem);
						if ($objChildItem)
							array_push($objPreviousItem->_objFamilyMemberAssocAsIdArray, $objChildItem);
					} else
						array_push($objPreviousItem->_objFamilyMemberAssocAsIdArray, FamilyMemberAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'familymemberassocasid__', $strExpandAsArrayNodes));
					$blnExpandedViaArray = true;
				}

				if ((array_key_exists($strAliasPrefix . 'membershipassocasid__Id', $strExpandAsArrayNodes)) &&
					(!is_null($objDbRow->GetColumn($strAliasPrefix . 'membershipassocasid__Id')))) {
					if ($intPreviousChildItemCount = count($objPreviousItem->_objMembershipAssocAsIdArray)) {
						$objPreviousChildItem = $objPreviousItem->_objMembershipAssocAsIdArray[$intPreviousChildItemCount - 1];
						$objChildItem = MembershipAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membershipassocasid__', $strExpandAsArrayNodes, $objPreviousChildItem);
						if ($objChildItem)
							array_push($objPreviousItem->_objMembershipAssocAsIdArray, $objChildItem);
					} else
						array_push($objPreviousItem->_objMembershipAssocAsIdArray, MembershipAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membershipassocasid__', $strExpandAsArrayNodes));
					$blnExpandedViaArray = true;
				}

				if ((array_key_exists($strAliasPrefix . 'notificationlogasid__Id', $strExpandAsArrayNodes)) &&
					(!is_null($objDbRow->GetColumn($strAliasPrefix . 'notificationlogasid__Id')))) {
					if ($intPreviousChildItemCount = count($objPreviousItem->_objNotificationLogAsIdArray)) {
						$objPreviousChildItem = $objPreviousItem->_objNotificationLogAsIdArray[$intPreviousChildItemCount - 1];
						$objChildItem = NotificationLog::InstantiateDbRow($objDbRow, $strAliasPrefix . 'notificationlogasid__', $strExpandAsArrayNodes, $objPreviousChildItem);
						if ($objChildItem)
							array_push($objPreviousItem->_objNotificationLogAsIdArray, $objChildItem);
					} else
						array_push($objPreviousItem->_objNotificationLogAsIdArray, NotificationLog::InstantiateDbRow($objDbRow, $strAliasPrefix . 'notificationlogasid__', $strExpandAsArrayNodes));
					$blnExpandedViaArray = true;
				}

				// Either return false to signal array expansion, or check-to-reset the Alias prefix and move on
				if ($blnExpandedViaArray)
					return false;
				else if ($strAliasPrefix == 'MembershipLog__')
					$strAliasPrefix = null;
			}

			// Create a new instance of the MembershipLog object
			$objToReturn = new MembershipLog();
			$objToReturn->__blnRestored = true;

			$objToReturn->intId = $objDbRow->GetColumn($strAliasPrefix . 'Id', 'Integer');
			$objToReturn->intLogType = $objDbRow->GetColumn($strAliasPrefix . 'LogType', 'Integer');
			$objToReturn->dttStartDate = $objDbRow->GetColumn($strAliasPrefix . 'StartDate', 'Date');
			$objToReturn->dttExpireDate = $objDbRow->GetColumn($strAliasPrefix . 'ExpireDate', 'Date');
			$objToReturn->intPaymentType = $objDbRow->GetColumn($strAliasPrefix . 'PaymentType', 'Integer');
			$objToReturn->fltPaymentAmount = $objDbRow->GetColumn($strAliasPrefix . 'PaymentAmount', 'Float');
			$objToReturn->dttPaidOn = $objDbRow->GetColumn($strAliasPrefix . 'PaidOn', 'Date');
			$objToReturn->strNote = $objDbRow->GetColumn($strAliasPrefix . 'Note', 'VarChar');
			$objToReturn->intMemberId = $objDbRow->GetColumn($strAliasPrefix . 'MemberId', 'Integer');
			$objToReturn->intTransferId = $objDbRow->GetColumn($strAliasPrefix . 'transferId', 'Integer');
			$objToReturn->dttLogDate = $objDbRow->GetColumn($strAliasPrefix . 'LogDate', 'Date');
			$objToReturn->blnNewMembership = $objDbRow->GetColumn($strAliasPrefix . 'NewMembership', 'Bit');
			$objToReturn->intMedTrainingType = $objDbRow->GetColumn($strAliasPrefix . 'MedTrainingType', 'Integer');
			$objToReturn->blnWillingMedVolunteer = $objDbRow->GetColumn($strAliasPrefix . 'WillingMedVolunteer', 'Bit');
			$objToReturn->strPayPalTransactionId = $objDbRow->GetColumn($strAliasPrefix . 'PayPalTransactionId', 'VarChar');
			$objToReturn->dttMembershipConsent = $objDbRow->GetColumn($strAliasPrefix . 'MembershipConsent', 'DateTime');
			$objToReturn->strConsentSignature = $objDbRow->GetColumn($strAliasPrefix . 'ConsentSignature', 'VarChar');

			// Instantiate Virtual Attributes
			foreach ($objDbRow->GetColumnNameArray() as $strColumnName => $mixValue) {
				$strVirtualPrefix = $strAliasPrefix . '__';
				$strVirtualPrefixLength = strlen($strVirtualPrefix ?? '');
				if (substr($strColumnName, 0, $strVirtualPrefixLength) == $strVirtualPrefix)
					$objToReturn->__strVirtualAttributeArray[substr($strColumnName, $strVirtualPrefixLength)] = $mixValue;
			}

			// Prepare to Check for Early/Virtual Binding
			if (!$strAliasPrefix)
				$strAliasPrefix = 'MembershipLog__';

			// Check for MemberIdObject Early Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'MemberId__Id')))
				$objToReturn->objMemberIdObject = MemberContact::InstantiateDbRow($objDbRow, $strAliasPrefix . 'MemberId__', $strExpandAsArrayNodes);




			// Check for FamilyMemberAssocAsId Virtual Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'familymemberassocasid__Id'))) {
				if (($strExpandAsArrayNodes) && (array_key_exists($strAliasPrefix . 'familymemberassocasid__Id', $strExpandAsArrayNodes)))
					array_push($objToReturn->_objFamilyMemberAssocAsIdArray, FamilyMemberAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'familymemberassocasid__', $strExpandAsArrayNodes));
				else
					$objToReturn->_objFamilyMemberAssocAsId = FamilyMemberAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'familymemberassocasid__', $strExpandAsArrayNodes);
			}

			// Check for MembershipAssocAsId Virtual Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'membershipassocasid__Id'))) {
				if (($strExpandAsArrayNodes) && (array_key_exists($strAliasPrefix . 'membershipassocasid__Id', $strExpandAsArrayNodes)))
					array_push($objToReturn->_objMembershipAssocAsIdArray, MembershipAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membershipassocasid__', $strExpandAsArrayNodes));
				else
					$objToReturn->_objMembershipAssocAsId = MembershipAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membershipassocasid__', $strExpandAsArrayNodes);
			}

			// Check for NotificationLogAsId Virtual Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'notificationlogasid__Id'))) {
				if (($strExpandAsArrayNodes) && (array_key_exists($strAliasPrefix . 'notificationlogasid__Id', $strExpandAsArrayNodes)))
					array_push($objToReturn->_objNotificationLogAsIdArray, NotificationLog::InstantiateDbRow($objDbRow, $strAliasPrefix . 'notificationlogasid__', $strExpandAsArrayNodes));
				else
					$objToReturn->_objNotificationLogAsId = NotificationLog::InstantiateDbRow($objDbRow, $strAliasPrefix . 'notificationlogasid__', $strExpandAsArrayNodes);
			}

			return $objToReturn;
		}

		/**
		 * Instantiate an array of MembershipLogs from a Database Result
		 * @param DatabaseResultBase $objDbResult
		 * @return MembershipLog[]
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
					$objItem = MembershipLog::InstantiateDbRow($objDbRow, null, $strExpandAsArrayNodes, $objLastRowItem);
					if ($objItem) {
						array_push($objToReturn, $objItem);
						$objLastRowItem = $objItem;
					}
				}
			} else {
				while ($objDbRow = $objDbResult->GetNextRow())
					array_push($objToReturn, MembershipLog::InstantiateDbRow($objDbRow));
			}

			return $objToReturn;
		}



		///////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Single Load and Array)
		///////////////////////////////////////////////////
			
		/**
		 * Load a single MembershipLog object,
		 * by Id Index(es)
		 * @param integer $intId
		 * @return MembershipLog
		*/
		public static function LoadById($intId) {
			return MembershipLog::QuerySingle(
				QQ::Equal(QQN::MembershipLog()->Id, $intId)
			);
		}
			
		/**
		 * Load an array of MembershipLog objects,
		 * by MemberId Index(es)
		 * @param integer $intMemberId
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return MembershipLog[]
		*/
		public static function LoadArrayByMemberId($intMemberId, $objOptionalClauses = null) {
			// Call MembershipLog::QueryArray to perform the LoadArrayByMemberId query
			try {
				return MembershipLog::QueryArray(
					QQ::Equal(QQN::MembershipLog()->MemberId, $intMemberId),
					$objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count MembershipLogs
		 * by MemberId Index(es)
		 * @param integer $intMemberId
		 * @return int
		*/
		public static function CountByMemberId($intMemberId) {
			// Call MembershipLog::QueryCount to perform the CountByMemberId query
			return MembershipLog::QueryCount(
				QQ::Equal(QQN::MembershipLog()->MemberId, $intMemberId)
			);
		}



		////////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Array via Many to Many)
		////////////////////////////////////////////////////



		//////////////////
		// SAVE AND DELETE
		//////////////////

		/**
		 * Save this MembershipLog
		 * @param bool $blnForceInsert
		 * @param bool $blnForceUpdate
		 * @return int
		*/
		public function Save($blnForceInsert = false, $blnForceUpdate = false) {
			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();

			$mixToReturn = null;

			try {
				if ((!$this->__blnRestored) || ($blnForceInsert)) {
					// Perform an INSERT query
					$objDatabase->NonQuery('
						INSERT INTO `MembershipLog` (
							`LogType`,
							`StartDate`,
							`ExpireDate`,
							`PaymentType`,
							`PaymentAmount`,
							`PaidOn`,
							`Note`,
							`MemberId`,
							`transferId`,
							`LogDate`,
							`NewMembership`,
							`MedTrainingType`,
							`WillingMedVolunteer`,
							`PayPalTransactionId`,
							`MembershipConsent`,
							`ConsentSignature`
						) VALUES (
							' . $objDatabase->SqlVariable($this->intLogType) . ',
							' . $objDatabase->SqlVariable($this->dttStartDate) . ',
							' . $objDatabase->SqlVariable($this->dttExpireDate) . ',
							' . $objDatabase->SqlVariable($this->intPaymentType) . ',
							' . $objDatabase->SqlVariable($this->fltPaymentAmount) . ',
							' . $objDatabase->SqlVariable($this->dttPaidOn) . ',
							' . $objDatabase->SqlVariable($this->strNote) . ',
							' . $objDatabase->SqlVariable($this->intMemberId) . ',
							' . $objDatabase->SqlVariable($this->intTransferId) . ',
							' . $objDatabase->SqlVariable($this->dttLogDate) . ',
							' . $objDatabase->SqlVariable($this->blnNewMembership) . ',
							' . $objDatabase->SqlVariable($this->intMedTrainingType) . ',
							' . $objDatabase->SqlVariable($this->blnWillingMedVolunteer) . ',
							' . $objDatabase->SqlVariable($this->strPayPalTransactionId) . ',
							' . $objDatabase->SqlVariable($this->dttMembershipConsent) . ',
							' . $objDatabase->SqlVariable($this->strConsentSignature) . '
						)
					');

					// Update Identity column and return its value
					$mixToReturn = $this->intId = $objDatabase->InsertId('MembershipLog', 'Id');
				} else {
					// Perform an UPDATE query

					// First checking for Optimistic Locking constraints (if applicable)

					// Perform the UPDATE query
					$objDatabase->NonQuery('
						UPDATE
							`MembershipLog`
						SET
							`LogType` = ' . $objDatabase->SqlVariable($this->intLogType) . ',
							`StartDate` = ' . $objDatabase->SqlVariable($this->dttStartDate) . ',
							`ExpireDate` = ' . $objDatabase->SqlVariable($this->dttExpireDate) . ',
							`PaymentType` = ' . $objDatabase->SqlVariable($this->intPaymentType) . ',
							`PaymentAmount` = ' . $objDatabase->SqlVariable($this->fltPaymentAmount) . ',
							`PaidOn` = ' . $objDatabase->SqlVariable($this->dttPaidOn) . ',
							`Note` = ' . $objDatabase->SqlVariable($this->strNote) . ',
							`MemberId` = ' . $objDatabase->SqlVariable($this->intMemberId) . ',
							`transferId` = ' . $objDatabase->SqlVariable($this->intTransferId) . ',
							`LogDate` = ' . $objDatabase->SqlVariable($this->dttLogDate) . ',
							`NewMembership` = ' . $objDatabase->SqlVariable($this->blnNewMembership) . ',
							`MedTrainingType` = ' . $objDatabase->SqlVariable($this->intMedTrainingType) . ',
							`WillingMedVolunteer` = ' . $objDatabase->SqlVariable($this->blnWillingMedVolunteer) . ',
							`PayPalTransactionId` = ' . $objDatabase->SqlVariable($this->strPayPalTransactionId) . ',
							`MembershipConsent` = ' . $objDatabase->SqlVariable($this->dttMembershipConsent) . ',
							`ConsentSignature` = ' . $objDatabase->SqlVariable($this->strConsentSignature) . '
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
		 * Delete this MembershipLog
		 * @return void
		*/
		public function Delete() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Cannot delete this MembershipLog with an unset primary key.');

			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();


			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MembershipLog`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($this->intId) . '');
		}

		/**
		 * Delete all MembershipLogs
		 * @return void
		*/
		public static function DeleteAll() {
			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MembershipLog`');
		}

		/**
		 * Truncate MembershipLog table
		 * @return void
		*/
		public static function Truncate() {
			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				TRUNCATE `MembershipLog`');
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

				case 'LogType':
					/**
					 * Gets the value for intLogType 
					 * @return integer
					 */
					return $this->intLogType;

				case 'StartDate':
					/**
					 * Gets the value for dttStartDate 
					 * @return QDateTime
					 */
					return $this->dttStartDate;

				case 'ExpireDate':
					/**
					 * Gets the value for dttExpireDate 
					 * @return QDateTime
					 */
					return $this->dttExpireDate;

				case 'PaymentType':
					/**
					 * Gets the value for intPaymentType 
					 * @return integer
					 */
					return $this->intPaymentType;

				case 'PaymentAmount':
					/**
					 * Gets the value for fltPaymentAmount 
					 * @return double
					 */
					return $this->fltPaymentAmount;

				case 'PaidOn':
					/**
					 * Gets the value for dttPaidOn 
					 * @return QDateTime
					 */
					return $this->dttPaidOn;

				case 'Note':
					/**
					 * Gets the value for strNote 
					 * @return string
					 */
					return $this->strNote;

				case 'MemberId':
					/**
					 * Gets the value for intMemberId 
					 * @return integer
					 */
					return $this->intMemberId;

				case 'TransferId':
					/**
					 * Gets the value for intTransferId 
					 * @return integer
					 */
					return $this->intTransferId;

				case 'LogDate':
					/**
					 * Gets the value for dttLogDate 
					 * @return QDateTime
					 */
					return $this->dttLogDate;

				case 'NewMembership':
					/**
					 * Gets the value for blnNewMembership 
					 * @return boolean
					 */
					return $this->blnNewMembership;

				case 'MedTrainingType':
					/**
					 * Gets the value for intMedTrainingType 
					 * @return integer
					 */
					return $this->intMedTrainingType;

				case 'WillingMedVolunteer':
					/**
					 * Gets the value for blnWillingMedVolunteer 
					 * @return boolean
					 */
					return $this->blnWillingMedVolunteer;

				case 'PayPalTransactionId':
					/**
					 * Gets the value for strPayPalTransactionId 
					 * @return string
					 */
					return $this->strPayPalTransactionId;

				case 'MembershipConsent':
					/**
					 * Gets the value for dttMembershipConsent (Not Null)
					 * @return QDateTime
					 */
					return $this->dttMembershipConsent;

				case 'ConsentSignature':
					/**
					 * Gets the value for strConsentSignature (Not Null)
					 * @return string
					 */
					return $this->strConsentSignature;


				///////////////////
				// Member Objects
				///////////////////
				case 'MemberIdObject':
					/**
					 * Gets the value for the MemberContact object referenced by intMemberId 
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

				case '_FamilyMemberAssocAsId':
					/**
					 * Gets the value for the private _objFamilyMemberAssocAsId (Read-Only)
					 * if set due to an expansion on the FamilyMemberAssoc.MembershipLogId reverse relationship
					 * @return FamilyMemberAssoc
					 */
					return $this->_objFamilyMemberAssocAsId;

				case '_FamilyMemberAssocAsIdArray':
					/**
					 * Gets the value for the private _objFamilyMemberAssocAsIdArray (Read-Only)
					 * if set due to an ExpandAsArray on the FamilyMemberAssoc.MembershipLogId reverse relationship
					 * @return FamilyMemberAssoc[]
					 */
					return (array) $this->_objFamilyMemberAssocAsIdArray;

				case '_MembershipAssocAsId':
					/**
					 * Gets the value for the private _objMembershipAssocAsId (Read-Only)
					 * if set due to an expansion on the MembershipAssoc.MembershipLogId reverse relationship
					 * @return MembershipAssoc
					 */
					return $this->_objMembershipAssocAsId;

				case '_MembershipAssocAsIdArray':
					/**
					 * Gets the value for the private _objMembershipAssocAsIdArray (Read-Only)
					 * if set due to an ExpandAsArray on the MembershipAssoc.MembershipLogId reverse relationship
					 * @return MembershipAssoc[]
					 */
					return (array) $this->_objMembershipAssocAsIdArray;

				case '_NotificationLogAsId':
					/**
					 * Gets the value for the private _objNotificationLogAsId (Read-Only)
					 * if set due to an expansion on the NotificationLog.MembershipLogId reverse relationship
					 * @return NotificationLog
					 */
					return $this->_objNotificationLogAsId;

				case '_NotificationLogAsIdArray':
					/**
					 * Gets the value for the private _objNotificationLogAsIdArray (Read-Only)
					 * if set due to an ExpandAsArray on the NotificationLog.MembershipLogId reverse relationship
					 * @return NotificationLog[]
					 */
					return (array) $this->_objNotificationLogAsIdArray;

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
				case 'LogType':
					/**
					 * Sets the value for intLogType 
					 * @param integer $mixValue
					 * @return integer
					 */
					try {
						return ($this->intLogType = QType::Cast($mixValue, QType::Integer));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'StartDate':
					/**
					 * Sets the value for dttStartDate 
					 * @param QDateTime $mixValue
					 * @return QDateTime
					 */
					try {
						return ($this->dttStartDate = QType::Cast($mixValue, QType::DateTime));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'ExpireDate':
					/**
					 * Sets the value for dttExpireDate 
					 * @param QDateTime $mixValue
					 * @return QDateTime
					 */
					try {
						return ($this->dttExpireDate = QType::Cast($mixValue, QType::DateTime));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'PaymentType':
					/**
					 * Sets the value for intPaymentType 
					 * @param integer $mixValue
					 * @return integer
					 */
					try {
						return ($this->intPaymentType = QType::Cast($mixValue, QType::Integer));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'PaymentAmount':
					/**
					 * Sets the value for fltPaymentAmount 
					 * @param double $mixValue
					 * @return double
					 */
					try {
						return ($this->fltPaymentAmount = QType::Cast($mixValue, QType::Float));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'PaidOn':
					/**
					 * Sets the value for dttPaidOn 
					 * @param QDateTime $mixValue
					 * @return QDateTime
					 */
					try {
						return ($this->dttPaidOn = QType::Cast($mixValue, QType::DateTime));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'Note':
					/**
					 * Sets the value for strNote 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strNote = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'MemberId':
					/**
					 * Sets the value for intMemberId 
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

				case 'TransferId':
					/**
					 * Sets the value for intTransferId 
					 * @param integer $mixValue
					 * @return integer
					 */
					try {
						return ($this->intTransferId = QType::Cast($mixValue, QType::Integer));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'LogDate':
					/**
					 * Sets the value for dttLogDate 
					 * @param QDateTime $mixValue
					 * @return QDateTime
					 */
					try {
						return ($this->dttLogDate = QType::Cast($mixValue, QType::DateTime));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'NewMembership':
					/**
					 * Sets the value for blnNewMembership 
					 * @param boolean $mixValue
					 * @return boolean
					 */
					try {
						return ($this->blnNewMembership = QType::Cast($mixValue, QType::Boolean));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'MedTrainingType':
					/**
					 * Sets the value for intMedTrainingType 
					 * @param integer $mixValue
					 * @return integer
					 */
					try {
						return ($this->intMedTrainingType = QType::Cast($mixValue, QType::Integer));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'WillingMedVolunteer':
					/**
					 * Sets the value for blnWillingMedVolunteer 
					 * @param boolean $mixValue
					 * @return boolean
					 */
					try {
						return ($this->blnWillingMedVolunteer = QType::Cast($mixValue, QType::Boolean));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'PayPalTransactionId':
					/**
					 * Sets the value for strPayPalTransactionId 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strPayPalTransactionId = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'MembershipConsent':
					/**
					 * Sets the value for dttMembershipConsent (Not Null)
					 * @param QDateTime $mixValue
					 * @return QDateTime
					 */
					try {
						return ($this->dttMembershipConsent = QType::Cast($mixValue, QType::DateTime));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'ConsentSignature':
					/**
					 * Sets the value for strConsentSignature (Not Null)
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strConsentSignature = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}


				///////////////////
				// Member Objects
				///////////////////
				case 'MemberIdObject':
					/**
					 * Sets the value for the MemberContact object referenced by intMemberId 
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
							throw new QCallerException('Unable to set an unsaved MemberIdObject for this MembershipLog');

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

			
		
		// Related Objects' Methods for FamilyMemberAssocAsId
		//-------------------------------------------------------------------

		/**
		 * Gets all associated FamilyMemberAssocsAsId as an array of FamilyMemberAssoc objects
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return FamilyMemberAssoc[]
		*/ 
		public function GetFamilyMemberAssocAsIdArray($objOptionalClauses = null) {
			if ((is_null($this->intId)))
				return array();

			try {
				return FamilyMemberAssoc::LoadArrayByMembershipLogId($this->intId, $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Counts all associated FamilyMemberAssocsAsId
		 * @return int
		*/ 
		public function CountFamilyMemberAssocsAsId() {
			if ((is_null($this->intId)))
				return 0;

			return FamilyMemberAssoc::CountByMembershipLogId($this->intId);
		}

		/**
		 * Associates a FamilyMemberAssocAsId
		 * @param FamilyMemberAssoc $objFamilyMemberAssoc
		 * @return void
		*/ 
		public function AssociateFamilyMemberAssocAsId(FamilyMemberAssoc $objFamilyMemberAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateFamilyMemberAssocAsId on this unsaved MembershipLog.');
			if ((is_null($objFamilyMemberAssoc->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateFamilyMemberAssocAsId on this MembershipLog with an unsaved FamilyMemberAssoc.');

			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`FamilyMemberAssoc`
				SET
					`MembershipLogId` = ' . $objDatabase->SqlVariable($this->intId) . '
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objFamilyMemberAssoc->Id) . '
			');
		}

		/**
		 * Unassociates a FamilyMemberAssocAsId
		 * @param FamilyMemberAssoc $objFamilyMemberAssoc
		 * @return void
		*/ 
		public function UnassociateFamilyMemberAssocAsId(FamilyMemberAssoc $objFamilyMemberAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateFamilyMemberAssocAsId on this unsaved MembershipLog.');
			if ((is_null($objFamilyMemberAssoc->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateFamilyMemberAssocAsId on this MembershipLog with an unsaved FamilyMemberAssoc.');

			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`FamilyMemberAssoc`
				SET
					`MembershipLogId` = null
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objFamilyMemberAssoc->Id) . ' AND
					`MembershipLogId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Unassociates all FamilyMemberAssocsAsId
		 * @return void
		*/ 
		public function UnassociateAllFamilyMemberAssocsAsId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateFamilyMemberAssocAsId on this unsaved MembershipLog.');

			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`FamilyMemberAssoc`
				SET
					`MembershipLogId` = null
				WHERE
					`MembershipLogId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes an associated FamilyMemberAssocAsId
		 * @param FamilyMemberAssoc $objFamilyMemberAssoc
		 * @return void
		*/ 
		public function DeleteAssociatedFamilyMemberAssocAsId(FamilyMemberAssoc $objFamilyMemberAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateFamilyMemberAssocAsId on this unsaved MembershipLog.');
			if ((is_null($objFamilyMemberAssoc->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateFamilyMemberAssocAsId on this MembershipLog with an unsaved FamilyMemberAssoc.');

			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`FamilyMemberAssoc`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objFamilyMemberAssoc->Id) . ' AND
					`MembershipLogId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes all associated FamilyMemberAssocsAsId
		 * @return void
		*/ 
		public function DeleteAllFamilyMemberAssocsAsId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateFamilyMemberAssocAsId on this unsaved MembershipLog.');

			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`FamilyMemberAssoc`
				WHERE
					`MembershipLogId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

			
		
		// Related Objects' Methods for MembershipAssocAsId
		//-------------------------------------------------------------------

		/**
		 * Gets all associated MembershipAssocsAsId as an array of MembershipAssoc objects
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return MembershipAssoc[]
		*/ 
		public function GetMembershipAssocAsIdArray($objOptionalClauses = null) {
			if ((is_null($this->intId)))
				return array();

			try {
				return MembershipAssoc::LoadArrayByMembershipLogId($this->intId, $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Counts all associated MembershipAssocsAsId
		 * @return int
		*/ 
		public function CountMembershipAssocsAsId() {
			if ((is_null($this->intId)))
				return 0;

			return MembershipAssoc::CountByMembershipLogId($this->intId);
		}

		/**
		 * Associates a MembershipAssocAsId
		 * @param MembershipAssoc $objMembershipAssoc
		 * @return void
		*/ 
		public function AssociateMembershipAssocAsId(MembershipAssoc $objMembershipAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateMembershipAssocAsId on this unsaved MembershipLog.');
			if ((is_null($objMembershipAssoc->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateMembershipAssocAsId on this MembershipLog with an unsaved MembershipAssoc.');

			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MembershipAssoc`
				SET
					`MembershipLogId` = ' . $objDatabase->SqlVariable($this->intId) . '
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMembershipAssoc->Id) . '
			');
		}

		/**
		 * Unassociates a MembershipAssocAsId
		 * @param MembershipAssoc $objMembershipAssoc
		 * @return void
		*/ 
		public function UnassociateMembershipAssocAsId(MembershipAssoc $objMembershipAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMembershipAssocAsId on this unsaved MembershipLog.');
			if ((is_null($objMembershipAssoc->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMembershipAssocAsId on this MembershipLog with an unsaved MembershipAssoc.');

			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MembershipAssoc`
				SET
					`MembershipLogId` = null
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMembershipAssoc->Id) . ' AND
					`MembershipLogId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Unassociates all MembershipAssocsAsId
		 * @return void
		*/ 
		public function UnassociateAllMembershipAssocsAsId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMembershipAssocAsId on this unsaved MembershipLog.');

			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MembershipAssoc`
				SET
					`MembershipLogId` = null
				WHERE
					`MembershipLogId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes an associated MembershipAssocAsId
		 * @param MembershipAssoc $objMembershipAssoc
		 * @return void
		*/ 
		public function DeleteAssociatedMembershipAssocAsId(MembershipAssoc $objMembershipAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMembershipAssocAsId on this unsaved MembershipLog.');
			if ((is_null($objMembershipAssoc->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMembershipAssocAsId on this MembershipLog with an unsaved MembershipAssoc.');

			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MembershipAssoc`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMembershipAssoc->Id) . ' AND
					`MembershipLogId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes all associated MembershipAssocsAsId
		 * @return void
		*/ 
		public function DeleteAllMembershipAssocsAsId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMembershipAssocAsId on this unsaved MembershipLog.');

			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MembershipAssoc`
				WHERE
					`MembershipLogId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

			
		
		// Related Objects' Methods for NotificationLogAsId
		//-------------------------------------------------------------------

		/**
		 * Gets all associated NotificationLogsAsId as an array of NotificationLog objects
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return NotificationLog[]
		*/ 
		public function GetNotificationLogAsIdArray($objOptionalClauses = null) {
			if ((is_null($this->intId)))
				return array();

			try {
				return NotificationLog::LoadArrayByMembershipLogId($this->intId, $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Counts all associated NotificationLogsAsId
		 * @return int
		*/ 
		public function CountNotificationLogsAsId() {
			if ((is_null($this->intId)))
				return 0;

			return NotificationLog::CountByMembershipLogId($this->intId);
		}

		/**
		 * Associates a NotificationLogAsId
		 * @param NotificationLog $objNotificationLog
		 * @return void
		*/ 
		public function AssociateNotificationLogAsId(NotificationLog $objNotificationLog) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateNotificationLogAsId on this unsaved MembershipLog.');
			if ((is_null($objNotificationLog->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateNotificationLogAsId on this MembershipLog with an unsaved NotificationLog.');

			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`NotificationLog`
				SET
					`MembershipLogId` = ' . $objDatabase->SqlVariable($this->intId) . '
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objNotificationLog->Id) . '
			');
		}

		/**
		 * Unassociates a NotificationLogAsId
		 * @param NotificationLog $objNotificationLog
		 * @return void
		*/ 
		public function UnassociateNotificationLogAsId(NotificationLog $objNotificationLog) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateNotificationLogAsId on this unsaved MembershipLog.');
			if ((is_null($objNotificationLog->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateNotificationLogAsId on this MembershipLog with an unsaved NotificationLog.');

			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`NotificationLog`
				SET
					`MembershipLogId` = null
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objNotificationLog->Id) . ' AND
					`MembershipLogId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Unassociates all NotificationLogsAsId
		 * @return void
		*/ 
		public function UnassociateAllNotificationLogsAsId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateNotificationLogAsId on this unsaved MembershipLog.');

			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`NotificationLog`
				SET
					`MembershipLogId` = null
				WHERE
					`MembershipLogId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes an associated NotificationLogAsId
		 * @param NotificationLog $objNotificationLog
		 * @return void
		*/ 
		public function DeleteAssociatedNotificationLogAsId(NotificationLog $objNotificationLog) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateNotificationLogAsId on this unsaved MembershipLog.');
			if ((is_null($objNotificationLog->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateNotificationLogAsId on this MembershipLog with an unsaved NotificationLog.');

			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`NotificationLog`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objNotificationLog->Id) . ' AND
					`MembershipLogId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes all associated NotificationLogsAsId
		 * @return void
		*/ 
		public function DeleteAllNotificationLogsAsId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateNotificationLogAsId on this unsaved MembershipLog.');

			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`NotificationLog`
				WHERE
					`MembershipLogId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}




		///////////////////////////////////////////////////////////////////////
		// PROTECTED MEMBER VARIABLES and TEXT FIELD MAXLENGTHS (if applicable)
		///////////////////////////////////////////////////////////////////////
		
		/**
		 * Protected member variable that maps to the database PK Identity column MembershipLog.Id
		 * @var integer intId
		 */
		protected $intId;
		const IdDefault = null;


		/**
		 * Protected member variable that maps to the database column MembershipLog.LogType
		 * @var integer intLogType
		 */
		protected $intLogType;
		const LogTypeDefault = null;


		/**
		 * Protected member variable that maps to the database column MembershipLog.StartDate
		 * @var QDateTime dttStartDate
		 */
		protected $dttStartDate;
		const StartDateDefault = null;


		/**
		 * Protected member variable that maps to the database column MembershipLog.ExpireDate
		 * @var QDateTime dttExpireDate
		 */
		protected $dttExpireDate;
		const ExpireDateDefault = null;


		/**
		 * Protected member variable that maps to the database column MembershipLog.PaymentType
		 * @var integer intPaymentType
		 */
		protected $intPaymentType;
		const PaymentTypeDefault = null;


		/**
		 * Protected member variable that maps to the database column MembershipLog.PaymentAmount
		 * @var double fltPaymentAmount
		 */
		protected $fltPaymentAmount;
		const PaymentAmountDefault = null;


		/**
		 * Protected member variable that maps to the database column MembershipLog.PaidOn
		 * @var QDateTime dttPaidOn
		 */
		protected $dttPaidOn;
		const PaidOnDefault = null;


		/**
		 * Protected member variable that maps to the database column MembershipLog.Note
		 * @var string strNote
		 */
		protected $strNote;
		const NoteMaxLength = 300;
		const NoteDefault = null;


		/**
		 * Protected member variable that maps to the database column MembershipLog.MemberId
		 * @var integer intMemberId
		 */
		protected $intMemberId;
		const MemberIdDefault = null;


		/**
		 * Protected member variable that maps to the database column MembershipLog.transferId
		 * @var integer intTransferId
		 */
		protected $intTransferId;
		const TransferIdDefault = null;


		/**
		 * Protected member variable that maps to the database column MembershipLog.LogDate
		 * @var QDateTime dttLogDate
		 */
		protected $dttLogDate;
		const LogDateDefault = null;


		/**
		 * Protected member variable that maps to the database column MembershipLog.NewMembership
		 * @var boolean blnNewMembership
		 */
		protected $blnNewMembership;
		const NewMembershipDefault = null;


		/**
		 * Protected member variable that maps to the database column MembershipLog.MedTrainingType
		 * @var integer intMedTrainingType
		 */
		protected $intMedTrainingType;
		const MedTrainingTypeDefault = null;


		/**
		 * Protected member variable that maps to the database column MembershipLog.WillingMedVolunteer
		 * @var boolean blnWillingMedVolunteer
		 */
		protected $blnWillingMedVolunteer;
		const WillingMedVolunteerDefault = null;


		/**
		 * Protected member variable that maps to the database column MembershipLog.PayPalTransactionId
		 * @var string strPayPalTransactionId
		 */
		protected $strPayPalTransactionId;
		const PayPalTransactionIdMaxLength = 25;
		const PayPalTransactionIdDefault = null;


		/**
		 * Protected member variable that maps to the database column MembershipLog.MembershipConsent
		 * @var QDateTime dttMembershipConsent
		 */
		protected $dttMembershipConsent;
		const MembershipConsentDefault = null;


		/**
		 * Protected member variable that maps to the database column MembershipLog.ConsentSignature
		 * @var string strConsentSignature
		 */
		protected $strConsentSignature;
		const ConsentSignatureMaxLength = 50;
		const ConsentSignatureDefault = null;


		/**
		 * Private member variable that stores a reference to a single FamilyMemberAssocAsId object
		 * (of type FamilyMemberAssoc), if this MembershipLog object was restored with
		 * an expansion on the FamilyMemberAssoc association table.
		 * @var FamilyMemberAssoc _objFamilyMemberAssocAsId;
		 */
		private $_objFamilyMemberAssocAsId;

		/**
		 * Private member variable that stores a reference to an array of FamilyMemberAssocAsId objects
		 * (of type FamilyMemberAssoc[]), if this MembershipLog object was restored with
		 * an ExpandAsArray on the FamilyMemberAssoc association table.
		 * @var FamilyMemberAssoc[] _objFamilyMemberAssocAsIdArray;
		 */
		private $_objFamilyMemberAssocAsIdArray = array();

		/**
		 * Private member variable that stores a reference to a single MembershipAssocAsId object
		 * (of type MembershipAssoc), if this MembershipLog object was restored with
		 * an expansion on the MembershipAssoc association table.
		 * @var MembershipAssoc _objMembershipAssocAsId;
		 */
		private $_objMembershipAssocAsId;

		/**
		 * Private member variable that stores a reference to an array of MembershipAssocAsId objects
		 * (of type MembershipAssoc[]), if this MembershipLog object was restored with
		 * an ExpandAsArray on the MembershipAssoc association table.
		 * @var MembershipAssoc[] _objMembershipAssocAsIdArray;
		 */
		private $_objMembershipAssocAsIdArray = array();

		/**
		 * Private member variable that stores a reference to a single NotificationLogAsId object
		 * (of type NotificationLog), if this MembershipLog object was restored with
		 * an expansion on the NotificationLog association table.
		 * @var NotificationLog _objNotificationLogAsId;
		 */
		private $_objNotificationLogAsId;

		/**
		 * Private member variable that stores a reference to an array of NotificationLogAsId objects
		 * (of type NotificationLog[]), if this MembershipLog object was restored with
		 * an ExpandAsArray on the NotificationLog association table.
		 * @var NotificationLog[] _objNotificationLogAsIdArray;
		 */
		private $_objNotificationLogAsIdArray = array();

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
		 * in the database column MembershipLog.MemberId.
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
			$strToReturn = '<complexType name="MembershipLog"><sequence>';
			$strToReturn .= '<element name="Id" type="xsd:int"/>';
			$strToReturn .= '<element name="LogType" type="xsd:int"/>';
			$strToReturn .= '<element name="StartDate" type="xsd:dateTime"/>';
			$strToReturn .= '<element name="ExpireDate" type="xsd:dateTime"/>';
			$strToReturn .= '<element name="PaymentType" type="xsd:int"/>';
			$strToReturn .= '<element name="PaymentAmount" type="xsd:float"/>';
			$strToReturn .= '<element name="PaidOn" type="xsd:dateTime"/>';
			$strToReturn .= '<element name="Note" type="xsd:string"/>';
			$strToReturn .= '<element name="MemberIdObject" type="xsd1:MemberContact"/>';
			$strToReturn .= '<element name="TransferId" type="xsd:int"/>';
			$strToReturn .= '<element name="LogDate" type="xsd:dateTime"/>';
			$strToReturn .= '<element name="NewMembership" type="xsd:boolean"/>';
			$strToReturn .= '<element name="MedTrainingType" type="xsd:int"/>';
			$strToReturn .= '<element name="WillingMedVolunteer" type="xsd:boolean"/>';
			$strToReturn .= '<element name="PayPalTransactionId" type="xsd:string"/>';
			$strToReturn .= '<element name="MembershipConsent" type="xsd:dateTime"/>';
			$strToReturn .= '<element name="ConsentSignature" type="xsd:string"/>';
			$strToReturn .= '<element name="__blnRestored" type="xsd:boolean"/>';
			$strToReturn .= '</sequence></complexType>';
			return $strToReturn;
		}

		public static function AlterSoapComplexTypeArray(&$strComplexTypeArray) {
			if (!array_key_exists('MembershipLog', $strComplexTypeArray)) {
				$strComplexTypeArray['MembershipLog'] = MembershipLog::GetSoapComplexTypeXml();
				MemberContact::AlterSoapComplexTypeArray($strComplexTypeArray);
			}
		}

		public static function GetArrayFromSoapArray($objSoapArray) {
			$objArrayToReturn = array();

			foreach ($objSoapArray as $objSoapObject)
				array_push($objArrayToReturn, MembershipLog::GetObjectFromSoapObject($objSoapObject));

			return $objArrayToReturn;
		}

		public static function GetObjectFromSoapObject($objSoapObject) {
			$objToReturn = new MembershipLog();
			if (property_exists($objSoapObject, 'Id'))
				$objToReturn->intId = $objSoapObject->Id;
			if (property_exists($objSoapObject, 'LogType'))
				$objToReturn->intLogType = $objSoapObject->LogType;
			if (property_exists($objSoapObject, 'StartDate'))
				$objToReturn->dttStartDate = new QDateTime($objSoapObject->StartDate);
			if (property_exists($objSoapObject, 'ExpireDate'))
				$objToReturn->dttExpireDate = new QDateTime($objSoapObject->ExpireDate);
			if (property_exists($objSoapObject, 'PaymentType'))
				$objToReturn->intPaymentType = $objSoapObject->PaymentType;
			if (property_exists($objSoapObject, 'PaymentAmount'))
				$objToReturn->fltPaymentAmount = $objSoapObject->PaymentAmount;
			if (property_exists($objSoapObject, 'PaidOn'))
				$objToReturn->dttPaidOn = new QDateTime($objSoapObject->PaidOn);
			if (property_exists($objSoapObject, 'Note'))
				$objToReturn->strNote = $objSoapObject->Note;
			if ((property_exists($objSoapObject, 'MemberIdObject')) &&
				($objSoapObject->MemberIdObject))
				$objToReturn->MemberIdObject = MemberContact::GetObjectFromSoapObject($objSoapObject->MemberIdObject);
			if (property_exists($objSoapObject, 'TransferId'))
				$objToReturn->intTransferId = $objSoapObject->TransferId;
			if (property_exists($objSoapObject, 'LogDate'))
				$objToReturn->dttLogDate = new QDateTime($objSoapObject->LogDate);
			if (property_exists($objSoapObject, 'NewMembership'))
				$objToReturn->blnNewMembership = $objSoapObject->NewMembership;
			if (property_exists($objSoapObject, 'MedTrainingType'))
				$objToReturn->intMedTrainingType = $objSoapObject->MedTrainingType;
			if (property_exists($objSoapObject, 'WillingMedVolunteer'))
				$objToReturn->blnWillingMedVolunteer = $objSoapObject->WillingMedVolunteer;
			if (property_exists($objSoapObject, 'PayPalTransactionId'))
				$objToReturn->strPayPalTransactionId = $objSoapObject->PayPalTransactionId;
			if (property_exists($objSoapObject, 'MembershipConsent'))
				$objToReturn->dttMembershipConsent = new QDateTime($objSoapObject->MembershipConsent);
			if (property_exists($objSoapObject, 'ConsentSignature'))
				$objToReturn->strConsentSignature = $objSoapObject->ConsentSignature;
			if (property_exists($objSoapObject, '__blnRestored'))
				$objToReturn->__blnRestored = $objSoapObject->__blnRestored;
			return $objToReturn;
		}

		public static function GetSoapArrayFromArray($objArray) {
			if (!$objArray)
				return null;

			$objArrayToReturn = array();

			foreach ($objArray as $objObject)
				array_push($objArrayToReturn, MembershipLog::GetSoapObjectFromObject($objObject, true));

			return unserialize(serialize($objArrayToReturn ?? '') ?? '');
		}

		public static function GetSoapObjectFromObject($objObject, $blnBindRelatedObjects) {
			if ($objObject->dttStartDate)
				$objObject->dttStartDate = $objObject->dttStartDate->toString(QDateTime::FormatSoap);
			if ($objObject->dttExpireDate)
				$objObject->dttExpireDate = $objObject->dttExpireDate->toString(QDateTime::FormatSoap);
			if ($objObject->dttPaidOn)
				$objObject->dttPaidOn = $objObject->dttPaidOn->toString(QDateTime::FormatSoap);
			if ($objObject->objMemberIdObject)
				$objObject->objMemberIdObject = MemberContact::GetSoapObjectFromObject($objObject->objMemberIdObject, false);
			else if (!$blnBindRelatedObjects)
				$objObject->intMemberId = null;
			if ($objObject->dttLogDate)
				$objObject->dttLogDate = $objObject->dttLogDate->toString(QDateTime::FormatSoap);
			if ($objObject->dttMembershipConsent)
				$objObject->dttMembershipConsent = $objObject->dttMembershipConsent->toString(QDateTime::FormatSoap);
			return $objObject;
		}
	}





	/////////////////////////////////////
	// ADDITIONAL CLASSES for QCODO QUERY
	/////////////////////////////////////

	class QQNodeMembershipLog extends QQNode {
		protected $strTableName = 'MembershipLog';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'MembershipLog';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'LogType':
					return new QQNode('LogType', 'integer', $this);
				case 'StartDate':
					return new QQNode('StartDate', 'QDateTime', $this);
				case 'ExpireDate':
					return new QQNode('ExpireDate', 'QDateTime', $this);
				case 'PaymentType':
					return new QQNode('PaymentType', 'integer', $this);
				case 'PaymentAmount':
					return new QQNode('PaymentAmount', 'double', $this);
				case 'PaidOn':
					return new QQNode('PaidOn', 'QDateTime', $this);
				case 'Note':
					return new QQNode('Note', 'string', $this);
				case 'MemberId':
					return new QQNode('MemberId', 'integer', $this);
				case 'MemberIdObject':
					return new QQNodeMemberContact('MemberId', 'integer', $this);
				case 'TransferId':
					return new QQNode('transferId', 'integer', $this);
				case 'LogDate':
					return new QQNode('LogDate', 'QDateTime', $this);
				case 'NewMembership':
					return new QQNode('NewMembership', 'boolean', $this);
				case 'MedTrainingType':
					return new QQNode('MedTrainingType', 'integer', $this);
				case 'WillingMedVolunteer':
					return new QQNode('WillingMedVolunteer', 'boolean', $this);
				case 'PayPalTransactionId':
					return new QQNode('PayPalTransactionId', 'string', $this);
				case 'MembershipConsent':
					return new QQNode('MembershipConsent', 'QDateTime', $this);
				case 'ConsentSignature':
					return new QQNode('ConsentSignature', 'string', $this);
				case 'FamilyMemberAssocAsId':
					return new QQReverseReferenceNodeFamilyMemberAssoc($this, 'familymemberassocasid', 'reverse_reference', 'MembershipLogId');
				case 'MembershipAssocAsId':
					return new QQReverseReferenceNodeMembershipAssoc($this, 'membershipassocasid', 'reverse_reference', 'MembershipLogId');
				case 'NotificationLogAsId':
					return new QQReverseReferenceNodeNotificationLog($this, 'notificationlogasid', 'reverse_reference', 'MembershipLogId');

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

	class QQReverseReferenceNodeMembershipLog extends QQReverseReferenceNode {
		protected $strTableName = 'MembershipLog';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'MembershipLog';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'LogType':
					return new QQNode('LogType', 'integer', $this);
				case 'StartDate':
					return new QQNode('StartDate', 'QDateTime', $this);
				case 'ExpireDate':
					return new QQNode('ExpireDate', 'QDateTime', $this);
				case 'PaymentType':
					return new QQNode('PaymentType', 'integer', $this);
				case 'PaymentAmount':
					return new QQNode('PaymentAmount', 'double', $this);
				case 'PaidOn':
					return new QQNode('PaidOn', 'QDateTime', $this);
				case 'Note':
					return new QQNode('Note', 'string', $this);
				case 'MemberId':
					return new QQNode('MemberId', 'integer', $this);
				case 'MemberIdObject':
					return new QQNodeMemberContact('MemberId', 'integer', $this);
				case 'TransferId':
					return new QQNode('transferId', 'integer', $this);
				case 'LogDate':
					return new QQNode('LogDate', 'QDateTime', $this);
				case 'NewMembership':
					return new QQNode('NewMembership', 'boolean', $this);
				case 'MedTrainingType':
					return new QQNode('MedTrainingType', 'integer', $this);
				case 'WillingMedVolunteer':
					return new QQNode('WillingMedVolunteer', 'boolean', $this);
				case 'PayPalTransactionId':
					return new QQNode('PayPalTransactionId', 'string', $this);
				case 'MembershipConsent':
					return new QQNode('MembershipConsent', 'QDateTime', $this);
				case 'ConsentSignature':
					return new QQNode('ConsentSignature', 'string', $this);
				case 'FamilyMemberAssocAsId':
					return new QQReverseReferenceNodeFamilyMemberAssoc($this, 'familymemberassocasid', 'reverse_reference', 'MembershipLogId');
				case 'MembershipAssocAsId':
					return new QQReverseReferenceNodeMembershipAssoc($this, 'membershipassocasid', 'reverse_reference', 'MembershipLogId');
				case 'NotificationLogAsId':
					return new QQReverseReferenceNodeNotificationLog($this, 'notificationlogasid', 'reverse_reference', 'MembershipLogId');

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