<?php
include_once '../includes/functions.php';
include_once '../includes/connection.php';

session_start();
if ( isset( $_SESSION[ 'author_role' ] ) ) {
    if ( $_SESSION[ 'author_role' ] == 'admin' ) {
        if ( isset( $_GET[ 'id' ] ) ) {
            $post_id = $_GET[ 'id' ];
            if ( isset( $_POST[ 'submit' ] ) ) {
                $post_title = mysqli_real_escape_string( $conn, $_POST[ 'post_title' ] );
                $post_content = mysqli_real_escape_string( $conn, $_POST[ 'post_content' ] );

                // Checking if above fields are empty
                if ( empty( $post_title ) OR empty( $post_content ) ) {
                    echo '<script>window.location = "posts.php?message=Empty+Fields";</script>';
                    exit();
                }

                if ( is_uploaded_file( $_FILES[ 'file' ][ 'tmp_name' ] ) ) {
                    // User wants to update the file too
                    $file = $_FILES[ 'file' ];

                    $fileName = $file[ 'name' ];
                    $fileType = $file[ 'type' ];
                    $fileTmp = $file[ 'tmp_name' ];
                    $fileErr = $file[ 'error' ];
                    $fileSize = $file[ 'size' ];

                    $fileEXT = explode( '.', $fileName );
                    $fileExtension = strtolower( end( $fileEXT ) );

                    // Remove special characters and spaces
                    $fileName = preg_replace( '/[^A-Za-z0-9\-_\.]/', '_', $fileName );
                    // Allowed formats
                    $allowedExt = array( 'jpg', 'JPG', 'jpeg', 'png', 'gif' );

                    if ( in_array( $fileExtension, $allowedExt ) ) {
                        if ( $fileErr === 0 ) {
                            if ( $fileSize < 5000000 ) {
                                $newFileName = uniqid( '', true ) . '.' . $fileExtension;
                                $destination = "../uploads/$newFileName";
                                $dbdestination = "uploads/$newFileName";
                                move_uploaded_file( $fileTmp, $destination );
                                $sql = 'UPDATE post SET post_title=?, post_content=?, post_image=? WHERE post_id=?';
                                $stmt = mysqli_prepare( $conn, $sql );

                                // Bind parameters
                                mysqli_stmt_bind_param( $stmt, 'sssi', $post_title, $post_content, $dbdestination, $post_id );

                                // Execute the statement
                                if ( mysqli_stmt_execute( $stmt ) ) {
                                    echo '<script>window.location = "posts.php?message=Project+Updated";</script>';
                                } else {
                                    echo '<script>window.location = "posts.php?message=Error";</script>';
                                }

                                // Close statement
                                mysqli_stmt_close( $stmt );
                            } else {
                                echo '<script>window.location = "newproject.php?message= Your file is too big to upload!";</script>';
                                exit();
                            }
                        } else {
                            echo '<script>window.location = "newproject.php?message=Oops Error Uploading your file";</script>';
                            exit();
                        }
                    } else {
                        echo '<script>window.location = "newproject.php?message=YOUR FILE IS TOO BIG TO UPLOAD!";</script>';
                        exit();
                    }
                } else {
                    // User doesn´t want to update the file
                    $sql = "UPDATE post SET post_title='$post_title', post_content='$post_content' WHERE post_id='$post_id'";
                    if ( mysqli_query( $conn, $sql ) ) {
                        echo '<script>window.location = "posts.php?message=Post+Updated";</script>';
                    } else {
                        echo '<script>window.location = "posts.php?message=Error";</script>';
                    }
                }
            }
            ?>
            <!DOCTYPE html>
            <html lang = 'en'>

            <head>
            <title>Edit project</title>
            <meta name = 'viewport' content = 'width=device-width, initial-scale=1'>
            <link rel = 'stylesheet' href = '../style/bootstrap.min.css'>
            <link rel = 'stylesheet' href = '../shed.css'>
            <link rel = 'icon' href = '../Shed_img/Shed02.png' />

            <script type = 'module' src = 'main.js'></script>
            <script type = 'text/javascript' src = '../bootstrap/js/bootstrap.min.js'></script>

            <link href = '../css/bootstrap.min.css' rel = 'stylesheet'>

            <!--https://www.bootstrapcdn.com/ -->
            <!--cdn.jsdelivr.net-->
            <link rel = 'stylesheet' href = 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity = 'sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin = 'anonymous'>

            <script src = 'https://cdnjs/cloudflare.com/ajax/libs/jqBootstrapValidation/1.3.6/jqBootstrapValidation.js'></script>

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

            </head>

            <body data-spy = 'scroll' data-target = '#navbarResponsive'>
            <!-- Navigation-->
            <nav class = 'navbar navbar-expand-lg fixed-top navbar-dark'>
            <div class = 'container'>
            <a class = 'navbar-brand' href = 'Shed.html'><img src = '../Shed_img/ShedLogo.png'></a>
            <button class = 'navbar-toggler' type = 'button' data-bs-toggle = 'collapse' data-bs-target = '#navbarNavDropdown'>
            <span class = 'navbar-toggler-icon'></span>
            </button>
            <div class = 'collapse navbar-collapse' id = 'navbarNavDropdown'>
            <ul class = 'navbar-nav ms-auto'>
            <li class = 'nav-item'>
            <a href = 'posts.php' class = 'nav-link fw-semibold'>All projects</a>
            </li>
            <li class = 'nav-item'>
            <a href = '../index.php' class = 'nav-link fw-semibold'>Return to website</a>
            </li>

            </ul>
            </div>
            <ul class = 'navbar-nav m-2'>
            <li class = 'nav-item text-nowrap'>
            <a class = 'nav-link' href = 'logout.php'>Sign out</a>
            </li>
            </ul>
            </div>
            </nav>
            <!--End of Navigation-->

            <div class = 'container-fluid '>
            <div class = 'row'>
            <h6>Welcome <?php echo $_SESSION[ 'author_name' ];
            ?> | You are logged in as <?php echo $_SESSION[ 'author_role' ];
            ?></h6>

            <main role = 'main' class = 'col-md-9 ml-sm-auto col-lg-10 px-4'>
            <div class = 'd-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom'>

            </div>

            <div id = 'admin-index-form'>
            <?php
            if ( isset( $_GET[ 'message' ] ) ) {
                $msg = $_GET[ 'message' ];
                echo '<div class="alert-message" role="alert">
					' . $msg . '
				  </div>';
            }
            ?>
            <?php
            $post_id = $_GET[ 'id' ];
            $FormSql = "SELECT * FROM post WHERE post_id='$post_id'";
            $FormResult = mysqli_query( $conn, $FormSql );
            while ( $FormRow = mysqli_fetch_assoc( $FormResult ) ) {

                $postTitle = $FormRow[ 'post_title' ];
                $postContent = $FormRow[ 'post_content' ];
                $postImage = $FormRow[ 'post_image' ];

                ?>
                <form method = 'post' enctype = 'multipart/form-data' class = 'm-5'>
                <h4 class = 'm-2 py-5'>Edit your project</h4>
                <legend>Project Title</legend>
                <input type = 'text' name = 'post_title' class = 'form-control' placeholder = 'Post Title' value = "<?php echo $postTitle; ?>"><br>

                <legend>Project description</legend>
                <textarea name = 'post_content' class = 'form-control' id = 'exampleFormControlTextarea1' rows = '9'><?php echo $postContent ?></textarea><br>

                <img src = "../<?php echo $postImage; ?>" width = '150px' height = '150px' alt = ''><br>
                <legend>Project Image</legend>
                <p>Choose an image with any of the following formats: jpg, jpeg, png, gif</p>
                <p >Note: The image will change after you select "Update"</p>
                <input type = 'file' name = 'file' class = 'form-control-file' id = 'exampleFormControlFile1'><br>

                <button name = 'submit' type = 'submit' class = 'btn btn-primary m-4'>Update</button>
                </form>
                <?php }
                ?>

                </div>

                </main>
                </div>
                </div>

                <script src = '../js/jquery.js'></script>
                <script src = '../js/bootstrap.min.js'></script>
                <script src = '../js/scroll.js'></script>

                <!-- fade out the message after 5 seconds -->
                <script>
                $( document ).ready( function() {
                    // Fade out the message after 5 seconds
                    setTimeout( function() {
                        $( '.alert-message' ).fadeOut( 'slow' );
                    }
                    , 5000 );
                    // 5 seconds
                }
            );
            </script>
            </body>

            </html>
            <?php
        }
    }
} else {
    header( 'Location: login.php?message=Please+Login' );
}
?>
