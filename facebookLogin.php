<?php

/**

 * @abstract Facebook account login

 * @author w. Patrick Gale

 *

 * Oct. 1, 2025 - wpg

 * - was not able to get the email address returned from the Facebook API so dooing away with it

 * 

 * Sept. 16, 2018 - wpg

 * - trying to determine why Facebook API settings are no longer allowing login; updated to using v2.8 of the API but that did not work either

 * 

 * Jan. 1, 2018 - wpg

 * - adding tracking of the type of login a member uses to access the application

 *

 * June 7, 2017 - wpg

 * - adding Facebook authentication constants

 *

 * April 22, 2017 - wpg

 * - getting authentication confirmed

 *

 * April 2, 2017 - wpg

 * - setting up basic authentication using Facebook

 * - creating a Facebook App. using my account (https://developers.facebook.com/apps/<?=FACEBOOK_APP_ID;?>/dashboard/) and

 * adding Facebook login product

 */



require('includes/prepend.inc.php');

// trying to solve login issues (https://stackoverflow.com/questions/32029116/facebook-sdk-returned-an-error-cross-site-request-forgery-validation-failed-th)

// if(!session_id()) {

// 	session_start();

// }

//https://developers.facebook.com/docs/php/gettingstarted

require('facebook-sdk-5.0.0/src/Facebook/autoload.php');



use Facebook\Facebook;

use Facebook\Http\GraphRawResponse;

use Facebook\HttpClients\FacebookHttpClientInterface;



// Custom HTTP client handler implementation

class MyCustomHttpClient implements FacebookHttpClientInterface

{

    public function send($url, $method, $body, array $headers, $timeOut)

    {

        // Implement custom HTTP request logic here, e.g., using Guzzle or cURL

        // This example uses a simplified cURL approach for demonstration

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // curl_setopt($ch, CURLOPT_HTTPHEADER, array_map(function($key, $value) {

        //     return "$key: $value";

        // }, array_keys($headers), $headers));

        // curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);



        $responseBody = curl_exec($ch);

        $statusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);



        return new GraphRawResponse($body, $headers, $statusCode);

    }

}

//https://developers.facebook.com/apps/<?=FACEBOOK_APP_ID;?>/fb-login/

$fb = new Facebook([

		'app_id' => __FBLOGIN_AppId__,

		'app_secret' => __FBLOGIN_AppSecret__,

		'default_graph_version' => __FBLOGIN_DefaultGraphVersion__

		]);



$fbClient = $fb->getClient();

$fbClient->setHttpClientHandler(new MyCustomHttpClient());

$accessToken =	QApplication::QueryString('fbToken');



// $helper = $fb->getRedirectLoginHelper();

// try {

// 	$accessToken = $helper->getAccessToken();

// } catch(Facebook\Exceptions\FacebookResponseException $e) {

// 	// When Graph returns an error

// 	echo 'Graph returned an error: ' . $e->getMessage();

// 	exit;

// } catch(Facebook\Exceptions\FacebookSDKException $e) {

// 	// When validation fails or other local issues

// 	echo 'Facebook SDK returned an error: ' . $e->getMessage();

// 	exit;

// }



// get results of login

if (isset($accessToken)) {

	// Logged in!

	$_SESSION['facebook_access_token'] = (string) $accessToken;



	try {

		// Returns a `Facebook\FacebookResponse` object

		

		$response = $fb->get('https://graph.facebook.com/me?fields=email', $accessToken, null, "2.11");



		// DOES NOT WORK

		// $response = $fb->get('/me?fields=email', $accessToken, null, "2.11");

		// $response = $fb->get('https://graph.facebook.com/me?fields=email', $accessToken)

		// $response = $fb->request("GET", "/me?fields=email&access_token=".$accessToken, [], $accessToken, null, "2.11");

		// $response = $fbClient->send("/me?fields=email&access_token=".$accessToken, "GET", "", [], "");

	} catch(Facebook\Exceptions\FacebookResponseException $e) {

		echo 'Graph returned an error: ' . $e->getMessage();

		exit;

	} catch(Facebook\Exceptions\FacebookSDKException $e) {

		echo 'Facebook SDK returned an error: ' . $e->getMessage();

		exit;

	}

	

	$user = $response->getGraphUser();

	error_log($user->__toString());

	// Now you can redirect to another page and use the

	// access token from $_SESSION['facebook_access_token']

	//print MemberContact::SetMemberLoginAccess($user['email'],2,false);

	exit;

}

print 'blah';

exit;

// else {

// 	$helper = $fb->getRedirectLoginHelper();

// 	$permissions = ['email']; // only ask for the member email address

// 	$authUrl = $helper->getLoginUrl(__FBLOGIN_RedirectUri__, $permissions);



// 	QApplication::Redirect($authUrl);

// 	exit;

// 	//echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';

// }

?>