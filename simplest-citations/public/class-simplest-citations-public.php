<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://thewebco.uk
 * @since      1.0.0
 *
 * @package    Simplest_Citations
 * @subpackage Simplest_Citations/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Simplest_Citations
 * @subpackage Simplest_Citations/public
 * @author     The Web Co. <hello@thewebco.uk>
 */
class Simplest_Citations_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simplest_Citations_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simplest_Citations_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/simplest-citations-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Simplest_Citations_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Simplest_Citations_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/simplest-citations-public.js', array( 'jquery' ), $this->version, false );

	}

}

// Citation Shortcode
function simplest_citations_cite_shortcode($atts, $content = null) {
    static $cite_count = 0;
    $cite_count++;

    // Store the citation content for use in both tooltip and [citelist] shortcode
    global $citelist;
    $citelist[$cite_count] = $content;

    // Citation link with tooltip data attribute
    $cite_link = '<sup><a href="#cite-' . $cite_count . '" id="cite-link-' . $cite_count . '" class="cite-tooltip" data-tooltip="' . esc_attr($content) . '">[' . $cite_count . ']</a></sup>';
    
    return $cite_link;
}
add_shortcode('cite', 'simplest_citations_cite_shortcode');

// Citation List shortcode
function simplest_citations_citelist_shortcode() {
    global $citelist;
    $output = '<ol class="citation-list">';

    foreach ($citelist as $num => $citation) {
        $output .= '<li id="cite-' . $num . '">' . $citation . ' <a href="#cite-link-' . $num . '">[Back]</a></li>';
    }

    $output .= '</ol>';
    return $output;
}
add_shortcode('citelist', 'simplest_citations_citelist_shortcode');

// Template Output
function simplest_citations_append_citelist($content) {
    global $citelist;

    // Only add the citations list if there are citations present
    if (!empty($citelist) && strpos($content, '[citelist]') === false) {
        $content .= '<h3>Citations</h3>[citelist]';
    }

    return $content;
}
add_filter('the_content', 'simplest_citations_append_citelist');
