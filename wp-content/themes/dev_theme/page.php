<?php

/**
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
<div class="py-section">
    <div class="container">
        <div class="editor">
            <?php the_content(); ?>
        </div>
    </div>
</div>
<?php
get_footer();
