<?php

namespace Drupal\mrmilu_twig\Twig;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\taxonomy\Entity\Term;
/**
 * Class DefaultService.
 *
 * @package Drupal\mrmilu_twig
 */
class MrMiluTerm extends \Twig_Extension {

  /**
   * The entity type manager.
   *
   * @var \Drupal\Core\Entity\EntityTypeManagerInterface
   */
  protected $entityTypeManager;

  /**
   * Constructs an EntityViewBuilder object.
   */
  public function __construct(EntityTypeManagerInterface $entity_type_manager) {
    $this->entityTypeManager = $entity_type_manager;
  }

  /**
   * {@inheritdoc}
   * This function must return the name of the extension. It must be unique.
   */
  public function getName() {
    return 'mrmilu_term';
  }

  /**
   * In this function we can declare the extension function
   */
  public function getFunctions() {
    return array(
      new \Twig_SimpleFunction('mrmilu_term', [$this, 'mrmilu_term']),
    );
  }

  /**
   * The php function to render a given entity
   */
  public function mrmilu_term($id) {
    $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $term = Term::load($id);
    if ($term) {
      if ($term->hasTranslation($langcode)) {
        return $term->getTranslation($langcode)->getName();
      }
      return $term->getName();
    }

    return;
  }
}
