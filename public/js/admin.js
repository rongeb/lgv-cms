$(function () {
    $('span.ajaxRotate').on('click', function (e) {
        e.preventDefault();
        var element = $(this);
        var url = element.attr('data-action');

        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                var img = $('img.' + element.attr('data-img'));
                tmp = new Date();
                tmp = "?" + tmp.getTime();
                img.attr('src', img.attr('src') + tmp);
            },
            error: function (error) {
                console.log(error);
            }
        });
    });

    $('.filepathBtn').on('click', function(){
        //create an attribute data-filepath
        var filepathTxtAttr = $(this).attr('data-clipboard');
        copyToClipboard(filepathTxtAttr);
    });

    function copyToClipboard(text) {
        var $temp = $("<input>");
        $("body").append($temp);
        $temp.val(text).select();
        document.execCommand("copy");
        $temp.remove();
    }
});
