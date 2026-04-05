<?php

require 'auth.php';
require '../db.php';


/* --GET ID-- */
/* Retrieve user ID from URL */
$id = (int)($_GET['id'] ?? 0);


/* --VALIDATE-- */
/* Ensure valid user ID */
if ($id <= 0) {
    header("Location: manage_users.php");
    exit();
}


/* --DELETE USER-- */
/* Remove user from database */
function deleteUser($pdo, $id)
{
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    return $stmt->execute([$id]);
}


/* --EXECUTE DELETE-- */
deleteUser($pdo, $id);


/* --REDIRECT-- */
/* Return to user management page */
header("Location: manage_users.php");
exit();

?>