<?php
	/**
	 * This is the abstract Form class for the List All functionality
	 * of the RaceResults class.  This code-generated class
	 * contains a Qform datagrid to display an HTML page that can
	 * list a collection of RaceResults objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this RaceResultsListFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class RaceResultsListFormBase extends QForm {
		protected $dtgRaceResults;

		// DataGrid Columns
		protected $colEditLinkColumn;
		protected $colId;
		protected $colRaceDate;
		protected $colPlacement;
		protected $colRace;
		protected $colHeaderLine;


		protected function Form_Create() {
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgRaceResults_EditLinkColumn_Render($_ITEM) ?>');
			$this->colEditLinkColumn->HtmlEntities = false;
			$this->colId = new QDataGridColumn(QApplication::Translate('Id'), '<?= $_ITEM->Id; ?>', array('OrderByClause' => QQ::OrderBy(QQN::RaceResults()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::RaceResults()->Id, false)));
			$this->colRaceDate = new QDataGridColumn(QApplication::Translate('Race Date'), '<?= $_FORM->dtgRaceResults_RaceDate_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::RaceResults()->RaceDate), 'ReverseOrderByClause' => QQ::OrderBy(QQN::RaceResults()->RaceDate, false)));
			$this->colPlacement = new QDataGridColumn(QApplication::Translate('Placement'), '<?= QString::Truncate($_ITEM->Placement, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::RaceResults()->Placement), 'ReverseOrderByClause' => QQ::OrderBy(QQN::RaceResults()->Placement, false)));
			$this->colRace = new QDataGridColumn(QApplication::Translate('Race'), '<?= $_FORM->dtgRaceResults_RaceObject_Render($_ITEM); ?>');
			$this->colHeaderLine = new QDataGridColumn(QApplication::Translate('Header Line'), '<?= $_ITEM->HeaderLine; ?>', array('OrderByClause' => QQ::OrderBy(QQN::RaceResults()->HeaderLine), 'ReverseOrderByClause' => QQ::OrderBy(QQN::RaceResults()->HeaderLine, false)));

			// Setup DataGrid
			$this->dtgRaceResults = new QDataGrid($this);
			$this->dtgRaceResults->CellSpacing = 0;
			$this->dtgRaceResults->CellPadding = 4;
			$this->dtgRaceResults->BorderStyle = QBorderStyle::Solid;
			$this->dtgRaceResults->BorderWidth = 1;
			$this->dtgRaceResults->GridLines = QGridLines::Both;

			// Datagrid Paginator
			$this->dtgRaceResults->Paginator = new QPaginator($this->dtgRaceResults);
			$this->dtgRaceResults->ItemsPerPage = 10;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgRaceResults->UseAjax = false;

			// Specify the local databind method this datagrid will use
			$this->dtgRaceResults->SetDataBinder('dtgRaceResults_Bind');

			$this->dtgRaceResults->AddColumn($this->colEditLinkColumn);
			$this->dtgRaceResults->AddColumn($this->colId);
			$this->dtgRaceResults->AddColumn($this->colRaceDate);
			$this->dtgRaceResults->AddColumn($this->colPlacement);
			$this->dtgRaceResults->AddColumn($this->colRace);
			$this->dtgRaceResults->AddColumn($this->colHeaderLine);
		}
		
		public function dtgRaceResults_EditLinkColumn_Render(RaceResults $objRaceResults) {
			return sprintf('<a href="race_results_edit.php?intId=%s">%s</a>',
				$objRaceResults->Id, 
				QApplication::Translate('Edit'));
		}

		public function dtgRaceResults_RaceDate_Render(RaceResults $objRaceResults) {
			if (!is_null($objRaceResults->RaceDate))
				return $objRaceResults->RaceDate->toString(QDateTime::FormatDisplayDate);
			else
				return null;
		}

		public function dtgRaceResults_RaceObject_Render(RaceResults $objRaceResults) {
			if (!is_null($objRaceResults->RaceObject))
				return $objRaceResults->RaceObject->__toString();
			else
				return null;
		}


		protected function dtgRaceResults_Bind() {
			// Because we want to enable pagination AND sorting, we need to setup the $objClauses array to send to LoadAll()

			// Remember!  We need to first set the TotalItemCount, which will affect the calcuation of LimitClause below
			$this->dtgRaceResults->TotalItemCount = RaceResults::CountAll();

			// Setup the $objClauses Array
			$objClauses = array();

			// If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
			// the OrderByClause to the $objClauses array
			if ($objClause = $this->dtgRaceResults->OrderByClause)
				array_push($objClauses, $objClause);

			// Add the LimitClause information, as well
			if ($objClause = $this->dtgRaceResults->LimitClause)
				array_push($objClauses, $objClause);

			// Set the DataSource to be the array of all RaceResults objects, given the clauses above
			$this->dtgRaceResults->DataSource = RaceResults::LoadAll($objClauses);
		}
	}
?>