<body>
    <section class="container-fluid position-relative">

        <header class="position-relative">
            <nav class="bg-light">
                <div class="w-full mx-auto px-1 px-md-5 px-lg-16 py-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center d-lg-none">
                        <img id="mobmenubtn" src="./assets/icon/Menu.svg" alt="menu" class="" />
                    </div>
                    <div class="d-flex">
                        <a href="./index.php">
                            <img src="./assets/icon/logo.svg" alt="Logo" class="img-fluid" />
                        </a>
                    </div>
                    <?php $pagename = $_SERVER['PHP_SELF']; ?>
                    <style>
                        .nav {
                            color: #000;
                            padding: 8px 15px;
                        }

                        .navactive {
                            background-color: #0f6290;
                            color: #fff;
                        }
                    </style>
                    <ul class="d-lg-flex align-items-center gap-5 d-none list-unstyled fs-5 mb-0">
                        <li>
                            <a href="./index.php" class="<?php if (basename($pagename) == 'index.php') {
                                                                echo 'navactive';
                                                            }  ?> link-underline nav link-underline-opacity-0 ">Home</a>
                        </li>
                        <li>
                            <a href="./shop.php" class="<?php if (basename($pagename) == 'shop.php') {
                                                            echo 'navactive';
                                                        } ?>  link-underline nav link-underline-opacity-0 ">Shop</a>
                        </li>
                        <li>
                            <a href="./about.php" class="<?php if (basename($pagename) == 'about.php') {
                                                                echo 'navactive';
                                                            }  ?>  link-underline  nav link-underline-opacity-0 ">About</a>
                        </li>

                        <li>
                            <a href="./contact.php" class="<?php if (basename($pagename) == 'contact.php') {
                                                                echo 'navactive';
                                                            } ?>  link-underline nav link-underline-opacity-0 ">Contact</a>
                        </li>

                        <li>
                            <a href="./blogs.php" class="<?php if (basename($pagename) == 'blogs.php') {
                                                                echo 'navactive';
                                                            }  ?>  link-underline nav link-underline-opacity-0 ">Blog</a>
                        </li>
                    </ul>

                    <div class="d-flex gap-3 position-relative">
                        <button id="searchBtn" class="w-100 bg-transparent border-0 p-0 d-none">
                            <img class="img-fluid" src="./assets/icon/Search.svg" alt="searcico" />
                        </button>
                        <a class="d-lg-block d-none w-100" href="./wishlist.php">
                            <img class="img-fluid" src="./assets/icon/Heart.svg" alt="haertico" />
                        </a>
                        <a class="d-lg-block d-none w-100" href="./cart.php">
                            <img class="img-fluid" src="./assets/icon/Shoppingcart.svg" alt="cartico" />
                        </a>
                        <button id="menuBtn" class="w-100 bg-transparent border-0 p-0">
                            <img class="img-fluid" src="./assets/icon/Avatar.svg" alt="profileico" />
                        </button>
                        <ul id="profileMenu" style="width: 300px; right: 5%; top: 200%" class="profile-menu position-absolute z-3 bg-light list-unstyled p-4 d-flex d-none flex-column gap-3 justify-content-center shadow-lg">
                            <?php

                            if (!empty($userId)) {

                                require_once "./config.php";

                                $sql = "SELECT * FROM merchants WHERE merchant_id = ? AND merchant_status=1;";
                                $stmt = $config->prepare($sql);
                                $stmt->bind_param("s", $userId);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $merchantId = $row['merchant_id'];
                                    $merchantName = $row['business_name'];
                                    $merchantMail = $row['merchant_email'];

                                    // echo $merchantId;
                                    // echo $userId;

                                    if ($merchantId == $userId) {
                                        echo "          
                                      <li>
                                        <div class='d-flex'>
                                            <img class='img-fluid me-3' src='./assets/icon/vuesax/vuesax/outline/profile-circle.png' alt='' />
                                            <p style='color: #0f6290' class='mb-0 fw-medium'>$merchantName</p>
                                        </div>
                                        <p style='margin-left:43px ' class='mb-0 '>$merchantMail</p>
                                      </li>
                           
                                      <li>
                                        <a target='_blank' style='color: #001E2F;' class='link-underline link-underline-opacity-0' href='./admin/dashboard.php'><img class='img-fluid me-3' src='./assets/icon/vuesax/vuesax/outline/status-up.png' alt='' />Dashboard</a>
                                           </li>
                                           <li>
                                        <a style='color: #001E2F;' class='link-underline link-underline-opacity-0' href='./orders.php'><img class='img-fluid me-3' src='./assets/icon/vuesax/vuesax/outline/bag-2.png' alt='' />Orders</a>
                                           </li>
                          
                                           <li>
                                        <a style='color: #001E2F;' class='link-underline link-underline-opacity-0' href=''><img class='img-fluid me-3' src='./assets/icon/vuesax/vuesax/outline/dollar-circle.png' alt='' />Payments</a>
                                           </li>
                                           <li>
                                        <a style='color: #001E2F;' class='link-underline link-underline-opacity-0' href='./logout.php'><img class='img-fluid me-3'         src='./assets/icon/vuesax/vuesax/outline/logout.png' alt='' />Log out</a>";
                                    }
                                }
                                // normal user
                                require_once "./config.php";
                                $sql2 = "SELECT * FROM users WHERE id = ?";
                                $stmt = $config->prepare($sql2);
                                $stmt->bind_param("s", $userId);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    $row = $result->fetch_assoc();
                                    $user_id = $row['id'];
                                    $userName = $row['name'];
                                    $userEmail = $row['email'];
                                    if ($user_id == $userId) {
                                        // username and email 

                                        echo "          
                                    <li>
                                       <div class='d-flex'>
                                           <img class='img-fluid me-3' src='./assets/icon/vuesax/vuesax/outline/profile-circle.png' alt='' />
                                           <p style='color: #0f6290' class='mb-0 fw-medium '>$userName</p>
                                       </div>
                                       <p style='margin-left:43px ' class='mb-0 '>$userEmail</p>
                                   </li>
                             
                               
                                   <li>
                                       <a style='color: #001E2F;' class='link-underline link-underline-opacity-0' href='./orders.php'><img class='img-fluid me-3' src='./assets/icon/vuesax/vuesax/outline/bag-2.png' alt='' />Orders</a>
                                   </li>
                                   
                                   <li>
                                       <a style='color: #001E2F;' class='link-underline link-underline-opacity-0' href='./merchant.php'><img class='img-fluid me-3' src='./assets/icon/vuesax/vuesax/outline/wallet-add.png' alt='' />Start Sales</a>
                                   </li>
                                   <li>
                                       <a style='color: #001E2F;' class='link-underline link-underline-opacity-0' href=''><img class='img-fluid me-3' src='./assets/icon/vuesax/vuesax/outline/dollar-circle.png' alt='' />Payments</a>
                                   </li>
                                   <li>
                                       <a style='color: #001E2F;' class='link-underline link-underline-opacity-0' href='./logout.php'><img class='img-fluid me-3' src='./assets/icon/vuesax/vuesax/outline/logout.png' alt='' />Log out</a>";
                                    }
                                }
                            } else {

                                echo "
                                <li>
                                <div class='d-flex'>
                                    <img class='img-fluid me-3' src='./assets/icon/vuesax/vuesax/outline/profile-circle.png' alt='' />
                                    <p style='color: #0f6290' class='mb-0 fw-medium '>Guest Mode</p>
                                </div>
                                <p style='margin-left:43px ' class='mb-0'>Log in for better perfomance</p>
                                </li>
                                <li>
                                   <a style='color: #001E2F;' class='link-underline link-underline-opacity-0' href='./login.php'><img class='img-fluid me-3' src='./assets/icon/vuesax/vuesax/outline/login.png' alt='' />Log in</a>
                                </li>";
                            }





                            ?>

                        </ul>
                    </div>
                </div>
            </nav>
            <ul style="top: 80px" id="navlinks" class="d-lg-none list-unstyled position-absolute d-flex flex-column gap-4 z-3 ps-5 py-5 vh-100 w-75 bg-light">
                <li class="ml-0">
                    <a href="./index.php" class="link link-dark link-underline link-underline-opacity-0">Home</a>
                </li>
                <li>
                    <a href="./shop.php" class="link link-dark link-underline link-underline-opacity-0">Shop</a>
                </li>
                <li>
                    <a href="./about.php" class="link link-dark link-underline link-underline-opacity-0">About</a>
                </li>

                <li>
                    <a href="./contact.php" class="link link-dark link-underline link-underline-opacity-0">Contact</a>
                </li>

                <li>
                    <a href="./blogs.php" class="link link-dark link-underline link-underline-opacity-0">Blog</a>
                </li>
                <li>
                    <a href="#" class="link link-dark link-underline link-underline-opacity-0">Wishlist</a>
                </li>
                <li>
                    <a href="./cart.php" class="link link-dark link-underline link-underline-opacity-0">Cart</a>
                </li>
            </ul>

            <div id="searchContainer" style="right: 5%;" class="d-none search-container w-25 position-absolute text-danger z-3 bg-light shadow-lg top-100 p-5 ">

                <form action="" method="post">
                    <div class="d-flex">
                        <input type="search" name="searchinput" class="py-2 px-3 " placeholder="search product" id="">
                        <button style="background-color: #0f6290;" type="submit" class="border-0 text-white py-2 px-3" name="searchsubmit">Search</button>
                    </div>
                </form>


                <div class="search-result mt-3">
                    <?php
                    include 'config.php'; // Replace with your database connection file

                    if (isset($_POST['searchsubmit'])) {
                        $search = $_POST['searchinput'];
                        $sql = "SELECT * FROM products WHERE product_status='active' AND category_name LIKE '%$search%' OR brand_name LIKE '%$search%'";
                        $result = $config->query($sql);

                        if ($result->num_rows > 0) {
                            // Output the results
                            while ($row = $result->fetch_assoc()) {


                    ?>
                                <form method="post" class="w-100 d-flex border-bottom pb-2 mt-3">

                                    <a href="./showproduct.php?productID=<?php echo $row['product_id']; ?>" class=" link-underline d-flex flex-column gap-1 justify-content-center link-underline-opacity-0 card-seller">
                                        <div class="d-flex gap-3">
                                            <div class="col-3">
                                                <img class="img-fluid" src="./uploads/<?php echo $row['main_image_name'] . '.' . $row['main_img_extension']; ?>" alt="" />
                                            </div>
                                            <div class="col-9">
                                                <p style="height: 35px; overflow: hidden;" class="fw-medium fs-5 mb-0 text-black"><?php echo $row['product_name']; ?></p>


                                                <h5 style="color: #0f6290;" class=" fs-3">&#8377;<?php echo $row['product_price'] * $row['discount_percent']; ?> <del class="text-black ms-3 fs-5">&#8377;<?php echo $row['product_price']; ?></del></h5>


                                            </div>
                                        </div>
                                    </a>

                                </form>
                    <?php
                            }
                        } else {
                            echo "No results found.";
                        }
                    }
                    ?>
                </div>
            </div>
            <script>
                const searchContainer = document.getElementById("searchContainer");
                const searchBtn = document.getElementById("searchBtn");

                searchBtn.addEventListener("click", () => {
                    // alert();
                    searchContainer.classList.toggle("d-none");
                });
            </script>
        </header>