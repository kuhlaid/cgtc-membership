<?php
/**
 * @abstract Main header HTML builder.
 *
 * Jan. 8, 2018 - wpg
 * - adding membership renewal options
 *
 */
define('__APPLICATION_NAME__', $_ENV['APPLICATION_TITLE']);

// finds out if a page is selected or not
function mainMenuSel($page) {
	// if the selected page matches the menu item then highlight it
	if (defined('__SEL_MENU__') && $page == __SEL_MENU__) return 'active';
}

// it is assumed this will be added to the pages one way or another
$_glblWrapper = '
<div class="container-fluid">
<div class="row flex-xl-nowrap">
<!-- begin content -->';
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php _p(QApplication::$EncodingType); ?>" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?=__APPLICATION_NAME__;?>
		<?php if (isset($strPageTitle)) { ?>
				- <?=$strPageTitle; ?>
		<?php } ?>
		</title>
		 <!-- bootstrap 4 -->
		<link rel="stylesheet" href="<?php _p(__CSS_ASSETS__); ?>/bootstrap.min.css">
		<script src="<?php _p(__JAVASCRIPT_ASSETS__); ?>/jquery.min.js"></script>
		<script src="<?php _p(__JAVASCRIPT_ASSETS__); ?>/popper.min.js"></script>
		<script src="<?php _p(__JAVASCRIPT_ASSETS__); ?>/bootstrap.min.js"></script> 
		<?php /* open iconic */ ?>
		<link  rel="stylesheet" href="<?=__SUBDIRECTORY__;?>/open-iconic/font/css/open-iconic-bootstrap.css">
		<link rel="stylesheet" type="text/css" media="screen, projection" href="<?php _p(__CSS_ASSETS__); ?>/style.css?v=<?=__VERSION_Num__;?>"/>
		<?php /* material design components
		<link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
		  <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
		 */ ?>
<?php /*
		<link rel="stylesheet" type="text/css" media="screen, projection" href="<?php _p(__CSS_ASSETS__); ?>/style.css?v=<?=__VERSION_Num__;?>"/>
		<link rel="stylesheet" type="text/css" media="print" href="<?php _p(__CSS_ASSETS__); ?>/print.css?v=<?=__VERSION_Num__;?>" />
		*/ ?>
		<link rel="stylesheet" type="text/css" media="screen, projection" href="<?php _p(__QCSS_ASSETS__); ?>/jquery.autocomplete.css?v=<?=__VERSION_Num__;?>" />
		<style>
		.popover {
			position:absolute;
			top:0px !important;
			max-width: none; /* // we can use this to disable wrapping but we must include the data-container="body" data-toggle="popover" data-placement="left" attributes */
		}
		.modal{
			z-index:1070 !important; /* we set this higher than default so the popover box will show below the modal window */
		}
	</style>
		<link rel="icon" type="image/ico" href="/favicon.ico" />

	</head>
	<body><a id="anchorTop" class="anchor"></a>
	<?php // --- navigation ?>
	<nav class="navbar navbar-expand-lg navbar-light bg-light d-flex">
		<div class="flex-grow-1">
			<?php // only show menu if logged in 
			if (MemberContact::LoggedIn()) { ?>
		<div class="btn-group">
				<a class="btn btn-primary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				<span class="oi oi-list"></span> Menu Options
				</a>
				<div class="dropdown-menu border border-dark rounded">
<?php
					// if user logged in then show menu items
if (MemberContact::LoggedIn()) {

	// hide the menu if this constant is defined
	if (!defined('__HIDE_MENU__')) {?>
		<?php
		require(__INCLUDES__ . '/menu-'.MemberAclAssn::getCurrentAccessType().'.inc.php');
							print '<div class="dropdown-divider"></div><h4 class="dropdown-header">App access:</h4>';
		require(__INCLUDES__ . '/acx-menu.inc.php');
		?>

	<?php
	}
}?>
					<a href="<?=__SUBDIRECTORY__;?>/logout.php" class="dropdown-item" title="Sign out of the membership app"><span class="oi oi-circle-x"></span> Logout</a>
				</div>
			</div>
			<?php } ?>
		</div>
		<div class="h5 justify-content-end p-1"><img src='<?=__APP_DOMAIN__.__IMAGE_ASSETS__;?>/CgtcLogo300px.png' alt='CGTC Logo' title='CGTC Logo' style='height:3em;' class='img-thumbnail mr-2'/><?=__APPLICATION_NAME__;?></div>
	</nav>
	<div class="container-fluid">
	<?php // if (trim(QSessionDB::get('error') ?? '') != '') {?>
		<h1 class="alert alert-warning"><?=QSessionDB::get('error');?></h1>
	<?php //} ?>
	<?php if (QSessionDB::get(__SESSION_PREFIX__.'__START_MEMBER_RENEWAL__')) {?>
		<div style="font: 14px 'Helvetica','Sans-Serif';border:1px dashed #000;background-color:#fcfdff;padding:20px;margin-bottom:20px;">
		<a href="index.php?strOption=cancelMemberRenewal" class="fltR" title="Cancel renewal"><img src="<?=__IMAGE_ASSETS__;?>/closebox.png" border="0"></a>
		<div><span class="fs18">Membership Renewal Process</span> (for questions or comments contact <b><?=$_ENV['EMAIL_MEMBERSHIP'];?>)</b></div><hr/>
		<?php
		$objMembershipAssoc = MembershipAssoc::GetLatestMembershipForMember(QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__'));	// get the latest membership
		$__txtLogType__ = QSessionDB::get(__SESSION_PREFIX__.'__txtLogType__');
		$__memberRenewal_contactCheck__ = QSessionDB::get(__SESSION_PREFIX__.'__memberRenewal_contactCheck__');
		$__memberRenewal_waiverSigned__ = QSessionDB::get(__SESSION_PREFIX__.'__memberRenewal_waiverSigned__');
		if ($__txtLogType__ != '') $__txtLogType__ = ": ".MembershipLog::showMembershipType($__txtLogType__)." via ".MembershipLog::$paymentTypeArray[QSessionDB::get(__SESSION_PREFIX__.'__txtPaymentType__')]." valid unti ".$objMembershipAssoc->MembershipLogIdObject->ExpireDate->AddYears(5)->toString();?>
		<a href="Membership.php?strOption=renewalType" title='Select a membership renewal type' class="pd10"><div>1. Select a membership renewal type<span class="bld fs18"><?=$__txtLogType__;?></span> <?php if ($__txtLogType__!='') print __CHECK_ICON__;?></div></a>
		<br/>
		<?php if ($__txtLogType__ != '') { ?>
			<a href="MemberContact.php?strOption=contactCheck" title='Verify member contact information'><div>2. Verify member contact information <?php if ($__memberRenewal_contactCheck__!='') print __CHECK_ICON__;?></div></a>
		<br/>
			<?php if ($__memberRenewal_contactCheck__!='') {?>
				<a href="MembershipWaiver.php?strOption=memberRenewal" title='Confirm and sign waiver'><div>3. Confirm and sign waiver <?php if ($__memberRenewal_waiverSigned__!='') print __CHECK_ICON__;?></div></a>
		<br/>
				<?php if ($__memberRenewal_waiverSigned__!='') {?>
					<a href="MembershipSubmitPayment.php" title='Submit payment'><div>4. Submit payment</div></a>
				<?php } ?>
			<?php } ?>
		<?php } ?>
		</div>
	<?php } ?>