<?php

namespace Drupal\mrmilu_twig\Twig;

use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class DefaultService.
 *
 * @package Drupal\mrmilu_twig
 */
class MrMiluSearchResult extends AbstractExtension {

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
    return 'mrmilu_search_result';
  }

  /**
   * In this function we can declare the extension function
   */
  public function getFunctions() {
    return array(
      new TwigFunction('mrmilu_search_result', [$this, 'mrmilu_search_result']),
    );
  }

  /**
   * The php function to render a given entity
   */
  public function mrmilu_search_result($item) {
    $datasource = $item->getDatasource();
    $originalObject = $item->getOriginalObject();
    $entity = $originalObject->getEntity();

    $build = $datasource->viewItem($originalObject, 'search_result');

    CacheableMetadata::createFromRenderArray($build)
      ->merge(CacheableMetadata::createFromObject($entity))
      ->applyTo($build);
    return $build;
  }
}
