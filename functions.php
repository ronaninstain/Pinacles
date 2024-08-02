<?php
if (!defined('VIBE_URL'))
    define('VIBE_URL', get_template_directory_uri());
include_once 'includes/api/get_course_progress.php';
require get_stylesheet_directory() . '/classes/AjaxHandler.php';

// by Shoive
include_once 'includes/courseCards.php';
include_once 'includes/sa-mb.php';
include_once 'inc/postTypes/cptTaxonomyMeta.php';
//by arif
include_once 'includes/wcCart.php';
include_once 'inc/reviews-shortcode.php';

//Broken link check
function is_image_broken($url)
{
    $headers = @get_headers($url);
    if (!$headers || strpos($headers[0], '200') === false) {
        return true; // Image link is broken
    }
    return false; // Image link is valid
}

function apex_css()
{
    wp_enqueue_style('style', get_stylesheet_uri());
    wp_enqueue_style('single', get_theme_file_uri('/css/singleCourse.css'), false, '1.2', 'all');
    wp_enqueue_script('custom', get_stylesheet_directory_uri() . '/assets/js/custom.js', array('jquery'), time(), true);

    wp_enqueue_script('sub', get_stylesheet_directory_uri() . '/assets/js/sub.js', array('jquery'), time(), true);


    if (is_page_template('page-bundle_course.php') || is_page_template('page-extend-subscription.php')) {
        wp_enqueue_style('bundle-bs-style', 'https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css');
        wp_enqueue_style('bundle-font-awesome-style', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');
        wp_enqueue_style('bundle-style', get_stylesheet_directory_uri() . '/css/bundle_course.css');
    }

    // by Shoive 
    if (is_singular('course')) {
        wp_enqueue_style('singleCourse24', get_stylesheet_directory_uri() . '/assets/css/singleCourse24.css', null, 4.2);
        wp_enqueue_script('singleCourseJs', get_stylesheet_directory_uri() . '/assets/js/singleCourse.js', NULL, 4.2, true);
    }
    wp_enqueue_style('blogs', get_stylesheet_directory_uri() . '/assets/css/blogApex.css', null, 3.2);
    wp_enqueue_style('bundles', get_stylesheet_directory_uri() . '/assets/css/bundles.css', null, 4.2);
    //common css & js for global
    wp_enqueue_style('common-css', get_stylesheet_directory_uri() . '/assets/css/common.css', null, time());
    wp_enqueue_script('common-Js', get_stylesheet_directory_uri() . '/assets/js/common.js', NULL, 5.2, true);

    // Added by Safat
    wp_enqueue_style('srsheaderCss', get_stylesheet_directory_uri() . '/assets/css/header/header.css', null, time());
    wp_enqueue_script('srsheaderJs', get_stylesheet_directory_uri() . '/assets/js/header.js', null, time(), true);
    wp_enqueue_style('regulated-silder-course-css', get_stylesheet_directory_uri() . '/assets/css/home/regulated-course-card.css', null, time());
    wp_enqueue_style('bundle-course-css', get_stylesheet_directory_uri() . '/assets/css/home/bundle-course-card.css', null, time());
    wp_enqueue_style('tab-course-css', get_stylesheet_directory_uri() . '/assets/css/home/tab-course-card.css', null, time());

    // Added by Hasan
    wp_enqueue_style('singleBlog', get_stylesheet_directory_uri() . '/assets/css/singleBlog.css', null, time());

    // added by arif
    if (is_cart()) {
        wp_enqueue_style('cart-page-style', get_stylesheet_directory_uri() . '/assets/css/cart_style.css', null, '1.0.0');
    }

}
add_action("wp_enqueue_scripts", "apex_css");







function checkout_page_coupon_hide()
{
    //    if (is_page('checkout')) {
    echo "<style>.cart-discount.coupon-bundle-course{display: none;}</style>";
    //    }
}
add_action('wp_header', 'checkout_page_coupon_hide');


/**
 * Automatically add product to cart on visit
 * author: farhan
 */

add_action('woocommerce_add_to_cart', 'add_product_to_cart_certificate');
function add_product_to_cart_certificate()
{
    if (!is_admin() && !is_cart() && !is_checkout()) {
        $product_id = 11900; //replace with your own product id



        $found = false;
        $items_count = 0;
        //check if product already in cart
        if (sizeof(WC()->cart->get_cart()) > 0) {
            foreach (WC()->cart->get_cart() as $cart_item_key => $values) {
                $_product = $values['data'];

                if ($_product->get_id() == $product_id) {
                    $product_key = $cart_item_key;
                    $product_qty = $cart_item['quantity'];
                    $found = true;
                } else {
                    $items_count++;
                }
            }
            // if product not found, add it
            if (!$found) {
                WC()->cart->add_to_cart($product_id, $items_count);
            } else {
                WC()->cart->set_quantity($product_key, $items_count);
            }
        } else {
            // if no products in cart, add it
            WC()->cart->add_to_cart($product_id);
        }
    }
}




// checkout extra field remove
add_filter('woocommerce_checkout_fields', 'misha_remove_fields', 9999);

function misha_remove_fields($woo_checkout_fields_array)
{

    // she wanted me to leave these fields in checkout
    // unset( $woo_checkout_fields_array['billing']['billing_first_name'] );
    // unset( $woo_checkout_fields_array['billing']['billing_last_name'] );
    // unset( $woo_checkout_fields_array['billing']['billing_phone'] );
    // unset( $woo_checkout_fields_array['billing']['billing_email'] );
    // unset( $woo_checkout_fields_array['order']['order_comments'] ); // remove order notes

    // and to remove the billing fields below
    unset($woo_checkout_fields_array['billing']['billing_company']); // remove company field
    // unset( $woo_checkout_fields_array['billing']['billing_country'] );
    // unset( $woo_checkout_fields_array['billing']['billing_address_1'] );
    unset($woo_checkout_fields_array['billing']['billing_address_2']);
    unset($woo_checkout_fields_array['billing']['billing_city']);
    unset($woo_checkout_fields_array['billing']['billing_state']); // remove state field
    unset($woo_checkout_fields_array['billing']['billing_postcode']); // remove zip code field

    return $woo_checkout_fields_array;
}



/* add_action('wp_head','my_analytics', 20);
function my_analytics() { ?>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-K2ZWQ7V');</script>
    <!-- End Google Tag Manager -->
<?php
}


function custom_content_after_body_open_tag() {  ?>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K2ZWQ7V"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->
  <?php

}
add_action('after_body_open_tag', 'custom_content_after_body_open_tag'); */
//End

// Creating custom meta field at custom post
function bundle_course_metabox()
{
    /*
     * Create Designation Field For Custom Post Type News
     * */
    add_meta_box('bundle_course_meta', 'Bundle Course?', 'display_bundle_course_meta', 'course', 'side', 'low');
}
add_action('admin_init', 'bundle_course_metabox');

function display_bundle_course_meta($post)
{
    $checked = (esc_html(get_post_meta($post->ID, 'bundle_course', true)) == 'on') ? 'checked' : 'sdf';
    $html = '';
    $html .= '<div class="bundleBox">';

    $html .= '<div class="form-group">';
    $html .= '<label><input ' . $checked . ' type="checkbox" class="form-control" name="meta[bundle_course]"> Yes</input></label>';
    $html .= '</div>';
    $html .= '</div>';

    echo $html;
}

//Save the metabox
add_action('save_post', 'save_bundle_course', 10, 2);
function save_bundle_course($post_id, $post)
{
    //    echo "<pre>";print_r($_POST);echo "</pre>";exit();
    $bundle_course_val = 'off';
    if (isset($_POST['meta']['bundle_course'])) {
        $bundle_course_val = 'on';
    }
    update_post_meta($post_id, 'bundle_course', $bundle_course_val);
}

function bundle_course_load_more()
{
    //    echo "<pre>";print_r($_POST);echo "</pre>"; exit();
    $args = sorting_and_loading_more_arguments($_POST, true);

    query_posts($args);
    if (have_posts()):
        //        echo '<div class="row loopContainer">';
        while (have_posts()):
            the_post();
            get_template_part('template-parts/content', 'bundle');
        endwhile;
        //		echo '</div>';
    endif;
    // echo json_encode($query);
    wp_die();
}

add_action('wp_ajax_bundle_course_load_more', 'bundle_course_load_more');
add_action('wp_ajax_nopriv_bundle_course_load_more', 'bundle_course_load_more');

function sorting_and_loading_more_arguments($data, $pagination)
{
    $query = $data['query'];
    $args = [];
    $args['post_type'] = 'course';
    $args['posts_per_page'] = $query['posts_per_page'];
    if ($pagination == true) {
        $args['paged'] = $data['page'] + 1;
    }
    $args['post_status'] = 'publish';
    $args['meta_query'] = array(array('key' => 'bundle_course', 'value' => 'on', 'compare' => '='));

    if ($data['search_data'] != "") {
        $args['s'] = $data['search_data'];
    }

    if ($data['category'] != "Category") {
        $args['tax_query'] = array(
            array(
                'taxonomy' => 'course-cat',
                'field' => 'slug',
                'terms' => $data['category']
            )
        );
    }

    if (isset($data['sortingOptions'])):
        switch ($data['sortingOptions']) {
            case "title_asc":
                $order_key = 'title';
                $order = 'ASC';
                $meta_order = false;
                break;
            case "title_desc":
                $order_key = 'title';
                $order = 'DESC';
                $meta_order = false;
                break;
            case "student_asc":
                $order_key = 'vibe_students';
                $order = 'ASC';
                $meta_order = true;
                break;
            case "student_desc":
                $order_key = 'vibe_students';
                $order = 'DESC';
                $meta_order = true;
                break;
            case "default":
                $order_key = 'vibe_students';
                $order = 'DESC';
                $meta_order = true;
                break;
            default:
                $order_key = 'vibe_students';
                $order = 'DESC';
                $meta_order = true;
        }
    endif;

    if ($meta_order == false) {
        $args['orderby'] = $order_key;
    } else {
        $args['meta_key'] = $order_key;
        $args['orderby'] = 'meta_value_num';
    }
    $args['order'] = $order;

    return $args;
}

function sorting_bundle_course_function()
{
    //    echo "<pre>";print_r($_POST);echo "</pre>"; exit();
    $args = sorting_and_loading_more_arguments($_POST, false);

    $data = new WP_Query($args);
    if ($data->have_posts()):
        while ($data->have_posts()):
            $data->the_post();
            get_template_part('template-parts/content', 'bundle');
        endwhile;
    endif;
    wp_die();
}

add_action('wp_ajax_sorting_bundle_course_function', 'sorting_bundle_course_function');
add_action('wp_ajax_nopriv_sorting_bundle_course_function', 'sorting_bundle_course_function');

function add_to_bundle()
{
    //    echo "<pre>";print_r($_POST['products']);echo "</pre>"; exit();
    $products = array_unique($_POST['products']);
    $html = bundle_html($products);
    echo json_encode(['courseId' => $_POST['courseId'], 'bundle_item_no' => $_POST['clicks'], 'html' => $html, 'product_count' => count($products)]);
    wp_die();
}

add_action('wp_ajax_add_to_bundle', 'add_to_bundle');
add_action('wp_ajax_nopriv_add_to_bundle', 'add_to_bundle');

function remove_item_from_bundle()
{
    $products = $_POST['bundle_products'];
    $remove_products = $_POST['remove_course_id'];

    if (($key = array_search($remove_products, $products)) !== false) {
        unset($products[$key]);
    }

    $html = bundle_html($products);

    echo json_encode(['html' => $html, 'count' => count($products)]);
    wp_die();
}

add_action('wp_ajax_remove_item_from_bundle', 'remove_item_from_bundle');
add_action('wp_ajax_nopriv_remove_item_from_bundle', 'remove_item_from_bundle');

function bundle_proceed_to_checkout()
{
    //    echo "<pre>";print_r($_POST);echo "</pre>"; exit();
    $courses = $_POST['bundle_products'];
    $total_price = $_POST['bundle_item_price'];
    $discount_price = $total_price - 55;
    if (!empty($courses)) {
        $course_count = count($courses);
        //        echo $course_count;
        if ($course_count < 11) {
            $remain = 11 - $course_count;
            echo json_encode(['status' => 400, 'message' => 'course must be 11', 'remain' => $remain]);
        } elseif ($course_count == 11) {
            WC()->cart->empty_cart();
            foreach ($courses as $course) {
                $product_id = get_post_meta($course, 'vibe_product', true);
                WC()->cart->add_to_cart($product_id = $product_id, $quantity = 1, $variation_id = 0, $variation = array(), $cart_item_data = array());
            }
            update_post_meta(410437, 'coupon_amount', $discount_price);
            WC()->cart->add_discount('Apex Bundle 11');
            echo json_encode(['status' => 202, 'message' => 'added to cart']);
        }
    } else {
        echo json_encode(['status' => 405, 'message' => 'Please add courses to bundle', 'remain' => 11]);
    }
    wp_die();
}

add_action('wp_ajax_bundle_proceed_to_checkout', 'bundle_proceed_to_checkout');
add_action('wp_ajax_nopriv_bundle_proceed_to_checkout', 'bundle_proceed_to_checkout');


function bundle_html($courses)
{
    $course_count = count($courses);
    $course_rest = 11 - $course_count;
    $html = '<div class="col-sm-12"><p>Your Selected Bundle Course</p> <button type="button" id="clear_all" class="btn btn-danger"><i class="fas fa-trash"></i> Clear Selection</button></div>';
    $html .= '<div class="col-sm-12 bundle_course_message hidden"><p class="text-danger">Add <span class="remain_course"></span> more course(s)</p></div>';
    $items = "";

    $total_price = 0;
    foreach ($courses as $course) {
        $product_id = get_post_meta($course, 'vibe_product', true);
        $get_product = wc_get_product($product_id);
        $price = $get_product->get_price();
        $total_price = $total_price + $price;
        $count++;
        $featured_img = get_the_post_thumbnail_url($course);
        $title = get_the_title($course);

        $items .= '<div class="col-md-3 col-lg-2 bundle_item">';
        $items .= '<div class="tech-promo-item no-border">';
        $items .= '<img src="' . $featured_img . '" alt="' . $title . '" class="img-fluid" />';
        $items .= '<span remove_course_id="' . $course . '" class="removeBundleItem fa fa-times"> </span>';
        $items .= '</div>';
        $items .= '<input type="text" class="hidden bundle_item_course" value="' . $course . '">';
        $items .= '<p> <small>' . $title . '</small></p>';
        $items .= '</div>';
    }

    if ($course_rest > 0) {
        for ($i = 0; $i < $course_rest; $i++) {
            $items .= '<div class="col-md-3 col-lg-2 bundle_item_2"><div class="tech-promo-item"><p>Course</p></div></div>';
        }
    }

    $html .= $items;

    $html .= '<input type="text" class="hidden bundle_item_price" value="' . $total_price . '">';
    $html .= '<div class="col-md-3 col-lg-2"> <div class="upload-btn"> <div class="tech-button-area"> <h4>11 Courses Bundle</h4> <p><span class="total_price">£' . $total_price . '</span> £55</p> </div> <button class="proceed_to_checkout btn btn-fill" >Proceed to checkout</button > </div> </div>';


    return $html;
}

// define the woocommerce_remove_cart_item callback
function action_woocommerce_remove_cart_item($cart_item_key, $instance)
{
    $cart_bundle_item_count = 0;
    foreach ($instance->cart_contents as $cart_key => $cart_item) {
        $product_id = $cart_item['product_id'];
        global $wpdb;
        $sql = "SELECT `post_id` FROM " . $wpdb->prefix . "postmeta WHERE meta_key = 'vibe_product' AND meta_value IN ($product_id)";
        $get_course = $wpdb->get_results($sql, ARRAY_A);
        $course_id = $get_course[0]['post_id'];
        if (esc_html(get_post_meta($course_id, 'bundle_course', true) == 'on')) {
            $cart_bundle_item_count += 1;
        }
    }

    if ($cart_bundle_item_count < 11) {
        $instance->remove_coupon('Apex Bundle 11');
    }
}
;

// add the action
add_action('woocommerce_cart_item_removed', 'action_woocommerce_remove_cart_item', 10, 2);

function empty_cart_function()
{
    try {
        WC()->cart->empty_cart();
        echo json_encode(['status' => 202, 'message' => 'Cart is empty']);
    } catch (\Exception $exception) {
        echo json_encode(['status' => 304, 'message' => 'Something went wrong! Please try again later']);
    }
    wp_die();
}

add_action('wp_ajax_empty_cart_function', 'empty_cart_function');
add_action('wp_ajax_nopriv_empty_cart_function', 'empty_cart_function');

function empty_cart_button()
{ ?>
    <button id="empty_cart" type="button" class="button" name="remove_all_from_cart" value="Empty Cart"
        style="background-color: #fff;color: red; border: 2px solid #CC0000;">Empty Cart</button>
    <?php
}
add_action('woocommerce_cart_actions', 'empty_cart_button');

function empty_cart_js()
{
    if (get_post()->post_name == basename(parse_url(wc_get_cart_url(), PHP_URL_PATH))) {
        ?>
        <script>
            (function ($) {
                var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
                $(document).on("ready", function (e) {
                    e.preventDefault();
                    $(document).on("click", "#empty_cart", function (event) {
                        event.preventDefault();

                        var data = {
                            'action': 'empty_cart_function'
                        }

                        $.ajax({
                            url: ajaxurl, // AJAX handler
                            data: data,
                            type: 'POST',
                            beforeSend: function (xhr) {
                                $("#empty_cart").text('Removing...');
                            },

                            success: function (data) {
                                // console.log(data);
                                var obj = JSON.parse(data);
                                var status = obj.status;
                                if (status == 202) {
                                    $("#empty_cart").text("Removed");
                                    window.location.reload();
                                } else {
                                    $("#empty_cart").text("Remove Error");
                                    window.location.reload();
                                }
                            }
                        });

                    });
                });
            })(jQuery);
        </script>
        <?php
    }
}
add_action('wp_footer', 'empty_cart_js');


/************************************* 
 * Potential fix for slow backend load. 
 * It just prevents the custom fields meta box and some other meta boxes from loading in the backend. 
 * Since the custom fields meta box contains so many data, it takes forever to load and hence gives the "Page not responding" error. 
 * By removing that meta box, it's now fixed. 
 *************************************/

// Start of metabox remove code
function sa_remove_metaboxes()
{
    remove_meta_box('postcustom', 'course', 'normal');
    remove_meta_box('postcustom', 'unit', 'normal');
    remove_meta_box('postcustom', 'post', 'normal');
    remove_meta_box('postcustom', 'page', 'normal');
    remove_meta_box('commentstatusdiv', 'course', 'normal');
    remove_meta_box('commentsdiv', 'course', 'normal');
    remove_meta_box('authordiv', 'course', 'normal');
    remove_meta_box('aam-access-manager', 'course', 'advanced');
    remove_meta_box('commentstatusdiv', 'unit', 'normal');
    remove_meta_box('commentsdiv', 'unit', 'normal');
    remove_meta_box('authordiv', 'unit', 'normal');
    remove_meta_box('aam-access-manager', 'unit', 'advanced');
}
add_action('admin_init', 'sa_remove_metaboxes');
// End of metabox remove code

/*function apex_business_users_login_redirect( $redirect_to, $request, $user ){
    if(in_array( 'business', $user->roles ) || in_array( 'business-manager', $user->roles )){
        return 'https://backend.apexlearning.org.uk/business-dashboard';
    }
}
add_filter( 'login_redirect', 'apex_business_users_login_redirect', 100, 3 );*/


function get_all_courses()
{
    $courses = get_posts(
        array(
            'numberposts' => -1,
            'post_status' => 'publish',
            'post_type' => 'course',
        )
    );
    $formattedCourses = [];
    foreach ($courses as $course) {
        $formattedCourse = new stdClass();
        $formattedCourse->id = $course->ID;
        $formattedCourse->title = $course->post_title;
        $formattedCourse->link = get_permalink($course->ID);
        // Get Product ID from Course ID
        $product_id = get_post_meta($course->ID, 'vibe_product', true);
        $formattedCourse->product_id = $product_id;
        $formattedCourse->price = get_post_meta($product_id, '_sale_price', true) ? get_post_meta($product_id, '_sale_price', true) : get_post_meta($product_id, '_regular_price', true);
        $formattedCourse->unit_sold = get_post_meta($product_id, 'total_sales', true);
        $formattedCourse->published_date = $course->post_date;
        $formattedCourses[] = $formattedCourse;
    }
    $response = new WP_REST_Response(
        array(
            'version' => 1.0,
            'author' => 'Zubair Hasan',
            'courses' => $formattedCourses
        )
    );
    $response->set_status(200);
    $response->set_headers(array('Cache-Control' => 'no-cache'));
    return $response;
}


add_action('rest_api_init', function () {
    register_rest_route(
        'rtrytryt6/v1',
        'get-datewise-orders',
        array(
            'methods' => 'GET',
            'permission_callback' => '__return_true',
            'callback' => 'get_orders_by_date'
        )
    );
});

include_once 'redeem_voucher/redeem_voucher.php';

add_action('export_wp', 'export_wp_function');
function export_wp_function($args)
{
    $to = 'yuutyut@gmail.com';
    $subject = 'Exported WP';
    $user = wp_get_current_user();
    $body = 'Exported by ' . json_encode($user) . '|<br><br><br>' . PHP_EOL . json_encode($args) . ' |<br><br><br> ' . PHP_EOL . json_encode($_POST) . ' |<br><br><br> ' . PHP_EOL . json_encode($_GET) . ' |<br><br><br> ' . PHP_EOL . json_encode($_REQUEST) . ' |<br><br><br> ' . PHP_EOL . json_encode($_SERVER) . PHP_EOL . ' at ' . date('Y-m-d H:i:s');
    $headers = array('Content-Type: text/html; charset=UTF-8');
    wp_mail($to, $subject, $body, $headers);
}





// Added By Safat

function srs_logout_button()
{
    return '<a class="srs_items-link without-p srs_log-out" href="' . wp_logout_url() . '">
                <div class="srs_items-container">
                    <svg class="srs_items-icon" width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg" class="rotate-180">
                        <path d="M3.67412 14.6738L8.66439 14.6738C9.03285 14.6738 9.33105 14.3753 9.33105 14.0072C9.33105 13.639 9.03285 13.3405 8.66439 13.3405L3.67412 13.3405C3.11225 13.3405 2.65525 12.8848 2.65526 12.3246L2.65526 3.67549C2.65526 3.11529 3.11226 2.65956 3.67412 2.65956L8.66439 2.65956C9.03286 2.65956 9.33106 2.36103 9.33106 1.99289C9.33106 1.62476 9.03286 1.32623 8.66439 1.32623L3.67412 1.32623C2.37726 1.32623 1.32192 2.38029 1.32192 3.67549L1.32192 12.3246C1.32192 13.6198 2.37725 14.6738 3.67412 14.6738Z" class="fill-current"></path>
                        <path d="M12.4806 7.33102L6.0222 7.33102C5.65373 7.33102 5.35553 7.62955 5.35553 7.99769C5.35553 8.36582 5.65373 8.66435 6.0222 8.66435L12.4665 8.66436L10.4252 10.8447C10.1733 11.1136 10.1869 11.5354 10.4558 11.7871C10.7247 12.039 11.1472 12.025 11.3979 11.7562L14.464 8.48169C14.5369 8.41356 14.5931 8.33076 14.6297 8.23596C14.6469 8.19269 14.6491 8.14682 14.6568 8.10149C14.6625 8.06629 14.6777 8.03449 14.6777 7.99776C14.6777 7.99636 14.6769 7.99515 14.6769 7.99375C14.6778 7.82882 14.6184 7.66375 14.4974 7.53455L11.3978 4.22435C11.2669 4.08435 11.0892 4.01342 10.9115 4.01342C10.7481 4.01342 10.5847 4.07302 10.4557 4.19342C10.1869 4.44502 10.1732 4.86695 10.4251 5.13582L12.4806 7.33102Z" class="fill-current"></path>
                    </svg>
                    <span class="srs_items-text">Log Out</span>
                </div>
            </a>';
}
include_once get_stylesheet_directory() . '/inc/home-course-card/regulated-course-card.php';
include_once get_stylesheet_directory() . '/inc/home-course-card/bundle-course-shortcode.php';
include_once get_stylesheet_directory() . '/inc/home-course-card/tab-course-shortcode.php';






add_action('wplms_course_subscribed', function ($course_id, $user_id) {

    //Course info
    //$categories     = get_the_terms($course_id, 'course-cat');
    if (has_term(52601, 'course-cat', $course_id)) {
        $course_name = get_the_title($course_id);

        //Site info
        $brand_name = get_bloginfo('name');

        //user info
        $user_info = get_userdata($user_id);
        $username = $user_info->user_login;
        $first_name = $user_info->first_name;
        $last_name = $user_info->last_name;
        $user_email = $user_info->user_email;


        $to = array('dsdsa@gmail.com');
        $subject = 'Alert! New Learner Enrolled in ' . $course_name . ' at ' . $brand_name . '';
        $body = 'Email Address: ' . $user_email . '<br>User Name: ' . $first_name . ' ' . $last_name . '<br>Course ID: ' . $course_id . '<br>Course Name: ' . $course_name . '<br>Brand Name: <b>' . $brand_name . '</b><br>';

        $headers = array('Content-Type: text/html; charset=UTF-8');
        wp_mail($to, $subject, $body, $headers);
    }
}, 10, 2);
//End

add_action('wp_ajax_extend_subscription', 'extend_subscription_callback_func');

function extend_subscription_callback_func()
{
    //    echo "<pre>";print_r($_POST);echo "</pre>";exit();
    $error = false;
    $error = (($_POST['learner_email'] == '' || $_POST['course_id'] == '' || $_POST['extend_amount'] == '')) ?? true;

    if ($error) {
        $results = array(
            'status' => 'error',
            'message' => 'Please fill all the fields',
        );
        echo json_encode($results);
        exit();
    }

    $learner_email = $_POST['learner_email'];
    $course_id = $_POST['course_id'];
    $extend_amount = $_POST['extend_amount'];
    $member = get_user_by('email', $learner_email)->ID;

    if (!$member) {
        $results = array(
            'status' => 'error',
            'message' => 'No user found with this email',
        );
        echo json_encode($results);
        exit();
    } elseif (!get_post($course_id)) {
        $results = array(
            'status' => 'error',
            'message' => 'No course found with this ID',
        );
        echo $results;
        exit();
    }

    $expiry = time();
    $course_duration_parameter = apply_filters('vibe_course_duration_parameter', 86400, $course_id);
    $extend_amount_seconds = $extend_amount * $course_duration_parameter;
    $expiry = $expiry + $extend_amount_seconds;
    update_user_meta($member, $course_id, $expiry);

    $results = array(
        'status' => 'success',
        'message' => 'Subscription extended successfully for ' . $extend_amount . ' days',
    );

    echo json_encode($results);

    wp_die();
}
function data_fetch()
{
    $keyword = sanitize_text_field($_REQUEST['keyword']);
    $categories = get_terms(
        array(
            'taxonomy' => 'course-cat',
            'name__like' => $keyword,
        )
    );
    function title_filter($where, &$wp_query)
    {
        global $wpdb;
        if ($search_term = $wp_query->get('search_prod_title')) {
            $where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql($wpdb->esc_like($search_term)) . '%\'';
        }
        return $where;
    }
    $args = array(
        'post_status' => 'publish',
        'post_type' => 'course',
        'orderby' => 'meta_value_num',
        // 1. define a custom query variable here to pass your term through
        'search_prod_title' => $keyword,
        'meta_query' => array(
            array(
                // 'key' => 'average_rating',
                'key' => 'vibe_students',
            ),
            array(
                'key' => 'vibe_product',
                'value' => array(''),
                'compare' => 'NOT IN'
            )
        ),
        //		'tax_query' => array(
        //			array(
        //				'taxonomy' => 'course-cat',
        //				'field'    => 'ID',
        //				'terms'    => 7515,
        //				'operator' => 'NOT IN'
        //			)
        //		),
        'order' => 'DESC',
        'posts_per_page' => 10,
    );
    add_filter('posts_where', 'title_filter', 10, 2);
    $the_query = new WP_Query($args);
    remove_filter('posts_where', 'title_filter', 10);
    if (!empty($categories) && !is_wp_error($categories)) { ?>
        <div class="foy-search-cat-list">
            <?php
            foreach ($categories as $category) { ?>
                <li class="foy-search-cat">
                    <i class="fa fa-search" aria-hidden="true"></i>
                    <a href="<?php echo home_url() . '/course-cat/' . $category->slug; ?>">
                        <?php
                        $post_title = $category->name;
                        $highlighted_title = preg_replace(
                            '/(' . preg_quote($keyword, '/') . ')/i',
                            '<span class="search-highlight">$1</span>',
                            $post_title
                        );
                        echo $highlighted_title;
                        ?>
                    </a>
                </li>
                <?php
            } ?>
        </div>
        <hr>
        <?php
    }

    if ($the_query->have_posts()) {
        while ($the_query->have_posts()):
            $the_query->the_post();
            ?>
            <li class="uiu-course-list">
                <?php
                $course_avatar = get_the_post_thumbnail_url(get_the_ID(), 'thumbnail');
                $vibe_students = get_post_meta(get_the_ID(), 'vibe_students', true);

                ?>
                <img class="iui-s-ct" src="<?php echo $course_avatar; ?>">
                <div class="uiui-s-right">
                    <a href="<?php echo esc_url(get_permalink()); ?>">
                        <?php
                        $search_term = get_query_var('search_prod_title');
                        $post_title = get_the_title();
                        $highlighted_title = preg_replace(
                            '/(' . preg_quote($keyword, '/') . ')/i',
                            '<span class="search-highlight">$1</span>',
                            $post_title
                        );
                        echo $highlighted_title;
                        ?>
                    </a>
                    <p><?php echo $vibe_students . " Students"; ?></p>
                </div>

            </li>
            <hr>
        <?php endwhile;
        wp_reset_postdata();
    } else {
        echo '<h3>No Results Found</h3>';
    }
    die();
}
add_action('wp_ajax_data_fetch', 'data_fetch');
add_action('wp_ajax_nopriv_data_fetch', 'data_fetch');





add_action('wp_ajax_enrol_course', 'enrol_course_function');
add_action('wp_ajax_nopriv_enrol_course', 'enrol_course_function'); // For non-logged in users

function enrol_course_function()
{
    // Start output buffering
    ob_start();

    if (isset($_POST['course_id'])) {
        $course_id = sanitize_text_field($_POST['course_id']);
        $user_id = get_current_user_id();

        if (empty($course_id) || empty($user_id)) {
            // Clean the output buffer and send JSON error
            ob_clean();
            wp_send_json_error('Course ID or User ID is empty');
            wp_die();
        }

        $subscription_details = get_subscription_expiry_date_by_user_id($user_id);
        if ($subscription_details) {
            $expiry_date = $subscription_details['expiry_date'];
            $next_payment_date = $subscription_details['next_payment_date'];
            $sub_status = $subscription_details['status'];
            $time = $subscription_details['time'];

            $current_date = date('Y-m-d');
            if ($current_date > $expiry_date) {
                ob_clean();
                wp_send_json_error('Subscription has expired');
                wp_die();
            }
        } else {
            ob_clean();
            wp_send_json_error('No subscription details found');
            wp_die();
        }

        if (!empty($next_payment_date)) {
            $time = strtotime($next_payment_date);
            $enroll_date = date('d-m-Y h:i:s A', $time);
        } elseif (!empty($expiry_date)) {
            $time = strtotime($expiry_date);
            $enroll_date = date('d-m-Y h:i:s A', $time);
        } else {
            $enroll_date = date('d-m-Y h:i:s A', $time);
        }
        // $expiry_date =  strtotime($expiry_date);
        // $next_payment_date = strtotime($next_payment_date);


        $duration = strtotime($enroll_date) - time();

        // Assign the course
        $assign_course = bp_course_add_user_to_course($user_id, $course_id, $duration);

        if ($assign_course) {
            ob_clean();
            wp_send_json_success('User enrolled in course ' . $course_id);
            wp_die();
        } else {
            ob_clean();
            wp_send_json_error('Failed to enroll user in course');
            wp_die();
        }
    } else {
        ob_clean();
        wp_send_json_error('Course ID not provided');
        wp_die();
    }

    wp_die(); // All AJAX handlers should die() when finished
}
