<?php
function add_ajax_url()
{
    ?>
    <script type="text/javascript">
        var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    </script>
    <?php
}
add_action('wp_head', 'add_ajax_url');

// 
function increase_post_like()
{
    $post_id = intval($_POST['post_id']);

    if ($post_id) {
        $likes = get_post_meta($post_id, 'post_likes', true);
        $likes = $likes ? $likes + 1 : 1;

        update_post_meta($post_id, 'post_likes', $likes);

        echo $likes;
    }
    wp_die();
}
add_action('wp_ajax_increase_post_like', 'increase_post_like');
add_action('wp_ajax_nopriv_increase_post_like', 'increase_post_like');
