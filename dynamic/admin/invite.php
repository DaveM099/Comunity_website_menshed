<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

include_once "../includes/functions.php";
include_once "../includes/connection.php";

session_start();
if (isset($_SESSION['author_role'])) {
    if (isset($_POST["submit"])) {
        // Retrieve email address from the form
        $memberName = mysqli_real_escape_string($conn, $_POST["member_name"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);

           // Check if member already exists
           $query = "SELECT * FROM author WHERE author_email = '$email'";
           $result = mysqli_query($conn, $query);
           if (mysqli_num_rows($result) > 0) {
               // Email belongs to an existing member, handle accordingly
               header("Location: invite.php?message=Member+already+has+an+account");
               exit();
           }

        // Generate a unique invitation code
        $length = 10;
        $inviteCode = "";
        $characters = "0123456789abcdefghijklmnopqrstuvwxyz";
        for ($i = 0; $i < $length; $i++) {
            $inviteCode .= $characters[rand(0, strlen($characters) - 1)];
        }

        // Insert email and invite code into the database
        $query = "INSERT INTO invitations (email, inviteCode) VALUES ('$email', '$inviteCode')";
        if (mysqli_query($conn, $query)) {
            // Construct the registration link with the invitation code
            $registrationLink = "http://localhost:8080/dynamic/admin/signup.php?invite=" . $inviteCode;

            // Send email using PHPMailer
            $mail = new PHPMailer(true);
            try {
                //Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'testvalleymenshed@gmail.com';
                $mail->Password = 'fkfh qiwm ddsp xyol';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                //Recipients
                $mail->setFrom('testvalleymenshed@gmail.com', 'Test Valley Men\'s Shed');
                $mail->addAddress($email, $memberName);

                //Content
                $mail->isHTML(true);
                $mail->Subject = 'Test Valley men\'s shed invitation';
                $mail->Body = "Dear $memberName,<br><br>You have been invited to register on our website.<br><br>Registration Link: <a href='$registrationLink'>$registrationLink</a><br><br>Best regards,<br><br>Test Valley Men's Shed";

                $mail->send();
                header("Location: invite.php?message=Invite+sent+successfully");
                exit();
            } catch (Exception $e) {
                header("Location: invite.php?message=Failed+to+send+invitation+email");
                exit();
            }
        } else {
            header("Location: invite.php?message=Failed+to+insert+invitation+into+database");
            exit();
        }
    }
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
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
            integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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
        <!-- fade out the alert after 5 seconds -->
        <script>
            $(document).ready(function () {

                setTimeout(function () {
                    $('.alert-message').fadeOut('slow');
                }, 5000);
            });
        </script>
    </head>

    <body>
    <?php
if(isset($_GET['message'])){
    $msg = $_GET['message'];
    echo '<div class="alert-message" role="alert">
            '.$msg.'
          </div>';
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
                            <a class="nav-link m-2" href="logout.php">Sign out</a>
                        </li>
                        <li class="nav-item">
                            <a href="posts.php" class="nav-link fw-semibold m-2">All projects</a>
                        </li>
                        <li class="nav-item">
                            <a href="../index.php" class="nav-link fw-semibold m-2">Return to website</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!--End of Navigation-->
        <!--invite area-->
        <div class="container py-4 mt-4">
            <div  style=" margin-top:200px" class="invite box col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2""
                class=" mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h2 class="panel-title" style="font-size: 24px;">Send an invite to a shed member</h2>

                    </div>

                    <div style="padding-top:30px" class="panel-body">

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>

                        <form method="post" id="inviteform" class="form-horizontal" role="form">
                        <div class="form-group row">
                            <label for="member_name" class="col-md-3 col-form-label text-md-right">Member's Name</label>
                            <div class="col-md-9">
                                <input type="text" name="member_name" id="member_name" class="form-control" placeholder="Enter member's name">
                            </div>
                        </div>
                        <div class="form-group row mt-4 mb-4">
                            <label for="email" class="col-md-3 col-form-label text-md-right">Member's Email</label>
                            <div class="col-md-9">
                                <input id="email" name="email" type="email" class="form-control" placeholder="Enter member's email here" required autofocus>
                            </div>
                        </div>
                        <div class="form-group row mt-4 mb-4">
                            <div class="col-md-9 offset-md-3">
                                <button class="btn btn-success btn-block" name="submit" type="submit">Submit</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
        <!--End of invite area-->


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