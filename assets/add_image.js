(function($) {

    $(document).on("submit", "#login", function(event){
        event.preventDefault();
        var serialized = $(this).serializeArray();
        serialized.push({
            name: 'csrf',
            value: Cookies.get('csrf_token')
        });
        $.ajax({
            method: 'post',
            dataType: 'json',
            data: serialized,
            url: url + 'Homepage/addimage',
            success: function(result) {
                if (result.status === true) {
                    toastr.success("başarılı giriş.");
                    setTimeout(
                        function(){
                            window.location.reload();
                        }, 1000);
                } else {
                    alert(result.error);
                }
            },
            error: function() {
                alert('hata');
            }
        });
    });

})(jQuery);