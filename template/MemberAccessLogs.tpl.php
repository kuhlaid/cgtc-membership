<?php
/**
 * @abstract Basic list of members who have logged into the application.
 * @author w. Patrick Gale
 *
 * July 16, 2017 - wpg
 * - setup basic form
 */
	// kick user away from script if they are not going through the proper channels
	if (!defined('__PREPEND_INCLUDED__')) exit;

	$strPageTitle = __strCGTC_MemberAccessLogs___;
	define('__SEL_MENU__',$strPageTitle);
	require(__INCLUDES__ . '/header.inc.php');
?>

	<?php $this->RenderBegin() ?>
		<div class="title"><?=$strPageTitle; ?></div><br/>

		<?php $this->dtgMemberAccessLog->Render() ?>

	<?php $this->RenderEnd() ?>
	
<?php require(__INCLUDES__ . '/footer.inc.php'); ?>