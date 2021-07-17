<?php
defined('_JEXEC') or die;

// No splitted button and modal. Therefore the easy way.
$btnModalConnector = $module->module . '_' . $module->id . time();

require ModuleHelper::getLayoutPath('mod_tocghsvs', 'tocGhsvs-button');
require ModuleHelper::getLayoutPath('mod_tocghsvs', 'tocGhsvs-modal');
