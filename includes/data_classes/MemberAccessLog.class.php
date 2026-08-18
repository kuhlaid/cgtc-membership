<?php
/**
 * Jan. 1, 2018 - wpg
 * - adding $accessArray
 *
 */
	require(__DATAGEN_CLASSES__ . '/MemberAccessLogGen.class.php');

	/**
	 * The MemberAccessLog class defined here contains any
	 * customized code for the MemberAccessLog class in the
	 * Object Relational Model.  It represents the "MemberAccessLog" table
	 * in the database, and extends from the code generated abstract MemberAccessLogGen
	 * class, which contains all the basic CRUD-type functionality as well as
	 * basic methods to handle relationships and index-based loading.
	 *
	 * @package My Application
	 * @subpackage DataObjects
	 *
	 */
	class MemberAccessLog extends MemberAccessLogGen {
		/**
		 * Default "to string" handler
		 * Allows pages to _p()/echo()/print() this object, and to define the default
		 * way this object would be outputted.
		 *
		 * Can also be called directly via $objMemberAccessLog->__toString().
		 *
		 * @return string a nicely formatted string representation of this object
		 */
		public function __toString() {
			return sprintf('MemberAccessLog Object %s',  $this->intId);
		}
		public static $accessArray = array(
				0=>'Unknown',
				1=>'Google',
				2=>'Facebook',
				3=>'Email link'
		);

		// defines the Access control list items (April 14, 2017 - wpg)
		public static $aclArray = array(
				1=>'Membership Admin',
				2=>'Read-only',
				3=>'General Member Access'
		);


		// Override or Create New Load/Count methods
		// (For obvious reasons, these methods are commented out...
		// but feel free to use these as a starting point)
/*
		public static function LoadArrayBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return an array of MemberAccessLog objects
			return MemberAccessLog::QueryArray(
				QQ::AndCondition(
					QQ::Equal(QQN::MemberAccessLog()->Param1, $strParam1),
					QQ::GreaterThan(QQN::MemberAccessLog()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function LoadBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return a single MemberAccessLog object
			return MemberAccessLog::QuerySingle(
				QQ::AndCondition(
					QQ::Equal(QQN::MemberAccessLog()->Param1, $strParam1),
					QQ::GreaterThan(QQN::MemberAccessLog()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function CountBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return a count of MemberAccessLog objects
			return MemberAccessLog::QueryCount(
				QQ::AndCondition(
					QQ::Equal(QQN::MemberAccessLog()->Param1, $strParam1),
					QQ::Equal(QQN::MemberAccessLog()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function LoadArrayBySample($strParam1, $intParam2, $objOptionalClauses) {
			// Performing the load manually (instead of using Qcodo Query)

			// Get the Database Object for this Class
			$objDatabase = MemberAccessLog::GetDatabase();

			// Properly Escape All Input Parameters using Database->SqlVariable()
			$strParam1 = $objDatabase->SqlVariable($strParam1);
			$intParam2 = $objDatabase->SqlVariable($intParam2);

			// Setup the SQL Query
			$strQuery = sprintf('
				SELECT
					`MemberAccessLog`.*
				FROM
					`MemberAccessLog` AS `MemberAccessLog`
				WHERE
					param_1 = %s AND
					param_2 < %s',
				$strParam1, $intParam2);

			// Perform the Query and Instantiate the Result
			$objDbResult = $objDatabase->Query($strQuery);
			return MemberAccessLog::InstantiateDbResult($objDbResult);
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