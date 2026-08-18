<?php
	/**
	 * This is the abstract Form class for the List All functionality
	 * of the MembershipAssoc class.  This code-generated class
	 * contains a Qform datagrid to display an HTML page that can
	 * list a collection of MembershipAssoc objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this MembershipAssocListFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class MembershipAssocListFormBase extends QForm {
		protected $dtgMembershipAssoc;

		// DataGrid Columns
		protected $colEditLinkColumn;
		protected $colId;
		protected $colMembershipLogId;
		protected $colPrimaryMember;
		protected $colMemberId;


		protected function Form_Create() {
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgMembershipAssoc_EditLinkColumn_Render($_ITEM) ?>');
			$this->colEditLinkColumn->HtmlEntities = false;
			$this->colId = new QDataGridColumn(QApplication::Translate('Id'), '<?= $_ITEM->Id; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipAssoc()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipAssoc()->Id, false)));
			$this->colMembershipLogId = new QDataGridColumn(QApplication::Translate('Membership Log Id'), '<?= $_FORM->dtgMembershipAssoc_MembershipLogIdObject_Render($_ITEM); ?>');
			$this->colPrimaryMember = new QDataGridColumn(QApplication::Translate('Primary Member'), '<?= ($_ITEM->PrimaryMember) ? "true" : "false" ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipAssoc()->PrimaryMember), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipAssoc()->PrimaryMember, false)));
			$this->colMemberId = new QDataGridColumn(QApplication::Translate('Member Id'), '<?= $_FORM->dtgMembershipAssoc_MemberIdObject_Render($_ITEM); ?>');

			// Setup DataGrid
			$this->dtgMembershipAssoc = new QDataGrid($this);
			$this->dtgMembershipAssoc->CellSpacing = 0;
			$this->dtgMembershipAssoc->CellPadding = 4;
			$this->dtgMembershipAssoc->BorderStyle = QBorderStyle::Solid;
			$this->dtgMembershipAssoc->BorderWidth = 1;
			$this->dtgMembershipAssoc->GridLines = QGridLines::Both;

			// Datagrid Paginator
			$this->dtgMembershipAssoc->Paginator = new QPaginator($this->dtgMembershipAssoc);
			$this->dtgMembershipAssoc->ItemsPerPage = 10;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgMembershipAssoc->UseAjax = false;

			// Specify the local databind method this datagrid will use
			$this->dtgMembershipAssoc->SetDataBinder('dtgMembershipAssoc_Bind');

			$this->dtgMembershipAssoc->AddColumn($this->colEditLinkColumn);
			$this->dtgMembershipAssoc->AddColumn($this->colId);
			$this->dtgMembershipAssoc->AddColumn($this->colMembershipLogId);
			$this->dtgMembershipAssoc->AddColumn($this->colPrimaryMember);
			$this->dtgMembershipAssoc->AddColumn($this->colMemberId);
		}
		
		public function dtgMembershipAssoc_EditLinkColumn_Render(MembershipAssoc $objMembershipAssoc) {
			return sprintf('<a href="membership_assoc_edit.php?intId=%s">%s</a>',
				$objMembershipAssoc->Id, 
				QApplication::Translate('Edit'));
		}

		public function dtgMembershipAssoc_MembershipLogIdObject_Render(MembershipAssoc $objMembershipAssoc) {
			if (!is_null($objMembershipAssoc->MembershipLogIdObject))
				return $objMembershipAssoc->MembershipLogIdObject->__toString();
			else
				return null;
		}

		public function dtgMembershipAssoc_MemberIdObject_Render(MembershipAssoc $objMembershipAssoc) {
			if (!is_null($objMembershipAssoc->MemberIdObject))
				return $objMembershipAssoc->MemberIdObject->__toString();
			else
				return null;
		}


		protected function dtgMembershipAssoc_Bind() {
			// Because we want to enable pagination AND sorting, we need to setup the $objClauses array to send to LoadAll()

			// Remember!  We need to first set the TotalItemCount, which will affect the calcuation of LimitClause below
			$this->dtgMembershipAssoc->TotalItemCount = MembershipAssoc::CountAll();

			// Setup the $objClauses Array
			$objClauses = array();

			// If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
			// the OrderByClause to the $objClauses array
			if ($objClause = $this->dtgMembershipAssoc->OrderByClause)
				array_push($objClauses, $objClause);

			// Add the LimitClause information, as well
			if ($objClause = $this->dtgMembershipAssoc->LimitClause)
				array_push($objClauses, $objClause);

			// Set the DataSource to be the array of all MembershipAssoc objects, given the clauses above
			$this->dtgMembershipAssoc->DataSource = MembershipAssoc::LoadAll($objClauses);
		}
	}
?>