<?php
	/**
	 * This is the abstract Form class for the Create, Edit, and Delete functionality
	 * of the Tag class.  This code-generated class
	 * contains all the basic Qform elements to display an HTML form that can
	 * manipulate a single Tag object.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this TagEditFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class TagEditFormBase extends QForm {
		// General Form Variables
		protected $objTag;
		protected $strTitleVerb;
		protected $blnEditMode;

		// Controls for Tag's Data Fields
		protected $lblId;
		protected $txtName;
		protected $txtDescription;
		protected $calCreated;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Button Actions
		protected $btnSave;
		protected $btnCancel;
		protected $btnDelete;

		protected function SetupTag() {
			// Lookup Object PK information from Query String (if applicable)
			// Set mode to Edit or New depending on what's found
			$intId = QApplication::QueryString('intId');
			if (($intId)) {
				$this->objTag = Tag::Load(($intId));

				if (!$this->objTag)
					throw new Exception('Could not find a Tag object with PK arguments: ' . $intId);

				$this->strTitleVerb = QApplication::Translate('Edit');
				$this->blnEditMode = true;
			} else {
				$this->objTag = new Tag();
				$this->strTitleVerb = QApplication::Translate('Create');
				$this->blnEditMode = false;
			}
		}

		protected function Form_Create() {
			// Call SetupTag to either Load/Edit Existing or Create New
			$this->SetupTag();

			// Create/Setup Controls for Tag's Data Fields
			$this->lblId_Create();
			$this->txtName_Create();
			$this->txtDescription_Create();
			$this->calCreated_Create();

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
				$this->lblId->Text = $this->objTag->Id;
			else
				$this->lblId->Text = 'N/A';
		}

		// Create and Setup txtName
		protected function txtName_Create() {
			$this->txtName = new QTextBox($this);
			$this->txtName->Name = QApplication::Translate('Name');
			$this->txtName->Text = $this->objTag->Name;
			$this->txtName->Required = true;
			$this->txtName->MaxLength = Tag::NameMaxLength;
		}

		// Create and Setup txtDescription
		protected function txtDescription_Create() {
			$this->txtDescription = new QTextBox($this);
			$this->txtDescription->Name = QApplication::Translate('Description');
			$this->txtDescription->Text = $this->objTag->Description;
			$this->txtDescription->Required = true;
			$this->txtDescription->MaxLength = Tag::DescriptionMaxLength;
		}

		// Create and Setup calCreated
		protected function calCreated_Create() {
			$this->calCreated = new QDateTimePicker($this);
			$this->calCreated->Name = QApplication::Translate('Created');
			$this->calCreated->DateTime = $this->objTag->Created;
			$this->calCreated->DateTimePickerType = QDateTimePickerType::Date;
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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(sprintf(QApplication::Translate('Are you SURE you want to DELETE this %s?'), 'Tag')));
			$this->btnDelete->AddAction(new QClickEvent(), new QServerAction('btnDelete_Click'));
			$this->btnDelete->CausesValidation = false;
			if (!$this->blnEditMode)
				$this->btnDelete->Visible = false;
		}
		
		// Protected Update Methods
		protected function UpdateTagFields() {
			$this->objTag->Name = $this->txtName->Text;
			$this->objTag->Description = $this->txtDescription->Text;
			$this->objTag->Created = $this->calCreated->DateTime;
		}


		// Control ServerActions
		protected function btnSave_Click($strFormId, $strControlId, $strParameter) {
			$this->UpdateTagFields();
			$this->objTag->Save();


			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {

			$this->objTag->Delete();

			$this->RedirectToListPage();
		}
		
		protected function RedirectToListPage() {
			QApplication::Redirect('tag_list.php');
		}
	}
?>