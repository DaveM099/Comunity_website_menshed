<?php
session_start();
include_once "includes/connection.php";
include_once "includes/functions.php";
// Check if the user is logged in and if they are an admin
if(isset($_SESSION['author_role']) && $_SESSION['author_role'] == "admin") {
    $isAdmin = true;
} else {
    $isAdmin = false;
}
// Check if the user is logged in and if they are an admin
if(isset($_SESSION['author_role']) && $_SESSION['author_role'] == "member") {
    $ismember = true;
} else {
    $ismember = false;
}
?>
<!DOCTYPE html>
<html lang="ENG">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <title>Men's Shed</title>
    <link rel="stylesheet" type="text/css" href="Shed.css" />
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
    <link rel="icon" href="Shed_img/Shed02.png" />

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet">

    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqBootstrapValidation/1.3.6/jqBootstrapValidation.js"></script>


    <script type="text/javascript" src="jquery/jquery-3.6.4.min.js"></script>
    <script type="module" src="main.js"></script>
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

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
<?php
if(isset($_GET['message'])){
    $msg = $_GET['message'];
    echo '<div class="alert-message" role="alert">
            '.$msg.'
          </div>';
}
?>
   <!-- Navigation-->
   <nav class="navbar navbar-expand-lg fixed-top navbar-dark">
      <div class="container">
        <a class="navbar-brand" href="Shed.html"
          ><img src="Shed_img/ShedLogo.png" alt="Shed logo"
        /></a>
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
              <a href="Shed.html" class="nav-link fw-semibold">Home</a>
            </li>
            <li class="nav-item">
              <a href="menshed.html" class="nav-link fw-semibold">Men's shed</a>
            </li>
            <li class="nav-item">
              <a href="index.php" class="nav-link fw-semibold">Projects</a>
            </li>
            <li class="nav-item">
              <a href="gallery.html" class="nav-link fw-semibold">Gallery</a>
            </li>
            <li class="nav-item">
              <a
                href="ShedContact.html"
                class="nav-link btn btn-outline-light fw-semibold px-4 mx-4"
                >Contact</a
              >
            </li>
          </ul>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                role="button"
                data-bs-toggle="dropdown"
                aria-expanded="false"
              >
                Members
              </a>
              <ul class="dropdown-menu">
                <li>
                  <a class="dropdown-item" href="../dynamic/admin/posts.php"
                    >Dashboard</a
                  >
                </li>
                <li>
                  <a class="dropdown-item" href="../dynamic/admin/profile.php"
                    >My Profile</a
                  >
                </li>
                <li>
                  <a class="dropdown-item" href="../dynamic/chat/index.php"
                    >Chat</a
                  >
                </li>

              </ul>
            </li>
            <?php if(isset($_SESSION['author_role'])): ?>
        <!-- if user is signed in -->
        <li class="nav-item">
          <a class="nav-link" href="../dynamic/admin/logout.php">Log out</a>
        </li>
        <?php else: ?>
        <!-- if user is not signed in -->
        <li class="nav-item">
          <a class="nav-link" href="../dynamic/admin/login.php">Sign in</a>
        </li>
        <?php endif; ?>
          </ul>
        </div>
      </div>
    </nav>

    <!--End of Navigation-->
        <!--Start of Hero-->
        <div id="contacthero" class="position-relative">
           <div class="p-5 text-center bg-image rounded-3" style="background-image: url('Shed_img/mens-shed.jpg'); height: 500px;">
               <div class="mask w-100 d-flex justify-content-center align-items-center" style="background-color: rgba(0, 0, 0, 0.6); position: absolute; top: 0; bottom: 0; left: 0; right: 0;">
                    <div class="text-white">
                      <h1 class="display-4 mb-3">The Men's Shed</h1>
                    </div>
               </div>
           </div>
        </div>
      <!--End of Hero-->

    <!-- Start of project section-->
    <div class="container mt-5">
      <?php
//pagination
$sqlpg = "SELECT * FROM `POST`";
$resultpg = mysqli_query($conn, $sqlpg);
$totalposts = mysqli_num_rows($resultpg);
$totalpages = ceil($totalposts/6);

//pagination get
if(isset($_GET['p'])){
  $pageid = $_GET['p'];
  $start = ($pageid*6)-6;
  $sql = "SELECT * FROM `post` ORDER BY post_id DESC LIMIT $start, 6";
} else {
  $sql = "SELECT * FROM `post` ORDER BY post_id DESC LIMIT 0,6";
}
?>

<div class="row justify-content-md-end">
  <?php if(isset($_SESSION['author_role'])): ?>
      <div class="col-md-2 mb-3">
          <a href="../dynamic/admin/newproject.php" class="profile-edit-btn d-block text-center" style="text-decoration:none; font-size:18px;">Add Project</a>
      </div>
  <?php endif; ?>
  <?php if($isAdmin): ?>
      <div class="col-md-2">
          <a href="../dynamic/admin/posts.php" class="profile-edit-btn d-block text-center" style="text-decoration:none; font-size:18px;">Edit Projects</a>
      </div>
  <?php endif; ?>
</div>
</div>


</div>




    <section id="projects" class="info py-6">
            <h2 class="text-center pb-4">
                Our <span class="project-text">Projects</span>
            </h2>
            <div class="container">
            <div class="card-columns">
            <?php

                $result = mysqli_query($conn, $sql);
                while($row=mysqli_fetch_assoc($result)){
                    $post_title = $row['post_title'];
                    $post_image = $row['post_image'];
                    $post_author = $row['post_author'];
                    $post_content = $row['post_content'];
                    $post_id = $row['post_id'];

                $sqlauth = "SELECT * FROM author WHERE author_id='$post_author'";
                $resultauth = mysqli_query($conn, $sqlauth);
                while($authrow=mysqli_fetch_assoc($resultauth)) {
                    $post_author_name = $authrow['author_name'];

            ?>
                <div class="card m-4" style="max-width: 18rem;">
                    <img class="card-img-top" src="<?php echo $post_image ?>" alt="Card image cap" style="max-height: 200px;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo $post_title ?></h5>
                        <p class="card-text flex-grow-1"><?php echo substr($post_content,0, 90)."...";?> </p>
                        <a href="post.php?id=<?php echo $post_id; ?>" class="btn btn-primary mt-2">View Project</a>

                    </div>

                 </div>

               <?php }}?>
               </div>
               <?php
               echo "<center>";
               for($i=1;$i<=$totalpages;$i++){
                echo '<a href="?p='.$i.'"><button class="btn btn-info">'.$i.'</button></a>&nbsp;';
            }
            echo "</center>";
            ?>

            </div>
            <br><br>
    </section>








</body>

<!--start of footer-->
<footer class="footer-bs">
    <div class="container">
      <div class="row">
        <!-- Opening Times Section -->
        <div class="col-sm-12 col-md-6 col-lg-4">
          <h5 class="mt-2">Opening Times</h5>
          <table id="hours">
            <tbody>
              <tr>
                <td>Tuesday</td>
                <td>9:00</td>
                <td>-</td>
                <td>12:00</td>
              </tr>
              <tr>
                <td>Thursday</td>
                <td>9:00</td>
                <td>-</td>
                <td>12:00</td>
              </tr>
            </tbody>
          </table>

          <!-- Documents Section -->

          <h5 class="mt-2">Documents</h5>
          <ul>
            <li>
              <a href="PDF%20Documents/openFlyerA4.pdf">OpenFlyerA4</a>
            </li>
            <li>
              <a href="PDF%20Documents/CodeOfConductA4.pdf">CodeOfConduct</a>
            </li>
            <li>
              <a href="PDF%20Documents/pavilionFloorplan.pdf.crdownload"
                >PavilionFloorplan</a
              >
            </li>
            <li>
              <a href="PDF%20Documents/HealthAndSafetyA3.pdf"
                >HealthAndSafetyA3</a
              >
            </li>
          </ul>
        </div>

        <!-- map Section -->
        <div class="col-sm-12 col-md-6 col-lg-4">
          <h5 class="mt-2" style="width: 300px">Where are we?</h5>
          <div
            class="map_space"
            style="border: 0; width: 100%; height: 300px"
          ></div>
        </div>

        <!-- Contact Details -->
        <div class="col-sm-12 col-md-12 col-lg-4">
          <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12 contact footer">
              <h5 class="mt-2">Contact Details</h5>
              <p>
                <strong>Email: </strong
                ><a href="mailto:mensshed@gmail.com"
                  ><strong>testvalleymenshed@gmail.com</strong></a
                >
              </p>
            </div>
            <div class="col-sm-12 col-md-12 col-lg-12">
              <hr />
              <!-- Add a horizontal line between sections -->
              <p>Copyright &copy; Test Valley Men's Shed 2024</p>
              <a
                target="_blank"
                href="https://icons8.com/icon/R8YGrGsiFiTq/workshop"
                >Workshop</a
              >
               <a target="_blank" href="https://icons8.com" style="color: #ccc;"> icon by Icons8</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </footer>


    <script src='https://www.bing.com/api/maps/mapcontrol?&key=AmPfYOrhwsLeIqj_W6WCnE-YOdiziSgGqQSkSSsZPvFF5tpxXNy3lnl2wWNppFuv&callback=draw_map'></script>
    <script src="../dynamic/js/map.js"></script>





</html>
