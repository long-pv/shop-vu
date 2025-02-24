<?php

/**
 * Template name: Blog
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package dev_theme
 */

get_header();
?>

<div class="container">
    <?php wp_breadcrumbs(); ?>
</div>

<?php
$paged = !empty($_GET['paging']) ? intval($_GET['paging']) : 1;

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 4,
    'paged' => $paged, // Thêm dòng này
);

$query = new WP_Query($args);
?>

<div class="container">
    <div class="row">
        <div class="col-12 col-md-8 col-lg-8">
            <div class="blog_list">
                <div class="row row_inner">
                    <?php if ($query && $query->have_posts()): ?>
                        <?php while ($query->have_posts()): ?>
                            <?php $query->the_post(); ?>
                            <div class="col-12 col-md-6 col-lg-6">
                                <?php get_template_part('template-parts/content-blog'); ?>
                            </div>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-4">
            <h2>Videos</h2>
            <div class="video-card">
                <img src="Videos card.png" alt="Video Thumbnail">
                <video src="video.mp4" muted loop></video>
                <div class="play-button"></div>
                <div class="overlay">How to connect your iPhone to a laptop?</div>
            </div>
        </div>
    </div>
</div>
<?php
$args_recent = array(
    'post_type' => 'post',
    'posts_per_page' => 4 // Đúng
);

$recent_post = new WP_Query($args_recent);
?>

<div class="container">
    <div class="recent_post">
        <h2 class="recent_post_title">
            Recent Posts
        </h2>
        <div class="row">
            <div class="col-7">
                <div class="recent_post_item_inner">
                    <?php if ($recent_post && $recent_post->have_posts()): ?>
                        <?php while ($recent_post->have_posts()): ?>
                            <?php $recent_post->the_post(); ?>
                            <?php get_template_part('template-parts/content-recent_blog'); ?>
                        <?php endwhile; ?>
                    <?php endif; ?>
                    <?php wp_reset_postdata(); ?>
                </div>
            </div>
        </div>
    </div>

    <!--  -->
    <?php
    echo '<div class="pagination">';
    echo paginate_links(
        array(
            'total' => $query->max_num_pages,
            'current' => max(1, $paged),
            'format' => '?paging=%#%',
            'end_size' => 2,
            'mid_size' => 1,
            'prev_text' => __('', 'basetheme'),
            'next_text' => __('', 'basetheme'),
        )
    );
    echo '</div>';
    ?>
</div>

<?php
get_footer();
