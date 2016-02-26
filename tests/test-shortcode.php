<?php

class WDSSC_Test_Shortcode extends WDSSC_Tests_Base {

	public function setUp() {
		parent::setUp();

		require_once( __DIR__ . '/includes/testing-shortcode.php' );
		$this->shortcode = new Test_Shortcode();
		$this->shortcode->shortcode_callback( array( 'color' => 'blue' ), 'Some SC content [foo]' );
		$this->shortcode_object = $this->shortcode->shortcode_object;

		add_shortcode( 'foo', function(){ return 'bar'; } );
	}

	function test_class_exists() {
		$this->assertTrue( class_exists( 'WDS_Shortcode') );
	}

	function test_is_class() {
		$this->assertTrue( is_a( $this->shortcode_object, 'WDS_Shortcode' ) );
	}

	public function test_properties_exist() {
		$this->assertObjectHasAttribute( 'shortcode', $this->shortcode_object );
		$this->assertEquals( 'test', $this->shortcode_object->shortcode );
		$this->assertObjectHasAttribute( 'atts', $this->shortcode_object );
		$this->assertObjectHasAttribute( 'pre_content', $this->shortcode_object );
		$this->assertObjectHasAttribute( 'content', $this->shortcode_object );
	}

	function test_attributes() {
		$this->assertEquals( array( 'color' => 'blue', 'name' => 'sc name' ), $this->shortcode_object->atts );

		$this->assertEquals( 'sc name', $this->shortcode_object->att( 'name' ) );
		$this->assertEquals( 'blue', $this->shortcode_object->att( 'color' ) );

		$this->assertEquals( 'sepia', $this->shortcode_object->set_att( 'color', 'sepia' ) );
		$this->assertEquals( 'sepia', $this->shortcode_object->att( 'color' ) );
		$this->assertEquals( '', $this->shortcode_object->att( 'nothing' ) );
		$this->assertEquals( 'default value', $this->shortcode_object->att( 'default', 'default value' ) );
	}

	function test_content() {
		// Content should include the converted nested shortcodes.
		$this->assertEquals( 'Some SC content bar', $this->shortcode_object->content() );
		// Original content, no processing.
		$this->assertEquals( 'Some SC content [foo]', $this->shortcode_object->pre_content );
	}
}
