<?php
// Check if the form is submitted
if(isset($_POST['clear_chat'])) {
    // Clear the contents of log.html
    file_put_contents("log.html", "");
    echo "Chat has been cleared successfully.";
    header("Location: index.php");
    exit;
}else{
header("Location: index.php?message=You+are+not+authorized+to+clear+the+chat");
  exit;
}
?>
