<?php
/**
 * @version    CVS: 1.0.1
 * @package    Com_Pm_sic
 * @author     Ponto Mega <contato@pontomega.com.br>
 * @copyright  2018 Ponto Mega
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Pm_sic', JPATH_COMPONENT);
JLoader::register('Pm_sicController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Pm_sic');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
