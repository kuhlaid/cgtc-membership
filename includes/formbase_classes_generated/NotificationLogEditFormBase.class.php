<?php
	/**
	 * This is the abstract Form class for the Create, Edit, and Delete functionality
	 * of the NotificationLog class.  This code-generated class
	 * contains all the basic Qform elements to display an HTML form that can
	 * manipulate a single NotificationLog object.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this NotificationLogEditFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class NotificationLogEditFormBase extends QForm {
		// General Form Variables
		protected $objNotificationLog;
		protected $strTitleVerb;
		protected $blnEditMode;

		// Controls for NotificationLog's Data Fields
		protected $lblId;
		protected $lstMemberIdObject;
		protected $txtNotificationType;
		protected $calNotificationDate;
		protected $txtNotificationSubject;
		protected $txtNotificationBody;
		protected $lstMembershipLogIdObject;
		protected $chkNotificationConfirmed;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Button Actions
		protected $btnSave;
		protected $btnCancel;
		protected $btnDelete;

		protected function SetupNotificationLog() {
			// Lookup Object PK information from Query String (if applicable)
			// Set mode to Edit or New depending on what's found
			$intId = QApplication::QueryString('intId');
			if (($intId)) {
				$this->objNotificationLog = NotificationLog::Load(($intId));

				if (!$this->objNotificationLog)
					throw new Exception('Could not find a NotificationLog object with PK arguments: ' . $intId);

				$this->strTitleVerb = QApplication::Translate('Edit');
				$this->blnEditMode = true;
			} else {
				$this->objNotificationLog = new NotificationLog();
				$this->strTitleVerb = QApplication::Translate('Create');
				$this->blnEditMode = false;
			}
		}

		protected function Form_Create() {
			// Call SetupNotificationLog to either Load/Edit Existing or Create New
			$this->SetupNotificationLog();

			// Create/Setup Controls for NotificationLog's Data Fields
			$this->lblId_Create();
			$this->lstMemberIdObject_Create();
			$this->txtNotificationType_Create();
			$this->calNotificationDate_Create();
			$this->txtNotificationSubject_Create();
			$this->txtNotificationBody_Create();
			$this->lstMembershipLogIdObject_Create();
			$this->chkNotificationConfirmed_Create();

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
				$this->lblId->Text = $this->objNotificationLog->Id;
			else
				$this->lblId->Text = 'N/A';
		}

		// Create and Setup lstMemberIdObject
		protected function lstMemberIdObject_Create() {
			$this->lstMemberIdObject = new QListBox($this);
			$this->lstMemberIdObject->Name = QApplication::Translate('Member Id Object');
			$this->lstMemberIdObject->Required = true;
			if (!$this->blnEditMode)
				$this->lstMemberIdObject->AddItem(QApplication::Translate('- Select One -'), null);
			$objMemberIdObjectArray = MemberContact::LoadAll();
			if ($objMemberIdObjectArray) foreach ($objMemberIdObjectArray as $objMemberIdObject) {
				$objListItem = new QListItem($objMemberIdObject->__toString(), $objMemberIdObject->Id);
				if (($this->objNotificationLog->MemberIdObject) && ($this->objNotificationLog->MemberIdObject->Id == $objMemberIdObject->Id))
					$objListItem->Selected = true;
				$this->lstMemberIdObject->AddItem($objListItem);
			}
		}

		// Create and Setup txtNotificationType
		protected function txtNotificationType_Create() {
			$this->txtNotificationType = new QIntegerTextBox($this);
			$this->txtNotificationType->Name = QApplication::Translate('Notification Type');
			$this->txtNotificationType->Text = $this->objNotificationLog->NotificationType;
			$this->txtNotificationType->Required = true;
		}

		// Create and Setup calNotificationDate
		protected function calNotificationDate_Create() {
			$this->calNotificationDate = new QDateTimePicker($this);
			$this->calNotificationDate->Name = QApplication::Translate('Notification Date');
			$this->calNotificationDate->DateTime = $this->objNotificationLog->NotificationDate;
			$this->calNotificationDate->DateTimePickerType = QDateTimePickerType::DateTime;
		}

		// Create and Setup txtNotificationSubject
		protected function txtNotificationSubject_Create() {
			$this->txtNotificationSubject = new QTextBox($this);
			$this->txtNotificationSubject->Name = QApplication::Translate('Notification Subject');
			$this->txtNotificationSubject->Text = $this->objNotificationLog->NotificationSubject;
			$this->txtNotificationSubject->MaxLength = NotificationLog::NotificationSubjectMaxLength;
		}

		// Create and Setup txtNotificationBody
		protected function txtNotificationBody_Create() {
			$this->txtNotificationBody = new QTextBox($this);
			$this->txtNotificationBody->Name = QApplication::Translate('Notification Body');
			$this->txtNotificationBody->Text = $this->objNotificationLog->NotificationBody;
			$this->txtNotificationBody->TextMode = QTextMode::MultiLine;
		}

		// Create and Setup lstMembershipLogIdObject
		protected function lstMembershipLogIdObject_Create() {
			$this->lstMembershipLogIdObject = new QListBox($this);
			$this->lstMembershipLogIdObject->Name = QApplication::Translate('Membership Log Id Object');
			$this->lstMembershipLogIdObject->AddItem(QApplication::Translate('- Select One -'), null);
			$objMembershipLogIdObjectArray = MembershipLog::LoadAll();
			if ($objMembershipLogIdObjectArray) foreach ($objMembershipLogIdObjectArray as $objMembershipLogIdObject) {
				$objListItem = new QListItem($objMembershipLogIdObject->__toString(), $objMembershipLogIdObject->Id);
				if (($this->objNotificationLog->MembershipLogIdObject) && ($this->objNotificationLog->MembershipLogIdObject->Id == $objMembershipLogIdObject->Id))
					$objListItem->Selected = true;
				$this->lstMembershipLogIdObject->AddItem($objListItem);
			}
		}

		// Create and Setup chkNotificationConfirmed
		protected function chkNotificationConfirmed_Create() {
			$this->chkNotificationConfirmed = new QCheckBox($this);
			$this->chkNotificationConfirmed->Name = QApplication::Translate('Notification Confirmed');
			$this->chkNotificationConfirmed->Checked = $this->objNotificationLog->NotificationConfirmed;
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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(sprintf(QApplication::Translate('Are you SURE you want to DELETE this %s?'), 'NotificationLog')));
			$this->btnDelete->AddAction(new QClickEvent(), new QServerAction('btnDelete_Click'));
			$this->btnDelete->CausesValidation = false;
			if (!$this->blnEditMode)
				$this->btnDelete->Visible = false;
		}
		
		// Protected Update Methods
		protected function UpdateNotificationLogFields() {
			$this->objNotificationLog->MemberId = $this->lstMemberIdObject->SelectedValue;
			$this->objNotificationLog->NotificationType = $this->txtNotificationType->Text;
			$this->objNotificationLog->NotificationDate = $this->calNotificationDate->DateTime;
			$this->objNotificationLog->NotificationSubject = $this->txtNotificationSubject->Text;
			$this->objNotificationLog->NotificationBody = $this->txtNotificationBody->Text;
			$this->objNotificationLog->MembershipLogId = $this->lstMembershipLogIdObject->SelectedValue;
			$this->objNotificationLog->NotificationConfirmed = $this->chkNotificationConfirmed->Checked;
		}


		// Control ServerActions
		protected function btnSave_Click($strFormId, $strControlId, $strParameter) {
			$this->UpdateNotificationLogFields();
			$this->objNotificationLog->Save();


			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {

			$this->objNotificationLog->Delete();

			$this->RedirectToListPage();
		}
		
		protected function RedirectToListPage() {
			QApplication::Redirect('notification_log_list.php');
		}
	}
?>