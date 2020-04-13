<?php

/**
 * @file
 * Contains \Drupal\mrmilu_twig\Twig\MrBlockExtension.
 */

namespace Drupal\mrmilu_twig\Twig;

use Drupal\Core\Block\BlockManager;

/**
 * Class DefaultService.
 *
 * @package Drupal\mrmilu_twig
 */
class MrMiluRenderPlugin extends \Twig_Extension {

  /**
   * @var \Drupal\Core\Block\BlockManager
   */
  protected $blockManager;

  public function __construct(BlockManager $blockManager) {
    $this->blockManager = $blockManager;
  }

  /**
   * {@inheritdoc}
   * This function must return the name of the extension. It must be unique.
   */
  public function getName() {
    return 'mrmilu_render_plugin';
  }

  /**
   * In this function we can declare the extension function
   */
  public function getFunctions() {
    return array(
      new \Twig_SimpleFunction('mrmilu_render_plugin', array($this, 'mrmilu_render_plugin'), array(
        'is_safe' => array('html'),
      )),
    );
  }

  /**
   * The php function to load a given block
   */
  public function mrmilu_render_plugin($plugin_id) {
    $config = [];// You can hard code configuration or you load from settings.
    $plugin_block = $this->blockManager->createInstance($plugin_id, $config);
    $render = $plugin_block->build();
    return $render;
  }
}
