<?php get_header(); ?>
  <?php $snrg_data = [ 'route' => '/404' ]; ?>
  <script id="snrg-data" type="application/json"><?= json_encode( $snrg_data, JSON_UNESCAPED_SLASHES ) ?></script>
  <div id="snrg-vue"></div>
<?php get_footer(); ?>