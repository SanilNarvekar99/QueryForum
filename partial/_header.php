<?php
session_start();

include "partial/-dbConnect.php";

echo '    <nav class="navbar sticky-top navbar-expand-lg navbar-dark bg-dark bg-body-tertiary border-bottom border-body" data-bs-theme="dark">
        <div class="container-fluid">
            <div class="companyName text-center my-2">
                <a class="navbar-brand" href="home.php">
                    <img src="logo\logo.png" width="100" height="100" class="logo d-inline-block align-text-top ml-5">
                </a>
            </div>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav justify-content-center me-auto mb-2 mb-lg-0 ms-2" style="font-size: 23px;">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">About</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu">';

$sql = "SELECT * FROM category limit 3";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_assoc($result)) {
    echo '<li><a class="dropdown-item" href="threadlists.php?catid=' . $row['category_id'] . '">' . $row['category_name'] . '</a></li>';
}

// <li><a class="dropdown-item" href="#">Action</a></li>
// <li><a class="dropdown-item" href="#">Another action</a></li>
// <li>
// </li>
// <li><a class="dropdown-item" href="#">Something else here</a></li>
echo '    </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="contact.php">Contact</a>
                    </li>
                </ul>

             <form class="d-flex ms-2" method="GET" action="search.php">
                 <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="search">
                  <button class="btn" type="submit" style="color: black; background-color: #ffa62e;">Search</button>
             </form>


                <div class="signBtn ms-2">';
?>

<?php
if (isset($_SESSION['login']) && $_SESSION['login'] == true) {

    echo '<button class="btn_log" id="logOutBtn" type="submit">LogOut</button>';
} else {
    echo '<button class="btn_log" id="signUpBtn" type="submit">Join Us</button>';
    echo '<button class="btn_log disable" id="logOutBtn" type="submit" style="display:none;">LogOut</button>';
}
?>

<?php
echo '           
                </div>
            </div>
        </div>
    </nav>';
?>

<script>
    document.getElementById("signUpBtn").addEventListener("click", function() {
        window.location.href = "joinUs.php";
    });
</script>

<script>
    document.getElementById("logOutBtn").addEventListener("click", function() {
        window.location.href = "logout.php";
    });
</script>