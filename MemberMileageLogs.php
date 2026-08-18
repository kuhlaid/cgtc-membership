<?php
/**
 * Jan. 1, 2021 - wpg
 * - corrected the year selection list default 
 * 
 * Dec. 12, 2020 - wpg
 * - adding runner place to leader board and year selection list
 * 
 * March 18, 2020 - wpg
 * - paginating the mileage logs to reduce page size
 * 
 * Dec. 11, 2019 - wpg
 * - adding yearly mileage chart
 */
	require('includes/prepend.inc.php');
	require(__FORMBASE_CLASSES__ . '/MemberMileageListFormBase.class.php');
	QApplication::CheckRemoteAdmin();

	// admin access
	class acx1MemberMileageListForm extends MemberMileageListFormBase {
		protected $strOption, $yrMileageGraph, $intMemberMileage, $intPlace, $lstYear, $currentYear, $lstMember;
		protected function Form_Create() {		
			$this->strOption = QApplication::QueryString('strOption');
			if ($this->strOption=='')
				$this->strOption = 'my';
			$this->lstYear_Create();
			$this->lstMember_Create();
			if ($this->strOption!='about') $this->dtgMemberMileage_Create();
			
			else $this->dtgMemberMileageAbout_Create();
		}

		protected function lstYear_Create() {
			$strFirstYear = '';
			if ($this->strOption!='about'){
				$this->lstYear = new QListBox($this);
				if ($this->strOption == 'my')
					$this->lstYear->Name = QApplication::Translate('My logs by year');
				elseif  ($this->strOption == 'leader')
					$this->lstYear->Name = QApplication::Translate('Leaders by year');
				elseif  ($this->strOption == 'other')
					$this->lstYear->Name = QApplication::Translate('Other mileage logs by year');
				$this->lstYear->CssClass = "form-control form-control-lg";
				$this->lstYear->AddAction(new QChangeEvent(), new QServerAction('updateStuff'));
				$this->currentYear = QDateTime::Now()->toString('YYYY');
				// if ($this->strOption=='my')
				// //QQ::Equal(QQN::MemberMileage()->Year, $this->currentYear)


				// get the list of years for mileage logs entered
				$objMemberMileageArray = MemberMileage::QueryArray(QQ::All(),QQ::Clause(
					QQ::GroupBy(QQN::MemberMileage()->Year),
					QQ::Distinct(),
					QQ::OrderBy(QQN::MemberMileage()->Year,false)
					),null,array('Year'));
				if ($objMemberMileageArray) foreach ($objMemberMileageArray as $objMemberMileage) {
					if ($strFirstYear=='') $strFirstYear = $objMemberMileage->Year;
					$objListItem = new QListItem($objMemberMileage->Year, $objMemberMileage->Year);
					if ($this->currentYear == $objMemberMileage->Year) $objListItem->Selected = true;
					$this->lstYear->AddItem($objListItem);
				}

				if ($this->lstYear->SelectedValue == '') $this->currentYear = $strFirstYear;
				//error_log($this->lstYear->SelectedValue);
			}
			else $this->lstYear = new QPlain($this);
		}

		protected function lstMember_Create() {
			if ($this->strOption=='other'){
				$this->lstMember = new QListBox($this);
				$this->lstMember->Name = QApplication::Translate('Logs by member');
				$this->lstMember->CssClass = "form-control form-control-lg";
				$this->lstMember->AddAction(new QChangeEvent(), new QServerAction('updateStuff'));
				$this->lstMember->AddItem(QApplication::Translate('- All -'), null);
				// get the list of members for mileage logs entered
				$objMemberArray = MemberContact::QueryArray(QQ::OrCondition(
					QQ::Equal(QQN::MemberContact()->NotActive, 0),
					QQ::IsNull(QQN::MemberContact()->NotActive)
					)		
					,QQ::Clause(
					QQ::OrderBy(QQN::MemberContact()->LastName,QQN::MemberContact()->FirstName)
					),null,array('FirstName','LastName','Id'));
				if ($objMemberArray) foreach ($objMemberArray as $objMember) {
					$objListItem = new QListItem($objMember->__toString(), $objMember->Id);
					$this->lstMember->AddItem($objListItem);
				}
			}
			else $this->lstMember = new QPlain($this);
		}

		protected function dtgMemberMileage_Create(){
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgMemberMileage_EditLinkColumn_Render($_ITEM) ?>');
			$this->colEditLinkColumn->HtmlEntities = false;
			$this->colMemberId = new QDataGridColumn(QApplication::Translate('Member'), '<?= $_FORM->dtgMemberMileage_MemberIdObject_Render($_ITEM); ?>');
			$this->colMiles = new QDataGridColumn(QApplication::Translate('Miles'), '<?=$_FORM->dtgMemberMileage_Miles_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberMileage()->Miles), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberMileage()->Miles, false)));
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
			$this->dtgMemberMileage->CssClass='table table-bordered';

			if ($this->strOption == 'leader') {
				$this->dtgMemberMileage->SortColumnIndex = 3;
			$this->dtgMemberMileage->SortDirection = 1;
				$this->dtgMemberMileage->NounPlural = "members";
			}
			else {
				$this->dtgMemberMileage->SortColumnIndex = 2;
				$this->dtgMemberMileage->SortDirection = 1;
				$this->dtgMemberMileage->NounPlural = "entries";
			}

			// Datagrid Paginator
			$this->dtgMemberMileage->Paginator = new QPaginator($this->dtgMemberMileage);
			$this->dtgMemberMileage->ItemsPerPage = __ITEMS_PER_PAGE__;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgMemberMileage->UseAjax = true;

			// Specify the local databind method this datagrid will use
			$this->dtgMemberMileage->SetDataBinder('dtgMemberMileage_Bind');

			$this->showColumns();
			$this->yrMileageGraph_Create();
		}

		protected function dtgMemberMileageAbout_Create(){
			$this->dtgMemberMileage = new QPlain($this);
			$this->dtgMemberMileage->Text = $_ENV['MEMBER_MILEAGE_MESSAGE'];
			$this->yrMileageGraph_Create();
		}

		public function dtgMemberMileage_MemberIdObject_Render(MemberMileage $objMemberMileage) {
			$strReturn = '';
			if (!is_null($objMemberMileage->MemberIdObject)) {
				if ($this->strOption=='leader') {
					$strReturn = $this->intPlace.". ";
					$this->intPlace++;
				}
				return $strReturn.$objMemberMileage->MemberIdObject->__toString()." (".$objMemberMileage->MemberIdObject->__age().")";
			}
			else
				return null;
		}
		
		protected function yrMileageGraph_Create(){
			$this->yrMileageGraph = new QPlain($this);
		}

		public function dtgMemberMileage_EditLinkColumn_Render(MemberMileage $objMemberMileage) {
			return sprintf('<a href="MemberMileageLog.php?intId=%s">%s</a>',
				$objMemberMileage->Id, 
				QApplication::Translate('Edit'));
		}

		public function dtgMemberMileage_Miles_Render(MemberMileage $objMemberMileage) {
			if ($this->strOption=='leader')
				return number_format($objMemberMileage->GetVirtualAttribute('Miles'),2);
			return $objMemberMileage->Miles;
		}

		protected function showColumns(){
			$this->dtgMemberMileage->AddColumn($this->colEditLinkColumn);
			$this->dtgMemberMileage->AddColumn($this->colMemberId);
			$this->dtgMemberMileage->AddColumn($this->colLoggedOn);
			$this->dtgMemberMileage->AddColumn($this->colMiles);
			
			$this->dtgMemberMileage->AddColumn($this->colNotes);
			$this->dtgMemberMileage->AddColumn($this->colYear);
		}

		protected function dtgMemberMileage_Bind() {
			$this->intPlace=1;
			$objClauses = array();
			$strAndCondition = '';
			// if we are only concerned with the current logged in member then query their logs
			// else we query everyone's logs
			// 
			
			if ($this->lstYear->SelectedValue != '') $this->currentYear = $this->lstYear->SelectedValue;
			//error_log($this->currentYear);

			if ($this->strOption=='my')
				$strAndCondition = "
				QQ::AndCondition(
					QQ::Equal(QQN::MemberMileage()->MemberId, ".QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__')."),
					QQ::Equal(QQN::MemberMileage()->Year, $this->currentYear)
				)";
			else if ($this->strOption=='other') {
				$strAndCondition = "
				QQ::AndCondition(
					QQ::NotEqual(QQN::MemberMileage()->MemberId, ".QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__')."),
					QQ::Equal(QQN::MemberMileage()->Year, $this->currentYear)
				)";
				if ($this->lstMember->SelectedValue != '') {
					if ($strAndCondition != '') $strAndCondition .= ',';
					$mId = $this->lstMember->SelectedValue;
					$strAndCondition .= "QQ::Equal(QQN::MemberMileage()->MemberId, \$mId)";
				}
			}
			else{
				$objDatabase = MemberMileage::GetDatabase();
					
				// Setup the SQL Query for the leader board
				$strQuery = sprintf('
				SELECT `MemberMileage`.`MemberId` AS `MemberId`, SUM(`MemberMileage`.`Miles`) AS `__Miles` FROM `MemberMileage` AS `MemberMileage` 
				WHERE `MemberMileage`.`Year` = %s 
				GROUP BY `MemberMileage`.`MemberId` 
				ORDER BY SUM(`MemberMileage`.`Miles`) DESC ',
				$this->currentYear);
				
				// Perform the Query and Instantiate the Result
				$objDbResult = $objDatabase->Query($strQuery);
				$objMemberMileageArray = MemberMileage::InstantiateDbResult($objDbResult);

			}
			if ($strAndCondition != '')
				$strAndCondition = "QQ::AndCondition(".$strAndCondition.")";
			else
				$strAndCondition = "QQ::All()";
			//print_r($strAndCondition);
			// do not show pagination for the leader board
			if ($this->strOption!='leader') {
				$this->dtgMemberMileage->TotalItemCount = MemberMileage::QueryCount(eval("return $strAndCondition;"));
			}

			// // If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
			// // the OrderByClause to the $objClauses array
			if ($objClause = $this->dtgMemberMileage->OrderByClause)
				array_push($objClauses, $objClause);

			// // Add the LimitClause information, as well
			if ($objClause = $this->dtgMemberMileage->LimitClause)
				array_push($objClauses, $objClause);

			// Set the DataSource to the leader board or other
			if ($this->strOption=='leader')
				$this->dtgMemberMileage->DataSource = $objMemberMileageArray;	//MemberMileage::QueryArray(eval("return $strAndCondition;"),$objClauses,array(),array('MemberId'));
			else
				$this->dtgMemberMileage->DataSource = MemberMileage::QueryArray(eval("return $strAndCondition;"),$objClauses);
		}
		// protected function dtgMemberMileage_Bind() {
		// 	$this->intPlace=1;
		// 	$objClauses = array();
		// 	// if we are only concerned with the current logged in member then query their logs
		// 	// else we query everyone's logs
		// 	// 
		// 	if ($this->lstYear->SelectedValue != '') $this->currentYear = $this->lstYear->SelectedValue;
		// 	//error_log($this->currentYear);
		// 	if ($this->strOption=='my')
		// 		$strAndCondition = "
		// 		QQ::AndCondition(
		// 			QQ::Equal(QQN::MemberMileage()->MemberId, ".QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__')."),
		// 			QQ::Equal(QQN::MemberMileage()->Year, $this->currentYear)
		// 		)";
		// 	else if ($this->strOption=='other')
		// 		$strAndCondition = "
		// 		QQ::AndCondition(
		// 			QQ::NotEqual(QQN::MemberMileage()->MemberId, ".QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__')."),
		// 			QQ::Equal(QQN::MemberMileage()->Year, $this->currentYear)
		// 		)";
		// 	else{
		// 		$objDatabase = MemberMileage::GetDatabase();
		// 		// Setup the SQL Query for the leader board
		// 		$strQuery = sprintf('
		// 		SELECT `MemberMileage`.`MemberId` AS `MemberId`, SUM(`MemberMileage`.`Miles`) AS `__Miles` FROM `MemberMileage` AS `MemberMileage` 
		// 		WHERE `MemberMileage`.`Year` = %s 
		// 		GROUP BY `MemberMileage`.`MemberId` 
		// 		ORDER BY SUM(`MemberMileage`.`Miles`) DESC ',
		// 		$this->currentYear);
		// 		// Perform the Query and Instantiate the Result
		// 		$objDbResult = $objDatabase->Query($strQuery);
		// 		$objMemberMileageArray = MemberMileage::InstantiateDbResult($objDbResult);
		// 		//
		// 		// $strAndCondition = "QQ::Equal(QQN::MemberMileage()->Year, $this->currentYear)";
		// 		// array_push($objClauses, QQ::Sum(QQN::MemberMileage()->Miles, 'Miles'));
		// 		// array_push($objClauses, QQ::GroupBy(QQN::MemberMileage()->MemberId));
		// 	}
		// 	// if ($this->lstMember->SelectedValue != '') {
		// 	// 	if ($strAndCondition != '') $strAndCondition .= ',';
		// 	// 	$strAndCondition .= "QQ::Equal(QQN::MemberMileage()->Id, ".$this->lstMember->SelectedValue.")";
		// 	// }
		// 	// do not show pagination for the leader board
		// 	if ($this->strOption!='leader') {
		// 		$this->dtgMemberMileage->TotalItemCount = MemberMileage::QueryCount(eval("return $strAndCondition;"));
		// 	}
		// 	// // If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
		// 	// // the OrderByClause to the $objClauses array
		// 	if ($objClause = $this->dtgMemberMileage->OrderByClause)
		// 		array_push($objClauses, $objClause);
		// 	// // Add the LimitClause information, as well
		// 	if ($objClause = $this->dtgMemberMileage->LimitClause)
		// 		array_push($objClauses, $objClause);
		// 	// Set the DataSource to the leader board or other
		// 	if ($this->strOption=='leader')
		// 		$this->dtgMemberMileage->DataSource = $objMemberMileageArray;	//MemberMileage::QueryArray(eval("return $strAndCondition;"),$objClauses,array(),array('MemberId'));
		// 	else
		// 		$this->dtgMemberMileage->DataSource = MemberMileage::QueryArray(eval("return $strAndCondition;"),$objClauses);
		// }

		protected function updateStuff() {
			$this->dtgMemberMileage_Bind();
			$this->yrMileageGraph_Create();
		}
	}

	// member access
	class acx2MemberMileageListForm extends acx1MemberMileageListForm {
		
		protected function dtgMemberMileage_Create(){
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgMemberMileage_EditLinkColumn_Render($_ITEM) ?>');
			$this->colEditLinkColumn->HtmlEntities = false;
			$this->colMemberId = new QDataGridColumn(QApplication::Translate('Member'), '<?= $_FORM->dtgMemberMileage_MemberIdObject_Render($_ITEM); ?>');
			$this->colMiles = new QDataGridColumn(QApplication::Translate('Miles'), '<?=$_FORM->dtgMemberMileage_Miles_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberMileage()->Miles), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberMileage()->Miles, false)));
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
			$this->dtgMemberMileage->CssClass='table table-bordered';

			

			if ($this->strOption == 'leader') {
				$this->dtgMemberMileage->SortColumnIndex = 1;
				$this->dtgMemberMileage->SortDirection = 1;
				$this->dtgMemberMileage->NounPlural = "members";
			}
			else {
				$this->dtgMemberMileage->SortColumnIndex = 1;
				$this->dtgMemberMileage->SortDirection = 1;
				$this->dtgMemberMileage->NounPlural = "entries";
			}

			// Datagrid Paginator
			$this->dtgMemberMileage->Paginator = new QPaginator($this->dtgMemberMileage);
			$this->dtgMemberMileage->ItemsPerPage = __ITEMS_PER_PAGE__;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgMemberMileage->UseAjax = true;

			// Specify the local databind method this datagrid will use
			$this->dtgMemberMileage->SetDataBinder('dtgMemberMileage_Bind');

			$this->showColumns();
			$this->yrMileageGraph_Create();
		}
		protected function dtgMemberMileage_Bind() {
			$this->intPlace=1;
			$objClauses = array();
			// if we are only concerned with the current logged in member then query their logs
			// else we query everyone's logs
			// 
			
			if ($this->lstYear->SelectedValue != '') $this->currentYear = $this->lstYear->SelectedValue;
			//error_log($this->currentYear);

			if ($this->strOption=='my')
				$strAndCondition = "
				QQ::AndCondition(
					QQ::Equal(QQN::MemberMileage()->MemberId, ".QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__')."),
					QQ::Equal(QQN::MemberMileage()->Year, $this->currentYear)
				)";
			else if ($this->strOption=='other') {
				$strAndCondition = "
				QQ::AndCondition(
					QQ::NotEqual(QQN::MemberMileage()->MemberId, ".QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__')."),
					QQ::Equal(QQN::MemberMileage()->Year, $this->currentYear)
				)";

				if ($this->lstMember->SelectedValue != '') {
					if ($strAndCondition != '') $strAndCondition .= ',';
					$mId = $this->lstMember->SelectedValue;
					$strAndCondition .= "QQ::Equal(QQN::MemberMileage()->MemberId, \$mId)";
				}
			}
			else{
				$objDatabase = MemberMileage::GetDatabase();
					
				// Setup the SQL Query for the leader board
				$strQuery = sprintf('
				SELECT `MemberMileage`.`MemberId` AS `MemberId`, SUM(`MemberMileage`.`Miles`) AS `__Miles` FROM `MemberMileage` AS `MemberMileage` 
				WHERE `MemberMileage`.`Year` = %s 
				GROUP BY `MemberMileage`.`MemberId` 
				ORDER BY SUM(`MemberMileage`.`Miles`) DESC ',
				$this->currentYear);
				
				// Perform the Query and Instantiate the Result
				$objDbResult = $objDatabase->Query($strQuery);
				$objMemberMileageArray = MemberMileage::InstantiateDbResult($objDbResult);
				//

				// $strAndCondition = "QQ::Equal(QQN::MemberMileage()->Year, $this->currentYear)";
				// array_push($objClauses, QQ::Sum(QQN::MemberMileage()->Miles, 'Miles'));
				// array_push($objClauses, QQ::GroupBy(QQN::MemberMileage()->MemberId));
			}
			if ($strAndCondition != '')
				$strAndCondition = "QQ::AndCondition(".$strAndCondition.")";
			else
				$strAndCondition = "QQ::All()";
			//print_r($strAndCondition);
			// do not show pagination for the leader board
			if ($this->strOption!='leader') {
				$this->dtgMemberMileage->TotalItemCount = MemberMileage::QueryCount(eval("return $strAndCondition;"));
			}

			// // If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
			// // the OrderByClause to the $objClauses array
			if ($objClause = $this->dtgMemberMileage->OrderByClause)
				array_push($objClauses, $objClause);

			// // Add the LimitClause information, as well
			if ($objClause = $this->dtgMemberMileage->LimitClause)
				array_push($objClauses, $objClause);


// print_r($strAndCondition);

			// Set the DataSource to the leader board or other
			if ($this->strOption=='leader')
				$this->dtgMemberMileage->DataSource = $objMemberMileageArray;	//MemberMileage::QueryArray(eval("return $strAndCondition;"),$objClauses,array(),array('MemberId'));
			else
				$this->dtgMemberMileage->DataSource = MemberMileage::QueryArray(eval("return $strAndCondition;"),$objClauses);
		}

		// setup the mileage graph for the year
		protected function yrMileageGraph_Create(){
			parent::yrMileageGraph_Create();
			// get this year
			//$this->currentYear = QDateTime::Now()->toString('YYYY');
			$this->intMemberMileage = 0;
			// get member mileage summary
			if ($this->strOption == 'my') {
				// get the mileage for the year
				$va = MemberMileage::QuerySingle(
					QQ::AndCondition(
						QQ::Equal(QQN::MemberMileage()->MemberId, QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__')),
						QQ::Equal(QQN::MemberMileage()->Year, $this->currentYear)
					), array(QQ::Sum(QQN::MemberMileage()->Miles, 'miles')), array(), array('MemberId')
				);
				if ($va instanceof MemberMileage) {
					$this->intMemberMileage = $va->GetVirtualAttribute('miles');
				} 

				if ($this->intMemberMileage > 0)
				$this->yrMileageGraph->Text = '<div id="barchart_miles" style="width: 700px; height: 200px;"></div>';
			}
		}

		protected function showColumns(){
			// show edit link on my mileage
			if ($this->strOption=='my')
				$this->dtgMemberMileage->AddColumn($this->colEditLinkColumn);
			else 
				$this->dtgMemberMileage->AddColumn($this->colMemberId);

			if ($this->strOption!='leader') {
				$this->dtgMemberMileage->AddColumn($this->colLoggedOn);
			}
			$this->dtgMemberMileage->AddColumn($this->colMiles);

			if ($this->strOption!='leader') {
				$this->dtgMemberMileage->AddColumn($this->colNotes);
				$this->dtgMemberMileage->AddColumn($this->colYear);
			}
		}
	}
	ACL_Run('MemberMileageLogs');
?>