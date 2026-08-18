<?php
	/**
	 * This is the abstract Form class for the List All functionality
	 * of the MemberMileage class.  This code-generated class
	 * contains a Qform datagrid to display an HTML page that can
	 * list a collection of MemberMileage objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this MemberMileageListFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class MemberMileageListFormBase extends QForm {
		protected $dtgMemberMileage;

		// DataGrid Columns
		protected $colEditLinkColumn;
		protected $colId;
		protected $colMemberId;
		protected $colMiles;
		protected $colLoggedOn;
		protected $colNotes;
		protected $colYear;


		protected function Form_Create() {
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgMemberMileage_EditLinkColumn_Render($_ITEM) ?>');
			$this->colEditLinkColumn->HtmlEntities = false;
			$this->colId = new QDataGridColumn(QApplication::Translate('Id'), '<?= $_ITEM->Id; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberMileage()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberMileage()->Id, false)));
			$this->colMemberId = new QDataGridColumn(QApplication::Translate('Member Id'), '<?= $_FORM->dtgMemberMileage_MemberIdObject_Render($_ITEM); ?>');
			$this->colMiles = new QDataGridColumn(QApplication::Translate('Miles'), '<?= $_ITEM->Miles; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberMileage()->Miles), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberMileage()->Miles, false)));
			$this->colLoggedOn = new QDataGridColumn(QApplication::Translate('Logged On'), '<?= $_FORM->dtgMemberMileage_LoggedOn_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberMileage()->LoggedOn), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberMileage()->LoggedOn, false)));
			$this->colNotes = new QDataGridColumn(QApplication::Translate('Notes'), '<?= QString::Truncate($_ITEM->Notes, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberMileage()->Notes), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberMileage()->Notes, false)));
			$this->colYear = new QDataGridColumn(QApplication::Translate('Year'), '<?= $_ITEM->Year; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberMileage()->Year), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberMileage()->Year, false)));

			// Setup DataGrid
			$this->dtgMemberMileage = new QDataGrid($this);
			$this->dtgMemberMileage->CellSpacing = 0;
			$this->dtgMemberMileage->CellPadding = 4;
			$this->dtgMemberMileage->BorderStyle = QBorderStyle::Solid;
			$this->dtgMemberMileage->BorderWidth = 1;
			$this->dtgMemberMileage->GridLines = QGridLines::Both;

			// Datagrid Paginator
			$this->dtgMemberMileage->Paginator = new QPaginator($this->dtgMemberMileage);
			$this->dtgMemberMileage->ItemsPerPage = 10;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgMemberMileage->UseAjax = false;

			// Specify the local databind method this datagrid will use
			$this->dtgMemberMileage->SetDataBinder('dtgMemberMileage_Bind');

			$this->dtgMemberMileage->AddColumn($this->colEditLinkColumn);
			$this->dtgMemberMileage->AddColumn($this->colId);
			$this->dtgMemberMileage->AddColumn($this->colMemberId);
			$this->dtgMemberMileage->AddColumn($this->colMiles);
			$this->dtgMemberMileage->AddColumn($this->colLoggedOn);
			$this->dtgMemberMileage->AddColumn($this->colNotes);
			$this->dtgMemberMileage->AddColumn($this->colYear);
		}
		
		public function dtgMemberMileage_EditLinkColumn_Render(MemberMileage $objMemberMileage) {
			return sprintf('<a href="member_mileage_edit.php?intId=%s">%s</a>',
				$objMemberMileage->Id, 
				QApplication::Translate('Edit'));
		}

		public function dtgMemberMileage_MemberIdObject_Render(MemberMileage $objMemberMileage) {
			if (!is_null($objMemberMileage->MemberIdObject))
				return $objMemberMileage->MemberIdObject->__toString();
			else
				return null;
		}

		public function dtgMemberMileage_LoggedOn_Render(MemberMileage $objMemberMileage) {
			if (!is_null($objMemberMileage->LoggedOn))
				return $objMemberMileage->LoggedOn->toString(QDateTime::FormatDisplayDate);
			else
				return null;
		}


		protected function dtgMemberMileage_Bind() {
			// Because we want to enable pagination AND sorting, we need to setup the $objClauses array to send to LoadAll()

			// Remember!  We need to first set the TotalItemCount, which will affect the calcuation of LimitClause below
			$this->dtgMemberMileage->TotalItemCount = MemberMileage::CountAll();

			// Setup the $objClauses Array
			$objClauses = array();

			// If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
			// the OrderByClause to the $objClauses array
			if ($objClause = $this->dtgMemberMileage->OrderByClause)
				array_push($objClauses, $objClause);

			// Add the LimitClause information, as well
			if ($objClause = $this->dtgMemberMileage->LimitClause)
				array_push($objClauses, $objClause);

			// Set the DataSource to be the array of all MemberMileage objects, given the clauses above
			$this->dtgMemberMileage->DataSource = MemberMileage::LoadAll($objClauses);
		}
	}
?>