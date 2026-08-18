<?php
/**
 * @abstract Main list of tags.
 * @author w. Patrick Gale
 *
 * Dec. 13, 2017 - wpg
 * - adding basic membership access and changing Tags to Member Participation
 *
 * March 21, 2017 - wpg
 * - creating basic tag list
 * - adding a link to enable tagging of members (selecting the link will start a tagging session and redirect the user to the membership list to select members)
 */
	// Include prepend.inc to load Qcodo
	require('includes/prepend.inc.php');
	require(__FORMBASE_CLASSES__ . '/TagListFormBase.class.php');
	QApplication::CheckRemoteAdmin();

	// system admin access
	class acx1TagListForm extends TagListFormBase {

		protected function Form_Create() {
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgTag_EditLinkColumn_Render($_ITEM) ?>', array('OrderByClause' => QQ::OrderBy(QQN::Tag()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Tag()->Id, false)));
			$this->colName = new QDataGridColumn(QApplication::Translate('Name'), '<?= $_FORM->dtgTag_NameColumn_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::Tag()->Name), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Tag()->Name, false)));
			$this->colDescription = new QDataGridColumn(QApplication::Translate('Description'), '<?= QString::Truncate($_ITEM->Description, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::Tag()->Description), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Tag()->Description, false)));
			$this->colCreated = new QDataGridColumn(QApplication::Translate('Created'), '<?= $_FORM->dtgTag_Created_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::Tag()->Created), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Tag()->Created, false)));

			$this->colName->HtmlEntities = $this->colEditLinkColumn->HtmlEntities = false;

			// Setup DataGrid
			$this->dtgTag = new QDataGrid($this);
			$this->dtgTag->CellSpacing = 0;
			$this->dtgTag->CellPadding = 4;
			$this->dtgTag->BorderStyle = QBorderStyle::Solid;
			$this->dtgTag->BorderWidth = 1;
			$this->dtgTag->GridLines = QGridLines::Both;

			// Datagrid Paginator
			$this->dtgTag->Paginator = new QPaginator($this->dtgTag);
			$this->dtgTag->ItemsPerPage = __ITEMS_PER_PAGE__;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgTag->UseAjax = false;

			// Specify the local databind method this datagrid will use
			$this->dtgTag->SetDataBinder('dtgTag_Bind');

			$this->showColumns();
		}

		protected function showColumns() {
			$this->dtgTag->AddColumn($this->colEditLinkColumn);
			$this->dtgTag->AddColumn($this->colName);
			$this->dtgTag->AddColumn($this->colDescription);
			$this->dtgTag->AddColumn($this->colCreated);
		}

		public function dtgTag_NameColumn_Render (Tag $objTag) {
			// get the number of members participated already
			$intMemberTagAssoc = MemberTagAssoc::QueryCount(QQ::Equal(QQN::MemberTagAssoc()->TagId, $objTag->Id));
			$tagCount = 0;
			if ($intMemberTagAssoc)$tagCount=$intMemberTagAssoc;
			return $objTag->Name."<br/>".sprintf('<a href="MemberTags.php?intTagId=%s" class="sm bld">%s</a> (%s members participated)',
					$objTag->Id,
					QApplication::Translate('Tag Members'),
					$tagCount);
		}

		public function dtgTag_EditLinkColumn_Render(Tag $objTag) {
			return sprintf('<a href="Tag.php?intId=%s">%s</a>',
					$objTag->Id,
					QApplication::Translate('Edit'));
		}

		//$this->btnStartTagSelect_Create();

		// button used to start tag selection for this data request
		protected function btnStartTagSelect_Create() {
			if ($this->objDataPullNotes->Id != '' && !$this->objDataPullNotes->Sent) {
				if (trim(QSessionDB::get('__VAR_COLLECTION_PROJECT_REQUEST_NAME__' ?? ''))=='') {
					$this->btnStartTagSelect = new QButton($this);
					$this->changeVarBtnTxt();
					$this->btnStartTagSelect->AddAction(new QClickEvent(), new QServerAction('startVarSelection'));
				}
				else {
					$this->btnStartTagSelect = new QPlain($this);
					// 				$this->changeVarBtnTxt(false);
					// 				$this->btnStartTagSelect->AddAction(new QClickEvent(), new QServerAction('stopVarSelection'));
				}
			}
			else {
				$this->btnStartTagSelect = new QPlain($this);
				if ($this->objDataPullNotes->Sent) {
					$this->btnSave->Visible = false;
					$this->btnDelete->Visible = false;
				}
			}

			$this->btnStartTagSelect->CssClass = 'fs14 bld c4168b7';
			//$this->btnStartTagSelect->HtmlBefore = $this->strRequestName." ";
		}

		protected function changeVarBtnTxt($blnEnable=true){
			if($blnEnable) {
				$this->btnStartTagSelect->Visible=true;
				$this->btnStartTagSelect->Text = "Select data variables for this request";
			}
			else {
				$this->btnStartTagSelect->Visible=true;
				$this->btnStartTagSelect->Text = NULL;
				$this->btnStartTagSelect->Enabled = false;//"Stop selection of data variables for this request";
			}
		}

		protected function stopVarSelection() {
			QApplication::Redirect('variable_pull.php');
		}

		protected function startVarSelection() {
			// see if we have initiated a variable selection session for a data request
			$intVarProjectRequest = QSessionDB::get('__MEMBER_TAG_SELECTION_');
			$intPrId = $this->objDataPullNotes->Id;

			// get list of selected variables for this project request if we have them
			if ($intVarProjectRequest == '' && $intPrId != ''){
				$intMemberTag = $intPrId;
				QSessionDB::set('__MEMBER_TAG_UPDATE_NEEDED__', false);
				QSessionDB::set('__MEMBER_TAG_SELECTION_', $intMemberTag);
				QSessionDB::set('__MEMBER_TAG_NAME__', $this->strRequestName);
				$this->changeVarBtnTxt(false);
				$objDataDictionaryArray = DataDictionary::QueryArray(
						QQ::Equal(QQN::DataDictionary()->DataPullNotesAsDpVariable->DpnId, $intMemberTag),
						null, null, array('id')
				);
				$tempDDarray = array();
				if ($objDataDictionaryArray) foreach ($objDataDictionaryArray as $objDataDictionary){
					$tempDDarray[$objDataDictionary->Id] = $objDataDictionary->Id;
				}
				QSessionDB::set('__MEMBER_TAG_LIST__',serialize($tempDDarray));
				QApplication::Redirect('#');
			}
			else
				$this->changeVarBtnTxt();
		}
	}

	// member access
	class acx2TagListForm extends acx1TagListForm{
		protected function showColumns() {
			$this->dtgTag->AddColumn($this->colName);
			$this->dtgTag->AddColumn($this->colDescription);
			$this->dtgTag->AddColumn($this->colCreated);
		}

		public function dtgTag_NameColumn_Render (Tag $objTag) {
			// get the number of members participated already
			$intMemberTagAssoc = MemberTagAssoc::QueryCount(QQ::Equal(QQN::MemberTagAssoc()->TagId, $objTag->Id));
			$tagCount = 0;
			if ($intMemberTagAssoc)$tagCount=$intMemberTagAssoc;
			return $objTag->Name."<br/>".sprintf('<a href="MemberTags.php?intTagId=%s" class="sm bld">%s</a> (%s members participated)',
					$objTag->Id,
					QApplication::Translate('Participation'),
					$tagCount);
		}
	}

	// go to the centralized form executing access control function to run the form and check access control
	ACL_Run('Tags');
?>