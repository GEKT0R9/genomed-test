$(document).on('beforeSubmit', '#url-form', function(e) {
    e.preventDefault();
    $('#url-ok-button')
        .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
        .attr('disabled', true)
        .addClass('disabled');
    $.ajax({
        url: '/site/create',
        type: 'post',
        data: $(this).serialize(),
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#short-url').val(response.shortUrl);
                $('#qr-code-container').html('<img src="/qr/' + response.idCode + '" class="img-fluid" alt="QR Code">');
                $('#result-container').show();
            } else {
                alert('Ошибка: ' + JSON.stringify(response.errors));
            }
        },
        error: function() {
            alert('Произошла ошибка при обработке запроса');
        },
        complete: function() {
            $('#url-ok-button')
                .attr('disabled', false)
                .removeClass('disabled')
                .html('ОК');
        }

    });
    return false;
});
$('#url-form')
    .on('ajaxBeforeSend', function (e) {
        $('#url-ok-button')
            .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>')
            .attr('disabled', true)
            .addClass('disabled');
        return true;
    })
    .on('beforeValidateAttribute', function (e) {
        $('#url-ok-button').attr('disabled', true).addClass('disabled');
        return true;
    })
    .on('afterValidate', function (event, messages, errorAttributes) {
        if (errorAttributes.length === 0) {
            $('#url-ok-button').attr('disabled', false).removeClass('disabled');
        }
        $('#url-ok-button').html('ОК');
        return true;
    });

function unsecuredCopyToClipboard() {
    const shortUrl = document.getElementById("short-url");
    shortUrl.select();
    try {
        document.execCommand('copy');

        const originalText = $('#copy-btn').html();
        $('#copy-btn').html('<i class="bi bi-check2"></i> Скопировано!');
        setTimeout(function() {
            $('#copy-btn').html(originalText);
        }, 2000);
    } catch (err) {
        alert('При копировании возникла ошибка')
    }
}
function securedCopyToClipboard() {
    const shortUrl = $('#short-url').val();
    window.navigator.clipboard
        .writeText(shortUrl)
        .then(function (){
            const originalText = $('#copy-btn').html();
            $('#copy-btn').html('<i class="bi bi-check2"></i> Скопировано!');
            setTimeout(function() {
                $('#copy-btn').html(originalText);
            }, 2000);
        })
        .catch(function (){
            alert('При копировании возникла ошибка')
        });
}

$('#copy-btn').on('click', function() {
    if (window.navigator.clipboard){
        securedCopyToClipboard()
    } else {
        unsecuredCopyToClipboard()
    }
});