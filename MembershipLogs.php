<?php
/**
 * @Shows when members renewed or joined the club.
 *
 * June 13, 2018 - wpg
 * - correcting the expired for more than 90 days queries
 *
 * April 6, 2018 - wpg
 * - adding tabs for all membership logs and those expired more than 90 days
 *
 * April 25, 2017 - wpg
 * - adding a link to send members a membership update email
 *
 * April 14, 2017 - wpg
 * - disabling the edit link for membership logs on read-only users
 *
 * April 10, 2017 - wpg
 * - adding PayPal transaction # and swapping the edit link for the membership type because I kept clicking on the wrong link to edit to log
 *
 * April 9, 2017 - wpg
 * - changing the membership logs to use the new paradigm for tracking memberships
 * - adding links to view single member info in the membership list
 *
 * March 18, 2017 - wpg
 * - building basic datagrid view
 */
	// Include prepend.inc to load Qcodo
	require('includes/prepend.inc.php');
	require(__FORMBASE_CLASSES__ . '/MembershipLogListFormBase.class.php');
	QApplication::CheckRemoteAdmin();

	// membership admin
	class acx1MembershipLogListForm extends MembershipLogListFormBase {
		protected $objMemberContact, $strOption;
		protected function Form_Create() {
			$this->strOption = QApplication::QueryString('strOption');
			// we will filter the list on a specific member if requested
			$intMemberId = QApplication::QueryString('iMD');
			if ($intMemberId!='') {
				$this->objMemberContact = MemberContact::Load($intMemberId);
			}
			$this->dtgMembershipLog_Create();
		}

		protected function dtgMembershipLog_Create() {
			
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Membership Type'), '<?= $_FORM->dtgMembershipLog_EditLinkColumn_Render($_ITEM) ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->Id, false)));

			$this->colId = new QDataGridColumn(QApplication::Translate('Id'), '<?= $_ITEM->Id; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->Id, false)));
			$this->colLogType = new QDataGridColumn(QApplication::Translate('Membership Type'), '<?= $_FORM->dtgMembershipLog_LogTypeColumn_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->LogType), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->LogType, false)));
			$this->colStartDate = new QDataGridColumn(QApplication::Translate('Membership started'), '<?= $_FORM->dtgMembershipLog_StartDate_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->StartDate), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->StartDate, false)));
			$this->colExpireDate = new QDataGridColumn(QApplication::Translate('Membership ends'), '<?= $_FORM->dtgMembershipLog_ExpireDate_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->ExpireDate), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->ExpireDate, false)));
			$this->colPaymentType = new QDataGridColumn(QApplication::Translate('Payment Type'), '<?= $_FORM->dtgMembershipLog_PaymentType_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->PaymentType), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->PaymentType, false)));
			$this->colPaymentAmount = new QDataGridColumn(QApplication::Translate('Payment Amount'), '<?= $_FORM->dtgMembershipLog_PaymentAmount_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->PaymentAmount), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->PaymentAmount, false)));
			$this->colPaidOn = new QDataGridColumn(QApplication::Translate('Paid On'), '<?= $_FORM->dtgMembershipLog_PaidOn_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->PaidOn), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->PaidOn, false)));
			$this->colNote = new QDataGridColumn(QApplication::Translate('Note'), '<?= QString::Truncate($_ITEM->Note, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->Note), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->Note, false)));
			$this->colMemberId = new QDataGridColumn(QApplication::Translate('Member(s)'), '<?= $_FORM->dtgMembershipLog_MemberIdObject_Render($_ITEM); ?>');
			$this->colNewMembership = new QDataGridColumn(QApplication::Translate('New Membership?'), '<?= ($_ITEM->NewMembership) ? __CHECK_ICON__ : "" ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->NewMembership), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->NewMembership, false)));
			$this->colMedTrainingType = new QDataGridColumn(QApplication::Translate('Medical Training'), '<?= $_FORM->dtgMembershipLog_MedTrainingTypeColumn_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->MedTrainingType), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->MedTrainingType, false)));
			$this->colWillingMedVolunteer = new QDataGridColumn(QApplication::Translate('Medical Volunteer?'), '<?= ($_ITEM->WillingMedVolunteer) ? __CHECK_ICON__ : "" ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->WillingMedVolunteer), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->WillingMedVolunteer, false)));
			$this->colPayPalTransactionId = new QDataGridColumn(QApplication::Translate('PayPal Transaction #'), '<?= QString::Truncate($_ITEM->PayPalTransactionId, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->PayPalTransactionId), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->PayPalTransactionId, false)));


			$this->colMemberId->HtmlEntities = $this->colWillingMedVolunteer->HtmlEntities = $this->colNewMembership->HtmlEntities = $this->colEditLinkColumn->HtmlEntities = false;
			$this->colMemberId->Wrap = false;
			$this->colWillingMedVolunteer->HorizontalAlign = $this->colNewMembership->HorizontalAlign = QHorizontalAlign::Center;

			// Setup DataGrid
			$this->dtgMembershipLog = new QDataGrid($this);
			$this->dtgMembershipLog->CellSpacing = 0;
			$this->dtgMembershipLog->CellPadding = 4;
			$this->dtgMembershipLog->BorderStyle = QBorderStyle::Solid;
			$this->dtgMembershipLog->BorderWidth = 1;
			$this->dtgMembershipLog->GridLines = QGridLines::Both;
			$this->dtgMembershipLog->CssClass='table table-bordered';

			// Datagrid Paginator
			$this->dtgMembershipLog->Paginator = new QPaginator($this->dtgMembershipLog);
			$this->dtgMembershipLog->ItemsPerPage = __ITEMS_PER_PAGE__;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgMembershipLog->UseAjax = false;

			$this->dtgMembershipLog->SortColumnIndex = 0;
			$this->dtgMembershipLog->SortDirection = 1;

			// Specify the local databind method this datagrid will use
			$this->dtgMembershipLog->SetDataBinder('dtgMembershipLog_Bind');

			$this->showColumns();
		}
		protected function showColumns() {
			$this->dtgMembershipLog->AddColumn($this->colEditLinkColumn);
			$this->dtgMembershipLog->AddColumn($this->colMemberId);
			//$this->dtgMembershipLog->AddColumn($this->colLogType);
			$this->dtgMembershipLog->AddColumn($this->colStartDate);
			$this->dtgMembershipLog->AddColumn($this->colExpireDate);
			$this->dtgMembershipLog->AddColumn($this->colPaymentType);
			$this->dtgMembershipLog->AddColumn($this->colPaymentAmount);
			$this->dtgMembershipLog->AddColumn($this->colPaidOn);
			$this->dtgMembershipLog->AddColumn($this->colNote);

			$this->dtgMembershipLog->AddColumn($this->colNewMembership);
			$this->dtgMembershipLog->AddColumn($this->colMedTrainingType);
			$this->dtgMembershipLog->AddColumn($this->colWillingMedVolunteer);
			$this->dtgMembershipLog->AddColumn($this->colPayPalTransactionId);
		}

		public function dtgMembershipLog_MemberIdObject_Render(MembershipLog $objMembershipLog) {
			return MembershipAssoc::MembersOfMembership($objMembershipLog->Id,true);
		}

		public function dtgMembershipLog_MedTrainingTypeColumn_Render (MembershipLog $objMembershipLog) {
			if ($objMembershipLog->MedTrainingType)
				return MembershipLog::$medicalTrainingArray[$objMembershipLog->MedTrainingType];
		}

		public function dtgMembershipLog_PaymentAmount_Render(MembershipLog $objMembershipLog) {
			if ($objMembershipLog->PaymentAmount)
				return "$".$objMembershipLog->PaymentAmount;
		}

		public function dtgMembershipLog_PaymentType_Render(MembershipLog $objMembershipLog) {
			if ($objMembershipLog->PaymentType)
				return MembershipLog::$paymentTypeArray[$objMembershipLog->PaymentType];
		}

		public function dtgMembershipLog_EditLinkColumn_Render(MembershipLog $objMembershipLog) {
			$membershipType='individual';
			if (!is_null($objMembershipLog->LogType)){
				if ($objMembershipLog->LogType!=88) $membershipType = MembershipLog::showMembershipType($objMembershipLog->LogType);
			}

			if ($this->objMemberContact)
				return sprintf('<a href="Membership.php?intId=%s" title="Edit the log details">%s</a><div class="bld"><a href="emailNotification.php?option=membershipUpdate&iMD=%s" title="Email membership info">Email membership info</a></div>',
					$objMembershipLog->Id,
					$membershipType,
					$this->objMemberContact->Id);
			else
				return sprintf('<a href="Membership.php?intId=%s" title="Edit the log details">%s</a>',
						$objMembershipLog->Id,
						$membershipType);
		}

		public function dtgMembershipLog_StartDate_Render(MembershipLog $objMembershipLog) {
			if (!is_null($objMembershipLog->StartDate))
				return $objMembershipLog->StartDate->toString(QDateTime::FormatDisplayDate);
			else
				return null;
		}

		public function dtgMembershipLog_ExpireDate_Render(MembershipLog $objMembershipLog) {
			if (!is_null($objMembershipLog->ExpireDate))
				return $objMembershipLog->ExpireDate->toString(QDateTime::FormatDisplayDate);
			else
				return null;
		}

		public function dtgMembershipLog_LogTypeColumn_Render(MembershipLog $objMembershipLog) {
			if (!is_null($objMembershipLog->LogType)){
				if ($objMembershipLog->LogType!=88) return MembershipLog::showMembershipType($objMembershipLog->LogType);
			}
			else
				return null;
		}

		protected function dtgMembershipLog_Bind() {
			$strAndCondition = "";
			if ($this->strOption == 'expired90'){

				$dt = QDateTime::Now(false);
				$ninetyDays = $dt->SubtractDays(90);	// 90 days ago

				// get the existing memberships for active members
			$strQuery = "SELECT ml.Id, ma.MemberId as MemberId, MAX(ml.ExpireDate) as ExpireDate
				FROM MembershipAssoc ma
				LEFT JOIN MembershipLog ml ON ml.Id=ma.MembershipLogId
				WHERE ml.Id IS NOT NULL and ma.MembershipLogId IN (SELECT Id FROM MembershipLog)
				AND ma.MemberId IN (SELECT Id FROM MemberContact WHERE NotActive=0 OR NotActive IS NULL)
				GROUP BY ma.MemberId
				ORDER BY ma.MemberId,ml.ExpireDate";

			$objDatabase = MembershipLog::GetDatabase();
			$objDbResult = $objDatabase->Query($strQuery);
			$expiredMembersshipId = array();
			// expired membership, disable account
			while ($objDbRow = $objDbResult->FetchArray()) {
				//print $objDbRow['MemberId']."***".(str_replace('-', '', $objDbRow['ExpireDate'])-$ninetyDays->toString('YYYYMMDD'))." for ".str_ireplace('-', '', $objDbRow['ExpireDate'])." on ".$ninetyDays->toString('YYYYMMDD')."<br/>";

				if (str_replace('-', '', $objDbRow['ExpireDate']) <= $ninetyDays->toString('YYYYMMDD')){
					array_push($expiredMembersshipId,$objDbRow['MemberId']);
					//print str_replace('-', '', $objDbRow['ExpireDate'])-$ninetyDays->toString('YYYYMMDD')." for ".str_ireplace('-', '', $objDbRow['ExpireDate'])." on ".$ninetyDays->toString('YYYYMMDD')."<br/>";

				}
			}


				// if we have members expired more than 90 days
				if (count($expiredMembersshipId)>0) {
					if ($strAndCondition != '') $strAndCondition .= ',';
					$strAndCondition .= "QQ::In(QQN::MembershipLog()->MembershipAssocAsId->MemberId, \$expiredMembersshipId)";
				}
				else $strAndCondition = "QQ::None()";

			}
			elseif ($this->objMemberContact) {
				$strAndCondition .= "QQ::Equal(QQN::MembershipLog()->MembershipAssocAsId->MemberId, ".$this->objMemberContact->Id.")";
			}
			if ($strAndCondition != '')
				$strAndCondition = "QQ::AndCondition(".$strAndCondition.")";
			else
				$strAndCondition = "QQ::All()";

			$this->dtgMembershipLog->TotalItemCount = MembershipLog::QueryCount(eval("return $strAndCondition;"));

			// Setup the $objClauses Array
			$objClauses = array();

			// If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
			// the OrderByClause to the $objClauses array
			if ($objClause = $this->dtgMembershipLog->OrderByClause)
				array_push($objClauses, $objClause);

			// Add the LimitClause information, as well
			if ($objClause = $this->dtgMembershipLog->LimitClause)
				array_push($objClauses, $objClause);

			// Set the DataSource to be the array of all MembershipLog objects, given the clauses above
			$this->dtgMembershipLog->DataSource = MembershipLog::QueryArray(eval("return $strAndCondition;"), $objClauses);
		}
	}

	// member access 
	class acx2MembershipLogListForm extends acx1MembershipLogListForm {
		protected function Form_Create() {
			$this->objMemberContact = MemberContact::Load(QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__'));
			$this->dtgMembershipLog_Create();
		}

		public function dtgMembershipLog_MemberIdObject_Render(MembershipLog $objMembershipLog) {
			return MembershipAssoc::MembersOfMembership($objMembershipLog->Id,false);
		}

		protected function showColumns() {
			$this->dtgMembershipLog->AddColumn($this->colMemberId);
			$this->dtgMembershipLog->AddColumn($this->colLogType);
			$this->dtgMembershipLog->AddColumn($this->colStartDate);
			$this->dtgMembershipLog->AddColumn($this->colExpireDate);
			$this->dtgMembershipLog->AddColumn($this->colPaymentType);
			$this->dtgMembershipLog->AddColumn($this->colPaymentAmount);
			$this->dtgMembershipLog->AddColumn($this->colPaidOn);
			$this->dtgMembershipLog->AddColumn($this->colPayPalTransactionId);
			$this->dtgMembershipLog->AddColumn($this->colNewMembership);
			$this->dtgMembershipLog->AddColumn($this->colMedTrainingType);
			$this->dtgMembershipLog->AddColumn($this->colWillingMedVolunteer);
		}

		protected function dtgMembershipLog_Bind() {
			$strAndCondition = "QQ::Equal(QQN::MembershipLog()->MembershipAssocAsId->MemberId, ".$this->objMemberContact->Id.")";
			$strAndCondition = "QQ::AndCondition(".$strAndCondition.")";

			$this->dtgMembershipLog->TotalItemCount = MembershipLog::QueryCount(eval("return $strAndCondition;"));

			// Setup the $objClauses Array
			$objClauses = array();

			// If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
			// the OrderByClause to the $objClauses array
			if ($objClause = $this->dtgMembershipLog->OrderByClause)
				array_push($objClauses, $objClause);

			// Add the LimitClause information, as well
			if ($objClause = $this->dtgMembershipLog->LimitClause)
				array_push($objClauses, $objClause);

			// Set the DataSource to be the array of all MembershipLog objects, given the clauses above
			$this->dtgMembershipLog->DataSource = MembershipLog::QueryArray(eval("return $strAndCondition;"), $objClauses);
		}
	}

	// read-only access
	class acx4MembershipLogListForm extends acx1MembershipLogListForm {
		protected function showColumns() {
			$this->dtgMembershipLog->AddColumn($this->colEditLinkColumn);
			$this->dtgMembershipLog->AddColumn($this->colMemberId);
			$this->dtgMembershipLog->AddColumn($this->colLogType);
			$this->dtgMembershipLog->AddColumn($this->colStartDate);
			$this->dtgMembershipLog->AddColumn($this->colExpireDate);
			$this->dtgMembershipLog->AddColumn($this->colPaymentType);
			$this->dtgMembershipLog->AddColumn($this->colPaymentAmount);
			$this->dtgMembershipLog->AddColumn($this->colPaidOn);
			$this->dtgMembershipLog->AddColumn($this->colNote);

			$this->dtgMembershipLog->AddColumn($this->colNewMembership);
			$this->dtgMembershipLog->AddColumn($this->colMedTrainingType);
			$this->dtgMembershipLog->AddColumn($this->colWillingMedVolunteer);
		}

		public function dtgMembershipLog_EditLinkColumn_Render(MembershipLog $objMembershipLog) {
			$membershipType='individual';
			if (!is_null($objMembershipLog->LogType)){
				if ($objMembershipLog->LogType!=88) $membershipType = MembershipLog::showMembershipType($objMembershipLog->LogType);
			}

			return $membershipType;
		}
	}
	// go to the centralized form executing access control function to run the form and check access control
	ACL_Run('MembershipLogs');
?>