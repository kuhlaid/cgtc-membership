<?php

/**

 * @abstract Membership list.

 * @author w. Patrick Gale

 * 

 * June 17, 2023 - wpg

 * - working on adding a link to show members from this member household

 *

 * Dec. 1, 2019 - wpg

 * - adding a link to include a membership joining notification for a member

 * 

 * Feb. 10, 2019 - wpg

 * - auto removing membership access for expiring members (DeleteMemberAcl)

 * 

 * July 1, 2018 - wpg

 * - changed the 90 day expiration query and criteria to correct issue with query and deactivation of membership

 *

 * June 13, 2018 - wpg

 * - made a change to the expired member query to hopefully correct the issue with pulling the wrong members

 *

 * May 16, 2018 - wpg

 * - separating the business membership expiration notices from regular member notice

 *

 * Jan. 1, 2018 - wpg

 * - writing a script to give all active members member access to the application (allowActiveMembersAccess)

 *

 * Dec. 31, 2017 - wpg

 * - adding application access column

 *

 * Dec. 30, 2017 - wpg

 * - adding member access to general member info

 *

 * June 15, 2017 - wpg

 * @todo need to create a bypass for expired membership notifications since the cron job on the web server can not login

 *

 * June 6, 2017 - wpg

 * - adding a door prize membership type (family)

 *

 * June 4, 2017 - wpg

 * - setting up expired membership notifications

 * - adding a filter for 'NotActive' members (exluding these members from all members and expired members lists)

 *

 * May 20, 2017 - wpg

 * - adding a link to create a family member

 *

 * May 4, 2017 - wpg

 * - correcting an issue where the 'add to family membership' button was not available

 *

 * April 28, 2017 - wpg

 * - adding a link to the member notifications

 *

 * April 19, 2017 - wpg

 * - setup access control

 *

 * April 14, 2017 - wpg

 * - creating scripts to convert all upper-case membership info to camel-case

 *

 * April 10, 2017 - wpg

 * - cleaning up the family association link/buttons as I try to link up family members in the application

 *

 * April 9, 2017 - wpg

 * - updating btnSelectFamilyMember function to reflect new family membership paradigm

 * - adding a handler to show only a single member

 * - adding tabs for filtering all members or expired

 *

 * April 7, 2017 - wpg

 * - updating the membership to use the new pardigm of membership associations (no longer using FamilyMemberAssoc table)

 *

 * April 3, 2017 - wpg

 * - fixing expired memberships queries

 *

 * March 27, 2017 - wpg

 * - continuing to work on family membership associations (needs some work)

 * - showing expired memberships

 *

 * March 24, 2017 - wpg

 * - adding handlers for family membership associations and flagging when associations are missing for a membership log

 *

 * March 21, 2017 - wpg

 * - adding member tagging

 *

 * March 19, 2017 - wpg

 * - sorting memberlist by last entered member id

 * - adding a notice if no membership log has been entered for the member

 * - adding email address to search

 *

 * March 18, 2017 - wpg

 *  - starting to do something with the data now that I have initial active member information imported

 *  - added links to membership logs and adding a new membership log

 *

 *  March 13, 2017 - wpg

 *  - created initial list view

 */



	require('includes/prepend.inc.php');		/* if you DO NOT have "includes/" in your include_path */

	require(__FORMBASE_CLASSES__ . '/MemberContactListFormBase.class.php');

	QApplication::CheckRemoteAdmin();



	// system admin

	class acx1MembershipListForm extends MemberContactListFormBase {

		protected $txtSearch, $objDefaultWaitIcon, $dttStart, $dttEnd, $colTags, $memberTagId, $memberTagName,

		$strOption, $strEmailOption, $intMemberId, $objMemberContact, $blnReadOnly, $colAcl;



		protected function blnReadOnly() {

			$this->blnReadOnly=false;

		}



		protected function Form_Create() {

			$this->blnReadOnly();

			$this->strOption = QApplication::QueryString('strOption');

			$this->strEmailOption = QApplication::QueryString('strEmailOption');



			if ($this->strOption == 'closeFamilyMemberSelection'){

				$this->closeFamilyMemberSelection();

			}



			// allow member login access to the application for those still active

			if ($this->strOption == 'allowActiveMembersAccess'){

				// MembershipList.php?strOption=allowAllMembersAccess

				// only include active members

				if ($strAndCondition != '') $strAndCondition .= ',';

				$strAndCondition .= "QQ::OrCondition(

						QQ::Equal(QQN::MemberContact()->NotActive, 0),

						QQ::IsNull(QQN::MemberContact()->NotActive)

				)";

				if ($strAndCondition != '')

					$strAndCondition = "QQ::AndCondition(".$strAndCondition.")";



				// Set the DataSource to be the array of all MemberContact objects, given the clauses above

				$objMemberArray = MemberContact::QueryArray(eval("return $strAndCondition;"));

				$c=0;

				foreach($objMemberArray as $objMemberContact) {

					// check to see if the members already has member login rights

					$objMemberAclAssnArray = MemberAclAssn::LoadArrayByMemberId($objMemberContact->Id);

					$intNotHaveAccess=1;

					if ($objMemberAclAssnArray) foreach ($objMemberAclAssnArray as $objMemberAclAssn) {

						if ($objMemberAclAssn->Acl==2){

							$intNotHaveAccess=0;

						}

					}

					if ($intNotHaveAccess) {

						$objMemberAclAssn = new MemberAclAssn();

						$objMemberAclAssn->MemberId = $objMemberContact->Id;

						$objMemberAclAssn->Acl = 2;

						$objMemberAclAssn->Save();

					}



				}

			}



			// convert upper-case member profile information to camel-case

// 			if ($this->strOption == 'updateMemberProfileCase'){

// 				$objMemberContactArray = MemberContact::LoadAll();

// 				if ($objMemberContactArray) foreach($objMemberContactArray as $objMemberContact) {

// 					$objMemberContact->FirstName=ucwords(ucwords(strtolower($objMemberContact->FirstName), "(-'"));

// 					$objMemberContact->LastName=ucwords(ucwords(strtolower($objMemberContact->LastName), "(-'"));

// 					$objMemberContact->Addr1=ucwords(ucwords(strtolower($objMemberContact->Addr1), "(-'"));

// 					$objMemberContact->Addr2=ucwords(strtolower($objMemberContact->Addr2));

// 					$objMemberContact->City=ucwords(strtolower($objMemberContact->City));

// 					$objMemberContact->Email=strtolower($objMemberContact->Email);

// 					$objMemberContact->Save();

// 				}

// 			}



			// see if we only want to look at one member

			$this->intMemberId = QApplication::QueryString('iMD');

			$this->objMemberContact = MemberContact::Load($this->intMemberId);

			if ($this->intMemberId && !$this->objMemberContact) $this->noMember();



			$this->objDefaultWaitIcon = new QWaitIcon($this);

			$this->objDefaultWaitIcon->CssClass = 'waitIcon';

			$this->memberTagging();





			$this->txtSearch_Create();

			

			// we need to disable the search box if we are filtering on something else

			if (trim($this->strOption ?? '') != "showHousehold" && trim($this->intMemberId ?? '') == "") {

			    $this->txtSearch->Name = "Membership search (by name or email address): <span class='sm'>(Enter part of a member name or email address you are searching for)</span>";

			}

			else {

			    if (trim($this->strOption ?? '') == "showHousehold") $strSearchBy = $this->strOption;

			    else $strSearchBy = 'individual member';

			    

			    $this->txtSearch->Name = "<div class='alert alert-warning'>Filtering by ".$strSearchBy."</div> <a href='?'>Reset filter to search</a>";

			    $this->txtSearch->Enabled = False;

			}

			$this->dttStart_Create();

			$this->dttEnd_Create();



			// Setup DataGrid Columns

			$this->colEditLinkColumn = new QDataGridColumn(QApplication::Translate('Edit'), '<?= $_FORM->dtgMemberContact_EditLinkColumn_Render($_ITEM) ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Id, false)));



			/* // used initially when moving from Excel to a database to convert all uppercase member names to camel case

			$this->colCamel = new QDataGridColumn(QApplication::Translate('Member'), '<?= $_FORM->dtgMemberContact_CamelColumn_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Id, false)));

			*/

			$this->colId = new QDataGridColumn(QApplication::Translate('ID'), '<?= $_ITEM->Id; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Id), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Id, false)));

			$this->colAcl = new QDataGridColumn(QApplication::Translate('Application Access'), '<?= $_FORM->dtgMemberContact_AclColumn_Render($_ITEM); ?>');

			$this->colFirstName = new QDataGridColumn(QApplication::Translate('First Name'), '<?= QString::Truncate($_ITEM->FirstName, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->FirstName), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->FirstName, false)));

			$this->colEmail = new QDataGridColumn(QApplication::Translate('Contact'), '<?= $_FORM->dtgMemberContact_ContactColumn_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Email), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Email, false)));

			$this->colAddr1 = new QDataGridColumn(QApplication::Translate('Member'), '<?= $_FORM->dtgMemberContact_AddressColumn_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->LastName), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->LastName, false)));

			$this->colAddr2 = new QDataGridColumn(QApplication::Translate('Addr 2'), '<?= QString::Truncate($_ITEM->Addr2, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Addr2), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Addr2, false)));

			$this->colCity = new QDataGridColumn(QApplication::Translate('City'), '<?= QString::Truncate($_ITEM->City, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->City), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->City, false)));

			$this->colState = new QDataGridColumn(QApplication::Translate('State'), '<?= QString::Truncate($_ITEM->State, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->State), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->State, false)));

			$this->colZip = new QDataGridColumn(QApplication::Translate('Zip'), '<?= QString::Truncate($_ITEM->Zip, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Zip), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Zip, false)));

			$this->colBirthDay = new QDataGridColumn(QApplication::Translate('Birth Day'), '<?= $_ITEM->BirthDay; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->BirthDay), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->BirthDay, false)));

			$this->colBirthMonth = new QDataGridColumn(QApplication::Translate('Birth Month'), '<?= $_ITEM->BirthMonth; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->BirthMonth), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->BirthMonth, false)));

			$this->colBirthYear = new QDataGridColumn(Q__SUBDIRECTORY__::Translate('Birth Year'), '<?= $_ITEM->BirthYear; ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->BirthYear), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->BirthYear, false)));

			$this->colMainPhone = new QDataGridColumn(QApplication::Translate('Main Phone'), '<?= QString::Truncate($_ITEM->MainPhone, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->MainPhone), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->MainPhone, false)));

			$this->colAltPhone = new QDataGridColumn(QApplication::Translate('Alt Phone'), '<?= QString::Truncate($_ITEM->AltPhone, 200); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->AltPhone), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->AltPhone, false)));

			$this->colNote = new QDataGridColumn(QApplication::Translate('Notes/Membership Logs'), '<?= $_FORM->dtgMemberContact_MembershipLogColumn_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->Note), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->Note, false)));

			$this->colTags = new QDataGridColumn(QApplication::Translate('Participation'), '<?= $_FORM->dtgMemberContact_MembershipTags_Render($_ITEM); ?>');

			$this->colJoinedClub = new QDataGridColumn(QApplication::Translate('Joined Club'), '<?= $_FORM->dtgMemberContact_JoinedClub_Render($_ITEM); ?>', array('OrderByClause' => QQ::OrderBy(QQN::MemberContact()->JoinedClub), 'ReverseOrderByClause' => QQ::OrderBy(QQN::MemberContact()->JoinedClub, false)));



			$this->colAcl->HtmlEntities = $this->colTags__SUBDIRECTORY__ies  = $this->colNote->HtmlEntities = $this->colAddr1->HtmlEntities = $this->colEditLinkColumn->HtmlEntities = false;

			$this->colTags->HorizontalAlign  = QHorizontalAlign::Center;



			// Setup DataGrid

			$this->dtgMemberContact = new QDataGrid($this);

			$this->dtgMemberContact->CellSpacing = 0;

			$this->dtgMemberContact->CellPadding = 4;

			$this->dtgMemberContact->BorderStyle = QBorderStyle::Solid;

			$this->dtgMemberContact->BorderWidth = 1;

			$this->dtgMemberContact->GridLines = QGridLines::Both;

			$this->dtgMemberContact->CssClass='table table-bordered';



			// Datagrid Paginator

			$this->dtgMemberContact->Paginator = new QPaginator($this->dtgMemberContact);

			$this->dtgMemberContact->ItemsPerPage = __ITEMS_PER_PAGE__;



			// Specify Whether or Not to Refresh using Ajax

			$this->dtgMemberContact->UseAjax = false;



			// Specify the local databind method this datagrid will use

			$this->dtgMemberContact->SetDataBinder('dtgMemberContact_Bind');



			$this->showColumns();

		}



		protected function noMember(){

			QSessionDB::set("error", "There was an error accessing the membership log. Try again.");

			QApplication::Redirect('MembershipList.php');

			exit;

		}



		protected function memberTagging(){

			$this->memberTagId = QSessionDB::get('__MEMBER_TAG_ID__');

			$this->memberTagName = QSessionDB::get('__MEMBER_TAG_NAME__');

		}



		protected function showColumns() {

			$this->dtgMemberContact->SortColumnIndex = 0;

			$this->dtgMemberContact->SortDirection = 1;



			$this->dtgMemberContact->AddColumn($this->colEditLinkColumn);

			// 			$this->dtgMemberContact->AddColumn($this->colFirstName);

			// 			$this->dtgMemberContact->AddColumn($this->colEmail);

			$this->dtgMemberContact->AddColumn($this->colAddr1);

 			//$this->dtgMemberContact->AddColumn($this->colCamel);

			// 			$this->dtgMemberContact->AddColumn($this->colState);

			$this->dtgMemberContact->AddColumn($this->colTags);

			$this->dtgMemberContact->AddColumn($this->colNote);

			$this->dtgMemberContact->AddColumn($this->colAcl);

		}



		public function dtgMemberContact_EditLinkColumn_Render(MemberContact $objMemberContact) {

			return sprintf('<a href="MemberContact.php?intId=%s">%s</a>',

					$objMemberContact->Id,

					QApplication::Translate('Edit'));

		}



		// Dec. 31, 2017 - wpg

		public function dtgMemberContact_AclColumn_Render(MemberContact $objMemberContact) {

			$return='';

			$objMemberAclAssnArray = MemberAclAssn::LoadArrayByMemberId($objMemberContact->Id);

			if ($objMemberAclAssnArray) foreach ($objMemberAclAssnArray as $objMemberAclAssn) {

				$return .= '<div class="tag">'.MemberAclAssn::$accessArray[$objMemberAclAssn->Acl].'</div>';

			}

			return $return."<div class='tag'><a href='MemberAcl.php?iMD=".$objMemberContact->Id."' class='sm'>Update access</a></div>";

		}



		public function dtgMemberContact_MembershipTags_Render(MemberContact $objMemberContact) {

			$objMemberTagAssocArray = MemberTagAssoc::QueryArray(

					QQ::Equal(QQN::MemberTagAssoc()->MemberId, $objMemberContact->Id),

					QQ::Clause(QQ::OrderBy(QQN::MemberTagAssoc()->TagIdObject->Name)));

			$return = '';

			$isTagged = false;



			// show if a member is no longer active

			if ($objMemberContact->NotActive) $return .= '<div class="error bld">Not active</div>';

			else $return .= '<div class="bld" style="color:green;">Active</div>';



			if ($objMemberTagAssocArray)foreach ($objMemberTagAssocArray as $objMemberTagAssoc){

				// if the member has been tagged with this already then show remove link

				if ($this->memberTagId && $this->memberTagId == $objMemberTagAssoc->TagId){

					$isTagged = true;

				}

				else

					$return .= '<div class="tag">'.$objMemberTagAssoc->TagIdObject->Name.'</div>';

			}



			if (!$isTagged && $this->memberTagId){

				//////////////

				$btnTag='';

				// we will use explicitly defined control ids.

				$strControlId = 'btnTag' . $objMemberContact->Id;



				// Let's see if the button exists already

				$btnTag = $this->GetControl($strControlId);



				if (!$btnTag) {

					$btnTag = new QButton($this->dtgMemberContact, $strControlId);

					$btnTag->ActionParameter = $objMemberContact->Id;

					// Let's assign a server action on click

					$btnTag->AddAction(new QClickEvent(), new QServerAction('btnTag_Add'));

				}

				$btnTag->Text =  "Tag this member";



				// Render the tagging button.  We want to *return* the contents of the rendered button,

				// not display it.  (The datagrid is responsible for the rendering of this column).

				// Therefore, we must specify "false" for the optional blnDisplayOutput parameter.

				if ($btnTag)

					return $btnTag->Render(false).$return;

				/////////////

			}

			if ($isTagged && $this->memberTagId){

				//////////////

				$btnTag='';

				// we will use explicitly defined control ids.

				$strControlId = 'btnTag' . $objMemberContact->Id;



				// Let's see if the button exists already

				$btnTag = $this->GetControl($strControlId);



				if (!$btnTag) {

					$btnTag = new QButton($this->dtgMemberContact, $strControlId);

					$btnTag->ActionParameter = $objMemberContact->Id;

					// Let's assign a server action on click

					$btnTag->AddAction(new QClickEvent(), new QConfirmAction('Are you SURE you want to DELETE this tag?'));

					$btnTag->AddAction(new QClickEvent(), new QServerAction('btnTag_Remove'));

				}

				$btnTag->Text =  "Remove '".QSessionDB::get('__MEMBER_TAG_NAME__')."' tag for this member";



				// Render the tagging button.  We want to *return* the contents of the rendered button,

				// not display it.  (The datagrid is responsible for the rendering of this column).

				// Therefore, we must specify "false" for the optional blnDisplayOutput parameter.

				if ($btnTag)

					return $btnTag->Render(false).$return;

				/////////////

			}

			return $return;

		}



		// add a tag for a member

		protected function btnTag_Add($strFormId, $strControlId, $strParameter) {

			$objMemberTagAssoc = new MemberTagAssoc();

			$objMemberTagAssoc->MemberId = $strParameter;

			$objMemberTagAssoc->TagId = $this->memberTagId;

			$objMemberTagAssoc->Save();

			//QApplication::DisplayAlert($strParameter.' tagged with '.$this->memberTagId);

			$this->dtgMemberContact_Bind();

		}



		// remove tag for a member

		protected function btnTag_Remove($strFormId, $strControlId, $strParameter) {

			$objMemberTagAssoc = MemberTagAssoc::Load($strParameter, $this->memberTagId);

			$objMemberTagAssoc->Delete();

			//QApplication::DisplayAlert($strParameter.' tagged with '.$this->memberTagId);

			$this->dtgMemberContact_Bind();

		}



		protected function txtSearch_Create() {

			$this->txtSearch = new QTextBox($this);

			$this->txtSearch->Width = "100%";

// 			$this->txtSearch->Name = "Membership search";

			$this->txtSearch->AddAction(new QEnterKeyEvent(), new QAjaxAction('updateGrid'));

			$this->txtSearch->CssClass = 'hghLight';

			$this->txtSearch->AddAction(new QEnterKeyEvent(), new QTerminateAction());

		}



		protected function dttStart_Create() {

			$this->dttStart = new QJsCalendar($this);

			$this->dttStart->Width = "100px";

			$this->dttStart->AddAction(new QChangeEvent(), new QAjaxAction('updateGrid'));

		}



		protected function dttEnd_Create() {

			$this->dttEnd = new QJsCalendar($this);

			$this->dttEnd->Width = "100px";

			$this->dttEnd->AddAction(new QChangeEvent(), new QAjaxAction('updateGrid'));

		}



		public function dtgMemberContact_AddressColumn_Render(MemberContact $objMemberContact) {



			// if expired membership then send out a notification

			// $_ENV['EXPIRATION_NOTICE_URL']



			// execute the notifications at:

			// $_ENV['SEND_EXPIRY_NOTICE_URL']



			// check to see if the member is a business partner or not (May 16, 2018 - wpg)

			$objBusinessMemberAssoc = BusinessMemberAssoc::QuerySingle(

					QQ::Equal(QQN::BusinessMemberAssoc()->MemberId, $objMemberContact->Id));



			// testing

// 			if ($objBusinessMemberAssoc && $this->strOption == 'showExpired' && $this->strEmailOption=='sendExpirationNotice' && $objMemberContact->Email!='') {

// 				return 'email business';

// 			}

// 			elseif ($this->strOption == 'showExpired' && $this->strEmailOption=='sendExpirationNotice' && $objMemberContact->Email!='') {

// 				return 'email member';

// 			}



			if ($objBusinessMemberAssoc && $this->strOption == 'showExpired' && $this->strEmailOption=='sendExpirationNotice' && $objMemberContact->Email!='') {

				if (!curl_init()) { print "Error: Authentication cannot be run with the current setup."; exit; }

				$ch = curl_init(''.__APP_DOMAIN__.__URLROOT__.'/emailNotification.php?option=businessMembershipExpired&iMD='.$objMemberContact->Id);

				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);

				curl_exec($ch);

				curl_close ($ch);



				QSessionDB::set('error','Expired membership notifications have been sent.');

			}

			// normal membership expiration notice

			elseif ($this->strOption == 'showExpired' && $this->strEmailOption=='sendExpirationNotice') {

				// if the member has an email address send a notice

				if ($objMemberContact->Email!='') {

					if (!curl_init()) { print "Error: Authentication cannot be run with the current setup."; exit; }

					$ch = curl_init(''.__APP_DOMAIN__.__URLROOT__.'/emailNotification.php?option=membershipExpired&iMD='.$objMemberContact->Id);

					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

					curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);

					curl_exec($ch);

					curl_close ($ch);



					QSessionDB::set('error','Expired membership notifications have been sent.');

				}

				//QApplication::DisplayAlert('expired membership for '.$objMemberContact->Email);

				//QApplication::Redirect('emailNotification.php?option=membershipExpired&iMD='.$objMemberContact->Id);





				// see if membership has expired for 90 days

				$today = QDateTime::Now(false);

				$dt = QDateTime::Now(false);

				$ninetyDays = $dt->SubtractDays(90);	// 90 days ago



				// get the existing memberships for active members

				$strQuery = "SELECT ml.Id, ma.MemberId, MAX(ml.ExpireDate) as ExpireDate

	FROM MembershipAssoc ma

	LEFT JOIN MembershipLog ml ON ml.Id=ma.MembershipLogId

	WHERE ml.Id IS NOT NULL and ma.MembershipLogId IN (SELECT Id FROM MembershipLog)

	AND ma.MemberId IN (SELECT Id FROM MemberContact WHERE NotActive=0 OR NotActive IS NULL)

	AND ma.MemberId=".$objMemberContact->Id."

	GROUP BY ma.MemberId

	ORDER BY ma.MemberId,ml.ExpireDate";

				//	AND ml.ExpireDate <= '".$ninetyDays->toString('YYYY-MM-DD')."'

				$objDatabase = MembershipLog::GetDatabase();

				$objDbResult = $objDatabase->Query($strQuery);

				// expired membership, disable account

				while ($objDbRow = $objDbResult->FetchArray()) {

					// only deactivate if expired 90 days ago

					if ($objDbRow['ExpireDate'] <= $ninetyDays->toString('YYYY-MM-DD')) {

						//$objMemberContact2 = MemberContact::Load($objMemberContact->Id);

						$objMemberContact->NotActive = 1;

						$objMemberContact->Note = 'membership was not renewed after 90 days so account deactivated ('.$today->toString('YYYY-MM-DD').' wpg);'.$objMemberContact->Note;

	 					$objMemberContact->Save();





						// remove all access for the member and then reassign new settings

						MemberAclAssn::DeleteMemberAcl($objMemberContact->Id);



	 					//MemberAclAssn::DeleteMemberAcl($objMemberContact->Id);	// remove membership access

						print 'expired membership for '.$objMemberContact->__toString().' --- '.$ninetyDays->toString('YYYY-MM-DD');

					}

				}

			}





			return MemberContact::BasicMemberContactInfo($objMemberContact,trim($this->txtSearch->Text ?? ''));

		}



		// conversion of upper-case to camel

// 		public function dtgMemberContact_CamelColumn_Render(MemberContact $objMemberContact) {

// 			$return='';

// 			if ($objMemberContact->FirstName){

// 				$return.="<b>".ucwords(ucwords(strtolower($objMemberContact->FirstName), "(-'"))."</b>";

// 			}

// 			if ($objMemberContact->LastName){

// 				if($return!='')$return.=" ";

// 				$return.="<b>".ucwords(ucwords(strtolower($objMemberContact->LastName), "(-'"))."</b>";

// 			}

// 			if ($objMemberContact->Addr1){

// 				if($return!='')$return.="<br/>";

// 				$return.=ucwords(strtolower($objMemberContact->Addr1));

// 			}

// 			if ($objMemberContact->Addr2){

// 				if($return!='')$return.="<br/>";

// 				$return.=ucwords(strtolower($objMemberContact->Addr2));

// 			}

// 			if ($objMemberContact->City){

// 				if($return!='')$return.="<br/>";

// 				$return.=ucwords(strtolower($objMemberContact->City));

// 			}

// 			if ($objMemberContact->State){

// 				if($return!='')$return.=" ";

// 				$return.=$objMemberContact->State;

// 			}

// 			if ($objMemberContact->Zip){

// 				if($return!='')$return.=" ";

// 				$return.=$objMemberContact->Zip;

// 			}

// 			if ($objMemberContact->Email){

// 				if($return!='')$return.="<br/>";

// 				$return.="<a href='mailto:".strtolower($objMemberContact->Email)."'>".strtolower($objMemberContact->Email)."</a>";

// 			}

// 			if ($objMemberContact->MainPhone){

// 				if($return!='')$return.="<br/>";

// 				$return.=$objMemberContact->MainPhone." (main)";

// 			}

// 			if ($objMemberContact->AltPhone){

// 				if($return!='')$return.="<br/>";

// 				$return.=$objMemberContact->AltPhone." (alt)";

// 			}

// 			return $return;

// 		}





		// return the member notes and membership log

		public function dtgMemberContact_MembershipLogColumn_Render(MemberContact $objMemberContact) {

			$intNotificationLog = NotificationLog::QueryCount(

				QQ::AndCondition(

					QQ::Equal(QQN::NotificationLog()->MemberId, $objMemberContact->Id),

					QQ::Equal(QQN::NotificationLog()->NotificationType, 8)

				)

				);

			$notifications="";

			if (!$this->blnReadOnly) {

				$notifications="<br/><a href='NotificationLogs.php?iMD=".$objMemberContact->Id."' class='bld'>View member notifications</a>";

				$notifications.="<br/><a href='Membership.php?iMD=".$objMemberContact->Id."' class='bld sm'>Update membership</a>";

				$notifications.="<br/><a href='NotificationLog.php?iMD=".$objMemberContact->Id."&logType=8' class='bld sm'>Add reason for joining</a>";

				if ($intNotificationLog!='') $notifications.= " (".$intNotificationLog." reasons added)";

				$notifications.="<br/><a href='MemberContact.php?intId=".$objMemberContact->Id."&option=copy' class='bld sm'>Copy contact info for additional family member</a>";

			}



			$return='';

			if ($objMemberContact->Note){

				$return.="Note: ".$objMemberContact->Note;

			}



			$assignedAsFamilyMember=$isPrimaryMember=0;

			// get membership logs for the member (showing only the latest)

			$objMembershipAssoc = MembershipAssoc::GetLatestMembershipForMember($objMemberContact->Id);



			// membership log found

			if ($objMembershipAssoc) {

				if($return!='')$return.="<hr/>";

				$return.="<br/><a href='MembershipLogs.php?iMD=".$objMemberContact->Id."' class='bld fs14'>View membership logs</a>";

				// adding a link to filter by household

				$return.=" | <a href='?strOption=showHousehold&strAddy=".$objMemberContact->Addr1."'>🏠 Show household members</a>";

				//foreach($objMembershipAssocArray as $objMembershipAssoc) {

					if($return!='')$return.="<br/>";

// 					$expired='';

// 					if ($objMembershipAssoc->MembershipLogIdObject->ExpireDate->toString('YYYYMMDD') < QDateTime::NowToString('YYYYMMDD')){

// 						$expired = ' class="error"';

// 						// add expiration notification button and list of notifications made (if email address provided)

// 					}

// 					else {

// 						// maybe add 'welcome' notification link if a welcome note has not been sent

// 					}

// 					$return.="Current membership expires <b".$expired.">".$objMembershipAssoc->MembershipLogIdObject->ExpireDate->toString()."</b>";



					$return.=MembershipAssoc::CurrentMembershipExpireString($objMembershipAssoc);

					// if the membership is a family membership then

					if ($objMembershipAssoc->MembershipLogIdObject->LogType == 3 || $objMembershipAssoc->MembershipLogIdObject->LogType == 4 || $objMembershipAssoc->MembershipLogIdObject->LogType == 8 || $objMembershipAssoc->MembershipLogIdObject->LogType == 11){

						if ($objMembershipAssoc->MemberId==$objMemberContact->Id && QSessionDB::get('__FAMILY_ASSOC_MEMBERSHIP_ID__')==$objMembershipAssoc->MembershipLogIdObject->Id) {

							$assignedAsFamilyMember=1;

							//QApplication::DisplayAlert('assigned'.QSessionDB::get('__FAMILY_ASSOC_MEMBERSHIP_ID__').$objMemberContact->Id);

						}



						$objMembershipLogArray = MembershipAssoc::QueryArray(

								QQ::Equal(QQN::MembershipAssoc()->MembershipLogIdObject->Id, $objMembershipAssoc->MembershipLogIdObject->Id)

						);

						//QApplication::DisplayAlert($intMembershipLogCount);

						if ($objMembershipAssoc->MemberId==$objMemberContact->Id && $objMembershipAssoc->PrimaryMember==1 && QSessionDB::get('__FAMILY_ASSOC_MEMBERSHIP_ID__')==$objMembershipAssoc->MembershipLogIdObject->Id) {

							$isPrimaryMember=1;

							//QApplication::DisplayAlert('isPrimaryMember'.QSessionDB::get('__FAMILY_ASSOC_MEMBERSHIP_ID__').$objMemberContact->Id);

							$return.="<div class='bld fs14'>Family membership: Primary contact</div>";

						}

						// do not return this if we are in 'add to family membership' mode

						elseif ($objMembershipAssoc->MemberId==$objMemberContact->Id && $objMembershipAssoc->PrimaryMember==0 && !QSessionDB::get('__FAMILY_ASSOC_PRIMARY_MEMBER_ID__')) {

							return $return.="<div class='ital sm'>Family membership: Secondary contact</div>".$notifications;

						}

						$btnFamilyAssoc='';

						// we will use explicitly defined control ids.

						$strControlId = 'btnFamilyAssoc' . $objMemberContact->Id;

						// Let's see if the button exists already

						$btnFamilyAssoc = $this->GetControl($strControlId);





						// we need to add additional family members

						if ($objMembershipAssoc->PrimaryMember==1 && !QSessionDB::get('__FAMILY_ASSOC_PRIMARY_MEMBER_ID__')){





							if (!$btnFamilyAssoc) {

								$btnFamilyAssoc = new QButton($this->dtgMemberContact, $strControlId);

								$btnFamilyAssoc->ActionParameter = $objMemberContact->Id."::".$objMembershipAssoc->MembershipLogIdObject->Id."::".$objMemberContact->__toString();	// we need to send the primary member ID and membership log to the action

								// Let's assign a server action on click

								$btnFamilyAssoc->AddAction(new QClickEvent(), new QServerAction('btnAddFamilyMembers'));

							}

							$btnFamilyAssoc->Text =  "Add family members to this membership";

                            

							// no family members associated with the membership

							if (count($objMembershipLogArray) < 2)

							

								$return.="<div class='bld error fs14'>***No other family members associated with this membership***</div>";



							// Render the tagging button.  We want to *return* the contents of the rendered button,

							// not display it.  (The datagrid is responsible for the rendering of this column).

							// Therefore, we must specify "false" for the optional blnDisplayOutput parameter.



							if (!$this->blnReadOnly && $btnFamilyAssoc)

								return $btnFamilyAssoc->RenderNoBreaks(false).$return.$notifications;

							else return $return;

							/////////////

							return;

						}

					}

// 					break;	// stop after first log since it is the most recent

// 				}

			}

			else $return.="<div class='bld error fs14'>***No membership logged***</div>";



			// -------------- add family members

			if (QSessionDB::get('__PRIMARY_FAMILY_MEMBER_NAME__')!='' && !$assignedAsFamilyMember && !$isPrimaryMember) {

				$btnFamilyAssoc='';

				// we will use explicitly defined control ids.

				$strControlId = 'btnFamilyAssoc' . $objMemberContact->Id;



				// Let's see if the button exists already

				$btnFamilyAssoc = $this->GetControl($strControlId);



				if (!$btnFamilyAssoc) {

					$btnFamilyAssoc = new QButton($this->dtgMemberContact, $strControlId);

					$btnFamilyAssoc->ActionParameter = $objMemberContact->Id;

					// Let's assign a server action on click

					$btnFamilyAssoc->AddAction(new QClickEvent(), new QServerAction('btnSelectFamilyMember'));



				}

				$btnFamilyAssoc->Text =  "Add to ".QSessionDB::get('__PRIMARY_FAMILY_MEMBER_NAME__')." membership";



				// Render the tagging button.  We want to *return* the contents of the rendered button,

				// not display it.  (The datagrid is responsible for the rendering of this column).

				// Therefore, we must specify "false" for the optional blnDisplayOutput parameter.

				if ($btnFamilyAssoc)

					return $btnFamilyAssoc->Render(false).$return.$notifications;

				/////////////

				return;

			}



			return $return.$notifications;

		}



		protected function btnSelectFamilyMember($strFormId, $strControlId, $strParameter) {

			$objMembershipAssoc = MembershipAssoc::QuerySingle(

				QQ::AndCondition(

				QQ::Equal(QQN::MembershipAssoc()->MemberId, $strParameter),

				QQ::Equal(QQN::MembershipAssoc()->MembershipLogId, QSessionDB::get('__FAMILY_ASSOC_MEMBERSHIP_ID__'))

				)

			);

			if (!$objMembershipAssoc) {

				$objMembershipAssoc = new MembershipAssoc();

				$objMembershipAssoc->MemberId = $strParameter;

				$objMembershipAssoc->PrimaryMember = 0;

				$objMembershipAssoc->MembershipLogId = QSessionDB::get('__FAMILY_ASSOC_MEMBERSHIP_ID__');

				$objMembershipAssoc->Save();

				$this->updateGrid();

			}

			else{

				QApplication::DisplayAlert('Member already assigned to this family membership.  There may be another membership log assigned to the member currently that needs to be removed.');

			}

		}



		protected function btnAddFamilyMembers($strFormId, $strControlId, $strParameter) {

			$membershipArray = explode("::", $strParameter);

			// start the family member association session

			QSessionDB::set('__FAMILY_ASSOC_PRIMARY_MEMBER_ID__', $membershipArray[0]);

			QSessionDB::set('__FAMILY_ASSOC_MEMBERSHIP_ID__', $membershipArray[1]);

			QSessionDB::set('__PRIMARY_FAMILY_MEMBER_NAME__', $membershipArray[2]);

			//$this->closeTagBtnActions();asdf

		}





		protected function closeFamilyMemberSelection() {

			QSessionDB::Delete('__FAMILY_ASSOC_PRIMARY_MEMBER_ID__');

			QSessionDB::Delete('__FAMILY_ASSOC_MEMBERSHIP_ID__');

			QSessionDB::Delete('__PRIMARY_FAMILY_MEMBER_NAME__');

		}



		protected function updateGrid() {

			searchFilterChange($this->dtgMemberContact);

			$this->dtgMemberContact_Bind();

		}



		// find members who do not have memberships expired after 90 days

		protected function get90DayExpired() {

			$dt = QDateTime::Now(false);

			$ninetyDays = $dt->SubtractDays(90);	// 90 days ago



			/*

			 * SELECT * FROM MembershipLog a WHERE a.MemberId IN (SELECT Id FROM MemberContact WHERE NotActive=0 OR NotActive IS NULL) AND Id IN (SELECT MemberId FROM MembershipAssoc) AND Id IN ( SELECT c.Id FROM MembershipLog c JOIN MembershipLog b ON b.id=c.Id WHERE EXISTS ( SELECT MemberId, MAX(ExpireDate) AS MaxExpireDate FROM MembershipLog groupd WHERE Id IN (SELECT MembershipLogId FROM MembershipAssoc) GROUP BY MemberId ) AND c.ExpireDate <= '2018-01-06' )

			*

			*/



			// get the existing memberships for active members

			$strQuery = "SELECT ml.Id, ma.MemberId as MemberId, MAX(ml.ExpireDate) as ExpireDate

FROM MembershipAssoc ma

LEFT JOIN MembershipLog ml ON ml.Id=ma.MembershipLogId

WHERE ml.Id IS NOT NULL and ma.MembershipLogId IN (SELECT Id FROM MembershipLog)

AND ma.MemberId IN (SELECT Id FROM MemberContact WHERE NotActive=0 OR NotActive IS NULL)

GROUP BY ma.MemberId

ORDER BY ma.MemberId,ml.ExpireDate";



			$objDatabase = MembershipLog::GetDatabase();

			$objDbResult = $objDatabase->Query($strQuery);

			$expiredMembersshipId = array();

			// expired membership, disable account

			while ($objDbRow = $objDbResult->FetchArray()) {

				if (str_replace('-', '', $objDbRow['ExpireDate']) <= $ninetyDays->toString('YYYYMMDD'))

				array_push($expiredMembersshipId,$objDbRow['MemberId']);

			}

// 			$objDatabase = MembershipLog::GetDatabase();

// 			$objDbResult = $objDatabase->Query($strQuery);

// 			$membershipLogArray = array();

// 			// get the most recent membership log

// 			while ($objDbRow = $objDbResult->FetchArray()) {

// 				$membershipLogArray[$objDbRow['MemberId']] = $objDbRow['Id'];

// 			}



// 			// get expired memberships and then we will compare

// 			$strQuery2 = "SELECT * FROM MembershipLog

// WHERE ExpireDate <= '".$ninetyDays->toString('YYYY-MM-DD')."'";

// 			$objDbResult = $objDatabase->Query($strQuery2);

// 			$expiredMembershipLogArray = array();

// 			// get the most recent membership log

// 			while ($objDbRow = $objDbResult->FetchArray()) {

// 				array_push($expiredMembershipLogArray,$objDbRow['Id']);

// 			}



// 			$expiredMembersshipId=array();

// 			foreach($membershipLogArray as $mem=>$logId){

// 				// get the list of expired memberships

// 				if (in_array($logId, $expiredMembershipLogArray)){

// 					//print_r(count($expiredMembersshipId)."member".$mem."log".$logId."<br/>");

// 					array_push($expiredMembersshipId, $mem);

// 				}

// 			}

			return $expiredMembersshipId;

		}



		protected function dtgMemberContact_Bind() {

			// if filtering by a single member and not searching

			// else show entire list

			if ($this->objMemberContact && $this->txtSearch->Text == '') {

				$this->dtgMemberContact->TotalItemCount=1;

				$this->dtgMemberContact->DataSource=array($this->objMemberContact);

				return;

			}



			$strAndCondition = "";



			if ($this->txtSearch->Text != null) {

				// needed to addslashes because the queries will break if ending with \

				$strAndCondition .= "

						QQ::OrCondition(

							QQ::Like(QQN::MemberContact()->Addr1, '%".addslashes(wildcardEscape(trim($this->txtSearch->Text ?? '')))."%'),

							QQ::Like(QQN::MemberContact()->FirstName, '%".addslashes(wildcardEscape(trim($this->txtSearch->Text ?? '')))."%'),

							QQ::Like(QQN::MemberContact()->LastName, '%".addslashes(wildcardEscape(trim($this->txtSearch->Text ?? '')))."%'),

							QQ::Like(QQN::MemberContact()->Email, '%".addslashes(wildcardEscape(trim($this->txtSearch->Text ?? '')))."%')

						)

				";

			}

			// if we only want to see expired memberships then we need to run a special query

			if ($this->strOption == 'showExpired'){

				$this->dtgMemberContact->ItemsPerPage = 500;



				// get the number of existing members who do not have memberships expired before today

				$strQuery = "SELECT Id FROM `MemberContact`

				WHERE Id IN (

				SELECT MemberId FROM MembershipAssoc WHERE MembershipLogId IN (

				SELECT Id FROM `MembershipLog` WHERE `ExpireDate` > '".QDateTime::NowToString('YYYY-MM-DD')."'))

				AND (NotActive=0 OR NotActive IS NULL)";

				$objDatabase = MemberContact::GetDatabase();

				$objDbResult = $objDatabase->Query($strQuery);

				$activeMembers = array();

				while ($objDbRow = $objDbResult->FetchArray()) {

					array_push($activeMembers, $objDbRow['Id']);

				}



				// get the number of members have no membership logs assigned (since we will exclude these as well

				$strQuery = "SELECT Id FROM `MemberContact`

				WHERE Id NOT IN (SELECT MemberId FROM MembershipAssoc)

						OR (NotActive=1)";

				$objDatabase = MemberContact::GetDatabase();

				$objDbResult = $objDatabase->Query($strQuery);

				while ($objDbRow = $objDbResult->FetchArray()) {

					array_push($activeMembers, $objDbRow['Id']);

				}





				if ($activeMembers!='') {

					if ($strAndCondition != '') $strAndCondition .= ',';

					$strAndCondition .= "QQ::NotIn(QQN::MemberContact()->Id, \$activeMembers)";

				}



			}

			elseif ($this->strOption == 'expired90'){

				$this->dtgMemberContact->ItemsPerPage = 100;



				$expiredMembersshipId = $this->get90DayExpired();





				// if we have members expired more than 90 days

				if (count($expiredMembersshipId)>0) {

					if ($strAndCondition != '') $strAndCondition .= ',';

					$strAndCondition .= "QQ::In(QQN::MemberContact()->Id, \$expiredMembersshipId)";

				}

				else $strAndCondition = "QQ::None()";



			}

			elseif($this->strOption == 'notActive'){

				// only include not active members

				if ($strAndCondition != '') $strAndCondition .= ',';

				$strAndCondition .= "QQ::Equal(QQN::MemberContact()->NotActive, 1)";

			}

		    elseif($this->strOption == 'showHousehold'){    // query members of a household

		        $strStreetAddress = QApplication::QueryString('strAddy');

				if ($strAndCondition != '') $strAndCondition .= ',';

				$strAndCondition .= "QQ::Equal(QQN::MemberContact()->Addr1, \$strStreetAddress)";

			}

			else {

				// only include active members

				if ($strAndCondition != '') $strAndCondition .= ',';

				$strAndCondition .= "QQ::OrCondition(

						QQ::Equal(QQN::MemberContact()->NotActive, 0),

						QQ::IsNull(QQN::MemberContact()->NotActive)

				)";



				$this->dtgMemberContact->ItemsPerPage = __ITEMS_PER_PAGE__;

			}

			// 			if ($this->dttStart->DateTime != null) {

			// 				if ($strAndCondition != '') $strAndCondition .= ',';

			// 				$strAndCondition .= "QQ::GreaterThan(QQN::MemberContact()->Filemodified, ".$this->dttStart->DateTime->Timestamp.")";

			// 			}



			// 			if ($this->dttEnd->DateTime != null) {

			// 				if ($strAndCondition != '') $strAndCondition .= ',';

			// 				$strAndCondition .= "QQ::LessThan(QQN::MemberContact()->Filemodified, ".$this->dttEnd->DateTime->Timestamp.")";

			// 			}



			if ($strAndCondition != '')

				$strAndCondition = "QQ::AndCondition(".$strAndCondition.")";

			else

				$strAndCondition = "QQ::All()";



			$this->dtgMemberContact->TotalItemCount = MemberContact::QueryCount(eval("return $strAndCondition;"));



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

			$this->dtgMemberContact->DataSource = MemberContact::QueryArray(eval("return $strAndCondition;"), $objClauses);

		}

	}



	// member access

	class acx2MembershipListForm extends acx1MembershipListForm {

		protected function blnReadOnly() {

			$this->blnReadOnly=true;

		}



		protected function txtSearch_Create() {

			$this->txtSearch = new QTextBox($this);

			$this->txtSearch->Width = "100%";

			$this->txtSearch->Name = QApplication::Translate('Member search (by name): ');

			$this->txtSearch->HtmlBefore = " <span class='sm'>(Enter part of a member name you are searching for)</span>";

			$this->txtSearch->AddAction(new QEnterKeyEvent(), new QServerAction('updateGrid'));

			$this->txtSearch->CssClass = 'hghLight';

			$this->txtSearch->AddAction(new QEnterKeyEvent(), new QTerminateAction());

		}



		public function dtgMemberContact_AddressColumn_Render(MemberContact $objMemberContact) {

			//MemberContact::MemberProfileImage($objMemberContact).

			return MemberContact::BasicMemberContactInfoAcx2($objMemberContact,trim($this->txtSearch->Text ?? ''));

		}



		protected function btnAddFamilyMembers($strFormId, $strControlId, $strParameter) {}

		protected function btnSelectFamilyMember($strFormId, $strControlId, $strParameter) {}



		protected function showColumns() {

			$this->dtgMemberContact->SortColumnIndex = 0;

			$this->dtgMemberContact->SortDirection = 1;



			$this->dtgMemberContact->AddColumn($this->colJoinedClub);

			$this->dtgMemberContact->AddColumn($this->colAddr1);

			//$this->dtgMemberContact->AddColumn($this->colTags);

		}



		public function dtgMemberContact_MembershipTags_Render(MemberContact $objMemberContact) {

			$objMemberTagAssocArray = MemberTagAssoc::QueryArray(

					QQ::Equal(QQN::MemberTagAssoc()->MemberId, $objMemberContact->Id),

					QQ::Clause(QQ::OrderBy(QQN::MemberTagAssoc()->TagIdObject->Name)));

			$return = '';

			$isTagged = false;

			if ($objMemberTagAssocArray)foreach ($objMemberTagAssocArray as $objMemberTagAssoc){

				// if the member has been tagged with this already then show remove link

				if ($this->memberTagId && $this->memberTagId == $objMemberTagAssoc->TagId){

					$isTagged = true;

				}

				else

					$return .= '<div class="tag">'.$objMemberTagAssoc->TagIdObject->Name.'</div>';

			}

			return $return;

		}



		protected function memberTagging(){}

	}



	// read-only access

	class acx4MembershipListForm extends acx1MembershipListForm {

		protected function blnReadOnly() {

			$this->blnReadOnly=true;

		}



		public function dtgMemberContact_MembershipTags_Render(MemberContact $objMemberContact) {

			$objMemberTagAssocArray = MemberTagAssoc::QueryArray(

					QQ::Equal(QQN::MemberTagAssoc()->MemberId, $objMemberContact->Id),

					QQ::Clause(QQ::OrderBy(QQN::MemberTagAssoc()->TagIdObject->Name)));

			$return = '';

			$isTagged = false;

			if ($objMemberTagAssocArray)foreach ($objMemberTagAssocArray as $objMemberTagAssoc){

				// if the member has been tagged with this already then show remove link

				if ($this->memberTagId && $this->memberTagId == $objMemberTagAssoc->TagId){

					$isTagged = true;

				}

				else

					$return .= '<div class="tag">'.$objMemberTagAssoc->TagIdObject->Name.'</div>';

			}

			return $return;

		}



		protected function btnAddFamilyMembers($strFormId, $strControlId, $strParameter) {}

		protected function btnSelectFamilyMember($strFormId, $strControlId, $strParameter) {}



		protected function showColumns() {

			$this->dtgMemberContact->SortColumnIndex = 0;

			$this->dtgMemberContact->SortDirection = 1;



			$this->dtgMemberContact->AddColumn($this->colJoinedClub);

			$this->dtgMemberContact->AddColumn($this->colAddr1);

			$this->dtgMemberContact->AddColumn($this->colNote);

		}

		protected function memberTagging(){}

	}

	// go to the centralized form executing access control function to run the form and check access control

	ACL_Run('MembershipList');

?>