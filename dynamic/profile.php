<?php
include_once "../includes/functions.php";
include_once "../includes/connection.php";
session_start();
if(isset($_SESSION['author_role'])){
 
					if(isset($_POST['update'])){
						$author_name = mysqli_real_escape_string($conn, $_POST['author_name']);
						$author_email = mysqli_real_escape_string($conn, $_POST['author_email']);
						$author_password = mysqli_real_escape_string($conn, $_POST['author_password']);
						$author_bio = mysqli_real_escape_string($conn, $_POST['author_bio']);
						
						//checking if fields are empty
						if(empty($author_name) OR empty($author_email) OR empty($author_bio)){
							echo "Empty Fields";
						}else{
							//checking if email is valid
							if(!filter_var($author_email, FILTER_VALIDATE_EMAIL)){
								echo "Pleaseenter a Valid email!";
							}else{
								//check if password entered is new
								if(empty($author_password)){
									//user dont want to change his password
									$author_id = $_SESSION['author_id'];
									$sql = "UPDATE `author` SET author_name='$author_name', author_email='$author_email', author_bio='$author_bio' WHERE author_id='$author_id';";
									if(mysqli_query($conn, $sql)){										
										$_SESSION['author_name'] = $author_name;
										$_SESSION['author_email'] = $author_email;
										$_SESSION['author_bio'] = $author_bio;
										header("Location: index.php?message=Record+Updated");
										
									}else{
										echo "error";
									}
								}else{
									//user wants to change his password
									$hash = password_hash($author_password, PASSWORD_DEFAULT);
									$author_id = $_SESSION['author_id'];
									$sql = "UPDATE `author` SET author_name='$author_name', author_email='$author_email', author_bio='$author_bio', author_password='$hash' WHERE author_id='$author_id';";
									if(mysqli_query($conn, $sql)){										
										session_unset();
										session_destroy();
										header("Location: login.php?message=Record+Updated+You+may+login+again+now");
										
										
									}else{
										echo "error";
									}
								}
							}
						}
					}
				
	?>
<!DOCTYPE html>
<html lang="eng">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <title>Men's Shed</title>
    <link rel="stylesheet" href="Shed.css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">

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

<body id="profile-background">
    <a class="nav-link active" aria-current="page" href="index.html"><i class="bi-house-door"></i>Home
    </a>
    <div class="container emp-profile">
        <form method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="profile-img">
                        <img src="img/minion profile pcitures/minion6Kevin.jpg"
                            alt="" />
                        <div class="file btn btn-lg btn-primary">
                            Change Photo
                            <input type="file" name="file" />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="profile-head">
                        <h5>
                            Kevin minion
                        </h5>
                        <h6>
                            Master of mischief                        </h6>
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab"
                                    aria-controls="home" aria-selected="true">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                                    aria-controls="profile" aria-selected="false">Timeline</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-2">
                    <input type="submit" class="profile-edit-btn" name="btnAddMore" value="Edit Profile" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 text-md-end">
                    <div class="tab-content profile-tab" id="myTabContent">
                        <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>User Id</label>
                                </div>
                                <div class="col-md-6">
                                    <p>Kevin123</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Name</label>
                                </div>
                                <div class="col-md-6">
                                <input name="author_name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name"value="<?php echo $_SESSION['author_name']; ?>"><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Email</label>
                                </div>
                                <div class="col-md-6">
                                    <<input name="author_email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email"value="<?php echo $_SESSION['author_email']; ?>"><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Password</label>
                                </div>
                                <div class="col-md-6">
                                <input name="author_password" type="password" class="form-control" id="exampleInputPassword1" placeholder="Password"><br>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>You bio</label>
                                </div>
                                <div class="col-md-6">
                                <textarea name="author_bio" class="form-control" id="exampleFormControlTextarea1" rows="3"><?php echo $_SESSION['author_bio']; ?></textarea><br>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Experience</label>
                                </div>
                                <div class="col-md-6">
                                    <p>Expert</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Hourly Rate</label>
                                </div>
                                <div class="col-md-6">
                                    <p>10$/hr</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Total Projects</label>
                                </div>
                                <div class="col-md-6">
                                    <p>230</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>English Level</label>
                                </div>
                                <div class="col-md-6">
                                    <p>Expert</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label>Availability</label>
                                </div>
                                <div class="col-md-6">
                                    <p>6 months</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <label>Your Bio</label><br />
                                    <p>Your detail description</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

</body>

</html>