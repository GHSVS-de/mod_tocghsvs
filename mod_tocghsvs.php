<?php
defined('_JEXEC') or die;

use Joomla\CMS\Helper\ModuleHelper;

JLoader::register('TocGhsvsHelper', __DIR__ . '/src/Helper/TocGhsvsHelper.php');

/* To calculate a unique id for both participating modules (button and modal) we need a
identical base in both modules. */
// Set already otherwise? E.g. in layout buttonAndModal.php.
$btnModalConnector = TocGhsvsHelper::getId($params);

### Deactivate this line if you have no sticky element or add your own selector.
### E.g. '#astroid-sticky-header'
### Not implemented yet in module settings.
$params->set('stickySelector', '#CfButtonGruppeGhsvs');

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'), ENT_COMPAT, 'UTF-8');

require ModuleHelper::getLayoutPath(
	'mod_tocghsvs', $params->get('layout', 'buttonAndModal')
);
