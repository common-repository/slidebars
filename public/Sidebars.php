<?php
/**
 * WK SLidebars
 * Sidebars Class
 */

namespace WebKinder\Slidebars;

class Sidebars {

	/**
	 * Registers one sidebar
	 */
	public function register() {

    register_sidebar( array(
      'name' => __( 'Slidebar', 'slidebars' ),
      'id' => 'wksl-slidebar',
      'description' => __( 'Slidebar', 'slidebars' ),
      'before_widget' => '<div id="%1$s" class="widget %2$s">',
      'after_widget'  => '</div>',
      'before_title'  => '<h4 class="widgettitle">',
      'after_title'   => '</h4>',
    ) );

	}

	/**
	 * Outputs the registered sidebar based on style settings
	 *
	 * @param $settings_array
	 * 	- 'button_icon',
	 *  - 'use_content_overlay'
	 *
	 */
  public function render( $settings_array ) {

    if( is_active_sidebar( 'wksl-slidebar' ) ) :
			$icon_class = $settings_array['button_icon'];
      ?>
      <div class="wksl-slidebar">
				<?php if( $settings_array['show_close'] ) : ?>
					<div class="wksl-slidebar-close">
						<span class="wksl-slidebar-button fa fa-close" aria-hidden="true"></span>
					</div>
				<?php endif; ?>
				<div class="wksl-slidebar-content">
	        <?php dynamic_sidebar( 'wksl-slidebar' ); ?>
				</div>
				<?php if( $settings_array['show_icon'] ) : ?>
					<span class="wksl-slidebar-trigger <?php echo "fa $icon_class" ?>"></span>
				<?php endif; ?>
      </div>
			<?php if( $settings_array['use_content_overlay'] ) : ?>
				<div class="wksl-slidebar-overlay"></div>
			<?php endif; ?>
      <?php
    endif;

	}

	/**
	 * Renders all styles based on settings for the slidebar
	 *
	 * @param $style_settings
	 *	- 'icon_background_color',
	 *  - 'sidebar_background_color',
	 *  - 'push_content',
	 *  - 'position',
	 *  - 'hide_on',
	 *  - 'use_content_overlay'
	 *
	 */
	public function custom_styles( $style_settings ) {

		?>
		<style>

			.wksl-slidebar .wksl-slidebar-trigger {
				background-color: <?php echo $style_settings['icon_background_color']; ?> !important;
				color: <?php echo $style_settings['icon_color']; ?> !important;
			}

			.wksl-slidebar {
				background-color: <?php echo $style_settings['sidebar_background_color'] ?> !important;
			}

			<?php if( $style_settings['push_content'] ) : ?>

			html {
				overflow-x: hidden !important;
			}

			body, body::before {
				transition: left 0.4s ease, right 0.4s ease;
				<?php echo $style_settings['position'] == 'left' ? "left: 0px;" : "right: 0px;"; ?>
				position: relative;
			}

			html.wksl-slidebar-is-out body,
			html.wksl-slidebar-is-out body::before {
				<?php echo $style_settings['position'] == 'left' ? "left: 300px;" : "right: 300px"; ?>
			}

			<?php endif; ?>

			@media screen and (max-width : 376px)  {
				html.wksl-slidebar-is-out body,
				html.wksl-slidebar-is-out body::before {
					<?php echo $style_settings['position'] == 'left' ? "left: 270px" : "right: 270px"; ?>;
				}
			}

			@media screen and (max-width : 320px)  {
				html.wksl-slidebar-is-out body,
				html.wksl-slidebar-is-out body::before {
					<?php echo $style_settings['position'] == 'left' ? "left: 230px" : "right: 230px"; ?>;
				}
			}

			.wksl-slidebar {
				left: <?php echo $style_settings['position'] == 'left' ? "0" : "auto"; ?> !important;
				right: <?php echo $style_settings['position'] == 'right' ? "0" : "auto"; ?> !important;
				-webkit-transform: <?php echo $style_settings['position'] == 'left' ? "translateX(-100%)" : "translateX(100%)"; ?> !important;
				transform: <?php echo $style_settings['position'] == 'left' ? "translateX(-100%)" : "translateX(100%)"; ?> !important;
			}

			<?php if( $style_settings['position'] == 'right' ) : ?>
				.wksl-slidebar .wksl-slidebar-trigger {
					right: unset !important;
					left: 0 !important;
					-webkit-transform: translateY(-50%) translateX(-200%) !important;
					transform: translateY(-50%) translateX(-200%) !important;
				}
			<?php endif; ?>
			<?php foreach( json_decode( $style_settings['hide_on'] ) as $page_id ) : ?>
				body.page.page-id-<?php echo $page_id; ?> .wksl-slidebar {
					display: none;
				}
			<?php endforeach; ?>

			<?php if( $style_settings['use_content_overlay'] ) : ?>
				.wksl-slidebar-overlay {
					background-color: black;
					pointer-events: none;
					opacity: 0;
					transition: opacity 0.4s ease;
					position: fixed;
					top: 0;
					left: 0;
					height: 100vh;
					width: 100vw;
					z-index: 1000000;
				}

				html.wksl-slidebar-is-out .wksl-slidebar-overlay {
					opacity: 0.2;
					pointer-events: all;
				}
			<?php endif; ?>

			/*static styles*/

				html.wksl-slidebar-is-out .wksl-slidebar {
					-webkit-transform: translateX(0) !important;
					transform: translateX(0) !important;
				}

			.wksl-slidebar {
				width: 300px;
				position: fixed;
				left: 0;
				top: 0;
				-webkit-transform: translateX(-100%);
				transform: translateX(-100%);
				height: 100vh;
				transition: -webkit-transform 0.4s ease;
				transition: transform 0.4s ease;
				background-color: white;
				z-index: 1000001;
			}

			.wksl-slidebar .wksl-slidebar-content {
				<?php if( !$style_settings['show_close'] ) : ?>
					padding-top: 50px;
				<?php endif; ?>
				overflow-y: auto;
				height: 100%;
			}

			.wksl-slidebar .wksl-slidebar-trigger {
				position: absolute;
				top: 50%;
				-webkit-transform: translateY(-50%) translateX(200%);
				transform: translateY(-50%) translateX(200%);
				right: 0px;
				background-color: black;
				color: white;
				height: 40px;
				line-height: 40px !important;
				text-align: center;
				width: 40px;
				border-radius: 100%;
				cursor: pointer;
			}

			<?php if( $style_settings['show_close'] ) : ?>
				.wksl-slidebar-close {
					height: 50px;
					width: 100%;
					padding:15px;
				}
				.wksl-slidebar-close .wksl-slidebar-button {
					cursor: pointer;
				}
			<?php endif; ?>

			<?php if( $style_settings['show_close'] && $style_settings['position'] == "left" ) : ?>
				.wksl-slidebar-close .wksl-slidebar-button {
					float: right;
				}
			<?php endif; ?>

			.wksl-slidebar .wksl-slidebar-trigger.dashicons {
				font-family: dashicons;
				text-decoration: inherit;
				font-weight: 400;
				font-style: normal;
				vertical-align: top;
			}

			@media screen and (max-width : 376px)  {
			  .wksl-slidebar {
			    width: 270px;
			  }
			}

			@media screen and (max-width : 320px)  {
			  .wksl-slidebar {
			    width: 230px;
			  }
			}

		</style>

		<?php
	}

}

?>
