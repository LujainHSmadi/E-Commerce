<?php
session_start();
include_once "include/connect.php";
$state = false;

if (isset($_POST["registeration"])) {
    echo "hello";
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['confirmpassword'];

    if (!is_dir('images')) {
        mkdir('images');
    }

    $image = $_FILES['image'] ?? null;
    $imagePath = '';
    if ($image) {
        $imagePath = 'images/' . $image['name'];
        // mkdir(dirname($imagePath));
        move_uploaded_file($image['tmp_name'], $imagePath);
    }

    if ($password === $cpassword) {
        $query = "INSERT INTO `admin`(`admin_id`, `admin_name`,  `admin_email`, `admin_password`, `admin_date`)
    VALUES (NULL,:username,:email,:password, NOW()) ";

        $statement = $conn->prepare($query);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->execute();

        $state = true;
        if ($state) {
            echo "MATCH";
            $_SESSION['success'] = "Admin Profile added";
            header("Location: register.php");

        } else {
            $_SESSION['status'] = "Admin Profile NOT Added";
            header("Location: register.php");

        }

    } else {
        $_SESSION['status'] = "PASSWORD and CONFIRM PASSWORD DOES NOT MATCH";
        // header("Location: register.php");

    }

}

if (isset($_POST['edit_username'])) {
    echo "2";
    $id = $_GET['id'];
    $username = $_POST['edit_username'];
    $email = $_POST['edit_email'];
    $password = $_POST['edit_password'];

    $query = "UPDATE `admin` SET
    `admin_name`= :name,
    `admin_email`= :email,
    `admin_password`= :password,
    `admin_date`= NOW()
     WHERE `admin_id` = :id";

    $statement = $conn->prepare($query);
    $statement->bindValue(':name', $username);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':password', $password);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $state = true;
    if ($state) {
        echo "MATCH";
        $_SESSION['success'] = "Admin Profile updated";
        header("Location: register.php");

    } else {
        $_SESSION['status'] = "Admin Profile NOT updated";
        header("Location: register.php");

    }

    // header("Location:register.php");

}

if (isset($_POST['login'])) {
    $stat = false;

    $email = $_POST['login_email'];
    $pass = $_POST['login_pass'];

    $query = "SELECT * FROM `admin` WHERE `admin_email` = '$email' AND `admin_password` = '$pass' ";
    $statement = $conn->prepare($query);
    $statement->execute();

    $info = $statement->fetch(PDO::FETCH_ASSOC);
    $stat = true;
    if ($stat) {

        if ($email === $info['admin_email'] && $pass == $info['admin_password']) {
            $_SESSION['username'] = $email;
            header("Location:index.php");
        } 
        else { $_SESSION['status'] = "Email or Password is in valid ";
            header("Location:login.php");
        }

    } else {

    }
}


