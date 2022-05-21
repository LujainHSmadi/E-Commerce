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

//update admin
if (isset($_POST['edit_username'])) {
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

// Login code.
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
        } else { $_SESSION['status'] = "Email or Password is in valid ";
            header("Location:login.php");
        }

    } else {

    }
}

//category

if (isset($_POST['add_category'])) {
    $errors = [];
    echo "Hello";
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $cat_name = $_POST['cat_name'];
        $cat_desc = $_POST['cat_desc'];

        if (empty($cat_name)) {
            $errors[] = 'Product title is required';

        }
        if (empty($cat_desc)) {
            $errors[] = 'Description is required';

        }
        if (!is_dir('images')) {
            mkdir('images');
        }

        if (empty($errors)) {
            $image = $_FILES['image'] ?? null;
            $imagePath = '';
            if ($image) {
                $imagePath = 'images/' . $image['name'];
                // mkdir(dirname($imagePath));
                move_uploaded_file($image['tmp_name'], $imagePath);
            }

            $query = "INSERT INTO `category` (`category_id`, `category_name`, `category_img`, `category_des`)
    VALUES (NULL, :name, :image, :desc)";

            $statment = $conn->prepare($query);
            $statment->bindValue(':name', $cat_name);
            $statment->bindValue(':image', $imagePath);
            $statment->bindValue(':desc', $cat_desc);
            $statment->execute();

            header("Location:cat_index.php");

        }
    }

}
//************************* delete category**********************
if (isset($_POST['delete_cat'])) {
    $id = $_POST['id'] ?? null;
    if (!$id) {
        header('Location: cat_index.php');
        exit;
    }

    $statement = $conn->prepare('DELETE FROM `category` WHERE `category`.`category_id` = :id');
    $statement->bindValue(':id', $id);
    $statement->execute();
    header("Location:cat_index.php");
}

//**********************edit categories****************************

if (isset($_POST['edit_category'])) {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        header('Location: cat_index.php');
        exit;
    }

    $query = "SELECT * FROM `category` WHERE category_id = :id";

    $statment = $conn->prepare($query);
    $statment->bindValue(':id', $id);
    $statment->execute();
    $category = $statment->fetch(PDO::FETCH_ASSOC);

    $errors = [];

    $name = $category['category_name'];
// $image = $category['category_img'];
    // $desc=$category['category_des'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $cat_name = $_POST['cat_name'];
        $cat_desc = $_POST['cat_desc'];
        $image = $_FILES['image'] ?? null;
        $imagePath = '';
        if (!is_dir('images')) {
            mkdir('images');
        }
        if (empty($cat_name)) {
            $errors[] = 'Product title is required';

        }
        if (empty($cat_desc)) {
            $errors[] = 'Description is required';

        }

        if ($image) {

            if ($category['category_img']) {
                unlink($category['category_img']);

            }
            $imagePath = 'images/' . $image['name'];
            move_uploaded_file($image['tmp_name'], $imagePath);

            if (empty($errors)) {
                $query = "UPDATE `category`
    SET `category_name`=:name,
    `category_img`= :image,
    `category_des`= :desc
    WHERE `category_id` = :id";

                $statment = $conn->prepare($query);
                $statment->bindValue(':name', $cat_name);
                $statment->bindValue(':image', $imagePath);
                $statment->bindValue(':desc', $cat_desc);
                $statment->bindValue(':id', $id);
                $statment->execute();

                header('Location:cat_index.php');
// echo "helllo";
            }

        }

    }

}
//***********************edit subcategory*************************** */
if (isset($_POST['edit_subcategory'])) {

    $id = $_GET['id'] ?? null;
    
    if (!$id) {
        header('Location: index.php');
        exit;
    }

    $query = "SELECT * FROM `subcategory` WHERE subcategory_id = :id";

    $statment = $conn->prepare($query);
    $statment->bindValue(':id', $id);
    $statment->execute();
    $subcategory = $statment->fetch(PDO::FETCH_ASSOC);

    $errors = [];

 

   

        $subcategory_name = $_POST['subcategory_name'];
        $subcategory_des = $_POST['subcategory_des'];
        $category_id = $_POST['categoryid'];

        $image = $_FILES['image'] ?? null;
        $imagePath = '';
        if (!is_dir('images')) {
            mkdir('images');
        }
        if (empty($subcategory_name)) {
            $errors[] = 'Product title is required';

        }
        if (empty($subcategory_des)) {
            $errors[] = 'Description is required';

        }
        if ($category_id == 'no') {
            $errors[] = 'category is required';

        }
        echo '<pre>';
        var_dump( $errors);
        echo '</pre>';
        if ($image) {

            $imagePath = 'images/' . $image['name'];
            move_uploaded_file($image['tmp_name'], $imagePath);

            if (empty($errors)) {
                echo " 4444";
                $query = "UPDATE `subcategory`
    SET `subcategory_name`=:name,
    `subcategory_img`= :image,
    `subcategory_des`= :desc,
    `category_id` = :category
    WHERE `subcategory_id` = :id";

                $statment = $conn->prepare($query);
                $statment->bindValue(':name', $subcat_name);
                $statment->bindValue(':image', $imagePath);
                $statment->bindValue(':desc', $subcat_desc);
                $statment->bindValue(':category', $category_id);
                $statment->bindValue(':id', $id);
                $statment->execute();

                header('Location:subcat_index.php');
                echo "helllo";
            }

        }

    }


//**************************************create subcategory********************/

if (isset($_POST['add_subcategory'])) {
    $subcategory_name = $_POST['subcategory_name'];
    $subcategory_des = $_POST['subcategory_des'];
    $category_id = $_POST['categoryid'];
    if (empty($subcategory_name)) {
        $errors[] = 'Product title is required';

    }
    if (empty($subcategory_des)) {
        $errors[] = 'Description is required';

    }
    if ($category_id == "no") {
        $errors[] = 'Category is required';

    }
    if (!is_dir('images')) {
        mkdir('images');
    }
    if (empty($errors)) {
        $image = $_FILES['image'] ?? null;
        $imagePath = '';
        if ($image) {
            $imagePath = 'images/' . $image['name'];
            // mkdir(dirname($imagePath));
            move_uploaded_file($image['tmp_name'], $imagePath);
        }

        $query = "INSERT INTO `subcategory` (`subcategory_id`, `subcategory_name`, `subcategory_img`, `subcategory_des`, `category_id`)
        VALUES (NULL, :name, :image, :des,:cat_id)";

        $statment = $conn->prepare($query);
        $statment->bindValue(':name', $subcategory_name);
        $statment->bindValue(':image', $imagePath);
        $statment->bindValue(':des', $subcategory_des);
        $statment->bindValue(':cat_id', $category_id);
        $statment->execute();

        header('Location:subcat_index.php');
    }

}