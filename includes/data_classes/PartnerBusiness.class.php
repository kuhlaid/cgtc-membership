<?php
	require(__DATAGEN_CLASSES__ . '/PartnerBusinessGen.class.php');

	/**
	 * The PartnerBusiness class defined here contains any
	 * customized code for the PartnerBusiness class in the
	 * Object Relational Model.  It represents the "PartnerBusiness" table
	 * in the database, and extends from the code generated abstract PartnerBusinessGen
	 * class, which contains all the basic CRUD-type functionality as well as
	 * basic methods to handle relationships and index-based loading.
	 *
	 * @package My Application
	 * @subpackage DataObjects
	 *
	 */
	class PartnerBusiness extends PartnerBusinessGen {
		/**
		 * Default "to string" handler
		 * Allows pages to _p()/echo()/print() this object, and to define the default
		 * way this object would be outputted.
		 *
		 * Can also be called directly via $objPartnerBusiness->__toString().
		 *
		 * @return string a nicely formatted string representation of this object
		 */
		public function __toString() {
			return sprintf('%s',  $this->Name);
		}

		// returns the list of current partner businesses to use for the member updates or club website
		public static function currentPbWebList() {
			$objPartnerBusinessArray = PartnerBusiness::QueryArray(
					QQ::Equal(QQN::PartnerBusiness()->Active, true),
					QQ::Clause(QQ::OrderBy(QQN::PartnerBusiness()->Name))
			);
			$bgColor="background-color:#f7f7f7;border-top:dashed 1px #ccc;border-bottom:dashed 1px #ccc;";
			$altRow = true;
			$body='';
			if ($objPartnerBusinessArray) foreach($objPartnerBusinessArray as $objPartnerBusiness) {
				$body .= "<div style='".(($altRow) ? $bgColor : '')."padding:15px;'>
				<span style='font-size:18px;font-weight:bold;color:red;'>".$objPartnerBusiness->Name."</span>
				<span style='font-size:14px;'>Discount:</span>
				<b>".trim($objPartnerBusiness->Discount ?? '')."</b>

				<span style='font-size:14px;'>Phone:</span>
				".trim($objPartnerBusiness->Phone ?? '')."

				<span style='font-size:14px;'>Locations:</span>
				".trim($objPartnerBusiness->Address ?? '')."

				<span style='font-size:14px;'>Hours:</span>
				<b>".trim($objPartnerBusiness->Hours ?? '')."</b>

				<span style='font-size:14px;'>Online:</span>
				".trim($objPartnerBusiness->Website ?? '');
				// needed to check that we had a date (May 16, 2018 - wpg)
				if ($objPartnerBusiness->VerifiedDiscountDate) $body .= "
				<i>Confirmed discount and store info: ".$objPartnerBusiness->VerifiedDiscountDate->toString(QDateTime::FormatDisplayDate)."</i></div>
				";
				$altRow = !$altRow;
			}
			return $body;
		}

		// Override or Create New Load/Count methods
		// (For obvious reasons, these methods are commented out...
		// but feel free to use these as a starting point)
/*
		public static function LoadArrayBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return an array of PartnerBusiness objects
			return PartnerBusiness::QueryArray(
				QQ::AndCondition(
					QQ::Equal(QQN::PartnerBusiness()->Param1, $strParam1),
					QQ::GreaterThan(QQN::PartnerBusiness()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function LoadBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return a single PartnerBusiness object
			return PartnerBusiness::QuerySingle(
				QQ::AndCondition(
					QQ::Equal(QQN::PartnerBusiness()->Param1, $strParam1),
					QQ::GreaterThan(QQN::PartnerBusiness()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function CountBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return a count of PartnerBusiness objects
			return PartnerBusiness::QueryCount(
				QQ::AndCondition(
					QQ::Equal(QQN::PartnerBusiness()->Param1, $strParam1),
					QQ::Equal(QQN::PartnerBusiness()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function LoadArrayBySample($strParam1, $intParam2, $objOptionalClauses) {
			// Performing the load manually (instead of using Qcodo Query)

			// Get the Database Object for this Class
			$objDatabase = PartnerBusiness::GetDatabase();

			// Properly Escape All Input Parameters using Database->SqlVariable()
			$strParam1 = $objDatabase->SqlVariable($strParam1);
			$intParam2 = $objDatabase->SqlVariable($intParam2);

			// Setup the SQL Query
			$strQuery = sprintf('
				SELECT
					`PartnerBusiness`.*
				FROM
					`PartnerBusiness` AS `PartnerBusiness`
				WHERE
					param_1 = %s AND
					param_2 < %s',
				$strParam1, $intParam2);

			// Perform the Query and Instantiate the Result
			$objDbResult = $objDatabase->Query($strQuery);
			return PartnerBusiness::InstantiateDbResult($objDbResult);
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