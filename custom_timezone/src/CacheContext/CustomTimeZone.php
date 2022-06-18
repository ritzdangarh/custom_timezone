<?php

namespace Drupal\custom_timezone\CacheContext;

use Drupal\Core\Cache\Context\CacheContextInterface;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Cache\CacheableMetadata;

class CustomTimeZone implements CacheContextInterface {
  /**
   * @var \Drupal\Core\Session\AccountProxyInterface
   */
	protected $config;

  /**
  * {@inheritdoc}
  */
	public function __construct(ConfigFactoryInterface $config_factory) {
		$this->config = $config_factory->get('custom_timezone.settings');
	}

  /**
   * Returns datetime for specific timezone.
   *
   * @return string
   */
  public function getDateTime() {
    $date = new \DateTime("now", new \DateTimeZone($this->config->get('time_zone')) );
    return $date->format('dS M Y - h:i a'); //25th Oct 2019 - 10:30 PM
  }

  /**
  * {@inheritdoc}
  */
	public static function getLabel() {
		return t('Config Timezone cache context');
	}

  /**
  * {@inheritdoc}
  */
	public function getContext() {
    $custom_time_zone = $this->config->get('time_zone');
    return $custom_time_zone;
	}

  /**
  * {@inheritdoc}
  */
  public function getCacheableMetadata() {
    return new CacheableMetadata();
  }
}
