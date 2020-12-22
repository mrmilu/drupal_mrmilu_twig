<?php

/**
 * @file
 * Contains \Drupal\mrmilu_twig\Twig\MrImageStyle.
 */

namespace Drupal\mrmilu_twig\Twig;
use Drupal\Core\Image\ImageFactory;
use Drupal\image\Entity\ImageStyle;

/**
 * Class DefaultService.
 *
 * @package Drupal\mrmilu_twig
 */
class MrMiluImageStyle extends \Twig_Extension {

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
    return 'mrmilu_image_style';
  }

  /**
   * In this function we can declare the extension function
   */
  public function getFunctions() {
    return array(
      new \Twig_SimpleFunction('mrmilu_image_style', [$this, 'mrmilu_image_style']),
    );
  }

  /**
   * The php function to load a given block
   */
  public function mrmilu_image_style($uri, $image_style) {
    $image = $this->imageFactory->get($uri);
    if ($image->isValid()) {
      $url = ImageStyle::load($image_style)->buildUrl($uri);
      return file_url_transform_relative($url);
    }
    else return file_create_url($uri);
  }
}
