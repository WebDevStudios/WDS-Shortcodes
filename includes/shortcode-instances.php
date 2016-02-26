<?php
/**
 * WDS Shortcode Instances
 * @version 0.1.0
 * @package WDS Shortcodes
 */

/**
 * A WDS_Shortcode instance instance registry
 * for storing every WDS_Shortcode instance.
 */
class WDS_Shortcode_Instances {

	/**
	 * Array of URSM_Shortcodes_Base instances
	 *
	 * @var array
	 * @since  0.1.0
	 */
	protected static $instances = array();

	/**
	 * Increments with each instance
	 *
	 * @var int
	 * @since  0.1.0
	 */
	protected static $counter = 0;

	/**
	 * Add a WDS_Shortcode instance to the registry
	 *
	 * @since 0.1.0
	 *
	 * @param WDS_Shortcode $instance Instance to add.
	 */
	public static function add( WDS_Shortcode $instance ) {
		if ( ! isset( self::$instances[ $instance->shortcode ] ) ) {
			self::$instances[ $instance->shortcode ] = array();
		}

		self::$counter++;

		return self::$instances[ $instance->shortcode ][] = $instance;
	}

	/**
	 * Retrieve all instances of a type of shortcode
	 *
	 * @since  0.1.0
	 *
	 * @param  string $shortcode Shortcode name.
	 *
	 * @return WDS_Shortcode|null
	 */
	public static function get( $shortcode ) {
		return isset( self::$instances[ $shortcode ] ) ? self::$instances[ $shortcode ] : null;
	}

	/**
	 * Retrievea all WDS_Shortcode instances
	 *
	 * @since  0.1.0
	 *
	 * @return WDS_Shortcode[]
	 */
	public static function get_all() {
		return self::$instances;
	}

	/**
	 * Get a count of all instances or count of instances of a certain type of shortcode
	 *
	 * @since  0.1.0
	 *
	 * @param  string $shortcode Shortcode name.
	 *
	 * @return int              Number of instances
	 */
	public static function count( $shortcode = '' ) {
		if ( $shortcode ) {
			$instances = self::get( $shortcode );
			return ! empty( $instances ) ? count( $instances ) : 0;
		}

		return self::$counter;
	}

}
