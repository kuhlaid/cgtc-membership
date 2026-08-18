<?php

/**

 * @author w. Patrick Gale

 * @abstract Email notification for membership tasks.

 *

 * Oct. 1, 2025 - wpg

 * - trying to troubleshoot the emails not being sent; switching to simple PHP mail function to fix the issue

 * 

 * May 16, 2018 - wpg

 * - creating custom expiration notification for business members

 *

 * Jan. 12, 2018 - wpg

 * - adding the member name to the subject line of member notifications to keep the notices separate when I get messages back

 *

 * Dec. 1, 2017 - wpg

 * - if a new member registers then automatically submit a request to add them to the club listserv

 *

 * July 16, 2017 - wpg

 * - moved the current club discounts to the Partner Business class so we can use it in other places than simply the email notifications

 *

 * June 25, 2017 - wpg

 * - changing the encryption for the member login link

 *

 * June 7, 2017 - wpg

 * - setting up membership login link email notification

 *

 * June 2, 2017 - wpg

 * - setting up expired membership notifications

 *

 * May 9, 2017 - wpg

 * - sent out an updated membership email to everyone since I had updated a good number of businesses and the formatting of the email

 *

 * April 25, 2017 - wpg

 * - setting up links on the MembershipLogs to allow administrators to click a link to send an updated membership email to a member

 *

 * April 24, 2017 - wpg

 * - confirmation by Kim at BullCity (kim@bullcityrunning.com) on discount

 *

 * April 11, 2017 - wpg

 * - working on email formatting to send out first round of membership updates

 * - contacted businesses we have store discounts listed and updating the discounts

 *

 * April 9, 2017 - wpg

 * - renaming the script and emailNotification.php?option=checkMembership

 */



// Include prepend.inc to load Qcodo

require('includes/prepend.inc.php');

QApplication::CheckRemoteAdmin();



class EmailReport extends QForm {

	protected $strReport, $emailOption, $emailListArray, $strReturn, $emailAddyList, $cgtcLogo;

	protected function Form_Create() {

		$this->strReturn='';

		// determine the type of email we will send out

		$this->emailOption = QApplication::QueryString('option');

		$iMD = QApplication::QueryString('iMD');	// member ID

		//$this->intMembershipLog = QApplication::QueryString('intMembershipLogId');

		$this->strReport_Create();

		//$this->cgtcLogo=__CLUB_LOGO_300px__;//"<img src='".__APP_DOMAIN__.__IMAGE_ASSETS__."/CgtcLogo300px.png' alt='CGTC Logo' title='CGTC Logo' style='display:block;' width='300' height='134'/>";

		// if we are simply sending a membership update we need to make sure the logged in user is an admin

		if ($this->emailOption=='membershipUpdate' && checkAccess(MemberAclAssn::$AdminAccess)) {

			// send email notification to a single member

			if ($iMD!='')

				$objMemberContactArray = MemberContact::QueryArray(

					QQ::In(QQN::MemberContact()->Id, array($iMD))

				);

			// everyone

			//$objMemberContactArray = MemberContact::QueryArray(QQ::All());

			// everyone except

// 			$objMemberContactArray = MemberContact::QueryArray(

// 					QQ::NotIn(QQN::MemberContact()->Id, array(1,2,3,409,408,407,83,134)));



			//April 23, 2017 - wpg (one time membership update that I may send once every six months)

			if ($objMemberContactArray) foreach($objMemberContactArray as $objMemberContact) {

				if ($objMemberContact && $objMemberContact->Email) {

					$strMemberContactInfo = $strMembershipLog = $strOtherFamilyMembers = $strMemberEmail = '';

					// get membership log for the member (only the latest)

					$objMembershipAssoc = MembershipAssoc::GetLatestMembershipForMember($objMemberContact->Id);



					$blnNewMember=0;

					if ($objMembershipAssoc) {

						$strMembershipLog = MembershipAssoc::MembershipExpireEmailString($objMembershipAssoc);

						// set if this is a new member

						if ($objMembershipAssoc->MembershipLogIdObject->NewMembership==1)$blnNewMember=1;

					}	

					$strMemberEmail = $objMemberContact->Email;

					$strMemberContactInfo = MemberContact::BasicMemberContactInfo($objMemberContact);

					$strOtherFamilyMembers = MembershipAssoc::MembersOfMembership($objMembershipAssoc->MembershipLogId,false,false).

						BusinessMemberAssoc::MemberBusinessRepresenting($objMemberContact->Id);



					

					// if this is a new member the automatically submit a request to add them to the listserv (added Dec. 1, 2017 - wpg)

					if ($blnNewMember)

						$this->buildEmail($_ENV['JOIN_EMAIL_LIST'],$_ENV['EMAIL_LIST_JOIN'],"","","",$strMemberEmail,0);

						

					// adding member name to the notifications so when an error occurs with the email being sent that I get a separate email for the member in question and not a thread of notifications for everyone (Jan. 12, 2018 - wpg)

					$this->membershipUpdate($strMemberContactInfo, $strMembershipLog, $strOtherFamilyMembers, $strMemberEmail,$objMemberContact->Id, ' for '.$objMemberContact->__toString());

				}

			}

			QSessionDB::set('error','An email report has been sent.  The notification should appear in your email box shortly.');

			QApplication::Redirect('NotificationLogs.php');

		}

		elseif ($this->emailOption=='membershipExpired') {

			// send email notification to a single member

			if ($iMD!='')

				$objMemberContactArray = MemberContact::QueryArray(

					QQ::In(QQN::MemberContact()->Id, array($iMD))

				);

			// everyone

			//$objMemberContactArray = MemberContact::QueryArray(QQ::All());

			// everyone except

// 			$objMemberContactArray = MemberContact::QueryArray(

// 					QQ::NotIn(QQN::MemberContact()->Id, array(1,2,3,409,408,407,83,134)));

			//April 23, 2017 - wpg (one time membership update that I may send once every six months)

			if ($objMemberContactArray) foreach($objMemberContactArray as $objMemberContact) {

				if ($objMemberContact && $objMemberContact->Email) {

					$strMemberContactInfo = $strMembershipLog = $strOtherFamilyMembers = $strMemberEmail = '';

					// get membership log for the member (only the latest)

					$objMembershipAssoc = MembershipAssoc::GetLatestMembershipForMember($objMemberContact->Id);

					if ($objMembershipAssoc) $strMembershipLog = MembershipAssoc::MembershipExpireEmailString($objMembershipAssoc);

					$strMemberEmail = $objMemberContact->Email;

					$strMemberContactInfo = MemberContact::BasicMemberContactInfo($objMemberContact);

					$strOtherFamilyMembers = MembershipAssoc::MembersOfMembership($objMembershipAssoc->MembershipLogId,false,false).

						BusinessMemberAssoc::MemberBusinessRepresenting($objMemberContact->Id);

					$this->expiredMembership($strMemberContactInfo, $strMembershipLog, $strOtherFamilyMembers, $strMemberEmail,$objMemberContact->Id, ' for '.$objMemberContact->__toString());

				}

			}

			//QSessionDB::set('error','Expired membership notifications have been sent.');

			//QApplication::Redirect('NotificationLogs.php');

		}

		elseif ($this->emailOption=='businessMembershipExpired') {

			// send email notification to a business member

			if ($iMD!='')

				$objMemberContactArray = MemberContact::QueryArray(

						QQ::In(QQN::MemberContact()->Id, array($iMD))

				);

			//April 23, 2017 - wpg (one time membership update that I may send once every six months)

			if ($objMemberContactArray) foreach($objMemberContactArray as $objMemberContact) {

				if ($objMemberContact && $objMemberContact->Email) {

					$strMemberContactInfo = $strMembershipLog = $strOtherFamilyMembers = $strMemberEmail = '';

					// get membership log for the member (only the latest)

					$objMembershipAssoc = MembershipAssoc::GetLatestMembershipForMember($objMemberContact->Id);

					if ($objMembershipAssoc) $strMembershipLog = MembershipAssoc::MembershipExpireEmailString($objMembershipAssoc);

					$strMemberEmail = $objMemberContact->Email;

					$strMemberContactInfo = MemberContact::BasicMemberContactInfo($objMemberContact);

					$this->businessMembershipExpired($strMemberContactInfo, $strMemberEmail,$objMemberContact->Id, $objMemberContact->__toString());

				}

			}

			//QSessionDB::set('error','Expired membership notifications have been sent.');

			//QApplication::Redirect('NotificationLogs.php');

		}

		// email member login

		elseif ($this->emailOption=='sendMemberLoginLink') {

			// we need to decode and then re-encode before sending the string

 			$loginKey = QApplication::QueryString('loginKey');

 			//error_log("emailNotification.php: line 114=".base64_decode(QApplication::QueryString('loginKey'))."**********".$loginKey);

			$linkAddress = __APP_DOMAIN__.__SUBDIRECTORY__."/MemberLogin.php?loginKey=".urlencode($loginKey);

			$strLink = "<a href='".$linkAddress."'>".$linkAddress."</a>";

			// decode the login link
			// $binaryIv = hex2bin(__EMAIL_IV__); 
			$cipher = $_ENV['CIPHER_TYPE'];
			// // 4. Calculate the required IV length dynamically for your cipher
			// $iv_length = openssl_cipher_iv_length($cipher);

			// // 5. Extract the IV from the beginning of the packet
			// $iv = substr($raw_packet, 0, $iv_length);

			$linkKeyArray = unserialize(openssl_decrypt(base64_decode($loginKey ?? ''), $cipher, __EMAIL_KEY__, OPENSSL_RAW_DATA, __EMAIL_IV__) ?? '');

			$memberId='x';

			if ($loginKey){

				$objMemberContact = MemberContact::QuerySingle(

						QQ::AndCondition(

								QQ::Equal(QQN::MemberContact()->Email, $linkKeyArray[0]),

								QQ::Equal(QQN::MemberContact()->LastName, $linkKeyArray[1])

						)

				);

				// if the member has a valid email address then log them in

				if ($objMemberContact){

					$memberId = $objMemberContact->Id;

				}

			}

			$this->memberLoginLink($strLink,$linkKeyArray[0],$memberId,$linkKeyArray[1]);

		}

	}



	// latest email

	protected function strReport_Create() {

		$this->strReport = new QPlain($this);

	}


	protected function membershipUpdate($strMemberContactInfo='', $strMembershipLog='', $strOtherFamilyMembers='', $strMemberEmail='', $intMemberId='', $strName=''){
		$strAppName = $_ENV['APPLICATION_TITLE'];
		$strEmailList = $_ENV['EMAIL_LIST']
		$subject = QDateTime::NowToString(QDateTime::FormatDisplayDate)." - ".$_ENV['MEMBERSHIP_UPDATE_TXT'].$strName;
		$strAppUrl=__APP_URL__;
		$strPBList = PartnerBusiness::currentPbWebList();
		$strClubLogo = __CLUB_LOGO_300px__;
		$strEmailFrom = __EMAIL_FROM__;
		$body = membershipUpdateNotice($subject, $strAppUrl, $strAppName, $strMemberContactInfo, $strMembershipLog, $strOtherFamilyMembers, $strEmailList, $strPBList, $strClubLogo, $strEmailFrom);
		
		$this->strReport->Text = nl2br($body);

		$to=$strMemberEmail;	

		$this->buildEmail($subject,$to,$body,5,$intMemberId);

	}



// sends a notice to business partners who have been with the club a year since we updated their contact information and to confirm their partnership with the club (added May 16, 2018 - wpg)

	protected function businessMembershipExpired($strMemberContactInfo='', $strMemberEmail='', $intMemberId='', $strName=''){

		$subject = QDateTime::NowToString(QDateTime::FormatDisplayDate)." - ".$_ENV['BUSINESS_PARTNER_RENEW_SUBJECT'].$strName;

		$strPBList = PartnerBusiness::currentPbWebList();
		$strClubLogo = __CLUB_LOGO_300px__;
		$strEmailFrom = __EMAIL_FROM__;
		$strAppDomain = __APP_DOMAIN__;
		$strCurrentTime = QDateTime::NowToString('MMM DD, YYYY at hhhh:mm:ss');
		$body = businessPartnerUpdateMessage($subject, $strMemberContactInfo, $strPBList, $strClubLogo, $strEmailFrom, $strAppDomain, $strCurrentTime);
		
		$this->strReport->Text = nl2br($body);

		$to=$strMemberEmail;	

		$this->buildEmail($subject,$to,$body,1,$intMemberId);	// disable on development

	}

	

	protected function expiredMembership($strMemberContactInfo='', $strMembershipLog='', $strOtherFamilyMembers='', $strMemberEmail='', $intMemberId='', $strName=''){

		$subject = QDateTime::NowToString(QDateTime::FormatDisplayDate)." - ".$_ENV['MEMBER_EXPIRE_SUBJECT'].$strName;

		$strAppDomain = __APP_DOMAIN__;
		$strClubLogo = __CLUB_LOGO_300px__;
		$strEmailFrom = __EMAIL_FROM__;
		$strCurrentTime = QDateTime::NowToString('MMM DD, YYYY at hhhh:mm:ss');

		$body = membershipExpirationNotice($subject, $strMembershipLog, $strAppDomain, $strClubLogo, $strEmailFrom, $strCurrentTime);
		$this->strReport->Text = nl2br($body);
		$to=$strMemberEmail;	
		$this->buildEmail($subject,$to,$body,1,$intMemberId);	// disable on development
	}



	// send member a login link for renewing membership

	protected function memberLoginLink($strMemberEmailLink='', $strMemberEmail='',$intMemberId='',$strLastName=''){

		// user does not have member id so send them to the membership login

// 		if ($intMemberId=='') {

// 			error_log($strMemberEmail.' failed login for '.$strLastName.' (emailNotification)');

// 			$this->memberLoginLinkSent();

// 		}

// error_log("emailNotification.php: line 263=".$strMemberEmail."==".$strLastName);

		$subject = $_ENV['MEMBER_LOGIN_LINK_TXT'];
		$strAppDomain = __APP_DOMAIN__;
		$strClubLogo = __CLUB_LOGO_300px__;
		$strEmailFrom = __EMAIL_FROM__;
		$strCurrentTime = QDateTime::NowToString('MMM DD, YYYY at hhhh:mm:ss');
		$body = membershipLoginLinkBody($subject, $strMemberEmailLink, $strClubLogo, $strEmailFrom, $strAppDomain, $strCurrentTime);
		$this->strReport->Text = nl2br($body);

		$to=$strMemberEmail;	

		$this->buildEmail($subject,$to,$body,6,$intMemberId);

	}



	// email the report

	protected function buildEmail($subject='',$to='',$body='',$notificationType='',$memberId='',$from=__EMAIL_FROM__,$saveTask=1) {

		try{

			// Create a new message

			// $objMessage = new QEmailMessage();

			// $objMessage->From = $from;

			// $objMessage->To = $to;

			// $objMessage->Subject = $subject;

			// $objMessage->HtmlBody = nl2br($body);//"<font face='arial narrow,arial,verdana'>".."</font>";

			// QEmailServer::Send($objMessage);



			# replacing QEmailServer since this does not seem to work in v8.4 for some reason

			mail($to,

				$subject,

				nl2br($body),

				"From: ".$from. "\r\n" . "Content-Type: text/html; charset=utf-8",

				"-f".$from);



		} catch (Exception $e) {

			// Code to handle the exception

			error_log("Caught exception on sending email: " . $e->getMessage() . "\n");

			// You can also log the error, display a custom message, etc.

		}

		if (!$saveTask) return;	// stop here



		// if not a new member

		// else a new member

		if ($memberId!='x') {

		// do not save notifications for member login link

		if ($notificationType != 6) {

			//wpg - save the email to the database

			$newNotification = new NotificationLog();

			$newNotification->MemberId = $memberId;

			$newNotification->NotificationBody = nl2br($body);

			$newNotification->NotificationSubject = $subject;

			$newNotification->NotificationType=$notificationType;

			$newNotification->NotificationDate = QDateTime::Now(true);

			$newNotification->Save();

		}

		elseif ($notificationType == 6) {

			//wpg - save the login to the database

			$newNotification = new NotificationLog();

			$newNotification->MemberId = $memberId;

			$newNotification->NotificationType=$notificationType;

			$newNotification->NotificationDate = QDateTime::Now(true);

			$newNotification->Save();

			$this->memberLoginLinkSent();

		}

	}

		else $this->memberLoginLinkSent();

	}



	protected function memberLoginLinkSent() {

		QSessionDB::set('error','An email is being sent to you with a link to access your club membership information.');	// (or to setup club membership for those joining the club)

		QApplication::Redirect('index.php');

		exit;

	}
}



EmailReport::Run('EmailReport', 'template/email_report.tpl.php');



// go to the centralized form executing access control function to run the form and check access control

//ACL_Run('EmailNotification');

?>