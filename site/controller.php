<?php

/**
 * @version    CVS: 1.0.1
 * @package    Com_Pm_sic
 * @author     Ponto Mega <contato@pontomega.com.br>
 * @copyright  2018 Ponto Mega
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controller');

/**
 * Class Pm_sicController
 *
 * @since  1.6
 */
class Pm_sicController extends JControllerLegacy
{
	/**
	 * Method to display a view.
	 *
	 * @param   boolean $cachable  If true, the view output will be cached
	 * @param   mixed   $urlparams An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController   This object to support chaining.
	 *
	 * @since    1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
        $app  = JFactory::getApplication();
        $view = $app->input->getCmd('view', 'requests');
		$app->input->set('view', $view);

		parent::display($cachable, $urlparams);

		return $this;
	}
}
