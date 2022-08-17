<?php

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

global $wpdb;

$sql = "DROP TABLE {$wpdb->prefix}shedule_event";
$sql2 = "DROP TABLE {$wpdb->prefix}shedule_instructor";

$wpdb->query($sql);
$wpdb->query($sql2);

?>