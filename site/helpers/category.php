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
/**
 * Content Component Category Tree
 *
 * @since  1.6
 */
class Pm_sicCategories extends JCategories
{
    /**
     * Class constructor
     *
     * @param   array  $options  Array of options
     *
     * @since   11.1
     */
    public function __construct($options = array())
    {
        $options['table'] = '#__pm_sic';
        $options['extension'] = 'com_pm_sic';

        parent::__construct($options);
    }
}
