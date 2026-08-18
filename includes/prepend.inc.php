<?php
/**
 * Dec. 13, 2017 - wpg
 * - changing 'Tags' to 'Member Participation' so it is more clear to members what this is
 */

# load any extra packages installed via composer
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__. '/../'); # used to read $_ENV array values (.env variables)
$dotenv->load();

if (!defined('__PREPEND_INCLUDED__')) {
	// Ensure prepend.inc is only executed once
	define('__PREPEND_INCLUDED__', 1);

	///////////////////////////////////
	// Define Server-specific constants
	///////////////////////////////////
	/*
		* This assumes that the configuration include file is in the same directory
		* as this prepend include file.  For security reasons, you can feel free
		* to move the configuration file anywhere you want.  But be sure to provide
		* a relative or absolute path to the file.
		*/
	require(dirname(__FILE__) . '/configuration.inc.php');

	//////////////////////////////
	// Include the Qcodo Framework
	//////////////////////////////
	require(__QCODO_CORE__ . '/qcodo.inc.php');

	///////////////////////////////
	// Define the Application Class
	///////////////////////////////
	/**
	 * The Application class is an abstract class that statically provides
	 * information and global utilities for the entire web application.
	 *
	 * Custom constants for this webapp, as well as global variables and global
	 * methods should be declared in this abstract class (declared statically).
	 *
	 * This Application class should extend from the ApplicationBase class in
	 * the framework.
	 */
	abstract class QApplication extends QApplicationBase {
		/**
		 * This is called by the PHP5 Autoloader.  This method overrides the
		 * one in ApplicationBase.
		 *
		 * @return void
		 */
		public static function Autoload($strClassName) {
			// First use the Qcodo Autoloader
			parent::Autoload($strClassName);

			// TODO: Run any custom autoloading functionality (if any) here...
		}

	}


	//////////////////////////
	// Custom Global Functions
	//////////////////////////
	// TODO: Define any custom global functions (if any) here...

	/**
	 * Will compare a date to the current date and return a formatted date or countdown until time
	 *
	 * @param unknown_type $date
	 * @param unknown_type $format
	 * @return unknown
	 */
	function dateOff($date, $format = null){
		if ($date == "") {
			return;
		}
		$Date_exp = explode("-", $date);	// break the formatting from the database 2006/12/31
		$date = strtotime($Date_exp[1]."/".$Date_exp[2]."/".$Date_exp[0]);	// reconstruct date in proper format 12/31/2006

		$offset = (strftime("%j")+strftime("%Y")*365)-(strftime("%j",$date)+strftime("%Y",$date)*365);
		if ($offset > 0){
			if ($format==null) $return = strftime("%B %d, %Y",$date)."<br/><span class='error bld'>Grant Expired</span>";
			elseif ($format=='passed') $return = "<span class='error bld'>".strftime("%B %d, %Y",$date)."</span>";
			elseif ($format=='normal') $return = strftime("%B %d, %Y",$date);
		}
		elseif ($offset <= 0){
			$offset = (strftime("%j",$date)+strftime("%Y",$date)*365) - (strftime("%j")+strftime("%Y")*365);
			$notice = 'gen_small2b';

			// if the grant expires within the next 30 days then display the number of days left in red
			if (intval($offset) < 30) $notice = 'error bld';
			if ($format==null) $return = strftime("%B %d, %Y",$date)."<br/><span class='$notice'>".$offset. " days left</span>";
			elseif ($format=='passed') $return = strftime("%B %d, %Y",$date);
			elseif ($format=='normal') $return = strftime("%B %d, %Y",$date);
		}
		return $return;
	}

	/**
	 * Datagrid filtering refresh
	 *
	 * @param datagrid object $objDataGrid
	 */
	function searchFilterChange($objDataGrid) {
		// if the datagrid has been created
		if ($objDataGrid){
			$objDataGrid->Paginator->PageNumber = 1;
			$objDataGrid->Refresh();
		}
	}

	// wpg - used in data queries so the query does not choke on some of the data
	function wildcardEscape($d){
		return str_replace("_","[_]",$d);
	}

	/**
	 * Wrapper for question labels in forms
	 * @param $t
	 */
	function questionWrap($t) {
		return '<b>'.$t.'</b>';
	}

	function errorAlert( $text, $action='window.history.go(-1);', $mode=1 ) {
		$text = nl2br( $text );
		$text = addslashes( $text  ?? '');
		$text = strip_tags( $text );

		switch ( $mode ) {
			case 2:
				echo "<script>$action</script> \n";
				break;

			case 1:
			default:
				echo "<script>alert('$text'); $action</script> \n";
				break;
		}

		exit;
	}

		/**
	 * wpg - call this function if someone has restricted access to something; right now we are redirecting to logout page
	 *
	 */
	function restrictedAccess() {
		QApplication::Redirect(__SUBDIRECTORY__.'/logout.php');
	}


	/**
	 * wpg - We just need to make sure the user is logged in
	 *
	 * @param int $accessKey
	 */
	function checkAccess($accessKey = '') {
		// we want to call the last visited function on the restricted pages (we will ignore the public pages)
		if (!MemberContact::LoggedIn()) {
			QSessionDB::set('error', 'You do not have access to this resource.');
			QApplication::Redirect('index.php');
			return false;
		}
		// membership admin
		elseif (QSessionDB::get(__SESSION_PREFIX__.'__CURRENT_SYSTEM_ACCESS__')==MemberAclAssn::$AdminAccess && QSessionDB::get(__SESSION_PREFIX__.'__CURRENT_SYSTEM_ACCESS__')==$accessKey){
			return true;
		}
		// readonly access
		elseif (QSessionDB::get(__SESSION_PREFIX__.'__CURRENT_SYSTEM_ACCESS__')==MemberAclAssn::$MemberAccess && QSessionDB::get(__SESSION_PREFIX__.'__CURRENT_SYSTEM_ACCESS__')==$accessKey){
			return true;
		}
		return false;
	}


	// centralized access control to easily see which forms users are able to access
	// argument is the script name we are wanting to access
	function ACL_Run($script=''){
		define('__ACCESSED_CONTROLLED_SCRIPT__',$script);
		require(__INCLUDES__ . '/acl-'.MemberAclAssn::getCurrentAccessType().'.php');
		exit;	// stop any other activities if we call this function
	}


		/**
	 * wpg - Takes search results text ($rowtext) and looks through it to find the items ($search) being searched on.
	 * Prints and hightlights the results found.
	 *
	 * @param search_string $search
	 * @param text_searching_on $text
	 * @param type_of_text $textType
	 */
	function highlightResults($strSearch,$strSubject) {
		$return = '';
		$return = str_ireplace($strSearch, "<span class='hghLight'>".$strSearch."</span>", $strSubject);
		return $return;
	}

	/**
	 *
	 *
	 */
	function switchItemsPerPage() {
		$intItemsPerPage = QApplication::QueryString('itemsPerPage');	// get the navigation preference the user is requesting
		if ($intItemsPerPage != '') {
			QSessionDB::set("__ITEMS_PER_PAGE__", $intItemsPerPage);
			$redirectBack = QSessionDB::get("__LAST_VISITED_PAGE__");
			if ($redirectBack)
				QApplication::Redirect($redirectBack);
			else
				QApplication::Redirect('/?');
			//
		}
	}

	function checkItemsPerPage() {
		// if the items per page is already defined then just return it
		if (defined('__ITEMS_PER_PAGE__')) return __ITEMS_PER_PAGE__;

		$intItemsPerPage = QSessionDB::get("__ITEMS_PER_PAGE__");
		if ($intItemsPerPage != '') {
			define('__ITEMS_PER_PAGE__', $intItemsPerPage);	// specify the number of list items to show for the user
		}
		else
			define('__ITEMS_PER_PAGE__', 25);	// specify the number of list items to show for the user by default
	}

	////////////////
	// Include Files
	////////////////
	// TODO: Include any other include files (if any) here...
	require(__QCODO_CORE__ . '/QSessionDB.class.php');

	require_once(__QCODO_CORE__ . '/crypt/StonePhpSafeCrypt.php');

	///////////////////////
	// Setup Error Handling
	///////////////////////
	/*
		* Set Error/Exception Handling to the default
		* Qcodo HandleError and HandlException functions
		* (Only in non CLI mode)
		*
		* Feel free to change, if needed, to your own
		* custom error handling script(s).
		*/
// 		if (array_key_exists('SERVER_PROTOCOL', $_SERVER)) {
// 			set_error_handler('QcodoHandleError');
// 			set_exception_handler('QcodoHandleException');	//QcodoHandleException_pg for custom
// 		}


	////////////////////////////////////////////////
	// Initialize the Application and DB Connections
	////////////////////////////////////////////////
	QApplication::Initialize();
	QApplication::InitializeDatabaseConnections();


	/////////////////////////////
	// Start Session Handler (if required)
	/////////////////////////////
	//session_start();
	QSessionDB::SetMaxHours(4000); //overrides the default max hours setting of 8 hours
	QSessionDB::Initialize();

	// check to see if the user is switching the items per page and set the items per page
	switchItemsPerPage();
	checkItemsPerPage();
	$strItemsPerPage = "";
	$itemsPerPageArray = array(10, 25, 50, 100, 1000);
	$strItemsPerPage = "
		<div style='padding-top:5px;' class='sm'>Set items/page
	";
	foreach ($itemsPerPageArray as $value) {
		$selectedIPP = "";
		if ($value == checkItemsPerPage()) $strItemsPerPage .= "<a href='?itemsPerPage=".$value."' class='paginator_selected_page'>".$value."</a>";
		else $strItemsPerPage .= "<a href='?itemsPerPage=".$value."' class='paginator_page'>".$value."</a>";

		$strItemsPerPage .= ' ';
	}
	$strItemsPerPage .=
	"
		</div>
	";

	/**
	 * If someone isn't logged in and they try to access a restricted page, save the page address
	 * which will be used to redirect to once they login.
	 * @return unknown_type
	 */
	function getVisitedPage(){
		// we need to get the last page visited so we can redirect back to it once we have switched items per page setting
		QSessionDB::set("__LAST_VISITED_PAGE__", "https://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	}

	// @TODO - need to move this to checkAccess function in the future
	getVisitedPage();

	define('__PAGINATION_OPTIONS__', '&nbsp;&nbsp;'.$strItemsPerPage);

	//////////////////////////////////////////////
	// Setup Internationalization and Localization (if applicable)
	// Note, this is where you would implement code to do Language Setting discovery, as well, for example:
	// * Checking against $_GET['language_code']
	// * checking against session (example provided below)
	// * Checking the URL
	// * etc.
	// TODO: options to do this are left to the developer
	//////////////////////////////////////////////
	if (isset($_SESSION)) {
		if (array_key_exists('country_code', $_SESSION))
			QApplication::$CountryCode = $_SESSION['country_code'];
		if (array_key_exists('language_code', $_SESSION))
			QApplication::$LanguageCode = $_SESSION['language_code'];
	}

	// Initialize I18n if QApplication::$LanguageCode is set
	if (QApplication::$LanguageCode)
		QI18n::Initialize();

	$acxChange = QApplication::QueryString('acx');
	if ($acxChange) MemberContact::ChangeUserAccess($acxChange);

	// - CGTC application constants
	define('__strCGTC_MembershipList___','Club Members'); // March 12, 2017 - wpg
	define('__strCGTC_MembershipLogs___','Membership Logs'); // March 12, 2017 - wpg
	define('__strCGTC_Reports___','Reports'); // March 12, 2017 - wpg
	define('__strCGTC_Home___','Main page'); // March 18, 2017 - wpg
	define('__strCGTC_Membership___','My Membership'); // March 18, 2017 - wpg
	define('__strCGTC_MemberContact___','Member Contact'); // March 19, 2017 - wpg
	define('__strCGTC_TAGS___','Member Participation'); // March 21, 2017 - wpg
	define('__strCGTC_RACE_RESULTS___','Race Results'); // March 28, 2017 - wpg
	define('__strCGTC_CurrentMemberEmails___','Current Member Emails'); // April 14, 2017 - wpg
	define('__strCGTC_NotificationLogs___','Notification Logs'); // April 23, 2017 - wpg
	define('__strCGTC_MemberLogin___','CGTC - Member Login Link'); // April 23, 2017 - wpg
	define('__strCGTC_MembershipCorner___','Membership Corner'); // April 25, 2017 - wpg
	define('__strCGTC_PartnerBusinesses___','Partner Businesses'); // April 28, 2017 - wpg
	define('__strCGTC_Races___','Races'); // May 21, 2017 - wpg
	define('__strCGTC_RaceResults___','Race Results'); // May 21, 2017 - wpg
	define('__strCGTC_ApplicationAccess___','Application Access'); // May 23, 2017 - wpg
	define('__strCGTC_CurrentClubDiscounts___','Current Club Discounts'); // July 16, 2017 - wpg
	define('__strCGTC_MemberAccessLogs___','Application Access Logs'); // July 16, 2017 - wpg
	define('__strCGTC_ActiveMemberExport___','Member Export'); // Dec. 4, 2018 - wpg (used for updating race timing databases)
	define('__strCGTC_MemberMileageLogs___','Member Mileage'); // Nov. 22, 2019 - wpg 
	define('__strCGTC_CurrentMemberAges___','Member Ages'); // Jan. 31, 2026 - wpg
	// had to do away with Emoji because it was causing errors
	define('__txtC_RunningPerson__','My progress');
	define('__txtC_FinishFlag__','Goal');
}
?>