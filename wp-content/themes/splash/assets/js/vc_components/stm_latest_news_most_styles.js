(function ($) {
    $(document).ready(function() {
        $('.load-posts-more-style').on('click', function (e) {
            e.preventDefault();
            var viewStyle = $(this).data('view-style');
            var categs = ($(this).data('categs') != '') ? $(this).data('categs') : '';
            var offset = $(this).data('offset');
            var limit = $(this).data('limit');
            var numColumns = $(this).data('num-columns');
            var generateClass = $(this).data('generate-class');

            getPosts(viewStyle, categs, offset, limit, numColumns, generateClass);
        });
    });

    function getPosts(viewStyle, categs, offset, limit, numColumns, genClass) {
        $.ajax({
            url: ajaxurl,
            dataType: 'json',
            context: this,
            data: {
                action: 'stm_posts_most_styles',
                viewStyle: viewStyle,
                categs: categs,
                offset: offset,
                limit: limit,
                numColumns: numColumns
            },
            beforeSend: function(){
                $('.load-posts-more-style').addClass('loading');
            },
            success: function (data) {
                console.log(genClass);

                $('.load-posts-more-style').removeClass('loading');
                if(data.offset !== 'none') {
                    $('.load-posts-more-style').attr('data-offset', parseInt(offset + data.offset));
                } else {
                    $('.load-posts-more-style').remove();
                }

                if(data.posts) {
                    $('.' + genClass).append(data.posts);
                }
            }
        });
    }
})(jQuery);