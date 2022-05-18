<?php

@include 'connect.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cat_name = $_POST['cat_name'];
    $cat_desc = $_POST['cat_desc'];
    $cat_image = $_FILES['cat_image']['name'];
    // $cat_image_tmp_name = $_FILES['cat_image']['tmp_name'];
    // $cat_image_size = $_FILES['cat_image']['tmp_name'];
    // $cat_image_folder = 'images/'.$cat_name;
    // $imgExtension = strtolower(pathinfo(
    //          $cat_image, PATHINFO_EXTENSION));
    // $valid_extension = array("png", "jpeg", "jpg");
    // $picProfile = rand(1000,1000000);

    if (empty($cat_name)) {
        $errors[] = 'Product title is required';

    }
    if (empty($cat_desc)) {
        $errors[] = 'Description is required';

    } 
    if(empty($errors)) {

        $query = "INSERT INTO `category` (`category_id`, `category_name`, `category_img`, `category_des`)
    VALUES (NULL, :name, :image, :desc)";

        $statment = $conn->prepare($query);
        $statment->bindValue(':name', $cat_name);
        $statment->bindValue(':image', '');
        $statment->bindValue(':desc', $cat_desc);
        $statment->execute();
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
      <!-- categories -->
      <h1>Create New Category</h1>
      <?php if (!empty($errors)): ?>

            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <div><?php echo $error ?></div>
                    <?php endforeach?>
            </div>
           <?php endif?>
      <br>
      <form action="create.php" method="post" enctype="multipart/form-data">
            <input class="form-control" type="text" placeholder="Add Categorry" name="cat_name" ">
            <br>
            <div class="custom-file">
                    <br>
                    <input type="file" class="custom-file-input" id="customFile" name="cat_image">
                    <label class="custom-file-label" for="customFile">Choose file</label>
                </div>

                <div class="form-group">
                <br>
                <label for="exampleFormControlTextarea1">Description </label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="cat_desc" ></textarea>
            </div>
            <button type="submit" class="btn btn-primary" name="add_product">Add</button>
            <br><br>
            <select class="form-control">
                <option>select Category</option>
            </select>
      <form>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
