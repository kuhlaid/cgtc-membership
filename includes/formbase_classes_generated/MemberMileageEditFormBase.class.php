<?php
	/**
	 * This is the abstract Form class for the Create, Edit, and Delete functionality
	 * of the MemberMileage class.  This code-generated class
	 * contains all the basic Qform elements to display an HTML form that can
	 * manipulate a single MemberMileage object.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this MemberMileageEditFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class MemberMileageEditFormBase extends QForm {
		// General Form Variables
		protected $objMemberMileage;
		protected $strTitleVerb;
		protected $blnEditMode;

		// Controls for MemberMileage's Data Fields
		protected $txtId;
		protected $lstMemberIdObject;
		protected $txtMiles;
		protected $calLoggedOn;
		protected $txtNotes;
		protected $txtYear;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Button Actions
		protected $btnSave;
		protected $btnCancel;
		protected $btnDelete;

		protected function SetupMemberMileage() {
			// Lookup Object PK information from Query String (if applicable)
			// Set mode to Edit or New depending on what's found
			$intId = QApplication::QueryString('intId');
			if (($intId)) {
				$this->objMemberMileage = MemberMileage::Load(($intId));

				if (!$this->objMemberMileage)
					throw new Exception('Could not find a MemberMileage object with PK arguments: ' . $intId);

				$this->strTitleVerb = QApplication::Translate('Edit');
				$this->blnEditMode = true;
			} else {
				$this->objMemberMileage = new MemberMileage();
				$this->strTitleVerb = QApplication::Translate('Create');
				$this->blnEditMode = false;
			}
		}

		protected function Form_Create() {
			// Call SetupMemberMileage to either Load/Edit Existing or Create New
			$this->SetupMemberMileage();

			// Create/Setup Controls for MemberMileage's Data Fields
			$this->txtId_Create();
			$this->lstMemberIdObject_Create();
			$this->txtMiles_Create();
			$this->calLoggedOn_Create();
			$this->txtNotes_Create();
			$this->txtYear_Create();

			// Create/Setup ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

			// Create/Setup Button Action controls
			$this->btnSave_Create();
			$this->btnCancel_Create();
			$this->btnDelete_Create();
		}

		// Protected Create Methods
		// Create and Setup txtId
		protected function txtId_Create() {
			$this->txtId = new QIntegerTextBox($this);
			$this->txtId->Name = QApplication::Translate('Id');
			$this->txtId->Text = $this->objMemberMileage->Id;
			$this->txtId->Required = true;
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
				if (($this->objMemberMileage->MemberIdObject) && ($this->objMemberMileage->MemberIdObject->Id == $objMemberIdObject->Id))
					$objListItem->Selected = true;
				$this->lstMemberIdObject->AddItem($objListItem);
			}
		}

		// Create and Setup txtMiles
		protected function txtMiles_Create() {
			$this->txtMiles = new QFloatTextBox($this);
			$this->txtMiles->Name = QApplication::Translate('Miles');
			$this->txtMiles->Text = $this->objMemberMileage->Miles;
			$this->txtMiles->Required = true;
		}

		// Create and Setup calLoggedOn
		protected function calLoggedOn_Create() {
			$this->calLoggedOn = new QDateTimePicker($this);
			$this->calLoggedOn->Name = QApplication::Translate('Logged On');
			$this->calLoggedOn->DateTime = $this->objMemberMileage->LoggedOn;
			$this->calLoggedOn->DateTimePickerType = QDateTimePickerType::Date;
			$this->calLoggedOn->Required = true;
		}

		// Create and Setup txtNotes
		protected function txtNotes_Create() {
			$this->txtNotes = new QTextBox($this);
			$this->txtNotes->Name = QApplication::Translate('Notes');
			$this->txtNotes->Text = $this->objMemberMileage->Notes;
			$this->txtNotes->MaxLength = MemberMileage::NotesMaxLength;
		}

		// Create and Setup txtYear
		protected function txtYear_Create() {
			$this->txtYear = new QIntegerTextBox($this);
			$this->txtYear->Name = QApplication::Translate('Year');
			$this->txtYear->Text = $this->objMemberMileage->Year;
			$this->txtYear->Required = true;
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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(sprintf(QApplication::Translate('Are you SURE you want to DELETE this %s?'), 'MemberMileage')));
			$this->btnDelete->AddAction(new QClickEvent(), new QServerAction('btnDelete_Click'));
			$this->btnDelete->CausesValidation = false;
			if (!$this->blnEditMode)
				$this->btnDelete->Visible = false;
		}
		
		// Protected Update Methods
		protected function UpdateMemberMileageFields() {
			$this->objMemberMileage->Id = $this->txtId->Text;
			$this->objMemberMileage->MemberId = $this->lstMemberIdObject->SelectedValue;
			$this->objMemberMileage->Miles = $this->txtMiles->Text;
			$this->objMemberMileage->LoggedOn = $this->calLoggedOn->DateTime;
			$this->objMemberMileage->Notes = $this->txtNotes->Text;
			$this->objMemberMileage->Year = $this->txtYear->Text;
		}


		// Control ServerActions
		protected function btnSave_Click($strFormId, $strControlId, $strParameter) {
			$this->UpdateMemberMileageFields();
			$this->objMemberMileage->Save();


			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {

			$this->objMemberMileage->Delete();

			$this->RedirectToListPage();
		}
		
		protected function RedirectToListPage() {
			QApplication::Redirect('member_mileage_list.php');
		}
	}
?>