<?php
/**
 * @package Ion
 */
?>

<li id="post-<?php the_ID(); ?>" class="post-list-item">

	<a class="item item-thumbnail-left item-text-wrap" href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php 
		if ( has_post_thumbnail(get_the_ID()) ) {
			echo '<img class="post-thumbnail" src="' . get_the_post_thumbnail_url(get_the_ID(), 'thumbnail' ) . '">';
		} else if(class_exists('AppPresser_Ajax_Extras')) {
			echo '<img class="post-thumbnail" src="' . AppPresser_Ajax_Extras::get_default_thumbnail() . '">';
		} ?>

		<div class="item-title"><?php the_title(); ?></div>

		<div class="item-text"><?php the_excerpt(); ?></div>

</a>

</li>