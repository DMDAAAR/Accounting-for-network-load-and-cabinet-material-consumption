<?php
function getUserByUsername($pdo, $username) {
    
    $sql = "SELECT id, login, password_hash, role FROM users WHERE login = :login";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':login' => $username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user === false) {
        return false;
    } else {
        return $user;
    }
}

function createUser($pdo, $login, $password, $role = 'operator') {
    
    $checkSql = "SELECT id FROM users WHERE login = :login";
    $checkStmt = $pdo->prepare($checkSql);
    $checkStmt->execute([':login' => $login]);
    $existingUser = $checkStmt->fetch(PDO::FETCH_ASSOC);
    
    if ($existingUser !== false) {
        return false;  
    }
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (login, password_hash, role) VALUES (:login, :password_hash, :role)";
    $stmt = $pdo->prepare($sql);
    
    return $stmt->execute([
        ':login' => $login,
        ':password_hash' => $hashedPassword,
        ':role' => $role
    ]);
}
?>