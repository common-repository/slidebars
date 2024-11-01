<?php
/**
 * WK Slidebars
 * Main Class
 */

namespace WebKinder\Slidebars;

class Plugin {

    /*==========================MEMBERS=========================*/

    public $settings, $sidebars, $shortcodes, $lifecycle, $i18n, $dependencies;

    /*==========================CONSTRUCTOR====================*/


    public function __construct() {

    	//Internal Setup
      $this->dependencies = array(
        'font-awesome' => '4.7.0',
        'dashicons' => '3.8'
      );
    	//===

    	//load textdomain
    	add_action('plugins_loaded', array( $this, "load_textdomain" ) );
    	//===

      //Settings
    	require_once( plugin_dir_path( __FILE__ ) . 'admin/Settings.php' );
      $this->settings = new Settings( $this->dependencies );

      add_action( 'admin_init', array( $this->settings, "register" ) );
      add_action( 'admin_menu', array( $this->settings, "render" ) );
      //===

      //Sidebars
      require_once( plugin_dir_path( __FILE__ ) . 'public/Sidebars.php' );
      $this->sidebars = new Sidebars();

      add_action( 'widgets_init', array( $this->sidebars, "register" ) );
      add_action( 'wp_footer', array( $this, "render_sidebars" ) );
      add_action( 'wp_head', array( $this, "custom_styles") );
      //===

      //Shortcodes
      require_once( plugin_dir_path( __FILE__ ) . 'public/Shortcodes.php' );
      $this->shortcodes = new Shortcodes();

      $this->shortcodes->add();

      //===

      //Loader
      require_once( plugin_dir_path( __FILE__ ) . 'includes/Loader.php');
      $this->loader = new Loader( $this->dependencies );

      add_action( 'admin_enqueue_scripts', array( $this->loader, "admin_scripts") );
      add_action( 'wp_enqueue_scripts', array( $this, "load_public_scripts") );
      //===

    }

    /*==========================METHODS========================*/

    /**
     * Load Text Domain
     */
  	public function load_textdomain() {
    		load_plugin_textdomain( 'slidebars', false, basename( dirname( __FILE__ ) ) . '/languages' );
		}

    /**
     * Register Sidebars
     */
    public function render_sidebars() {
      if( $this->should_render_slidebar() ) {

        $settings_array = array(
					'button_icon' => $this->settings->get_wksl_slidebars_option('button_icon'),
					'use_content_overlay' => $this->settings->get_wksl_slidebars_option('use_content_overlay'),
					'show_icon' => $this->settings->get_wksl_slidebars_option('show_icon'),
					'show_close' => !$this->settings->get_wksl_slidebars_option('show_icon')
        );

        $this->sidebars->render( $settings_array );

      }
    }

    /**
     * Passes all style settings down to the custom styles method of sidebars class
     */
    public function custom_styles() {
      if( $this->should_render_slidebar() ) {

        $settings_array = array(
            'icon_background_color' => $this->settings->get_wksl_slidebars_option('icon_background_color'),
            'icon_color' => $this->settings->get_wksl_slidebars_option('icon_color'),
            'sidebar_background_color' => $this->settings->get_wksl_slidebars_option('sidebar_background_color'),
            'position' => $this->settings->get_wksl_slidebars_option('position'),
            'hide_on' => $this->settings->get_wksl_slidebars_option('hide_on'),
            'push_content' => $this->settings->get_wksl_slidebars_option('push_content'),
            'use_content_overlay' => $this->settings->get_wksl_slidebars_option('use_content_overlay'),
						'show_close' => !$this->settings->get_wksl_slidebars_option('show_icon')
        );

        $this->sidebars->custom_styles( $settings_array );

      }
    }

    /**
     * Loads public scripts if the slidebar is active on frontend
     */
    public function load_public_scripts( $hook ) {
      if( $this->should_render_slidebar() ) {

         $this->loader->public_scripts( $hook );

      }
    }

    /**
     * Returns wether the slidebar gets rendered or not
     *
     * @return boolean
     *
     */
    public function should_render_slidebar() {
      $is_preview_mode = $this->settings->get_wksl_slidebars_option('preview_mode');
      $is_logged_in    = is_user_logged_in();

      return !$is_preview_mode || $is_logged_in;
    }


}

?>
