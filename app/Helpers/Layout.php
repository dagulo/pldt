<?php

namespace Helpers;

use Collective\Html\HtmlFacade;

class Layout extends HtmlFacade{
	
	protected $scripts  = array(); 
	protected $styles   = array();
	protected static $instances = array();
	
	public static function instance( $key = 'default' ){		

		if( isset( static::$instances[ $key ] ) ){
			return static::$instances[ $key ];
		}
		
		return static::$instances[ $key ] = new static;
	}

	/**
	 * add single page scripts
	 * @param string $script_path
	 */
	public function addScript( $script_path ){
		$this->scripts[] = 	$script_path;
	}
	
	/**
	 * add style 
	 * @param string $script_path
	 */
	public function addStyle( $style_path ){
		$this->styles[] = 	$style_path;
	}

	/**
	 * get all javascripts queued
	 * @return array
	 */
	public function getScripts(){
		return $this->scripts;
	}

	/**
	 * get all stylesheet queued
	 * @return array
	 */
	public function getStyles(){
		return $this->styles;
	}

	public function renderScript( $path ){

		$subdir = '';

		if( substr( $path , 0 , 4 ) != 'http' ){
			$subdir = env('SUBDIR') ? '/'.env('SUBDIR'): '';
			$path = substr( $path , 0 , 1 ) == '/' ? $path : '/'.$path;
		}

		return '<script src="'.$subdir.$path.'"></script>'."\r";
	}

	public function renderStyle( $path ){
		$subdir = '';

		if( substr( $path , 0 , 4 ) != 'http' ){
			$subdir = env('SUBDIR') ? '/'.env('SUBDIR'): '';
			$path = substr( $path , 0 , 1 ) == '/' ? $path : '/'.$path;
		}

		return '<link rel="stylesheet" href="'.$subdir.$path.'">'."\r";
	}

	public function renderPageScripts(){
		$html = array();		
		foreach( $this->getScripts() as $script ){
			$html[] = $this->renderScript( $script );
		}
		return implode( "\r\n" , $html );
	}
	
	public function renderPageStyles(){
		$html = array();		
		foreach( $this->getStyles() as $style ){
			$html[] = $this->renderStyle( $style );
		}
		return implode( "\r\n" , $html );
	}

	public static function loadVue()
	{
		static::instance()->addScript( '/vendor/vue/vue-2.0.1.min.js' );
	}

	public static function loadCaption()
	{
		Html::instance()->addScript( '/plugins/captions/jquery.caption.min.js' );
		Html::instance()->addStyle( '/plugins/captions/captionjs.min.css' );
	}


	public static function loadDateCombo()
	{
		static::instance()->addScript( '/public/plugins/datecombo/moment.js' );
		static::instance()->addScript( '/public/plugins/datecombo/combodate.js' );
	}

	public static function loadToastr()
	{
		static::instance()->addStyle( '/vendor/toastr/toastr.min.css' );
		static::instance()->addScript( '/vendor/toastr/toastr.min.js' );
	}

	public static function loadJQueryUI()
	{
		static::instance()->addScript( '/js/jquery_ui/jquery-ui.min.js' );
		static::instance()->addStyle( '/js/jquery_ui/jquery-ui.min.css' );

	}


	public static function loadChatbot()
	{
		static::instance()->addScript( '/public/plugins/apiai/src/resampler.js' );
		static::instance()->addScript( '/public/plugins/apiai/src/recorderWorker.js' );
		static::instance()->addScript( '/public/plugins/apiai/src/recorder.js' );
		static::instance()->addScript( '/public/plugins/apiai/src/processors.js' );
		static::instance()->addScript( '/public/plugins/apiai/src/vad.js' );
		static::instance()->addScript( '/public/plugins/apiai/src/tts.js' );
		static::instance()->addScript( '/public/plugins/apiai/src/api.ai.js' );
	}

	public static function loadDatepicker()
	{
		static::instance()->addScript( '/public/plugins/datepicker/jquery-ui-datepicker.js' );
		static::instance()->addStyle( '/public/plugins/datepicker/datepicker.css' );
		static::instance()->addStyle( '/public/css/jquery-ui/base.css' );
	}


	public static function loadFileupload( $file_type = null )
	{
		static::instance()->addScript( '/vendor/jquery-fileupload/js/vendor/jquery.ui.widget.js' );
		static::instance()->addScript( '/vendor/jquery-fileupload/js/jquery.iframe-transport.js' );
		static::instance()->addScript( '/vendor/jquery-fileupload/js/jquery.fileupload.js' );
	}

	public static function placeholderImage(){
		return '/images/placeholder.jpg';
	}

	public static function generateErrorMessage( $errors ){
		$html = '<ul>';
		 foreach( $errors as $e ){
			 $html .= '<li>'.$e.'</li>';
		 }
		$html .= '</ul>';
		return $html;
	}

}