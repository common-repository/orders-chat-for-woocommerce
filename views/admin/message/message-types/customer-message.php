<?php defined( 'ABSPATH' ) || die;

use U2Code\OrderMessenger\Core\ServiceContainer;
use U2Code\OrderMessenger\Entity\Message;
use U2Code\OrderMessenger\Services\TextPreprocessor;

/**
 * View variables
 *
 * @var Message $message
 */

?>

<div class="order-message order-message--<?php echo esc_attr( $message->getMessageType()->getName() ); ?>"
	 data-message-id="<?php echo esc_attr( $message->getId() ); ?>">
	<div class="order-message__content">

		<?php
		TextPreprocessor::process( $message->getMessage(), true );
		ServiceContainer::getInstance()->getFileManager()->includeTemplate( 'admin/message/message-attachment.php', array( 'message' => $message ) );
		?>

	</div>
	<p class="order-message-meta">
		<abbr class="exact-date"
			  title="<?php echo esc_attr( $message->getDateSent()->format( 'y-m-d H:i:s' ) ); ?>">
			<?php
			printf(
			/* translators: $1: Date created, $2 Time created */
				esc_html__( 'Sent on %1$s at %2$s ', 'order-messenger-for-woocommerce' ),
				esc_html( date_i18n( wc_date_format(), strtotime( $message->getDateSent()->format( 'y-m-d H:i:s' ) ) ) ),
				esc_html( date_i18n( wc_time_format(), strtotime( $message->getDateSent()->format( 'y-m-d H:i:s' ) ) ) )
			);
			?>
		</abbr>
		<span>
			<?php
			/* translators: $1: Send by */
			echo esc_html( sprintf( __( 'by %s', 'order-messenger-for-woocommerce' ), $message->getSenderName() ) );
			?>
			</span>
		<a href="#" role="button" class="order-message-meta__delete"
		   data-delete-message="<?php echo esc_attr( $message->getId() ); ?>">
			<?php esc_attr_e( 'Delete message', 'order-messenger-for-woocommerce' ); ?>
		</a>
		|
		<a href="#" role="button" class="order-message-meta__mark-unread"
		   data-unread-message="<?php echo esc_attr( $message->getId() ); ?>">
			<?php esc_attr_e( 'Mark as unread', 'order-messenger-for-woocommerce' ); ?>
		</a>
	</p>
</div>
