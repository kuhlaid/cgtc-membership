<?php
/**
 * @abstract Partner businesses.
 * @author w. Patrick Gale
 *
 * May 6, 2017 - wpg
 * - adding business representative member
 *
 */
require('includes/prepend.inc.php');
require(__FORMBASE_CLASSES__ . '/PartnerBusinessListFormBase.class.php');
QApplication::CheckRemoteAdmin();

class acx1PartnerBusinessListForm extends PartnerBusinessListFormBase {
	protected $colBusniessRep;
	protected function Form_Create() {
		// Setup DataGrid Columns
		$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgPartnerBusiness_EditLinkColumn_Render($_ITEM) ?>');
		$this->colId = new QDataGridColumn(QApplication::Translate('Id'), '<?= $_ITEM->Id; ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Id, false)));
		$this->colActive = new QDataGridColumn(QApplication::Translate('Active'), '<?= ($_ITEM->Active) ? "true" : "false" ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Active), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Active, false)));
		$this->colVerifiedDiscountDate = new QDataGridColumn(QApplication::Translate('Last Verified Discount Date'), '<?= $_FORM->dtgPartnerBusiness_VerifiedDiscountDate_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->VerifiedDiscountDate), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->VerifiedDiscountDate, false)));
		$this->colName = new QDataGridColumn(QApplication::Translate('Name'), '<?= QString::Truncate($_ITEM->Name, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Name), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Name, false)));
		$this->colDiscount = new QDataGridColumn(QApplication::Translate('Discount'), '<?= QString::Truncate($_ITEM->Discount, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Discount), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Discount, false)));
		$this->colPhone = new QDataGridColumn(QApplication::Translate('Phone'), '<?= QString::Truncate($_ITEM->Phone, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Phone), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Phone, false)));
		$this->colAddress = new QDataGridColumn(QApplication::Translate('Address'), '<?= QString::Truncate($_ITEM->Address, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Address), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Address, false)));
		$this->colHours = new QDataGridColumn(QApplication::Translate('Hours'), '<?= QString::Truncate($_ITEM->Hours, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Hours), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Hours, false)));
		$this->colWebsite = new QDataGridColumn(QApplication::Translate('Website'), '<?= QString::Truncate($_ITEM->Website, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Website), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->Website, false)));
		$this->colUpdateResponse = new QDataGridColumn(QApplication::Translate('Last Update Response'), '<?= QString::Truncate($_ITEM->UpdateResponse, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->UpdateResponse), 'ReverseOrderByClause' => QQ::OrderBy(QQN::PartnerBusiness()->UpdateResponse, false)));
		$this->colBusniessRep = new QDataGridColumn(QApplication::Translate('Business Rep.'), '<?= $_FORM->dtgPartnerBusiness_BusniessRepColumn_Render($_ITEM) ?>');
		$this->colBusniessRep->HtmlEntities = $this->colEditLinkColumn->HtmlEntities = false;

		// Setup DataGrid
		$this->dtgPartnerBusiness = new QDataGrid($this);
		$this->dtgPartnerBusiness->CellSpacing = 0;
		$this->dtgPartnerBusiness->CellPadding = 4;
		$this->dtgPartnerBusiness->BorderStyle = QBorderStyle::Solid;
		$this->dtgPartnerBusiness->BorderWidth = 1;
		$this->dtgPartnerBusiness->GridLines = QGridLines::Both;
		$this->dtgPartnerBusiness->CssClass='table table-bordered';

		// Datagrid Paginator
		$this->dtgPartnerBusiness->Paginator = new QPaginator($this->dtgPartnerBusiness);
		$this->dtgPartnerBusiness->ItemsPerPage = __ITEMS_PER_PAGE__;

		// Specify Whether or Not to Refresh using Ajax
		$this->dtgPartnerBusiness->UseAjax = false;

		// Specify the local databind method this datagrid will use
		$this->dtgPartnerBusiness->SetDataBinder('dtgPartnerBusiness_Bind');

		$this->dtgPartnerBusiness->AddColumn($this->colEditLinkColumn);
		$this->dtgPartnerBusiness->AddColumn($this->colName);
		$this->dtgPartnerBusiness->AddColumn($this->colBusniessRep);
		$this->dtgPartnerBusiness->AddColumn($this->colDiscount);
		$this->dtgPartnerBusiness->AddColumn($this->colPhone);
		$this->dtgPartnerBusiness->AddColumn($this->colAddress);
		$this->dtgPartnerBusiness->AddColumn($this->colHours);
		$this->dtgPartnerBusiness->AddColumn($this->colWebsite);
		$this->dtgPartnerBusiness->AddColumn($this->colActive);
		$this->dtgPartnerBusiness->AddColumn($this->colVerifiedDiscountDate);
		$this->dtgPartnerBusiness->AddColumn($this->colUpdateResponse);
	}

	public function dtgPartnerBusiness_EditLinkColumn_Render(PartnerBusiness $objPartnerBusiness) {
		return sprintf('<a href="PartnerBusiness.php?intId=%s">%s</a>',
				$objPartnerBusiness->Id,
				QApplication::Translate('Edit'));
	}

	public function dtgPartnerBusiness_BusniessRepColumn_Render(PartnerBusiness $objPartnerBusiness) {
		return BusinessMemberAssoc::MemberRepresentative($objPartnerBusiness->Id,true);
	}
}

// go to the centralized form executing access control function to run the form and check access control
ACL_Run('PartnerBusinesses');
?>