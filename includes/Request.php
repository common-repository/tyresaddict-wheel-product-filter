<?php
/**
 * Processing requests
 *
 * @since      1.0.0
 * @package    TyresAddict/WFilter
 * @author     TyresAddict
 * @link       http://b2b.tyresaddict.com
 */

namespace TyresAddict\WFilter;


/**
 * Request class
 */
class Request
{
	public static function __callStatic($name, $arguments)
    {                             
    	if ( $name == 'width' || $name == 'dia' || $name == 'r' )
		    return isset( $_GET[ $name ] ) ? (float) $_GET[ $name ] : 0;

    	if ( $name == 'et' )
		    return ( isset( $_GET[ $name ] ) && $_GET[ $name ] !== '' ) ? (int) $_GET[ $name ] : '';

    	if ( $name == 'brand' ) 
    	{
    		if ( isset( $_GET[ 'wheel_brand' ] ) )
	    	{
			    if ( is_array( $_GET[ 'wheel_brand' ] ) )
			    {
		    		$brands = [];
		    		foreach( $_GET[ 'wheel_brand' ] as $brand )
			    	{
			    		$brands[] = sanitize_text_field( $brand );
			    	}
		    		return $brands;
			    } 
			    elseif ( $_GET[ 'wheel_brand' ] !== "" ) 
			    	return $_GET[ 'wheel_brand' ];
		    	else	
		   			return 'all';
			}
			else
				return 'all';
		}

    	if ( $name == 'type' )
		    return isset( $_GET[ $name ] ) ? sanitize_text_field( (string) $_GET[ $name ] ) : 'all';

    	if ( $name == 'pcd' )
		    return ( isset( $_GET[ $name ] ) && $_GET[ $name ] !== "" ) ? sanitize_text_field( (string) $_GET[ $name ] ) : '';
    }

}

