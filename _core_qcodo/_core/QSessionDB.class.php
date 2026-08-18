<?php
/**
 * Dec. 11, 2018 - wpg
 * - adding $strLastAccessed and $strTimeExpiring to use in application so we know when the session will expire
 * 
 * Jan. 19, 2018 - wpg
 * - updated the code to use open_ssl instead of mcrypt which is deprecated in PHP 7.1
 *
 */
/***************************************************************************
** FILE :  QSession.inc    AUTHOR:  Eric Brigham     Date:  9/3/2006
*
*						   Modified:  Chad Koski   10/20/06  -- minor mods for beta 3
*
*  Description:  The following classes can be used in conjunction with QCodo data objects
*                to store and retrieve session data from the database.  This is good if your site
*                runs on multiple servers.  Everything is transparent to you, menaing that you only have to
*                initialize the QSession class and code normally (ie: using $_SESSION as you normally would
*
*  Instalation:  1.  This class assumes you have a table called sessions of this form
						CREATE TABLE `session` (
						  `id` varchar(40) NOT NULL PRIMARY KEY,
						  `session_data` longtext NOT NULL,
						  `last_access` datetime NOT NULL
						) TYPE=InnoDB;
                     Add the above table to your databasse and code generate to create the Sessions data object.
                 2.  Have prepend.inc include this file (QSession.inc)
*                3.  Find the line in prepend.inc that "has session_start();" and replace it with
                          QSession::SetMaxHours(4); //overrides the default max hours setting of 8 hours
                          QSession::Initialize();
*                4.  Optionally, you can change the max hours for sessions (default is 8) by adding an additional line of
*                                QSession::SetMaxHours(12);
*
*  Example Usage:   QSession::set("foo","bar");
*                   echo QSession::get("foo"); //echos "bar"
*                   $_SESSION["foo"] = "bar";  //yep, this still works fine
*
*	wpg - modified to store sessions in database instead of files; the SQL for the session
*table is below
*
CREATE TABLE  `session` (
  `id` varchar(40) NOT NULL,
  `session_data` longtext NOT NULL,
  `last_access` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
*****************************************************************************/


interface SessionSaveHandlerDB{
/*these methods need to be declared in a class and assigned with the
   php function session_set_save_handler()*/
        public static function _open();
        public static function _close();
        public static function _read($id);
        public static function _write($id, $data);
        public static function _destroy($id);
        public static function _clean($max);
}


global $mySessionInfo,$_myReturn;

/*
function getSessionArray ( $sessionString ) {
	global $mySessionInfo,$_myReturn;
  	if (eval("return isset(\$_SESSION['$sessionString']);")) {
  		$mySessionInfo = '';
  		//unscrambleElements($_SESSION[$sessionString],"\$_SESSION['$sessionString']", "\$_myReturn['$sessionString']");
  		unscrambleElements($_SESSION[$sessionString],"\$_SESSION['$sessionString']", "\$_myReturn");
  		return $mySessionInfo;
  	}
  	else return null;
}

function& unscrambleElements($arrResult, $where, $saveVar){
	global $mySessionInfo,$_myReturn;
	if (is_array($arrResult)) {
		while(list($key,$value)=each($arrResult)){
			if (is_array($value)) {
				unscrambleElements($value, $where."['$key']", $saveVar."['$key']");
			}
			else {
				for ($i=0; $i < count($value);$i++){
					$temp = $where."['$key']";
					$startTemp = $saveVar."['$key']";
					//print $startTemp."<br>";
					eval("return $startTemp = UnpackCrypt($temp, SessionRegisterDB::cryptKey());");
					$mySessionInfo = eval("return \$_myReturn;");
				}
			}
		}
	}
}
*/

/* register class for storing stuff in the $_SESSION global variable*/
class SessionRegisterDB {

		public static function cryptKey(){
			return "!@#334klkdjfo0i9LSDKFJO**SDFs3k";
		}

		public static function getIv() {
			$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
			return mcrypt_create_iv($iv_size, MCRYPT_RAND);
		}

		public static function set ( $strName, $varValue ) {
			if ($varValue != '') {
				if (defined('__DISABLE_PACKCRYPT__'))
					$_SESSION[$strName] = base64_encode($varValue);
				else {
					$_SESSION[$strName] = base64_encode(PackCrypt($varValue, SessionRegisterDB::cryptKey()));
				}
				return false;
			}
		    return true;
		}

		/**
		 * Enter description here...
		 *
		 * @param unknown_type $arrayString
		 * @return unknown
		 */
		public static function setArray ( $arrayString ) {
			// handle setting session arrays
			if (is_array($arrayString)) {
				SessionRegisterDB::get_array_elems($arrayString);
				return false;
			}
		    return true;
		}

		/**
		 * A recursive function to traverse a multi-dimensional array where the dimensions are not known
		 *
		 * @param unknown_type $arrResult
		 * @param unknown_type $where
		 */
		public static function get_array_elems($arrResult, $where="\$_SESSION"){
			while(list($key,$value)=each($arrResult)){
				if (is_array($value))
					SessionRegisterDB::get_array_elems($value, base64_decode($where."['$key']" ?? '') ?? '');
				else {
					for ($i=0; $i<count($value);$i++){
						$temp = $where."['$key']";
						if (defined('__DISABLE_PACKCRYPT__'))
							eval("return $temp = \$value;");
						else {
							eval("return $temp = PackCrypt(\$value, SessionRegisterDB::cryptKey());");
						}
					}
				}
			}
		}


		/**
		 * Enter description here...
		 *
		 * @param unknown_type $arrayString
		 * @return unknown
		 */
//		public static function getSessionArray ( $sessionString ) {
//	      	if (eval("return isset(\$_SESSION['$sessionString']);")) {
//	      		$mySessionInfo = '';
//	      		print_r($_SESSION);
//	      		SessionRegisterDB::unscrambleElements($_SESSION[$sessionString],"\$_SESSION['$sessionString']", "\$_myReturn['$sessionString']", $mySessionInfo);
//	      		return $mySessionInfo;
//	      	}
//	      	else return null;
//		}
//
//		public $mySessionInfo;
//
//
//		public static function& unscrambleElements($arrResult, $where, $saveVar, &$mySessionInfo){
//			for (; ; ) {
//				while(list($key,$value)=each($arrResult)){
//					if (is_array($value)) {
//						//SessionRegisterDB::unscrambleElements($value, $where."['$key']", $saveVar."['$key']", $mySessionInfo);
//						$arrResult = $value;
//						$where = $where."['$key']";
//						$saveVar = $saveVar."['$key']";
//						//$mySessionInfo =& $mySessionInfo;
//					}
//					else {
//						for ($i=0; $i < count($value);$i++){
//							$temp = $where."['$key']";
//							$startTemp = $saveVar."['$key']";
//							print $startTemp."<br>";
//							eval("return $startTemp = UnpackCrypt($temp, SessionRegisterDB::cryptKey());");
//						}
//					}
//				}
//				break;
//			}
//
//			$mySessionInfo = eval("return \$_myReturn;");
//		}


      public static function get ( $strName ) {
      	if (isset($_SESSION[$strName])) {
      		if (defined('__DISABLE_PACKCRYPT__'))
      			return base64_decode($_SESSION[$strName]  ?? '');
      		else {
      			$str = base64_decode($_SESSION[$strName]  ?? '');
      			return UnpackCrypt($str, SessionRegisterDB::cryptKey());
      		}
      	}
      	else return null;
      }

	public static function DeleteAll() {
		$_SESSION = null;
		session_destroy();
        return true;
	}

      public static function Delete( $strName ) {
             if( isset($_SESSION[$strName]) )
                 unset($_SESSION[$strName]);
                 $_SESSION[$strName]=null;
             return true;
      }

      public static function Dump () {
             var_dump($_SESSION);
      }
}

/* SESSION Class for storing sessions in the database */

class QSessionDB extends SessionRegisterDB implements SessionSaveHandlerDB {

      /*instance of Sessions object that will hold the current session*/
      public static $objSession_data;
      // wpg - added so we can check when the session will expire
      public static $strLastAccessed;
      public static $strTimeExpiring;

      /*number of hours that the session is valid for*/
      private static $max_hours = 8;

      //run this to start the session
      public static function Initialize() {
        // if (defined('__COOKIE_DOMAIN_HOST__')) $domainHost = __COOKIE_DOMAIN_HOST__;
        // else $domainHost = $_SERVER['HTTP_HOST'];
        // print $domainHost;exit;
      	// wpg - commented out the following lines to keep the sessions from saving to the database since we are encrypting them and not sure how well the code does at cleaning up old sessions in the table
      	// uncomment the following code to have sessions saved to the database instead
             session_set_save_handler(array("QSessionDB","_open"),
                                      array("QSessionDB","_close"),
                                      array("QSessionDB","_read"),
                                      array("QSessionDB","_write"),
                                      array("QSessionDB","_destroy"),
                                      array("QSessionDB","_clean"));
             register_shutdown_function("session_write_close");

            // *** begin cookie settings - the following is important for setting the headers for Chrome and other browsers expecting cooke samesite settings
            $secure = true; // if you only want to receive the cookie over HTTPS
            $httponly = true; // prevent JavaScript access to session cookie
            $samesite = 'Secure';
            $maxlifetime = 28800;

            // // should probably skip these statements if running locally
            if(PHP_VERSION_ID < 70300) {
                session_set_cookie_params($maxlifetime, '/; samesite='.$samesite, $_SERVER['HTTP_HOST'], $secure, $httponly);
            } else {
                session_set_cookie_params([
                    'lifetime' => $maxlifetime,
                    'path' => '/',
                    'domain' => $_SERVER['HTTP_HOST'],
                    'secure' => $secure,
                    'httponly' => $httponly,
                    'samesite' => $samesite
                ]);
            }
            // **** end cookie settings

             session_start();
             return true;
      }

      public static function SetMaxHours( $hours = 8 ) {
             self::$max_hours = $hours;
             return true;
      }

      /*db session functions*/
      public static function _open () {
             return true;
      }

      public static function _close() {
             return true;
      }
        /**
        * Reads data from the data source
        * @access public
        * @static
        * @returns string
        */
        public static function _read($id){
            
        	// wpg - you must have the 'session' table built and the generated Session class for this code to work
                self::$objSession_data = Session::Load($id);
                if( self::$objSession_data == null ) {
                    /*must be a new session*/
                    self::$objSession_data = new Session();
                    self::$objSession_data->Id = $id;
                    return ''; /*return empty string if there is no session*/
                 } else {
                    /*must be an existing session*/
                    /*if session is too old, then delete session data, otherwise return it*/
                    //$sessTime = new QDateTime(self::$objSession_data->LastAccess);
                    $sessTime = self::$objSession_data->LastAccess;
                    self::$strLastAccessed = new QDateTime(QDateTime::Now); // we want to 'reset the clock' before the session expires so we can track this in our application (wpg - added Dec. 11, 2018 
                    self::$strTimeExpiring = (time() - self::$max_hours*3600); // we need to get the expiration time for the session so we can alert application users the session is about to expire (wpg - added Dec. 11, 2018 
                    //error_log( self::$strTimeExpiring);
                    if( $sessTime->Timestamp < (time() - self::$max_hours*3600) ) {
                        /*session is too old*/
                        self::$objSession_data->SessionData = '';
	                    self::$objSession_data->LastAccess = new QDateTime(QDateTime::Now);
                        self::$objSession_data->Save();
                        return ''; /*essentially restarts the session, but keeps the session id*/
                    } else {
                        return self::$objSession_data->SessionData;
                    }
                 }
        }

        /**
        * Writes serialized data to data source
        * @access public
        * @static
        * @returns bool
        */
        public static function _write($id, $data){
               if( $id != self::$objSession_data->Id ) {
                   /*maybe we hijacked a session somehow?*/
                   return false;
               } else {
                   // do not try to save empty session data since data is required in the data field
                   if ($data!='') {
                    self::$objSession_data->SessionData = $data;
                    self::$objSession_data->LastAccess = new QDateTime(QDateTime::Now);
                    self::$objSession_data->Save();
                   }
                   //self::DeleteAll(); /*we do this in case we are on multiple servers and we dont want to confuse anyone*/
                   return true;
              }
        }

        /**
        * Delete session data associated with this id
        * @access public
        * @static
        * @returns bool
        */
        public static function _destroy($id){

               if(self::$objSession_data && $id != self::$objSession_data->Id ) {
                   /*maybe we hijacked a session somehow?*/
                   return false;
               } elseif (self::$objSession_data) {
                   self::$objSession_data->Delete();
                   return true;
               }
        }

        /**
        * Delete old session data
        * @access public
        * @static
        * @returns bool
        */
        public static function _clean($maxphptime){
               /*put a function in your Sessions class and call it here, the function should clean out the sessions
               ** table through the $max date (which is a unix/php timestamp*/
               /*EXMPLE:*/
               //Session::CleanExpiredSessions($maxphptime);
               return true;
        }
}
?>