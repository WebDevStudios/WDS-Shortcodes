<?php

class WDSSC_Test_Shortcodes_Base extends WDSSC_Tests_Base {

	function test_class_exists() {
		$this->assertTrue( class_exists( 'WDS_Shortcodes_Base') );
	}

	function test_get_instance() {
		$this->assertTrue( is_a( wds_shortcodes(), 'WDS_Shortcodes_Base' ) );
	}

	public function test_properties_exist() {
		$this->assertObjectHasAttribute( 'basename', wds_shortcodes() );
		$this->assertObjectHasAttribute( 'url', wds_shortcodes() );
		$this->assertObjectHasAttribute( 'path', wds_shortcodes() );
	}

}
