<?php
	/**
	 * The abstract MemberContactGen class defined here is
	 * code-generated and contains all the basic CRUD-type functionality as well as
	 * basic methods to handle relationships and index-based loading.
	 *
	 * To use, you should use the MemberContact subclass which
	 * extends this MemberContactGen class.
	 *
	 * Because subsequent re-code generations will overwrite any changes to this
	 * file, you should leave this file unaltered to prevent yourself from losing
	 * any information or code changes.  All customizations should be done by
	 * overriding existing or implementing new methods, properties and variables
	 * in the MemberContact class.
	 * 
	 * @package My Application
	 * @subpackage GeneratedDataObjects
	 * 
	 */
	class MemberContactGen extends QBaseClass {
		///////////////////////////////
		// COMMON LOAD METHODS
		///////////////////////////////

		/**
		 * Load a MemberContact from PK Info
		 * @param integer $intId
		 * @return MemberContact
		 */
		public static function Load($intId) {
			// Use QuerySingle to Perform the Query
			return MemberContact::QuerySingle(
				QQ::Equal(QQN::MemberContact()->Id, $intId)
			);
		}

		/**
		 * Load all MemberContacts
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return MemberContact[]
		 */
		public static function LoadAll($objOptionalClauses = null) {
			// Call MemberContact::QueryArray to perform the LoadAll query
			try {
				return MemberContact::QueryArray(QQ::All(), $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Count all MemberContacts
		 * @return int
		 */
		public static function CountAll() {
			// Call MemberContact::QueryCount to perform the CountAll query
			return MemberContact::QueryCount(QQ::All());
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
			$objDatabase = MemberContact::GetDatabase();

			// Create/Build out the QueryBuilder object with MemberContact-specific SELET and FROM fields
			$objQueryBuilder = new QQueryBuilder($objDatabase, 'MemberContact');
			MemberContact::GetSelectFields($objQueryBuilder,null,$selectionArray);
			$objQueryBuilder->AddFromItem('`MemberContact` AS `MemberContact`');

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
		 * Static Qcodo Query method to query for a single MemberContact object.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return MemberContact the queried object
		 */
		public static function QuerySingle(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = MemberContact::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query, Get the First Row, and Instantiate a new MemberContact object
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return MemberContact::InstantiateDbRow($objDbResult->GetNextRow());
		}

		/**
		 * Static Qcodo Query method to query for an array of MemberContact objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return MemberContact[] the queried objects as an array
		 */
		public static function QueryArray(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = MemberContact::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, false,$selectionArray);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// Perform the Query and Instantiate the Array Result
			$objDbResult = $objQueryBuilder->Database->Query($strQuery);
			return MemberContact::InstantiateDbResult($objDbResult, $objQueryBuilder->ExpandAsArrayNodes);
		}

		/**
		 * Static Qcodo Query method to query for a count of MemberContact objects.
		 * Uses BuildQueryStatment to perform most of the work.
		 * @param QQCondition $objConditions any conditions on the query, itself
		 * @param QQClause[] $objOptionalClausees additional optional QQClause objects for this query
		 * @param mixed[] $mixParameterArray a array of name-value pairs to perform PrepareStatement with
		 * @return integer the count of queried objects as an integer
		 */
		public static function QueryCount(QQCondition $objConditions, $objOptionalClauses = null, $mixParameterArray = null,$selectionArray = null) {
			// Get the Query Statement
			try {
				$strQuery = MemberContact::BuildQueryStatement($objQueryBuilder, $objConditions, $objOptionalClauses, $mixParameterArray, true,$selectionArray);
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
			$objDatabase = MemberContact::GetDatabase();

			// Lookup the QCache for This Query Statement
			$objCache = new QCache('query', 'MemberContact_' . serialize($strConditions));
			if (!($strQuery = $objCache->GetData())) {
				// Not Found -- Go ahead and Create/Build out a new QueryBuilder object with MemberContact-specific fields
				$objQueryBuilder = new QQueryBuilder($objDatabase);
				MemberContact::GetSelectFields($objQueryBuilder);
				MemberContact::GetFromFields($objQueryBuilder);

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
			return MemberContact::InstantiateDbResult($objDbResult);
		}*/

		/**
		 * Updates a QQueryBuilder with the SELECT fields for this MemberContact
		 * @param QQueryBuilder $objBuilder the Query Builder object to update
		 * @param string $strPrefix optional prefix to add to the SELECT fields
		 * @param array $selectionArray optional array of SELECT field items (wpg - added Sept 2012)
		 */
		public static function GetSelectFields(QQueryBuilder $objBuilder, $strPrefix = null, $selectionArray = null) {
			if ($strPrefix) {
				$strTableName = '`' . $strPrefix . '`';
				$strAliasPrefix = '`' . $strPrefix . '__';
			} else {
				$strTableName = '`MemberContact`';
				$strAliasPrefix = '`';
			}

			// wpg - if we are not passing in an array of participant fields we want then get them all
			if (!$selectionArray){
				$objBuilder->AddSelectItem($strTableName . '.`Id` AS ' . $strAliasPrefix . 'Id`');
				$objBuilder->AddSelectItem($strTableName . '.`LastName` AS ' . $strAliasPrefix . 'LastName`');
				$objBuilder->AddSelectItem($strTableName . '.`FirstName` AS ' . $strAliasPrefix . 'FirstName`');
				$objBuilder->AddSelectItem($strTableName . '.`Email` AS ' . $strAliasPrefix . 'Email`');
				$objBuilder->AddSelectItem($strTableName . '.`Addr1` AS ' . $strAliasPrefix . 'Addr1`');
				$objBuilder->AddSelectItem($strTableName . '.`Addr2` AS ' . $strAliasPrefix . 'Addr2`');
				$objBuilder->AddSelectItem($strTableName . '.`City` AS ' . $strAliasPrefix . 'City`');
				$objBuilder->AddSelectItem($strTableName . '.`State` AS ' . $strAliasPrefix . 'State`');
				$objBuilder->AddSelectItem($strTableName . '.`Zip` AS ' . $strAliasPrefix . 'Zip`');
				$objBuilder->AddSelectItem($strTableName . '.`Gender` AS ' . $strAliasPrefix . 'Gender`');
				$objBuilder->AddSelectItem($strTableName . '.`BirthDay` AS ' . $strAliasPrefix . 'BirthDay`');
				$objBuilder->AddSelectItem($strTableName . '.`BirthMonth` AS ' . $strAliasPrefix . 'BirthMonth`');
				$objBuilder->AddSelectItem($strTableName . '.`BirthYear` AS ' . $strAliasPrefix . 'BirthYear`');
				$objBuilder->AddSelectItem($strTableName . '.`MainPhone` AS ' . $strAliasPrefix . 'MainPhone`');
				$objBuilder->AddSelectItem($strTableName . '.`AltPhone` AS ' . $strAliasPrefix . 'AltPhone`');
				$objBuilder->AddSelectItem($strTableName . '.`Note` AS ' . $strAliasPrefix . 'Note`');
				$objBuilder->AddSelectItem($strTableName . '.`transferId` AS ' . $strAliasPrefix . 'transferId`');
				$objBuilder->AddSelectItem($strTableName . '.`ContactAdded` AS ' . $strAliasPrefix . 'ContactAdded`');
				$objBuilder->AddSelectItem($strTableName . '.`GoogleEmail` AS ' . $strAliasPrefix . 'GoogleEmail`');
				$objBuilder->AddSelectItem($strTableName . '.`FacebookEmail` AS ' . $strAliasPrefix . 'FacebookEmail`');
				$objBuilder->AddSelectItem($strTableName . '.`JoinedClub` AS ' . $strAliasPrefix . 'JoinedClub`');
				$objBuilder->AddSelectItem($strTableName . '.`NotActive` AS ' . $strAliasPrefix . 'NotActive`');
				$objBuilder->AddSelectItem($strTableName . '.`ImageReference` AS ' . $strAliasPrefix . 'ImageReference`');
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
		 * Instantiate a MemberContact from a Database Row.
		 * Takes in an optional strAliasPrefix, used in case another Object::InstantiateDbRow
		 * is calling this MemberContact::InstantiateDbRow in order to perform
		 * early binding on referenced objects.
		 * @param DatabaseRowBase $objDbRow
		 * @param string $strAliasPrefix
		 * @return MemberContact
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
					$strAliasPrefix = 'MemberContact__';


				if ((array_key_exists($strAliasPrefix . 'businessmemberassocasmemberid__Id', $strExpandAsArrayNodes)) &&
					(!is_null($objDbRow->GetColumn($strAliasPrefix . 'businessmemberassocasmemberid__Id')))) {
					if ($intPreviousChildItemCount = count($objPreviousItem->_objBusinessMemberAssocAsMemberIdArray)) {
						$objPreviousChildItem = $objPreviousItem->_objBusinessMemberAssocAsMemberIdArray[$intPreviousChildItemCount - 1];
						$objChildItem = BusinessMemberAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'businessmemberassocasmemberid__', $strExpandAsArrayNodes, $objPreviousChildItem);
						if ($objChildItem)
							array_push($objPreviousItem->_objBusinessMemberAssocAsMemberIdArray, $objChildItem);
					} else
						array_push($objPreviousItem->_objBusinessMemberAssocAsMemberIdArray, BusinessMemberAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'businessmemberassocasmemberid__', $strExpandAsArrayNodes));
					$blnExpandedViaArray = true;
				}

				if ((array_key_exists($strAliasPrefix . 'familymemberassocasfamilymemberid__Id', $strExpandAsArrayNodes)) &&
					(!is_null($objDbRow->GetColumn($strAliasPrefix . 'familymemberassocasfamilymemberid__Id')))) {
					if ($intPreviousChildItemCount = count($objPreviousItem->_objFamilyMemberAssocAsFamilyMemberIdArray)) {
						$objPreviousChildItem = $objPreviousItem->_objFamilyMemberAssocAsFamilyMemberIdArray[$intPreviousChildItemCount - 1];
						$objChildItem = FamilyMemberAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'familymemberassocasfamilymemberid__', $strExpandAsArrayNodes, $objPreviousChildItem);
						if ($objChildItem)
							array_push($objPreviousItem->_objFamilyMemberAssocAsFamilyMemberIdArray, $objChildItem);
					} else
						array_push($objPreviousItem->_objFamilyMemberAssocAsFamilyMemberIdArray, FamilyMemberAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'familymemberassocasfamilymemberid__', $strExpandAsArrayNodes));
					$blnExpandedViaArray = true;
				}

				if ((array_key_exists($strAliasPrefix . 'memberaccesslogasmemberid__Id', $strExpandAsArrayNodes)) &&
					(!is_null($objDbRow->GetColumn($strAliasPrefix . 'memberaccesslogasmemberid__Id')))) {
					if ($intPreviousChildItemCount = count($objPreviousItem->_objMemberAccessLogAsMemberIdArray)) {
						$objPreviousChildItem = $objPreviousItem->_objMemberAccessLogAsMemberIdArray[$intPreviousChildItemCount - 1];
						$objChildItem = MemberAccessLog::InstantiateDbRow($objDbRow, $strAliasPrefix . 'memberaccesslogasmemberid__', $strExpandAsArrayNodes, $objPreviousChildItem);
						if ($objChildItem)
							array_push($objPreviousItem->_objMemberAccessLogAsMemberIdArray, $objChildItem);
					} else
						array_push($objPreviousItem->_objMemberAccessLogAsMemberIdArray, MemberAccessLog::InstantiateDbRow($objDbRow, $strAliasPrefix . 'memberaccesslogasmemberid__', $strExpandAsArrayNodes));
					$blnExpandedViaArray = true;
				}

				if ((array_key_exists($strAliasPrefix . 'memberaclassnasmemberid__Id', $strExpandAsArrayNodes)) &&
					(!is_null($objDbRow->GetColumn($strAliasPrefix . 'memberaclassnasmemberid__Id')))) {
					if ($intPreviousChildItemCount = count($objPreviousItem->_objMemberAclAssnAsMemberIdArray)) {
						$objPreviousChildItem = $objPreviousItem->_objMemberAclAssnAsMemberIdArray[$intPreviousChildItemCount - 1];
						$objChildItem = MemberAclAssn::InstantiateDbRow($objDbRow, $strAliasPrefix . 'memberaclassnasmemberid__', $strExpandAsArrayNodes, $objPreviousChildItem);
						if ($objChildItem)
							array_push($objPreviousItem->_objMemberAclAssnAsMemberIdArray, $objChildItem);
					} else
						array_push($objPreviousItem->_objMemberAclAssnAsMemberIdArray, MemberAclAssn::InstantiateDbRow($objDbRow, $strAliasPrefix . 'memberaclassnasmemberid__', $strExpandAsArrayNodes));
					$blnExpandedViaArray = true;
				}

				if ((array_key_exists($strAliasPrefix . 'memberraceresultasid__Id', $strExpandAsArrayNodes)) &&
					(!is_null($objDbRow->GetColumn($strAliasPrefix . 'memberraceresultasid__Id')))) {
					if ($intPreviousChildItemCount = count($objPreviousItem->_objMemberRaceResultAsIdArray)) {
						$objPreviousChildItem = $objPreviousItem->_objMemberRaceResultAsIdArray[$intPreviousChildItemCount - 1];
						$objChildItem = MemberRaceResult::InstantiateDbRow($objDbRow, $strAliasPrefix . 'memberraceresultasid__', $strExpandAsArrayNodes, $objPreviousChildItem);
						if ($objChildItem)
							array_push($objPreviousItem->_objMemberRaceResultAsIdArray, $objChildItem);
					} else
						array_push($objPreviousItem->_objMemberRaceResultAsIdArray, MemberRaceResult::InstantiateDbRow($objDbRow, $strAliasPrefix . 'memberraceresultasid__', $strExpandAsArrayNodes));
					$blnExpandedViaArray = true;
				}

				if ((array_key_exists($strAliasPrefix . 'membertagassocasmemberid__MemberId', $strExpandAsArrayNodes)) &&
					(!is_null($objDbRow->GetColumn($strAliasPrefix . 'membertagassocasmemberid__MemberId')))) {
					if ($intPreviousChildItemCount = count($objPreviousItem->_objMemberTagAssocAsMemberIdArray)) {
						$objPreviousChildItem = $objPreviousItem->_objMemberTagAssocAsMemberIdArray[$intPreviousChildItemCount - 1];
						$objChildItem = MemberTagAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membertagassocasmemberid__', $strExpandAsArrayNodes, $objPreviousChildItem);
						if ($objChildItem)
							array_push($objPreviousItem->_objMemberTagAssocAsMemberIdArray, $objChildItem);
					} else
						array_push($objPreviousItem->_objMemberTagAssocAsMemberIdArray, MemberTagAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membertagassocasmemberid__', $strExpandAsArrayNodes));
					$blnExpandedViaArray = true;
				}

				if ((array_key_exists($strAliasPrefix . 'membershipassocasmemberid__Id', $strExpandAsArrayNodes)) &&
					(!is_null($objDbRow->GetColumn($strAliasPrefix . 'membershipassocasmemberid__Id')))) {
					if ($intPreviousChildItemCount = count($objPreviousItem->_objMembershipAssocAsMemberIdArray)) {
						$objPreviousChildItem = $objPreviousItem->_objMembershipAssocAsMemberIdArray[$intPreviousChildItemCount - 1];
						$objChildItem = MembershipAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membershipassocasmemberid__', $strExpandAsArrayNodes, $objPreviousChildItem);
						if ($objChildItem)
							array_push($objPreviousItem->_objMembershipAssocAsMemberIdArray, $objChildItem);
					} else
						array_push($objPreviousItem->_objMembershipAssocAsMemberIdArray, MembershipAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membershipassocasmemberid__', $strExpandAsArrayNodes));
					$blnExpandedViaArray = true;
				}

				if ((array_key_exists($strAliasPrefix . 'membershiplogasmemberid__Id', $strExpandAsArrayNodes)) &&
					(!is_null($objDbRow->GetColumn($strAliasPrefix . 'membershiplogasmemberid__Id')))) {
					if ($intPreviousChildItemCount = count($objPreviousItem->_objMembershipLogAsMemberIdArray)) {
						$objPreviousChildItem = $objPreviousItem->_objMembershipLogAsMemberIdArray[$intPreviousChildItemCount - 1];
						$objChildItem = MembershipLog::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membershiplogasmemberid__', $strExpandAsArrayNodes, $objPreviousChildItem);
						if ($objChildItem)
							array_push($objPreviousItem->_objMembershipLogAsMemberIdArray, $objChildItem);
					} else
						array_push($objPreviousItem->_objMembershipLogAsMemberIdArray, MembershipLog::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membershiplogasmemberid__', $strExpandAsArrayNodes));
					$blnExpandedViaArray = true;
				}

				if ((array_key_exists($strAliasPrefix . 'notificationlogasmemberid__Id', $strExpandAsArrayNodes)) &&
					(!is_null($objDbRow->GetColumn($strAliasPrefix . 'notificationlogasmemberid__Id')))) {
					if ($intPreviousChildItemCount = count($objPreviousItem->_objNotificationLogAsMemberIdArray)) {
						$objPreviousChildItem = $objPreviousItem->_objNotificationLogAsMemberIdArray[$intPreviousChildItemCount - 1];
						$objChildItem = NotificationLog::InstantiateDbRow($objDbRow, $strAliasPrefix . 'notificationlogasmemberid__', $strExpandAsArrayNodes, $objPreviousChildItem);
						if ($objChildItem)
							array_push($objPreviousItem->_objNotificationLogAsMemberIdArray, $objChildItem);
					} else
						array_push($objPreviousItem->_objNotificationLogAsMemberIdArray, NotificationLog::InstantiateDbRow($objDbRow, $strAliasPrefix . 'notificationlogasmemberid__', $strExpandAsArrayNodes));
					$blnExpandedViaArray = true;
				}

				// Either return false to signal array expansion, or check-to-reset the Alias prefix and move on
				if ($blnExpandedViaArray)
					return false;
				else if ($strAliasPrefix == 'MemberContact__')
					$strAliasPrefix = null;
			}

			// Create a new instance of the MemberContact object
			$objToReturn = new MemberContact();
			$objToReturn->__blnRestored = true;

			$objToReturn->intId = $objDbRow->GetColumn($strAliasPrefix . 'Id', 'Integer');
			$objToReturn->strLastName = $objDbRow->GetColumn($strAliasPrefix . 'LastName', 'VarChar');
			$objToReturn->strFirstName = $objDbRow->GetColumn($strAliasPrefix . 'FirstName', 'VarChar');
			$objToReturn->strEmail = $objDbRow->GetColumn($strAliasPrefix . 'Email', 'VarChar');
			$objToReturn->strAddr1 = $objDbRow->GetColumn($strAliasPrefix . 'Addr1', 'VarChar');
			$objToReturn->strAddr2 = $objDbRow->GetColumn($strAliasPrefix . 'Addr2', 'VarChar');
			$objToReturn->strCity = $objDbRow->GetColumn($strAliasPrefix . 'City', 'VarChar');
			$objToReturn->strState = $objDbRow->GetColumn($strAliasPrefix . 'State', 'VarChar');
			$objToReturn->strZip = $objDbRow->GetColumn($strAliasPrefix . 'Zip', 'VarChar');
			$objToReturn->strGender = $objDbRow->GetColumn($strAliasPrefix . 'Gender', 'VarChar');
			$objToReturn->intBirthDay = $objDbRow->GetColumn($strAliasPrefix . 'BirthDay', 'Integer');
			$objToReturn->intBirthMonth = $objDbRow->GetColumn($strAliasPrefix . 'BirthMonth', 'Integer');
			$objToReturn->intBirthYear = $objDbRow->GetColumn($strAliasPrefix . 'BirthYear', 'Integer');
			$objToReturn->strMainPhone = $objDbRow->GetColumn($strAliasPrefix . 'MainPhone', 'VarChar');
			$objToReturn->strAltPhone = $objDbRow->GetColumn($strAliasPrefix . 'AltPhone', 'VarChar');
			$objToReturn->strNote = $objDbRow->GetColumn($strAliasPrefix . 'Note', 'VarChar');
			$objToReturn->intTransferId = $objDbRow->GetColumn($strAliasPrefix . 'transferId', 'Integer');
			$objToReturn->dttContactAdded = $objDbRow->GetColumn($strAliasPrefix . 'ContactAdded', 'Date');
			$objToReturn->strGoogleEmail = $objDbRow->GetColumn($strAliasPrefix . 'GoogleEmail', 'VarChar');
			$objToReturn->strFacebookEmail = $objDbRow->GetColumn($strAliasPrefix . 'FacebookEmail', 'VarChar');
			$objToReturn->dttJoinedClub = $objDbRow->GetColumn($strAliasPrefix . 'JoinedClub', 'Date');
			$objToReturn->blnNotActive = $objDbRow->GetColumn($strAliasPrefix . 'NotActive', 'Bit');
			$objToReturn->strImageReference = $objDbRow->GetColumn($strAliasPrefix . 'ImageReference', 'VarChar');

			// Instantiate Virtual Attributes
			foreach ($objDbRow->GetColumnNameArray() as $strColumnName => $mixValue) {
				$strVirtualPrefix = $strAliasPrefix . '__';
				$strVirtualPrefixLength = strlen($strVirtualPrefix ?? '');
				if (substr($strColumnName, 0, $strVirtualPrefixLength) == $strVirtualPrefix)
					$objToReturn->__strVirtualAttributeArray[substr($strColumnName, $strVirtualPrefixLength)] = $mixValue;
			}

			// Prepare to Check for Early/Virtual Binding
			if (!$strAliasPrefix)
				$strAliasPrefix = 'MemberContact__';




			// Check for BusinessMemberAssocAsMemberId Virtual Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'businessmemberassocasmemberid__Id'))) {
				if (($strExpandAsArrayNodes) && (array_key_exists($strAliasPrefix . 'businessmemberassocasmemberid__Id', $strExpandAsArrayNodes)))
					array_push($objToReturn->_objBusinessMemberAssocAsMemberIdArray, BusinessMemberAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'businessmemberassocasmemberid__', $strExpandAsArrayNodes));
				else
					$objToReturn->_objBusinessMemberAssocAsMemberId = BusinessMemberAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'businessmemberassocasmemberid__', $strExpandAsArrayNodes);
			}

			// Check for FamilyMemberAssocAsFamilyMemberId Virtual Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'familymemberassocasfamilymemberid__Id'))) {
				if (($strExpandAsArrayNodes) && (array_key_exists($strAliasPrefix . 'familymemberassocasfamilymemberid__Id', $strExpandAsArrayNodes)))
					array_push($objToReturn->_objFamilyMemberAssocAsFamilyMemberIdArray, FamilyMemberAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'familymemberassocasfamilymemberid__', $strExpandAsArrayNodes));
				else
					$objToReturn->_objFamilyMemberAssocAsFamilyMemberId = FamilyMemberAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'familymemberassocasfamilymemberid__', $strExpandAsArrayNodes);
			}

			// Check for MemberAccessLogAsMemberId Virtual Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'memberaccesslogasmemberid__Id'))) {
				if (($strExpandAsArrayNodes) && (array_key_exists($strAliasPrefix . 'memberaccesslogasmemberid__Id', $strExpandAsArrayNodes)))
					array_push($objToReturn->_objMemberAccessLogAsMemberIdArray, MemberAccessLog::InstantiateDbRow($objDbRow, $strAliasPrefix . 'memberaccesslogasmemberid__', $strExpandAsArrayNodes));
				else
					$objToReturn->_objMemberAccessLogAsMemberId = MemberAccessLog::InstantiateDbRow($objDbRow, $strAliasPrefix . 'memberaccesslogasmemberid__', $strExpandAsArrayNodes);
			}

			// Check for MemberAclAssnAsMemberId Virtual Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'memberaclassnasmemberid__Id'))) {
				if (($strExpandAsArrayNodes) && (array_key_exists($strAliasPrefix . 'memberaclassnasmemberid__Id', $strExpandAsArrayNodes)))
					array_push($objToReturn->_objMemberAclAssnAsMemberIdArray, MemberAclAssn::InstantiateDbRow($objDbRow, $strAliasPrefix . 'memberaclassnasmemberid__', $strExpandAsArrayNodes));
				else
					$objToReturn->_objMemberAclAssnAsMemberId = MemberAclAssn::InstantiateDbRow($objDbRow, $strAliasPrefix . 'memberaclassnasmemberid__', $strExpandAsArrayNodes);
			}

			// Check for MemberRaceResultAsId Virtual Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'memberraceresultasid__Id'))) {
				if (($strExpandAsArrayNodes) && (array_key_exists($strAliasPrefix . 'memberraceresultasid__Id', $strExpandAsArrayNodes)))
					array_push($objToReturn->_objMemberRaceResultAsIdArray, MemberRaceResult::InstantiateDbRow($objDbRow, $strAliasPrefix . 'memberraceresultasid__', $strExpandAsArrayNodes));
				else
					$objToReturn->_objMemberRaceResultAsId = MemberRaceResult::InstantiateDbRow($objDbRow, $strAliasPrefix . 'memberraceresultasid__', $strExpandAsArrayNodes);
			}

			// Check for MemberTagAssocAsMemberId Virtual Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'membertagassocasmemberid__MemberId'))) {
				if (($strExpandAsArrayNodes) && (array_key_exists($strAliasPrefix . 'membertagassocasmemberid__MemberId', $strExpandAsArrayNodes)))
					array_push($objToReturn->_objMemberTagAssocAsMemberIdArray, MemberTagAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membertagassocasmemberid__', $strExpandAsArrayNodes));
				else
					$objToReturn->_objMemberTagAssocAsMemberId = MemberTagAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membertagassocasmemberid__', $strExpandAsArrayNodes);
			}

			// Check for MembershipAssocAsMemberId Virtual Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'membershipassocasmemberid__Id'))) {
				if (($strExpandAsArrayNodes) && (array_key_exists($strAliasPrefix . 'membershipassocasmemberid__Id', $strExpandAsArrayNodes)))
					array_push($objToReturn->_objMembershipAssocAsMemberIdArray, MembershipAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membershipassocasmemberid__', $strExpandAsArrayNodes));
				else
					$objToReturn->_objMembershipAssocAsMemberId = MembershipAssoc::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membershipassocasmemberid__', $strExpandAsArrayNodes);
			}

			// Check for MembershipLogAsMemberId Virtual Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'membershiplogasmemberid__Id'))) {
				if (($strExpandAsArrayNodes) && (array_key_exists($strAliasPrefix . 'membershiplogasmemberid__Id', $strExpandAsArrayNodes)))
					array_push($objToReturn->_objMembershipLogAsMemberIdArray, MembershipLog::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membershiplogasmemberid__', $strExpandAsArrayNodes));
				else
					$objToReturn->_objMembershipLogAsMemberId = MembershipLog::InstantiateDbRow($objDbRow, $strAliasPrefix . 'membershiplogasmemberid__', $strExpandAsArrayNodes);
			}

			// Check for NotificationLogAsMemberId Virtual Binding
			if (!is_null($objDbRow->GetColumn($strAliasPrefix . 'notificationlogasmemberid__Id'))) {
				if (($strExpandAsArrayNodes) && (array_key_exists($strAliasPrefix . 'notificationlogasmemberid__Id', $strExpandAsArrayNodes)))
					array_push($objToReturn->_objNotificationLogAsMemberIdArray, NotificationLog::InstantiateDbRow($objDbRow, $strAliasPrefix . 'notificationlogasmemberid__', $strExpandAsArrayNodes));
				else
					$objToReturn->_objNotificationLogAsMemberId = NotificationLog::InstantiateDbRow($objDbRow, $strAliasPrefix . 'notificationlogasmemberid__', $strExpandAsArrayNodes);
			}

			return $objToReturn;
		}

		/**
		 * Instantiate an array of MemberContacts from a Database Result
		 * @param DatabaseResultBase $objDbResult
		 * @return MemberContact[]
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
					$objItem = MemberContact::InstantiateDbRow($objDbRow, null, $strExpandAsArrayNodes, $objLastRowItem);
					if ($objItem) {
						array_push($objToReturn, $objItem);
						$objLastRowItem = $objItem;
					}
				}
			} else {
				while ($objDbRow = $objDbResult->GetNextRow())
					array_push($objToReturn, MemberContact::InstantiateDbRow($objDbRow));
			}

			return $objToReturn;
		}



		///////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Single Load and Array)
		///////////////////////////////////////////////////
			
		/**
		 * Load a single MemberContact object,
		 * by Id Index(es)
		 * @param integer $intId
		 * @return MemberContact
		*/
		public static function LoadById($intId) {
			return MemberContact::QuerySingle(
				QQ::Equal(QQN::MemberContact()->Id, $intId)
			);
		}



		////////////////////////////////////////////////////
		// INDEX-BASED LOAD METHODS (Array via Many to Many)
		////////////////////////////////////////////////////



		//////////////////
		// SAVE AND DELETE
		//////////////////

		/**
		 * Save this MemberContact
		 * @param bool $blnForceInsert
		 * @param bool $blnForceUpdate
		 * @return int
		*/
		public function Save($blnForceInsert = false, $blnForceUpdate = false) {
			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			$mixToReturn = null;

			try {
				if ((!$this->__blnRestored) || ($blnForceInsert)) {
					// Perform an INSERT query
					$objDatabase->NonQuery('
						INSERT INTO `MemberContact` (
							`LastName`,
							`FirstName`,
							`Email`,
							`Addr1`,
							`Addr2`,
							`City`,
							`State`,
							`Zip`,
							`Gender`,
							`BirthDay`,
							`BirthMonth`,
							`BirthYear`,
							`MainPhone`,
							`AltPhone`,
							`Note`,
							`transferId`,
							`ContactAdded`,
							`GoogleEmail`,
							`FacebookEmail`,
							`JoinedClub`,
							`NotActive`,
							`ImageReference`
						) VALUES (
							' . $objDatabase->SqlVariable($this->strLastName) . ',
							' . $objDatabase->SqlVariable($this->strFirstName) . ',
							' . $objDatabase->SqlVariable($this->strEmail) . ',
							' . $objDatabase->SqlVariable($this->strAddr1) . ',
							' . $objDatabase->SqlVariable($this->strAddr2) . ',
							' . $objDatabase->SqlVariable($this->strCity) . ',
							' . $objDatabase->SqlVariable($this->strState) . ',
							' . $objDatabase->SqlVariable($this->strZip) . ',
							' . $objDatabase->SqlVariable($this->strGender) . ',
							' . $objDatabase->SqlVariable($this->intBirthDay) . ',
							' . $objDatabase->SqlVariable($this->intBirthMonth) . ',
							' . $objDatabase->SqlVariable($this->intBirthYear) . ',
							' . $objDatabase->SqlVariable($this->strMainPhone) . ',
							' . $objDatabase->SqlVariable($this->strAltPhone) . ',
							' . $objDatabase->SqlVariable($this->strNote) . ',
							' . $objDatabase->SqlVariable($this->intTransferId) . ',
							' . $objDatabase->SqlVariable($this->dttContactAdded) . ',
							' . $objDatabase->SqlVariable($this->strGoogleEmail) . ',
							' . $objDatabase->SqlVariable($this->strFacebookEmail) . ',
							' . $objDatabase->SqlVariable($this->dttJoinedClub) . ',
							' . $objDatabase->SqlVariable($this->blnNotActive) . ',
							' . $objDatabase->SqlVariable($this->strImageReference) . '
						)
					');

					// Update Identity column and return its value
					$mixToReturn = $this->intId = $objDatabase->InsertId('MemberContact', 'Id');
				} else {
					// Perform an UPDATE query

					// First checking for Optimistic Locking constraints (if applicable)

					// Perform the UPDATE query
					$objDatabase->NonQuery('
						UPDATE
							`MemberContact`
						SET
							`LastName` = ' . $objDatabase->SqlVariable($this->strLastName) . ',
							`FirstName` = ' . $objDatabase->SqlVariable($this->strFirstName) . ',
							`Email` = ' . $objDatabase->SqlVariable($this->strEmail) . ',
							`Addr1` = ' . $objDatabase->SqlVariable($this->strAddr1) . ',
							`Addr2` = ' . $objDatabase->SqlVariable($this->strAddr2) . ',
							`City` = ' . $objDatabase->SqlVariable($this->strCity) . ',
							`State` = ' . $objDatabase->SqlVariable($this->strState) . ',
							`Zip` = ' . $objDatabase->SqlVariable($this->strZip) . ',
							`Gender` = ' . $objDatabase->SqlVariable($this->strGender) . ',
							`BirthDay` = ' . $objDatabase->SqlVariable($this->intBirthDay) . ',
							`BirthMonth` = ' . $objDatabase->SqlVariable($this->intBirthMonth) . ',
							`BirthYear` = ' . $objDatabase->SqlVariable($this->intBirthYear) . ',
							`MainPhone` = ' . $objDatabase->SqlVariable($this->strMainPhone) . ',
							`AltPhone` = ' . $objDatabase->SqlVariable($this->strAltPhone) . ',
							`Note` = ' . $objDatabase->SqlVariable($this->strNote) . ',
							`transferId` = ' . $objDatabase->SqlVariable($this->intTransferId) . ',
							`ContactAdded` = ' . $objDatabase->SqlVariable($this->dttContactAdded) . ',
							`GoogleEmail` = ' . $objDatabase->SqlVariable($this->strGoogleEmail) . ',
							`FacebookEmail` = ' . $objDatabase->SqlVariable($this->strFacebookEmail) . ',
							`JoinedClub` = ' . $objDatabase->SqlVariable($this->dttJoinedClub) . ',
							`NotActive` = ' . $objDatabase->SqlVariable($this->blnNotActive) . ',
							`ImageReference` = ' . $objDatabase->SqlVariable($this->strImageReference) . '
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
		 * Delete this MemberContact
		 * @return void
		*/
		public function Delete() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Cannot delete this MemberContact with an unset primary key.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();


			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MemberContact`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($this->intId) . '');
		}

		/**
		 * Delete all MemberContacts
		 * @return void
		*/
		public static function DeleteAll() {
			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MemberContact`');
		}

		/**
		 * Truncate MemberContact table
		 * @return void
		*/
		public static function Truncate() {
			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the Query
			$objDatabase->NonQuery('
				TRUNCATE `MemberContact`');
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

				case 'LastName':
					/**
					 * Gets the value for strLastName (Not Null)
					 * @return string
					 */
					return $this->strLastName;

				case 'FirstName':
					/**
					 * Gets the value for strFirstName (Not Null)
					 * @return string
					 */
					return $this->strFirstName;

				case 'Email':
					/**
					 * Gets the value for strEmail 
					 * @return string
					 */
					return $this->strEmail;

				case 'Addr1':
					/**
					 * Gets the value for strAddr1 
					 * @return string
					 */
					return $this->strAddr1;

				case 'Addr2':
					/**
					 * Gets the value for strAddr2 
					 * @return string
					 */
					return $this->strAddr2;

				case 'City':
					/**
					 * Gets the value for strCity 
					 * @return string
					 */
					return $this->strCity;

				case 'State':
					/**
					 * Gets the value for strState 
					 * @return string
					 */
					return $this->strState;

				case 'Zip':
					/**
					 * Gets the value for strZip 
					 * @return string
					 */
					return $this->strZip;

				case 'Gender':
					/**
					 * Gets the value for strGender 
					 * @return string
					 */
					return $this->strGender;

				case 'BirthDay':
					/**
					 * Gets the value for intBirthDay 
					 * @return integer
					 */
					return $this->intBirthDay;

				case 'BirthMonth':
					/**
					 * Gets the value for intBirthMonth 
					 * @return integer
					 */
					return $this->intBirthMonth;

				case 'BirthYear':
					/**
					 * Gets the value for intBirthYear 
					 * @return integer
					 */
					return $this->intBirthYear;

				case 'MainPhone':
					/**
					 * Gets the value for strMainPhone 
					 * @return string
					 */
					return $this->strMainPhone;

				case 'AltPhone':
					/**
					 * Gets the value for strAltPhone 
					 * @return string
					 */
					return $this->strAltPhone;

				case 'Note':
					/**
					 * Gets the value for strNote 
					 * @return string
					 */
					return $this->strNote;

				case 'TransferId':
					/**
					 * Gets the value for intTransferId 
					 * @return integer
					 */
					return $this->intTransferId;

				case 'ContactAdded':
					/**
					 * Gets the value for dttContactAdded 
					 * @return QDateTime
					 */
					return $this->dttContactAdded;

				case 'GoogleEmail':
					/**
					 * Gets the value for strGoogleEmail 
					 * @return string
					 */
					return $this->strGoogleEmail;

				case 'FacebookEmail':
					/**
					 * Gets the value for strFacebookEmail 
					 * @return string
					 */
					return $this->strFacebookEmail;

				case 'JoinedClub':
					/**
					 * Gets the value for dttJoinedClub 
					 * @return QDateTime
					 */
					return $this->dttJoinedClub;

				case 'NotActive':
					/**
					 * Gets the value for blnNotActive 
					 * @return boolean
					 */
					return $this->blnNotActive;

				case 'ImageReference':
					/**
					 * Gets the value for strImageReference (Not Null)
					 * @return string
					 */
					return $this->strImageReference;


				///////////////////
				// Member Objects
				///////////////////

				////////////////////////////
				// Virtual Object References (Many to Many and Reverse References)
				// (If restored via a "Many-to" expansion)
				////////////////////////////

				case '_BusinessMemberAssocAsMemberId':
					/**
					 * Gets the value for the private _objBusinessMemberAssocAsMemberId (Read-Only)
					 * if set due to an expansion on the BusinessMemberAssoc.MemberId reverse relationship
					 * @return BusinessMemberAssoc
					 */
					return $this->_objBusinessMemberAssocAsMemberId;

				case '_BusinessMemberAssocAsMemberIdArray':
					/**
					 * Gets the value for the private _objBusinessMemberAssocAsMemberIdArray (Read-Only)
					 * if set due to an ExpandAsArray on the BusinessMemberAssoc.MemberId reverse relationship
					 * @return BusinessMemberAssoc[]
					 */
					return (array) $this->_objBusinessMemberAssocAsMemberIdArray;

				case '_FamilyMemberAssocAsFamilyMemberId':
					/**
					 * Gets the value for the private _objFamilyMemberAssocAsFamilyMemberId (Read-Only)
					 * if set due to an expansion on the FamilyMemberAssoc.FamilyMemberId reverse relationship
					 * @return FamilyMemberAssoc
					 */
					return $this->_objFamilyMemberAssocAsFamilyMemberId;

				case '_FamilyMemberAssocAsFamilyMemberIdArray':
					/**
					 * Gets the value for the private _objFamilyMemberAssocAsFamilyMemberIdArray (Read-Only)
					 * if set due to an ExpandAsArray on the FamilyMemberAssoc.FamilyMemberId reverse relationship
					 * @return FamilyMemberAssoc[]
					 */
					return (array) $this->_objFamilyMemberAssocAsFamilyMemberIdArray;

				case '_MemberAccessLogAsMemberId':
					/**
					 * Gets the value for the private _objMemberAccessLogAsMemberId (Read-Only)
					 * if set due to an expansion on the MemberAccessLog.MemberId reverse relationship
					 * @return MemberAccessLog
					 */
					return $this->_objMemberAccessLogAsMemberId;

				case '_MemberAccessLogAsMemberIdArray':
					/**
					 * Gets the value for the private _objMemberAccessLogAsMemberIdArray (Read-Only)
					 * if set due to an ExpandAsArray on the MemberAccessLog.MemberId reverse relationship
					 * @return MemberAccessLog[]
					 */
					return (array) $this->_objMemberAccessLogAsMemberIdArray;

				case '_MemberAclAssnAsMemberId':
					/**
					 * Gets the value for the private _objMemberAclAssnAsMemberId (Read-Only)
					 * if set due to an expansion on the MemberAclAssn.MemberId reverse relationship
					 * @return MemberAclAssn
					 */
					return $this->_objMemberAclAssnAsMemberId;

				case '_MemberAclAssnAsMemberIdArray':
					/**
					 * Gets the value for the private _objMemberAclAssnAsMemberIdArray (Read-Only)
					 * if set due to an ExpandAsArray on the MemberAclAssn.MemberId reverse relationship
					 * @return MemberAclAssn[]
					 */
					return (array) $this->_objMemberAclAssnAsMemberIdArray;

				case '_MemberRaceResultAsId':
					/**
					 * Gets the value for the private _objMemberRaceResultAsId (Read-Only)
					 * if set due to an expansion on the MemberRaceResult.MemberContactId reverse relationship
					 * @return MemberRaceResult
					 */
					return $this->_objMemberRaceResultAsId;

				case '_MemberRaceResultAsIdArray':
					/**
					 * Gets the value for the private _objMemberRaceResultAsIdArray (Read-Only)
					 * if set due to an ExpandAsArray on the MemberRaceResult.MemberContactId reverse relationship
					 * @return MemberRaceResult[]
					 */
					return (array) $this->_objMemberRaceResultAsIdArray;

				case '_MemberTagAssocAsMemberId':
					/**
					 * Gets the value for the private _objMemberTagAssocAsMemberId (Read-Only)
					 * if set due to an expansion on the MemberTagAssoc.MemberId reverse relationship
					 * @return MemberTagAssoc
					 */
					return $this->_objMemberTagAssocAsMemberId;

				case '_MemberTagAssocAsMemberIdArray':
					/**
					 * Gets the value for the private _objMemberTagAssocAsMemberIdArray (Read-Only)
					 * if set due to an ExpandAsArray on the MemberTagAssoc.MemberId reverse relationship
					 * @return MemberTagAssoc[]
					 */
					return (array) $this->_objMemberTagAssocAsMemberIdArray;

				case '_MembershipAssocAsMemberId':
					/**
					 * Gets the value for the private _objMembershipAssocAsMemberId (Read-Only)
					 * if set due to an expansion on the MembershipAssoc.MemberId reverse relationship
					 * @return MembershipAssoc
					 */
					return $this->_objMembershipAssocAsMemberId;

				case '_MembershipAssocAsMemberIdArray':
					/**
					 * Gets the value for the private _objMembershipAssocAsMemberIdArray (Read-Only)
					 * if set due to an ExpandAsArray on the MembershipAssoc.MemberId reverse relationship
					 * @return MembershipAssoc[]
					 */
					return (array) $this->_objMembershipAssocAsMemberIdArray;

				case '_MembershipLogAsMemberId':
					/**
					 * Gets the value for the private _objMembershipLogAsMemberId (Read-Only)
					 * if set due to an expansion on the MembershipLog.MemberId reverse relationship
					 * @return MembershipLog
					 */
					return $this->_objMembershipLogAsMemberId;

				case '_MembershipLogAsMemberIdArray':
					/**
					 * Gets the value for the private _objMembershipLogAsMemberIdArray (Read-Only)
					 * if set due to an ExpandAsArray on the MembershipLog.MemberId reverse relationship
					 * @return MembershipLog[]
					 */
					return (array) $this->_objMembershipLogAsMemberIdArray;

				case '_NotificationLogAsMemberId':
					/**
					 * Gets the value for the private _objNotificationLogAsMemberId (Read-Only)
					 * if set due to an expansion on the NotificationLog.MemberId reverse relationship
					 * @return NotificationLog
					 */
					return $this->_objNotificationLogAsMemberId;

				case '_NotificationLogAsMemberIdArray':
					/**
					 * Gets the value for the private _objNotificationLogAsMemberIdArray (Read-Only)
					 * if set due to an ExpandAsArray on the NotificationLog.MemberId reverse relationship
					 * @return NotificationLog[]
					 */
					return (array) $this->_objNotificationLogAsMemberIdArray;

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
				case 'LastName':
					/**
					 * Sets the value for strLastName (Not Null)
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strLastName = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'FirstName':
					/**
					 * Sets the value for strFirstName (Not Null)
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strFirstName = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'Email':
					/**
					 * Sets the value for strEmail 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strEmail = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'Addr1':
					/**
					 * Sets the value for strAddr1 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strAddr1 = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'Addr2':
					/**
					 * Sets the value for strAddr2 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strAddr2 = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'City':
					/**
					 * Sets the value for strCity 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strCity = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'State':
					/**
					 * Sets the value for strState 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strState = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'Zip':
					/**
					 * Sets the value for strZip 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strZip = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'Gender':
					/**
					 * Sets the value for strGender 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strGender = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'BirthDay':
					/**
					 * Sets the value for intBirthDay 
					 * @param integer $mixValue
					 * @return integer
					 */
					try {
						return ($this->intBirthDay = QType::Cast($mixValue, QType::Integer));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'BirthMonth':
					/**
					 * Sets the value for intBirthMonth 
					 * @param integer $mixValue
					 * @return integer
					 */
					try {
						return ($this->intBirthMonth = QType::Cast($mixValue, QType::Integer));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'BirthYear':
					/**
					 * Sets the value for intBirthYear 
					 * @param integer $mixValue
					 * @return integer
					 */
					try {
						return ($this->intBirthYear = QType::Cast($mixValue, QType::Integer));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'MainPhone':
					/**
					 * Sets the value for strMainPhone 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strMainPhone = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'AltPhone':
					/**
					 * Sets the value for strAltPhone 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strAltPhone = QType::Cast($mixValue, QType::String));
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

				case 'ContactAdded':
					/**
					 * Sets the value for dttContactAdded 
					 * @param QDateTime $mixValue
					 * @return QDateTime
					 */
					try {
						return ($this->dttContactAdded = QType::Cast($mixValue, QType::DateTime));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'GoogleEmail':
					/**
					 * Sets the value for strGoogleEmail 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strGoogleEmail = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'FacebookEmail':
					/**
					 * Sets the value for strFacebookEmail 
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strFacebookEmail = QType::Cast($mixValue, QType::String));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'JoinedClub':
					/**
					 * Sets the value for dttJoinedClub 
					 * @param QDateTime $mixValue
					 * @return QDateTime
					 */
					try {
						return ($this->dttJoinedClub = QType::Cast($mixValue, QType::DateTime));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'NotActive':
					/**
					 * Sets the value for blnNotActive 
					 * @param boolean $mixValue
					 * @return boolean
					 */
					try {
						return ($this->blnNotActive = QType::Cast($mixValue, QType::Boolean));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'ImageReference':
					/**
					 * Sets the value for strImageReference (Not Null)
					 * @param string $mixValue
					 * @return string
					 */
					try {
						return ($this->strImageReference = QType::Cast($mixValue, QType::String));
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

			
		
		// Related Objects' Methods for BusinessMemberAssocAsMemberId
		//-------------------------------------------------------------------

		/**
		 * Gets all associated BusinessMemberAssocsAsMemberId as an array of BusinessMemberAssoc objects
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return BusinessMemberAssoc[]
		*/ 
		public function GetBusinessMemberAssocAsMemberIdArray($objOptionalClauses = null) {
			if ((is_null($this->intId)))
				return array();

			try {
				return BusinessMemberAssoc::LoadArrayByMemberId($this->intId, $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Counts all associated BusinessMemberAssocsAsMemberId
		 * @return int
		*/ 
		public function CountBusinessMemberAssocsAsMemberId() {
			if ((is_null($this->intId)))
				return 0;

			return BusinessMemberAssoc::CountByMemberId($this->intId);
		}

		/**
		 * Associates a BusinessMemberAssocAsMemberId
		 * @param BusinessMemberAssoc $objBusinessMemberAssoc
		 * @return void
		*/ 
		public function AssociateBusinessMemberAssocAsMemberId(BusinessMemberAssoc $objBusinessMemberAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateBusinessMemberAssocAsMemberId on this unsaved MemberContact.');
			if ((is_null($objBusinessMemberAssoc->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateBusinessMemberAssocAsMemberId on this MemberContact with an unsaved BusinessMemberAssoc.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`BusinessMemberAssoc`
				SET
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objBusinessMemberAssoc->Id) . '
			');
		}

		/**
		 * Unassociates a BusinessMemberAssocAsMemberId
		 * @param BusinessMemberAssoc $objBusinessMemberAssoc
		 * @return void
		*/ 
		public function UnassociateBusinessMemberAssocAsMemberId(BusinessMemberAssoc $objBusinessMemberAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateBusinessMemberAssocAsMemberId on this unsaved MemberContact.');
			if ((is_null($objBusinessMemberAssoc->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateBusinessMemberAssocAsMemberId on this MemberContact with an unsaved BusinessMemberAssoc.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`BusinessMemberAssoc`
				SET
					`MemberId` = null
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objBusinessMemberAssoc->Id) . ' AND
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Unassociates all BusinessMemberAssocsAsMemberId
		 * @return void
		*/ 
		public function UnassociateAllBusinessMemberAssocsAsMemberId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateBusinessMemberAssocAsMemberId on this unsaved MemberContact.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`BusinessMemberAssoc`
				SET
					`MemberId` = null
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes an associated BusinessMemberAssocAsMemberId
		 * @param BusinessMemberAssoc $objBusinessMemberAssoc
		 * @return void
		*/ 
		public function DeleteAssociatedBusinessMemberAssocAsMemberId(BusinessMemberAssoc $objBusinessMemberAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateBusinessMemberAssocAsMemberId on this unsaved MemberContact.');
			if ((is_null($objBusinessMemberAssoc->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateBusinessMemberAssocAsMemberId on this MemberContact with an unsaved BusinessMemberAssoc.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`BusinessMemberAssoc`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objBusinessMemberAssoc->Id) . ' AND
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes all associated BusinessMemberAssocsAsMemberId
		 * @return void
		*/ 
		public function DeleteAllBusinessMemberAssocsAsMemberId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateBusinessMemberAssocAsMemberId on this unsaved MemberContact.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`BusinessMemberAssoc`
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

			
		
		// Related Objects' Methods for FamilyMemberAssocAsFamilyMemberId
		//-------------------------------------------------------------------

		/**
		 * Gets all associated FamilyMemberAssocsAsFamilyMemberId as an array of FamilyMemberAssoc objects
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return FamilyMemberAssoc[]
		*/ 
		public function GetFamilyMemberAssocAsFamilyMemberIdArray($objOptionalClauses = null) {
			if ((is_null($this->intId)))
				return array();

			try {
				return FamilyMemberAssoc::LoadArrayByFamilyMemberId($this->intId, $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Counts all associated FamilyMemberAssocsAsFamilyMemberId
		 * @return int
		*/ 
		public function CountFamilyMemberAssocsAsFamilyMemberId() {
			if ((is_null($this->intId)))
				return 0;

			return FamilyMemberAssoc::CountByFamilyMemberId($this->intId);
		}

		/**
		 * Associates a FamilyMemberAssocAsFamilyMemberId
		 * @param FamilyMemberAssoc $objFamilyMemberAssoc
		 * @return void
		*/ 
		public function AssociateFamilyMemberAssocAsFamilyMemberId(FamilyMemberAssoc $objFamilyMemberAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateFamilyMemberAssocAsFamilyMemberId on this unsaved MemberContact.');
			if ((is_null($objFamilyMemberAssoc->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateFamilyMemberAssocAsFamilyMemberId on this MemberContact with an unsaved FamilyMemberAssoc.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`FamilyMemberAssoc`
				SET
					`FamilyMemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objFamilyMemberAssoc->Id) . '
			');
		}

		/**
		 * Unassociates a FamilyMemberAssocAsFamilyMemberId
		 * @param FamilyMemberAssoc $objFamilyMemberAssoc
		 * @return void
		*/ 
		public function UnassociateFamilyMemberAssocAsFamilyMemberId(FamilyMemberAssoc $objFamilyMemberAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateFamilyMemberAssocAsFamilyMemberId on this unsaved MemberContact.');
			if ((is_null($objFamilyMemberAssoc->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateFamilyMemberAssocAsFamilyMemberId on this MemberContact with an unsaved FamilyMemberAssoc.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`FamilyMemberAssoc`
				SET
					`FamilyMemberId` = null
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objFamilyMemberAssoc->Id) . ' AND
					`FamilyMemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Unassociates all FamilyMemberAssocsAsFamilyMemberId
		 * @return void
		*/ 
		public function UnassociateAllFamilyMemberAssocsAsFamilyMemberId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateFamilyMemberAssocAsFamilyMemberId on this unsaved MemberContact.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`FamilyMemberAssoc`
				SET
					`FamilyMemberId` = null
				WHERE
					`FamilyMemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes an associated FamilyMemberAssocAsFamilyMemberId
		 * @param FamilyMemberAssoc $objFamilyMemberAssoc
		 * @return void
		*/ 
		public function DeleteAssociatedFamilyMemberAssocAsFamilyMemberId(FamilyMemberAssoc $objFamilyMemberAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateFamilyMemberAssocAsFamilyMemberId on this unsaved MemberContact.');
			if ((is_null($objFamilyMemberAssoc->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateFamilyMemberAssocAsFamilyMemberId on this MemberContact with an unsaved FamilyMemberAssoc.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`FamilyMemberAssoc`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objFamilyMemberAssoc->Id) . ' AND
					`FamilyMemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes all associated FamilyMemberAssocsAsFamilyMemberId
		 * @return void
		*/ 
		public function DeleteAllFamilyMemberAssocsAsFamilyMemberId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateFamilyMemberAssocAsFamilyMemberId on this unsaved MemberContact.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`FamilyMemberAssoc`
				WHERE
					`FamilyMemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

			
		
		// Related Objects' Methods for MemberAccessLogAsMemberId
		//-------------------------------------------------------------------

		/**
		 * Gets all associated MemberAccessLogsAsMemberId as an array of MemberAccessLog objects
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return MemberAccessLog[]
		*/ 
		public function GetMemberAccessLogAsMemberIdArray($objOptionalClauses = null) {
			if ((is_null($this->intId)))
				return array();

			try {
				return MemberAccessLog::LoadArrayByMemberId($this->intId, $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Counts all associated MemberAccessLogsAsMemberId
		 * @return int
		*/ 
		public function CountMemberAccessLogsAsMemberId() {
			if ((is_null($this->intId)))
				return 0;

			return MemberAccessLog::CountByMemberId($this->intId);
		}

		/**
		 * Associates a MemberAccessLogAsMemberId
		 * @param MemberAccessLog $objMemberAccessLog
		 * @return void
		*/ 
		public function AssociateMemberAccessLogAsMemberId(MemberAccessLog $objMemberAccessLog) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateMemberAccessLogAsMemberId on this unsaved MemberContact.');
			if ((is_null($objMemberAccessLog->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateMemberAccessLogAsMemberId on this MemberContact with an unsaved MemberAccessLog.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MemberAccessLog`
				SET
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMemberAccessLog->Id) . '
			');
		}

		/**
		 * Unassociates a MemberAccessLogAsMemberId
		 * @param MemberAccessLog $objMemberAccessLog
		 * @return void
		*/ 
		public function UnassociateMemberAccessLogAsMemberId(MemberAccessLog $objMemberAccessLog) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberAccessLogAsMemberId on this unsaved MemberContact.');
			if ((is_null($objMemberAccessLog->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberAccessLogAsMemberId on this MemberContact with an unsaved MemberAccessLog.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MemberAccessLog`
				SET
					`MemberId` = null
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMemberAccessLog->Id) . ' AND
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Unassociates all MemberAccessLogsAsMemberId
		 * @return void
		*/ 
		public function UnassociateAllMemberAccessLogsAsMemberId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberAccessLogAsMemberId on this unsaved MemberContact.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MemberAccessLog`
				SET
					`MemberId` = null
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes an associated MemberAccessLogAsMemberId
		 * @param MemberAccessLog $objMemberAccessLog
		 * @return void
		*/ 
		public function DeleteAssociatedMemberAccessLogAsMemberId(MemberAccessLog $objMemberAccessLog) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberAccessLogAsMemberId on this unsaved MemberContact.');
			if ((is_null($objMemberAccessLog->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberAccessLogAsMemberId on this MemberContact with an unsaved MemberAccessLog.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MemberAccessLog`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMemberAccessLog->Id) . ' AND
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes all associated MemberAccessLogsAsMemberId
		 * @return void
		*/ 
		public function DeleteAllMemberAccessLogsAsMemberId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberAccessLogAsMemberId on this unsaved MemberContact.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MemberAccessLog`
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

			
		
		// Related Objects' Methods for MemberAclAssnAsMemberId
		//-------------------------------------------------------------------

		/**
		 * Gets all associated MemberAclAssnsAsMemberId as an array of MemberAclAssn objects
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return MemberAclAssn[]
		*/ 
		public function GetMemberAclAssnAsMemberIdArray($objOptionalClauses = null) {
			if ((is_null($this->intId)))
				return array();

			try {
				return MemberAclAssn::LoadArrayByMemberId($this->intId, $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Counts all associated MemberAclAssnsAsMemberId
		 * @return int
		*/ 
		public function CountMemberAclAssnsAsMemberId() {
			if ((is_null($this->intId)))
				return 0;

			return MemberAclAssn::CountByMemberId($this->intId);
		}

		/**
		 * Associates a MemberAclAssnAsMemberId
		 * @param MemberAclAssn $objMemberAclAssn
		 * @return void
		*/ 
		public function AssociateMemberAclAssnAsMemberId(MemberAclAssn $objMemberAclAssn) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateMemberAclAssnAsMemberId on this unsaved MemberContact.');
			if ((is_null($objMemberAclAssn->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateMemberAclAssnAsMemberId on this MemberContact with an unsaved MemberAclAssn.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MemberAclAssn`
				SET
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMemberAclAssn->Id) . '
			');
		}

		/**
		 * Unassociates a MemberAclAssnAsMemberId
		 * @param MemberAclAssn $objMemberAclAssn
		 * @return void
		*/ 
		public function UnassociateMemberAclAssnAsMemberId(MemberAclAssn $objMemberAclAssn) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberAclAssnAsMemberId on this unsaved MemberContact.');
			if ((is_null($objMemberAclAssn->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberAclAssnAsMemberId on this MemberContact with an unsaved MemberAclAssn.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MemberAclAssn`
				SET
					`MemberId` = null
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMemberAclAssn->Id) . ' AND
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Unassociates all MemberAclAssnsAsMemberId
		 * @return void
		*/ 
		public function UnassociateAllMemberAclAssnsAsMemberId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberAclAssnAsMemberId on this unsaved MemberContact.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MemberAclAssn`
				SET
					`MemberId` = null
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes an associated MemberAclAssnAsMemberId
		 * @param MemberAclAssn $objMemberAclAssn
		 * @return void
		*/ 
		public function DeleteAssociatedMemberAclAssnAsMemberId(MemberAclAssn $objMemberAclAssn) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberAclAssnAsMemberId on this unsaved MemberContact.');
			if ((is_null($objMemberAclAssn->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberAclAssnAsMemberId on this MemberContact with an unsaved MemberAclAssn.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MemberAclAssn`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMemberAclAssn->Id) . ' AND
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes all associated MemberAclAssnsAsMemberId
		 * @return void
		*/ 
		public function DeleteAllMemberAclAssnsAsMemberId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberAclAssnAsMemberId on this unsaved MemberContact.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MemberAclAssn`
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

			
		
		// Related Objects' Methods for MemberRaceResultAsId
		//-------------------------------------------------------------------

		/**
		 * Gets all associated MemberRaceResultsAsId as an array of MemberRaceResult objects
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return MemberRaceResult[]
		*/ 
		public function GetMemberRaceResultAsIdArray($objOptionalClauses = null) {
			if ((is_null($this->intId)))
				return array();

			try {
				return MemberRaceResult::LoadArrayByMemberContactId($this->intId, $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Counts all associated MemberRaceResultsAsId
		 * @return int
		*/ 
		public function CountMemberRaceResultsAsId() {
			if ((is_null($this->intId)))
				return 0;

			return MemberRaceResult::CountByMemberContactId($this->intId);
		}

		/**
		 * Associates a MemberRaceResultAsId
		 * @param MemberRaceResult $objMemberRaceResult
		 * @return void
		*/ 
		public function AssociateMemberRaceResultAsId(MemberRaceResult $objMemberRaceResult) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateMemberRaceResultAsId on this unsaved MemberContact.');
			if ((is_null($objMemberRaceResult->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateMemberRaceResultAsId on this MemberContact with an unsaved MemberRaceResult.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MemberRaceResult`
				SET
					`MemberContactId` = ' . $objDatabase->SqlVariable($this->intId) . '
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMemberRaceResult->Id) . '
			');
		}

		/**
		 * Unassociates a MemberRaceResultAsId
		 * @param MemberRaceResult $objMemberRaceResult
		 * @return void
		*/ 
		public function UnassociateMemberRaceResultAsId(MemberRaceResult $objMemberRaceResult) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberRaceResultAsId on this unsaved MemberContact.');
			if ((is_null($objMemberRaceResult->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberRaceResultAsId on this MemberContact with an unsaved MemberRaceResult.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MemberRaceResult`
				SET
					`MemberContactId` = null
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMemberRaceResult->Id) . ' AND
					`MemberContactId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Unassociates all MemberRaceResultsAsId
		 * @return void
		*/ 
		public function UnassociateAllMemberRaceResultsAsId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberRaceResultAsId on this unsaved MemberContact.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MemberRaceResult`
				SET
					`MemberContactId` = null
				WHERE
					`MemberContactId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes an associated MemberRaceResultAsId
		 * @param MemberRaceResult $objMemberRaceResult
		 * @return void
		*/ 
		public function DeleteAssociatedMemberRaceResultAsId(MemberRaceResult $objMemberRaceResult) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberRaceResultAsId on this unsaved MemberContact.');
			if ((is_null($objMemberRaceResult->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberRaceResultAsId on this MemberContact with an unsaved MemberRaceResult.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MemberRaceResult`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMemberRaceResult->Id) . ' AND
					`MemberContactId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes all associated MemberRaceResultsAsId
		 * @return void
		*/ 
		public function DeleteAllMemberRaceResultsAsId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberRaceResultAsId on this unsaved MemberContact.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MemberRaceResult`
				WHERE
					`MemberContactId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

			
		
		// Related Objects' Methods for MemberTagAssocAsMemberId
		//-------------------------------------------------------------------

		/**
		 * Gets all associated MemberTagAssocsAsMemberId as an array of MemberTagAssoc objects
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return MemberTagAssoc[]
		*/ 
		public function GetMemberTagAssocAsMemberIdArray($objOptionalClauses = null) {
			if ((is_null($this->intId)))
				return array();

			try {
				return MemberTagAssoc::LoadArrayByMemberId($this->intId, $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Counts all associated MemberTagAssocsAsMemberId
		 * @return int
		*/ 
		public function CountMemberTagAssocsAsMemberId() {
			if ((is_null($this->intId)))
				return 0;

			return MemberTagAssoc::CountByMemberId($this->intId);
		}

		/**
		 * Associates a MemberTagAssocAsMemberId
		 * @param MemberTagAssoc $objMemberTagAssoc
		 * @return void
		*/ 
		public function AssociateMemberTagAssocAsMemberId(MemberTagAssoc $objMemberTagAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateMemberTagAssocAsMemberId on this unsaved MemberContact.');
			if ((is_null($objMemberTagAssoc->MemberId)) || (is_null($objMemberTagAssoc->TagId)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateMemberTagAssocAsMemberId on this MemberContact with an unsaved MemberTagAssoc.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MemberTagAssoc`
				SET
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($objMemberTagAssoc->MemberId) . ' AND
					`TagId` = ' . $objDatabase->SqlVariable($objMemberTagAssoc->TagId) . '
			');
		}

		/**
		 * Unassociates a MemberTagAssocAsMemberId
		 * @param MemberTagAssoc $objMemberTagAssoc
		 * @return void
		*/ 
		public function UnassociateMemberTagAssocAsMemberId(MemberTagAssoc $objMemberTagAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberTagAssocAsMemberId on this unsaved MemberContact.');
			if ((is_null($objMemberTagAssoc->MemberId)) || (is_null($objMemberTagAssoc->TagId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberTagAssocAsMemberId on this MemberContact with an unsaved MemberTagAssoc.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MemberTagAssoc`
				SET
					`MemberId` = null
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($objMemberTagAssoc->MemberId) . ' AND
					`TagId` = ' . $objDatabase->SqlVariable($objMemberTagAssoc->TagId) . ' AND
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Unassociates all MemberTagAssocsAsMemberId
		 * @return void
		*/ 
		public function UnassociateAllMemberTagAssocsAsMemberId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberTagAssocAsMemberId on this unsaved MemberContact.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MemberTagAssoc`
				SET
					`MemberId` = null
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes an associated MemberTagAssocAsMemberId
		 * @param MemberTagAssoc $objMemberTagAssoc
		 * @return void
		*/ 
		public function DeleteAssociatedMemberTagAssocAsMemberId(MemberTagAssoc $objMemberTagAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberTagAssocAsMemberId on this unsaved MemberContact.');
			if ((is_null($objMemberTagAssoc->MemberId)) || (is_null($objMemberTagAssoc->TagId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberTagAssocAsMemberId on this MemberContact with an unsaved MemberTagAssoc.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MemberTagAssoc`
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($objMemberTagAssoc->MemberId) . ' AND
					`TagId` = ' . $objDatabase->SqlVariable($objMemberTagAssoc->TagId) . ' AND
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes all associated MemberTagAssocsAsMemberId
		 * @return void
		*/ 
		public function DeleteAllMemberTagAssocsAsMemberId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMemberTagAssocAsMemberId on this unsaved MemberContact.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MemberTagAssoc`
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

			
		
		// Related Objects' Methods for MembershipAssocAsMemberId
		//-------------------------------------------------------------------

		/**
		 * Gets all associated MembershipAssocsAsMemberId as an array of MembershipAssoc objects
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return MembershipAssoc[]
		*/ 
		public function GetMembershipAssocAsMemberIdArray($objOptionalClauses = null) {
			if ((is_null($this->intId)))
				return array();

			try {
				return MembershipAssoc::LoadArrayByMemberId($this->intId, $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Counts all associated MembershipAssocsAsMemberId
		 * @return int
		*/ 
		public function CountMembershipAssocsAsMemberId() {
			if ((is_null($this->intId)))
				return 0;

			return MembershipAssoc::CountByMemberId($this->intId);
		}

		/**
		 * Associates a MembershipAssocAsMemberId
		 * @param MembershipAssoc $objMembershipAssoc
		 * @return void
		*/ 
		public function AssociateMembershipAssocAsMemberId(MembershipAssoc $objMembershipAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateMembershipAssocAsMemberId on this unsaved MemberContact.');
			if ((is_null($objMembershipAssoc->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateMembershipAssocAsMemberId on this MemberContact with an unsaved MembershipAssoc.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MembershipAssoc`
				SET
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMembershipAssoc->Id) . '
			');
		}

		/**
		 * Unassociates a MembershipAssocAsMemberId
		 * @param MembershipAssoc $objMembershipAssoc
		 * @return void
		*/ 
		public function UnassociateMembershipAssocAsMemberId(MembershipAssoc $objMembershipAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMembershipAssocAsMemberId on this unsaved MemberContact.');
			if ((is_null($objMembershipAssoc->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMembershipAssocAsMemberId on this MemberContact with an unsaved MembershipAssoc.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MembershipAssoc`
				SET
					`MemberId` = null
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMembershipAssoc->Id) . ' AND
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Unassociates all MembershipAssocsAsMemberId
		 * @return void
		*/ 
		public function UnassociateAllMembershipAssocsAsMemberId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMembershipAssocAsMemberId on this unsaved MemberContact.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MembershipAssoc`
				SET
					`MemberId` = null
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes an associated MembershipAssocAsMemberId
		 * @param MembershipAssoc $objMembershipAssoc
		 * @return void
		*/ 
		public function DeleteAssociatedMembershipAssocAsMemberId(MembershipAssoc $objMembershipAssoc) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMembershipAssocAsMemberId on this unsaved MemberContact.');
			if ((is_null($objMembershipAssoc->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMembershipAssocAsMemberId on this MemberContact with an unsaved MembershipAssoc.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MembershipAssoc`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMembershipAssoc->Id) . ' AND
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes all associated MembershipAssocsAsMemberId
		 * @return void
		*/ 
		public function DeleteAllMembershipAssocsAsMemberId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMembershipAssocAsMemberId on this unsaved MemberContact.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MembershipAssoc`
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

			
		
		// Related Objects' Methods for MembershipLogAsMemberId
		//-------------------------------------------------------------------

		/**
		 * Gets all associated MembershipLogsAsMemberId as an array of MembershipLog objects
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return MembershipLog[]
		*/ 
		public function GetMembershipLogAsMemberIdArray($objOptionalClauses = null) {
			if ((is_null($this->intId)))
				return array();

			try {
				return MembershipLog::LoadArrayByMemberId($this->intId, $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Counts all associated MembershipLogsAsMemberId
		 * @return int
		*/ 
		public function CountMembershipLogsAsMemberId() {
			if ((is_null($this->intId)))
				return 0;

			return MembershipLog::CountByMemberId($this->intId);
		}

		/**
		 * Associates a MembershipLogAsMemberId
		 * @param MembershipLog $objMembershipLog
		 * @return void
		*/ 
		public function AssociateMembershipLogAsMemberId(MembershipLog $objMembershipLog) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateMembershipLogAsMemberId on this unsaved MemberContact.');
			if ((is_null($objMembershipLog->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateMembershipLogAsMemberId on this MemberContact with an unsaved MembershipLog.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MembershipLog`
				SET
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMembershipLog->Id) . '
			');
		}

		/**
		 * Unassociates a MembershipLogAsMemberId
		 * @param MembershipLog $objMembershipLog
		 * @return void
		*/ 
		public function UnassociateMembershipLogAsMemberId(MembershipLog $objMembershipLog) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMembershipLogAsMemberId on this unsaved MemberContact.');
			if ((is_null($objMembershipLog->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMembershipLogAsMemberId on this MemberContact with an unsaved MembershipLog.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MembershipLog`
				SET
					`MemberId` = null
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMembershipLog->Id) . ' AND
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Unassociates all MembershipLogsAsMemberId
		 * @return void
		*/ 
		public function UnassociateAllMembershipLogsAsMemberId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMembershipLogAsMemberId on this unsaved MemberContact.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`MembershipLog`
				SET
					`MemberId` = null
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes an associated MembershipLogAsMemberId
		 * @param MembershipLog $objMembershipLog
		 * @return void
		*/ 
		public function DeleteAssociatedMembershipLogAsMemberId(MembershipLog $objMembershipLog) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMembershipLogAsMemberId on this unsaved MemberContact.');
			if ((is_null($objMembershipLog->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMembershipLogAsMemberId on this MemberContact with an unsaved MembershipLog.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MembershipLog`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objMembershipLog->Id) . ' AND
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes all associated MembershipLogsAsMemberId
		 * @return void
		*/ 
		public function DeleteAllMembershipLogsAsMemberId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateMembershipLogAsMemberId on this unsaved MemberContact.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MembershipLog`
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

			
		
		// Related Objects' Methods for NotificationLogAsMemberId
		//-------------------------------------------------------------------

		/**
		 * Gets all associated NotificationLogsAsMemberId as an array of NotificationLog objects
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return NotificationLog[]
		*/ 
		public function GetNotificationLogAsMemberIdArray($objOptionalClauses = null) {
			if ((is_null($this->intId)))
				return array();

			try {
				return NotificationLog::LoadArrayByMemberId($this->intId, $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Counts all associated NotificationLogsAsMemberId
		 * @return int
		*/ 
		public function CountNotificationLogsAsMemberId() {
			if ((is_null($this->intId)))
				return 0;

			return NotificationLog::CountByMemberId($this->intId);
		}

		/**
		 * Associates a NotificationLogAsMemberId
		 * @param NotificationLog $objNotificationLog
		 * @return void
		*/ 
		public function AssociateNotificationLogAsMemberId(NotificationLog $objNotificationLog) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateNotificationLogAsMemberId on this unsaved MemberContact.');
			if ((is_null($objNotificationLog->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociateNotificationLogAsMemberId on this MemberContact with an unsaved NotificationLog.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`NotificationLog`
				SET
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objNotificationLog->Id) . '
			');
		}

		/**
		 * Unassociates a NotificationLogAsMemberId
		 * @param NotificationLog $objNotificationLog
		 * @return void
		*/ 
		public function UnassociateNotificationLogAsMemberId(NotificationLog $objNotificationLog) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateNotificationLogAsMemberId on this unsaved MemberContact.');
			if ((is_null($objNotificationLog->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateNotificationLogAsMemberId on this MemberContact with an unsaved NotificationLog.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`NotificationLog`
				SET
					`MemberId` = null
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objNotificationLog->Id) . ' AND
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Unassociates all NotificationLogsAsMemberId
		 * @return void
		*/ 
		public function UnassociateAllNotificationLogsAsMemberId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateNotificationLogAsMemberId on this unsaved MemberContact.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				UPDATE
					`NotificationLog`
				SET
					`MemberId` = null
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes an associated NotificationLogAsMemberId
		 * @param NotificationLog $objNotificationLog
		 * @return void
		*/ 
		public function DeleteAssociatedNotificationLogAsMemberId(NotificationLog $objNotificationLog) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateNotificationLogAsMemberId on this unsaved MemberContact.');
			if ((is_null($objNotificationLog->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateNotificationLogAsMemberId on this MemberContact with an unsaved NotificationLog.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`NotificationLog`
				WHERE
					`Id` = ' . $objDatabase->SqlVariable($objNotificationLog->Id) . ' AND
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}

		/**
		 * Deletes all associated NotificationLogsAsMemberId
		 * @return void
		*/ 
		public function DeleteAllNotificationLogsAsMemberId() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateNotificationLogAsMemberId on this unsaved MemberContact.');

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`NotificationLog`
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '
			');
		}




		///////////////////////////////////////////////////////////////////////
		// PROTECTED MEMBER VARIABLES and TEXT FIELD MAXLENGTHS (if applicable)
		///////////////////////////////////////////////////////////////////////
		
		/**
		 * Protected member variable that maps to the database PK Identity column MemberContact.Id
		 * @var integer intId
		 */
		protected $intId;
		const IdDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.LastName
		 * @var string strLastName
		 */
		protected $strLastName;
		const LastNameMaxLength = 25;
		const LastNameDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.FirstName
		 * @var string strFirstName
		 */
		protected $strFirstName;
		const FirstNameMaxLength = 25;
		const FirstNameDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.Email
		 * @var string strEmail
		 */
		protected $strEmail;
		const EmailMaxLength = 50;
		const EmailDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.Addr1
		 * @var string strAddr1
		 */
		protected $strAddr1;
		const Addr1MaxLength = 50;
		const Addr1Default = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.Addr2
		 * @var string strAddr2
		 */
		protected $strAddr2;
		const Addr2MaxLength = 50;
		const Addr2Default = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.City
		 * @var string strCity
		 */
		protected $strCity;
		const CityMaxLength = 25;
		const CityDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.State
		 * @var string strState
		 */
		protected $strState;
		const StateMaxLength = 2;
		const StateDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.Zip
		 * @var string strZip
		 */
		protected $strZip;
		const ZipMaxLength = 10;
		const ZipDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.Gender
		 * @var string strGender
		 */
		protected $strGender;
		const GenderMaxLength = 1;
		const GenderDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.BirthDay
		 * @var integer intBirthDay
		 */
		protected $intBirthDay;
		const BirthDayDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.BirthMonth
		 * @var integer intBirthMonth
		 */
		protected $intBirthMonth;
		const BirthMonthDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.BirthYear
		 * @var integer intBirthYear
		 */
		protected $intBirthYear;
		const BirthYearDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.MainPhone
		 * @var string strMainPhone
		 */
		protected $strMainPhone;
		const MainPhoneMaxLength = 15;
		const MainPhoneDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.AltPhone
		 * @var string strAltPhone
		 */
		protected $strAltPhone;
		const AltPhoneMaxLength = 15;
		const AltPhoneDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.Note
		 * @var string strNote
		 */
		protected $strNote;
		const NoteMaxLength = 300;
		const NoteDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.transferId
		 * @var integer intTransferId
		 */
		protected $intTransferId;
		const TransferIdDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.ContactAdded
		 * @var QDateTime dttContactAdded
		 */
		protected $dttContactAdded;
		const ContactAddedDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.GoogleEmail
		 * @var string strGoogleEmail
		 */
		protected $strGoogleEmail;
		const GoogleEmailMaxLength = 50;
		const GoogleEmailDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.FacebookEmail
		 * @var string strFacebookEmail
		 */
		protected $strFacebookEmail;
		const FacebookEmailMaxLength = 50;
		const FacebookEmailDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.JoinedClub
		 * @var QDateTime dttJoinedClub
		 */
		protected $dttJoinedClub;
		const JoinedClubDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.NotActive
		 * @var boolean blnNotActive
		 */
		protected $blnNotActive;
		const NotActiveDefault = null;


		/**
		 * Protected member variable that maps to the database column MemberContact.ImageReference
		 * @var string strImageReference
		 */
		protected $strImageReference;
		const ImageReferenceMaxLength = 500;
		const ImageReferenceDefault = null;


		/**
		 * Private member variable that stores a reference to a single BusinessMemberAssocAsMemberId object
		 * (of type BusinessMemberAssoc), if this MemberContact object was restored with
		 * an expansion on the BusinessMemberAssoc association table.
		 * @var BusinessMemberAssoc _objBusinessMemberAssocAsMemberId;
		 */
		private $_objBusinessMemberAssocAsMemberId;

		/**
		 * Private member variable that stores a reference to an array of BusinessMemberAssocAsMemberId objects
		 * (of type BusinessMemberAssoc[]), if this MemberContact object was restored with
		 * an ExpandAsArray on the BusinessMemberAssoc association table.
		 * @var BusinessMemberAssoc[] _objBusinessMemberAssocAsMemberIdArray;
		 */
		private $_objBusinessMemberAssocAsMemberIdArray = array();

		/**
		 * Private member variable that stores a reference to a single FamilyMemberAssocAsFamilyMemberId object
		 * (of type FamilyMemberAssoc), if this MemberContact object was restored with
		 * an expansion on the FamilyMemberAssoc association table.
		 * @var FamilyMemberAssoc _objFamilyMemberAssocAsFamilyMemberId;
		 */
		private $_objFamilyMemberAssocAsFamilyMemberId;

		/**
		 * Private member variable that stores a reference to an array of FamilyMemberAssocAsFamilyMemberId objects
		 * (of type FamilyMemberAssoc[]), if this MemberContact object was restored with
		 * an ExpandAsArray on the FamilyMemberAssoc association table.
		 * @var FamilyMemberAssoc[] _objFamilyMemberAssocAsFamilyMemberIdArray;
		 */
		private $_objFamilyMemberAssocAsFamilyMemberIdArray = array();

		/**
		 * Private member variable that stores a reference to a single MemberAccessLogAsMemberId object
		 * (of type MemberAccessLog), if this MemberContact object was restored with
		 * an expansion on the MemberAccessLog association table.
		 * @var MemberAccessLog _objMemberAccessLogAsMemberId;
		 */
		private $_objMemberAccessLogAsMemberId;

		/**
		 * Private member variable that stores a reference to an array of MemberAccessLogAsMemberId objects
		 * (of type MemberAccessLog[]), if this MemberContact object was restored with
		 * an ExpandAsArray on the MemberAccessLog association table.
		 * @var MemberAccessLog[] _objMemberAccessLogAsMemberIdArray;
		 */
		private $_objMemberAccessLogAsMemberIdArray = array();

		/**
		 * Private member variable that stores a reference to a single MemberAclAssnAsMemberId object
		 * (of type MemberAclAssn), if this MemberContact object was restored with
		 * an expansion on the MemberAclAssn association table.
		 * @var MemberAclAssn _objMemberAclAssnAsMemberId;
		 */
		private $_objMemberAclAssnAsMemberId;

		/**
		 * Private member variable that stores a reference to an array of MemberAclAssnAsMemberId objects
		 * (of type MemberAclAssn[]), if this MemberContact object was restored with
		 * an ExpandAsArray on the MemberAclAssn association table.
		 * @var MemberAclAssn[] _objMemberAclAssnAsMemberIdArray;
		 */
		private $_objMemberAclAssnAsMemberIdArray = array();

		/**
		 * Private member variable that stores a reference to a single MemberRaceResultAsId object
		 * (of type MemberRaceResult), if this MemberContact object was restored with
		 * an expansion on the MemberRaceResult association table.
		 * @var MemberRaceResult _objMemberRaceResultAsId;
		 */
		private $_objMemberRaceResultAsId;

		/**
		 * Private member variable that stores a reference to an array of MemberRaceResultAsId objects
		 * (of type MemberRaceResult[]), if this MemberContact object was restored with
		 * an ExpandAsArray on the MemberRaceResult association table.
		 * @var MemberRaceResult[] _objMemberRaceResultAsIdArray;
		 */
		private $_objMemberRaceResultAsIdArray = array();

		/**
		 * Private member variable that stores a reference to a single MemberTagAssocAsMemberId object
		 * (of type MemberTagAssoc), if this MemberContact object was restored with
		 * an expansion on the MemberTagAssoc association table.
		 * @var MemberTagAssoc _objMemberTagAssocAsMemberId;
		 */
		private $_objMemberTagAssocAsMemberId;

		/**
		 * Private member variable that stores a reference to an array of MemberTagAssocAsMemberId objects
		 * (of type MemberTagAssoc[]), if this MemberContact object was restored with
		 * an ExpandAsArray on the MemberTagAssoc association table.
		 * @var MemberTagAssoc[] _objMemberTagAssocAsMemberIdArray;
		 */
		private $_objMemberTagAssocAsMemberIdArray = array();

		/**
		 * Private member variable that stores a reference to a single MembershipAssocAsMemberId object
		 * (of type MembershipAssoc), if this MemberContact object was restored with
		 * an expansion on the MembershipAssoc association table.
		 * @var MembershipAssoc _objMembershipAssocAsMemberId;
		 */
		private $_objMembershipAssocAsMemberId;

		/**
		 * Private member variable that stores a reference to an array of MembershipAssocAsMemberId objects
		 * (of type MembershipAssoc[]), if this MemberContact object was restored with
		 * an ExpandAsArray on the MembershipAssoc association table.
		 * @var MembershipAssoc[] _objMembershipAssocAsMemberIdArray;
		 */
		private $_objMembershipAssocAsMemberIdArray = array();

		/**
		 * Private member variable that stores a reference to a single MembershipLogAsMemberId object
		 * (of type MembershipLog), if this MemberContact object was restored with
		 * an expansion on the MembershipLog association table.
		 * @var MembershipLog _objMembershipLogAsMemberId;
		 */
		private $_objMembershipLogAsMemberId;

		/**
		 * Private member variable that stores a reference to an array of MembershipLogAsMemberId objects
		 * (of type MembershipLog[]), if this MemberContact object was restored with
		 * an ExpandAsArray on the MembershipLog association table.
		 * @var MembershipLog[] _objMembershipLogAsMemberIdArray;
		 */
		private $_objMembershipLogAsMemberIdArray = array();

		/**
		 * Private member variable that stores a reference to a single NotificationLogAsMemberId object
		 * (of type NotificationLog), if this MemberContact object was restored with
		 * an expansion on the NotificationLog association table.
		 * @var NotificationLog _objNotificationLogAsMemberId;
		 */
		private $_objNotificationLogAsMemberId;

		/**
		 * Private member variable that stores a reference to an array of NotificationLogAsMemberId objects
		 * (of type NotificationLog[]), if this MemberContact object was restored with
		 * an ExpandAsArray on the NotificationLog association table.
		 * @var NotificationLog[] _objNotificationLogAsMemberIdArray;
		 */
		private $_objNotificationLogAsMemberIdArray = array();

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
			$strToReturn = '<complexType name="MemberContact"><sequence>';
			$strToReturn .= '<element name="Id" type="xsd:int"/>';
			$strToReturn .= '<element name="LastName" type="xsd:string"/>';
			$strToReturn .= '<element name="FirstName" type="xsd:string"/>';
			$strToReturn .= '<element name="Email" type="xsd:string"/>';
			$strToReturn .= '<element name="Addr1" type="xsd:string"/>';
			$strToReturn .= '<element name="Addr2" type="xsd:string"/>';
			$strToReturn .= '<element name="City" type="xsd:string"/>';
			$strToReturn .= '<element name="State" type="xsd:string"/>';
			$strToReturn .= '<element name="Zip" type="xsd:string"/>';
			$strToReturn .= '<element name="Gender" type="xsd:string"/>';
			$strToReturn .= '<element name="BirthDay" type="xsd:int"/>';
			$strToReturn .= '<element name="BirthMonth" type="xsd:int"/>';
			$strToReturn .= '<element name="BirthYear" type="xsd:int"/>';
			$strToReturn .= '<element name="MainPhone" type="xsd:string"/>';
			$strToReturn .= '<element name="AltPhone" type="xsd:string"/>';
			$strToReturn .= '<element name="Note" type="xsd:string"/>';
			$strToReturn .= '<element name="TransferId" type="xsd:int"/>';
			$strToReturn .= '<element name="ContactAdded" type="xsd:dateTime"/>';
			$strToReturn .= '<element name="GoogleEmail" type="xsd:string"/>';
			$strToReturn .= '<element name="FacebookEmail" type="xsd:string"/>';
			$strToReturn .= '<element name="JoinedClub" type="xsd:dateTime"/>';
			$strToReturn .= '<element name="NotActive" type="xsd:boolean"/>';
			$strToReturn .= '<element name="ImageReference" type="xsd:string"/>';
			$strToReturn .= '<element name="__blnRestored" type="xsd:boolean"/>';
			$strToReturn .= '</sequence></complexType>';
			return $strToReturn;
		}

		public static function AlterSoapComplexTypeArray(&$strComplexTypeArray) {
			if (!array_key_exists('MemberContact', $strComplexTypeArray)) {
				$strComplexTypeArray['MemberContact'] = MemberContact::GetSoapComplexTypeXml();
			}
		}

		public static function GetArrayFromSoapArray($objSoapArray) {
			$objArrayToReturn = array();

			foreach ($objSoapArray as $objSoapObject)
				array_push($objArrayToReturn, MemberContact::GetObjectFromSoapObject($objSoapObject));

			return $objArrayToReturn;
		}

		public static function GetObjectFromSoapObject($objSoapObject) {
			$objToReturn = new MemberContact();
			if (property_exists($objSoapObject, 'Id'))
				$objToReturn->intId = $objSoapObject->Id;
			if (property_exists($objSoapObject, 'LastName'))
				$objToReturn->strLastName = $objSoapObject->LastName;
			if (property_exists($objSoapObject, 'FirstName'))
				$objToReturn->strFirstName = $objSoapObject->FirstName;
			if (property_exists($objSoapObject, 'Email'))
				$objToReturn->strEmail = $objSoapObject->Email;
			if (property_exists($objSoapObject, 'Addr1'))
				$objToReturn->strAddr1 = $objSoapObject->Addr1;
			if (property_exists($objSoapObject, 'Addr2'))
				$objToReturn->strAddr2 = $objSoapObject->Addr2;
			if (property_exists($objSoapObject, 'City'))
				$objToReturn->strCity = $objSoapObject->City;
			if (property_exists($objSoapObject, 'State'))
				$objToReturn->strState = $objSoapObject->State;
			if (property_exists($objSoapObject, 'Zip'))
				$objToReturn->strZip = $objSoapObject->Zip;
			if (property_exists($objSoapObject, 'Gender'))
				$objToReturn->strGender = $objSoapObject->Gender;
			if (property_exists($objSoapObject, 'BirthDay'))
				$objToReturn->intBirthDay = $objSoapObject->BirthDay;
			if (property_exists($objSoapObject, 'BirthMonth'))
				$objToReturn->intBirthMonth = $objSoapObject->BirthMonth;
			if (property_exists($objSoapObject, 'BirthYear'))
				$objToReturn->intBirthYear = $objSoapObject->BirthYear;
			if (property_exists($objSoapObject, 'MainPhone'))
				$objToReturn->strMainPhone = $objSoapObject->MainPhone;
			if (property_exists($objSoapObject, 'AltPhone'))
				$objToReturn->strAltPhone = $objSoapObject->AltPhone;
			if (property_exists($objSoapObject, 'Note'))
				$objToReturn->strNote = $objSoapObject->Note;
			if (property_exists($objSoapObject, 'TransferId'))
				$objToReturn->intTransferId = $objSoapObject->TransferId;
			if (property_exists($objSoapObject, 'ContactAdded'))
				$objToReturn->dttContactAdded = new QDateTime($objSoapObject->ContactAdded);
			if (property_exists($objSoapObject, 'GoogleEmail'))
				$objToReturn->strGoogleEmail = $objSoapObject->GoogleEmail;
			if (property_exists($objSoapObject, 'FacebookEmail'))
				$objToReturn->strFacebookEmail = $objSoapObject->FacebookEmail;
			if (property_exists($objSoapObject, 'JoinedClub'))
				$objToReturn->dttJoinedClub = new QDateTime($objSoapObject->JoinedClub);
			if (property_exists($objSoapObject, 'NotActive'))
				$objToReturn->blnNotActive = $objSoapObject->NotActive;
			if (property_exists($objSoapObject, 'ImageReference'))
				$objToReturn->strImageReference = $objSoapObject->ImageReference;
			if (property_exists($objSoapObject, '__blnRestored'))
				$objToReturn->__blnRestored = $objSoapObject->__blnRestored;
			return $objToReturn;
		}

		public static function GetSoapArrayFromArray($objArray) {
			if (!$objArray)
				return null;

			$objArrayToReturn = array();

			foreach ($objArray as $objObject)
				array_push($objArrayToReturn, MemberContact::GetSoapObjectFromObject($objObject, true));

			return unserialize(serialize($objArrayToReturn ?? '') ?? '');
		}

		public static function GetSoapObjectFromObject($objObject, $blnBindRelatedObjects) {
			if ($objObject->dttContactAdded)
				$objObject->dttContactAdded = $objObject->dttContactAdded->toString(QDateTime::FormatSoap);
			if ($objObject->dttJoinedClub)
				$objObject->dttJoinedClub = $objObject->dttJoinedClub->toString(QDateTime::FormatSoap);
			return $objObject;
		}
	}





	/////////////////////////////////////
	// ADDITIONAL CLASSES for QCODO QUERY
	/////////////////////////////////////

	class QQNodeMemberContact extends QQNode {
		protected $strTableName = 'MemberContact';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'MemberContact';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'LastName':
					return new QQNode('LastName', 'string', $this);
				case 'FirstName':
					return new QQNode('FirstName', 'string', $this);
				case 'Email':
					return new QQNode('Email', 'string', $this);
				case 'Addr1':
					return new QQNode('Addr1', 'string', $this);
				case 'Addr2':
					return new QQNode('Addr2', 'string', $this);
				case 'City':
					return new QQNode('City', 'string', $this);
				case 'State':
					return new QQNode('State', 'string', $this);
				case 'Zip':
					return new QQNode('Zip', 'string', $this);
				case 'Gender':
					return new QQNode('Gender', 'string', $this);
				case 'BirthDay':
					return new QQNode('BirthDay', 'integer', $this);
				case 'BirthMonth':
					return new QQNode('BirthMonth', 'integer', $this);
				case 'BirthYear':
					return new QQNode('BirthYear', 'integer', $this);
				case 'MainPhone':
					return new QQNode('MainPhone', 'string', $this);
				case 'AltPhone':
					return new QQNode('AltPhone', 'string', $this);
				case 'Note':
					return new QQNode('Note', 'string', $this);
				case 'TransferId':
					return new QQNode('transferId', 'integer', $this);
				case 'ContactAdded':
					return new QQNode('ContactAdded', 'QDateTime', $this);
				case 'GoogleEmail':
					return new QQNode('GoogleEmail', 'string', $this);
				case 'FacebookEmail':
					return new QQNode('FacebookEmail', 'string', $this);
				case 'JoinedClub':
					return new QQNode('JoinedClub', 'QDateTime', $this);
				case 'NotActive':
					return new QQNode('NotActive', 'boolean', $this);
				case 'ImageReference':
					return new QQNode('ImageReference', 'string', $this);
				case 'BusinessMemberAssocAsMemberId':
					return new QQReverseReferenceNodeBusinessMemberAssoc($this, 'businessmemberassocasmemberid', 'reverse_reference', 'MemberId');
				case 'FamilyMemberAssocAsFamilyMemberId':
					return new QQReverseReferenceNodeFamilyMemberAssoc($this, 'familymemberassocasfamilymemberid', 'reverse_reference', 'FamilyMemberId');
				case 'MemberAccessLogAsMemberId':
					return new QQReverseReferenceNodeMemberAccessLog($this, 'memberaccesslogasmemberid', 'reverse_reference', 'MemberId');
				case 'MemberAclAssnAsMemberId':
					return new QQReverseReferenceNodeMemberAclAssn($this, 'memberaclassnasmemberid', 'reverse_reference', 'MemberId');
				case 'MemberRaceResultAsId':
					return new QQReverseReferenceNodeMemberRaceResult($this, 'memberraceresultasid', 'reverse_reference', 'MemberContactId');
				case 'MemberTagAssocAsMemberId':
					return new QQReverseReferenceNodeMemberTagAssoc($this, 'membertagassocasmemberid', 'reverse_reference', 'MemberId');
				case 'MembershipAssocAsMemberId':
					return new QQReverseReferenceNodeMembershipAssoc($this, 'membershipassocasmemberid', 'reverse_reference', 'MemberId');
				case 'MembershipLogAsMemberId':
					return new QQReverseReferenceNodeMembershipLog($this, 'membershiplogasmemberid', 'reverse_reference', 'MemberId');
				case 'NotificationLogAsMemberId':
					return new QQReverseReferenceNodeNotificationLog($this, 'notificationlogasmemberid', 'reverse_reference', 'MemberId');

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

	class QQReverseReferenceNodeMemberContact extends QQReverseReferenceNode {
		protected $strTableName = 'MemberContact';
		protected $strPrimaryKey = 'Id';
		protected $strClassName = 'MemberContact';
		protected $strDbSchema = '';	// wpg - added so we would have the database schema
		
		public function __get($strName) {
			switch ($strName) {
				case 'Id':
					return new QQNode('Id', 'integer', $this);
				case 'LastName':
					return new QQNode('LastName', 'string', $this);
				case 'FirstName':
					return new QQNode('FirstName', 'string', $this);
				case 'Email':
					return new QQNode('Email', 'string', $this);
				case 'Addr1':
					return new QQNode('Addr1', 'string', $this);
				case 'Addr2':
					return new QQNode('Addr2', 'string', $this);
				case 'City':
					return new QQNode('City', 'string', $this);
				case 'State':
					return new QQNode('State', 'string', $this);
				case 'Zip':
					return new QQNode('Zip', 'string', $this);
				case 'Gender':
					return new QQNode('Gender', 'string', $this);
				case 'BirthDay':
					return new QQNode('BirthDay', 'integer', $this);
				case 'BirthMonth':
					return new QQNode('BirthMonth', 'integer', $this);
				case 'BirthYear':
					return new QQNode('BirthYear', 'integer', $this);
				case 'MainPhone':
					return new QQNode('MainPhone', 'string', $this);
				case 'AltPhone':
					return new QQNode('AltPhone', 'string', $this);
				case 'Note':
					return new QQNode('Note', 'string', $this);
				case 'TransferId':
					return new QQNode('transferId', 'integer', $this);
				case 'ContactAdded':
					return new QQNode('ContactAdded', 'QDateTime', $this);
				case 'GoogleEmail':
					return new QQNode('GoogleEmail', 'string', $this);
				case 'FacebookEmail':
					return new QQNode('FacebookEmail', 'string', $this);
				case 'JoinedClub':
					return new QQNode('JoinedClub', 'QDateTime', $this);
				case 'NotActive':
					return new QQNode('NotActive', 'boolean', $this);
				case 'ImageReference':
					return new QQNode('ImageReference', 'string', $this);
				case 'BusinessMemberAssocAsMemberId':
					return new QQReverseReferenceNodeBusinessMemberAssoc($this, 'businessmemberassocasmemberid', 'reverse_reference', 'MemberId');
				case 'FamilyMemberAssocAsFamilyMemberId':
					return new QQReverseReferenceNodeFamilyMemberAssoc($this, 'familymemberassocasfamilymemberid', 'reverse_reference', 'FamilyMemberId');
				case 'MemberAccessLogAsMemberId':
					return new QQReverseReferenceNodeMemberAccessLog($this, 'memberaccesslogasmemberid', 'reverse_reference', 'MemberId');
				case 'MemberAclAssnAsMemberId':
					return new QQReverseReferenceNodeMemberAclAssn($this, 'memberaclassnasmemberid', 'reverse_reference', 'MemberId');
				case 'MemberRaceResultAsId':
					return new QQReverseReferenceNodeMemberRaceResult($this, 'memberraceresultasid', 'reverse_reference', 'MemberContactId');
				case 'MemberTagAssocAsMemberId':
					return new QQReverseReferenceNodeMemberTagAssoc($this, 'membertagassocasmemberid', 'reverse_reference', 'MemberId');
				case 'MembershipAssocAsMemberId':
					return new QQReverseReferenceNodeMembershipAssoc($this, 'membershipassocasmemberid', 'reverse_reference', 'MemberId');
				case 'MembershipLogAsMemberId':
					return new QQReverseReferenceNodeMembershipLog($this, 'membershiplogasmemberid', 'reverse_reference', 'MemberId');
				case 'NotificationLogAsMemberId':
					return new QQReverseReferenceNodeNotificationLog($this, 'notificationlogasmemberid', 'reverse_reference', 'MemberId');

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