<?php
if (!defined('ABSPATH'))
    exit;
get_header(vibe_get_header());
?>

<div class="r4h-apex-blog-page">
    <!-- hero section start -->
    <section class="hero-rh">
        <div class="rh-content">
            <div class="hero-container">
                <div class="text-part">
                    <h3 class="title">Where New Horizons Emerge</h3>
                    <p>
                        As a prominent online learning and teaching marketplace
                        platform, we invite you to delve into a selection of our highly
                        sought-after content, enabling you to embark on a journey of
                        discovery and acquire fresh knowledge.
                    </p>
                </div>
                <div class="image">
                    <img src="<?php echo site_url(); ?>/wp-content/uploads/2024/07/blog-hero.webp" alt="hero-img" />
                </div>
            </div>
        </div>
    </section>
    <!-- hero section end -->
    <!-- search bar start -->
    <section class="search-links">
        <div class="rh-content">
            <div class="form-links">
                <form action="<?php echo esc_url(home_url('/')); ?>" method="get" class="search-blogs">

                    <input placeholder="Enter your query for search blogs ..." type="text" class="search-blogs-input"
                        name="s" value="<?php echo get_search_query(); ?>" in />
                    <input type="hidden" name="post_type" value="post">

                </form>
                <button class="search-toggle">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" class="hidden" viewBox="0 0 24 24"
                        fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none"
                        class="block">
                        <g clip-path="url(#clip0_2209_3910)">
                            <path
                                d="M24.7681 22.9407L18.2449 16.56C19.7921 14.8039 20.7288 12.5192 20.7288 10.0245C20.7288 4.49697 16.1314 0 10.4803 0C4.82928 0 0.231812 4.49697 0.231812 10.0245C0.231812 15.552 4.82928 20.049 10.4803 20.049C13.0308 20.049 15.3665 19.1327 17.1619 17.6194L23.6852 24.0001L24.7681 22.9407ZM1.7634 10.0245C1.7634 5.32303 5.67379 1.49811 10.4803 1.49811C15.2868 1.49811 19.1972 5.32303 19.1972 10.0245C19.1972 14.726 15.2868 18.5509 10.4803 18.5509C5.67379 18.5509 1.7634 14.726 1.7634 10.0245Z"
                                fill="#fff"></path>
                        </g>
                        <defs>
                            <clipPath id="clip0_2209_3910">
                                <rect width="24.5363" height="24" fill="#fff" transform="translate(0.231812)">
                                </rect>
                            </clipPath>
                        </defs>
                    </svg>
                </button>

                <div class="linkss">
                    <?php
                    $categories = get_categories(
                        array(
                            'orderby' => 'name',
                            'order' => 'ASC',
                            'number' => 3,
                        )
                    );

                    foreach ($categories as $category) {
                        ?>
                        <a
                            href="<?php echo esc_url(get_category_link($category->term_id)); ?>"><?php echo esc_html($category->name); ?></a>
                        <?php
                    }
                    ?>
                </div>

            </div>
        </div>
    </section>
    <!-- search bar end -->
    <!-- featured post start -->
    <section class="features-post">
        <div class="rh-content">
            <h3 class="title">Featured Posts</h3>
            <div class="featured-post-container">
                <?php
                $args = array(
                    'posts_per_page' => 3,
                    'post__in' => get_option('sticky_posts'),
                );
                $x = 0;
                $else_count = 0;
                $query = new WP_Query($args);

                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        if ($x < 1) {
                            ?>
                            <!-- blog post card common start -->
                            <div class="blog-post-card-rh">
                                <div class="card-img-rh">
                                    <?php if (has_post_thumbnail()) { ?>
                                        <img src="<?php the_post_thumbnail('large'); ?>" alt="<?php the_title(); ?>" />
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
                                                <span> <?php the_title(); ?> </span>
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
                                        <?php $categories = get_the_category();
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
                        } else if ($else_count < 2) {
                            ?>
                                <div class="feature-post-card">
                                    <div class="card-img-rh">
                                    <?php if (has_post_thumbnail()) { ?>
                                            <img src="<?php the_post_thumbnail('medium_large'); ?>" alt="<?php the_title(); ?>" />
                                    <?php } ?>
                                    </div>
                                    <div class="blog-info-rh">
                                        <div class="info">
                                            <div class="author-date">
                                                <div class="author-name">
                                                    <span> <?php echo get_the_author(); ?> </span>
                                                </div>
                                                •
                                                <div class="published-date">
                                                    <span><?php echo get_the_date(); ?> </span>
                                                </div>
                                            </div>
                                            <div class="title-link">
                                                <a href="<?php the_permalink(); ?>" class="link">
                                                    <span>
                                                    <?php the_title(); ?>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="detail">
                                                <span><?php the_excerpt(); ?></span>
                                            </div>
                                        </div>
                                        <div class="blog-tags-rh">
                                        <?php $categories = get_the_category();
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
                                <?php
                                $else_count++;
                        }
                        $x++;
                    }
                    wp_reset_postdata();
                } else {
                    echo 'No sticky posts found.';
                }
                ?>
            </div>
        </div>
    </section>
    <!-- featured post end -->
    <!-- all blogs start -->
    <section class="all-blogs">
        <div class="rh-content">
            <h3 class="title">All blog posts</h3>
            <div class="all-blogs-container">
                <?php
                // Get an array of sticky posts
                $sticky_posts = get_option('sticky_posts');

                // Custom query to exclude sticky posts and handle pagination
                $paged = get_query_var('paged') ? get_query_var('paged') : 1;
                $args = array(
                    'post__not_in' => $sticky_posts,
                    'paged' => $paged,
                );
                $all_blogs_query = new WP_Query($args);

                if ($all_blogs_query->have_posts()):
                    while ($all_blogs_query->have_posts()):
                        $all_blogs_query->the_post();
                        ?>
                        <!-- blog post card common start -->
                        <div class="blog-post-card-rh">
                            <div class="card-img-rh">
                                <?php if (has_post_thumbnail()) { ?>
                                    <img src="<?php the_post_thumbnail('medium_large'); ?>" alt="<?php the_title(); ?>" />
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
                    
                else:
                    echo 'No posts found.';
                endif;

                // Restore original Post Data
                wp_reset_postdata();
                ?>
            </div>
    
                    <!-- Pagination -->
                    <div class="pagination">
                        <?php
                        echo paginate_links(
                            array(
                                'total' => $all_blogs_query->max_num_pages,
                                'current' => $paged,
                                'format' => '?paged=%#%',
                                'show_all' => false,
                                'type' => 'plain',
                                'end_size' => 2,
                                'mid_size' => 2,
                                'prev_next' => true,
                                'prev_text' => __('« Prev'),
                                'next_text' => __('Next »'),
                                'add_args' => false,
                                'add_fragment' => '',
                            )
                        );
                        ?>
                    </div>
                   
        </div>
    </section>
    <!-- all blogs end -->
</div>
<?php
get_footer(vibe_get_footer());
?>