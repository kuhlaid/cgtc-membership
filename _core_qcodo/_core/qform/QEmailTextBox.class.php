<?php
	// A subclass of TextBox with its validate method overridden -- Validate will also ensure
	// that the Text is a valid email address

	class QEmailTextBox extends QTextBoxBase {
		//////////
		// Methods
		//////////
		public function Validate() {
			if (parent::Validate()) {
				if ($this->strText != "") {
					// RegExp taken from php.net
					//if ( !preg_replace("/^[a-z0-9]+([_\\.-][a-z0-9]+)*"."@([a-z0-9]+([\.-][a-z0-9]{1,})+)*$", $this->strText, '') ) {
					
					// wpg - changed to use filter_var function after production server started complaining
					if (!filter_var($this->strText,FILTER_VALIDATE_EMAIL)) {
						$this->strValidationError = "Invalid e-mail address";
						return false;
					}
				}
			} else
				return false;

			$this->strValidationError = "";
			return true;
		}
	}
?>
