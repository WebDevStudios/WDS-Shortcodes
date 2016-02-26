<?php

class WDSSC_Test_Shortcodes extends WDSSC_Tests_Base {

	public function setUp() {
		parent::setUp();

		require_once( __DIR__ . '/includes/testing-shortcode.php' );
		$this->shortcode = new Test_Shortcode();
		$this->shortcode->shortcode_callback( array( 'color' => 'blue' ), 'Some SC content [foo]' );

		add_shortcode( 'foo', function(){ return 'bar'; } );
	}

	function test_class_exists() {
		$this->assertTrue( class_exists( 'WDS_Shortcodes') );
	}

	function test_is_class() {
		$this->assertTrue( is_a( $this->shortcode, 'WDS_Shortcodes' ) );
	}

	function test_attributes() {
		$this->assertEquals( 'sc name', $this->shortcode->att( 'name' ) );
		$this->assertEquals( 'blue', $this->shortcode->att( 'color' ) );
	}

	function test_shortcode_output() {
		$this->assertEquals( 'Some SC content bar', $this->shortcode->shortcode() );
	}

	function test_normalize_string() {
		$string = "<p>test</p>\n

		<div>      sjflsjf    </div>\r

		<span></span> <span></span>
		test
		";

		$normalized = '<p>test</p><div> sjflsjf </div><span></span><span></span>test';
		$this->assertEquals( $normalized, $this->shortcode->normalize_string( $string ) );
	}
}
