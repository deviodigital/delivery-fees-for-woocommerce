<?php

/**
 * The file that defines the core helper functions
 *
 * @package    DFWC
 * @subpackage DFWC/includes
 * @author     Devio Digital <contact@deviodigital.com>
 * @license    GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 * @link       https://www.deviodigital.com
 * @since      1.0.0
 */

if ( ! function_exists( 'is_rest' ) ) {
    /**
     * Checks if the current request is a WP REST API request.
     * 
     * Case #1: After WP_REST_Request initialisation
     * Case #2: Support "plain" permalink settings
     * Case #3: URL Path begins with wp-json/ (your REST prefix)
     *          Also supports WP installations in subfolders
     * 
     * @author matzeeable
     * @since  1.2
     * @return boolean
     */
    function is_rest() {
        $prefix = rest_get_url_prefix( );
        if ( defined( 'REST_REQUEST' ) && REST_REQUEST // (#1)
            || isset( $_GET['rest_route'] ) // (#2)
            && strpos( trim( filter_input( INPUT_GET, 'rest_route' ), '\\/' ), $prefix, 0 ) === 0 )
            return true;

        // (#3)
        $rest_url    = wp_parse_url( site_url( $prefix ) );
        $current_url = wp_parse_url( add_query_arg( array( ) ) );
        return strpos( $current_url['path'], $rest_url['path'], 0 ) === 0;
    }
}
