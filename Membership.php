<?php

/**

 * @abstract Form used to edit/create a membership dues log.

 * @author w. Patrick Gale

 *

 * Oct. 1, 2025 - wpg

 * - finally fixed the problem with the membership start and end dates (I was not cloning variables and the original values were being updated instead of new values being created like we wanted)

 * 

 * Feb. 10, 2019 - wpg

 * - adding membership expiration date and auto setting the membership start date according to that expiration

 * - auto setting the membership access for new members

 * - defaulting the checkbox for new members

 * 

 * April 6, 2018 - wpg

 * - adding membership consent to admin form

 *

 * March 2, 2018 - wpg

 * - changing the state and expire dates to allow admin to update

 *

 * Jan. 20, 2018 - wpg

 * - adding medical training and medical volunteering to the membership renewal

 *

 * Jan. 8, 2018 - wpg

 * - adding membership renewal options

 *

 * June 6, 2017 - wpg

 * - adding a door prize membership type (family)

 *

 * May 20, 2017 - wpg

 * - autotrim the paypal ID since it is difficult to copy from the emails without the space

 * - do not set new membership flag for complimentary members otherwise they appear as new members in the newsletter

 *

 * April 25, 2017 - wpg

 * - automatically send a membership update email to the member when a membership is added (for single membership only since we need to select the family members for a family membership)

 *

 * April 19, 2017 - wpg

 * - adding PayPal field

 *

 * April 9, 2017 - wpg

 * - revising the form to autofill most fields such as start and expire dates and payment amounts

 * - adding a delete handler for the logs since the membership association is tied to it

 *

 * PayPal

 * 0D560732HH342040E

 *

 * April 2, 2017 - wpg

 * - updating the RedirectToListPage to redirect to the logs for the selected member

 *

 * March 24, 2017 - wpg

 * - adding a handler that makes the member who signs up for the family membership, the primary member on the family membership

 */

	// Include prepend.inc to load Qcodo

	require('includes/prepend.inc.php');

	require(__FORMBASE_CLASSES__ . '/MembershipLogEditFormBase.class.php');

	QApplication::CheckRemoteAdmin();



	// system admin access

	class acx1MembershipLogEditForm extends MembershipLogEditFormBase {

		protected $objMemberContact, $objMembershipAssoc, $today, $expirationDate;

		protected function SetupMembershipLog() {

			// Lookup Object PK information from Query String (if applicable)

			// Set mode to Edit or New depending on what's found

			$intId = QApplication::QueryString('intId');

			$intMemberId = QApplication::QueryString('iMD');

			if (($intId)) {

				$this->objMembershipLog = MembershipLog::Load(($intId));



				if (!$this->objMembershipLog) $this->noMember();



				$this->objMemberContact = MemberContact::Load($this->objMembershipLog->MemberId);

				if (!$this->objMemberContact) $this->noMember();



				$this->strTitleVerb = QApplication::Translate('Edit');

				$this->blnEditMode = true;

			} else {

				$this->objMembershipLog = new MembershipLog();

				// make sure we are creating a membership log for an existing member contact

				if ($intMemberId) {

					$this->objMemberContact = MemberContact::Load($intMemberId);

					if (!$this->objMemberContact) $this->noMember();



					$this->objMembershipLog->MemberId = $this->objMemberContact->Id;

				}

				else $this->noMember();

				$this->strTitleVerb = QApplication::Translate('Create');

				$this->blnEditMode = false;

			}

			$this->today = QDateTime::Now(false);

			$this->objMembershipAssoc = MembershipAssoc::GetLatestMembershipForMember($this->objMemberContact->Id);

			if ($this->objMembershipAssoc && $this->objMembershipAssoc->MembershipLogIdObject->ExpireDate > $this->today) {

				$this->expirationDate = $this->objMembershipAssoc->MembershipLogIdObject->ExpireDate;

			}

		}



		protected function noMember(){

			QSessionDB::set("error", "There was an error accessing the membership log. Try again.");

			QApplication::Redirect('MembershipList.php');

			exit;

		}



		protected function chkNewMembership_Create() {

			$this->chkNewMembership = new QCheckBox($this);

			$this->chkNewMembership->Name = QApplication::Translate('New Membership');

			if (!$this->objMembershipAssoc)

				$this->chkNewMembership->Checked = true;

			else

				$this->chkNewMembership->Checked = $this->objMembershipLog->NewMembership;

		}



		// Create and Setup txtLogType

		protected function txtLogType_Create() {

			$this->txtLogType = new QRadioButtonList($this);

			$this->txtLogType->Name = QApplication::Translate('Membership Type');

// 			if (!$this->blnEditMode)

// 				$this->txtLogType->AddItem(QApplication::Translate('- Select One -'), null);

			$objMembershipTypeArray = MembershipLog::$membershipTypeArray;

			if ($objMembershipTypeArray) foreach ($objMembershipTypeArray as $key=>$membershipTypeArray) {

				$objListItem = new QListItem(MembershipLog::showMembershipType($key), $key);

				if (($this->objMembershipLog->LogType) && ($this->objMembershipLog->LogType == $key))

					$objListItem->Selected = true;

				$this->txtLogType->AddItem($objListItem);

			}

			$this->txtLogType->AddAction(new QChangeEvent(), new QAjaxAction('txtLogType_Change'));

			//$this->txtLogType_Change();

		}



		protected function txtLogType_Change() {

			// make the user select the paid date first so we can calculate the start and expire dates

			if ($this->calPaidOn->DateTime == ''){

				$this->txtLogType->SelectedValue=NULL;

				QApplication::DisplayAlert("Please select the date paid");

				return;

			}



			$MembershipStartDate='';

			// set start and expire dates

			

			// if we have a previous membership logged and it is greater than today then we default to the current membership expiration

			// everything else we default to today

			if ($this->expirationDate && $this->expirationDate > $this->today) {

				$MembershipStartDate = clone $this->expirationDate;

			}

			else {

				$MembershipStartDate = clone $this->today;

			}



			$expiryDate = clone $MembershipStartDate;

			// QApplication::DisplayAlert("expiryDate=".$expiryDate->toString());

			$this->calStartDate->DateTime = $MembershipStartDate;

			$this->calExpireDate->DateTime = $expiryDate->AddYears(MembershipLog::$membershipTypeArray[$this->txtLogType->SelectedValue][0]);

			// if this is a family membership then flag the member as primary if none exist

			if ($this->txtLogType->SelectedValue==3 || $this->txtLogType->SelectedValue==4 || $this->txtLogType->SelectedValue==8 || $this->txtLogType->SelectedValue==11) {

				// if we are editing a log then make sure we have a member assigned as primary member for the membership

				// else we are creating a new log then

				if ($this->objMembershipLog->Id) {

					$objMembershipAssoc = MembershipAssoc::QuerySingle(

						QQ::AndCondition(

							QQ::Equal(QQN::MembershipAssoc()->MembershipLogId, $this->objMembershipLog->Id),

							QQ::Equal(QQN::MembershipAssoc()->MemberId, $this->objMembershipLog->MemberId)

						)

					);

					if ($objMembershipAssoc) {

						if ($objMembershipAssoc->PrimaryMember) {

							$this->txtLogType->HtmlAfter = "<div class='alert alert-primary'>This member is assigned as the primary contact for this family membership</div>";

						}

					}

				}

				else {

					$this->txtLogType->HtmlAfter = "<div class='alert alert-danger'>***Note: This member will be assigned as the primary contact for this family membership***</div>";

				}

			}

			else $this->txtLogType->HtmlAfter = "";

		}



		// Create and Setup calStartDate

		protected function calStartDate_Create() {

			$this->calStartDate = new QJsCalendar($this);

			$this->calStartDate->Name = QApplication::Translate('Start Date');

			$this->calStartDate->DateTime = $this->objMembershipLog->StartDate;

		}



		// Create and Setup calExpireDate

		protected function calExpireDate_Create() {

			$this->calExpireDate = new QJsCalendar($this);

			$this->calExpireDate->Name = QApplication::Translate('Expire Date');

			$this->calExpireDate->DateTime = $this->objMembershipLog->ExpireDate;

		}



		// Create and Setup txtPaymentType

		protected function txtPaymentType_Create() {

			$this->txtPaymentType = new QRadioButtonList($this);

			$this->txtPaymentType->Name = QApplication::Translate('Payment Type');



			$objMembershipTypeArray = MembershipLog::$paymentTypeArray;

			if ($objMembershipTypeArray) foreach ($objMembershipTypeArray as $key=>$value) {

				$objListItem = new QListItem($value, $key);

				if (($this->objMembershipLog->PaymentType) && ($this->objMembershipLog->PaymentType == $key))

					$objListItem->Selected = true;

				$this->txtPaymentType->AddItem($objListItem);

			}

		}



		// Create and Setup calPaidOn

		protected function calPaidOn_Create() {

			$this->calPaidOn = new QJsCalendar($this);

			$this->calPaidOn->Name = QApplication::Translate('Paid on/Membership start');

			if ($this->objMembershipLog->Id == '')

				$this->calPaidOn->DateTime = clone $this->today;

			else

				$this->calPaidOn->DateTime = $this->objMembershipLog->PaidOn;

		}



		// Create and Setup txtNote

		protected function txtNote_Create() {

			$this->txtNote = new QTextBox($this);

			$this->txtNote->Name = QApplication::Translate('Note');

			$this->txtNote->Text = $this->objMembershipLog->Note;

			$this->txtNote->MaxLength = MembershipLog::NoteMaxLength;

		}



		// Create and Setup lstMemberIdObject

		protected function lstMemberIdObject_Create() {

			$this->lstMemberIdObject = new QLabel($this);

			$this->lstMemberIdObject->HtmlEntities = false;

			

			$strExpires='';

			// membership log found

			if ($this->objMembershipAssoc) {

				$strExpires = "<div>".MembershipAssoc::CurrentMembershipExpireString($this->objMembershipAssoc)."</div>";

			}

			$this->lstMemberIdObject->Text = MemberContact::BasicMemberContactInfo($this->objMemberContact,'').$strExpires;

		}



		protected function UpdateMembershipLogFields() {

			$this->objMembershipLog->LogType = $this->txtLogType->SelectedValue;

			$this->objMembershipLog->StartDate = $this->calStartDate->DateTime;

			$this->objMembershipLog->ExpireDate = $this->calExpireDate->DateTime;

			$this->objMembershipLog->PaymentType = $this->txtPaymentType->SelectedValue;

			$this->objMembershipLog->PaymentAmount = MembershipLog::$membershipTypeArray[$this->txtLogType->SelectedValue][1];

			$this->objMembershipLog->PaidOn = $this->calPaidOn->DateTime;

			$this->objMembershipLog->Note = $this->txtNote->Text;

			$this->objMembershipLog->MedTrainingType = $this->txtMedTrainingType->SelectedValue;

			$this->objMembershipLog->WillingMedVolunteer = $this->chkWillingMedVolunteer->Checked;

			$this->objMembershipLog->MembershipConsent = QDateTime::Now(false);

			$this->objMembershipLog->ConsentSignature = "yes";

			// do not set new membership flag for complimentary members otherwise they appear as new members in the newsletter

			if ($this->txtPaymentType->SelectedValue==6)

				$this->objMembershipLog->NewMembership = 0;

			else

				$this->objMembershipLog->NewMembership = $this->chkNewMembership->Checked;

			if (!$this->blnEditMode)

				$this->objMembershipLog->LogDate = QDateTime::Now(false);

			$this->objMembershipLog->PayPalTransactionId = $this->txtPayPalTransactionId->Text;

		}



		protected function txtMedTrainingType_Create() {

			$this->txtMedTrainingType = new QRadioButtonList($this);

			$this->txtMedTrainingType->Name = QApplication::Translate('Medical training?');



			$objMembershipTypeArray = MembershipLog::$medicalTrainingArray;

			if ($objMembershipTypeArray) foreach ($objMembershipTypeArray as $key=>$value) {

				$objListItem = new QListItem($value, $key);

				if (($this->objMembershipLog->MedTrainingType) && ($this->objMembershipLog->MedTrainingType == $key))

					$objListItem->Selected = true;

				$this->txtMedTrainingType->AddItem($objListItem);

			}

		}



		protected function chkWillingMedVolunteer_Create() {

			$this->chkWillingMedVolunteer = new QCheckBox($this);

			$this->chkWillingMedVolunteer->Name = $_ENV['MED_VOLUNTEER_TXT'];

			$this->chkWillingMedVolunteer->Checked = $this->objMembershipLog->WillingMedVolunteer;

		}



		protected function btnSave_Click($strFormId, $strControlId, $strParameter) {

			$this->UpdateMembershipLogFields();

			$this->objMembershipLog->Save();



			// if this is a new member or they have no access then auto assign them member access

			if (!$this->objMembershipAssoc || MemberAclAssn::CountByMemberId($this->objMemberContact->Id) < 1) {

				$objMemberAclAssn = new MemberAclAssn();

				$objMemberAclAssn->MemberId = $this->objMemberContact->Id;

				$objMemberAclAssn->Acl = 2;

				$objMemberAclAssn->Save();

			}

		 

			// associate this member as primary family member if creating a new membership log

			if (!$this->blnEditMode) {

				$objMemberAssoc = new MembershipAssoc();

				$objMemberAssoc->PrimaryMember = true;

				$objMemberAssoc->MemberId = $this->objMembershipLog->MemberId;

				$objMemberAssoc->MembershipLogId = $this->objMembershipLog->Id;

				$objMemberAssoc->Save();



				// if not a family membership, send an email notification

				if ($this->txtLogType->SelectedValue!=3 && $this->txtLogType->SelectedValue!=4 && $this->txtLogType->SelectedValue!=8  && $this->txtLogType->SelectedValue!=11){

					$this->sendNotification();	// disable on development

					exit;

				}

			}



			$this->RedirectToListPage();

		}



		// send an email notification to the member about their membership renewal

		protected function sendNotification() {

			QApplication::Redirect('emailNotification.php?option=membershipUpdate&iMD='.$this->objMembershipLog->MemberId);

		}



		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {

			$objMembershipAssoc = MembershipAssoc::QuerySingle(

				QQ::AndCondition(

					QQ::Equal(QQN::MembershipAssoc()->MembershipLogId, $this->objMembershipLog->Id),

					QQ::Equal(QQN::MembershipAssoc()->MemberId, $this->objMemberContact->Id)

				)

			);

			if ($objMembershipAssoc) $objMembershipAssoc->Delete();

			$this->objMembershipLog->Delete();



			$this->RedirectToListPage();

		}



		protected function RedirectToListPage() {

			QApplication::Redirect('MembershipLogs.php?iMD='.$this->objMemberContact->Id);

		}



		protected function txtPayPalTransactionId_Create() {

			$this->txtPayPalTransactionId = new QTextBox($this);

			$this->txtPayPalTransactionId->Name = QApplication::Translate('Paypal Transaction ID');

			$this->txtPayPalTransactionId->Text = $this->objMembershipLog->PayPalTransactionId;

			$this->txtPayPalTransactionId->MaxLength = MembershipLog::PayPalTransactionIdMaxLength;

			$this->txtPayPalTransactionId->AddAction(new QChangeEvent(), new QAjaxAction('trimLeadingTrailing'));

		}



		public function trimLeadingTrailing($strFormId, $strControlId, $strParameter){

			// Let's see if the checkbox exists already

			$objComponent = $this->GetControl($strControlId);

			$objComponent->Text = trim($objComponent->Text);

		}

	}



	// member access

	class acx2MembershipLogEditForm extends acx1MembershipLogEditForm {

		protected $strOption;

		protected function SetupMembershipLog() {}



		protected function Form_Create() {

			$this->strOption = QApplication::QueryString('strOption');

			if ($this->strOption=='startRenewal') {

				QSessionDB::set(__SESSION_PREFIX__.'__START_MEMBER_RENEWAL__', true);

				QApplication::Redirect('Membership.php?strOption=renewalType');

				exit;

			}

			elseif ($this->strOption=='renewalType') {

				// maybe pull last membership settings and set as default

				$this->txtLogType_RenewalCreate();

				$this->txtPaymentType_RenewalCreate();

				$this->txtMedTrainingType_Create();

				$this->chkWillingMedVolunteer_Create();

			}

			$this->btnSave_Create();

			$this->btnCancel_Create();

		}



		// Create and Setup calStartDate

		protected function calStartDate_Create() {

			$this->calStartDate = new QJsCalendar($this);

			$this->calStartDate->Name = QApplication::Translate('Start Date');

			$this->calStartDate->DateTime = $this->objMembershipLog->StartDate;

			$this->calStartDate->Enabled = false;

		}



		// Create and Setup calExpireDate

		protected function calExpireDate_Create() {

			$this->calExpireDate = new QJsCalendar($this);

			$this->calExpireDate->Name = QApplication::Translate('Expire Date');

			$this->calExpireDate->DateTime = $this->objMembershipLog->ExpireDate;

			$this->calExpireDate->Enabled = false;

		}



		protected function txtLogType_RenewalCreate() {

			$this->txtLogType = new QRadioButtonList($this);

			$this->txtLogType->Name = QApplication::Translate('Membership Renewal Type');

			$this->txtLogType->Required = true;

			$objMembershipTypeArray = MembershipLog::$membershipTypeArray;

			if ($objMembershipTypeArray) foreach ($objMembershipTypeArray as $key=>$membershipTypeArray) {

				// only show 'fee' membership options

				if ($membershipTypeArray[3]){

					$objListItem = new QListItem(MembershipLog::showMembershipType($key), $key);

					if (QSessionDB::get(__SESSION_PREFIX__.'__txtLogType__') && (QSessionDB::get(__SESSION_PREFIX__.'__txtLogType__') == $key))

						$objListItem->Selected = true;

					$this->txtLogType->AddItem($objListItem);

				}

			}

			$this->txtLogType->AddAction(new QChangeEvent(), new QAjaxAction('txtLogType_Renewal_Change'));

		}



		protected function txtMedTrainingType_Create() {

			$this->txtMedTrainingType = new QListBox($this);

			$this->txtMedTrainingType->Name = QApplication::Translate('Do you have any of the following medical training?');

			$this->txtMedTrainingType->Rows = 4;

			$objListItem = new QListItem('--None--',NULL);

			if (!QSessionDB::get(__SESSION_PREFIX__.'__txtMedTrainingType__'))

				$objListItem->Selected = true;

			$this->txtMedTrainingType->AddItem($objListItem);

			$this->txtMedTrainingType->AddAction(new QChangeEvent(), new QAjaxAction('txtMedTrainingType_Renewal_Change'));

			$objMembershipTypeArray = MembershipLog::$medicalTrainingArray;

			if ($objMembershipTypeArray) foreach ($objMembershipTypeArray as $key=>$value) {

				$objListItem = new QListItem($value, $key);

				if (QSessionDB::get(__SESSION_PREFIX__.'__txtMedTrainingType__') && (QSessionDB::get(__SESSION_PREFIX__.'__txtMedTrainingType__') == $key))

					$objListItem->Selected = true;

				$this->txtMedTrainingType->AddItem($objListItem);

			}

		}



		protected function chkWillingMedVolunteer_Create() {

			$this->chkWillingMedVolunteer = new QCheckBox($this);

			$this->chkWillingMedVolunteer->Name = $_ENV['MED_VOLUNTEER_TXT'];

			$this->chkWillingMedVolunteer->Checked = QSessionDB::get(__SESSION_PREFIX__.'__chkWillingMedVolunteer__');

			$this->chkWillingMedVolunteer->AddAction(new QChangeEvent(), new QAjaxAction('chkWillingMedVolunteer_Renewal_Change'));

		}



		protected function txtMedTrainingType_Renewal_Change() {

			if (!$this->txtMedTrainingType->SelectedValue)

				QSessionDB::Delete(__SESSION_PREFIX__.'__txtMedTrainingType__');

			else

				QSessionDB::set(__SESSION_PREFIX__.'__txtMedTrainingType__',$this->txtMedTrainingType->SelectedValue);

		}



		protected function chkWillingMedVolunteer_Renewal_Change() {

			if (!$this->chkWillingMedVolunteer->Checked)

				QSessionDB::delete(__SESSION_PREFIX__.'__chkWillingMedVolunteer__');

			else

				QSessionDB::set(__SESSION_PREFIX__.'__chkWillingMedVolunteer__', $this->chkWillingMedVolunteer->Checked);

		}



		protected function txtLogType_Renewal_Change() {

			QSessionDB::set(__SESSION_PREFIX__.'__txtLogType__', $this->txtLogType->SelectedValue);

		}



		protected function btnSave_Create() {

			$this->btnSave = new QButton($this);

			$this->btnSave->Text = QApplication::Translate('Next >');

			$this->btnSave->AddAction(new QClickEvent(), new QServerAction('btnSave_Click'));

			$this->btnSave->CausesValidation = true;

			$this->btnSave->CssClass = "fltR";

		}



		// Setup btnCancel

		protected function btnCancel_Create() {

			$this->btnCancel = new QButton($this);

			$this->btnCancel->Text = QApplication::Translate('< Back');

			$this->btnCancel->AddAction(new QClickEvent(), new QServerAction('btnCancel_Click'));

			$this->btnCancel->CausesValidation = false;

			$this->btnCancel->CssClass = "fltL";

		}



		protected function btnSave_Click($strFormId, $strControlId, $strParameter) {

			QApplication::Redirect('MemberContact.php?strOption=contactCheck');

		}



		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {

			QApplication::Redirect('index.php');

		}



		protected function txtPaymentType_RenewalCreate() {

			$this->txtPaymentType = new QRadioButtonList($this);

			$this->txtPaymentType->Name = QApplication::Translate('Payment Type');

			$this->txtPaymentType->Required = true;

			$objMembershipTypeArray = MembershipLog::$paymentTypeArray;

			if ($objMembershipTypeArray) foreach ($objMembershipTypeArray as $key=>$value) {

				$objListItem = new QListItem($value, $key);

				if (QSessionDB::get(__SESSION_PREFIX__.'__txtPaymentType__') && (QSessionDB::get(__SESSION_PREFIX__.'__txtPaymentType__') == $key))

					$objListItem->Selected = true;

				$this->txtPaymentType->AddItem($objListItem);

			}

			$this->txtPaymentType->AddAction(new QChangeEvent(), new QAjaxAction('txtPaymentType_Renewal_Change'));

		}



		protected function txtPaymentType_Renewal_Change() {

			QSessionDB::set(__SESSION_PREFIX__.'__txtPaymentType__', $this->txtPaymentType->SelectedValue);

		}

	}

	// go to the centralized form executing access control function to run the form and check access control

	ACL_Run('Membership');

?>