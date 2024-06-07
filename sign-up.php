<?php
session_start();
require "config.php";
// $user_id = $_SESSION['id'];
$uname = $email = $pswd = $password2 = $position = "";
$unameerr = $emailerr = $pswderr = $password2err = $positionerr = "";

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST["submit"])) {

    // $conn=mysqli_connect('localhost','Erick','Rickie','signup') or die('Connection Failed'.mysqli_connect_error());

    if (
        isset($_POST['uname']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password2']) && isset($_POST['position']) && isset($_POST['submit'])
    ) {
        // $uname = ($_POST["uname"]);
        // $email = ($_POST["email"]);
        // $pswd = ($_POST["password"]);
        // $password2 = ($_POST["password2"]);
        // $position = ($_POST['position']);
        // // $id = ($_POST['id']);
        // $submit = ($_POST['submit']);

        // validate username
        if (empty(($_POST['uname']))) {
            $unameerr = "Please Enter Your Username!";
        } elseif (strlen(($_POST['uname'])) < 3) {
            $unameerr = "Name Must Have Atleast 3 Characters!";
        } else {
            $uname = ($_POST['uname']);
        }

        // validate email
        if (empty(($_POST['email']))) {
            $emailerr = "Please Enter Your Email!";
        } elseif (!filter_var(($_POST['email']), FILTER_VALIDATE_EMAIL)) {
            $emailerr = "Invalid Email Format!";
        } else {
            $email = ($_POST['email']);
            $sqlmail = "SELECT id from subscribers where email='$email'";
            $link = mysqli_query($conn, $sqlmail);
            if ($link && mysqli_num_rows($link) > 0) {
                $emailerr = "Email Exists!";
            }
        }


        // validate password
        if (empty(($_POST['password']))) {
            $pswderr = "Please Enter Your Password!";
        } elseif (strlen(($_POST['password'])) < 8) {
            $pswderr = "Password Must Have Atleast 8 Characters!";
        } elseif (!preg_match('/[A-Za-z]/', $_POST['password'])) {
            $pswderr = "Password Must Contain Atleast one Letter!";
        } elseif (!preg_match('/[^\w\s]/', $_POST['password'])) {
            $pswderr = "Password Must Contain Atleast one Symbol!";
        } else {
            $pswd = ($_POST['password']);
        }

        // validate confirm password
        if (empty(($_POST['password2']))) {
            $password2err = "Please Confirm Password!";
        } else {
            $password2 = ($_POST['password2']);
            if (empty($pswderr) && ($pswd != $password2)) {
                $password2err = "Password did not match!";
            }
        }

        // check input errors before inserting into database
        if (!empty($uname) && !empty($email) && !empty($pswd) && !empty($password2)) {
            // echo "Taken";
            // echo ($password2);
            // exit;
            // -- insert to database
            $sql = "INSERT INTO subscribers(uname,email,password,password2,position) VALUES ('$uname','$email','$pswd','$password2','$position')";
            $query = mysqli_query($conn, $sql);
            if ($query) {
                echo '<script> alert("Successfully Subscribed!") </script>';
                header("Location: sign-in.php");
            } else {
                echo '<script> alert("Not Subscribed! Please Try Again!!") </script>';
            }
        }
    }
}

?>

<!doctype html>
<html lang="zxx">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Owl Carousel CSS -->
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <!-- Owl Carousel Theme Default CSS -->
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css">
    <!-- Box Icon CSS-->
    <link rel="stylesheet" href="assets/css/boxicon.min.css">
    <!-- Flaticon CSS-->
    <link rel="stylesheet" href="assets/fonts/flaticon/flaticon.css">
    <!-- Magnific CSS -->
    <link rel="stylesheet" href="assets/css/magnific-popup.css">
    <!-- Meanmenu CSS -->
    <link rel="stylesheet" href="assets/css/meanmenu.css">
    <!-- Nice Select CSS -->
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <!-- Dark CSS -->
    <link rel="stylesheet" href="assets/css/dark.css">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="assets/css/responsive.css">
    <!-- Title CSS -->
    <title>Opportunity Hub</title>
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/img/favicon.png">
</head>

<body>
   
    <!-- Page Title Start -->
    <section class="page-title title-bg13">
        <div class="d-table">
            <div class="d-table-cell">
                <h2>Sign Up</h2>
                <ul>
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>Sign Up</li>
                </ul>
            </div>
        </div>
        <div class="lines">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </div>
    </section>
    <!-- Page Title End -->

    <!-- Sign up Section Start -->
    <div class="signup-section ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-8 offset-md-2 offset-lg-3">
                    <form class="signup-form" action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
                        <div class="form-group">
                            <label>Enter Username</label>
                            <input type="text" class="form-control" name="uname" placeholder="Enter Username" value="<?= htmlspecialchars($uname) ?>">
                            <?php if (!empty($unameerr)) : ?>
                                <span><?= $unameerr ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label>Enter Email</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter Your Email" value="<?= htmlspecialchars($email) ?>" required>
                            <?php if (!empty($emailerr)) : ?>
                                <span><?= $emailerr ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label>Enter Password</label>
                            <input type="password" class="form-control" name="password" placeholder="Enter Your Password" value="<?= htmlspecialchars($pswd) ?>" required>
                            <?php if (!empty($pswderr)) : ?>
                                <span><?= $pswderr ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label>Repeat Password</label>
                            <input type="password" class="form-control" name="password2" placeholder="Repeat Your Password" value="<?= htmlspecialchars($password2) ?>" required>
                            <?php if (!empty($password2err)) : ?>
                                <span><?= $password2err ?></span>
                            <?php endif; ?>
                        </div>

                        <div class="form-group">
                            <label>Enter Your Category/Position</label>
                            <select class="form-select category" name="position">
                                <!-- <option data-display="Job Type">Job Type</option> -->
                                <option value="Employer">Employer</option>
                                <option value="Job Seeker">Job Seeker</option>
                                <!-- <option value="Freelancer">Freelancer</option> -->
                            </select>
                            <!-- <input type="password" class="form-control" name="position" placeholder="Enter Employer or Job-seeker" required> -->
                        </div>

                        <div class="signup-btn text-center">
                            <button type="submit" name="submit">Sign Up</button>
                        </div>

                        <!-- <div class="other-signup text-center">
                            <span>Or sign up with</span>
                            <ul>
                                <li>
                                    <a href="#">
                                        <i class='bx bxl-google'></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class='bx bxl-facebook'></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class='bx bxl-twitter'></i>
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <i class='bx bxl-linkedin'></i>
                                    </a>
                                </li>
                            </ul>
                        </div> -->

                        <div class="create-btn text-center">
                            <p>
                                Have an Account?
                                <a href="sign-in.php">
                                    Sign In
                                    <i class='bx bx-chevrons-right bx-fade-right'></i>
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Sign Up Section End -->
   
</body>

</html>