<?php
/**
 * @package Hyp_Contact_Form
 * @version 1.0
 */
/*
Plugin Name: Hyp Contact Form
Plugin URI: https://github.com/JuniorTak
Description: This is a simple plugin to generate a contact form for users to add into their website
Version: 1.0
Author: Hyppolite Takoua Foduop
Author URI: https://www.hyppolitetakouafoduop.online
License: GPLv2 or later
Text Domain: hypcontactform
*/

define('HCF_PATH', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );
define('HCF_NAME', "Hyp Contact Form");
define ("HCF_VERSION", "1.0");
define ("HCF_SLUG", 'hyp-contact-form');

/* Building the form */
function hcf_build_form($sendTo, $subject){

    /* Processing the form */
    if(isset($_POST['hcf-submit'])){
        include('hypprocessform.php');
        $hcfProcessor= new HypProcessForm($sendTo);
        $message= $hcfProcessor->email($subject, $hcfProcessor->buildMsg($_POST), $_POST['hcf-email']);
        print "<h3>$message</h3>";
    }
    
    $form= '<div class="'. HCF_SLUG . '">
                <form name="'. HCF_SLUG . '" method="POST">
                    <div>
                        <label for="hcf-name">Name:</label><br/>
                        <input type="text" name="hcf-name" required="required" placeholder="ex David Colman" />
                    </div>
                    <div>
                        <label for="hcf-email">Email:</label><br/>
                        <input type="email" name="hcf-email" required="required" placeholder="ex david@example.com" />
                    </div>
                    <div>
                        <label for="hcf-message">Message:</label><br/>
                        <textarea name="hcf-message" required="required"></textarea>
                    </div>
                    <div>
                        <input type="submit" name="hcf-submit" value="Submit" />
                    </div>
                </form>
            </div>';
    
    return $form;

}

/* For shortcode */
function hcf_insert_form($atts, $content=null){

    extract(shortcode_atts( array(
        'sendto' => get_bloginfo('admin_email'),
        'subject' => 'Contact Form from '. get_bloginfo('name')
    ), $atts));

    $form = hcf_build_form($sendto, $subject);
    
    return $form;

}
add_shortcode('hcf_form', 'hcf_insert_form');

/* For template tag */
function hcf_get_form($sendto="", $subject=""){
    
    $sendto= ($sendto == "") ? get_bloginfo('admin_email') : $sendto;
    $subject= ($subject == "") ? 'Contact Form from '. get_bloginfo('name') : $subject;
    print hcf_build_form($sendto, $subject);

}

?>