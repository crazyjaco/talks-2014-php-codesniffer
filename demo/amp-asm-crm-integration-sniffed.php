<?php
/*
Plugin Name: AMP ASM CRM Integration
Plugin Author: Bradley Jacobs
*/

class AMP_ASM_CRM_Integration {
	private static $instance = false;
 
	public static function instance(){
		if ( ! self::$instance ) {
			self::$instance = new AMP_ASM_CRM_Integration;			
		}
		return self::$instance;
	}
 
	function __construct(){
		add_action( 'wp_footer', array( $this, 'amp_asm_crm_add_tracking_script' ) );
		add_action( 'gform_after_submission', array( $this, 'amp_asm_crm_contact_us' ), 10, 2 );
		add_action( 'gform_after_submission', array( $this, 'amp_asm_crm_newsletter_signup' ), 10, 2 );
		add_action( 'gform_after_submission', array( $this, 'amp_asm_crm_whitepapers' ), 10, 2 );
		add_action( 'gform_after_submission', array( $this, 'amp_asm_crm_services' ), 10, 2 );
	}

	/**
	 * Adds ASM CRM Tracking Scripts to AMP site's footer
	 *
	 */
	function amp_asm_crm_add_tracking_script() {
		?>
		<script type="text/javascript"> 
			var cdJsHost = (("https:" == document.location.protocol) ? "https://" : "http://"); 
			document.write(unescape("%3Cscript src='" + cdJsHost + "analytics.clickdimensions.com/ts.js' type='text/javascript'%3E%3C/script%3E")); 
		</script> 

		<script type="text/javascript"> 
			var cdAnalytics = new clickdimensions.Analytics('analytics.clickdimensions.com'); 
			cdAnalytics.setAccountKey('aJ7yVwEm1k2RMJlS56gLyQ'); 
			cdAnalytics.setDomain('ampagency.com'); 
			cdAnalytics.trackPage(); 
		</script> 
		<?php
	}

	/**
	 *  Add lead capture to Contact Us form. Forwards data to ASM CRM
	 * @param  object $entry submitted form data
	 * @param  object $form  form object
	 */
	function amp_asm_crm_contact_us( $entry, $form ) {
		$url = 'http://analytics.clickdimensions.com/forms/h/';

		if ( 'Contact Us' === $form['title'] ) {
			$response = wp_remote_post(
					$url,
					array(
						'body' => array(
							'firstname'     => $entry['1'],   // First Name
							'lastname'      => $entry['2'],   // Last Name
							'email'         => $entry['3'],   // E-Mail
							'title'         => $entry['7'],   // Title
							'company'       => $entry['8'],   // Company
							'phone'         => $entry['9'],   // Phone
							'interest'      => $entry['4'],   // Interest
							'message'       => $entry['5'],   // Message
							'mailinglist'   => $entry['6.1'], // Mailing List
						)
					)
				);
			if ( WP_DEBUG ) {
				if ( is_wp_error( $response ) ) {
					error_log( 'error' );
				} else {
					error_log( 'no error' );
				}
			}
		}
	}

	/**
	 *  Add lead capture to Newsletter signup form. Forwards data to ASM CRM
	 * @param  object $entry submitted form data
	 * @param  object $form  form object
	 */
	function amp_asm_crm_newsletter_signup( $entry, $form ) {
		$url = 'http://analytics.clickdimensions.com/forms/h/';

		if ( 'Newsletter Sign Up' === $form['title'] ) {
			$response = wp_remote_post(
					$url,
					array(
						'body' => array(
							'email' => $entry['1'],  // E-Mail
						)
					)
				);
			if ( WP_DEBUG ) {
				if ( is_wp_error( $response ) ) {
					error_log( 'error' );
				} else {
					error_log( 'no error' );
				}
			}
		}
	}

	/**
	 *  Add lead capture to Whitepaper download form. Forwards data to ASM CRM
	 * @param  object $entry submitted form data
	 * @param  object $form  form object
	 */
	function amp_asm_crm_whitepapers( $entry, $form ) {
		$url = 'http://analytics.clickdimensions.com/forms/h/a6pyzMUCqUbtV8jI4re5A';

		if ( 'Whitepages Form' === $form['title'] ) {
			$response = wp_remote_post(
					$url,
					array(
						'body' => array(
							'firstname'     => $entry['2'], // First Name
							'lastname'      => $entry['3'], // Last Name
							'email'         => $entry['4'], // E-Mail
							'title'         => $entry['6'], // Title
							'company'       => $entry['5'], // Company
							'phone'         => $entry['7'], // Phone
							'whitepaper'    => $entry['8'], // White Paper
							'sourcepage'    => $entry['9'], // Source Page
						)
					)
				);
			if ( WP_DEBUG ) {
				if ( is_wp_error( $response ) ) {
					error_log( 'error' );
				} else {
					error_log( 'no error' );
				}
			}
		}
	}

	/**
	 *  Add lead capture to Services request form. Forwards data to ASM CRM
	 * @param  object $entry submitted form data
	 * @param  object $form  form object
	 */
	function amp_asm_crm_services( $entry, $form ) {
		$url = 'http://analytics.clickdimensions.com/forms/h/aZwVKSYnaiU656XMmRuKp5';

		if ( 'Services Form' === $form['title'] ) {
			$response = wp_remote_post(
					$url,
					array(
						'body' => array(
							'firstname'   => $entry['2'],  // First Name
							'lastname'    => $entry['3'],  // Last Name
							'email'       => $entry['4'],  // E-Mail
							'title'       => $entry['6'],  // Title
							'company'     => $entry['5'],  // Company
							'phone'       => $entry['7'],  // Phone
							'service'     => $entry['8'],  // Service
						)
					)
				);
			if ( WP_DEBUG ) {
				if ( is_wp_error( $response ) ) {
					error_log( 'error' );
				} else {
					error_log( 'no error' );
				}
			}
		}
	}

} // End Class

AMP_ASM_CRM_Integration::instance();