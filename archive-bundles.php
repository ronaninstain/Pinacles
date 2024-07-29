<?php
if (!defined('ABSPATH'))
    exit;

?>
<?php get_header(vibe_get_header()); ?>

<!-- bundle title area start  -->
<div class="a2n-bundle_area">
    <div class="section-area_container">
        <div class="a2n-bundle_titles">
            <h3>FALL IN LOVE WITH LEARNING</h3>
            <h2>Bundle Courses</h2>
            <p>
                Start learning with us and achieve higher value certificates. Start
                learning now, this is your perfect place to start.
            </p>
        </div>
    </div>
</div>
<!-- bundle title area end  -->
<!-- bundle courses area start  -->
<?php
$args = array(
    'posts_per_page' => -1,
    'post_type' => 'bundles',
    'post_status' => 'publish',
);

$the_query = new WP_Query($args);
?>
<div class="a2n-bundle_courses__area">
    <div class="section-area_container">
        <div class="a2n-bundle__wrapper">
            <?php if ($the_query->have_posts()):
                while ($the_query->have_posts()):
                    $the_query->the_post();



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
                    <!-- #1 bundle course end-->
                    <?php
                endwhile;
                wp_reset_postdata();
            endif;

            ?>

        </div>
    </div>
</div>
<div class="bundllePagination">
    <?php the_posts_pagination(); ?>
</div>
<!-- bundle courses area end  -->


<?php get_footer(vibe_get_footer()); ?>