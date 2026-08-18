<?php
/**
 * @abstract List of race results
 * @author w. Patrick Gale
 *
 * May 21, 2017 - wpg
 * - setting up basic Race form
 */

	require('includes/prepend.inc.php');
	require(__FORMBASE_CLASSES__ . '/RaceResultsListFormBase.class.php');
	QApplication::CheckRemoteAdmin();

	// admin access
	class acx1RaceResultsListForm extends RaceResultsListFormBase {
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
			$this->dtgRaceResults->CssClass='table table-bordered';

			// Datagrid Paginator
			$this->dtgRaceResults->Paginator = new QPaginator($this->dtgRaceResults);
			$this->dtgRaceResults->ItemsPerPage = __ITEMS_PER_PAGE__;

			$this->dtgRaceResults->SortDirection = 1;
			$this->dtgRaceResults->SortColumnIndex = 1;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgRaceResults->UseAjax = false;

			// Specify the local databind method this datagrid will use
			$this->dtgRaceResults->SetDataBinder('dtgRaceResults_Bind');

			$this->dtgRaceResults->AddColumn($this->colEditLinkColumn);
			$this->dtgRaceResults->AddColumn($this->colRaceDate);
			//$this->dtgRaceResults->AddColumn($this->colPlacement);
			$this->dtgRaceResults->AddColumn($this->colRace);
			//$this->dtgRaceResults->AddColumn($this->colHeaderLine);
		}

		public function dtgRaceResults_EditLinkColumn_Render(RaceResults $objRaceResults) {
			return sprintf('<a href="RaceResult.php?intId=%s&strOption=edit">%s</a> | <a href="RaceResult.php?intId=%s&strOption=view">%s</a>',
					$objRaceResults->Id,
					QApplication::Translate('Edit'),
					$objRaceResults->Id,
					QApplication::Translate('View'));
		}
	}

	// member access
	class acx2RaceResultsListForm extends acx1RaceResultsListForm {}

	// go to the centralized form executing access control function to run the form and check access control
	ACL_Run('RaceResults');
?>