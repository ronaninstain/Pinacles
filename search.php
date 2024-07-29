<?php
if (isset($_GET["post_type"]) && $_GET["post_type"] == 'course') {
    if (file_exists(get_stylesheet_directory() . '/search-incourse.php')) {
        load_template(get_stylesheet_directory() . '/search-incourse.php');
        exit();
    }
    if (file_exists(get_template_directory() . '/search-incourse.php')) {
        load_template(get_template_directory() . '/search-incourse.php');
        exit();
    }
}

get_header(vibe_get_header());
global $wp_query;
$total_results = $wp_query->found_posts;
?>

<h1>Search Results</h1>
<section id="title">
    <?php do_action('wplms_before_title'); ?>
    <div class="<?php echo vibe_get_container(); ?>">
        <div class="row">
            <div class="col-md-12">
                <div class="pagetitle">
                    <?php vibe_breadcrumbs(); ?>
                    <h1><?php _e('Search Results for "', 'vibe');
                    the_search_query(); ?>"</h1>
                    <h5><?php echo vibe_sanitizer($total_results) . __(' results found', 'vibe'); ?></h5>
                </div>
            </div>
        </div>
    </div>
</section>


<?php
if (have_posts()):
    ?>
    <div class="r4h-apex-blog-page">
        <section class="all-blogs">
            <div class="rh-content">
                <div class="all-blogs-container">
                    <?php
                    while (have_posts()):
                        the_post();
                        ?>
                        <!-- blog post card common start -->
                        <div class="blog-post-card-rh">
                            <div class="card-img-rh">
                                <?php if (has_post_thumbnail()) { ?>
                                    <img src="<?php the_post_thumbnail_url('medium_large'); ?>" alt="<?php the_title(); ?>" />
                                <?php } ?>
                            </div>
                            <div class="blog-info-rh">
                                <div class="info">
                                    <div class="author-date">
                                        <div class="author-name">
                                            <span><?php echo get_the_author(); ?></span>
                                        </div>
                                        •
                                        <div class="published-date">
                                            <span><?php echo get_the_date(); ?></span>
                                        </div>
                                    </div>
                                    <div class="title-link">
                                        <a href="<?php the_permalink(); ?>">
                                            <span><?php the_title(); ?></span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24"
                                                fill="none">
                                                <path d="M7.33334 17L17.3333 7M17.3333 7H7.33334M17.3333 7V17" stroke="#18181b"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
                                            </svg>
                                        </a>
                                    </div>
                                    <div class="detail">
                                        <span><?php the_excerpt(); ?></span>
                                    </div>
                                </div>
                                <div class="blog-tags-rh">
                                    <?php
                                    $categories = get_the_category();
                                    foreach ($categories as $category) {
                                        ?>
                                        <a
                                            href="<?php echo get_category_link($category->term_id); ?>"><?php echo $category->cat_name; ?></a>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- blog post card common end -->
                        <?php
                    endwhile;
                    ?>
                </div>
            </div>
        </section>
    </div>


    <?php
else:
    echo '<h3>' . __('Sorry, No results found.', 'vibe') . '</h3>';
endif;

// Pagination
$pagination_args = array(
    'prev_text' => __('« Previous', 'vibe'),
    'next_text' => __('Next »', 'vibe'),
);
echo paginate_links($pagination_args);
?>


<?php get_footer(vibe_get_footer()); ?>