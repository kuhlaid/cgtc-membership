<?php
/**
 * @abstract Basic list of members who have logged into the application.
 * @author w. Patrick Gale
 *
 * Jan. 1, 2018 - wpg
 * - adding tracking of the type of login a member uses to access the application
 *
 * Dec. 31, 2017 - wpg
 * - adding sorting by member
 *
 * July 16, 2017 - wpg
 * - setup basic form
 */
	// Include prepend.inc to load Qcodo
	require('includes/prepend.inc.php');
	require(__FORMBASE_CLASSES__ . '/MemberAccessLogListFormBase.class.php');
	QApplication::CheckRemoteAdmin();

	class acx1MemberAccessLogs extends MemberAccessLogListFormBase {
		protected function Form_Create() {
			// Setup DataGrid Columns
			//$this->colEditLinkColumn->HtmlEntities = false;
			$this->colMemberId = new QDataGridColumn(QApplication::Translate('Member'), '<?= $_FORM->dtgMemberAccessLog_MemberIdObject_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberAccessLog()->MemberId), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberAccessLog()->MemberId, false)));
			$this->colTimeOfLogin = new QDataGridColumn(QApplication::Translate('Time Of Login'), '<?= $_FORM->dtgMemberAccessLog_TimeOfLogin_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberAccessLog()->TimeOfLogin), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberAccessLog()->TimeOfLogin, false)));
			$this->colLoginMethod = new QDataGridColumn(QApplication::Translate('Login Method'), '<?= MemberAccessLog::$accessArray[$_ITEM->LoginMethod]; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberAccessLog()->LoginMethod), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberAccessLog()->LoginMethod, false)));

			// Setup DataGrid
			$this->dtgMemberAccessLog = new QDataGrid($this);
			$this->dtgMemberAccessLog->CellSpacing = 0;
			$this->dtgMemberAccessLog->CellPadding = 4;
			$this->dtgMemberAccessLog->BorderStyle = QBorderStyle::Solid;
			$this->dtgMemberAccessLog->BorderWidth = 1;
			$this->dtgMemberAccessLog->GridLines = QGridLines::Both;

			// Datagrid Paginator
			$this->dtgMemberAccessLog->Paginator = new QPaginator($this->dtgMemberAccessLog);
			$this->dtgMemberAccessLog->ItemsPerPage = __ITEMS_PER_PAGE__;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgMemberAccessLog->UseAjax = true;

			$this->dtgMemberAccessLog->SortColumnIndex = 1;
			$this->dtgMemberAccessLog->SortDirection = 1;

			// Specify the local databind method this datagrid will use
			$this->dtgMemberAccessLog->SetDataBinder('dtgMemberAccessLog_Bind');

			$this->dtgMemberAccessLog->AddColumn($this->colMemberId);
			$this->dtgMemberAccessLog->AddColumn($this->colTimeOfLogin);
			$this->dtgMemberAccessLog->AddColumn($this->colLoginMethod);
		}

		public function dtgMemberAccessLog_EditLinkColumn_Render(MemberAccessLog $objMemberAccessLog) {
			return sprintf('<a href="member_access_log_edit.php?intId=%s">%s</a>',
					$objMemberAccessLog->Id,
					QApplication::Translate('Edit'));
		}
	}

	ACL_Run('MemberAccessLogs');
?>