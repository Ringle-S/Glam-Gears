<?php
session_start();


include_once('./config.php');


if ($config->connect_error) {
    die("Connection failed: " . $config->connect_error);
}

$data = $_POST['searchTerm'];


$sql = "SELECT * FROM products WHERE product_status='active' AND (category_name LIKE '%$data%' OR brand_name LIKE '%$data%' OR product_name LIKE '%$data%');";
// echo $sql;
$stmt = $config->prepare($sql);


if ($stmt->execute()) {
    $result = $stmt->get_result();
    $output = '';
    if ($result) {
        // Process the results
        while ($rows = $result->fetch_assoc()) {
            // Do something with the row data
            // $total_row = $result->num_rows;
            // print_r($rows);
            if ($result->num_rows > 0) {
                echo $result->num_rows > 0;
                echo "<br>";

                while ($row = $result->fetch_assoc()) {
                    // echo $row;
                    // print_r($row);
                    $output .= "
                        <form method='post' class='w-100 d-flex border border-bottom-2 pb-2 mt-3'>
                            <a href='./showproduct.php?productID=" . $row['product_id'] . "' class='link-underline d-flex flex-column gap-1 justify-content-center link-underline-opacity-0 card-seller'>
                                <div class='d-flex gap-3'>
                                    <div class='col-3'>
                                        <img class='img-fluid object-fit-contain' src='./uploads/" . $row['main_image_name'] . "' alt='' />
                                    </div>
                                    <div class='col-9'>
                                        <p style='height: 35px; overflow: hidden;' class='fw-medium fs-5 mb-0 text-black'>" . $row['product_name'] . "</p>
                                        <h5 style='color: #0f6290;' class='fs-3'>&#8377;" . $row['product_price'] * (1 - $row['discount_percent']) . "<del class='text-black ms-3 fs-5'>&#8377;" . $row['product_price'] . "</del></h5>
                                    </div>
                                </div>
                            </a>
                        </form>
                    ";
                    echo $output;
                }
            } else {
                $output = '<h3>No Data Found</h3>';
                echo $output;
            }
        }
    } else {
        $output = '<h3>No Data Found</h3>';
    }
} else {
    echo "Error executing query: " . $stmt->error;
}
