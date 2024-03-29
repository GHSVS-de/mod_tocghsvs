<?php
use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use GHSVS\Module\TocGhsvs\Site\Helper\TocGhsvsHelper;

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

$scriptOptions = TocGhsvsHelper::getScriptOptions($params, $id, $module->id);

### Custom overrides START
/* Here you can override the $scriptOptions array because not all parameters
are already implemented in module settings. */

### Custom overrides END

$document = Factory::getDocument();

$document->addScriptOptions(
	'tocGhsvs-settings' . $module->id,
	[
			'settings' => [
				'TocGhsvs' => $scriptOptions,
			],
		]
);

$document->addScriptDeclaration(
<<<JS
document.addEventListener('DOMContentLoaded', function()
{
	window.tocGhsvsInit(Joomla.getOptions("tocGhsvs-settings$module->id"));

	var myModalEl$module->id = new bootstrap.Modal("#$id");
	document.getElementById("$id").querySelectorAll("#$id a[href*=\"#\"]")
		.forEach((link) =>
		{
			let parts = link.href.split('#');

			if (! parts[1] || parts[1] === '0')
			{
				return;
			}

			link.addEventListener('click', (e) => {
				myModalEl$module->id.hide();
			});
	});
});
JS);
?>
<div class="HIDEIFNOTHINGFOUND<?php echo $id; ?>">
	<div class="modal" id="<?php echo $id; ?>" tabindex="-1" role="dialog"
		aria-labelledby="<?php echo $id; ?>Title" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
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
