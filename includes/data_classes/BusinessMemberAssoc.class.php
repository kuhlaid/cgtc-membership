<?php
/**
 * May 6, 2017 - wpg
 * - adding MemberRepresentative and MemberBusinessRepresenting functions
 */
	require(__DATAGEN_CLASSES__ . '/BusinessMemberAssocGen.class.php');

	/**
	 * The BusinessMemberAssoc class defined here contains any
	 * customized code for the BusinessMemberAssoc class in the
	 * Object Relational Model.  It represents the "BusinessMemberAssoc" table
	 * in the database, and extends from the code generated abstract BusinessMemberAssocGen
	 * class, which contains all the basic CRUD-type functionality as well as
	 * basic methods to handle relationships and index-based loading.
	 *
	 * @package My Application
	 * @subpackage DataObjects
	 *
	 */
	class BusinessMemberAssoc extends BusinessMemberAssocGen {
		/**
		 * Default "to string" handler
		 * Allows pages to _p()/echo()/print() this object, and to define the default
		 * way this object would be outputted.
		 *
		 * Can also be called directly via $objBusinessMemberAssoc->__toString().
		 *
		 * @return string a nicely formatted string representation of this object
		 */
		public function __toString() {
			return sprintf('BusinessMemberAssoc Object %s',  $this->intId);
		}

		// shows the members representing a business
		public static function MemberRepresentative($intPartnerBusinessId,$link=false) {
			$objBusinessMemberAssocArray = BusinessMemberAssoc::LoadArrayByPartnerBusinessId($intPartnerBusinessId);
			$return = '';
			if ($objBusinessMemberAssocArray) {
				foreach($objBusinessMemberAssocArray as $objBusinessMemberAssoc) {
					// do not show link to member by default
					if ($link)
						$return .= "<div class='bld'><a href='MembershipList.php?iMD=".$objBusinessMemberAssoc->MemberId."'>".$objBusinessMemberAssoc->MemberIdObject->__toString()."</a></div>";
					else
						$return .= "<div class='bld'>".$objBusinessMemberAssoc->MemberIdObject->__toString()."</div>";
				}
				return $return;
			}
			else
				return null;
		}

		// shows the businesses represented by a member
		public static function MemberBusinessRepresenting($intMemberId,$link=false) {
			$objBusinessMemberAssocArray = BusinessMemberAssoc::LoadArrayByMemberId($intMemberId);
			$return = '';
			if ($objBusinessMemberAssocArray) {
				foreach($objBusinessMemberAssocArray as $objBusinessMemberAssoc) {
					// do not show link to business by default
					if ($link)
						$return .= "<div class='bld'><a href='PartnerBusinesses.php?iPB=".$objBusinessMemberAssoc->PartnerBusinessId."'>".$objBusinessMemberAssoc->PartnerBusinessIdObject->__toString()."</a></div>";
					else
						$return .= "<div class='bld'>".$objBusinessMemberAssoc->PartnerBusinessIdObject->__toString()."</div>";
				}
				return "Business contact for: ".$return;
			}
			else
				return null;
		}

		// Override or Create New Load/Count methods
		// (For obvious reasons, these methods are commented out...
		// but feel free to use these as a starting point)
/*
		public static function LoadArrayBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return an array of BusinessMemberAssoc objects
			return BusinessMemberAssoc::QueryArray(
				QQ::AndCondition(
					QQ::Equal(QQN::BusinessMemberAssoc()->Param1, $strParam1),
					QQ::GreaterThan(QQN::BusinessMemberAssoc()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function LoadBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return a single BusinessMemberAssoc object
			return BusinessMemberAssoc::QuerySingle(
				QQ::AndCondition(
					QQ::Equal(QQN::BusinessMemberAssoc()->Param1, $strParam1),
					QQ::GreaterThan(QQN::BusinessMemberAssoc()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function CountBySample($strParam1, $intParam2, $objOptionalClauses = null) {
			// This will return a count of BusinessMemberAssoc objects
			return BusinessMemberAssoc::QueryCount(
				QQ::AndCondition(
					QQ::Equal(QQN::BusinessMemberAssoc()->Param1, $strParam1),
					QQ::Equal(QQN::BusinessMemberAssoc()->Param2, $intParam2)
				),
				$objOptionalClauses
			);
		}

		public static function LoadArrayBySample($strParam1, $intParam2, $objOptionalClauses) {
			// Performing the load manually (instead of using Qcodo Query)

			// Get the Database Object for this Class
			$objDatabase = BusinessMemberAssoc::GetDatabase();

			// Properly Escape All Input Parameters using Database->SqlVariable()
			$strParam1 = $objDatabase->SqlVariable($strParam1);
			$intParam2 = $objDatabase->SqlVariable($intParam2);

			// Setup the SQL Query
			$strQuery = sprintf('
				SELECT
					`BusinessMemberAssoc`.*
				FROM
					`BusinessMemberAssoc` AS `BusinessMemberAssoc`
				WHERE
					param_1 = %s AND
					param_2 < %s',
				$strParam1, $intParam2);

			// Perform the Query and Instantiate the Result
			$objDbResult = $objDatabase->Query($strQuery);
			return BusinessMemberAssoc::InstantiateDbResult($objDbResult);
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