<?php
	/**
	 * This is the abstract Form class for the List All functionality
	 * of the FamilyMemberAssoc class.  This code-generated class
	 * contains a Qform datagrid to display an HTML page that can
	 * list a collection of FamilyMemberAssoc objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this FamilyMemberAssocListFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class FamilyMemberAssocListFormBase extends QForm {
		protected $dtgFamilyMemberAssoc;

		// DataGrid Columns
		protected $colEditLinkColumn;
		protected $colId;
		protected $colMembershipLogId;
		protected $colPrimaryMember;
		protected $colFamilyMemberId;


		protected function Form_Create() {
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgFamilyMemberAssoc_EditLinkColumn_Render($_ITEM) ?>');
			$this->colEditLinkColumn->HtmlEntities = false;
			$this->colId = new QDataGridColumn(QApplication::Translate('Id'), '<?= $_ITEM->Id; ?>', array('OrderByClause' => QQ::OrderBy(QQN::FamilyMemberAssoc()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::FamilyMemberAssoc()->Id, false)));
			$this->colMembershipLogId = new QDataGridColumn(QApplication::Translate('Membership Log Id'), '<?= $_FORM->dtgFamilyMemberAssoc_MembershipLogIdObject_Render($_ITEM); ?>');
			$this->colPrimaryMember = new QDataGridColumn(QApplication::Translate('Primary Member'), '<?= ($_ITEM->PrimaryMember) ? "true" : "false" ?>', array('OrderByClause' => QQ::OrderBy(QQN::FamilyMemberAssoc()->PrimaryMember), 'ReverseOrderByClause' => QQ::OrderBy(QQN::FamilyMemberAssoc()->PrimaryMember, false)));
			$this->colFamilyMemberId = new QDataGridColumn(QApplication::Translate('Family Member Id'), '<?= $_FORM->dtgFamilyMemberAssoc_FamilyMemberIdObject_Render($_ITEM); ?>');

			// Setup DataGrid
			$this->dtgFamilyMemberAssoc = new QDataGrid($this);
			$this->dtgFamilyMemberAssoc->CellSpacing = 0;
			$this->dtgFamilyMemberAssoc->CellPadding = 4;
			$this->dtgFamilyMemberAssoc->BorderStyle = QBorderStyle::Solid;
			$this->dtgFamilyMemberAssoc->BorderWidth = 1;
			$this->dtgFamilyMemberAssoc->GridLines = QGridLines::Both;

			// Datagrid Paginator
			$this->dtgFamilyMemberAssoc->Paginator = new QPaginator($this->dtgFamilyMemberAssoc);
			$this->dtgFamilyMemberAssoc->ItemsPerPage = 10;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgFamilyMemberAssoc->UseAjax = false;

			// Specify the local databind method this datagrid will use
			$this->dtgFamilyMemberAssoc->SetDataBinder('dtgFamilyMemberAssoc_Bind');

			$this->dtgFamilyMemberAssoc->AddColumn($this->colEditLinkColumn);
			$this->dtgFamilyMemberAssoc->AddColumn($this->colId);
			$this->dtgFamilyMemberAssoc->AddColumn($this->colMembershipLogId);
			$this->dtgFamilyMemberAssoc->AddColumn($this->colPrimaryMember);
			$this->dtgFamilyMemberAssoc->AddColumn($this->colFamilyMemberId);
		}
		
		public function dtgFamilyMemberAssoc_EditLinkColumn_Render(FamilyMemberAssoc $objFamilyMemberAssoc) {
			return sprintf('<a href="family_member_assoc_edit.php?intId=%s">%s</a>',
				$objFamilyMemberAssoc->Id, 
				QApplication::Translate('Edit'));
		}

		public function dtgFamilyMemberAssoc_MembershipLogIdObject_Render(FamilyMemberAssoc $objFamilyMemberAssoc) {
			if (!is_null($objFamilyMemberAssoc->MembershipLogIdObject))
				return $objFamilyMemberAssoc->MembershipLogIdObject->__toString();
			else
				return null;
		}

		public function dtgFamilyMemberAssoc_FamilyMemberIdObject_Render(FamilyMemberAssoc $objFamilyMemberAssoc) {
			if (!is_null($objFamilyMemberAssoc->FamilyMemberIdObject))
				return $objFamilyMemberAssoc->FamilyMemberIdObject->__toString();
			else
				return null;
		}


		protected function dtgFamilyMemberAssoc_Bind() {
			// Because we want to enable pagination AND sorting, we need to setup the $objClauses array to send to LoadAll()

			// Remember!  We need to first set the TotalItemCount, which will affect the calcuation of LimitClause below
			$this->dtgFamilyMemberAssoc->TotalItemCount = FamilyMemberAssoc::CountAll();

			// Setup the $objClauses Array
			$objClauses = array();

			// If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
			// the OrderByClause to the $objClauses array
			if ($objClause = $this->dtgFamilyMemberAssoc->OrderByClause)
				array_push($objClauses, $objClause);

			// Add the LimitClause information, as well
			if ($objClause = $this->dtgFamilyMemberAssoc->LimitClause)
				array_push($objClauses, $objClause);

			// Set the DataSource to be the array of all FamilyMemberAssoc objects, given the clauses above
			$this->dtgFamilyMemberAssoc->DataSource = FamilyMemberAssoc::LoadAll($objClauses);
		}
	}
?>