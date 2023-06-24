<?php
    require_once get_template_directory() . '/inc/constants.php';

    function snrg_theme_support() {
        add_theme_support( 'post-thumbnails' );
    }

    add_action( 'after_setup_theme', 'snrg_theme_support' );

    function snrg_add_fonts() {
        wp_enqueue_style( 'google-font-roboto-condensed', 'https://fonts.googleapis.com/css2?family=Roboto+Condensed:ital,wght@0,400;0,700;1,400;1,700&display=swap' );
    }

    add_action( 'wp_enqueue_scripts', 'snrg_add_fonts' );

    function snrg_enqueue_styles() {
        $vue_css = '/assets/app/index.css';
        wp_enqueue_style( 'snrg-vue', get_template_directory_uri() . $vue_css, array(), date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $vue_css ) ) );
    }

    add_action( 'wp_enqueue_scripts', 'snrg_enqueue_styles' );

    function snrg_enqueue_scripts() {
        $vue_js = '/assets/app/index.js';
        wp_enqueue_script( 'snrg-vue', get_template_directory_uri() . $vue_js, array(), date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $vue_js ) ) );
    }

    function snrg_add_vue_js_html_attributes( $tag, $handle, $src ) {
        $prefix = 'snrg-vue';
        if ( substr($handle, 0, strlen( $prefix ) ) === $prefix ) {
            return preg_replace( '/(type\s*=\s*["\']).*?(["\'])/', '$1module$2', $tag, 1 );
        }
        return $tag;
    }

    add_filter( 'script_loader_tag', 'snrg_add_vue_js_html_attributes' , 10, 3 );
    add_action( 'wp_enqueue_scripts', 'snrg_enqueue_scripts' );


    function snrg_enqueue_admin_styles() {
        wp_enqueue_style( 'select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css' );
        $admin_css = '/assets/snrg-admin.css';
        wp_enqueue_style( 'snrg-admin', get_template_directory_uri() . $admin_css, array( 'select2' ), date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $admin_css ) ) );
    }

    add_action( 'admin_enqueue_scripts', 'snrg_enqueue_admin_styles' );

    function snrg_enqueue_admin_scripts() {
        wp_enqueue_script( 'select2', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array( 'jquery' ) );
        $admin_js = '/assets/snrg-admin.js';
        wp_enqueue_script( 'snrg-admin', get_template_directory_uri() . $admin_js, array( 'select2' ), date( 'Y.m.d.H.i.s', filemtime( get_template_directory() . $admin_js ) ) );
    }

    add_action( 'admin_enqueue_scripts', 'snrg_enqueue_admin_scripts' );

    function snrg_register_taxonomies() {
        register_taxonomy( SNRG_TAGS, 'post', array(
                'labels' => array(
                    'name' => __( SNRG_TAGS_LABEL, SNRG_DOMAIN ),
                    'add_new_item' => __( SNRG_TAGS_SELECTION, SNRG_DOMAIN ),
                ),
                'hierarchical' => false,
                'show_in_rest' => true,
                'rest_base' => SNRG_REST_TAGS,
                'show_ui' => true,
                'capabilities' => array(
                    'manage_terms' => SNRG_TAGS_CAPABILITY,
                    'edit_terms'   => SNRG_TAGS_CAPABILITY,
                    'delete_terms' => SNRG_TAGS_CAPABILITY,
                    'assign_terms' => 'edit_posts',
                ),
            ) );
        $terms = array(
                array( 'name' => SNRG_PADDY_TAG, 'slug' => SNRG_PADDY_SLUG, 'description' => '' ),
                array( 'name' => SNRG_HELIKIA_TAG, 'slug' => SNRG_HELIKIA_SLUG, 'description' => '' ),
                array( 'name' => SNRG_SYNERGIA_TAG, 'slug' => SNRG_SYNERGIA_SLUG, 'description' => '' ),
                array( 'name' => SNRG_HESYCHIA_TAG, 'slug' => SNRG_HESYCHIA_SLUG, 'description' => '' ),
            );
        foreach ( $terms as $term ):
            wp_insert_term( $term[ 'name' ], SNRG_TAGS, array(
                    'description' => $term[ 'description' ],
                    'slug' => $term[ 'slug' ],
                ) );
        endforeach;
    }

    add_action( 'init', 'snrg_register_taxonomies' );

    function snrg_on_post_tags_updated( $term_id, $tt_id, $update, $args ) {
        $valid_names = array( SNRG_PADDY_TAG, SNRG_HELIKIA_TAG, SNRG_SYNERGIA_TAG, SNRG_HESYCHIA_TAG );
        foreach ( get_terms( array( 'taxonomy' => SNRG_TAGS, 'hide_empty' => false, 'fields' => 'id=>name' ) ) as $id => $name ):
            if ( $id === $term_id && ! in_array( $name, $valid_names, true ) ) {
                wp_delete_term( $id, SNRG_TAGS );
            }
        endforeach;
    }

    add_action( 'saved_' . SNRG_TAGS, 'snrg_on_post_tags_updated', 10, 4 );

    function snrg_register_post_types() {
        register_post_type(
            'snrg_module',
            array(
                'labels' => array(
                    'name' => __( 'Modules', 'synergia' ),
                    'singular_name' => __( 'Module', 'synergia' ),
                    'add_new_item' => __( 'Add a New Module', 'synergia' ),
                    'edit_item' => __( 'Edit Module', 'synergia' ),
                    'new_item' => __( 'New Module', 'synergia' ),
                    'view_item' => __( 'View Module', 'synergia' ),
                    'view_items' => __( 'View Modules', 'synergia' ),
                    'search_items' => __( 'Search Modules', 'synergia' ),
                    'not_found' => __( 'No modules found', 'synergia' ),
                    'not_found_in_trash' => __( 'No modules found in trash', 'synergia' ),
                    'all_items' => __( 'All Modules', 'synergia' ),
                    'archives' => __( 'Module Archives', 'synergia' ),
                    'attributes' => __( 'Module Attributes', 'synergia' ),
                    'insert_into_item' => __( 'Insert into module', 'synergia' ),
                    'uploaded_to_this_item' => __( 'Uploaded to this module', 'synergia' ),
                    'filter_items_list' => __( 'Filter modules list', 'synergia' ),
                    'items_list_navigation' => __( 'Modules list navigation', 'synergia' ),
                    'items_list' => __( 'Modules list', 'synergia' ),
                    'item_published' => __( 'Module published', 'synergia' ),
                    'item_published_privately' => __( 'Module published privately', 'synergia' ),
                    'item_reverted_to_draft' => __( 'Module reverted to draft', 'synergia' ),
                    'item_scheduled' => __( 'Module scheduled', 'synergia' ),
                    'item_updated' => __( 'Module updated', 'synergia' ),
                    'item_link' => __( 'Module Link', 'synergia' ),
                    'item_link_description' => __( 'A link to a module', 'synergia' ),
                ),
                'menu_icon' => 'dashicons-microphone',
                'menu_position' => 5,
                'public' => true,
                'supports' => array( 'title', 'thumbnail', 'excerpt' ),
                'show_in_rest' => true,
                'rest_base' => SNRG_REST_MODULES,
            )
        );
        register_post_type(
            'snrg_session',
            array(
                'labels' => array(
                    'name' => __('Sessions', 'synergia' ),
                    'singular_name' => __( 'Session', 'synergia' ),
                    'add_new_item' => __( 'Add a New Session', 'synergia' ),
                    'edit_item' => __( 'Edit Session', 'synergia' ),
                    'new_item' => __( 'New Session', 'synergia' ),
                    'view_item' => __( 'View Session', 'synergia' ),
                    'view_items' => __( 'View Sessions', 'synergia' ),
                    'search_items' => __( 'Search Sessions', 'synergia' ),
                    'not_found' => __( 'No sessions found', 'synergia' ),
                    'not_found_in_trash' => __( 'No sessions found in trash', 'synergia' ),
                    'all_items' => __( 'All Sessions', 'synergia' ),
                    'archives' => __( 'Session Archives', 'synergia' ),
                    'attributes' => __( 'Session Attributes', 'synergia' ),
                    'insert_into_item' => __( 'Insert into session', 'synergia' ),
                    'uploaded_to_this_item' => __( 'Uploaded to this session', 'synergia' ),
                    'filter_items_list' => __( 'Filter sessions list', 'synergia' ),
                    'items_list_navigation' => __( 'Sessions list navigation', 'synergia' ),
                    'items_list' => __( 'Sessions list', 'synergia' ),
                    'item_published' => __( 'Session published', 'synergia' ),
                    'item_published_privately' => __( 'Session published privately', 'synergia' ),
                    'item_reverted_to_draft' => __( 'Session reverted to draft', 'synergia' ),
                    'item_scheduled' => __( 'Session scheduled', 'synergia' ),
                    'item_updated' => __( 'Session updated', 'synergia' ),
                    'item_link' => __( 'Session Link', 'synergia' ),
                    'item_link_description' => __( 'A link to a session', 'synergia' ),
                ),
                'public' => true,
                'show_in_menu' => 'edit.php?post_type=snrg_module',
                'supports' => array( 'title', 'editor', 'revisions', 'custom-fields' ),
                'show_in_rest' => true,
                'rest_base' => SNRG_REST_SESSIONS,
            )
        );
    }

    add_action( 'init', 'snrg_register_post_types' );

    function snrg_add_meta_boxes() {
        add_meta_box( 'snrg-session-meta-box', __( 'Session', 'synergia' ), 'snrg_html_for_session_meta_box', 'snrg_session', 'side' );
    }

    function snrg_html_for_session_meta_box( $post ) {
        $current_module = get_post_meta( $post->ID, 'snrg_module_of_session', true );
        $ordinal = get_post_meta( $post->ID, 'snrg_ordinal_of_session', true );
        $audio = get_post_meta( $post->ID, 'snrg_audio_of_session', true );
        $modules = get_posts( array( 'post_type' => 'snrg_module', 'posts_per_page' => -1 ) );
        ?>
        <div id="snrg-session-meta-box-wrapper">
            <label for="snrg-select-module-of-session"><?php _e( 'Module', 'synergia' ); ?></label>
            <select id="snrg-select-module-of-session" name="snrgModuleOfSession">
                <option value="0"><?php esc_html_e( 'Please select a module', 'synergia' ); ?></option>
                <?php foreach ( $modules as $module ): ?>
                    <option value="<?php echo esc_attr( $module->ID ); ?>" <?php selected( $current_module, esc_attr( $module->ID ) ); ?>><?php echo esc_html( $module->post_title ); ?></option>
                <?php endforeach; ?>
            </select>
            <label for="snrg-input-ordinal-of-session"><?php _e( 'Ordinal', 'synergia' ); ?></label>
            <input type="number" id="snrg-input-ordinal-of-session" name="snrgOrdinalOfSession" value="<?php echo esc_attr( $ordinal ); ?>"/>
            <label for="snrg-input-audio-of-session"><?php _e( 'Audio URL', 'synergia' ); ?></label>
            <input type="url" id="snrg-input-audio-of-session" name="snrgAudioOfSession" value="<?php echo esc_attr( $audio ); ?>"/>
        </div>
        <?php
    }

    add_action( 'add_meta_boxes', 'snrg_add_meta_boxes' );

    function snrg_save_session_data( $post_id ) {
        if ( array_key_exists( 'snrgModuleOfSession', $_POST ) ):
            update_post_meta( $post_id, 'snrg_module_of_session', $_POST['snrgModuleOfSession'] );
        endif;
        if ( array_key_exists( 'snrgOrdinalOfSession', $_POST ) ):
            update_post_meta( $post_id, 'snrg_ordinal_of_session', $_POST['snrgOrdinalOfSession'] );
        endif;
        if ( array_key_exists( 'snrgAudioOfSession', $_POST ) ):
            update_post_meta( $post_id, 'snrg_audio_of_session', $_POST['snrgAudioOfSession'] );
        endif;
    }
    add_action( 'save_post', 'snrg_save_session_data' );

    function snrg_session_columns( $columns ) {
        $new_columns = array();
        foreach ( $columns as $column => $value ):
            if ( 'date' === $column ):
                $new_columns['module'] = __( 'Module', 'synergia' );
                $new_columns['ordinal'] = __( 'Ordinal', 'synergia' );
            endif;
            $new_columns[$column] = $value;
        endforeach;
        return $new_columns;
    }

    add_filter( 'manage_snrg_session_posts_columns', 'snrg_session_columns' );

    function snrg_session_column_values( $column, $post_id ) {
        switch ( $column ):
            case 'module':
                $module = get_post( get_post_meta( $post_id, 'snrg_module_of_session', true ) );
                if ( $module ):
                    edit_post_link( $module->post_title, '', '', $module->ID );
                else:
                    echo '';
                endif;
            break;
            case 'ordinal':
                echo get_post_meta( $post_id, 'snrg_ordinal_of_session', true );
            break;
        endswitch;
    }

    add_action( 'manage_snrg_session_posts_custom_column' , 'snrg_session_column_values', 10, 2 );

    /*
    function snrg_register_session_meta_fields(){
        register_post_meta( 'snrg_session', 'snrg_module_of_session', array(
            'type' => 'string',
            'description' => 'Module of session',
            'single' => true,
            'show_in_rest' => true,
        ));
    }

    add_action( 'rest_api_init', 'snrg_register_session_meta_fields');
    */
?>