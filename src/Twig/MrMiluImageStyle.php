<?php

/**
 * @file
 * Contains \Drupal\mrmilu_twig\Twig\MrImageStyle.
 */

namespace Drupal\mrmilu_twig\Twig;
use Drupal\Core\File\FileUrlGeneratorInterface;
use Drupal\Core\Image\ImageFactory;
use Drupal\image\Entity\ImageStyle;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class DefaultService.
 *
 * @package Drupal\mrmilu_twig
 */
class MrMiluImageStyle extends AbstractExtension {

  protected ImageFactory $imageFactory;
  protected FileUrlGeneratorInterface $fileUrlGenerator;

  public function __construct(ImageFactory $imageFactory, FileUrlGeneratorInterface $fileUrlGenerator) {
    $this->imageFactory = $imageFactory;
    $this->fileUrlGenerator = $fileUrlGenerator;
  }

  /**
   * {@inheritdoc}
   * This function must return the name of the extension. It must be unique.
   */
  public function getName(): string {
    return 'mrmilu_image_style';
  }

  /**
   * In this function we can declare the extension function
   */
  public function getFunctions(): array {
    return [
      new TwigFunction('mrmilu_image_style', [$this, 'mrmilu_image_style']),
    ];
  }

  /**
   * The php function to load a given block
   */
  public function mrmilu_image_style($uri, $image_style): string {
    $image = $this->imageFactory->get($uri);
    if (!$image->isValid()) {
      return $this->fileUrlGenerator->generateAbsoluteString($uri);
    }
    $url = ImageStyle::load($image_style)->buildUrl($uri);
    return $this->fileUrlGenerator->generateString($url);
  }
}
