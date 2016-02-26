<?php

abstract class WDS_Shortcode_Admin extends Shortcode_Button {

	/**
	 * Shortcode name
	 *
	 * @var array
	 */
	protected $shortcode = '';

	/**
	 * Shortcode attribute defaults
	 *
	 * @var array
	 */
	protected $atts_defaults = array();

	/**
	 * Version String
	 * @var string
	 */
	protected $version = '';

	/**
	 * Constructor
	 *
	 * @since 0.1.0
	 */
	public function __construct( $shortcode = '', $version = '', $atts_defaults = array() ) {
		$this->shortcode     = $shortcode;
		$this->atts_defaults = $atts_defaults;
		$this->version       = $version;

		if ( empty( $this->shortcode ) || empty( $this->version ) ) {
			wp_die( get_class( $this ) . ' must have $shortcode and $version properties set and non-empty.' );
		}

		$button = parent::__construct( $this->shortcode, $this->_js_button_data(), $this->_additional_args() );
		remove_action( 'init', array( $this, 'hooks' ) );
	}

	abstract function js_button_data();
	abstract function fields( $fields, $button_data );

	protected function _js_button_data() {

		// Set up the button data that will be passed to the javascript files
		$data = array(
			// Optional parameters
			'author'         => 'WebDevStudios',
			'authorurl'      => 'http://webdevstudios.com',
			'infourl'        => 'https://github.com/jtsternberg/Shortcode_Button',
			'version'        => $this->version,

			// Use your own textdomain
			'l10ncancel'     => __( 'Cancel', 'wds-shortcodes' ),
			'l10ninsert'     => __( 'Insert Shortcode', 'wds-shortcodes' ),

			// Optional modal settings override
			// 'dialogClass' => 'wp-dialog',
			// 'modalHeight' => 'auto',
			// 'width'       => 500,
		);

		return wp_parse_args( $this->js_button_data(), $data );
	}

	protected function _additional_args() {

		// Optional additional parameters
		$additional_args = array(
			// Can be a callback or metabox config array
			'cmb_metabox_config'   => array( $this, 'shortcode_button_cmb_config' ),
			// Set the conditions of the shortcode buttons
			'conditional_callback' => array( $this, 'conditional_callback' ),

			// Use if you are not using CMB2 to generate the form fields
			// 'form_display_callback' => '',

			// Only set if the javascript files cannot be found
			// 'scripts_url' => '',
		);

		return $additional_args;
	}

	/**
	 * Return CMB2 config array
	 *
	 * @param  array  $button_data Array of button data
	 *
	 * @return array               CMB2 config array
	 */
	public function shortcode_button_cmb_config( $button_data ) {

		$fields = array();
		$args = array(
			'id'     => 'shortcode_'. $button_data['slug'],
			'fields' => $this->fields( $fields, $button_data ),
			// keep this w/ a key of 'options-page' and use the button slug as the value
			'show_on' => array( 'key' => 'options-page', 'value' => $button_data['slug'] ),
		);

		return $args;
	}

	public function conditional_callback() {
		global $pagenow;

		$is_only_posts = ( is_admin() && ( ( 'post.php' === $pagenow ) || ( 'post-new.php' === $pagenow ) ) );

		// By default, display only for posts.
		return $is_only_posts;
	}
}
