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

    try {
        $query = "SELECT salasana FROM Kayttaja WHERE sahkoposti=?";
        $statement = $db->prepare($query);
        $statement->execute(array($username));

        $hashed_pw = $statement->fetchColumn();
        

        if (isset($hashed_pw)) {

            return password_verify($password, $hashed_pw) ? $username : false;
        }
        return false;
    } catch (PDOException $e) {
        return $e;
    }
}

function searchInput($input)
{

    $db = openDB();

    try {
        $search_input = htmlspecialchars($input->searchInput);

        $product_query = "SELECT tuotenimi,kuvaosoite,hinta,tuoteosoiteM,tuoteosoiteN FROM Tuote WHERE tuotenimi LIKE ?";
    
        $product_statement = $db->prepare($product_query);
        $product_statement->execute(array("$search_input%"));
        $response_arr = array();
        $response_arr["products"] = $product_statement->fetchAll(PDO::FETCH_ASSOC);
    
        return $response_arr;
    } catch (PDOException $e) {
        return $e;
    }
}

function getShoppingcartImage()
{
    $db = openDB();
    
    try {
        $product_name = htmlspecialchars($_GET['productName']);
        $query = "SELECT kuvaosoite FROM Tuote WHERE tuotenimi = ?";
        $statement = $db->prepare($query);
        $statement->execute(array($product_name));
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        return $e;
    }
}

function getAdminTables() {

    $db = openDB();

    try {
        $query = "SELECT tuoteId,trnro,tuotenimi,hinta,kustannus FROM Tuote";
        $statement = $db->prepare($query);
        $statement->execute();
        $result_product = $statement->fetchAll(PDO::FETCH_ASSOC);

        $query = "SELECT trnro,trnimi FROM Tuoteryhma";
        $statement = $db->prepare($query);
        $statement->execute();
        $result_category = $statement->fetchAll(PDO::FETCH_ASSOC);

        $respond = new stdClass();
        $respond->products = $result_product;
        $respond->category = $result_category;

        return $respond;
        
    } catch (PDOException $e) {
        return $e;
    }   
}

function addNewCategory($category) {
    $db = openDB();

    try {
        $sql = "INSERT INTO Tuoteryhma (trnimi) VALUES (?)";
        $statement = $db->prepare($sql);
        $statement->execute(array($category));
        return true;
    } catch (PDOexception $e) {
        return $e;
    }
}

function setUserInfo($userInfo) {
    $db = openDB();
    
    $fname = htmlspecialchars($userInfo->fname);
    $lname = htmlspecialchars($userInfo->lname);
    $email = htmlspecialchars($userInfo->email);
    $address = htmlspecialchars($userInfo->address);
    $zipcode = htmlspecialchars($userInfo->zipcode);
    $phone = htmlspecialchars($userInfo->phone);
    try {
        $sql = "INSERT INTO Asiakas (astunnus,postinumero,sahkoposti,etunimi,sukunimi,puh,osoite) VALUES (?,?,?,?,?,?)";
        $statement = $db->prepare($sql);
        $statement->execute(array($fname,$lname,$email,$address,$zipcode,$phone));
    } catch (PDOexception $e) {
        return $e;
    }
}

function setUserOrder($order) {

}
