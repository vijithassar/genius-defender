<?php

/*
Plugin Name: Genius Defender
Plugin URI: http://github.com/vijithassar/wp-no-genius
Description: break Genius.com annotations
Version: 0.0.1
Author: Vijith Assar
Author URI: http://www.vijithassar.com
License: GPL-2.0+
License URI: http://www.gnu.org/licenses/gpl-2.0.txt
*/

class WPGeniusDefender {

  // register content actions
	public function __construct() {
		if ( !is_feed() ) {
  		add_filter( 'the_content', array($this, 'scramble') );
		}
	}

	// scramble content
	public function scramble($content) {
		require_once(plugin_dir_path(__FILE__) . 'genius-defender.php');
		$genius_defender = new GeniusDefender;
		return $genius_defender->html($content);
	}

}

// instantiate
new WPGeniusDefender;
