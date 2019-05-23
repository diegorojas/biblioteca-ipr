<?php get_header(); ?>

<?php

$url =  home_url().'/articles/?autor='.get_post_field( 'ID', get_post() );
echo '<meta http-equiv="refresh" content="0; url='.$url.'" />'	

?>

<?php get_footer();