<?php
@include_once "connect.php";
$satement = $conn->prepare('SELECT * FROM `category` ORDER BY category_id DESC');
$satement->execute();
$categories = $satement->fetchAll(PDO::FETCH_ASSOC);

?>

<!doctype html>
<html lang="en">
  <head>
    <title>index</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      <h1>Product CRUD</h1>
      <table class="table">
          <p>
         <a href="create.php" class="btn btn-success">GO Back to Products </a>
       </p>
          <thead>
              <tr>
                  <th scope ="col">#</th>
                  <th scope ="col">Image</th>
                  <th scope ="col">name</th>
                  <th scope ="col">Description</th>
              </tr>
          </thead>
          <tbody>
              <?php foreach ($categories as $i => $category): ?>
              <tr>
                  <th scope = "row"><?php echo $i + 1; ?></th>
                  <td><?php echo "<img src=" . $category["category_img"] . " width=100px height=100px>" ?></td>
                  <td><?php echo $category["category_name"] ?></td>
                  <td><?php echo $category["category_des"] ?></td>
                  <td> <a class="btn btn-outline-primary" href="update.php?id=<?php echo $category['category_id'] ?>">Edit</a>
                  <form style ="display:inline-block" action="delete.php" method="post">
                      <input type="hidden" name="id" value="<?php echo $category['category_id'] ?>">
                      <button type="submit" class="btn btn-outline-danger" href="delete?=<?php echo $category['category_id'] ?>" >Delete</button> </td>
                  </form>     


              </tr>
              <?php endforeach;?>
          </tbody>
      </table>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>