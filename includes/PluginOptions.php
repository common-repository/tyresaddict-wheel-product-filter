<?php
/**
 * Option page of the plugin.
 *
 * @since      1.0.0
 * @package    TyresAddict/WFilter
 * @author     TyresAddict
 * @link       http://b2b.tyresaddict.com
 */

namespace TyresAddict\WFilter;


class PluginOptions
{
	const defaults = [	'category' 		=> '',
						];

	private $options 	= [];

	const OptionGroup 	= 'tyresaddict_wpfp_options';
	const OptionPage 	= 'tyresaddict-wpfp-option-page';
	const OptionFilterUrl 	= 'tyresaddict_wpfp_url';

	static function value( $field ) 
	{
		$options = get_option( PluginOptions::OptionGroup );
		
		if ( false === $options )
			return PluginOptions::defaults[ $field ];

		if ( !isset( $options[ $field ] ) )
			return PluginOptions::defaults[ $field ];

		return $options[ $field ];
	}

	static function update( $field, $value ) 
	{
		$options = get_option( PluginOptions::OptionGroup );

		if ( false === $options ) 
			$options = [];
		
		$options[ $field ] = $value;
		update_option( PluginOptions::OptionGroup, $options );
	}
}




