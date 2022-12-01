<?php
require('./openDb.php');

function registerUser($username, $password)
{
    $db = openDB();

    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    try {
        $sql = "INSERT INTO Kayttaja (sahkoposti,salasana) VALUES (?,?)";
        $statement = $db->prepare($sql);
        $statement->execute(array($username, $hash_password));
        return "Tervetuloa Collect Shoes kantajäseneksi!";
    } catch (PDOexception $e) {
        return $e;
    }
}

function checkUser($username, $password)
{
    $db = openDB();

    $query = "SELECT salasana FROM Kayttaja WHERE sahkoposti=?";
    $statement = $db->prepare($query);
    $statement->execute(array($username));

    $hashed_pw = $statement->fetchColumn();

    if(isset($hashed_pw)) {
        return password_verify($password,$hashed_pw) ? $username : null;
    }
    return null;
}

function searchInput($user) {

    $db = openDB();
    $search_input = htmlspecialchars($user->searchInput);

    $product_query = "SELECT tuotenimi,kuvaosoite,hinta,tuoteosoiteM,tuoteosoiteN FROM Tuote WHERE tuotenimi LIKE ?";

    $product_statement = $db->prepare($product_query);
    $product_statement->execute(array("$search_input%"));
    $response_arr = array();
    $response_arr["products"] = $product_statement->fetchAll(PDO::FETCH_ASSOC);

    return $response_arr;
}
