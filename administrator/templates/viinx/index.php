<?php

/**
 * @package     Joomla.Administrator
 * @subpackage  Templates.isis
 * @copyright   Copyright (C) 2005 - 2020 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @since       3.0
 */

defined('_JEXEC') or die;

/** @var JDocumentHtml $this */

$app   = JFactory::getApplication();
$lang  = JFactory::getLanguage();
$input = $app->input;
$user  = JFactory::getUser();

// Output as HTML5
$this->setHtml5(true);

// Gets the FrontEnd Main page Uri
$frontEndUri = JUri::getInstance(JUri::root());
$frontEndUri->setScheme(((int) $app->get('force_ssl', 0) === 2) ? 'https' : 'http');
$mainPageUri = $frontEndUri->toString();

// Add JavaScript Frameworks
// JHtml::_('bootstrap.framework');


// Add template js
JHtml::_('script', 'template.js', array('version' => 'auto', 'relative' => true));

// Add Stylesheets
JHtml::_('stylesheet', 'style' . ($this->direction === 'rtl' ? '-rtl' : '') . '.css', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'icomoon.css', array('version' => 'auto', 'relative' => true));

// Load specific language related CSS
JHtml::_('stylesheet', 'administrator/language/' . $lang->getTag() . '/' . $lang->getTag() . '.css', array('version' => 'auto'));


// Detecting Active Variables
$option   = $input->get('option', '');
$task     = $input->get('task', '');
$itemid   = $input->get('Itemid', 0, 'int');
$sitename = htmlspecialchars($app->get('sitename', ''), ENT_QUOTES, 'UTF-8');
$cpanel   = $option === 'com_cpanel';

$hidden = $app->input->get('hidemainmenu');

$showSubmenu          = false;
$this->submenumodules = JModuleHelper::getModules('submenu');

foreach ($this->submenumodules as $submenumodule) {
	$output = JModuleHelper::renderModule($submenumodule);

	if ($output !== '') {
		$showSubmenu = true;
		break;
	}
}

// Template Parameters
$displayHeader = $this->params->get('displayHeader', '1');
$statusFixed   = $this->params->get('statusFixed', '1');
$stickyToolbar = $this->params->get('stickyToolbar', '1');

// Header classes
$navbar_color    = $this->params->get('templateColor') ?: '';
$header_color    = $displayHeader && $this->params->get('headerColor') ? $this->params->get('headerColor') : '';
$navbar_is_light = $navbar_color && colorIsLight($navbar_color);
$header_is_light = $header_color && colorIsLight($header_color);

if ($displayHeader) {
	// Logo file
	if ($this->params->get('logoFile')) {
		$logo = JUri::root() . htmlspecialchars($this->params->get('logoFile'), ENT_QUOTES);
	} else {
		$logo = $this->baseurl . '/templates/' . $this->template . '/images/logo' . ($header_is_light ? '-inverse' : '') . '.png';
	}
}



// Pass some values to javascript
$offset = 20;


$stickyBar = 0;
if ($stickyToolbar) {
	$stickyBar = 'true';
}

// $document = JFactory::getDocument();
// $headData = $document->getHeadData();
// $scripts = $headData['scripts'];
// // unset($doc->_scripts[JURI::root(true) . '/media/jui/js/bootstrap-tooltip-extended.min.js']);

// unset($scripts['/media/jui/js/bootstrap-tooltip-extended.min.js']);
unset($this->_scripts['/media/jui/js/bootstrap-tooltip-extended.min.js']);
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">

<head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.js" defer></script>
	<jdoc:include type="head" />
</head>

<body class="bg-gray-100  flex <?php echo $option ?>" data-basepath="<?php echo JURI::root(true); ?>">

	<aside class="w-56 h-screen bg-gray-800 overflow-x-scroll sm:block shadow-xl">

		<div class="flex items-center justify-center mt-5 px-6">
			<img src="<?php echo $logo; ?>" class="logo" alt="<?php echo $sitename; ?>" />
		</div>

		<nav class="mt-3 text-white text-base font-semibold pt-3">
			<jdoc:include type="modules" name="menu" style="none" />
		</nav>

		<div class="absolute w-auto bg-gray-800 bottom-0">
			<a class="py-2 px-6 block text-gray-100 hover:text-gray-200 text-xs" href="#">
				Joomla v3.9.19
			</a>
		</div>

	</aside>

	<div class="w-full flex flex-col h-screen overflow-y-hidden">
		<!-- Desktop Header -->
		<header class="w-full flex items-center bg-grey-darker py-2 px-6 hidden sm:flex">
			<div class="w-1/4">
				<jdoc:include type="modules" name="title" />
			</div>
			<div class="relative w-3/4 flex flex-wrap justify-end">
				<jdoc:include type="modules" name="toolbar" style="no" />
			</div>

		</header>

		<!-- Mobile Header & Nav -->
		<header x-data="{ isOpen: false }" class="w-full bg-sidebar py-5 px-6 sm:hidden">
			<div class="flex items-center justify-between">
				<a href="index.html" class="text-white text-3xl font-semibold uppercase hover:text-gray-300">Admin</a>
				<button @click="isOpen = !isOpen" class="text-white text-3xl focus:outline-none">
					<i x-show="!isOpen" class="fas fa-bars"></i>
					<i x-show="isOpen" class="fas fa-times"></i>
				</button>
			</div>

			<!-- Dropdown Nav -->
			<nav :class="isOpen ? 'flex': 'hidden'" class="flex flex-col pt-4">
				<div class="w-1/2">
					<jdoc:include type="modules" name="title" />
				</div>
				<div class="relative w-1/2 flex justify-end">
					<jdoc:include type="modules" name="toolbar" style="no" />
				</div>
			</nav>
			<!-- <button class="w-full bg-white cta-btn font-semibold py-2 mt-5 rounded-br-lg rounded-bl-lg rounded-tr-lg shadow-lg hover:shadow-xl hover:bg-gray-300 flex items-center justify-center">
                <i class="fas fa-plus mr-3"></i> New Report
            </button> -->
		</header>

		<div class="w-full overflow-x-hidden border-t flex flex-col">
			<main class="w-full flex-grow">
				<?php if ($showSubmenu) : ?>
					<jdoc:include type="modules" name="submenu" style="none" />
				<?php endif; ?>
				<jdoc:include type="message" />
				<jdoc:include type="component" />
				<?php if ($this->countModules('bottom')) : ?>
					<jdoc:include type="modules" name="bottom" style="xhtml" />
				<?php endif; ?>
			</main>
		</div>

	</div>

	<!-- AlpineJS -->
	<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
	<!-- Font Awesome -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" integrity="sha256-KzZiKy0DWYsnwMF+X1DvQngQ2/FxF7MF3Ff72XcpuPs=" crossorigin="anonymous"></script>
	<jdoc:include type="modules" name="debug" style="none" />


	<script src="http://localhost:35729/livereload.js"></script>

</body>

</html>