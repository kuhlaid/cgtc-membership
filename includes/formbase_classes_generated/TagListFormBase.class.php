<?php
	/**
	 * This is the abstract Form class for the List All functionality
	 * of the Tag class.  This code-generated class
	 * contains a Qform datagrid to display an HTML page that can
	 * list a collection of Tag objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this TagListFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class TagListFormBase extends QForm {
		protected $dtgTag;

		// DataGrid Columns
		protected $colEditLinkColumn;
		protected $colId;
		protected $colName;
		protected $colDescription;
		protected $colCreated;


		protected function Form_Create() {
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgTag_EditLinkColumn_Render($_ITEM) ?>');
			$this->colEditLinkColumn->HtmlEntities = false;
			$this->colId = new QDataGridColumn(QApplication::Translate('Id'), '<?= $_ITEM->Id; ?>', array('OrderByClause' => QQ::OrderBy(QQN::Tag()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Tag()->Id, false)));
			$this->colName = new QDataGridColumn(QApplication::Translate('Name'), '<?= QString::Truncate($_ITEM->Name, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::Tag()->Name), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Tag()->Name, false)));
			$this->colDescription = new QDataGridColumn(QApplication::Translate('Description'), '<?= QString::Truncate($_ITEM->Description, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::Tag()->Description), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Tag()->Description, false)));
			$this->colCreated = new QDataGridColumn(QApplication::Translate('Created'), '<?= $_FORM->dtgTag_Created_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::Tag()->Created), 'ReverseOrderByClause' => QQ::OrderBy(QQN::Tag()->Created, false)));

			// Setup DataGrid
			$this->dtgTag = new QDataGrid($this);
			$this->dtgTag->CellSpacing = 0;
			$this->dtgTag->CellPadding = 4;
			$this->dtgTag->BorderStyle = QBorderStyle::Solid;
			$this->dtgTag->BorderWidth = 1;
			$this->dtgTag->GridLines = QGridLines::Both;

			// Datagrid Paginator
			$this->dtgTag->Paginator = new QPaginator($this->dtgTag);
			$this->dtgTag->ItemsPerPage = 10;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgTag->UseAjax = false;

			// Specify the local databind method this datagrid will use
			$this->dtgTag->SetDataBinder('dtgTag_Bind');

			$this->dtgTag->AddColumn($this->colEditLinkColumn);
			$this->dtgTag->AddColumn($this->colId);
			$this->dtgTag->AddColumn($this->colName);
			$this->dtgTag->AddColumn($this->colDescription);
			$this->dtgTag->AddColumn($this->colCreated);
		}
		
		public function dtgTag_EditLinkColumn_Render(Tag $objTag) {
			return sprintf('<a href="tag_edit.php?intId=%s">%s</a>',
				$objTag->Id, 
				QApplication::Translate('Edit'));
		}

		public function dtgTag_Created_Render(Tag $objTag) {
			if (!is_null($objTag->Created))
				return $objTag->Created->toString(QDateTime::FormatDisplayDate);
			else
				return null;
		}


		protected function dtgTag_Bind() {
			// Because we want to enable pagination AND sorting, we need to setup the $objClauses array to send to LoadAll()

			// Remember!  We need to first set the TotalItemCount, which will affect the calcuation of LimitClause below
			$this->dtgTag->TotalItemCount = Tag::CountAll();

			// Setup the $objClauses Array
			$objClauses = array();

			// If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
			// the OrderByClause to the $objClauses array
			if ($objClause = $this->dtgTag->OrderByClause)
				array_push($objClauses, $objClause);

			// Add the LimitClause information, as well
			if ($objClause = $this->dtgTag->LimitClause)
				array_push($objClauses, $objClause);

			// Set the DataSource to be the array of all Tag objects, given the clauses above
			$this->dtgTag->DataSource = Tag::LoadAll($objClauses);
		}
	}
?>