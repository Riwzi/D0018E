<?php
    $servername = "localhost";
    $username = "nilfit-3";
    $password = "nilfit-3";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password);

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $product_name = $_REQUEST["product_name"];
    $product_price = $_REQUEST["product_price"];

    $sql = "USE nilfit3db;";
    $conn->query($sql);
    $sql = "INSERT INTO products (name, price)
            VALUES ('$product_name', $product_price);";

    if ( $conn->query($sql) === TRUE) {
        echo "The product was successfully added";
    } else {
        echo "Insertion failed: " . $conn->error;
    }
    $conn->close();
?>
