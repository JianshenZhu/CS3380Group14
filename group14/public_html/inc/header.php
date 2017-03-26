<header>
<?php

// different header for internal
if (preg_match('/(internal)|(log.php)/', $_SERVER['REQUEST_URI'])) {
    include 'navbar_internal.php';
    echo "<h1>Missouri Rail - Employee Facing Content</h1>";
}
else {
    include 'navbar_store.php';
    echo "<h1>The Missouri Rail - Store</h1>";
}
?>
</header>
