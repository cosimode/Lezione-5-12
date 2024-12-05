<?php

header("Content-Type: application/json");
$dati_json = file_get_contents("php://input");
$dati = json_decode($dati_json, true);

// Recupero il metodo della richiesta HTTP
$richiesta = $_SERVER['REQUEST_METHOD'];
$azione = isset($_GET['azione']) ? $_GET['azione'] : null;

switch ($richiesta){
    case "GET":
        if($azione == "getCatalogo"){
            getCatalogo();
        }
    case "POST":
        if($azione == "addCatalogo"){
            addCatalogo($dati);
        }
    case "PUT":
        if($azione == "updateCatalogo"){
            updateCatalogo($dati);
        }
    case "DELETE":
        if($azione == "deleteCatalogo"){
            deleteCatalogo($dati);
        }
    default:
        echo json_encode(["message" => "Metodo non supportato"]);
        break;
}

function getCatalogo(){
    $query="SELECT * FROM catalogo";
    $result=mysqli_query($conn, $query);
    $catalogo=mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($catalogo);
    mysqli_close($conn);
}

function addCatalogo($dati){
    if(empty($dati['nome_catalogo'])){
        echo json_encode(["message" => "Il nome del catalogo è obbligatorio"]);
        exit;
    }else{
        $query="INSERT INTO catalogo (nome_catalogo) VALUES (?)";
        $stmt=mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "s", $dati['nome_catalogo']);
        if(mysqli_stmt_execute($stmt)){
            echo json_encode(["message" => "Catalogo aggiunto con successo"]);
        }else{
            echo json_encode(["message" => "Errore durante l'aggiunta del catalogo"]);
        }
    }
    mysqli_stmt_close($stmt);
}

function updateCatalogo($dati){
    if(empty($dati['id_catalogo']) || empty($dati['nome_catalogo'])){
        echo json_encode(["message" => "Tutti i campi sono obbligatori"]);
        exit;
    }else{
        $query="UPDATE catalogo SET nome_catalogo=? WHERE id_catalogo=?";
        $stmt=mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "si", $dati['nome_catalogo'], $dati['id_catalogo']);
        if(mysqli_stmt_execute($stmt)){
            echo json_encode(["message" => "Catalogo aggiornato con successo"]);
        }else{
            echo json_encode(["message" => "Errore durante l'aggiornamento del catalogo"]);
        }
    }
    mysqli_stmt_close($stmt);
}

function deleteCatalogo($dati){
    if(empty($dati['id_catalogo'])){
        echo json_encode(["message" => "L'id del catalogo è obbligatorio"]);
        exit;
    }else{
        $query="DELETE FROM catalogo WHERE id_catalogo=?";
        $stmt=mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $dati['id_catalogo']);
        if(mysqli_stmt_execute($stmt)){
            echo json_encode(["message" => "Catalogo eliminato con successo"]);
        }else{
            echo json_encode(["message" => "Errore durante l'eliminazione del catalogo"]);
        }
    }
    mysqli_stmt_close($stmt);
}
?>