/**
 * Sets visibility of icon related settings when "Show Icon" is disabled
 *
 * @param selector, valid jQuery selector of show_icon checkbox
 * @param targets, valid jQuery selector of targets to toggle
 */

function wk_icon_settings_init( selector, targets ) {
  if ( !selector.is(':checked') ) {
    targets.hide();
  }
}

/**
 * Updates visibility of icon related settings when "Show Icon" is disabled
 *
 * @param targets, valid jQuery selector of targets to toggle
 */

function wk_icon_settings_update( targets ) {
    targets.fadeToggle();
}
