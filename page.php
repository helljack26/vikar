<?php 
session_start();
error_reporting(3);

include('includes/config.php');
include('function.php');

function isset_file($file){
    $arr = explode(PATH_SEPARATOR,get_include_path());
    foreach ($arr as $val){
        if(file_exists($val.'/'.$file))return true;
    }
    return false;              
}
function get_info_page($con, $id){
    $getInfoPage = mysqli_query($con,"SELECT * from info_pages where newid='$id'");
    $rowInfoPage = mysqli_fetch_array($getInfoPage);
    return $rowInfoPage;              
}

    $getParamTransName = removeRootDir();

    if(isset_file("information/$getParamTransName.php")){	
        require_once "information/$getParamTransName.php";
    }else{
        header('Location: 404.php');
    }
exit;
?>
