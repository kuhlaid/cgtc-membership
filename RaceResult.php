<?php
/**
 * @abstract Race result edit form
 * @author w. Patrick Gale
 * @todo
 * - need to find out if there is an easy way to convert PDF text files to plain text and not lose too much of the formatting
 * - use Excel to create 'fixed width' data from tab or comma delimited data (can use this online tool maybe http://www.convertcsv.com/csv-to-flat-file.htm)
 *
 * Jan. 15, 2020 - wpg
 * - hiding elements based on race dates and edit mode
 * - adding link to edit the results
 * 
 * Jan. 14, 2020 - wpg
 * - revising the form styling and updating the functionality
 * 
 * May 21, 2017 - wpg
 * - setting up basic Race form
 */

	require('includes/prepend.inc.php');
	require(__FORMBASE_CLASSES__ . '/RaceResultsEditFormBase.class.php');
	QApplication::CheckRemoteAdmin();


	class acx1RaceResultsEditForm extends RaceResultsEditFormBase {
		protected $intRaceId, $strOption, $btnPart;
		protected function SetupRaceResults() {
			// Lookup Object PK information from Query String (if applicable)
			// Set mode to Edit or New depending on what's found
			$intId = QApplication::QueryString('intId');
			$this->strOption = QApplication::QueryString('strOption');
			$this->intRaceId = QApplication::QueryString('intRaceId');
			
			if (($intId)) {
				$this->objRaceResults = RaceResults::Load(($intId));
				// if no race result found
				if (!$this->objRaceResults) {
					QSessionDB::set('error', 'Could not find the Race Result');
					QApplication::Redirect('Races.php');
				}

				$this->strTitleVerb = QApplication::Translate('Edit');
			} else {
				$this->objRaceResults = new RaceResults();
				$this->strTitleVerb = QApplication::Translate('Create');
				
			}
			if ($this->strOption=='edit') $this->blnEditMode = true;
			else $this->blnEditMode = false;
		}

		// hide some elements if the race date is in the future
		protected function calRaceDate_Change(){
			if ($this->calRaceDate->DateTime != '' && $this->calRaceDate->DateTime >= QDateTime::Now())  {
				$this->txtPlacement->Visible = false;
				$this->txtHeaderLine->Visible = false;
			}
		}

		protected function calRaceDate_Create() {
			if ($this->strOption=='edit') {
				$this->calRaceDate = new QJsCalendar($this);
				$this->calRaceDate->Name = QApplication::Translate('Race Date: ');
				$this->calRaceDate->DateTime = $this->objRaceResults->RaceDate;
				$this->calRaceDate->Required = true;
				$this->calRaceDate->AddAction(new QChangeEvent(), new QAjaxAction('calRaceDate_Change'));
			}
			else {
				//
				// pull race dates starting with the most recent
				$objRaceResultsArray = RaceResults::QueryArray(
					QQ::Equal(QQN::RaceResults()->Race, $this->intRaceId),
					QQ::Clause(QQ::OrderBy(QQN::RaceResults()->RaceDate,false)));
				$return = '';
				if ($objRaceResultsArray) foreach ($objRaceResultsArray as $objRaceResults){
					$active='class="breadcrumb-item"';
					// if on the active result then highlight it
					if ($objRaceResults->Id == $this->objRaceResults->Id) 
					$return .= sprintf('<li class="breadcrumb-item active" aria-current="page"><span class="font-weight-bold">%s</span> <a href="RaceResult.php?intId=%s&strOption=edit&intRaceId=%s" class="small" data-toggle="tooltip" title="Update the race results">Edit</a></li>',
							$objRaceResults->RaceDate->toString(),
							$objRaceResults->Id,
							$this->intRaceId);
					else
					$return .= sprintf('<li class="breadcrumb-item"><a href="RaceResult.php?intId=%s&strOption=view&intRaceId=%s">%s</a></li>',
							$objRaceResults->Id,
							$this->intRaceId,
							$objRaceResults->RaceDate->toString());
					
				}
				//	add race result or upcoming date
				$return .= sprintf('<li class="breadcrumb-item"><a href="RaceResult.php?strOption=edit&intRaceId=%s" data-toggle="tooltip" title="Log an additional past or upcoming race date" class="btn btn-primary small">%s</a></li>',
				$this->intRaceId,
				'Add race date/results');
				$this->calRaceDate = new QPlain($this);
				$this->calRaceDate->Text = $return;
			}
		}

		protected function txtPlacement_Create() {
			$notes = "";
			if ($this->blnEditMode) {
				$this->txtPlacement = new QTextBox($this);
				$this->txtPlacement->Text = $this->objRaceResults->Placement;
				//$this->txtPlacement->Required = true;
				$this->txtPlacement->TextMode = QTextMode::MultiLine;
				$this->txtPlacement->Rows = 20;
				$this->txtPlacement->Width = '100%';
				$this->txtPlacement->CssClass = 'ambig';
				$notes = "
			<div><b>Note:</b> There is no consistent way to convert race result PDF files to plain text and not lose too much of the 
		formatting or have a consistent plain text format (What happened to the days of simple text file race results?).  
		You may use Excel to create [Fixed Width .prn] formatted data from tab or comma delimited data to paste in the results field below 
		(see this online tool which is simple to use 
		<a href='http://www.convertcsv.com/csv-to-flat-file.htm' target='_blank'>http://www.convertcsv.com/csv-to-flat-file.htm</a>)</div>";
				$this->btnPart = new QPlain($this);
			}
			else {
					$this->txtPlacement = new QLabel($this);
					$this->txtPlacement->HtmlEntities = false;
					// if the race date is today or in the past then show the results list
					if ($this->calRaceDate->Text <= QDateTime::Now() && trim($this->objRaceResults->Placement ?? '') != '')
						$this->txtPlacement->Text = $this->objRaceResults->Placement."<hr/><h2>".$_ENV['POTENTIONAL_MEMBER_PARTICIPATION']."</h2>";
					// get the list of members
					$objMemberContactArray = MemberContact::QueryArray(QQ::All(), array(),array(),array('Id','FirstName','LastName','BirthMonth','BirthDay','BirthYear'));

					// check to see if any members are linked to this race
					$objMemberRaceResultArray = MemberRaceResult::QueryArray(QQ::Equal(QQN::MemberRaceResult()->RaceResultId, $this->objRaceResults->Id), array(),array(),array('MemberContactId'));
					$mrrArray = array();
					if ($objMemberRaceResultArray) foreach($objMemberRaceResultArray as $objMemberRaceResult) {
						$mrrArray[$objMemberRaceResult->MemberContactId]=true;
					}

					$rows = '';
					$rowCount=1;
					$delimiter = "\r\n";
					$strParticipantArray = explode($delimiter, trim($this->objRaceResults->Placement ?? ''));
					if ($strParticipantArray) {
						foreach ($strParticipantArray as $strParticipant) {
							// if header row then print
							if ($rowCount == $this->objRaceResults->HeaderLine) $this->txtPlacement->Text .= $strParticipant."\r\n";
							// look at stuff after the header
							if ($rowCount > $this->objRaceResults->HeaderLine) {
								foreach ($objMemberContactArray as $objMemberContact) {
									// see if a member appears in the results row and if so print it
									if (stripos($strParticipant, $objMemberContact->LastName) !== false && stripos($strParticipant, $objMemberContact->FirstName) !== false && !array_key_exists($objMemberContact->Id,$mrrArray)) {
										$this->txtPlacement->Text .= $strParticipant." --> Is this member ".$objMemberContact->__toString()." (".$objMemberContact->__age().")\r\n";
									}
			// 						elseif (stripos($strParticipant, $objMemberContact->LastName) !== false) {
			// 							$this->txtPlacement->Text .= "<span class='hghLight'>".$strParticipant." (Is this ".$objMemberContact->__toString()." with member ID=".$objMemberContact->Id.")\r\n"."</span>";
			// 						}
								}
							}
							$rowCount++;
						}
					}

					$this->txtPlacement->Text .= "<hr/><h2>Member Participation</h2>";
					$blnMyParticipation = false;
					foreach ($objMemberContactArray as $objMemberContact) {
						if (array_key_exists($objMemberContact->Id,$mrrArray)) {
							if ($objMemberContact->Id == QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__')) $blnMyParticipation=true;
							$this->txtPlacement->Text .= '<span class="badge badge-success badge-pill p-2" data-toggle="tooltip" title="'.$objMemberContact->__toString().' is a participant in this race">'.$objMemberContact->__toString()." (".$objMemberContact->__age().")</span>\r\n";
						}
					}
					
					// if we need are already marked as a participant then do nothing
					// else show a button to add us
					if ($blnMyParticipation) {
						$this->btnPart = new QPlain($this);
					}
					else {
						$this->btnPart = new QLinkButton($this);
						$this->btnPart->Text = "I am a participant";
						$this->btnPart->HtmlEntities = false;
						$this->btnPart->CausesValidation = false;
						$this->btnPart->CssClass = "btn btn-primary";
						// Let's assign a server action on click
						$this->btnPart->AddAction(new QClickEvent(), new QServerAction('btnPart_Click'));
					}
					
				//}
				$this->txtPlacement->HtmlBefore = $notes.'<div class="card m-2">
					<div class=" card-header">Results & Participation</div>
					<div class="card-body">
					<div class="card-text"><pre>';
				$this->txtPlacement->HtmlAfter = "</pre></div></div></div>";
				$this->txtPlacement->CssClass = 'ambig';
				//$this->txtPlacement->Text = $this->objRaceResults->Placement;
			}
			
		
		}

		// races list
		protected function lstRaceObject_Create() {
			if (!$this->blnEditMode) {
				$this->lstRaceObject = new QLabel($this);
				$this->lstRaceObject->Text = $this->objRaceResults->RaceObject->__toString();
			}
			else {
				$this->lstRaceObject = new QListBox($this);
				$this->lstRaceObject->Required = true;
				// if (!$this->blnEditMode)
				// 	$this->lstRaceObject->AddItem(QApplication::Translate('- Select One -'), null);
				$objRaceObjectArray = Race::LoadAll();
				if ($objRaceObjectArray) foreach ($objRaceObjectArray as $objRaceObject) {
					$objListItem = new QListItem($objRaceObject->__toString(), $objRaceObject->Id);
					if (($this->objRaceResults->RaceObject) && ($this->objRaceResults->RaceObject->Id == $objRaceObject->Id))
						$objListItem->Selected = true;
					elseif (($this->intRaceId != '') && ($this->intRaceId == $objRaceObject->Id))
						$objListItem->Selected = true;
					$this->lstRaceObject->AddItem($objListItem);
				}
			}
		}

		protected function RedirectToListPage() {
			QApplication::Redirect('RaceResult.php?intId='.$this->objRaceResults->Id.'&strOption=view&intRaceId='.$this->intRaceId);
		}

		protected function txtHeaderLine_Create() {
			if (!$this->blnEditMode) {
				$this->txtHeaderLine = new QPlain($this);
			}
			else {
				$this->txtHeaderLine = new QIntegerTextBox($this);
				$this->txtHeaderLine->Name = QApplication::Translate('Header line #: ');
				$this->txtHeaderLine->Text = $this->objRaceResults->HeaderLine;
				$this->txtHeaderLine->HtmlAfter = " (enter row number in the results that coorespond to the 'Name' and 'Time' titles; the first line in the results starts at 1)";
				$this->txtHeaderLine->Width = "50px";
			}
		}

		protected function btnSave_Create() {
			if ($this->blnEditMode) {
			$this->btnSave = new QButton($this);
			$this->btnSave->Text = QApplication::Translate('Save');
			$this->btnSave->AddAction(new QClickEvent(), new QServerAction('btnSave_Click'));
			$this->btnSave->PrimaryButton = true;
			$this->btnSave->CausesValidation = true;
			}
			else $this->btnSave = new QPlain($this);
		}

		// Setup btnCancel
		protected function btnCancel_Create() {
			if ($this->blnEditMode) {
			$this->btnCancel = new QButton($this);
			$this->btnCancel->Text = QApplication::Translate('Cancel');
			$this->btnCancel->AddAction(new QClickEvent(), new QServerAction('btnCancel_Click'));
			$this->btnCancel->CausesValidation = false;
			}
			else $this->btnCancel = new QPlain($this);
		}

		protected function btnPart_Click($strFormId, $strControlId, $strParameter) {
			$objMemberRaceResult  = new MemberRaceResult();
			$objMemberRaceResult->RaceResultId = $this->objRaceResults->Id;
			$objMemberRaceResult->MemberContactId = QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__');
			$objMemberRaceResult->Save();
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {

			$this->objRaceResults->Delete();

			QApplication::Redirect('Races.php');
		}
			
	}
	class acx1RaceResultsViewForm extends acx1RaceResultsEditForm {}

	//// member access
	class acx2RaceResultsEditForm extends acx1RaceResultsEditForm {}
	class acx2RaceResultsViewForm extends acx2RaceResultsEditForm {}


	// go to the centralized form executing access control function to run the form and check access control
	$strOption = QApplication::QueryString('strOption');
	if ($strOption=='edit')
		ACL_Run('RaceResult.edit');
	elseif ($strOption=='view')
		ACL_Run('RaceResult.view');
?>