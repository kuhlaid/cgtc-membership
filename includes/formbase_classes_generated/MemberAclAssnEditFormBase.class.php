<?php
	/**
	 * This is the abstract Form class for the Create, Edit, and Delete functionality
	 * of the MemberAclAssn class.  This code-generated class
	 * contains all the basic Qform elements to display an HTML form that can
	 * manipulate a single MemberAclAssn object.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this MemberAclAssnEditFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class MemberAclAssnEditFormBase extends QForm {
		// General Form Variables
		protected $objMemberAclAssn;
		protected $strTitleVerb;
		protected $blnEditMode;

		// Controls for MemberAclAssn's Data Fields
		protected $lblId;
		protected $lstMemberIdObject;
		protected $txtAcl;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Button Actions
		protected $btnSave;
		protected $btnCancel;
		protected $btnDelete;

		protected function SetupMemberAclAssn() {
			// Lookup Object PK information from Query String (if applicable)
			// Set mode to Edit or New depending on what's found
			$intId = QApplication::QueryString('intId');
			if (($intId)) {
				$this->objMemberAclAssn = MemberAclAssn::Load(($intId));

				if (!$this->objMemberAclAssn)
					throw new Exception('Could not find a MemberAclAssn object with PK arguments: ' . $intId);

				$this->strTitleVerb = QApplication::Translate('Edit');
				$this->blnEditMode = true;
			} else {
				$this->objMemberAclAssn = new MemberAclAssn();
				$this->strTitleVerb = QApplication::Translate('Create');
				$this->blnEditMode = false;
			}
		}

		protected function Form_Create() {
			// Call SetupMemberAclAssn to either Load/Edit Existing or Create New
			$this->SetupMemberAclAssn();

			// Create/Setup Controls for MemberAclAssn's Data Fields
			$this->lblId_Create();
			$this->lstMemberIdObject_Create();
			$this->txtAcl_Create();

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
				$this->lblId->Text = $this->objMemberAclAssn->Id;
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
				if (($this->objMemberAclAssn->MemberIdObject) && ($this->objMemberAclAssn->MemberIdObject->Id == $objMemberIdObject->Id))
					$objListItem->Selected = true;
				$this->lstMemberIdObject->AddItem($objListItem);
			}
		}

		// Create and Setup txtAcl
		protected function txtAcl_Create() {
			$this->txtAcl = new QIntegerTextBox($this);
			$this->txtAcl->Name = QApplication::Translate('Acl');
			$this->txtAcl->Text = $this->objMemberAclAssn->Acl;
			$this->txtAcl->Required = true;
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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(sprintf(QApplication::Translate('Are you SURE you want to DELETE this %s?'), 'MemberAclAssn')));
			$this->btnDelete->AddAction(new QClickEvent(), new QServerAction('btnDelete_Click'));
			$this->btnDelete->CausesValidation = false;
			if (!$this->blnEditMode)
				$this->btnDelete->Visible = false;
		}
		
		// Protected Update Methods
		protected function UpdateMemberAclAssnFields() {
			$this->objMemberAclAssn->MemberId = $this->lstMemberIdObject->SelectedValue;
			$this->objMemberAclAssn->Acl = $this->txtAcl->Text;
		}


		// Control ServerActions
		protected function btnSave_Click($strFormId, $strControlId, $strParameter) {
			$this->UpdateMemberAclAssnFields();
			$this->objMemberAclAssn->Save();


			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {

			$this->objMemberAclAssn->Delete();

			$this->RedirectToListPage();
		}
		
		protected function RedirectToListPage() {
			QApplication::Redirect('member_acl_assn_list.php');
		}
	}
?>