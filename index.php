<?php
require_once("controller.php");

if (isset($_POST["controller"])) {
    $_POST["controller"]();
}
elseif (isset($_GET["controller"])) {
    $_GET["controller"]();
}
else {
    view_all();
}
?>