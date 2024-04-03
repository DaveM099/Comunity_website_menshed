<?php
include_once 'includes/connection.php';
include_once 'includes/functions.php';
if ( !isset( $_GET[ 'id' ] ) ) {
    header( 'Location: index.php?geterr' );
} else {
    $id = mysqli_real_escape_string( $conn, $_GET[ 'id' ] );
    if ( !is_numeric( $id ) ) {
        header( 'Location: index.php?numerror' );
        exit();
    } else if ( is_numeric( $id ) ) {
        $sql = "SELECT * FROM post WHERE post_id='$id'";
        $result = mysqli_query( $conn, $sql );
        //Check if posts exits
        if ( mysqli_num_rows( $result ) <= 0 ) {
            //no posts
            header( 'Location: index.php?noresult' );
        } else if ( mysqli_num_rows( $result )>0 ) {
            while( $row = mysqli_fetch_assoc( $result ) ) {
                $post_title = $row[ 'post_title' ];
                $post_content = $row[ 'post_content' ];
                $post_date = $row[ 'post_date' ];
                $post_image = $row[ 'post_image' ];
                $post_keywords = $row[ 'post_keywords' ];
                $post_author = $row[ 'post_author' ];
                $post_category = $row[ 'post_category' ];
                ?>

                <!DOCTYPE html>
                <html lang = 'en'>
                <head>
                <meta charset = 'utf-8' />
                <meta name = 'viewport' content = 'width=device-width, user-scalable=no' />
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
        <a class="navbar-brand" href="Shed.html"><img src="Shed_img/ShedLogo.png"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
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
                <li class = 'nav-item'>
                <a href = 'index.php' class = 'nav-link fw-semibold'>Projects</a>
                </li>
                <li class = 'nav-item'>
                <a href = 'gallery.html' class = 'nav-link fw-semibold'>Gallery</a>
                </li>
                <li class = 'nav-item'>
                <a href = 'ShedContact.html' class = 'nav-link btn btn-outline-light fw-semibold px-4 mx-4'>Contact</a>
                </li>
                </ul>
                <ul class = 'navbar-nav ml-auto'>
                <li class = 'nav-item dropdown'>
                <a class = 'nav-link dropdown-toggle' href = '#' role = 'button' data-bs-toggle = 'dropdown' aria-expanded = 'false'>
                Members
                </a>
                <ul class = 'dropdown-menu'>
                <li><a class = 'dropdown-item' href = '../dynamic/admin/posts.php'>Dashboard</a></li>
                <li><a class = 'dropdown-item' href = '../dynamic/admin/profile.php'>My Profile</a></li>
                <li><a class = 'dropdown-item' href = '../dynamic/admin/login.php'>Login</a></li>
                </ul>
                </li>
                <li class = 'nav-item'>
                <a class = 'nav-link' href = '../dynamic/admin/logout.php'>Sign out</a>
                </li>
                </ul>
                </div>
                </div>
                </nav>

                <!--End of Navigation-->
                <!--Start of Hero-->
                <div id = 'contacthero' class = 'position-relative'>
                <div class = 'p-5 text-center bg-image rounded-3' style = "background-image: url('Shed_img/mens-shed.jpg'); height: 500px;">
                <div class = 'mask w-100 d-flex justify-content-center align-items-center' style = 'background-color: rgba(0, 0, 0, 0.6); position: absolute; top: 0; bottom: 0; left: 0; right: 0;'>
                <div class = 'text-white'>
                <h1 class = 'display-4 mb-3'>The Men's Shed</h1>
                    </div>
               </div>
           </div>
        </div>
      <!--End of Hero-->

    <!-- Start of project section-->
	<section class="py-6 my-4">
    <div class="container py-6">
        <div class="row">
            <div class="col-lg-6 mt-4 mt-lg-0">
                <img class="img-fluid mb-4" src="<?php echo $post_image; ?>" alt="Project Image">
            </div>
            <div class="col-lg-6">
                <h1><?php echo $post_title; ?></h1>
                <h6>Posted On: <?php echo $post_date; ?> | By: <?php getAuthorName($post_author); ?></h6>
                <h4>Category: <?php getCategoryName($post_category); ?></h4>

                <hr>
                <h4>Description:</h4>
				<div style="max-height: 500px; overflow-y: auto;">
				    <p><?php echo $post_content; ?></p>
			    </div>


            </div>
        </div>
    </div>
</section>













<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/scroll.js"></script>

</body>

<!--start of footer-->
<footer class="footer-bs">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-md-6 col-lg-4">
                <h5 class="my-4">
                    Opening Times
                </h5>
                <table id="hours">
                    <tbody>

                        <tr>
                            <td>
                                Tuesday
                            </td>
                            <td>
                                9:00
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                12:00
                            </td>
                        </tr>

                        <tr>
                            <td>
                                Thursday
                            </td>
                            <td>
                                9:00
                            </td>
                            <td>
                                -
                            </td>
                            <td>
                                12:00
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-4">

                    <h5 class="h5 my-4">
                        Where are we?
                    </h5>

                        <iframe style="border:0;"
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2483.621588833226!2d-0.10138978208233192!3d51.50181131713625!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x487604a7ad8695e7%3A0x77977f1c5c6ea419!2sMint%20Street%20Park!5e0!3m2!1sen!2suk!4v1661278379284!5m2!1sen!2suk"
                            width="me-auto" height="450" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>


            </div>
            <div class="col-sm-12 col-md-12 col-lg-4">
                <div class="row">
                    <div class=" col-sm-6 col-md-6 col-lg-0 contact footer">
                        <h5 class="my-4">
                            Contact Details
                        </h5>
                        <p>
                            <strong>Email: </strong><a
                                href="mailto:Email@address.com"><strong>Email@Address.com</strong></a>
                        </p>
                        <p>
                            <strong>Tel: 07634859845</strong>
                        </p>
                    </div>
                </div>
                <hr>
                <div class=" col-sm-6 col-md-6 col-lg-12">
                    <p>Copyright &copy; Test Valley Men's Shed 2024</p>
                </div>

                <a target = '_blank' href = 'https://icons8.com/icon/R8YGrGsiFiTq/workshop'>Workshop</a> icon by <a target = '_blank' href = 'https://icons8.com'>Icons8</a>
                </div>

                </div>
                </div>
                </footer>
                </html>

                <?php
            }
        }
    }
}
?>
