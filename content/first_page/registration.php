<!--registration form-->
<div id="registration-box">
    <h2>Register</h2>

    <form action="registration-check.php" method="POST">
        <input id="registration-email" type="text" name="email" placeholder="E-Mail">
        <input id="registration-nickname" type="text" name="nickname" placeholder="Nickname">
        <input id="registration-password" type="password" name="password" placeholder="Password">
        <br>
        <p class="form-message"></p>
        <button id="submit-registration-button" class="validate" type="submit" name="submit">Validate</button>
    </form>



    <button id="login-button" class="change">Login</button>

</div>

<!--change for login-->
<script>
    $(document).ready(function(){
        $("#login-button").click(function(){
            $("#login-box").load("login.php");
        });
    });
</script>

<!--check for registration-->
<script>
    $(document).ready(function () {
        $("form").submit(function(event){
            event.preventDefault();
            var email = $("#registration-email").val();
            var nickname = $("#registration-nickname").val();
            var password = $("#registration-password").val();
            var registration_submit = $("#submit-registration-button").val();
            $('.form-message').load("registration-check.php", {
                email: email,
                nickname: nickname,
                password: password,
                registration_submit: registration_submit
            });
        });
    });
</script>
