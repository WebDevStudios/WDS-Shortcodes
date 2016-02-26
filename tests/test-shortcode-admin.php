<?php

class WDSSC_Test_Shortcode_Admin extends WDSSC_Tests_Base {

	public function setUp() {
		parent::setUp();

		require_once( __DIR__ . '/includes/testing-shortcode-admin.php' );
		$this->shortcode_admin = new Test_Shortcode_Admin();
	}

	function test_class_exists() {
		if ( class_exists( 'Shortcode_Button' ) ) {
			$this->assertTrue( class_exists( 'WDS_Shortcode_Admin') );
		}
	}

	function test_is_class() {
		$this->assertTrue( is_a( $this->shortcode_admin, 'WDS_Shortcode_Admin' ) );
	}

}
