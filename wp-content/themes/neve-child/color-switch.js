jQuery(document).ready(function ($) {
    $('body').append('<label class="il-color-switch"><input name="il-color-switch" type="checkbox"><span class="il-color-switch-slide-circle"></span></label>');
    let cookieStatus = getCookie('il-color-switch');
    console.log({ cookieStatus });
    console.log(cookieStatus == 'light');
    if (cookieStatus == 'light') {
        $('input[name="il-color-switch"]').prop('checked', true);
        setToCurrentColor();
    }



    $(document).on('change', 'input[name="il-color-switch"]', function () {
        setToCurrentColor();
    });

    function setToCurrentColor() {
        var state = $('input[name="il-color-switch"]').is(':checked');
        if (state) {
            $('body').addClass('il-color-switch-mode');
            setCookie('il-color-switch', 'light', 0.25);
        } else {
            $('body').removeClass('il-color-switch-mode');
            setCookie('il-color-switch', 'dark', 0.25);
        }
        console.log(getCookie('il-color-switch'));
    }
});