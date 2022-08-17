<?php
/*
Plugin Name: Shedule creator UNNA
Description:  Creador de itinerarios para UNNA
Author: cindy ita
Version: BETA 1.0.3
*/

if (!defined('ABSPATH')) die();


define("SHEDULER_DIR", __FILE__);
define("SHEDULER_PLUGIN_DIR", plugin_dir_path(SHEDULER_DIR));
define("SHEDULER_PLUGIN_URL", plugin_dir_url(SHEDULER_DIR));
define("SHEDULER_PLUGIN_NAME", "SHEDULER PLUGIN");
define("SHEDULER_CANT_ELEMENTS_SHOW", 12);

require_once SHEDULER_PLUGIN_DIR . '/clases/principal.php';
require_once SHEDULER_PLUGIN_DIR . '/clases/shortcodeEvent.php';
require_once SHEDULER_PLUGIN_DIR . '/clases/shortcodeInstructor.php';
require_once SHEDULER_PLUGIN_DIR . '/clases/shortcodeNextSession.php';
require_once SHEDULER_PLUGIN_DIR . '/clases/shortcodeOverview.php';

$principal = new principal;

register_activation_hook(SHEDULER_DIR, array($principal, "active"));

register_deactivation_hook(SHEDULER_DIR, array($principal, "desactive"));

add_action("admin_bar_menu", "menusuperior", 100);

function menusuperior($bar)
{
/* $bar->remove_node("comments");*/

if (!current_user_can("manage_options")) return;

$bar->add_menu(array(
"id" => "new_event",
"title" => "Nuevo evento",
"href" => SHEDULER_DIR . "?page=sp_menu_ajustes",
"parent" => "new-content"
));
}

add_action("admin_menu", "createmenu");

function createmenu()
{

if (!current_user_can("manage_options")) return;

add_menu_page(
'Creador de itinerario UNNA', //titulo de la pagina
'Shedule creator', // titulo del menu
'manage_options', //capability
plugin_dir_path(__FILE__) . 'admin/list_shedule.php', //slug
null, //funcion del contenido
plugin_dir_url(__FILE__) . 'admin/img/shedule.png', //icon
'3' //position
);

/*
add_submenu_page(
"sp_menu", //parent slug
"Nuevo evento", //titulo pagina
"Nuevo evento", //titulo menu
"manage_options", //capability
"sp_menu_ajustes", //nombre
"nuevoevento" //funcion
);
*/
}

/*
function nuevoevento(){
echo "<h1>Crear nuevo evento</h1>";
}
*/

// Enqueu script

function dcms_insert_script_upload()
{
wp_enqueue_media();
wp_register_script('my_upload', plugin_dir_url(__FILE__) . '/admin/upload.js', array('jquery'), '1', true);
wp_enqueue_script('my_upload');
}
add_action("admin_enqueue_scripts", "dcms_insert_script_upload");

//encolar js propio

function EncolarJS($hook)
{
if ($hook != "shedule-creator/admin/list_shedule.php") {
return;
}
wp_enqueue_script('JsExterno', plugins_url('admin/shedule.js', __FILE__), array('jquery'));
wp_localize_script('JsExterno', 'sAjax', [
'url' => admin_url('admin-ajax.php'),
'seguridad' => wp_create_nonce('seg')
]);
}
add_action('admin_enqueue_scripts', 'EncolarJS');

function deleteShedule()
{
$nonce = $_POST['nonce'];
if (!wp_verify_nonce($nonce, 'seg')) {
die('no tiene permisos para ejecutar el ajax');
}

$id = $_POST['id'];
global $wpdb;
$tabla_shedule = "{$wpdb->prefix}shedule_event";
$wpdb->delete($tabla_shedule, array('eventoid' => $id));
return true;
}

add_action('wp_ajax_deleteshedule', 'deleteShedule');

function deleteinstructor()
{
$nonce = $_POST['nonce'];
if (!wp_verify_nonce($nonce, 'seg')) {
die('no tiene permisos para ejecutar el ajax');
}

$id = $_POST['id'];
global $wpdb;
$tabla_instructor = "{$wpdb->prefix}shedule_instructor";
$wpdb->delete($tabla_instructor, array('instructorid' => $id));
return true;
}

add_action('wp_ajax_deleteinstructor', 'deleteinstructor');

//Shortcodes

function showShortcodeEvent($atts)
{
$_shortcodeEvent = new shortcodeEvent;
$id = $atts['id'];
$html = $_shortcodeEvent->showEvent($id);
return $html;
}

add_shortcode("SH_EVENT", "showShortcodeEvent");

function showRecentEvents()
{
$_shortcode = new shortcodeNextSession;
$html = $_shortcode->showEvent();
return $html;
}

add_shortcode("SH_RECENT_EVENT", "showRecentEvents");

function showInstructor($atts)
{
$_shortcode = new shortcodeInstructor;
$id = $atts['id'];
$html = $_shortcode->showInstructor($id);
return $html;
}

add_shortcode("SH_INSTRUCTOR", "showInstructor");

function showOverview()
{
$_shortcode = new shortcodeOverview;
$html = $_shortcode->showOverview();
return $html;
}

add_shortcode("SH_ALL_EVENTS", "showOverview");

?>