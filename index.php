<h1>TEST SUR REQUETE D'ENVOI / RECEPTION</h1>
<h2>REQUETE D'ENVOI</h2>

<?php

session_start();
require 'autoload.php';

$datas = [
    "user_id" => "abcdef",
    "pwd" => hash("tiger128,3", "lyon2014", false),
    "article" => [2 => "update"]
];

//var_dump($datas);

$ssl_pwd = "1234";
$ssl_iv_16 = "1234432112344321";

$ath_req = http_build_query($datas) . "\n"; // creation de la requete sous forme GET
$auth_request = preg_replace('/(%5B)([a-zA-Z0-9])(%5D)/', '=$2&action', $ath_req); // nettoyage
echo "<strong>$auth_request</strong>";
// Quelques injections pour le test
$datas["uri"] = "http://api.at.zef?";
$datas['request_method'] = "AES128"; // method d'encryptage TLS
$datas['request_key'] = hash("md5",$ssl_pwd, false);
$_SESSION['req_key'] = $datas['request_key']; // api_key ?
$datas['request_secret'] = hash("fnv164", $ssl_iv_16, false);
$_SESSION['req_secret'] = $datas['request_secret']; // api_secret ?
// encryptage de la requête à envoyer
$_SESSION['authorization_request'] = openssl_encrypt($datas["uri"].$auth_request, $datas['request_method'], $datas['request_key'], 0, $datas['request_secret']);
echo "Authorization_request (SSL/AES128)";
var_dump($_SESSION);
?>

<hr>

<h2>REQUETE DE RECEPTION</h2>
<h3>DECRYPTAGE SSL</h3>

<?php

$decrypt_query = openssl_decrypt($_SESSION['authorization_request'], "AES128", $datas['request_key'], 0,$datas['request_secret']);
var_dump($decrypt_query);