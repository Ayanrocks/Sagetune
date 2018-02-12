var error = false;

$(document).bind("contextmenu", function (e) {
    e.preventDefault();
});
$(document).keydown(function (e) {
    if (e.which === 123) {
        return false;
    }
});
document.onkeydown = function (e) {

    if (e.ctrlKey && e.shiftKey && e.keyCode == 'I'.charCodeAt(0)) {
        return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'J'.charCodeAt(0)) {
        return false;
    }
    if (e.ctrlKey && e.shiftKey && e.keyCode == 'C'.charCodeAt(0)) {
        return false;
    }
    if (e.ctrlKey && e.keyCode == 'U'.charCodeAt(0)) {
        return false;
    }
}

    
    

$(document).ready(function () {
    $("#confirm_password").keyup(function () {
        $("#message").show();        
    });

    

    $("#hidelogin").click(function () {
        $("#loginform").hide();
        $("#registerform").show();
    });

    $("#hideregister").click(function () {
        $("#loginform").show();
        $("#registerform").hide();
    });

    $('#password, #confirm_password').on('keyup', function () {
        if ($('#password').val() == $('#confirm_password').val()) {
            $('#message').html('Password Matched').css('color', 'green');
            error = false;
        } else
            $('#message').html('Password Do Not Matched').css('color', 'red');
            error = true;
    });

    $("button[type=submit]").click(function () {
        if (error == true) {
            $("#errorMessage").addClass('animated shake');
        }

    });
    $('#register').submit(function (e) {
                if (error == true)
                    $("button[type=submit]").preventDefault(); // will stop the form from submitting
                else
                    return true;
    });


});