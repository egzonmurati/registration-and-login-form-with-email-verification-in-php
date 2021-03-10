
<?php 

include "connection.php";


session_start();

$errors = [];
if(isset($_POST['check'])){
   
    $code = $_POST['code'];
    $check_code = "SELECT * FROM user WHERE activationcode = $code";
    $result=mysqli_query($con,$check_code); 
    if($result->num_rows > 0){
        $fetch_data = $result->fetch_assoc();
        $fetch_code = $fetch_data['activationcode'];
     
        $status = 'verified';
        $update = "UPDATE user SET activationcode = '$status' WHERE activationcode = $fetch_code";
        $update_res = mysqli_query($con,$update); 
        if($update_res){
          
            $_SESSION['success'] = "You account now is active !";
            header('location: login.php');
            
            exit();
        }else{
            $errors[] = "Failed while updating code!";
        }
    }else{
        $errors[] = "You've entered incorrect code!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Somehow I got an error, so I comment the title, just uncomment to show -->
    <!-- <title>Code Verification</title> -->
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4 form mt-5">

            <div class="card ">
                        <div class="card-header text-white bg-primary text-center">
                        Code Verification
                        </div>
                        <div class="card-body">
                        <form  method="Post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" autocomplete="off">
                    <h2 class="text-center"></h2>
                    <?php 
                    if(isset($_SESSION['email']) && !empty($_SESSION['email'])){
                        ?>
                       
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php echo $_SESSION['email']; ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                        <?php
                    }
                    ?>
                    <?php
                    if(count($errors) > 0){
                        ?>
                      
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <?php  foreach($errors as $showerror){
                                echo $showerror;
                            }?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                        
                        <?php
                    }
                    ?>
                    <div class="form-group">
                        <input class="form-control" type="number" name="code" placeholder="Enter verification code" required>
                    </div>
                    <div class="form-group">
                        <input class="form-control button" type="submit" name="check" value="Submit">
                    </div>
                </form>
                        </div>
                     
                    </div>

             
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>
</html>
