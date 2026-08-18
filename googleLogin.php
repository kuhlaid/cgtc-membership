<?php
/**
 * @abstract Google account login
 * @author w. Patrick Gale
 *
 * Jan. 1, 2018 - wpg
 * - adding tracking of the type of login a member uses to access the application
 *
 * April 19, 2017 - wpg
 * - setting up production API connection ($_ENV['GOOGLE_API_CREATE'])
 *
 * April 2, 2017 - wpg
 * - setting up basic authentication using Google
 */
require('includes/prepend.inc.php');
// Backdoor testing of other member
// if (QApplication::QueryString('bdop')=='FfLWr51xnajQvgUDYhfB') {
// 	MemberContact::SetMemberLoginAccess('[some email address]',1);
// 	exit;
// }
// Google auth
// https://developers.google.com/accounts/docs/OAuth2Login

// PHP API
// https://code.google.com/p/google-api-php-client/wiki/OAuth2
// https://developers.google.com/identity/protocols/OpenIDConnect

// start Google code
require_once 'google-api-php-client/src/Google_Client.php';
require_once 'google-api-php-client/src/contrib/Google_Oauth2Service.php';
$client = new Google_Client();
$client->setApplicationName("Google Login");
//$client->setScopes("https://www.googleapis.com/auth/userinfo.email");   // adde d Sept. 29, 2018 to try and correct issue with scope
// Visit https://code.google.com/apis/console?api=plus to generate your
// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
$client->setClientId(__GOOGLELOGIN_ClientId__);
$client->setClientSecret(__GOOGLELOGIN_ClientSecret__);
$client->setRedirectUri(__GOOGLELOGIN_RedirectUri__);
//$client->setDeveloperKey('insert_your_developer_key');
$oauth2 = new Google_Oauth2Service($client);

if (isset($_GET['code'])) {
	$client->authenticate($_GET['code']);
	$_SESSION['token'] = $client->getAccessToken();
	$redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
	header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
	return;
}

if (isset($_SESSION['token'])) {
	$client->setAccessToken($_SESSION['token']);
}

if (isset($_REQUEST['logout'])) {
	unset($_SESSION['token']);
	$client->revokeToken();
}

// if access allowed then...
if ($client->getAccessToken()) {
	$user = $oauth2->userinfo->get();
	// The access token may have been updated lazily.
	$_SESSION['token'] = $client->getAccessToken();
} else {
	$authUrl = $client->createAuthUrl();
	QApplication::Redirect($authUrl);
	exit;
}
MemberContact::SetMemberLoginAccess($user['email'],1);
exit;
?>