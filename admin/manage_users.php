<?php

require 'auth.php';
require '../db.php';

/* GET USERS */
function getUsers($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM users ORDER BY id DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}

$users = getUsers($pdo);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <link rel="icon" type="image/png" href="../images/car_logo.png">

    <link rel="stylesheet" href="../css/style.css?v=<?php echo filemtime('../css/style.css'); ?>">
    <link rel="stylesheet" href="../css/admin.css?v=<?php echo filemtime('../css/admin.css'); ?>">
</head>

<body>
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <?php include '../header.php'; ?>

    <main id="main-content">

        <section class="admin-container">

            <header class="admin-header">
                <h1>Manage Users</h1>
                <p>Delete users from the system</p>
            </header>

            <section class="admin-table-section">
                <h2 class="visually-hidden-heading">Users management table</h2>

                <table class="admin-table">

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php foreach ($users as $user): ?>

                            <tr>

                                <td><?= $user['id'] ?></td>

                                <td><?= htmlspecialchars($user['name']) ?></td>

                                <td><?= htmlspecialchars($user['email']) ?></td>

                                <td><?= htmlspecialchars($user['role']) ?></td>

                                <td class="actions">

                                    <?php if ($user['role'] !== 'admin'): ?>
                                        <a href="delete_user.php?id=<?= $user['id'] ?>" class="btn-delete js-delete">
                                            Delete
                                        </a>
                                    <?php else: ?>
                                        <span>Protected</span>
                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </section>

        </section>

    </main>

    <?php include '../footer.php'; ?>

</body>

</html>