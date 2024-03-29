<?php
include_once "../includes/functions.php";
include_once "../includes/connection.php";

$message = ''; // Initialize message variable

if(isset($_POST['signup'])){
				
	$author_name = mysqli_real_escape_string($conn, $_POST['author_name']);
	$author_email = mysqli_real_escape_string($conn, $_POST['author_email']);
	$author_password = mysqli_real_escape_string($conn, $_POST['author_password']);
	
	//checking for empty fields
	if(empty($author_name) OR empty($author_email) OR empty($author_password)){
        header("Location: signup.php?message=Empty+Fields");
        exit();
	} 
	
	//checking for validity of email
	if(!filter_var($author_email,FILTER_VALIDATE_EMAIL)){
        header("Location: signup.php?message=Please+Enter+A+Valid+email");
        exit();
	}else{
		//If email exists
		$sql2 = "SELECT * FROM `author` WHERE `author_email`='$author_email'";
		$result = mysqli_query($conn, $sql2);
		if(mysqli_num_rows($result)>0){
			header("Location: signup.php?message=Email+already+exists!");
		} else {
			//hashing password
			$hash = password_hash($author_password, PASSWORD_DEFAULT);
			
			//Signing Up the USER
			$sql = "INSERT INTO `author` (`author_name`, `author_email`, `author_password`, `author_bio`, `author_role`) VALUES ('$author_name', '$author_email', '$hash', '', 'Member')";
			
			
			if(mysqli_query($conn, $sql)){
                header("Location: login.php?message=SuccessFully+Registered");
                exit();
            }else{
                header("Location: signup.php?message=Registration+Failed");
                exit();
			}
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>SignUp Men's Shed</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="admin.css">
    <link rel="icon" href="../Shed_img/Shed02.png" />
    <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.1.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <!--Alert style-->
    <style>
        .alert-message {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 12px;
            display: flex; 
            align-items: center; 
            z-index: 9999;
            padding: 20px;
            background-color: #d9edf7; 
            color: #0d2a4f;
            text-align: left;
        }
    </style>
    <!-- fade out the message after 5 seconds -->
    <script>
        $(document).ready(function(){
            // Fade out the message after 5 seconds
            setTimeout(function(){
                $('.alert-message').fadeOut('slow');
            }, 5000); // 5 seconds
        });
    </script>
</head>
<body style="background: url(../shed_img/workshop.jpg) no-repeat center center fixed; background-size: cover;">

<?php
if(isset($_GET['message'])){
    $msg = $_GET['message'];
    echo '<div class="alert-message" role="alert">
            '.$msg.'
          </div>';
}
?>
    <div class="container">    
        
        <div id="signupbox" style=" margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                   
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Sign Up</div>
                            
                        </div>  
                        <div class="panel-body" >
                            <form method="post" id="signupform" class="form-signin form-horizontal" role="form">
                                
                                <div id="signupalert" style="display:none" class="alert alert-danger">
                                    <p>Error:</p>
                                    <span></span>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="firstname" class="col-md-3 control-label">Full Name</label>
                                    <div class="col-md-9">
									<input type="text" name="author_name" id="input" class="form-control" placeholder="Enter name" required autofocus>
                                    </div>
                                </div>
                                  
                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
									<input type="email" name="author_email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
                                    </div>
                                </div>
    
                                
                                <div class="form-group">
                                    <label for="password" class="col-md-3 control-label">Password</label>
                                    <div class="col-md-9">
									<input type="password" name="author_password" id="inputPassword" class="form-control" placeholder="Password" required>
                                    </div>
                                </div>

								

                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-signup" type="submit" name="signup" class="btn btn-info"><i class="icon-hand-right"></i> &nbsp Sign Up</button>
                                    </div>
                                </div>

								<div style="border-top: 1px solid#888; padding-top:20px; font-size:95%; font-weight:bold" >
                                            Already have an account?
											<a id="signinlink" href="login.php" >Sign In to your account here!</a>
                                        </div>
                                
                              
                                
                                
                                
                            </form>
                         </div>
                    </div>

               
               
                
         </div> 
    </div>
    
	

	
	
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/scroll.js"></script>
	</body>
</html>