<?php

/**
 * @file
 * Contains \Drupal\mrmilu_twig\Twig\MrImageStyle.
 */

namespace Drupal\mrmilu_twig\Twig;
use Drupal\Core\Image\ImageFactory;
use Drupal\image\Entity\ImageStyle;
use Twig\TwigFunction;

/**
 * Class DefaultService.
 *
 * @package Drupal\mrmilu_twig
 */
class MrMiluWebpImage extends \Twig_Extension {

  /**
   * @var \Drupal\Core\Image\ImageFactory
   */
  protected $imageFactory;

  public function __construct(ImageFactory $imageFactory) {
    $this->imageFactory = $imageFactory;
  }

  /**
   * {@inheritdoc}
   * This function must return the name of the extension. It must be unique.
   */
  public function getName() {
    return 'webp_image';
  }

  /**
   * In this function we can declare the extension function
   */
  public function getFunctions() {
    return array(
      new \Twig_SimpleFunction('webp_image', [$this, 'webp_image']),
    );
  }

  /**
   * The php function to load a given block
   */
  public function webp_image($image) {
    $webp = \Drupal::service('webp.webp');
    $webp_srcset = $webp->getWebpSrcset($image);

    return $webp_srcset;
  }
}