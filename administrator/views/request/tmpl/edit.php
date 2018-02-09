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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_pm_sic/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	js('input:hidden.situation').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('situationhidden')){
			js('#jform_situation option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_situation").trigger("liszt:updated");
	});

	Joomla.submitbutton = function (task) {
		if (task == 'request.cancel') {
			Joomla.submitform(task, document.getElementById('request-form'));
		}
		else {
			
			if (task != 'request.cancel' && document.formvalidator.isValid(document.id('request-form'))) {
				
				Joomla.submitform(task, document.getElementById('request-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_pm_sic&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="request-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_PM_SIC_TITLE_REQUEST', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

									<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->renderField('created_by'); ?>
				<?php echo $this->form->renderField('modified_by'); ?>				<?php echo $this->form->renderField('name'); ?>
				<?php echo $this->form->renderField('situation'); ?>

			<?php
				foreach((array)$this->item->situation as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="situation" name="jform[situationhidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<?php echo $this->form->renderField('cpf'); ?>
				<?php echo $this->form->renderField('rg'); ?>
				<?php echo $this->form->renderField('telephone'); ?>
				<?php echo $this->form->renderField('email'); ?>
				<?php echo $this->form->renderField('cep'); ?>
				<?php echo $this->form->renderField('address'); ?>
				<?php echo $this->form->renderField('complement'); ?>
				<?php echo $this->form->renderField('neighborhood'); ?>
				<?php echo $this->form->renderField('city'); ?>
				<?php echo $this->form->renderField('country_state'); ?>
				<?php echo $this->form->renderField('order'); ?>
				<?php echo $this->form->renderField('other_order'); ?>
				<?php echo $this->form->renderField('informations'); ?>


					<?php if ($this->state->params->get('save_history', 1)) : ?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('version_note'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('version_note'); ?></div>
					</div>
					<?php endif; ?>
				</fieldset>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		<?php if (JFactory::getUser()->authorise('core.admin','pm_sic')) : ?>
	<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'permissions', JText::_('JGLOBAL_ACTION_PERMISSIONS_LABEL', true)); ?>
		<?php echo $this->form->getInput('rules'); ?>
	<?php echo JHtml::_('bootstrap.endTab'); ?>
<?php endif; ?>

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

		<input type="hidden" name="task" value=""/>
		<?php echo JHtml::_('form.token'); ?>

	</div>
</form>
