<?php

namespace Drupal\semi_split\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Extension\ThemeHandlerInterface;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 *
 */
class SemiSplitEntityForm extends EntityForm {

  /**
   * Theme Handler.
   *
   * @var \Drupal\Core\Extension\ThemeHandlerInterface
   */
  private $themeHandler;

  /**
   * Constructs a new class instance.
   *
   * @param \Drupal\Core\Extension\ThemeHandlerInterface $themeHandler
   *   The theme handler.
   */
  public function __construct(ThemeHandlerInterface $themeHandler) {
    $this->themeHandler = $themeHandler;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('theme_handler')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {
    $form = parent::form($form, $form_state);

    /** @var \Drupal\config_split\Entity\ConfigSplitEntityInterface $config */
    $config = $this->entity;
    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $config->label(),
      '#description' => $this->t("Label for the Configuration Semi Split setting."),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $config->id(),
      '#machine_name' => [
        'exists' => '\Drupal\semi_split\Entity\SemiSplitEntity::load',
      ],
    ];

    $form['description'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Description'),
      '#description' => $this->t('Describe this config semi split setting.'),
      '#default_value' => $config->get('description'),
    ];
    $form['folder'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Folder'),
      '#description' => $this->t('The directory, relative to the Drupal root, to which to save the filtered config. Recommended is a sibling directory of what you defined in <code>$config_directories[CONFIG_SYNC_DIRECTORY]</code> in settings.php.'),
      '#default_value' => $config->get('folder'),
    ];
    $form['weight'] = [
      '#type' => 'number',
      '#title' => $this->t('Weight'),
      '#description' => $this->t('The weight to order the semi splits.'),
      '#default_value' => $config->get('weight'),
    ];

    $module_handler = $this->moduleHandler;
    $modules = array_map(function ($module) use ($module_handler) {
      return $module_handler->getName($module->getName());
    }, $module_handler->getModuleList());
    // Add the existing ones with the machine name so they do not get lost.
    $modules = $modules + array_combine(array_keys($config->get('module')), array_keys($config->get('module')));

    // Sorting module list by name for making selection easier.
    asort($modules, SORT_NATURAL | SORT_FLAG_CASE);

    $form['module'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Modules'),
      '#description' => $this->t('Select modules to split. Configuration depending on the modules is automatically split off completely as well.'),
      '#options' => $modules,
      '#size' => 20,
      '#multiple' => TRUE,
      '#default_value' => array_keys($config->get('module')),
    ];

    // We should probably find a better way for this.
    $theme_handler = $this->themeHandler;
    $themes = array_map(function ($theme) use ($theme_handler) {
      return $theme_handler->getName($theme->getName());
    }, $theme_handler->listInfo());
    $form['theme'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Themes'),
      '#description' => $this->t('Select themes to split.'),
      '#options' => $themes,
      '#size' => 5,
      '#multiple' => TRUE,
      '#default_value' => array_keys($config->get('theme')),
    ];

    $form['#attached']['library'][] = 'semi_split/semi-split-form';

    return $form;
  }

}
