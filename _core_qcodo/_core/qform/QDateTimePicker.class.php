<?php
	// This class is meant to be a date-picker.  It will essentially render an uneditable HTML textbox
	// as well as a calendar icon.  The idea is that if you click on the icon or the textbox,
	// it will pop up a calendar in a new small window.
	// * "Date" is a Date object for the specified date.

	class QDateTimePicker extends QControl {
		///////////////////////////
		// Private Member Variables
		///////////////////////////

		// MISC
		protected $dttDateTime = null;
		protected $strDateTimePickerType = QDateTimePickerType::Date;
		protected $strDateTimePickerFormat = QDateTimePickerFormat::MonthDayYear;

		// wpg - added minute interval so we can control if we only want to show every 15 minutes, 30 minutes
		protected $intMinuteInterval = 1;

		// wpg - added to let us control the min and max minutes
		protected $intMinimumMinute = 0;
		protected $intMaximumMinute = 59;

		// wpg - added to let us control the min and max hours
		protected $intMinimumHour = 0;
		protected $intMaximumHour = 23;	// set using military hours (24 hour clock and not 12 hour clock)

		protected $intMinimumYear = 1970;
		protected $intMaximumYear = 2020;

		protected $strFormat = QDateTime::FormatDisplayDateTime;

		protected $intSelectedMonth = null;
		protected $intSelectedDay = null;
		protected $intSelectedYear = null;

		// wpg - flag for not null minutes
		protected $blnMinutesRequired = false;

		// SETTINGS
		protected $strJavaScripts = '_core/date_time_picker.js';

		//////////
		// Methods
		//////////
		public function ParsePostData() {
			$dttNewDateTime = new QDateTime();

			// Update Date Component
			switch ($this->strDateTimePickerType) {
				case QDateTimePickerType::Date:
				case QDateTimePickerType::DateTime:
				case QDateTimePickerType::DateTimeSeconds:
					$strKey = $this->strControlId . '_lstMonth';
					if (array_key_exists($strKey, $_POST))
						$intMonth = $_POST[$strKey];
					else
						$intMonth = null;

					$strKey = $this->strControlId . '_lstDay';
					if (array_key_exists($strKey, $_POST))
						$intDay = $_POST[$strKey];
					else
						$intDay = null;

					$strKey = $this->strControlId . '_lstYear';
					if (array_key_exists($strKey, $_POST))
						$intYear = $_POST[$strKey];
					else
						$intYear = null;

					$this->intSelectedMonth = $intMonth;
					$this->intSelectedDay = $intDay;
					$this->intSelectedYear = $intYear;

					if (strlen($intYear ?? '') && strlen($intMonth ?? '') && strlen($intDay ?? ''))
						$dttNewDateTime->setDate($intYear, $intMonth, $intDay);
					else
						$dttNewDateTime->Year = null;
					break;
			}

			// Update Time Component
			switch ($this->strDateTimePickerType) {
				case QDateTimePickerType::Time:
				case QDateTimePickerType::TimeSeconds:
				case QDateTimePickerType::DateTime:
				case QDateTimePickerType::DateTimeSeconds:
					$strKey = $this->strControlId . '_lstHour';
					if (array_key_exists($strKey, $_POST)) {
						$intHour = $_POST[$strKey];
						if (strlen($intHour ?? '')) {
							$intHour = $_POST[$this->strControlId . '_lstHour'];
							$intMinute = $_POST[$this->strControlId . '_lstMinute'];
							$intSecond = 0;
							if (($this->strDateTimePickerType == QDateTimePickerType::TimeSeconds) ||
								($this->strDateTimePickerType == QDateTimePickerType::DateTimeSeconds))
								$intSecond = $_POST[$this->strControlId . '_lstSecond'];

							if (strlen($intHour ?? '') && strlen($intMinute ?? '') && strlen($intSecond ?? ''))
								$dttNewDateTime->setTime($intHour, $intMinute, $intSecond);
							else
								$dttNewDateTime->Hour = null;
						}
					}
					break;
			}

			// Update local intTimestamp
			$this->dttDateTime = $dttNewDateTime;
		}

		public function GetJavaScriptAction() {
			return "onchange";
		}

		protected function GetControlHtml() {
			$strAttributes = $this->GetAttributes();

			$strStyle = $this->GetStyleAttributes();
			if ($strStyle)
				$strAttributes .= sprintf(' style="%s"', $strStyle);

			if ($this->dttDateTime) {
				$dttDateTime = $this->dttDateTime;
			} else {
				$dttDateTime = new QDateTime();
			}

			// wpg - added to see if we can easily switch from input forms to read only print forms
			// wpg - else if we want view only then just show textboxes
			// I added a FormatDisplay variable so we can define the format of the label
			if ($this->blnLabelMode){
				$strToReturn = sprintf('<span name="%s" id="%s" %s%s>%s</span>',
						$this->strControlId,
						$this->strControlId,
						$this->GetAttributes(),
						$strStyle,
						QApplication::HtmlEntities($this->DateTime->toString($this->FormatDisplay)));
				return $strToReturn;
			}
			elseif ($this->blnViewOnlyMode){
				return '<input value="" size="3" maxlength="2" type="text"> hour :<input value="" size="3" maxlength="2" type="text"> minute';
			}
			else {
				$strCommand = sprintf(' onchange="Qcodo__DateTimePicker_Change(\'%s\', this);"', $this->strControlId);

				$strToReturn = '';

				// Generate Date-portion
				switch ($this->strDateTimePickerType) {
					case QDateTimePickerType::Date:
					case QDateTimePickerType::DateTime:
					case QDateTimePickerType::DateTimeSeconds:
						// Month
						$strMonthListbox = sprintf('<select name="%s_lstMonth" id="%s_lstMonth"%s%s>', $this->strControlId, $this->strControlId, $strAttributes, $strCommand);
						if (!$this->blnRequired || $dttDateTime->IsDateNull())
							$strMonthListbox .= '<option value="">--</option>';
						for ($intMonth = 1; $intMonth <= 12; $intMonth++) {
							if ((!$dttDateTime->IsDateNull() && ($dttDateTime->Month == $intMonth)) || ($this->intSelectedMonth == $intMonth))
								$strSelected = ' selected="selected"';
							else
								$strSelected = '';
							$strMonthListbox .= sprintf('<option value="%s"%s>%s</option>',
								$intMonth,
								$strSelected,
								date('M', mktime(0, 0, 0, $intMonth, 1, 2000)));
						}
						$strMonthListbox .= '</select>';

						// Day
						$strDayListbox = sprintf('<select name="%s_lstDay" id="%s_lstDay"%s%s>', $this->strControlId, $this->strControlId, $strAttributes, $strCommand);
						if (!$this->blnRequired || $dttDateTime->IsDateNull())
							$strDayListbox .= '<option value="">--</option>';
						if ($dttDateTime->IsDateNull()) {
							if ($this->blnRequired) {
								// New DateTime, but we are required -- therefore, let's assume January is preselected
								for ($intDay = 1; $intDay <= 31; $intDay++) {
									$strDayListbox .= sprintf('<option value="%s">%s</option>', $intDay, $intDay);
								}
							} else {
								// New DateTime -- but we are NOT required

								// See if a month has been selected yet.
								if ($this->intSelectedMonth) {
									$intSelectedYear = ($this->intSelectedYear) ? $this->intSelectedYear : 2000;
									$intDaysInMonth = date('t', mktime(0, 0, 0, $this->intSelectedMonth, 1, $intSelectedYear));
									for ($intDay = 1; $intDay <= $intDaysInMonth; $intDay++) {
										if (($dttDateTime->Day == $intDay) || ($this->intSelectedDay == $intDay))
											$strSelected = ' selected="selected"';
										else
											$strSelected = '';
										$strDayListbox .= sprintf('<option value="%s"%s>%s</option>',
											$intDay,
											$strSelected,
											$intDay);
									}
								} else {
									// It's ok just to have the "--" marks and nothing else
								}
							}
						} else {
							$intDaysInMonth = $dttDateTime->PHPDate('t');
							for ($intDay = 1; $intDay <= $intDaysInMonth; $intDay++) {
								if (($dttDateTime->Day == $intDay) || ($this->intSelectedDay == $intDay))
									$strSelected = ' selected="selected"';
								else
									$strSelected = '';
								$strDayListbox .= sprintf('<option value="%s"%s>%s</option>',
									$intDay,
									$strSelected,
									$intDay);
							}
						}
						$strDayListbox .= '</select>';

						// Year
						$strYearListbox = sprintf('<select name="%s_lstYear" id="%s_lstYear"%s%s>', $this->strControlId, $this->strControlId, $strAttributes, $strCommand);
						if (!$this->blnRequired || $dttDateTime->IsDateNull())
							$strYearListbox .= '<option value="">--</option>';
						for ($intYear = $this->intMinimumYear; $intYear <= $this->intMaximumYear; $intYear++) {
							if (/*!$dttDateTime->IsDateNull() && */(($dttDateTime->Year == $intYear) || ($this->intSelectedYear == $intYear)))
								$strSelected = ' selected="selected"';
							else
								$strSelected = '';
							$strYearListbox .= sprintf('<option value="%s"%s>%s</option>', $intYear, $strSelected, $intYear);
						}
						$strYearListbox .= '</select>';

						// Put it all together
						switch ($this->strDateTimePickerFormat) {
							case QDateTimePickerFormat::MonthDayYear:
								$strToReturn .= $strMonthListbox . '&nbsp;' . $strDayListbox . '&nbsp;' . $strYearListbox;
								break;
							case QDateTimePickerFormat::DayMonthYear:
								$strToReturn .= $strDayListbox . '&nbsp;' . $strMonthListbox . '&nbsp;' . $strYearListbox;
								break;
							case QDateTimePickerFormat::YearMonthDay:
								$strToReturn .= $strYearListbox . '&nbsp;' . $strMonthListbox . '&nbsp;' . $strDayListbox;
								break;
						}
				}

				switch ($this->strDateTimePickerType) {
					case QDateTimePickerType::DateTime:
					case QDateTimePickerType::DateTimeSeconds:
						$strToReturn .= '&nbsp;&nbsp;&nbsp;';
				}

				switch ($this->strDateTimePickerType) {
					case QDateTimePickerType::Time:
					case QDateTimePickerType::TimeSeconds:
					case QDateTimePickerType::DateTime:
					case QDateTimePickerType::DateTimeSeconds:
						// Hour
						$strHourListBox = sprintf('<select name="%s_lstHour" id="%s_lstHour"%s>', $this->strControlId, $this->strControlId, $strAttributes);
						if (!$this->blnRequired || $dttDateTime->IsTimeNull())
							$strHourListBox .= '<option value="">--</option>';

						$intHour = $this->intMinimumHour;
						$count = 0;
						// wpg - specify what minute range should be built
						while ($intHour <= $this->intMaximumHour) {
							if (!$dttDateTime->IsTimeNull() && ($dttDateTime->Hour == $intHour))
								$strSelected = ' selected="selected"';
							else
								$strSelected = '';
							$strHourListBox .= sprintf('<option value="%s"%s>%s</option>',
								$intHour,
								$strSelected,
								date('g A', mktime($intHour, 0, 0, 1, 1, 2000)));

							$intHour++;

							$count++;
							if ($count > 24) break;	// wpg - emergency exit
						}
						$strHourListBox .= '</select>';


						// Minute
						$strMinuteListBox = sprintf('<select name="%s_lstMinute" id="%s_lstMinute"%s>', $this->strControlId, $this->strControlId, $strAttributes);

						// wpg - changed to include the minutes required flag so we can default the minutes to 00 if we want
						if ((!$this->blnRequired || $dttDateTime->IsTimeNull()) && !$this->blnMinutesRequired)
							$strMinuteListBox .= '<option value="">--</option>';

						$intMinute = $this->intMinimumMinute;
						$count = 0;
						// wpg - specify what minute range should be built
						while ($intMinute <= $this->intMaximumMinute) {
							if (!$dttDateTime->IsTimeNull() && ($dttDateTime->Minute == $intMinute))
								$strSelected = ' selected="selected"';
							else
								$strSelected = '';
							$strMinuteListBox .= sprintf('<option value="%s"%s>%02d</option>',
								$intMinute,
								$strSelected,
								$intMinute);
							$intMinute = $intMinute+$this->intMinuteInterval;

							$count++;
							if ($count > 61) break;	// wpg - emergency exit
						}

						$strMinuteListBox .= '</select>';


						// Seconds
						$strSecondListBox = sprintf('<select name="%s_lstSecond" id="%s_lstSecond"%s>', $this->strControlId, $this->strControlId, $strAttributes);
						if (!$this->blnRequired || $dttDateTime->IsTimeNull())
							$strSecondListBox .= '<option value="">--</option>';
						for ($intSecond = 0; $intSecond <= 59; $intSecond++) {
							if (!$dttDateTime->IsTimeNull() && ($dttDateTime->Second == $intSecond))
								$strSelected = ' selected="selected"';
							else
								$strSelected = '';
							$strSecondListBox .= sprintf('<option value="%s"%s>%02d</option>',
								$intSecond,
								$strSelected,
								$intSecond);
						}
						$strSecondListBox .= '</select>';


						// PUtting it all together
						if (($this->strDateTimePickerType == QDateTimePickerType::DateTimeSeconds) ||
							($this->strDateTimePickerType == QDateTimePickerType::TimeSeconds))
							$strToReturn .= $strHourListBox . '&nbsp;:&nbsp;' . $strMinuteListBox . '&nbsp;:&nbsp;' . $strSecondListBox;
						else
							$strToReturn .= $strHourListBox . '&nbsp;:&nbsp;' . $strMinuteListBox;
				}

				return sprintf('<span id="%s">%s</span>', $this->strControlId, $strToReturn);
			}
		}

		public function Validate() {
			if ($this->blnRequired) {
				$blnIsNull = false;
				// wpg - added to handle time validation (if we are validating a time picker then)
				// else we are handling date pickers
				if ($this->strDateTimePickerType == QDateTimePickerType::Time) {
					// we need to make sure we check that the hour and minute have been entered before returning a validation response
					// since the minute and hour can be 0 (which would return a false result in the if statement) we need to check for null
					
					// wpg - if the hour and minutes are selected then we are all set else we have some work to do
					if (isset($this->dttDateTime) && $this->dttDateTime->Hour != '' && $this->dttDateTime->Minute !== '') {
						// && $this->dttDateTime->Minute
//						if ($this->dttDateTime->Hour !== '')
//							QApplication::DisplayAlert($this->strName."-> min ".$this->dttDateTime->Hour."--".$this->dttDateTime->Minute);
//						else
//							QApplication::DisplayAlert($this->strName." says is not set");
						return true;
					}
					else {
						if ($this->strName)
							$this->strValidationError = sprintf('%s is required', $this->strName);
						else
							$this->strValidationError = 'Required';
						return false;
					}
					//QApplication::DisplayAlert($this->strName);
					//return true;
				}
				else {

					if (!$this->dttDateTime)
						$blnIsNull = true;
					else {
						if ((($this->strDateTimePickerType == QDateTimePickerType::Date) ||
							($this->strDateTimePickerType == QDateTimePickerType::DateTime) ||
							($this->strDateTimePickerType == QDateTimePickerType::DateTimeSeconds )) &&
							($this->dttDateTime->IsDateNull()))
							$blnIsNull = true;
						else if ((($this->strDateTimePickerType == QDateTimePickerType::Time) ||
							($this->strDateTimePickerType == QDateTimePickerType::TimeSeconds)) &&
							($this->dttDateTime->IsTimeNull()))
							$blnIsNull = true;
					}

					if ($blnIsNull) {
						if ($this->strName)
							$this->strValidationError = sprintf('%s is required', $this->strName);
						else
							$this->strValidationError = 'Required';
						return false;
					}
				}
			} else {
				if ((($this->strDateTimePickerType == QDateTimePickerType::Date) ||
					($this->strDateTimePickerType == QDateTimePickerType::DateTime) ||
					($this->strDateTimePickerType == QDateTimePickerType::DateTimeSeconds )) &&
					($this->dttDateTime->Month || $this->dttDateTime->Day || $this->dttDateTime->Year) &&
					(!$this->dttDateTime->Month || !$this->dttDateTime->Day || !$this->dttDateTime->Year)) {
					$this->strValidationError = 'Invalid Date';
					return false;
				}
			}

			$this->strValidationError = '';
			return true;
		}

		/////////////////////////
		// Public Properties: GET
		/////////////////////////
		public function __get($strName) {
			switch ($strName) {
				// MISC
				case "DateTime":
					if (is_null($this->dttDateTime) || $this->dttDateTime->IsNull())
						return null;
					else {
						$objToReturn = clone($this->dttDateTime);
						return $objToReturn;
					}

				// wpg - added to allow us to check the hour selected
				case "Hour":
					if (is_null($this->dttDateTime) || $this->dttDateTime->IsNull())
						return null;
					else {
						return $this->dttDateTime->Hour;
					}

				// wpg - added to allow us to check the minutes selected
				case "Minute":
					if (is_null($this->dttDateTime) || $this->dttDateTime->IsNull())
						return null;
					else {
						return $this->dttDateTime->Minute;
					}

				case "DateTimePickerType": return $this->strDateTimePickerType;
				case "DateTimePickerFormat": return $this->strDateTimePickerFormat;
				case "MinimumYear": return $this->intMinimumYear;
				case "MaximumYear": return $this->intMaximumYear;

				// wpg - added so we can get the minute interval
				case "MinuteInterval": return $this->intMinuteInterval;

				// wpg - added so we can get the minimum and maximum hours set for the object
				case "MinimumHour": return $this->intMinimumHour;
				case "MaximumHour": return $this->intMaximumHour;

				// wpg - added so we can get the minimum and maximum minutes set for the object
				case "MinimumMinute": return $this->intMinimumMinute;
				case "MaximumMinute": return $this->intMaximumMinute;

				// wpg - added to switch to label mode
				case "LabelMode": return $this->blnLabelMode;
				case "ViewOnlyMode": return $this->blnViewOnlyMode;
				case "FormatDisplay": return $this->strFormat;

				default:
					try {
						return parent::__get($strName);
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}

		/////////////////////////
		// Public Properties: SET
		/////////////////////////
		public function __set($strName, $mixValue) {
			$this->blnModified = true;

			switch ($strName) {
				// MISC
				case "DateTime":
					try {
						$dttDate = QType::Cast($mixValue, QType::DateTime);
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

					$this->intSelectedMonth = null;
					$this->intSelectedDay = null;
					$this->intSelectedYear = null;

					if (is_null($dttDate) || $dttDate->IsNull())
						$this->dttDateTime = null;
					else
						$this->dttDateTime = $dttDate;

					break;

				case "DateTimePickerType":
					try {
						$this->strDateTimePickerType = QType::Cast($mixValue, QType::String);
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					break;

				case "DateTimePickerFormat":
					try {
						$this->strDateTimePickerFormat = QType::Cast($mixValue, QType::String);
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					break;

				case "MinimumYear":
					try {
						$this->intMinimumYear = QType::Cast($mixValue, QType::String);
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					break;

				case "MaximumYear":
					try {
						$this->intMaximumYear = QType::Cast($mixValue, QType::String);
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					break;

				// wpg - added so we can set the type of the minimum minute setting
				case "MinuteInterval":
					try {
						$this->intMinuteInterval = QType::Cast($mixValue, QType::String);
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					break;

				// wpg - added so we can check the type of the minimum minute setting
				case "MinimumMinute":
					try {
						$this->intMinimumMinute = QType::Cast($mixValue, QType::String);
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					break;

				case "MaximumMinute":
					try {
						$this->intMaximumMinute = QType::Cast($mixValue, QType::String);
						// wpg - do not allow for maximum minutes greater then 59
						if ($this->intMaximumMinute > 59) $this->intMaximumMinute = 59;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					break;

				// wpg - added so we can check the type of the Hour setting
				case "MinimumHour":
					try {
						$this->intMinimumHour = QType::Cast($mixValue, QType::String);
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					break;

				case "MaximumHour":
					try {
						$this->intMaximumHour = QType::Cast($mixValue, QType::String);
						// wpg - do not allow for maximum minutes greater then 23
						if ($this->intMaximumHour > 23) $this->intMaximumMinute = 23;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					break;

				// wpg - added so we can default minutes to 00
				case "MinutesRequired":
					try {
						$this->blnMinutesRequired = QType::Cast($mixValue, QType::Boolean);
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					break;


				case "FormatDisplay":
					try {
						$this->strFormat = QType::Cast($mixValue, QType::String);
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
					break;

				default:
					try {
						parent::__set($strName, $mixValue);
						break;
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}
	}
?>