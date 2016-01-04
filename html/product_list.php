<?php
/**/
ini_set('display_errors', 'On');
error_reporting(E_ALL | E_STRICT);
/**/

// Displays the requested page of the product list. Page 1 is the first page.
// $displayfn should be a function that outputs the data from
// one row of the table.
function displayProductList($displayfn){
    require 'dbconnect.php';
    $conn = dbconnect();

    if (array_key_exists('page', $_REQUEST)){
        $page = $_REQUEST['page'];
    } else{
        $page = 1;
    }

    $firstproduct = ($page-1)*20;
    if ($page < 1){
        die("<tr><td>Product list page numbers can't be less than 1</td></tr>");
    } elseif ($page == 1){ //use the frontpage view
        $sql = "SELECT * FROM shopdb.FrontPageProducts";
        $result = $conn->query($sql);
        if ( $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $displayfn($row);
            }
        } else {
            echo "No products found";
        }
    } else {
        $stmt = $conn->prepare("SELECT product_id, product_name, product_price
                FROM shopdb.Products
                LIMIT ?, 20;");
        
        $stmt->bind_param("i", $firstproduct);
        $stmt->execute();
        $stmt->bind_result($product_id, $product_name, $product_price);
        $stmt->store_result();
/*
        var_dump($result);
        var_dump($conn->error_list);/**/
        if ( $stmt->num_rows > 0) {
            while($stmt->fetch()) {
                //would have liked to use $stmt->get_result(), but it seems to
                //be missing on the installation of php that we use
                $row = [
                    "product_id" => $product_id,
                    "product_name" => $product_name,
                    "product_price" => $product_price
                ];
                $displayfn($row);
            }
        } else {
            echo "<tr><td>No products found</td></tr>";
        }
        
        $stmt->close();
        
    }
    $conn->close();
}
?>
