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
    <link rel="stylesheet" href="css/signinForm.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />

    <style>
        .formContainer {
            padding-bottom: 50px;
            padding-top: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 10%;

        }

        .form-main {
            width: 820px;
            height: 550px;
            background: linear-gradient(to bottom, #0f0c29, #302b63, #24243e);

            overflow: hidden;
            /* background: url("https://doc-08-2c-docs.googleusercontent.com/docs/securesc/68c90smiglihng9534mvqmq1946dmis5/fo0picsp1nhiucmc0l25s29respgpr4j/1631524275000/03522360960922298374/03522360960922298374/1Sx0jhdpEpnNIydS4rnN4kHSJtU1EyWka?e=view&authuser=0&nonce=gcrocepgbb17m&user=03522360960922298374&hash=tfhgbs86ka6divo3llbvp93mg4csvb38") no-repeat center/ cover; */
            border-radius: 10px;
            box-shadow: 5px 20px 50px #000;
        }

        #chk {
            display: none;
        }

        .form-signup {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .form-signup label,
        .form-login label {
            color: #fff;
            font-size: 2.3em;
            justify-content: center;
            display: flex;
            margin: 60px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.5s ease-in-out;
        }


        .form-signup input,
        .form-login input {
            width: 60%;
            height: 35px;
            background: #e0dede;
            justify-content: center;
            display: flex;
            margin: 20px auto;
            padding: 10px;
            border: none;
            outline: none;
            border-radius: 5px;
        }

        .form-login button,
        .form-signup button {
            width: 60%;
            height: 40px;
            margin: 10px auto;
            justify-content: center;
            display: block;
            color: #fff;
            background: #573b8a;
            font-size: 1em;
            font-weight: bold;
            margin-top: 20px;
            outline: none;
            border: none;
            border-radius: 5px;
            transition: 0.2s ease-in;
            cursor: pointer;
        }

        .form-login button,
        .form-signup button:hover {
            background: #6d44b8;
        }

        .form-login {
            height: 460px;
            background: #eee;
            border-radius: 60% / 10%;
            transform: translateY(-180px);
            transition: 0.8s ease-in-out;
        }

        .form-login label {
            color: #573b8a;
            transform: scale(0.6);
        }

        #chk:checked~.form-login {
            transform: translateY(-637px);
        }

        #chk:checked~.form-login label {
            transform: scale(1);
        }

        #chk:checked~.form-signup label {
            transform: scale(0.6);
        }
    </style>

</head>

<body>
    <?php

    include("partial/_header.php");
    ?>

    <div class="formContainer">

        <div class="form-main">

            <input type="checkbox" id="chk" aria-hidden="true">

            <div class="form-signup">
                <form method="post" action="">
                    <label for="chk" aria-hidden="true">Sign up</label>
                    <input type="text" name="userName" placeholder="Full name" required>
                    <input type="email" name="signupEmail" placeholder="Email" required>
                    <input type="password" id="pswd" name="signupPswd" placeholder="Password" required>

                    <button type="submit">Sign up</button>
                </form>
            </div>

            <div class="form-login">
                <form method="post" action="">
                    <label for="chk" aria-hidden="true">Login</label>
                    <input type="hidden" value="log" name="log">
                    <input type="email" name="loginMail" placeholder="Email" required="">
                    <input type="password" name="loginPswd" placeholder="Password" required="">

                    <button>Login</button>
                </form>
            </div>
        </div>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['log'])) {

            //user is trying to login
            $email = $_POST['loginMail'];
            $password = $_POST['loginPswd'];

            $sqlChckEmail = "SELECT * FROM userdata WHERE user_email = '$email'";
            $ChckResult = mysqli_query($con, $sqlChckEmail);

            if (mysqli_num_rows($ChckResult) == 0) {

                echo "<script>alert('Email not found Please signUp');</script>";
            } else {

                while ($row = mysqli_fetch_assoc($ChckResult)) {
                    if (password_verify($password, $row['user_pswd'])) {

                        //Adding SESSION
                        $_SESSION['id'] = $row['user_id'];
                        $_SESSION['login'] = true;
                        $_SESSION['userName'] = $row['user_name'];

                        $fullName = $_SESSION['userName'];

                        echo '<script>alert("Kudos!   ' .  $fullName . ' You are now part of the Query Solution family, where programming is a serious business, but laughing at our own mistakes is a mandatory break! ")</script>';
                        echo "<script> window.location.href = '/index.php';</script>";
                    } else {

                        echo '<script>alert("Ohhh no... Password does not match to mail!!")</script>';
                    }
                }
            }
        } else {
            //user is trying to signup
            $email = $_POST['signupEmail'];

            // check is email already exists in db
            $sqlChckEmail = "SELECT * FROM userdata WHERE user_email = '$email'";
            $ChckResult = mysqli_query($con, $sqlChckEmail);

            if (mysqli_num_rows($ChckResult) > 0) {
                echo "<script>alert('Email already exists Please Login!!');</script>";
            } else {

                $userName = $_POST['userName'];
                $password = $_POST['signupPswd'];
                $hashPswd = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO userdata (user_name, user_email, user_pswd) VALUES ('$userName', '$email', '$hashPswd')";
                $result = mysqli_query($con, $sql);

                if ($result) {
                    echo "<script>alert('You have successfully signed up!')</script>";
                    echo "<script>window.location.href='/index.php'</script>";
                }
            }
        }
    }
    ?>

    <?php
    include("partial/_footer.php");
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>