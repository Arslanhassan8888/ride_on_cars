<?php

require 'auth.php';
require '../db.php';


/* --GET USERS-- */
/* Retrieve all users (latest first) */
function getUsers($pdo)
{
    $stmt = $pdo->prepare("SELECT * FROM users ORDER BY id DESC");
    $stmt->execute();
    return $stmt->fetchAll();
}


/* --DATA-- */
$users = getUsers($pdo);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META -->
    <meta charset="UTF-8">
    <title>Manage Users</title>

    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="../images/car_logo.png">

    <!-- STYLES -->
    <link rel="stylesheet" href="../css/style.css?v=<?php echo filemtime('../css/style.css'); ?>">
    <link rel="stylesheet" href="../css/admin.css?v=<?php echo filemtime('../css/admin.css'); ?>">
</head>

<body>

    <!-- SKIP LINK -->
    <a href="#main-content" class="skip-link">Skip to main content</a>

    <!-- HEADER -->
    <?php include '../header.php'; ?>

    <!-- MAIN -->
    <main id="main-content" tabindex="-1">

        <!-- ADMIN CONTAINER -->
        <section class="admin-container">

            <!-- HEADER -->
            <header class="admin-header">
                <h1>Manage Users</h1>
                <p>Delete users from the system</p>
            </header>

            <!-- TABLE SECTION -->
            <section class="admin-table-section" aria-labelledby="user-table-title">
                <h2 id="user-table-title" class="visually-hidden">Users management table</h2>

                <!-- TABLE -->
                <table class="admin-table">

                    <!-- TABLE HEADER -->
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <!-- TABLE BODY -->
                    <tbody>

                        <!-- USER LOOP -->
                        <?php foreach ($users as $user): ?>

                            <tr>

                                <!-- ID -->
                                <td><?= $user['id'] ?></td>

                                <!-- NAME -->
                                <td><?= htmlspecialchars($user['name']) ?></td>

                                <!-- EMAIL -->
                                <td><?= htmlspecialchars($user['email']) ?></td>

                                <!-- ROLE -->
                                <td><?= htmlspecialchars($user['role']) ?></td>

                                <!-- ACTIONS -->
                                <td class="actions">

                                    <?php if ($user['role'] !== 'admin'): ?>

                                        <!-- DELETE -->
                                        <form method="POST" action="delete_user.php" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <button type="submit" class="btn-delete js-delete">Delete</button>
                                        </form>

                                    <?php else: ?>

                                        <!-- PROTECTED -->
                                        <span>
                                            <span class="visually-hidden">Admin account protected from deletion </span>Protected
                                        </span>

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endforeach; ?>

                    </tbody>

                </table>

            </section>

        </section>

    </main>

    <!-- FOOTER -->
    <?php include '../footer.php'; ?>

</body>

</html>