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

jimport('joomla.application.component.controllerform');

/**
 * Request controller class.
 *
 * @since  1.6
 */
class Pm_sicControllerRequest extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'requests';
		parent::__construct();
	}
}
