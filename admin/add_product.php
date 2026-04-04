<?php

require 'auth.php';
require '../db.php';

$error = "";

/* ADD PRODUCT */
function addProduct($pdo, $data)
{
    $sql = "INSERT INTO products 
            (name, brand, price, age_range, description, long_description, rating, stock, image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    return $stmt->execute([
        $data['name'],
        $data['brand'],
        $data['price'],
        $data['age_range'],
        $data['description'],
        $data['long_description'],
        $data['rating'],
        $data['stock'],
        $data['image']
    ]);
}

/* HANDLE IMAGE */
function handleImageUpload()
{
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
        return "";
    }

    $name = basename($_FILES['image']['name']);
    $target = "../images/" . $name;

    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    return $name;
}

/* HANDLE FORM */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $image = handleImageUpload();

    $data = [
        'name' => htmlspecialchars(trim($_POST['name'])),
        'brand' => htmlspecialchars(trim($_POST['brand'])),
        'price' => (float)$_POST['price'],
        'age_range' => htmlspecialchars(trim($_POST['age_range'])),
        'description' => htmlspecialchars(trim($_POST['description'])),
        'long_description' => htmlspecialchars(trim($_POST['long_description'])),
        'rating' => (int)$_POST['rating'],
        'stock' => (int)$_POST['stock'],
        'image' => $image
    ];

    if ($data['name'] == "" || $data['price'] <= 0) {
        $error = "Please fill all required fields correctly.";
    } else {
        addProduct($pdo, $data);
        header("Location: dashboard.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="icon" type="image/png" href="../images/car_logo.png">

    <link rel="stylesheet" href="../css/style.css?v=<?php echo filemtime('../css/style.css'); ?>">
    <link rel="stylesheet" href="../css/admin.css?v=<?php echo filemtime('../css/admin.css'); ?>">
</head>

<body>

<?php include '../header.php'; ?>

<main>

<section class="admin-container">

    <header class="admin-header">
        <h1>Add Product</h1>
        <p>Create a new product</p>
    </header>

    <section class="form-container">
        <h2 class="visually-hidden-heading">Add product form</h2>

        <form method="POST" enctype="multipart/form-data">

            <?php if ($error): ?>
                <p class="error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <label for="name">Product Name</label>
            <input id="name" type="text" name="name" required>

            <label for="brand">Brand</label>
            <input id="brand" type="text" name="brand" required>

            <label for="price">Price (£)</label>
            <input id="price" type="number" step="0.01" name="price" required>

            <label for="age_range">Age Range</label>
            <input id="age_range" type="text" name="age_range" required>

            <label for="image">Upload Image</label>
            <input id="image" type="file" name="image">

            <label for="rating">Rating</label>
            <input id="rating" type="number" name="rating" required>

            <label for="stock">Stock</label>
            <input id="stock" type="number" name="stock" required>

            <label for="description">Short Description</label>
            <textarea id="description" name="description" required></textarea>

            <label for="long_description">Long Description</label>
            <textarea id="long_description" name="long_description" required></textarea>

            <button type="submit">Add Product</button>

        </form>

    </section>

</section>

</main>

<?php include '../footer.php'; ?>

</body>
</html>