<?php
	require(__DATAGEN_CLASSES__ . '/MemberAclAssnGen.class.php');

	/**
	 * The MemberAclAssn class defined here contains any
	 * customized code for the MemberAclAssn class in the
	 * Object Relational Model.  It represents the "MemberAclAssn" table
	 * in the database, and extends from the code generated abstract MemberAclAssnGen
	 * class, which contains all the basic CRUD-type functionality as well as
	 * basic methods to handle relationships and index-based loading.
	 *
	 * @package My Application
	 * @subpackage DataObjects
	 *
	 */
	class MemberAclAssn extends MemberAclAssnGen {
		/**
		 * Default "to string" handler
		 * Allows pages to _p()/echo()/print() this object, and to define the default
		 * way this object would be outputted.
		 *
		 * Can also be called directly via $objMemberAclAssn->__toString().
		 *
		 * @return string a nicely formatted string representation of this object
		 */
		public function __toString() {
			return sprintf('MemberAclAssn Object %s',  $this->intId);
		}

		public static $accessArray = array(
				1=>'System Admin',
				2=>'Member',
				3=>'Newsletter Editor',
				4=>'Read-only'
		);

		public static $AdminAccess = 1;
		public static $MemberAccess = 2;
		public static $NewsletterEditorAccess = 3;
		public static $ReadOnlyAccess = 4;

		// get the current system access for the user
		public static function getCurrentAccessType() {
			$acx = QSessionDB::get(__SESSION_PREFIX__.'__CURRENT_SYSTEM_ACCESS__');
			if (!$acx) {
				MemberAclAssn::noSystemAccess();
			}
			return $acx;
		}

		public static function noSystemAccess() {
			QSessionDB::set('error', 'You do not have access to the system.  Please contact the CGTC membership chair.');
			header("Location: ".__SUBDIRECTORY__."/logout.php");
			exit;
		}

		/**
		 * Delete the access for a Member
		 * @return void
		 */
		public static function DeleteMemberAcl($intMemberId) {
			// Get the Database Object for this Class
			$objDatabase = MemberAclAssn::GetDatabase();

			// Perform the SQL Query
			$objDatabase->NonQuery('
				DELETE FROM
					`MemberAclAssn`
				WHERE
					`MemberId` = ' . $objDatabase->SqlVariable($intMemberId) . '');
		}


		// Override or Create New Load/Count methods
		// (For obvious reasons, these methods are commented out...
		// but feel free to use these as a starting point)
/*
		public static function LoadArrayBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return an array of MemberAclAssn objects
			return MemberAclAssn::QueryArray(
				QQ::AndCondition(
					QQ::Equal(QQN::MemberAclAssn()->Param1, $strParam1),
					QQ::GreaterThan(QQN::MemberAclAssn()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function LoadBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return a single MemberAclAssn object
			return MemberAclAssn::QuerySingle(
				QQ::AndCondition(
					QQ::Equal(QQN::MemberAclAssn()->Param1, $strParam1),
					QQ::GreaterThan(QQN::MemberAclAssn()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function CountBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return a count of MemberAclAssn objects
			return MemberAclAssn::QueryCount(
				QQ::AndCondition(
					QQ::Equal(QQN::MemberAclAssn()->Param1, $strParam1),
					QQ::Equal(QQN::MemberAclAssn()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function LoadArrayBySample($strParam1, $intParam2, $objOptionalClauses) {
			// Performing the load manually (instead of using Qcodo Query)

			// Get the Database Object for this Class
			$objDatabase = MemberAclAssn::GetDatabase();

			// Properly Escape All Input Parameters using Database->SqlVariable()
			$strParam1 = $objDatabase->SqlVariable($strParam1);
			$intParam2 = $objDatabase->SqlVariable($intParam2);

			// Setup the SQL Query
			$strQuery = sprintf('
				SELECT
					`MemberAclAssn`.*
				FROM
					`MemberAclAssn` AS `MemberAclAssn`
				WHERE
					param_1 = %s AND
					param_2 < %s',
				$strParam1, $intParam2);

			// Perform the Query and Instantiate the Result
			$objDbResult = $objDatabase->Query($strQuery);
			return MemberAclAssn::InstantiateDbResult($objDbResult);
		}
*/



		// Override or Create New Properties and Variables
		// For performance reasons, these variables and __set and __get override methods
		// are commented out.  But if you wish to implement or override any
		// of the data generated properties, please feel free to uncomment them.
/*
		protected $strSomeNewProperty;

		public function __get($strName) {
			switch ($strName) {
				case 'SomeNewProperty': return $this->strSomeNewProperty;

				default:
					try {
						return parent::__get($strName);
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}

		public function __set($strName, $mixValue) {
			switch ($strName) {
				case 'SomeNewProperty':
					try {
						return ($this->strSomeNewProperty = QType::Cast($mixValue, QType::String));
					} catch (QInvalidCastException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}

				default:
					try {
						return (parent::__set($strName, $mixValue));
					} catch (QCallerException $objExc) {
						$objExc->IncrementOffset();
						throw $objExc;
					}
			}
		}
*/
	}
?>