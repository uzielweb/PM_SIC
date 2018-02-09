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

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');
$lang = JFactory::getLanguage();
$lang->load('com_pm_sic', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_pm_sic/js/form.js');
$doc->addStyleSheet(JUri::base() . '/media/com_pm_sic/css/list.css');
$doc->addStyleSheet(JUri::base() . '/media/com_pm_sic/css/form.css');

$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_pm_sic') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'requestform.xml');
$canEdit    = $user->authorise('core.edit', 'com_pm_sic') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'requestform.xml');
$canCheckin = $user->authorise('core.manage', 'com_pm_sic');
$canChange  = $user->authorise('core.edit.state', 'com_pm_sic');
$canDelete  = $user->authorise('core.delete', 'com_pm_sic');

?>

<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post"
      name="adminForm" id="adminForm">

	<?php 
	echo JLayoutHelper::render('default_filter', array('view' => $this), dirname(__FILE__)); 

	?>
	
	<?php


	if ($this->state->get('filter.search') != "") : ?>
	
	
	<table class="table table-striped" id="requestList">
		<thead>
		<tr>
			<?php if (isset($this->items[0]->state) and $canChange): ?>
				<th width="5%">
	<?php echo JHtml::_('grid.sort', 'JPUBLISHED', 'a.state', $listDirn, $listOrder); ?>
</th>
			<?php endif; ?>

			<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_PM_SIC_REQUESTS_ID', 'a.id', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_PM_SIC_REQUESTS_NAME', 'a.name', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_PM_SIC_REQUESTS_SITUATION', 'a.situation', $listDirn, $listOrder); ?>
				</th>
				
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_PM_SIC_REQUESTS_ORDER', 'a.order', $listDirn, $listOrder); ?>
				</th>
				<th class=''>
				<?php echo JHtml::_('grid.sort',  'COM_PM_SIC_REQUESTS_OTHER_ORDER', 'a.other_order', $listDirn, $listOrder); ?>
				</th>


				<?php if ($canEdit || $canDelete): ?>
					<th class="center">
				<?php echo JText::_('COM_PM_SIC_REQUESTS_ACTIONS'); ?>
				</th>
				<?php endif; ?>

		</tr>
		</thead>
		<tfoot>
		<tr>
			<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
				<?php echo $this->pagination->getListFooter(); ?>
			</td>
		</tr>
		</tfoot>
		<tbody>
		<?php foreach ($this->items as $i => $item) : ?>
			<?php $canEdit = $user->authorise('core.edit', 'com_pm_sic'); ?>

							<?php if (!$canEdit && $user->authorise('core.edit.own', 'com_pm_sic')): ?>
					<?php $canEdit = JFactory::getUser()->id == $item->created_by; ?>
				<?php endif; ?>

			<tr class="row<?php echo $i % 2; ?>">

				<?php if (isset($this->items[0]->state)) : ?>
					<?php $class = ($canChange) ? 'active' : 'disabled'; ?>
				<?php if ($class == 'active') : ?>
					<td class="center">
	<a class="btn btn-micro <?php echo $class; ?>" href="<?php echo ($canChange) ? JRoute::_('index.php?option=com_pm_sic&task=request.publish&id=' . $item->id . '&state=' . (($item->state + 1) % 2), false, 2) : '#'; ?>">
	<?php if ($item->state == 1): ?>
		<i class="icon-publish"></i>
	<?php else: ?>
		<i class="icon-unpublish"></i>
	<?php endif; ?>
	</a>
</td>
					<?php endif; ?>
				<?php endif; ?>

								<td>

					<?php echo $item->id; ?>
				</td>
				<td>
				<?php if (isset($item->checked_out) && $item->checked_out) : ?>
					<?php echo JHtml::_('jgrid.checkedout', $i, $item->uEditor, $item->checked_out_time, 'requests.', $canCheckin); ?>
				<?php endif; ?>
				<a href="<?php echo JRoute::_('index.php?option=com_pm_sic&view=request&id='.(int) $item->id); ?>">
				<?php echo $this->escape($item->name); ?></a>
				</td>
				<td>

					<?php echo $item->situation; ?>
				</td>
				
				<td>

					<?php echo $item->order; ?>
				</td>
				<td>

					<?php echo $item->other_order; ?>
				</td>


								<?php if ($canEdit || $canDelete): ?>
					<td class="center">
						<?php if ($canEdit): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_pm_sic&task=requestform.edit&id=' . $item->id, false, 2); ?>" class="btn btn-mini" type="button"><i class="icon-edit" ></i></a>
						<?php endif; ?>
						<?php if ($canDelete): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_pm_sic&task=requestform.remove&id=' . $item->id, false, 2); ?>" class="btn btn-mini delete-button" type="button"><i class="icon-trash" ></i></a>
						<?php endif; ?>
					</td>
				<?php endif; ?>

			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
<?php endif;?>
	<?php if ($canCreate and $canDelete) : ?>
		<a href="<?php echo JRoute::_('index.php?option=com_pm_sic&task=requestform.edit&id=0', false, 0); ?>"
		   class="btn btn-success btn-small"><i
				class="icon-plus"></i>
			<?php echo JText::_('COM_PM_SIC_ADD_ITEM'); ?></a>
	<?php endif; ?>

	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
</form>

<?php if($canDelete) : ?>
<script type="text/javascript">

	jQuery(document).ready(function () {
		jQuery('.delete-button').click(deleteItem);
	});

	function deleteItem() {

		if (!confirm("<?php echo JText::_('COM_PM_SIC_DELETE_MESSAGE'); ?>")) {
			return false;
		}
	}
</script>
<?php endif; ?>
