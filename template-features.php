<?php /* Template Name: Features */ ?>

<?php get_header(); ?>

<h1><center>Features</center></h1>
<?php
while ( have_posts() ) : the_post();

the_title();

the_content();

the_post_thumbnail('large'); 

endwhile; // End of the loop.
?>

</div><!-- .container -->


<?php get_footer(); ?>
