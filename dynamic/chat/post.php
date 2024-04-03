<?php
session_start();
if(isset($_SESSION['author_name'])){
    $text = $_POST['text'];

 date_default_timezone_set('Europe/London');// uk time zone
	$text_message = "<div class='msgln'><span class='chat-time'>".date("g:i A")."</span> <b class='user-name'>".$_SESSION['author_name']."</b> ".stripslashes(htmlspecialchars($text))."<br></div>";
    file_put_contents("log.html", $text_message, FILE_APPEND | LOCK_EX);
}
?>
