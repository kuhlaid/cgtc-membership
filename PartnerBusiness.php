<?php
/**
 * @abstract Partner businesses.
 * @author w. Patrick Gale
 *
 */
require('includes/prepend.inc.php');
require(__FORMBASE_CLASSES__ . '/PartnerBusinessEditFormBase.class.php');
QApplication::CheckRemoteAdmin();

class acx1PartnerBusinessEditForm extends PartnerBusinessEditFormBase {
	protected function SetupPartnerBusiness() {
		// Lookup Object PK information from Query String (if applicable)
		// Set mode to Edit or New depending on what's found
		$intId = QApplication::QueryString('intId');
		if (($intId)) {
			$this->objPartnerBusiness = PartnerBusiness::Load(($intId));

			if (!$this->objPartnerBusiness) {
				QSessionDB::set("error", "There was an error accessing the partner business. Try again.");
				QApplication::Redirect('MembershipList.php');
				exit;
			}

			$this->strTitleVerb = QApplication::Translate('Edit');
			$this->blnEditMode = true;
		} else {
			$this->objPartnerBusiness = new PartnerBusiness();
			$this->strTitleVerb = QApplication::Translate('Create');
			$this->blnEditMode = false;
		}
	}

	// Create and Setup calVerifiedDiscountDate
	protected function calVerifiedDiscountDate_Create() {
		$this->calVerifiedDiscountDate = new QJsCalendar($this);
		$this->calVerifiedDiscountDate->Name = QApplication::Translate('Verified Discount Date');
		$this->calVerifiedDiscountDate->DateTime = $this->objPartnerBusiness->VerifiedDiscountDate;
	}

	// Create and Setup txtName
	protected function txtName_Create() {
		$this->txtName = new QTextBox($this);
		$this->txtName->Name = QApplication::Translate('Business Name');
		$this->txtName->Text = $this->objPartnerBusiness->Name;
		$this->txtName->Width = '100%';
		$this->txtName->Required = true;
		$this->txtName->MaxLength = PartnerBusiness::NameMaxLength;
	}

	// Create and Setup txtDiscount
	protected function txtDiscount_Create() {
		$this->txtDiscount = new QTextBox($this);
		$this->txtDiscount->Name = QApplication::Translate('Discount');
		$this->txtDiscount->Text = $this->objPartnerBusiness->Discount;
		$this->txtDiscount->TextMode = QTextMode::MultiLine;
		$this->txtDiscount->Width = '100%';
		$this->txtDiscount_Length();
		$this->txtDiscount->AddAction(new QChangeEvent(), new QAjaxAction('txtDiscount_Length'));
	}

	protected function charLengthToLong() {
		QApplication::DisplayAlert('Increase the field size or decrease the characters entered in the field.');
	}
	protected function txtDiscount_Length() {
		$strlen = ((PartnerBusiness::DiscountMaxLength)-strlen(trim($this->txtDiscount->Text ?? '')));
		if ($strlen < 0) $this->charLengthToLong();
		$this->txtDiscount->HtmlAfter = "<b>".$strlen." characters left</b>";
	}

	// Create and Setup txtPhone
	protected function txtPhone_Create() {
		$this->txtPhone = new QTextBox($this);
		$this->txtPhone->Name = QApplication::Translate('Phone');
		$this->txtPhone->Text = $this->objPartnerBusiness->Phone;
		$this->txtPhone->TextMode = QTextMode::MultiLine;
		$this->txtPhone->Width = '100%';
		$this->txtPhone_Length();
		$this->txtPhone->AddAction(new QChangeEvent(), new QAjaxAction('txtPhone_Length'));
	}

	protected function txtPhone_Length() {
		$strlen = ((PartnerBusiness::PhoneMaxLength)-strlen(trim($this->txtPhone->Text ?? '')));
		if ($strlen < 0) $this->charLengthToLong();
		$this->txtPhone->HtmlAfter = "<b>".$strlen." characters left</b>";
	}

	// Create and Setup txtAddress
	protected function txtAddress_Create() {
		$this->txtAddress = new QTextBox($this);
		$this->txtAddress->Name = QApplication::Translate('Address');
		$this->txtAddress->Text = $this->objPartnerBusiness->Address;
		$this->txtAddress->TextMode = QTextMode::MultiLine;
		$this->txtAddress->Width = '100%';
		$this->txtAddress_Length();
		$this->txtAddress->AddAction(new QChangeEvent(), new QAjaxAction('txtAddress_Length'));
	}

	protected function txtAddress_Length() {
		$strlen = ((PartnerBusiness::AddressMaxLength)-strlen(trim($this->txtAddress->Text ?? '')));
		if ($strlen < 0) $this->charLengthToLong();
		$this->txtAddress->HtmlAfter = "<b>".$strlen." characters left</b>";
	}

	// Create and Setup txtHours
	protected function txtHours_Create() {
		$this->txtHours = new QTextBox($this);
		$this->txtHours->Name = QApplication::Translate('Hours');
		$this->txtHours->Text = $this->objPartnerBusiness->Hours;
		$this->txtHours->TextMode = QTextMode::MultiLine;
		$this->txtHours->Width = '100%';
		$this->txtHours_Length();
		$this->txtHours->AddAction(new QChangeEvent(), new QAjaxAction('txtHours_Length'));
	}

	protected function txtHours_Length() {
		$strlen = ((PartnerBusiness::HoursMaxLength)-strlen(trim($this->txtHours->Text ?? '')));
		if ($strlen < 0) $this->charLengthToLong();
		$this->txtHours->HtmlAfter = "<b>".$strlen." characters left</b>";
	}

	// Create and Setup txtWebsite
	protected function txtWebsite_Create() {
		$this->txtWebsite = new QTextBox($this);
		$this->txtWebsite->Name = QApplication::Translate('Website');
		$this->txtWebsite->Text = $this->objPartnerBusiness->Website;
		$this->txtWebsite->TextMode = QTextMode::MultiLine;
		$this->txtWebsite->Width = '100%';
		$this->txtWebsite_Length();
		$this->txtWebsite->AddAction(new QChangeEvent(), new QAjaxAction('txtWebsite_Length'));
	}

	protected function txtWebsite_Length() {
		$strlen = ((PartnerBusiness::WebsiteMaxLength)-strlen(trim($this->txtWebsite->Text ?? '')));
		if ($strlen < 0) $this->charLengthToLong();
		$this->txtWebsite->HtmlAfter = "<b>".$strlen." characters left</b>";
	}

	// Create and Setup txtUpdateResponse
	protected function txtUpdateResponse_Create() {
		$this->txtUpdateResponse = new QTextBox($this);
		$this->txtUpdateResponse->Name = QApplication::Translate('Update Response');
		$this->txtUpdateResponse->Text = $this->objPartnerBusiness->UpdateResponse;
		$this->txtUpdateResponse->Width = '100%';
		$this->txtUpdateResponse->TextMode = QTextMode::MultiLine;
		$this->txtUpdateResponse_Length();
		$this->txtUpdateResponse->AddAction(new QChangeEvent(), new QAjaxAction('txtUpdateResponse_Length'));
	}

	protected function txtUpdateResponse_Length() {
		$strlen = ((PartnerBusiness::UpdateResponseMaxLength)-strlen(trim($this->txtUpdateResponse->Text ?? '')));
		if ($strlen < 0) $this->charLengthToLong();
		$this->txtUpdateResponse->HtmlAfter = "<b>".$strlen." characters left</b>";
	}

	protected function RedirectToListPage() {
		QApplication::Redirect('PartnerBusinesses.php');
	}
}

ACL_Run('PartnerBusiness');
?>