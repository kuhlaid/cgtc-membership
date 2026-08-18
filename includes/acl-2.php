<?php
if (!defined('__PREPEND_INCLUDED__')) exit;
/*
 * @abstract This provides member-only access.
 * -----------
 * Executes the requested script after being checked for access. Moved access to one file so
* we can easily see what a type of user can access.  This provides access for member-only users.
* @author w. Patrick Gale - March 2017
*/
// ---- CGTC application access ---------

if (!QSessionDB::get(__SESSION_PREFIX__.'__MEMBERSHIP_EXPIRED__')) {
	// added March 19, 2017 - wpg
	if (__ACCESSED_CONTROLLED_SCRIPT__=='MembershipList')
		acx2MembershipListForm::Run('acx2MembershipListForm', 'template/MembershipList.tpl.php');
	// added Dec. 13, 2017 - wpg
	elseif (__ACCESSED_CONTROLLED_SCRIPT__=='Tags')
		acx2TagListForm::Run('acx2TagListForm', 'template/tag_list.tpl.php');
	// added Dec. 13, 2017 - wpg
	elseif (__ACCESSED_CONTROLLED_SCRIPT__=='MemberTags')
		acx2MemberTagAssocListForm::Run('acx2MemberTagAssocListForm', 'template/member_tag_assoc_list.tpl.php');
	// added Jan. 1, 2018 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='MemberContact')
acx2MemberContactEditForm::Run('acx2MemberContactEditForm', 'template/Acx2MemberContact.tpl.php');
// added Jan. 7, 2018 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='Membership')
acx2MembershipLogEditForm::Run('acx2MembershipLogEditForm', 'template/Acx2Membership.tpl.php');
// added Jan. 9, 2018 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='MembershipWaiver')
acx2MembershipLogEditForm::Run('acx2MembershipLogEditForm', 'template/Acx2MembershipWaiver.tpl.php');
// added Jan. 9, 2018 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='MembershipSubmitPayment')
acx2MembershipSubmitPaymentForm::Run('acx2MembershipSubmitPaymentForm', 'template/Acx2MembershipSubmitPayment.tpl.php');
// added March 19, 2017 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='MembershipLogs')
acx2MembershipLogListForm::Run('acx2MembershipLogListForm', 'template/Acx2MembershipLogList.tpl.php');
// added Nov. 22, 2019 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='MemberMileageLogs')
	acx2MemberMileageListForm::Run('acx2MemberMileageListForm', 'template/MemberMileageLogs.tpl.php');
// added Nov. 22, 2019 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='MemberMileageLog')
	acx2MemberMileageEditForm::Run('acx2MemberMileageEditForm', 'template/MemberMileageLog.tpl.php');
// added Jan. 20, 2020 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='Races')
	acx2RaceListForm::Run('acx2RaceListForm', 'template/Races.tpl.php');
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='Race')
	acx2RaceEditForm::Run('acx2RaceEditForm', 'template/Race.tpl.php');
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='RaceResult.edit')
	acx2RaceResultsEditForm::Run('acx2RaceResultsEditForm', 'template/RaceResult.tpl.php');
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='RaceResult.view')
	acx2RaceResultsViewForm::Run('acx2RaceResultsViewForm', 'template/RaceResult.tpl.php');
}

else {
	MemberContact::setUserAccess();
	print 'No access to this resource - '.__ACCESSED_CONTROLLED_SCRIPT__.'. Try refreshing the page if your membership has been updated';
	exit;
}
?>