<?php
	/**
	 * This is the abstract Form class for the Create, Edit, and Delete functionality
	 * of the FamilyMemberAssoc class.  This code-generated class
	 * contains all the basic Qform elements to display an HTML form that can
	 * manipulate a single FamilyMemberAssoc object.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this FamilyMemberAssocEditFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class FamilyMemberAssocEditFormBase extends QForm {
		// General Form Variables
		protected $objFamilyMemberAssoc;
		protected $strTitleVerb;
		protected $blnEditMode;

		// Controls for FamilyMemberAssoc's Data Fields
		protected $lblId;
		protected $lstMembershipLogIdObject;
		protected $chkPrimaryMember;
		protected $lstFamilyMemberIdObject;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Button Actions
		protected $btnSave;
		protected $btnCancel;
		protected $btnDelete;

		protected function SetupFamilyMemberAssoc() {
			// Lookup Object PK information from Query String (if applicable)
			// Set mode to Edit or New depending on what's found
			$intId = QApplication::QueryString('intId');
			if (($intId)) {
				$this->objFamilyMemberAssoc = FamilyMemberAssoc::Load(($intId));

				if (!$this->objFamilyMemberAssoc)
					throw new Exception('Could not find a FamilyMemberAssoc object with PK arguments: ' . $intId);

				$this->strTitleVerb = QApplication::Translate('Edit');
				$this->blnEditMode = true;
			} else {
				$this->objFamilyMemberAssoc = new FamilyMemberAssoc();
				$this->strTitleVerb = QApplication::Translate('Create');
				$this->blnEditMode = false;
			}
		}

		protected function Form_Create() {
			// Call SetupFamilyMemberAssoc to either Load/Edit Existing or Create New
			$this->SetupFamilyMemberAssoc();

			// Create/Setup Controls for FamilyMemberAssoc's Data Fields
			$this->lblId_Create();
			$this->lstMembershipLogIdObject_Create();
			$this->chkPrimaryMember_Create();
			$this->lstFamilyMemberIdObject_Create();

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
				$this->lblId->Text = $this->objFamilyMemberAssoc->Id;
			else
				$this->lblId->Text = 'N/A';
		}

		// Create and Setup lstMembershipLogIdObject
		protected function lstMembershipLogIdObject_Create() {
			$this->lstMembershipLogIdObject = new QListBox($this);
			$this->lstMembershipLogIdObject->Name = QApplication::Translate('Membership Log Id Object');
			$this->lstMembershipLogIdObject->Required = true;
			if (!$this->blnEditMode)
				$this->lstMembershipLogIdObject->AddItem(QApplication::Translate('- Select One -'), null);
			$objMembershipLogIdObjectArray = MembershipLog::LoadAll();
			if ($objMembershipLogIdObjectArray) foreach ($objMembershipLogIdObjectArray as $objMembershipLogIdObject) {
				$objListItem = new QListItem($objMembershipLogIdObject->__toString(), $objMembershipLogIdObject->Id);
				if (($this->objFamilyMemberAssoc->MembershipLogIdObject) && ($this->objFamilyMemberAssoc->MembershipLogIdObject->Id == $objMembershipLogIdObject->Id))
					$objListItem->Selected = true;
				$this->lstMembershipLogIdObject->AddItem($objListItem);
			}
		}

		// Create and Setup chkPrimaryMember
		protected function chkPrimaryMember_Create() {
			$this->chkPrimaryMember = new QCheckBox($this);
			$this->chkPrimaryMember->Name = QApplication::Translate('Primary Member');
			$this->chkPrimaryMember->Checked = $this->objFamilyMemberAssoc->PrimaryMember;
		}

		// Create and Setup lstFamilyMemberIdObject
		protected function lstFamilyMemberIdObject_Create() {
			$this->lstFamilyMemberIdObject = new QListBox($this);
			$this->lstFamilyMemberIdObject->Name = QApplication::Translate('Family Member Id Object');
			$this->lstFamilyMemberIdObject->AddItem(QApplication::Translate('- Select One -'), null);
			$objFamilyMemberIdObjectArray = MemberContact::LoadAll();
			if ($objFamilyMemberIdObjectArray) foreach ($objFamilyMemberIdObjectArray as $objFamilyMemberIdObject) {
				$objListItem = new QListItem($objFamilyMemberIdObject->__toString(), $objFamilyMemberIdObject->Id);
				if (($this->objFamilyMemberAssoc->FamilyMemberIdObject) && ($this->objFamilyMemberAssoc->FamilyMemberIdObject->Id == $objFamilyMemberIdObject->Id))
					$objListItem->Selected = true;
				$this->lstFamilyMemberIdObject->AddItem($objListItem);
			}
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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(sprintf(QApplication::Translate('Are you SURE you want to DELETE this %s?'), 'FamilyMemberAssoc')));
			$this->btnDelete->AddAction(new QClickEvent(), new QServerAction('btnDelete_Click'));
			$this->btnDelete->CausesValidation = false;
			if (!$this->blnEditMode)
				$this->btnDelete->Visible = false;
		}
		
		// Protected Update Methods
		protected function UpdateFamilyMemberAssocFields() {
			$this->objFamilyMemberAssoc->MembershipLogId = $this->lstMembershipLogIdObject->SelectedValue;
			$this->objFamilyMemberAssoc->PrimaryMember = $this->chkPrimaryMember->Checked;
			$this->objFamilyMemberAssoc->FamilyMemberId = $this->lstFamilyMemberIdObject->SelectedValue;
		}


		// Control ServerActions
		protected function btnSave_Click($strFormId, $strControlId, $strParameter) {
			$this->UpdateFamilyMemberAssocFields();
			$this->objFamilyMemberAssoc->Save();


			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {

			$this->objFamilyMemberAssoc->Delete();

			$this->RedirectToListPage();
		}
		
		protected function RedirectToListPage() {
			QApplication::Redirect('family_member_assoc_list.php');
		}
	}
?>