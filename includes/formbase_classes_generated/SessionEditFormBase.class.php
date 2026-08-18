<?php
	/**
	 * This is the abstract Form class for the Create, Edit, and Delete functionality
	 * of the Session class.  This code-generated class
	 * contains all the basic Qform elements to display an HTML form that can
	 * manipulate a single Session object.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this SessionEditFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class SessionEditFormBase extends QForm {
		// General Form Variables
		protected $objSession;
		protected $strTitleVerb;
		protected $blnEditMode;

		// Controls for Session's Data Fields
		protected $txtId;
		protected $txtSessionData;
		protected $calLastAccess;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Button Actions
		protected $btnSave;
		protected $btnCancel;
		protected $btnDelete;

		protected function SetupSession() {
			// Lookup Object PK information from Query String (if applicable)
			// Set mode to Edit or New depending on what's found
			$strId = QApplication::QueryString('strId');
			if (($strId)) {
				$this->objSession = Session::Load(($strId));

				if (!$this->objSession)
					throw new Exception('Could not find a Session object with PK arguments: ' . $strId);

				$this->strTitleVerb = QApplication::Translate('Edit');
				$this->blnEditMode = true;
			} else {
				$this->objSession = new Session();
				$this->strTitleVerb = QApplication::Translate('Create');
				$this->blnEditMode = false;
			}
		}

		protected function Form_Create() {
			// Call SetupSession to either Load/Edit Existing or Create New
			$this->SetupSession();

			// Create/Setup Controls for Session's Data Fields
			$this->txtId_Create();
			$this->txtSessionData_Create();
			$this->calLastAccess_Create();

			// Create/Setup ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

			// Create/Setup Button Action controls
			$this->btnSave_Create();
			$this->btnCancel_Create();
			$this->btnDelete_Create();
		}

		// Protected Create Methods
		// Create and Setup txtId
		protected function txtId_Create() {
			$this->txtId = new QTextBox($this);
			$this->txtId->Name = QApplication::Translate('Id');
			$this->txtId->Text = $this->objSession->Id;
			$this->txtId->Required = true;
			$this->txtId->MaxLength = Session::IdMaxLength;
		}

		// Create and Setup txtSessionData
		protected function txtSessionData_Create() {
			$this->txtSessionData = new QTextBox($this);
			$this->txtSessionData->Name = QApplication::Translate('Session Data');
			$this->txtSessionData->Text = $this->objSession->SessionData;
			$this->txtSessionData->Required = true;
			$this->txtSessionData->TextMode = QTextMode::MultiLine;
		}

		// Create and Setup calLastAccess
		protected function calLastAccess_Create() {
			$this->calLastAccess = new QDateTimePicker($this);
			$this->calLastAccess->Name = QApplication::Translate('Last Access');
			$this->calLastAccess->DateTime = $this->objSession->LastAccess;
			$this->calLastAccess->DateTimePickerType = QDateTimePickerType::DateTime;
			$this->calLastAccess->Required = true;
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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(sprintf(QApplication::Translate('Are you SURE you want to DELETE this %s?'), 'Session')));
			$this->btnDelete->AddAction(new QClickEvent(), new QServerAction('btnDelete_Click'));
			$this->btnDelete->CausesValidation = false;
			if (!$this->blnEditMode)
				$this->btnDelete->Visible = false;
		}
		
		// Protected Update Methods
		protected function UpdateSessionFields() {
			$this->objSession->Id = $this->txtId->Text;
			$this->objSession->SessionData = $this->txtSessionData->Text;
			$this->objSession->LastAccess = $this->calLastAccess->DateTime;
		}


		// Control ServerActions
		protected function btnSave_Click($strFormId, $strControlId, $strParameter) {
			$this->UpdateSessionFields();
			$this->objSession->Save();


			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {

			$this->objSession->Delete();

			$this->RedirectToListPage();
		}
		
		protected function RedirectToListPage() {
			QApplication::Redirect('session_list.php');
		}
	}
?>