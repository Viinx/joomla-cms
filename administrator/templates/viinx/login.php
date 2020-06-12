<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.isis
 *
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/** @var JDocumentHtml $this */

$app  = JFactory::getApplication();
$lang = JFactory::getLanguage();

// Output as HTML5
$this->setHtml5(true);

// Gets the FrontEnd Main page Uri
$frontEndUri = JUri::getInstance(JUri::root());
$frontEndUri->setScheme(((int) $app->get('force_ssl', 0) === 2) ? 'https' : 'http');

// Color Params
$background_color = $this->params->get('loginBackgroundColor') ?: '';
$color_is_light   = $background_color && colorIsLight($background_color);

// Add Stylesheets
JHtml::_('stylesheet', 'style' . ($this->direction === 'rtl' ? '-rtl' : '') . '.css', array('version' => 'auto', 'relative' => true));

// Load specific language related CSS
JHtml::_('stylesheet', 'administrator/language/' . $lang->getTag() . '/' . $lang->getTag() . '.css', array('version' => 'auto'));


// Detecting Active Variables
$option   = $app->input->getCmd('option', '');
$view     = $app->input->getCmd('view', '');
$layout   = $app->input->getCmd('layout', '');
$task     = $app->input->getCmd('task', '');
$itemid   = $app->input->getCmd('Itemid', '');
$sitename = htmlspecialchars($app->get('sitename', ''), ENT_QUOTES, 'UTF-8');


// Check if debug is on
if (JPluginHelper::isEnabled('system', 'debug') && ($app->get('debug_lang', 0) || $app->get('debug', 0))) {
	$this->addStyleDeclaration('
	.view-login .container {
		position: static;
		margin-top: 20px;
		margin-left: auto;
		margin-right: auto;
	}
	.view-login .navbar-fixed-bottom {
		position: relative;
	}');
}
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
	<jdoc:include type="head" />
</head>

<body class="site <?php echo $option . ' view-' . $view . ' layout-' . $layout . ' task-' . $task . ' itemid-' . $itemid . ' '; ?>">
	<div class="container max-w-full mx-auto py-24 px-6">
		<div class="font-sans">
			<div class="max-w-sm mx-auto px-6">
				<div class="relative flex flex-wrap">
					<div class="w-full relative">
						<div class="mt-6">
							<div class="text-center font-semibold text-black">
								<?php if ($loginLogoFile = $this->params->get('loginLogoFile')) : ?>
									<img src="<?php echo JUri::root() . htmlspecialchars($loginLogoFile, ENT_QUOTES); ?>" alt="<?php echo $sitename; ?>" />
								<?php else : ?>
									<img src="<?php echo $this->baseurl; ?>/templates/<?php echo $this->template; ?>/images/joomla.png" alt="<?php echo $sitename; ?>" />
								<?php endif; ?>
							</div>
							<jdoc:include type="message" />
							<jdoc:include type="component" />
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<jdoc:include type="modules" name="debug" style="none" />
</body>

</html>