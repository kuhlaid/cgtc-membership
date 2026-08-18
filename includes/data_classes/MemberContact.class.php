<?php
/**
 * @abstract Main Member profile override class.
 * @author w. Patrick Gale
 *
 *  April 25, 2020 - wpg
 * - adding redirect login bypass for Facebook
 * 
 * June 13, 2018 - wpg
 * - calculate the years in the club for members
 *
 * Jan. 1, 2018 - wpg
 * - adding login method to track login access
 *
 * May 23, 2017 - wpg
 * - adding age to general member contact info
 *
 * May 9, 2017 - wpg
 * - adding handlers for associating members with partner businesses
 *
 * April 19, 2017 - wpg
 * - adding access control functions
 */
	require(__DATAGEN_CLASSES__ . '/MemberContactGen.class.php');

	/**
	 * The MemberContact class defined here contains any
	 * customized code for the MemberContact class in the
	 * Object Relational Model.  It represents the "MemberContact" table
	 * in the database, and extends from the code generated abstract MemberContactGen
	 * class, which contains all the basic CRUD-type functionality as well as
	 * basic methods to handle relationships and index-based loading.
	 *
	 * @package My Application
	 * @subpackage DataObjects
	 *
	 */
	class MemberContact extends MemberContactGen {
		/**
		 * Default "to string" handler
		 * Allows pages to _p()/echo()/print() this object, and to define the default
		 * way this object would be outputted.
		 *
		 * Can also be called directly via $objMemberContact->__toString().
		 *
		 * @return string a nicely formatted string representation of this object
		 */
		public function __toString() {
			// changed member string to first and last name (March 18, 2017 - wpg)
			return sprintf('%s',  $this->FirstName." ".$this->LastName);
		}

		// created last name first string for member tags (March 22, 2017 - wpg)
		public function __toStringLnFirst() {
			return sprintf('%s',  $this->LastName.", ".$this->FirstName);
		}

		// return age of the member
		public function __age() {
			//get age from date or birthdate
		if (!$this->BirthYear) return '?';	// return nothing if no birthday
		  $age = (date("md", date("U", mktime(0, 0, 0, $this->BirthMonth, $this->BirthDay, $this->BirthYear))) > date("md")
		    ? ((date("Y") - $this->BirthYear) - 1)
		    : (date("Y") - $this->BirthYear));
		  return $age;
		}

		// member years in the club
		public function __yearsInClub() {
			$today = QDateTime::Now();
			if ($this->JoinedClub && $this->JoinedClub->toString("YYYY")!='' && intval($this->JoinedClub->toString("YYYY")) > 1){
				return (intval($today->toString("YYYY"))-intval($this->JoinedClub->toString("YYYY")));	//"joined year:".intval($this->JoinedClub->toString("YYYY"))." year in: ".
			}
			return '';
		}

		public static function checkExpiredMembership(){
			// set if the logged in member has an expired membership or not
			$objMembershipAssoc = MembershipAssoc::GetLatestMembershipForMember(QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__'));
			if (MembershipAssoc::IsMembershipExpired($objMembershipAssoc))
				QSessionDB::set(__SESSION_PREFIX__.'__MEMBERSHIP_EXPIRED__', true);
			else
				QSessionDB::set(__SESSION_PREFIX__.'__MEMBERSHIP_EXPIRED__', false);
		}

		public static function setUserAccess($objMemberContact=null){
			if (!$objMemberContact)
				$objMemberContact = MemberContact::Load(QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__'));

			// find out what the user access rights are
			$objMemberAclAssnArray = MemberAclAssn::QueryArray(
				QQ::Equal(QQN::MemberAclAssn()->MemberId, $objMemberContact->Id),
				QQ::Clause(QQ::OrderBy(QQN::MemberAclAssn()->Acl)));

			// if access rights found
			// else we give them rights simply as a member if they have not been set previously
			if ($objMemberAclAssnArray) {
				foreach ($objMemberAclAssnArray as $objMemberAclAssn){
					// set first access found
					QSessionDB::set(__SESSION_PREFIX__.'__CURRENT_SYSTEM_ACCESS__', $objMemberAclAssn->Acl);
					break;
				}
				$userAccess = serialize($objMemberAclAssnArray);
			}
			else {
				$objMemberAclAssn = new MemberAclAssn();
				$objMemberAclAssn->MemberId = $objMemberContact->Id;
				$objMemberAclAssn->Acl = MemberAclAssn::$MemberAccess;
				$objMemberAclAssn->Save();

				QSessionDB::set(__SESSION_PREFIX__.'__CURRENT_SYSTEM_ACCESS__', MemberAclAssn::$MemberAccess);

				$objMemberAclAssnArray = MemberAclAssn::LoadArrayByMemberId($objMemberContact->Id);

				$userAccess = serialize($objMemberAclAssnArray);
			}

			QSessionDB::set(__SESSION_PREFIX__.'__MEMBER_ACL__', $userAccess);
		}

		// used to set the member access to the system based on the email address verified through our login options
		public static function SetMemberLoginAccess($strMemberEmail, $intLoginMethod=0,$blnRedirect=true) {
			
			if ($strMemberEmail=='') {
				error_log("user trying to login with no email address via".$intLoginMethod);
				exit;
			}
			
			// login passed so now we check the system for the member info
			$objMemberContact = MemberContact::QuerySingle(
				QQ::OrCondition(
					QQ::Equal(QQN::MemberContact()->GoogleEmail, $strMemberEmail),
					QQ::Equal(QQN::MemberContact()->FacebookEmail, $strMemberEmail),
					QQ::Equal(QQN::MemberContact()->Email, $strMemberEmail)
				)
			);

			// if member found
			if ($objMemberContact) {
				// set the member id and name in a session
				QSessionDB::set(__SESSION_PREFIX__.'__MEMBER_ID__', $objMemberContact->Id);
				QSessionDB::set(__SESSION_PREFIX__.'__MEMBER_NAME__', $objMemberContact->__toString());

				MemberContact::checkExpiredMembership();

				MemberContact::setUserAccess($objMemberContact);
				// // find out what the user access rights are
				// $objMemberAclAssnArray = MemberAclAssn::QueryArray(
				// 	QQ::Equal(QQN::MemberAclAssn()->MemberId, $objMemberContact->Id),
				// 	QQ::Clause(QQ::OrderBy(QQN::MemberAclAssn()->Acl)));

				// // if access rights found
				// // else we give them rights simply as a member if they have not been set previously
				// if ($objMemberAclAssnArray) {
				// 	foreach ($objMemberAclAssnArray as $objMemberAclAssn){
				// 		// set first access found
				// 		QSessionDB::set(__SESSION_PREFIX__.'__CURRENT_SYSTEM_ACCESS__', $objMemberAclAssn->Acl);
				// 		break;
				// 	}
				// 	$userAccess = serialize($objMemberAclAssnArray);
				// }
				// else {
				// 	$objMemberAclAssn = new MemberAclAssn();
				// 	$objMemberAclAssn->MemberId = $objMemberContact->Id;
				// 	$objMemberAclAssn->Acl = MemberAclAssn::$MemberAccess;
				// 	$objMemberAclAssn->Save();

				// 	QSessionDB::set(__SESSION_PREFIX__.'__CURRENT_SYSTEM_ACCESS__', MemberAclAssn::$MemberAccess);

				// 	$objMemberAclAssnArray = MemberAclAssn::LoadArrayByMemberId($objMemberContact->Id);

				// 	$userAccess = serialize($objMemberAclAssnArray);
				// }

				// QSessionDB::set(__SESSION_PREFIX__.'__MEMBER_ACL__', $userAccess);

				// save the login
				$objMemberAccessLog = new MemberAccessLog();
				$objMemberAccessLog->MemberId = $objMemberContact->Id;
				$objMemberAccessLog->TimeOfLogin = QDateTime::Now(true);
				$objMemberAccessLog->LoginMethod = $intLoginMethod;
				$objMemberAccessLog->Save();
				if ($blnRedirect) {
				QSessionDB::set('error', 'Login successful');
				header("Location: ".__SUBDIRECTORY__."/index.php");
				}
				else return 'loggedIn';
			}
			else {
				MemberAclAssn::noSystemAccess();
			}
			exit;
		}

		public static function ChangeUserAccess($acx) {
			$objMemberAclAssnArray = unserialize(QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ACL__') ?? '');
			if ($objMemberAclAssnArray) foreach ($objMemberAclAssnArray as $objMemberAclAssn) {
				if ($objMemberAclAssn->Acl == $acx) {
					QSessionDB::set(__SESSION_PREFIX__.'__CURRENT_SYSTEM_ACCESS__', $acx);
					QApplication::Redirect("index.php");
					exit;
				}
			}
		}

		public static function LoggedIn() {
			if (QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__'))
				return true;
			else
				return false;
		}

		public static $genderArray = array(
				'F'=>'Female',
				'M'=>'Male'
		);

		public static $monthArray = array(
				1=>'January',
				2=>'February',
				3=>'March',
				4=>'April',
				5=>'May',
				6=>'June',
				7=>'July',
				8=>'August',
				9=>'September',
				10=>'October',
				11=>'November',
				12=>'December'
		);

		public static $stateArray = array(
				'AL'=>'ALABAMA',
				'AK'=>'ALASKA',
				'AS'=>'AMERICAN SAMOA',
				'AZ'=>'ARIZONA',
				'AR'=>'ARKANSAS',
				'CA'=>'CALIFORNIA',
				'CO'=>'COLORADO',
				'CT'=>'CONNECTICUT',
				'DE'=>'DELAWARE',
				'DC'=>'DISTRICT OF COLUMBIA',
				'FM'=>'FEDERATED STATES OF MICRONESIA',
				'FL'=>'FLORIDA',
				'GA'=>'GEORGIA',
				'GU'=>'GUAM GU',
				'HI'=>'HAWAII',
				'ID'=>'IDAHO',
				'IL'=>'ILLINOIS',
				'IN'=>'INDIANA',
				'IA'=>'IOWA',
				'KS'=>'KANSAS',
				'KY'=>'KENTUCKY',
				'LA'=>'LOUISIANA',
				'ME'=>'MAINE',
				'MH'=>'MARSHALL ISLANDS',
				'MD'=>'MARYLAND',
				'MA'=>'MASSACHUSETTS',
				'MI'=>'MICHIGAN',
				'MN'=>'MINNESOTA',
				'MS'=>'MISSISSIPPI',
				'MO'=>'MISSOURI',
				'MT'=>'MONTANA',
				'NE'=>'NEBRASKA',
				'NV'=>'NEVADA',
				'NH'=>'NEW HAMPSHIRE',
				'NJ'=>'NEW JERSEY',
				'NM'=>'NEW MEXICO',
				'NY'=>'NEW YORK',
				'NC'=>'NORTH CAROLINA',
				'ND'=>'NORTH DAKOTA',
				'MP'=>'NORTHERN MARIANA ISLANDS',
				'OH'=>'OHIO',
				'OK'=>'OKLAHOMA',
				'OR'=>'OREGON',
				'PW'=>'PALAU',
				'PA'=>'PENNSYLVANIA',
				'PR'=>'PUERTO RICO',
				'RI'=>'RHODE ISLAND',
				'SC'=>'SOUTH CAROLINA',
				'SD'=>'SOUTH DAKOTA',
				'TN'=>'TENNESSEE',
				'TX'=>'TEXAS',
				'UT'=>'UTAH',
				'VT'=>'VERMONT',
				'VI'=>'VIRGIN ISLANDS',
				'VA'=>'VIRGINIA',
				'WA'=>'WASHINGTON',
				'WV'=>'WEST VIRGINIA',
				'WI'=>'WISCONSIN',
				'WY'=>'WYOMING'
		);

		// April 22, 2017 - wpg
		public static function BasicMemberContactInfo($objMemberContact, $strTxtSearch=''){
			$return='';
			if ($objMemberContact->FirstName){
				if ($strTxtSearch != '')
					$return.=highlightResults($strTxtSearch, "<b>".$objMemberContact->FirstName."</b>");
				else
					$return.="<b>".$objMemberContact->FirstName."</b>";
			}
			if ($objMemberContact->LastName){
				if($return!='')$return.=" ";
				if ($strTxtSearch != '')
					$return.=highlightResults($strTxtSearch, "<b>".$objMemberContact->LastName."</b>");
				else
					$return.="<b>".$objMemberContact->LastName."</b>";
			}
			if ($objMemberContact->Addr1){
				if($return!='')$return.="<br/>";
				if ($strTxtSearch != '')
					$return.=highlightResults($strTxtSearch, $objMemberContact->Addr1);
				else
				$return.=$objMemberContact->Addr1;
			}
			if ($objMemberContact->Addr2){
				if($return!='')$return.="<br/>";
				$return.=$objMemberContact->Addr2;
			}
			if ($objMemberContact->City){
				if($return!='')$return.="<br/>";
				$return.=$objMemberContact->City;
			}
			if ($objMemberContact->State){
				if($return!='')$return.=", ";
				$return.=$objMemberContact->State;
			}
			if ($objMemberContact->Zip){
				if($return!='')$return.=" ";
				$return.=$objMemberContact->Zip;
			}
			if ($objMemberContact->Email){
				if($return!='')$return.="<br/>";

				if ($strTxtSearch != '')
					$return.="<a href='mailto:".$objMemberContact->Email."'>".highlightResults($strTxtSearch, $objMemberContact->Email)."</a>";
				else
					$return.="<a href='mailto:".$objMemberContact->Email."'>".$objMemberContact->Email."</a>";
					
				$return.="<br/><a href='emailNotification.php?option=membershipUpdate&iMD=".$objMemberContact->Id."' class='btn btn-primary' title='This will send an email with the current membership information (e.g. expiration, business partners, etc.).'>📧 Send membership information</a>";
			}
			if ($objMemberContact->MainPhone){
				if($return!='')$return.="<br/>";
				$return.=$objMemberContact->MainPhone." (main)";
			}
			if ($objMemberContact->AltPhone){
				if($return!='')$return.="<br/>";
				$return.=$objMemberContact->AltPhone." (alt)";
			}
			if ($objMemberContact->JoinedClub && $objMemberContact->JoinedClub->toString("MMM DD, YYYY")!='Nov 30, -0001'){
				if($return!='')$return.="<br/>";
				$return.="<b>Joined: </b>".$objMemberContact->JoinedClub->toString("MMMM D, YYYY");
			}
			if ($objMemberContact->BirthDay && $objMemberContact->BirthMonth && $objMemberContact->BirthYear){
				if($return!='')$return.="<br/>";
				$return.="<b>Age: </b>".$objMemberContact->__age();
			}
			return $return;
		}

		// Jan. 1, 2018 - wpg (return member profile image
		public static function MemberProfileImage($objMemberContact, $css='height:70px;float:right;'){
			if ($objMemberContact->ImageReference){
				return "<img src='".$objMemberContact->ImageReference."' style='".$css."'>";
			}
		}

		// Dec. 31, 2017 - wpg
		public static function BasicMemberContactInfoAcx2($objMemberContact, $strTxtSearch=''){
			$return='';
			if ($objMemberContact->FirstName){
				if ($strTxtSearch != '')
					$return.=highlightResults($strTxtSearch, "<b>".$objMemberContact->FirstName."</b>");
				else
					$return.="<b>".$objMemberContact->FirstName."</b>";
			}
			if ($objMemberContact->LastName){
				if($return!='')$return.=" ";
				if ($strTxtSearch != '')
					$return.=highlightResults($strTxtSearch, "<b>".$objMemberContact->LastName."</b>");
				else
					$return.="<b>".$objMemberContact->LastName."</b>";
			}
			if ($objMemberContact->City){
				if($return!='')$return.="<br/>";
				$return.=$objMemberContact->City;
			}
			if ($objMemberContact->State){
				if($return!='')$return.=", ";
				$return.=$objMemberContact->State;
			}
// 			if ($objMemberContact->JoinedClub && $objMemberContact->JoinedClub->toString("MMM DD, YYYY")!='Nov 30, -0001'){
// 				if($return!='')$return.="<br/>";
// 				$return.="<b>Joined: </b>".$objMemberContact->JoinedClub->toString("MMMM D, YYYY");
// 			}
			if ($objMemberContact->BirthDay && $objMemberContact->BirthMonth && $objMemberContact->BirthYear){
				if($return!='')$return.="<br/>";
				$return.="<b>Age: </b>".$objMemberContact->__age();
			}
			return $return;
		}

		/**
		 * Gets all many-to-many associated PartnerBusinesss as an array of PartnerBusiness objects
		 * @param QQClause[] $objOptionalClauses additional optional QQClause objects for this query
		 * @return PartnerBusiness[]
		 */
		public function GetPartnerBusinessArray($objOptionalClauses = null) {
			if ((is_null($this->intId)))
				return array();

			try {
				return BusinessMemberAssoc::QueryArray(QQ::Equal(QQN::BusinessMemberAssoc()->MemberId, $this->intId), $objOptionalClauses);
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		/**
		 * Unassociates all PartnerBusinesses
		 * @return void
		 */
		public function UnassociateAllPartnerBusinesses() {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call UnassociateAllUserArray on this unsaved Member.');

			// Get the Database Object for this Class
			$objDatabase = BusinessMemberAssoc::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`BusinessMemberAssoc`
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($this->intId) . '');
		}

		/**
		 * Associates a PartnerBusiness
		 * @param PartnerBusiness $objPartnerBusiness
		 * @return void
		 */
		public function AssociatePartnerBusiness(PartnerBusiness $objPartnerBusiness) {
			if ((is_null($this->intId)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociatePartnerBusiness on this unsaved Member.');
			if ((is_null($objPartnerBusiness->Id)))
				throw new QUndefinedPrimaryKeyException('Unable to call AssociatePartnerBusiness on this Member with an unsaved PartnerBusiness.');

			// Get the Database Object for this Class
			$objDatabase = BusinessMemberAssoc::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				INSERT INTO `BusinessMemberAssoc` (
					`MemberId`,
					`PartnerBusinessId`
				) VALUES (
					' . $objDatabase->SqlVariable($this->intId) . ',
					' . $objDatabase->SqlVariable($objPartnerBusiness->Id) . '
				)
			');
		}

		// cannot delete members from the application
		public function Delete() {}

		// Override or Create New Load/Count methods
		// (For obvious reasons, these methods are commented out...
		// but feel free to use these as a starting point)
/*
		public static function LoadArrayBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return an array of MemberContact objects
			return MemberContact::QueryArray(
				QQ::AndCondition(
					QQ::Equal(QQN::MemberContact()->Param1, $strParam1),
					QQ::GreaterThan(QQN::MemberContact()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function LoadBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return a single MemberContact object
			return MemberContact::QuerySingle(
				QQ::AndCondition(
					QQ::Equal(QQN::MemberContact()->Param1, $strParam1),
					QQ::GreaterThan(QQN::MemberContact()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function CountBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return a count of MemberContact objects
			return MemberContact::QueryCount(
				QQ::AndCondition(
					QQ::Equal(QQN::MemberContact()->Param1, $strParam1),
					QQ::Equal(QQN::MemberContact()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function LoadArrayBySample($strParam1, $intParam2, $objOptionalClauses) {
			// Performing the load manually (instead of using Qcodo Query)

			// Get the Database Object for this Class
			$objDatabase = MemberContact::GetDatabase();

			// Properly Escape All Input Parameters using Database->SqlVariable()
			$strParam1 = $objDatabase->SqlVariable($strParam1);
			$intParam2 = $objDatabase->SqlVariable($intParam2);

			// Setup the SQL Query
			$strQuery = sprintf('
				SELECT
					`MemberContact`.*
				FROM
					`MemberContact` AS `MemberContact`
				WHERE
					param_1 = %s AND
					param_2 < %s',
				$strParam1, $intParam2);

			// Perform the Query and Instantiate the Result
			$objDbResult = $objDatabase->Query($strQuery);
			return MemberContact::InstantiateDbResult($objDbResult);
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