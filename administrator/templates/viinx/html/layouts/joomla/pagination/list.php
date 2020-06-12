<?php

/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$list = $displayData['list'];
?>
<ul>
	<li class="mx-1 px-3 py-2 bg-gray-200 text-gray-500 rounded-lg"><?php echo $list['start']['data']; ?></li>
	<li class="mx-1 px-3 py-2 bg-gray-200 text-gray-500 rounded-lg"><?php echo $list['previous']['data']; ?></li>
	<?php foreach ($list['pages'] as $page) : ?>
		<?php echo '<li class="mx-1 px-3 py-2 bg-gray-200 text-gray-700 hover:bg-gray-700 hover:text-gray-200 rounded-lg" >' . $page['data'] . '</li>'; ?>
	<?php endforeach; ?>
	<li class="mx-1 px-3 py-2 bg-gray-200 text-gray-500 rounded-lg"><?php echo $list['next']['data']; ?></li>
	<li class="mx-1 px-3 py-2 bg-gray-200 text-gray-500 rounded-lg"><?php echo $list['end']['data']; ?></li>
</ul>