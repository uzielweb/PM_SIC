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

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_pm_sic.' . $this->item->id);

if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_pm_sic' . $this->item->id))
{
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>

<div class="item_fields">

	<table class="table">
		

		<tr>
			<th><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_NAME'); ?></th>
			<td><?php echo $this->item->name; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_SITUATION'); ?></th>
			<td><?php echo $this->item->situation; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_CPF'); ?></th>
			<td><?php echo $this->item->cpf; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_RG'); ?></th>
			<td><?php echo $this->item->rg; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_TELEPHONE'); ?></th>
			<td><?php echo $this->item->telephone; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_EMAIL'); ?></th>
			<td><?php echo $this->item->email; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_CEP'); ?></th>
			<td><?php echo $this->item->cep; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_ADDRESS'); ?></th>
			<td><?php echo $this->item->address; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_COMPLEMENT'); ?></th>
			<td><?php echo $this->item->complement; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_NEIGHBORHOOD'); ?></th>
			<td><?php echo $this->item->neighborhood; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_CITY'); ?></th>
			<td><?php echo $this->item->city; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_COUNTRY_STATE'); ?></th>
			<td><?php echo $this->item->country_state; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_ORDER'); ?></th>
			<td><?php echo $this->item->order; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_OTHER_ORDER'); ?></th>
			<td><?php if( $this->item->order == outras_nao_especificadas_anteriormente ) echo $this->item->other_order; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_INFORMATIONS'); ?></th>
			<td><?php echo nl2br($this->item->informations); ?></td>
		</tr>

	</table>

</div>

<?php if($canEdit && $this->item->checked_out == 0): ?>

	<a class="btn" href="<?php echo JRoute::_('index.php?option=com_pm_sic&task=request.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_PM_SIC_EDIT_ITEM"); ?></a>

<?php endif; ?>

<?php if (JFactory::getUser()->authorise('core.delete','com_pm_sic.request.'.$this->item->id)) : ?>

	<a class="btn btn-danger" href="#deleteModal" role="button" data-toggle="modal">
		<?php echo JText::_("COM_PM_SIC_DELETE_ITEM"); ?>
	</a>

	<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3><?php echo JText::_('COM_PM_SIC_DELETE_ITEM'); ?></h3>
		</div>
		<div class="modal-body">
			<p><?php echo JText::sprintf('COM_PM_SIC_DELETE_CONFIRM', $this->item->id); ?></p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal">Close</button>
			<a href="<?php echo JRoute::_('index.php?option=com_pm_sic&task=request.remove&id=' . $this->item->id, false, 2); ?>" class="btn btn-danger">
				<?php echo JText::_('COM_PM_SIC_DELETE_ITEM'); ?>
			</a>
		</div>
	</div>

<?php endif; ?>