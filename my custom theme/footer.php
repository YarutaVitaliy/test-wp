<footer>
    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
</footer>
<?php wp_footer(); ?>

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#genre-filter').on('change', function() {
            var selectedGenre = $(this).val();

            $.ajax({
                url: '<?php echo admin_url('admin-ajax.php'); ?>',
                type: 'POST',
                data: {
                    action: 'filter_albums',
                    genre: selectedGenre
                },
                success: function(response) {
                    $('#albums-list').html(response);
                }
            });
        });
    });
</script>
</body>
</html>
