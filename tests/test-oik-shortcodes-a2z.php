<?php // (C) Copyright Bobbing Wide 2017
/**
 * @group oik_shortcodes_a2z
 */
class Tests_oik_shortcodes_a2z extends BW_UnitTestCase {


	function setUp() { 
		oik_require( "oik-shortcodes-a2z.php", "oik-shortcodes-a2z" );
	}

	/**
	 * Test the first letter logic edge cases.
	 */
	function test_oik_shortcodes_a2z_first_letter() {
		$term = oik_shortcodes_a2z_first_letter( null );
		$this->assertEquals( $term, '' );
		
		$terms = array( "oik" => "O" 
									, "123" => "#"
									, "\xe8" => "E"	 // lowercase e grave
								  );
		foreach ( $terms as $term => $letter ) {
			$result = oik_shortcodes_a2z_first_letter( $term );
			$this->assertEquals( $result, $letter );
		}
	}
	
	/**
	 * Test some WordPress function names
	 */
	function test_WordPress_function_names() {
		$post = new stdClass();
		$terms = array();
		$titles = array( "__" => array( "_" )
									 , "__return_true" => array( "_", "R", "T" )
									 , "_doing_it_wrong" => array( "_", "D", "I", "W" ) 
									 , "get_post" => array( "G", "P" )
									 , "_wp_call_all_hook" => array( "_", "W", "C", "A", "H" ) 
									 , "add_action" => array( "A", "A" )
									 , "wp" => array( "W" )
									 , "wp_set_object_terms" => array( "W", "S", "O", "T" )
									 , "zeroise" => array( "Z" )
									 ); 
		foreach ( $titles as $title => $letters ) {
			$post->post_title = $title;
			$post->post_content = "You shouldn't get here";
			$result = oik_shortcodes_a2z_first_letters( $terms, $post );
			$this->assertSame( $letters, $result );
		}
	}
	
	
	/** 
	 * Test some WordPress method names
	 * 
	 * Methods are saved with a title of class::method
	 * The code in oik_shortcodes_a2z_first_letters should account for this.
	 * @TODO: This also indicates we may need to determine more than 5 terms.
	 * 
	 */
	function test_WordPress_method_names() {
		$post = new stdClass();
		$terms = array();
		$titles = array( "__" => array( "_" )
									 , "__return_true" => array( "_", "R", "T" )
									 , "_doing_it_wrong" => array( "_", "D", "I", "W" ) 
									 , "get_post" => array( "G", "P" )
									 , "_wp_call_all_hook" => array( "_", "W", "C", "A", "H" ) 
									 , "add_action" => array( "A", "A" )
									 , "wp" => array( "W" )
									 , "wp_set_object_terms" => array( "W", "S", "O", "T" )
									 , "zeroise" => array( "Z" )
									 ); 
		foreach ( $titles as $title => $letters ) {
			$post->post_title = $title;
			$post->post_content = "You shouldn't get here";
			$result = oik_shortcodes_a2z_first_letters( $terms, $post );
			$this->assertSame( $letters, $result );
		}
	}
	
	/**
	 * Test the standarization logic
	 */
	function test_oik_shortcodes_standardize_name() {
		$titles = array( "Class::Method() - Summary" => "Class_Method" 
									 , "Function() - Summary" => "Function" 
									 , "path/file-name.php" => "path_file_name_php"
									 , "shortcode - Summary" => "shortcode"
									 , "Class - Summary" => "Class"
									 , 'hook <span class="summary"> - action/filter </span>' => "hook"
									 );
		foreach ( $titles as $title => $standardized ) {
			$result = oik_shortcodes_a2z_standardize_name( $title );
			$this->assertSame( $standardized, $result );
		}	
	}
	 
}
