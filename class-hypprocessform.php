<?php
/**
 * @package HypProcessForm
 */

/**
 * HypProcessForm class
 */
class HypProcessForm {

	/**
	 * The recepient email address
	 *
	 * @var string
	 */
	private $to;

	/**
	 * Constructor
	 *
	 * @param string $send_to The recepient email address.
	 */
	public function __construct( $send_to ) {
		$this->to = $send_to;
	}

	/**
	 * Building the email message to send
	 *
	 * @param array $arr The email data collection.
	 */
	public function build_msg( $arr ) {

		$built_msg = 'Name: ' . $arr['hcf-name'] . "\nEmail: " . $arr['hcf-email'] . "\nMessage: " . $arr['hcf-message'];

		return $built_msg;
	}

	/**
	 * Sending email
	 *
	 * @param string $subject The email subject.
	 * @param string $message The email message.
	 * @param string $from The sender email address.
	 * @param string $msg The confirmation message.
	 */
	public function email( $subject, $message, $from = null, $msg = 'Thanks! Your message has been sent.' ) {

		try {
			mail( $this->to, $subject, $message, "From: $from" );
		} catch ( \Throwable $th ) {
			$msg = 'Sorry! An error occurs when submitting sur message.';
		}

		return $msg;
	}
}
