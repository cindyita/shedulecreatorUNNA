<?php

if(!defined(WP_UNINSTALL_PLUGIN)) die();

global $wpdb;

$sql_del1 = "DELETE TABLE {$wpdb->prefix}shedule_event";
$sql_del2 = "DELETE TABLE {$wpdb->prefix}shedule_instructor";

$wpdb->query($sql_del1);
$wpdb->query($sql_del2);

?>