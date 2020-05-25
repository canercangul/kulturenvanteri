<?php

namespace ACP\Settings\ListScreen\HideOnScreen;

use ACP;

class Filters extends ACP\Settings\ListScreen\HideOnScreen {

	public function __construct() {
		parent::__construct( 'hide_filters', __( 'Filters', 'codepress-admin-columns' ) );
	}

}