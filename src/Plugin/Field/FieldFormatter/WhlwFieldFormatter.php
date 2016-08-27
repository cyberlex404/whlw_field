<?php

namespace Drupal\whlw_field\Plugin\Field\FieldFormatter;

use Drupal\Component\Utility\Html;
use Drupal\Core\Field\FieldItemInterface;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Plugin implementation of the 'whlw_field_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "whlw_field_formatter",
 *   label = @Translation("Whlw field formatter"),
 *   field_types = {
 *     "whlw_field"
 *   }
 * )
 */
class WhlwFieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    return array(
      // Implement default settings.
      'wlh_thousand_separator' => '',
      'wlh_decimal_separator' => '.',
      'wlh_scale' => 0,
      'w_thousand_separator' => '',
      'w_decimal_separator' => '.',
      'w_scale' => 2,
      'prefix_suffix' => TRUE,
    ) + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {

    $options = array(
      ''  => t('- None -'),
      '.' => t('Decimal point'),
      ',' => t('Comma'),
      ' ' => t('Space'),
      chr(8201) => t('Thin space'),
      "'" => t('Apostrophe'),
    );
    $elements['wlh_thousand_separator'] = array(
      '#type' => 'select',
      '#title' => t('Thousand marker for WLH'),
      '#options' => $options,
      '#default_value' => $this->getSetting('wlh_thousand_separator'),
      '#weight' => 0,
    );

    $elements['wlh_decimal_separator'] = array(
      '#type' => 'select',
      '#title' => t('Decimal marker'),
      '#options' => array('.' => t('Decimal point'), ',' => t('Comma')),
      '#default_value' => $this->getSetting('wlh_decimal_separator'),
      '#weight' => 5,
    );
    $elements['wlh_scale'] = array(
      '#type' => 'number',
      '#title' => t('Scale', array(), array('context' => 'decimal places')),
      '#min' => 0,
      '#max' => 10,
      '#default_value' => $this->getSetting('scale'),
      '#description' => t('The number of digits to the right of the decimal.'),
      '#weight' => 6,
    );

    $elements['w_thousand_separator'] = array(
      '#type' => 'select',
      '#title' => t('Thousand marker for WLH'),
      '#options' => $options,
      '#default_value' => $this->getSetting('w_thousand_separator'),
      '#weight' => 0,
    );

    $elements['w_decimal_separator'] = array(
      '#type' => 'select',
      '#title' => t('Decimal marker'),
      '#options' => array('.' => t('Decimal point'), ',' => t('Comma')),
      '#default_value' => $this->getSetting('w_decimal_separator'),
      '#weight' => 5,
    );
    $elements['w_scale'] = array(
      '#type' => 'number',
      '#title' => t('Scale', array(), array('context' => 'decimal places')),
      '#min' => 0,
      '#max' => 10,
      '#default_value' => $this->getSetting('w_scale'),
      '#description' => t('The number of digits to the right of the decimal.'),
      '#weight' => 6,
    );

    return $elements;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    $summary = [];
    // Implement settings summary.
    $settings = $this->getSettings();
    // dpm($settings);
    $summary[] = t('Units: ');

    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $elements[$delta] = ['#markup' => $this->viewValue($item)];
    }

    return $elements;
  }

  /**
   * Generate the output appropriate for one field item.
   *
   * @param \Drupal\Core\Field\FieldItemInterface $item
   *   One field item.
   *
   * @return string
   *   The textual output generated.
   */
  protected function viewValue(FieldItemInterface $item) {
    // The text value has no text format assigned to it, so the user input
    // should equal the output, including newlines.
    $width = $item->width;
    $length = $item->length;
    $height = $item->height;
    $weight = $item->weight;
    $values = [];
    foreach (array('width', 'length', 'height', 'weight') as $field) {
      $values[$field] = $item->$field;
    }

    foreach (array('width', 'length', 'height') as $field) {
      $values[$field] = number_format($values[$field], $this->getSetting('wlh_scale'), $this->getSetting('wlh_decimal_separator'), $this->getSetting('wlh_thousand_separator'));
    }
    $values['weight'] = number_format($values['weight'], $this->getSetting('w_scale'), $this->getSetting('w_decimal_separator'), $this->getSetting('w_thousand_separator'));
    dpm($values, '$values');
    //$length = number_format($item->length, 0, '', $this->getSetting('thousand_separator'));
    return $values;
  }

}
