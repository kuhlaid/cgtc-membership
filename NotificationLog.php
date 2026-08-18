<?php
/**
 * @abstract Shows the notification sent to members.
 * @author w. Patrick Gale
 *
 * Dec. 1, 2019 - wpg
 * - create a notification log
 * 
 * April 23, 2017 - wpg
 * - building basic view
 *
 */
require('includes/prepend.inc.php');
require(__FORMBASE_CLASSES__ . '/NotificationLogEditFormBase.class.php');
QApplication::CheckRemoteAdmin();

// admin class
class acx1NotificationLogEditForm extends NotificationLogEditFormBase {

	protected $objMemberContact,$intLogType;
	protected function SetupNotificationLog() {
		$intMemberId = QApplication::QueryString('iMD');
		$this->intLogType = QApplication::QueryString('logType');
		if ($intMemberId) {
			$this->objMemberContact = MemberContact::Load($intMemberId);
			if (!$this->objMemberContact) $this->noMember();
		}

		// Lookup Object PK information from Query String (if applicable)
		// Set mode to Edit or New depending on what's found
		$intId = QApplication::QueryString('intId');
		if (($intId)) {
			$this->objNotificationLog = NotificationLog::Load(($intId));

			if (!$this->objNotificationLog)
				throw new Exception('Could not find a NotificationLog object with PK arguments: ' . $intId);

			$this->strTitleVerb = QApplication::Translate('Edit');
			$this->blnEditMode = true;
		} else {
			$this->objNotificationLog = new NotificationLog();
			$this->strTitleVerb = QApplication::Translate('Create');
			$this->blnEditMode = false;
		}
	}

	protected function noMember(){
		QSessionDB::set("error", "There was an error accessing the membership log. Try again.");
		QApplication::Redirect('MembershipList.php');
		exit;
	}
	

	protected function txtNotificationType_Create() {
		$this->txtNotificationType = new QIntegerTextBox($this);
		$this->txtNotificationType->Name = QApplication::Translate('Notification Type');
		
		if ($this->intLogType!='' && !$this->blnEditMode)
			$this->txtNotificationType->Text = $this->intLogType;
		else 
			$this->txtNotificationType->Text = $this->objNotificationLog->NotificationType;
		$this->txtNotificationType->Required = true;
	}

	protected function lstMemberIdObject_Create() {
		$this->lstMemberIdObject = new QLabel($this);
		$this->lstMemberIdObject->Name = QApplication::Translate('Member');
		if ($this->blnEditMode)
			$this->lstMemberIdObject->Text = $this->objNotificationLog->MemberIdObject->__toString();
		elseif ($this->objMemberContact)
			$this->lstMemberIdObject->Text = $this->objMemberContact->__toString();
	}

	protected function calNotificationDate_Create() {
		$this->calNotificationDate = new QJsCalendar($this);
		$this->calNotificationDate->Name = QApplication::Translate('Notification Date');
		$today = QDateTime::Now(false);
		if ($this->blnEditMode)
			$this->calNotificationDate->DateTime = $this->objNotificationLog->NotificationDate;
		else 
			$this->calNotificationDate->DateTime = $today;
	}

	// Create and Setup txtNotificationSubject
	protected function txtNotificationSubject_Create() {
		$this->txtNotificationSubject = new QTextBox($this);
		$this->txtNotificationSubject->Name = QApplication::Translate('Notification Subject');
		if ($this->blnEditMode)
			$this->txtNotificationSubject->Text = $this->objNotificationLog->NotificationSubject;
		elseif ($this->intLogType != '')
			$this->txtNotificationSubject->Text = NotificationLog::$notificationTypeArray[$this->intLogType];
		$this->txtNotificationSubject->MaxLength = NotificationLog::NotificationSubjectMaxLength;
	}

	protected function txtNotificationBody_Create() {
		if ($this->blnEditMode) {
			$this->txtNotificationBody = new QLabel($this);
			$this->txtNotificationBody->Name = QApplication::Translate('Notification Body');
			$this->txtNotificationBody->Text = "<hr/>".$this->objNotificationLog->NotificationBody."<hr/>";
			$this->txtNotificationBody->HtmlEntities = false;
		}
		else {
			$this->txtNotificationBody = new QFCKeditor($this);
			$this->txtNotificationBody->Width = '100%';
			$this->txtNotificationBody->Height = '400px';
			$this->txtNotificationBody->Name = QApplication::Translate('Notification Body');
		
		}
	}

	protected function UpdateNotificationLogFields() {
		// adding reason for joining
		if ($this->intLogType == 8) {
			$this->objNotificationLog->MemberId = $this->objMemberContact->Id;
			$this->objNotificationLog->NotificationType = $this->intLogType;
			$this->objNotificationLog->NotificationDate = $this->calNotificationDate->DateTime;
			$this->objNotificationLog->NotificationSubject = $this->txtNotificationSubject->Text;
			$this->objNotificationLog->NotificationBody = $this->txtNotificationBody->Text;
			$this->objNotificationLog->NotificationConfirmed = true;
		}
	}

	protected function lstMembershipLogIdObject_Create() {
		$this->lstMembershipLogIdObject = new QLabel($this);
		$this->lstMembershipLogIdObject->Name = QApplication::Translate('Membership Log');
		if ($this->objNotificationLog->MembershipLogIdObject)
			$this->lstMembershipLogIdObject->Text = $this->objNotificationLog->MembershipLogIdObject->__toString();
	}

	protected function RedirectToListPage() {
		QApplication::Redirect('NotificationLogs.php');
	}
}

// go to the centralized form executing access control function to run the form and check access control
ACL_Run('NotificationLog');
?>