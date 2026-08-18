<?php
	/**
	 * This is the abstract Form class for the List All functionality
	 * of the NotificationLog class.  This code-generated class
	 * contains a Qform datagrid to display an HTML page that can
	 * list a collection of NotificationLog objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this NotificationLogListFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class NotificationLogListFormBase extends QForm {
		protected $dtgNotificationLog;

		// DataGrid Columns
		protected $colEditLinkColumn;
		protected $colId;
		protected $colMemberId;
		protected $colNotificationType;
		protected $colNotificationDate;
		protected $colNotificationSubject;
		protected $colNotificationBody;
		protected $colMembershipLogId;
		protected $colNotificationConfirmed;


		protected function Form_Create() {
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgNotificationLog_EditLinkColumn_Render($_ITEM) ?>');
			$this->colEditLinkColumn->HtmlEntities = false;
			$this->colId = new QDataGridColumn(QApplication::Translate('Id'), '<?= $_ITEM->Id; ?>', array('OrderByClause' => QQ::OrderBy(QQN::NotificationLog()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::NotificationLog()->Id, false)));
			$this->colMemberId = new QDataGridColumn(QApplication::Translate('Member Id'), '<?= $_FORM->dtgNotificationLog_MemberIdObject_Render($_ITEM); ?>');
			$this->colNotificationType = new QDataGridColumn(QApplication::Translate('Notification Type'), '<?= $_ITEM->NotificationType; ?>', array('OrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationType), 'ReverseOrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationType, false)));
			$this->colNotificationDate = new QDataGridColumn(QApplication::Translate('Notification Date'), '<?= $_FORM->dtgNotificationLog_NotificationDate_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationDate), 'ReverseOrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationDate, false)));
			$this->colNotificationSubject = new QDataGridColumn(QApplication::Translate('Notification Subject'), '<?= QString::Truncate($_ITEM->NotificationSubject, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationSubject), 'ReverseOrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationSubject, false)));
			$this->colNotificationBody = new QDataGridColumn(QApplication::Translate('Notification Body'), '<?= QString::Truncate($_ITEM->NotificationBody, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationBody), 'ReverseOrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationBody, false)));
			$this->colMembershipLogId = new QDataGridColumn(QApplication::Translate('Membership Log Id'), '<?= $_FORM->dtgNotificationLog_MembershipLogIdObject_Render($_ITEM); ?>');
			$this->colNotificationConfirmed = new QDataGridColumn(QApplication::Translate('Notification Confirmed'), '<?= ($_ITEM->NotificationConfirmed) ? "true" : "false" ?>', array('OrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationConfirmed), 'ReverseOrderByClause' => QQ::OrderBy(QQN::NotificationLog()->NotificationConfirmed, false)));

			// Setup DataGrid
			$this->dtgNotificationLog = new QDataGrid($this);
			$this->dtgNotificationLog->CellSpacing = 0;
			$this->dtgNotificationLog->CellPadding = 4;
			$this->dtgNotificationLog->BorderStyle = QBorderStyle::Solid;
			$this->dtgNotificationLog->BorderWidth = 1;
			$this->dtgNotificationLog->GridLines = QGridLines::Both;

			// Datagrid Paginator
			$this->dtgNotificationLog->Paginator = new QPaginator($this->dtgNotificationLog);
			$this->dtgNotificationLog->ItemsPerPage = 10;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgNotificationLog->UseAjax = false;

			// Specify the local databind method this datagrid will use
			$this->dtgNotificationLog->SetDataBinder('dtgNotificationLog_Bind');

			$this->dtgNotificationLog->AddColumn($this->colEditLinkColumn);
			$this->dtgNotificationLog->AddColumn($this->colId);
			$this->dtgNotificationLog->AddColumn($this->colMemberId);
			$this->dtgNotificationLog->AddColumn($this->colNotificationType);
			$this->dtgNotificationLog->AddColumn($this->colNotificationDate);
			$this->dtgNotificationLog->AddColumn($this->colNotificationSubject);
			$this->dtgNotificationLog->AddColumn($this->colNotificationBody);
			$this->dtgNotificationLog->AddColumn($this->colMembershipLogId);
			$this->dtgNotificationLog->AddColumn($this->colNotificationConfirmed);
		}
		
		public function dtgNotificationLog_EditLinkColumn_Render(NotificationLog $objNotificationLog) {
			return sprintf('<a href="notification_log_edit.php?intId=%s">%s</a>',
				$objNotificationLog->Id, 
				QApplication::Translate('Edit'));
		}

		public function dtgNotificationLog_MemberIdObject_Render(NotificationLog $objNotificationLog) {
			if (!is_null($objNotificationLog->MemberIdObject))
				return $objNotificationLog->MemberIdObject->__toString();
			else
				return null;
		}

		public function dtgNotificationLog_NotificationDate_Render(NotificationLog $objNotificationLog) {
			if (!is_null($objNotificationLog->NotificationDate))
				return $objNotificationLog->NotificationDate->toString(QDateTime::FormatDisplayDateTime);
			else
				return null;
		}

		public function dtgNotificationLog_MembershipLogIdObject_Render(NotificationLog $objNotificationLog) {
			if (!is_null($objNotificationLog->MembershipLogIdObject))
				return $objNotificationLog->MembershipLogIdObject->__toString();
			else
				return null;
		}


		protected function dtgNotificationLog_Bind() {
			// Because we want to enable pagination AND sorting, we need to setup the $objClauses array to send to LoadAll()

			// Remember!  We need to first set the TotalItemCount, which will affect the calcuation of LimitClause below
			$this->dtgNotificationLog->TotalItemCount = NotificationLog::CountAll();

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
			$this->dtgNotificationLog->DataSource = NotificationLog::LoadAll($objClauses);
		}
	}
?>