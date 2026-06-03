<?php
function getDefects($link) {
    $sql = "SELECT * FROM defects ORDER BY created_at DESC";
    $result = mysqli_query($link, $sql);
    
    $list = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $list[] = $row;
    }
    
    return $list;
}
function addDefect($link, $point_id, $category, $severity, $description, $photo_path, $created_by) {
    $sql = "INSERT INTO defects (point_id, category, severity, description, photo_path, created_by, status, created_at) 
            VALUES ($point_id, '$category', '$severity', '$description', '$photo_path', $created_by, 'open', NOW())";
    
    if (mysqli_query($link, $sql)) {
        return mysqli_insert_id($link);
    } else {
        return false;
    }
}
