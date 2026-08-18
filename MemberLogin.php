<?php
/**
 * @abstract Form use to send an email to the member with a link to login to their profile info.
 * @author w. Patrick Gale
 *
 * Jan. 4, 2018 - wpg
 * - allowing members to add alternate email addresses to their membership to allow others (family) to update their membership information
 *
 * Jan. 1, 2018 - wpg
 * - adding tracking of the type of login a member uses to access the application
 *
 * June 25, 2017 - wpg
 * - changing the encryption for the member login link
 *
 * June 13, 2017 - wpg
 * - changing the form to setup new members if they do not exist in our database
 *
 * April 23, 2017 - wpg
 * - setting up basic form
 */

// encrypt the member ID if we want
//

// echo "<p>Our data, encrypted:</p><pre>", print_r($enc, true), "</pre>";
// echo "<p>Our data, as the stream only, in hex:</p><tt>", MakeWrap(StrToHex($enc['output'])), "</tt>";

// $rawsize = strlen($enc['output'] ?? '');

// echo '<h2>After Restore</h2>';

// $dec_os1 = UnpackCrypt($os1['output'], $LocalKey, array('cipher' => 'twofish'));


// Include prepend.inc to load Qcodo
require('includes/prepend.inc.php');
require(__FORMBASE_CLASSES__ . '/MemberContactEditFormBase.class.php');
QApplication::CheckRemoteAdmin();

class acx2MemberLoginForm extends MemberContactEditFormBase {

	protected function SetupMemberContact() {
		// if the member is trying to login using a loginKey then let them in
		$loginKey = QApplication::QueryString('loginKey');
		// $binaryIv = hex2bin(__EMAIL_IV__); 
		$linkKeyArray = unserialize(openssl_decrypt(base64_decode($loginKey ?? ''), $_ENV['CIPHER_TYPE'], __EMAIL_KEY__, OPENSSL_RAW_DATA, __EMAIL_IV__) ?? '');

		if ($loginKey){
			// check to see if member already exists
			$objMemberContact = MemberContact::QuerySingle(
				QQ::AndCondition(
					QQ::OrCondition(
					QQ::Equal(QQN::MemberContact()->Email, trim($linkKeyArray[0] ?? '')),
					QQ::Equal(QQN::MemberContact()->GoogleEmail, trim($linkKeyArray[0] ?? '')),
					QQ::Equal(QQN::MemberContact()->FacebookEmail, trim($linkKeyArray[0] ?? ''))
					),
					QQ::Equal(QQN::MemberContact()->LastName, trim($linkKeyArray[1] ?? ''))
				)
			);

			// if the member has a valid email address then log them in
			// else save their email address and last name and ask them if they want to join the club
			if ($objMemberContact){
				MemberContact::SetMemberLoginAccess($objMemberContact->Email,3);
			}
			else {
				// set the new member session variables
				QSessionDB::set(__SESSION_PREFIX__.'__NEWMEMBER_LASTNAME__', $linkKeyArray[1]);
				QSessionDB::set(__SESSION_PREFIX__.'__NEWMEMBER_EMAIL__', $linkKeyArray[0]);
				QSessionDB::set('error',"Was not able to find member with last name ".$linkKeyArray[1]." and email ".$linkKeyArray[0]);
				QApplication::Redirect('index.php');
				exit;
			}
		}

	}


	protected function txtEmail_Create() {
		$this->txtEmail = new QEmailTextBox($this);
		$this->txtEmail->Name = QApplication::Translate('Email address used with membership');
		$this->txtEmail->MaxLength = MemberContact::EmailMaxLength;
		//$this->txtEmail->AddAction(new QChangeEvent(), new QAjaxAction('trimLeadingTrailing'));
		$this->txtEmail->Required = true;
		$this->txtEmail->Width = "300px";
	}

// 	public function trimLeadingTrailing($strFormId, $strControlId, $strParameter){
// 		// Let's see if the checkbox exists already
// 		$objComponent = $this->GetControl($strControlId);
// 		$objComponent->Text = trim($objComponent->Text ?? '');
// 	}

	protected function txtLastName_Create() {
		$this->txtLastName = new QTextBox($this);
		$this->txtLastName->Name = QApplication::Translate('Last Name');
		$this->txtLastName->Required = true;
		$this->txtLastName->Width = "100px";
	}

	protected function btnSave_Create() {
		$this->btnSave = new QButton($this);
		$this->btnSave->Text = QApplication::Translate('Continue >');
		$this->btnSave->AddAction(new QClickEvent(), new QServerAction('btnLogin_Click'));
		$this->btnSave->PrimaryButton = true;
		$this->btnSave->CausesValidation = true;
	}

	protected function btnLogin_Click($strFormId, $strControlId, $strParameter) {
		$this->RedirectToListPage();
	}

	protected function RedirectToListPage() {
		//error_log($this->txtEmail->Text.$this->txtLastName->Text);
		// send the email and last name
		$dataArray = array(trim(strtolower($this->txtEmail->Text ?? '')),trim(ucfirst($this->txtLastName->Text ?? '')));
		// we need to encode the data
		$linkKey = urlencode(base64_encode(openssl_encrypt(serialize($dataArray), $_ENV['CIPHER_TYPE'], __EMAIL_KEY__, OPENSSL_RAW_DATA,__EMAIL_IV__)));

		QApplication::Redirect('emailNotification.php?option=sendMemberLoginLink&loginKey='.$linkKey);
	}
}
acx2MemberLoginForm::Run('acx2MemberLoginForm', 'template/member_login.tpl.php');
?>