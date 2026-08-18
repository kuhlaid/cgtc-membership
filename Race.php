<?php
/**
 * @abstract Edit form for races members of the club participate in.
 * @author w. Patrick Gale
 *
 * Jan. 14, 2020 - wpg
 * - adding autocomplete field to the race name and updating the form styling
 * 
 * Nov. 8, 2017 - wpg
 * - adding race location and fixing issue with saving races
 *
 * May 21, 2017 - wpg
 * - setting up basic Race form
 */
	require('includes/prepend.inc.php');
	require(__FORMBASE_CLASSES__ . '/RaceEditFormBase.class.php');
	QApplication::CheckRemoteAdmin();


	class acx1RaceEditForm extends RaceEditFormBase {
		protected function txtDistance_Create() {
			$this->txtDistance = new QFloatTextBox($this);
			$this->txtDistance->Name = QApplication::Translate('Distance Number');
			$this->txtDistance->Text = $this->objRace->Distance;
			$this->txtDistance->Required = true;
		}

		protected function txtRaceLocation_Create() {
			$this->txtRaceLocation = new QTextBox($this);
			$this->txtRaceLocation->Name = QApplication::Translate('Race Start Location');
			$this->txtRaceLocation->Text = $this->objRace->RaceLocation;
			$this->txtRaceLocation->MaxLength = Race::RaceLocationMaxLength;
		}

		protected function txtDistanceUnit_Create() {
			$this->txtDistanceUnit = new QRadioButtonList($this);
			$this->txtDistanceUnit->Name = QApplication::Translate('Distance Unit');
			
			$this->txtDistanceUnit->Required = true;
			$objRaceUnitArray = Race::$distanceUnitArray;
			if ($objRaceUnitArray) foreach ($objRaceUnitArray as $key=>$value) {
				$objListItem = new QListItem($value, $key);
				if ($this->objRace->DistanceUnit == $key)
					$objListItem->Selected = true;
				$this->txtDistanceUnit->AddItem($objListItem);
			}
		}

		protected function UpdateRaceFields() {
			$this->objRace->Name = $this->txtName->Text;
			$this->objRace->Distance = $this->txtDistance->Text;
			$this->objRace->DistanceUnit = $this->txtDistanceUnit->SelectedValue;
			$this->objRace->Website = $this->txtWebsite->Text;
			$this->objRace->RaceLocation = $this->txtRaceLocation->Text;
		}

		protected function RedirectToListPage() {
			if (!$this->blnEditMode) QApplication::Redirect('RaceResult.php?strOption=edit&intRaceId='.$this->objRace->Id);
			else QApplication::Redirect('Races.php');
		}

		protected function txtName_Create() {
			$this->txtName = new QAutoCompleteTextBox($this);
			$this->txtName->Text = $this->objRace->Name;
			
			$this->txtName->Required = true;
			$this->txtName->MaxLength = Race::NameMaxLength;
			$this->txtName->CssClass = 'form-control-lg';
			$this->txtName->UseAjax = true;
			$this->txtName->MinChars = 3;
			$this->txtName->HtmlBefore = '<div class="alert alert-info">This screen is ONLY used to log the race basics, and NOT the individual dates for the race.  Once a race name has been added to our database the results, or upcoming date for the race, may be added under the races list.</div>
			<div class="h3">Name</div>';
			$this->txtName->HtmlAfter = '<div>Note: As you type, a list of race names currently saved in our database will appear below the box.  Please do not duplicate race names already saved.</div>';
			$this->txtName->AddAction(new QAutoCompleteTextBoxEvent(), new QAjaxAction('txtName_Change'));
			//$this->txtName->AddAction(new QChangeEvent(), new QAjaxAction('trimLeadingTrailing'));
		}

		// public function trimLeadingTrailing($strFormId, $strControlId, $strParameter){
		// 	// Let's see if the checkbox exists already
		// 	$objComponent = $this->GetControl($strControlId);
		// 	$objComponent->Text = trim($objComponent->Text ?? '');
		// }

		// show races that exist in the database including the keyed in characters
		public function txtName_Change($strFormId, $strControlId, $strParameter){
			// get the list of existing races
			$objRaceArray = Race::QueryArray(
					QQ::AndCondition(
							QQ::Like(QQN::Race()->Name, "%$strParameter%")
					),array(),array(),array('Name','Distance','DistanceUnit')
			);

			if ($objRaceArray) foreach($objRaceArray as $objRace) {
				print $objRace->__toString()."\n";
			}

			exit;
		}
	}

	// member access
	class acx2RaceEditForm extends acx1RaceEditForm {}

	// go to the centralized form executing access control function to run the form and check access control
	ACL_Run('Race');
?>