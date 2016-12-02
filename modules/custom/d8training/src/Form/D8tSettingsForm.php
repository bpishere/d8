<?php
namespace Drupal\d8training\Form;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Form\ConfigFormBase;


class D8tSettingsForm extends ConfigFormBase
{
  protected function getEditableConfigNames()
  {
    // TODO: Implement getEditableConfigNames() method.
    return ['d8training.config'];
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId()
  {
    return 'd8t_admin_setting_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $config = $this->config('d8training.config');

    //$elements = drupal_map_assoc(array('pre', 'code'));

    $form['app_id'] = array(
        '#type' => 'textfield',
        '#title' => $this->t('App ID'),
        '#default_value' => $config->get('app_id'),
    );

    return parent::buildForm($form, $form_state);
  }


  /**
   * Form submission handler.
   *
   * @param array $form
   * An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   * The current state of the form.
   */
  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    $this->config('d8training.config')
        ->set('app_id', $form_state->getValue('app_id'))
        ->save();
    parent::submitForm($form, $form_state);
  }

}
