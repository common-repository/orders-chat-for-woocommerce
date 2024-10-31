<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * View variables
 *
 * @var string $total_messages
 * @var string $additional_content
 * @var WC_Order $order
 * @var string $email_heading
 * @var WC_Email $email
 * @var bool $sent_to_admin
 * @var bool $plain_text
 */

/*
 * @hooked WC_Emails::email_header() Output the email header
 */
do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<?php /* translators: %s: Customer first name */ ?>
	<p><?php printf( esc_html__( 'Hi %s,', 'woocommerce' ), esc_html( $order->get_billing_first_name() ) ); ?></p>
	<p>
		<?php esc_html_e( 'You have', 'order-messenger-for-woocommerce' ); ?>
		<b><?php echo esc_html( $total_messages ); ?></b>
		<?php
		/* translators: %s: messages or messages  */
		printf( esc_html__( 'new %s', 'order-messenger-for-woocommerce' ), esc_html( _nx( 'message', 'messages', esc_html( $total_messages ), 'order-messenger-for-woocommerce' ) ) ); 
		?>
	</p>
	<p><a target="_blank"
		  href="<?php echo esc_attr( wc_get_account_endpoint_url( 'messenger' ) . $order->get_id() ); ?>"><?php esc_html_e( 'View it', 'order-messenger-for-woocommerce' ); ?></a>
	</p>
<?php

/*
 * @hooked WC_Emails::order_details() Shows the order details table.
 * @hooked WC_Structured_Data::generate_order_data() Generates structured data.
 * @hooked WC_Structured_Data::output_structured_data() Outputs structured data.
 * @since 2.5.0
 */
do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::order_meta() Shows order meta data.
 */
do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );

/*
 * @hooked WC_Emails::customer_details() Shows customer details
 * @hooked WC_Emails::email_address() Shows email address
 */
do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );

/**
 * Show user-defined additional content - this is set in each email's settings.
 */
if ( $additional_content ) {
	echo wp_kses_post( wpautop( wptexturize( $additional_content ) ) );
}

/*
 * @hooked WC_Emails::email_footer() Output the email footer
 */
do_action( 'woocommerce_email_footer', $email );
