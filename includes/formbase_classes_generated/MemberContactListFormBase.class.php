<?php
	/**
	 * This is the abstract Form class for the List All functionality
	 * of the MemberContact class.  This code-generated class
	 * contains a Qform datagrid to display an HTML page that can
	 * list a collection of MemberContact objects.  It includes
	 * functionality to perform pagination and sorting on columns.
	 *
	 * To take advantage of some (or all) of these control objects, you
	 * must create a new Form which extends this MemberContactListFormBase
	 * class.
	 *
	 * Any and all changes to this file will be overwritten with any subsequent re-
	 * code generation.
	 * 
	 * @package My Application
	 * @subpackage FormBaseObjects
	 * 
	 */
	abstract class MemberContactListFormBase extends QForm {
		protected $dtgMemberContact;

		// DataGrid Columns
		protected $colEditLinkColumn;
		protected $colId;
		protected $colLastName;
		protected $colFirstName;
		protected $colEmail;
		protected $colAddr1;
		protected $colAddr2;
		protected $colCity;
		protected $colState;
		protected $colZip;
		protected $colGender;
		protected $colBirthDay;
		protected $colBirthMonth;
		protected $colBirthYear;
		protected $colMainPhone;
		protected $colAltPhone;
		protected $colNote;
		protected $colTransferId;
		protected $colContactAdded;
		protected $colGoogleEmail;
		protected $colFacebookEmail;
		protected $colJoinedClub;
		protected $colNotActive;
		protected $colImageReference;


		protected function Form_Create() {
			// Setup DataGrid Columns
			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgMemberContact_EditLinkColumn_Render($_ITEM) ?>');
			$this->colEditLinkColumn->HtmlEntities = false;
			$this->colId = new QDataGridColumn(QApplication::Translate('Id'), '<?= $_ITEM->Id; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Id, false)));
			$this->colLastName = new QDataGridColumn(QApplication::Translate('Last Name'), '<?= QString::Truncate($_ITEM->LastName, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->LastName), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->LastName, false)));
			$this->colFirstName = new QDataGridColumn(QApplication::Translate('First Name'), '<?= QString::Truncate($_ITEM->FirstName, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->FirstName), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->FirstName, false)));
			$this->colEmail = new QDataGridColumn(QApplication::Translate('Email'), '<?= QString::Truncate($_ITEM->Email, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Email), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Email, false)));
			$this->colAddr1 = new QDataGridColumn(QApplication::Translate('Addr 1'), '<?= QString::Truncate($_ITEM->Addr1, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Addr1), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Addr1, false)));
			$this->colAddr2 = new QDataGridColumn(QApplication::Translate('Addr 2'), '<?= QString::Truncate($_ITEM->Addr2, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Addr2), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Addr2, false)));
			$this->colCity = new QDataGridColumn(QApplication::Translate('City'), '<?= QString::Truncate($_ITEM->City, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->City), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->City, false)));
			$this->colState = new QDataGridColumn(QApplication::Translate('State'), '<?= QString::Truncate($_ITEM->State, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->State), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->State, false)));
			$this->colZip = new QDataGridColumn(QApplication::Translate('Zip'), '<?= QString::Truncate($_ITEM->Zip, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Zip), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Zip, false)));
			$this->colGender = new QDataGridColumn(QApplication::Translate('Gender'), '<?= QString::Truncate($_ITEM->Gender, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Gender), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Gender, false)));
			$this->colBirthDay = new QDataGridColumn(QApplication::Translate('Birth Day'), '<?= $_ITEM->BirthDay; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->BirthDay), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->BirthDay, false)));
			$this->colBirthMonth = new QDataGridColumn(QApplication::Translate('Birth Month'), '<?= $_ITEM->BirthMonth; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->BirthMonth), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->BirthMonth, false)));
			$this->colBirthYear = new QDataGridColumn(QApplication::Translate('Birth Year'), '<?= $_ITEM->BirthYear; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->BirthYear), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->BirthYear, false)));
			$this->colMainPhone = new QDataGridColumn(QApplication::Translate('Main Phone'), '<?= QString::Truncate($_ITEM->MainPhone, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->MainPhone), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->MainPhone, false)));
			$this->colAltPhone = new QDataGridColumn(QApplication::Translate('Alt Phone'), '<?= QString::Truncate($_ITEM->AltPhone, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->AltPhone), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->AltPhone, false)));
			$this->colNote = new QDataGridColumn(QApplication::Translate('Note'), '<?= QString::Truncate($_ITEM->Note, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Note), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Note, false)));
			$this->colTransferId = new QDataGridColumn(QApplication::Translate('Transfer Id'), '<?= $_ITEM->TransferId; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->TransferId), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->TransferId, false)));
			$this->colContactAdded = new QDataGridColumn(QApplication::Translate('Contact Added'), '<?= $_FORM->dtgMemberContact_ContactAdded_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->ContactAdded), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->ContactAdded, false)));
			$this->colGoogleEmail = new QDataGridColumn(QApplication::Translate('Google Email'), '<?= QString::Truncate($_ITEM->GoogleEmail, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->GoogleEmail), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->GoogleEmail, false)));
			$this->colFacebookEmail = new QDataGridColumn(QApplication::Translate('Facebook Email'), '<?= QString::Truncate($_ITEM->FacebookEmail, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->FacebookEmail), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->FacebookEmail, false)));
			$this->colJoinedClub = new QDataGridColumn(QApplication::Translate('Joined Club'), '<?= $_FORM->dtgMemberContact_JoinedClub_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->JoinedClub), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->JoinedClub, false)));
			$this->colNotActive = new QDataGridColumn(QApplication::Translate('Not Active'), '<?= ($_ITEM->NotActive) ? "true" : "false" ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->NotActive), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->NotActive, false)));
			$this->colImageReference = new QDataGridColumn(QApplication::Translate('Image Reference'), '<?= QString::Truncate($_ITEM->ImageReference, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->ImageReference), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->ImageReference, false)));

			// Setup DataGrid
			$this->dtgMemberContact = new QDataGrid($this);
			$this->dtgMemberContact->CellSpacing = 0;
			$this->dtgMemberContact->CellPadding = 4;
			$this->dtgMemberContact->BorderStyle = QBorderStyle::Solid;
			$this->dtgMemberContact->BorderWidth = 1;
			$this->dtgMemberContact->GridLines = QGridLines::Both;

			// Datagrid Paginator
			$this->dtgMemberContact->Paginator = new QPaginator($this->dtgMemberContact);
			$this->dtgMemberContact->ItemsPerPage = 10;

			// Specify Whether or Not to Refresh using Ajax
			$this->dtgMemberContact->UseAjax = false;

			// Specify the local databind method this datagrid will use
			$this->dtgMemberContact->SetDataBinder('dtgMemberContact_Bind');

			$this->dtgMemberContact->AddColumn($this->colEditLinkColumn);
			$this->dtgMemberContact->AddColumn($this->colId);
			$this->dtgMemberContact->AddColumn($this->colLastName);
			$this->dtgMemberContact->AddColumn($this->colFirstName);
			$this->dtgMemberContact->AddColumn($this->colEmail);
			$this->dtgMemberContact->AddColumn($this->colAddr1);
			$this->dtgMemberContact->AddColumn($this->colAddr2);
			$this->dtgMemberContact->AddColumn($this->colCity);
			$this->dtgMemberContact->AddColumn($this->colState);
			$this->dtgMemberContact->AddColumn($this->colZip);
			$this->dtgMemberContact->AddColumn($this->colGender);
			$this->dtgMemberContact->AddColumn($this->colBirthDay);
			$this->dtgMemberContact->AddColumn($this->colBirthMonth);
			$this->dtgMemberContact->AddColumn($this->colBirthYear);
			$this->dtgMemberContact->AddColumn($this->colMainPhone);
			$this->dtgMemberContact->AddColumn($this->colAltPhone);
			$this->dtgMemberContact->AddColumn($this->colNote);
			$this->dtgMemberContact->AddColumn($this->colTransferId);
			$this->dtgMemberContact->AddColumn($this->colContactAdded);
			$this->dtgMemberContact->AddColumn($this->colGoogleEmail);
			$this->dtgMemberContact->AddColumn($this->colFacebookEmail);
			$this->dtgMemberContact->AddColumn($this->colJoinedClub);
			$this->dtgMemberContact->AddColumn($this->colNotActive);
			$this->dtgMemberContact->AddColumn($this->colImageReference);
		}
		
		public function dtgMemberContact_EditLinkColumn_Render(MemberContact $objMemberContact) {
			return sprintf('<a href="member_contact_edit.php?intId=%s">%s</a>',
				$objMemberContact->Id, 
				QApplication::Translate('Edit'));
		}

		public function dtgMemberContact_ContactAdded_Render(MemberContact $objMemberContact) {
			if (!is_null($objMemberContact->ContactAdded))
				return $objMemberContact->ContactAdded->toString(QDateTime::FormatDisplayDate);
			else
				return null;
		}

		public function dtgMemberContact_JoinedClub_Render(MemberContact $objMemberContact) {
			if (!is_null($objMemberContact->JoinedClub))
				return $objMemberContact->JoinedClub->toString(QDateTime::FormatDisplayDate);
			else
				return null;
		}


		protected function dtgMemberContact_Bind() {
			// Because we want to enable pagination AND sorting, we need to setup the $objClauses array to send to LoadAll()

			// Remember!  We need to first set the TotalItemCount, which will affect the calcuation of LimitClause below
			$this->dtgMemberContact->TotalItemCount = MemberContact::CountAll();

			// Setup the $objClauses Array
			$objClauses = array();

			// If a column is selected to be sorted, and if that column has a OrderByClause set on it, then let's add
			// the OrderByClause to the $objClauses array
			if ($objClause = $this->dtgMemberContact->OrderByClause)
				array_push($objClauses, $objClause);

			// Add the LimitClause information, as well
			if ($objClause = $this->dtgMemberContact->LimitClause)
				array_push($objClauses, $objClause);

			// Set the DataSource to be the array of all MemberContact objects, given the clauses above
			$this->dtgMemberContact->DataSource = MemberContact::LoadAll($objClauses);
		}
	}
?>