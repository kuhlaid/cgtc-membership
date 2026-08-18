<?php
/**
 * @abstract Form used to edit/create a member contact.
 * @author w. Patrick Gale
 *
 * Feb. 10, 2019 - wpg
 * - defaulting the join date for new members
 * 
 * June 5, 2018 - wpg
 * - adding the 'trim' function to the rest of the form elements where it matters
 *
 * Jan. 20, 2018 - wpg
 * - ensuring we are updating the member profile during membership renewal and tracking the updates through the notification log
 *
 * Jan. 8, 2018 - wpg
 * - editing for 'contactCheck' membership renewal
 *
 * Jan. 1, 2018 - wpg
 * - adding member editing
 *
 * June 4, 2017 - wpg
 * - added NotActive field so we stop bugging people who want to take a break from the club
 *
 * May 20, 2017 - wpg
 * - creating a function to add family members (duplicate address and phone number from primary member)
 *
 * May 9, 2017 - wpg
 * - adding the partner business list so partner members can be assigned to their businesses
 *
 * April 25, 2017 - wpg
 * - adding JoinedClub field
 *
 * April 14, 2017 - wpg
 * - creating scripts to convert all upper-case membership info to camel-case
 *
 * April 9, 2017 - wpg
 * - adding links to view single member info in the membership list on redirect
 *
 * April 3, 2017 - wpg
 * - adding a check to see that duplicate email addresses are not added when a new member is created
 *
 * March 19, 2017 - wpg
 * - setting up basic form
 * - changing last name to autocomplete so when we are adding a new member it will help us in preventing adding a duplicate (or to create a family member)
 */
	// Include prepend.inc to load Qcodo
	require('includes/prepend.inc.php');
	require(__FORMBASE_CLASSES__ . '/MemberContactEditFormBase.class.php');
	QApplication::CheckRemoteAdmin();

	// admin access
	class acx1MemberContactEditForm extends MemberContactEditFormBase {
		protected $lstPartnerBusiness;

		protected function SetupMemberContact() {
			// Lookup Object PK information from Query String (if applicable)
			// Set mode to Edit or New depending on what's found
			$intId = QApplication::QueryString('intId');
			$strOption = QApplication::QueryString('option');
			if (($intId)) {
				// if copying member contact info from primary contact
				if ($strOption=='copy'){
					$objMemberContact = MemberContact::Load(($intId));
					$this->newMember();
					$this->objMemberContact->LastName = $objMemberContact->LastName;
					$this->objMemberContact->Addr1 = $objMemberContact->Addr1;
					$this->objMemberContact->Addr2 = $objMemberContact->Addr2;
					$this->objMemberContact->City = $objMemberContact->City;
					$this->objMemberContact->State = $objMemberContact->State;
					$this->objMemberContact->Zip = $objMemberContact->Zip;
					if ($this->txtGender->SelectedValue != '')
						$this->objMemberContact->Gender = $this->txtGender->SelectedValue;
					$this->objMemberContact->MainPhone = $objMemberContact->MainPhone;
					$this->objMemberContact->AltPhone = $objMemberContact->AltPhone;
					$this->objMemberContact->JoinedClub = $objMemberContact->JoinedClub;
				}
				else
					$this->objMemberContact = MemberContact::Load(($intId));

				if (!$this->objMemberContact)
					throw new Exception('Could not find a MemberContact object with PK arguments: ' . $intId);

				$this->strTitleVerb = QApplication::Translate('Edit');
				$this->blnEditMode = true;
			}
			else {
				$this->newMember();
			}
		}

		protected function newMember(){
			$this->objMemberContact = new MemberContact();
			$this->strTitleVerb = QApplication::Translate('Create');
			$this->blnEditMode = false;
		}

		protected function Form_Create() {
			parent::Form_Create();
			$this->lstPartnerBusiness_Create();
		}

		protected function lstPartnerBusiness_Create() {
			$this->lstPartnerBusiness = new QListBox($this);
			$this->lstPartnerBusiness->Name = QApplication::Translate('Represents Partner Business');
			$this->lstPartnerBusiness->AddItem(QApplication::Translate('- Select One -'), null);
			$objPartnerBusinessIdObjectArray = PartnerBusiness::QueryArray(QQ::All(),QQ::Clause(QQ::OrderBy(QQN::PartnerBusiness()->Name, 1)),null, null, array('Id','Name'));
			$objBusinessMemberAssocArray = $this->objMemberContact->GetPartnerBusinessArray();
			if ($objPartnerBusinessIdObjectArray) foreach ($objPartnerBusinessIdObjectArray as $objPartnerBusinessIdObject) {
				$objListItem = new QListItem($objPartnerBusinessIdObject->__toString(), $objPartnerBusinessIdObject->Id);
				foreach ($objBusinessMemberAssocArray as $objBusinessMemberAssoc) {
					if (($objBusinessMemberAssoc->PartnerBusinessIdObject) && ($objBusinessMemberAssoc->PartnerBusinessIdObject->Id == $objPartnerBusinessIdObject->Id))
						$objListItem->Selected = true;
				}
				$this->lstPartnerBusiness->AddItem($objListItem);
			}
		}

		protected function lstPartnerBusiness_Update() {
			$this->objMemberContact->UnassociateAllPartnerBusinesses();
			$objSelectedListItems = $this->lstPartnerBusiness->SelectedItems;
			if ($objSelectedListItems) foreach ($objSelectedListItems as $objListItem) {
				if ($objListItem->Value != '')
					$this->objMemberContact->AssociatePartnerBusiness(PartnerBusiness::Load($objListItem->Value));
			}
		}

	// Control ServerActions
		protected function btnSave_Click($strFormId, $strControlId, $strParameter) {
			$this->UpdateMemberContactFields();
			$this->objMemberContact->Save();

			$this->lstPartnerBusiness_Update();	// added May 9, 2017 - wpg
			$this->RedirectToListPage();
		}

		protected function txtEmail_Create() {
			$this->txtEmail = new QTextBox($this);
			$this->txtEmail->Name = QApplication::Translate('Email');
			$this->txtEmail->Text = $this->objMemberContact->Email;
			$this->txtEmail->MaxLength = MemberContact::EmailMaxLength;
			$this->txtEmail->AddAction(new QChangeEvent(), new QAjaxAction('trimLeadingTrailing'));
			$this->txtEmail->HtmlAfter = $_ENV['EMAIL_USE_MSG'];
		}

		public function trimLeadingTrailing($strFormId, $strControlId, $strParameter){
			// Let's see if the checkbox exists already
			$objComponent = $this->GetControl($strControlId);
			$objComponent->Text = trim($objComponent->Text ?? '');
		}

		protected function txtFirstName_Create() {
			parent::txtFirstName_Create();
			$this->txtFirstName->AddAction(new QChangeEvent(), new QAjaxAction('trimLeadingTrailing'));
		}

		protected function txtMainPhone_Create() {
			$this->txtMainPhone = new QTextBox($this);
			$this->txtMainPhone->Name = 'Main Phone';
			$this->txtMainPhone->Text = $this->objMemberContact->MainPhone;
			$this->txtMainPhone->MaxLength = MemberContact::MainPhoneMaxLength;
			$this->txtMainPhone->AddAction(new QChangeEvent(), new QAjaxAction('trimLeadingTrailing'));
		}

		// Create and Setup txtAltPhone
		protected function txtAltPhone_Create() {
			$this->txtAltPhone = new QTextBox($this);
			$this->txtAltPhone->Name = QApplication::Translate('Alt Phone');
			$this->txtAltPhone->Text = $this->objMemberContact->AltPhone;
			$this->txtAltPhone->MaxLength = MemberContact::AltPhoneMaxLength;
			$this->txtAltPhone->AddAction(new QChangeEvent(), new QAjaxAction('trimLeadingTrailing'));
		}

		protected function txtLastName_Create() {
			$this->txtLastName = new QAutoCompleteTextBox($this);
			$this->txtLastName->Name = QApplication::Translate('Last Name');
			$this->txtLastName->Text = $this->objMemberContact->LastName;
			$this->txtLastName->Required = true;
			$this->txtLastName->CssClass = 'bld hghLight';
			$this->txtLastName->UseAjax = true;
			$this->txtLastName->MinChars = 3;
			$this->txtLastName->MaxLength = MemberContact::LastNameMaxLength;
			$this->txtLastName->HtmlAfter = '<br/><span style="font-size:11px;">Note: As you type, a list of current members will appear below to help prevent adding duplicate members.</span>';
			$this->txtLastName->AddAction(new QAutoCompleteTextBoxEvent(), new QAjaxAction('txtLastName_Change'));
			$this->txtLastName->AddAction(new QChangeEvent(), new QAjaxAction('trimLeadingTrailing'));
		}

		// show last names that exist in the database beginning with the keyed in characters (March 19, 2017 - wpg)
		public function txtLastName_Change($strFormId, $strControlId, $strParameter){
			// get the list of existing last names
			$objMemberContactArray = MemberContact::QueryArray(
					QQ::AndCondition(
							QQ::Like(QQN::MemberContact()->LastName, "%$strParameter%")
					),array(),array(),array('FirstName','LastName')
			);

			if ($objMemberContactArray) foreach($objMemberContactArray as $objMemberContact) {
				print $objMemberContact->FirstName." ".$objMemberContact->LastName."\n";
			}

			exit;
		}

		protected function txtGender_Create() {
			$this->txtGender = new QListBox($this);
			$this->txtGender->Name = QApplication::Translate('Gender');
			if (!$this->blnEditMode || !$this->objMemberContact->Gender)
				$this->txtGender->AddItem(QApplication::Translate('- Select One -'), null);
			$objMembershipTypeArray = MemberContact::$genderArray;
			if ($objMembershipTypeArray) foreach ($objMembershipTypeArray as $key=>$value) {
				$objListItem = new QListItem($value, $key);
				if (($this->objMemberContact->Gender) && ($this->objMemberContact->Gender == $key))
					$objListItem->Selected = true;
				$this->txtGender->AddItem($objListItem);
			}
		}

		protected function txtBirthDay_Create() {
			$this->txtBirthDay = new QIntegerTextBox($this);
			$this->txtBirthDay->Name = QApplication::Translate('Birth Day');
			$this->txtBirthDay->Text = $this->objMemberContact->BirthDay;
			$this->txtBirthDay->Width = '25px';
			$this->txtBirthDay->Minimum = 1;
			$this->txtBirthDay->Maximum = 32;
		}

		protected function txtBirthMonth_Create() {
			$this->txtBirthMonth = new QListBox($this);
			$this->txtBirthMonth->Name = QApplication::Translate('Birth Month');
			if (!$this->blnEditMode || !$this->objMemberContact->BirthMonth)
				$this->txtBirthMonth->AddItem(QApplication::Translate('- Select One -'), null);
			$objMembershipTypeArray = MemberContact::$monthArray;
			if ($objMembershipTypeArray) foreach ($objMembershipTypeArray as $key=>$value) {
				$objListItem = new QListItem($value, $key);
				if (($this->objMemberContact->BirthMonth) && ($this->objMemberContact->BirthMonth == $key))
					$objListItem->Selected = true;
				$this->txtBirthMonth->AddItem($objListItem);
			}
		}

		protected function txtBirthYear_Create() {
			$this->txtBirthYear = new QIntegerTextBox($this);
			$this->txtBirthYear->Name = QApplication::Translate('Birth Year');
			$this->txtBirthYear->Text = $this->objMemberContact->BirthYear;
			$this->txtBirthYear->Width = '50px';
			$this->txtBirthYear->Minimum = 1890;
			$this->txtBirthYear->Maximum = 2025;
			$this->txtBirthYear->AddAction(new QChangeEvent(), new QAjaxAction('trimLeadingTrailing'));
		}

		protected function txtState_Create() {
			$this->txtState = new QListBox($this);
			$this->txtState->Name = QApplication::Translate('State');
			$this->txtState->Required = true;
			if (!$this->blnEditMode)
					$this->txtState->AddItem(QApplication::Translate('- Select One -'), null);
			$objMembershipTypeArray = MemberContact::$stateArray;
			if ($objMembershipTypeArray) foreach ($objMembershipTypeArray as $key=>$value) {
				$objListItem = new QListItem($value, $key);
				if (($this->objMemberContact->State) && ($this->objMemberContact->State == $key))
					$objListItem->Selected = true;
				$this->txtState->AddItem($objListItem);
			}
		}

		protected function txtAddr1_Create() {
			$this->txtAddr1 = new QTextBox($this);
			$this->txtAddr1->Name = QApplication::Translate('Address Line 1');
			$this->txtAddr1->Text = $this->objMemberContact->Addr1;
			$this->txtAddr1->MaxLength = MemberContact::Addr1MaxLength;
			$this->txtAddr1->Required = true;
			$this->txtAddr1->AddAction(new QChangeEvent(), new QAjaxAction('trimLeadingTrailing'));
		}

		// Create and Setup txtAddr2
		protected function txtAddr2_Create() {
			$this->txtAddr2 = new QTextBox($this);
			$this->txtAddr2->Name = QApplication::Translate('Address Line 2');
			$this->txtAddr2->Text = $this->objMemberContact->Addr2;
			$this->txtAddr2->MaxLength = MemberContact::Addr2MaxLength;
			$this->txtAddr2->AddAction(new QChangeEvent(), new QAjaxAction('trimLeadingTrailing'));
		}

		protected function txtCity_Create() {
			$this->txtCity = new QTextBox($this);
			$this->txtCity->Name = QApplication::Translate('City');
			$this->txtCity->Text = $this->objMemberContact->City;
			$this->txtCity->MaxLength = MemberContact::CityMaxLength;
			$this->txtCity->Required = true;
			$this->txtCity->AddAction(new QChangeEvent(), new QAjaxAction('trimLeadingTrailing'));
		}

		// Create and Setup txtZip
		protected function txtZip_Create() {
			$this->txtZip = new QTextBox($this);
			$this->txtZip->Name = QApplication::Translate('Zip');
			$this->txtZip->Text = $this->objMemberContact->Zip;
			$this->txtZip->MaxLength = MemberContact::ZipMaxLength;
			$this->txtZip->Required = true;
			$this->txtZip->AddAction(new QChangeEvent(), new QAjaxAction('trimLeadingTrailing'));
		}

		protected function calJoinedClub_Create() {
			$this->calJoinedClub = new QJsCalendar($this);
			$this->calJoinedClub->Name = QApplication::Translate('Joined Club');
			$today = QDateTime::Now(false);
			if(!$this->blnEditMode){
				$this->calJoinedClub->DateTime = $today;
			}
			else $this->calJoinedClub->DateTime = $this->objMemberContact->JoinedClub;
		}

		protected function standardizeStr($str){
			return trim($str ?? '');
		}

		protected function UpdateMemberContactFields() {
			// if entering a new member, do not allow duplicate email address since that would signify an existing member
			if(!$this->blnEditMode){
				$email = $this->standardizeStr($this->txtEmail->Text);
				// only applies to email addresses entered
				if ($email != '') {
					// see if the member is already registered with this email
					$objMemberContact = MemberContact::QueryArray(
						QQ::AndCondition(
								QQ::Like(QQN::MemberContact()->Email, $email)
						)
					);

					if ($objMemberContact) {
						$this->txtEmail->Text='';
						QSessionDB::set("error", $email." is already registered in our system as an email address.  If your membership has expired, please use the membership renewal form.");
						$this->RedirectToListPage();
						exit;
					}
				}
			}

			$this->objMemberContact->LastName = $this->standardizeStr($this->txtLastName->Text);
			$this->objMemberContact->FirstName = $this->standardizeStr($this->txtFirstName->Text);
			$this->objMemberContact->Email = strtolower($this->standardizeStr($this->txtEmail->Text));
			$this->objMemberContact->Addr1 = $this->standardizeStr($this->txtAddr1->Text);
			$this->objMemberContact->Addr2 = $this->standardizeStr($this->txtAddr2->Text);
			$this->objMemberContact->City = ucwords(strtolower($this->standardizeStr($this->txtCity->Text)));
			$this->objMemberContact->State = $this->txtState->SelectedValue;
			$this->objMemberContact->Zip = $this->standardizeStr($this->txtZip->Text);
			$this->objMemberContact->Gender = $this->txtGender->SelectedValue;
			$this->objMemberContact->BirthDay = $this->standardizeStr($this->txtBirthDay->Text);
			$this->objMemberContact->BirthMonth = $this->txtBirthMonth->SelectedValue;
			$this->objMemberContact->BirthYear = $this->standardizeStr($this->txtBirthYear->Text);
			$this->objMemberContact->MainPhone = $this->standardizeStr($this->txtMainPhone->Text);
			$this->objMemberContact->AltPhone = $this->standardizeStr($this->txtAltPhone->Text);
			$this->objMemberContact->Note = $this->standardizeStr($this->txtNote->Text);
			$this->objMemberContact->JoinedClub = $this->calJoinedClub->DateTime;
			$this->objMemberContact->NotActive = $this->chkNotActive->Checked;
			$this->objMemberContact->GoogleEmail = $this->txtGoogleEmail->Text;
			$this->objMemberContact->FacebookEmail = $this->txtFacebookEmail->Text;
			$this->objMemberContact->ImageReference = '';

			// add current date for new member
			if(!$this->blnEditMode)
				$this->objMemberContact->ContactAdded = QDateTime::Now(false);
		}

		protected function chkNotActive_Create() {
			$this->chkNotActive = new QCheckBox($this);
			$this->chkNotActive->Name = QApplication::Translate('Member no longer active?');
			$this->chkNotActive->Checked = $this->objMemberContact->NotActive;
		}

		protected function RedirectToListPage() {
			QApplication::Redirect('MembershipList.php?iMD='.$this->objMemberContact->Id);
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {
			QApplication::DisplayAlert("***You must delete members directly from the database.***");
		}

	}
	// go to the centralized form executing access control function to run the form and check access control

	// member access
	class acx2MemberContactEditForm extends acx1MemberContactEditForm {
		protected $strUpdateChanges, $strOption;
		protected function SetupMemberContact() {
			$this->objMemberContact = MemberContact::Load(QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__'));
		}

		protected function Form_Create() {
			// Call SetupMemberContact to either Load/Edit Existing or Create New
			$this->SetupMemberContact();

			$this->strOption = QApplication::QueryString('strOption');
			if ($this->strOption=='contactCheck') {
				$this->btnSave_RenewalCreate();
				$this->btnCancel_RenewalCreate();
			}
			else {
				$this->btnSave_Create();
				$this->btnCancel_Create();
			}
			$this->txtLastName_Create();
			$this->txtFirstName_Create();
			$this->txtEmail_Create();
			$this->txtAddr1_Create();
			$this->txtAddr2_Create();
			$this->txtCity_Create();
			$this->txtState_Create();
			$this->txtZip_Create();
			$this->txtGender_Create();
			$this->txtBirthDay_Create();
			$this->txtBirthMonth_Create();
			$this->txtBirthYear_Create();
			$this->txtMainPhone_Create();
			$this->txtAltPhone_Create();
			$this->txtGoogleEmail_Create();
			$this->txtFacebookEmail_Create();
			$this->calJoinedClub_Create();
			$this->txtImageReference_Create();
		}

		protected function txtEmail_Create() {
			$this->txtEmail = new QTextBox($this);
			$this->txtEmail->Name = QApplication::Translate('Email');
			$this->txtEmail->Text = $this->objMemberContact->Email;
			$this->txtEmail->MaxLength = MemberContact::EmailMaxLength;
			$this->txtEmail->Required = true;
			$this->txtEmail->AddAction(new QChangeEvent(), new QAjaxAction('trimLeadingTrailing'));
			$this->txtEmail->HtmlAfter = $_ENV['EMAIL_USE_MSG'];
		}

		protected function btnSave_RenewalCreate() {
			$this->btnSave = new QButton($this);
			$this->btnSave->Text = QApplication::Translate('Next >');
			$this->btnSave->AddAction(new QClickEvent(), new QServerAction('btnSave_RenewalClick'));
			$this->btnSave->CausesValidation = true;
			$this->btnSave->CssClass = "fltR";
		}

		// Setup btnCancel
		protected function btnCancel_RenewalCreate() {
			$this->btnCancel = new QButton($this);
			$this->btnCancel->Text = QApplication::Translate('< Back');
			$this->btnCancel->AddAction(new QClickEvent(), new QServerAction('btnCancel_RenewalClick'));
			$this->btnCancel->CausesValidation = false;
			$this->btnCancel->CssClass = "fltL";
		}

		protected function btnSave_RenewalClick($strFormId, $strControlId, $strParameter) {
			$this->UpdateMemberContactFields();
			$this->objMemberContact->Save();
			$this->notificationLogUpdate();
			QSessionDB::set(__SESSION_PREFIX__.'__memberRenewal_contactCheck__', true);
			QApplication::Redirect('MembershipWaiver.php?strOption=memberRenewal');
		}

		protected function btnCancel_RenewalClick($strFormId, $strControlId, $strParameter) {
			QApplication::Redirect('Membership.php?strOption=renewalType');
		}

		// -----------------

		protected function txtFirstName_Create() {
			$this->txtFirstName = new QLabel($this);
			$this->txtFirstName->Name = QApplication::Translate('First Name');
			$this->txtFirstName->Text = $this->objMemberContact->FirstName;
			$this->txtFirstName->CssClass = 'bld';
			$this->txtFirstName->Required = true;
		}

		protected function txtLastName_Create() {
			$this->txtLastName = new QLabel($this);
			$this->txtLastName->Name = QApplication::Translate('Last Name');
			$this->txtLastName->Text = $this->objMemberContact->LastName;
			$this->txtLastName->CssClass = 'bld';
			$this->txtLastName->Required = true;
		}

		protected function txtGender_Create() {
			$this->txtGender = new QLabel($this);
			$this->txtGender->Name = QApplication::Translate('Gender');
			$this->txtGender->Text = MemberContact::$genderArray[$this->objMemberContact->Gender];
			$this->txtGender->CssClass = 'bld';
		}

		protected function txtBirthDay_Create() {
			$this->txtBirthDay = new QLabel($this);
			$this->txtBirthDay->Name = QApplication::Translate('Date of Birth');
			$this->txtBirthDay->Text = MemberContact::$monthArray[$this->objMemberContact->BirthMonth]." ".$this->objMemberContact->BirthDay.", ".$this->objMemberContact->BirthYear;
			$this->txtBirthDay->CssClass = 'bld';
		}

		protected function calJoinedClub_Create() {
			$this->calJoinedClub = new QLabel($this);
			$this->calJoinedClub->Name = QApplication::Translate('Joined Club');
			if ($this->objMemberContact->JoinedClub && $this->objMemberContact->JoinedClub->toString("MMM DD, YYYY")!='Nov 30, -0001'){
				$this->calJoinedClub->Text = $this->objMemberContact->JoinedClub->toString("MMMM D, YYYY");
			}
			else
				$this->calJoinedClub->Text = "-- missing a date --";
			$this->calJoinedClub->CssClass = 'bld';
		}

		protected function lstPartnerBusiness_Create() {
			$objBusinessMemberAssocArray = $this->objMemberContact->GetPartnerBusinessArray();
			if ($objBusinessMemberAssocArray) {
				$this->lstPartnerBusiness = new QLabel($this);
				$this->lstPartnerBusiness->Name = QApplication::Translate('Business contact for:');
				$objPartnerBusinessIdObjectArray = PartnerBusiness::QueryArray(QQ::All(),QQ::Clause(QQ::OrderBy(QQN::PartnerBusiness()->Name, 1)),null, null, array('Id','Name'));
				if ($objPartnerBusinessIdObjectArray) foreach ($objPartnerBusinessIdObjectArray as $objPartnerBusinessIdObject) {
					$objListItem = new QListItem($objPartnerBusinessIdObject->__toString(), $objPartnerBusinessIdObject->Id);
					foreach ($objBusinessMemberAssocArray as $objBusinessMemberAssoc) {
						if (($objBusinessMemberAssoc->PartnerBusinessIdObject) && ($objBusinessMemberAssoc->PartnerBusinessIdObject->Id == $objPartnerBusinessIdObject->Id))
							$this->lstPartnerBusiness->Text = $objPartnerBusinessIdObject->__toString();
					}
				}
				$this->lstPartnerBusiness->CssClass = 'bld';
			}
			else {
				$this->lstPartnerBusiness = new QPlain($this);
			}
		}

		protected function notificationLogUpdate(){
			// note that the member updated their profile
			$newNotification = new NotificationLog();
			$newNotification->MemberId = QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__');
			$newNotification->NotificationType=7;	//Member updated their profile
			$newNotification->NotificationDate = QDateTime::Now(true);
			$newNotification->NotificationBody = $this->strUpdateChanges;
			$newNotification->Save();
		}

		protected function btnSave_Click($strFormId, $strControlId, $strParameter) {
			$this->UpdateMemberContactFields();
			$this->objMemberContact->Save();

			$this->notificationLogUpdate();

			$this->RedirectToListPage();
		}

		protected function UpdateMemberContactFields() {
			if (strtolower($this->standardizeStr($this->objMemberContact->Email)) != strtolower($this->standardizeStr($this->txtEmail->Text))) $this->strUpdateChanges .= "<br/>Email address changed from ".$this->objMemberContact->Email." to ".strtolower($this->standardizeStr($this->txtEmail->Text));
			$this->objMemberContact->Email = strtolower($this->standardizeStr($this->txtEmail->Text));

			if ($this->standardizeStr($this->objMemberContact->Addr1) != $this->standardizeStr($this->txtAddr1->Text)) $this->strUpdateChanges .= "<br/>Addr1 address changed from ".$this->objMemberContact->Addr1." to ".$this->standardizeStr($this->txtAddr1->Text);
			$this->objMemberContact->Addr1 = $this->standardizeStr($this->txtAddr1->Text);

			if ($this->standardizeStr($this->objMemberContact->Addr2) != $this->standardizeStr($this->txtAddr2->Text)) $this->strUpdateChanges .= "<br/>Addr2 address changed from ".$this->objMemberContact->Addr2." to ".$this->standardizeStr($this->txtAddr2->Text);
			$this->objMemberContact->Addr2 = $this->standardizeStr($this->txtAddr2->Text);

			if (ucwords(strtolower($this->objMemberContact->City)) != ucwords(strtolower($this->standardizeStr($this->txtCity->Text)))) $this->strUpdateChanges .= "<br/>City changed from ".$this->objMemberContact->City." to ".ucwords(strtolower($this->standardizeStr($this->txtCity->Text)));
			$this->objMemberContact->City = ucwords(strtolower($this->standardizeStr($this->txtCity->Text)));

			if ($this->objMemberContact->State != $this->txtState->SelectedValue) $this->strUpdateChanges .= "<br/>State changed from ".$this->objMemberContact->State." to ".$this->txtState->SelectedValue;
			$this->objMemberContact->State = $this->txtState->SelectedValue;

			if ($this->standardizeStr($this->objMemberContact->Zip) != $this->standardizeStr($this->txtZip->Text)) $this->strUpdateChanges .= "<br/>Zip changed from ".$this->objMemberContact->Zip." to ".$this->standardizeStr($this->txtZip->Text);
			$this->objMemberContact->Zip = $this->standardizeStr($this->txtZip->Text);

			if ($this->standardizeStr($this->objMemberContact->MainPhone) != $this->standardizeStr($this->txtMainPhone->Text)) $this->strUpdateChanges .= "<br/>Main phone changed from ".$this->objMemberContact->MainPhone." to ".$this->standardizeStr($this->txtMainPhone->Text);
			$this->objMemberContact->MainPhone = $this->standardizeStr($this->txtMainPhone->Text);

			if ($this->standardizeStr($this->objMemberContact->AltPhone) != $this->standardizeStr($this->txtAltPhone->Text)) $this->strUpdateChanges .= "<br/>Alt phone changed from ".$this->objMemberContact->AltPhone." to ".$this->standardizeStr($this->txtAltPhone->Text);
			$this->objMemberContact->AltPhone = $this->standardizeStr($this->txtAltPhone->Text);

			if (strtolower($this->standardizeStr($this->objMemberContact->GoogleEmail)) != strtolower($this->standardizeStr($this->txtGoogleEmail->Text))) $this->strUpdateChanges .= "<br/>GoogleEmail changed from ".$this->objMemberContact->GoogleEmail." to ".strtolower($this->standardizeStr($this->txtGoogleEmail->Text));
			$this->objMemberContact->GoogleEmail = strtolower($this->standardizeStr($this->txtGoogleEmail->Text));

			if (strtolower($this->standardizeStr($this->objMemberContact->FacebookEmail)) != strtolower($this->standardizeStr($this->txtFacebookEmail->Text))) $this->strUpdateChanges .= "<br/>FacebookEmail changed from ".$this->objMemberContact->FacebookEmail." to ".strtolower($this->standardizeStr($this->txtFacebookEmail->Text));
			$this->objMemberContact->FacebookEmail = strtolower($this->standardizeStr( $this->txtFacebookEmail->Text));

			$this->objMemberContact->ImageReference = '';
		}

		protected function RedirectToListPage() {
			QApplication::Redirect('index.php');
		}
	}
	ACL_Run('MemberContact');

	// 		protected function ValidateControlAndChildren(QControl $objControl) {
	// 			// Initially Assume Validation is True
	// 			$blnToReturn = true;
	// 			// Check the Control to see if it passes validation
	// 			if (!$objControl->Validate()) {
	// 				QSessionDB::set("_page_ValidateControlID", $objControl->ControlId);
	// 				QApplication::Redirect('#'.$objControl->ControlId);
	// 				exit;	// wpg - we need to exit here for the iPad to behave is a field is required
	// 			}
	// 			return $blnToReturn;
	// 		}

	// 		protected function Form_Exit() {
	// 			parent::Form_Exit();
	// 			$strControlId = QSessionDB::get("_page_ValidateControlID");
	// 			if ($strControlId != '') {
	// 				$objControl = $this->GetControl($strControlId);
	// 				$strNeedValidation = $objControl->Name;
	// 				//error_log($strNeedValidation." (is required) - participant.php");
	// 				//            	QApplication::ExecuteJavaScript(sprintf('$("#dialog" ).html("'.$strNeedValidation.'");', $this));
	// 				//           		QApplication::ExecuteJavaScript(sprintf('$("#dialog" ).dialog({ title: "The following question needs an answer", modal: false });', $this));
	// 				// wpg - had to remove the dialog javascript because it was causing problems in the iPad (javascript alerts work fine)
	// 				QApplication::DisplayAlert($strNeedValidation." (is required)");
	// 				QSessionDB::Delete("_page_ValidateControlID");
	// 			}

	// 			// hide header and disable the page from being edited or clicked
	// 			$blnHideHeader = QApplication::QueryString('hideHeader');
	// 			if ($blnHideHeader) {
	// 				QApplication::ExecuteJavaScript(sprintf('$("#cover").css({"display":"block"});', $this));
	// 			}
	// 		}

	// 		protected function validatePhoneCheck($strFormId, $strControlId, $strParameter){
	// 			$objComponent = $this->GetControl($strControlId);
	// 			// wpg - check if phone number is correct format
	// 			if (!preg_match("/^[0-9]{3}-[0-9]{4}-[0-9]{4}$/", $objControl->Text)) {
	// 				QApplication::DisplayAlert('Invalid phone number. Please use');
	// 				$objControl->strValidationError = "Invalid phone number";
	// 				return false;
	// 			}
	// 		}
?>