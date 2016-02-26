<?php
/**
 * WDS Shortcodes Shortcode
 * @version 0.1.0
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
	 *
	 * @return  null
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
			return $this->atts[ $att ];
		}

		return $default;
	}

	/**
	 * Handles setting a shortcode attribute
	 *
	 * @since 0.1.0
	 *
	 * @param string $att   Attribute to set
	 * @param mixed  $value Value for attribute
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
