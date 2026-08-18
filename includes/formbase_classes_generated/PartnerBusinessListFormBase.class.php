<?php
	/**
	 * This is the abstract Form class for the List All functionality
	 * of the PartnerBusiness class.  This code-generated class
	 * contains a Qform datagrid to display an HTML page that can
	 * list a collection of PartnerBusiness objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this PartnerBusinessListFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class PartnerBusinessListFormBase extends QForm {
		protected $dtgPartnerBusiness;

		// DataGrid Columns
		protected $colEditLinkColumn;
		protected $colId;
		protected $colActive;
		protected $colVerifiedDiscountDate;
		protected $colName;
		protected $colDiscount;
		protected $colPhone;
		protected $colAddress;
		protected $colHours;
		protected $colWebsite;
		protected $colUpdateResponse;


		protected function Form_Create() {
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgPartnerBusiness_EditLinkColumn_Render($_ITEM) ?>');
			$this->colEditLinkColumn->HtmlEntities = false;
			$this->colId = new QDataGridColumn(QApplication::Translate('Id'), '<?= $_ITEM->Id; ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Id, false)));
			$this->colActive = new QDataGridColumn(QApplication::Translate('Active'), '<?= ($_ITEM->Active) ? "true" : "false" ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Active), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Active, false)));
			$this->colVerifiedDiscountDate = new QDataGridColumn(QApplication::Translate('Verified Discount Date'), '<?= $_FORM->dtgPartnerBusiness_VerifiedDiscountDate_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->VerifiedDiscountDate), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->VerifiedDiscountDate, false)));
			$this->colName = new QDataGridColumn(QApplication::Translate('Name'), '<?= QString::Truncate($_ITEM->Name, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Name), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Name, false)));
			$this->colDiscount = new QDataGridColumn(QApplication::Translate('Discount'), '<?= QString::Truncate($_ITEM->Discount, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Discount), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Discount, false)));
			$this->colPhone = new QDataGridColumn(QApplication::Translate('Phone'), '<?= QString::Truncate($_ITEM->Phone, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Phone), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Phone, false)));
			$this->colAddress = new QDataGridColumn(QApplication::Translate('Address'), '<?= QString::Truncate($_ITEM->Address, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Address), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Address, false)));
			$this->colHours = new QDataGridColumn(QApplication::Translate('Hours'), '<?= QString::Truncate($_ITEM->Hours, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Hours), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Hours, false)));
			$this->colWebsite = new QDataGridColumn(QApplication::Translate('Website'), '<?= QString::Truncate($_ITEM->Website, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Website), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Website, false)));
			$this->colUpdateResponse = new QDataGridColumn(QApplication::Translate('Update Response'), '<?= QString::Truncate($_ITEM->UpdateResponse, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->UpdateResponse), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->UpdateResponse, false)));

			// Setup DataGrid
			$this->dtgPartnerBusiness = new QDataGrid($this);
			$this->dtgPartnerBusiness->CellSpacing = 0;
			$this->dtgPartnerBusiness->CellPadding = 4;
			$this->dtgPartnerBusiness->BorderStyle = QBorderStyle::Solid;
			$this->dtgPartnerBusiness->BorderWidth = 1;
			$this->dtgPartnerBusiness->GridLines = QGridLines::Both;

			// Datagrid Paginator
			$this->dtgPartnerBusiness->Paginator = new QPaginator($this->dtgPartnerBusiness);
			$this->dtgPartnerBusiness->ItemsPerPage = 10;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgPartnerBusiness->UseAjax = false;

			// Specify the local databind method this datagrid will use
			$this->dtgPartnerBusiness->SetDataBinder('dtgPartnerBusiness_Bind');

			$this->dtgPartnerBusiness->AddColumn($this->colEditLinkColumn);
			$this->dtgPartnerBusiness->AddColumn($this->colId);
			$this->dtgPartnerBusiness->AddColumn($this->colActive);
			$this->dtgPartnerBusiness->AddColumn($this->colVerifiedDiscountDate);
			$this->dtgPartnerBusiness->AddColumn($this->colName);
			$this->dtgPartnerBusiness->AddColumn($this->colDiscount);
			$this->dtgPartnerBusiness->AddColumn($this->colPhone);
			$this->dtgPartnerBusiness->AddColumn($this->colAddress);
			$this->dtgPartnerBusiness->AddColumn($this->colHours);
			$this->dtgPartnerBusiness->AddColumn($this->colWebsite);
			$this->dtgPartnerBusiness->AddColumn($this->colUpdateResponse);
		}
		
		public function dtgPartnerBusiness_EditLinkColumn_Render(PartnerBusiness $objPartnerBusiness) {
			return sprintf('<a href="partner_business_edit.php?intId=%s">%s</a>',
				$objPartnerBusiness->Id, 
				QApplication::Translate('Edit'));
		}

		public function dtgPartnerBusiness_VerifiedDiscountDate_Render(PartnerBusiness $objPartnerBusiness) {
			if (!is_null($objPartnerBusiness->VerifiedDiscountDate))
				return $objPartnerBusiness->VerifiedDiscountDate->toString(QDateTime::FormatDisplayDate);
			else
				return null;
		}


		protected function dtgPartnerBusiness_Bind() {
			// Because we want to enable pagination AND sorting, we need to setup the $objClauses array to send to LoadAll()

			// Remember!  We need to first set the TotalItemCount, which will affect the calcuation of LimitClause below
			$this->dtgPartnerBusiness->TotalItemCount = PartnerBusiness::CountAll();

			// Setup the $objClauses Array
			$objClauses = array();

			// If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
			// the OrderByClause to the $objClauses array
			if ($objClause = $this->dtgPartnerBusiness->OrderByClause)
				array_push($objClauses, $objClause);

			// Add the LimitClause information, as well
			if ($objClause = $this->dtgPartnerBusiness->LimitClause)
				array_push($objClauses, $objClause);

			// Set the DataSource to be the array of all PartnerBusiness objects, given the clauses above
			$this->dtgPartnerBusiness->DataSource = PartnerBusiness::LoadAll($objClauses);
		}
	}
?>