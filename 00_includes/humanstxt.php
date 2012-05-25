<?php
/**
 * Humans.txt Tutorial (for for onextrapixel.com)
 *
 * Author: Anna Ladoshkina
 * Description: Code snippet to incorporate humans.txt functionality into WordPress
 * Author URI: http://about.me/foralien
 * Requires: WordPress 3.1
 * Mod: Read humans.txt file on theme directory by attendants
 **/

/* Generate humans.txt content */
function do_humans() {		
	
	//serve correct headers
	header( 'Content-Type: text/plain; charset=utf-8' ); 
	
	//let some other plugins do something here
	do_action( 'do_humanstxt' ); 
	
	//prepare default content
	$content =file_get_contents(TEMPLATEPATH .'/humans.txt');
	
	//make it filterable
	$content = apply_filters('humans_txt', $content);
	
	//correct line ends
	$content = str_replace("\r\n", "\n", $content);
	$content = str_replace("\r", "\n", $content);
	
	//output
	echo $content;		
}

/* Link to humans.txt for head section of site */
function frl_humanstxt_link(){
   
    $url = esc_url(home_url('humans.txt'));    
    echo "<link rel='author' href='{$url}' />";
}

/* Print humans.txt button somewhere on the site */
function frl_humanstxt_button(){	
	
	//make sure that this is correct path to button image !!!
	$src = esc_url(trailingslashit(plugins_url('', __FILE__)).'humanstxt-isolated-orange.gif');	
	$url = esc_url(home_url('humans.txt'));	
	echo "<div id='humanstxt-badge'><a href='{$url}'><img src='{$src}' alt='humans.txt' /></a></div>";
}


/* Make WP understand humans.txt url */
function frl_humanstxt_init(){
    global $wp_rewrite, $wp;
    
	//root install check
	$homeurl = parse_url(home_url());
	if (isset($homeurl['path']) && !empty($homeurl['path']) && $homeurl['path'] != '/')
		return;
	
	//check for pretty permalinks
	$permalink_test = get_option('permalink_structure');
	if(empty($permalink_test))
		return;
	    
    //register rewrite rule for humans.txt request		
	add_rewrite_rule('humans\.txt$', $wp_rewrite->index.'?humans=1', 'top');
		    
    // flush rewrite rules if 'humans' one is missing
	$rewrite_rules = get_option('rewrite_rules');
	if (!isset($rewrite_rules['humans\.txt$'])) 
		flush_rewrite_rules(false);
		
	//add 'humans' query variable to WP 
	$wp->add_query_var('humans');
	
	// display links to humans txt (when it's properly registered)
	if(function_exists('frl_humanstxt_link'))
		add_action('wp_head', 'frl_humanstxt_link');
		
	if(function_exists('frl_humanstxt_button'))
		add_action('wp_footer', 'frl_humanstxt_button'); 
}
add_action('init', 'frl_humanstxt_init');

/* Conditional tag to check for humans.txt request */
function is_humans(){
       
    if( 1 == get_query_var('humans'))
        return true;
    
    return false;
}


/* Load dynamic content instead or regular WP template */
function frl_humanstxt_load(){
    
    if(is_humans()){
        do_humans();
        die();
    }
}
add_action('template_redirect', 'frl_humanstxt_load');

?>