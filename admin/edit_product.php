<?php

require 'auth.php';
require '../db.php';


/* --GET PRODUCT-- */
/* Retrieve product by ID */
function getProduct($pdo, $id)
{   /* Prepare and execute select statement to get product by ID */
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch();
}


/* --UPDATE PRODUCT-- */
/* Update product details */
function updateProduct($pdo, $data)
{   /* Prepare SQL update statement with placeholders for product fields */
    $sql = "UPDATE products 
            SET name = ?, brand = ?, price = ?, age_range = ?, 
                description = ?, long_description = ?, rating = ?, stock = ?, image = ?
            WHERE id = ?";
    /* Prepare and execute the update statement with product data */
    $stmt = $pdo->prepare($sql);
    /* Return true if product is updated successfully, false otherwise */
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


/* --IMAGE UPLOAD-- */
/* Handle image replacement */
function handleImageUpload($currentImage)
{   /* Check if image file is uploaded without errors */
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
        return $currentImage;
    }
    /* Get the original filename and set the target path */
    $name = basename($_FILES['image']['name']);
    $target = "../images/" . $name;
    /* Move the uploaded file to the target directory */
    move_uploaded_file($_FILES['image']['tmp_name'], $target);
    /* Return the filename of the uploaded image */
    return $name;
}


/* --GET ID-- */
$id = (int)($_GET['id'] ?? 0);


/* --GET DATA-- */
$product = getProduct($pdo, $id);


/* --VALIDATE-- */
if (!$product) {
    header("Location: dashboard.php");
    exit();
}


/* --HANDLE FORM-- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* IMAGE */
    $image = handleImageUpload($product['image']);

    /* INPUT */
    /* Collect and sanitize form input data into an array */
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

    /* UPDATE */
    updateProduct($pdo, $data);

    /* REDIRECT */
    header("Location: dashboard.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META -->
    <meta charset="UTF-8">
    <title>Edit Product</title>

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
    <main id="main-content">

        <!-- ADMIN CONTAINER -->
        <section class="admin-container">

            <!-- HEADER -->
            <header class="admin-header">
                <h1>Edit Product</h1>
                <p>Update product details</p>
            </header>

            <!-- FORM CONTAINER -->
            <section class="form-container">

                <h2 class="visually-hidden-heading">Edit product form</h2>

                <!-- FORM -->
                <form method="POST" enctype="multipart/form-data">

                    <!-- NAME -->
                    <label for="name">Product Name</label>
                    <input id="name" type="text" name="name"
                        value="<?= htmlspecialchars($product['name']) ?>" required>

                    <!-- BRAND -->
                    <label for="brand">Brand</label>
                    <input id="brand" type="text" name="brand"
                        value="<?= htmlspecialchars($product['brand']) ?>" required>

                    <!-- PRICE -->
                    <label for="price">Price (£)</label>
                    <input id="price" type="number" step="0.01" name="price"
                        value="<?= $product['price'] ?>" required>

                    <!-- AGE RANGE -->
                    <label for="age_range">Age Range</label>
                    <input id="age_range" type="text" name="age_range"
                        value="<?= htmlspecialchars($product['age_range']) ?>" required>

                    <!-- IMAGE -->
                    <label for="image">Replace Image</label>
                    <input id="image" type="file" name="image">

                    <!-- RATING -->
                    <label for="rating">Rating</label>
                    <input id="rating" type="number" name="rating"
                        value="<?= $product['rating'] ?>" required>

                    <!-- STOCK -->
                    <label for="stock">Stock</label>
                    <input id="stock" type="number" name="stock"
                        value="<?= $product['stock'] ?>" required>

                    <!-- SHORT DESCRIPTION -->
                    <label for="description">Short Description</label>
                    <textarea id="description" name="description" required>
<?= htmlspecialchars($product['description']) ?>
</textarea>

                    <!-- LONG DESCRIPTION -->
                    <label for="long_description">Long Description</label>
                    <textarea id="long_description" name="long_description" required>
<?= htmlspecialchars($product['long_description']) ?>
</textarea>

                    <!-- SUBMIT -->
                    <button type="submit" class="btn-add">Update Product</button>

                </form>

            </section>

        </section>

    </main>

    <!-- FOOTER -->
    <?php include '../footer.php'; ?>

</body>

</html>