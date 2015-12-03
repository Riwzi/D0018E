<?php
// Displays the requested page of the product list. Page 1 is the first page.
// $displayfn should be a function that outputs the data from
// one row of the table.
function displayProductList($page, $displayfn){
    require 'dbconnect.php';
    $conn = dbconnect();
    $firstproduct = ($page-1)*20;
    
    if ($page < 1){
        die("Product list page numbers can't be less than 1");
    } elseif ($page = 1){ //use the frontpage view
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
        
        $stmt->store_result();
        $stmt->get_result();
        
        if ( $stmt->num_rows > 0) {
            while($row = $stmt->fetch_assoc()) {
                $displayfn($row);
            }
        } else {
            echo "No products found";
        }
        
        $stmt->close();
        
    }
    $conn->close();
}
?>
