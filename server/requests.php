<?php

session_start();
include("../common/db.php");
header("Content-Type: application/json");

// if (!isset($_SESSION['user'])) {
//     echo json_encode([
//         'res_status' => false,
//         'message' => 'Unauthorized access'
//     ]);
//     exit;
// }


// search 
if (isset($_GET['task']) && $_GET['task'] == "searchData") {
    // print_r($_GET);
    // die();
    $search = $_GET['search'];
    $stmt = $con->prepare(
        "SELECT * FROM questions WHERE title LIKE ? OR description LIKE ?"
    );
    $like = "%" . $search . "%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
    $result = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode([
        "res_status" => true,
        "searchResult" => $result
    ]);
    exit();
}


// get user
function getUserId($email)
{
    include("../common/db.php");
    $stmt = $con->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    // print_r("email");
    // print_r($email);
    // print_r("userid");
    // print_r($user['id']);
    // exit();
    return $user['id'];
}

// get username
if (isset($_GET['task']) && $_GET['task'] == "getUsername") {

    $user_id = intval($_GET['user_id']);

    // // print_r($currentuserid);
    // exit();
    // Prepare and execute query
    $stmt = $con->prepare("SELECT username FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Check if user exists
    if ($user) {
        echo json_encode([
            'res_status' => true,
            'username' => $user['username']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'User not found'
        ]);
    }
    exit();
}

// edit ask question
if (isset($_GET['task']) && $_GET['task'] == "updateQuest") {

    $question_id = intval($_GET['questionId']);
    // print_r("user_id");
    // print_r($user_id);
    // exit();
    // Prepare and execute query
    $stmt = $con->prepare("SELECT * FROM questions WHERE id = ?");
    $stmt->bind_param("i", $question_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $question = $result->fetch_assoc();
    $currentuserid = getUserId($_SESSION['user']['email']);
    // print_r($question['user_id']);
    // print_r($currentuserid);
    // exit();
    // Check if user exists
    if (isset($question) && $question['user_id'] == $currentuserid) {
        if ($question) {
            echo json_encode([
                'res_status' => true,
                'question' => $question
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Data not found'
            ]);
        }
        exit();
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Not authorized user'
        ]);
    }
    exit();
}


// update ask question
if (isset($_POST['updateaskQuesBtn'])) {

    $question_id = ($_POST['questionid']) ?? "";
    $title = ($_POST['title']) ?? "";
    $description = ($_POST['description']) ?? "";
    $stmt = $con->prepare("update questions set title=?, description=? WHERE id = ?");
    $stmt->bind_param("sss", $title, $description, $question_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $_SESSION["flash_message"] = "Question updated successfully";
        $_SESSION["flash_status"] = "success";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        // echo json_encode([
        //     "res_status" => true,
        //     "redirect" => $_SERVER['HTTP_REFERER']
        // ]);
    } else {
        $_SESSION["flash_message"] = "Failed to update question";
        $_SESSION["flash_status"] = "danger";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        // echo json_encode([
        //     "res_status" => false,
        //     "redirect" => $_SERVER['HTTP_REFERER']
        // ]);
    }
    exit();
}

// delete ask question
if (isset($_GET['task']) && $_GET['task'] == "deleteQuesPage") {

    $question_id = intval($_GET['questionid']) ?? "";

    // print_r("HEllo");
    // print_r($_GET);
    // exit();
    $title = ($_POST['title']) ?? "";
    $description = ($_POST['description']) ?? "";
    $stmt = $con->prepare("delete from questions WHERE id = ?");
    $stmt->bind_param("i", $question_id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        $stmtcmt = $con->prepare("delete from comments WHERE question_id = ?");
        $stmtcmt->bind_param("i", $question_id);
        $stmtcmt->execute();

        if ($stmtcmt->affected_rows > 0) {
            $_SESSION["flash_message"] = "Question deleted successfully";
            $_SESSION["flash_status"] = "success";
            header("Location: " . $_SERVER['HTTP_REFERER']);
        }
        exit();
        // echo json_encode([
        //     "res_status" => true,
        //     "redirect" => $_SERVER['HTTP_REFERER']
        // ]);
    } else {
        $_SESSION["flash_message"] = "Failed to delete question";
        $_SESSION["flash_status"] = "danger";
        header("Location: " . $_SERVER['HTTP_REFERER']);
        // echo json_encode([
        //     "res_status" => false,
        //     "redirect" => $_SERVER['HTTP_REFERER']
        // ]);
    }
    exit();
}

// signup
if (isset($_POST['task']) && $_POST['task'] == "signup") {


    if (!hash_equals($_SESSION['csrf'], $_POST['csrf'] ?? '')) {
        http_response_code(403);
        echo json_encode([
            "res_status" => false,
            "message" => "Invalid CSRF token"
        ]);
        exit;
    }


    $username = $_POST['username'] ?? '';
    $email    = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $address  = $_POST['address'] ?? '';
    $favourite  = $_POST['favourite'] ?? '';

    if (!$username || !$email || !$password || !$address || !$favourite) {
        echo json_encode([
            "res_status" => false,
            "message" => "All fields are required"
        ]);
        exit;
    }

    if (
        strlen($username) > 100 ||
        strlen($email) > 150 ||
        strlen($address) > 255 ||
        strlen($favourite) > 50
    ) {
        echo json_encode([
            "res_status" => false,
            "message" => "Input too long"
        ]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            "res_status" => false,
            "message" => "Invalid email address"
        ]);
        exit;
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $checkstmt = $con->prepare('SELECT * from users where email = ?');
    $checkstmt->bind_param("s", $email);
    $checkstmt->execute();
    $checkstmt->store_result();
    if ($checkstmt->num_rows() > 0) {
        echo json_encode([
            "res_status" => false,
            "message" => "Record already exists"
        ]);
        exit();
    }

    $stmt = $con->prepare(
        "INSERT INTO users (username, email, password, address, favourite) VALUES (?,?,?,?,?)"
    );
    $stmt->bind_param("sssss", $username, $email, $hashedPassword, $address, $favourite);

    if ($stmt->execute()) {
        $_SESSION['flash_message'] = "Welcome " . ucfirst($username);
        $_SESSION['flash_status'] = "success";
        $_SESSION['user'] = ["login" => true, "username" => ucfirst($username), "email" => $email, "favourite" => ucfirst($favourite)];
        echo json_encode([
            "res_status" => true,
            "redirect" => "../discuss"
        ]);
    } else {
        echo json_encode([
            "res_status" => false,
            "message" => "Record insertion failed"
        ]);
    }
    exit;
}


// logout
if (isset($_GET['logout'])) {
    session_unset(); // remove all session variables
    session_destroy(); // optional: destroy session completely
    header('Location: ../'); // correct syntax
    exit(); // always exit after header redirect
}


// login

$data = json_decode(file_get_contents("php://input"), true);
if (isset($data['task']) && $data['task'] == "login") {

    // echo "haklsdhfka";
    // if (!hash_equals($_SESSION['csrf'], $_POST['csrf'] ?? '')) {
    //     http_response_code(403);
    //     echo json_encode([
    //         "res_status" => false,
    //         "message" => "Invalid CSRF token"
    //     ]);
    //     exit;
    // }

    $email    = $data['email'] ?? '';
    $password = $data['password'] ?? '';


    if (!$email || !$password) {
        echo json_encode([
            "res_status" => false,
            "message" => "All fields are required"
        ]);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode([
            "res_status" => false,
            "message" => "Invalid email address"
        ]);
        exit;
    }


    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $checkstmt = $con->prepare('SELECT * from users where email = ?');
    $checkstmt->bind_param("s", $email);
    $checkstmt->execute();
    $result = $checkstmt->get_result();
    // print_r($result->fetch_assoc());
    // die();
    if ($result->num_rows >  0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            if ($username != "") {
                $_SESSION['user'] = ["login" => true, "username" => ucfirst($user['username']), "email" => $user['email'], "favourite" => ucfirst($user['favourite'])];
                $_SESSION['flash_message'] = "Welcome " . ucfirst($user['username']);
                $_SESSION['flash_status'] = "success";
                echo json_encode([
                    "res_status" => true,
                    // "message" => "Welcome " . $user['username']
                    "redirect" => "../discuss"
                ]);
                // header('Location: ../');
                exit();
            }
        } else {
            echo json_encode([
                "res_status" => false,
                "message" => "Invalid password"
            ]);
            exit();
        }
    } else {
        echo json_encode([
            "res_status" => false,
            "message" => "Record does not exist"
        ]);
        exit();
    }
}


if (isset($data['task']) && $data['task'] == "verifyPassword") {
    // echo "verify password";

    $email = $data['email'] ?? '';
    $favourite = $data['favourite'] ?? '';

    if (!$email || !$favourite) {

        echo json_encode([
            "res_status" => false,
            "message" => "All fields are required"
        ]);
        exit();
    }

    $verifyPassStmt = $con->prepare('Select * from users where email = ? and favourite = ?');
    $verifyPassStmt->bind_param("ss", $email, $favourite);
    $verifyPassStmt->execute();
    $result = $verifyPassStmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode([
            "res_status" => true,
        ]);
        exit();
    } else {
        echo json_encode([
            "res_status" => false,
            "message" => "Invalid details"
        ]);
        exit();
    }
    exit();
}

if (isset($data['task']) && $data['task'] == "updatePassword") {
    // echo "verify password";

    $email = $data['email'] ?? '';
    $favourite = $data['favourite'] ?? '';
    $password = $data['password'] ?? '';

    if (!$email || !$favourite || !$password) {

        echo json_encode([
            "res_status" => false,
            "message" => "All fields are required"
        ]);
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $verifyPassStmt = $con->prepare('update users set password = ? where email = ? and favourite = ?');
    $verifyPassStmt->bind_param("sss", $hashedPassword, $email, $favourite);
    $verifyPassStmt->execute();
    // $result = $verifyPassStmt->get_result();
    if ($verifyPassStmt->affected_rows > 0) {
        $_SESSION['flash_message'] = "Password updated successfully";
        $_SESSION['flash_status'] = "success";
        echo json_encode([
            "res_status" => true,
            "redirect" => "?login=true"
        ]);
        exit();
    } else {
        echo json_encode([
            "res_status" => false,
            "message" => "Failed to update password"
        ]);
        exit();
    }
    exit();
}

// after logged in verify password
if (isset($data['task']) && $data['task'] == "verifyPass") {
    // echo "verify password";

    $password = $data['oldpassword'] ?? '';

    if (!$password) {

        echo json_encode([
            "res_status" => false,
            "message" => "Enter your old password"
        ]);
        exit();
    }

    $verifyPassStmt = $con->prepare('Select * from users where email = ?');
    $verifyPassStmt->bind_param("s", $_SESSION['user']['email']);
    $verifyPassStmt->execute();
    $result = $verifyPassStmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            echo json_encode([
                "res_status" => true,
            ]);
            exit();
        } else {
            echo json_encode([
                "res_status" => false,
                "message" => "Wrong Password, Please enter correct Password"
            ]);
            exit();
        }
    } else {
        echo json_encode([
            "res_status" => false,
            "message" => "Invalid details"
        ]);
        exit();
    }
    exit();
}

if (isset($data['task']) && $data['task'] == "updatePass") {

    $email =  $_SESSION['user']['email'];
    $password = $data['newpassword'] ?? '';

    if (!$email || !$password) {

        echo json_encode([
            "res_status" => false,
            "message" => "All fields are required"
        ]);
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $verifyPassStmt = $con->prepare('update users set password = ? where email = ? ');
    $verifyPassStmt->bind_param("ss", $hashedPassword, $email);
    $verifyPassStmt->execute();
    // $result = $verifyPassStmt->get_result();
    if ($verifyPassStmt->affected_rows > 0) {
        $_SESSION['flash_message'] = "Password updated successfully";
        $_SESSION['flash_status'] = "success";
        echo json_encode([
            "res_status" => true,
            "redirect" => "?changePassword=true"
        ]);
        exit();
    } else {
        echo json_encode([
            "res_status" => false,
            "message" => "Failed to update password"
        ]);
        exit();
    }
    exit();
}


// edit profile
if (isset($_GET['task']) && $_GET['task'] === "getProfile") {

    if (!isset($_SESSION['user'])) {
        echo json_encode([
            "res_status" => false,
            "message" => "Unauthorized"
        ]);
        exit;
    }

    $stmt = $con->prepare(
        "SELECT username, email, address, favourite 
         FROM users WHERE email = ?"
    );
    $stmt->bind_param("s", $_SESSION['user']['email']);
    $stmt->execute();

    $user = $stmt->get_result()->fetch_assoc();

    echo json_encode([
        "res_status" => true,
        "user" => $user
    ]);
    exit;
}


// update profile

// signup
if (isset($_POST['task']) && $_POST['task'] == "updateProfile") {


    // if (!hash_equals($_SESSION['csrf'], $_POST['csrf'] ?? '')) {
    //     http_response_code(403);
    //     echo json_encode([
    //         "res_status" => false,
    //         "message" => "Invalid CSRF token"
    //     ]);
    //     exit;
    // }


    $username = $_POST['username'] ?? '';
    $address  = $_POST['address'] ?? '';
    $favourite  = $_POST['favourite'] ?? '';
    $email  = $_SESSION['user']['email'] ?? '';

    if (!$username || !$address || !$favourite) {
        echo json_encode([
            "res_status" => false,
            "message" => "All fields are required"
        ]);
        exit;
    }

    if (
        strlen($username) > 100 ||
        strlen($address) > 255 ||
        strlen($favourite) > 50
    ) {
        echo json_encode([
            "res_status" => false,
            "message" => "Input too long"
        ]);
        exit;
    }



    $checkstmt = $con->prepare('update users set username=?, address=?,favourite=?  where email = ?');
    $checkstmt->bind_param("ssss", $username, $address, $favourite, $email);
    // $checkstmt->execute();

    if ($checkstmt->execute()) {
        $_SESSION['flash_message'] = "Profile has been updated";
        $_SESSION['flash_status'] = "success";
        echo json_encode([
            "res_status" => true,
            "redirect" => "?profile=true"
        ]);
        exit();
    } else {
        echo json_encode([
            "res_status" => false,
            "message" => "Error while updating profile"
        ]);
        exit();
    }
}



// profile image upload
if (isset($_POST['profileSubmitBtn'])) {
    $profileStmt = $con->prepare('Select * from users where email=?');
    $profileStmt->bind_param("s", $_SESSION['user']['email']);
    $profileStmt->execute();
    $result = $profileStmt->get_result();
    $user = $result->fetch_assoc();

    // print_r($_FILES["profile"]);


    $target_dir = __DIR__ . "/../public/uploads/";
    $filename = $user['id'] . "_" . basename($_FILES["profile"]["name"]);
    $target_file = $target_dir . $filename;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["profile"]["tmp_name"]);
    if ($check === false) {
        $_SESSION["flash_message"] = "Profile image uploaded";
        $_SESSION["flash_status"] = "success";
        echo json_encode([
            "res_status" => false,
        ]);
        header("Location: ../?profile=true");
        $uploadOk = 0;
    }

    if ($_FILES["profile"]["size"] > (5 * 1024 * 1024)) {

        $_SESSION["flash_message"] = "Image size is large";
        $_SESSION["flash_status"] = "success";
        echo json_encode([
            "res_status" => false,
        ]);
        header("Location: ../?profile=true");
        $uploadOk = 0;
    }

    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {

        $_SESSION["flash_message"] = "Invalid image type";
        $_SESSION["flash_status"] = "success";
        echo json_encode([
            "res_status" => true,
        ]);
        header("Location: ../?profile=true");
        $uploadOk = 0;
    }

    if ($uploadOk) {

        move_uploaded_file($_FILES["profile"]["tmp_name"], $target_file);
        $updateProfileImageStmt = $con->prepare("update users set profile=? where id=?");
        $updateProfileImageStmt->bind_param("ss", $filename, $user['id']);
        if ($updateProfileImageStmt->execute()) {
            $_SESSION["flash_message"] = "Profile image uploaded";
            $_SESSION["flash_status"] = "success";
            echo json_encode([
                "res_status" => true,
            ]);
            header("Location: ../?profile=true");
        }
        exit();
    }
    exit();
}


// edit profile
if (isset($_GET['task']) && $_GET['task'] === "getProfileImage") {

    if (!isset($_SESSION['user'])) {
        echo json_encode([
            "res_status" => false,
            "message" => "Unauthorized"
        ]);
        exit;
    }

    $stmt = $con->prepare(
        "SELECT * 
         FROM users WHERE email = ?"
    );
    $stmt->bind_param("s", $_SESSION['user']['email']);
    $stmt->execute();

    $user = $stmt->get_result()->fetch_assoc();

    echo json_encode([
        "res_status" => true,
        "profile" => $user['profile']
    ]);
    exit;
}



// create ask question

if (isset($_POST['askQuesBtn'])) {


    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $category = $_POST['category'] ?? '';

    if (empty($title) || empty($description) || empty($category)) {
        $_SESSION['flash_message'] = "All field are required";
        $_SESSION['flash_status'] = "danger";
        echo json_encode([
            "res_status" => false
        ]);
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }

    $getUserStmt = $con->prepare('SELECT id from users where email=?');
    $getUserStmt->bind_param("s", $_SESSION['user']['email']);
    $getUserStmt->execute();
    $result = $getUserStmt->get_result();
    $userid = $result->fetch_assoc();

    $createQuesStmt = $con->prepare('insert into questions (title, description, category, user_id) values(?,?,?,?)');
    $createQuesStmt->bind_param("ssss", $title, $description, $category, $userid['id']);
    if ($createQuesStmt->execute()) {
        $_SESSION['flash_message'] = "Question has been created";
        $_SESSION['flash_status'] = "success";
        echo json_encode([
            "res_status" => true
        ]);
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        $_SESSION['flash_message'] = "Something error";
        $_SESSION['flash_status'] = "danger";
        echo json_encode([
            "res_status" => false
        ]);
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}


// getQuestionsRespectiveUser

if (isset($_GET['task']) && $_GET['task'] == 'getQuestionsRespectiveUser') {

    $getUserStmt = $con->prepare('SELECT id from users where email=?');
    $getUserStmt->bind_param("s", $_SESSION['user']['email']);
    $getUserStmt->execute();
    $result = $getUserStmt->get_result();
    $userid = $result->fetch_assoc();
    if (!$userid) {
        echo json_encode(["error" => "User not found"]);
        exit;
    }
    $getQuestStmt = $con->prepare('SELECT * from questions where user_id=?');
    $getQuestStmt->bind_param("i", $userid['id']);

    $getQuestStmt->execute();
    $resultQues = $getQuestStmt->get_result();
    $questions = $resultQues->fetch_all(MYSQLI_ASSOC);
    if (count($questions) > 0) {
        echo json_encode([
            "res_status" => true,
            "questions" => $questions
        ]);
        // header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo json_encode([
            "res_status" => false,
            "message" => "Something went wrong"
        ]);
        // header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}


// getQuestionsRespectiveUser

if (isset($_GET['task']) && $_GET['task'] == 'getQuestionRespective') {
    $questionid = $_GET['questionid'] ?? "";
    $getQuestStmt = $con->prepare('SELECT * from questions where id=?');
    $getQuestStmt->bind_param("i", $questionid);

    $getQuestStmt->execute();
    $resultQues = $getQuestStmt->get_result();
    $questions = $resultQues->fetch_assoc();

    $getCmtStmt = $con->prepare('SELECT * FROM comments WHERE question_id = ? ORDER BY id DESC');
    $getCmtStmt->bind_param("i", $questionid);

    $getCmtStmt->execute();
    $resultCmt = $getCmtStmt->get_result();
    $comments = $resultCmt->fetch_all(MYSQLI_ASSOC);
    // print_r($questions);
    // exit();
    if (count($questions) > 0) {
        echo json_encode([
            "res_status" => true,
            "questions" => $questions,
            "comments" => $comments
        ]);
        // header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        echo json_encode([
            "res_status" => false,
            "message" => "Something went wrong"
        ]);
        // header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}


if (isset($data['task']) && $data['task'] == "makeComment") {
    // print_r($data);
    // exit();
    $questionid = $data['questionId'] ?? "";
    $comment = $data['comment'] ?? "";
    // $questionid = $_SESSION['user'][''] ?? "";
    $getUserStmt = $con->prepare('SELECT id from users where email=?');
    $getUserStmt->bind_param("s", $_SESSION['user']['email']);
    $getUserStmt->execute();
    $result = $getUserStmt->get_result();
    $userid = $result->fetch_assoc();

    $makeCmtStmt = $con->prepare('INSERT into comments (comment, question_id, user_id) VALUES(?,?,?)');
    $makeCmtStmt->bind_param("sss", $comment, $questionid, $userid['id']);
    if ($makeCmtStmt->execute()) {
        $_SESSION['flash_message'] = "Comment has been created";
        $_SESSION['flash_status'] = "success";
        echo json_encode([
            "res_status" => true,
            "redirect" => $_SERVER['HTTP_REFERER']
        ]);
        exit();
    } else {
        echo json_encode([
            "res_status" => false,
            "message" => "Something went wrong"
        ]);
        // header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}

$cursor = $_GET['cursor'] ?? null;
$limit = 6;

if ($cursor) {
    $stmt = $con->prepare("
        SELECT *
        FROM questions
        WHERE id < ?
        ORDER BY id DESC
        LIMIT ?
    ");
    $stmt->bind_param("ii", $cursor, $limit);
    $stmt->execute();
    $srlresult = $stmt->get_result();
    $srquestions = $srlresult->fetch_all(MYSQLI_ASSOC);

    // next cursor = last ID
    $nextCursor = count($srquestions) ? end($srquestions)['id'] : null;

    echo json_encode([
        'srquestions' => $srquestions,
        'nextCursor' => $nextCursor
    ]);
    exit();
} else {
    $stmt = $con->prepare("
        SELECT *
        FROM questions
        ORDER BY id DESC
        LIMIT ?
    ");
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $srlresult = $stmt->get_result();
    $srquestions = $srlresult->fetch_all(MYSQLI_ASSOC);

    // next cursor = last ID
    $nextCursor = count($srquestions) ? end($srquestions)['id'] : null;

    echo json_encode([
        'srquestions' => $srquestions,
        'nextCursor' => $nextCursor
    ]);
    exit();
}
