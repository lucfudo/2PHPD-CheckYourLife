<?php
session_start();
include '../../models/ConfigDao.php';

$owner = $_SESSION['user_id'];
echo $owner;
if(isset($_SESSION['user_id'])){?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">

        <script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity=
        "sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin=
                "anonymous"></script>
        <link rel="stylesheet" href="../../assets/css/second-page.css">

        <link rel="icon" href="../../assets/images/logo.svg" />
        <title>Check Your Life</title>
    </head>

    <body id="tout">
        <div id="container-principal">
            <div id="container-left">
                <div id="profile-box">
                    <button class="icon icon-profile">
                        <img src="../../assets/images/icon-profile.svg">
                    </button>
                    <a href="logout.php"><img class="icon-logout" src="../../assets/images/icon-logout.svg"></a>
                    <p class="field field-name"><?php echo $_SESSION['user'];?></p>
                </div>
                <div id="notification-box">
                    <button class="icon icon-notification">
                        <img src="../../assets/images/icon-notification.svg">
                    </button>
                    <p class="field field-notification">0 notifications</p>
                </div>
                <div id="left-box">
                    <div id="left-background">
                        <i class="leftTitle leftTitle-1">TODOLIST</i>
                        <button id="myList" class="leftTitle leftTitle-2">#my lists</button>
                        <div id="titleOfMyList">
                            <?php
                            $myList = $data_base->prepare("SELECT DISTINCT title FROM list LIMIT 2" );
                            $myList->execute();
                            $statement = $myList->rowCount();
                            if ($statement > 0){
                                while ($row = $myList->fetch()){
                                    echo "<button type='submit' id='".$row['title']."' class=\"leftTitle leftTitle-myList\">";
                                    echo "-";
                                    echo $row['title'];
                                    echo"</button>";
                                    echo "<br>";
                                }
                            }
                            ?>
                        </div>
                        <p class="leftTitle leftTitle-3">#shared to me</p>
                    </div>
                </div>
            </div>

            <div id="container-central">

            </div>

            <div id="container-right">
                <div id="right-box">
                    <p class="field field-create">Create list</p>
                    <button id="create-list" class="icon icon-createList">
                        <img src="../../assets/images/icon-create-list.svg">
                    </button>
                </div>
            </div>

            <div>
                <button id="change-color" class="colorR"></button>
            </div>
            <div id="logo">
                <div id="logo-image">
                    <img src="../../assets/images/logo.svg">
                </div>
            </div>
        </div>


        <script>
            const colorDiv ={
                leftBackground: document.getElementById('left-background'),
                icon: document.getElementsByClassName('icon'),
                field: document.getElementsByClassName('field')
            };
            const colorButton = document.getElementById('change-color');


            colorButton.addEventListener('click', (event) => {
                colorButton.classList.toggle('colorB');
                if(colorButton.className !== 'colorR'){
                    document.body.style.background = "linear-gradient(180deg, rgba(44,22,196,1) 0%, rgba(115,31,225,1) 46.02%, rgba(180,33,196,1) 100%) no-repeat center fixed";
                    colorDiv.leftBackground.style.backgroundColor = "#553EA7";
                    colorDiv.icon[0].style.backgroundColor = "#553EA7";
                    colorDiv.icon[1].style.backgroundColor = "#553EA7";
                    colorDiv.icon[2].style.backgroundColor = "#553EA7";
                    colorDiv.field[0].style.backgroundColor = "#553EA7";
                    colorDiv.field[1].style.backgroundColor = "#553EA7";
                    colorDiv.field[2].style.backgroundColor = "#553EA7";
                }else{
                    document.body.style.background = "linear-gradient(180deg, rgba(196, 22, 149, 1) 0%, rgba(225, 31, 94, 1) 46.02%, rgba(196, 78, 33, 1) 100%) no-repeat center fixed";
                    colorDiv.leftBackground.style.backgroundColor = "#A63E7E";
                    colorDiv.icon[0].style.backgroundColor = "#A63E7E";
                    colorDiv.icon[1].style.backgroundColor = "#A63E7E";
                    colorDiv.icon[2].style.backgroundColor = "#A63E7E";
                    colorDiv.field[0].style.backgroundColor = "#A63E7E";
                    colorDiv.field[1].style.backgroundColor = "#A63E7E";
                    colorDiv.field[2].style.backgroundColor = "#A63E7E";
                }
            })

        </script>
        <script>
            $(document).ready(function () {
                $("#create-list").click(function(){
                    $("#container-central").load("todo-list.php")
                })
            });
        </script>
        <script>
            $(document).ready(function(){
                var commentCount = 2;
                $("#myList").click(function(){
                    commentCount = commentCount + 2;
                    $("#titleOfMyList").load("load-myList.php", {
                        commentNewCount : commentCount
                    });
                })
            })
        </script>
        <script>
            $(document).ready(function(){
                $(".leftTitle-myList").click(function(){
                    var $title = $(this).attr("id");
                    $("#container-central").load("todo-list.php", {
                        title: $title
                    });
                })
            })
        </script>



    </body>

    </html>
<?php }
else{
    echo "<script>window.location.href = \"http://localhost:63342/CheckYourLife/content/first_page/first-page.php\"</script>";
}
?>