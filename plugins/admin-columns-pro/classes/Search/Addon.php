<?php

namespace ACP\Search;

use AC;
use AC\Asset\Location;
use AC\ListScreenRepository\Storage;
use ACP;
use ACP\Search\Controller\Comparison;
use ACP\Search\Controller\Segment;
use ACP\Settings\ListScreen\HideOnScreen;
use ACP\Settings\ListScreen\HideOnScreenCollection;

final class Addon implements AC\Registrable {

	/**
	 * @var AC\Request
	 */
	private $request;

	/**
	 * @var Location
	 */
	private $location;

	/** @var ACP\Search\Preferences\SmartFiltering */
	private $table_preference;

	/** @var HideOnScreen\Filters */
	private $hide_filters;

	/**
	 * @var Storage
	 */
	private $storage;

	public function __construct( Storage $storage, Location $location ) {
		$this->storage = $storage;
		$this->location = $location;
		$this->request = new AC\Request();
		$this->request->add_middleware( new Middleware\Request() );
		$this->table_preference = new ACP\Search\Preferences\SmartFiltering();
		$this->hide_filters = new HideOnScreen\Filters();
	}

	/**
	 * @param AC\ListScreen $list_screen
	 *
	 * @return bool
	 */
	private function is_active( AC\ListScreen $list_screen ) {
		return apply_filters( 'acp/search/is_active', $this->table_preference->is_active( $list_screen ), $list_screen );
	}

	public function register() {
		$settings = new Settings( [
			new AC\Asset\Style( 'acp-search-admin', $this->location->with_suffix( 'assets/search/css/admin.css' ) ),
		] );
		$settings->register();

		$table_screen_options = new TableScreenOptions(
			[
				new AC\Asset\Script( 'acp-search-table-screen-options', $this->location->with_suffix( 'assets/search/js/screen-options.bundle.js' ) ),
			],
			$this->table_preference,
			$this->hide_filters
		);
		$table_screen_options->register();

		add_action( 'ac/table/list_screen', [ $this, 'table_screen_request' ] );
		add_action( 'wp_ajax_acp_search_segment_request', [ $this, 'segment_request' ] );
		add_action( 'wp_ajax_acp_search_comparison_request', [ $this, 'comparison_request' ] );
		add_action( 'acp/admin/settings/hide_on_screen', [ $this, 'add_hide_on_screen' ] );
	}

	public function add_hide_on_screen( HideOnScreenCollection $collection ) {
		$collection->add( new ACP\Search\Settings\HideOnScreen\SavedFilters(), 30 );
	}

	public function segment_request() {
		$segment = new Segment(
			$this->storage,
			$this->request,
			new Middleware\Rules()
		);

		$segment->dispatch( $this->request->get( 'method' ) );
	}

	public function comparison_request() {
		$comparison = new Comparison(
			$this->storage,
			$this->request
		);

		$comparison->dispatch( $this->request->get( 'method' ) );
	}

	/**
	 * @param AC\ListScreen $list_screen
	 *
	 * @return bool
	 */
	private function is_filters_hidden( AC\ListScreen $list_screen ) {
		return $this->hide_filters->is_hidden( $list_screen );
	}

	/**
	 * @param AC\ListScreen $list_screen
	 */
	public function table_screen_request( AC\ListScreen $list_screen ) {
		if ( $this->is_filters_hidden( $list_screen ) || ! $this->is_active( $list_screen ) ) {
			return;
		}

		$filters = $this->get_filters( $list_screen );

		$assets = [
			new AC\Asset\Style( 'aca-search-table', $this->location->with_suffix( 'assets/search/css/table.css' ) ),
			new AC\Asset\Script( 'aca-search-moment', $this->location->with_suffix( 'assets/search/js/moment.min.js' ) ),
			new AC\Asset\Script( 'aca-search-querybuilder', $this->location->with_suffix( 'assets/search/js/query-builder.standalone.min.js' ), [ 'jquery', 'jquery-ui-datepicker' ] ),
			new Asset\Script\Table(
				'aca-search-table',
				$this->location->with_suffix( 'assets/search/js/table.bundle.js' ),
				$filters,
				$this->request
			),
		];

		$table_screen = TableScreenFactory::create( $this, $list_screen, $this->request, $assets );

		if ( ! $table_screen ) {
			return;
		}

		$table_screen->register();
	}

	/**
	 * @param AC\ListScreen $list_screen
	 *
	 * @return array
	 */
	private function get_filters( AC\ListScreen $list_screen ) {
		$filters = [];

		foreach ( $list_screen->get_columns() as $column ) {
			$setting = $column->get_setting( 'search' );

			if ( ! $setting instanceof Settings\Column || ! $setting->is_active() ) {
				continue;
			}

			if ( ! $column instanceof Searchable || ! $column->search() ) {
				continue;
			}

			$filter = new Middleware\Filter(
				$column->get_name(),
				$column->search(),
				$this->get_filter_label( $column )
			);

			$filters[] = $filter();
		}

		return $filters;
	}

	/**
	 * @param AC\Column $column
	 *
	 * @return string
	 */
	private function get_filter_label( AC\Column $column ) {
		$label = $this->sanitize_label( $column->get_custom_label() );

		if ( ! $label ) {
			$label = $this->sanitize_label( $column->get_label() );
		}

		if ( ! $label ) {
			$label = $column->get_type();
		}

		return $label;
	}

	/**
	 * Allow dashicons as label, all the rest is parsed by 'strip_tags'
	 *
	 * @param string $label
	 *
	 * @return string
	 */
	private function sanitize_label( $label ) {
		if ( false === strpos( $label, 'dashicons' ) ) {
			$label = strip_tags( $label );
		}

		return trim( $label );
	}

}