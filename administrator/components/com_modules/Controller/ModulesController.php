<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_modules
 *
 * @copyright   Copyright (C) 2005 - 2019 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

namespace Joomla\Component\Modules\Administrator\Controller;

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;
use Joomla\CMS\MVC\Controller\AdminController;
use Joomla\CMS\Response\JsonResponse;
use Joomla\Utilities\ArrayHelper;

/**
 * Modules list controller class.
 *
 * @since  1.6
 */
class ModulesController extends AdminController
{
	/**
	 * Method to clone an existing module.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public function duplicate()
	{
		// Check for request forgeries
		$this->checkToken();

		$pks = $this->input->post->get('cid', array(), 'array');
		$pks = ArrayHelper::toInteger($pks);

		try
		{
			if (empty($pks))
			{
				throw new \Exception(Text::_('COM_MODULES_ERROR_NO_MODULES_SELECTED'));
			}

			$model = $this->getModel();
			$model->duplicate($pks);
			$this->setMessage(Text::plural('COM_MODULES_N_MODULES_DUPLICATED', count($pks)));
		}
		catch (\Exception $e)
		{
			$this->app->enqueueMessage($e->getMessage(), 'warning');
		}

		$this->setRedirect('index.php?option=com_modules&view=modules');
	}

	/**
	 * Method to get a model object, loading it if required.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  object  The model.
	 *
	 * @since   1.6
	 */
	public function getModel($name = 'Module', $prefix = 'Administrator', $config = array('ignore_request' => true))
	{
		return parent::getModel($name, $prefix, $config);
	}
			
	/**
	 * Method to get the number of frontend modules
	 * 
	 * @return  integer  The amount of modules
	 *
	 * @since   4.0
	 */
	public function quickiconAmount()
	{
		$model = $this->getModel('Modules');

		$model->setState('list.start', 0);
		$model->setState('list.limit', 0);
		$model->setState('filter.published', 1);
		$model->setState('filter.client_id', 0);

		echo new JsonResponse(count($model->getItems()));
	}
}
