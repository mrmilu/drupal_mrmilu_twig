<?php

namespace Drupal\mrmilu_twig\Twig;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Twig\TwigFunction;

/**
 * Class DefaultService.
 *
 * @package Drupal\mrmilu_twig
 */
class MrMiluRenderEntity extends \Twig_Extension {

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
    return 'mrmilu_render_entity';
  }

  /**
   * In this function we can declare the extension function
   */
  public function getFunctions() {
    return array(
      new TwigFunction('mrmilu_render_entity', [$this, 'mrmilu_render_entity']),
    );
  }

  /**
   * The php function to render a given entity
   */
  public function mrmilu_render_entity($entityId, $entityType, $displayMode) {
    $langcode = \Drupal::languageManager()->getCurrentLanguage()->getId();
    $entity = \Drupal::entityTypeManager()->getStorage($entityType)->load($entityId);

    if ($entity) {
      $build = $this->entityTypeManager
        ->getViewBuilder($entityType)
        ->view($entity, $displayMode, $langcode);

      CacheableMetadata::createFromRenderArray($build)
        ->merge(CacheableMetadata::createFromObject($entity))
        ->applyTo($build);
      return $build;
    }
    return NULL;
  }
}
