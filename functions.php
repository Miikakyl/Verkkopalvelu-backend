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

function getAdminTables()
{

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

function addNewCategory($category)
{
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

function setUserOrder($input)
{

    $db = openDB();

    $fname = htmlspecialchars($input->userInfo->fname);
    $lname = htmlspecialchars($input->userInfo->lname);
    $email = htmlspecialchars($input->userInfo->email);
    $address = htmlspecialchars($input->userInfo->address);
    $zipcode = htmlspecialchars($input->userInfo->zipcode);
    $date = htmlspecialchars($input->userInfo->date);
    $phone = htmlspecialchars($input->userInfo->phone);
    $payment = htmlspecialchars($input->userInfo->payment);
    $shipping = htmlspecialchars($input->userInfo->shipping);

    $last_id = 0;
    $shoppingcart = $input->shoppingcart;

    try {
        $sql = "INSERT INTO Asiakas (postinumero,sahkoposti,etunimi,sukunimi,puh,osoite) VALUES (?,?,?,?,?,?)";
        $statement = $db->prepare($sql);
        $statement->execute(array($zipcode, $email, $fname, $lname, $phone, $address));
        $last_id = $db->lastInsertId();
    } catch (PDOexception $e) {
        return $e;
    }

    try {
        $sql = "INSERT INTO Tilaus (astunnus,tilauspvm,maksutapa,postitustapa) VALUES (?,?,?,?)";
        $statement = $db->prepare($sql);
        $statement->execute(array($last_id, $date, $payment, $shipping));
        $last_id = $db->lastInsertId();
    } catch (PDOexception $e) {
        return $e;
    }

    foreach ($shoppingcart as $item) {
        $quantity = htmlspecialchars($item->quantity);
        $color = htmlspecialchars($item->color);
        $size = htmlspecialchars($item->size);  
        $product_id = 0;

        try {
            $sql = "SELECT tuoteId FROM Tuote WHERE tuotenimi = ?";
            $statement = $db->prepare($sql);
            $statement->execute(array($item->name));
            $result = $statement->fetch();
            $product_id = (int)$result[0];
        } catch (PDOexception $e) {
            return $e;
        }

         try {
             $sql = "INSERT INTO Tilausrivi (tilausnro,tuoteId,kpl,vari,koko) VALUES (?,?,?,?,?)";
             $statement = $db->prepare($sql);
             $statement->execute(array($last_id,$product_id, $quantity, $color, $size));
             return true;
         } catch (PDOexception $e) {
             return $e;
         }
    }
    return false;
}
