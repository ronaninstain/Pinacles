<?php
if (!defined('ABSPATH'))
    exit;

$courseID = get_the_ID();

function createMultidimensionalArray($courseID)
{
    $curriculums = bp_course_get_curriculum($courseID);
    $resultArray = array();
    $currentParent = null;

    foreach ($curriculums as $item) {
        if (get_post_type($item) != 'unit') {
            $currentParent = $item;
            $resultArray[$currentParent] = array();
        } elseif ($currentParent !== null) {
            $resultArray[$currentParent][] = $item;
        }
    }
    return $resultArray;
}

$units = bp_course_get_curriculum_units($courseID);
$total_duration = 0;

foreach ($units as $unit) {
    $duration = get_post_meta($unit, 'vibe_duration', true);
    $duration = empty($duration) ? 0 : $duration;

    $unit_duration_parameter = (get_post_type($unit) == 'unit')
        ? apply_filters('vibe_unit_duration_parameter', 60, $unit)
        : apply_filters('vibe_quiz_duration_parameter', 60, $unit);

    $total_duration += $duration * $unit_duration_parameter;
}

$courseDuration = tofriendlytime(($total_duration));

$multidimensionalArray = createMultidimensionalArray($courseID);
$sectionCount = count($multidimensionalArray);

$average_rating = get_post_meta($courseID, 'average_rating', true);
$countRating = get_post_meta($courseID, 'rating_count', true);

$args = array(
    'post_id' => $courseID,
    'status' => 'approve',
);
$comments = get_comments($args);
?>

<div class="col-md-8">
    <div class="adminBarApex">

        <?php
        // $user = wp_get_current_user();
        $roles = (array) $user->roles;

        // var_dump($roles );
        $notAllowedRoles = array('Subscriber', 'Student');

        if (is_user_logged_in()) {
            if (!in_array($user->roles, $notAllowedRoles)) {
                ?>
                <section class="adminbar-23-iBeauty">
                    <div class="item-nav">
                        <div class="item-list-tabs no-ajax" id="object-nav" role="navigation">
                            <div id="item-body">
                                <!-- Admin nav start -->
                                <?php bp_get_options_nav(); ?>
                                <?php
                                if (function_exists('bp_course_nav_menu'))
                                    bp_course_nav_menu();
                                ?>
                                <?php do_action('bp_course_options_nav'); ?>
                                <!-- Admin nav end -->
                            </div>
                        </div>
                    </div>
                </section>
                <?php
            }
        }
        ?>
    </div>
    <div class="theContentBox">
        <?php the_content(); ?>
    </div>
     <!-- The collapse div button  -->
    <button class="theContentBoxButton" id="theContentBoxToggle">Show More</button>
     <!-- The collapse div button  -->
    <div class="theCurriculumnBox">
        <h2>Course Curriculum</h2>
        <div class="miniInformations">
            <ul>
                <li><?php echo $sectionCount; ?> section<?php echo ($sectionCount > 1) ? 's' : ''; ?></li>
                <li><?php echo count($units); ?> lecture<?php echo (count($units) > 1) ? 's' : ''; ?></li>
                <li><?php echo $courseDuration; ?> total length</li>
            </ul>
            <a href="javascript:void(0);" id="expandAllSections">Expand all sections</a>
        </div>
        <div class="panel-group" id="accordion">
            <?php
            $id = 1;
            foreach ($multidimensionalArray as $key => $item) {
                ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $id; ?>"
                            aria-expanded="<?php echo ($id == 1) ? 'true' : 'false'; ?>"
                            class="<?php echo ($id == 1) ? '' : 'collapsed'; ?>">
                            <h4 class="panel-title">
                                <?php echo $key; ?>
                            </h4>
                        </a>
                    </div>
                    <div id="collapse<?php echo $id; ?>"
                        class="panel-collapse <?php echo ($id == 1) ? 'collapse in' : 'collapse'; ?>"
                        aria-expanded="<?php echo ($id == 1) ? 'true' : 'false'; ?>">
                        <div class="panel-body">
                            <ul>
                                <?php
                                foreach ($item as $i) {
                                    ?>
                                    <li>
                                        <div class="videoTitle">
                                            <img src="<?php echo get_stylesheet_directory_uri() . '/assets/img/video.svg'; ?>"
                                                alt="video">
                                            <?php echo get_the_title($i); ?>
                                        </div>
                                        <div class="videoDuration">
                                            <?php
                                            $curriculumnDuration = get_post_meta($i, 'vibe_duration', true);
                                            if (!empty($curriculumnDuration)) {
                                                $seconds = $curriculumnDuration * 60;
                                                $datetime = new DateTime("@$seconds");
                                                $timeFormat = $datetime->format('H:i:s');
                                                echo $timeFormat;
                                            }
                                            ?>
                                        </div>
                                    </li>
                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <?php
                $id++;
            }
            ?>
        </div>
    </div>
    <div class="theRelatedCoursesBox">
        <h2>
            Frequently Bought Together
        </h2>
        <?php echo do_shortcode('[courseCards]'); ?>
    </div>
    <div class="courseCommentBox">
        <h3 class="headingReview">
            <svg class="mr-1.5 text-warning-500" width="22" height="22" viewBox="0 0 24 24" fill="none"
                xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_1235_29014)">
                    <path
                        d="M23.79 9.87027L18.43 15.3603L19.69 23.1303C19.801 23.7503 19.128 24.2043 18.59 23.9103L12 20.2603V0.0302734C12.28 0.0302734 12.56 0.160273 12.68 0.430273L15.99 7.48027L23.36 8.60027C23.976 8.71027 24.203 9.43527 23.79 9.87027Z"
                        fill="currentColor"></path>
                    <path
                        d="M12 0.0302734V20.2603L5.40996 23.9103C4.88096 24.2073 4.19796 23.7573 4.30996 23.1303L5.56996 15.3603L0.20996 9.87027C-0.20304 9.43527 0.0229596 8.71027 0.63996 8.60027L8.00996 7.48027L11.32 0.430273C11.44 0.160273 11.72 0.0302734 12 0.0302734Z"
                        fill="currentColor"></path>
                </g>
                <defs>
                    <clipPath id="clip0_1235_29014">
                        <rect width="24" height="24" fill="white"></rect>
                    </clipPath>
                </defs>
            </svg>
            <?php echo $average_rating; ?> course rating -
            <?php echo $countRating . ' ' . ($countRating > 1 ? 'reviews' : 'review'); ?>
        </h3>
        <div class="theComments" id="theComments">
            <?php
            foreach ($comments as $index => $comment) {
                $displayClass = $index < 3 ? 'commentBox' : 'commentBox hidden';
                echo '<div class="' . $displayClass . '">';
                echo '<div class="commentAuthor">' . get_avatar($comment, 32) . '<span class="authorName">' . $comment->comment_author . '</span></div>';

                $rating = get_comment_meta($comment->comment_ID, 'rating', true);
                echo '<div class="ks-star-rating">';
                echo '<svg viewBox="0 0 1000 200" class="rating">';
                echo '<defs>';
                echo '<polygon id="star" points="100,0 131,66 200,76 150,128 162,200 100,166 38,200 50,128 0,76 69,66 "></polygon>';
                echo '<clipPath id="stars">';
                echo '<use xlink:href="#star"></use>';
                echo '<use xlink:href="#star" x="20%"></use>';
                echo '<use xlink:href="#star" x="40%"></use>';
                echo '<use xlink:href="#star" x="60%"></use>';
                echo '<use xlink:href="#star" x="80%"></use>';
                echo '</clipPath>';
                echo '</defs>';
                echo '<rect class="rating__background" clip-path="url(#stars)"></rect>';
                echo '<rect width="' . ($rating ? 20 * $rating : 0) . '%" class="rating__value" clip-path="url(#stars)"></rect>';
                echo '</svg>';
                echo '</div>';

                echo '<div class="commentContent">' . $comment->comment_content . '</div>';
                echo '</div>';
            }
            ?>
        </div>
        <?php if (count($comments) > 3): ?>
            <button class="loadMoreBtn" id="loadMoreBtn" onclick="loadMoreReviews()">Load more reviews</button>
        <?php endif; ?>
    </div>
</div>