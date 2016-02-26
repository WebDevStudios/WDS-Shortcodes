<?php
class Test_Shortcode extends WDS_Shortcodes {

	/**
	 * Shortcode string
	 *
	 * @var null
	 */
	public $shortcode = 'test';

	/**
	 * Shortcode attribute defaults
	 *
	 * @var array
	 */
	public $atts_defaults = array(
		'name' => 'sc name',
		'color' => 'red',
	);

	/**
	 * Display Shortcode Output
	 *
	 * @return string
	 */
	public function shortcode() {
		return $this->content();
	}
}
