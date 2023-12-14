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
        #thread:hover {
            color: white;

        }

        #cont {
            min-height: 500px;
        }

        #formBtn {
            color: black;
            background-color: #ffa62e;
        }
    </style>
</head>

<body>
    <?php
    include("partial/_header.php");

    // Query to get category 
    $id = $_GET['catid']; // id from the URL
    $sql = "SELECT * FROM category WHERE category_id = $id";
    $result = mysqli_query($con, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        $cat_name = $row['category_name'];
        $cat_desc = $row['category_desc'];
    }
    ?>

    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $cat_name; ?> forums</h1>
            <p class="lead"><?php echo $cat_desc; ?></p>
            <hr class="my-4">
            <p>
                This platform serves as a collaborative space where individuals come together to exchange information, insights, and expertise, fostering a community-driven environment for shared learning and mutual support.</p>
            <!-- <a class="btn btn-primary btn-lg" href="#" role="button">Learn more</a> -->
        </div>
    </div>

    <!-- form to ask question -->
    <div class="container">
        <form method="POST" action="">
            <h1>Ask Questions</h1>
            <div class="form-group my-4">
                <label for="title">Issue Heading</label>
                <input type="text" class="form-control" name="issue_title" id="issue_title" aria-describedby="titleHelp" required>
                <small id="titleHelp" class="form-text text-muted">Keep your issue description brief and focused.</small>
            </div>
            <div class="form-group">
                <label for="title_desc">Provide more details about your issue.</label>
                <textarea class="form-control" id="issue_desc" name="issue_desc" rows="3" required></textarea>
            </div>

            <button id="formBtn" type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- Storing questions in data base thread -->
    <?php



    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (!isset($_SESSION['login'])) {
            echo "<script>alert('You are not login Please logIn to ask Question!!')</script>";
            echo "<script>window.location.href = '/joinUs.php';</script>";
        } else {

            $t_title = $_POST['issue_title'];
            $t_desc = $_POST['issue_desc'];
            $t_user_id = $_SESSION['id'];


            // $t_title =  str_replace('<', '&lt;', $t_title);
            // $t_title =  str_replace('>', '&gt;', $t_title);
            // $t_title = str_replace(' ', '&nbsp;', $t_title);
            // $t_title = nl2br($t_title);

            // $t_desc =  str_replace('<', '&lt;', $t_desc);
            // $t_desc =  str_replace('>', '&gt;', $t_desc);

            // $t_desc = str_replace(' ', '&nbsp;', $t_desc);
            $t_desc = htmlspecialchars($t_desc);

            $t_desc = nl2br($t_desc);


            $sql_insert = "INSERT INTO threads (thread_title, thread_desc, thread_cat_id ,thread_user_id) 
     VALUES  ('$t_title','$t_desc','$id','$t_user_id')";

            $result = mysqli_query($con, $sql_insert);
            if ($result) {
                echo '<script>alert("Your issue has been submitted successfully")</script>';
            } else {
                echo '<script>alert("Your issue has not been submitted")</script>';
            }
        }
    }
    ?>

    <!-- display Questions  -->
    <div id="cont" class="container my-4" style="background-color: azure;">

        <!-- Query to get questions  -->
        <?php
        $sqlQtion = "SELECT * FROM threads WHERE thread_cat_id = $id";
        $resultQtion = mysqli_query($con, $sqlQtion);

        if (mysqli_num_rows($resultQtion) > 0) {
            echo '<h1>Browse Questions</h1>';

            while ($rowQtion = mysqli_fetch_assoc($resultQtion)) {

                $thread_sub = $rowQtion['thread_title'];
                $thread_question = $rowQtion['thread_desc'];
                $thread_id = $rowQtion['thread_id'];
                $user = $rowQtion['thread_user_id'];
                $createdDate = $rowQtion['thread_created_date'];
                $dateTimeObject = new DateTime($createdDate);
                $formatDate = date_format($dateTimeObject, 'Y-m-d');

                //Getting user details

                $sqlUser = "SELECT * FROM userdata WHERE user_id = '$user'";
                $resultUser = mysqli_query($con, $sqlUser);

                while ($rowUser = mysqli_fetch_assoc($resultUser)) {
                    $user_name = $rowUser['user_name'];
                }
                echo '   <div class="media  py-3">
                <img src="logo\defaultUser.png" width="40px" class="mr-3" alt="...">
                <div class="media-body">
                    <h3 class="mt-0"><a id="thread" style="text-decoration: none;  color: inherit; " href="/thread.php?catid=' . $id . '&threadid=' . $thread_id . '">' . $thread_sub . '</a></h3>
              <p>By:<b>' . $user_name . '</b></p>  <p class="text-right">on:  ' . $formatDate . '</p>


                    ' . $thread_question . '<hr class="my-4"> </div></div>';
            }
        } else {
            echo '  
    <div class="container my-4">
        <div class="jumbotron">
            <h1 class="display-4">No result found </h1>
            <h1>Be the first person to ask!!</h1>
            
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