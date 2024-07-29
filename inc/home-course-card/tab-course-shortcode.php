<?php
function srs_tab_function($atts)
{
    ob_start();

    $atts = shortcode_atts(
        array(
            'filter' => 'new',
        ),
        $atts
    );


    if ($atts['filter'] == 'top_rated') {
        $arg = array(
            "post_type" => "course",
            "posts_per_page" => 7,
            "meta_key" => 'rating_count',
            "orderby" => 'meta_value_num',
            "order" => 'DESC',
            "post_status" => "publish",
        );
    } elseif ($atts['filter'] == 'most_popular') {
        $arg = array(
            "post_type" => "course",
            "posts_per_page" => 7,
            "post_status" => "publish",
            "meta_key" => "vibe_students",
            "orderby" => "meta_value_num",
            "order" => "DESC",
        );
    } else {
        $arg = array(
            "post_type" => "course",
            "posts_per_page" => 7,
            "post_status" => "publish",
            "orderby" => "date",
            "order" => "DESC"
        );
    }

    $loop = new WP_Query($arg);
    if ($loop->have_posts()) {
        while ($loop->have_posts()) {
            $loop->the_post();
            $course_ID = get_the_ID();
            $average_rating = get_post_meta($course_ID, 'average_rating', true);
            $course_img = get_the_post_thumbnail_url($course_ID, "medium");
            $countRating = get_post_meta($course_ID, 'rating_count', true);
            $course_title = get_the_title($course_ID);
            $courseLink = get_the_permalink($course_ID);
            $courseStudents = get_post_meta($course_ID, 'vibe_students', true);
            $image_url = get_the_post_thumbnail_url($course_ID);

            if (is_numeric($average_rating)) {
                $percentage = ($average_rating / 5) * 100;
            }
            ?>

            <div class="a2n_bs-card">
                <?php
                $product_ID = get_post_meta($course_ID, 'vibe_product', true);
                ?>
                <?php
                $product = wc_get_product($product_ID);
                if ($product) {
                    $sale_price = $product->get_sale_price();
                    $regular_price = $product->get_regular_price();

                    if (is_numeric($sale_price) && is_numeric($regular_price) && $regular_price != 0) {

                        $discount = ($regular_price - $sale_price) / $regular_price * 100;
                        ?>
                        <div class="a2n_discount">
                            <span><?php echo round($discount) ?> % OFF</span>
                            <img class="a2n_offer-img" src="<?php echo site_url(); ?>/wp-content/uploads/2024/06/corner-ribbon.svg"
                                alt="ribon" />
                        </div>

                        <?php
                    } else {
                        ?>
                        <div class="a2n_discount"><span>0 % OFF</span>
                            <img class="a2n_offer-img" src="<?php echo site_url(); ?>/wp-content/uploads/2024/06/corner-ribbon.svg"
                                alt="ribon" />
                        </div>
                        <?php
                    }
                }
                ?>

                <div class="a2n_image_sec"><a href="<?php echo $courseLink ?>">
                        <?php
                        if (is_image_broken($image_url)) {
                            $placeholder_img = get_stylesheet_directory_uri() . '/assets/img/default-image.webp';
                            ?>
                            <img width="100%" src="<?php echo $placeholder_img; ?>" alt="">
                            <?php
                        } else {
                            ?>
                            <img src="<?php echo $course_img ?>" alt="<?php echo $course_title; ?>" />
                            <?php
                        }
                        ?>
                    </a></div>
                <div class="a2n_content_sec">
                    <?php
                    $course_ID = get_the_ID();
                    $taxonomy = 'course-cat';
                    $terms = wp_get_post_terms($course_ID, $taxonomy, array('fields' => 'all'));
                    ?>
                    <?php
                    foreach (array_slice($terms, 0, 1) as $term_single) {
                        ?>
                        <div class="a2n_cat-items">
                            <a class="a2n_cat"
                                href="<?php echo esc_url(get_term_link($term_single)); ?>"><?php echo esc_html($term_single->name); ?></a>
                        </div>
                        <?php
                    }
                    ?>
                    <div>

                        <a class="a2n_heading" href="<?php echo $courseLink ?>"><?php echo $course_title ?></a>

                    </div>
                    <div>
                        <div class="a2n_rating_sec">
                            <p><?php echo $average_rating ?></p>
                            <div class="a2n-ratings-container bp_blank_stars">
                                <div class="bp_filled_stars" style="width: <?php echo $percentage ?>%;"></div>
                            </div>
                        </div>
                        <div class="a2n_footer_content">
                            <?php bp_course_credits(); ?>
                            <div class="a2n_member">
                                <div class="members_icon">
                                    <svg class="text-neutral-600" width="12" height="12" viewBox="0 0 12 12" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.80908 5.56418C8.57692 5.00419 9.07693 4.09791 9.07693 3.07692C9.07693 1.3803 7.69663 0 6.00001 0C4.30339 0 2.92309 1.3803 2.92309 3.07692C2.92309 4.09791 3.42308 5.00419 4.19094 5.56418C2.28219 6.29461 0.923096 8.14526 0.923096 10.3077C0.923096 11.2408 1.68226 12 2.6154 12H9.38462C10.3178 12 11.0769 11.2408 11.0769 10.3077C11.0769 8.14526 9.71783 6.29461 7.80908 5.56418ZM3.84617 3.07692C3.84617 1.8893 4.81238 0.923086 6.00001 0.923086C7.18763 0.923086 8.15385 1.8893 8.15385 3.07692C8.15385 4.26455 7.18763 5.23078 6.00001 5.23078C4.81238 5.23078 3.84617 4.26455 3.84617 3.07692ZM9.38462 11.0769H2.6154C2.19125 11.0769 1.84618 10.7318 1.84618 10.3077C1.84618 8.01722 3.70956 6.15382 6.00003 6.15382C8.29051 6.15382 10.1539 8.0172 10.1539 10.3077C10.1539 10.7318 9.80879 11.0769 9.38462 11.0769Z"
                                            fill="currentColor"></path>
                                    </svg>
                                </div>
                                <p><?php echo $courseStudents ?> Students</p>

                            </div>
                        </div>
                    </div>
                </div>
                <a class="a2n_bs-btn" href="<?php echo $courseLink ?>"><i class="fas fa-arrow-right" aria-hidden="true"></i></a>
                <div class="a2n_hover_card"><img
                        src="https://backend.apexlearning.org.uk/wp-content/uploads/2024/06/card-hover-arrow.webp" alt="" /></div>
            </div>

            <?php
        }
        wp_reset_query();
    } else {
        echo "No Course Found";
    }

    return ob_get_clean();
}

add_shortcode('srs_tab_course', 'srs_tab_function');
?>