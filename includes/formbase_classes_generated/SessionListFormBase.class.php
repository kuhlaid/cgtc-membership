<?php
	/**
	 * This is the abstract Form class for the List All functionality
	 * of the Session class.  This code-generated class
	 * contains a Qform datagrid to display an HTML page that can
	 * list a collection of Session objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this SessionListFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class SessionListFormBase extends QForm {
		protected $dtgSession;

		// DataGrid Columns
		protected $colEditLinkColumn;
		protected $colId;
		protected $colSessionData;
		protected $colLastAccess;


		protected function Form_Create() {
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgSession_EditLinkColumn_Render($_ITEM) ?>');
			$this->colEditLinkColumn->HtmlEntities = false;
			$this->colId = new QDataGridColumn(QApplication::Translate('Id'), '<?= QString::Truncate($_ITEM->Id, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::Session()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Session()->Id, false)));
			$this->colSessionData = new QDataGridColumn(QApplication::Translate('Session Data'), '<?= QString::Truncate($_ITEM->SessionData, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::Session()->SessionData), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Session()->SessionData, false)));
			$this->colLastAccess = new QDataGridColumn(QApplication::Translate('Last Access'), '<?= $_FORM->dtgSession_LastAccess_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::Session()->LastAccess), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Session()->LastAccess, false)));

			// Setup DataGrid
			$this->dtgSession = new QDataGrid($this);
			$this->dtgSession->CellSpacing = 0;
			$this->dtgSession->CellPadding = 4;
			$this->dtgSession->BorderStyle = QBorderStyle::Solid;
			$this->dtgSession->BorderWidth = 1;
			$this->dtgSession->GridLines = QGridLines::Both;

			// Datagrid Paginator
			$this->dtgSession->Paginator = new QPaginator($this->dtgSession);
			$this->dtgSession->ItemsPerPage = 10;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgSession->UseAjax = false;

			// Specify the local databind method this datagrid will use
			$this->dtgSession->SetDataBinder('dtgSession_Bind');

			$this->dtgSession->AddColumn($this->colEditLinkColumn);
			$this->dtgSession->AddColumn($this->colId);
			$this->dtgSession->AddColumn($this->colSessionData);
			$this->dtgSession->AddColumn($this->colLastAccess);
		}
		
		public function dtgSession_EditLinkColumn_Render(Session $objSession) {
			return sprintf('<a href="session_edit.php?strId=%s">%s</a>',
				$objSession->Id, 
				QApplication::Translate('Edit'));
		}

		public function dtgSession_LastAccess_Render(Session $objSession) {
			if (!is_null($objSession->LastAccess))
				return $objSession->LastAccess->toString(QDateTime::FormatDisplayDateTime);
			else
				return null;
		}


		protected function dtgSession_Bind() {
			// Because we want to enable pagination AND sorting, we need to setup the $objClauses array to send to LoadAll()

			// Remember!  We need to first set the TotalItemCount, which will affect the calcuation of LimitClause below
			$this->dtgSession->TotalItemCount = Session::CountAll();

			// Setup the $objClauses Array
			$objClauses = array();

			// If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
			// the OrderByClause to the $objClauses array
			if ($objClause = $this->dtgSession->OrderByClause)
				array_push($objClauses, $objClause);

			// Add the LimitClause information, as well
			if ($objClause = $this->dtgSession->LimitClause)
				array_push($objClauses, $objClause);

			// Set the DataSource to be the array of all Session objects, given the clauses above
			$this->dtgSession->DataSource = Session::LoadAll($objClauses);
		}
	}
?>