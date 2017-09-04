$(document).ready(function () {
    $(".input__add_task").on('click', function () {
        var parent = $(this).parent();
        var textarea = parent.find('.textarea__add-task');
        var content = textarea.val();
        if (content !== '') {
            var id = $(this).data('id');
            var url = $(this).data('url');
            var data = {
                'list_id': id,
                'content': content
            };
            $.ajax({
                url: url,
                type: "POST",
                data: data,
                success: function (response) {
                    if (response.status === 'ok') {
                        setTimeout(function() {
                                location.reload(true)
                            }, 1000);
                    }
                }
            });
        }
        else {
            return false;
        }
    });
});