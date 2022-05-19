<?php
@include 'includes/connect.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php');
    exit;
}



$query = "SELECT * FROM `category` WHERE category_id = :id";

$statment = $conn->prepare($query);
$statment->bindValue(':id', $id);
$statment->execute();
$category = $statment->fetch(PDO::FETCH_ASSOC);




$errors=[];

$name=$category['category_name'];
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

if(empty($errors)){
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
      <h1>Update Category <?php echo $name ?></h1>
      <?php if (!empty($errors)): ?>

            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <div><?php echo $error ?></div>
                <?php endforeach;?>
            </div>
           <?php endif?>
      <br>
      <form action="" method="POST" enctype="multipart/form-data">

          <?php if ($category['category_img']): ?>
            <img src = "<?php echo $category['category_img'] ?>" width=100px height=100px >
            <?php endif;?>


            <input class="form-control" type="text" placeholder="Add Categorry" name="cat_name" value = "<?php echo $category['category_name'] ?>">
            <br>
            <div class="custom-file">
                    <br>
                    <input type="file" class="form-control-file" id="customFile" name="image" value = "<?php echo $category['category_img'] ?>">

                </div>

                <div class="form-group">
                <br>
                <label for="exampleFormControlTextarea1">Description </label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="cat_desc" ><?php echo $category['category_des'] ?></textarea>
            </div>
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
