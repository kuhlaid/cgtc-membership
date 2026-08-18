<?php
require('includes/prepend.inc.php');
QSessionDB::DeleteAll();
/**
 * Deletes:
 * QSessionDB::get(__SESSION_PREFIX__.'__CURRENT_SYSTEM_ACCESS__') // currently set system access
 * QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ACL__') // list of member access rights
 * QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__'); // member ID
 * QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_NAME__'); // member name
 * QSessionDB::get(__SESSION_PREFIX__.'__MEMBERSHIP_EXPIRED__');  // member expiration flag
 */
QSessionDB::set('error', 'You have been logged out.');
header("Location: ".__SUBDIRECTORY__."/login.php");
exit;
?>