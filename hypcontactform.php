<?php
/**
 * @package HypContactForm
 * @version 1.0
 *
 * Plugin Name: Hyp Contact Form
 * Plugin URI: https://github.com/JuniorTak
 * Description: This is a simple plugin to generate a contact form for users to add into their website
 * Version: 1.0
 * Author: Hyppolite Takoua Foduop
 * Author URI: https://www.hyppolitetakouafoduop.online
 * License: GPLv2 or later
 * Text Domain: hypcontactform
 */

define( 'HCF_PATH', WP_PLUGIN_URL . '/' . plugin_basename( __DIR__ ) . '/' );
define( 'HCF_NAME', 'Hyp Contact Form' );
define( 'HCF_VERSION', '1.0' );
define( 'HCF_SLUG', 'hyp-contact-form' );

/**
 * Building the form
 *
 * @param string $send_to The recepient email address.
 * @param string $subject The email subject.
 * @return string
 */
function hcf_build_form( $send_to, $subject ) {

	// Processing the form.
	if ( isset( $_POST['hcf-submit'] ) ) {
		include 'class-hypprocessform.php';
		$hcf_processor = new HypProcessForm( $send_to );
		if ( isset( $_POST['hcf-email'] ) ) {
			$message = $hcf_processor->email( $subject, $hcf_processor->build_msg( $_POST ), sanitize_text_field( wp_unslash( $_POST['hcf-email'] ) ) );
			print '<h3>' . esc_html( $message ) . '</h3>';
		}
	}

	$form = '<div class="' . HCF_SLUG . '">
                <form name="' . HCF_SLUG . '" method="POST">
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

/**
 * For shortcode usage
 *
 * @param array $atts The shortcode attribut.
 * @return string
 */
function hcf_insert_form( $atts ) {

	extract(
		shortcode_atts(
			array(
				'send_to' => get_bloginfo( 'admin_email' ),
				'subject' => 'Contact Form from ' . get_bloginfo( 'name' ),
			),
			$atts
		)
	);

	$form = hcf_build_form( $send_to, $subject );

	return $form;
}
add_shortcode( 'hcf_form', 'hcf_insert_form' );

/**
 * For template tag usage
 *
 * @param string $send_to The recepient email address.
 * @param string $subject The email subject.
 * @return void
 */
function hcf_get_form( $send_to = '', $subject = '' ) {

	$send_to = ( $send_to === '' ) ? get_bloginfo( 'admin_email' ) : $send_to;
	$subject = ( $subject === '' ) ? 'Contact Form from ' . get_bloginfo( 'name' ) : $subject;
	print esc_html( hcf_build_form( $send_to, $subject ) );
}
