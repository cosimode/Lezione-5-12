<?php

header("Content-Type: application/json");
$dati_json = file_get_contents("php://input");
$dati = json_decode($dati_json, true);

// Recupero il metodo della richiesta HTTP
$richiesta = $_SERVER['REQUEST_METHOD'];
$azione = isset($_GET['azione']) ? $_GET['azione'] : null;

switch ($richiesta){
    case "GET":
        if($azione == "getLibri"){
            getLibri();
        }
    case "POST":
        if($azione == "addLibro"){
            addLibro($dati);
        }
    case "PUT":
        if($azione == "updateLibro"){
            updateLibro($dati);
        }
    case "DELETE":
        if($azione == "deleteLibro"){
            deleteLibro($dati);
        }
    default:
        echo json_encode(["message" => "Metodo non supportato"]);
        break;
}

function getLibri(){
    $query="SELECT * FROM libri";
    $result=mysqli_query($conn, $query);
    $libri=mysqli_fetch_all($result, MYSQLI_ASSOC);
    echo json_encode($libri);
}

function addLibro($dati){
    if(empty($dati['titolo']) || empty($dati['autore']) || empty($dati['prezzo'])|| empty($dati['descrizione'])){
        echo json_encode(["message" => "Tutti i campi sono obbligatori"]);
        exit;
    }else{
        $query="INSERT INTO libri (titolo, autore, prezzo, descrizione) VALUES (?, ?, ?, ?)";
        $stmt=mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sss", $dati['titolo'], $dati['autore'], $dati['prezzo'], $dati['descrizione']);
        if(mysqli_stmt_execute($stmt)){
            echo json_encode(["message" => "Libro aggiunto con successo"]);
        }else{
            echo json_encode(["message" => "Errore durante l'aggiunta del libro"]);
        }
    }
    mysqli_stmt_close($stmt);
}

function updateLibro($dati){
    if(empty($dati['id']) || empty($dati['titolo']) || empty($dati['autore']) || empty($dati['prezzo']) || empty($dati['descrizione'])){
        echo json_encode(["message" => "Tutti i campi sono obbligatori"]);
        exit;
    }else{
        $query="UPDATE libri SET titolo=?, autore=?, prezzo=?, descrizione=? WHERE id=?";
        $stmt=mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sss", $dati['titolo'], $dati['autore'], $dati['prezzo'], $dati['descrizione'], $dati['id']);
        if(mysqli_stmt_execute($stmt)){
            echo json_encode(["message" => "Libro aggiornato con successo"]);
        }else{
            echo json_encode(["message" => "Errore durante l'aggiornamento del libro"]);
        }
    }
    mysqli_stmt_close($stmt);
}

function deleteLibro($dati){
    if(empty($dati['id'])){
        echo json_encode(["message" => "L'id del libro è obbligatorio"]);
        exit;
    }else{
        $query="DELETE FROM libri WHERE id=?";
        $stmt=mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $dati['id']);
        if(mysqli_stmt_execute($stmt)){ 
            echo json_encode(["message" => "Libro eliminato con successo"]);
        }else{
            echo json_encode(["message" => "Errore durante l'eliminazione del libro"]);
        }
    }
    mysqli_stmt_close($stmt);
}
?>