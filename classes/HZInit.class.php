<?php
class HZInit extends HZWP {
	
	private $options;
	
	function HZInit($options) {

		$this->options = $options;

		$this->utilities = new HZUtilities();

		$this->add_stylesheets();
		
		if (!is_admin())
			$this->add_javascript();
				
		$this->remove_generator_meta();
		
		if ($this->options->print_author_tag)
			add_action('wp_head',array($this,'print_author_tag'),null,null);
				
		add_theme_support('post-thumbnails');
		add_theme_support('post-formats');
			
	}

	function add_stylesheets() {
		wp_enqueue_style('jquery-ui-lightness',get_bloginfo('template_url').'/css/jquery-ui-lightness.css');

		if ($this->utilities->is_ie() == 'IE6')
			wp_enqueue_style('ie6',get_bloginfo('template_url').'/css/ie6.css','main-styles');
		
		if ($this->utilities->is_ie() == 'IE7')
			wp_enqueue_style('ie7',get_bloginfo('template_url').'/css/ie7.css','main-styles');

		if ($this->utilities->is_ie() == 'IE8')
			wp_enqueue_style('ie8',get_bloginfo('template_url').'/css/ie8.css','main-styles');
	
		if(is_admin())
			wp_enqueue_style('hz-admin',get_bloginfo('template_url').'/css/hz-admin.css');			
			
		add_action('wp_print_styles',array($this,'add_main_stylesheet'));

	}
	
	
	function add_main_stylesheet() {
		
		if(is_admin())
			return;
			
		wp_enqueue_style('main-styles',get_bloginfo('template_url').'/css/style.css');
		
	}

	function add_javascript() {
		
		if (is_admin())
			return;
		
		if ($this->options->load_modernizr)
		wp_enqueue_script('modernizr',get_bloginfo(
			'template_url').'/js/modernizr.js');
		
		wp_deregister_script('jquery');
		
		if ($this->options->use_jquery_google_cdn) {
			wp_register_script(
				'jquery','https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
			wp_enqueue_script('jquery');
		} else {
			wp_enqueue_script('jquery',get_bloginfo('template_url').'/js/jquery-latest.min.js');
		}
		
		if ($this->options->use_jquery_ui_google_cdn) {
			wp_register_script('jquery-ui','https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js','jquery');
		} else {
			wp_register_script('jquery-ui',get_bloginfo('template_url').'/js/jquery-latest.min.js','jquery');
		}
		
		if ($this->options->load_jquery_ui)
			wp_enqueue_script('jquery-ui');
		
		if ($this->options->load_swf_object)
			wp_enqueue_script('swfobject',get_bloginfo('template_url').'/js/swfobject-latest.js','jquery');
		
		wp_enqueue_script('global-scripts',get_bloginfo('template_url').'/js/global-scripts.js','jquery',null,true);  		  
		
	}

  /**
   *
   * CSS directory setter
   *
   * Specifies the new CSS Directory
   *
   * @author Ryan Bagwell <ryan@ryanbagwell.com>
   * @return void
	 *
  */
	function set_stylesheet_dir($stylesheet_uri = null,$theme_name){
		
		if (is_null($stylesheet_uri))
			$stylesheet_uri = TEMPLATEPATH."/css";
		
		return $stylesheet_uri.'/css';
	
	}


  /**
   *
   * Generator meta tag remover
   *
   * Removes the generator meta tag from the head section
   *
   * @author Ryan Bagwell <ryan@ryanbagwell.com>
   * @return void
	 *
  */	
	function remove_generator_meta() {
		remove_action('wp_head', 'wp_generator');
	}

  /**
   *
   * Author Setter
   *
   * Adds an author tag to the 
   *
   * @author Ryan Bagwell <ryan@ryanbagwell.com>
   * @return void
	 *
  */	
	function print_author_tag() {
		
		echo "<meta name='author' content='{$this->options->site_author}' />\r\n";
	}
	
}

?>
