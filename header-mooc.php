<?php
//Header File
if (!defined('ABSPATH')) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <?php
    wp_head();
    ?>
</head>

<body <?php body_class(); ?>>
    <div id="global" class="global">
        <?php
        get_template_part('mobile', 'sidebar');
        ?>
        <div class="pusher">
            <?php
            $fix = vibe_get_option('header_fix');
            ?>
            <?php
            //             $current_user = wp_get_current_user();
            //             $user_email = $current_user->user_email;
            // 	$allowed_email = 'shoivehossain@staffasia.org';
            // 	$allowed_email2 = 'sakibursafat@staffasia.org';
            // 	$allowed_email3 = 'Sakib@staffasia.org';
            // 	$allowed_email4 = 'hasanarif@staffasia.org';
            // 	$allowed_email5 = 'muhiburnabil@staffasia.org';
            // if (is_user_logged_in() && $user_email === $allowed_email || $user_email === $allowed_email2 || $user_email === $allowed_email3 || $user_email === $allowed_email4 || $user_email === $allowed_email5) {
            include_once get_stylesheet_directory() . '/inc/headers/updated-header.php'; 
// }
// else{
//     include_once get_stylesheet_directory() . '/inc/headers/old-header.php'; 
    
// }
    ?>
            <style>
                div#foy-search-suggestion {
                    width: 100%;
                    max-width: 582px;
                }
                form#header-search-form {
                    position: relative;
                    display: flex;
                }
                #foy-search-suggestion .autocomplete_field {
                    width: 75%;
                    padding: 10px;
                    margin: 0;
                    border-color: rgb(198 197 198);
                }
                #foy-search-suggestion #search_iconOne {
                    width: 25%;
                    padding: 0;
                    margin: 0;
                    background: rgb(0 55 139);
                }
                #search_iconOne .fa-search:before {
                    content: "\f002";
                    color: #ffffff;
                }
                /* for ajax search */
                .foy-suggestion-box {
                    position: absolute;
                    background: #ffffff;
                    max-width: 436px !important;
                    width: 100%;
                    padding: 15px;
                    border-radius: 8px;
                    box-shadow: rgb(0 0 0 / 16%) 0px 1px 4px;
                    display: none;
                    z-index: 999999;
                }

                .foy-search-suggestion .foy-course-list img {
                    height: 45px;
                    width: 60px;
                    border-radius: 3px;
                    margin-right: 5px;
                }

                .foy-suggestion-box hr {
                    margin-top: 10px !important;
                    margin-bottom: 10px !important;
                }

                .foy-suggestion-box hr:last-child {
                    display: none;
                }

                #foy-loading {
                    display: none;
                    background: #ffffff;
                    padding: 0;
                    position: absolute;
                    right: 50px;
                    top: 6px;
                }

                #foy-loading img {
                    height: 30px;
                    width: 30px;
                }

                .foy-suggestion-box h3 {
                    margin: 0px;
                    font-size: 12px;
                }

                #foy-search-suggestion .foy-course-list a {
                    padding: 0px !important;
                    font-size: 14px;
                    line-height: 22px;
                }

                #foy-search-suggestion .foy-course-list ul#menu-main-menu li a {
                    padding: 0px !important;
                }

                #foy-search-suggestion .foy-course-list {
                    align-items: center;
                    display: flex;
                    justify-content: start;
                }

                .search-highlight {
                    color: #337ab7;
                }

                .foy-search-cat {
                    align-items: center;
                    display: flex;
                    justify-content: start;
                    gap: 10px;
                    s
                }
                img.foy-s-ct {
                    width: 3rem;
                    border-radius: 2px;
                }
                .foy-s-right {
                    margin-left: 10px;
                }
                .foy-s-right a {
                    display: -webkit-box;
                    -webkit-line-clamp: 1;
                    -webkit-box-orient: vertical;
                    overflow: hidden;
                    font-size: .875rem;
                    font-weight: 700;
                    line-height: 1.25rem;
                }
                .foy-s-right p {
                    margin: 0;
                    font-weight: 300;
                    color: rgb(118 116 118);
                }
            </style>
            <script type="text/javascript">
                jQuery(document).ready(function($) {
                    function foyFunction() {
                        const navSearch = $(this).closest('#foy-search-suggestion');
                        const suggestionBox = navSearch.find('.foy-suggestion-box');
                        let loader = navSearch.find('#foy-loading');
                        const keyword = $(this).val();
                        if (keyword.length < 4) {
                            if (suggestionBox) {
                                suggestionBox.remove();
                            }
                            if (loader) {
                                loader.remove();
                            }
                        } else {
                            if (!suggestionBox.length) {
                                navSearch.append('<div class="foy-suggestion-box" id="foy-suggestion-box"><!-- course suggestion --></div>');
                            }
                            if (!loader.length) {
                                const input = navSearch.find('input[name="s"]');
                                loader = $('<div>', {
                                    id: 'foy-loading',
                                    class: 'spinner-border',
                                    role: 'status'
                                })
                                    .html('<img src="https://adamsfc1.wpenginepowered.com/wp-content/themes/wplmsblankchildhtheme/assets/images/loader.webp" alt="search loader">');
                                input.after(loader);
                            }
                            loader.show();
                            $.ajax({
                                url: ajaxurl,
                                type: 'get',
                                data: {
                                    action: 'data_fetch',
                                    keyword: keyword
                                },
                                success: function(data) {
                                    const suggestionBox = navSearch.find('.foy-suggestion-box');
                                    suggestionBox.html(data).show();
                                    loader.hide();
                                }
                            });
                        }
                    }
                    $('#foy-search-suggestion input[name="s"]').on('keyup', foyFunction);
                });
                document.addEventListener('click', function(event) {
                    var suggestionBox = document.querySelector('.foy-suggestion-box');
                    if (suggestionBox) {
                        let loader = document.querySelector('#foy-loading');
                        var isClickedInside = suggestionBox.contains(event.target);
                        if (!isClickedInside) {
                            suggestionBox.remove();
                            if (loader) {
                                loader.remove();
                            }
                        }
                    }
                });
            </script>
