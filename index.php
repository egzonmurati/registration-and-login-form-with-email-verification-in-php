<?php

include "connection.php";
session_start();
$errors = [];

if (isset($_POST['submit'])) {
    $firstname = mysqli_real_escape_string($con, $_POST['name']);
    $lastname = mysqli_real_escape_string($con, $_POST['lname']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
    if (
        isset($firstname) && !empty($firstname) && isset($lastname) && !empty($lastname) && isset($email) && !empty($email) &&
        isset($password) && !empty($password) && isset($cpassword) && !empty($cpassword)
    ) {
        $sql =mysqli_query($con,"SELECT * from user WHERE email = '$email'"); 
        $count=mysqli_num_rows($sql);  
        if($count > 0){
            $errors[] = "This email are exit!!";
        }else{
            if ($password === $cpassword) {
                $passwordhash = password_hash($password, PASSWORD_BCRYPT);
                $activationcode = rand(999999, 111111);
                $sql = "INSERT INTO user (firstname,lastname,email,password,activationcode)
                VALUES ('$firstname','$lastname','$email','$passwordhash','$activationcode')";
                $result = mysqli_query($con, $sql);
                if ($result) {
                    $to = $email;
                    $subject = "Email Verification Code";
                    $message = "Your verification code is $activationcode";
                    mail($to, $subject, $message);
                    $_SESSION['email'] = "We've sent a verification code to your email - $email!";
                    header("Location: verification.php");
                }
            } else {
                $errors[] = "Password and Confirm password doesn't match!";
            }
        }
       
    } else {
        $errors[] = "All fields are required!";
    }
}

?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">

    <title>Register form PHP</title>
    <style>
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        #bg {
            width: 100%;
            height: 650px;
  position: absolute;
  top: 0;
  left: 0;
}
.card{

  
    background-color: rgba(0, 0, 0, 0.6)!important;
}
.form-control{
    background-color: rgba(0, 0, 0, 0.4)!important;
    color: red;
}
.form-label{
    color: white;
}
.form-control::-webkit-input-placeholder {
  color: white;
}
</style>
</head>

<body>
<img src="2.png" id="bg" alt="">
    <div class="container mt-4">
        <div class="row">
            <div class="col">
                <div class="mx-auto mt-5" style="width: 450px;">

                    <div class="card ">
                        <div class="card-header text-white bg-primary text-center">
                         REGISTER FORM
                        </div>
                        <div class="card-body">
                          
                            <?php
                            if (isset($errors) && !empty($errors)) {
                            ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?php foreach($errors as $error){echo $error;} ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php } ?>
                            <form class="row g-3 needs-validation" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <div class="col-md-6">
                                    <label for="validationCustom01" class="form-label">First name</label>
                                    <input type="text" class="form-control" name="name" id="validationCustom01" placeholder="First Name">

                                </div>
                                <div class="col-md-6">
                                    <label for="validationCustom02" class="form-label">Last name</label>
                                    <input type="text" class="form-control" name="lname" id="validationCustom02" placeholder="Last Name">
                                </div>
                                <div class="col-md-12">
                                    <label for="validationCustom02" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="validationCustom02" placeholder="Email">

                                </div>
                                <div class="col-md-12">
                                    <label for="validationCustom02" class="form-label">Password</label>
                                    <input type="password" class="form-control" name="password" id="validationCustom02" placeholder="Password">

                                </div>
                                <div class="col-md-12">
                                    <label for="validationCustom02" class="form-label">Confrim Password</label>
                                    <input type="password" class="form-control" name="cpassword" id="validationCustom02" placeholder="Confirm Password">

                                </div>
                                <div class="d-grid gap-2 col-6 mx-auto">
                                    <button class="btn btn-primary" name="submit" type="submit">Register</button>

                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-white bg-primary text-center">
                            Already Registered? | <a href="login.php" class="text-white">Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>

</body>

</html>