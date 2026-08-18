<?
/**
 * @abstract Main menu for read-only users
 * @author w. Patrick Gale
 */
?>
<a href="<?=__SUBDIRECTORY__;?>/index.php" class="dropdown-item <?=mainMenuSel(__strCGTC_Home___);?>"><?=__strCGTC_Home___;?></a>
<a href="<?=__SUBDIRECTORY__;?>/MembershipList.php" class="dropdown-item <?=mainMenuSel(__strCGTC_MembershipList___);?>"><?=__strCGTC_MembershipList___;?></a>
<a href="<?=__SUBDIRECTORY__;?>/MembershipLogs.php" class="dropdown-item <?=mainMenuSel(__strCGTC_MembershipLogs___);?>"><?=__strCGTC_MembershipLogs___;?></a>