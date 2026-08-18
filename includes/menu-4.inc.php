<?
/**
 * @abstract Main menu for read-only users
 * @author w. Patrick Gale
 */
?>
<a href="<?=__SUBDIRECTORY__;?>/index.php" class="dropdown-item <?=mainMenuSel(__strClub_Home___);?>"><?=__strClub_Home___;?></a>
<a href="<?=__SUBDIRECTORY__;?>/MembershipList.php" class="dropdown-item <?=mainMenuSel(__strClub_MembershipList___);?>"><?=__strClub_MembershipList___;?></a>
<a href="<?=__SUBDIRECTORY__;?>/MembershipLogs.php" class="dropdown-item <?=mainMenuSel(__strClub_MembershipLogs___);?>"><?=__strClub_MembershipLogs___;?></a>