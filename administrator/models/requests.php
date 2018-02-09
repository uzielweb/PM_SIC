<?php

/**
 * @version    CVS: 1.0.1
 * @package    Com_Pm_sic
 * @author     Ponto Mega <contato@pontomega.com.br>
 * @copyright  2018 Ponto Mega
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Pm_sic records.
 *
 * @since  1.6
 */
class Pm_sicModelRequests extends JModelList
{
/**
	* Constructor.
	*
	* @param   array  $config  An optional associative array of configuration settings.
	*
	* @see        JController
	* @since      1.6
	*/
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.`id`',
				'ordering', 'a.`ordering`',
				'state', 'a.`state`',
				'created_by', 'a.`created_by`',
				'modified_by', 'a.`modified_by`',
				'name', 'a.`name`',
				'situation', 'a.`situation`',
				'cpf', 'a.`cpf`',
				'rg', 'a.`rg`',
				'telephone', 'a.`telephone`',
				'email', 'a.`email`',
				'cep', 'a.`cep`',
				'address', 'a.`address`',
				'complement', 'a.`complement`',
				'neighborhood', 'a.`neighborhood`',
				'city', 'a.`city`',
				'country_state', 'a.`country_state`',
				'order', 'a.`order`',
				'other_order', 'a.`other_order`',
				'informations', 'a.`informations`',
			);
		}

		parent::__construct($config);
	}

	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   Elements order
	 * @param   string  $direction  Order direction
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $published);
		// Filtering situation
		$this->setState('filter.situation', $app->getUserStateFromRequest($this->context.'.filter.situation', 'filter_situation', '', 'string'));

		// Filtering order
		$this->setState('filter.order', $app->getUserStateFromRequest($this->context.'.filter.order', 'filter_order', '', 'string'));


		// Load the parameters.
		$params = JComponentHelper::getParams('com_pm_sic');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.name', 'asc');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param   string  $id  A prefix for the store id.
	 *
	 * @return   string A store id.
	 *
	 * @since    1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.state');

		return parent::getStoreId($id);
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return   JDatabaseQuery
	 *
	 * @since    1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select', 'DISTINCT a.*'
			)
		);
		$query->from('`#__pm_sic` AS a');

		// Join over the users for the checked out user
		$query->select("uc.name AS uEditor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");

		// Join over the user field 'created_by'
		$query->select('`created_by`.name AS `created_by`');
		$query->join('LEFT', '#__users AS `created_by` ON `created_by`.id = a.`created_by`');

		// Join over the user field 'modified_by'
		$query->select('`modified_by`.name AS `modified_by`');
		$query->join('LEFT', '#__users AS `modified_by` ON `modified_by`.id = a.`modified_by`');

		// Filter by published state
		$published = $this->getState('filter.state');

		if (is_numeric($published))
		{
			$query->where('a.state = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.state IN (0, 1))');
		}

		// Filter by search in title
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%' . $db->escape($search, true) . '%');
				$query->where('( a.name LIKE ' . $search . '  OR  a.situation LIKE ' . $search . '  OR  a.cpf LIKE ' . $search . '  OR  a.rg LIKE ' . $search . '  OR  a.telephone LIKE ' . $search . '  OR  a.email LIKE ' . $search . '  OR  a.cep LIKE ' . $search . '  OR  a.city LIKE ' . $search . '  OR  a.order LIKE ' . $search . '  OR  a.other_order LIKE ' . $search . ' )');
			}
		}


		// Filtering situation
		$filter_situation = $this->state->get("filter.situation");

		if ($filter_situation !== null && !empty($filter_situation))
		{
			$query->where("a.`situation` = '".$db->escape($filter_situation)."'");
		}

		// Filtering order
		$filter_order = $this->state->get("filter.order");

		if ($filter_order !== null && (is_numeric($filter_order) || !empty($filter_order)))
		{
			$query->where('FIND_IN_SET(' . $db->quote($filter_order) . ', ' . $db->quoteName('a.order') . ')');
		}
		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');

		if ($orderCol && $orderDirn)
		{
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		return $query;
	}

	/**
	 * Get an array of data items
	 *
	 * @return mixed Array of data items on success, false on failure.
	 */
	public function getItems()
	{
		$items = parent::getItems();

		foreach ($items as $oneItem)
		{

			if (isset($oneItem->situation))
			{
				$db    = JFactory::getDbo();
				$query = $db->getQuery(true);

				$query
					->select($db->quoteName('title'))
					->from($db->quoteName('#__categories'))
					->where('FIND_IN_SET(' . $db->quoteName('id') . ', ' . $db->quote($oneItem->situation) . ')');

				$db->setQuery($query);
				$result = $db->loadColumn();

				$oneItem->situation = !empty($result) ? implode(', ', $result) : '';
			}

			// Get the title of every option selected.

			$options      = explode(',', $oneItem->order);

			$options_text = array();

			foreach ((array) $options as $option)
			{
				$options_text[] = JText::_('COM_PM_SIC_REQUESTS_ORDER_OPTION_' . strtoupper($option));
			}

			$oneItem->order = !empty($options_text) ? implode(', ', $options_text) : $oneItem->order;
		}

		return $items;
	}
}
