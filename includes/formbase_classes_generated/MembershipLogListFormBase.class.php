<?php
	/**
	 * This is the abstract Form class for the List All functionality
	 * of the MembershipLog class.  This code-generated class
	 * contains a Qform datagrid to display an HTML page that can
	 * list a collection of MembershipLog objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this MembershipLogListFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class MembershipLogListFormBase extends QForm {
		protected $dtgMembershipLog;

		// DataGrid Columns
		protected $colEditLinkColumn;
		protected $colId;
		protected $colLogType;
		protected $colStartDate;
		protected $colExpireDate;
		protected $colPaymentType;
		protected $colPaymentAmount;
		protected $colPaidOn;
		protected $colNote;
		protected $colMemberId;
		protected $colTransferId;
		protected $colLogDate;
		protected $colNewMembership;
		protected $colMedTrainingType;
		protected $colWillingMedVolunteer;
		protected $colPayPalTransactionId;
		protected $colMembershipConsent;
		protected $colConsentSignature;


		protected function Form_Create() {
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgMembershipLog_EditLinkColumn_Render($_ITEM) ?>');
			$this->colEditLinkColumn->HtmlEntities = false;
			$this->colId = new QDataGridColumn(QApplication::Translate('Id'), '<?= $_ITEM->Id; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->Id, false)));
			$this->colLogType = new QDataGridColumn(QApplication::Translate('Log Type'), '<?= $_ITEM->LogType; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->LogType), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->LogType, false)));
			$this->colStartDate = new QDataGridColumn(QApplication::Translate('Start Date'), '<?= $_FORM->dtgMembershipLog_StartDate_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->StartDate), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->StartDate, false)));
			$this->colExpireDate = new QDataGridColumn(QApplication::Translate('Expire Date'), '<?= $_FORM->dtgMembershipLog_ExpireDate_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->ExpireDate), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->ExpireDate, false)));
			$this->colPaymentType = new QDataGridColumn(QApplication::Translate('Payment Type'), '<?= $_ITEM->PaymentType; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->PaymentType), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->PaymentType, false)));
			$this->colPaymentAmount = new QDataGridColumn(QApplication::Translate('Payment Amount'), '<?= $_ITEM->PaymentAmount; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->PaymentAmount), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->PaymentAmount, false)));
			$this->colPaidOn = new QDataGridColumn(QApplication::Translate('Paid On'), '<?= $_FORM->dtgMembershipLog_PaidOn_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->PaidOn), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->PaidOn, false)));
			$this->colNote = new QDataGridColumn(QApplication::Translate('Note'), '<?= QString::Truncate($_ITEM->Note, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->Note), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->Note, false)));
			$this->colMemberId = new QDataGridColumn(QApplication::Translate('Member Id'), '<?= $_FORM->dtgMembershipLog_MemberIdObject_Render($_ITEM); ?>');
			$this->colTransferId = new QDataGridColumn(QApplication::Translate('Transfer Id'), '<?= $_ITEM->TransferId; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->TransferId), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->TransferId, false)));
			$this->colLogDate = new QDataGridColumn(QApplication::Translate('Log Date'), '<?= $_FORM->dtgMembershipLog_LogDate_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->LogDate), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->LogDate, false)));
			$this->colNewMembership = new QDataGridColumn(QApplication::Translate('New Membership'), '<?= ($_ITEM->NewMembership) ? "true" : "false" ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->NewMembership), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->NewMembership, false)));
			$this->colMedTrainingType = new QDataGridColumn(QApplication::Translate('Med Training Type'), '<?= $_ITEM->MedTrainingType; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->MedTrainingType), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->MedTrainingType, false)));
			$this->colWillingMedVolunteer = new QDataGridColumn(QApplication::Translate('Willing Med Volunteer'), '<?= ($_ITEM->WillingMedVolunteer) ? "true" : "false" ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->WillingMedVolunteer), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->WillingMedVolunteer, false)));
			$this->colPayPalTransactionId = new QDataGridColumn(QApplication::Translate('Pay Pal Transaction Id'), '<?= QString::Truncate($_ITEM->PayPalTransactionId, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->PayPalTransactionId), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->PayPalTransactionId, false)));
			$this->colMembershipConsent = new QDataGridColumn(QApplication::Translate('Membership Consent'), '<?= $_FORM->dtgMembershipLog_MembershipConsent_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->MembershipConsent), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->MembershipConsent, false)));
			$this->colConsentSignature = new QDataGridColumn(QApplication::Translate('Consent Signature'), '<?= QString::Truncate($_ITEM->ConsentSignature, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MembershipLog()->ConsentSignature), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MembershipLog()->ConsentSignature, false)));

			// Setup DataGrid
			$this->dtgMembershipLog = new QDataGrid($this);
			$this->dtgMembershipLog->CellSpacing = 0;
			$this->dtgMembershipLog->CellPadding = 4;
			$this->dtgMembershipLog->BorderStyle = QBorderStyle::Solid;
			$this->dtgMembershipLog->BorderWidth = 1;
			$this->dtgMembershipLog->GridLines = QGridLines::Both;

			// Datagrid Paginator
			$this->dtgMembershipLog->Paginator = new QPaginator($this->dtgMembershipLog);
			$this->dtgMembershipLog->ItemsPerPage = 10;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgMembershipLog->UseAjax = false;

			// Specify the local databind method this datagrid will use
			$this->dtgMembershipLog->SetDataBinder('dtgMembershipLog_Bind');

			$this->dtgMembershipLog->AddColumn($this->colEditLinkColumn);
			$this->dtgMembershipLog->AddColumn($this->colId);
			$this->dtgMembershipLog->AddColumn($this->colLogType);
			$this->dtgMembershipLog->AddColumn($this->colStartDate);
			$this->dtgMembershipLog->AddColumn($this->colExpireDate);
			$this->dtgMembershipLog->AddColumn($this->colPaymentType);
			$this->dtgMembershipLog->AddColumn($this->colPaymentAmount);
			$this->dtgMembershipLog->AddColumn($this->colPaidOn);
			$this->dtgMembershipLog->AddColumn($this->colNote);
			$this->dtgMembershipLog->AddColumn($this->colMemberId);
			$this->dtgMembershipLog->AddColumn($this->colTransferId);
			$this->dtgMembershipLog->AddColumn($this->colLogDate);
			$this->dtgMembershipLog->AddColumn($this->colNewMembership);
			$this->dtgMembershipLog->AddColumn($this->colMedTrainingType);
			$this->dtgMembershipLog->AddColumn($this->colWillingMedVolunteer);
			$this->dtgMembershipLog->AddColumn($this->colPayPalTransactionId);
			$this->dtgMembershipLog->AddColumn($this->colMembershipConsent);
			$this->dtgMembershipLog->AddColumn($this->colConsentSignature);
		}
		
		public function dtgMembershipLog_EditLinkColumn_Render(MembershipLog $objMembershipLog) {
			return sprintf('<a href="membership_log_edit.php?intId=%s">%s</a>',
				$objMembershipLog->Id, 
				QApplication::Translate('Edit'));
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

		public function dtgMembershipLog_PaidOn_Render(MembershipLog $objMembershipLog) {
			if (!is_null($objMembershipLog->PaidOn))
				return $objMembershipLog->PaidOn->toString(QDateTime::FormatDisplayDate);
			else
				return null;
		}

		public function dtgMembershipLog_MemberIdObject_Render(MembershipLog $objMembershipLog) {
			if (!is_null($objMembershipLog->MemberIdObject))
				return $objMembershipLog->MemberIdObject->__toString();
			else
				return null;
		}

		public function dtgMembershipLog_LogDate_Render(MembershipLog $objMembershipLog) {
			if (!is_null($objMembershipLog->LogDate))
				return $objMembershipLog->LogDate->toString(QDateTime::FormatDisplayDate);
			else
				return null;
		}

		public function dtgMembershipLog_MembershipConsent_Render(MembershipLog $objMembershipLog) {
			if (!is_null($objMembershipLog->MembershipConsent))
				return $objMembershipLog->MembershipConsent->toString(QDateTime::FormatDisplayDateTime);
			else
				return null;
		}


		protected function dtgMembershipLog_Bind() {
			// Because we want to enable pagination AND sorting, we need to setup the $objClauses array to send to LoadAll()

			// Remember!  We need to first set the TotalItemCount, which will affect the calcuation of LimitClause below
			$this->dtgMembershipLog->TotalItemCount = MembershipLog::CountAll();

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
			$this->dtgMembershipLog->DataSource = MembershipLog::LoadAll($objClauses);
		}
	}
?>