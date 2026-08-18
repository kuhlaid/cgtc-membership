<?php
	/**
	 * This is the abstract Form class for the Create, Edit, and Delete functionality
	 * of the PartnerBusiness class.  This code-generated class
	 * contains all the basic Qform elements to display an HTML form that can
	 * manipulate a single PartnerBusiness object.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this PartnerBusinessEditFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class PartnerBusinessEditFormBase extends QForm {
		// General Form Variables
		protected $objPartnerBusiness;
		protected $strTitleVerb;
		protected $blnEditMode;

		// Controls for PartnerBusiness's Data Fields
		protected $lblId;
		protected $chkActive;
		protected $calVerifiedDiscountDate;
		protected $txtName;
		protected $txtDiscount;
		protected $txtPhone;
		protected $txtAddress;
		protected $txtHours;
		protected $txtWebsite;
		protected $txtUpdateResponse;

		// Other ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

		// Button Actions
		protected $btnSave;
		protected $btnCancel;
		protected $btnDelete;

		protected function SetupPartnerBusiness() {
			// Lookup Object PK information from Query String (if applicable)
			// Set mode to Edit or New depending on what's found
			$intId = QApplication::QueryString('intId');
			if (($intId)) {
				$this->objPartnerBusiness = PartnerBusiness::Load(($intId));

				if (!$this->objPartnerBusiness)
					throw new Exception('Could not find a PartnerBusiness object with PK arguments: ' . $intId);

				$this->strTitleVerb = QApplication::Translate('Edit');
				$this->blnEditMode = true;
			} else {
				$this->objPartnerBusiness = new PartnerBusiness();
				$this->strTitleVerb = QApplication::Translate('Create');
				$this->blnEditMode = false;
			}
		}

		protected function Form_Create() {
			// Call SetupPartnerBusiness to either Load/Edit Existing or Create New
			$this->SetupPartnerBusiness();

			// Create/Setup Controls for PartnerBusiness's Data Fields
			$this->lblId_Create();
			$this->chkActive_Create();
			$this->calVerifiedDiscountDate_Create();
			$this->txtName_Create();
			$this->txtDiscount_Create();
			$this->txtPhone_Create();
			$this->txtAddress_Create();
			$this->txtHours_Create();
			$this->txtWebsite_Create();
			$this->txtUpdateResponse_Create();

			// Create/Setup ListBoxes (if applicable) via Unique ReverseReferences and ManyToMany References

			// Create/Setup Button Action controls
			$this->btnSave_Create();
			$this->btnCancel_Create();
			$this->btnDelete_Create();
		}

		// Protected Create Methods
		// Create and Setup lblId
		protected function lblId_Create() {
			$this->lblId = new QLabel($this);
			$this->lblId->Name = QApplication::Translate('Id');
			if ($this->blnEditMode)
				$this->lblId->Text = $this->objPartnerBusiness->Id;
			else
				$this->lblId->Text = 'N/A';
		}

		// Create and Setup chkActive
		protected function chkActive_Create() {
			$this->chkActive = new QCheckBox($this);
			$this->chkActive->Name = QApplication::Translate('Active');
			$this->chkActive->Checked = $this->objPartnerBusiness->Active;
		}

		// Create and Setup calVerifiedDiscountDate
		protected function calVerifiedDiscountDate_Create() {
			$this->calVerifiedDiscountDate = new QDateTimePicker($this);
			$this->calVerifiedDiscountDate->Name = QApplication::Translate('Verified Discount Date');
			$this->calVerifiedDiscountDate->DateTime = $this->objPartnerBusiness->VerifiedDiscountDate;
			$this->calVerifiedDiscountDate->DateTimePickerType = QDateTimePickerType::Date;
		}

		// Create and Setup txtName
		protected function txtName_Create() {
			$this->txtName = new QTextBox($this);
			$this->txtName->Name = QApplication::Translate('Name');
			$this->txtName->Text = $this->objPartnerBusiness->Name;
			$this->txtName->Required = true;
			$this->txtName->MaxLength = PartnerBusiness::NameMaxLength;
		}

		// Create and Setup txtDiscount
		protected function txtDiscount_Create() {
			$this->txtDiscount = new QTextBox($this);
			$this->txtDiscount->Name = QApplication::Translate('Discount');
			$this->txtDiscount->Text = $this->objPartnerBusiness->Discount;
			$this->txtDiscount->MaxLength = PartnerBusiness::DiscountMaxLength;
		}

		// Create and Setup txtPhone
		protected function txtPhone_Create() {
			$this->txtPhone = new QTextBox($this);
			$this->txtPhone->Name = QApplication::Translate('Phone');
			$this->txtPhone->Text = $this->objPartnerBusiness->Phone;
			$this->txtPhone->MaxLength = PartnerBusiness::PhoneMaxLength;
		}

		// Create and Setup txtAddress
		protected function txtAddress_Create() {
			$this->txtAddress = new QTextBox($this);
			$this->txtAddress->Name = QApplication::Translate('Address');
			$this->txtAddress->Text = $this->objPartnerBusiness->Address;
			$this->txtAddress->MaxLength = PartnerBusiness::AddressMaxLength;
		}

		// Create and Setup txtHours
		protected function txtHours_Create() {
			$this->txtHours = new QTextBox($this);
			$this->txtHours->Name = QApplication::Translate('Hours');
			$this->txtHours->Text = $this->objPartnerBusiness->Hours;
			$this->txtHours->MaxLength = PartnerBusiness::HoursMaxLength;
		}

		// Create and Setup txtWebsite
		protected function txtWebsite_Create() {
			$this->txtWebsite = new QTextBox($this);
			$this->txtWebsite->Name = QApplication::Translate('Website');
			$this->txtWebsite->Text = $this->objPartnerBusiness->Website;
			$this->txtWebsite->MaxLength = PartnerBusiness::WebsiteMaxLength;
		}

		// Create and Setup txtUpdateResponse
		protected function txtUpdateResponse_Create() {
			$this->txtUpdateResponse = new QTextBox($this);
			$this->txtUpdateResponse->Name = QApplication::Translate('Update Response');
			$this->txtUpdateResponse->Text = $this->objPartnerBusiness->UpdateResponse;
			$this->txtUpdateResponse->MaxLength = PartnerBusiness::UpdateResponseMaxLength;
		}


		// Setup btnSave
		protected function btnSave_Create() {
			$this->btnSave = new QButton($this);
			$this->btnSave->Text = QApplication::Translate('Save');
			$this->btnSave->AddAction(new QClickEvent(), new QServerAction('btnSave_Click'));
			$this->btnSave->PrimaryButton = true;
			$this->btnSave->CausesValidation = true;
		}

		// Setup btnCancel
		protected function btnCancel_Create() {
			$this->btnCancel = new QButton($this);
			$this->btnCancel->Text = QApplication::Translate('Cancel');
			$this->btnCancel->AddAction(new QClickEvent(), new QServerAction('btnCancel_Click'));
			$this->btnCancel->CausesValidation = false;
		}

		// Setup btnDelete
		protected function btnDelete_Create() {
			$this->btnDelete = new QButton($this);
			$this->btnDelete->Text = QApplication::Translate('Delete');
			$this->btnDelete->AddAction(new QClickEvent(), new QConfirmAction(sprintf(QApplication::Translate('Are you SURE you want to DELETE this %s?'), 'PartnerBusiness')));
			$this->btnDelete->AddAction(new QClickEvent(), new QServerAction('btnDelete_Click'));
			$this->btnDelete->CausesValidation = false;
			if (!$this->blnEditMode)
				$this->btnDelete->Visible = false;
		}
		
		// Protected Update Methods
		protected function UpdatePartnerBusinessFields() {
			$this->objPartnerBusiness->Active = $this->chkActive->Checked;
			$this->objPartnerBusiness->VerifiedDiscountDate = $this->calVerifiedDiscountDate->DateTime;
			$this->objPartnerBusiness->Name = $this->txtName->Text;
			$this->objPartnerBusiness->Discount = $this->txtDiscount->Text;
			$this->objPartnerBusiness->Phone = $this->txtPhone->Text;
			$this->objPartnerBusiness->Address = $this->txtAddress->Text;
			$this->objPartnerBusiness->Hours = $this->txtHours->Text;
			$this->objPartnerBusiness->Website = $this->txtWebsite->Text;
			$this->objPartnerBusiness->UpdateResponse = $this->txtUpdateResponse->Text;
		}


		// Control ServerActions
		protected function btnSave_Click($strFormId, $strControlId, $strParameter) {
			$this->UpdatePartnerBusinessFields();
			$this->objPartnerBusiness->Save();


			$this->RedirectToListPage();
		}

		protected function btnCancel_Click($strFormId, $strControlId, $strParameter) {
			$this->RedirectToListPage();
		}

		protected function btnDelete_Click($strFormId, $strControlId, $strParameter) {

			$this->objPartnerBusiness->Delete();

			$this->RedirectToListPage();
		}
		
		protected function RedirectToListPage() {
			QApplication::Redirect('partner_business_list.php');
		}
	}
?>