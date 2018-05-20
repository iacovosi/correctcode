<?php

include 'class.database.php';
//get conjnection singletton
$db = Database::getInstance();
$mysqli = $db->getConnection();

$id = $_REQUEST['id'];
//check if you go id
//else end
if (isset($id) && !empty($id)) {
    $id = addslashes($id);
// prepare and bind
    $stmt = $mysqli->prepare("SELECT title,descriptions FROM videos WHERE id=?");
    $stmt->bind_param("i", $decryptedid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($stmt->affected_rows > 0) {
        //calculate server data
        $serveraddress = $_SERVER['SERVER_ADDR'];
        $serverPort = $_SERVER['SERVER_PORT'];

        // output data of row
        if ($video = $result->fetch_assoc()) {
            echo '<h3>' . $video['title'] . '</h3>';
            echo '<br/>';
            echo $video['description'];
            echo '<br/>';
            echo 'You are viewing <a href="http://' . $serveraddress . ":" . $serverPort . 
                    "/" . $_SERVER['PHP_SELF'] . '?id=' . $id . '">This video</a>';
        }
        else {
            echo "<h3>Something went wrong.. we returned record!</h3>";
        }
    } else {
        echo "<h3>No Results!</h3><br/>";
        echo "0 result";
    }

    //close statement
    $stmt->close();
} else {
    echo "<h3>To use the Page! You need to send id</h3>";
}

