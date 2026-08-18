<?php
	/**
	 * This is the abstract Form class for the Create, Edit, and Delete functionality
	 * of the Race class.  This code-generated class
	 * contains all the basic Qform elements to display an HTML form that can
	 * manipulate a single Race object.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this RaceEditFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class RaceEditFormBase extends QForm {
		// General Form Variables
		protected $objRace;
		protected $strTitleVerb;
		protected $blnEditMode;

		// Controls for Race's Data Fields
		protected $lblId;
		protected $txtName;
		protected $txtDistance;
		protected $txtDistanceUnit;
		protected $txtWebsite;
		protected $txtRaceLocation;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Button Actions
		protected $btnSave;
		protected $btnCancel;
		protected $btnDelete;

		protected function SetupRace() {
			// Lookup Object PK information from Query String (if applicable)
			// Set mode to Edit or New depending on what's found
			$intId = QApplication::QueryString('intId');
			if (($intId)) {
				$this->objRace = Race::Load(($intId));

				if (!$this->objRace)
					throw new Exception('Could not find a Race object with PK arguments: ' . $intId);

				$this->strTitleVerb = QApplication::Translate('Edit');
				$this->blnEditMode = true;
			} else {
				$this->objRace = new Race();
				$this->strTitleVerb = QApplication::Translate('Create');
				$this->blnEditMode = false;
			}
		}

		protected function Form_Create() {
			// Call SetupRace to either Load/Edit Existing or Create New
			$this->SetupRace();

			// Create/Setup Controls for Race's Data Fields
			$this->lblId_Create();
			$this->txtName_Create();
			$this->txtDistance_Create();
			$this->txtDistanceUnit_Create();
			$this->txtWebsite_Create();
			$this->txtRaceLocation_Create();

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
				$this->lblId->Text = $this->objRace->Id;
			else
				$this->lblId->Text = 'N/A';
		}

		// Create and Setup txtName
		protected function txtName_Create() {
			$this->txtName = new QTextBox($this);
			$this->txtName->Name = QApplication::Translate('Name');
			$this->txtName->Text = $this->objRace->Name;
			$this->txtName->Required = true;
			$this->txtName->MaxLength = Race::NameMaxLength;
		}

		// Create and Setup txtDistance
		protected function txtDistance_Create() {
			$this->txtDistance = new QFloatTextBox($this);
			$this->txtDistance->Name = QApplication::Translate('Distance');
			$this->txtDistance->Text = $this->objRace->Distance;
			$this->txtDistance->Required = true;
		}

		// Create and Setup txtDistanceUnit
		protected function txtDistanceUnit_Create() {
			$this->txtDistanceUnit = new QIntegerTextBox($this);
			$this->txtDistanceUnit->Name = QApplication::Translate('Distance Unit');
			$this->txtDistanceUnit->Text = $this->objRace->DistanceUnit;
			$this->txtDistanceUnit->Required = true;
		}

		// Create and Setup txtWebsite
		protected function txtWebsite_Create() {
			$this->txtWebsite = new QTextBox($this);
			$this->txtWebsite->Name = QApplication::Translate('Website');
			$this->txtWebsite->Text = $this->objRace->Website;
			$this->txtWebsite->MaxLength = Race::WebsiteMaxLength;
		}

		// Create and Setup txtRaceLocation
		protected function txtRaceLocation_Create() {
			$this->txtRaceLocation = new QTextBox($this);
			$this->txtRaceLocation->Name = QApplication::Translate('Race Location');
			$this->txtRaceLocation->Text = $this->objRace->RaceLocation;
			$this->txtRaceLocation->MaxLength = Race::RaceLocationMaxLength;
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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(sprintf(QApplication::Translate('Are you SURE you want to DELETE this %s?'), 'Race')));
			$this->btnDelete->AddAction(new QClickEvent(), new QServerAction('btnDelete_Click'));
			$this->btnDelete->CausesValidation = false;
			if (!$this->blnEditMode)
				$this->btnDelete->Visible = false;
		}
		
		// Protected Update Methods
		protected function UpdateRaceFields() {
			$this->objRace->Name = $this->txtName->Text;
			$this->objRace->Distance = $this->txtDistance->Text;
			$this->objRace->DistanceUnit = $this->txtDistanceUnit->Text;
			$this->objRace->Website = $this->txtWebsite->Text;
			$this->objRace->RaceLocation = $this->txtRaceLocation->Text;
		}


		// Control ServerActions
		protected function btnSave_Click($strFormId, $strControlId, $strParameter) {
			$this->UpdateRaceFields();
			$this->objRace->Save();


			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {

			$this->objRace->Delete();

			$this->RedirectToListPage();
		}
		
		protected function RedirectToListPage() {
			QApplication::Redirect('race_list.php');
		}
	}
?>