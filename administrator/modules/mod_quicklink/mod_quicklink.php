<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  mod_quickicon
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('ModQuickLinkHelper', __DIR__ . '/helper.php');

$buttons = ModQuickLinkHelper::getButtons($params);

require JModuleHelper::getLayoutPath('mod_quicklink', $params->get('layout', 'default'));
