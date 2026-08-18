<?php
	/**
	 * This is the abstract Form class for the Create, Edit, and Delete functionality
	 * of the MemberAccessLog class.  This code-generated class
	 * contains all the basic Qform elements to display an HTML form that can
	 * manipulate a single MemberAccessLog object.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this MemberAccessLogEditFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class MemberAccessLogEditFormBase extends QForm {
		// General Form Variables
		protected $objMemberAccessLog;
		protected $strTitleVerb;
		protected $blnEditMode;

		// Controls for MemberAccessLog's Data Fields
		protected $lblId;
		protected $lstMemberIdObject;
		protected $calTimeOfLogin;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Button Actions
		protected $btnSave;
		protected $btnCancel;
		protected $btnDelete;

		protected function SetupMemberAccessLog() {
			// Lookup Object PK information from Query String (if applicable)
			// Set mode to Edit or New depending on what's found
			$intId = QApplication::QueryString('intId');
			if (($intId)) {
				$this->objMemberAccessLog = MemberAccessLog::Load(($intId));

				if (!$this->objMemberAccessLog)
					throw new Exception('Could not find a MemberAccessLog object with PK arguments: ' . $intId);

				$this->strTitleVerb = QApplication::Translate('Edit');
				$this->blnEditMode = true;
			} else {
				$this->objMemberAccessLog = new MemberAccessLog();
				$this->strTitleVerb = QApplication::Translate('Create');
				$this->blnEditMode = false;
			}
		}

		protected function Form_Create() {
			// Call SetupMemberAccessLog to either Load/Edit Existing or Create New
			$this->SetupMemberAccessLog();

			// Create/Setup Controls for MemberAccessLog's Data Fields
			$this->lblId_Create();
			$this->lstMemberIdObject_Create();
			$this->calTimeOfLogin_Create();

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
				$this->lblId->Text = $this->objMemberAccessLog->Id;
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
				if (($this->objMemberAccessLog->MemberIdObject) && ($this->objMemberAccessLog->MemberIdObject->Id == $objMemberIdObject->Id))
					$objListItem->Selected = true;
				$this->lstMemberIdObject->AddItem($objListItem);
			}
		}

		// Create and Setup calTimeOfLogin
		protected function calTimeOfLogin_Create() {
			$this->calTimeOfLogin = new QDateTimePicker($this);
			$this->calTimeOfLogin->Name = QApplication::Translate('Time Of Login');
			$this->calTimeOfLogin->DateTime = $this->objMemberAccessLog->TimeOfLogin;
			$this->calTimeOfLogin->DateTimePickerType = QDateTimePickerType::DateTime;
			$this->calTimeOfLogin->Required = true;
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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(sprintf(QApplication::Translate('Are you SURE you want to DELETE this %s?'), 'MemberAccessLog')));
			$this->btnDelete->AddAction(new QClickEvent(), new QServerAction('btnDelete_Click'));
			$this->btnDelete->CausesValidation = false;
			if (!$this->blnEditMode)
				$this->btnDelete->Visible = false;
		}
		
		// Protected Update Methods
		protected function UpdateMemberAccessLogFields() {
			$this->objMemberAccessLog->MemberId = $this->lstMemberIdObject->SelectedValue;
			$this->objMemberAccessLog->TimeOfLogin = $this->calTimeOfLogin->DateTime;
		}


		// Control ServerActions
		protected function btnSave_Click($strFormId, $strControlId, $strParameter) {
			$this->UpdateMemberAccessLogFields();
			$this->objMemberAccessLog->Save();


			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {

			$this->objMemberAccessLog->Delete();

			$this->RedirectToListPage();
		}
		
		protected function RedirectToListPage() {
			QApplication::Redirect('member_access_log_list.php');
		}
	}
?>