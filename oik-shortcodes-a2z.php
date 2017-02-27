<?php 
/**
Plugin Name: oik shortcode and API server letter taxonomies
Depends: oik base plugin, oik fields, oik themes, oik-shortcodes
Plugin URI: http://www.oik-plugins.com/oik-plugins/oik-shortcodes-a2z
Description: Letter taxonomies for oik-shortcodes
Version: 0.0.0
Author: bobbingwide
Author URI: http://www.oik-plugins.com/author/bobbingwide
Text Domain: oik-theme-fields
Domain Path: /languages/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

    Copyright 2017 Bobbing Wide (email : herb@bobbingwide.com )

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License version 2,
    as published by the Free Software Foundation.

    You may NOT assume that you can use any other version of the GPL.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    The license for this software can likely be found here:
    http://www.gnu.org/licenses/gpl-2.0.html

*/


/**
 * Register the additional taxonomies for oik-shortcodes
 *
 */ 
function oik_shortcodes_a2z_loaded() {
  add_action( 'oik_fields_loaded', 'oik_shortcodes_a2z_oik_fields_loaded', 11 );
	add_filter( "query_post_type_letter_taxonomy_filters", "oik_shortcodes_a2z_query_post_type_letter_taxonomy_filters", 11 );
}

/**
 * Registers the letters taxonomies
 *
 * Associates the letters and/or oik_letters taxonomies to the object types as required.
 * 
 * Note: This association is used to automatically set the 
 * filter hooks which automatically set the taxonomy terms for a post
 * from the title and/or content. 
 * 
 */ 
function oik_shortcodes_a2z_oik_fields_loaded() {
	bw_register_custom_tags( "letters", "oik-plugins", "Letters" );
	//register_taxonomy_for_object_type( "letters", "oik-plugins" );
	bw_register_field_for_object_type( "letters", "oik-plugins" );
	
	bw_register_custom_tags( "letters", "oik-themes", "Letters" );
	bw_register_field_for_object_type( "letters", "oik-themes" );

	bw_register_custom_tags( "oik_letters", "oik_api", "API Letters" );
	bw_register_field_for_object_type( "oik_letters", "oik_api" );
	
	register_taxonomy_for_object_type( "oik_letters", "oik_class" );
	bw_register_field_for_object_type( "oik_letters", "oik_class" );
	
	register_taxonomy_for_object_type( "oik_letters", "oik_file" );
	bw_register_field_for_object_type( "oik_letters", "oik_file" );		
	
	register_taxonomy_for_object_type( "oik_letters", "oik_hook" );
	bw_register_field_for_object_type( "oik_letters", "oik_hook" );
	
	register_taxonomy_for_object_type( "oik_letters", "oik_shortcodes" );
	bw_register_field_for_object_type( "oik_letters", "oik_shortcodes" );
	
	
	register_taxonomy_for_object_type( "oik_letters", "shortcode_example" );
	bw_register_field_for_object_type( "oik_letters", "shortcode_example" );
	
}

/**
 * Implements 'query_post_type_letter_taxonomy_filters' for the oik_letters taxonomy
 */
function oik_shortcodes_a2z_query_post_type_letter_taxonomy_filters( $taxonomies ) {
	$taxonomies = oik_a2z_add_post_type_letter_taxonomy_filters( $taxonomies, "oik_letters", "oik_shortcodes_a2z_first_letters" );
	return( $taxonomies );
}

/**
 * Implement "oik_a2z_query_terms_$post_type_oik_letters"
 * 
 * e.g. "oik_a2z_query_terms_oik_api_oik_letters" for post_type: oik_api, taxonomy: oik_letters
 * 
 * @TODO - should the hook have a '-' separator rather rather than '_' or something completely different?
 *
 * Mapping the first letter of each part of the API name is performed similarly to oik-a2z  
 
 * 
 * @param array $terms - current values - there may be more than one - can you think of a good reason?
 * @param object $post
 * @return array replaced by the new term name
 */
function oik_shortcodes_a2z_first_letters( $terms, $post ) {
	$terms = array();
	$string = trim( $post->post_title );
	if ( !$string ) {
		$string = trim( $post->post_content );
	}
	$string = oik_shortcodes_a2z_standardize_name( $string );
	$words = explode( "_", $string );
	$loop = 0;
	for ( $loop = 0; $loop < 5; $loop++ ) {
		$word = bw_array_get( $words, $loop, null );
		if ( oik_shortcodes_a2z_worth_indexing_word( $word ) ) {
			$term = oik_shortcodes_a2z_first_letter( $word );
			$terms[] = $term;
		} else {
			if ( 0 == $loop ) {
				$terms[] = "_";
			}
		}
	}
	return( $terms );
}

/**
 * Standardizes the API name
 * 
 * Reduce to a simple string with underscores by:
 * - stripping off the unwanted bits at the end
 * - converting expected punctuation to underscores
 * 
 * We should be able to deal with the following:
 * `
 * Class::Method() - Summary
 * Function() - Summary
 * path/file-name.php
 * shortcode - Summary
 * Class - Summary
 * hook <span class="summary"> - action/filter </span>
 * `
 *
 * @param string $string
 * @return string standardized
 */
function oik_shortcodes_a2z_standardize_name( $string ) {
	$standardized = trim( $string );
	$standardized = str_replace( "()", " - ", $standardized );
	$standardized = str_replace( " <", " - ", $standardized ); 
	$summary_pos = strpos( $standardized . " - ", " - " );
	$standardized = substr( $standardized, 0, $summary_pos ); 
	$standardized = str_replace( "::", "_", $standardized );
	$standardized = str_replace( "/", "_", $standardized );
	$standardized = str_replace( ".", "_", $standardized );
	$standardized = str_replace( "-", "_", $standardized );
	return( $standardized );
}

/**
 * Returns the first letter term from the string.
 *
 * @param string $term not expected to be null
 * @return string Expected to be a single character
 */
function oik_shortcodes_a2z_first_letter( $term ) {
	$new_term = substr( $term, 0, 1 );
	//echo "!$new_term!";
	if ( ctype_digit( $new_term ) ) {
		$new_term = "#";
	}	else {
		$new_term = ucfirst( $new_term );
		//echo "New term: $new_term" . PHP_EOL ;
		$new_term = remove_accents( $new_term );
		//echo "New term: $new_term" . PHP_EOL ;
	}
	return( $new_term );
}

/**
 * Checks for worth_indexing word
 * 
 * This returns false when the word is in the naughty list ... whatever that is.
 *
 * @param string $word
 * @return bool true when we should use this word to determine a letter
 * 
 */
function oik_shortcodes_a2z_worth_indexing_word( $word ) {
	$worth_indexing = strlen( $word );
	return( $worth_indexing ); 
}

 


oik_shortcodes_a2z_loaded();
