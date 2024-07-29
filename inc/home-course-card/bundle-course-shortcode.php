<?php


function srs_bundle_courses_function($atts)
{
    $atts = shortcode_atts(
        array(
            'id' => '',
        ),
        $atts
    );
    ob_start();

    $a2n_course_id = $atts['id'];
    if (!empty($a2n_course_id)) {
        $a2n_course_ids = $a2n_course_id;
        $a2n_course_ids = (explode(",", $a2n_course_ids));
        $course_id = array();
        if ($a2n_course_ids) {
            foreach ($a2n_course_ids as $a2n_course_id) {
                $course_id[] = $a2n_course_id;
            }
        }
        $args = array(
            'post_type' => 'bundles',
            'posts_per_page' => 3,
            'post__in' => $course_id,
            'post_status' => 'published',
        );
    }
    $fetch = new WP_Query($args);
    if ($fetch->have_posts()) {
        while ($fetch->have_posts()) {
            $fetch->the_post();

            $bundleID = get_the_ID();
                    $bundleTitle = get_the_Title($bundleID);
                    $bundleLink = get_the_permalink($bundleID);
                    $bundleImg = get_the_post_thumbnail_url($bundleID, 'medium');
                    $bundleNumber = get_field("bundle_items_quantity_text");
                    $ProductID = get_field("product_id");
                    $regular_price = get_post_meta(trim($ProductID), '_regular_price', true);
                    $sale_price = get_post_meta(trim($ProductID), '_sale_price', true);
                    $current_currency = get_woocommerce_currency_symbol();
                    $bundleTags = get_field('bundle_tags');

                    ?>
                    <!-- #1 bundle course start-->
                    <div class="a2n_bundle_course">
                        <div class="bundle-content">
                            <div class="bundle-image-container">
                                <a href="<?php echo $bundleLink; ?>">
                                    <?php
                                    if (has_post_thumbnail()) {
                                        ?>
                                        <img src="<?php echo $bundleImg; ?>" alt="<?php echo $bundleTitle; ?>" class="bundle-image"
                                            loading="lazy" decoding="async">
                                        <?php
                                    } else {
                                        ?>
                                        <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/dummy.png' ?>"
                                            class="bundle-image" alt="<?php echo $bundleTitle; ?>" loading="lazy" decoding="async">
                                        <?php
                                    }
                                    ?>

                                    <div class="course-badge">
                                        <?php if ($bundleNumber) {
                                            ?>
                                            <span>
                                                <?php echo $bundleNumber; ?>
                                            </span>
                                            <?php
                                        } ?>
                                    </div>
                                </a>
                            </div>
                            <div class="bundle-details">
                                <h3 class="bundle-title">
                                    <a href="<?php echo $bundleLink; ?>">
                                        <?php echo $bundleTitle; ?>
                                    </a>
                                </h3>
                                <?php
                                if ($bundleTags) {
                                    $tagsArray = explode(',', $bundleTags);
                                    ?>

                                    <ul class="bundle-features">
                                        <?php foreach ($tagsArray as $tag): ?>
                                            <li class="feature-item">
                                                <svg class="feature-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                    viewBox="0 0 16 16" fill="none">
                                                    <path
                                                        d="M6.44845 15.6088C6.96584 16.1325 8.11819 15.9589 8.24226 15.1355C9.01422 10.0233 12.8769 5.71052 15.8 1.64658C16.6105 0.520419 14.7469 -0.549399 13.947 0.56336C11.2758 4.27665 7.909 8.18398 6.59187 12.6899C5.08671 11.1516 3.57547 9.62798 1.88731 8.27629C0.818189 7.41991 -0.71113 8.92864 0.369511 9.79401C2.56898 11.5558 4.46976 13.6102 6.44845 15.6088Z"
                                                        fill="currentColor"></path>
                                                </svg>
                                                <span class="feature-text"> <?php echo esc_html($tag); ?></span>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>

                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                        <div class="bundle-footer">
                            <?php
                            if ($ProductID) {
                                ?>
                                <div class="bundle-price-container-wrapper">
                                    <div class="bundle-price-container">
                                        <strong>
                                            <?php
                                            if ($regular_price) {
                                                ?>
                                                <del aria-hidden="true">
                                                    <span
                                                        class="woocommerce-Price-amount amount"><?php echo $current_currency . $regular_price; ?></span>
                                                </del>
                                                <?php
                                            }
                                            if ($sale_price) {
                                                ?>
                                                <ins aria-hidden="true">
                                                    <span
                                                        class="woocommerce-Price-amount amount"><?php echo $current_currency . $sale_price; ?></span>
                                                </ins>
                                                <?php
                                            }
                                            ?>
                                        </strong>
                                    </div>
                                    <div class="bundle-button-container">
                                        <a href="<?php echo site_url(); ?>/cart/?add-to-cart=<?php echo $ProductID; ?>"
                                            class="bundle-button">
                                            <div class="button-text">Add to cart</div>
                                        </a>
                                    </div>
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>

            <?php
        }
        wp_reset_query();
    } else {
        echo "no course found";
    }
    return ob_get_clean();
}
add_shortcode('srs_bundle_course_apex', 'srs_bundle_courses_function');
