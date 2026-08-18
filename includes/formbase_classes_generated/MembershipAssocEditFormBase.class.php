<?php
	/**
	 * This is the abstract Form class for the Create, Edit, and Delete functionality
	 * of the MembershipAssoc class.  This code-generated class
	 * contains all the basic Qform elements to display an HTML form that can
	 * manipulate a single MembershipAssoc object.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this MembershipAssocEditFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class MembershipAssocEditFormBase extends QForm {
		// General Form Variables
		protected $objMembershipAssoc;
		protected $strTitleVerb;
		protected $blnEditMode;

		// Controls for MembershipAssoc's Data Fields
		protected $lblId;
		protected $lstMembershipLogIdObject;
		protected $chkPrimaryMember;
		protected $lstMemberIdObject;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Button Actions
		protected $btnSave;
		protected $btnCancel;
		protected $btnDelete;

		protected function SetupMembershipAssoc() {
			// Lookup Object PK information from Query String (if applicable)
			// Set mode to Edit or New depending on what's found
			$intId = QApplication::QueryString('intId');
			if (($intId)) {
				$this->objMembershipAssoc = MembershipAssoc::Load(($intId));

				if (!$this->objMembershipAssoc)
					throw new Exception('Could not find a MembershipAssoc object with PK arguments: ' . $intId);

				$this->strTitleVerb = QApplication::Translate('Edit');
				$this->blnEditMode = true;
			} else {
				$this->objMembershipAssoc = new MembershipAssoc();
				$this->strTitleVerb = QApplication::Translate('Create');
				$this->blnEditMode = false;
			}
		}

		protected function Form_Create() {
			// Call SetupMembershipAssoc to either Load/Edit Existing or Create New
			$this->SetupMembershipAssoc();

			// Create/Setup Controls for MembershipAssoc's Data Fields
			$this->lblId_Create();
			$this->lstMembershipLogIdObject_Create();
			$this->chkPrimaryMember_Create();
			$this->lstMemberIdObject_Create();

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
				$this->lblId->Text = $this->objMembershipAssoc->Id;
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
				if (($this->objMembershipAssoc->MembershipLogIdObject) && ($this->objMembershipAssoc->MembershipLogIdObject->Id == $objMembershipLogIdObject->Id))
					$objListItem->Selected = true;
				$this->lstMembershipLogIdObject->AddItem($objListItem);
			}
		}

		// Create and Setup chkPrimaryMember
		protected function chkPrimaryMember_Create() {
			$this->chkPrimaryMember = new QCheckBox($this);
			$this->chkPrimaryMember->Name = QApplication::Translate('Primary Member');
			$this->chkPrimaryMember->Checked = $this->objMembershipAssoc->PrimaryMember;
		}

		// Create and Setup lstMemberIdObject
		protected function lstMemberIdObject_Create() {
			$this->lstMemberIdObject = new QListBox($this);
			$this->lstMemberIdObject->Name = QApplication::Translate('Member Id Object');
			$this->lstMemberIdObject->AddItem(QApplication::Translate('- Select One -'), null);
			$objMemberIdObjectArray = MemberContact::LoadAll();
			if ($objMemberIdObjectArray) foreach ($objMemberIdObjectArray as $objMemberIdObject) {
				$objListItem = new QListItem($objMemberIdObject->__toString(), $objMemberIdObject->Id);
				if (($this->objMembershipAssoc->MemberIdObject) && ($this->objMembershipAssoc->MemberIdObject->Id == $objMemberIdObject->Id))
					$objListItem->Selected = true;
				$this->lstMemberIdObject->AddItem($objListItem);
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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(sprintf(QApplication::Translate('Are you SURE you want to DELETE this %s?'), 'MembershipAssoc')));
			$this->btnDelete->AddAction(new QClickEvent(), new QServerAction('btnDelete_Click'));
			$this->btnDelete->CausesValidation = false;
			if (!$this->blnEditMode)
				$this->btnDelete->Visible = false;
		}
		
		// Protected Update Methods
		protected function UpdateMembershipAssocFields() {
			$this->objMembershipAssoc->MembershipLogId = $this->lstMembershipLogIdObject->SelectedValue;
			$this->objMembershipAssoc->PrimaryMember = $this->chkPrimaryMember->Checked;
			$this->objMembershipAssoc->MemberId = $this->lstMemberIdObject->SelectedValue;
		}


		// Control ServerActions
		protected function btnSave_Click($strFormId, $strControlId, $strParameter) {
			$this->UpdateMembershipAssocFields();
			$this->objMembershipAssoc->Save();


			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {

			$this->objMembershipAssoc->Delete();

			$this->RedirectToListPage();
		}
		
		protected function RedirectToListPage() {
			QApplication::Redirect('membership_assoc_list.php');
		}
	}
?>