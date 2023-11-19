<?php
use Joomla\CMS\Language\Text;
use GHSVS\Module\TocGhsvs\Site\Helper\TocGhsvsHelper;

echo PHP_EOL . '<!--File: ' . str_replace(JPATH_SITE, '', dirname(__FILE__)) . '/' . basename(__FILE__) . '-->' . PHP_EOL;

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

$buttonTitle = $module->showtitle ? $module->title : 'MOD_TOCGSHVS_BUTTON_TEXT';
$buttonTitle = Text::_($buttonTitle);
?><button type="button" class="btn btn-primary HIDEIFNOTHINGFOUND<?php echo $id; ?>"
	data-bs-toggle="modal"
	data-bs-target="#<?php echo $id; ?>">
	<?php echo $buttonTitle; ?>
	{svg{bi/sort-down-alt}}
</button>
