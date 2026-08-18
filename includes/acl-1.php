<?php
if (!defined('__PREPEND_INCLUDED__')) exit;
/*
 * @abstract This provides access for member admin.
 * -----------
 * Executes the requested script after being checked for access. Moved access to one file so
*  we can easily see what a type of user can access.
*  @author w. Patrick Gale - March 2017
*
 * April 19, 2017 - wpg
 * - setup access control
*/
// ---- CGTC application access ---------
if (__ACCESSED_CONTROLLED_SCRIPT__=='MembershipList')
	acx1MembershipListForm::Run('acx1MembershipListForm', 'template/MembershipList.tpl.php');

// added March 18, 2017 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='MembershipLogs')
	acx1MembershipLogListForm::Run('acx1MembershipLogListForm', 'template/membership_log_list.tpl.php');

// added March 18, 2017 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='Membership')
	acx1MembershipLogEditForm::Run('acx1MembershipLogEditForm', 'template/membership_log_edit.tpl.php');

// added March 19, 2017 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='MemberContact')
	acx1MemberContactEditForm::Run('acx1MemberContactEditForm', 'template/member_contact_edit.tpl.php');

// added March 21, 2017 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='Tags')
	acx1TagListForm::Run('acx1TagListForm', 'template/tag_list.tpl.php');
// added March 21, 2017 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='Tag')
	acx1TagEditForm::Run('acx1TagEditForm', 'template/tag_edit.tpl.php');
// added March 21, 2017 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='MemberTags')
	acx1MemberTagAssocListForm::Run('acx1MemberTagAssocListForm', 'template/member_tag_assoc_list.tpl.php');
// added Jan. 31, 2026 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='CurrentMemberAges')
	acx1CurrentMemberAgeListForm::Run('acx1CurrentMemberAgeListForm', 'template/CurrentMemberAges.tpl.php');
// added April 14, 2017 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='CurrentMemberEmails')
	acx1CurrentMemberEmailsListForm::Run('acx1CurrentMemberEmailsListForm', 'template/CurrentMemberEmails.tpl.php');
// added April 23, 2017 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='NotificationLogs')
	acx1NotificationLogListForm::Run('acx1NotificationLogListForm', 'template/notification_log_list.tpl.php');
// added April 23, 2017 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='NotificationLog')
	acx1NotificationLogEditForm::Run('acx1NotificationLogEditForm', 'template/notification_log_edit.tpl.php');
// added April 23, 2017 - wpg
// elseif (__ACCESSED_CONTROLLED_SCRIPT__=='EmailNotification')
// 	acx1EmailReport::Run('acx1EmailReport', 'template/email_report.tpl.php');

elseif (__ACCESSED_CONTROLLED_SCRIPT__=='CurrentMemberEmails')
	acx1CurrentMemberEmailsListForm::Run('acx1CurrentMemberEmailsListForm', 'template/CurrentMemberEmails.tpl.php');

// added April 25, 2017 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='MembershipCorner')
	acx1MembershipCornerForm::Run('acx1MembershipCornerForm', 'template/MembershipCorner.tpl.php');

// added April 28, 2017 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='PartnerBusinesses')
	acx1PartnerBusinessListForm::Run('acx1PartnerBusinessListForm', 'template/PartnerBusinesses.tpl.php');
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='PartnerBusiness')
	acx1PartnerBusinessEditForm::Run('acx1PartnerBusinessEditForm', 'template/PartnerBusiness.tpl.php');

// added May 21, 2017 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='Races')
	acx1RaceListForm::Run('acx1RaceListForm', 'template/Races.tpl.php');
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='Race')
	acx1RaceEditForm::Run('acx1RaceEditForm', 'template/Race.tpl.php');
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='RaceResults')
	acx1RaceResultsListForm::Run('acx1RaceResultsListForm', 'template/RaceResults.tpl.php');
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='RaceResult.edit')
	acx1RaceResultsEditForm::Run('acx1RaceResultsEditForm', 'template/RaceResult.tpl.php');
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='RaceResult.view')
	acx1RaceResultsViewForm::Run('acx1RaceResultsViewForm', 'template/RaceResult.tpl.php');

// added May 23, 2017 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='MemberAcls')
	acx1MemberAclAssnListForm::Run('acx1MemberAclAssnListForm', 'template/MemberAcls.tpl.php');
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='MemberAcl')
	acx1MemberAclAssnEditForm::Run('acx1MemberAclAssnEditForm', 'template/MemberAcl.tpl.php');

elseif (__ACCESSED_CONTROLLED_SCRIPT__=='MemberAccessLogs')
	acx1MemberAccessLogs::Run('acx1MemberAccessLogs', 'template/MemberAccessLogs.tpl.php');
// added Dec. 4, 2018
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='ActiveMemberExport')
	acx1ActiveMemberExportListForm::Run('acx1ActiveMemberExportListForm', 'template/ActiveMemberExport.tpl.php');
// added Nov. 22, 2019 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='MemberMileageLogs')
	acx1MemberMileageListForm::Run('acx1MemberMileageListForm', 'template/MemberMileageLogs.tpl.php');
// added Nov. 22, 2019 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='MemberMileageLog')
	acx1MemberMileageEditForm::Run('acx1MemberMileageEditForm', 'template/MemberMileageLog.tpl.php');
else {
	print 'no access';
	exit;
}
?>