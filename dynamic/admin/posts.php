<?php
include_once '../includes/functions.php';
include_once '../includes/connection.php';

session_start();
if (isset($_SESSION['author_role'])) {

    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Projects</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../style/bootstrap.min.css">
        <link rel="stylesheet" href="../Shed.css">
        <link rel="icon" href="../Shed_img/Shed02.png" />
        <link href="../css/bootstrap.min.css" rel="stylesheet">

        <!--https://www.bootstrapcdn.com/ -->
        <!--cdn.jsdelivr.net-->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqBootstrapValidation/1.3.6/jqBootstrapValidation.js"></script>

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
            $(document).ready(function() {
                // Fade out the message after 5 seconds
                setTimeout(function() {
                    $('.alert-message').fadeOut('slow');
                }, 5000); // 5 seconds
            });
        </script>
    </head>

    <body data-spy="scroll" data-target="#navbarResponsive">
        <?php
        if (isset($_GET['message'])) {
            $msg = $_GET['message'];
            echo '<div class="alert-message" role="alert">' . $msg . '</div>';
        }
        ?>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="Shed.html"><img src="../Shed_img/ShedLogo.png"></a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">Sign out</a>
                        </li>
                        <?php if ($_SESSION['author_role'] == 'admin') { ?>
                            <li class="nav-item">
                                <a class="nav-link mx-4" href="invite.php">Invite member</a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </nav>
        <!--End of Navigation-->

        <div class="container-fluid py-4 mb-4 mt-4">
            <div class="row">
                <div class="col-md-12">

                    <h1 class="m-5 py-6">All projects:</h1>
                    <div class="row justify-content-md-front mb-3">
                        <div class="col-md-3">
                            <a href="newproject.php"><button class="btn btn-info m-2">Add a new project</button></a>
                        </div>
                        <div class="col-md-3">
                            <a href="../index.php" class="btn btn-primary btn-lg active m-2" role="button" style="text-decoration:none; font-size:18px;">Go to Website</a>
                        </div>
                    </div>

                </div>

                <div>

                    <hr>

                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Project Id</th>
                                <th scope="col">Project Image</th>
                                <th scope="col">Project Title</th>
                                <th scope="col">Author</th>
                                <?php if ($_SESSION['author_role'] == "admin") { ?>
                                    <th scope="col">Action</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM `post` ORDER BY post_id DESC";
                            $result = mysqli_query($conn, $sql);
                            while ($row = mysqli_fetch_assoc($result)) {
                                $post_title = $row['post_title'];
                                $post_image = $row['post_image'];
                                $post_author = $row['post_author'];
                                $post_content = $row['post_content'];
                                $post_id = $row['post_id'];

                                $sqlauth = "SELECT * FROM author WHERE author_id = '$post_author'";
                                $resultauth = mysqli_query($conn, $sqlauth);
                                while ($authrow = mysqli_fetch_assoc($resultauth)) {
                                    $post_author_name = $authrow['author_name'];
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo $post_id; ?></th>
                                        <td><img src="../<?php echo $post_image; ?>" width="50px" height="50px"></td>
                                        <td><?php echo $post_title; ?></td>
                                        <td><?php echo $post_author_name; ?></td>
                                        <?php if ($_SESSION['author_role'] == "admin") { ?>
                                            <td><a href="editproject.php?id=<?php echo $post_id; ?>"><button class="btn btn-info">Edit</button></a> <a onclick='return confirm("Are You sure you want to delete this project?");' href='deletepost.php?id=<?php echo $post_id; ?>'><button class="btn btn-danger">Delete</button></a></td>
                                        <?php } ?>
                                    </tr>

                            <?php }
                            } ?>

                        </tbody>
                    </table>

                </div>

            </div>
        </div>

        <script src="../js/jquery.js"></script>
        <script src="../js/bootstrap.min.js"></script>
        <script src="../js/scroll.js"></script>
    </body>

    </html>
<?php
} else {
    header("Location: login.php?message=Please+Login");
}
?>
