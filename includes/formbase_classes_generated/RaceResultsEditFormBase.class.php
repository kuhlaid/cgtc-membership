<?php
	/**
	 * This is the abstract Form class for the Create, Edit, and Delete functionality
	 * of the RaceResults class.  This code-generated class
	 * contains all the basic Qform elements to display an HTML form that can
	 * manipulate a single RaceResults object.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this RaceResultsEditFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class RaceResultsEditFormBase extends QForm {
		// General Form Variables
		protected $objRaceResults;
		protected $strTitleVerb;
		protected $blnEditMode;

		// Controls for RaceResults's Data Fields
		protected $lblId;
		protected $calRaceDate;
		protected $txtPlacement;
		protected $lstRaceObject;
		protected $txtHeaderLine;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Button Actions
		protected $btnSave;
		protected $btnCancel;
		protected $btnDelete;

		protected function SetupRaceResults() {
			// Lookup Object PK information from Query String (if applicable)
			// Set mode to Edit or New depending on what's found
			$intId = QApplication::QueryString('intId');
			if (($intId)) {
				$this->objRaceResults = RaceResults::Load(($intId));

				if (!$this->objRaceResults)
					throw new Exception('Could not find a RaceResults object with PK arguments: ' . $intId);

				$this->strTitleVerb = QApplication::Translate('Edit');
				$this->blnEditMode = true;
			} else {
				$this->objRaceResults = new RaceResults();
				$this->strTitleVerb = QApplication::Translate('Create');
				$this->blnEditMode = false;
			}
		}

		protected function Form_Create() {
			// Call SetupRaceResults to either Load/Edit Existing or Create New
			$this->SetupRaceResults();

			// Create/Setup Controls for RaceResults's Data Fields
			$this->lblId_Create();
			$this->calRaceDate_Create();
			$this->txtPlacement_Create();
			$this->lstRaceObject_Create();
			$this->txtHeaderLine_Create();

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
				$this->lblId->Text = $this->objRaceResults->Id;
			else
				$this->lblId->Text = 'N/A';
		}

		// Create and Setup calRaceDate
		protected function calRaceDate_Create() {
			$this->calRaceDate = new QDateTimePicker($this);
			$this->calRaceDate->Name = QApplication::Translate('Race Date');
			$this->calRaceDate->DateTime = $this->objRaceResults->RaceDate;
			$this->calRaceDate->DateTimePickerType = QDateTimePickerType::Date;
			$this->calRaceDate->Required = true;
		}

		// Create and Setup txtPlacement
		protected function txtPlacement_Create() {
			$this->txtPlacement = new QTextBox($this);
			$this->txtPlacement->Name = QApplication::Translate('Placement');
			$this->txtPlacement->Text = $this->objRaceResults->Placement;
			$this->txtPlacement->Required = true;
			$this->txtPlacement->TextMode = QTextMode::MultiLine;
		}

		// Create and Setup lstRaceObject
		protected function lstRaceObject_Create() {
			$this->lstRaceObject = new QListBox($this);
			$this->lstRaceObject->Name = QApplication::Translate('Race Object');
			$this->lstRaceObject->Required = true;
			if (!$this->blnEditMode)
				$this->lstRaceObject->AddItem(QApplication::Translate('- Select One -'), null);
			$objRaceObjectArray = Race::LoadAll();
			if ($objRaceObjectArray) foreach ($objRaceObjectArray as $objRaceObject) {
				$objListItem = new QListItem($objRaceObject->__toString(), $objRaceObject->Id);
				if (($this->objRaceResults->RaceObject) && ($this->objRaceResults->RaceObject->Id == $objRaceObject->Id))
					$objListItem->Selected = true;
				$this->lstRaceObject->AddItem($objListItem);
			}
		}

		// Create and Setup txtHeaderLine
		protected function txtHeaderLine_Create() {
			$this->txtHeaderLine = new QIntegerTextBox($this);
			$this->txtHeaderLine->Name = QApplication::Translate('Header Line');
			$this->txtHeaderLine->Text = $this->objRaceResults->HeaderLine;
			$this->txtHeaderLine->Required = true;
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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(sprintf(QApplication::Translate('Are you SURE you want to DELETE this %s?'), 'RaceResults')));
			$this->btnDelete->AddAction(new QClickEvent(), new QServerAction('btnDelete_Click'));
			$this->btnDelete->CausesValidation = false;
			if (!$this->blnEditMode)
				$this->btnDelete->Visible = false;
		}
		
		// Protected Update Methods
		protected function UpdateRaceResultsFields() {
			$this->objRaceResults->RaceDate = $this->calRaceDate->DateTime;
			$this->objRaceResults->Placement = $this->txtPlacement->Text;
			$this->objRaceResults->Race = $this->lstRaceObject->SelectedValue;
			$this->objRaceResults->HeaderLine = $this->txtHeaderLine->Text;
		}


		// Control ServerActions
		protected function btnSave_Click($strFormId, $strControlId, $strParameter) {
			$this->UpdateRaceResultsFields();
			$this->objRaceResults->Save();


			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {

			$this->objRaceResults->Delete();

			$this->RedirectToListPage();
		}
		
		protected function RedirectToListPage() {
			QApplication::Redirect('race_results_list.php');
		}
	}
?>