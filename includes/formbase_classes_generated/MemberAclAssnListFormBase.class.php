<?php
	/**
	 * This is the abstract Form class for the List All functionality
	 * of the MemberAclAssn class.  This code-generated class
	 * contains a Qform datagrid to display an HTML page that can
	 * list a collection of MemberAclAssn objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this MemberAclAssnListFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class MemberAclAssnListFormBase extends QForm {
		protected $dtgMemberAclAssn;

		// DataGrid Columns
		protected $colEditLinkColumn;
		protected $colId;
		protected $colMemberId;
		protected $colAcl;


		protected function Form_Create() {
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgMemberAclAssn_EditLinkColumn_Render($_ITEM) ?>');
			$this->colEditLinkColumn->HtmlEntities = false;
			$this->colId = new QDataGridColumn(QApplication::Translate('Id'), '<?= $_ITEM->Id; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberAclAssn()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberAclAssn()->Id, false)));
			$this->colMemberId = new QDataGridColumn(QApplication::Translate('Member Id'), '<?= $_FORM->dtgMemberAclAssn_MemberIdObject_Render($_ITEM); ?>');
			$this->colAcl = new QDataGridColumn(QApplication::Translate('Acl'), '<?= $_ITEM->Acl; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberAclAssn()->Acl), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberAclAssn()->Acl, false)));

			// Setup DataGrid
			$this->dtgMemberAclAssn = new QDataGrid($this);
			$this->dtgMemberAclAssn->CellSpacing = 0;
			$this->dtgMemberAclAssn->CellPadding = 4;
			$this->dtgMemberAclAssn->BorderStyle = QBorderStyle::Solid;
			$this->dtgMemberAclAssn->BorderWidth = 1;
			$this->dtgMemberAclAssn->GridLines = QGridLines::Both;

			// Datagrid Paginator
			$this->dtgMemberAclAssn->Paginator = new QPaginator($this->dtgMemberAclAssn);
			$this->dtgMemberAclAssn->ItemsPerPage = 10;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgMemberAclAssn->UseAjax = false;

			// Specify the local databind method this datagrid will use
			$this->dtgMemberAclAssn->SetDataBinder('dtgMemberAclAssn_Bind');

			$this->dtgMemberAclAssn->AddColumn($this->colEditLinkColumn);
			$this->dtgMemberAclAssn->AddColumn($this->colId);
			$this->dtgMemberAclAssn->AddColumn($this->colMemberId);
			$this->dtgMemberAclAssn->AddColumn($this->colAcl);
		}
		
		public function dtgMemberAclAssn_EditLinkColumn_Render(MemberAclAssn $objMemberAclAssn) {
			return sprintf('<a href="member_acl_assn_edit.php?intId=%s">%s</a>',
				$objMemberAclAssn->Id, 
				QApplication::Translate('Edit'));
		}

		public function dtgMemberAclAssn_MemberIdObject_Render(MemberAclAssn $objMemberAclAssn) {
			if (!is_null($objMemberAclAssn->MemberIdObject))
				return $objMemberAclAssn->MemberIdObject->__toString();
			else
				return null;
		}


		protected function dtgMemberAclAssn_Bind() {
			// Because we want to enable pagination AND sorting, we need to setup the $objClauses array to send to LoadAll()

			// Remember!  We need to first set the TotalItemCount, which will affect the calcuation of LimitClause below
			$this->dtgMemberAclAssn->TotalItemCount = MemberAclAssn::CountAll();

			// Setup the $objClauses Array
			$objClauses = array();

			// If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
			// the OrderByClause to the $objClauses array
			if ($objClause = $this->dtgMemberAclAssn->OrderByClause)
				array_push($objClauses, $objClause);

			// Add the LimitClause information, as well
			if ($objClause = $this->dtgMemberAclAssn->LimitClause)
				array_push($objClauses, $objClause);

			// Set the DataSource to be the array of all MemberAclAssn objects, given the clauses above
			$this->dtgMemberAclAssn->DataSource = MemberAclAssn::LoadAll($objClauses);
		}
	}
?>