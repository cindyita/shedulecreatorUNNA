<?php

class principal{

    function active(){

        global $wpdb;

        $sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}shedule_event(
            `eventoid` INT NOT NULL AUTO_INCREMENT,
            `nombre` VARCHAR(150) NULL,
            `imageLink` VARCHAR(250) NULL,
            `fechahorainicio` DATETIME NULL,
            `fechahorafin` DATETIME NULL,
            `instructorIdAssign` INT NULL,
            `descripcion` VARCHAR(500) NULL,
            `linkevent` VARCHAR(250) NULL,
            `linkcalendar` VARCHAR(250) NULL,
            `shortcode` VARCHAR(45) NULL,
            `timestamp` TIMESTAMP,
            PRIMARY KEY(`eventoid`)
        );";

        $sql2 = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}shedule_instructor(
            `instructorid` INT NOT NULL AUTO_INCREMENT,
            `nombre` VARCHAR(45) NULL,
            `cargo` VARCHAR(45) NULL,
            `imageLink` VARCHAR(250) NULL,
            `descripcion` VARCHAR(500) NULL,
            `instagramLink` VARCHAR(250) NULL,
            `whatsapp` VARCHAR(45) NULL,
            `shortcode` VARCHAR(45) NULL,
            `linkcategoria` VARCHAR(250) NULL,
            `timestamp` TIMESTAMP,
            PRIMARY KEY(`instructorid`)
        );";

        $sql3 = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}shedule_registrations(
            `registerid` INT NOT NULL AUTO_INCREMENT,
            `userid` INT(11) NULL,
            `eventid` INT(11) NULL,
            `timestamp` TIMESTAMP,
            PRIMARY KEY(`registerid`)
        );";

        $wpdb->query($sql);
        $wpdb->query($sql2);
        $wpdb->query($sql3);

        /*

        if(!username_exists("scheduler")) {

            $password = wp_generate_password( 12,false,false);

            $user = [
                "user_pass" => $password,
                "user_login" => "sheduler",
                "user_email" => "cindy_al25@hotmail.com",
                "nickname" => "sheduler01",
                "first_name" => "user",
                "last_name" => "userlastname",
                "role" => "administrator"
            ];

            wp_insert_user($user); 
        }
        
        */
    }

    function desactive(){

    }


}

?>