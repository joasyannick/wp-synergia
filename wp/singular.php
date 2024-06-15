<?php get_header(); ?>
<div id="snrg-app" data-snrg-route="<?php global $wp_query; echo '/' . $wp_query->query_vars[ 'route' ]; ?>">
</div>
<?php get_footer(); ?>