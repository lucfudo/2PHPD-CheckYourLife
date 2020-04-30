<?php
session_start();
include '../../models/ConfigDao.php';

if (isset($_POST['registration_submit'])){
    $email = $_POST['email'];
    $nickname= $_POST['nickname'];
    $password = $_POST['password'];

    $flag = 0;
    $errorEmpty = false;
    $errorEmail = false;
    $errorNickname = false;

    $answer = $data_base->query('SELECT * from users');
    $insert = $data_base->prepare("INSERT INTO users (user_email, user_nickname, user_password) VALUE(:email, :nickname, :password)");

    if (empty($email) || empty($nickname) || empty($password)){
        echo"<span class='error-message'>Fill in all Fields!</span>";
        $errorEmpty = true;
        }
    elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        echo"<span class='error-message'>Invalid E-Mail!</span>";
        $errorEmail = true;
        }
    else{
        while ($data = $answer->fetch()) {
            if($nickname == $data['user_nickname'] && $email == $data['user_email']){
                echo"<span class='error-message'>Already exist!</span>";
                $errorNickname = true;
                $errorEmail = true;
                $flag = 0;
                break;
                }
            elseif($nickname == $data['user_nickname'] || strlen($nickname) > 10){
                echo"<span class='error-message'>Invalid Nickname!</span>";
                $errorNickname = true;
                $flag = 0;
                break;
                }
            elseif($email == $data['user_email']){
                echo"<span class='error-message'>Invalid E-Mail!</span>";
                $errorEmail = true;
                $flag = 0;
                break;
                }
            else{
                $flag = 1;
            }
            }
    }
    if ($flag){
        echo"<span class='success-message'>Successfully registered!</span>";
        $insert->execute(array(
        'email' => $email,
        'nickname' => $nickname,
        'password' => $password,)
        );
    }
}
?>

<script>
    $("#registration-email, #registration-nickname, #registration-password").removeClass("input-error");

    var errorEmpty = "<?php echo $errorEmpty; ?>";
    var errorEmail = "<?php echo $errorEmail; ?>";
    var errorNickname = "<?php echo $errorNickname; ?>";

    if(errorEmpty){
        $("#registration-email, #registration-nickname, #registration-password").addClass("input-error");
    }
    if (errorEmail){
        $("#registration-email").addClass("input-error");
    }
    if (errorNickname){
        $("#registration-nickname").addClass("input-error");
    }
    if(!errorEmpty && !errorEmail){
        $("#registration-email, #registration-nickname, #registration-password").val("")
    }
</script>
