<?php
    namespace snrg;

    define( 'DOMAIN', 'synergia' );
    define( 'CAPABILITY_REQUIRED_FOR_SETTINGS', 'manage_options' );
    define( 'SETTINGS', 'snrg-settings' );
    define( 'SETTINGS_DATA', 'snrg_settings' );
    define( 'SETTINGS_SECTION_FOR_URLS', 'snrg-url-settings' );
    define( 'SETTINGS_TYPE_FOR_URLS', 'url' );
    define( 'SETTING_FOR_HESYCHIA_URL', 'hesychia_url' );
    define( 'SETTINGS_FIELDS', [ [ 'id' => SETTING_FOR_HESYCHIA_URL, 'label' => 'Cap Hesychia URL', 'type' => SETTINGS_TYPE_FOR_URLS ] ] );
    define( 'SLUG_FOR_ACCOUNT_PAGE', 'compte' );
    define( 'SLUG_FOR_BIOGRAPHY_PAGE', 'bio' );
    define( 'SLUG_FOR_BLOG_PAGE', 'blog' );
    define( 'SLUG_FOR_CONTACT_PAGE', 'contact' );
    define( 'SLUG_FOR_HELIKIA_PAGE', 'helikia' );
    define( 'SLUG_FOR_INTRODUCTION_PAGE', 'intro' );
    define( 'WP_BASE_IN_REST', 'wp/v2' );
    define( 'MODULE_POST_TYPE', 'snrg_module' );
    define( 'MODULE_BASE_IN_REST', 'snrg-modules' );
    define( 'MODULE_LINK_IN_REST', 'snrg-module' );
    define( 'PROGRAM_POST_TYPE', 'snrg_program' );
    define( 'PROGRAM_BASE_IN_REST', 'snrg-programs' );
    define( 'SESSION_POST_TYPE', 'snrg_session' );
    define( 'SESSION_BASE_IN_REST', 'snrg-sessions' );
    define( 'MODULE_OF_SESSION_META', 'snrg_module_of_session' );
    define( 'DEFAULT_MODULE_OF_SESSION', 0 );
    define( 'SESSION_NUMBER_META', 'snrg_session_number' );
    define( 'DEFAULT_SESSION_NUMBER', 0 );
    define( 'AUDIO_OF_SESSION_META', 'snrg_audio_of_session' );
    define( 'DEFAULT_AUDIO_OF_SESSION', 0 );
    define( 'MODULE_OF_SESSION_COLUMN', 'module' );
    define( 'SESSION_NUMBER_COLUMN', 'number' );
    define( 'SERIES_TAXONOMY', 'snrg_series' );
    define( 'SERIES_BASE_IN_REST', 'snrg-series' );
    define( 'REST_ROUTE', 'synergia/v1' );
    define( 'HOME_IMAGE_IN_REST', '/home-image' );
    define( 'HOME_IMAGE_PATH', '/assets/home.jpg' );
?>