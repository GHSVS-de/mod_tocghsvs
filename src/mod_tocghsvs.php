<?php
defined('_JEXEC') or die;

if (version_compare(JVERSION, '4', 'lt'))
{
	JLoader::registerNamespace(
		'GHSVS\Module\TocGhsvs\Site',
		__DIR__ . '/src', false, false, 'psr4'
	);
}

use Joomla\CMS\Helper\ModuleHelper;
use GHSVS\Module\TocGhsvs\Site\Helper\TocGhsvsHelper;

TocGhsvsHelper::loadAssets($params);

/* To calculate a unique id for both participating modules (button and modal) we need a
identical base in both modules. */
// Set already otherwise? E.g. in layout buttonAndModal.php.
$btnModalConnector = TocGhsvsHelper::getId($params);

### Deactivate this line if you have no sticky element or add your own selector.
### E.g. '#astroid-sticky-header'
# Wohl noch gar nicht wirklich implementiert.
$params->set('stickySelector', '#CfButtonGruppeGhsvs');

$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx', ''), ENT_COMPAT, 'UTF-8');

require ModuleHelper::getLayoutPath(
	'mod_tocghsvs',
	$params->get('layout', 'buttonAndModal')
);
