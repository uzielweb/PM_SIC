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
$lang = JFactory::getLanguage();
$lang->load('com_pm_sic', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_pm_sic/js/form.js');
$doc->addStyleSheet(JUri::base() . '/media/com_pm_sic/css/item.css');
$doc->addStyleSheet(JUri::base() . '/media/com_pm_sic/css/form.css');
$canEdit = JFactory::getUser()->authorise('core.edit', 'com_pm_sic.' . $this->item->id);

if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_pm_sic' . $this->item->id))
{
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>

	<div class="item_fields">

		<h2>
			<?php echo $this->item->name; ?>
		</h2>
		<p>
			<span class="pm-sic-situation pm-sic-label"><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_SITUATION'); ?></span>
			<span class="pm-sic-situation pm-sic-value"><?php echo $this->item->situation; ?></span>
		</p>
		<p>
			<span class="pm-sic-city pm-sic-label"><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_CITY'); ?></span>
			<span class="pm-sic-city pm-sic-label"><?php echo $this->item->city; ?></span>
		</p>

		<p>
			<span class="pm-sic-country-state pm-sic-label"><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_COUNTRY_STATE'); ?></span>
			<span class="pm-sic-country-state pm-sic-label"><?php echo $this->item->country_state; ?></span>
		</p>

		<p>
			<span class="pm-sic-order pm-sic-label"><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_ORDER'); ?></span>
			<span class="pm-sic-order pm-sic-label"><?php echo $this->item->order; ?></span>
		</p>
<?php if( $this->item->order == outras_nao_especificadas_anteriormente ) : ?>
		<p>
			<span class="pm-sic-other pm-sic-label"><?php echo JText::_('COM_PM_SIC_FORM_LBL_REQUEST_OTHER_ORDER'); ?></span>
			<span class="pm-sic-other pm-sic-label"><?php if( $this->item->order == outras_nao_especificadas_anteriormente ) echo $this->item->other_order; ?></span>
		</p>
<?php endif;?>



	</div>

	<?php if($canEdit && $this->item->checked_out == 0): ?>

	<a class="btn" href="<?php echo JRoute::_('index.php?option=com_pm_sic&task=request.edit&id='.$this->item->id); ?>">
		<?php echo JText::_("COM_PM_SIC_EDIT_ITEM"); ?>
	</a>

	<?php endif; ?>

	<?php if (JFactory::getUser()->authorise('core.delete','com_pm_sic.request.'.$this->item->id)) : ?>

	<a class="btn btn-danger" href="#deleteModal" role="button" data-toggle="modal">
		<?php echo JText::_("COM_PM_SIC_DELETE_ITEM"); ?>
	</a>

	<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>
				<?php echo JText::_('COM_PM_SIC_DELETE_ITEM'); ?>
			</h3>
		</div>
		<div class="modal-body">
			<p>
				<?php echo JText::sprintf('COM_PM_SIC_DELETE_CONFIRM', $this->item->id); ?>
			</p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal">Close</button>
			<a href="<?php echo JRoute::_('index.php?option=com_pm_sic&task=request.remove&id=' . $this->item->id, false, 2); ?>" class="btn btn-danger">
				<?php echo JText::_('COM_PM_SIC_DELETE_ITEM'); ?>
			</a>
		</div>
	</div>

	<?php endif; ?>