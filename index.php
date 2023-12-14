<?php
session_start();
include "partial/-dbConnect.php";

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Query Solution</title>
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
</head>

<body>

    <?php

    include("partial/_header.php");
    ?>

    <!-- banners -->
    <div id="carouselExampleCaptions" class="carousel slide">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">

            <div class="carousel-item active">
                <img src="logo\label\label-2.jpeg" class="d-block w-100 img-fluid" style="object-fit: cover;min-height: 80vh;" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2 style=" color: #ffa62e;">Community Connects</h2>
                    <p>Where questions find answers, and minds come together in a vibrant community.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="logo\label\label-3.jpeg" class="d-block w-100 img-fluid" style="object-fit: cover;min-height: 80vh;" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2 style=" color: #ffa62e;">Your Answers Await</h2>
                    <p>Empowering curiosity – Where inquisitive minds find the solutions they seek.</p>
                </div>
            </div>
            <div class="carousel-item ">
                <img src="logo\label\label-1.jpeg" class="d-block w-100 img-fluid" style="object-fit: cover;min-height: 80vh;" alt="...">
                <div class="carousel-caption d-none d-md-block">
                    <h2 style=" color: #ffa62e;">Knowledge Hub</h2>
                    <p>Explore a world of answers and connect with a thriving community at Query Solution.</p>
                </div>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>

        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- catagory cards -->
    <div class="container" style=" width: 75%;">
        <h2 class="text-center my-4">Welcome to Query Solution - Categories. </h2>
        <div class="row">

            <?php

            $sql = "SELECT * FROM category";
            $result = mysqli_query($con, $sql);  //To get all categories

            while ($row = mysqli_fetch_assoc($result)) {

                $cat_id = $row['category_id'];
                $cat_name = $row['category_name'];
                $cat_desc = $row['category_desc'];

                echo ' <div class="col-md-4">
                            <div class="card my-3" style="width: 100%;">
                                <img src="https://source.unsplash.com/500x400/?coding,' . $cat_name . '" class="card-img-top" alt="...">
                  
                                <div class="card-body">
                                        <h5 class="card-title text-center">' . $cat_name . '</h5>
                                        <p class="card-text text-center">' . substr($cat_desc, 0, 110)  . '...</p>
                                        <a href="/threadlists.php?catid=' . $cat_id . '" class="btn btn-primary d-block mx-auto">View Threads</a>
                                </div>
                            </div>
                        </div>';
            }

            ?>

        </div>
    </div>


    <?php
    include("partial/_footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>