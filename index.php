<?php

session_start();
if (!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}


$title = "VartaLaap - Ask & Answer Platform";
$description = "VartaLaap is a community where users ask questions and share answers.";

if (isset($_GET['signup'])) {
    $title = "Sign Up - VartaLaap";
    $description = "Create an account on VartaLaap to ask questions and join the community.";
} elseif (isset($_GET['login'])) {
    $title = "Login - VartaLaap";
    $description = "Login to VartaLaap and start asking or answering questions.";
} elseif (isset($_GET['askquestion'])) {
    $title = "Ask a Question - VartaLaap";
    $description = "Ask questions on VartaLaap and get answers from the community.";
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php
            echo htmlspecialchars($title);
            ?>
    </title>
    <meta name="description" content="<?php echo htmlspecialchars($description) ?>">
    <link rel="shortcut icon" href="./discuss.jpg" type="image/x-icon">
    <?php
    include("./client/commonFiles.php");
    ?>
</head>

<body>
    <?php

    include("./client/header.php");
    ?>
    <div id="response_message">

    </div>

    <?php
    // session_start();
    if (isset($_SESSION['flash_message'])):
    ?>
        <div class="alert alert-<?= $_SESSION['flash_status'] ?> alert-dismissible fade show text-center" role="alert">
            <strong><?= htmlspecialchars($_SESSION['flash_message'], ENT_QUOTES, 'UTF-8') ?></strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php
        // remove flash message so it shows only once
        unset($_SESSION['flash_message']);
        unset($_SESSION['flash_status']);
    endif;
    ?>
    <?php

    if (isset($_SESSION['user'])) {
        if (isset($_GET['askquestion'])) {

            include("./client/askquestion.php");
        } elseif (($_SERVER['REQUEST_URI'] == '/testProjects/discuss/')) {
            include("./client/home.php");
        } else if (isset($_GET['changePassword'])) {
            include("./client/changePassword.php");
        } else if (isset($_GET['profile'])) {
            include("./client/profile.php");
        } else if (isset($_GET['editProfile'])) {
            include("./client/editProfile.php");
        } else if (isset($_GET['viewQuestions'])) {
            include("./client/viewQuestions.php");
        } else if (isset($_GET['viewPage'])) {
            include("./client/viewquestion.php");
        } else if (isset($_GET['editQuesPage'])) {
            include("./client/editQuesPage.php");
        } else if (isset($_GET['searchPage'])) {
            include("./client/searchPage.php");
        } else {
            include("./client/pagenotfound.php");
        }
    } else {

        if (isset($_GET['signup'])) {
            include("./client/signup.php");
        } else if (isset($_GET['login'])) {
            include("./client/login.php");
        } else if (isset($_GET['resetPassword'])) {
            include("./client/resetpassword.php");
        } else if (($_SERVER['REQUEST_URI'] == '/testProjects/discuss/')) {
            include("./client/home.php");
        } else if (isset($_GET['askquestion'])) {
            if (isset($_SESSION['user']))
                include("./client/askquestion.php");
            else
                header("Location: ?login=true");
        } else if (isset($_GET['viewPage'])) {
            include("./client/viewquestion.php");
        } else if (isset($_GET['searchPage'])) {
            include("./client/searchPage.php");
        } else {
            include("./client/pagenotfound.php");
        }
    }
    ?>

    <script src="./public/script.js"></script>
</body>

</html>