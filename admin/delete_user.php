<?php

require 'auth.php';
require '../db.php';

/* DELETE USER */
function deleteUser($pdo, $id)
{
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    return $stmt->execute([$id]);
}

/* GET ID */
$id = (int)($_GET['id'] ?? 0);

/* VALIDATE */
if ($id <= 0) {
    header("Location: manage_users.php");
    exit();
}

/* DELETE */
deleteUser($pdo, $id);

/* REDIRECT */
header("Location: manage_users.php");
exit();

?>