<?php

  namespace Drupal\mrmilu_twig\Twig;

  use Drupal\Component\Render\FormattableMarkup;
  use Drupal\file\Entity\File;
  use Drupal\image\Entity\ImageStyle;
  use Twig\TwigFilter;

  /**
   * Class DefaultService.
   *
   * @package Drupal\mrmilu_twig
   */
  class MrMiluImageBackground extends \Twig_Extension {

    public function getFilters() {
      $filters = [
        new TwigFilter('image_background', [$this, 'imageBackground']),
        new TwigFilter('image_src_background', [$this, 'imageSrcBackground']),
      ];

      return $filters;
    }

    /**
     * Returns the background style of this image derivative for an original image object
     *
     * @param object $image_object
     *   The original field image object.
     * @param string $size
     *   The background size
     * @param string $position
     *   The background position
     * @param string $repeat
     *   The background repeat property
     *
     * @return string
     *   The background-image
     */
    public function imageBackground($image_object, $size = "cover", $position = "center center", $repeat = "inherit") {
      if (isset($image_object['#field_name'])) {
        $default_style = self::getDefaultStyle($image_object);
        $file = self::getFile($image_object);
        if (!empty($file)) {
          $image_uri = $file->getFileUri();
          if ($default_style) {
            $args['@uri'] = \Drupal::service('file_url_generator')->transformRelative(ImageStyle::load($default_style)->buildUrl($image_uri));
          } else {
            $args['@uri'] = \Drupal::service('file_url_generator')->generateAbsoluteString($image_uri);
          }
          $args['@size'] = $size;
          $args['@position'] = $position;
          $args['@repeat'] = $repeat;
          return new FormattableMarkup("background-image: url('@uri');background-size: @size;background-position: @position;background-repeat:@repeat;", $args);
        }
      }
      return NULL;
    }

    /**
     * Returns the background style of this image derivative for an original image src
     *
     * @param object $image_src
     *   The original field image src.
     * @param string $size
     *   The background size
     * @param string $position
     *   The background position
     *
     * @return string
     *   The background-image
     */
    public function imageSrcBackground($image_src, $size = "cover", $position = "center center") {
      if (!empty($image_src)) {
        $args['@uri'] = $image_src;
        $args['@size'] = $size;
        $args['@position'] = $position;

        return new FormattableMarkup("background-image: url('@uri');background-size: @size;background-position: @position;", $args);
      }
      return NULL;
    }

    protected static function getDefaultStyle($image_object) {
      $default_style = NULL;
      switch ($image_object[0]['#theme']) {
        case 'image_formatter':
          $entity_type = $image_object["#entity_type"];
          $bundle = $image_object["#bundle"];
          $view_mode = $image_object["#view_mode"];
          $field_name = $image_object["#field_name"];
          $settings = \Drupal::service('entity_type.manager')
            ->getStorage('entity_view_display')
            ->load($entity_type . '.' . $bundle . '.' . $view_mode)
            ->getRenderer($field_name)
            ->getSettings();
          $default_style = $settings['image_style'];
          break;
        case 'media':
          $media = $image_object[0]["#media"];
          $entity_type = $media->getEntityType()->id();
          $bundle = $media->bundle();
          $view_mode = $image_object[0]["#view_mode"];
          $media_type = \Drupal\media\Entity\MediaType::load($bundle);
          $source_field_definition = $media_type->getSource()->getSourceFieldDefinition($media_type);
          $field_name = $source_field_definition->getName();
          $settings = \Drupal::service('entity_type.manager')
            ->getStorage('entity_view_display')
            ->load($entity_type . '.' . $bundle . '.' . $view_mode)
            ->getRenderer($field_name)
            ->getSettings();
          $default_style = $settings['image_style'];
          break;
      }
      return $default_style;
    }
    protected static function getFile($image_object) {
      $file = NULL;
      switch ($image_object[0]['#theme']) {
        case 'image_formatter':
          $viewBuilder = $image_object['#object'];
          $file_name = $image_object["#field_name"];
          $fid = $viewBuilder->get($file_name)->target_id;
          break;
        case 'media':
          $media = $image_object[0]["#media"];
          $fid = $media->field_media_image->target_id;
          break;
      }
      if (isset($fid)) $file = File::load($fid);
      return $file;
    }
  }
