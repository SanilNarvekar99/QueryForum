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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />


    <style>
        #cont {
            min-height: 500px;
        }

        #ansBtn {
            color: black;
            background-color: #ffa62e;
        }
    </style>
</head>

<body>
    <?php

    include("partial/_header.php");

    // Query to get category 
    $category_id = $_GET['catid']; // id from the URL
    $thread_id = $_GET['threadid'];

    $sql = "SELECT * FROM threads WHERE thread_id = $thread_id";
    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $th_title = $row['thread_title'];
        $th_desc = $row['thread_desc'];
        $th_by = $row['thread_user_id'];
    }
    //Getting user details

    $sqlUser = "SELECT * FROM userdata WHERE user_id = ' $th_by'";
    $resultUser = mysqli_query($con, $sqlUser);

    while ($rowUser = mysqli_fetch_assoc($resultUser)) {
        $user_name = $rowUser['user_name'];
    }
    ?>

    <div class="container my-4 " id="cont">
        <div class="jumbotron">
            <h1 class="display-4"><?php echo $th_title; ?></h1>
            <p class="lead"><?php echo $th_desc; ?></p>
            <p class="text-right"><b>Posted by: <?php echo $user_name ?> </b></p>
            <hr class="my-4">
            <p>
                This platform serves as a collaborative space where individuals come together to exchange information, insights, and expertise, fostering a community-driven environment for shared learning and mutual support.</p>
            <!-- <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a> -->
        </div>
    </div>

    <!-- form to answer Question -->
    <div class="container my-5">
        <form method="POST" action="">
            <h1>Suggest a fix for the problem</h1>

            <div class="form-group">
                <label for="ansDesc">Share your solution in the space provided.</label>
                <textarea class="form-control" id="ans_desc" name="ans_desc" rows="3" required></textarea>
            </div>

            <button id="ansBtn" type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_SESSION['login'])) {
            echo "<script>alert('You are not login  Please logIn to ask Question!!')</script>";
            echo "<script>window.location.href = '/joinUs.php';</script>";
        } else {
            $ans_desc = $_POST['ans_desc'];

            $ans_user_id = $_SESSION['id'];

            // $ans_desc =  str_replace('<', '&lt;', $ans_desc);
            // $ans_desc =  str_replace('>', '&gt;', $ans_desc);

            // $ans_desc = str_replace(' ', '&nbsp;', $ans_desc);
            $ans_desc = htmlspecialchars($ans_desc);
            $ans_desc = nl2br($ans_desc);



            $sqlCom = "INSERT INTO comments (com_desc, com_thread_id, com_cat_id, com_user_id)
               values  ('$ans_desc','$thread_id','$category_id','$ans_user_id')";

            $resultCom = mysqli_query($con, $sqlCom);
            if ($resultCom) {
                echo '<script>alert("Thanks for your contribution your answr saved successfully")</script>';
            } else {
                echo '<script>alert("Your answer has not been submitted")</script>';
            }
        }
    }
    ?>


    <!-- Questions  -->
    <div class="container" id="cont" style="background-color: azure;">

        <!-- Query to fetch answer from database -->
        <?php
        $sqlAns = "SELECT * FROM comments WHERE com_cat_id = '$category_id' AND com_thread_id ='$thread_id '";
        $resultAns = mysqli_query($con, $sqlAns);
        if (mysqli_num_rows($resultAns) > 0) {
            echo '<h1>Possible answers!!</h1>';
            while ($rowAns = mysqli_fetch_assoc($resultAns)) {
                $ans_desc = $rowAns['com_desc'];
                $ans_user_id = $rowAns['com_user_id'];

                // Getting user details
                $sqlUser = "SELECT * FROM userdata WHERE user_id = '$ans_user_id'";
                $resultUser = mysqli_query($con, $sqlUser);

                while ($rowUser = mysqli_fetch_assoc($resultUser)) {
                    $user_name = $rowUser['user_name'];
                }


                echo '   <div class="media  py-3">
                <img src="logo\defaultUser.png" width="40px" class="mr-3" alt="...">
                <div class="media-body">
                 <h5 class="mt-0">' . $user_name . '</h5>

                    ' . $ans_desc . '<hr class="my-4"> </div></div>';
            }
        } else {
            echo '  
            <div class="container my-4">
                <div class="jumbotron">
                    <h1 class="display-4">No results found</h1>
                    <h1>Be the first person to answer!!</h1>
                </div>
            </div>';
        }
        ?>
    </div>


    <?php
    include("partial/_footer.php");
    ?>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>