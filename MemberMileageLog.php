<?php
/**
 * Simple script for logging mileage for the year.
 */
	require('includes/prepend.inc.php');
	require(__FORMBASE_CLASSES__ . '/MemberMileageEditFormBase.class.php');
	QApplication::CheckRemoteAdmin();

	
	// admin access
	class acx1MemberMileageEditForm extends MemberMileageEditFormBase {
		protected $lstMember, $isFamilyMembership;
		protected function SetupMemberMileage() {
			// Lookup Object PK information from Query String (if applicable)
			// Set mode to Edit or New depending on what's found
			$intId = QApplication::QueryString('intId');
			if (($intId)) {
				$this->objMemberMileage = MemberMileage::QuerySingle(
					QQ::Equal(QQN::MemberMileage()->Id, $intId)
				);

				if (!$this->objMemberMileage){
					error_log('error accessing acx1MemberMileageEditForm for logID='.$intId.' and member '.QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__'));
					QSessionDB::set("error", "Could not find a MemberMileage log with PK arguments: " . $intId);
					QApplication::Redirect('MemberMileageLogs.php');
					exit;
				}
				$this->strTitleVerb = QApplication::Translate('Edit');
				$this->blnEditMode = true;
			} else {
				$this->objMemberMileage = new MemberMileage();
				$this->strTitleVerb = QApplication::Translate('Create');
				$this->blnEditMode = false;
			}
		}

		protected function Form_Create() {
			// Call SetupMemberMileage to either Load/Edit Existing or Create New
			$this->SetupMemberMileage();

			$this->txtMiles_Create();
			$this->calLoggedOn_Create();
			$this->txtNotes_Create();
			$this->txtYear_Create();
			$this->lstMember_Create();

			// Create/Setup Button Action controls
			$this->btnSave_Create();
			$this->btnCancel_Create();
			$this->btnDelete_Create();
		}
		protected function lstMember_Create() {
			$this->isFamilyMembership=0;
			$this->lstMember = new QListBox($this);
			$this->lstMember->Name = QApplication::Translate('Logs by member');
			$this->lstMember->CssClass = "form-control form-control-sm";
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
				if ($this->blnEditMode && $objMember->Id==$this->objMemberMileage->MemberId)
					$objListItem->Selected = true;
				$this->lstMember->AddItem($objListItem);
			}
		}

		// Create and Setup txtMiles
		protected function txtMiles_Create() {
			$this->txtMiles = new QFloatTextBox($this);
			$this->txtMiles->Name = QApplication::Translate('Miles');
			$this->txtMiles->Text = $this->objMemberMileage->Miles;
			$this->txtMiles->Required = true;
		}

		// Create and Setup calLoggedOn
		protected function calLoggedOn_Create() {
			$this->calLoggedOn = new QJsCalendar($this);
			$this->calLoggedOn->Name = QApplication::Translate('Logged On');
			if ($this->blnEditMode)
				$this->calLoggedOn->DateTime = $this->objMemberMileage->LoggedOn;
			else $this->calLoggedOn->DateTime = QDateTime::Now();
			$this->calLoggedOn->Required = true;
		}

		// Create and Setup txtNotes
		protected function txtNotes_Create() {
			$this->txtNotes = new QTextBox($this);
			$this->txtNotes->Name = QApplication::Translate('Notes (500 character limit)');
			$this->txtNotes->Text = $this->objMemberMileage->Notes;
			$this->txtNotes->CssClass = "form-control form-control-sm";
			$this->txtNotes->MaxLength = MemberMileage::NotesMaxLength;
		}

		// Create and Setup txtYear
		protected function txtYear_Create() {
			$this->txtYear = new QIntegerTextBox($this);
			$this->txtYear->Name = QApplication::Translate('Year');
			if ($this->blnEditMode)
				$this->txtYear->Text = $this->objMemberMileage->Year;
			else $this->txtYear->Text = QDateTime::Now(true)->toString('YYYY');
			$this->txtYear->Required = true;
			//$this->txtYear->Required = true;
		}

		

		// Protected Update Methods
		protected function UpdateMemberMileageFields() {
			// log a notification if an admin updates another member mileage log
			if ($this->blnEditMode && QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__') != $this->lstMember->SelectedValue) {
				//wpg - save the login to the database
				$newNotification = new NotificationLog();
				$newNotification->MemberId = QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__');
				$newNotification->NotificationBody = '{"MemberId":"'.$this->objMemberMileage->MemberId.'", "Miles":"'.$this->objMemberMileage->Miles.'", "Year":"'.$this->objMemberMileage->Year.'"}';
				$newNotification->NotificationSubject = 'Updated mileage log: '.$this->objMemberMileage->Id;
				$newNotification->NotificationType=10;
				$newNotification->NotificationDate = QDateTime::Now(true);
				$newNotification->Save();
			}
			$this->objMemberMileage->MemberId = $this->lstMember->SelectedValue;
			$this->objMemberMileage->Miles = trim($this->txtMiles->Text ?? '');
			$this->objMemberMileage->LoggedOn = $this->calLoggedOn->DateTime;
			$this->objMemberMileage->Notes = trim($this->txtNotes->Text ?? '');
			$this->objMemberMileage->Year = trim($this->txtYear->Text ?? '');
		}

		protected function RedirectToListPage() {
			QApplication::Redirect('MemberMileageLogs.php');
		}
	}

	// member access
	class acx2MemberMileageEditForm extends acx1MemberMileageEditForm {
		protected function SetupMemberMileage() {
			// only allow members to update their own mileage logs
			$intId = QApplication::QueryString('intId');
			if (($intId)) {
				$this->objMemberMileage = MemberMileage::QuerySingle(
					QQ::AndCondition(
						QQ::Equal(QQN::MemberMileage()->Id, $intId),
						QQ::Equal(QQN::MemberMileage()->MemberId, QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__'))
					)
				);

				if (!$this->objMemberMileage){
					error_log('error accessing acx1MemberMileageEditForm for logID='.$intId.' and member '.QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__'));
					QSessionDB::set("error", "Could not find a MemberMileage log with PK arguments: " . $intId);
					QApplication::Redirect('MemberMileageLogs.php');
					exit;
				}
				$this->strTitleVerb = QApplication::Translate('Edit');
				$this->blnEditMode = true;
			} else {
				$this->objMemberMileage = new MemberMileage();
				$this->strTitleVerb = QApplication::Translate('Create');
				$this->blnEditMode = false;
			}
		}
		protected function lstMember_Create() {
			$this->isFamilyMembership=0;
			// get membership logs for the member (showing only the latest)
			$objMembershipAssoc = MembershipAssoc::GetLatestMembershipForMember(QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__'));
			// membership log found and the membership is a family membership then
			if ($objMembershipAssoc && ($objMembershipAssoc->MembershipLogIdObject->LogType == 3 || $objMembershipAssoc->MembershipLogIdObject->LogType == 4 || $objMembershipAssoc->MembershipLogIdObject->LogType == 8)) {
				$this->isFamilyMembership=1;
				$this->lstMember = new QListBox($this);
				$this->lstMember->Name = QApplication::Translate('Log for a family member');
				$this->lstMember->CssClass = "form-control form-control-sm";
				//$this->lstMember->AddAction(new QChangeEvent(), new QServerAction('updateStuff'));
				$this->lstMember->AddItem(QApplication::Translate('- Me -'), null);
				//get the list of family members
				$objMembershipAssocArray = MembershipAssoc::QueryArray(
					QQ::Equal(QQN::MembershipAssoc()->MembershipLogId, $objMembershipAssoc->MembershipLogId),
					QQ::Clause(QQ::OrderBy(QQN::MembershipAssoc()->PrimaryMember,false))
				);
				if ($objMembershipAssocArray) foreach ($objMembershipAssocArray as $objMembershipAssoc2) {
					// exclude yourself
					if (QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__') != $objMembershipAssoc2->MemberId) {
						$objListItem = new QListItem($objMembershipAssoc2->MemberIdObject->__toString(), $objMembershipAssoc2->MemberId);
						if ($this->blnEditMode && $objMembershipAssoc2->MemberId==$this->objMemberMileage->MemberId)
							$objListItem->Selected = true;
						$this->lstMember->AddItem($objListItem);
					}
				}
			}
			else $this->lstMember = new QPlain($this);
		}
		// Protected Update Methods
		protected function UpdateMemberMileageFields() {
			// logging mileage for family members
			if ($this->isFamilyMembership && $this->lstMember->SelectedValue != '') {
				$this->objMemberMileage->MemberId = $this->lstMember->SelectedValue;
			}
			else $this->objMemberMileage->MemberId = QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__');
			$this->objMemberMileage->Miles = trim($this->txtMiles->Text ?? '');
			$this->objMemberMileage->LoggedOn = $this->calLoggedOn->DateTime;
			$this->objMemberMileage->Notes = trim($this->txtNotes->Text ?? '');
			$this->objMemberMileage->Year = trim($this->txtYear->Text ?? '');
		}
	}
	ACL_Run('MemberMileageLog');
?>