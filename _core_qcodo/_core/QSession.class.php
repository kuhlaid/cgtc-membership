<?php
/***************************************************************************
** FILE :  QSession.inc    AUTHOR:  Eric Brigham     Date:  9/3/2006
*
*						   Modified:  Chad Koski   10/20/06  -- minor mods for beta 3
*
*  Description:  Stores sessions in files instead of database (wpg - modified from original that stored in database)
*
*  Example Usage:   QSession::set("foo","bar");
*                   echo QSession::get("foo"); //echos "bar"
*                   $_SESSION["foo"] = "bar";  //yep, this still works fine
*
*****************************************************************************/

interface SessionSaveHandler{
/*these methods need to be declared in a class and assigned with the
   php function session_set_save_handler()*/
        public static function _open();
        public static function _close();
        public static function _read($id);
        public static function _write($id, $data);
        public static function _destroy($id);
        public static function _clean($max);
}



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

global $mySessionInfo,$_myReturn;


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
					eval("return $startTemp = UnpackCrypt($temp, SessionRegister::cryptKey());");
					$mySessionInfo = eval("return \$_myReturn;");
				}
			}
		}
	}
}


/* register class for storing stuff in the $_SESSION global variable*/
class SessionRegister {

		public static function cryptKey(){
			return "!@#334klkdjfo0i9LSDKFJO**SDFs3k";
		}

		public static function getIv() {
			$iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
			return mcrypt_create_iv($iv_size, MCRYPT_RAND);
		}

		public static function set ( $strName, $varValue ) {
			if ($varValue != '') {
				$_SESSION[$strName] = PackCrypt($varValue, SessionRegister::cryptKey());
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
				SessionRegister::get_array_elems($arrayString);
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
					SessionRegister::get_array_elems($value, $where."['$key']");
				else {
					for ($i=0; $i<count($value);$i++){
						$temp = $where."['$key']";
						eval("return $temp = PackCrypt(\$value, SessionRegister::cryptKey());");
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
//	      		SessionRegister::unscrambleElements($_SESSION[$sessionString],"\$_SESSION['$sessionString']", "\$_myReturn['$sessionString']", $mySessionInfo);
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
//						//SessionRegister::unscrambleElements($value, $where."['$key']", $saveVar."['$key']", $mySessionInfo);
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
//							eval("return $startTemp = UnpackCrypt($temp, SessionRegister::cryptKey());");
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
      		return UnpackCrypt($_SESSION[$strName], SessionRegister::cryptKey());
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

class QSession extends SessionRegister implements SessionSaveHandler {

      /*instance of Sessions object that will hold the current session*/
      public static $objSession_data;

      /*number of hours that the session is valid for*/
      private static $max_minutes = 8;
      private static $max_hours = 8;

      //run this to start the session
      public static function Initialize() {
      	// wpg - commented out the following lines to keep the sessions from saving to the database since we are encrypting them and not sure how well the code does at cleaning up old sessions in the table
      	// uncomment the following code to have sessions saved to the database instead
//             session_set_save_handler(array("QSession","_open"),
//                                      array("QSession","_close"),
//                                      array("QSession","_read"),
//                                      array("QSession","_write"),
//                                      array("QSession","_destroy"),
//                                      array("QSession","_clean"));
//             register_shutdown_function("session_write_close");

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
             
            // wpg - handling session timeout for file based sessions
	        $objNow = QDateTime::Now(true);	// get the current time
	        $strNowFormat = $objNow->toString(QDateTime::FormatIso);	// get current time string
	      	if (isset($_SESSION['LAST_ACTIVITY'])) {
	      		$last_activity = UnpackCrypt($_SESSION['LAST_ACTIVITY'], SessionRegister::cryptKey());
		      	// if we have started the session then we need to check that the session has not expired
		      	if (isset($last_activity)) {
		      		$objLastActivity = new QDateTime($last_activity);
		      		$difference = $objLastActivity->Difference($objNow->AddMinutes(-self::$max_minutes));
		      		// if time expired then we reset the session
					if (!is_null($difference)) {
						if ($difference->Seconds < 0) {
			    			// last request was more than self::$max_minutes minates ago
						    session_unset();     // unset $_SESSION variable for the runtime 
						    session_destroy();   // destroy session data in storage
						}
					}
				}
	      	}
			$_SESSION['LAST_ACTIVITY'] = PackCrypt($strNowFormat, SessionRegister::cryptKey()); // update last activity time stamp


             return true;
      }

      public static function SetMaxMinutes( $minutes = 120 ) {
             self::$max_minutes = $minutes;
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
        	
//                self::$objSession_data = Session::Load($id);
//                if( self::$objSession_data == null ) {
//                    /*must be a new session*/
//                    self::$objSession_data = new Session();
//                    self::$objSession_data->Id = $id;
//                    return ''; /*return empty string if there is no session*/
//                 } else {
//                    /*must be an existing session*/
//                    /*if session is too old, then delete session data, otherwise return it*/
//                    //$sessTime = new QDateTime(self::$objSession_data->LastAccess);
//                    $sessTime = self::$objSession_data->LastAccess;
//                    if( $sessTime->Timestamp < time() - self::$max_minutes*3600 ) {
//                        /*session is too old*/
//                        self::$objSession_data->SessionData = '';
//	                    self::$objSession_data->LastAccess = new QDateTime(QDateTime::Now);
//                        self::$objSession_data->Save();
//                        return ''; /*essentially restarts the session, but keeps the session id*/
//                    } else {
//                        return self::$objSession_data->SessionData;
//                    }
//                 }
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
                   self::$objSession_data->SessionData = $data;
                   self::$objSession_data->LastAccess = new QDateTime(QDateTime::Now);
                   self::$objSession_data->Save();
                   self::DeleteAll(); /*we do this in case we are on multiple servers and we dont want to confuse anyone*/
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
               if( $id != self::$objSession_data->Id ) {
                   /*maybe we hijacked a session somehow?*/
                   return false;
               } else {
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