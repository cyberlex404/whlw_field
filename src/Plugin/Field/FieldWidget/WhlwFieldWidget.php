<?php

namespace Drupal\whlw_field\Plugin\Field\FieldWidget;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\WidgetBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'whlw_field_widget' widget.
 *
 * @FieldWidget(
 *   id = "whlw_field_widget",
 *   label = @Translation("Whlw field widget"),
 *   field_types = {
 *     "whlw_field"
 *   }
 * )
 */
class WhlwFieldWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      'size' => 60,
      'placeholder' => '',
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    $elements = [];

    $elements['size'] = array(
      '#type' => 'number',
      '#title' => t('Size of textfield'),
      '#default_value' => $this->getSetting('size'),
      '#required' => TRUE,
      '#min' => 1,
    );
    $elements['placeholder'] = array(
      '#type' => 'textfield',
      '#title' => t('Placeholder'),
      '#default_value' => $this->getSetting('placeholder'),
      '#description' => t('Text that will be shown inside the field until a value is entered. This hint is usually a sample value or a brief description of the expected format.'),
    );

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];

    $summary[] = t('Textfield size: !size', array('!size' => $this->getSetting('size')));
    if (!empty($this->getSetting('placeholder'))) {
      $summary[] = t('Placeholder: @placeholder', array('@placeholder' => $this->getSetting('placeholder')));
    }

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    $element = [];

    $element['width'] =  array(
      '#type' => 'number',
      '#title' => t('Width'),
      '#default_value' => isset($items[$delta]->width) ? $items[$delta]->width : NULL,
      '#size' => $this->getSetting('size'),
      '#placeholder' => $this->getSetting('placeholder'),
      '#field_suffix' => $this->getFieldSetting('wlh_units'),
      '#min' => 0,
      //'#maxlength' => $this->getFieldSetting('max_length'),
    );
    $element['length'] = array(
      '#type' => 'number',
      '#title' => t('Length'),
      '#default_value' => isset($items[$delta]->length) ? $items[$delta]->length : NULL,
      '#size' => $this->getSetting('size'),
      '#placeholder' => $this->getSetting('placeholder'),
      '#field_suffix' => $this->getFieldSetting('wlh_units'),
      '#min' => 0,
      //'#maxlength' => $this->getFieldSetting('max_length'),
    );
    $element['height'] = array(
      '#type' => 'number',
      '#title' => t('Height'),
      '#step' => 'any',
      '#default_value' => isset($items[$delta]->height) ? $items[$delta]->height : NULL,
      '#size' => $this->getSetting('size'),
      '#placeholder' => $this->getSetting('placeholder'),
      '#field_suffix' => $this->getFieldSetting('wlh_units'),
      '#min' => 0,

      //'#maxlength' => $this->getFieldSetting('max_length'),
    );
    $element['weight'] = array(
      '#type' => 'number',
      '#title' => t('Weight'),
      '#step' => 'any',
      '#default_value' => isset($items[$delta]->weight) ? $items[$delta]->weight : NULL,
      '#size' => $this->getSetting('size'),
      '#placeholder' => $this->getSetting('placeholder'),
      '#field_suffix' => $this->getFieldSetting('w_units'),
      '#min' => 0,
      //  '#maxlength' => $this->getFieldSetting('max_length'),
    );
    $element += [
      '#type' => 'fieldset',
      '#title' => t('Sizes'),
    ];

    return $element;
  }

}
