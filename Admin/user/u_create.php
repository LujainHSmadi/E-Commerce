<?php
@include '../includes/connect.php';
$errors = [];
$flag = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];
    $username = $_POST['username'];
    
    if (empty($password)) {
        $errors[] = 'password title is required';

    }
    if (empty($email)) {
        $errors[] = 'email is required';

    }
    if (empty($username)) {
        $errors[] = 'username is required';

    }
    if (empty($phone)) {
        $errors[] = 'phone is required';

    }
    if (empty($address)) {
        $errors[] = 'address is required';

    }
    if (empty($city)) {
        $errors[] = 'city is required';

    }
      
    if (empty($errors)) {
       
        $query = "INSERT INTO `user`(`user_id`, `password`, `email`, `address`, `city`, `phone`, `username`)
        VALUES (NULL,:password,:email,:address,:city,:phone,:username)";

        $statment = $conn->prepare($query);
        $statment->bindValue(':password', $password);
        $statment->bindValue(':email', $email);
        $statment->bindValue(':address', $address);
        $statment->bindValue(':city', $city);
        $statment->bindValue(':phone', $phone);
        $statment->bindValue(':username', $username);
        $statment->execute();
        $flag = true;
        
        if($flag){?>
        <div class="alert alert-success" role="alert">
      <?php
             echo "YOU HAVE REGISTERED SUCCESSFULLY!"?>
        </div>
        <?php
                // header('Location:index.php');
            }
        }
    }
?>



<!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
      



  <form class="needs-validation" novalidate method = "post" action="">
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="validationCustom01">User name</label>
      <input type="text" class="form-control" id="validationCustom01" placeholder="Username" name="username" required>
      <div class="valid-feedback">
        Looks good!
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationCustom02">Password</label>
      <input type="password" class="form-control" id="validationCustom02" placeholder="password" name="password" required>
      <div class="valid-feedback">
        Looks good!
      </div>
    </div>
    <div class="col-md-4 mb-3">
      <label for="validationCustomUsername">E-mail</label>
      <div class="input-group">
        
        <input type="email" class="form-control" id="validationCustomUsername" placeholder="Email" aria-describedby="inputGroupPrepend" name="email" required>
        <div class="invalid-feedback">
          Please choose an email.
        </div>
      </div>
    </div>
  </div>
  <div class="form-row">
    <div class="col-md-6 mb-3">
      <label for="validationCustom03">City</label>
      <input type="text" class="form-control" id="validationCustom03" placeholder="City" name="city" required>
      <div class="invalid-feedback">
        Please provide a valid city.
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <label for="validationCustom04">Address</label>
      <input type="text" class="form-control" id="validationCustom04" placeholder="Address" name="address" required>
      <div class="invalid-feedback">
        Please provide a valid address.
      </div>
    </div>
    <div class="col-md-3 mb-3">
      <label for="validationCustom05">Phone</label>
      <input type="tel" class="form-control" id="validationCustom05" placeholder="example : +962 000 000 000" name="phone" required>
      <div class="invalid-feedback">
        Please provide a valid phone number.
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" value="" id="invalidCheck" required>
      <label class="form-check-label" for="invalidCheck">
        Agree to terms and conditions
      </label>
      <div class="invalid-feedback">
        You must agree before submitting.
      </div>
    </div>
  </div>
  <button class="btn btn-primary" type="submit">Submit form</button>
</form>

<script>
// Example starter JavaScript for disabling form submissions if there are invalid fields
(function() {
  'use strict';
  window.addEventListener('load', function() {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    var forms = document.getElementsByClassName('needs-validation');
    // Loop over them and prevent submission
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add('was-validated');
      }, false);
    });
  }, false);
})();
</script>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>