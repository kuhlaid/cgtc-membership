<?php
if (!defined('__PREPEND_INCLUDED__')) exit;
/*
 * @abstract This provides read-only access for the newsletter editor to access member emails.
 * -----------
 * Executes the requested script after being checked for access. Moved access to one file so
* we can easily see what a type of user can access.  This provides access for the newsletter editor users.
* @author w. Patrick Gale - March 2017
*/
// ---- CGTC application access ---------


// added April 14, 2017 - wpg
if (__ACCESSED_CONTROLLED_SCRIPT__=='CurrentMemberEmails')
	acx3CurrentMemberEmailsListForm::Run('acx3CurrentMemberEmailsListForm', 'template/CurrentMemberEmails.tpl.php');

// added May 2, 2017 - wpg
elseif (__ACCESSED_CONTROLLED_SCRIPT__=='MembershipCorner')
	acx3MembershipCornerForm::Run('acx3MembershipCornerForm', 'template/MembershipCorner.tpl.php');
else {
	print 'no access';
	exit;
}
?>