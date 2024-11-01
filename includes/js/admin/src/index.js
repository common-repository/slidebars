/**
 * WK Slidebars
 * JavaScript for the settings page
 * Depends on functions defined in /deps
 */

jQuery(document).ready(function() {

  var icon_checkbox_selector = jQuery("input[name='wksl_slidebars_settings[show_icon]']");
  var icon_targets_selector = jQuery("input[name='wksl_slidebars_settings[button_icon]'], input[name='wksl_slidebars_settings[icon_color]'], input[name='wksl_slidebars_settings[icon_background_color]']").closest("tr");

  icon_checkbox_selector.click( function () {
    wk_icon_settings_update( icon_targets_selector );
  });

  wk_icon_settings_init( icon_checkbox_selector, icon_targets_selector  );


  WordpressSettingsTooltips.create( 'wksl_slidebars_settings[preview_mode]', wksl_settings_content.preview_mode_tooltip );
  WordpressSettingsTooltips.create( 'wksl_slidebars_settings[hide_on]', wksl_settings_content.hide_on_tooltip );
  WordpressSettingsTooltips.create( 'wksl_slidebars_settings[push_content]', wksl_settings_content.push_content_tooltip );
  WordpressSettingsTooltips.create( 'wksl_slidebars_settings[use_content_overlay]', wksl_settings_content.use_content_overlay_tooltip );

  wp_color_picker( '.wksl-slidebars-color-field' );

  wk_select_setting({
    container: '.wk-select-setting',
    option: '.wk-select-value-option',
    valueContainer: '.wk-select-value-container',
    optionsContainer: '.wk-select-options-container',
    searchField: '.wk-select-value-search'
  });

  wk_json_setting({
    container: '.wk-json-setting',
    valueAdder: '.wk-json-value-adder',
    valueRemover: '.wk-json-value-remover',
    valueContainer: '.wk-json-value-container',
    valueDisplay: '.wk-json-value-display'
  });

});
