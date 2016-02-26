<?php

class WDSSC_Test_Shortcode_Admin extends WDSSC_Tests_Base {

	function test_class_exists() {
		if ( class_exists( 'Shortcode_Button' ) ) {
			$this->assertTrue( class_exists( 'WDS_Shortcode_Admin') );
		}
	}

}
