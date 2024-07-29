<?php
function srs_regulated_slider_course_function($atts)
{

    $atts = shortcode_atts(
        array(
            'id' => '',
        ), $atts);
    ob_start();

    $course_id = $atts['id'];
    if (!empty($course_id)) {
        $course_ids = $course_id;
        $course_ids = (explode(",", $course_ids));
        $cid = array();
        if ($course_ids) {
            foreach ($course_ids as $course_id) {
                $cid[] = $course_id;
            }
        }

        $arg = array(
            "post_type" => "course",
            "posts_per_page" => 8,
            "post__in" => $cid,
            "post_status" => "published",
        );
    }

    $loop = new WP_Query($arg);
    if ($loop->have_posts()) {
        ?>

        <?php
        while ($loop->have_posts()) {
            $loop->the_post();
            ?>
            <?php
            $course_ID = get_the_ID();
            $average_rating = get_post_meta($course_ID, 'average_rating', true);
            $course_img = get_the_post_thumbnail_url($course_ID, "medium");
            $countRating = get_post_meta($course_ID, 'rating_count', true);
            $course_title = get_the_title($course_ID);
            $courseLink = get_the_permalink($course_ID);
            if (is_numeric($average_rating)) {
                $percentage = ($average_rating / 5) * 100;
            }
            $image_url = get_the_post_thumbnail_url($course_ID);

            ?>
            <div class="a2n_nxt-container">
                <div class="nxt-start">
                    <?php
                    if (is_image_broken($image_url)) {
                        $placeholder_img = get_stylesheet_directory_uri() . '/assets/img/default-image.webp';
                        ?>
                        <img width="100%" src="<?php echo $placeholder_img; ?>" alt="img">
                        <?php
                    } else {
                        ?>
                        <img src="<?php echo $course_img ?>" alt="<?php echo $course_title; ?>" />
                        <?php
                    }
                    ?>
                </div>

                <div class="nxt-contents">
                    <a class="nxt_title" href="<?php echo $courseLink ?>"><?php echo $course_title ?></a>
                    <div class="nxt_ratings">
                        <h5><?php echo $average_rating ?></h5>
                        <div class="a2n-ratings-container bp_blank_stars">
                            <div style="width: <?php echo $percentage ?>%" class="bp_filled_stars"></div>
                        </div>
                    </div>

                    <div class="nxt-end">
                        <div class="nxt-end_tag">
                            <?php bp_course_credits(); ?>
                        </div>
                        <a href="<?php echo $courseLink ?>" class="nxt_button">Vew Details</a>
                    </div>
                </div>
            </div>
            <?php
        }
        wp_reset_query();
        ?>

        <?php
    } else {
        echo "No Course Found";
    }

    ?>



    <?php
    return ob_get_clean();
}

add_shortcode('srs_regulated_slider_course', 'srs_regulated_slider_course_function');
?>