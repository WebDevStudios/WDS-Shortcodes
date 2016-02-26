<?php

class WDSSC_Test_Shortcode_Instances extends WDSSC_Tests_Base {

	public function setUp() {
		parent::setUp();

		require_once( __DIR__ . '/includes/testing-shortcode.php' );
	}

	function test_class_exists() {
		$this->assertTrue( class_exists( 'WDS_Shortcode_Instances') );
	}

	/**
    * @expectedException Exception
    */
	function test_create_fail() {
		try {
			$shortcode_object = WDS_Shortcode_Instances::add( new Test_Shortcode() );
		} catch (Exception $e) {
			throw new Exception($e);
		}

		$this->assertTrue( is_a( $shortcode_object, 'WDS_Shortcode' ) );
	}

	function test_add() {
		$shortcode_object = WDS_Shortcode_Instances::add( new WDS_Shortcode( 'sc', array(), 'content' ) );
		$this->assertTrue( is_a( $shortcode_object, 'WDS_Shortcode' ) );
	}

	function test_get() {
		$shortcode_objects = WDS_Shortcode_Instances::get( 'sc' );
		$this->assertTrue( is_array( $shortcode_objects ) );
		$this->assertTrue( is_a( $shortcode_objects[0], 'WDS_Shortcode' ) );
	}

	function test_get_all() {
		WDS_Shortcode_Instances::add( new WDS_Shortcode( 'sc2', array(), 'content' ) );

		$shortcode_objects = WDS_Shortcode_Instances::get_all();
		$this->assertTrue( is_array( $shortcode_objects ) );
		$this->assertEquals( 2, count( $shortcode_objects ) );
	}

	function test_count_instances_of_shortcode() {
		$this->assertEquals( 1, WDS_Shortcode_Instances::count( 'sc' ) );
	}

}
