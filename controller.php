<?php
require("model.php");

function replacePLus($chaine)
{
    //remplace le caracrtère '+' par %2B
    return str_replace('+', '%2B', $chaine);
}

function replace2B($chaine)
{
    return str_replace('%2B', '+', $chaine);
}

function chiffrerAES($data, $cle)
{
    // Générer une clé de 16 octets (AES-128) en remplissant la clé si nécessaire
    $cleCompletee = str_pad($cle, 16, '0');
    // Générer un IV (vecteur d'initialisation) de 16 octets
    $iv = random_bytes(openssl_cipher_iv_length('aes-128-cbc'));
    // Chiffrer les données
    $ciphertext = openssl_encrypt($data, 'aes-128-cbc', $cleCompletee, 0, $iv);
    // Concaténer l'IV et le texte chiffré pour stockage
    return base64_encode($iv . $ciphertext);
}

function dechiffrerAES($dataChiffree, $cle)
{
    // Générer une clé de 16 octets (AES-128) en remplissant la clé si nécessaire
    $cleCompletee = str_pad($cle, 16, '0');
    // Décoder les données encodées en base64
    $data = base64_decode($dataChiffree);
    $ivLength = openssl_cipher_iv_length('aes-128-cbc');
    // Extraire l'IV et le texte chiffré
    $iv = substr($data, 0, $ivLength);
    $ciphertext = substr($data, $ivLength);
    // Déchiffrer les données
    return openssl_decrypt($ciphertext, 'aes-128-cbc', $cleCompletee, 0, $iv);
}

function view_all()
{
    require("view/all_films.php");
}

function add_content()
{
    if (isset($_POST["save"])) {
        $encryption_key = 'developpement';
        $sql = new FilmAPI();
        extract($_POST);
        $title = htmlspecialchars($title);
        $description = htmlspecialchars($description);
        $lang = htmlspecialchars($lang);
        $genre = htmlspecialchars($genre);
        $date_de_sortie = htmlspecialchars($date_de_sortie);
        $box_office = htmlspecialchars($box_office);
        $duree = htmlspecialchars($duree);
        $nombre_etoiles = htmlspecialchars($nombre_etoiles);
        $table = "cinema";
        $fields = "titre, description, langue, genre, date_de_sortie, box_office, duree, nombre_etoiles";
        $value = '?, ?, ?, ?, ?, ?, ?, ?';
        $data = array($title, $description, $lang, $genre, $date_de_sortie, $box_office, $duree, $nombre_etoiles);
        if (!($sql->add($table, $fields, $value, $data))) {
            header('location:index.php?controller=view_all');
        }
    }
    require("view/add_films.php");
}

function edit_content()
{
    //déchiffrer l'id avant d'enregistrer
    if (isset($_POST['update'])) {
        $sql = new FilmAPI();
        extract($_POST);
        $id = htmlspecialchars($id);
        $title = htmlspecialchars($title);
        $description = htmlspecialchars($description);
        $lang = htmlspecialchars($lang);
        $genre = htmlspecialchars($genre);
        $date_de_sortie = htmlspecialchars($date_de_sortie);
        $box_office = htmlspecialchars($box_office);
        $duree = htmlspecialchars($duree);
        $nombre_etoiles = htmlspecialchars($nombre_etoiles);
        $table = "cinema";
        $fields = "titre = ?, description = ?, langue = ?, genre = ?, date_de_sortie = ?, box_office = ?, duree = ?, nombre_etoiles = ?";
        $condition = 'id = ?';
        $data = array($title, $description, $lang, $genre, $date_de_sortie, $box_office, $duree, $nombre_etoiles, $id);
        $sql->update($table, $fields, $condition, $data);
        header('location:index.php');
    }
    require('view/edit_films.php');
}

function del_content()
{
    if (isset($_GET['id'])) {
        $encryption_key = 'developpement';
        $id = dechiffrerAES(htmlspecialchars($_GET['id']), $encryption_key);
        $sql = new FilmAPI();
        $table = "cinema";
        $condition = 'id = ?';
        $data = array($id);
        //echo $id;
        $sql->delete($table, $condition, $data);
        header('location:index.php');
    }
    //require ('view/all_films.php');
}

function add_gender(){
    if (isset($_POST['add'])) {
        $sql = new FilmAPI();
        if (isset($_POST['gender'])) {
            extract($_POST);
            $gender = htmlspecialchars($_POST['gender']);
            $table = 'genre';
            $fields = 'nom';
            $value = '?';
            $data = array($gender);
            $sql->add($table, $fields, $value, $data);
        } else{
            header('location:index.php?controller=editgender&error=void');
        }
    }
    require('view/gender.php');
}

function del_gender(){
    if (isset($_GET['id'])) {
        $encryption_key = 'developpement';
        $id = dechiffrerAES(htmlspecialchars($_GET['id']), $encryption_key);
        $sql = new FilmAPI();
        $table = "genre";
        $condition = 'id = ?';
        $data = array($id);
        //echo $id;
        $sql->delete($table, $condition, $data);
    }
    require ('view/gender.php');
}

function edit_gender(){
    $encryption_key = 'developpement';
    if (isset($_POST['edit'])) {
        $sql = new FilmAPI();
        if (isset($_POST['gender'])) {
            extract($_POST);
            $id = htmlspecialchars($id);
            $gender = htmlspecialchars($gender);
            $table = "genre";
            $fields = "nom = ?";
            $condition = 'id = ?';
            $data = array($gender, $id);
            $sql->update($table, $fields, $condition, $data);
        } else{
            header('location:index.php?controller=editgender&error=void');
        }        
    }
    require ('view/gender.php');
}

function search_content(){
    require ('view/all_films.php');
}
?>