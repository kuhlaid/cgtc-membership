<?php
	// This is the HTML template include file (.tpl.php) for the race_results_edit.php
	// form DRAFT page.  Remember that this is a DRAFT.  It is MEANT to be altered/modified.
	// Be sure to move this out of the generated/ subdirectory before modifying to ensure that subsequent
	// code re-generations do not overwrite your changes.

	// kick user away from script if they are not going through the proper channels
	if (!defined('__PREPEND_INCLUDED__')) exit;

	require(__INCLUDES__ . '/header.inc.php');
?>
	<?php $this->RenderBegin() ?>
	<?php print $_glblWrapper;  // NOTE: this flex bootstrap tag MUST BE inside the Qcodo form and not outside of it?> 
<div class="p-2 col-md-12">
<?php // build the page title and critical links ?>
	<div class="d-flex h3">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="Races.php" data-toggle="tooltip" title="View the list of races">Races</a></li>
			<li class="breadcrumb-item active font-weight-bold" aria-current="page"><?php $this->lstRaceObject->RenderNoBreaks(); ?></li>
			</ol>
		</nav>
	</div>
	<div class="d-flex h5">
		<nav aria-label="breadcrumb">
			<ol class="breadcrumb">
			<?php $this->calRaceDate->RenderNoBreaks(); ?>
			</ol>
		</nav>
	</div>

	<?php $this->btnPart->RenderNoBreaks(); ?>
		<?php $this->txtHeaderLine->RenderNoBreaks(); ?>

		<?php $this->txtPlacement->RenderNoBreaks(); ?>
		
		<br class="item_divider" />

		<br />
		<?php $this->btnSave->Render(); ?>
		&nbsp;&nbsp;&nbsp;
		<?php $this->btnCancel->Render(); ?>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<?php $this->btnDelete->Render(); ?>
		</div>
	<?php $this->RenderEnd() ?>

<?php require(__INCLUDES__ .'/footer.inc.php'); ?>