<?php
	/**
	 * This is the abstract Form class for the List All functionality
	 * of the MemberAccessLog class.  This code-generated class
	 * contains a Qform datagrid to display an HTML page that can
	 * list a collection of MemberAccessLog objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this MemberAccessLogListFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class MemberAccessLogListFormBase extends QForm {
		protected $dtgMemberAccessLog;

		// DataGrid Columns
		protected $colEditLinkColumn;
		protected $colId;
		protected $colMemberId;
		protected $colTimeOfLogin;
		protected $colLoginMethod;


		protected function Form_Create() {
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgMemberAccessLog_EditLinkColumn_Render($_ITEM) ?>');
			$this->colEditLinkColumn->HtmlEntities = false;
			$this->colId = new QDataGridColumn(QApplication::Translate('Id'), '<?= $_ITEM->Id; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberAccessLog()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberAccessLog()->Id, false)));
			$this->colMemberId = new QDataGridColumn(QApplication::Translate('Member Id'), '<?= $_FORM->dtgMemberAccessLog_MemberIdObject_Render($_ITEM); ?>');
			$this->colTimeOfLogin = new QDataGridColumn(QApplication::Translate('Time Of Login'), '<?= $_FORM->dtgMemberAccessLog_TimeOfLogin_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberAccessLog()->TimeOfLogin), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberAccessLog()->TimeOfLogin, false)));
			$this->colLoginMethod = new QDataGridColumn(QApplication::Translate('Login Method'), '<?= $_ITEM->LoginMethod; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberAccessLog()->LoginMethod), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberAccessLog()->LoginMethod, false)));

			// Setup DataGrid
			$this->dtgMemberAccessLog = new QDataGrid($this);
			$this->dtgMemberAccessLog->CellSpacing = 0;
			$this->dtgMemberAccessLog->CellPadding = 4;
			$this->dtgMemberAccessLog->BorderStyle = QBorderStyle::Solid;
			$this->dtgMemberAccessLog->BorderWidth = 1;
			$this->dtgMemberAccessLog->GridLines = QGridLines::Both;

			// Datagrid Paginator
			$this->dtgMemberAccessLog->Paginator = new QPaginator($this->dtgMemberAccessLog);
			$this->dtgMemberAccessLog->ItemsPerPage = 10;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgMemberAccessLog->UseAjax = false;

			// Specify the local databind method this datagrid will use
			$this->dtgMemberAccessLog->SetDataBinder('dtgMemberAccessLog_Bind');

			$this->dtgMemberAccessLog->AddColumn($this->colEditLinkColumn);
			$this->dtgMemberAccessLog->AddColumn($this->colId);
			$this->dtgMemberAccessLog->AddColumn($this->colMemberId);
			$this->dtgMemberAccessLog->AddColumn($this->colTimeOfLogin);
			$this->dtgMemberAccessLog->AddColumn($this->colLoginMethod);
		}
		
		public function dtgMemberAccessLog_EditLinkColumn_Render(MemberAccessLog $objMemberAccessLog) {
			return sprintf('<a href="member_access_log_edit.php?intId=%s">%s</a>',
				$objMemberAccessLog->Id, 
				QApplication::Translate('Edit'));
		}

		public function dtgMemberAccessLog_MemberIdObject_Render(MemberAccessLog $objMemberAccessLog) {
			if (!is_null($objMemberAccessLog->MemberIdObject))
				return $objMemberAccessLog->MemberIdObject->__toString();
			else
				return null;
		}

		public function dtgMemberAccessLog_TimeOfLogin_Render(MemberAccessLog $objMemberAccessLog) {
			if (!is_null($objMemberAccessLog->TimeOfLogin))
				return $objMemberAccessLog->TimeOfLogin->toString(QDateTime::FormatDisplayDateTime);
			else
				return null;
		}


		protected function dtgMemberAccessLog_Bind() {
			// Because we want to enable pagination AND sorting, we need to setup the $objClauses array to send to LoadAll()

			// Remember!  We need to first set the TotalItemCount, which will affect the calcuation of LimitClause below
			$this->dtgMemberAccessLog->TotalItemCount = MemberAccessLog::CountAll();

			// Setup the $objClauses Array
			$objClauses = array();

			// If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
			// the OrderByClause to the $objClauses array
			if ($objClause = $this->dtgMemberAccessLog->OrderByClause)
				array_push($objClauses, $objClause);

			// Add the LimitClause information, as well
			if ($objClause = $this->dtgMemberAccessLog->LimitClause)
				array_push($objClauses, $objClause);

			// Set the DataSource to be the array of all MemberAccessLog objects, given the clauses above
			$this->dtgMemberAccessLog->DataSource = MemberAccessLog::LoadAll($objClauses);
		}
	}
?>