<?php
include_once "../includes/functions.php";
include_once "../includes/connection.php";

session_start();
if(isset($_SESSION['author_role'])){
    if(isset($_POST['submit'])){
        // Handle form submission
        $post_title = mysqli_real_escape_string($conn, $_POST['post_title']);
        $post_category = mysqli_real_escape_string($conn, $_POST['post_category']);
        $post_content = mysqli_real_escape_string($conn, $_POST['post_content']);
        $post_keywords = mysqli_real_escape_string($conn, $_POST['post_keywords']);
        $post_author = $_SESSION['author_id'];
        $post_date = date("d/m/y");

        // Checking if above fields are empty
        if(empty($post_title) OR empty($post_category)){
            header("Location: newproject.php?message= Fields can not be empty");
            exit();
        }

        $file = $_FILES['file'];

        $fileName = $file['name'];
        $fileType = $file['type'];
        $fileTmp = $file['tmp_name'];
        $fileErr = $file['error'];
        $fileSize = $file['size'];

        $fileEXT = explode('.',$fileName);
        $fileExtension = strtolower(end($fileEXT));

        //remove special characters and spaces
         $fileName = preg_replace("/[^A-Za-z0-9\-_\.]/", '_', $fileName);
        //allowed formats
        $allowedExt = array("jpg","JPG", "jpeg", "png", "gif");

        if(in_array($fileExtension, $allowedExt)){
            if($fileErr === 0){
                if($fileSize < 5000000){
                    $newFileName = uniqid('',true).'.'.$fileExtension;
                    $destination = "../uploads/$newFileName";
                    $dbdestination = "uploads/$newFileName";
                    move_uploaded_file($fileTmp, $destination);
                    $sql = "INSERT INTO post (`post_title`,`post_content`,`post_category`, `post_author`, `post_date`, `post_keywords`, `post_image`) VALUES ('$post_title', '$post_content', '$post_category', '$post_author', '$post_date', '$post_keywords', '$dbdestination');";
                    if(mysqli_query($conn, $sql)){
                        header("Location: posts.php?message=Project+Published");
                        exit();
                    }else{
                        header("Location: newproject.php?message=Error");
                        exit();
                    }
                } else {
                    header("Location: newproject.php?message= Your file is too big to upload");
                    exit();
                }
            }else{
                header("Location: newproject.php?message=Oops Error Uploading your file");
                exit();
            }
        }else{
            header("Location: newproject.php?message=Invalid+File+Format");
            exit();
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../style/bootstrap.min.css">
    <link rel="stylesheet" href="../shed.css">
    <link rel="icon" href="../Shed_img/Shed02.png" />

    <script type="module" src="main.js"></script>
    <script type="text/javascript" src="../bootstrap/js/bootstrap.min.js"></script>

    <link href="../css/bootstrap.min.css" rel="stylesheet">


    <!--https://www.bootstrapcdn.com/ -->
    <!--cdn.jsdelivr.net-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">


    <script src="https://cdnjs/cloudflare.com/ajax/libs/jqBootstrapValidation/1.3.6/jqBootstrapValidation.js"></script>

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
<body data-spy="scroll" data-target="#navbarResponsive">
<!-- Navigation-->
<nav class="navbar navbar-expand-lg fixed-top navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="Shed.html"><img src="../Shed_img/ShedLogo.png"></a>
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarNavDropdown"
        >
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a href="posts.php" class="nav-link fw-semibold">All projects</a>
                </li>
                <li class="nav-item">
                    <a href="../index.php" class="nav-link fw-semibold">Return to website</a>
                </li>

            </ul>
        </div>
        <ul class="navbar-nav m-2">
            <li class="nav-item text-nowrap">
                <a class="nav-link" href="logout.php">Sign out</a>
            </li>
        </ul>
    </div>
</nav>
<!--End of Navigation-->


<div class="container-fluid ">
    <div class="row">
        <h6>Welcome <?php echo $_SESSION['author_name']; ?> | You are logged in as <?php echo $_SESSION['author_role']; ?></h6>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">


            </div>

            <div id="admin-index-form">
                <?php
                if(isset($_GET['message'])){
                    $msg = $_GET['message'];
                    echo '<div class="alert-message" role="alert">
					'.$msg.'
				  </div>';
                }
                ?>
                 <form method="post" enctype="multipart/form-data" class="m-5">
                    <h4 class="m-2 py-5" >Add a new project</h4>
					<legend>Project Title</legend>
					 <input type="text" name="post_title" class="form-control" placeholder="Post Title"><br>
					 
					<legend>Project Category</legend>
                    <p>Choose a catergory for your project from the following dropdown menu list</p>
					<select name="post_category" class="form-control" id="exampleFormControlSelect1">
					<?php
						$sql = "SELECT * FROM `category`";
						$result = mysqli_query($conn, $sql);
						while($row=mysqli_fetch_assoc($result)){
							$category_id = $row['category_id'];
							$category_name = $row['category_name'];
							?>
							<option value="<?php echo $category_id; ?>"><?php echo $category_name; ?></option>
							<?php
						}
					?>
					</select><br>
					
					<legend>Project description</legend>
					<textarea name="post_content" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea><br>
					
					<legend>Project Image</legend>
                    <p>Choose an image with any of the following formats: jpg, jpeg, png, gif</p>
					<input type="file" name="file" class="form-control-file" id="exampleFormControlFile1"><br>
					
					<legend>Project Keywords</legend>
                    <p>Note: These can't be changed once submitted</p>
					 <input type="text" name="post_keywords" class="form-control" placeholder="Enter Keywords"><br>
					 
					 
					 <button name="submit" type="submit" class="btn btn-primary">Submit</button>
				</form>
				
				
				 
			
			
			</div>
        
          </div>
        </main>
      </div>
    </div>
	
	<script src="../js/jquery.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/scroll.js"></script>
	</body>
</html>
	<?php
}else{
	header("Location: login.php?message=Please+Login");
}
?>
