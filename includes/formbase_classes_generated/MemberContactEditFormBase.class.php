<?php
	/**
	 * This is the abstract Form class for the Create, Edit, and Delete functionality
	 * of the MemberContact class.  This code-generated class
	 * contains all the basic Qform elements to display an HTML form that can
	 * manipulate a single MemberContact object.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this MemberContactEditFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class MemberContactEditFormBase extends QForm {
		// General Form Variables
		protected $objMemberContact;
		protected $strTitleVerb;
		protected $blnEditMode;

		// Controls for MemberContact's Data Fields
		protected $lblId;
		protected $txtLastName;
		protected $txtFirstName;
		protected $txtEmail;
		protected $txtAddr1;
		protected $txtAddr2;
		protected $txtCity;
		protected $txtState;
		protected $txtZip;
		protected $txtGender;
		protected $txtBirthDay;
		protected $txtBirthMonth;
		protected $txtBirthYear;
		protected $txtMainPhone;
		protected $txtAltPhone;
		protected $txtNote;
		protected $txtTransferId;
		protected $calContactAdded;
		protected $txtGoogleEmail;
		protected $txtFacebookEmail;
		protected $calJoinedClub;
		protected $chkNotActive;
		protected $txtImageReference;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Button Actions
		protected $btnSave;
		protected $btnCancel;
		protected $btnDelete;

		protected function SetupMemberContact() {
			// Lookup Object PK information from Query String (if applicable)
			// Set mode to Edit or New depending on what's found
			$intId = QApplication::QueryString('intId');
			if (($intId)) {
				$this->objMemberContact = MemberContact::Load(($intId));

				if (!$this->objMemberContact)
					throw new Exception('Could not find a MemberContact object with PK arguments: ' . $intId);

				$this->strTitleVerb = QApplication::Translate('Edit');
				$this->blnEditMode = true;
			} else {
				$this->objMemberContact = new MemberContact();
				$this->strTitleVerb = QApplication::Translate('Create');
				$this->blnEditMode = false;
			}
		}

		protected function Form_Create() {
			// Call SetupMemberContact to either Load/Edit Existing or Create New
			$this->SetupMemberContact();

			// Create/Setup Controls for MemberContact's Data Fields
			$this->lblId_Create();
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
			$this->txtNote_Create();
			$this->txtTransferId_Create();
			$this->calContactAdded_Create();
			$this->txtGoogleEmail_Create();
			$this->txtFacebookEmail_Create();
			$this->calJoinedClub_Create();
			$this->chkNotActive_Create();
			$this->txtImageReference_Create();

			// Create/Setup ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

			// Create/Setup Button Action controls
			$this->btnSave_Create();
			$this->btnCancel_Create();
			$this->btnDelete_Create();
		}

		// Protected Create Methods
		// Create and Setup lblId
		protected function lblId_Create() {
			$this->lblId = new QLabel($this);
			$this->lblId->Name = QApplication::Translate('Id');
			if ($this->blnEditMode)
				$this->lblId->Text = $this->objMemberContact?->Id;
			else
				$this->lblId->Text = 'N/A';
		}

		// Create and Setup txtLastName
		protected function txtLastName_Create() {
			$this->txtLastName = new QTextBox($this);
			$this->txtLastName->Name = QApplication::Translate('Last Name');
			$this->txtLastName->Text = $this->objMemberContact?->LastName;
			$this->txtLastName->Required = true;
			$this->txtLastName->MaxLength = MemberContact::LastNameMaxLength;
		}

		// Create and Setup txtFirstName
		protected function txtFirstName_Create() {
			$this->txtFirstName = new QTextBox($this);
			$this->txtFirstName->Name = QApplication::Translate('First Name');
			$this->txtFirstName->Text = $this->objMemberContact?->FirstName;
			$this->txtFirstName->Required = true;
			$this->txtFirstName->MaxLength = MemberContact::FirstNameMaxLength;
		}

		// Create and Setup txtEmail
		protected function txtEmail_Create() {
			$this->txtEmail = new QTextBox($this);
			$this->txtEmail->Name = QApplication::Translate('Email');
			$this->txtEmail->Text = $this->objMemberContact?->Email;
			$this->txtEmail->MaxLength = MemberContact::EmailMaxLength;
		}

		// Create and Setup txtAddr1
		protected function txtAddr1_Create() {
			$this->txtAddr1 = new QTextBox($this);
			$this->txtAddr1->Name = QApplication::Translate('Addr 1');
			$this->txtAddr1->Text = $this->objMemberContact?->Addr1;
			$this->txtAddr1->MaxLength = MemberContact::Addr1MaxLength;
		}

		// Create and Setup txtAddr2
		protected function txtAddr2_Create() {
			$this->txtAddr2 = new QTextBox($this);
			$this->txtAddr2->Name = QApplication::Translate('Addr 2');
			$this->txtAddr2->Text = $this->objMemberContact?->Addr2;
			$this->txtAddr2->MaxLength = MemberContact::Addr2MaxLength;
		}

		// Create and Setup txtCity
		protected function txtCity_Create() {
			$this->txtCity = new QTextBox($this);
			$this->txtCity->Name = QApplication::Translate('City');
			$this->txtCity->Text = $this->objMemberContact?->City;
			$this->txtCity->MaxLength = MemberContact::CityMaxLength;
		}

		// Create and Setup txtState
		protected function txtState_Create() {
			$this->txtState = new QTextBox($this);
			$this->txtState->Name = QApplication::Translate('State');
			$this->txtState->Text = $this->objMemberContact?->State;
			$this->txtState->MaxLength = MemberContact::StateMaxLength;
		}

		// Create and Setup txtZip
		protected function txtZip_Create() {
			$this->txtZip = new QTextBox($this);
			$this->txtZip->Name = QApplication::Translate('Zip');
			$this->txtZip->Text = $this->objMemberContact?->Zip;
			$this->txtZip->MaxLength = MemberContact::ZipMaxLength;
		}

		// Create and Setup txtGender
		protected function txtGender_Create() {
			$this->txtGender = new QTextBox($this);
			$this->txtGender->Name = QApplication::Translate('Gender');
			$this->txtGender->Text = $this->objMemberContact?->Gender;
			$this->txtGender->MaxLength = MemberContact::GenderMaxLength;
		}

		// Create and Setup txtBirthDay
		protected function txtBirthDay_Create() {
			$this->txtBirthDay = new QIntegerTextBox($this);
			$this->txtBirthDay->Name = QApplication::Translate('Birth Day');
			$this->txtBirthDay->Text = $this->objMemberContact?->BirthDay;
		}

		// Create and Setup txtBirthMonth
		protected function txtBirthMonth_Create() {
			$this->txtBirthMonth = new QIntegerTextBox($this);
			$this->txtBirthMonth->Name = QApplication::Translate('Birth Month');
			$this->txtBirthMonth->Text = $this->objMemberContact?->BirthMonth;
		}

		// Create and Setup txtBirthYear
		protected function txtBirthYear_Create() {
			$this->txtBirthYear = new QIntegerTextBox($this);
			$this->txtBirthYear->Name = QApplication::Translate('Birth Year');
			$this->txtBirthYear->Text = $this->objMemberContact?->BirthYear;
		}

		// Create and Setup txtMainPhone
		protected function txtMainPhone_Create() {
			$this->txtMainPhone = new QTextBox($this);
			$this->txtMainPhone->Name = QApplication::Translate('Main Phone');
			$this->txtMainPhone->Text = $this->objMemberContact?->MainPhone;
			$this->txtMainPhone->MaxLength = MemberContact::MainPhoneMaxLength;
		}

		// Create and Setup txtAltPhone
		protected function txtAltPhone_Create() {
			$this->txtAltPhone = new QTextBox($this);
			$this->txtAltPhone->Name = QApplication::Translate('Alt Phone');
			$this->txtAltPhone->Text = $this->objMemberContact?->AltPhone;
			$this->txtAltPhone->MaxLength = MemberContact::AltPhoneMaxLength;
		}

		// Create and Setup txtNote
		protected function txtNote_Create() {
			$this->txtNote = new QTextBox($this);
			$this->txtNote->Name = QApplication::Translate('Note');
			$this->txtNote->Text = $this->objMemberContact?->Note;
			$this->txtNote->MaxLength = MemberContact::NoteMaxLength;
		}

		// Create and Setup txtTransferId
		protected function txtTransferId_Create() {
			$this->txtTransferId = new QIntegerTextBox($this);
			$this->txtTransferId->Name = QApplication::Translate('Transfer Id');
			$this->txtTransferId->Text = $this->objMemberContact?->TransferId;
		}

		// Create and Setup calContactAdded
		protected function calContactAdded_Create() {
			$this->calContactAdded = new QDateTimePicker($this);
			$this->calContactAdded->Name = QApplication::Translate('Contact Added');
			$this->calContactAdded->DateTime = $this->objMemberContact?->ContactAdded;
			$this->calContactAdded->DateTimePickerType = QDateTimePickerType::Date;
		}

		// Create and Setup txtGoogleEmail
		protected function txtGoogleEmail_Create() {
			$this->txtGoogleEmail = new QTextBox($this);
			$this->txtGoogleEmail->Name = QApplication::Translate('Google Email');
			$this->txtGoogleEmail->Text = $this->objMemberContact?->GoogleEmail;
			$this->txtGoogleEmail->MaxLength = MemberContact::GoogleEmailMaxLength;
		}

		// Create and Setup txtFacebookEmail
		protected function txtFacebookEmail_Create() {
			$this->txtFacebookEmail = new QTextBox($this);
			$this->txtFacebookEmail->Name = QApplication::Translate('Facebook Email');
			$this->txtFacebookEmail->Text = $this->objMemberContact?->FacebookEmail;
			$this->txtFacebookEmail->MaxLength = MemberContact::FacebookEmailMaxLength;
		}

		// Create and Setup calJoinedClub
		protected function calJoinedClub_Create() {
			$this->calJoinedClub = new QDateTimePicker($this);
			$this->calJoinedClub->Name = QApplication::Translate('Joined Club');
			$this->calJoinedClub->DateTime = $this->objMemberContact?->JoinedClub;
			$this->calJoinedClub->DateTimePickerType = QDateTimePickerType::Date;
		}

		// Create and Setup chkNotActive
		protected function chkNotActive_Create() {
			$this->chkNotActive = new QCheckBox($this);
			$this->chkNotActive->Name = QApplication::Translate('Not Active');
			$this->chkNotActive->Checked = $this->objMemberContact?->NotActive;
		}

		// Create and Setup txtImageReference
		protected function txtImageReference_Create() {
			$this->txtImageReference = new QTextBox($this);
			$this->txtImageReference->Name = QApplication::Translate('Image Reference');
			$this->txtImageReference->Text = $this->objMemberContact?->ImageReference;
			$this->txtImageReference->Required = true;
			$this->txtImageReference->MaxLength = MemberContact::ImageReferenceMaxLength;
		}


		// Setup btnSave
		protected function btnSave_Create() {
			$this->btnSave = new QButton($this);
			$this->btnSave->Text = QApplication::Translate('Save');
			$this->btnSave->AddAction(new QClickEvent(), new QServerAction('btnSave_Click'));
			$this->btnSave->PrimaryButton = true;
			$this->btnSave->CausesValidation = true;
		}

		// Setup btnCancel
		protected function btnCancel_Create() {
			$this->btnCancel = new QButton($this);
			$this->btnCancel->Text = QApplication::Translate('Cancel');
			$this->btnCancel->AddAction(new QClickEvent(), new QServerAction('btnCancel_Click'));
			$this->btnCancel->CausesValidation = false;
		}

		// Setup btnDelete
		protected function btnDelete_Create() {
			$this->btnDelete = new QButton($this);
			$this->btnDelete->Text = QApplication::Translate('Delete');
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(sprintf(QApplication::Translate('Are you SURE you want to DELETE this %s?'), 'MemberContact')));
			$this->btnDelete->AddAction(new QClickEvent(), new QServerAction('btnDelete_Click'));
			$this->btnDelete->CausesValidation = false;
			if (!$this->blnEditMode)
				$this->btnDelete->Visible = false;
		}
		
		// Protected Update Methods
		protected function UpdateMemberContactFields() {
			$this->objMemberContact->LastName = $this->txtLastName->Text;
			$this->objMemberContact->FirstName = $this->txtFirstName->Text;
			$this->objMemberContact->Email = $this->txtEmail->Text;
			$this->objMemberContact->Addr1 = $this->txtAddr1->Text;
			$this->objMemberContact->Addr2 = $this->txtAddr2->Text;
			$this->objMemberContact->City = $this->txtCity->Text;
			$this->objMemberContact->State = $this->txtState->Text;
			$this->objMemberContact->Zip = $this->txtZip->Text;
			$this->objMemberContact->Gender = $this->txtGender->Text;
			$this->objMemberContact->BirthDay = $this->txtBirthDay->Text;
			$this->objMemberContact->BirthMonth = $this->txtBirthMonth->Text;
			$this->objMemberContact->BirthYear = $this->txtBirthYear->Text;
			$this->objMemberContact->MainPhone = $this->txtMainPhone->Text;
			$this->objMemberContact->AltPhone = $this->txtAltPhone->Text;
			$this->objMemberContact->Note = $this->txtNote->Text;
			$this->objMemberContact->TransferId = $this->txtTransferId->Text;
			$this->objMemberContact->ContactAdded = $this->calContactAdded->DateTime;
			$this->objMemberContact->GoogleEmail = $this->txtGoogleEmail->Text;
			$this->objMemberContact->FacebookEmail = $this->txtFacebookEmail->Text;
			$this->objMemberContact->JoinedClub = $this->calJoinedClub->DateTime;
			$this->objMemberContact->NotActive = $this->chkNotActive->Checked;
			$this->objMemberContact->ImageReference = $this->txtImageReference->Text;
		}


		// Control ServerActions
		protected function btnSave_Click($strFormId, $strControlId, $strParameter) {
			$this->UpdateMemberContactFields();
			$this->objMemberContact->Save();


			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {

			$this->objMemberContact->Delete();

			$this->RedirectToListPage();
		}
		
		protected function RedirectToListPage() {
			QApplication::Redirect('member_contact_list.php');
		}
	}
?>