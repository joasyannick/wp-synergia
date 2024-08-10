<?php get_header(); ?>
  <?php
    global $wp_query;
    $snrg_data = [ 'route' => '/' . $wp_query->query_vars[ 'route' ] ];
  ?>
  <script id="snrg-data" type="application/json"><?= json_encode( $snrg_data, JSON_UNESCAPED_SLASHES ) ?></script>
  <div id="snrg-vue"></div>
<?php get_footer(); ?>