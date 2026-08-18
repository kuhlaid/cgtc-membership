<?php
/**
 * @abstract Tracks the races members of the club participate in.
 * @author w. Patrick Gale
 *
 * Jan. 14, 2020 - wpg
 * - consolidating the columns to clean up the interface and beginning to add filters
 * - added a distance filter and tabs
 * 
 * Nov. 8, 2017 - wpg
 * - adding race dates to the races list
 *
 * May 21, 2017 - wpg
 * - setting up basic Races list
 */
	require('includes/prepend.inc.php');
	require(__FORMBASE_CLASSES__ . '/RaceListFormBase.class.php');
	QApplication::CheckRemoteAdmin();


	class acx1RaceListForm extends RaceListFormBase {
		protected $colResults, $lstDistanceFilter, $strOption;

		protected function Form_Create() {
			$this->strOption = QApplication::QueryString('strOption');
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgRace_EditLinkColumn_Render($_ITEM) ?>');

			$this->colId = new QDataGridColumn(QApplication::Translate('Id'), '<?= $_ITEM->Id; ?>', array('OrderByClause' => QQ::OrderBy(QQN::Race()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Race()->Id, false)));
			$this->colName = new QDataGridColumn(QApplication::Translate('Name'), '<?= $_FORM->dtgRace_WebsiteColumn_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::Race()->Name), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Race()->Name, false)));
			$this->colDistance = new QDataGridColumn(QApplication::Translate('Distance'), '<?= $_ITEM->__distanceString(); ?>', array('OrderByClause' => QQ::OrderBy(QQN::Race()->Distance), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Race()->Distance, false)));
			$this->colResults = new QDataGridColumn(QApplication::Translate('Dates/Results'), '<?= $_FORM->dtgRace_ResultsColumn_Render($_ITEM); ?>');
			$this->colWebsite = new QDataGridColumn(QApplication::Translate('Website'), '<?= $_FORM->dtgRace_WebsiteColumn_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::Race()->Website), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Race()->Website, false)));
			$this->colRaceLocation = new QDataGridColumn(QApplication::Translate('Race Start Location'), '<?= QString::Truncate($_ITEM->RaceLocation, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::Race()->RaceLocation), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Race()->RaceLocation, false)));

			$this->colResults->Wrap = false;
			$this->colName->HtmlEntities = $this->colResults->HtmlEntities = $this->colEditLinkColumn->HtmlEntities = false;

			// Setup DataGrid
			$this->dtgRace = new QDataGrid($this);
			$this->dtgRace->CellSpacing = 0;
			$this->dtgRace->CellPadding = 4;
			$this->dtgRace->BorderStyle = QBorderStyle::Solid;
			$this->dtgRace->BorderWidth = 1;
			$this->dtgRace->GridLines = QGridLines::Both;
			$this->dtgRace->CssClass='table table-bordered';

			// Datagrid Paginator
			$this->dtgRace->Paginator = new QPaginator($this->dtgRace);
			$this->dtgRace->ItemsPerPage = __ITEMS_PER_PAGE__;
			$this->dtgRace->SortColumnIndex = 1;
			$this->dtgRace->SortDirection = 0;


			// Specify Whether or Not to Refresh using Ajax
			$this->dtgRace->UseAjax = true;

			// Specify the local databind method this datagrid will use
			$this->dtgRace->SetDataBinder('dtgRace_Bind');

			//$this->dtgRace->AddColumn($this->colEditLinkColumn);
			$this->dtgRace->AddColumn($this->colName);
			$this->dtgRace->AddColumn($this->colDistance);
			$this->dtgRace->AddColumn($this->colResults);
			//$this->dtgRace->AddColumn($this->colWebsite);
			$this->dtgRace->AddColumn($this->colRaceLocation);

			$this->lstDistanceFilter_Create();
		}

		protected function lstDistanceFilter_Create() {
			$this->lstDistanceFilter = new QListBox($this);
			$this->lstDistanceFilter->Name = QApplication::Translate('Distance: ');
			$this->lstDistanceFilter->AddAction(new QChangeEvent(), new QAjaxAction('dtgRace_Bind'));

			$objDatabase = Race::GetDatabase();
			/* get the list race distances */
$strQuery1 = <<<MLS
SELECT DISTINCT(CONCAT(Distance,'::',DistanceUnit)) as DD, Distance, DistanceUnit FROM Race ORDER BY DistanceUnit,Distance 
MLS;
			$objDbResult1 = $objDatabase->Query($strQuery1);
			$this->lstDistanceFilter->AddItem(QApplication::Translate('- Filter by distance -'), null);
			if ($objDbResult1) while ($objDbRow = $objDbResult1->FetchArray()) {
				$objListItem = new QListItem($objDbRow['Distance']." ".Race::$distanceUnitArray[$objDbRow['DistanceUnit']], $objDbRow['DD']);
				// if ($this->objRace->DistanceUnit == $key)
				// 	$objListItem->Selected = true;
				$this->lstDistanceFilter->AddItem($objListItem);
			}
		}

		public function dtgRace_EditLinkColumn_Render(Race $objRace) {
			return sprintf('<a href="Race.php?intId=%s">%s</a>',
					$objRace->Id,
					QApplication::Translate('Edit'));
		}

		public function dtgRace_WebsiteColumn_Render(Race $objRace) {
			$return = '<div class="font-weight-bold">'.$objRace->Name.sprintf(' (%s) <a href="Race.php?intId=%s">%s</a>',
			$objRace->__distanceString(),
			$objRace->Id,
			QApplication::Translate('Edit')).'</div>';
			if ($objRace->Website && $objRace->Website!='')
				$return .= sprintf('<div class="small">Website: <a href="%s" target="_blank">%s</a></div>',
						$objRace->Website,
						$objRace->Website);
			return $return;
		}

		public function dtgRace_ResultsColumn_Render(Race $objRace) {
			// pull race dates starting with the most recent
			$objRaceResultsArray = RaceResults::QueryArray(
					QQ::Equal(QQN::RaceResults()->Race, $objRace->Id),
					QQ::Clause(QQ::OrderBy(QQN::RaceResults()->RaceDate,false)));
			$return = '';
			if ($objRaceResultsArray) foreach ($objRaceResultsArray as $objRaceResults){
				// check to see if any members are linked to this race
				$objMemberRaceResultArray = MemberRaceResult::QueryArray(
					QQ::Equal(QQN::MemberRaceResult()->RaceResultId, $objRaceResults->Id));
					
				$membersAssigned = 0;
				if ($objMemberRaceResultArray) $membersAssigned = count($objMemberRaceResultArray);
				$return .= sprintf('<div class="d-flex"><a href="RaceResult.php?intId=%s&strOption=view&intRaceId=%s" class="btn btn-link small p-1 m-1" ><span data-toggle="tooltip" title="Date of race and race results if they exist">%s</span> <span class="h5 border rounded-pill p-2" title="Members in this race" data-toggle="tooltip">%s %s</span></a></div>',
						$objRaceResults->Id,
						$objRace->Id,
						$objRaceResults->RaceDate->toString(),
						$membersAssigned,
						__txtC_RunningPerson__);
			}


			return $return;
		}


		protected function dtgRace_Bind() {
			$strAndCondition = "";
			
			// filter by distance
			if ($this->lstDistanceFilter->SelectedValue!='') {
				error_log($this->lstDistanceFilter->SelectedValue);
				$ddArray = explode('::',$this->lstDistanceFilter->SelectedValue);

				$strAndCondition .= "QQ::Equal(QQN::Race()->Distance, ".$ddArray[0]."),
				QQ::Equal(QQN::Race()->DistanceUnit, ".$ddArray[1].")
				";		
			}
			// upcoming race dates
			if ($this->strOption == 'upcoming' || $this->strOption == '') {
				$raceArrayId=array();
				// pull race dates starting with the most recent
				$objRaceResultsArray = RaceResults::QueryArray(QQ::GreaterThan(QQN::RaceResults()->RaceDate, QDateTime::Now()));
				if ($objRaceResultsArray) foreach ($objRaceResultsArray as $objRaceResults) array_push($raceArrayId,$objRaceResults->Race);
				if ($strAndCondition != '') $strAndCondition .= ",";
				$strAndCondition .= "QQ::In(QQN::Race()->Id, \$raceArrayId)";
			}

			if ($strAndCondition != '')
				$strAndCondition = "QQ::AndCondition(".$strAndCondition.")";
			else $strAndCondition = "QQ::All()";

			// Because we want to enable pagination AND sorting, we need to setup the $objClauses array to send to LoadAll()

			// Remember!  We need to first set the TotalItemCount, which will affect the calcuation of LimitClause below
			$this->dtgRace->TotalItemCount = Race::QueryCount(eval("return $strAndCondition;"));

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
			$this->dtgRace->DataSource = Race::QueryArray(eval("return $strAndCondition;"),$objClauses);
		}
	}

	// member access
	class acx2RaceListForm extends acx1RaceListForm {}

	// go to the centralized form executing access control function to run the form and check access control
	ACL_Run('Races');
?>