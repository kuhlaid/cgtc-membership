<?php
	/*
	 * This class is INTENDED to be modified.  Please define any custom "Render"-based methods
	 * to handle custom global rendering functionality for all your controls.
	 *
	 * As an EXAMPLE, a RenderWithName method is included for you.  Feel free to modify this method,
	 * or to add as many of your own as you wish.
	 *
	 * Please note: All custom render methods should start with a RenderHelper call and end with a RenderOUtput call.
	 */
	abstract class QControl extends QControlBase {
		// This will call GetControlHtml() for the bulk of the work, but will add layout html as well.  It will include
		// the rendering of the Controls' name label, any errors or warnings, instructions, and html before/after (if specified).
		//
		// This one method can define how ALL controls should be rendered when "Rendered with Name" throughout the entire site.
		// For example:
		//			<Name>
		//			<HTML Before><Control><HTML After>
		//			<Instructions>
		//			<Error>
		//			<warning>
		public function RenderWithName($blnDisplayOutput = true) {
			////////////////////
			// Call RenderHelper
			$this->RenderHelper(func_get_args(), __FUNCTION__);
			////////////////////


			// Custom Render Functionality Here
			if ($this->strName) {
				if ($this->blnRequired)
					$strName = sprintf('<span class="required">%s</span>', $this->strName);	// wpg - replaced bold tags with style
				else
					$strName = sprintf('%s', $this->strName);
			} else
				$strName = '';

			try {
				if ($this->blnEnabled)
					$strClass = 'item_label';
				else
					$strClass = 'item_label_disabled';

				// For X/HTML Standards Compliance, we want to output the HTML for the Name as either a DIV or a SPAN
				// depending on whether or not this control is considered an X/HTML "Block" Element
				if ($this->blnIsBlockElement) {
					$strToReturn = sprintf('<div class="%s">%s</div>%s%s%s',
						$strClass,
						$strName,
						$this->strHtmlBefore,
						$this->GetControlHtml(),
						$this->strHtmlAfter);
				} else {
					$strToReturn = sprintf('<span class="%s">%s</span><br/>%s%s%s',
						$strClass,
						$strName,
						$this->strHtmlBefore,
						$this->GetControlHtml(),
						$this->strHtmlAfter);
				}
				// wpg - jquery alternative
				//QApplication::ExecuteJavaScript(sprintf("$('#".$this->strControlId."').validationEngine('validateField', '#".$this->strControlId."');", $this));
							
				if ($this->strInstructions)
					$strToReturn .= sprintf('<br /><span class="instructions">%s</span>', $this->strInstructions);

				if ($this->strValidationError)
					$strToReturn .= sprintf('<br /><span class="warning">%s</span>', $this->strValidationError);
				else if ($this->strWarning)
					$strToReturn .= sprintf('<br /><span class="warning">%s</span>', $this->strWarning);

				$strToReturn .= '<br />';
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			////////////////////////////////////////////
			// Call RenderOutput, Returning its Contents
			return $this->RenderOutput($strToReturn, $blnDisplayOutput);
			////////////////////////////////////////////
		}

		// This will call GetControlHtml() for the bulk of the work, but will add layout html as well.  It will include
		// the rendering of the Controls' name label, any errors or warnings, instructions, and html before/after (if specified).
		//
		// wpg - same function as above but does not display the name field (it is just used to show validation error)
		public function RenderNoName($blnDisplayOutput = true) {
			////////////////////
			// Call RenderHelper
			$this->RenderHelper(func_get_args(), __FUNCTION__);
			////////////////////


			// Custom Render Functionality Here
//			if ($this->strName) {
//				if ($this->blnRequired)
//					$strName = sprintf('<span class="required">%s</span>', $this->strName);	// wpg - replaced bold tags with style
//				else
//					$strName = sprintf('%s', $this->strName);
//			} else
//				
			$strName = '';

			try {
				if ($this->blnEnabled)
					$strClass = 'item_label';
				else
					$strClass = 'item_label_disabled';

				// For X/HTML Standards Compliance, we want to output the HTML for the Name as either a DIV or a SPAN
				// depending on whether or not this control is considered an X/HTML "Block" Element
				if ($this->blnIsBlockElement) {
					$strToReturn = sprintf('<div class="%s">%s</div>%s%s%s',
						$strClass,
						$strName,
						$this->strHtmlBefore,
						$this->GetControlHtml(),
						$this->strHtmlAfter);
				} else {
					$strToReturn = sprintf('<span class="%s">%s</span><br/>%s%s%s',
						$strClass,
						$strName,
						$this->strHtmlBefore,
						$this->GetControlHtml(),
						$this->strHtmlAfter);
				}
				// wpg - jquery alternative
				//QApplication::ExecuteJavaScript(sprintf("$('#".$this->strControlId."').validationEngine('validateField', '#".$this->strControlId."');", $this));

//				if ($this->strInstructions)
//					QApplication::ExecuteJavaScript(sprintf("$('#".$this->strControlId."').validationEngine('validateField', '#".$this->strControlId."');", $this));
//
//				if ($this->strValidationError)
//					QApplication::ExecuteJavaScript(sprintf("$('#".$this->strControlId."').validationEngine('validateField', '#".$this->strControlId."');", $this));
//				else if ($this->strWarning)
//					QApplication::ExecuteJavaScript(sprintf("$('#".$this->strControlId."').validationEngine('validateField', '#".$this->strControlId."');", $this));
					
					
				if ($this->strInstructions)
					$strToReturn .= sprintf('<br /><span class="instructions">%s</span>', $this->strInstructions);

				if ($this->strValidationError)
					$strToReturn .= sprintf('<br /><span class="warning">%s</span>', $this->strValidationError);
				else if ($this->strWarning)
					$strToReturn .= sprintf('<br /><span class="warning">%s</span>', $this->strWarning);

				$strToReturn .= '<br />';
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			////////////////////////////////////////////
			// Call RenderOutput, Returning its Contents
			return $this->RenderOutput("<a name='".$this->ControlId."'></a>".$strToReturn, $blnDisplayOutput);
			////////////////////////////////////////////
		}

		
			// This will call GetControlHtml() for the bulk of the work, but will add layout html as well.  It will include
		// the rendering of the Controls' name label, any errors or warnings, instructions, and html before/after (if specified).
		//
		// wpg - same function as above but does not display the name field (it is just used to show validation error)
		// and no breaks
		public function RenderNoNameNB($blnDisplayOutput = true) {
			////////////////////
			// Call RenderHelper
			$this->RenderHelper(func_get_args(), __FUNCTION__);
			////////////////////


			// Custom Render Functionality Here
//			if ($this->strName) {
//				if ($this->blnRequired)
//					$strName = sprintf('<span class="required">%s</span>', $this->strName);	// wpg - replaced bold tags with style
//				else
//					$strName = sprintf('%s', $this->strName);
//			} else
//				
			$strName = '';

			try {
				if ($this->blnEnabled)
					$strClass = 'item_label';
				else
					$strClass = 'item_label_disabled';

				// For X/HTML Standards Compliance, we want to output the HTML for the Name as either a DIV or a SPAN
				// depending on whether or not this control is considered an X/HTML "Block" Element
				if ($this->blnIsBlockElement) {
					$strToReturn = sprintf('<div class="%s">%s</div>%s%s%s',
						$strClass,
						$strName,
						$this->strHtmlBefore,
						$this->GetControlHtml(),
						$this->strHtmlAfter);
				} 
				// wpg - removed <span class="%s">%s</span><br/>%s%s%s
				else {
					$strToReturn = sprintf('<span class="%s">%s</span>%s%s%s',
						$strClass,
						$strName,
						$this->strHtmlBefore,
						$this->GetControlHtml(),
						$this->strHtmlAfter);
				}
				
				// wpg - jquery alternative
				//QApplication::ExecuteJavaScript(sprintf("$('#".$this->strControlId."').validationEngine('validateField', '#".$this->strControlId."');", $this));
				
//				if ($this->strInstructions)
//					QApplication::ExecuteJavaScript(sprintf("$('#".$this->strControlId."').validationEngine('validateField', '#".$this->strControlId."');", $this));
//
//				if ($this->strValidationError)
//					QApplication::ExecuteJavaScript(sprintf("$('#".$this->strControlId."').validationEngine('validateField', '#".$this->strControlId."');", $this));
//				else if ($this->strWarning)
//					QApplication::ExecuteJavaScript(sprintf("$('#".$this->strControlId."').validationEngine('validateField', '#".$this->strControlId."');", $this));
					
				if ($this->strInstructions)
					$strToReturn .= sprintf('<br /><span class="instructions">%s</span>', $this->strInstructions);

				if ($this->strValidationError)
					$strToReturn .= sprintf('<br /><span class="warning">%s</span>', $this->strValidationError);
				else if ($this->strWarning)
					$strToReturn .= sprintf('<br /><span class="warning">%s</span>', $this->strWarning);

			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			////////////////////////////////////////////
			// Call RenderOutput, Returning its Contents
			return $this->RenderOutput("<a name='".$this->ControlId."'></a>".$strToReturn, $blnDisplayOutput);
			////////////////////////////////////////////
		}
		

		// This will call GetControlHtml() for the bulk of the work, but will add layout html as well.  It will include
		// the rendering of the Controls' name label, any errors or warnings, instructions, and html before/after (if specified).
		//
		// This one method can define how ALL controls should be rendered when "Rendered with Name" throughout the entire site.
		// For example:
		//			<Name>
		//			<HTML Before><Control><HTML After>
		//			<Instructions>
		//			<Error>
		//			<warning>
		/**
		 * wpg - edited from original to specify if we want a break after the label or not (defaults to <br/>)
		 *
		 * @param unknown_type $blnDisplayOutput
		 * @param string $br
		 * @return html
		 */
		public function RenderNoBreaks($blnDisplayOutput = true) {
			////////////////////
			// Call RenderHelper
			$this->RenderHelper(func_get_args(), __FUNCTION__);
			////////////////////

			// Custom Render Functionality Here
			if ($this->strName) {
				if ($this->blnRequired)
					$strName = sprintf('<span class="required">%s</span>', $this->strName);	// wpg - replaced bold tags with style
				else
					$strName = sprintf('%s', $this->strName);
			} else
				$strName = '';

			try {
				if ($this->blnEnabled)
					$strClass = 'item_label';
				else
					$strClass = 'item_label_disabled';

				// For X/HTML Standards Compliance, we want to output the HTML for the Name as either a DIV or a SPAN
				// depending on whether or not this control is considered an X/HTML "Block" Element
				if ($this->blnIsBlockElement) {
					$strToReturn = sprintf('<div class="%s">%s</div>%s%s%s',
						$strClass,
						$strName,
						$this->strHtmlBefore,
						$this->GetControlHtml(),
						$this->strHtmlAfter);
				} else {
					$strToReturn = sprintf('<span class="%s">%s</span>%s%s%s',
						$strClass,
						$strName,
						$this->strHtmlBefore,
						$this->GetControlHtml(),
						$this->strHtmlAfter);
				}

				if ($this->strInstructions)
					$strToReturn .= sprintf('<br /><span class="instructions">%s</span>', $this->strInstructions);

				if ($this->strValidationError)
					$strToReturn .= sprintf('<br /><span class="warning">%s</span>', $this->strValidationError);
				else if ($this->strWarning)
					$strToReturn .= sprintf('<br /><span class="warning">%s</span>', $this->strWarning);

			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			////////////////////////////////////////////
			// Call RenderOutput, Returning its Contents
			return $this->RenderOutput("<a name='".$this->ControlId."'></a>".$strToReturn, $blnDisplayOutput);
			////////////////////////////////////////////
		}


		// This will call GetControlHtml() for the bulk of the work, but will add layout html as well.  It will include
		// the rendering of the Controls' name label, any errors or warnings, instructions, and html before/after (if specified).
		//
		// This one method can define how ALL controls should be rendered when "Rendered with Name" throughout the entire site.
		// For example:
		//			<Name>
		//			<HTML Before><Control><HTML After>
		//			<Instructions>
		//			<Error>
		//			<warning>
		/**
		 * wpg - edited from RenderNoBreaks to show html before and after all elements
		 *
		 * @param unknown_type $blnDisplayOutput
		 * @param string $br
		 * @return html
		 */
		public function RenderNoBreaksAlt($blnDisplayOutput = true) {
			////////////////////
			// Call RenderHelper
			$this->RenderHelper(func_get_args(), __FUNCTION__);
			////////////////////

			// Custom Render Functionality Here
			if ($this->strName) {
				if ($this->blnRequired)
					$strName = sprintf('<span class="required">%s</span>', $this->strName);	// wpg - replaced bold tags with style
				else
					$strName = sprintf('%s', $this->strName);
			} else
				$strName = '';

			try {
				if ($this->blnEnabled)
					$strClass = 'item_label';
				else
					$strClass = 'item_label_disabled';

				// For X/HTML Standards Compliance, we want to output the HTML for the Name as either a DIV or a SPAN
				// depending on whether or not this control is considered an X/HTML "Block" Element
				if ($this->blnIsBlockElement) {
					$strToReturn = sprintf('%s<div class="%s">%s</div>%s%s',
						$this->strHtmlBefore,
						$strClass,
						$strName,
						$this->GetControlHtml(),
						$this->strHtmlAfter);
				} else {
					$strToReturn = sprintf('%s<span class="%s">%s</span>%s%s',
						$this->strHtmlBefore,
						$strClass,
						$strName,
						$this->GetControlHtml(),
						$this->strHtmlAfter);
				}

				if ($this->strInstructions)
					$strToReturn .= sprintf('<br /><span class="instructions">%s</span>', $this->strInstructions);

				if ($this->strValidationError)
					$strToReturn .= sprintf('<br /><span class="warning">%s</span>', $this->strValidationError);
				else if ($this->strWarning)
					$strToReturn .= sprintf('<br /><span class="warning">%s</span>', $this->strWarning);

			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			////////////////////////////////////////////
			// Call RenderOutput, Returning its Contents
			return $this->RenderOutput("<a name='".$this->ControlId."'></a>".$strToReturn, $blnDisplayOutput);
			////////////////////////////////////////////
		}


//		public function RenderNoBreaks_NoValidation($blnDisplayOutput = true) {
//			////////////////////
//			// Call RenderHelper
//			$this->RenderHelper(func_get_args(), __FUNCTION__);
//			////////////////////
//
//			// Custom Render Functionality Here
//			if ($this->strName) {
//				if ($this->blnRequired)
//					$strName = sprintf('<span class="required">%s</span>', $this->strName);	// wpg - replaced bold tags with style
//				else
//					$strName = sprintf('%s', $this->strName);
//			} else
//				$strName = '';
//
//			try {
//				if ($this->blnEnabled)
//					$strClass = 'item_label';
//				else
//					$strClass = 'item_label_disabled';
//
//				// For X/HTML Standards Compliance, we want to output the HTML for the Name as either a DIV or a SPAN
//				// depending on whether or not this control is considered an X/HTML "Block" Element
//				if ($this->blnIsBlockElement) {
//					$strToReturn = sprintf('<div class="%s">%s</div>%s%s%s',
//						$strClass,
//						$strName,
//						$this->strHtmlBefore,
//						$this->GetControlHtml(),
//						$this->strHtmlAfter);
//				} else {
//					$strToReturn = sprintf('<span class="%s">%s</span>%s%s%s',
//						$strClass,
//						$strName,
//						$this->strHtmlBefore,
//						$this->GetControlHtml(),
//						$this->strHtmlAfter);
//				}
//
//				if ($this->strInstructions)
//					$strToReturn .= sprintf('<br /><span class="instructions">%s</span>', $this->strInstructions);
//
////				if ($this->strValidationError)
////					$strToReturn .= sprintf('<br /><span class="warning">%s</span>', $this->strValidationError);
//				else if ($this->strWarning)
//					$strToReturn .= sprintf('<br /><span class="warning">%s</span>', $this->strWarning);
//
//			} catch (QCallerException $objExc) {
//				$objExc->IncrementOffset();
//				throw $objExc;
//			}
//
//			////////////////////////////////////////////
//			// Call RenderOutput, Returning its Contents
//			return $this->RenderOutput($strToReturn, $blnDisplayOutput);
//			////////////////////////////////////////////
//		}


		/**
		 * wpg - Same as RenderPlain but does not push output
		 *
		 * @param unknown_type $blnDisplayOutput
		 * @return simple string
		 */
		public function PreBuild() {

			////////////////////
			// Call RenderHelper
			$this->RenderHelper(func_get_args(), __FUNCTION__);
			////////////////////

			try {
				// Custom Render Functionality Here
				return $this->GetControlHtml();

			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		}

		public function ShowHtml($html, $blnDisplayOutput = true) {
			////////////////////////////////////////////
			// Call RenderOutput, Returning its Contents
			return $this->RenderOutput($html, $blnDisplayOutput);
			////////////////////////////////////////////
		}

		/**
		 * wpg - Simple control rendering for things that we do not want an html wrapper around
		 *
		 * @param unknown_type $blnDisplayOutput
		 * @return simple string
		 */
		public function RenderPlain($blnDisplayOutput = true) {
			////////////////////
			// Call RenderHelper
			$this->RenderHelper(func_get_args(), __FUNCTION__);
			////////////////////

			try {
				// Custom Render Functionality Here
				$strToReturn = $this->GetControlHtml();

			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
			////////////////////////////////////////////
			// Call RenderOutput, Returning its Contents
			return $this->RenderOutput("<a name='".$this->ControlId."'></a>".$strToReturn, $blnDisplayOutput);
			////////////////////////////////////////////
		}
		
		public function RenderRaw($blnDisplayOutput = true) {
			// Call RenderHelper
			$this->RenderHelper(func_get_args(), __FUNCTION__);
			
			try {
				$strOutput = $this->GetControlHtml();
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}

			// wpg - Call RenderOutputNW to keep wrapper off of control
			return $this->RenderOutputNW("<a name='".$this->ControlId."'></a>".$strOutput, $blnDisplayOutput);
		}
		
		// wpg - render just raw text from the control
		public function RenderText($blnDisplayOutput = true) {
			// Call RenderHelper
			$this->RenderHelper(func_get_args(), __FUNCTION__);
				
			try {
				$strOutput = $this->GetControlHtml();
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		
			// wpg - Call RenderOutputNW to keep wrapper off of control
			return $this->RenderOutputNW($strOutput, $blnDisplayOutput);
		}
		
		/**
		 * wpg - render output without the span or div wrapper
		 * @param unknown_type $strOutput
		 * @param unknown_type $blnDisplayOutput
		 * @param unknown_type $blnForceAsBlockElement
		 */
		protected function RenderOutputNW($strOutput, $blnDisplayOutput, $blnForceAsBlockElement = false) {
			// Output or Return
			if ($blnDisplayOutput)
				print($strOutput);
			else
				return $strOutput;

		}
		
		/**
		 * @author w. Patrick Gale (Jan 2013)
		 * @abstract A copy of RenderWithName function but used for checkbox display for print purposes
		 * @param unknown_type $blnDisplayOutput
		 * @throws QCallerException
		 * @return string
		 */
		public function RenderInputWithName($blnDisplayOutput = true) {
			////////////////////
			// Call RenderHelper
			$this->RenderHelper(func_get_args(), __FUNCTION__);
			////////////////////
		
		
			// Custom Render Functionality Here
			if ($this->strName) {
				if ($this->blnRequired)
					$strName = sprintf('<span class="required">%s</span>', $this->strName);	// wpg - replaced bold tags with style
				else
					$strName = sprintf('%s', $this->strName);
			} else
				$strName = '';
		
			try {
				if ($this->blnEnabled)
					$strClass = 'item_label';
				else
					$strClass = 'item_label_disabled';
		
				$strToReturn = sprintf('<div class="%s"><span class="%s">%s</span>%s%s%s</div>',
							$this->CssClass,
							$strClass,
							$strName,
							$this->strHtmlBefore,
							$this->GetControlHtml(),
							$this->strHtmlAfter);

				if ($this->strInstructions)
					$strToReturn .= sprintf('<br /><span class="instructions">%s</span>', $this->strInstructions);
		
				if ($this->strValidationError)
					$strToReturn .= sprintf('<br /><span class="warning">%s</span>', $this->strValidationError);
				else if ($this->strWarning)
					$strToReturn .= sprintf('<br /><span class="warning">%s</span>', $this->strWarning);
		
				$strToReturn .= '<br />';
			} catch (QCallerException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
		
			////////////////////////////////////////////
			// Call RenderOutput, Returning its Contents
			return $this->RenderOutput($strToReturn, $blnDisplayOutput);
			////////////////////////////////////////////
		}
	}
?>