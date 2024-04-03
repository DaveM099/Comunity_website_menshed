<?php
session_start();
include_once "../includes/functions.php";
include_once "../includes/connection.php";
?>

<?php 
			if(isset($_POST['signup'])){
				
			
				$author_email = mysqli_real_escape_string($conn, $_POST['author_email']);
				$author_password = mysqli_real_escape_string($conn, $_POST['author_password']);
             
				
				//checking for empty fields
				if(empty($author_email) OR empty($author_password)){
					header("Location: login.php?message=Empty+Fields");
					exit();
				}
				
				//checking for validity of email
				if(!filter_var($author_email,FILTER_VALIDATE_EMAIL)){
					header("Location: login.php?message=Please+Enter+A+Valid+email");
					exit();
				}else{
					//If email exists
					$sql = "SELECT * FROM `author` WHERE `author_email`='$author_email'";
					$result = mysqli_query($conn, $sql);
					if(mysqli_num_rows($result)<=0){
						header("Location: login.php?message=Login+error");
						exit();
					} else {
						while($row = mysqli_fetch_assoc($result)){
							//checking if password matches
							if(!password_verify($author_password, $row['author_password'])){
								header("Location: login.php?message=Login+error");
								exit();
							} else if(password_verify($author_password, $row['author_password'])) {
								$_SESSION['author_id'] = $row['author_id'];
								$_SESSION['author_name'] = $row['author_name'];
								$_SESSION['author_email'] = $row['author_email'];
								$_SESSION['author_bio'] = $row['author_bio'];
								$_SESSION['author_role'] = $row['author_role'];
                               
								header("Location: ../index.php?message=You+are+now+logged+in");
								exit();
							}
						}
					}
				}
			}
		?>
	
<!DOCTYPE html>
<html lang="en">
	<head>
	<title>Login Men's Shed</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../Shed.css">
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


		<!--Login area-->
		 <div class="container">    
         <div id="loginbox" style="margin-top:50px;border-style: none;vertical-align: middle;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title" style="font-size: 24px;">Sign In</div>
                        
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form id="loginform" method="post" action="login.php"class="form-horizontal" role="form">
                                    
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
										<input type="email" name="author_email" id="inputEmail" class="form-control" placeholder="Enter your Email address" required autofocus>                                       
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
										<input type="password" name="author_password" id="inputPassword" class="form-control" placeholder="Enter your Password" required>
                                    </div>
                                    

                                
                         

                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls">
									<button class="btn btn-success btn-block" name="signup" type="submit">Log  In</button>
                                      

                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-12 control">
                                        <div style="border-top: 1px solid#888; padding-top:20px; font-size:95%; font-weight:bold" >
                                            Don't have an account?
                                        <a href="../ShedContact.html" >
                                            Contact us here and we'll send you an invite link to register.
                                        </a>
                                        </div>
                                    </div>
                                </div>    
                            </form>     



                        </div>                     
                    </div>  
        </div>
		<!--End of Login area-->
		
	
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/scroll.js"></script>
	</body>
</html>