<?php

header("Content-Type: application/json");
$dati_json = file_get_contents("php://input");
$dati = json_decode($dati_json, true);

// Recupero il metodo della richiesta HTTP
$richiesta = $_SERVER['REQUEST_METHOD'];
$azione = isset($_GET['azione']) ? $_GET['azione'] : null;

switch ($richiesta){
    case "GET":
        if($azione == "getLibroCatalogo"){
            getLibroCatalogo();
        }
    case "POST":
        if($azione == "addLibroCatalogo"){
            addLibroCatalogo($dati);
        }
    case "PUT":
        if($azione == "updateLibroCatalogo"){
            updateLibroCatalogo($dati);
        }
    case "DELETE":
        if($azione == "deleteLibroCatalogo"){
            deleteLibroCatalogo($dati);
        }
    default:
        echo json_encode(["message" => "Metodo non supportato"]);
        break;
}


?>