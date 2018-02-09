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

JHtml::_('behavior.keepalive');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');

// Load admin language file
$lang = JFactory::getLanguage();
$lang->load('com_pm_sic', JPATH_SITE);
$doc = JFactory::getDocument();
$doc->addScript(JUri::base() . '/media/com_pm_sic/js/form.js');
$doc->addStyleSheet(JUri::base() . '/media/com_pm_sic/css/form.css');
$user    = JFactory::getUser();
$canEdit = Pm_sicHelpersPm_sic::canUserEdit($this->item, $user);

$app =JFactory::getApplication('site');
$componentParams = $app->getParams('com_pm_sic');
$default_situation = $componentParams->get('default_situation');

?>

<div class="request-edit front-end-edit">
	<?php if (!$canEdit) : ?>
		<h3>
			<?php throw new Exception(JText::_('COM_PM_SIC_ERROR_MESSAGE_NOT_AUTHORISED'), 403); ?>
		</h3>
	<?php else : ?>
		<?php if (!empty($this->item->id)): ?>
			<h1><?php echo JText::sprintf('COM_PM_SIC_EDIT_ITEM_TITLE', $this->item->id); ?></h1>
		<?php else: ?>
			<h1><?php echo JText::_('COM_PM_SIC_ADD_ITEM_TITLE'); ?></h1>
		<?php endif; ?>

		<form id="form-request"
			  action="<?php echo JRoute::_('index.php?option=com_pm_sic&task=request.save'); ?>"
			  method="post" class="form-validate form-horizontal" enctype="multipart/form-data">
			
	<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />

	<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />

	<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />

	<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />

	<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->getInput('created_by'); ?>
				<?php echo $this->form->getInput('modified_by'); ?>
	<?php echo $this->form->renderField('name'); ?>



	<?php echo $this->form->renderField('cpf'); ?>

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

    <?php echo $this->form->renderField('captcha'); ?>

				<div class="fltlft" <?php if (!JFactory::getUser()->authorise('core.admin','pm_sic')): ?> style="display:none;" <?php endif; ?> >
                <?php echo JHtml::_('sliders.start', 'permissions-sliders-'.$this->item->id, array('useCookie'=>1)); ?>
                <?php echo JHtml::_('sliders.panel', JText::_('ACL Configuration'), 'access-rules'); ?>
                <fieldset class="panelform">
                    <?php echo $this->form->getLabel('rules'); ?>
                    <?php echo $this->form->getInput('rules'); ?>
                </fieldset>
                <?php echo JHtml::_('sliders.end'); ?>
            </div>
				<?php if (!JFactory::getUser()->authorise('core.admin','pm_sic')): ?>
                <script type="text/javascript">
                    jQuery.noConflict();
                    jQuery('.tab-pane select').each(function(){
                       var option_selected = jQuery(this).find(':selected');
                       var input = document.createElement("input");
                       input.setAttribute("type", "hidden");
                       input.setAttribute("name", jQuery(this).attr('name'));
                       input.setAttribute("value", option_selected.val());
                       document.getElementById("form-request").appendChild(input);
                    });
                </script>
             <?php endif; ?>
			<div class="control-group">
				<div class="controls">

					<?php if ($this->canSave): ?>

						<button type="submit" class="validate btn btn-primary">
							<?php echo JText::_('JSUBMIT'); ?>
						</button>
					<?php endif; ?>
					<a class="btn"
					   href="<?php echo JRoute::_('index.php?option=com_pm_sic&task=requestform.cancel'); ?>"
					   title="<?php echo JText::_('JCANCEL'); ?>">
						<?php echo JText::_('JCANCEL'); ?>
					</a>
				</div>
			</div>
		<input name="jform[situation]" id="jform_situation" value="<?php echo $default_situation;?>" required="required" aria-required="true" aria-invalid="true" type="hidden">
			<input type="hidden" name="option" value="com_pm_sic"/>
			<input type="hidden" name="task"
				   value="requestform.save"/>
			<?php echo JHtml::_('form.token'); ?>
		</form>
	<?php endif; ?>
</div>
