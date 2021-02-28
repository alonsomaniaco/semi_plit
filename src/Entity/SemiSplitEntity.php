<?php

namespace Drupal\semi_split\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;

/**
 * Define semi split entity.
 *
 * @ConfigEntityType(
 *   id = "semi_split",
 *   label = @Translation("Configuration semi split config"),
 *   handlers = {
 *     "route_provider" = {
 *         "html" = "Drupal\semi_split\Routing\SemiSplitHtmlRouteProvider",
 *       },
 *     "list_builder" = "Drupal\semi_split\Entity\SemiSplitListBuilder",
 *     "form" = {
 *       "add" = "Drupal\semi_split\Form\SemiSplitEntityForm",
 *       "edit" = "Drupal\semi_split\Form\SemiSplitEntityForm",
 *       "delete" = "Drupal\semi_split\Form\SemiSplitDeleteEntityForm",
 *     }
 *   },
 *   config_prefix = "config_split",
 *   admin_permission = "administer configuration split",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/config/development/configuration/semi-split/add",
 *     "edit-form" = "/admin/config/development/configuration/semi-split/{config_split}/edit",
 *     "delete-form" = "/admin/config/development/configuration/semi-split/{config_split}/delete",
 *     "collection" = "/admin/config/development/configuration/semi-split",
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "description",
 *     "folder",
 *     "module",
 *     "theme",
 *   }
 * )
 */
class SemiSplitEntity extends ConfigEntityBase implements SemiSplitInterface {

  /**
   * The Configuration Split setting ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The Configuration Split setting label.
   *
   * @var string
   */
  protected $label;

  /**
   * The Configuration Split setting description.
   *
   * @var string
   */
  protected $description = '';

  /**
   * The folder to export to.
   *
   * @var string
   */
  protected $folder = '';

  /**
   * The modules to split.
   *
   * @var array
   */
  protected $module = [];

  /**
   * The themes to split.
   *
   * @var array
   */
  protected $theme = [];

}
