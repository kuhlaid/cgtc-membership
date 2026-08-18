<?
/**
 * @abstract Main menu for member only
 * @author w. Patrick Gale
 *
 * Jan. 20, 2020 - wpg
 * - adding races
 * 
 * Nov. 15, 2018 - wpg
 * - adding member access
 * 
 * Jan. 4, 2018 - wpg
 * - disable some functions if the member has an expired membership
 *
 * Dec. 31, 2017 - wpg
 * - adding link to membership list
 *
 * July 16, 2017 - wpg
 * - adding club discounts view
 */
?>

    <a href="<?=__SUBDIRECTORY__;?>/index.php" class="dropdown-item <?=mainMenuSel(__strClub_Home___);?>"><?=__strClub_Home___;?></a>
    <a href="<?=__SUBDIRECTORY__;?>/MembershipLogs.php" class="dropdown-item <?=mainMenuSel(__strClub_MembershipLogs___);?>"><?=__strClub_MembershipLogs___;?></a>
    <a href="<?=__SUBDIRECTORY__;?>/MemberMileageLogs.php" class="dropdown-item <?=mainMenuSel(__strClub_MemberMileageLogs___);?>"><?=__strClub_MemberMileageLogs___;?></a>
    <a href="<?=__SUBDIRECTORY__;?>/Races.php" class="dropdown-item <?=mainMenuSel(__strClub_Races___);?>"><?=__strClub_Races___;?></a>
    <a href="<?=__SUBDIRECTORY__;?>/currentClubDiscounts.php?option=showMenu" class="dropdown-item <?=mainMenuSel(__strClub_CurrentClubDiscounts___);?>"><?=__strClub_CurrentClubDiscounts___;?></a>
    <?php
    // only show these options if the membership is not expired
    if (!QSessionDB::get(__SESSION_PREFIX__.'__MEMBERSHIP_EXPIRED__')) {
    ?>
    <a href="<?=__SUBDIRECTORY__;?>/MembershipList.php" class="dropdown-item <?=mainMenuSel(__strClub_MembershipList___);?>"><?=__strClub_MembershipList___;?></a>
    <?php
    /*<a href="<?=__SUBDIRECTORY__;?>/Tags.php" class="dropdown-item <?=mainMenuSel(__strClub_TAGS___);?>"><?=__strClub_TAGS___;?></a>
    */
    ?>
    <?php }?>
