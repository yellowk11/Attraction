<?php
/*
    Plugin Name: Accessibility Assistant
    Plugin URI: https://accessibility-assistant.cartcoders.com/
    Description: With Accessibility Assistant, blind and visually impaired people have the ease of access to become more independent and integration with the Digital world, which replicates their daily lives
    Author: CartCoder
    Version: 1.2
    License: GPLv2 or later
    License URI: https://www.gnu.org/licenses/gpl-2.0.html
    Requires at least: 5.0
    Requires PHP:      5.0
    Author URI: https://cartcoders.com/
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define('ASSISTANT_URL', 'https://accessibility-assistant.cartcoders.com');
define('ASSISTANT_API_URL', ASSISTANT_URL.'/v1');


// During Activatation 
register_activation_hook(__FILE__,'accessibility_activatation');

if ( ! function_exists( 'accessibility_activatation' ) ) {
function accessibility_activatation()
{

  $plugin_data = get_plugin_data( __FILE__ );
  $plugin_version = $plugin_data['Version'];
    update_option('accessibility_install', 0);  
    $rand = (time() * mt_rand());
    $shopid = ($rand.strftime("%m", time()).substr(strftime("%Y", time()),2)); 
    if(get_option('accessibility_shopid') != null AND get_option('accessibility_tokken')!= null)
    {
        $shopid = get_option('accessibility_shopid');
        $token = get_option('accessibility_tokken');
        $url = get_option('accessibility_url');

    }
    $init_data = array(
        'shopid' => $shopid,
        'status' => 1,
        'isUninstall' => 0, 
        'timestamp' => time(),
        'name' => (get_bloginfo('name')),
        'email' => (get_option('admin_email')),
        'domain' => (get_bloginfo('url')),
        'wordpress_version'=> $plugin_version,
        );
    $type = 'post';
     $body = assistant_api_call('/install', $init_data,$type);
  
    if ($body['status'] == 200 && count($body['data']) > 0) {
        $response = $body['data'];
        update_option('accessibility_shopid',sanitize_text_field($response['shopid']));
        update_option('accessibility_tokken',sanitize_text_field($response['token']));
        update_option('accessibility_url',sanitize_text_field($response['url']));
        update_option('accessibility_install',1);
    }
   
}
}

// During Deactivatation
register_deactivation_hook( __FILE__, 'accessibility_deactivation' );

if ( ! function_exists( 'accessibility_deactivation' ) ) {
function accessibility_deactivation()
{
  $shopid = get_option('accessibility_shopid');
  $deactive_data = array(
    'shopid' => $shopid,
    );
  $body = assistant_api_call('/uninstallShopData', $deactive_data,'get');
  update_option('accessibility_install', 0);  
}
}
// Add Js And Style Sheet.

add_action( 'admin_enqueue_scripts', 'accessibility_load_admin_styles' );
function accessibility_load_admin_styles() {
 
  wp_enqueue_style( 'admin_accesibility_css', plugin_dir_url(__FILE__) . '/assets/stylesheet.css', false, '1.0.0' );
  wp_enqueue_style( 'accesibility_bootstrap_css', plugin_dir_url(__FILE__) . '/assets/bootstrap/css/bootstrap.min.css', false, '4.4.1' );
  wp_enqueue_script( 'admin_accesibility_js', plugin_dir_url(__FILE__) . '/assets/bootstrap/js/bootstrap.bundle.min.js', false, '4.4.1' );

 } 

//API Send function Call through path and data......
if ( ! function_exists( 'assistant_api_call' ) ) {
function assistant_api_call($path, $fields,$type)
{
  $url = ASSISTANT_API_URL.$path;
  $apidata = array(
    'body' => $fields,
    'timeout' => '15',
    'redirection' => '5',
    'httpversion' => '1.0',
    'blocking' => true,
    'headers' => array(),
    'cookies' => array()
  );
if($type == 'post')
{
  $response = wp_remote_post($url, $apidata);
}else
{
    $response = wp_remote_get($url, $apidata);
}
 // return $response;
  $body = wp_remote_retrieve_body($response);
  return json_decode($body, true);
}
}

/* Describe what the code snippet does so you can remember later on */
add_action('wp_footer', 'accessibility_addjsfooter');
function accessibility_addjsfooter(){
$url = get_option('accessibility_url'); 
if(!empty($url)){
  wp_enqueue_script( 'frontfooter_accesibility_js',$url, false, '1.0' );
}
}
if(is_admin())
{
require_once 'admin/accessibility_assistant_admin.php';
}


add_action('admin_notices', 'accessibility_installadmin_notice');
function accessibility_installadmin_notice(){
  $accessibility_install = get_option('accessibility_install');
  if ( (get_option('accessibility_shopid')) == null || (get_option('accessibility_install')) == 0) {
  echo '<div class="notice notice-error is-dismissible"><p>Please unistall this plugin and Again install it..</p></div>';
  }
}