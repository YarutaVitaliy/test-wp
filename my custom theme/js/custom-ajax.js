jQuery(document).ready(function($) {
    // Toggle dropdown
    $('.dropdown-btn').on('click', function() {
        $(this).next('.dropdown-content').toggleClass('show');
    });

    // Handle genre selection
    $('.dropdown-content a').on('click', function(e) {
        e.preventDefault();

        var selectedGenre = $(this).data('genre');
        var genreText = $(this).text();

        $('.dropdown-btn').text(genreText);

        $.ajax({
            url: myAjax.ajax_url,
            type: 'POST',
            data: {
                action: 'filter_albums',
                genre: selectedGenre
            },
            success: function(response) {
                $('#albums-list').html(response);
            }
        });

        // Close the dropdown after selection
        $(this).parent().removeClass('show');
    });

    // Close dropdown when clicking outside
    $(document).click(function(e) {
        if (!$(e.target).closest('.custom-dropdown').length) {
            $('.dropdown-content').removeClass('show');
        }
    });
});
