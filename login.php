<?php
/**
 * @abstract Moved the login to a separate script from index.php since sessions failing on the index (root)
 * would not trigger a session disposal and cause issues for some loggin in through Facebook for example.
 * 
 * April 22, 2020 - wpg
 * - moving the login out of the main index.php script
 */
// Include prepend.inc to load Qcodo
require('includes/prepend.inc.php');
define('__SEL_MENU__',__strClub_Home___);
$joinUrl=$_ENV['JOIN_URL'];
require(__INCLUDES__ . '/header.inc.php');
// read-only login under readonly_login.php?id=7oP1587heEAJn36762lKw1R294A4n3GBcu58Ao2845MFY4q
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
					<!-- Adding version 6 Facebook login button -->
					<div id="fb-root"></div>
					<script async defer crossorigin="anonymous" src="connect.facebook.net/en_US/sdk.js#xfbml=1&version=v6.0&appId=<?=FACEBOOK_APP_ID;?>"></script>

					If you have a Facebook account then <br/>
					<!-- <div class="font-weight-bold">you are out of luck at the moment as this login option is disabled until FB provides access again :(</div> -->
					<div class="fb-login-button" data-size="large" data-button-type="continue_with" data-layout="default" data-auto-logout-link="false" data-use-continue-as="true" data-width="" data-scope="email" scope="public_profile,email" onlogin="checkLoginState();"></div>

					<script>
						window.fbAsyncInit = function() {
							FB.init({
								appId      : '<?=__FBLOGIN_AppId__;?>',
								cookie     : true,
								xfbml      : true,
								version    : 'v9.0'
							});
								
							FB.AppEvents.logPageView();   
							
							// this is simply called on page load
							// FB.getLoginStatus(function(response) {
							// 	if (response.status === 'connected') {
							// 		console.log('facebook login');
							// 		console.log(response.authResponse.accessToken);
							// 	}
							// });
						};


						function checkLoginState() {
							console.log('checkLoginState');
							// this is called when the user wishes to login using Facebook
							FB.getLoginStatus(function(response) {
								if (response.status === 'connected') {
									if (response.authResponse.accessToken) {
										// we get the accessToken and send to the Facebook login
										console.log(response.authResponse.accessToken);
										// $.post( "facebookLogin.php", { fbToken: response.authResponse.accessToken }).done(function( data ) {
										// alert( "Data Loaded: " + data );
										// });
										// $.ajax({url: "facebookLogin.php?fbToken="+response.authResponse.accessToken).done(function( data ) {
										// alert( "Data Loaded: " + data );
										// });

										$.ajax({
											type: "GET",
											url: "<?=__APP_URL__;?>/facebookLogin.php",
											data: {"fbToken":response.authResponse.accessToken},
											async: false
										}).done(function( data ) {
											if (data=='loggedIn'){
												// redirect to main
												window.location.replace('<?=__APP_DOMAIN__.__SUBDIRECTORY__;?>');
											}
										});
									}
								}
							});
						}

						(function(d, s, id){
							var js, fjs = d.getElementsByTagName(s)[0];
							if (d.getElementById(id)) {return;}
							js = d.createElement(s); js.id = id;
							js.src = "https://connect.facebook.net/en_US/sdk.js";
							fjs.parentNode.insertBefore(js, fjs);
						}(document, 'script', 'facebook-jssdk'));
					</script>
					<script>
					

						// FB.getLoginStatus(function(response) {
						// 	statusChangeCallback(response);
						// });

						// function checkLoginState() {
						// 	FB.getLoginStatus(function(response) {
						// 		statusChangeCallback(response);
						// 	});
						// }

					</script>
					<!-- <a href="facebookLogin.php" class="bld">click here to login using a
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
		and access other member-only resources online. The <a href="#ToS">Terms of Service</a> and <a href="#PP">Privacy Policy</a> can be found below.
				</div>
			</div>
			<div class="card m-2">
				<div class=" card-header"><a href="<?=$joinUrl;?>" class="h4">Join the club</a></div>
				<div class="card-body">
					If you would like to become a member <a href="<?=$joinUrl;?>" class="bld">click here to fill out this form</a>.
				</div>
			</div>
			<div class="card m-2">
				<div class=" card-header h4" id="ToS">Terms of Service</div>
				<div class="card-body">
					<div class="p-2">
						This app was created for club members by club members. No club funds were used to design and build this app. Any app updates are 
						performed by non-paid volunteers. With that said, sometimes things will break (like social logins), but we try to get these things
						resolved as soon as possible. Also functionality may change from time to time, but hopefully it is for the better. We only 
						use the social login or other login functions to verify you are a club member, so your logins will not give us access to 
						your Facebook or Google accounts.
					</div>
				</div>
			</div>
			<div class="card m-2">
				<div class=" card-header h4" id="PP">Privacy Policy</div>
				<div class="card-body">
				We do not collect any additional information from social logins or other membership app logins, so what you provided us when you
				registered with the club is what we have. 
				</div>
			</div>
		</div>
	</div>
	</div></div></div>


<?php require(__INCLUDES__ . '/footer.inc.php'); ?>
