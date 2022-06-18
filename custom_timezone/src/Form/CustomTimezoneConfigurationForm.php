<?php

/**
 * @file
 * Contains Drupal\custom_timezone\Form\CustomTimezoneConfigurationForm.
 */

namespace Drupal\custom_timezone\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Class SettingsForm
 *
 * @package Drupal\custom_timezone\Form
 */

class CustomTimezoneConfigurationForm extends ConfigFormBase
{
  /**
   * {@inheritDoc}
   */
  protected function getEditableConfigNames()
  {
    return [
      'custom_timezone.settings',
    ];
  }

  /**
   * {@inheritDoc}
   */
  public function getFormId() {
   return 'custom_timezone_settings_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state)
  {
    $config = $this->config('custom_timezone.settings');

    $form['country'] = [
      '#type' => 'textfield',
      '#title' => 'Country',
      '#default_value' => $config->get('country'),
      '#required' => TURE,
    ];
    $form['city'] = [
      '#type' => 'textfield',
      '#title' => 'City',
      '#default_value' => $config->get('city'),
      '#required' => TURE,
    ];

    $options = [
      'America/Chicago' => 'America/Chicago',
      'America/New_York' => 'America/New_York',
      'Asia/Tokyo' => 'Asia/Tokyo',
      'Asia/Dubai' => 'Asia/Dubai',
      'Asia/Kolkata' => 'Asia/Kolkata',
      'Europe/Amsterdam' => 'Europe/Amsterdam',
      'Europe/Oslo' => 'Europe/Oslo',
      'Europe/London' => 'Europe/London',
    ];

    $form['time_zone'] = [
      '#type' => 'select',
      '#title' => 'Timezone',
      '#description' => 'Select timezone.',
      '#options' => $options,
      '#default_value' => $config->get('time_zone'),
      '#required' => TURE,
    ];

    return parent::buildForm($form, $form_state);
  }


  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $this->config('custom_timezone.settings')
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('time_zone', $form_state->getValue('time_zone'))
      ->save();
  }

}
