<?php
/**
 * WDS Shortcodes Shortcodes
 * @version 1.0.4
 * @package WDS Shortcodes
 */

/**
 * Base shortcodes class
 */
abstract class WDS_Shortcodes {

	/**
	 * Shortcode name
	 *
	 * @var array
	 */
	protected $shortcode = '';

	/**
	 * WDS_Shortcode instance
	 *
	 * @var WDS_Shortcode|null
	 */
	protected $shortcode_object = null;

	/**
	 * Default attributes
	 *
	 * @var array()
	 */
	protected $atts_defaults = array();


	/**
	 * Constructor
	 *
	 * @since 0.1.0
	 * @return  null
	 */
	public function __construct() {
		// At minimum, we must have the shortcode property set.
		if ( empty( $this->shortcode ) || ! is_string( $this->shortcode ) ) {
			wp_die( get_class( $this ) . ' must have a non-empty $shortcode property.' );
		}
	}

	/**
	 * Initiate our hooks
	 *
	 * @since 0.1.0
	 * @return void
	 */
	public function hooks() {
		add_shortcode( $this->shortcode, array( $this, 'shortcode_callback' ) );
		add_action( $this->shortcode, array( $this, 'do_shortcode_callback' ) );
	}

	/**
	 * Our do_action callback. Sets up the object properties
	 * and calls the shortcode method (to be overridden by subclasses)
	 * and echos the results
	 *
	 * @since  0.1.0
	 *
	 * @param  array  $atts    Array of attributes.
	 * @param  string $content Shortcode content.
	 *
	 * @return string           Modified shortcode content.
	 */
	public function do_shortcode_callback( $atts = array(), $content = '' ) {
		echo $this->shortcode_callback( $atts, $content );
	}

	/**
	 * Our shortcodes' callback. Sets up the object properties
	 * and calls the shortcode method (to be overridden by subclasses)
	 *
	 * @since  0.1.0
	 *
	 * @param  array  $atts    Array of attributes.
	 * @param  string $content Shortcode content.
	 *
	 * @return string           Modified shortcode content.
	 */
	public function shortcode_callback( $atts = array(), $content = '' ) {
		$this->create_shortcode_object(
			shortcode_atts( $this->atts_defaults, $atts, $this->shortcode ),
			$content
		);

		return $this->shortcode();
	}

	/**
	 * Generates a new unique WDS_Shortcode object to hold this shortcode's data
	 *
	 * @since  0.1.0
	 *
	 * @param  array  $atts    Array of attributes after shortcode_atts.
	 * @param  string $content Shortcode content.
	 *
	 * @return WDS_Shortcode
	 */
	public function create_shortcode_object( $atts, $content ) {
		$this->shortcode_object = WDS_Shortcode_Instances::add( new WDS_Shortcode( $this->shortcode, $atts, $content ) );

		$this->shortcode_object->content();

		return $this->shortcode_object;
	}

	/**
	 * Handles shortcode logic and return of shortcode output
	 *
	 * @since  0.1.0
	 *
	 * @throws Exception This method is required to be overridden by sub-class.
	 * @return string    Modified shortcode output.
	 */
	abstract function shortcode();

	/**
	 * Should be used on returned shortcode content since WordPress wpautop
	 * will add errant paragraph tags
	 *
	 * @since  0.1.0
	 *
	 * @param  string  $string String to remove white-space
	 *
	 * @return string          Normalized string
	 */
	public function normalize_string( $string ) {
		return trim( preg_replace( array(
			'/[\t\n\r]/', // Remove tabs and newlines
			'/\s{2,}/', // Replace repeating spaces with one space
			'/> </', // Remove spaces between carats
		), array(
			'',
			' ',
			'><',
		), $string ) );
	}

	/**
	 * Calls the methods on the shortcode_object instance.
	 *
	 * @since  NEXT
	 * @param  string $method    Non-existent method name
	 * @param  array  $arguments All arguments passed to the method
	 * @return mixed
	 */
	public function __call( $method, $arguments ) {
		switch ( $method ) {
			case 'att':
			case 'bool_att':
			case 'json_decode_att':
			case 'set_att':
			case 'content':
				return call_user_func_array( array( $this->shortcode_object, $method ), $arguments );
			default:
				throw new Exception( 'Invalid '. __CLASS__ .' method: ' . $method );
		}
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
			case 'atts_defaults' :
			case 'shortcode_object' :
				return $this->$field;
			case 'atts' :
			case 'pre_content' :
				return $this->shortcode_object->$field;
			case 'content' :
				return $this->content();
			default:
				throw new Exception( 'Invalid '. __CLASS__ .' property: ' . $field );
		}
	}

}
