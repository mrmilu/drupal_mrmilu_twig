<?php

namespace Drupal\mrmilu_twig\Twig;

use Drupal\Core\Render\RendererInterface;
use Twig\TwigFunction;
use Twig\Extension\AbstractExtension;

/**
 * Class DefaultService.
 *
 * @package Drupal\mrmilu_twig
 */
class MrMiluPictureWebp extends AbstractExtension {

  /**
   * @var RendererInterface
   */
  private $renderer;

  public function __construct(RendererInterface $renderer) {
    $this->renderer = $renderer;
  }

  /**
   * {@inheritdoc}
   * This function must return the name of the extension. It must be unique.
   */
  public function getName() {
    return 'mrmilu_picture_webp';
  }

  /**
   * In this function we can declare the extension function
   */
  public function getFunctions() {
    return array(
      new TwigFunction('mrmilu_picture_webp', [$this, 'mrmilu_picture_webp']),
    );
  }

  /**
   * The php function to load a given block
   * @throws \Exception
   */
  public function mrmilu_picture_webp($uri, $image_style) {
    $responsiveImage = [
      '#theme' => 'responsive_image',
      '#responsive_image_style_id' => $image_style,
      '#uri' => $uri,
    ];

    return $this->renderer->render($responsiveImage);
  }
}
