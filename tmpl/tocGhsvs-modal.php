<?php
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

echo PHP_EOL . '<!--File: ' . str_replace(JPATH_SITE, '', dirname(__FILE__)) . '/'. basename(__FILE__) . '-->' . PHP_EOL;

/* To calculate a unique id for both participating modules (button and modal) we need a
identical base in both modules. */
// Set already otherwise? E.g. in layout buttonAndModal.php.
if (!empty($btnModalConnector))
{
	$id = $btnModalConnector;
}
// Paranoia.
else
{
	$id = TocGhsvsHelper::getId($params);
}

$scriptOptions = TocGhsvsHelper::getScriptOptions(
	$params, $id, $module->id
);

### Custom overrides START
/* Here you can override the $scriptOptions array because not all parameters
are already implemented in module settings. */

### Custom overrides END

$document = Factory::getDocument();

$document->addScriptOptions(
	'tocGhsvs-settings' . $module->id,
		[
			'settings' => [
				'TocGhsvs' => $scriptOptions
			]
		]
);

// Why?
//HTMLHelper::_('behavior.core');
HTMLHelper::_('script', 'mod_tocghsvs/tocGhsvs.min.js',
	['version' => 'auto', 'relative' => true], ['defer' => true]);

$document->addScriptDeclaration("document.addEventListener('DOMContentLoaded', function() {
	window.tocGhsvsInit(Joomla.getOptions('tocGhsvs-settings" . $module->id ."'));
});");

######### Close modal after action.
/* $document->addScriptDeclaration(
'jQuery(function(){jQuery("#' . $id . ' a[href*=\"#\"]").not("[href=\"#\"]").not("[href=\"#0\"]").on("click", function(event){jQuery("#' . $id . '").modal("hide");jQuery("#' . $id . ' .dropdown").removeClass("open");});});'
); */
// BS5
$document->addScriptDeclaration(
'jQuery(function(){
 var myModalEl' . $module->id . ' = new bootstrap.Modal("#' . $id .'");
 jQuery("#' . $id . ' a[href*=\"#\"]").not("[href=\"#\"]").not("[href=\"#0\"]").on("click",
  function(event){myModalEl' . $module->id . '.hide();}
 );});');
?>
<div class="HIDEIFNOTHINGFOUND<?php echo $id; ?>">
	<div class="modal" id="<?php echo $id; ?>" tabindex="-1" role="dialog"
		aria-labelledby="<?php echo $id; ?>Title" aria-hidden="true">
		<div class="modal-dialog modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<p class="modal-title h3" id="<?php echo $id; ?>Title">
						<?php echo Text::_('MOD_TOCGSHVS_MODAL_TITLE'); ?>
					</p>
					<button type="button" class="btn-close" data-bs-dismiss="modal"
						aria-label="<?php echo Text::_('MOD_TOCGSHVS_MODAL_CLOSE'); ?>">
						{svg{bi/x-circle-fill}class="text-danger"}
					</button>
				</div><!--/modal-header-->
				<div class="modal-body container-fluid">
					<div class="row">
						<div class="col-12" id="tocGhsvsOutput-<?php echo $id; ?>">

						</div>
					</div>
				</div><!--/modal-body-->
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
						<?php echo Text::_('MOD_TOCGSHVS_MODAL_CLOSE'); ?>
					</button>
				</div><!--/modal-footer-->
			</div><!--/modal-content-->
		</div><!--/modal-dialog-->
	</div>
</div>
