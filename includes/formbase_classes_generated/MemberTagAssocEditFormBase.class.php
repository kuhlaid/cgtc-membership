<?php
	/**
	 * This is the abstract Form class for the Create, Edit, and Delete functionality
	 * of the MemberTagAssoc class.  This code-generated class
	 * contains all the basic Qform elements to display an HTML form that can
	 * manipulate a single MemberTagAssoc object.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this MemberTagAssocEditFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class MemberTagAssocEditFormBase extends QForm {
		// General Form Variables
		protected $objMemberTagAssoc;
		protected $strTitleVerb;
		protected $blnEditMode;

		// Controls for MemberTagAssoc's Data Fields
		protected $lblId;
		protected $lstMemberIdObject;
		protected $lstTagIdObject;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Button Actions
		protected $btnSave;
		protected $btnCancel;
		protected $btnDelete;

		protected function SetupMemberTagAssoc() {
			// Lookup Object PK information from Query String (if applicable)
			// Set mode to Edit or New depending on what's found
			$intMemberId = QApplication::QueryString('intMemberId');
			$intTagId = QApplication::QueryString('intTagId');
			if (($intMemberId) || ($intTagId)) {
				$this->objMemberTagAssoc = MemberTagAssoc::Load(($intMemberId), ($intTagId));

				if (!$this->objMemberTagAssoc)
					throw new Exception('Could not find a MemberTagAssoc object with PK arguments: ' . $intMemberId . ', ' . $intTagId);

				$this->strTitleVerb = QApplication::Translate('Edit');
				$this->blnEditMode = true;
			} else {
				$this->objMemberTagAssoc = new MemberTagAssoc();
				$this->strTitleVerb = QApplication::Translate('Create');
				$this->blnEditMode = false;
			}
		}

		protected function Form_Create() {
			// Call SetupMemberTagAssoc to either Load/Edit Existing or Create New
			$this->SetupMemberTagAssoc();

			// Create/Setup Controls for MemberTagAssoc's Data Fields
			$this->lblId_Create();
			$this->lstMemberIdObject_Create();
			$this->lstTagIdObject_Create();

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
				$this->lblId->Text = $this->objMemberTagAssoc->Id;
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
				if (($this->objMemberTagAssoc->MemberIdObject) && ($this->objMemberTagAssoc->MemberIdObject->Id == $objMemberIdObject->Id))
					$objListItem->Selected = true;
				$this->lstMemberIdObject->AddItem($objListItem);
			}
		}

		// Create and Setup lstTagIdObject
		protected function lstTagIdObject_Create() {
			$this->lstTagIdObject = new QListBox($this);
			$this->lstTagIdObject->Name = QApplication::Translate('Tag Id Object');
			$this->lstTagIdObject->Required = true;
			if (!$this->blnEditMode)
				$this->lstTagIdObject->AddItem(QApplication::Translate('- Select One -'), null);
			$objTagIdObjectArray = Tag::LoadAll();
			if ($objTagIdObjectArray) foreach ($objTagIdObjectArray as $objTagIdObject) {
				$objListItem = new QListItem($objTagIdObject->__toString(), $objTagIdObject->Id);
				if (($this->objMemberTagAssoc->TagIdObject) && ($this->objMemberTagAssoc->TagIdObject->Id == $objTagIdObject->Id))
					$objListItem->Selected = true;
				$this->lstTagIdObject->AddItem($objListItem);
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
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(sprintf(QApplication::Translate('Are you SURE you want to DELETE this %s?'), 'MemberTagAssoc')));
			$this->btnDelete->AddAction(new QClickEvent(), new QServerAction('btnDelete_Click'));
			$this->btnDelete->CausesValidation = false;
			if (!$this->blnEditMode)
				$this->btnDelete->Visible = false;
		}
		
		// Protected Update Methods
		protected function UpdateMemberTagAssocFields() {
			$this->objMemberTagAssoc->MemberId = $this->lstMemberIdObject->SelectedValue;
			$this->objMemberTagAssoc->TagId = $this->lstTagIdObject->SelectedValue;
		}


		// Control ServerActions
		protected function btnSave_Click($strFormId, $strControlId, $strParameter) {
			$this->UpdateMemberTagAssocFields();
			$this->objMemberTagAssoc->Save();


			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {

			$this->objMemberTagAssoc->Delete();

			$this->RedirectToListPage();
		}
		
		protected function RedirectToListPage() {
			QApplication::Redirect('member_tag_assoc_list.php');
		}
	}
?>