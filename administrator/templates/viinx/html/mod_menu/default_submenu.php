<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  mod_menu
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

use Joomla\CMS\Menu\Node\Separator;

defined('_JEXEC') or die;

/**
 * =========================================================================================================
 * IMPORTANT: The scope of this layout file is the `JAdminCssMenu` object and NOT the module context.
 * =========================================================================================================
 */
/** @var  JAdminCssMenu  $this */
$current = $this->tree->getCurrent();

// Build the CSS class suffix
if (!$this->enabled) {
	$class = ' class="disabled"';
} elseif ($current instanceof Separator) {
	$class = $current->get('title') ? ' class="menuitem-group"' : ' class="divider"';
} elseif ($current->hasChildren()) {
	if ($current->getLevel() == 1) {
		$class = '  x-data="{ open: false }" class="dropdown"';
	} elseif ($current->get('class') == 'scrollable-menu') {
		$class = ' class="dropdown scrollable-menu"';
	} else {
		$class = ' class="dropdown-submenu"';
	}
} else {
	$class = '';
}

// Print the item
echo '<li' . $class . '>';

// Print a link if it exists
$linkClass     = array();
$dataToggle    = '';
$dropdownCaret = '';

if (!($current instanceof Separator) && ($current->getLevel() > 1)) {
	$iconClass = $this->tree->getIconClass();

	if (trim($iconClass)) {
		$linkClass[] = $iconClass;
	}
}

// Implode out $linkClass for rendering
$linkClass = ' class="w-full flex justify-between items-center py-2 px-2 text-gray-100 cursor-pointer hover:bg-gray-700 hover:text-gray-100 focus:outline-none ' . implode(' ', $linkClass) . '" ';

// Links: component/url/heading/container
if ($link = $current->get('link')) {
	$icon = $current->get('icon');

	if ($icon) {
		if (substr($icon, 0, 6) == 'class:') {
			$icon = '<span class="' . substr($icon, 6) . '"></span>';
		} elseif (substr($icon, 0, 6) == 'image:') {
			$icon = JHtml::_('image', substr($icon, 6), null, null, true);
		} else {
			$icon = JHtml::_('image', $icon, null);
		}
	}

	$target = $current->get('target') ? 'target="' . $current->get('target') . '"' : '';

	echo '<a @click="open = !open" ' . $linkClass . $dataToggle . ' href="' . $link . '" ' . $target . '>
			<span class="mx-4 text-xs font-thin">' . JText::_($current->get('title')) . $icon . $dropdownCaret . '</span>
		  </a>';
}
// Separator
else {
	echo '<span class="mx-4 text-xs font-thin">' . JText::_($current->get('title')) . '</span>';
}

// Recurse through children if they exist
if ($this->enabled && $current->hasChildren()) {
	if ($current->getLevel() > 1) {
		$id = $current->get('id') ? ' id="menu-' . strtolower($current->get('id')) . '"' : '';

		echo '<ul' . $id . ' class="hidden">' . "\n";
	} else {
		echo '<ul class="pl-2 bg-gray-700" x-show="open" style="display:none"> ' . "\n";
	}

	// WARNING: Do not use direct 'include' or 'require' as it is important to isolate the scope for each call
	$this->renderSubmenu(__FILE__);

	echo "</ul>\n";
}

echo "</li>\n";
