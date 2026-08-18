<?php
	/**
	 * @author w. Patrick Gale - w.patrick.gale@unc.edu (March 2011)
	 * @abstract This class is just a modified extension of the Datagrid but formats the data using the jQueryDT table format so
	 * columns can be sorted using Ajax without database calls.  This is useful when you want to sort a column that has values that are
	 * a result of a mathematical calculation or something that can not be easily translated to a QQuery for sorting the column.
	 * 
	 * June 20, 2019 - wpg
	 * - updating to allow basic exporting of datagrid data to Excel
	 */


	// Due to the fact that DataGrid's will perform php eval's on anything that is back-ticked within each column/row's
	// DataGridColumn::HTML, we need to set up this special DataGridEvalHandleError error handler to correctly report
	// errors that happen.
	function DataGridEvalHandleError($__exc_errno, $__exc_errstr, $__exc_errfile, $__exc_errline) {
		$__exc_objBacktrace = debug_backtrace();
		for ($__exc_intIndex = 0; $__exc_intIndex < count($__exc_objBacktrace); $__exc_intIndex++) {
			$__exc_objItem = $__exc_objBacktrace[$__exc_intIndex];

			if ((strpos($__exc_errfile, "DataGrid.inc") !== false) &&
				(strpos($__exc_objItem["file"], "DataGrid.inc") === false)) {
				$__exc_errfile = $__exc_objItem["file"];
				$__exc_errline = $__exc_objItem["line"];
			} else if ((strpos($__exc_errfile, "Form.inc") !== false) &&
				(strpos($__exc_objItem["file"], "Form.inc") === false)) {
				$__exc_errfile = $__exc_objItem["file"];
				$__exc_errline = $__exc_objItem["line"];
			}
		}

		global $__exc_dtg_errstr;
		if (isset($__exc_dtg_errstr) && ($__exc_dtg_errstr))
			$__exc_errstr = sprintf("%s\n%s", $__exc_dtg_errstr, $__exc_errstr);
		QcodoHandleError($__exc_errno, $__exc_errstr, $__exc_errfile, $__exc_errline);
	}

	class QjQueryDT extends QPaginatedControl  {
		///////////////////////////
		// DataGrid Preferences
		///////////////////////////

			// APPEARANCE
		protected $objAlternateRowStyle = null;
		protected $strBorderCollapse = QBorderCollapse::NotSet;
		protected $objHeaderRowStyle = null;
		protected $objFooterRowStyle = null;
		protected $objOverrideRowStyleArray = null;
		protected $objHeaderLinkStyle = null;
		protected $objFooterLinkStyle = null;
		protected $objRowStyle = null;

		// LAYOUT
		protected $intCellPadding = -1;
		protected $intCellSpacing = -1;
		protected $strGridLines = QGridLines::None;
		protected $blnShowHeader = true;
		protected $blnShowFooter = false;

		// MISC
		protected $objColumnArray;

		protected $intCurrentRowIndex;
		protected $intSortColumnIndex = -1;
		protected $intSortDirection = 0;

		protected $strLabelForNoneFound;
		protected $strLabelForOneFound;
		protected $strLabelForMultipleFound;
		protected $strLabelForPaginated;

		public function __construct($objParentObject, $strControlId = null) {
			try {
				parent::__construct($objParentObject, $strControlId);
			} catch (QCallerException  $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
			$this->objRowStyle = new QDataGridRowStyle();
			$this->objAlternateRowStyle = new QDataGridRowStyle();
			$this->objHeaderRowStyle = new QDataGridRowStyle();
			$this->objFooterRowStyle = new QDataGridRowStyle();
			$this->objHeaderLinkStyle = new QDataGridRowStyle();
			$this->objFooterLinkStyle = new QDataGridRowStyle();

			// Labels
			$this->strLabelForNoneFound = QApplication::Translate('<b>Results:</b> No %s found.');
			$this->strLabelForOneFound = QApplication::Translate('<b>Results:</b> 1 %s found.');
			$this->strLabelForMultipleFound = QApplication::Translate('<b>Results:</b> %s %s found.');
			$this->strLabelForPaginated = QApplication::Translate('<b>Results:</b>&nbsp;Viewing&nbsp;%s&nbsp;%s-%s&nbsp;of&nbsp;%s.%s');	// wpg - added last option for additional options we may want to add to the paginator

			$this->objColumnArray = array();

			// Setup Sorting Events
			if ($this->blnUseAjax)
				$this->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'Sort_Click'));
			else
				$this->AddAction(new QClickEvent(), new QServerControlAction($this, 'Sort_Click'));

			$this->AddAction(new QClickEvent(), new QTerminateAction());
		}

		// Used to add a DataGridColumn to this DataGrid
		public function AddColumn(QDataGridColumn $objColumn) {
			$this->blnModified = true;
			array_push($this->objColumnArray, $objColumn);
//			$this->objColumnArray[count($this->objColumnArray)] = $objColumn;
		}

		public function AddColumnAt($intColumnIndex, QDataGridColumn $objColumn) {
			$this->blnModified = true;
			try {
				$intColumnIndex = QType::Cast($intColumnIndex, QType::Integer);
			} catch (QInvalidCastException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
			if (($intColumnIndex < 0) ||
				($intColumnIndex > (count($this->objColumnArray))))
				throw new QIndexOutOfRangeException($intColumnIndex, "AddColumnAt()");

			if ($intColumnIndex == 0) {
				$this->objColumnArray = array_merge(array($objColumn), $this->objColumnArray);
			} else {
				$this->objColumnArray = array_merge(array_slice($this->objColumnArray, 0, $intColumnIndex),
					array($objColumn),
					array_slice($this->objColumnArray, $intColumnIndex));
			}
		}

		public function RemoveColumn($intColumnIndex) {
			$this->blnModified = true;
			try {
				$intColumnIndex = QType::Cast($intColumnIndex, QType::Integer);
			} catch (QInvalidCastException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
			if (($intColumnIndex < 0) ||
				($intColumnIndex > (count($this->objColumnArray) - 1)))
				throw new QIndexOutOfRangeException($intColumnIndex, "RemoveColumn()");

			array_splice($this->objColumnArray, $intColumnIndex, 1);
		}

		public function RemoveColumnByName($strName) {
			$this->blnModified = true;
			for ($intIndex = 0; $intIndex < count($this->objColumnArray); $intIndex++)
				if ($this->objColumnArray[$intIndex]->Name == $strName) {
					array_splice($this->objColumnArray, $intIndex, 1);
					return;
				}
		}

		public function RemoveColumnsByName($strName) {
			$this->blnModified = true;
			for ($intIndex = 0; $intIndex < count($this->objColumnArray); $intIndex++)
				if ($this->objColumnArray[$intIndex]->Name == $strName) {
					array_splice($this->objColumnArray, $intIndex, 1);
					$intIndex--;
				}
		}

		public function RemoveAllColumns() {
			$this->blnModified = true;
			$this->objColumnArray = array();
		}

		public function GetAllColumns() {
			return $this->objColumnArray;
		}

		public function GetColumn($intColumnIndex) {
			if (array_key_exists($intColumnIndex, $this->objColumnArray))
				return $this->objColumnArray[$intColumnIndex];
		}

		public function GetColumnByName($strName) {
			if ($this->objColumnArray) foreach ($this->objColumnArray as $objColumn)
				if ($objColumn->Name == $strName)
					return $objColumn;
		}

		public function GetColumnsByName($strName) {
			$objColumnArrayToReturn = array();
			if ($this->objColumnArray) foreach ($this->objColumnArray as $objColumn)
				if ($objColumn->Name == $strName)
					array_push($objColumnArrayToReturn, $objColumn);
			return $objColumnArrayToReturn;
		}

		// If you want to override a SPECIFIC row's style, you can specify
		// the RowIndex and the DataGridRowStyle with which to override
		public function OverrideRowStyle($intRowIndex, $objStyle) {
			try {
				$objStyle = QType::Cast($objStyle, "QDataGridRowStyle");
			} catch (QInvalidCastException $objExc) {
				$objExc->IncrementOffset();
				throw $objExc;
			}
			$this->objOverrideRowStyleArray[$intRowIndex] = $objStyle;
		}

		// Used upon rendering to find backticks and perform PHP eval's
		protected function ParseColumnHtml($objColumn, $objObject) {
			$_ITEM = $objObject;
			$_FORM = $this->objForm;
			$_CONTROL = $this;
			$_COLUMN = $objColumn;

			$strHtml = $objColumn->Html;
			$intPosition = 0;

			while (($intStartPosition = strpos($strHtml, '<?=', $intPosition)) !== false) {
				$intEndPosition = strpos($strHtml, '?>', $intStartPosition);
				if ($intEndPosition === false)
					return $strHtml;
				$strToken = substr($strHtml, $intStartPosition + 3, ($intEndPosition - $intStartPosition) - 3);
				$strToken = trim($strToken ?? '');

				if ($strToken) {
					// Because Eval doesn't utilize exception management, we need to do hack thru the PHP Error Handler
					set_error_handler("DataGridEvalHandleError");
					global $__exc_dtg_errstr;
					$__exc_dtg_errstr = sprintf("Incorrectly formatted DataGridColumn HTML in %s: %s", $this->strControlId, $strHtml);

					try {
						$strEvaledToken = eval(sprintf('return %s;', $strToken));
					} catch (QCallerException $objExc) {
						$objExc->DecrementOffset();
						throw $objExc;
					}

					// Restore the original error handler
					set_error_handler("QcodoHandleError");
					$__exc_dtg_errstr = null;
					unset($__exc_dtg_errstr);
				} else {
					$strEvaledToken = '';
				}

				$strHtml = sprintf("%s%s%s",
					substr($strHtml, 0, $intStartPosition),
					$strEvaledToken,
					substr($strHtml, $intEndPosition + 2));

				$intPosition = $intStartPosition + strlen($strEvaledToken ?? '');
			}

			return $strHtml;
		}

		// The Table, itself, should have no actions defined on it and should not be parsing anything
		public function ParsePostData() {}

		public function GetAttributes($blnIncludeCustom = true, $blnIncludeAction = false) {
			$strToReturn = parent::GetAttributes($blnIncludeCustom, $blnIncludeAction);

			if ($this->strGridLines == QGridLines::Horizontal)
				$strToReturn .= 'rules="rows" ';
			else if ($this->strGridLines == QGridLines::Vertical)
				$strToReturn .= 'rules="cols" ';
			else if ($this->strGridLines == QGridLines::Both)
				$strToReturn .= 'rules="all" ';

			if ($this->intCellPadding >= 0)
				$strToReturn .= sprintf('cellpadding="%s" ', $this->intCellPadding);

			if ($this->intCellSpacing >= 0)
				$strToReturn .= sprintf('cellspacing="%s" ', $this->intCellSpacing);

				// deprecated attributes in HTML5 removed - wpg
			// $strBorder = $this->strBorderWidth;
			// settype($strBorder, QType::Integer);
			// $strToReturn .= sprintf('border="%s" ', $strBorder);

			// if ($this->strBorderColor)
			// 	$strToReturn .= sprintf('bordercolor="%s" ', $this->strBorderColor);

			return $strToReturn;
		}

		public function GetJavaScriptAction() {
			return "onclick";
		}

		public function GetStyleAttributes() {
			$strToReturn = parent::GetStyleAttributes();

			if ($this->strBorderCollapse == QBorderCollapse::Collapse)
				$strToReturn .= 'border-collapse:collapse;';
			else if ($this->strBorderCollapse == QBorderCollapse::Separate)
				$strToReturn .= 'border-collapse:separate;';

			return $strToReturn;
		}

		// Parse the _POST to see if the user is requesting a change in the sort column or page
		public function Sort_Click($strFormId, $strControlId, $strParameter) {
			$this->blnModified = true;

			if (strlen($strParameter ?? '')) {
				// Sorting
				$intColumnIndex = QType::Cast($strParameter, QType::Integer);
				$objColumn = $this->objColumnArray[$intColumnIndex];

				// First, reset pagination (if applicable)
				if ($this->objPaginator)
					$this->PageNumber = 1;

				// First, make sure the Column is Sortable
				if ($objColumn->OrderByClause) {
					// It is

					// Are we currently sorting by this column?
					if ($this->intSortColumnIndex == $intColumnIndex) {
						// Yes we are currently sorting by this column

						// In Reverse?
						if ($this->intSortDirection == 1) {
							// Yep -- unreverse the sort
							$this->intSortDirection = 0;
						} else {
							// Nope -- can we reverse?
							if ($objColumn->ReverseOrderByClause)
								$this->intSortDirection = 1;
						}
					} else {
						// Nope -- so let's set it to this column
						$this->intSortColumnIndex = $intColumnIndex;
						$this->intSortDirection = 0;
					}
				} else {
					// It isn't -- clear all sort properties
					$this->intSortDirection = 0;
					$this->intSortColumnIndex = -1;
				}
			}
		}

		/**
		 * wpg - edited to allow for better control over style of pagination panel
		 *
		 * @param unknown_type $objPaginator
		 * @return unknown
		 */
		protected function GetPaginatorRowHtml($objPaginator) {
			$strToReturn = sprintf('<table class="results"><tr><td valign="bottom" class="resultsPagieC1">', count($this->objColumnArray));

			// wpg - added __PAGINATION_OPTIONS__ so we can set how many items per page we want
			if ($this->TotalItemCount > 0) {
				$intStart = (($this->PageNumber - 1) * $this->ItemsPerPage) + 1;
				$intEnd = $intStart + count($this->DataSource) - 1;
				$strToReturn .= sprintf($this->strLabelForPaginated,
					$this->strNounPlural,
					$intStart,
					$intEnd,
					$this->TotalItemCount,
					__PAGINATION_OPTIONS__);
			} else {
				$intCount = count($this->objDataSource);
				if ($intCount == 0)
					$strToReturn .= sprintf($this->strLabelForNoneFound, $this->strNounPlural);
				else if ($intCount == 1)
					$strToReturn .= sprintf($this->strLabelForOneFound, $this->strNoun);
				else
					$strToReturn .= sprintf($this->strLabelForMultipleFound, $intCount, $this->strNounPlural);
			}

			$strToReturn .= '</td><td valign="bottom" class="resultsPagieC2">';
			$strToReturn .= $objPaginator->Render(false);
			$strToReturn .= '</td></tr></table>';

			return $strToReturn;
		}

		/**
		 * wpg - removed Qcodo sorting code and just returning the column name
		 * @param QDataGridColumn $objColumn
		 * @return unknown
		 */
		protected function GetHeaderSortedHtml(QDataGridColumn $objColumn) {
			return $objColumn->Name;
		}

		/**
		 * wpg - just printing out the header row information
		 */
		protected function GetHeaderRowHtml($basic = null, $removeHtml = 0) {
			$objHeaderStyle = $this->objRowStyle->ApplyOverride($this->objHeaderRowStyle);

			if ($basic)
				$strToReturn = '<tr>';
			else
			$strToReturn = '<tr>';//sprintf('<thead><tr %s>', $objHeaderStyle->GetAttributes());
			$intColumnIndex = 0;
			if ($this->objColumnArray) foreach ($this->objColumnArray as $objColumn) {
				if ($objColumn->OrderByClause) {
					// This Column is Sortable
					if ($intColumnIndex == $this->intSortColumnIndex)
						$strName = $this->GetHeaderSortedHtml($objColumn);
					else
						$strName = $objColumn->Name;

					$this->strActionParameter = $intColumnIndex;

					// if we are wanting the raw data without html tags for Excel export
					if ($removeHtml)
						$strName = strip_tags($strName);
					$strToReturn .= sprintf('<th>%s</th>',
						$strName);
				} else
					$strToReturn .= sprintf('<th>%s</th>', $objColumn->Name);
				$intColumnIndex++;
			}
			$strToReturn .= '</tr>';

			return $strToReturn;
		}

		protected function GetDataGridRowHtml($objObject, $removeHtml = 0,$cleanQuotes=0) {
			// Get the Default Style
			$objStyle = $this->objRowStyle;

			// Iterate through the Columns
			$strColumnsHtml = '';
			$intCurrentCellIndex=0;
			foreach ($this->objColumnArray as $objColumn) {
				try {
					$strHtml = $this->ParseColumnHtml($objColumn, $objObject);

					if ($objColumn->HtmlEntities)
						$strHtml = QApplication::HtmlEntities($strHtml);

					 // For IE
					if (QApplication::IsBrowser(QBrowserType::InternetExplorer) &&
						($strHtml == ''))
							$strHtml = '&nbsp;';
				} catch (QCallerException $objExc) {
					$objExc->IncrementOffset();
					throw $objExc;
				}
				// if we are wanting the raw data without html tags for Excel export
				if ($removeHtml)
					$strHtml = strip_tags($strHtml);


				if ($cleanQuotes){
					// wpg - replacing quotes with
// 					$strHtml = str_replace('"', '\"', $strHtml);
// 					$strHtml = str_replace("'", '\"', $strHtml);

					//$strHtml = str_replace('"', "'", $strHtml);
					//$strHtml = str_replace("'", "\'", $strHtml);
				}
				$strColumnsHtml .= sprintf('<td id="%s_cell%s" %s>%s</td>', $this->strControlId, $intCurrentCellIndex,$objColumn->GetAttributes(), $strHtml);
				$intCurrentCellIndex++;	// wpg - added so we can focus on a table cell if needed
			}

			// Apply AlternateRowStyle (if applicable)
			if (($this->intCurrentRowIndex % 2) == 1)
				$objStyle = $objStyle->ApplyOverride($this->objAlternateRowStyle);

			// Apply any Style Override (if applicable)
			if ((is_array($this->objOverrideRowStyleArray)) &&
				(array_key_exists($this->intCurrentRowIndex, $this->objOverrideRowStyleArray)) &&
				(!is_null($this->objOverrideRowStyleArray[$this->intCurrentRowIndex])))
				$objStyle = $objStyle->ApplyOverride($this->objOverrideRowStyleArray[$this->intCurrentRowIndex]);

			// Finish up
			$strToReturn = sprintf('<tr id="%s_row%s" %s>%s</tr>', $this->strControlId, $this->intCurrentRowIndex, $objStyle->GetAttributes(), $strColumnsHtml);
			$this->intCurrentRowIndex++;
			return $strToReturn;
		}

		// wpg - adding functionality for footer row
		protected function GetFooterRowHtml($removeHtml = 0) {

			$objFooterStyle = $this->objRowStyle->ApplyOverride($this->objFooterRowStyle);

			$strToReturn = sprintf('<tfoot><tr %s>', $objFooterStyle->GetAttributes());
			$intColumnIndex = 0;
			if ($this->objColumnArray) foreach ($this->objColumnArray as $objColumn) {
				$strColumnsHtml = $this->GetFooterHtml($objColumn->Footer);
				if ($removeHtml)
					$strColumnsHtml = strip_tags($strColumnsHtml);

					$strToReturn .= sprintf('<td %s>%s</td>', $this->objFooterRowStyle->GetAttributes(), $strColumnsHtml);
				$intColumnIndex++;
			}
			$strToReturn .= '</tr><t/foot>';

			return $strToReturn;
		}

		/**
		 * wpg - Function for parsing php code in the column so we can call a function instead of a static variable that wouldn't do us any good
		 *
		 * @param unknown_type $obj
		 * @return unknown
		 */
		protected function GetFooterHtml($obj) {
			$_FORM = $this->objForm;	// wpg - need this because the evaluated code includes the $_FORM object in it and it need evaluation
			$strHtml = $obj;
			$intPosition = 0;

			while (($intStartPosition = strpos($strHtml, '<?=', $intPosition)) !== false) {
				$intEndPosition = strpos($strHtml, '?>', $intStartPosition);

				// if we are just passing in a string then skip the php evaluation
				if ($intEndPosition === false)
					return $strHtml;
				$strToken = substr($strHtml, $intStartPosition + 3, ($intEndPosition - $intStartPosition) - 3);
				$strToken = trim($strToken ?? '');

				if ($strToken) {
					// Because Eval doesn't utilize exception management, we need to do hack thru the PHP Error Handler
					set_error_handler("DataGridEvalHandleError");
					global $__exc_dtg_errstr;
					$__exc_dtg_errstr = sprintf("Incorrectly formatted DataGridColumn HTML in %s: %s", $this->strControlId, $strHtml);

					try {
						$strEvaledToken = eval(sprintf('return %s;', $strToken));
					} catch (QCallerException $objExc) {
						$objExc->DecrementOffset();
						throw $objExc;
					}

					// Restore the original error handler
					set_error_handler("QcodoHandleError");
					$__exc_dtg_errstr = null;
					unset($__exc_dtg_errstr);
				} else {
					$strEvaledToken = '';
				}

				$strHtml = sprintf("%s%s%s",
					substr($strHtml, 0, $intStartPosition),
					$strEvaledToken,
					substr($strHtml, $intEndPosition + 2));

				$intPosition = $intStartPosition + strlen($strEvaledToken ?? '');
			}

			return $strHtml;
		}

		protected function GetControlHtml() {
			$this->DataBind();
			$strToReturn = '';
			// Paginator Row (if applicable)
			if ($this->objPaginator)
				$strToReturn .= $this->GetPaginatorRowHtml($this->objPaginator);
				// wpg - added the datatable preferences in case we are loading the tables from a datarepeater (in which case we need to add a unique control id to the data table id)
				$cId = $this->ControlId;
$_jQueryDTset = <<<MLS
		<script charset="utf-8">

			// wpg - set the datatable preferences
			$(document).ready(function() {
				oTable = $('#example_$cId').dataTable({
					"bJQueryUI": true,
					"bPaginate": false,
					"bLengthChange": false,
					"bFilter": false,
					"bSort": true,
					"bInfo": false,
					"bAutoWidth": true
				 } );

			} );

		</script>
MLS;

			$strToReturn .= $_jQueryDTset;
			// Table Tag
			$strStyle = $this->GetStyleAttributes();
			if ($strStyle)
				$strStyle = sprintf('style="%s" ', $strStyle);

			// wpg - adding the control id to the table to give it a unique id (for multiple instances of the table in one page)
			$strToReturn .= sprintf('<table class="display" id="example_%s" %s>',$this->ControlId, $this->GetAttributes());

			$strToReturn .= '<thead>';

			// Header Row (if applicable)
			if ($this->blnShowHeader)
				$strToReturn .= $this->GetHeaderRowHtml();

			$strToReturn .= '</thead>';
			// DataGrid Rows
			$this->intCurrentRowIndex = 0;
			if ($this->objDataSource)
				foreach ($this->objDataSource as $objObject)
					$strToReturn .= $this->GetDataGridRowHtml($objObject);

			// Footer Row (if applicable)
			if ($this->blnShowFooter)
				$strToReturn .= $this->GetFooterRowHtml(count($this->objDataSource));

			// Finish Up
			$strToReturn .= '</table>';
			$this->objDataSource = null;
			return $strToReturn;
		}

		// wpg - get read only view of data for export
		protected function GetControlHtmlReadOnly() {
			$this->DataBind();

			$strToReturn = sprintf('<table>');

			// Header Row (if applicable)
			if ($this->blnShowHeader)
				$strToReturn .= $this->GetHeaderRowHtml(1,1);

			// DataGrid Rows
			$this->intCurrentRowIndex = 0;
			if ($this->objDataSource)
				foreach ($this->objDataSource as $objObject)
					$strToReturn .= $this->GetDataGridRowHtml($objObject,1);

			// Footer Row (if applicable)
			if ($this->blnShowFooter)
				$strToReturn .= $this->GetFooterRowHtml(1);

			$this->objDataSource = null;

			$strToReturn .= sprintf('</table>');
			return $strToReturn;
		}

		/////////////////////////
		// Public Properties: GET
		/////////////////////////
		public function __get($strName) {
			switch ($strName) {
				// APPEARANCE
				case "AlternateRowStyle": return $this->objAlternateRowStyle;
				case "BorderCollapse": return $this->strBorderCollapse;
				case "HeaderRowStyle": return $this->objHeaderRowStyle;
				case "HeaderLinkStyle": return $this->objHeaderLinkStyle;
				case "FooterLinkStyle": return $this->objFooterLinkStyle;
				case "RowStyle": return $this->objRowStyle;

				// LAYOUT
				case "CellPadding": return $this->intCellPadding;
				case "CellSpacing": return $this->intCellSpacing;
				case "GridLines": return $this->strGridLines;
				case "ShowHeader": return $this->blnShowHeader;
				case "ShowFooter": return $this->blnShowFooter;

				// wpg - added to return only datagrid data without extraineous html (for exporting to CSV)
				case "DG": return $this->GetControlHtmlReadOnly();

				// wpg - newer format for exporting to Excel (preferred) (Dec. 4, 2014 - wpg)
				//case "PHPExcel": return $this->GetControlHtmlReadOnlyPHPExcel();

				// MISC
				case "OrderByClause":
					if ($this->intSortColumnIndex >= 0) {
						if ($this->intSortDirection == 0)
							return $this->objColumnArray[$this->intSortColumnIndex]->OrderByClause;
						else
							return $this->objColumnArray[$this->intSortColumnIndex]->ReverseOrderByClause;
					} else
						return null;
				case "SortInfo":
					if ($this->intSortColumnIndex >= 0) {
						if ($this->intSortDirection == 0) {
							$mixToReturn = $this->objColumnArray[$this->intSortColumnIndex]->SortByCommand;
							if ($mixToReturn instanceof QQOrderBy)
								return $mixToReturn->GetAsManualSql();
							else
								return $mixToReturn;
						} else {
							$mixToReturn = $this->objColumnArray[$this->intSortColumnIndex]->ReverseSortByCommand;
							if ($mixToReturn instanceof QQOrderBy)
								return $mixToReturn->GetAsManualSql();
							else
								return $mixToReturn;
						}
					} else
						return null;

				case "CurrentRowIndex": return $this->intCurrentRowIndex;
				case "SortColumnIndex": return $this->intSortColumnIndex;
				case "SortDirection": return $this->intSortDirection;

				case 'LabelForNoneFound': return $this->strLabelForNoneFound;
				case 'LabelForOneFound': return $this->strLabelForOneFound;
				case 'LabelForMultipleFound': return $this->strLabelForMultipleFound;
				case 'LabelForPaginated': return $this->strLabelForPaginated;

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
			switch ($strName) {
				// APPEARANCE
				case "AlternateRowStyle":
					try {
						$this->objAlternateRowStyle = QType::Cast($mixValue, "QDataGridRowStyle");
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
				case "BorderCollapse":
					try {
						$this->strBorderCollapse = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
				case "HeaderRowStyle":
					try {
						$this->objHeaderRowStyle = QType::Cast($mixValue, "QDataGridRowStyle");
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
				case "FooterRowStyle":
					try {
						$this->objFooterRowStyle = QType::Cast($mixValue, "QDataGridRowStyle");
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
				case "HeaderLinkStyle":
					try {
						$this->objHeaderLinkStyle = QType::Cast($mixValue, "QDataGridRowStyle");
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
				case "FooterLinkStyle":
					try {
						$this->objFooterLinkStyle = QType::Cast($mixValue, "QDataGridRowStyle");
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
				case "RowStyle":
					try {
						$this->objRowStyle = QType::Cast($mixValue, "QDataGridRowStyle");
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				// BEHAVIOR
				case "UseAjax":
					try {
						$blnToReturn = parent::__set($strName, $mixValue);
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

					// Because we are switching to/from Ajax, we need to reset the events
					$this->RemoveAllActions('onclick');
					if ($this->blnUseAjax)
						$this->AddAction(new QClickEvent(), new QAjaxControlAction($this, 'Sort_Click'));
					else
						$this->AddAction(new QClickEvent(), new QServerControlAction($this, 'Sort_Click'));

					$this->AddAction(new QClickEvent(), new QTerminateAction());
					return $blnToReturn;

				// LAYOUT
				case "CellPadding":
					try {
						$this->intCellPadding = QType::Cast($mixValue, QType::Integer);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
				case "CellSpacing":
					try {
						$this->intCellSpacing = QType::Cast($mixValue, QType::Integer);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
				case "GridLines":
					try {
						$this->strGridLines = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
				case "ShowHeader":
					try {
						$this->blnShowHeader = QType::Cast($mixValue, QType::Boolean);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case "ShowFooter":
					try {
						$this->blnShowFooter = QType::Cast($mixValue, QType::Boolean);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				// MISC
				case "SortColumnIndex":
					try {
						$this->intSortColumnIndex = QType::Cast($mixValue, QType::Integer);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case "SortDirection":
					if ($mixValue == 1)
						$this->intSortDirection = 1;
					else
						$this->intSortDirection = 0;
					break;


				case 'LabelForNoneFound':
					try {
						$this->strLabelForNoneFound = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'LabelForOneFound':
					try {
						$this->strLabelForOneFound = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'LabelForMultipleFound':
					try {
						$this->strLabelForMultipleFound = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				case 'LabelForPaginated':
					try {
						$this->strLabelForPaginated = QType::Cast($mixValue, QType::String);
						break;
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

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