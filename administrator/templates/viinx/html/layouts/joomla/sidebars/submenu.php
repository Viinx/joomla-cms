<?php

/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtmlBehavior::core();
?>

<?php if ($displayData->displayMenu) : ?>
	<menu class="bg-gray-200 -mt-1 px-6">
		<ul id="submenu" class="flex justify-start bg-gray-200">
			<?php foreach ($displayData->list as $item) :
				if (isset($item[2]) && $item[2] == 1) : ?>
					<li class="active bg-gray-800 text-gray-100 text-sm px-5 py-3">
					<?php else : ?>
					<li class="bg-gray-200 text-sm px-5 py-3">
					<?php endif;
				if ($displayData->hide) : ?>
						<a class="nolink"><?php echo $item[0]; ?></a>
						<?php else :
						if ($item[1] !== '') : ?>
							<a href="<?php echo JFilterOutput::ampReplace($item[1]); ?>"><?php echo $item[0]; ?></a>
						<?php else : ?>
							<?php echo $item[0]; ?>
					<?php endif;
					endif; ?>
					</li>
				<?php endforeach; ?>
		</ul>
	</menu>
<?php endif; ?>

<?php if ($displayData->displayFilters) : ?>
	<div class="hidden-phone p-6">
		<h4 class=""><?php echo JText::_('JSEARCH_FILTER_LABEL'); ?></h4>
		<?php foreach ($displayData->filters as $filter) : ?>
			<label for="<?php echo $filter['name']; ?>" class="element-invisible"><?php echo $filter['label']; ?></label>
			<select name="<?php echo $filter['name']; ?>" id="<?php echo $filter['name']; ?>" class="span12 small" onchange="this.form.submit()">
				<?php if (!$filter['noDefault']) : ?>
					<option value=""><?php echo $filter['label']; ?></option>
				<?php endif; ?>
				<?php echo $filter['options']; ?>
			</select>
			<hr class="hr-condensed" />
		<?php endforeach; ?>
	</div>
<?php endif; ?>