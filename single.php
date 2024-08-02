<?php

if (!defined('ABSPATH'))
    exit;

    function get_post_read_time($post_id = null) {
    
        $post_id = $post_id ? $post_id : get_the_ID();
        $content = get_post_field('post_content', $post_id);
    
        $word_count = str_word_count(strip_tags($content));
    
        $reading_speed = 200;
    
        $reading_time = ceil($word_count / $reading_speed);
    
        return $reading_time . ' minutes read';
    }

get_header(vibe_get_header());

if (have_posts()):
    while (have_posts()):
        the_post();
        ?>

        <div class="r4h-apex-single-blog">
            <section class="hero-rh">
                <div class="rh-content">
                    <div class="hero-container">
                        <div class="text-part">
                            <div class="read-time-type">
                                <?php
                                $categories = get_the_category();
                                if (!empty($categories)) {
                                    $first_category = $categories[0];
                                    ?>
                                    <a class="cate" href="<?php echo get_category_link($first_category->term_id); ?>">
                                        <?php echo esc_html($first_category->cat_name); ?>
                                    </a>
                                    <?php
                                }
                                ?>
                                <span class="timing">
                                <?php echo get_post_read_time(); ?>
                                </span>
                            </div>
                            <h3 class="title"><?php the_title(); ?></h3>
                            <div class="excrpt">
                                <?php the_excerpt(); ?>
                            </div>
                            <div class="author">
                                <?php
                                function getFirstTwoLetters($full)
                                {
                                    $words = explode(' ', $full);

                                    $firstLetter = substr($words[0], 0, 1);

                                    if (count($words) > 1) {
                                        $secondLetter = substr($words[1], 0, 1);
                                        return $firstLetter . $secondLetter;
                                    } else {
                                        return $firstLetter;
                                    }
                                }

                                $full = get_the_author();
                                $two_letter = getFirstTwoLetters($full);
                                ?>
                                <div class="author-image">
                                    <span><?php echo $two_letter; ?></span>
                                </div>
                                <div class="author-name-date">
                                    <p class="name"><?php the_author(); ?></p>
                                    <p class="date">Published <?php echo the_modified_date(); ?></p>
                                </div>
                            </div>
                        </div>
                        <?php if (has_post_thumbnail()) { ?>
                            <div class="image">
                                <?php the_post_thumbnail(get_the_ID(), 'full'); ?>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="arrow-rh">
                            <img src="<?php echo get_theme_file_uri() . '/assets/images/single-blog/hand-drawn-arrow.svg' ?>"
                                alt="arrow">
                        </div>
                    </div>
                </div>
            </section>
            <section class="main-section-rh">
                <div class="rh-content">
                    <div class="main-container">
                        <div class="row contents-rh">
                            <div class="col-md-3 left-bottom">
                                <hr>
                                <div class="social_sharing social-links-rh">
                                    <?php
                                    if (function_exists('social_sharing'))
                                        echo social_sharing();
                                    ?>
                                </div>
                            </div>
                            <div class="col-md-9 second-bottom">
                                <div class="editabl-contents">
                                    <?php
                                    the_content();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
    endwhile;
endif;
?>
    <section class="latest-section-rh">
        <div class="rh-content">
            <div class="latest-blog-container">
                <div class="title-rh">
                    <div class="texts">
                        <p>Our Blogs</p>
                        <h3>
                            Latest blog posts
                        </h3>
                        <h6>
                            Tool and strategies modern teams need to help their companies grow.
                        </h6>
                    </div>
                    <div class="btnn">
                        <a href="/blog/" class="view-blog">View all posts</a>
                    </div>
                </div>
                <div class="all-blogs-container">
                    <?php

                    $args = array(
                        'posts_per_page' => 3,
                        'post_type' => 'post',
                        'post_status' => 'publish',
                        'ignore_sticky_posts' => true,
                    );
                    $single_post_query = new WP_Query($args);

                    if ($single_post_query->have_posts()):
                        while ($single_post_query->have_posts()):
                            $single_post_query->the_post();
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
                                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24"
                                                    viewBox="0 0 25 24" fill="none">
                                                    <path d="M7.33334 17L17.3333 7M17.3333 7H7.33334M17.3333 7V17"
                                                        stroke="#18181b" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round"></path>
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
            </div>
        </div>
    </section>
</div>
<?php
get_footer(vibe_get_footer());
?>