<?php
/**
 * WK Slidebars
 * Settings Class
 */

namespace WebKinder\Slidebars;

class Settings {

	/*==========================METHODS========================*/

	/**
	 * Constructor
	 */
	public function __construct( $dependencies ) {
		$this->dependencies = $dependencies;
	}

	public function get_defaults() {
		return array(
			'icon_background_color' => '#000000',
			'icon_color' => '#ffffff',
			'sidebar_background_color' => '#ffffff',
			'position' => 'left',
			'hide_on' => '[]',
			'use_content_overlay' => false,
			'show_icon' => true,
			'button_icon' => 'fa-bars',
			'push_content' => false,
			'preview_mode' => false,
			);
	}

	public function sanitize_checkbox($array, $key, $defaults) {

		if (!isset($array[$key])) {
			return false;
		}

		if ($array[$key] === '1') {
			return true;
		}

		if ($array[$key] === '0') {
			return false;
		}

		return $defaults[$key];

	}

	public function sanitize_settings($settings) {
		return array(
				'icon_background_color' => isset($settings['icon_background_color']) ? sanitize_hex_color($settings['icon_background_color']) : $this->get_defaults()['icon_background_color'],
				'icon_color' => isset($settings['icon_color']) ? sanitize_hex_color($settings['icon_color']) : $this->get_defaults()['icon_color'],
				'sidebar_background_color' => isset($settings['sidebar_background_color']) ? sanitize_hex_color($settings['sidebar_background_color']) : $this->get_defaults()['sidebar_background_color'],
				'position' => isset($settings['position']) ? ($settings['position'] === 'right' ? 'right' : 'left') : 'left',
				'hide_on' => isset($settings['hide_on']) ?  $settings['hide_on'] : $this->get_defaults()['hide_on'],
				'use_content_overlay' => $this->sanitize_checkbox($settings, 'use_content_overlay', $this->get_defaults()),
				'show_icon' => $this->sanitize_checkbox($settings, 'show_icon', $this->get_defaults()),
				'button_icon' => isset($settings['button_icon']) ? sanitize_text_field($settings['button_icon']) : $this->get_defaults()['button_icon'],
				'push_content' => $this->sanitize_checkbox($settings, 'push_content', $this->get_defaults()),
				'preview_mode' => $this->sanitize_checkbox($settings, 'preview_mode', $this->get_defaults()),
			);
	}

	/**
	 * Registers one global settings group and setting that saves all options as serialized array
	 * and all the individual settings fields
	 */
	public function register() {

		if (!apply_filters('wksl_slidebars_dev_mode', false)) {

			register_setting( 'wksl_slidebars_group', 'wksl_slidebars_settings', array(
				'sanitize_callback' => array( $this, 'sanitize_settings'),
			) );

			add_settings_section(
				'slidebar',
				__( 'Slidebar', 'slidebars' ),
				array( $this, 'slidebar'),
				'wksl_slidebars'
			);

			add_settings_field(
				'preview_mode',
				__('Preview mode', 'slidebars' ),
				array( $this, 'preview_mode'),
				'wksl_slidebars',
				'slidebar'
			);

			add_settings_field(
				'hide_on',
				__('Hide on', 'slidebars' ),
				array( $this, 'hide_on'),
				'wksl_slidebars',
				'slidebar'
			);

			add_settings_field(
				'push_content',
				__('Push content', 'slidebars' ),
				array( $this, 'push_content'),
				'wksl_slidebars',
				'slidebar'
			);

			add_settings_field(
				'use_content_overlay',
				__('Content overlay', 'slidebars' ),
				array( $this, 'use_content_overlay'),
				'wksl_slidebars',
				'slidebar'
			);

			add_settings_field(
				'position',
				__('Position', 'slidebars' ),
				array( $this, 'position'),
				'wksl_slidebars',
				'slidebar'
			);

			add_settings_field(
				'sidebar_background_color',
				__('Sidebar background', 'slidebars' ),
				array( $this, 'sidebar_background_color'),
				'wksl_slidebars',
				'slidebar'
			);

			add_settings_field(
				'show_icon',
				__('Show Icon', 'wksl-slidebars' ),
				array( $this, 'show_icon'),
				'wksl_slidebars',
				'slidebar'
			);

			add_settings_field(
				'button_icon',
				__('Icon', 'wksl-slidebars' ),
				array( $this, 'button_icon'),
				'wksl_slidebars',
				'slidebar'
			);

			add_settings_field(
				'icon_background_color',
				__('Icon background', 'wksl-slidebars' ),
				array( $this, 'icon_background_color'),
				'wksl_slidebars',
				'slidebar'
			);

			add_settings_field(
				'icon_color',
				__('Icon color', 'wksl-slidebars' ),
				array( $this, 'icon_color'),
				'wksl_slidebars',
				'slidebar'
			);

		}

	}

	/**
	 * Adds a new options subpage to 'Settings'
	 */
	public function render() {
		if (!apply_filters('wksl_slidebars_dev_mode', false)) {
			add_options_page(
				'Slidebars',
				'Slidebars',
				'manage_options',
				'wksl_slidebars',
				array( $this, 'content' )
				);
		}
	}

	/**
	 * Outputs all the markup for the options page, renders all the registered settings
	 * and the mailchimp newsletter form
	 */
	public function content() {

		?>
		<div class="wrap">
			<h2><?php _e('Slidebar Settings', 'slidebars' ); ?></h2>
			<div class="wk-left-part">
				<form action="options.php" method="POST">
					<?php settings_fields( 'wksl_slidebars_group' ); ?>
					<?php do_settings_sections( 'wksl_slidebars' ); ?>
					<?php submit_button( __( 'Save' , 'slidebars' ) ); ?>
				</form>
			</div>
			<div class="wk-right-part">
				<h2>Button with Shortcode</h2>
				This plugin supports custom slidebar buttons using the shortcode
				<code>[wksl_slidebar_button text="yourtext"]</code> where you can replace "yourtext" with whatever you like.
				The button will use the default styling defined by your theme.
				<?php include_once( __DIR__ . "/components/mailchimp-form.php" ); ?>
			</div>
		</div>

		<?php
	}

	/**
	 * Section: Slidebar
	 * Name: 		slidebar
	 */
	public function slidebar() {

		_e('Customize your Slidebar using the settings below. If you check preview mode, only logged in WordPress users will see the slidebar.', 'slidebars' );

	}

	/**
	 * Field: 	Preview Mode
	 * Name:		preview_mode
	 */
	public function preview_mode() {

		$field = 'preview_mode';
		$value = $this->get_wksl_slidebars_option( $field );
		?>

			<input type="checkbox" name="wksl_slidebars_settings[<?php echo $field; ?>]" value="1" <?php checked( 1 == $value ); ?> />

		<?php
	}

	/**
	 * Field: 	Content Overlay
	 * Name:		use_content_overlay
	 */
	public function use_content_overlay() {

		$field = 'use_content_overlay';
		$value = $this->get_wksl_slidebars_option( $field );
		?>

			<input type="checkbox" name="wksl_slidebars_settings[<?php echo $field; ?>]" value="1" <?php checked( 1 == $value ); ?> />

		<?php
	}

	/**
	 * Field: 	Sidebar Background Color
	 * Name:		sidebar_background_color
	 */
	public function sidebar_background_color() {

		$field = 'sidebar_background_color';
		$value = $this->get_wksl_slidebars_option( $field );

		echo "<input type='text' class='wksl-slidebars-color-field' name='wksl_slidebars_settings[$field]' value='$value' />";

	}

	/**
	 * Field: 	Show Icon
	 * Name:		show_icon
	 */
	public function show_icon() {

		$field = 'show_icon';
		$value = $this->get_wksl_slidebars_option( $field );
		?>

			<input type="checkbox" name="wksl_slidebars_settings[<?php echo $field; ?>]" value="1" <?php checked( 1 == $value ); ?> />

		<?php
	}

	/**
	 * Field: 	Icon Background Color
	 * Name:		icon_background_color
	 */
	public function icon_background_color() {

		$field = 'icon_background_color';
		$value = $this->get_wksl_slidebars_option( $field );

		echo "<input type='text' class='wksl-slidebars-color-field' name='wksl_slidebars_settings[$field]' value='$value' />";

	}

	/**
	 * Field: 	Icon Color
	 * Name:		icon_color
	 */
	public function icon_color() {

		$field = 'icon_color';
		$value = $this->get_wksl_slidebars_option( $field );

		echo "<input type='text' class='wksl-slidebars-color-field' name='wksl_slidebars_settings[$field]' value='$value' />";

	}

	/**
	 * Field: 	Position
	 * Name:		position
	 */
	public function position() {

		$field = 'position';
		$value = $this->get_wksl_slidebars_option( $field );

		?>
			<div class="wk-setting-radio"><input type="radio" name="wksl_slidebars_settings[<?php echo $field; ?>]" value="left" <?php checked('left', $value, true); ?> /><?php _e('left', 'slidebars' ); ?></div>
			<div class="wk-setting-radio"><input type="radio" name="wksl_slidebars_settings[<?php echo $field; ?>]" value="right" <?php checked('right', $value, true); ?> /><?php _e('right', 'slidebars' ); ?></div>
		<?php

	}

	/**
	 * Field: Hide on
	 * Name: 	hide_on
	 */
	public function hide_on() {

		$field = 'hide_on';
		$value = $this->get_wksl_slidebars_option( $field );
		?>

		<div class="wk-json-setting">
			<?php wp_dropdown_pages(); ?>
			<span class="wk-json-value-adder">+</span>
			<input type="hidden" class="wk-json-value-container" name="wksl_slidebars_settings[<?php echo $field; ?>]" value="<?php echo $value; ?>" />
			<ul class="wk-json-value-display"></ul>
		</div>

		<?php

	}

	/**
	 * Field: Button Icon
	 * Name: 	button_icon
	 */
	public function button_icon() {

		$field = 'button_icon';
		$value = $this->get_wksl_slidebars_option( $field );
		$font_awesome_version = $this->dependencies['font-awesome'];
		$font_awesome_classes = json_decode( file_get_contents( __DIR__ . "/source/fontawesome-$font_awesome_version.json") );

		$dashicons_version = $this->dependencies['dashicons'];
		$dashicons_classes = json_decode( file_get_contents( __DIR__ . "/source/dashicons-$dashicons_version.json") );
		?>

		<div class="wk-select-setting">
			<input type="hidden" class="wk-select-value-container" name="wksl_slidebars_settings[<?php echo $field; ?>]" value="<?php echo $value; ?>" placeholder="search for icon" />
			<input type="text" class="wk-select-value-search" value="" placeholder="<?php _e("Search icons by name...", 'slidebars' ); ?>" />
			<ul class="wk-select-options-container">
			<h6><?php _e("Font Awesome", 'slidebars' ); ?> (<?php echo count( $font_awesome_classes ); ?> <?php _e("icons", 'slidebars' ); ?>) </h6>
			<?php
				foreach( $font_awesome_classes as $font_awesome_class ) {
					?>
						<li class="wk-select-value-option <?php echo $font_awesome_class; ?>" data-value="<?php echo $font_awesome_class; ?>"></li>
					<?php
				}
			?>
			<h6><?php _e("WordPress", 'slidebars' ); ?> (<?php echo count( $dashicons_classes ); ?> <?php _e("icons", 'slidebars' ); ?>) </h6>
			<?php
				foreach( $dashicons_classes as $dash_icon_class ) {
					?>
						<li class="wk-select-value-option <?php echo $dash_icon_class; ?>" data-value="<?php echo $dash_icon_class; ?>"></li>
					<?php
				}
			?>
			</ul>
		</div>

		<?php

	}

	/**
	 * Field: 	Push Content
	 * Name:		push_content
	 */
	public function push_content() {

		$field = 'push_content';
		$value = $this->get_wksl_slidebars_option( $field );
		?>

			<input type="checkbox" name="wksl_slidebars_settings[<?php echo $field; ?>]" value="1" <?php checked( 1 == $value ); ?> />

		<?php
	}

	/**
	 * Options helper functions that checks all settings against an array of defaults
	 *
	 * @param Option name, a.k.a. name of the settings field
	 *
	 * @return Value of the requested setting
	 *
	 */
	public function get_wksl_slidebars_option( $optionname ) {

		if (apply_filters('wksl_slidebars_dev_mode', false)) {
			return apply_filters( 'wksl_slidebars_settings', $this->get_defaults() )[$optionname];
		} else {
			return wp_parse_args( get_option( 'wksl_slidebars_settings' ), $this->get_defaults() )[$optionname];
		}

	}
}

?>
