<?php
/**
 * @abstract Form for assigning application access to members.
 * @author w. Patrick Gale
 *
 * Dec. 31, 2017 - wpg
 * - simplifying the form so a member must be selected before coming here and all access selections are made on a single form
 */
// Include prepend.inc to load Qcodo
require('includes/prepend.inc.php');
require(__FORMBASE_CLASSES__ . '/MemberAclAssnEditFormBase.class.php');
QApplication::CheckRemoteAdmin();


class acx1MemberAclAssnEditForm extends MemberAclAssnEditFormBase {
	protected $objMemberContact;
	protected function SetupMemberAclAssn() {
		$intMemberId = QApplication::QueryString('iMD');
		// check for the member
		if ($intMemberId) {
			$this->objMemberContact = MemberContact::Load($intMemberId);
			if (!$this->objMemberContact) $this->noMember();
		}
		else $this->noMember();
	}

	protected function noMember(){
		QSessionDB::set("error", "There was an error accessing the member. Try again.");
		QApplication::Redirect('MembershipList.php');
		exit;
	}

	protected function lstMemberIdObject_Create() {
		$this->lstMemberIdObject = new QLabel($this);
		$this->lstMemberIdObject->Name = '<span class="bld fs18">Member:</span>';
		$this->lstMemberIdObject->Text = MemberContact::BasicMemberContactInfo($this->objMemberContact);
		$this->lstMemberIdObject->HtmlEntities = false;
	}

	protected function txtAcl_Create() {
		$this->txtAcl = new QCheckBoxList($this);
		$this->txtAcl->Name = QApplication::Translate('Member Access');
		// get the list of assigned application access for the member
		$objMemberAclAssnArray = MemberAclAssn::LoadArrayByMemberId($this->objMemberContact->Id);
		$memberAcxArray = array();
		if ($objMemberAclAssnArray) foreach ($objMemberAclAssnArray as $objMemberAclAssn) {
			array_push($memberAcxArray, $objMemberAclAssn->Acl);
		}
		foreach (MemberAclAssn::$accessArray as $acxKey=>$acxValue) {
			$objListItem = new QListItem($acxValue, $acxKey);
			if ($memberAcxArray && (in_array($acxKey, $memberAcxArray)))
				$objListItem->Selected = true;
			$this->txtAcl->AddItem($objListItem);
		}
	}

	protected function btnSave_Click($strFormId, $strControlId, $strParameter) {
		// remove all access for the member and then reassign new settings
		MemberAclAssn::DeleteMemberAcl($this->objMemberContact->Id);

		$objSelectedListItems = $this->txtAcl->SelectedItems;
 		if ($objSelectedListItems) foreach ($objSelectedListItems as $objListItem) {
 			$this->objMemberAclAssn = new MemberAclAssn();
			$this->objMemberAclAssn->MemberId = $this->objMemberContact->Id;
			$this->objMemberAclAssn->Acl = $objListItem->Value;
			$this->objMemberAclAssn->Save();
 		}
		$this->RedirectToListPage();
	}

	protected function RedirectToListPage() {
		QApplication::Redirect('MembershipList.php?iMD='.$this->objMemberContact->Id);
	}
}

// go to the centralized form executing access control function to run the form and check access control
ACL_Run('MemberAcl');
?>