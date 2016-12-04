<?php

namespace Drupal\d8training\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\d8training\OpenWeatherForecaster;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a 'WeatherBlock' block.
 *
 * @Block(
 *   id = "weather_block",
 *   admin_label = @Translation("Weather Block")
 * )
 */
class WeatherBlock extends BlockBase implements ContainerFactoryPluginInterface
{
  private $WeatherData;

  public function __construct(array $configuration, $plugin_id, $plugin_definition, OpenWeatherForecaster $WeatherData)
  {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->WeatherData = $WeatherData;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
  {
    return new static($configuration, $plugin_id, $plugin_definition, $container->get('d8training.open_weather_forecaster')

    );
  }

  public function build()
  {
    $configuration = $this->getConfiguration();
    $city_name = $configuration['city_name'];
    $weather_data = $this->WeatherData->fetchWeatherData($city_name);
    //dsm($weather_data); exit;
    /*return array(
        '#theme' => 'test_twig',
        '#test_var' => $this->t('Test Value'),
        '#attached' => [
          'library' => ['d8training/weather_widget']
       ]
    );*/
    return array(
        '#type' => 'markup',
        '#markup' => $city_name,

      //'#attach' =>
    );
  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration()
  {
    return array(
        'city_name' => $this->t('A City default value. This block was created at %time', array('%time' => date('c'))),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state)
  {

    $form['city_name'] = array(
        '#type' => 'textfield',
        '#title' => t('City'),
        '#required' => TRUE,
        '#default_value' => $this->configuration['city_name']
      // '#default_value' => $this->getConfiguration('city_name')
    );

    $form['submit'] = array(
        '#type' => 'submit',
        '#value' => t('Submit'),
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state)
  {
    $this->configuration['city_name'] = $form_state->getValue('city_name');
  }
}