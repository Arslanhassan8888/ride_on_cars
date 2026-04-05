<?php

/* --PASSWORD HASHING-- */
/* Generate a hashed password (for testing / admin setup) */

echo password_hash("ciao123", PASSWORD_DEFAULT);

?>