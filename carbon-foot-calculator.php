<?php
/**
 * Plugin Name: Calculador de Impacto Ambiental 1.0
 * Description: Este plugin calcula el impacto ambiental
 * Version: 1.0.0
 * Author: Manuel Jesús Aguair Gámez
 * License: GPL2
 */


 if(!defined('ABSPATH')) die();

 define("TEST_DIR", __FILE__);
 define("TEST_PLUGIN_DIR", plugin_dir_path(TEST_DIR));
 define("TEST_PLUGIN_URL", plugin_dir_url(TEST_DIR));


/*
 add_shortcode( "carbon-foot-calculator", function($atts, $content){
    return '';
 }*/

 require_once TEST_PLUGIN_DIR."includes/classes/main.php";
 require_once TEST_PLUGIN_DIR."includes/classes/main.php";
 $main = new main;

 register_activation_hook( TEST_DIR, [$main, 'activate'] );
 register_deactivation_hook( TEST_DIR, [$main, 'deactivate'] );

 add_shortcode( "carbon-foot-calculator", function($atts, $content){
    return '';
 }