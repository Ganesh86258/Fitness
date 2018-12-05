<?php


namespace ComponentManualUserApprove\classes;

if ( ! defined('ABSPATH') ) die('Forbidden');

/**
 * Email sender
 *
 * Class Eonet_MUA_Sender
 *
 * @package ComponentManualUserApprove
 */
class Eonet_MUA_Sender {

	/**
	 * @var string|array
	 */
	protected $to;

	/**
	 * @var string
	 */
	protected $subject;

	/**
	 * @var string
	 */
	protected $message;

	/**
	 * @var array
	 */
	protected $headers;

	/**
	 * Eonet_MUA_Sender constructor.
	 *
	 * @param null $to
	 * @param null $subject
	 * @param null $message
	 * @param null $headers
	 */
	public function __construct($to = null, $subject = null, $message = null, $headers = null) {
		$this->setTo($to);
		$this->setSubject($subject);
		$this->setMessage($message);
		$this->setHeaders($message);
	}

	/**
	 * Send the email
	 *
	 * @return bool|void
	 *
	 * @throws \Exception
	 */
	public function send(){
		
		if(empty($this->to))
			throw new \Exception('Impossible to send email: the receiver is not set');

		if(empty($this->subject))
			throw new \Exception('Impossible to send email: the subject is not set');
		
		if(empty($this->message))
			throw new \Exception('Impossible to send email: the message body is not set');
		
		return wp_mail( $this->to, $this->subject, $this->message, $this->headers );
	}


	public static function alert_user_about_status_changing($status, $user_id, $password){
		
		
	}


	/**
	 * @return array|string
	 */
	public function getTo() {
		return $this->to;
	}

	/**
	 * @param array|string $to
	 */
	public function setTo( $to ) {
		$this->to = $to;
	}

	/**
	 * @return string
	 */
	public function getSubject() {
		return $this->subject;
	}

	/**
	 * @param string $subject
	 */
	public function setSubject( $subject ) {
		$this->subject = '['. get_bloginfo('name') .'] '. $subject;
	}

	/**
	 * @return string
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @param string $message
	 */
	public function setMessage( $message ) {
		$this->message = $message;
	}

	/**
	 * @return array
	 */
	public function getHeaders() {
		return $this->headers;
	}

	/**
	 * @param null|array $headers
	 */
	public function setHeaders( $headers = null ) {

		if(is_null($headers)) {

			$admin_email = get_option('admin_email');
			if ( empty( $admin_email ) ) {
				$admin_email = 'signup@' . $_SERVER['SERVER_NAME'];
			}

			$from_name = get_option( 'blogname' );

			$headers = array(
				"From: \"{$from_name}\" <{$admin_email}>\n",
				"Content-Type: text/plain; charset=\"" . get_option( 'blog_charset' ) . "\"\n",
			);

			$headers = apply_filters( 'eonet_mua_email_headers', $headers );

		}

		$this->headers = $headers;
	}


}