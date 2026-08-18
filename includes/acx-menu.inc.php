<?
/**
 * @abstract Access switcher for the user
 * @author w. Patrick Gale
 *
 * April 19, 2017 - wpg
 * - setting up basic selector
 */
// find out the current user access
function accessMenuSel($acx){
	// if the selected page matches the menu item then highlight it
	if ($acx == MemberAclAssn::getCurrentAccessType()) return 'active';
}


$objMemberAclAssnArray = unserialize(QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ACL__') ?? '');
if ($objMemberAclAssnArray) foreach ($objMemberAclAssnArray as $objMemberAclAssn) {?>
<a class="small dropdown-item <?=accessMenuSel($objMemberAclAssn->Acl);?>" href="?acx=<?=$objMemberAclAssn->Acl;?>"><?=MemberAclAssn::$accessArray[$objMemberAclAssn->Acl];?></a>
<?php
}
?>