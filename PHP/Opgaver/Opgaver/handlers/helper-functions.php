<?php
function CleanText($data) {
    if ($data == null) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    return $data;
}
?>