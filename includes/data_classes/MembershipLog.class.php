<?php
/**
 *
 * 
 * June 6, 2017 - wpg
 * - adding a door prize membership type (family)
 *
 * May 22, 2017 - wpg
 * - adding a door prize membership type (single)
 *
 * May 2, 2017 - wpg
 * - adding 'complimentary business membership' type
 *
 * April 9, 2017 - wpg
 * - modifying the $membershipTypeArray constant to include years and dollar amounts so I do not need to enter this in the form
 *
 * March 18, 2017 - wpg
 * - added membership log types and payment types for membership dues
 */
	require(__DATAGEN_CLASSES__ . '/MembershipLogGen.class.php');

	/**
	 * The MembershipLog class defined here contains any
	 * customized code for the MembershipLog class in the
	 * Object Relational Model.  It represents the "MembershipLog" table
	 * in the database, and extends from the code generated abstract MembershipLogGen
	 * class, which contains all the basic CRUD-type functionality as well as
	 * basic methods to handle relationships and index-based loading.
	 *
	 * @package My Application
	 * @subpackage DataObjects
	 *
	 */
	class MembershipLog extends MembershipLogGen {
		// defines the membership: years the membership applies to, the dollar amount, and the membership type (individual, family or student)
		// memberships and dollar amounts set as of 2016
		// adding a fourth array element for membership payment options (1 for include and 0 for exclude)
	    // the COVID-19 reprieve option added May 1, 2020 (this may extend until May 1, 2021)
		public static $membershipTypeArray = array(
				1=>array(1,"20.00","individual",1),
				10=>array(1,"0.00","individual (COVID-19 reprieve)",1),
				2=>array(5,"90.00","individual",1),
				3=>array(1,"30.00","family",1),
				11=>array(1,"0.00","family (COVID-19 reprieve)",1),
				4=>array(5,"135.00","family",1),
				5=>array(1,"15.00","student",1),
				6=>array(1,"0.00","complimentary business membership",0),
				7=>array(1,"0.00","complimentary door prize membership (single)",0),
				8=>array(1,"0.00","complimentary door prize membership (family)",0),
				9=>array(1,"75.00","individual - Running Start program",1),);
				// 88 - database initialization flag (March 18, 2017 - wpg)

		// defines payment types
		public static $paymentTypeArray = array(
				1=>"PayPal (or credit card)",
				2=>"Check",
				3=>"Cash");

		// defines payment types
		public static $medicalTrainingArray = array(
				1=>"MD",
				2=>"Nurse",
				3=>"EMT");

		/**
		 * Default "to string" handler
		 * Allows pages to _p()/echo()/print() this object, and to define the default
		 * way this object would be outputted.
		 *
		 * Can also be called directly via $objMembershipLog->__toString().
		 *
		 * @return string a nicely formatted string representation of this object
		 */
		public function __toString() {
			return sprintf('MembershipLog Object %s',  $this->intId);
		}

		public static function showMembershipType($intType) {
			if (array_key_exists($intType, MembershipLog::$membershipTypeArray))
				return MembershipLog::$membershipTypeArray[$intType][0]." year ".MembershipLog::$membershipTypeArray[$intType][2]." ($".MembershipLog::$membershipTypeArray[$intType][1].")";
		}

		public static function showPublicMembershipType($intType) {
			if (array_key_exists($intType, MembershipLog::$membershipTypeArray) && MembershipLog::$membershipTypeArray[$intType][3])
				return MembershipLog::$membershipTypeArray[$intType][0]." year ".MembershipLog::$membershipTypeArray[$intType][2];
		}

		// Override or Create New Load/Count methods
		// (For obvious reasons, these methods are commented out...
		// but feel free to use these as a starting point)
/*
		public static function LoadArrayBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return an array of MembershipLog objects
			return MembershipLog::QueryArray(
				QQ::AndCondition(
					QQ::Equal(QQN::MembershipLog()->Param1, $strParam1),
					QQ::GreaterThan(QQN::MembershipLog()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function LoadBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return a single MembershipLog object
			return MembershipLog::QuerySingle(
				QQ::AndCondition(
					QQ::Equal(QQN::MembershipLog()->Param1, $strParam1),
					QQ::GreaterThan(QQN::MembershipLog()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function CountBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return a count of MembershipLog objects
			return MembershipLog::QueryCount(
				QQ::AndCondition(
					QQ::Equal(QQN::MembershipLog()->Param1, $strParam1),
					QQ::Equal(QQN::MembershipLog()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function LoadArrayBySample($strParam1, $intParam2, $objOptionalClauses) {
			// Performing the load manually (instead of using Qcodo Query)

			// Get the Database Object for this Class
			$objDatabase = MembershipLog::GetDatabase();

			// Properly Escape All Input Parameters using Database->SqlVariable()
			$strParam1 = $objDatabase->SqlVariable($strParam1);
			$intParam2 = $objDatabase->SqlVariable($intParam2);

			// Setup the SQL Query
			$strQuery = sprintf('
				SELECT
					`MembershipLog`.*
				FROM
					`MembershipLog` AS `MembershipLog`
				WHERE
					param_1 = %s AND
					param_2 < %s',
				$strParam1, $intParam2);

			// Perform the Query and Instantiate the Result
			$objDbResult = $objDatabase->Query($strQuery);
			return MembershipLog::InstantiateDbResult($objDbResult);
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