<?php namespace U2Code\OrderMessenger\Email;

use U2Code\OrderMessenger\Core\ServiceContainer;
use WC_Email;

class AdminMessagesNotificationEmail extends WC_Email {

	/**
	 * Customer note.
	 *
	 * @var string
	 */
	public $customer_note;

	/**
	 * Total unread messages
	 *
	 * @var int
	 */
	private $totalMessages;

	/**
	 * Constructor.
	 */
	public function __construct() {
		$this->id = 'admin_messenger_notification_email';

		$this->title          = __( 'Admin messenger notification', 'order-messenger-for-woocommerce' );
		$this->description    = __( 'The email is sent when you have new messages from customers',
			'order-messenger-for-woocommerce' );
		$this->template_html  = 'admin-messenger-notification.php';
		$this->template_plain = '/plain/admin-messenger-notification.php';

		$this->template_base = ServiceContainer::getInstance()->getFileManager()->getPluginDirectory() . 'views/emails/';

		$this->placeholders = array(
			'{order_date}'   => '',
			'{order_number}' => '',
		);

		$this->recipient     = $this->get_option( 'recipient', get_option( 'admin_email' ) );
		$this->totalMessages = 0;
		// Call parent constructor.
		parent::__construct();
	}

	/**
	 * Get email subject.
	 *
	 * @return string
	 * @since  3.1.0
	 */
	public function get_default_subject() {
		return __( 'You have new messages related to order #{order_number}', 'order-messenger-for-woocommerce' );
	}

	/**
	 * Get email heading.
	 *
	 * @return string
	 * @since  3.1.0
	 */
	public function get_default_heading() {
		return __( 'You have new messages related to order #{order_number}', 'order-messenger-for-woocommerce' );
	}

	/**
	 * Trigger.
	 *
	 * @param $orderId
	 * @param $messagesCount
	 *
	 * @return bool
	 */
	public function trigger( $orderId, $messagesCount ) {
		$result = false;
		$this->setup_locale();

		$this->object        = wc_get_order( $orderId );
		$this->totalMessages = $messagesCount;

		if ( $this->object ) {
			$this->placeholders['{order_number}']   = $this->object->get_order_number();
			$this->placeholders['{total_messages}'] = $messagesCount;
		}

		if ( $this->is_enabled() && $this->get_recipient() ) {
			$result = $this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(),
				$this->get_headers(), $this->get_attachments() );
		}

		$this->restore_locale();

		return $result;
	}

	/**
	 * Get content html.
	 *
	 * @return string
	 */
	public function get_content_html() {

		return ServiceContainer::getInstance()->getFileManager()->renderTemplate( 'emails/' . $this->template_html,
			array(
				'order'              => $this->object,
				'email_heading'      => $this->get_heading(),
				'additional_content' => $this->get_additional_content(),
				'customer_note'      => $this->customer_note,
				'sent_to_admin'      => true,
				'plain_text'         => false,
				'email'              => $this,
				'total_messages'     => $this->totalMessages,
			) );
	}

	/**
	 * Get content plain.
	 *
	 * @return string
	 */
	public function get_content_plain() {
		return ServiceContainer::getInstance()->getFileManager()->renderTemplate( 'emails/plain' . $this->template_plain,
			array(
				'order'              => $this->object,
				'email_heading'      => $this->get_heading(),
				'additional_content' => $this->get_additional_content(),
				'customer_note'      => $this->customer_note,
				'sent_to_admin'      => true,
				'plain_text'         => true,
				'email'              => $this,
				'total_messages'     => $this->totalMessages,
			) );
	}

	/**
	 * Default content to show below main email content.
	 *
	 * @return string
	 * @since 3.7.0
	 */
	public function get_default_additional_content() {
		return __( 'Thanks for using {site_url}!', 'woocommerce' );
	}
}
