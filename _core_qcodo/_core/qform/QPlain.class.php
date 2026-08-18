<?php
/**
 * wpg - Plain component that does not have html wrappers around it.  Can be used for creating dynamic css for example.
 * The RenderOutput function was overridden so that no html wrappers are placed around it.
 * I just used the QLabel class as a base in creating this component.
 *
 * FUTURE CHANGES:
 * - may add back in the HtmlBefore and HtmlAfter variables so that we can create a style or javascript wrapper with it instead
 * of hard coding into the html templates (if that is what we are using this component for)
 */
	class QPlain extends QBlockControl {
		///////////////////////////
		// Private Member Variables
		///////////////////////////
		protected $strTagName = '';
		protected $blnHtmlEntities = false;
		
		// just return the text sent to the control
		protected function GetControlHtml() {
			return $this->strText;
		}
		
		// just display or don't display the text
		protected function RenderOutput($strOutput, $blnDisplayOutput, $blnForceAsBlockElement = false) {
			// First, let's mark this control as being rendered and is ON the Page
			$this->blnRendering = false;
			$this->blnRendered = true;
			$this->blnOnPage = true;

			// Check for Visibility
			if (!$this->blnVisible)
				$strOutput = '';

			// Output or Return
			if ($blnDisplayOutput)
				print($strOutput);
			else
				return $strOutput;
		}
	}
?>