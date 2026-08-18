<?php
/**
 * June 4, 2017 - wpg
 * - setting up MembershipExpiredDate function
 *
 * April 28, 2017 - wpg
 * - adding 'membership' to the valid until email string since the email messages looked strange without it
 */
	require(__DATAGEN_CLASSES__ . '/MembershipAssocGen.class.php');

	/**
	 * The MembershipAssoc class defined here contains any
	 * customized code for the MembershipAssoc class in the
	 * Object Relational Model.  It represents the "MembershipAssoc" table
	 * in the database, and extends from the code generated abstract MembershipAssocGen
	 * class, which contains all the basic CRUD-type functionality as well as
	 * basic methods to handle relationships and index-based loading.
	 *
	 * @package My Application
	 * @subpackage DataObjects
	 *
	 */
	class MembershipAssoc extends MembershipAssocGen {
		/**
		 * Default "to string" handler
		 * Allows pages to _p()/echo()/print() this object, and to define the default
		 * way this object would be outputted.
		 *
		 * Can also be called directly via $objMembershipAssoc->__toString().
		 *
		 * @return string a nicely formatted string representation of this object
		 */
		public function __toString() {
			return sprintf('MembershipAssoc Object %s',  $this->intId);
		}

		// April 22, 2017 - wpg
		public static function GetLatestMembershipForMember($intMemberContact) {
			// get the latest membership for the member
			$objMembershipAssoc = MembershipAssoc::QuerySingle(
				QQ::Equal(QQN::MembershipAssoc()->MemberId, $intMemberContact),
				QQ::Clause(QQ::OrderBy(QQN::MembershipAssoc()->MembershipLogIdObject->ExpireDate, false))
			);
			if ($objMembershipAssoc) return $objMembershipAssoc;

			return;
		}

		// April 22, 2017 - wpg
		public static function CurrentMembershipExpireString($objMembershipAssoc){
			$expired='';
			if ($objMembershipAssoc->MembershipLogIdObject->ExpireDate->toString('YYYYMMDD') < QDateTime::NowToString('YYYYMMDD')){
				$expired = ' class="error"';
				// add expiration notification button and list of notifications made (if email address provided)
			}
			else {
				// maybe add 'welcome' notification link if a welcome note has not been sent
			}

			return "Current membership expires <b".$expired.">".$objMembershipAssoc->MembershipLogIdObject->ExpireDate->toString()."</b>";
		}

		// April 22, 2017 - wpg
		public static function MembershipExpireEmailString($objMembershipAssoc){
			// as long as the log type is defined and not set to the application initialization type then show details
			if ($objMembershipAssoc->MembershipLogIdObject->LogType!='' && $objMembershipAssoc->MembershipLogIdObject->LogType!=88)
				return MembershipLog::showMembershipType($objMembershipAssoc->MembershipLogIdObject->LogType)." membership valid until <b>".$objMembershipAssoc->MembershipLogIdObject->ExpireDate->toString()."</b>";
			else
				return "Membership valid until <b>".$objMembershipAssoc->MembershipLogIdObject->ExpireDate->toString()."</b>";
		}
		// June 4, 2017 - wpg
		public static function MembershipExpiredDate($objMembershipAssoc){
			// as long as the log type is defined and not set to the application initialization type then show details
			return "<b>".$objMembershipAssoc->MembershipLogIdObject->ExpireDate->toString()."</b>";
		}
		// Jan. 4, 2018 - wpg
		public static function IsMembershipExpired($objMembershipAssoc){
			// test if membership has expired
			if ($objMembershipAssoc->MembershipLogIdObject->ExpireDate->toString('YYYYMMDD') < QDateTime::NowToString('YYYYMMDD')) return true;
			else return false;
		}

		public static function MembersOfMembership($intMembershipLogId,$link=false,$css=true) {
			$objMembershipAssocArray = MembershipAssoc::QueryArray(
					QQ::Equal(QQN::MembershipAssoc()->MembershipLogId, $intMembershipLogId),
					QQ::Clause(QQ::OrderBy(QQN::MembershipAssoc()->PrimaryMember,false))
			);
			if ($objMembershipAssocArray) {
				$return='';
				foreach ($objMembershipAssocArray as $objMembershipAssoc){
					$primaryMember='';
					$cssElement="style";
					if ($css){
						$cssElement="class";
						$class='sm ital';
					}
					else {
						$class='font-size:small;font-style: italic;';
					}

					if ($objMembershipAssoc->PrimaryMember) {
						if ($css){
							$class='bld';
						}
						else {
							$class='font-weight:bold;';
						}
						if (count($objMembershipAssocArray)>1)
							$primaryMember=' (primary contact)';
					}
					// do not show link to member by default
					if ($link)
						$return .= "<div class='".$class."'><a href='MembershipList.php?iMD=".$objMembershipAssoc->MemberId."'>".$objMembershipAssoc->MemberIdObject->__toString()."</a>".$primaryMember."</div>";
					else
						$return .= "<div ".$cssElement."='".$class."'>".$objMembershipAssoc->MemberIdObject->__toString().$primaryMember."</div>";
				}
				return $return;
			}

			else
				return null;
		}
		// Override or Create New Load/Count methods
		// (For obvious reasons, these methods are commented out...
		// but feel free to use these as a starting point)
/*
		public static function LoadArrayBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return an array of MembershipAssoc objects
			return MembershipAssoc::QueryArray(
				QQ::AndCondition(
					QQ::Equal(QQN::MembershipAssoc()->Param1, $strParam1),
					QQ::GreaterThan(QQN::MembershipAssoc()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function LoadBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return a single MembershipAssoc object
			return MembershipAssoc::QuerySingle(
				QQ::AndCondition(
					QQ::Equal(QQN::MembershipAssoc()->Param1, $strParam1),
					QQ::GreaterThan(QQN::MembershipAssoc()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function CountBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return a count of MembershipAssoc objects
			return MembershipAssoc::QueryCount(
				QQ::AndCondition(
					QQ::Equal(QQN::MembershipAssoc()->Param1, $strParam1),
					QQ::Equal(QQN::MembershipAssoc()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function LoadArrayBySample($strParam1, $intParam2, $objOptionalClauses) {
			// Performing the load manually (instead of using Qcodo Query)

			// Get the Database Object for this Class
			$objDatabase = MembershipAssoc::GetDatabase();

			// Properly Escape All Input Parameters using Database->SqlVariable()
			$strParam1 = $objDatabase->SqlVariable($strParam1);
			$intParam2 = $objDatabase->SqlVariable($intParam2);

			// Setup the SQL Query
			$strQuery = sprintf('
				SELECT
					`MembershipAssoc`.*
				FROM
					`MembershipAssoc` AS `MembershipAssoc`
				WHERE
					param_1 = %s AND
					param_2 < %s',
				$strParam1, $intParam2);

			// Perform the Query and Instantiate the Result
			$objDbResult = $objDatabase->Query($strQuery);
			return MembershipAssoc::InstantiateDbResult($objDbResult);
		}
*/



		// Override or Create New Properties and Variables
		// For performance reasons, these variables and __set and __get override methods
		// are commented out.  But if you wish to implement or override any
		// of the data generated properties, please feel free to uncomment them.
/*
		protected $strSomeNewProperty;

		public function __get($strName) {
			switch ($strName) {
				case 'SomeNewProperty': return $this->strSomeNewProperty;

				default:
					try {
						return parent::__get($strName);
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}

		public function __set($strName, $mixValue) {
			switch ($strName) {
				case 'SomeNewProperty':
					try {
						return ($this->strSomeNewProperty = QType::Cast($mixValue, QType::String));
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				default:
					try {
						return (parent::__set($strName, $mixValue));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}
*/
	}
?>