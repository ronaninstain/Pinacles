function toggleFilter() {
    var filterContent = document.querySelector('.foy-custom-sidebar');
    var filterButtonIcon = document.querySelector('.filter-button i');
    // Toggle the display of the filter content
    filterContent.style.display = (filterContent.style.display == 'none' || filterContent.style.display == '') ? 'block' : 'none';
    // Toggle the icon between 'times' and 'filter'
    filterButtonIcon.classList.toggle('fa-times', filterContent.style.display === 'block');
    filterButtonIcon.classList.toggle('fa-filter', filterContent.style.display === 'none');
}
// Function to handle AllCourse Ajax
jQuery(document).ready(function ($) {
    function sendAjaxRequest(page, filters) {
        var loading = true;
        loadingClassHandler(loading);
        var data = {
            action: 'get_courses_ajax',
            page: page,
            filters: filters,
        };
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: data,
            beforeSend: function() {

            },
            success: function(response) {
                console.log(response);
                $('.foy-course-list').html(response);
                // console.log(response);
                if (clickedRadioButton && !clickedRadioButton.prop('checked')) {
                    propertiesUpdate(clickedRadioButton);
                }
            },
            complete: function() {
                var loading = false;
                loadingClassHandler(loading);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
            }
        });
    }
    // Event listener for radio buttons and pagination
    $(document).on('change click', '.foy-custom-sidebar input[type=radio], .foy-allcourse-pagination .foy-pagination a, .foy-reset', function (e) {
        e.preventDefault();
        var selectedFilters = "";
        var page = 1;
        // for radio button checked action
        clickedRadioButton = false;
        if ($(e.target).is('input[type=radio]')) {
            clickedRadioButton = $(this);
        }else if ($(this).hasClass('foy-reset')) {
            // If the clicked element has the class 'foy-reset', handle reset logic
            var currentContainer = $(this).closest('.foy-course-sidebar');
            resetRadioButton(currentContainer);
        }else{
            if ($(this).attr('data-page')) {
                var page = parseInt($(this).attr('data-page'), 10);
            }
        }
        var selectedFilters = {
            subject: $('input[name=subject]:checked').val() ?? "",
            type: $('input[name=type]:checked').val() ?? "",
            language: $('input[name=language]:checked').val() ?? "",
            order: $('.foy-course-filter select').val() ?? ""
        }
        sendAjaxRequest(page, selectedFilters);
    });

    $(document).on('change', '.foy-course-filter select', function (e) {
        e.preventDefault();
        clickedRadioButton = false;
        if ($(e.target).is('input[type=radio]')) {
            clickedRadioButton = $(this);
        }
        var selectedFilters = {
            subject: $('input[name=subject]:checked').val() ?? "",
            type: $('input[name=type]:checked').val() ?? "",
            language: $('input[name=language]:checked').val() ?? "",
            order: $(this).val() ?? "" // Capture the value of the select element
        };
        sendAjaxRequest(1, selectedFilters); // Assuming the page should reset to 1 on filter change
    });
    // for handling loading css
    function loadingClassHandler(loading) {
        $('#loader').toggle(loading);
        $('.foy-custom-sidebar, #course-list').toggleClass('foy-loading', loading);
    }
    // function loadingClassHandler(loading) {
    //     if(loading){
    //         $('#loader').show();
    //         $('.foy-custom-sidebar').addClass('foy-loading');
    //         $('#course-list').addClass('foy-loading');
    //     }else{
    //         $('#loader').hide();
    //         $('.foy-custom-sidebar').removeClass('foy-loading');
    //         $('#course-list').removeClass('foy-loading');
    //     }
    // }
    // for handling resetbutton
    function resetRadioButton(container) {
        container.find('input[type=radio]').prop('checked', false);
        container.find('button.foy-reset').prop('disabled', true);
        lebelClassUpdate(container);
    }
    function lebelClassUpdate(container) {
        container.find('label.foy-not-clickable').removeClass('foy-not-clickable');
    }
    function propertiesUpdate(clickedRadioButton){
        var currentContainer = clickedRadioButton.closest('.foy-course-sidebar');
        resetRadioButton(currentContainer);
        currentContainer.find('button.foy-reset').prop('disabled', false);
        var label = clickedRadioButton.closest('label');
        clickedRadioButton.prop('checked', true);
        label.addClass('foy-not-clickable');

        $('.foy-custom-sidebar li').removeClass('active');
        clickedRadioButton.closest('li').addClass('active');
    }
});

// Function to handle CourseCat Ajax
jQuery(document).ready(function ($) {
    function sendAjaxRequest(page, filters) {
        var loading = true;
        loadingClassHandler(loading);
        var data = {
            action: 'get_cat_courses_ajax',
            page: page,
            filters: filters,
        };
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: data,
            beforeSend: function() {
                // handle beforeSend
            },
            success: function(response) {
                $('.foy-course-list').html(response);
                // console.log(response);
            },
            complete: function() {
                var loading = false;
                loadingClassHandler(loading);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
            }
        });
    }
    // Event listener for radio buttons and pagination
    $(document).on('change click', '.foy-archive-pagination .foy-pagination a', function (e) {
        e.preventDefault();
        var page = 1;
        if ($(this).attr('data-page')) {
            var page = parseInt($(this).attr('data-page'), 10);
        }
        var selectedFilters = {
            subject: $('.foy-page-name').val() ?? "",
        }
        sendAjaxRequest(page, selectedFilters);
    });
    function loadingClassHandler(loading) {
        if(loading){
            $('#loader').show();
            $('.foy-custom-sidebar').addClass('foy-loading');
            $('#course-list').addClass('foy-loading');
        }else{
            $('#loader').hide();
            $('.foy-custom-sidebar').removeClass('foy-loading');
            $('#course-list').removeClass('foy-loading');
        }
    }
});

// Function to handle CourseSearch Ajax
jQuery(document).ready(function ($) {
    function sendAjaxRequest(page, filters) {
        var loading = true;
        loadingClassHandler(loading);
        var data = {
            action: 'get_search_courses_ajax',
            page: page,
            filters: filters,
        };
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: data,
            beforeSend: function() {
                // handle beforeSend
            },
            success: function(response) {
                $('.foy-course-list').html(response);
                console.log(response);
                if (clickedCheckboxButton) {
                    propertiesUpdate(clickedCheckboxButton);
                }
                // updateCourseCount(page);
            },
            complete: function() {
                var loading = false;
                loadingClassHandler(loading);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
            }
        });
    }
    // Event listener for radio buttons and pagination
    $(document).on('change click', '.foy-custom-sidebar input[type=checkbox], .foy-searchcourse-pagination .foy-pagination a, .foy-all-reset', function (e) {
        e.preventDefault();
        var selectedFilters = "";
        var page = 1;
        clickedCheckboxButton = false;
        if ($(e.target).is('input[type=checkbox]')) {
            clickedCheckboxButton = $(this);
        } else if ($(this).attr('data-page')){
            var page = parseInt($(this).attr('data-page'), 10);
        }else if ($(this).hasClass('foy-all-reset')) {
            resetCheckboxButton();
        }
        var selectedFilters = {
            subject: getCheckedValues('subject[]'),
            type: getCheckedValues('type[]'),
            language: getCheckedValues('language[]'),
            query: $('.foy-search-query').val() ?? "",
        };
        sendAjaxRequest(page, selectedFilters);
    });
    function getCheckedValues(name) {
        var checkboxes = $('input[name="' + name + '"]:checked');
        var values = checkboxes.map(function() {
            return $(this).val();
        }).get();
        return values;
        // return values != '' ? values : '';
    }
    // function updateCourseCount(page){
    //     courseStart = ((page - 1) * 16) + 1;
    //     courseEnd = page * 16;
    //     $('.foy-course-count h2 span').text(courseStart + ' - ' + courseEnd);
    // }
    function loadingClassHandler(loading) {
        $('#loader').toggle(loading);
        $('.foy-custom-sidebar, #course-list').toggleClass('foy-loading', loading);
    }
    // for handling resetbutton
    function resetCheckboxButton(container) {
        $('.foy-custom-sidebar input[type=checkbox]').prop('checked', false);
        $('.foy-custom-sidebar button.foy-all-reset').prop('disabled', true);
    }
    function propertiesUpdate(clickedCheckboxButton) {
        clickedCheckboxButton.prop('checked', !clickedCheckboxButton.prop('checked'));
        $('.foy-custom-sidebar button.foy-all-reset').prop('disabled', false);
    }
});