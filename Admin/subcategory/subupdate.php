<?php
@include '../includes/connect.php';

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

$name = $subcategory['subcategory_name'];
// $image = $category['category_img'];
// $desc=$category['category_des'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $subcat_name = $_POST['subcat_name'];
    $subcat_desc = $_POST['subcat_desc'];
    $category_id = $_POST['categoryid'];

    $image = $_FILES['image'] ?? null;
    $imagePath = '';
    if (!is_dir('images')) {
        mkdir('images');
    }
    if (empty($subcat_name)) {
        $errors[] = 'Product title is required';

    }
    if (empty($subcat_desc)) {
        $errors[] = 'Description is required';

    }
if( $category_id =='no'){
    $errors[] = 'category is required';

}
    if ($image) {

       
        $imagePath = 'images/' . $image['name'];
        move_uploaded_file($image['tmp_name'], $imagePath);

        if (empty($errors)) {
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

            header('Location:index.php');
            echo "helllo";
        }

    }

}

?>



<!doctype html>
<html lang="en">
  <head>
    <title>Create</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <p>
      <a href="index.php" class="btn btn-primary">GO Back to Products </a>
    </p>
      <!-- categories -->
      <h1>Update SubCategory <?php echo $name ?></h1>
      <?php if (!empty($errors)): ?>

            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <div><?php echo $error ?></div>
                <?php endforeach;?>
            </div>
           <?php endif?>
      <br>
      <form action="" method="POST" enctype="multipart/form-data">

          <?php if ($subcategory['subcategory_img']): ?>
            <img src = "<?php echo $subcategory['subcategory_img'] ?>" width=100px height=100px >
            <?php endif;?>


            <input class="form-control" type="text" placeholder="Add Categorry" name="subcat_name" value = "<?php echo $subcategory['subcategory_name'] ?>">
            <br>
            <div class="custom-file">
                    <br>
                    <input type="file" class="form-control-file" id="customFile" name="image" value = "<?php echo $subcategory['subcategory_img'] ?>">

                </div>

                <div class="form-group">
                <br>
                <label for="exampleFormControlTextarea1">Description </label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="subcat_desc" ><?php echo $subcategory['subcategory_des'] ?></textarea>
            </div>

                <?php

                $sql = "SELECT * FROM `category`";

                $sta = $conn->prepare($sql);
                $sta->execute();
                $publish = $sta->fetchAll();

                ?>

            <select name="categoryid" require>
                <option value="no">select Category</option>
                <?php foreach ($publish as $value): ?>
                <option value="<?php echo $value['category_id']; ?>"><?php echo $value['category_name']; ?></option>
            <?php endforeach?>
                </select>

             <br><br>
             <br><br>

            <button type="submit" class="btn btn-primary" name="add_product">update</button>
            <br><br>


      <form>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
