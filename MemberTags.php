<?php
/**
 * @abstract Shows the list of members associated with a tag.
 * @author w. Patrick Gale
 *
 * Dec. 13, 2017 - wpg
 * - adding basic membership access
 *
 * March 24, 2017 - wpg
 * - changed the page so it does not automatically go into tag editing mode
 *
 * March 21, 2017 - wpg
 * - building basic member associate tag list
 *
 */
	// Include prepend.inc to load Qcodo
	require('includes/prepend.inc.php');
	require(__FORMBASE_CLASSES__ . '/MemberTagAssocListFormBase.class.php');
	QApplication::CheckRemoteAdmin();

	class acx1MemberTagAssocListForm extends MemberTagAssocListFormBase {
		protected $memberTagId, $btnTagging, $objTag;
		protected function Form_Create() {
			$intTagId = QApplication::QueryString('intTagId');
			$this->objTag = Tag::Load($intTagId);
			if (!$this->objTag) {
				QSessionDB::set("error", "Tag not found. Try again.");
				QApplication::Redirect('Tags.php');
				exit;
			}
			//$this->memberTagging();
			$this->btnTagging_Create();

			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgMemberTagAssoc_EditLinkColumn_Render($_ITEM) ?>');
			$this->colEditLinkColumn->HtmlEntities = false;
			$this->colMemberId = new QDataGridColumn(QApplication::Translate('Member'), '<?= $_FORM->dtgMemberTagAssoc_MemberIdObject_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberTagAssoc()->MemberIdObject->LastName), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberTagAssoc()->MemberIdObject->LastName, false)));
			$this->colTagId = new QDataGridColumn(QApplication::Translate('Tag'), '<?= $_FORM->dtgMemberTagAssoc_TagIdObject_Render($_ITEM); ?>');

			$this->colEditLinkColumn->HorizontalAlign  = QHorizontalAlign::Center;

			// Setup DataGrid
			$this->dtgMemberTagAssoc = new QDataGrid($this);
			$this->dtgMemberTagAssoc->CellSpacing = 0;
			$this->dtgMemberTagAssoc->CellPadding = 4;
			$this->dtgMemberTagAssoc->BorderStyle = QBorderStyle::Solid;
			$this->dtgMemberTagAssoc->BorderWidth = 1;
			$this->dtgMemberTagAssoc->GridLines = QGridLines::Both;

			// Datagrid Paginator
			$this->dtgMemberTagAssoc->Paginator = new QPaginator($this->dtgMemberTagAssoc);
			$this->dtgMemberTagAssoc->ItemsPerPage = 500;

			$this->dtgMemberTagAssoc->SortColumnIndex = 0;
			$this->dtgMemberTagAssoc->SortDirection = 0;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgMemberTagAssoc->UseAjax = false;

			// Specify the local databind method this datagrid will use
			$this->dtgMemberTagAssoc->SetDataBinder('dtgMemberTagAssoc_Bind');
			$this->showColumns();
		}

		public function dtgMemberTagAssoc_EditLinkColumn_Render(MemberTagAssoc $objMemberTagAssoc) {
			//////////////
			$btnTag='';
			// we will use explicitly defined control ids.
			$strControlId = 'btnTag' . $objMemberTagAssoc->MemberId;

			// Let's see if the button exists already
			$btnTag = $this->GetControl($strControlId);

			if (!$btnTag) {
				$btnTag = new QButton($this->dtgMemberTagAssoc, $strControlId);
				$btnTag->ActionParameter = $objMemberTagAssoc->MemberId;
				// Let's assign a server action on click
				$btnTag->AddAction(new QClickEvent(), new QConfirmAction('Are you SURE you want to REMOVE this tag for the member?'));
				$btnTag->AddAction(new QClickEvent(), new QServerAction('btnTag_Remove'));
			}
			$btnTag->Text =  "Remove '".$this->objTag->Name."' tag for this member";

			// Render the tagging button.  We want to *return* the contents of the rendered button,
			// not display it.  (The datagrid is responsible for the rendering of this column).
			// Therefore, we must specify "false" for the optional blnDisplayOutput parameter.
			if ($btnTag)
				return $btnTag->Render(false);
			/////////////
			return;
		}

		// remove tag for a member
		protected function btnTag_Remove($strFormId, $strControlId, $strParameter) {
			$objMemberTagAssoc = MemberTagAssoc::Load($strParameter, $this->objTag->Id);
			$objMemberTagAssoc->Delete();
			$this->dtgMemberTagAssoc_Bind();
		}

		protected function showColumns() {
			$this->dtgMemberTagAssoc->AddColumn($this->colMemberId);
			$this->dtgMemberTagAssoc->AddColumn($this->colEditLinkColumn);

			//$this->dtgMemberTagAssoc->AddColumn($this->colTagId);
		}

		protected function btnTagging_Click(){
			// start the member tagging session
			QSessionDB::set('__MEMBER_TAG_ID__', $this->objTag->Id);
			QSessionDB::set('__MEMBER_TAG_NAME__', $this->objTag->Name);
			$this->closeTagBtnActions();
		}

		public function dtgMemberTagAssoc_MemberIdObject_Render(MemberTagAssoc $objMemberTagAssoc) {
			if (!is_null($objMemberTagAssoc->MemberIdObject))
				return $objMemberTagAssoc->MemberIdObject->__toStringLnFirst();
			else
				return null;
		}

		protected function dtgMemberTagAssoc_Bind() {
			$intTagId = $this->objTag->Id;
			$strAndCondition = "
				QQ::Equal(QQN::MemberTagAssoc()->TagId, $intTagId)
			";

			$strAndCondition = "QQ::AndCondition(".$strAndCondition.")";


			$this->dtgMemberTagAssoc->TotalItemCount = MemberTagAssoc::QueryCount(eval("return $strAndCondition;"));

			// Setup the $objClauses Array
			$objClauses = array();

			// If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
			// the OrderByClause to the $objClauses array
			if ($objClause = $this->dtgMemberTagAssoc->OrderByClause)
				array_push($objClauses, $objClause);

			// Add the LimitClause information, as well
			if ($objClause = $this->dtgMemberTagAssoc->LimitClause)
				array_push($objClauses, $objClause);

			// Set the DataSource to be the array of all MemberTagAssoc objects, given the clauses above
			$this->dtgMemberTagAssoc->DataSource = MemberTagAssoc::QueryArray(eval("return $strAndCondition;"),$objClauses);
		}

		// finished selecting variables for the request so can now save them
		protected function btnTagging_Create() {
			$this->btnTagging = new QButton($this);
			// if we have started member tagging then show close member button
			if (QSessionDB::get('__MEMBER_TAG_ID__')) {
				$this->closeTagBtnActions();
			}
			else {
				$this->startTagBtnActions();
			}
			$this->btnTagging->PrimaryButton = true;
			$this->btnTagging->CssClass = 'fs14';
		}

		protected function closeTagBtnActions() {
			$this->btnTagging->HtmlBefore = "<div><< <a href='MembershipList.php' class='fs14'>Go to the membership list to tag additional members</a></div><br/>";
			$this->btnTagging->Text = QApplication::Translate("Close member tagging of '".QSessionDB::get('__MEMBER_TAG_NAME__')."'");
			$this->btnTagging->AddAction(new QClickEvent(), new QServerAction('btnTaggingClose_Click'));
		}

		protected function startTagBtnActions() {
			$this->btnTagging->HtmlBefore = "";
			$this->btnTagging->Text = QApplication::Translate("Tag additional members");
			$this->btnTagging->AddAction(new QClickEvent(), new QServerAction('btnTagging_Click'));
		}

		// save/update the variable selections
		protected function btnTaggingClose_Click() {
			// remove the variables we were using to keep track of the variable selection
			$this->clearVars();
			$this->startTagBtnActions();
		}

		protected function clearVars() {
			QSessionDB::Delete('__MEMBER_TAG_ID__');
			QSessionDB::Delete('__MEMBER_TAG_NAME__');
		}
	}
	class acx2MemberTagAssocListForm extends acx1MemberTagAssocListForm {
		protected function showColumns() {
			$this->dtgMemberTagAssoc->AddColumn($this->colMemberId);
		}
		protected function startTagBtnActions() {
			$this->btnTagging->HtmlBefore = "";
			$this->btnTagging->Text = "";
			$this->btnTagging->Visible = false;
		}
	}
	// go to the centralized form executing access control function to run the form and check access control
	ACL_Run('MemberTags');
?>