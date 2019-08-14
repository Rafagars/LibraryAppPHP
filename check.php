<?php

//Maybe not the most optimal way to code this, but was the only way that I could make it works
// If you find a better way, please fix this code.

//Functions to check is the username or the email already exist in the database
//We need to pass pdo as a parameter in order to use SQL instructions

/*
DOESN'T WORK AT ALL, AND I DON'T KNOW WHY!!!!
function check_username ($username, $pdo){

    $userCheck = false;

    $stmt = $pdo->prepare('SELECT * FROM users WHERE name = :name');

    $stmt->execute(array(
        ':name' => $username
    ));

    $sql = $stmt->fetch(PDO::FETCH_ASSOC);


    if ($sql['name']===$username){
        $userCheck = true;
        $_SESSION['error'] = "Username already exist";
    }

    return $userCheck;

}*/

function check_email ($email, $pdo){

    $emailCheck = false;

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");

    $stmt->execute(array(
        ':email' => $email
    ));

    $sql = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($sql['email']===$email){
        $emailCheck = true;
        $_SESSION['error'] = "Email already in use";
    }

    return $emailCheck;

}

?>