<?php
	/**
	 * This is the abstract Form class for the List All functionality
	 * of the Race class.  This code-generated class
	 * contains a Qform datagrid to display an HTML page that can
	 * list a collection of Race objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this RaceListFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class RaceListFormBase extends QForm {
		protected $dtgRace;

		// DataGrid Columns
		protected $colEditLinkColumn;
		protected $colId;
		protected $colName;
		protected $colDistance;
		protected $colDistanceUnit;
		protected $colWebsite;
		protected $colRaceLocation;


		protected function Form_Create() {
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgRace_EditLinkColumn_Render($_ITEM) ?>');
			$this->colEditLinkColumn->HtmlEntities = false;
			$this->colId = new QDataGridColumn(QApplication::Translate('Id'), '<?= $_ITEM->Id; ?>', array('OrderByClause' => QQ::OrderBy(QQN::Race()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Race()->Id, false)));
			$this->colName = new QDataGridColumn(QApplication::Translate('Name'), '<?= QString::Truncate($_ITEM->Name, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::Race()->Name), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Race()->Name, false)));
			$this->colDistance = new QDataGridColumn(QApplication::Translate('Distance'), '<?= $_ITEM->Distance; ?>', array('OrderByClause' => QQ::OrderBy(QQN::Race()->Distance), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Race()->Distance, false)));
			$this->colDistanceUnit = new QDataGridColumn(QApplication::Translate('Distance Unit'), '<?= $_ITEM->DistanceUnit; ?>', array('OrderByClause' => QQ::OrderBy(QQN::Race()->DistanceUnit), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Race()->DistanceUnit, false)));
			$this->colWebsite = new QDataGridColumn(QApplication::Translate('Website'), '<?= QString::Truncate($_ITEM->Website, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::Race()->Website), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Race()->Website, false)));
			$this->colRaceLocation = new QDataGridColumn(QApplication::Translate('Race Location'), '<?= QString::Truncate($_ITEM->RaceLocation, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::Race()->RaceLocation), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Race()->RaceLocation, false)));

			// Setup DataGrid
			$this->dtgRace = new QDataGrid($this);
			$this->dtgRace->CellSpacing = 0;
			$this->dtgRace->CellPadding = 4;
			$this->dtgRace->BorderStyle = QBorderStyle::Solid;
			$this->dtgRace->BorderWidth = 1;
			$this->dtgRace->GridLines = QGridLines::Both;

			// Datagrid Paginator
			$this->dtgRace->Paginator = new QPaginator($this->dtgRace);
			$this->dtgRace->ItemsPerPage = 10;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgRace->UseAjax = false;

			// Specify the local databind method this datagrid will use
			$this->dtgRace->SetDataBinder('dtgRace_Bind');

			$this->dtgRace->AddColumn($this->colEditLinkColumn);
			$this->dtgRace->AddColumn($this->colId);
			$this->dtgRace->AddColumn($this->colName);
			$this->dtgRace->AddColumn($this->colDistance);
			$this->dtgRace->AddColumn($this->colDistanceUnit);
			$this->dtgRace->AddColumn($this->colWebsite);
			$this->dtgRace->AddColumn($this->colRaceLocation);
		}
		
		public function dtgRace_EditLinkColumn_Render(Race $objRace) {
			return sprintf('<a href="race_edit.php?intId=%s">%s</a>',
				$objRace->Id, 
				QApplication::Translate('Edit'));
		}


		protected function dtgRace_Bind() {
			// Because we want to enable pagination AND sorting, we need to setup the $objClauses array to send to LoadAll()

			// Remember!  We need to first set the TotalItemCount, which will affect the calcuation of LimitClause below
			$this->dtgRace->TotalItemCount = Race::CountAll();

			// Setup the $objClauses Array
			$objClauses = array();

			// If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
			// the OrderByClause to the $objClauses array
			if ($objClause = $this->dtgRace->OrderByClause)
				array_push($objClauses, $objClause);

			// Add the LimitClause information, as well
			if ($objClause = $this->dtgRace->LimitClause)
				array_push($objClauses, $objClause);

			// Set the DataSource to be the array of all Race objects, given the clauses above
			$this->dtgRace->DataSource = Race::LoadAll($objClauses);
		}
	}
?>