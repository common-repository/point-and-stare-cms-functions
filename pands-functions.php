<?php
/*
  Plugin Name: Point and Stare CMS Functions
  Plugin URI: http://wordpress.org/extend/plugins/point-and-stare-cms-functions/
  Description: This plugin will generate special functions that help convert your WordPress install into a white labelled CMS, add security and generally protect the admin.
  Version: 3.1.6
  Author: Lee Rickler
  Author URI: http://pointandstare.com

  License: GPLv2 or later
  License URI: http://www.gnu.org/licenses/gpl-2.0.html

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

// TO REMOVE THIS OPTIONS PAGE FROM YOUR SETTINGS MENU
// SIMPLY UNCOMMENT THIS LITTLE LOT
// START THE SNEAKY PLUGIN HIDING UNCOMMENTING
// function delete_submenu_items() {
//    remove_submenu_page( 'options-general.php', 'pands-script');
// }
// add_action( 'admin_init', 'delete_submenu_items' );
// END THE SNEAKY PLUGIN HIDING UNCOMMENTIING

function pands_plugin_settings_link($links) {
    $settings_link = '<a href="options-general.php?page=pands-script">Settings</a>';
    array_unshift($links, $settings_link);
    return $links;
}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'pands_plugin_settings_link');

// ADD THE ADMIN OPTIONS PAGE
add_action('admin_menu', 'pands_script_add_page');

function pands_script_add_page() {
    add_options_page('P and S CMS', 'P and S CMS Functions', 'manage_options', 'pands-script', 'pands_script_page');
}

add_action('admin_init', 'pands_script_admin_init');

function pands_script_admin_init() {
    register_setting('pands_script_options', 'pands_script_plugin_options');
}

// DISPLAY THE ADMIN OPTIONS PAGE
function pands_script_page() {
    ?>
    <div class="wrap">
        <div id="heres-jonny"><h2>Point and Stare CMS Functions WordPress plugin</h2>
            <h3><?php _e('This plugin will generate special functions that help convert your default WordPress install into a fully branded CMS, add security features and generally white label the admin.', 'pands'); ?></h3>
            <p><?php _e('Simply choose the options required below and click save.', 'pands'); ?><br />
            <strong>Any issues, contact Point and Stare anytime:</strong><br />
                <?php
echo '<a href="http://twitter.com/pointandstare" target="_blank"><img class="icon-twitter" src="' . plugins_url( 'img/cms-plugin-twitter.png', __FILE__ ) . '" ></a> '; ?></p>
            <form id="pands_cms_form" action="options.php" method="post">
                <?php settings_fields('pands_script_options'); ?>
                <?php $options = get_option('pands_script_plugin_options'); ?>
                <input type="hidden" id="current_tab" name="pands_script_plugin_options[current_tab]" value="<?php echo intval($options['current_tab']) ?>" />
                <div id="tabs-pands-script">
                    <ul id="pands-tab-list">
                        <li><a href="#tabs-pands-admin" title="Use these fields to personalise the login page and admin area"><?php _e('General settings', 'pands'); ?></a></li>
                        <li id="pands-dashboard" title="You can remove widgets and add your own panels using these options"><a href="#tabs-pands-dashboard"><?php _e('Dashboard', 'pands'); ?></a></li>
                        <li title="<?php _e('Keep the write pages minimal by reducing clutter.', 'pands'); ?>"><a href="#tabs-pands-pages-posts"><?php _e('Pages &amp; Posts', 'pands'); ?></a></li>
                        <li title="<?php _e('If you need to stop your client adding a ton of widgets, switch them off here', 'pands'); ?>"><a href="#tabs-pands-widgets"><?php _e('Widgets', 'pands'); ?></a></li>
                        <li title="<?php _e('Use these options to change elements on the front end of the website', 'pands'); ?>"><a href="#tabs-pands-front-end"><?php _e('Front end', 'pands'); ?></a></li>
                    </ul>
                    <input name="Submit" class="button-primary" type="submit" value="<?php _e('Save Changes', 'pands'); ?>" /><br />
                    <div id="tabs-pands-admin">
                        <h3><?php _e('Use these fields to personalise the login page and admin area.','pands') ?></h3>
                        <table class="pands-cms-options-table">
                            <tr>
                                <td class="panel-title" colspan="2"><?php _e('Custom login page', 'pands' ); ?></td>
                            </tr>
                            <tr>
                                <td><?php _e('Change the Login logo', 'pands'); ?><br /><span class="th-small"><?php _e('Default is the WordPress logo - 310px x 70px', 'pands'); ?></span></td>
                                <td>
                                    <input id="custom_admin_header_logo" class="ui-widget-text" name="pands_script_plugin_options[custom_admin_header_logo]" type="hidden" value="<?php echo $options['custom_admin_header_logo']; ?>" />
                                    <a data-update="Set as Login Logo" data-choose="<?php _e('Choose Image', 'pands'); ?>" class="cms_upload_image_button button"><?php _e('Choose Image', 'pands'); ?></a>
                                    <?php if (!empty($options['custom_admin_header_logo'])) { ?>
                                        <div class="img-prev-container">
                                            <a title="<?php _e('Remove', 'pands'); ?>" class="del-icon" href="javascript:void(0)"></a>
                                            <img src="<?php echo $options['custom_admin_header_logo'] ?>" style="max-width: 100%" />
                                        </div>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php _e('Login page logo Alt text', 'pands'); ?><br /><span class="th-small"><?php _e('Change this to your company strapline', 'pands'); ?></span></td>
                                <td><input class="ui-widget-text" name="pands_script_plugin_options[custom_admin_login_header_link_alt_text]" type="text" value="<?php echo $options['custom_admin_login_header_link_alt_text']; ?>" /></td>
                            </tr>
                        </table>
                        <table class="pands-cms-options-table">
                            <tr>
                                <td class="panel-title" colspan="2"><?php _e('Global Admin area', 'pands'); ?></td>
                            </tr>
                            <tr>
                                <td><?php _e('Admin WP Logo', 'pands'); ?><br /><span class="th-small"><?php _e('Upload a new image or leave blank to use your main favicon (installed in root)', 'pands'); ?></span></td>
                                <td>
                                    <input id="cms_admin_wp_logo" class="ui-widget-text" name="pands_script_plugin_options[admin_wp_logo]" type="hidden" value="<?php echo $options['admin_wp_logo']; ?>" />
                                    <a data-update="Set as Admin WP Logo" data-choose="Choose an Admin WP Logo" class="cms_upload_image_button button"><?php _e('Choose Image', 'pands'); ?></a>
                                    <?php if (!empty($options['admin_wp_logo'])) { ?>
                                        <div class="img-prev-container">
                                            <a title="<?php _e('Remove', 'pands'); ?>" class="del-icon" href="javascript:void(0)"></a>
                                            <img src="<?php echo $options['admin_wp_logo'] ?>" style="max-width: 100%" />
                                        </div>
                                    <?php } ?>
                                </td>
                            </tr>
                        </table>
                       <table class="pands-cms-options-table">
                                <tr>
                                    <td class="panel-title" colspan="5"><?php _e('Remove admin menu items', 'pands'); ?></td>
                                </tr>
                                <tr>
                                    <th scope="col" colspan="2" class="th-small"><?php _e('Top level menu items', 'pands'); ?></th>
                                    <th rowspan="19" class="th-small" scope="col">&nbsp;</th>
                                    <th colspan="2" class="th-small" scope="col"><?php _e('Submenu items', 'pands'); ?></th>
                                </tr>
                                <tr>
                                    <td><?php _e('Appearance', 'pands'); ?></td>
                                    <td><input name="pands_script_plugin_options[themes_menu_item]" type="checkbox" value="1" <?php checked('1', isset($options['themes_menu_item'])); ?> /></td>
                                    <td><?php _e('Available tools', 'pands'); ?></td>
                                    <td><input name="pands_script_plugin_options[available_tools_submenu]" type="checkbox" value="1" <?php checked('1', isset($options['available_tools_submenu'])); ?> /></td>
                                </tr>
                                 <tr>
                                   <td><?php _e('Comments', 'pands'); ?></td>
                                   <td><input name="pands_script_plugin_options[edit-comments_menu_item]" type="checkbox" value="1" <?php checked('1', isset($options['edit-comments_menu_item'])); ?> /></td>
                                   <td><?php _e('Customise', 'pands'); ?></td>
                                   <td><input name="pands_script_plugin_options[customize_submenu]" type="checkbox" value="1" <?php checked('1', isset($options['customize_submenu'])); ?> /></td>
                                 </tr>
    
                                 <tr>
                                   <td><?php _e('Media', 'pands'); ?></td>
                                   <td><input name="pands_script_plugin_options[upload_menu_item]2" type="checkbox" value="1" <?php checked('1', isset($options['upload_menu_item'])); ?> /></td>
                                   <td><?php _e('Discussion', 'pands'); ?></td>
                                    <td><input name="pands_script_plugin_options[discussion_submenu]" type="checkbox" value="1" <?php checked('1', isset($options['discussion_submenu'])); ?> /></td>
                                </tr>
    
                                 <tr>
                                   <td><?php _e('Pages', 'pands'); ?></td>
                                   <td><input name="pands_script_plugin_options[edit_menu_item]2" type="checkbox" value="1" <?php checked('1', isset($options['edit_menu_item'])); ?> /></td>
                                   <td><?php _e('Export', 'pands'); ?></td>
                                   <td><input name="pands_script_plugin_options[export_submenu]" type="checkbox" value="1" <?php checked('1', isset($options['export_submenu'])); ?> /></td>
                                 </tr>
                                <tr>
                                  <td><?php _e('Plugins', 'pands'); ?></td>
                                  <td><input name="pands_script_plugin_options[plugins_menu_item]2" type="checkbox" value="1" <?php checked('1', isset($options['plugins_menu_item'])); ?> /></td>
                                  <td><?php _e('General', 'pands'); ?></td>
                                    <td><input name="pands_script_plugin_options[general_submenu]" type="checkbox" value="1" <?php checked('1', isset($options['general_submenu'])); ?> /></td>
                                </tr>
                                <tr>
                                  <td><?php _e('Posts', 'pands'); ?></td>
                                  <td><input name="pands_script_plugin_options[posts_menu_item]2" type="checkbox" value="1" <?php checked('1', isset($options['posts_menu_item'])); ?> /></td>
                                  <td><?php _e('Import', 'pands'); ?></td>
                                  <td><input name="pands_script_plugin_options[import_submenu]" type="checkbox" value="1" <?php checked('1', isset($options['import_submenu'])); ?> /></td>
                                </tr>
                                <tr>
                                  <td rowspan="4" valign="top"><?php _e('Settings', 'pands'); ?><br />
                                    <small class="red"><?php _e('Be careful with this one - switch it off and<br />
                                    you\'ll lose access to these functions.<br />
                                    To hide this menu, either <a href="options-general.php?page=pands-script">bookmark this page<br />
                                  first</a> or see the commented code at the top of this plugin.</small>', 'pands'); ?></td>
                                  <td rowspan="4" valign="top"><input name="pands_script_plugin_options[options-general_menu_item]2" type="checkbox" value="1" <?php checked('1', isset($options['options-general_menu_item'])); ?> /></td>
                                  <td><?php _e('Media', 'pands'); ?></td>
                                    <td><input name="pands_script_plugin_options[media_submenu]" type="checkbox" value="1" <?php checked('1', isset($options['media_submenu'])); ?> /></td>
                                </tr>
                                <tr>
                                    <td><?php _e('Menus', 'pands'); ?></td>
                                    <td><input name="pands_script_plugin_options[menu_submenu]" type="checkbox" value="1" <?php checked('1', isset($options['menu_submenu'])); ?> /></td>
                                </tr>
                                <tr>
                                    <td><?php _e('Permalinks', 'pands'); ?></td>
                                    <td><input name="pands_script_plugin_options[permalinks_submenu]" type="checkbox" value="1" <?php checked('1', isset($options['permalinks_submenu'])); ?> /></td>
                                </tr>
                                <tr>
                                    <td><?php _e('Plugin Editor', 'pands'); ?></td>
                                    <td><input name="pands_script_plugin_options[plugin_editor_submenu]" type="checkbox" value="1" <?php checked('1', isset($options['plugin_editor_submenu'])); ?> /></td>
                                </tr>
                                <tr>
                                  <td valign="top"><?php _e('Tools', 'pands'); ?></td>
                                    <td valign="top"><input name="pands_script_plugin_options[tools_menu_item]2" type="checkbox" value="1" <?php checked('1', isset($options['tools_menu_item'])); ?> /></td>
                                     <td><?php _e('Reading', 'pands'); ?></td>
                                    <td><input name="pands_script_plugin_options[reading_submenu]" type="checkbox" value="1" <?php checked('1', isset($options['reading_submenu'])); ?> /></td>
                                   
                                </tr>
                                <tr>
                                  <td><?php _e('Users', 'pands'); ?></td>
                                  <td><input name="pands_script_plugin_options[users_menu_item]" type="checkbox" value="1" <?php checked('1', isset($options['users_menu_item'])); ?> /></td>
                                   <td><?php _e('Tags', 'pands'); ?></td>
                                    <td><input name="pands_script_plugin_options[tags_submenu]" type="checkbox" value="1" <?php checked('1', isset($options['tags_submenu'])); ?> /></td>
                                 
                                </tr>
                                <tr>
                                  <td colspan="2" rowspan="6">&nbsp;</td>
                                 
                                </tr>
                                <tr>
                                  <td><?php _e('Themes', 'pands'); ?></td>
                                    <td><input name="pands_script_plugin_options[themes_submenu]" type="checkbox" value="1" <?php checked('1', isset($options['themes_submenu'])); ?> /></td>
                                </tr>
                                <tr>
                                  <td><?php _e('Theme editor', 'pands'); ?></td>
                                    <td><input name="pands_script_plugin_options[theme_editor_submenu]" type="checkbox" value="1" <?php checked('1', isset($options['theme_editor_submenu'])); ?> /></td>
                                </tr>
                                <tr>
                                    <td><?php _e('Updates', 'pands'); ?></td>
                                    <td><input name="pands_script_plugin_options[updates_submenu]" type="checkbox" value="1" <?php checked('1', isset($options['updates_submenu'])); ?> /></td>
                                </tr>
    
                                <tr>
                                    <td><?php _e('Widgets', 'pands'); ?></td>
                                    <td><input name="pands_script_plugin_options[widgets_submenu]" type="checkbox" value="1" <?php checked('1', isset($options['widgets_submenu'])); ?> /></td>
                                </tr>
                                <tr>
                                    <td><?php _e('Writing', 'pands'); ?></td>
                                    <td><input name="pands_script_plugin_options[writing_submenu]" type="checkbox" value="1" <?php checked('1', isset($options['writing_submenu'])); ?> /></td>
                                </tr>
                            </table>
                        <table class="pands-cms-options-table">
                            <tr>
                                <td class="panel-title" colspan="2"><?php _e('Admin footer information', 'pands'); ?></td>
                            </tr>
                            <tr>
                                <th colspan="2" class="th-small"><?php _e('Add the development company name, URL, favicon and site version number.<br />These details will appear below in the footer.', 'pands'); ?></th></tr>
                            <tr>
                                <td><?php _e('Company Name', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[company_name]" type="text" value="<?php echo $options['company_name']; ?>" /></td>
                            </tr>
                            <tr>
                                <td><?php _e('URL', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[company_url]" type="text" value="<?php echo $options['company_url']; ?>" /></td>
                            </tr>
                            <tr>
                                <td>
                                    <?php _e('Favicon url', 'pands'); ?>
                                    <br />
                                    <span class="th-small"><?php _e('For best results use a 16px x 16px image.', 'pands'); ?></span>
                                </td>
                                <td>
                                    <input id="favicon_company_url" name="pands_script_plugin_options[favicon_company_url]" type="hidden" value="<?php echo $options['favicon_company_url']; ?>" />
                                    <a data-update="Set as Favicon" data-choose="Choose a Favicon" class="cms_upload_image_button button"><?php _e('Choose Image', 'pands'); ?></a>
                                    <?php if (!empty($options['favicon_company_url'])) { ?>
                                        <div class="img-prev-container">
                                            <a title="<?php _e('Remove', 'pands'); ?>" class="del-icon" href="javascript:void(0)"></a>
                                            <img src="<?php echo $options['favicon_company_url'] ?>" style="max-width: 100%" />
                                        </div>
                                    <?php } ?>
                                </td>
                            </tr>
                            <tr>
                                <td><?php _e('Version number', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[footer_ver]" type="text" value="<?php echo $options['footer_ver']; ?>" /></td>
                            </tr>
                        </table>
                    </div>
                    <div id="tabs-pands-dashboard">
                        <h3><?php _e('You can remove dashboard widgets and add your own panels using these options.', 'pands'); ?></h3>
                        <table class="pands-cms-options-table">
                            <tr>
                                <td class="panel-title" colspan="2"><?php _e('Remove dashboard widgets', 'pands'); ?></td>
                            </tr>
                            <tr>
                                <th colspan="2" class="th-small"><?php _e('Replace them with your own panels below', 'pands'); ?></th>
                            </tr>
                             <tr>
                                <td><?php _e('Activity', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[dashboard_activity]" type="checkbox" value="1" <?php checked('1', isset($options['dashboard_activity'])); ?> /></td>
                            </tr>
                             <tr>
                                <td><?php _e('At a glance', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[dash-right-now]" type="checkbox" value="1" <?php checked('1', isset($options['dash-right-now'])); ?> /></td>
                            </tr>
                            <tr>
                                <td><?php _e('Quick Draft', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[dashboard_quick_press]" type="checkbox" value="1" <?php checked('1', isset($options['dashboard_quick_press'])); ?> /></td>
                            </tr>
                             <tr>
                                <td><?php _e('Welcome panel', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[welcome_panel]" type="checkbox" value="1" <?php checked('1', isset($options['welcome_panel'])); ?> /></td>
                            </tr>
                            <tr>
                                <td><?php _e('WordPress news', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[dashboard_primary]" type="checkbox" value="1" <?php checked('1', isset($options['dashboard_primary'])); ?> /></td>
                            </tr>
                        </table>
                        <table class="pands-cms-options-table">
                            <tr>
                                <td class="panel-title" colspan="2"><?php _e('Add custom dashboard panels', 'pands'); ?></td>
                            </tr>
                            <tr>
                                <td>
                                    <a href="javascript:void(0);" onclick="addDBPanel()" class="button"><?php _e('Add Panel', 'pands'); ?></a>
                                    <table class="dasboard-panels">
                                        <?php
                                        if (isset($options['dashboard_panels']) && is_array($options['dashboard_panels'])) {

                                            foreach ($options['dashboard_panels'] as $id => $panel) {
                                                ?>
                                                <tr>
                                                    <td class="cms_panel_container">
                                                        <a title="<?php _e('Delete', 'pands'); ?>" style="float: right" class="button del_panel" href="javascript:void(0)"><?php _e('Delete', 'pands'); ?></a>
                                                        <table class="panel_table">
                                                            <tr>
                                                                <td><?php _e('Active', 'pands'); ?></td>
                                                                <td><input name="pands_script_plugin_options[dashboard_panels][<?php echo $id ?>][active]" type="checkbox" value="1" <?php checked('1', $panel['active']); ?> /></td>
                                                            </tr>
                                                            <tr>
                                                                <td><?php _e('Title', 'pands'); ?></td>
                                                                <td><input name="pands_script_plugin_options[dashboard_panels][<?php echo $id ?>][title]" type="text" value="<?php echo $panel['title']; ?>" /></td>
                                                            </tr>
                                                            <tr>
                                                                <td style="vertical-align:top"><?php _e('Content', 'pands'); ?></td>
                                                                <td>
                                                                    <?php
                                                                    $wp_editor_id = 'pands_script_plugin_options_dashboard_panels_' . $id . '_content';
                                                                    $wp_editor_args = array(
                                                                      'textarea_name' => 'pands_script_plugin_options[dashboard_panels][' . $id . '][content]'
                                                                    );
                                                                    wp_editor($panel['content'], $wp_editor_id, $wp_editor_args) ?>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <hr />
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div id="tabs-pands-pages-posts">
                        <h3><?php _e('Keep the write pages minimal by reducing clutter.', 'pands'); ?></h3>
                        <table class="pands-cms-options-table">
                            <tr>
                                <td class="panel-title" colspan="5"><?php _e('Remove write page furniture', 'pands'); ?></td>
                            </tr>
                            <tr>
                                <th colspan="5"><strong><?php _e('General pages', 'pands'); ?></strong></th>
                            </tr>
                            <tr>
                                <td><?php _e('Screen Options tab', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[remove_screen_options_tab]" type="checkbox" value="1" <?php checked('1', isset($options['remove_screen_options_tab'])); ?> /></td>
                                <td>&nbsp;</td>
                                <td><?php _e('Help tab', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[hide_help_tab]" type="checkbox" value="1" <?php checked('1', isset($options['hide_help_tab'])); ?> /></td>
                            </tr>
                            <tr>
                                <th colspan="2"><strong><?php _e('For Posts', 'pands'); ?></strong></th>
                                <th rowspan="13">&nbsp;</th>
                                <th colspan="2"><strong><?php _e('For Pages', 'pands'); ?></strong></th>
                            </tr>
                            <tr>
                                <td><?php _e('Author', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[authordiv_post]" type="checkbox" value="1" <?php checked('1', isset($options['authordiv_post'])); ?> /></td>
                                <td><?php _e('Author', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[authordiv_page]" type="checkbox" value="1" <?php checked('1', isset($options['authordiv_page'])); ?> /></td>
                            </tr>
                            <tr>

                                <td><?php _e('Comments', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[commentsdiv_post]" type="checkbox" value="1" <?php checked('1', isset($options['commentsdiv_post'])); ?> /></td>
                                 <td><?php _e('Custom Fields', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[postcustom_page]" type="checkbox" value="1" <?php checked('1', isset($options['postcustom_page'])); ?> /></td>
                                
                            </tr>
                            <tr>
                              <td><?php _e('Categories', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[categorydiv_post]" type="checkbox" value="1" <?php checked('1', isset($options['categorydiv_post'])); ?> /></td>
                                <td><?php _e('Discussion', 'pands'); ?></td>
                                <td><input class="checkbox" name="pands_script_plugin_options[discussiondiv_page]" type="checkbox" value="1" <?php checked('1', isset($options['discussiondiv_page'])); ?> /></td>
                               
                            </tr>
                            <tr>
                               <td><?php _e('Custom Fields', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[postcustom_post]" type="checkbox" value="1" <?php checked('1', isset($options['postcustom_post'])); ?> /></td>
                                 <td><?php _e('Featured image', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[postimagediv_page]" type="checkbox" value="1" <?php checked('1', isset($options['postimagediv_page'])); ?> /></td>

                                
                            </tr>
                            <tr>
                              <td><?php _e('Discussion', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[discussiondiv_post]" type="checkbox" value="1" <?php checked('1', isset($options['discussiondiv_post'])); ?> /></td>
                                 <td><?php _e('Page Attributes', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[pageparentdiv_page]" type="checkbox" value="1" <?php checked('1', isset($options['pageparentdiv_page'])); ?> /></td>
                            </tr>
                             <tr>
                              <td><?php _e('Excerpt', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[postexcerpt_post]" type="checkbox" value="1" <?php checked('1', isset($options['postexcerpt_post'])); ?> /></td>
                                 <td><?php _e('Publish', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[submitdiv_page]" type="checkbox" value="1" <?php checked('1', isset($options['submitdiv_page'])); ?> /></td>
                               
                            </tr>
                            <tr>
                               <td><?php _e('Featured image', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[postimagediv_post]" type="checkbox" value="1" <?php checked('1', isset($options['postimagediv_post'])); ?> /></td>
                                <td><?php _e('Revisions', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[revisionsdiv_page]" type="checkbox" value="1" <?php checked('1', isset($options['revisionsdiv_page'])); ?> /></td>
                               
                            </tr>
                            <tr>
                              <td><?php _e('Tags', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[tagsdiv-post_tag_post]" type="checkbox" value="1" <?php checked('1', isset($options['tagsdiv-post_tag_post'])); ?> /></td>
                                 <td><?php _e('Slug', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[slugdiv_page]" type="checkbox" value="1" <?php checked('1', isset($options['slugdiv_page'])); ?> /></td>
                                
                            </tr>
                             <tr>
                              <td><?php _e('Publish', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[submitdiv_post]" type="checkbox" value="1" <?php checked('1', isset($options['submitdiv_post'])); ?> /></td>
                                <td colspan="2" rowspan="4">&nbsp;</td>
                               
                            </tr>
                            <tr>
                              <td><?php _e('Revisions', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[revisionsdiv_post]" type="checkbox" value="1" <?php checked('1', isset($options['revisionsdiv_post'])); ?> /></td>
                               
                            </tr>
                            <tr><td><?php _e('Slug', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[slugdiv_post]" type="checkbox" value="1" <?php checked('1', isset($options['slugdiv_post'])); ?> /></td>
                                
                            </tr>

                            <tr><td><?php _e('Trackbacks', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[trackbacksdiv_post]" type="checkbox" value="1" <?php checked('1', isset($options['trackbacksdiv_post'])); ?> /></td>
                                
                            </tr>
                             <tr>
                                <td colspan="4"><?php _e('Revisions - (in publish panel both posts and pages)', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[revisionsdiv_panel]" type="checkbox" value="1" <?php checked('1', isset($options['revisionsdiv_panel'])); ?> /></td>

                            </tr>
                        </table>
                    </div>
                    <div id="tabs-pands-widgets">
                        <table class="pands-cms-options-table">
                            <h3><?php _e('If you need to stop your client adding a ton of widgets, switch them off here.', 'pands'); ?></h3>
                            <tr>
                                <td class="panel-title" colspan="2"><?php _e('Remove Default Widgets', 'pands'); ?></td>
                            </tr>
                            <tr>
                                <th colspan="2" class="th-small"><?php _e('Select the widgets that you\'d like to hide.', 'pands'); ?></th>
                            </tr>
                            <tr>
                                <td><?php _e('Archives', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[WP_Widget_Archives]" type="checkbox" value="1" <?php checked('1', isset($options['WP_Widget_Archives'])); ?> /></td>
                            </tr>
                            <tr>
                                <td><?php _e('Calendar', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[WP_Widget_Calendar]" type="checkbox" value="1" <?php checked('1', isset($options['WP_Widget_Calendar'])); ?> /></td>
                            </tr>
                            <tr>
                                <td><?php _e('Categories', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[WP_Widget_Categories]" type="checkbox" value="1" <?php checked('1', isset($options['WP_Widget_Categories'])); ?> /></td>
                            </tr>
                            <tr>
                                <td><?php _e('Custom Menu', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[WP_Nav_Menu_Widget]" type="checkbox" value="1" <?php checked('1', isset($options['WP_Nav_Menu_Widget'])); ?> /></td>
                            </tr>
                            <tr>
                                <td><?php _e('Meta', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[WP_Widget_Meta]" type="checkbox" value="1" <?php checked('1', isset($options['WP_Widget_Meta'])); ?> /></td>
                            </tr>
                            <tr>
                                <td><?php _e('Pages', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[WP_Widget_Pages]" type="checkbox" value="1" <?php checked('1', isset($options['WP_Widget_Pages'])); ?> /></td>
                            </tr>
                            <tr>
                                <td><?php _e('Recent comments', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[WP_Widget_Recent_Comments]" type="checkbox" value="1" <?php checked('1', isset($options['WP_Widget_Recent_Comments'])); ?> /></td>
                            </tr>
                            <tr>
                                <td><?php _e('Recent posts', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[WP_Widget_Recent_Posts]" type="checkbox" value="1" <?php checked('1', isset($options['WP_Widget_Recent_Posts'])); ?> /></td>
                            </tr>
                            <tr>
                                <td><?php _e('RSS', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[WP_Widget_RSS]" type="checkbox" value="1" <?php checked('1', isset($options['WP_Widget_RSS'])); ?> /></td>
                            </tr>

                            <tr>
                                <td><?php _e('Search', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[WP_Widget_Search]" type="checkbox" value="1" <?php checked('1', isset($options['WP_Widget_Search'])); ?> /></td>
                            </tr>
                            <tr>
                                <td><?php _e('Tag cloud', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[WP_Widget_Tag_Cloud]" type="checkbox" value="1" <?php checked('1', isset($options['WP_Widget_Tag_Cloud'])); ?> /></td>
                            </tr>
                            <tr>
                                <td><?php _e('Text', 'pands'); ?></td>
                                <td><input name="pands_script_plugin_options[WP_Widget_Text]" type="checkbox" value="1" <?php checked('1', isset($options['WP_Widget_Text'])); ?> /></td>
                            </tr>
                        </table></div>
                    <div id="tabs-pands-front-end">
                        <h3>Use these options to change elements on the front end of the website.</h3>
                        <table class="pands-cms-options-table">
                            <tr>
                                <td class="panel-title" colspan="3">Visible front end</td>
                            </tr>
                            <tr>
                                <td>Maintenance mode<br /><span class="th-small">Put your site temporarily in maintenance mode (and add a message)<br />The site will still be visible to admins only.</span></td>
                                <td><input name="pands_script_plugin_options[maintenance_mode]" type="checkbox" value="1" <?php checked('1', isset($options['maintenance_mode'])); ?> /></td>
                                <td><input class="ui-widget-text" name="pands_script_plugin_options[maintenance_message]" type="text" value="<?php echo $options['maintenance_message']; ?>" /></td>
                            </tr>
                            <tr>
                                <td>Remove v3 admin bar<br /><span class="th-small">Removes the enforced admin bar across the top of the front-end.</span></td>
                                <td colspan="2"><input name="pands_script_plugin_options[remove_admin_bar]" type="checkbox" value="1" <?php checked('1', isset($options['remove_admin_bar'])); ?> /></td>
                            </tr>
                            <tr>
                                <td>
                                    Site wide favicon
                                    <br />
                                    <span class="th-small">For good results please use 16px x 16px dimension for image.</span>
                                </td>
                                <td colspan="2">
                                    <input id="cms_blog_favicon" class="ui-widget-text" name="pands_script_plugin_options[blog_favicon]" type="hidden" value="<?php echo $options['blog_favicon']; ?>" />
                                    <a data-update="Set as Favicon" data-choose="Choose a Favicon" class="cms_upload_image_button button">Choose Image</a>
                                    <?php if (!empty($options['blog_favicon'])) { ?>
                                        <div class="img-prev-container">
                                            <a title="<?php _e('Remove') ?>" class="del-icon" href="javascript:void(0)"></a>
                                            <img src="<?php echo $options['blog_favicon'] ?>" style="max-width: 100%" />
                                        </div>
                                    <?php } ?>
                                </td>
                            </tr>
                        </table>
                        <br />
                        <table class="pands-cms-options-table">
                            <tr>
                                <td class="panel-title" colspan="2">Remove header meta tags</td>
                            </tr>
                            <tr>
                                <td>Remove RSD Link</td>
                                <td><input name="pands_script_plugin_options[remove_rsd_link]" type="checkbox" value="1" <?php checked('1', isset($options['remove_rsd_link'])); ?> /></td>
                            </tr>
                            <tr>
                                <td>Remove site RSS feeds</td>
                                <td><input name="pands_script_plugin_options[remove_site_feed_links]" type="checkbox" value="1" <?php checked('1', isset($options['remove_site_feed_links'])); ?> /></td>
                            </tr>
                            <tr>
                                <td>Remove comments RSS feeds</td>
                                <td><input name="pands_script_plugin_options[remove_comments_feed_links]" type="checkbox" value="1" <?php checked('1', isset($options['remove_comments_feed_links'])); ?> /></td>
                            </tr>
                            <tr>
                                <td>Remove WP Generator meta tag</td>
                                <td><input name="pands_script_plugin_options[remove_wp_generator]" type="checkbox" value="1" <?php checked('1', isset($options['remove_wp_generator'])); ?> /></td>
                            </tr>
                            <tr>
                                <td>Remove extra feed links</td>
                                <td><input name="pands_script_plugin_options[remove_feed_links_extra]" type="checkbox" value="1" <?php checked('1', isset($options['remove_feed_links_extra'])); ?> /></td>
                            </tr>
                            <tr>
                                <td>Remove WLW tag</td>
                                <td><input name="pands_script_plugin_options[remove_wlwmanifest_link]" type="checkbox" value="1" <?php checked('1', isset($options['remove_wlwmanifest_link'])); ?> /></td>
                            </tr>
                            <tr>
                                <td class="panel-title" colspan="2">Add dev elements</td>
                            </tr>
                            <tr>
                                <td>Google analytics<br /><span class="th-small">Only add the ID <i>ex: UA-XXXXXX-XX</i></span></td>
                                <td><input name="pands_script_plugin_options[google_analytics_number]" type="text" value="<?php echo $options['google_analytics_number']; ?>" /></td>
                            </tr>
                            <tr>
                                <td>Sitemap path<br /><span class="th-small">Add the absolute path to your sitemap to include it in your auto created robots.txt file.</span></td>
                                <td><input name="pands_script_plugin_options[sitemap_path]" type="text" value="<?php echo $options['sitemap_path']; ?>" /></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <input name="Submit" class="button-primary" type="submit" value="<?php esc_attr_e('Save Changes'); ?>" />
            </form></div></div>
    <?php
}
$options = get_option('pands_script_plugin_options');

function pands_admin_enqueue_scripts() {
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-tabs');
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    wp_enqueue_style('thickbox');

    wp_register_script('cms-script', plugin_dir_url(__FILE__) . 'js/cms_script.js', array('jquery', 'jquery-ui-tabs', 'media-upload', 'thickbox'));
    wp_localize_script('cms-script', 'siteurl', array('ajax' => admin_url('admin-ajax.php')));

    wp_enqueue_script('cms-script');

    wp_enqueue_style('cms_style', plugin_dir_url(__FILE__) . 'css/cms_style.css');
}

add_action('admin_enqueue_scripts', 'pands_admin_enqueue_scripts');

// REPLACE ADMIN WP LOGO
function pands_custom_admin_logo() {
    $options = get_option('pands_script_plugin_options');
    if (isset($options['admin_wp_logo']) == "") {
        echo '<style type="text/css">
   li#wp-admin-bar-wp-logo a, #wp-logo { background: url(' . get_bloginfo('wpurl') . '/favicon.png) no-repeat right !important}
   #wpadminbar .ab-wp-logo {display:block;height: 28px;width:16px;  background:none!important }</style>';
    } else {
        echo '<style type="text/css">
   li#wp-admin-bar-wp-logo a, #wp-logo { background: url(' . $options['admin_wp_logo'] . ') no-repeat right !important}
   #wpadminbar .ab-wp-logo {display:block;height: 28px;width:16px;  background:none!important }</style>';
    }
}

add_action('admin_head', 'pands_custom_admin_logo');

// HIDE REVISIONS
function pands_hide_revisions() {
    $options = get_option('pands_script_plugin_options');
    if (isset($options['revisionsdiv_panel']) == "") {
        echo '';
    } else {
        echo '<style>
    div.misc-pub-revisions {
      display: none!important;
      visibility: hidden!important

    }
  </style>';
    }
}

add_action('admin_head', 'pands_hide_revisions');


// LOGIN HEADER LOGO
function my_custom_login_logo() {
    $options = get_option('pands_script_plugin_options');
    if (isset($options['custom_admin_header_logo']) == "") {

    } else {
        echo '<style type="text/css">div#login h1 a { background-image:url(' . $options['custom_admin_header_logo'] . ')!important; width: 320px!important; background-size: 100% 100%!important } </style>';
    }
}

add_action('login_head', 'my_custom_login_logo');

// CUSTOM ADMIN LOGIN HEADER LINK & ALT TEXT
function change_wp_login_title() {
    if (is_user_logged_in()) {
        $options = get_option('custom_admin_login_header_link_alt_text');
        if (isset($options['custom_admin_login_header_link_alt_text']) == "") {
            echo get_option('blogname'); // OR ECHO YOUR OWN ALT TEXT
        } else {
            echo $options['custom_admin_login_header_link_alt_text'];
        }
    } else {}
}

add_filter('login_headertitle', 'change_wp_login_title');

// ADD FAVICON
function blog_favicon() {
    $options = get_option('pands_script_plugin_options');
    if (isset($options['blog_favicon']) == "") {
        echo '<link rel="Shortcut Icon" type="image/x-icon" href="' . get_bloginfo('wpurl') . '/favicon.png" />';
    } else {
        echo '<link rel="Shortcut Icon" type="image/x-icon" href="' . $options['blog_favicon'] . '" />';
    }
}
add_action('wp_head', 'blog_favicon');

// HIDE ADMIN SCREEN OPTIONS TAB
function pands_remove_screen_options_tab() {
    $options = get_option('pands_script_plugin_options');
}

if (isset($options['remove_screen_options_tab']) == 1)
    add_filter('screen_options_show_screen', '__return_false');

// HIDE ADMIN HELP TAB
function pands_hide_help_tab() {
    $options = get_option('pands_script_plugin_options');
    echo '<style type="text/css">
            #contextual-help-link-wrap { display: none !important; }
          </style>';
}
if (isset($options['hide_help_tab']) == 1)
    add_action('admin_head', 'pands_hide_help_tab');

// REMOVE META BOXES FROM DEFAULT PAGES SCREEN
function pands_remove_boxes() {
    $options = get_option('pands_script_plugin_options');
    // -- * For posts * -- //
    if (isset($options['postcustom_post']) == 1)
        remove_meta_box('postcustom', 'post', 'normal');
    if (isset($options['postexcerpt_post']) == 1)
        remove_meta_box('postexcerpt', 'post', 'normal');
      // REVIEW

    if (isset($options['trackbacksdiv_post']) == 1)
        remove_meta_box('trackbacksdiv', 'post', 'normal');
    if (isset($options['commentsdiv_post']) == 1)
        remove_meta_box('commentsdiv', 'post', 'normal');
    if (isset($options['discussiondiv_post']) == 1)
        remove_meta_box('commentstatusdiv', 'post', 'normal');
   if (isset($options['revisionsdiv_post']) == 1)
       remove_meta_box('revisionsdiv', 'post', 'normal');
    if (isset($options['slugdiv_post']) == 1)
        remove_meta_box('slugdiv', 'post', 'normal');
    if (isset($options['authordiv_post']) == 1)
        remove_meta_box('authordiv', 'post', 'normal');
    if (isset($options['categorydiv_post']) == 1)
        remove_meta_box('categorydiv', 'post', 'normal');
    if (isset($options['tagsdiv-post_tag_post']) == 1)
        remove_meta_box('tagsdiv-post_tag', 'post', 'normal');
    if (isset($options['submitdiv_post']) == 1)
        remove_meta_box('submitdiv', 'post', 'normal');

    // -- * For pages * -- //
    if (isset($options['postcustom_page']) == 1)
        remove_meta_box('postcustom', 'page', 'normal');
    if (isset($options['commentsdiv_page']) == 1)
        remove_meta_box('commentsdiv', 'page', 'normal');
    if (isset($options['discussiondiv_page']) == 1)
        remove_meta_box('commentstatusdiv', 'page', 'normal');
    if (isset($options['revisionsdiv_page']) == 1)
        remove_meta_box('revisionsdiv', 'page', 'normal');
    if (isset($options['slugdiv_page']) == 1)
        remove_meta_box('slugdiv', 'page', 'normal');
    if (isset($options['authordiv_page']) == 1)
        remove_meta_box('authordiv', 'page', 'normal');
    if (isset($options['pageparentdiv_page']) == 1)
        remove_meta_box('pageparentdiv', 'page', 'normal');
    if (isset($options['submitdiv_page']) == 1)
        remove_meta_box('submitdiv', 'page', 'normal');
}

// REMOVE FEATURED IMAGE PANELS
add_action('do_meta_boxes', 'remove_thumbnail_box');
function remove_thumbnail_box() {
  $options = get_option('pands_script_plugin_options');
    if (isset($options['postimagediv_post']) == 1)
      remove_meta_box( 'postimagediv','post','side' );

    if (isset($options['postimagediv_page']) == 1)
      remove_meta_box( 'postimagediv','page','side' );
}
add_action('admin_init', 'pands_remove_boxes');

// DISABLE DEFAULT DASHBOARD WIDGETS
function disable_default_dashboard_widgets() {
    $options = get_option('pands_script_plugin_options');
    if (isset($options['dashboard_activity']) == 1)
        remove_meta_box('dashboard_activity', 'dashboard', 'core');
    if (isset($options['dashboard_quick_press']) == 1)
        remove_meta_box('dashboard_quick_press', 'dashboard', 'core');
    if (isset($options['dash-right-now']) == 1)
        remove_meta_box('dashboard_right_now', 'dashboard', 'core');
    if (isset($options['welcome_panel']) == 1)
        remove_action('welcome_panel', 'wp_welcome_panel');
    if (isset($options['dashboard_primary']) == 1)
        remove_meta_box('dashboard_primary', 'dashboard', 'core');
}
add_action('admin_menu', 'disable_default_dashboard_widgets');

// REMOVE DEFAULT WIDGETS //
function my_unregister_widgets() {
    $options = get_option('pands_script_plugin_options');
    if (isset($options['WP_Widget_Pages']) == 1)
        unregister_widget('WP_Widget_Pages');
    if (isset($options['WP_Widget_Meta']) == 1)
        unregister_widget('WP_Widget_Meta');
    if (isset($options['WP_Widget_Calendar']) == 1)
        unregister_widget('WP_Widget_Calendar');
    if (isset($options['WP_Widget_Archives']) == 1)
        unregister_widget('WP_Widget_Archives');
    if (isset($options['WP_Widget_Categories']) == 1)
        unregister_widget('WP_Widget_Categories');
    if (isset($options['WP_Widget_Recent_Posts']) == 1)
        unregister_widget('WP_Widget_Recent_Posts');
    if (isset($options['WP_Widget_Search']) == 1)
        unregister_widget('WP_Widget_Search');
    if (isset($options['WP_Widget_Tag_Cloud']) == 1)
        unregister_widget('WP_Widget_Tag_Cloud');
    if (isset($options['WP_Widget_RSS']) == 1)
        unregister_widget('WP_Widget_RSS');
    if (isset($options['WP_Widget_Tag_Cloud']) == 1)
        unregister_widget('WP_Widget_Tag_Cloud');
    if (isset($options['WP_Widget_Recent_Comments']) == 1)
        unregister_widget('WP_Widget_Recent_Comments');
    if (isset($options['WP_Nav_Menu_Widget']) == 1)
        unregister_widget('WP_Nav_Menu_Widget');
    if (isset($options['WP_Widget_Text']) == 1)
        unregister_widget('WP_Widget_Text');
}

add_action('widgets_init', 'my_unregister_widgets');

// PUT SITE IN MAINENANCE MODE
function pands_maintenace_mode() {
    $options = get_option('pands_script_plugin_options');
    if (isset($options['maintenance_mode']) == "") {

    } else {
        if (!current_user_can('administrator')) {
            wp_die('' . $options['maintenance_message'] . '');
        }
    }
}

add_action('get_header', 'pands_maintenace_mode');

// REMOVE MENU ITEMS
function remove_admin_menus() {
    $options = get_option('pands_script_plugin_options');
    if (isset($options['link-manager_menu_item']) == 1)
        remove_menu_page('link-manager.php'); // Links
    if (isset($options['edit-comments_menu_item']) == 1)
        remove_menu_page('edit-comments.php'); // Comments
    if (isset($options['tools_menu_item']) == 1)
        remove_menu_page('tools.php'); // Tools
    if (isset($options['themes_menu_item']) == 1)
        remove_menu_page('themes.php'); // Appearance
    if (isset($options['upload_menu_item']) == 1)
        remove_menu_page('upload.php'); // Media
    if (isset($options['edit_menu_item']) == 1)
        remove_menu_page('edit.php?post_type=page'); // Pages
    if (isset($options['plugins_menu_item']) == 1)
        remove_menu_page('plugins.php'); // Plugins
    if (isset($options['posts_menu_item']) == 1)
        remove_menu_page('edit.php'); // Posts
    if (isset($options['users_menu_item']) == 1)
        remove_menu_page('users.php'); // Users
    if (isset($options['options-general_menu_item']) == 1)
        remove_menu_page('options-general.php'); // Settings
}

add_action('admin_menu', 'remove_admin_menus');

// REMOVE SUBMENUS
function remove_submenus() {
    $options = get_option('pands_script_plugin_options');
    global $submenu;

    if (isset($options['updates_submenu']) == 1)
        unset($submenu['index.php'][10]); // Removes 'Updates'
    if (isset($options['themes_submenu']) == 1)
        unset($submenu['themes.php'][5]); // Removes 'Themes'
    if (isset($options['widgets_submenu']) == 1)
        unset($submenu['themes.php'][7]); // Removes 'Widgets'
    if (isset($options['menu_submenu']) == 1)
        unset($submenu['themes.php'][10]); // Removes 'Menu'
    if (isset($options['tags_submenu']) == 1)
        unset($submenu['edit.php'][16]); // Removes 'Tags'
    if (isset($options['plugin_editor_submenu']) == 1)
        unset($submenu['plugins.php'][15]); // Removes 'Plugin editor'
    if (isset($options['writing_submenu']) == 1)
        unset($submenu['options-general.php'][15]); // Removes 'Writing'
    if (isset($options['discussion_submenu']) == 1)
        unset($submenu['options-general.php'][25]); // Removes 'Discussion'
    if (isset($options['media_submenu']) == 1)
        unset($submenu['options-general.php'][30]); // Removes 'Media'
    if (isset($options['general_submenu']) == 1)
        unset($submenu['options-general.php'][10]); // Removes 'General'
    if (isset($options['reading_submenu']) == 1)
        unset($submenu['options-general.php'][20]); // Removes 'Reading'
    if (isset($options['permalinks_submenu']) == 1)
        unset($submenu['options-general.php'][40]); // Removes 'Permalinks'
    if (isset($options['available_tools_submenu']) == 1)
        unset($submenu['tools.php'][5]); // Removes 'Available tools'
    if (isset($options['export_submenu']) == 1)
        unset($submenu['tools.php'][15]); // Removes 'Export'
    if (isset($options['import_submenu']) == 1)
        unset($submenu['tools.php'][10]); // Removes 'Import'
    if (isset($options['customize_submenu']) == 1)
        unset($submenu['themes.php'][6]); // Removes 'Customize'
}

add_action('admin_menu', 'remove_submenus');

// REMOVE THEME EDITOR SUBMENU
function remove_editor_menu() {
    $options = get_option('pands_script_plugin_options');
    if (isset($options['theme_editor_submenu']) == 1) {
        remove_action('admin_menu', '_add_themes_utility_last', 101);
    }
}

add_action('_admin_menu', 'remove_editor_menu', 1);

// REMOVE HEADER TAT
if (isset($options['remove_rsd_link']) == 1)
    remove_action('wp_head', 'rsd_link');
if (isset($options['remove_wp_generator']) == 1)
    remove_action('wp_head', 'wp_generator');
if (isset($options['remove_site_feed_links']) == 1)
    remove_action('wp_head', 'feed_links', 2);
if (isset($options['remove_comments_feed_links']) == 1)
    remove_action('wp_head', 'automatic_feed_links', 3);
if (isset($options['remove_wlwmanifest_link']) == 1)
    remove_action('wp_head', 'wlwmanifest_link');
if (isset($options['remove_feed_links_extra']) == 1)
    remove_action('wp_head', 'feed_links_extra', 3);
if (isset($options['remove_admin_bar']) == 1)
    add_filter('show_admin_bar', '__return_false');

// REJIG WP SUBMENU
function sl_dashboard_tweaks_render() {
    global $wp_admin_bar;
    $wp_admin_bar->add_menu(array(
        'id' => 'wp-logo',
        'title' => '<span class="sl-dashboard-logo"></span>',
        'href' => is_admin() ? home_url('/') : admin_url(),
        'meta' => array(
            'title' => __('Visit the Frontend of your website'),
        ),
    ));
    $wp_admin_bar->remove_menu('about');
    $wp_admin_bar->remove_menu('wporg');
    $wp_admin_bar->remove_menu('documentation');
    $wp_admin_bar->remove_menu('support-forums');
    $wp_admin_bar->remove_menu('feedback');
    $wp_admin_bar->remove_menu('view-site');
}
add_action('wp_before_admin_bar_render', 'sl_dashboard_tweaks_render');

function custom_pages_columns($defaults) {
    unset($defaults['comments']);
    return $defaults;
}
add_filter('manage_pages_columns', 'custom_pages_columns');

// CUSTOM COMMENTS
function wp_threaded_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(); ?>>
        <div class="comment clearfix">
            <div class="ct-avatar"><?php echo get_avatar($comment, 20); ?></div>
            <span class="ct-author"><?php if (get_comment_author_url()) : ?><a href="<?php echo get_comment_author_url(); ?>"><?php comment_author(); ?></a><?php else : ?><?php comment_author(); ?><?php endif; ?></span>
            <span class="ct-date"><?php printf(__('%1$s at %2$s', ''), get_comment_date(), get_comment_time()); ?></span>
            <div class="ct-text clearfix" id="comment-<?php comment_ID() ?>">
                <?php comment_text(); ?>
                <?php if ($comment->comment_approved == '0'): ?><p class="warning"><?php _e('Your comment is awaiting moderation.', 'mystique'); ?></p><?php endif; ?>
                <div class="clearfix">
                    <?php
                    if (function_exists('comment_reply_link')) {
                        comment_reply_link(array_merge($args, array('add_below' => 'comment-reply', 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => 'Reply &not;')));
                    }
                    ?>
                </div>
                <a id="comment-reply-<?php comment_ID() ?>"></a>
            </div>
        </div>
        <?php
    }

    function cms_db_widget_content_handler() {

    }

    // Add dashboard widgets
    function pands_cms_add_dashboard_widgets() {
        $options = get_option('pands_script_plugin_options');

        if (isset($options['dashboard_panels']) && is_array($options['dashboard_panels'])) {
            foreach ($options['dashboard_panels'] as $key => $widget) {

//                $options['dashboard_panels'] = array();
//                update_option('pands_script_plugin_options',$options);
//                echo '<pre>';
//                print_r($options['dashboard_panels']);
//                exit;

                if (!empty($widget['active']) && $widget['active'] == 1) {
                    wp_add_dashboard_widget($key, $widget['title'], 'cms_db_widget_content_handler');
                }
            }
        }
    }

    add_action('wp_dashboard_setup', 'pands_cms_add_dashboard_widgets');

    add_action('wp_ajax_get_db_panel_content', 'cms_ajax_get_db_panel');

    function cms_ajax_get_db_panel() {
        $id = $_POST['id'];
        $options = get_option('pands_script_plugin_options');

        if (isset($options['dashboard_panels']) && is_array($options['dashboard_panels'])) {
            if (isset($options['dashboard_panels'][$id])) {
                $widget = $options['dashboard_panels'][$id];
                $filtered_content = apply_filters('the_content', $widget['content']);
                echo $filtered_content;
            }
        }

        exit;
    }

    add_action('wp_ajax_add_db_panel', 'cms_ajax_add_db_panel');

    function cms_ajax_add_db_panel() {
        $options = get_option('pands_script_plugin_options');
        $id = uniqid('db_panel_');
        $options['dashboard_panels'][$id] = array('id' => $id, 'title' => '', 'content' => '', 'active' => 0);
        update_option('pands_script_plugin_options', $options);
        exit;
    }

// OPTIONAL - AUTO CREATE ROBOTS.TXT FILE
// ADAPT AS REQUIRED
    function mytheme_robots() {
        $options = get_option('pands_script_plugin_options');

        echo "Disallow: /cgi-bin\n";
        echo "Disallow: /wp-admin\n";
        echo "Disallow: /wp-includes\n";
        echo "Disallow: /tag\n";
        echo "Disallow: /wget\n";
        echo "Disallow: /httpd\n";
        echo 'Disallow: ' . $url = content_url() . "\n";
        echo 'Disallow: ' . $url = plugins_url() . "\n";
        echo 'Disallow: ' . $url = content_url() . "/cache\n";
        echo 'Disallow: ' . $url = content_url() . "/themes\n";
        echo 'Disallow: ' . $url = content_url() . "/upgrade\n";
        echo 'Disallow: ' . $url = content_url() . "/uploads\n";
        echo "Disallow: /trackback\n";
        echo "Disallow: /comments\n";
        echo "Disallow: /category/*/*\n";
        echo "Disallow: */trackback\n";
        echo "Disallow: */feed\n";
        echo "Disallow: */comments\n";
        echo "Disallow: /*?*\n";
        echo "Disallow: /*?\n";
        echo "Disallow: */print\n\n";

        echo "User-agent: Googlebot-Image\n";
        echo "Disallow:/* \n\n";

        echo "User-agent: Mediapartners-Google*\n";
        echo "Disallow:/* \n\n";

        echo "User-agent: Adsbot-Google\n";
        echo "Disallow: /\n\n";

        echo "User-agent: Googlebot-Mobile\n";
        echo "Allow: /\n\n";

        echo "User-agent: duggmirror\n";
        echo "Disallow:/* \n\n";

        echo 'Sitemap: ' . $options['sitemap_path'] . '';
    }

    add_action('do_robots', 'mytheme_robots');

// ADMIN FOOTER STUFF
    function modify_footer_admin() {
        $options = get_option('pands_script_plugin_options');
        echo '<a href="' . $options['company_url'] . '"><img src="' . $options['favicon_company_url'] . '" /></a> ' . get_bloginfo('name') . ' online presence developed by <a href="' . $options['company_url'] . '">' . $options['company_name'] . '</a>.';
    }

    add_filter('admin_footer_text', 'modify_footer_admin');

    function change_footer_version() {
        $options = get_option('pands_script_plugin_options');
        return 'Version ' . $options['footer_ver'];
    }

    if (isset($options['footer_ver']) != "")
        add_filter('update_footer', 'change_footer_version', 9999);

// ADD GOOGLE ANALYTICS TRACKING CODE
    function add_google_analytics() {
        $options = get_option('pands_script_plugin_options');
        ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $options['google_analytics_number']; ?>"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', '<?php echo $options['google_analytics_number']; ?>');
        </script>
        <?php
    }

    if (isset($options['google_analytics_number']) != "")
        add_action('wp_head', 'add_google_analytics');
    ?>