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
    <style>
        #cont {
            width: 100%;
            padding: 4%;
        }
    </style>
</head>

<body>

    <?php
    include("partial/_header.php");
    ?>
    <!-- $sql = "alter table threads add FULLTEXT (`thread_desc` , `thread_title`)"   // Query to enable full text search in database -->
    <div class="container">
        <div class="dispalyArea" style="margin-top: 30px; min-height:80vh; ">
            <?php
            $search = $_GET['search'];
            ?>
            <h1 class="text-center">Search Results <?php echo $search ?></h1>

            <div class="media my-4" id="cont" style="background-color: azure;">

                <?php


                // Corrected SQL query
                $sqlSearchQuery = "SELECT * FROM threads WHERE MATCH (thread_title) AGAINST ('.net' IN BOOLEAN MODE);
";

                $result = mysqli_query($con, $sqlSearchQuery);
                // echo var_dump($sqlSearchQuery);

                if ($result) {
                    $num = mysqli_num_rows($result);

                    if ($num > 0) {
                        // Use a while loop to fetch each row
                        while ($row = mysqli_fetch_assoc($result)) {
                            $title = $row['thread_title'];
                            $desc = $row['thread_desc'];
                            $id = $row['thread_id'];
                            $cat_id = $row['thread_cat_id'];

                            echo
                            ' <div class="media  py-3">
               
                <div class="media-body">
                 <h5 class="mt-0"><a style="text-decoration: none;  color: inherit; " href="/querySolution-solution/thread.php?catid=' . $cat_id . ' &threadid=' . $id . '"> ' .  $title . '</a></h5>

                    ' . $desc . '<hr class="my-4"> </div></div>';
                        }
                    } else {
                        echo "No results found";
                    }
                } else {
                    // Handle query error
                    echo "Query failed: " . mysqli_error($con);
                }
                ?>


            </div>

        </div>
    </div>


    <?php
    include("partial/_footer.php");

    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>