<?php
/**
 * @abstract Main tag edit form
 * @author w. Patrick Gale
 *
 * March 21, 2017 - wpg
 * - creating basic form
 */
	// Include prepend.inc to load Qcodo
	require('includes/prepend.inc.php');
	require(__FORMBASE_CLASSES__ . '/TagEditFormBase.class.php');
	QApplication::CheckRemoteAdmin();

	class acx1TagEditForm extends TagEditFormBase {
		protected function calCreated_Create() {
			$this->calCreated = new QJsCalendar($this);
			$this->calCreated->Name = QApplication::Translate('Created date');
			$this->calCreated->DateTime = $this->objTag->Created;
		}

		protected function RedirectToListPage() {
			QApplication::Redirect('Tags.php');
		}
	}

	// go to the centralized form executing access control function to run the form and check access control
	ACL_Run('Tag');
?>