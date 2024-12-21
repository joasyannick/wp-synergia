<?php
  namespace snrg;

  define( 'DOMAIN', 'wp-synergia' );
  define( 'CAPABILITY_REQUIRED_FOR_SETTINGS', 'manage_options' );
  define( 'SETTINGS_ID', 'snrg-settings' );
  define( 'SETTINGS_DATA', 'snrg_settings' );
  define( 'SETTINGS_SECTION_ID', 'snrg-settings-section' );
  define( 'SETTING_KEY', 'key' );
  define( 'SETTING_ID', 'id' );
  define( 'SETTING_LABEL', 'label' );
  define( 'SETTING_REST_ROUTE', 'rest_route' );
  define( 'SETTING_DEFAULT', 'default' );
  define( 'SETTING_TYPE', 'type' );
  define( 'SETTINGS_TYPE_FOR_URLS', 'url' );
  define( 'SETTINGS_TYPE_FOR_TEXT_ARRAYS', 'text_array' );
  define( 'SETTING_KEY_FOR_HESYCHIA_URL', 'hesychia_url' );
  define( 'SETTING_ID_FOR_HESYCHIA_URL', 'snrg-hesychia-url' );
  define( 'SETTING_REST_ROUTE_FOR_HESYCHIA_URL', '/settings/hesychia-url' );
  define( 'SETTING_KEY_FOR_SLOGANS', 'slogans' );
  define( 'SETTING_ID_FOR_ONE_SLOGAN', 'snrg-slogan' );
  define( 'SETTING_REST_ROUTE_FOR_SLOGANS', '/settings/slogans' );
  define( 'SETTINGS', [
      [ SETTING_KEY => SETTING_KEY_FOR_HESYCHIA_URL, SETTING_ID => SETTING_ID_FOR_HESYCHIA_URL, SETTING_TYPE => SETTINGS_TYPE_FOR_URLS, SETTING_DEFAULT => '', SETTING_LABEL => 'Cap Hesychia URL', SETTING_REST_ROUTE => SETTING_REST_ROUTE_FOR_HESYCHIA_URL ],
      [ SETTING_KEY => SETTING_KEY_FOR_SLOGANS, SETTING_ID => SETTING_ID_FOR_ONE_SLOGAN, SETTING_TYPE => SETTINGS_TYPE_FOR_TEXT_ARRAYS, SETTING_DEFAULT => [], SETTING_LABEL => 'Slogans', SETTING_REST_ROUTE => SETTING_REST_ROUTE_FOR_SLOGANS ]
    ] );
  define( 'ACCOUNT_PATH', 'compte' );
  define( 'BIOGRAPHY_PATH', 'bio' );
  define( 'BLOG_PATH', 'blog' );
  define( 'CONTACT_PATH', 'contact' );
  define( 'HELIKIA_PATH', 'helikia' );
  define( 'ERROR_PATH', '404' );
  define( 'INTRODUCTION_PATH', 'intro' );
  define( 'WP_IN_REST', 'wp/v2' );
  define( 'MODULE_POST_TYPE', 'snrg_module' );
  define( 'MODULE_IN_REST', 'snrg-modules' );
  define( 'MODULE_LINK_IN_REST', 'snrg-module' );
  define( 'PROGRAM_POST_TYPE', 'snrg_program' );
  define( 'PROGRAM_IN_REST', 'snrg-programs' );
  define( 'SESSION_POST_TYPE', 'snrg_session' );
  define( 'SESSION_IN_REST', 'snrg-sessions' );
  define( 'MODULE_OF_SESSION_META', 'snrg_module_of_session' );
  define( 'DEFAULT_MODULE_OF_SESSION', 0 );
  define( 'SESSION_NUMBER_META', 'snrg_session_number' );
  define( 'DEFAULT_SESSION_NUMBER', 0 );
  define( 'AUDIO_OF_SESSION_META', 'snrg_audio_of_session' );
  define( 'DEFAULT_AUDIO_OF_SESSION', 0 );
  define( 'MODULE_OF_SESSION_COLUMN', 'module' );
  define( 'SESSION_NUMBER_COLUMN', 'number' );
  define( 'SERIES_TAXONOMY', 'snrg_series' );
  define( 'SERIES_IN_REST', 'snrg-series' );
  define( 'REST_ROUTE', 'synergia/v1' );
  define( 'HOME_IMAGE_IN_REST', '/home-image' );
  define( 'HOME_IMAGE_PATH', '/assets/images/home.jpg' );
  define( 'DEFAULT_IMAGE_IN_REST', '/default-image' );
  define( 'DEFAULT_IMAGE_PATH', '/assets/images/default.jpg' );
?>