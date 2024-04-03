<?php
include_once "../includes/functions.php";
include_once "../includes/connection.php";

session_start();
if(isset($_SESSION['author_role'])){
    if(isset($_GET['logout'])){
        //Simple exit message
        $logout_message = "<div class='msgln'><span class='left-info'>User <b class='user-name-left'>". $_SESSION['author_name'] ."</b> has left the chat session.</span><br></div>";
        file_put_contents("log.html", $logout_message, FILE_APPEND | LOCK_EX);

        session_destroy();
        header("Location: ../index.php"); //Redirect the user
    }

    if(isset($_POST['enter'])){
        if($_POST['name'] != ""){
            $_SESSION['name'] = stripslashes(htmlspecialchars($_POST['name']));
        }
        else{
            echo '<span class="error">Please type in a name</span>';
        }
    }

    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>The Shed Chat</title>
        <meta name="description" content="Website Chatbox" />
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
            $(document).ready(function(){
                // Fade out the message after 5 seconds
                setTimeout(function(){
                    $('.alert-message').fadeOut('slow');
                }, 5000); // 5 seconds
            });
        </script>
    </head>
    <body id="chatbody" data-spy="scroll" data-target="#navbarResponsive">
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

            </div>
            <ul class="navbar-nav m-2">
                <li class="nav-item text-nowrap">
                    <a id="exit" class="nav-link" style="text-decoration:none;" href="#">Log out</a>
                </li>
            </ul>
        </div>
    </nav>
    <!--End of Navigation-->
    <!--Start of Hero-->
    <div id="contacthero" class="position-relative">
        <div class="p-5 text-center bg-image rounded-3" style="background-image: url('../Shed_img/mens-shed.jpg'); height: 250px;">
            <div class="mask w-100 d-flex justify-content-center align-items-center" style="background-color: rgba(0, 0, 0, 0.6); position: absolute; top: 0; bottom: 0; left: 0; right: 0;">
                <div class="text-white">
                    <h2 class="display-5 mb-3">The Men's Shed - Test Valley Chat!</h2>
                </div>
            </div>
        </div>
    </div>
    <!--End of Hero-->
    <div class="col-md-2">
        <a href="../index.php" class="btn btn-primary btn-lg active m-4" role="button"  style="text-decoration:none; font-size:18px;"  >Return home</a>
    </div>
    <div id="wrapper">
        <div id="menu">
            <p class="welcome">Welcome, <b><?php echo $_SESSION['author_name']; ?></b></p>
            <?php if($_SESSION['author_role']=="admin"){?>
            <form action="clear_chat.php" method="post">
                <input class="btn btn-info" type="submit" name="clear_chat" value="Clear Chat" onclick="return confirm('Are you sure you want to clear the chat? This action cannot be undone and will clear the chat for everyone. Will only work for Admin');">
            </form>
            <?php } ?>
        </div>
        <div id="chatbox">
            <?php
            if(file_exists("log.html") && filesize("log.html") > 0){
                $contents = file_get_contents("log.html");
                echo $contents;
            }
            ?>
        </div>
        <form class="chatform" name="message" action="">
            <input name="usermsg" type="text" id="usermsg" />
            <input name="submitmsg" type="submit" id="submitmsg" value="Send" />
        </form>
    </div>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript">
        // jQuery Document
        $(document).ready(function () {
            $("#submitmsg").click(function () {
                var clientmsg = $("#usermsg").val();
                $.post("post.php", { text: clientmsg });
                $("#usermsg").val("");
                return false;
            });
            function loadLog() {
                var oldscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height before the request
                $.ajax({
                    url: "log.html",
                    cache: false,
                    success: function (html) {
                        $("#chatbox").html(html); //Insert chat log into the #chatbox div
                        //Auto-scroll
                        var newscrollHeight = $("#chatbox")[0].scrollHeight - 20; //Scroll height after the request
                        if(newscrollHeight > oldscrollHeight){
                            $("#chatbox").animate({ scrollTop: newscrollHeight }, 'normal'); //Autoscroll to bottom of div
                        }
                    }
                });
            }
            setInterval (loadLog, 2500);
            $("#exit").click(function () {
                var exit = confirm("Are you sure you want to end the session?");
                if (exit == true) {
                    window.location = "index.php?logout=true";
                }
            });
        });
    </script>
    </body>
    </html>
    <?php
}else{
    header("Location: ../admin/login.php?message=Please+Login");
}
?>
