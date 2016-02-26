<?php
class Test_Shortcode_Admin extends WDS_Shortcode_Admin {

	public function __construct() {
		parent::__construct( 'testing', '1.0', array() );
	}

	function js_button_data() {
		return array(
			'qt_button_text' => 'Quick Tags Button Text',
			'button_tooltip' => 'Button Tooltip',
			'icon'           => 'dashicons-slides',
			'include_close'  => true,
		);
	}

	function fields( $fields, $button_data ) {
		$fields[] = array(
			'name' => __( 'Image', 'uwishunu-inline-images' ),
			'type' => 'file',
			'id'   => 'image',
		);

		$fields[] = array(
			'name'    => __( 'Image Display Options', 'uwishunu-inline-images' ),
			'type'    => 'radio',
			'id'      => 'position',
			'options' => array(
				'hidden' => __( 'Full Bleed', 'uwishunu-inline-images' ),
				'left'   => __( 'Text Box on Left', 'uwishunu-inline-images' ),
				'right'  => __( 'Text Box on Right', 'uwishunu-inline-images' ),
			),
			'default' => 'hidden',
		);
		return $fields;
	}

}
