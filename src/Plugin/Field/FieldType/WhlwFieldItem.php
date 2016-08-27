<?php

namespace Drupal\whlw_field\Plugin\Field\FieldType;

use Drupal\Component\Utility\Random;
use Drupal\Core\Field\FieldDefinitionInterface;
use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\TypedData\DataDefinition;

/**
 * Plugin implementation of the 'whlw_field' field type.
 *
 * @FieldType(
 *   id = "whlw_field",
 *   label = @Translation("WHLW field"),
 *   description = @Translation("WHLW Field Type"),
 *   default_widget = "whlw_field_widget",
 *   default_formatter = "whlw_field_formatter"
 * )
 */
class WhlwFieldItem extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  /*
  public static function defaultStorageSettings() {
    return array(
      'max_length' => 255,
      'is_ascii' => FALSE,
      'case_sensitive' => FALSE,
    ) + parent::defaultStorageSettings();
  }
*/

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings() {
    return array(
      'wlh_units' => 'mm',
      'w_units' => 'kg',
    ) + parent::defaultFieldSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    $element = array();
    $settings = $this->getSettings();

    $elements['wlh_units'] = array(
      '#type' => 'select',
      '#title' => t('WLH units'),
      '#options' => array('mm' => t('mm.'), 'sm' => t('sm.')),
      '#default_value' => $this->getSetting('wlh_units'),
      '#description' => t('Width , Length and Height units'),
      '#weight' => 1,
    );
    $elements['w_units'] = array(
      '#type' => 'select',
      '#title' => t('Weight units'),
      '#options' => array('kg' => t('kg.'), 'gr' => t('gr.')),
      '#default_value' => $this->getSetting('w_units'),
      '#description' => t('Weight units'),
      '#weight' => 2,
    );

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // Prevent early t() calls by using the TranslatableMarkup.
    $properties['width'] = DataDefinition::create('float')
      ->setLabel(t('Float width'))
      ->setRequired(TRUE);

    $properties['height'] = DataDefinition::create('float')
      ->setLabel(t('Float height'))
      ->setRequired(TRUE);

    $properties['length'] = DataDefinition::create('float')
      ->setLabel(t('Float length'))
      ->setRequired(TRUE);

    $properties['weight'] = DataDefinition::create('float')
      ->setLabel(t('Float weight'))
      ->setRequired(TRUE);

    return $properties;
  }

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    $schema = array(
      'columns' => array(
        'width' => array(
          'type' => 'float',
        ),
        'length' => array(
          'type' => 'float',
        ),
        'height' => array(
          'type' => 'float',
        ),
        'weight' => array(
          'type' => 'float',
        ),
      ),
    );

    return $schema;
  }

  /**
   * {@inheritdoc}
   */
  /*
  public function getConstraints() {
    $constraints = parent::getConstraints();

    if ($max_length = $this->getSetting('max_length')) {
      $constraint_manager = \Drupal::typedDataManager()->getValidationConstraintManager();
      $constraints[] = $constraint_manager->create('ComplexData', array(
        'value' => array(
          'Length' => array(
            'max' => $max_length,
            'maxMessage' => t('%name: may not be longer than @max characters.', array(
              '%name' => $this->getFieldDefinition()->getLabel(),
              '@max' => $max_length
            )),
          ),
        ),
      ));
    }

    return $constraints;
  }
*/
  /**
   * {@inheritdoc}
   */
  public static function generateSampleValue(FieldDefinitionInterface $field_definition) {
    $random = new Random();
    $values['width'] = 1.0;// $random->float(mt_rand(1, $field_definition->getSetting('max_length')));
    return $values;
  }

  /**
   * {@inheritdoc}
   */
 /*public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
    $elements = [];

    $elements['max_length'] = array(
      '#type' => 'number',
      '#title' => t('Maximum length'),
      '#default_value' => $this->getSetting('max_length'),
      '#required' => TRUE,
      '#description' => t('The maximum length of the field in characters.'),
      '#min' => 1,
      '#disabled' => $has_data,
    );

    return $elements;
  }
*/
  /**
   * {@inheritdoc}
   */
  public function isEmpty() {
    $value = $this->get('width')->getValue();
    return $value === NULL || $value === '';
  }

}
