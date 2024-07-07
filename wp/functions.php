<?php
  namespace snrg;

  require_once get_template_directory() . '/include/constants.php';



  //--------
  // ROUTING
  //--------


  function add_query_vars( $query_vars ) {
    $query_vars[] = 'route';
    return $query_vars;
  }

  add_filter( 'query_vars', 'snrg\add_query_vars' );

  function add_rewrite_rules() {
    /* Routes by which the single page application can be accessed (visible by search engines):
     * - /
     * - /bio
     * - /compte
     * - /helikia
     * - /helikia/:module
     * - /blog/:slug
     */
    add_rewrite_rule( '^(' . SLUG_FOR_BIOGRAPHY_PAGE . ')/?$', 'index.php?route=$matches[1]', 'top' );
    add_rewrite_rule( '^(' . SLUG_FOR_ACCOUNT_PAGE . ')/?$', 'index.php?route=$matches[1]', 'top' );
    add_rewrite_rule( '^(' . SLUG_FOR_HELIKIA_PAGE . ')/?$', 'index.php?route=$matches[1]', 'top' );
    add_rewrite_rule( '^(' . SLUG_FOR_HELIKIA_PAGE . '/[^/]+)/?$', 'index.php?route=$matches[1]', 'top' );
    add_rewrite_rule( '^(' . SLUG_FOR_BLOG_PAGE . '/[^/]+)/?$', 'index.php?route=$matches[1]', 'top' );
    add_rewrite_rule( '^.+/?$', 'index.php?route=404', 'top' );
  }

  add_action( 'init', 'snrg\add_rewrite_rules' );

  function change_template_selection( $template ) {
    $route = get_query_var( 'route' );
    if ( $route ):
      if ( $route != '404' ):
        $matches = [];
        if ( preg_match( '@^(' . SLUG_FOR_BIOGRAPHY_PAGE . ')/?$@', $route, $matches ) ||
            preg_match( '@^(' . SLUG_FOR_ACCOUNT_PAGE . ')/?$@', $route, $matches ) ||
            preg_match( '@^(' . SLUG_FOR_HELIKIA_PAGE . ')/?$@', $route, $matches ) ||
            preg_match( '@^' . SLUG_FOR_HELIKIA_PAGE . '/([^/]+)/?$@', $route, $matches ) ||
            preg_match( '@^' . SLUG_FOR_BLOG_PAGE . '/([^/]+)/?$@', $route, $matches )
          ):
          // Slugs must be unique across post types. Slugs starting with 'snrg-' are reserved for the theme.
          if ( substr( $matches[ 1 ], 0, 5 ) !== 'snrg-' && get_posts( [ 'name' => $matches[ 1 ], 'post_type' => [ 'post', 'page', MODULE_POST_TYPE ], 'post_status' => 'publish', 'posts_per_page' => 1 ] ) ):
            return locate_template( 'singular.php' );
          endif;
        endif;
      endif;
      global $wp_query;
      $wp_query->set_404();
      status_header( 404 );
      $template = locate_template( '404.php' );
    endif;
    return $template;
  }

  add_filter( 'template_include', 'snrg\change_template_selection' );



  //---------
  // SETTINGS
  //---------


  function render_section( $args ) { ?>
    <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( '', DOMAIN ); ?></p>
  <?php }

  function render_field( $args ) {
    $field = $args['field'];
    $options = get_option( SETTINGS_DATA );
    if ( $field[ 'type' ] == SETTINGS_TYPE_FOR_URLS ): ?>
      <input type="url" id="<?php echo str_replace( '_', '-', esc_attr( $field['id'] ) ); ?>" name="<?php echo SETTINGS_DATA . '[' . esc_attr( $field['id'] ) . ']'; ?>" value="<?php echo isset( $options[ $field['id'] ] ) ? esc_attr( $options[ $field['id'] ] ) : ''; ?>" placeholder="https://example.com" pattern="https://.*" size="30" required />
    <?php endif;
  }

  function render_settings_page() {
    if ( ! current_user_can( CAPABILITY_REQUIRED_FOR_SETTINGS ) ):
      return;
    endif;
    if ( isset( $_GET['settings-updated'] ) ):
      add_settings_error( 'snrg_messages', 'snrg_message', __( 'Settings Saved', DOMAIN ), 'updated' );
    endif;
    settings_errors( 'snrg_messages' ); ?>
    <div class="wrap">
      <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
      <form action="options.php" method="post"> <?php
        settings_fields( SETTINGS );
        do_settings_sections( SETTINGS );
        submit_button( __( 'Save Settings', DOMAIN ) ); ?>
      </form>
    </div> <?php
  }

  function add_settings() {
    register_setting( SETTINGS, SETTINGS_DATA );
    add_settings_section( SETTINGS_SECTION_FOR_URLS, __( 'Page Settings', DOMAIN ), 'snrg\render_section', SETTINGS );
    foreach( SETTINGS_FIELDS as $field ) {
      add_settings_field( $field[ 'id' ], __( $field[ 'label' ], DOMAIN ), 'snrg\render_field', SETTINGS, SETTINGS_SECTION_FOR_URLS, [ 'label_for' => str_replace( '_', '-', $field[ 'id' ] ), 'field' => $field ] );
    }
  }

  function add_settings_page() {
    add_menu_page( 'WP Synergia', 'WP Synergia', CAPABILITY_REQUIRED_FOR_SETTINGS, SETTINGS, 'snrg\render_settings_page', 'dashicons-menu' );
  }

  add_action( 'admin_init', 'snrg\add_settings' );
  add_action( 'admin_menu', 'snrg\add_settings_page' );



  //-----------
  // POST TYPES
  //-----------


  function add_theme_supports() {
    add_theme_support( 'post-thumbnails' );
  }

  add_action( 'after_setup_theme', 'snrg\add_theme_supports' );

  function register_post_types() {
    register_post_type( PROGRAM_POST_TYPE, [
        'labels' => [
            'name' => __('Programs', DOMAIN ),
            'singular_name' => __( 'Program', DOMAIN ),
            'add_new' => __( 'Add New Program', DOMAIN ),
            'add_new_item' => __( 'Add New Program', DOMAIN ),
            'edit_item' => __( 'Edit Program', DOMAIN ),
            'new_item' => __( 'New Program', DOMAIN ),
            'view_item' => __( 'View Program', DOMAIN ),
            'view_items' => __( 'View Programs', DOMAIN ),
            'search_items' => __( 'Search Programs', DOMAIN ),
            'not_found' => __( 'No programs found', DOMAIN ),
            'not_found_in_trash' => __( 'No programs found in Trash', DOMAIN ),
            'all_items' => __( 'All Programs', DOMAIN ),
            'archives' => __( 'Program Archives', DOMAIN ),
            'attributes' => __( 'Program Attributes', DOMAIN ),
            'insert_into_item' => __( 'Insert into program', DOMAIN ),
            'uploaded_to_this_item' => __( 'Uploaded to this program', DOMAIN ),
            'filter_items_list' => __( 'Filter programs list', DOMAIN ),
            'items_list_navigation' => __( 'Programs list navigation', DOMAIN ),
            'items_list' => __( 'Programs list', DOMAIN ),
            'item_published' => __( 'Program published', DOMAIN ),
            'item_published_privately' => __( 'Program published privately', DOMAIN ),
            'item_reverted_to_draft' => __( 'Program reverted to draft', DOMAIN ),
            'item_trashed' => __( 'Program trashed', DOMAIN ),
            'item_scheduled' => __( 'Program scheduled', DOMAIN ),
            'item_updated' => __( 'Program updated', DOMAIN ),
            'item_link' => __( 'Program Link', DOMAIN ),
            'item_link_description' => __( 'A link to a program', DOMAIN ),
          ],
        'menu_icon' => 'dashicons-pressthis',
        'menu_position' => 20,
        'public' => true,
        'supports' => [ 'title', 'editor' ],
        'show_in_rest' => true,
        'rest_base' => PROGRAM_BASE_IN_REST,
      ] );
    register_post_type( MODULE_POST_TYPE, [
        'labels' => [
            'name' => __( 'Modules', DOMAIN ),
            'singular_name' => __( 'Module', DOMAIN ),
            'add_new' => __( 'Add New Module', DOMAIN ),
            'add_new_item' => __( 'Add New Module', DOMAIN ),
            'edit_item' => __( 'Edit Module', DOMAIN ),
            'new_item' => __( 'New Module', DOMAIN ),
            'view_item' => __( 'View Module', DOMAIN ),
            'view_items' => __( 'View Modules', DOMAIN ),
            'search_items' => __( 'Search Modules', DOMAIN ),
            'not_found' => __( 'No modules found', DOMAIN ),
            'not_found_in_trash' => __( 'No modules found in trash', DOMAIN ),
            'all_items' => __( 'All Modules', DOMAIN ),
            'archives' => __( 'Module Archives', DOMAIN ),
            'attributes' => __( 'Module Attributes', DOMAIN ),
            'insert_into_item' => __( 'Insert into module', DOMAIN ),
            'uploaded_to_this_item' => __( 'Uploaded to this module', DOMAIN ),
            'filter_items_list' => __( 'Filter modules list', DOMAIN ),
            'items_list_navigation' => __( 'Modules list navigation', DOMAIN ),
            'items_list' => __( 'Modules list', DOMAIN ),
            'item_published' => __( 'Module published', DOMAIN ),
            'item_published_privately' => __( 'Module published privately', DOMAIN ),
            'item_reverted_to_draft' => __( 'Module reverted to draft', DOMAIN ),
            'item_trashed' => __( 'Module trashed', DOMAIN ),
            'item_scheduled' => __( 'Module scheduled', DOMAIN ),
            'item_updated' => __( 'Module updated', DOMAIN ),
            'item_link' => __( 'Module Link', DOMAIN ),
            'item_link_description' => __( 'A link to a module', DOMAIN ),
          ],
        'menu_icon' => 'data:image/svg+xml;base64,' . base64_encode( file_get_contents( get_template_directory() . '/assets/icons/module.svg' ) ),
        'menu_position' => 20,
        'public' => true,
        'supports' => [ 'title', 'thumbnail', 'excerpt' ],
        'show_in_rest' => true,
        'rest_base' => MODULE_BASE_IN_REST,
      ] );
    register_post_type( SESSION_POST_TYPE, [
        'labels' => [
            'name' => __('Sessions', DOMAIN ),
            'singular_name' => __( 'Session', DOMAIN ),
            'add_new' => __( 'Add New Session', DOMAIN ),
            'add_new_item' => __( 'Add a New Session', DOMAIN ),
            'edit_item' => __( 'Edit Session', DOMAIN ),
            'new_item' => __( 'New Session', DOMAIN ),
            'view_item' => __( 'View Session', DOMAIN ),
            'view_items' => __( 'View Sessions', DOMAIN ),
            'search_items' => __( 'Search Sessions', DOMAIN ),
            'not_found' => __( 'No sessions found', DOMAIN ),
            'not_found_in_trash' => __( 'No sessions found in trash', DOMAIN ),
            'all_items' => __( 'All Sessions', DOMAIN ),
            'archives' => __( 'Session Archives', DOMAIN ),
            'attributes' => __( 'Session Attributes', DOMAIN ),
            'insert_into_item' => __( 'Insert into session', DOMAIN ),
            'uploaded_to_this_item' => __( 'Uploaded to this session', DOMAIN ),
            'filter_items_list' => __( 'Filter sessions list', DOMAIN ),
            'items_list_navigation' => __( 'Sessions list navigation', DOMAIN ),
            'items_list' => __( 'Sessions list', DOMAIN ),
            'item_published' => __( 'Session published', DOMAIN ),
            'item_published_privately' => __( 'Session published privately', DOMAIN ),
            'item_reverted_to_draft' => __( 'Session reverted to draft', DOMAIN ),
            'item_trashed' => __( 'Session trashed', DOMAIN ),
            'item_scheduled' => __( 'Session scheduled', DOMAIN ),
            'item_updated' => __( 'Session updated', DOMAIN ),
            'item_link' => __( 'Session Link', DOMAIN ),
            'item_link_description' => __( 'A link to a session', DOMAIN ),
          ],
        'menu_icon' => 'dashicons-microphone',
        'menu_position' => 20,
        'public' => true,
        'supports' => [ 'title', 'editor', 'custom-fields' ],
        'show_in_rest' => true,
        'rest_base' => SESSION_BASE_IN_REST,
      ] );
  }

  function register_post_metas() {
    register_post_meta( SESSION_POST_TYPE, MODULE_OF_SESSION_META, [
        'description' => __( 'Module of the session', DOMAIN ),
        'type' => 'integer',
        'single' => true,
        'default' => DEFAULT_MODULE_OF_SESSION,
        'show_in_rest' => true,
      ] );
    register_post_meta( SESSION_POST_TYPE, SESSION_NUMBER_META, [
        'description' => __( 'Session number', DOMAIN ),
        'type' => 'integer',
        'single' => true,
        'default' => DEFAULT_SESSION_NUMBER,
        'show_in_rest' => true,
      ] );
    register_post_meta( SESSION_POST_TYPE, AUDIO_OF_SESSION_META, [
        'description' => __( 'Audio of the session', DOMAIN ),
        'type' => 'integer',
        'single' => true,
              'default' => DEFAULT_AUDIO_OF_SESSION,
        'show_in_rest' => true,
      ] );
  }

  add_action( 'init', 'snrg\register_post_types' );
  add_action( 'init', 'snrg\register_post_metas' );

  function add_sessions_in_rest( $response, $post, $request ) {
    $module = get_post( get_post_meta( $post->ID, MODULE_OF_SESSION_META, true ) );
    if ( $module ):
      $response->add_link( MODULE_LINK_IN_REST, esc_url( rest_url( WP_BASE_IN_REST . '/' . MODULE_BASE_IN_REST . '/' . $module->ID ) ), [ 'embeddable' => true ] );
    endif;
    return $response;
  }

  add_filter( 'rest_prepare_' . SESSION_POST_TYPE, 'snrg\add_sessions_in_rest', 10, 3 );

  function change_session_columns( $columns ) {
    $new_columns = [];
    foreach ( $columns as $column => $value ):
      if ( 'date' === $column ):
        $new_columns[ MODULE_OF_SESSION_COLUMN ] = __( 'Module', DOMAIN );
        $new_columns[ SESSION_NUMBER_COLUMN ] = __( 'Number', DOMAIN );
      endif;
      $new_columns[ $column ] = $value;
    endforeach;
    return $new_columns;
  }

  add_filter( 'manage_snrg_session_posts_columns', 'snrg\change_session_columns', 10, 1 );

  function change_session_column_values( $column, $post_id ) {
    switch ( $column ):
      case MODULE_OF_SESSION_COLUMN:
        $module = get_post( get_post_meta( $post_id, MODULE_OF_SESSION_META, true ) );
        if ( $module ):
          edit_post_link( $module->post_title, '', '', $module->ID );
        else:
          echo '';
        endif;
      break;
      case SESSION_NUMBER_COLUMN:
        echo get_post_meta( $post_id, SESSION_NUMBER_META, true );
      break;
    endswitch;
  }

  add_action( 'manage_snrg_session_posts_custom_column' , 'snrg\change_session_column_values', 10, 2 );



  //-----------
  // TAXONOMIES
  //-----------


  function register_taxonomies() {
    // TODO: Define a 'Module' taxonomy for sessions.
    // Terms are created/removed automatically when modules are created/removed.
    // Use capabilites to prevent users from creating/modifying/removing terms.

    register_taxonomy( SERIES_TAXONOMY, [ 'post', MODULE_POST_TYPE ], [
        'labels' => [
            'name' => __( 'Series', DOMAIN ),
            'singular_name' => __( 'Series', DOMAIN ),
            'search_items' => __( 'Search Series', DOMAIN ),
            'popular_items' => __( 'Popular Series', DOMAIN ),
            'all_items' => __( 'All Series', DOMAIN ),
            'edit_item' => __( 'Edit Series', DOMAIN ),
            'view_item' => __( 'View Series', DOMAIN ),
            'update_item' => __( 'Update Series', DOMAIN ),
            'add_new_item' => __( 'Add New Series', DOMAIN ),
            'new_item_name' => __( 'New Series Name', DOMAIN ),
            'separate_items_with_commas' => __( 'Separate series with commas', DOMAIN ),
            'add_or_remove_items' => __( 'Add or remove series', DOMAIN ),
            'choose_from_most_used' => __( 'Choose from the most used series', DOMAIN ),
            'not_found' => __( 'No series found', DOMAIN ),
            'no_terms' => __( 'No series', DOMAIN ),
            'item_link' => __( 'Series Link', DOMAIN ),
            'item_link_description' => __( 'A link to a series', DOMAIN ),
            'menu_name' => __( 'Series', DOMAIN ),
          ],
        'public' => true,
        'hierarchical' => false,
        'show_in_rest' => true,
        'rest_base' => SERIES_BASE_IN_REST,
      ] );
  }

  add_action( 'init', 'snrg\register_taxonomies' );


  //---------
  // REST API
  //---------


  function extend_rest_api() {
    register_rest_route( REST_ROUTE, HOME_IMAGE_IN_REST, [
        'methods' => \WP_REST_Server::READABLE,
        'callback' => function( $request ) {
          return rest_ensure_response( esc_url( get_template_directory_uri() ) . HOME_IMAGE_PATH );
        },
        'permission_callback' => '__return_true'
      ] );
    $settings = [ SETTING_FOR_HESYCHIA_URL ];
    foreach ( $settings as $setting ) {
      register_rest_route( REST_ROUTE, str_replace( '_', '-', $setting ), [
          'methods' => \WP_REST_Server::READABLE,
          'callback' => function( $request ) use ( $setting ) {
            $options = get_option( SETTINGS_DATA );
            return rest_ensure_response( isset( $options[ $setting ] ) ? $options[ $setting ] : ( $setting == SETTING_FOR_HESYCHIA_URL ? '' : '0' ) );
          },
          'permission_callback' => '__return_true'
        ] );
    }
  }

  add_action( 'rest_api_init', 'snrg\extend_rest_api' );



  //-----------
  // CSS AND JS
  //-----------


  function add_fonts() {
    wp_enqueue_style( 'google-font-nunito-sans', 'https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap' );
    wp_enqueue_style( 'google-font-roboto', 'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap' );
  }

  function enqueue_styles() {
    $synergia_css = '/assets/synergia.css';
    $vue_css = '/assets/app/index.css';
    wp_enqueue_style( 'snrg-synergia', get_template_directory_uri() . $synergia_css, [], date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $synergia_css ) ) );
    wp_enqueue_style( 'snrg-vue', get_template_directory_uri() . $vue_css, [ 'snrg-synergia' ], date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $vue_css ) ) );
  }

  function enqueue_scripts() {
    $vue_js = '/assets/app/index.js';
    wp_enqueue_script( 'snrg-vue', get_template_directory_uri() . $vue_js, [], date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $vue_js ) ), true );
  }

  add_action( 'wp_enqueue_scripts', 'snrg\add_fonts' );
  add_action( 'wp_enqueue_scripts', 'snrg\enqueue_styles' );
  add_action( 'wp_enqueue_scripts', 'snrg\enqueue_scripts' );

  function enqueue_admin_styles() {
    wp_enqueue_style( 'select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css' );
    $admin_css = '/assets/admin.css';
    wp_enqueue_style( 'snrg-admin', get_template_directory_uri() . $admin_css, [ 'select2' ], date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $admin_css ) ) );
  }

  function enqueue_admin_scripts() {
    wp_enqueue_script( 'select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', [ 'jquery' ] );
    $admin_js = '/assets/admin.js';
    wp_enqueue_script( 'snrg-admin', get_template_directory_uri() . $admin_js, [ 'select2' ], date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $admin_js ) ) );
  }

  add_action( 'admin_enqueue_scripts', 'snrg\enqueue_admin_styles' );
  add_action( 'admin_enqueue_scripts', 'snrg\enqueue_admin_scripts' );


  function add_vue_js_html_attributes( $tag, $handle, $src ) {
    $prefix = 'snrg-vue';
    if ( substr($handle, 0, strlen( $prefix ) ) === $prefix ) {
      return preg_replace( '/(type\s*=\s*["\']).*?(["\'])/', '$1module$2', $tag, 1 );
    }
    return $tag;
  }

  add_filter( 'script_loader_tag', 'snrg\add_vue_js_html_attributes' , 10, 3 );
?>