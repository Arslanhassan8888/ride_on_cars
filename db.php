<?php

/* --DATABASE CONNECTION-- */
/* Create PDO connection to MySQL database */
$pdo = new PDO(
    "mysql:host=localhost;dbname=ride_on_cars;charset=utf8",
    "root",
    ""
);


/* --ERROR MODE-- */
/* Enable exception handling for database errors */
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
