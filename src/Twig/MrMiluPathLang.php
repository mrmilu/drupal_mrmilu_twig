<?php

namespace Drupal\mrmilu_twig\Twig;
use Drupal\Core\Url;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class DefaultService.
 *
 * @package Drupal\mrmilu_twig
 */
class MrMiluPathLang extends AbstractExtension {

  /**
   * {@inheritdoc}
   * This function must return the name of the extension. It must be unique.
   */
  public function getName() {
    return 'mrmilu_path_lang';
  }

  /**
   * In this function we can declare the extension function
   */
  public function getFunctions() {
    return array(
      new TwigFunction('mrmilu_path_lang', [$this, 'mrmilu_path_lang']),
    );
  }

  /**
   * The php function to load a given block
   */
  public function mrmilu_path_lang($name, $parameters, $options, $langcode) {
    if ($langcode) {
      if ($language = \Drupal::languageManager()->getLanguage($langcode)) {
        $options['language'] = $language;
      }
    }
    return Url::fromRoute($name, $parameters, $options)->toString();
  }
}
