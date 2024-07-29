<?php

function all_comments_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'limit' => 10,
        ),
        $atts,
        'show_reviews'
    );

    $args = array(
        'number' => intval($atts['limit']),
        'status' => 'approve',
        'post_type' => 'course'
    );
    $comments = get_comments($args);

    ob_start();

    if (!empty($comments)) {
        echo '<div class="reviews_content_wrapper">';
        foreach ($comments as $comment) {
            $review_content = esc_html($comment->comment_content);
            $author_name = $comment->comment_author;

            $comment_meta = get_comment_meta($comment->comment_ID);
            $review_rating = $comment_meta['review_rating'][0];
            $review_percent = $review_rating * 20;
            $course_id = $comment->comment_post_ID;
            $course_title = get_the_title($course_id);
            $course_link = get_the_permalink($course_id);

            $student_num = get_post_meta($course_id, 'vibe_students', true);

            $thumb_src = get_the_post_thumbnail_url($course_id);
            $thumb_default = get_stylesheet_directory_uri() . '/assets/img/default-image.webp';
            $image_url = !is_image_broken($thumb_src) ? $thumb_src : $thumb_default;

            $categories = get_the_terms($course_id, 'course-cat');

            $product_ID = get_post_meta($course_id, 'vibe_product', true);
            $regular_price = get_post_meta($product_ID, '_regular_price', true);
            $sale_price = get_post_meta($product_ID, '_sale_price', true);
            $current_currency = get_woocommerce_currency_symbol();
            if (!empty($product_ID)) {
                if ($sale_price !== "") {
                    $m_price =   '<span>' . $current_currency . $sale_price . '</span>' . ' ' . '<del>' . $current_currency . $regular_price . '</del>';
                } elseif ($regular_price !== "") {
                    $m_price = '<span>' . $current_currency . $regular_price . '</span>';
                } else {
                    $m_price = '';
                }
            } else {
                $m_price = "Free";
            }

?>

            <div class="a2n-apex-review-card">
                <div class="review-rh">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M9.74066 3.375H0.703125C0.314758 3.375 0 3.68976 0 4.07812V13.1157C0 13.504 0.314758 13.8188 0.703125 13.8188H4.51868V19.8939C4.51868 20.282 4.83344 20.597 5.2218 20.597H7.48132C7.784 20.597 8.05261 20.4033 8.14819 20.1161L10.4075 13.338C10.4315 13.2664 10.4438 13.1913 10.4438 13.1157V4.07812C10.4438 3.68976 10.129 3.375 9.74066 3.375Z" fill="currentColor"></path>
                        <path d="M23.2968 3.375H14.2593C13.8709 3.375 13.5562 3.68976 13.5562 4.07812V13.1157C13.5562 13.504 13.8709 13.8188 14.2593 13.8188H18.075V19.8939C18.075 20.282 18.3898 20.597 18.7781 20.597H21.0375C21.3401 20.597 21.6088 20.4033 21.7045 20.1161L23.9639 13.338C23.9877 13.2664 23.9999 13.1913 23.9999 13.1157V4.07812C23.9999 3.68976 23.6852 3.375 23.2968 3.375Z" fill="currentColor"></path>
                    </svg>
                    <p><?php echo $review_content; ?></p>
                </div>
                <div class="user">
                    <div class="imfrh">
                        <span><?php
                                $wp_users_data = wp_get_current_user();
                                $user_display_name = $wp_users_data->display_name;
                                echo substr($user_display_name, 0, 1);
                                ?></span>
                    </div>
                    <div class="name-rating">
                        <span><?php echo $author_name; ?></span>
                        <div class="ks-star-rating">
                            <svg viewBox="0 0 1000 200" class="rating">
                                <defs>
                                    <polygon id="star" points="100,0 131,66 200,76 150,128 162,200 100,166 38,200 50,128 0,76 69,66 "></polygon>
                                    <clipPath id="stars">
                                        <use xlink:href="#star"></use>
                                        <use xlink:href="#star" x="20%"></use>
                                        <use xlink:href="#star" x="40%"></use>
                                        <use xlink:href="#star" x="60%"></use>
                                        <use xlink:href="#star" x="80%"></use>
                                    </clipPath>
                                </defs>
                                <rect class="rating__background" clip-path="url(#stars)"></rect>

                                <rect width="<?php echo $review_percent; ?>%" class="rating__value" clip-path="url(#stars)"></rect>
                            </svg>
                        </div>
                    </div>
                </div>
                <hr />
                <a href="<?php echo $course_link; ?>" class="course-name-img">
                    <img src="<?php echo $image_url; ?>" alt="" />
                    <h3><?php echo $course_title; ?></h3>
                </a>
                <div class="floating-r-card-h">
                    <div class="a2n_shape"></div>
                    <div class="course_card_rh">
                        <a href="<?php echo $course_link; ?>" class="course-name-img">
                            <img src="<?php echo $image_url; ?>" alt="" />
                            <h3><?php echo $course_title; ?></h3>
                        </a>
                        <div class="course_info">
                            <div class="pricee">
                                <span><?php echo $m_price; ?></span>
                            </div>
                            <div class="cat_stdnt">
                                <div class="category">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/templates/profile/assets/images/Category.svg" />
                                    <div class="cat">
                                        <span>Category: </span>
                                        <?php
                                        if (!empty($categories)) {

                                            foreach ($categories as $category) {
                                                echo '<a href="' . home_url() . '/course-cat/' . $category->slug . '"> ' . $category->name . '</a>';
                                                break;
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="student">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/templates/profile/assets/images/Friends.svg" />
                                    <div class="cat">
                                        <span>Student Enrolled: </span>
                                        <small><?php echo $student_num; ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="buttons">
                            <a href="<?php echo $course_link; ?>" class="view-details"> View Details </a>
                            <a href="<?php echo home_url(); ?>/cart/?add-to-cart=<?php echo $product_ID; ?>" class="to-cart">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
        echo '</div>';
        echo '<a class="a2n-Load_more" href="#">Load More</a>';
    } else {
        echo '<p>No reviews found.</p>';
    }

    return ob_get_clean();
}

add_shortcode('show_reviews', 'all_comments_shortcode');

function review_ajax_script()
{
    ?>
    <script>
        jQuery(document).ready(function($) {
            var page = 2;
            var loading = false;

            $('.a2n-Load_more').on('click', function(e) {
                e.preventDefault();
                if (loading) return;

                loading = true;
                var button = $(this);
                button.text('Loading...');

                $.ajax({
                    url: ajaxurl,
                    type: 'POST',
                    data: {
                        action: 'load_more_reviews',
                        page: page
                    },
                    success: function(response) {
                        if (response) {
                            $('.reviews_content_wrapper').append(response);
                            button.text('Load More');
                            page++;
                        } else {
                            button.text('No More Reviews');
                        }
                        loading = false;
                    }
                });
            });
        });
    </script>
    <?php
}
add_action('wp_footer', 'review_ajax_script');


function load_more_reviews()
{
    $page = isset($_POST['page']) ? intval($_POST['page']) : 2;
    $args = array(
        'number' => 12,
        'status' => 'approve',
        'post_type' => 'course',
        'offset' => ($page - 1) * 12
    );
    $comments = get_comments($args);

    if (!empty($comments)) {
        ob_start();
        foreach ($comments as $comment) {
            $review_content = esc_html($comment->comment_content);
            $author_name = $comment->comment_author;

            $comment_meta = get_comment_meta($comment->comment_ID);
            $review_rating = $comment_meta['review_rating'][0];
            $review_percent = $review_rating * 20;
            $course_id = $comment->comment_post_ID;
            $course_title = get_the_title($course_id);
            $course_link = get_the_permalink($course_id);

            $student_num = get_post_meta($course_id, 'vibe_students', true);

            $thumb_src = get_the_post_thumbnail_url($course_id);
            $thumb_default = get_stylesheet_directory_uri() . '/assets/img/default-image.webp';
            $image_url = !is_image_broken($thumb_src) ? $thumb_src : $thumb_default;

            $categories = get_the_terms($course_id, 'course-cat');

            $product_ID = get_post_meta($course_id, 'vibe_product', true);
            $regular_price = get_post_meta($product_ID, '_regular_price', true);
            $sale_price = get_post_meta($product_ID, '_sale_price', true);
            $current_currency = get_woocommerce_currency_symbol();
            if (!empty($product_ID)) {
                if ($sale_price !== "") {
                    $m_price =   '<span>' . $current_currency . $sale_price . '</span>' . ' ' . '<del>' . $current_currency . $regular_price . '</del>';
                } elseif ($regular_price !== "") {
                    $m_price = '<span>' . $current_currency . $regular_price . '</span>';
                } else {
                    $m_price = '';
                }
            } else {
                $m_price = "Free";
            }

            // Output the comment HTML structure
    ?>
            <div class="a2n-apex-review-card">
                <div class="review-rh">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M9.74066 3.375H0.703125C0.314758 3.375 0 3.68976 0 4.07812V13.1157C0 13.504 0.314758 13.8188 0.703125 13.8188H4.51868V19.8939C4.51868 20.282 4.83344 20.597 5.2218 20.597H7.48132C7.784 20.597 8.05261 20.4033 8.14819 20.1161L10.4075 13.338C10.4315 13.2664 10.4438 13.1913 10.4438 13.1157V4.07812C10.4438 3.68976 10.129 3.375 9.74066 3.375Z" fill="currentColor"></path>
                        <path d="M23.2968 3.375H14.2593C13.8709 3.375 13.5562 3.68976 13.5562 4.07812V13.1157C13.5562 13.504 13.8709 13.8188 14.2593 13.8188H18.075V19.8939C18.075 20.282 18.3898 20.597 18.7781 20.597H21.0375C21.3401 20.597 21.6088 20.4033 21.7045 20.1161L23.9639 13.338C23.9877 13.2664 23.9999 13.1913 23.9999 13.1157V4.07812C23.9999 3.68976 23.6852 3.375 23.2968 3.375Z" fill="currentColor"></path>
                    </svg>
                    <p><?php echo $review_content; ?></p>
                </div>
                <div class="user">
                    <div class="imfrh">
                        <span><?php
                                $wp_users_data = wp_get_current_user();
                                $user_display_name = $wp_users_data->display_name;
                                echo substr($user_display_name, 0, 1);
                                ?></span>
                    </div>
                    <div class="name-rating">
                        <span><?php echo $author_name; ?></span>
                        <div class="ks-star-rating">
                            <svg viewBox="0 0 1000 200" class="rating">
                                <defs>
                                    <polygon id="star" points="100,0 131,66 200,76 150,128 162,200 100,166 38,200 50,128 0,76 69,66 "></polygon>
                                    <clipPath id="stars">
                                        <use xlink:href="#star"></use>
                                        <use xlink:href="#star" x="20%"></use>
                                        <use xlink:href="#star" x="40%"></use>
                                        <use xlink:href="#star" x="60%"></use>
                                        <use xlink:href="#star" x="80%"></use>
                                    </clipPath>
                                </defs>
                                <rect class="rating__background" clip-path="url(#stars)"></rect>
                                <rect width="<?php echo $review_percent; ?>%" class="rating__value" clip-path="url(#stars)"></rect>
                            </svg>
                        </div>
                    </div>
                </div>
                <hr />
                <a href="<?php echo $course_link; ?>" class="course-name-img">
                    <img src="<?php echo $image_url; ?>" alt="" />
                    <h3><?php echo $course_title; ?></h3>
                </a>
                <div class="floating-r-card-h">
                    <div class="a2n_shape"></div>
                    <div class="course_card_rh">
                        <a href="<?php echo $course_link; ?>" class="course-name-img">
                            <img src="<?php echo $image_url; ?>" alt="" />
                            <h3><?php echo $course_title; ?></h3>
                        </a>
                        <div class="course_info">
                            <div class="pricee">
                                <span><?php echo $m_price; ?></span>
                            </div>
                            <div class="cat_stdnt">
                                <div class="category">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/templates/profile/assets/images/Category.svg" />
                                    <div class="cat">
                                        <span>Category: </span>
                                        <?php
                                        if (!empty($categories)) {
                                            foreach ($categories as $category) {
                                                echo '<a href="' . home_url() . '/course-cat/' . $category->slug . '"> ' . $category->name . '</a>';
                                                break;
                                            }
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="student">
                                    <img src="<?php echo get_stylesheet_directory_uri() ?>/templates/profile/assets/images/Friends.svg" />
                                    <div class="cat">
                                        <span>Student Enrolled: </span>
                                        <small><?php echo $student_num; ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="buttons">
                            <a href="<?php echo $course_link; ?>" class="view-details"> View Details </a>
                            <a href="<?php echo home_url(); ?>/cart/?add-to-cart=<?php echo $product_ID; ?>" class="to-cart">Add to Cart</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        }
        echo ob_get_clean();
    } else {
        echo '';
    }

    wp_die();
}
add_action('wp_ajax_load_more_reviews', 'load_more_reviews');
add_action('wp_ajax_nopriv_load_more_reviews', 'load_more_reviews');

// home page reviews section 
function single_review_shortcode($atts)
{
    $atts = shortcode_atts(
        array(
            'index' => 0, // Default to the first review if no index is specified
        ),
        $atts,
        'show_single_review'
    );

    $args = array(
        'number' => 1,
        'status' => 'approve',
        'post_type' => 'course',
        'offset' => intval($atts['index'])
    );
    $comments = get_comments($args);

    ob_start();

    if (!empty($comments)) {
        $comment = $comments[0];
        $review_content = esc_html($comment->comment_content);
        $author_name = $comment->comment_author;

        $comment_meta = get_comment_meta($comment->comment_ID);
        $review_rating = isset($comment_meta['review_rating'][0]) ? $comment_meta['review_rating'][0] : 0;
        $review_percent = $review_rating * 20;
        $course_id = $comment->comment_post_ID;
        $course_title = get_the_title($course_id);
        $course_link = get_the_permalink($course_id);

        $student_num = get_post_meta($course_id, 'vibe_students', true);

        $thumb_src = get_the_post_thumbnail_url($course_id);
        $thumb_default = get_stylesheet_directory_uri() . '/assets/img/default-image.webp';
        $image_url = !is_image_broken($thumb_src) ? $thumb_src : $thumb_default;

        $categories = get_the_terms($course_id, 'course-cat');

        $product_ID = get_post_meta($course_id, 'vibe_product', true);
        $regular_price = get_post_meta($product_ID, '_regular_price', true);
        $sale_price = get_post_meta($product_ID, '_sale_price', true);
        $current_currency = get_woocommerce_currency_symbol();
        if (!empty($product_ID)) {
            if ($sale_price !== "") {
                $m_price = '<span>' . $current_currency . $sale_price . '</span>' . ' ' . '<del>' . $current_currency . $regular_price . '</del>';
            } elseif ($regular_price !== "") {
                $m_price = '<span>' . $current_currency . $regular_price . '</span>';
            } else {
                $m_price = '';
            }
        } else {
            $m_price = "Free";
        }


        ?>

        <div class="r4h-apex-review-card">
            <div class="review-rh">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M9.74066 3.375H0.703125C0.314758 3.375 0 3.68976 0 4.07812V13.1157C0 13.504 0.314758 13.8188 0.703125 13.8188H4.51868V19.8939C4.51868 20.282 4.83344 20.597 5.2218 20.597H7.48132C7.784 20.597 8.05261 20.4033 8.14819 20.1161L10.4075 13.338C10.4315 13.2664 10.4438 13.1913 10.4438 13.1157V4.07812C10.4438 3.68976 10.129 3.375 9.74066 3.375Z" fill="currentColor"></path>
                    <path d="M23.2968 3.375H14.2593C13.8709 3.375 13.5562 3.68976 13.5562 4.07812V13.1157C13.5562 13.504 13.8709 13.8188 14.2593 13.8188H18.075V19.8939C18.075 20.282 18.3898 20.597 18.7781 20.597H21.0375C21.3401 20.597 21.6088 20.4033 21.7045 20.1161L23.9639 13.338C23.9877 13.2664 23.9999 13.1913 23.9999 13.1157V4.07812C23.9999 3.68976 23.6852 3.375 23.2968 3.375Z" fill="currentColor"></path>
                </svg>
                <p> <?php echo $review_content; ?></p>
            </div>
            <div class="floating-r-card-h">
                <div class="user">
                    <div class="imfrh">
                        <span><?php
                                $wp_users_data = wp_get_current_user();
                                $user_display_name = $wp_users_data->display_name;
                                echo substr($user_display_name, 0, 1);
                                ?></span>
                    </div>
                    <div class="name-rating">
                        <span><?php echo $author_name; ?></span>
                        <div class="ks-star-rating">
                            <svg viewBox="0 0 1000 200" class="rating">
                                <defs>
                                    <polygon id="star" points="100,0 131,66 200,76 150,128 162,200 100,166 38,200 50,128 0,76 69,66 "></polygon>
                                    <clipPath id="stars">
                                        <use xlink:href="#star"></use>
                                        <use xlink:href="#star" x="20%"></use>
                                        <use xlink:href="#star" x="40%"></use>
                                        <use xlink:href="#star" x="60%"></use>
                                        <use xlink:href="#star" x="80%"></use>
                                    </clipPath>
                                </defs>
                                <rect class="rating__background" clip-path="url(#stars)"></rect>

                                <rect width="<?php echo $review_percent; ?>%" class="rating__value" clip-path="url(#stars)"></rect>
                            </svg>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="course_card_rh">
                    <a href="<?php echo $course_link; ?>" class="course-name-img">
                        <img src="<?php echo $image_url; ?>" alt="" />
                        <h3><?php echo $course_title; ?></h3>
                    </a>
                    <div class="course_info">
                        <div class="pricee">
                            <span><?php echo $m_price; ?></span>
                        </div>
                        <div class="cat_stdnt">
                            <div class="category">
                                <svg width="16" height="16" viewBox="0 0 16 16" class="text-primary-500" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_68_2519)">
                                        <path d="M15.8137 7.42163C15.5708 7.0293 15.1411 6.79517 14.6643 6.79517H13.4741V4.61194C13.4741 4.08496 13.0295 3.65637 12.4832 3.65637H6.65686C6.64831 3.65637 6.64258 3.65393 6.64026 3.65247L5.59753 2.19409C5.4126 1.93555 5.10767 1.78125 4.78174 1.78125H0.990967C0.444458 1.78125 0 2.20996 0 2.73682V13.2102C0 13.7495 0.455322 14.1884 1.01514 14.1884H12.8077C12.9915 14.1884 13.1501 14.0823 13.2269 13.9283L13.2273 13.9285L15.8699 8.62097C16.0615 8.23633 16.0404 7.78796 15.8137 7.42163ZM0.990967 2.71875H4.78174C4.80981 2.71875 4.82886 2.73108 4.83484 2.7395L5.87915 4.19995C6.05542 4.44653 6.34619 4.59387 6.65686 4.59387H12.4832C12.5159 4.59387 12.5325 4.60925 12.5366 4.61475V6.79517H4.0531C3.52698 6.79517 3.04846 7.09167 2.83398 7.55066L0.9375 11.6091V2.73962C0.94165 2.73413 0.958252 2.71875 0.990967 2.71875ZM15.0306 8.20312L12.5175 13.2507H1.2052L3.68335 7.94763C3.74341 7.81909 3.89209 7.73267 4.0531 7.73267H14.6643C14.8141 7.73267 14.9458 7.8009 15.0166 7.91516C15.0564 7.97949 15.0911 8.08166 15.0306 8.20312Z" fill="#00378b"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_68_2519">
                                            <rect width="16" height="16" fill="white"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                                <div class="cat">
                                    <span>Category: </span>
                                    <?php
                                    if (!empty($categories)) {
                                        foreach ($categories as $category) {
                                            echo '<a href="' . home_url() . '/course-cat/' . $category->slug . '"> ' . $category->name . '</a>';
                                            break;
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="student">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_68_2523)">
                                        <path d="M15.9835 10.3766C15.7194 8.8888 14.7321 7.69422 13.4302 7.14014C14.008 6.65564 14.377 5.922 14.377 5.10242C14.377 3.64673 13.2134 2.4624 11.7831 2.4624C10.3528 2.4624 9.18923 3.64661 9.18923 5.10242C9.18923 5.92249 9.55862 6.65637 10.137 7.14099C9.92117 7.23303 9.71206 7.3429 9.51235 7.47095C9.00906 7.7937 8.57937 8.21875 8.24819 8.71655C7.91116 8.49268 7.54873 8.3064 7.16665 8.16345C7.98782 7.56983 8.52468 6.59375 8.52468 5.49231C8.52468 3.68726 7.08291 2.21875 5.31069 2.21875C3.53848 2.21875 2.0967 3.68726 2.0967 5.49231C2.0967 6.59375 2.63357 7.56983 3.45474 8.16345C1.70718 8.81726 0.366845 10.3721 0.0191885 12.3296C-0.0450205 12.6915 0.0536124 13.0607 0.289574 13.3424C0.523339 13.6213 0.864404 13.7813 1.22537 13.7813H9.39602C9.75698 13.7813 10.098 13.6213 10.3318 13.3424C10.5679 13.0607 10.6664 12.6915 10.6022 12.3296C10.5594 12.0881 10.5012 11.8529 10.4293 11.6248H14.9455C15.2563 11.6248 15.55 11.4871 15.7511 11.2471C15.954 11.005 16.0387 10.6876 15.9835 10.3766ZM10.1267 5.10242C10.1267 4.16357 10.8698 3.3999 11.7831 3.3999C12.6964 3.3999 13.4395 4.16357 13.4395 5.10242C13.4395 6.04114 12.6964 6.80481 11.7831 6.80481C10.8698 6.80481 10.1267 6.04114 10.1267 5.10242ZM3.0342 5.49231C3.0342 4.20422 4.05544 3.15625 5.31069 3.15625C6.56594 3.15625 7.58731 4.20422 7.58731 5.49231C7.58731 6.7804 6.56594 7.82837 5.31069 7.82837C4.05544 7.82837 3.0342 6.7804 3.0342 5.49231ZM9.61331 12.7402C9.58084 12.7789 9.50955 12.8438 9.39602 12.8438H1.22537C1.11184 12.8438 1.04055 12.7789 1.00808 12.7402C0.974389 12.7 0.920922 12.6143 0.942284 12.4934C1.32583 10.3336 3.16299 8.76587 5.31069 8.76587C7.4584 8.76587 9.29568 10.3336 9.6791 12.4934C9.70059 12.6143 9.64712 12.7 9.61331 12.7402ZM15.0326 10.6449C15.0193 10.6608 14.9904 10.6873 14.9456 10.6873H10.0353C9.75796 10.1676 9.40176 9.70142 8.98391 9.30371C9.59451 8.3324 10.6381 7.74231 11.7831 7.74231C13.3943 7.74231 14.7725 8.91907 15.0605 10.5405C15.0695 10.5917 15.0469 10.6279 15.0326 10.6449Z" fill="#00378b"></path>
                                    </g>
                                    <defs>
                                        <clipPath id="clip0_68_2523">
                                            <rect width="16" height="16" fill="white"></rect>
                                        </clipPath>
                                    </defs>
                                </svg>
                                <div class="cat">
                                    <span>Student Enrolled: </span>
                                    <small><?php echo $student_num; ?></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="buttons">
                        <a href="<?php echo $course_link; ?>" class="view-details"> View Details </a>
                        <a href="<?php echo home_url(); ?>/cart/?add-to-cart=<?php echo $product_ID; ?>" class="to-cart">Add to Cart</a>
                    </div>
                </div>
            </div>
        </div>
<?php
    } else {
        echo '<p>No reviews found.</p>';
    }

    return ob_get_clean();
}

add_shortcode('show_single_review', 'single_review_shortcode');
