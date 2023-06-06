<?php
    require_once get_template_directory() . '/inc/constants.php';

    function snrg_query_vars( $query_vars ) {
        $query_vars[] = 'route';
        return $query_vars;
    }

    add_filter( 'query_vars', 'snrg_query_vars' );

    function snrg_template_include( $template ){
        if ( get_query_var( 'route' ) != '404' ) :
            return $template;
        endif;
        global $wp_query;
        $wp_query->set_404();
        status_header( 404 );
        $template = locate_template( '404.php' );
        return $template;
    }

    add_filter( 'template_include', 'snrg_template_include' );

    function snrg_add_rewrite_rules() {
        add_rewrite_rule( '^(helikia/[^/]+/\d+)/?$', 'index.php?route=$matches[1]', 'top' );
        add_rewrite_rule( '^(helikia/[^/]+)/?$', 'index.php?route=$matches[1]', 'top' );
        add_rewrite_rule( '^([^/]+)/?$', 'index.php?route=$matches[1]', 'top' );
        add_rewrite_rule( '^.+/?$', 'index.php?route=404', 'top' );
    }

    add_action( 'init', 'snrg_add_rewrite_rules' );

    function snrg_theme_support() {
        add_theme_support( 'post-thumbnails' );
    }

    add_action( 'after_setup_theme', 'snrg_theme_support' );

    function snrg_add_fonts() {
        wp_enqueue_style( 'google-font-nunito-sans', 'https://fonts.googleapis.com/css2?family=Nunito+Sans:opsz@6..12&display=swap' );
    }

    function snrg_enqueue_styles() {
        $synergia_css = '/assets/synergia.css';
        $vue_css = '/assets/app/index.css';
        wp_enqueue_style( 'snrg-synergia', get_template_directory_uri() . $synergia_css, array(), date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $synergia_css ) ) );
        wp_enqueue_style( 'snrg-vue', get_template_directory_uri() . $vue_css, array( 'snrg-synergia' ), date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $vue_css ) ) );
    }

    function snrg_enqueue_scripts() {
        $vue_js = '/assets/app/index.js';
        wp_enqueue_script( 'snrg-vue', get_template_directory_uri() . $vue_js, array(), date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $vue_js ) ), true );
    }

    add_action( 'wp_enqueue_scripts', 'snrg_add_fonts' );
    add_action( 'wp_enqueue_scripts', 'snrg_enqueue_styles' );
    add_action( 'wp_enqueue_scripts', 'snrg_enqueue_scripts' );

    function snrg_enqueue_admin_styles() {
        wp_enqueue_style( 'select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css' );
        $admin_css = '/assets/admin.css';
        wp_enqueue_style( 'snrg-admin', get_template_directory_uri() . $admin_css, array( 'select2' ), date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $admin_css ) ) );
    }

    function snrg_enqueue_admin_scripts() {
        wp_enqueue_script( 'select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array( 'jquery' ) );
        $admin_js = '/assets/admin.js';
        wp_enqueue_script( 'snrg-admin', get_template_directory_uri() . $admin_js, array( 'select2' ), date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $admin_js ) ) );
    }

    add_action( 'admin_enqueue_scripts', 'snrg_enqueue_admin_styles' );
    add_action( 'admin_enqueue_scripts', 'snrg_enqueue_admin_scripts' );

    function snrg_add_vue_js_html_attributes( $tag, $handle, $src ) {
        $prefix = 'snrg-vue';
        if ( substr($handle, 0, strlen( $prefix ) ) === $prefix ) {
            return preg_replace( '/(type\s*=\s*["\']).*?(["\'])/', '$1module$2', $tag, 1 );
        }
        return $tag;
    }

    add_filter( 'script_loader_tag', 'snrg_add_vue_js_html_attributes' , 10, 3 );

    function snrg_register_post_types() {
        register_post_type(
            SNRG_MUST_SEE_POST_TYPE,
            array(
                'labels' => array(
                    'name' => __('Must-sees', SNRG_DOMAIN ),
                    'singular_name' => __( 'Must-see', SNRG_DOMAIN ),
                    'add_new_item' => __( 'Add a New Must-see', SNRG_DOMAIN ),
                    'edit_item' => __( 'Edit Must-see', SNRG_DOMAIN ),
                    'new_item' => __( 'New Must-see', SNRG_DOMAIN ),
                    'view_item' => __( 'View Must-see', SNRG_DOMAIN ),
                    'view_items' => __( 'View Must-sees', SNRG_DOMAIN ),
                    'search_items' => __( 'Search Must-sees', SNRG_DOMAIN ),
                    'not_found' => __( 'No must-sees found', SNRG_DOMAIN ),
                    'not_found_in_trash' => __( 'No must-sees found in trash', SNRG_DOMAIN ),
                    'all_items' => __( 'All Must-sees', SNRG_DOMAIN ),
                    'archives' => __( 'Must-see Archives', SNRG_DOMAIN ),
                    'attributes' => __( 'Must-see Attributes', SNRG_DOMAIN ),
                    'insert_into_item' => __( 'Insert into must-see', SNRG_DOMAIN ),
                    'uploaded_to_this_item' => __( 'Uploaded to this must-see', SNRG_DOMAIN ),
                    'filter_items_list' => __( 'Filter must-sees list', SNRG_DOMAIN ),
                    'items_list_navigation' => __( 'Must-sees list navigation', SNRG_DOMAIN ),
                    'items_list' => __( 'Must-sees list', SNRG_DOMAIN ),
                    'item_published' => __( 'Must-see published', SNRG_DOMAIN ),
                    'item_published_privately' => __( 'Must-see published privately', SNRG_DOMAIN ),
                    'item_reverted_to_draft' => __( 'Must-see reverted to draft', SNRG_DOMAIN ),
                    'item_scheduled' => __( 'Must-see scheduled', SNRG_DOMAIN ),
                    'item_updated' => __( 'Must-see updated', SNRG_DOMAIN ),
                    'item_link' => __( 'Must-see Link', SNRG_DOMAIN ),
                    'item_link_description' => __( 'A link to a must-see', SNRG_DOMAIN ),
                ),
                'menu_icon' => 'dashicons-pressthis',
                'menu_position' => 20,
                'public' => true,
                'supports' => array( 'title', 'editor' ),
                'show_in_rest' => true,
                'rest_base' => SNRG_MUST_SEE_BASE_IN_REST,
            )
        );
        register_post_type(
            SNRG_MODULE_POST_TYPE,
            array(
                'labels' => array(
                    'name' => __( 'Modules', SNRG_DOMAIN ),
                    'singular_name' => __( 'Module', SNRG_DOMAIN ),
                    'add_new_item' => __( 'Add a New Module', SNRG_DOMAIN ),
                    'edit_item' => __( 'Edit Module', SNRG_DOMAIN ),
                    'new_item' => __( 'New Module', SNRG_DOMAIN ),
                    'view_item' => __( 'View Module', SNRG_DOMAIN ),
                    'view_items' => __( 'View Modules', SNRG_DOMAIN ),
                    'search_items' => __( 'Search Modules', SNRG_DOMAIN ),
                    'not_found' => __( 'No modules found', SNRG_DOMAIN ),
                    'not_found_in_trash' => __( 'No modules found in trash', SNRG_DOMAIN ),
                    'all_items' => __( 'All Modules', SNRG_DOMAIN ),
                    'archives' => __( 'Module Archives', SNRG_DOMAIN ),
                    'attributes' => __( 'Module Attributes', SNRG_DOMAIN ),
                    'insert_into_item' => __( 'Insert into module', SNRG_DOMAIN ),
                    'uploaded_to_this_item' => __( 'Uploaded to this module', SNRG_DOMAIN ),
                    'filter_items_list' => __( 'Filter modules list', SNRG_DOMAIN ),
                    'items_list_navigation' => __( 'Modules list navigation', SNRG_DOMAIN ),
                    'items_list' => __( 'Modules list', SNRG_DOMAIN ),
                    'item_published' => __( 'Module published', SNRG_DOMAIN ),
                    'item_published_privately' => __( 'Module published privately', SNRG_DOMAIN ),
                    'item_reverted_to_draft' => __( 'Module reverted to draft', SNRG_DOMAIN ),
                    'item_scheduled' => __( 'Module scheduled', SNRG_DOMAIN ),
                    'item_updated' => __( 'Module updated', SNRG_DOMAIN ),
                    'item_link' => __( 'Module Link', SNRG_DOMAIN ),
                    'item_link_description' => __( 'A link to a module', SNRG_DOMAIN ),
                ),
                'menu_icon' => 'data:image/svg+xml;base64,' . base64_encode( file_get_contents( get_template_directory() . '/assets/icons/module.svg' ) ),
                'menu_position' => 20,
                'public' => true,
                'supports' => array( 'title', 'thumbnail', 'editor', 'excerpt' ),
                'show_in_rest' => true,
                'rest_base' => SNRG_MODULE_BASE_IN_REST,
            )
        );
        register_post_type(
            SNRG_SESSION_POST_TYPE,
            array(
                'labels' => array(
                    'name' => __('Sessions', SNRG_DOMAIN ),
                    'singular_name' => __( 'Session', SNRG_DOMAIN ),
                    'add_new_item' => __( 'Add a New Session', SNRG_DOMAIN ),
                    'edit_item' => __( 'Edit Session', SNRG_DOMAIN ),
                    'new_item' => __( 'New Session', SNRG_DOMAIN ),
                    'view_item' => __( 'View Session', SNRG_DOMAIN ),
                    'view_items' => __( 'View Sessions', SNRG_DOMAIN ),
                    'search_items' => __( 'Search Sessions', SNRG_DOMAIN ),
                    'not_found' => __( 'No sessions found', SNRG_DOMAIN ),
                    'not_found_in_trash' => __( 'No sessions found in trash', SNRG_DOMAIN ),
                    'all_items' => __( 'All Sessions', SNRG_DOMAIN ),
                    'archives' => __( 'Session Archives', SNRG_DOMAIN ),
                    'attributes' => __( 'Session Attributes', SNRG_DOMAIN ),
                    'insert_into_item' => __( 'Insert into session', SNRG_DOMAIN ),
                    'uploaded_to_this_item' => __( 'Uploaded to this session', SNRG_DOMAIN ),
                    'filter_items_list' => __( 'Filter sessions list', SNRG_DOMAIN ),
                    'items_list_navigation' => __( 'Sessions list navigation', SNRG_DOMAIN ),
                    'items_list' => __( 'Sessions list', SNRG_DOMAIN ),
                    'item_published' => __( 'Session published', SNRG_DOMAIN ),
                    'item_published_privately' => __( 'Session published privately', SNRG_DOMAIN ),
                    'item_reverted_to_draft' => __( 'Session reverted to draft', SNRG_DOMAIN ),
                    'item_scheduled' => __( 'Session scheduled', SNRG_DOMAIN ),
                    'item_updated' => __( 'Session updated', SNRG_DOMAIN ),
                    'item_link' => __( 'Session Link', SNRG_DOMAIN ),
                    'item_link_description' => __( 'A link to a session', SNRG_DOMAIN ),
                ),
                'menu_icon' => 'dashicons-microphone',
                'menu_position' => 20,
                'public' => true,
                'supports' => array( 'title', 'editor', 'revisions', 'excerpt', 'custom-fields' ),
                'show_in_rest' => true,
                'rest_base' => SNRG_SESSION_BASE_IN_REST,
            )
        );
    }

    function snrg_register_meta() {
        register_post_meta( SNRG_SESSION_POST_TYPE, SNRG_MODULE_OF_SESSION_META, array(
                'description' => __( 'Module of the session', SNRG_DOMAIN ),
                'type' => 'integer',
                'single' => true,
                'default' => SNRG_DEFAULT_MODULE_OF_SESSION,
                'show_in_rest' => true,
            ) );
        register_post_meta( SNRG_SESSION_POST_TYPE, SNRG_SESSION_NUMBER_META, array(
                'description' => __( 'Session number', SNRG_DOMAIN ),
                'type' => 'integer',
                'single' => true,
                'default' => SNRG_DEFAULT_SESSION_NUMBER,
                'show_in_rest' => true,
            ) );
        register_post_meta( SNRG_SESSION_POST_TYPE, SNRG_AUDIO_OF_SESSION_META, array(
                'description' => __( 'Audio of the session', SNRG_DOMAIN ),
                'type' => 'integer',
                'single' => true,
                            'default' => SNRG_DEFAULT_AUDIO_OF_SESSION,
                'show_in_rest' => true,
            ) );
    }

    add_action( 'init', 'snrg_register_post_types' );
    add_action( 'init', 'snrg_register_meta' );

    function snrg_sessions_in_rest( $response, $post, $request ) {
        $module = get_post( get_post_meta( $post->ID, SNRG_MODULE_OF_SESSION_META, true ) );
        if ( $module ):
            $response->add_link( SNRG_MODULE_LINK_IN_REST, esc_url( rest_url( SNRG_WP_BASE_IN_REST . '/' . SNRG_MODULE_BASE_IN_REST . '/' . $module->ID ) ), array( 'embeddable' => true ) );
        endif;
        return $response;
    }

    add_filter( 'rest_prepare_' . SNRG_SESSION_POST_TYPE, 'snrg_sessions_in_rest', 10, 3 );

    function snrg_session_columns( $columns ) {
        $new_columns = array();
        foreach ( $columns as $column => $value ):
            if ( 'date' === $column ):
                $new_columns[ SNRG_MODULE_OF_SESSION_COLUMN ] = __( 'Module', SNRG_DOMAIN );
                $new_columns[ SNRG_SESSION_NUMBER_COLUMN ] = __( 'Number', SNRG_DOMAIN );
            endif;
            $new_columns[ $column ] = $value;
        endforeach;
        return $new_columns;
    }

    add_filter( 'manage_snrg_session_posts_columns', 'snrg_session_columns', 10, 1 );

    function snrg_session_column_values( $column, $post_id ) {
        switch ( $column ):
            case SNRG_MODULE_OF_SESSION_COLUMN:
                $module = get_post( get_post_meta( $post_id, SNRG_MODULE_OF_SESSION_META, true ) );
                if ( $module ):
                    edit_post_link( $module->post_title, '', '', $module->ID );
                else:
                    echo '';
                endif;
            break;
            case SNRG_SESSION_NUMBER_COLUMN:
                echo get_post_meta( $post_id, SNRG_SESSION_NUMBER_META, true );
            break;
        endswitch;
    }

    add_action( 'manage_snrg_session_posts_custom_column' , 'snrg_session_column_values', 10, 2 );

    function snrg_extend_rest_api() {
        register_rest_route( SNRG_REST_ROUTE, SNRG_HOME_IMAGE_ROUTE, array(
                'methods' => WP_REST_Server::READABLE,
                'callback' => function( $request ) {
                    return rest_ensure_response( esc_url( get_template_directory_uri() ) . SNRG_HOME_IMAGE_PATH );
                },
                'permission_callback' => '__return_true'
            ) );
    }

    add_action( 'rest_api_init', 'snrg_extend_rest_api' );
?>