<script type="text/javascript">
    $('#btn_login').click(function() {        
        username = $('#username').val();
        password = $('#password').val();
        var str = 'username=' + username + '&password=' + password;
        var dir_login = "/classes/";
        $.ajax({            
            url: dir_login + 'login.php?' + str,
            success: function(resp) {											
                if (resp == 'false') {
                    alert('Login failed: Incorrect username or password!');
                    $.notify({
                            message: 'Login failed: Incorrect username or password!'
                        }, {
                            type: 'warning'
                        });
                } else window.location.reload(true);						
            }
        });
        return false;
    });
    $("#btn_logout").click(function() {
        $.ajax({		
            url: 'LogOut.php?argument=logOut',
            success: function(resp){
                if (resp == 'true') window.location.reload(true);
            }
        });
    });
</script>	