// ajax 上传头像
$(document).ready(function() {
    var options = {
        beforeSubmit:  showRequest,
        success:       showResponse,
        dataType: 'json'
    };
    $('#avatar').on('change', function(){
        $('#uploading').text('正在上传...');
        $('#upload-form').ajaxForm(options).submit();
    });
});
function showRequest() {
    $("#validation-errors").hide().empty();
    $("#output").css('display','none');
    return true;
}

function showResponse(response)  {
    if(response.success == false)
    {
        var responseErrors = response.errors;
        $.each(responseErrors, function(index, value)
        {
            if (value.length != 0)
            {
                $("#validation-errors").append('<div class="alert alert-error"><strong>'+ value +'</strong><div>');
            }
        });
        $("#validation-errors").show();
    } else {

        $('#user-avatar').attr('src',response.avatar);
        $('#uploading').text('上传头像');

    }
}