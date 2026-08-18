<?php
// no longer using
exit;
/**
 * @abstract Lists the member access
 * @author w. Patrick Gale
 *
 * Dec. 31, 2017 - wpg
 * - adding sorting by member
 */
	// Include prepend.inc to load Qcodo
	require('includes/prepend.inc.php');
	require(__FORMBASE_CLASSES__ . '/MemberAclAssnListFormBase.class.php');
	QApplication::CheckRemoteAdmin();

	class acx1MemberAclAssnListForm extends MemberAclAssnListFormBase {
		protected function Form_Create() {
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgMemberAclAssn_EditLinkColumn_Render($_ITEM) ?>');
			$this->colEditLinkColumn->HtmlEntities = false;
			$this->colMemberId = new QDataGridColumn(QApplication::Translate('Member'), '<?= $_FORM->dtgMemberAclAssn_MemberIdObject_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberAclAssn()->MemberId), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberAclAssn()->MemberId, false)));
			$this->colAcl = new QDataGridColumn(QApplication::Translate('Access'), '<?= MemberAclAssn::$accessArray[$_ITEM->Acl]; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberAclAssn()->Acl), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberAclAssn()->Acl, false)));

			// Setup DataGrid
			$this->dtgMemberAclAssn = new QDataGrid($this);
			$this->dtgMemberAclAssn->CellSpacing = 0;
			$this->dtgMemberAclAssn->CellPadding = 4;
			$this->dtgMemberAclAssn->BorderStyle = QBorderStyle::Solid;
			$this->dtgMemberAclAssn->BorderWidth = 1;
			$this->dtgMemberAclAssn->GridLines = QGridLines::Both;

			// Datagrid Paginator
			$this->dtgMemberAclAssn->Paginator = new QPaginator($this->dtgMemberAclAssn);
			$this->dtgMemberAclAssn->ItemsPerPage = __ITEMS_PER_PAGE__;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgMemberAclAssn->UseAjax = false;

			// Specify the local databind method this datagrid will use
			$this->dtgMemberAclAssn->SetDataBinder('dtgMemberAclAssn_Bind');

			$this->dtgMemberAclAssn->AddColumn($this->colEditLinkColumn);
			$this->dtgMemberAclAssn->AddColumn($this->colMemberId);
			$this->dtgMemberAclAssn->AddColumn($this->colAcl);
		}

		public function dtgMemberAclAssn_EditLinkColumn_Render(MemberAclAssn $objMemberAclAssn) {
			return sprintf('<a href="MemberAcl.php?intId=%s">%s</a>',
					$objMemberAclAssn->Id,
					QApplication::Translate('Edit'));
		}
	}

	// go to the centralized form executing access control function to run the form and check access control
	//ACL_Run('MemberAcls');
?>