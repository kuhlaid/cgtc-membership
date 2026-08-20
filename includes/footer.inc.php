<?php
/**
 * @abstract HMTL footer for the application
 * @author w. Patrick Gale
 *
 * Jan. 14, 2020 - wpg
 * - adding tooltip hover action
 * 
 * March 24, 2017 - wpg
 * - adding family membership association tagging
 *
 */
	// This example footer.inc.php is intended to be modfied for your application.
	QSessionDB::set('error', ' ');

	// print link to view database queries
	// again, replace '1' with whatever database connection you are using
	//QApplication::$Database[1]->OutputProfiling();
	/*
	<div class="m-2">
<img src='<?=__APP_DOMAIN__.__IMAGE_ASSETS__;?>/CgtcLogo300px.png' alt='CGTC Logo' title='CGTC Logo' style='height:3em;' class='img-thumbnail mr-2'/>
</div>
*/
?>


<!-- End the container-fluid -->

</div>
<div class="p-4"></div>




<?php
$intMemberTagId = QSessionDB::get('__MEMBER_TAG_ID__');
$intFamAssocMemId = QSessionDB::get('__FAMILY_ASSOC_PRIMARY_MEMBER_ID__');

// if selecting members for bulk tagging then show the notice
if ($intMemberTagId != '') {
	$varList = 'View tagged members';
	$cssId = 'dmIr_BT';
?>
<div id="<?=$cssId;?>" class="active bld txtalignC"
	style="position: fixed; top: 0px; right: 0px;" >
	<div>Member tagging enabled for</div>
	<div class="fs18">
	<?=QSessionDB::get('__MEMBER_TAG_NAME__');?><br/>
	<a href="MemberTags.php?intTagId=<?=$intMemberTagId?>" title="<?=$varList;?>"><?=$varList;?></a>
	</div>
	<div>
	</div>
</div>
<?php }

	// if selecting members for family membership associations then show the notice
	if ($intFamAssocMemId != '') {
		$cssId = 'dmIr_BT';
		?>
	<div id="<?=$cssId;?>" class="bg-warning border p-4"
		style="position: fixed; top: 0px; right: 0px;" >
		<div><b>Select family members for:</b></div>
		<div class="fs18">
		<?=QSessionDB::get('__PRIMARY_FAMILY_MEMBER_NAME__');?><br/>
		<a href="MembershipList.php?strOption=showFamilyMembers">Show membership list</a> | <a href="MembershipList.php?strOption=closeFamilyMemberSelection">Close family member selection</a>
		</div>
		<div>
		</div>
	</div>
<?php } ?>
	<!-- footer -->
	<div class="d-flex text-white fixed-bottom small" style="background: #b00101;" id="appFooter">
		<div class="p-2"><span data-toggle="tooltip" title="<?=$_ENV['APP_ACCESS_TEXT'];?>" ><a href="<?=__APP_DOMAIN__;?>" target="_blank" class="text-white"><?=$_ENV['VERSION_FULL_TEXT'];?></a></span></div>
	</div>
	<script type="text/javascript">
  WebFontConfig = {
    google: { families: [ 'Inconsolata::latin' ] }
  };
  (function() {
    var wf = document.createElement('script');
    wf.src = ('https:' == document.location.protocol ? 'https' : 'http') +
      '://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js';
    wf.type = 'text/javascript';
    wf.async = 'true';
    var s = document.getElementsByTagName('script')[0];
    s.parentNode.insertBefore(wf, s);
  })(); 
  jQuery(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip({trigger: "hover"}); // auto-load the tooltips and do not keep open with click
  });
  </script>
<style type="text/css" media="print,screen">
.ambig {font-family: 'Inconsolata',verdana;}
</style>
	</body>
</html>