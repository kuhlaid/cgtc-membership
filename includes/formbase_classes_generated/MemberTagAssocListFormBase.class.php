<?php
	/**
	 * This is the abstract Form class for the List All functionality
	 * of the MemberTagAssoc class.  This code-generated class
	 * contains a Qform datagrid to display an HTML page that can
	 * list a collection of MemberTagAssoc objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this MemberTagAssocListFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class MemberTagAssocListFormBase extends QForm {
		protected $dtgMemberTagAssoc;

		// DataGrid Columns
		protected $colEditLinkColumn;
		protected $colId;
		protected $colMemberId;
		protected $colTagId;


		protected function Form_Create() {
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgMemberTagAssoc_EditLinkColumn_Render($_ITEM) ?>');
			$this->colEditLinkColumn->HtmlEntities = false;
			$this->colId = new QDataGridColumn(QApplication::Translate('Id'), '<?= $_ITEM->Id; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberTagAssoc()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberTagAssoc()->Id, false)));
			$this->colMemberId = new QDataGridColumn(QApplication::Translate('Member Id'), '<?= $_FORM->dtgMemberTagAssoc_MemberIdObject_Render($_ITEM); ?>');
			$this->colTagId = new QDataGridColumn(QApplication::Translate('Tag Id'), '<?= $_FORM->dtgMemberTagAssoc_TagIdObject_Render($_ITEM); ?>');

			// Setup DataGrid
			$this->dtgMemberTagAssoc = new QDataGrid($this);
			$this->dtgMemberTagAssoc->CellSpacing = 0;
			$this->dtgMemberTagAssoc->CellPadding = 4;
			$this->dtgMemberTagAssoc->BorderStyle = QBorderStyle::Solid;
			$this->dtgMemberTagAssoc->BorderWidth = 1;
			$this->dtgMemberTagAssoc->GridLines = QGridLines::Both;

			// Datagrid Paginator
			$this->dtgMemberTagAssoc->Paginator = new QPaginator($this->dtgMemberTagAssoc);
			$this->dtgMemberTagAssoc->ItemsPerPage = 10;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgMemberTagAssoc->UseAjax = false;

			// Specify the local databind method this datagrid will use
			$this->dtgMemberTagAssoc->SetDataBinder('dtgMemberTagAssoc_Bind');

			$this->dtgMemberTagAssoc->AddColumn($this->colEditLinkColumn);
			$this->dtgMemberTagAssoc->AddColumn($this->colId);
			$this->dtgMemberTagAssoc->AddColumn($this->colMemberId);
			$this->dtgMemberTagAssoc->AddColumn($this->colTagId);
		}
		
		public function dtgMemberTagAssoc_EditLinkColumn_Render(MemberTagAssoc $objMemberTagAssoc) {
			return sprintf('<a href="member_tag_assoc_edit.php?intMemberId=%s&intTagId=%s">%s</a>',
				$objMemberTagAssoc->MemberId, 
				$objMemberTagAssoc->TagId, 
				QApplication::Translate('Edit'));
		}

		public function dtgMemberTagAssoc_MemberIdObject_Render(MemberTagAssoc $objMemberTagAssoc) {
			if (!is_null($objMemberTagAssoc->MemberIdObject))
				return $objMemberTagAssoc->MemberIdObject->__toString();
			else
				return null;
		}

		public function dtgMemberTagAssoc_TagIdObject_Render(MemberTagAssoc $objMemberTagAssoc) {
			if (!is_null($objMemberTagAssoc->TagIdObject))
				return $objMemberTagAssoc->TagIdObject->__toString();
			else
				return null;
		}


		protected function dtgMemberTagAssoc_Bind() {
			// Because we want to enable pagination AND sorting, we need to setup the $objClauses array to send to LoadAll()

			// Remember!  We need to first set the TotalItemCount, which will affect the calcuation of LimitClause below
			$this->dtgMemberTagAssoc->TotalItemCount = MemberTagAssoc::CountAll();

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
			$this->dtgMemberTagAssoc->DataSource = MemberTagAssoc::LoadAll($objClauses);
		}
	}
?>