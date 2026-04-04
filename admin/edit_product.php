<?php

require 'auth.php';
require '../db.php';

/* GET PRODUCT */
function getProduct($pdo, $id)
{
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}

/* UPDATE PRODUCT */
function updateProduct($pdo, $data)
{
    $sql = "UPDATE products 
            SET name = ?, brand = ?, price = ?, age_range = ?, 
                description = ?, long_description = ?, rating = ?, stock = ?, image = ?
            WHERE id = ?";

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
        $data['image'],
        $data['id']
    ]);
}

/* HANDLE UPLOAD */
function handleImageUpload($currentImage)
{
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
        return $currentImage;
    }

    $name = basename($_FILES['image']['name']);
    $target = "../images/" . $name;

    move_uploaded_file($_FILES['image']['tmp_name'], $target);

    return $name;
}

/* GET ID */
$id = (int)($_GET['id'] ?? 0);

$product = getProduct($pdo, $id);

if (!$product) {
    header("Location: dashboard.php");
    exit();
}

/* HANDLE FORM */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $image = handleImageUpload($product['image']);

    $data = [
        'id' => $id,
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

    updateProduct($pdo, $data);

    header("Location: dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
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
                <h1>Edit Product</h1>
                <p>Update product details</p>
            </header>

            <section class="form-container">
                <h2 class="visually-hidden-heading">Edit product form</h2>

                <form method="POST" enctype="multipart/form-data">

                    <label for="name">Product Name</label>
                    <input id="name" type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

                    <label for="brand">Brand</label>
                    <input id="brand" type="text" name="brand" value="<?= htmlspecialchars($product['brand']) ?>" required>

                    <label for="price">Price (£)</label>
                    <input id="price" type="number" step="0.01" name="price" value="<?= $product['price'] ?>" required>

                    <label for="age_range">Age Range</label>
                    <input id="age_range" type="text" name="age_range" value="<?= htmlspecialchars($product['age_range']) ?>" required>

                    <label for="image">Replace Image</label>
                    <input id="image" type="file" name="image">

                    <label for="rating">Rating</label>
                    <input id="rating" type="number" name="rating" value="<?= $product['rating'] ?>" required>

                    <label for="stock">Stock</label>
                    <input id="stock" type="number" name="stock" value="<?= $product['stock'] ?>" required>

                    <label for="description">Short Description</label>
                    <textarea id="description" name="description" required><?= htmlspecialchars($product['description']) ?></textarea>

                    <label for="long_description">Long Description</label>
                    <textarea id="long_description" name="long_description" required><?= htmlspecialchars($product['long_description']) ?></textarea>

                    <button type="submit" class="btn-add">Update Product</button>

                </form>

            </section>

        </section>

    </main>

    <?php include '../footer.php'; ?>

</body>

</html>