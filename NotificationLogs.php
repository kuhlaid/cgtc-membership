<?php
/**
 * @abstract Shows the list of notifications sent to members.
 * @author w. Patrick Gale
 *
 * April 28, 2017 - wpg
 * - adding a filter for specific member notifications
 * - changing the notification date to datetime
 *
 * April 23, 2017 - wpg
 * - building basic list
 *
 */
require('includes/prepend.inc.php');
require(__FORMBASE_CLASSES__ . '/NotificationLogListFormBase.class.php');
QApplication::CheckRemoteAdmin();


class acx1NotificationLogListForm extends NotificationLogListFormBase {
	protected $objMemberContact;
	protected function Form_Create() {
		// we will filter the list on a specific member if requested
		$intMemberId = QApplication::QueryString('iMD');
		if ($intMemberId!='') {
			$this->objMemberContact = MemberContact::Load($intMemberId);
		}

		// Setup DataGrid Columns
		$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgNotificationLog_EditLinkColumn_Render($_ITEM) ?>');

		$this->colId = new QDataGridColumn(QApplication::Translate('Id'), '<?= $_ITEM->Id; ?>', array('OrderByClause' => QQ::OrderBy(QQN::NotificationLog()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::NotificationLog()->Id, false)));
		$this->colMemberId = new QDataGridColumn(QApplication::Translate('Member'), '<?= $_FORM->dtgNotificationLog_MemberIdObject_Render($_ITEM); ?>');
		$this->colNotificationType = new QDataGridColumn(QApplication::Translate('Notification Type'), '<?= NotificationLog::$notificationTypeArray[$_ITEM->NotificationType]; ?>', array('OrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationType), 'ReverseOrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationType, false)));
		$this->colNotificationDate = new QDataGridColumn(QApplication::Translate('Notification Date'), '<?= $_FORM->dtgNotificationLog_NotificationDate_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationDate), 'ReverseOrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationDate, false)));
		$this->colNotificationSubject = new QDataGridColumn(QApplication::Translate('Notification Subject'), '<?= QString::Truncate($_ITEM->NotificationSubject, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationSubject), 'ReverseOrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationSubject, false)));
		$this->colNotificationBody = new QDataGridColumn(QApplication::Translate('Notification Body'), '<?= QString::Truncate($_ITEM->NotificationBody, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationBody), 'ReverseOrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationBody, false)));
		$this->colMembershipLogId = new QDataGridColumn(QApplication::Translate('Membership Log Id'), '<?= $_FORM->dtgNotificationLog_MembershipLogIdObject_Render($_ITEM); ?>');
		$this->colNotificationConfirmed = new QDataGridColumn(QApplication::Translate('Notification Confirmed'), '<?= ($_ITEM->NotificationConfirmed) ? "true" : "false" ?>', array('OrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationConfirmed), 'ReverseOrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationConfirmed, false)));
		$this->colMemberId->HtmlEntities = $this->colEditLinkColumn->HtmlEntities = false;

		// Setup DataGrid
		$this->dtgNotificationLog = new QDataGrid($this);
		$this->dtgNotificationLog->CellSpacing = 0;
		$this->dtgNotificationLog->CellPadding = 4;
		$this->dtgNotificationLog->BorderStyle = QBorderStyle::Solid;
		$this->dtgNotificationLog->BorderWidth = 1;
		$this->dtgNotificationLog->GridLines = QGridLines::Both;
		$this->dtgNotificationLog->CssClass='table table-bordered';

		// Datagrid Paginator
		$this->dtgNotificationLog->Paginator = new QPaginator($this->dtgNotificationLog);
		$this->dtgNotificationLog->ItemsPerPage = __ITEMS_PER_PAGE__;

		// Specify Whether or Not to Refresh using Ajax
		$this->dtgNotificationLog->UseAjax = false;

		$this->dtgNotificationLog->SortColumnIndex = 3;
		$this->dtgNotificationLog->SortDirection = 1;

		// Specify the local databind method this datagrid will use
		$this->dtgNotificationLog->SetDataBinder('dtgNotificationLog_Bind');

		$this->dtgNotificationLog->AddColumn($this->colEditLinkColumn);
		$this->dtgNotificationLog->AddColumn($this->colMemberId);
		$this->dtgNotificationLog->AddColumn($this->colNotificationType);
		$this->dtgNotificationLog->AddColumn($this->colNotificationDate);
		$this->dtgNotificationLog->AddColumn($this->colNotificationSubject);
		$this->dtgNotificationLog->AddColumn($this->colNotificationBody);
		//$this->dtgNotificationLog->AddColumn($this->colMembershipLogId);
		//$this->dtgNotificationLog->AddColumn($this->colNotificationConfirmed);
	}

	public function dtgNotificationLog_NotificationDate_Render(NotificationLog $objNotificationLog) {
		if (!is_null($objNotificationLog->NotificationDate))
			return $objNotificationLog->NotificationDate->toString('MMMM DD, YYYY hh:mm:ss');
		else
			return null;
	}

	public function dtgNotificationLog_EditLinkColumn_Render(NotificationLog $objNotificationLog) {
		return sprintf('<a href="NotificationLog.php?intId=%s">%s</a>',
				$objNotificationLog->Id,
				QApplication::Translate('View'));
	}

	public function dtgNotificationLog_MemberIdObject_Render(NotificationLog $objNotificationLog) {
		if (!is_null($objNotificationLog->MemberIdObject))
			return "<a href='MembershipList.php?iMD=".$objNotificationLog->MemberId."'>".$objNotificationLog->MemberIdObject->__toString()."</a>";
		else
			return null;
	}

	protected function dtgNotificationLog_Bind() {
		$strAndCondition = "";
		if ($this->objMemberContact) {
			$strAndCondition .= "QQ::Equal(QQN::NotificationLog()->MemberId, ".$this->objMemberContact->Id.")";
		}
		if ($strAndCondition != '')
			$strAndCondition = "QQ::AndCondition(".$strAndCondition.")";
		else
			$strAndCondition = "QQ::All()";

		// Remember!  We need to first set the TotalItemCount, which will affect the calcuation of LimitClause below
		$this->dtgNotificationLog->TotalItemCount = NotificationLog::QueryCount(eval("return $strAndCondition;"));

		// Setup the $objClauses Array
		$objClauses = array();

		// If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
		// the OrderByClause to the $objClauses array
		if ($objClause = $this->dtgNotificationLog->OrderByClause)
			array_push($objClauses, $objClause);

		// Add the LimitClause information, as well
		if ($objClause = $this->dtgNotificationLog->LimitClause)
			array_push($objClauses, $objClause);

		// Set the DataSource to be the array of all NotificationLog objects, given the clauses above
		$this->dtgNotificationLog->DataSource = NotificationLog::QueryArray(eval("return $strAndCondition;"), $objClauses);
	}

}

// go to the centralized form executing access control function to run the form and check access control
ACL_Run('NotificationLogs');
?>