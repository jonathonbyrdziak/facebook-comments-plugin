<?php
/**
 * @package RedRokk
 * @version 0.04
 * 
 * Plugin Name: Facebook Comments :: Red Rokk Widget Collection
 * Description: Facebook Comments is a social plugin that enables facebook user commenting on your site. Features include moderation tools and distribution.
 * Author: RedRokk Interactive Media
 * Version: 0.04
 * Author URI: http://redrokk.com/2012/07/03/facebook-comments-red-rokk-widget-collection/
 */

/**
 * Protection 
 * 
 * This string of code will prevent hacks from accessing the file directly.
 */
defined('ABSPATH') or die("Cannot access pages directly.");

/**
 * Initializing 
 * 
 * The directory separator is different between linux and microsoft servers.
 * Thankfully php sets the DIRECTORY_SEPARATOR constant so that we know what
 * to use.
 */
defined("DS") or define("DS", DIRECTORY_SEPARATOR);

/**
 * Loading the widget class
 * 
 */
require_once dirname(__file__).DS.'widget.class.php';

/**
 * Actions and Filters
 *
 * Register any and all actions here. Nothing should actually be called
 * directly, the entire system will be based on these actions and hooks.
 */
add_action( 'widgets_init', create_function( '', 'register_widget("Facebook_Comments_Widget");' ) );

/**
 * This is the class that you'll be working with. Duplicate this class as many times as you want. Make sure
 * to include an add_action call to each class, like the line above.
 *
 * @author byrd
 *
 */
class Facebook_Comments_Widget extends Empty_Widget_Abstract
{
	/**
	 * Widget settings
	 *
	 * Simply use the following field examples to create the WordPress Widget options that
	 * will display to administrators. These options can then be found in the $params
	 * variable within the widget method.
	 *
	 *
	 */
	protected $widget = array(
		// you can give it a name here, otherwise it will default
		// to the classes name. BTW, you should change the class
		// name each time you create a new widget. Just use find
		// and replace!
		'name' => false,

		// this description will display within the administrative widgets area
		// when a user is deciding which widget to use.
		'description' => 'Facebook Comments is a social plugin that enables facebook user commenting on your site. Features include moderation tools and distribution.',

		// determines whether or not to use the sidebar _before and _after html
		'do_wrapper' => true,

		// determines whether or not to display the widgets title on the frontend
		'do_title'	=> false,

		// string : if you set a filename here, it will be loaded as the view
		// when using a file the following array will be given to the file :
		// array('widget'=>array(),'params'=>array(),'sidebar'=>array(),
		// alternatively, you can return an html string here that will be used
		'view' => false,
	
		// If you desire to change the size of the widget administrative options
		// area
		'width'	=> 350,
		'height' => 350,
	
		// Shortcode button row
		'buttonrow' => 4,
	
		// The image to use as a representation of your widget.
		// Whatever you place here will be used as the img src
		// so we have opted to use a basencoded image.
		'thumbnail' => 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAYAAACNiR0NAAAABGdBTUEAALGPC/xhBQAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9wHBQ4yL2DpHvQAAAQSSURBVDjLtZRraNZ1FMc/5/f/P3s25+aczmerJZuOzYHmSqcmBZIUiUY0pdQM8hJkaSpIEA0k3xRdhEgLLIpedCFJhCJmYr7xkqUWaIJj5RSa83E5dbfn+f8upxcbo2DWqw4cDudwzofDgfOF/9tSlfVjleO/JwU1C247P9qYmnY/9vej2O724rJNBzZU1zU8VlpWPKdoXGFplE4R3JDmEnuhO3vzSMe+rz6h84eT6WVvoD/uJcl2jAIFIK5/BNfeRvHirXMql6w/OruxrrAkFavGsUQpiGIligQ1SmEsXOpXjn2xf0/P7hWbAAoyDSRXLwBg4qqZw7AVb2+oa9l4qqk2Uxi5vAaXSOQdxivGCzjACjcGoESER1e1vFC369wJABY+P7phFPqzULOobvqytYcaKydoLogUGqTAQCzDN4lUEAVRIQrgPPQlQm3VlOqudH1t36fPHogz9YSBP4kAMqtfO11XV1Nmg0pxBOlISAEpUWJRDIEIxQTwXhFVCIHBvKespqHpYkf2cOg4dBnA0PRUfXnNtDsil1cTLHGwRCHBhDz4POpG3OZQlwM7hCY5QpJjKJdjyFqm3PdwC8DmtbOJSzJVUyW42PtIUkYwAXBKICAaIHgkxIgIYDAAXsAreMUnQWdV+m0N6xa+8+5Hxy/FOthbYoIV5yIwEJyiEggoEgLqI8RYxEQggiJoALxiLIgNMr54Is9tbj118tTS2ri/qzMbnPXBx5FzKs4osYxsF0WIiRAxiDGjwOAheCV4BQ/jkx4ymTnlW7buuMfw2+H27rM/9QUNkrcOay3eJng3Em2Cdwk+yeNtHpfksSPRJQkDgznmTUoQI+bGzYEGUwHXrre939pzuRP1Tp2zWOtwNsGNQvN4m+DyCTbJY/N5EptnaChH6c9f8vhD83De0j8wcCsaBKKSSWeutf9SUtrQPL+oICUiilFFNaAhEELAB48PHusDifcMWk/v6UPs3bqUqkw5PT1duZ2vtu6ITFk1ofeymr7uIz0X23vLGxc8EscxISiqqgEkBFUfEK9Kbz7QcfYszaaDXRuXUjO1Sjs7L8j27Vu3HT3R2RaDAhAgSU+8yyQSM5Q4DalYslev+OvZbLdJF6Vi21c2Pm3STRURO5+exdy5zXhvNaiT1lc2v9T23a+7G+/NEItJDz9heeOCigda3sp5JRm08sex/dmBc99v8S45KHGhTJ1MaWVlwczrV8bf/eaZzwsfXLxo9br1L04f6L/FqlVrKr7+9mWeWb5oWG1MUdmUouYn9o2ryExObvZevnn++EG6znwGZP9FOgtWtMxfs/LJlUviODXtww/ee/2btvP7hhViQuWYE9HE6jHrM+rH7v94z3KISm8DK7vzP9V9Rn3mH3ljQ4a/AAVwIqT8UxdwAAAAAElFTkSuQmCC',
			
		/* The field options that you have available to you. Please
		 * contribute additional field options if you create any.
		 * 
		 */
		'fields' => array(
			array(
				'name' => 'Title',
				'desc' => '',
				'id' => 'title',
				'type' => 'text',
				'default' => ''
			),
			array(
				'name' => 'App ID',
				'desc' => '',
				'id' => 'appId',
				'type' => 'text',
				'default' => '',
				'desc'	=> '<a href="https://developers.facebook.com/apps/" target="_blank">Get an App ID</a>'
			),
			array(
				'name' 		=> 'Link',
				'desc' 		=> '',
				'id' 		=> 'href',
				'type' 		=> 'text',
				'default' 	=> '',
				'desc'		=> 'No url will use the current pages url'
			),
			array(
				'name' 		=> 'Number of Posts',
				'desc' 		=> '',
				'id' 		=> 'numPosts',
				'type' 		=> 'text',
				'default' 	=> '5',
				'desc'		=> 'The number of posts to display by default'
			),
			array(
				'name' 		=> 'Width',
				'desc' 		=> '',
				'id' 		=> 'width',
				'type' 		=> 'text',
				'default' 	=> '470',
				'desc'		=> ''
			),
			array(
			    'name'    	=> 'Style',
				'desc' 		=> '',
			    'id'      	=> 'color',
			    'type'    	=> 'select',
			    'options' 	=> array(
				    'dark' 	=> 'Dark',
				    'light'	=> 'Light'
				),
				'desc'		=> 'The color scheme of the comments'
			),
			array(
			    'name'    	=> 'Code',
				'desc' 		=> '',
			    'id'      	=> 'code',
			    'type'    	=> 'select',
			    'options' 	=> array(
				    'html5' 	=> 'HTML 5',
				    'xfbml'		=> 'XFBML',
		//			'iframe'	=> 'IFRAME',
		//			'url'		=> 'URL'
				),
				'desc'		=> ''
			),
		)
	);
	
	/**
	 * Constructor.
	 * 
	 */
	function __construct()
	{
		parent::__construct();
		
		// Hooks
		add_action('init', array(&$this, 'init'));
		add_filter('language_attributes', array(&$this, 'language_attributes'));
		add_filter('comments_template', array(&$this, 'comments_template'));
	}
	
	/**
	 * 
	 */
	function init()
	{
		register_sidebar( array(
			'name'          => 'Comments Area',
			'id'            => 'sidebar-comments-area',
			'description'   => 'This sidebar wraps your current WordPress comments area. Any widgets placed in this area will hide your default comments and display the widgets instead.',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widgettitle">',
			'after_title'   => '</h2>' 
		) );
	}
	
	/**
	 * 
	 * @param string $output
	 * @return string
	 */
	function language_attributes( $output )
	{
		static $once;
		if (isset($once)) return;
		$once = $output .= ' xmlns:fb="http://ogp.me/ns/fb#" ';
		
		return $output;
	}
	
	/**
	 * 
	 * @param $file
	 */
	function comments_template( $file )
	{
		if (!dynamic_sidebar('sidebar-comments-area')) {
			return $file;
		}
		return dirname(__file__).DS.'index.php';
	}

	/**
	 * Widget HTML
	 *
	 * If you want to have an all inclusive single widget file, you can do so by
	 * dumping your css styles with base_encoded images along with all of your
	 * html string, right into this method.
	 *
	 * @param array $widget
	 * @param array $params
	 * @param array $sidebar
	 */
	function html( $widget = array(), $params = array(), $sidebar = array() )
	{
		extract(wp_parse_args($params, array(
			'appId' 	=> '',
			'color'		=> 'light',
			'href'		=> false,
			'numPosts'	=> 5,
			'width'		=> '470',
			'mobile'	=> 'auto-detect',
			'code'		=> 'html5'
		)));
		
		$href = trim($href)?trim($href) :get_permalink( get_queried_object_id() );
		
		switch ($code) { default:
		case 'html5' :
		?>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo $appId ?>";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<div class="fb-comments" 
			data-href="<?php echo $href ?>"
			href="<?php echo $href ?>"
			data-num-posts="<?php echo $numPosts ?>" 
			data-width="<?php echo $width ?>" 
			mobile="<?php echo $mobile ?>"
			data-colorscheme="<?php echo $color ?>"></div>
		<?php 
		break;
		case 'xfbml' :
		?>
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=<?php echo $appId ?>";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<fb:comments 
			href="<?php echo $href ?>" 
			num_posts="<?php echo $numPosts ?>" 
			mobile="<?php echo $mobile ?>"
			data_colorscheme="<?php echo $color ?>"
			width="<?php echo $width ?>"></fb:comments>
		<?php 
		break;
		}
	}
}

