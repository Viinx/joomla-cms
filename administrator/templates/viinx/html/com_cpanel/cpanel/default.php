<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  com_cpanel
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\Registry\Registry;

$user = JFactory::getUser();
?>
<div class="p-6">
	<?php $iconmodules = JModuleHelper::getModules('icon');
	if ($iconmodules) : ?>
		<div>
			<div class="cpanel-links">
				<?php
				// Display the submenu position modules
				foreach ($iconmodules as $iconmodule) {
					echo JModuleHelper::renderModule($iconmodule);
				}
				?>
			</div>
		</div>
	<?php endif; ?>
	<div class="span<?php echo $iconmodules ? 9 : 12; ?>">
		<?php if ($user->authorise('core.manage', 'com_postinstall') && $this->postinstall_message_count) : ?>
			<div class="row-fluid">
				<div class="alert alert-info">
					<h3>
						<?php echo JText::_('COM_CPANEL_MESSAGES_TITLE'); ?>
					</h3>
					<p>
						<?php echo JText::_('COM_CPANEL_MESSAGES_BODY_NOCLOSE'); ?>
					</p>
					<p>
						<?php echo JText::_('COM_CPANEL_MESSAGES_BODYMORE_NOCLOSE'); ?>
					</p>
					<p>
						<a href="index.php?option=com_postinstall&amp;eid=700" class="btn btn-primary">
							<?php echo JText::_('COM_CPANEL_MESSAGES_REVIEW'); ?>
						</a>
					</p>
				</div>
			</div>
		<?php endif; ?>
		<div class="flex">
			<?php

			foreach ($this->modules as $module) {
				// Get module parameters
				$params = new Registry($module->params);
				if ($spans > 12) {
					echo '</div><div class="row-fluid">';
					$spans = $bootstrapSize;
				}
				echo JModuleHelper::renderModule($module, array('style' => 'well'));
			}
			?>
		</div>
	</div>
</div>