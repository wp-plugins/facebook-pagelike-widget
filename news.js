jQuery(document).ready(function () {
    jQuery.ajax({
        url: vars.news_type,
        data: {
            apikey: vars.api_key,
            _accept: "application/json"
        },
        dataType: "jsonp",
        success: function (data) {
            var ul = jQuery('<ul/>');
            jQuery.each(data.headlines, function () {
                var li = jQuery('<li/>')
                    .text(this.headline);
                ul.append(li)
            });
            jQuery('div #news')
                .append(ul);
        },
        error: function () {
            // handle the error
        }
    });
});