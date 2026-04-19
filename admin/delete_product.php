<?php

require 'auth.php';
require '../db.php';


/* --GET ID-- */
/* Retrieve product ID from URL */
$id = (int)($_POST['id'] ?? 0);


/* --VALIDATE-- */
/* Ensure valid ID */
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || $id <= 0) {
    header("Location: dashboard.php");
    exit();
}


/* --DELETE PRODUCT-- */
/* Remove product from database */
function deleteProduct($pdo, $id)
{
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    return $stmt->execute([$id]);
}


/* --EXECUTE DELETE-- */
deleteProduct($pdo, $id);


/* --REDIRECT-- */
/* Return to dashboard */
header("Location: dashboard.php");
exit();
