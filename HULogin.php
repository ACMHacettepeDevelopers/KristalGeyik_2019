<?php

$arrContextOptions = array(
    "ssl" => array(
        "verify_peer" => false,
        "verify_peer_name" => false,
    ),
);

if (!isset($_SESSION)) {
    session_start();
}
$user = "";
$Username = "";

$MuratDELENThisPageFullURL = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if (isset($_GET["logout"]) && isset($_SESSION["huuser"])) {
    unset($_SESSION["huuser"]);
    unset($_SESSION["huuser"]);
    header("location:https://oturum.hacettepe.edu.tr/logout.php?redirectdomainlogout=$MuratDELENThisPageFullURL");
    die();
}
if (isset($_GET["huuser"])) {
    $User = $_GET["huuser"];
}
if (isset($_SESSION["huuser"])) {
    $Username = $_SESSION["huuser"];
} else if (isset($_GET["huusertoken"])) {
    //$_SESSION["huuser"] = $Username = file_get_contents("https://oturum.hacettepe.edu.tr/isLogin.php?key=" . $_GET["huusertoken"], false, stream_context_create($arrContextOptions));
    $_SESSION["huuser"] = $Username = file_get_contents("https://oturum.hacettepe.edu.tr/isLogin.php?key=" . $_GET["huusertoken"]);
    if ($Username == 0) {
        header("location:https://oturum.hacettepe.edu.tr/?redirectdomain=$MuratDELENThisPageFullURL");
        die();
    }
} else {
    header("location:https://oturum.hacettepe.edu.tr/?redirectdomain=$MuratDELENThisPageFullURL");
    die();
}

