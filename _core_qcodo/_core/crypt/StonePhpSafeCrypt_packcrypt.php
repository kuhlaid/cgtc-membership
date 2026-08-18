<?php
/**
 * Jan. 19, 2018 - wpg
 * - converted the mcrypt functions to use openSSL instead
 *
 * @param unknown_type $Data
 * @param unknown_type $key
 * @param unknown_type $options
 * @return string
 */
  define('DEFAULT_ENCRYPTION_METHOD','aes-256-gcm');
  function PackCrypt(&$Data, $key, $iv=null, $options=array() ) {

    return serialize($Data);  // bypassing encryption
    $result = array(
      'success' => false,
      'reason'  => 'Incomplete pack for unknown reason; indicates horrible failure.',
      'output'  => false
    );

    // load options
    if (isset($options['cipher'])) {                                 // Check whether user specified an alternate cipher in the options
      $cipher = $options['cipher'];                              // if so, use it
    } else {
      $cipher = DEFAULT_ENCRYPTION_METHOD;                       // otherwise, use the default cipher
    }

    // do preparation
    $SecretData = serialize($Data);                                  // Convert data into a serialized string for single packing
     // do work

	//if (in_array($cipher, openssl_get_cipher_methods())) {
	    $ivlen = openssl_cipher_iv_length($cipher);
	    $iv = openssl_random_pseudo_bytes($ivlen);
	    $tag = '';
	    $tag_length = 16;
	    //return openssl_encrypt($SecretData, $cipher, $key, $options=0, $iv, $tag);
$ciphertext = openssl_encrypt($SecretData, $cipher, $key, OPENSSL_RAW_DATA, $iv, $tag, "", $tag_length);
return base64_encode($iv.$tag.$ciphertext);
	//}
  }

  function PackCryptIv (){
  	if ($_SESSION["__OPEN_SSL_IV__"]=='') {
  		$cipher = DEFAULT_ENCRYPTION_METHOD;
  		$ivlen = openssl_cipher_iv_length($cipher);
  		$iv = openssl_random_pseudo_bytes($ivlen);
  		$_SESSION["__OPEN_SSL_IV__"] = openssl_random_pseudo_bytes($ivlen);
  	}
  	return $_SESSION["__OPEN_SSL_IV__"];
  }

  function PackCryptKey (){
  	if ($_SESSION["__OPEN_SSL_IV__"]=='') {
  		$cipher = DEFAULT_ENCRYPTION_METHOD;
  		$ivlen = openssl_cipher_iv_length($cipher);
  		$iv = openssl_random_pseudo_bytes($ivlen);
  		$_SESSION["__OPEN_SSL_IV__"] = openssl_random_pseudo_bytes($ivlen);
  	}
  	return $_SESSION["__OPEN_SSL_IV__"];
  }


  function UnpackCrypt(&$SecretData, $key, $options=array() ) {// $cipher = 'tripledes', $mode = 'ofb') {

    return unserialize($SecretData ?? '');  // bypassing encryption
    // load options

    if (isset($options['cipher'])) {                                 // Check whether user specified an alternate cipher in the options
      $cipher = $options['cipher'];                              // if so, use it
    } else {
      $cipher = DEFAULT_ENCRYPTION_METHOD;                       // otherwise, use the default cipher
    }

//error_log($cipher);
   // $ivlen = openssl_cipher_iv_length($cipher);
    //$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
   // 
//    $decrypted = openssl_decrypt($SecretData, $cipher, $key, $options=0, $iv="", $tag="");
$encrypted = base64_decode($SecretData  ?? '');
$iv_len = openssl_cipher_iv_length($cipher);
$iv = substr($encrypted, 0, $iv_len);
$tag_length = 16;
$tag = substr($encrypted, $iv_len, $tag_length);
$ciphertext = substr($encrypted, $iv_len + $tag_length);

return openssl_decrypt($ciphertext, $cipher, $key, OPENSSL_RAW_DATA, $iv, $tag);
exit;
    //(unserialize($decrypted) ?? '');
//error_log('unencrypt');
//error_log(len($SecretData));
//error_log(unserialize($decrypted) ?? '');
    return unserialize($decrypted ?? '');
   	exit;
  }
?>