<?php
/**
 * WDS Shortcodes Shortcode
 * @version 1.0.4
 * @package WDS Shortcodes
 */

/**
 * Base shortcodes class
 */
class WDS_Shortcode {

	/**
	 * Shortcode name
	 *
	 * @var array
	 */
	protected $shortcode = '';

	/**
	 * Shortcode attributes
	 *
	 * @var array
	 */
	protected $atts = array();

	/**
	 * Shortcode contents (pre-parsing)
	 *
	 * @var string
	 */
	protected $pre_content = '';

	/**
	 * Shortcode contents
	 *
	 * @var string
	 */
	protected $content = '';

	/**
	 * Constructor
	 *
	 * @since 0.1.0
	 *
	 * @param string $shortcode Shortcode name.
	 * @param array  $atts      Array of parsed attributes for shortcode.
	 * @param string $content   Parsed content for shortcode.
	 */
	public function __construct( $shortcode, $atts, $content ) {
		$this->shortcode = $shortcode;
		$this->atts      = $atts;
		$this->content = $this->pre_content = $content;
	}

	/**
	 * Attribute-getter with a default fallback option.
	 *
	 * @since  0.1.0
	 *
	 * @param  string $att     Attribute key.
	 * @param  mixed  $default Optional default value for this key if no value is found.
	 *
	 * @return mixed           Value for this attribute (or the default)
	 */
	public function att( $att, $default = null ) {
		if ( isset( $this->atts[ $att ] ) && ! empty( $this->atts[ $att ] ) ) {
			return $this->maybe_json_decode( $this->atts[ $att ] );
		}

		return $default;
	}

	/**
	 * Attribute-getter for boolean values with a default fallback option.
	 *
	 * @since  1.0.1
	 *
	 * @param  string $att     Attribute key.
	 * @param  mixed  $default Optional default value for this key if no value is found.
	 *
	 * @return mixed           Value for this attribute (or the default)
	 */
	public function bool_att( $att, $default = null ) {
		$value = $this->att( $att, $default );
		if ( in_array( $value, array( 'false', '0', '', 0 ), 1 ) ) {
			$value = false;
		}

		return (bool) $value;
	}

	/**
	 * Attribute-getter for converting json values with a default fallback option.
	 *
	 * By default, CMB2 fields in the shortcode button form  which store an array
	 * of information will be stored to the shortcode with a modified json format.
	 *
	 * @since  1.0.2
	 *
	 * @param  string $att     Attribute key.
	 * @param  mixed  $default Optional default value for this key if no value is found.
	 *
	 * @return mixed           Value for this attribute (or the default)
	 */
	public function json_decode_att( $att, $default = null ) {
		if ( isset( $this->atts[ $att ] ) && ! empty( $this->atts[ $att ] ) ) {
			return $this->maybe_json_decode( $this->atts[ $att ], 1 );
		}

		return $default;
	}

	/**
	 * If a modified JSON value was stored as the attribute (Shortcode_Button handling)
	 * then restore the JSON string, and json_decode it.
	 *
	 * @since  0.1.2
	 *
	 * @param  string  $value Attribute value
	 *
	 * @return string         Possibly modified attribute value
	 */
	protected function maybe_json_decode( $value, $force = false ) {
		if (
			! $value
			|| ! is_string( $value )
			|| ( ! $force && 0 !== strpos( $value, '|~' ) )
		) {
			return $value;
		}

		return json_decode( str_replace(
			array( "'", '|~', '~|' ),
			array( '"', '[', ']' ),
			$value
		), 1 );
	}

	/**
	 * Handles setting a shortcode attribute
	 *
	 * @since 0.1.0
	 *
	 * @param string $att   Attribute to set
	 * @param mixed  $value Value for attribute
	 *
	 * @return bool
	 */
	public function set_att( $att, $value ) {
		return $this->atts[ $att ] = $value;
	}

	/**
	 * Handles fetching and parsing the shortcode content.
	 *
	 * @since  0.1.0
	 *
	 * @return string  Parsed content.
	 */
	public function content() {
		static $parsed = false;
		if ( $parsed ) {
			return $this->content;
		}

		$this->content = ! empty( $this->content ) ? do_shortcode( $this->content ) : '';
		return $this->content;
	}

	/**
	 * Magic getter for our object.
	 *
	 * @since  0.1.0
	 * @param  string $field Property to retrieve.
	 * @throws Exception Throws an exception if the field is invalid.
	 * @return mixed
	 */
	public function __get( $field ) {
		switch ( $field ) {
			case 'shortcode' :
			case 'atts' :
			case 'pre_content' :
				return $this->$field;
			default:
				throw new Exception( 'Invalid '. __CLASS__ .' property: ' . $field );
		}
	}

}
