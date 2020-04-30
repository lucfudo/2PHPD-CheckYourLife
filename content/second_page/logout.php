<?php
session_start();
if(isset($_SESSION['user'])){
    session_destroy();

    echo "<script>setTimeout(function(){window.location.href = \"http://localhost:63342/CheckYourLife/content/first_page/first-page.php\";}, 500)</script>";
}
else{
    echo "<script>setTimeout(function(){window.location.href = \"http://localhost:63342/CheckYourLife/content/first_page/first-page.php\";}, 500)</script>";
}