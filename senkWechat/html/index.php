<?php

$arr = array("id"=>"3");
$json = json_encode($arr);

if(isset($_GET["callback"])){
    
    $cb = $_GET["callback"];
    echo $cb."($json".")";
    
}else{
    //echo $json;
    echo "<a href='index.html'>";
}

?>