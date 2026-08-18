<?php
	class QQN {
		static public function BusinessMemberAssoc() {
			return new QQNodeBusinessMemberAssoc('BusinessMemberAssoc', null);
		}
		static public function FamilyMemberAssoc() {
			return new QQNodeFamilyMemberAssoc('FamilyMemberAssoc', null);
		}
		static public function MemberAccessLog() {
			return new QQNodeMemberAccessLog('MemberAccessLog', null);
		}
		static public function MemberAclAssn() {
			return new QQNodeMemberAclAssn('MemberAclAssn', null);
		}
		static public function MemberContact() {
			return new QQNodeMemberContact('MemberContact', null);
		}
		static public function MemberMileage() {
			return new QQNodeMemberMileage('MemberMileage', null);
		}
		static public function MemberRaceResult() {
			return new QQNodeMemberRaceResult('MemberRaceResult', null);
		}
		static public function MemberTagAssoc() {
			return new QQNodeMemberTagAssoc('MemberTagAssoc', null);
		}
		static public function MembershipAssoc() {
			return new QQNodeMembershipAssoc('MembershipAssoc', null);
		}
		static public function MembershipLog() {
			return new QQNodeMembershipLog('MembershipLog', null);
		}
		static public function NotificationLog() {
			return new QQNodeNotificationLog('NotificationLog', null);
		}
		static public function PartnerBusiness() {
			return new QQNodePartnerBusiness('PartnerBusiness', null);
		}
		static public function Race() {
			return new QQNodeRace('Race', null);
		}
		static public function RaceResults() {
			return new QQNodeRaceResults('RaceResults', null);
		}
		static public function Session() {
			return new QQNodeSession('Session', null);
		}
		static public function Tag() {
			return new QQNodeTag('Tag', null);
		}
	}
?>