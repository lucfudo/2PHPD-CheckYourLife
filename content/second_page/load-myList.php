<?php
include '../../models/ConfigDao.php';
$commentNewCount = $_POST["commentNewCount"];

$query = "SELECT DISTINCT title FROM list LIMIT $commentNewCount";
$myList = $data_base->prepare($query);
$myList->execute();
$statement = $myList->rowCount();
if ($statement > 0){
    while ($row = $myList->fetch()){
        echo "<button type='submit' class=\"leftTitle leftTitle-myList\">";
        echo "-";
        echo $row['title'];
        echo"</button>";
        echo "<br>";
    }
}
else{
    echo "...";
}