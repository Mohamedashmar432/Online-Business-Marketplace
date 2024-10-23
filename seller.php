<?php  include "./src/libs/load.php";
if(Session::isAuthenticated()){
    Session::renderPage();
}else{
    Session::set('_redirect', $_SERVER['REQUEST_URI']);
    header("Location:/signin.php");
}
?>