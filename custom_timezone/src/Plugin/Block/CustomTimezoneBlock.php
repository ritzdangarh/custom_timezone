<?php

namespace Drupal\custom_timezone\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\custom_timezone\CacheContext\CustomTimeZone;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Cache\Cache;

/**
 * Provides a block with Custom timezone service.
 *
 * @Block(
 *   id = "custom_timezone_block",
 *   admin_label = @Translation("Custom Timezone Block"),
 * )
 */
class CustomTimezoneBlock extends BlockBase implements ContainerFactoryPluginInterface{
  /**
   * The timezone service.
   *
   * @var \Drupal\custom_timezone\CacheContext\CustomTimeZone
   */
  protected $customTimezone;

  /**
   * The constructor.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin ID for the plugin instance.
   * @param mixed $plugin_definition
   *   The plugin implementation definition.
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The entity type manager.
   * @param \Drupal\custom_timezone\CacheContext\CustomTimeZone $customTimezone
   *   The entity type manager.
   * @param \Drupal\Core\Cache\Cache $cache
   *   The entity type manager.
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition,  ConfigFactoryInterface $config_factory, CustomTimeZone $customTimezone) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->config = $config_factory->get('custom_timezone.settings');
    $this->customTimezone = $customTimezone;
    $this->cache = $cache;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('config.factory'),
      $container->get('cache_context.custom_timezone'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $time_zone = $this->config->get('time_zone');
    $date_time = $this->customTimezone->getDateTime();
    $country = $this->config->get('country');
    $city = $this->config->get('city');
    $output = [
      '#theme' => 'custom_time_zone_block',
      '#city' => $city,
      '#country' => $country,
      '#datetime' => $date_time,
      '#custom_timezone' =>$time_zone,
    ];
    return $output;
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return Cache::mergeContexts(
      parent::getCacheContexts(),
      ['custom_timezone']
    );
  }

}