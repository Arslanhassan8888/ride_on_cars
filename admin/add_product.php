<?php

require 'auth.php';
require '../db.php';

/* --STATE-- */
$error = "";


/* --ADD PRODUCT-- */
/* Insert new product into database */
/* Returns true on success, false on failure */
function addProduct($pdo, $data)
{   /* Prepare and execute insert statement with product data */
    $sql = "INSERT INTO products 
            (name, brand, price, age_range, description, long_description, rating, stock, image)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    /* Prepare and execute the insert statement */
    $stmt = $pdo->prepare($sql);
    /* Return true if product is added successfully, false otherwise */
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


/* --IMAGE UPLOAD-- */
/* Handle uploaded product image */
/* Returns the filename of the uploaded image, or empty string if no image uploaded */
function handleImageUpload()
{   /* Check if image file is uploaded without errors */
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
        return "";
    }
    /* Get the original filename and set the target path */
    $name = basename($_FILES['image']['name']);
    $target = "../images/" . $name;
    /* Move the uploaded file to the target directory */
    move_uploaded_file($_FILES['image']['tmp_name'], $target);
    /* Return the filename of the uploaded image */
    return $name;
}


/* --HANDLE FORM-- */
/* Process form submission for adding a new product */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /* IMAGE */
    $image = handleImageUpload();

    /* INPUT */
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

    /* VALIDATION */
    /* Basic validation for required fields */
    if ($data['name'] == "" || $data['price'] <= 0) {
        $error = "Please fill all required fields correctly.";
    } else {

        /* INSERT */
        addProduct($pdo, $data);

        /* REDIRECT */
        header("Location: dashboard.php");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- META -->
    <meta charset="UTF-8">
    <title>Add Product</title>

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
                <h1>Add Product</h1>
                <p>Create a new product</p>
            </header>

            <!-- FORM CONTAINER -->
            <section class="form-container">

                <h2 class="visually-hidden-heading">Add product form</h2>

                <!-- FORM -->
                <form method="POST" enctype="multipart/form-data">

                    <!-- ERROR -->
                    <?php if ($error): ?>
                        <p class="error"><?= htmlspecialchars($error) ?></p>
                    <?php endif; ?>

                    <!-- NAME -->
                    <label for="name">Product Name</label>
                    <input id="name" type="text" name="name" required>

                    <!-- BRAND -->
                    <label for="brand">Brand</label>
                    <input id="brand" type="text" name="brand" required>

                    <!-- PRICE -->
                    <label for="price">Price (£)</label>
                    <input id="price" type="number" step="0.01" name="price" required>

                    <!-- AGE RANGE -->
                    <label for="age_range">Age Range</label>
                    <input id="age_range" type="text" name="age_range" required>

                    <!-- IMAGE -->
                    <label for="image">Upload Image</label>
                    <input id="image" type="file" name="image">

                    <!-- RATING -->
                    <label for="rating">Rating</label>
                    <input id="rating" type="number" name="rating" required>

                    <!-- STOCK -->
                    <label for="stock">Stock</label>
                    <input id="stock" type="number" name="stock" required>

                    <!-- SHORT DESCRIPTION -->
                    <label for="description">Short Description</label>
                    <textarea id="description" name="description" required></textarea>

                    <!-- LONG DESCRIPTION -->
                    <label for="long_description">Long Description</label>
                    <textarea id="long_description" name="long_description" required></textarea>

                    <!-- SUBMIT -->
                    <button type="submit">Add Product</button>

                </form>

            </section>

        </section>

    </main>

    <!-- FOOTER -->
    <?php include '../footer.php'; ?>

</body>

</html>