<?php
/**
 *
 * Nov. 7, 2019 - wpg
 * - embedding the discussion group emails 
 * 
 * Jan. 8, 2018 - wpg
 * - adding membership renewal options
 *
 * Jan. 4, 2018 - wpg
 * - changing the view/edit profile link to only show for those with member access
 *
 * Jan. 1, 2018 - wpg
 * - adding membership information
 *
 * Dec. 31, 2017 - wpg
 * - adding Facebook feed
 *
 * Dec. 30, 2017 - wpg
 * - adding Google events calendar
 *
 * June 13, 2017 - wpg
 * - separating member and non-member sections for login (club signup)
 */

// Include prepend.inc to load Qcodo
require('includes/prepend.inc.php');

print "Env var: ".$_ENV['TEST_ENV_VAR'];
exit;

define('__SEL_MENU__',__strCGTC_Home___);
$joinUrl=$_ENV['JOIN_URL'];
require(__INCLUDES__ . '/header.inc.php');

function clearRenewalSession(){
	QSessionDB::Delete(__SESSION_PREFIX__.'__txtLogType__');
	QSessionDB::Delete(__SESSION_PREFIX__.'__txtPaymentType__');
	QSessionDB::Delete(__SESSION_PREFIX__.'__START_MEMBER_RENEWAL__');
	QSessionDB::Delete(__SESSION_PREFIX__.'__memberRenewal_contactCheck__');
	QSessionDB::Delete(__SESSION_PREFIX__.'__calMembershipConsent__');
	QSessionDB::Delete(__SESSION_PREFIX__.'__txtConsentSignature__');
	QSessionDB::Delete(__SESSION_PREFIX__.'__memberRenewal_waiverSigned__');
}
// cancel the membership renewal process
if (QApplication::QueryString('strOption')=='cancelMemberRenewal') {
	clearRenewalSession();
	QSessionDB::set('error',"Membership renewal canceled");
	QApplication::Redirect('index.php');
	exit;
}
// membership renewal process complete
if (QApplication::QueryString('strOption')=='PaymentReceived') {
	clearRenewalSession();
	QSessionDB::set('error',"Thank you, your membership renewal is complete!");
	QApplication::Redirect('index.php');
	exit;
}
function showChangeLog(){
	print $_ENV['CHANGELOG_INFO'];
}

// if the user has logged in
		if (MemberContact::LoggedIn()) {
			$objMembershipAssoc = MembershipAssoc::GetLatestMembershipForMember(QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__'));
			$objMemberContact = MemberContact::LoadById(QSessionDB::get(__SESSION_PREFIX__.'__MEMBER_ID__'));
			$strMembershipLog = MembershipAssoc::MembershipExpireEmailString($objMembershipAssoc);

			$strOtherFamilyMembers = MembershipAssoc::MembersOfMembership($objMembershipAssoc->MembershipLogId,false,false).
			BusinessMemberAssoc::MemberBusinessRepresenting($objMemberContact->Id);

// if membership login
// MemberContact::MemberProfileImage($objMemberContact).
if(checkAccess(2)) {

MemberContact::checkExpiredMembership();

// membership info
?>
<div class="row">
  <div class="col-lg-4">
	<div class="card m-2">
		<div class=" card-header">My Contact Information</div>
			<div class="card-body">
				<div class="card-text"><?=MemberContact::BasicMemberContactInfo($objMemberContact);?></div>
				<a href='MemberContact.php' class='btn btn-primary'><?=__PERSON_ICON__;?> View/Edit</a>
			</div>
		</div>
	</div>
	<div class="col-lg-8">
		<div class="card m-2">
		<div class=" card-header">My Membership</div>
			<div class="card-body">
				<div class="card-text">
					<div class='h3 text-bold'><?=$strMembershipLog;?></div>
					<div>This membership applies to the following members:
					<div class="h3"><?=$strOtherFamilyMembers;?></div>
					</div>
					<div>
					<a href='<?=$_ENV['MEMBERSHIP_PAYMENT_URL'];?>' class='btn btn-primary' target='_blank' title='Renew or extend your membership'><?=$_ENV['RENEWAL_TEXT'];?></a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
		
<div class="row">
  <div class="col-lg-6">
	<div class="card m-2">
		<div class=" card-header">Event Calendar</div>
			<div class="card-body">
			<div class="embed-responsive embed-responsive-1by1">
	<iframe src="<?=$_ENV['GOOGLE_CALENDAR_EMBED'];?>" scrolling="yes"></iframe>
</div>
			</div>
		</div>
	</div>
	<div class="col-lg-6">
	<div class="embed-responsive embed-responsive-1by1">
					<iframe src="<?=$_ENV['FACEBOOK_EMBED_URL'];?>"  scrolling="yes"></iframe>
					</div>
	</div>
</div>


<div class="embed-responsive embed-responsive-4by3">
	<iframe id="forum_embed"
  src="javascript:void(0)"
  scrolling="yes"
  >
</iframe>
<script type="text/javascript">
  document.getElementById('forum_embed').src =
     '<?=$_ENV['GOOGLE_GROUP_EMBED'];?>'
     + '&showsearch=true&showpopout=true&showtabs=false'
     + '&parenturl=' + encodeURIComponent(window.location.href);
</script>
</div>
			<?php print showChangeLog();
		//}
}
else {
	print "<h2>You are logged in as a ".MemberAclAssn::$accessArray[MemberAclAssn::getCurrentAccessType()]." user</h2>";
	showChangeLog();
}
} else {
	QSessionDB::DeleteAll();	// make sure the clear the sessions
	QApplication::Redirect('login.php');
	exit;
	?>

<div class="container">
  <div class="row">
    <div class="col-sm">

		<div class="card m-2">
			<div class=" card-header h4">Member login</div>
			<div class="card-body">
						
				<div class="text-center p-2">
				If you have a Google/Gmail account then <br/><a href="googleLogin.php" class="bld">click here to login using a
					Google account<br/>
					<img src='<?=__APP_DOMAIN__.__IMAGE_ASSETS__;?>/goo_login.png' height="46px" alt='Google login Logo' title='Google login Logo'/></a>
			
				</div>
				<div class="text-center p-2">
					Sorry, the Facebook login is broken.
				</div>
				<?php
				/*
				<div class="text-center p-2">
					Sorry, the Facebook login is broken.
					<!-- If you have a Facebook account then <br/><a href="facebookLogin.php" class="bld">click here to login using a
						Facebook account<br/>
						<img src='<?=__APP_DOMAIN__.__IMAGE_ASSETS__;?>/fb_login.png' height="46px" alt='Facebook login Logo' title='Facebook login Logo'/></a> -->
				</div>
				*/
				?>
			
				<div class="text-center p-2">
					...or to simply have your login emailed to you<br/>
					<a href="MemberLogin.php" class="bld">click here to fill out this form<br/><img src='<?=__APP_DOMAIN__.__IMAGE_ASSETS__;?>/email.jpg' height="46px" alt='Email login image' title='Email login image'/></a>
				</div>
			</div>
		</div>
	</div>

	<div class="col-sm">
		<div>
			<div class="card m-2">
				<div class=" card-header h4">About this App</div>
				<div class="card-body">
				Welcome club members. Log into this Web App to view your membership account information, log miles for the 1,001 mile challenge,
		and access other member-only resources online.
				</div>
			</div>
			<div class="card m-2">
				<div class=" card-header"><a href="<?=$joinUrl;?>" class="h4">Join the club</a></div>
				<div class="card-body">
					If you would like to become a member <a href="<?=$joinUrl;?>" class="bld">click here to fill out this form</a>.
				</div>
			</div>
		</div>
	</div>
	</div></div></div>




	<?php } ?>

<?php require(__INCLUDES__ . '/footer.inc.php'); ?>
