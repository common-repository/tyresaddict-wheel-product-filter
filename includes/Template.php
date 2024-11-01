<?php
/**
 * Simple Template
 *
 * @since      1.0.0
 * @package    TyresAddict/WFilter
 * @author     TyresAddict
 * @link       http://b2b.tyresaddict.com
 */

namespace TyresAddict\WFilter;


// Template Class

class Template
{
	protected $template_path = '';

	// Setup template path

	public function __construct( $template_path = '' ) 
	{
		if ( $template_path ) {
			$this->template_path = Plugin::path() . $template_path . '/';
		} else {
			$this->template_path = Plugin::path() . 'templates/';
		}
	}

	public function display( $template, $theme = '', array $data = [] ) 
	{
		if ( $theme != '' )
			$template = $template . '-' . $theme;

		echo $this->fetch( $template, $data );
	}

	// Fetch a template, returns string
	// throws RuntimeException if template does not exist

	public function fetch( $template, array $data = [] ) 
	{
		// Look in templates folder.
		if ( ! is_file( $this->template_path ) ) {
			$file = $this->template_path . $template . '.php';
			if ( ! is_file( $file ) ) {
				throw new \RuntimeException( "View cannot render `$template` because the template does not exist" );
			}
		}

		// add textdomain

		$data['t'] = Plugin::lang;

		ob_start();
		$this->sandbox( $file, $data );
		$output = ob_get_clean();

		return $output;
	}

	// sandbox for template variables

	protected function sandbox( $template, array $data ) 
	{
		extract( $data );
		include $template;
	}

}


