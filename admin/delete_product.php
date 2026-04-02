<?php

require 'auth.php';
require '../db.php';

/* DELETE PRODUCT */
function deleteProduct($pdo, $id)
{
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    return $stmt->execute([$id]);
}

/* GET ID */
$id = (int)($_GET['id'] ?? 0);

/* VALIDATE */
if ($id <= 0) {
    header("Location: dashboard.php");
    exit();
}

/* DELETE */
deleteProduct($pdo, $id);

/* REDIRECT */
header("Location: dashboard.php");
exit();

?>