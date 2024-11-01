<?php
/**
 * Database support
 *
 * @since      1.0.0
 * @package    TyresAddict/WFilter
 * @author     TyresAddict
 * @link       http://b2b.tyresaddict.com
 */

namespace TyresAddict\WFilter;

// DB class

class DB 
{

	public static function wheel_types()
	{
		return [ 	'alloy' 	=> __('Alloy', Plugin::lang), 
					'forged' 	=> __('Forged', Plugin::lang),
					'steel' 	=> __('Steel', Plugin::lang),
				];
	}

	public static function wheel_dia()
	{
		return [ 	
					48.1, 
					54, 54.1, 56, 56.1, 56.5, 56.6, 57.1, 58, 58.1, 58.5, 58.6, 59.1, 59.6, 
					60, 60.1, 63.1, 63.3, 63.4, 63.5, 64.1, 65, 65.1, 65.2, 66, 66.1, 66.5, 66.6, 66.7, 66.9, 67, 67.1, 68.1, 69.1, 69.5, 
					70.1, 70.2, 70.3, 70.4, 70.5, 70.6, 71.1, 71.4, 71.5, 71.6, 
					72.2,
					72.5, 72.6, 73.1, 73.8, 74.1, 75.1, 76, 77.7, 77.8, 78, 78.1, 78.3, 
					84, 84.1, 86, 86.5, 86.8, 87, 87.1, 89, 
					92.5, 93, 93.1, 95.3, 98.5, 
					100, 100.1, 100.3, 102.6, 105, 106, 106.1, 106.2, 107.1, 108, 108.1, 108.4, 108.5, 
					110, 110.1, 111, 113, 114.5, 116.1, 116.6, 117, 
					120.9, 124.1, 124.9, 125, 
					138.8
		];
	}

	static public function wheel_et()
	{
		return [ 	'-1'	=> __('Less than 0', Plugin::lang), 
					'0'		=> '0-10',
					'10'	=> '10-20',
					'20'	=> '20-30',
					'30'	=> '30-40',
					'40'	=> '40-50',
					'50'	=> __('More than 50', Plugin::lang), 
		];
	}

	static public function wheel_et_minmax( $et )
	{
		if ( $et === '' ) return [ 'ui' => '' ];
		if ( $et < 0 )						return ['min' => 1000, 'max' => 0, 'ui' => -1];
		elseif ( $et >= 0 && $et < 10 )		return ['min' => 0, 'max' => 10, 'ui' => 0];
		elseif ( $et >= 10 && $et < 20 )	return ['min' => 10, 'max' => 20, 'ui' => 10];
		elseif ( $et >= 20 && $et < 30 )	return ['min' => 20, 'max' => 30, 'ui' => 20];
		elseif ( $et >= 30 && $et < 40 )	return ['min' => 30, 'max' => 40, 'ui' => 30];
		elseif ( $et >= 40 && $et < 50 )	return ['min' => 40, 'max' => 50, 'ui' => 40];
		else								return ['min' => 50, 'max' => 999, 'ui' => 50];
	}

	public static function tyre_profile()
	{
		return [25,30,35,40,45,50,55,60,65,70,75,80,85,100];
	}

	// wheel size

	public static function wheel_width()
	{
		return [ 3.5,4, 4.5, 5, 5.5, 6, 6.5, 7, 7.5, 8,
				8.5, 9, 9.5, 10, 10.5, 11, 11.5 ];
	}

	public static function wheel_r()
	{
		return [12,13,14,15,16,17,18,19,20,21,22,23,24];
	}

	public static function wheel_pcd()
	{
		return [ 	
			'3x98', '3x112',
			'4x100', '4x108', '4x114', '4x114.3', '4x98',
			'5x100', '5x105', '5x108', '5x110', '5x112', '5x114', '5x114.3', '5x115', '5x118',
			'5x120', '5x120.6', '5x127', '5x128','5x130', '5x135', '5x139.7',
			'5x150', '5x160', '5x165', '5x98',
			'6x114.3', '6x115', '6x120', '6x125', '6x127', '6x130', '6x132', '6x135', '6x139.7', '6x180',
			'8x165.1','8x170','8x180'
		];
	}
	
	static function brands()
	{
		return DB::meta_values( 'wheel_brand' );
	}

	static function meta_values( $key, $type = 'product', $status = 'publish' ) 
	{
		global $wpdb;
		
		if( empty( $key ) )
			return;

		$sql = "SELECT pm.meta_value 
				FROM {$wpdb->postmeta} pm
				LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
				WHERE pm.meta_key = '%s' 
					AND p.post_status = '%s' 
					AND p.post_type = '%s'
				GROUP BY pm.meta_value";

		$r = $wpdb->get_results( $wpdb->prepare( $sql, $key, $status, $type ) );

		$metas = [];
	    foreach ( $r as $my_r )
    	    $metas[] = $my_r->meta_value;

		return $metas;
	}

}                                  





