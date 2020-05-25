<?php
namespace ACP;

use AC\Registrable;

class Localize implements Registrable {

	const TEXTDOMAIN = 'codepress-admin-columns';

	/**
	 * @var string
	 */
	private $plugin_dir;

	public function __construct( $plugin_dir ) {
		$this->plugin_dir = $plugin_dir;
	}

	public function register() {
		add_action( 'init', [ $this, 'localize' ] );
	}

	public function localize() {
		// prevent the loading of existing translations within the 'wp-content/languages' folder.
		unload_textdomain( self::TEXTDOMAIN );

		$this->load_textdomain( $this->plugin_dir . 'admin-columns/languages' );
		$this->load_textdomain( $this->plugin_dir . 'languages' );
	}

	/**
	 * @return string
	 */
	private function get_local() {
		return (string) apply_filters( 'plugin_locale', determine_locale(), self::TEXTDOMAIN );
	}

	/**
	 * Do no use `load_plugin_textdomain()` because it could prevent
	 * pro languages from loading when core translation files are found.
	 */
	private function load_textdomain( $language_dir ) {
		$mofile = sprintf(
			'%s/%s-%s.mo',
			$language_dir,
			self::TEXTDOMAIN,
			$this->get_local()
		);

		load_textdomain( self::TEXTDOMAIN, $mofile );
	}

}