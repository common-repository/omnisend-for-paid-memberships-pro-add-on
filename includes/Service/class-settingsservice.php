<?php
/**
 * Omnisend Settings service
 *
 * @package OmnisendPaidMerbershipsProPlugin
 */

declare(strict_types=1);

namespace Omnisend\PaidMembershipsProAddon\Service;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class SettingsService
 *
 * @package Omnisend\PaidMembershipsProAddon\Service
 */
class SettingsService {
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_init', array( $this, 'settings_init' ) );
	}

	public function add_menu() {
		add_options_page(
			'Omnisend for Paid Memberships Pro Options',
			'PMPro Omnisend',
			'manage_options',
			'omnisend-pmp',
			array( $this, 'options_page' )
		);
	}

	public function options_page() {
		?>
		<div class="wrap">
			<h1>Omnisend for Paid Memberships Pro Options</h1>
			<form method="post" action="options.php">
				<?php
				settings_fields( 'omnisend_pmp_options_group' );
				do_settings_sections( 'omnisend-pmp' );
				submit_button();
				?>
			</form>
		</div>
		<?php
	}

	public function settings_init() {
		register_setting( 'omnisend_pmp_options_group', 'omnisend_pmp_options' );

		add_settings_section(
			'omnisend_pmp_settings_section',
			'Settings',
			array( $this, 'settings_section_callback' ),
			'omnisend-pmp'
		);

		add_settings_field(
			'omnisend_pmp_setting_field',
			'Enable consent collection',
			array( $this, 'setting_field_callback' ),
			'omnisend-pmp',
			'omnisend_pmp_settings_section'
		);
	}

	public function settings_section_callback() {
		echo '<p class="information-notice">Depending on the privacy laws of your country of operation, it is recommended to enable marketing opt-in checkboxes in Account Creation & Membership Checkout forms to collect marketing consent from your customers</p>';
		echo '<p>If you wish to enable consent collection, check below</p>';
	}

	public function setting_field_callback() {
		$options = get_option( 'omnisend_pmp_options' );
		if ( isset( $options['setting_field'] ) && $options['setting_field'] == '1' ) {
			$checked_form = 'checked';
		} else {
			$checked_form = '';
		}

		?>
		<input type="checkbox" name="omnisend_pmp_options[setting_field]" <?php echo esc_html( $checked_form ); ?> value="1" />
		<?php
	}
}