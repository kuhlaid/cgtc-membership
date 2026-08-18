<?php
	/**
	 * This is the abstract Form class for the Create, Edit, and Delete functionality
	 * of the MembershipLog class.  This code-generated class
	 * contains all the basic Qform elements to display an HTML form that can
	 * manipulate a single MembershipLog object.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this MembershipLogEditFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class MembershipLogEditFormBase extends QForm {
		// General Form Variables
		protected $objMembershipLog;
		protected $strTitleVerb;
		protected $blnEditMode;

		// Controls for MembershipLog's Data Fields
		protected $lblId;
		protected $txtLogType;
		protected $calStartDate;
		protected $calExpireDate;
		protected $txtPaymentType;
		protected $txtPaymentAmount;
		protected $calPaidOn;
		protected $txtNote;
		protected $lstMemberIdObject;
		protected $txtTransferId;
		protected $calLogDate;
		protected $chkNewMembership;
		protected $txtMedTrainingType;
		protected $chkWillingMedVolunteer;
		protected $txtPayPalTransactionId;
		protected $calMembershipConsent;
		protected $txtConsentSignature;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Button Actions
		protected $btnSave;
		protected $btnCancel;
		protected $btnDelete;

		protected function SetupMembershipLog() {
			// Lookup Object PK information from Query String (if applicable)
			// Set mode to Edit or New depending on what's found
			$intId = QApplication::QueryString('intId');
			if (($intId)) {
				$this->objMembershipLog = MembershipLog::Load(($intId));

				if (!$this->objMembershipLog)
					throw new Exception('Could not find a MembershipLog object with PK arguments: ' . $intId);

				$this->strTitleVerb = QApplication::Translate('Edit');
				$this->blnEditMode = true;
			} else {
				$this->objMembershipLog = new MembershipLog();
				$this->strTitleVerb = QApplication::Translate('Create');
				$this->blnEditMode = false;
			}
		}

		protected function Form_Create() {
			// Call SetupMembershipLog to either Load/Edit Existing or Create New
			$this->SetupMembershipLog();

			// Create/Setup Controls for MembershipLog's Data Fields
			$this->lblId_Create();
			$this->txtLogType_Create();
			$this->calStartDate_Create();
			$this->calExpireDate_Create();
			$this->txtPaymentType_Create();
			$this->txtPaymentAmount_Create();
			$this->calPaidOn_Create();
			$this->txtNote_Create();
			$this->lstMemberIdObject_Create();
			$this->txtTransferId_Create();
			$this->calLogDate_Create();
			$this->chkNewMembership_Create();
			$this->txtMedTrainingType_Create();
			$this->chkWillingMedVolunteer_Create();
			$this->txtPayPalTransactionId_Create();
			$this->calMembershipConsent_Create();
			$this->txtConsentSignature_Create();

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
				$this->lblId->Text = $this->objMembershipLog->Id;
			else
				$this->lblId->Text = 'N/A';
		}

		// Create and Setup txtLogType
		protected function txtLogType_Create() {
			$this->txtLogType = new QIntegerTextBox($this);
			$this->txtLogType->Name = QApplication::Translate('Log Type');
			$this->txtLogType->Text = $this->objMembershipLog->LogType;
		}

		// Create and Setup calStartDate
		protected function calStartDate_Create() {
			$this->calStartDate = new QDateTimePicker($this);
			$this->calStartDate->Name = QApplication::Translate('Start Date');
			$this->calStartDate->DateTime = $this->objMembershipLog->StartDate;
			$this->calStartDate->DateTimePickerType = QDateTimePickerType::Date;
		}

		// Create and Setup calExpireDate
		protected function calExpireDate_Create() {
			$this->calExpireDate = new QDateTimePicker($this);
			$this->calExpireDate->Name = QApplication::Translate('Expire Date');
			$this->calExpireDate->DateTime = $this->objMembershipLog->ExpireDate;
			$this->calExpireDate->DateTimePickerType = QDateTimePickerType::Date;
		}

		// Create and Setup txtPaymentType
		protected function txtPaymentType_Create() {
			$this->txtPaymentType = new QIntegerTextBox($this);
			$this->txtPaymentType->Name = QApplication::Translate('Payment Type');
			$this->txtPaymentType->Text = $this->objMembershipLog->PaymentType;
		}

		// Create and Setup txtPaymentAmount
		protected function txtPaymentAmount_Create() {
			$this->txtPaymentAmount = new QFloatTextBox($this);
			$this->txtPaymentAmount->Name = QApplication::Translate('Payment Amount');
			$this->txtPaymentAmount->Text = $this->objMembershipLog->PaymentAmount;
		}

		// Create and Setup calPaidOn
		protected function calPaidOn_Create() {
			$this->calPaidOn = new QDateTimePicker($this);
			$this->calPaidOn->Name = QApplication::Translate('Paid On');
			$this->calPaidOn->DateTime = $this->objMembershipLog->PaidOn;
			$this->calPaidOn->DateTimePickerType = QDateTimePickerType::Date;
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
			$this->lstMemberIdObject = new QListBox($this);
			$this->lstMemberIdObject->Name = QApplication::Translate('Member Id Object');
			$this->lstMemberIdObject->AddItem(QApplication::Translate('- Select One -'), null);
			$objMemberIdObjectArray = MemberContact::LoadAll();
			if ($objMemberIdObjectArray) foreach ($objMemberIdObjectArray as $objMemberIdObject) {
				$objListItem = new QListItem($objMemberIdObject->__toString(), $objMemberIdObject->Id);
				if (($this->objMembershipLog->MemberIdObject) && ($this->objMembershipLog->MemberIdObject->Id == $objMemberIdObject->Id))
					$objListItem->Selected = true;
				$this->lstMemberIdObject->AddItem($objListItem);
			}
		}

		// Create and Setup txtTransferId
		protected function txtTransferId_Create() {
			$this->txtTransferId = new QIntegerTextBox($this);
			$this->txtTransferId->Name = QApplication::Translate('Transfer Id');
			$this->txtTransferId->Text = $this->objMembershipLog->TransferId;
		}

		// Create and Setup calLogDate
		protected function calLogDate_Create() {
			$this->calLogDate = new QDateTimePicker($this);
			$this->calLogDate->Name = QApplication::Translate('Log Date');
			$this->calLogDate->DateTime = $this->objMembershipLog->LogDate;
			$this->calLogDate->DateTimePickerType = QDateTimePickerType::Date;
		}

		// Create and Setup chkNewMembership
		protected function chkNewMembership_Create() {
			$this->chkNewMembership = new QCheckBox($this);
			$this->chkNewMembership->Name = QApplication::Translate('New Membership');
			$this->chkNewMembership->Checked = $this->objMembershipLog->NewMembership;
		}

		// Create and Setup txtMedTrainingType
		protected function txtMedTrainingType_Create() {
			$this->txtMedTrainingType = new QIntegerTextBox($this);
			$this->txtMedTrainingType->Name = QApplication::Translate('Med Training Type');
			$this->txtMedTrainingType->Text = $this->objMembershipLog->MedTrainingType;
		}

		// Create and Setup chkWillingMedVolunteer
		protected function chkWillingMedVolunteer_Create() {
			$this->chkWillingMedVolunteer = new QCheckBox($this);
			$this->chkWillingMedVolunteer->Name = QApplication::Translate('Willing Med Volunteer');
			$this->chkWillingMedVolunteer->Checked = $this->objMembershipLog->WillingMedVolunteer;
		}

		// Create and Setup txtPayPalTransactionId
		protected function txtPayPalTransactionId_Create() {
			$this->txtPayPalTransactionId = new QTextBox($this);
			$this->txtPayPalTransactionId->Name = QApplication::Translate('Pay Pal Transaction Id');
			$this->txtPayPalTransactionId->Text = $this->objMembershipLog->PayPalTransactionId;
			$this->txtPayPalTransactionId->MaxLength = MembershipLog::PayPalTransactionIdMaxLength;
		}

		// Create and Setup calMembershipConsent
		protected function calMembershipConsent_Create() {
			$this->calMembershipConsent = new QDateTimePicker($this);
			$this->calMembershipConsent->Name = QApplication::Translate('Membership Consent');
			$this->calMembershipConsent->DateTime = $this->objMembershipLog->MembershipConsent;
			$this->calMembershipConsent->DateTimePickerType = QDateTimePickerType::DateTime;
			$this->calMembershipConsent->Required = true;
		}

		// Create and Setup txtConsentSignature
		protected function txtConsentSignature_Create() {
			$this->txtConsentSignature = new QTextBox($this);
			$this->txtConsentSignature->Name = QApplication::Translate('Consent Signature');
			$this->txtConsentSignature->Text = $this->objMembershipLog->ConsentSignature;
			$this->txtConsentSignature->Required = true;
			$this->txtConsentSignature->MaxLength = MembershipLog::ConsentSignatureMaxLength;
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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(sprintf(QApplication::Translate('Are you SURE you want to DELETE this %s?'), 'MembershipLog')));
			$this->btnDelete->AddAction(new QClickEvent(), new QServerAction('btnDelete_Click'));
			$this->btnDelete->CausesValidation = false;
			if (!$this->blnEditMode)
				$this->btnDelete->Visible = false;
		}
		
		// Protected Update Methods
		protected function UpdateMembershipLogFields() {
			$this->objMembershipLog->LogType = $this->txtLogType->Text;
			$this->objMembershipLog->StartDate = $this->calStartDate->DateTime;
			$this->objMembershipLog->ExpireDate = $this->calExpireDate->DateTime;
			$this->objMembershipLog->PaymentType = $this->txtPaymentType->Text;
			$this->objMembershipLog->PaymentAmount = $this->txtPaymentAmount->Text;
			$this->objMembershipLog->PaidOn = $this->calPaidOn->DateTime;
			$this->objMembershipLog->Note = $this->txtNote->Text;
			$this->objMembershipLog->MemberId = $this->lstMemberIdObject->SelectedValue;
			$this->objMembershipLog->TransferId = $this->txtTransferId->Text;
			$this->objMembershipLog->LogDate = $this->calLogDate->DateTime;
			$this->objMembershipLog->NewMembership = $this->chkNewMembership->Checked;
			$this->objMembershipLog->MedTrainingType = $this->txtMedTrainingType->Text;
			$this->objMembershipLog->WillingMedVolunteer = $this->chkWillingMedVolunteer->Checked;
			$this->objMembershipLog->PayPalTransactionId = $this->txtPayPalTransactionId->Text;
			$this->objMembershipLog->MembershipConsent = $this->calMembershipConsent->DateTime;
			$this->objMembershipLog->ConsentSignature = $this->txtConsentSignature->Text;
		}


		// Control ServerActions
		protected function btnSave_Click($strFormId, $strControlId, $strParameter) {
			$this->UpdateMembershipLogFields();
			$this->objMembershipLog->Save();


			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {

			$this->objMembershipLog->Delete();

			$this->RedirectToListPage();
		}
		
		protected function RedirectToListPage() {
			QApplication::Redirect('membership_log_list.php');
		}
	}
?>