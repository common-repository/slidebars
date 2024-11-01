<?php
/**
 * WK SLidebars
 * Shortcodes Class
 */

namespace WebKinder\Slidebars;

class Shortcodes {

	/**
	 * Defines all the shortcode identifiers and their corresponding render functions
	 */
	public function __construct() {
		$this->shortcodes = array(

			'wksl_slidebar_button' => function($atts, $content) {
					$text = isset( $atts['text'] ) ? $atts['text'] : 'Slidebar';
					return '<button class="wksl-slidebar-button">' . sanitize_text_field($text) . '</button>';
				},

		);
	}

  /**
   * Adds all shortcode registered in constructor
   */
  public function add() {
    foreach( array_keys($this->shortcodes) as $identifier ) {
      add_shortcode( $identifier, $this->shortcodes[$identifier]);
    }
  }

}

?>
