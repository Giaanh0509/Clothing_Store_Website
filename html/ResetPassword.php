<?php
$serverName = "MSI\SQLEXPRESS";
$database = "ClothingStore";
$uid = "";
$pass = "";

$connection = [
    "Database" => $database,
    "Uid" => $uid,
    "PWD" => $pass
];

$conn = sqlsrv_connect($serverName, $connection);

if (!$conn) {
    exit();
}
$userEmail = $_COOKIE['userEmail'];
$userNewPassword = '';
$userConfirmPassword = '';
$errorMissing = '';
$errorNotMatched = '';
// require_once 'StoredUserInfo.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userNewPassword = $_POST['userNewPassword'];
    $userConfirmPassword = $_POST['userConfirmPassword'];

    if(empty($userNewPassword || empty($userConfirmPassword)))
    {
        $errorMissing = 'Please fill in the fields !';
    } else if ($userConfirmPassword !== $userNewPassword) {
        $errorNotMatched = 'Confirm password does not matched!';
    } else {
        $query = 'UPDATE dbo.CUSTOMERS SET Pword = ? WHERE Email = ?';
        $params = array($userNewPassword, $userEmail);
        $startQuery = sqlsrv_query($conn, $query, $params);
        if($startQuery === false) {
            die( print_r( sqlsrv_errors(), true));
        } else {
            header("Location: login.php");
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên Mật Khẩu</title>
    <link rel="stylesheet" href="../css/createAccount.css">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet" />
</head>

<body>
    <section class="h-100 gradient-form" style="background-color: white; ">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-xl-10">
                    <div class="card rounded-3 text-black" style="border: 1px solid #dadada;">
                        <div class="row g-0">

                            <div class="col-lg-6 d-flex align-items-center gradient-custom-2">
                                <img src="../img/login.png" alt="" style="width: 100%; height: 595px" />
                            </div>
                            <div class="col-lg-6">
                                <div class="card-body p-md-5 mx-md-4">
                                    <div class="text-center">
                                        <h4 class="mt-1 mb-5 pb-1" style="font-weight: 450; margin-bottom: 20px !important;">Reset your password</h4>
                                        <p><?php if($errorMissing) echo $errorMissing; ?></p>
                                    </div>

                                    <form method="post">
                                        <div class="form-outline mb-4">
                                            <input type="password" id="form2Example11" class="form-control" name="userNewPassword"/>
                                            <label class="form-label" for="form2Example11">New Password</label>
                                        </div>
                                        <div class="form-outline mb-4">
                                            <input type="password" id="form2Example11" class="form-control" name="userConfirmPassword"/>
                                            <label class="form-label" for="form2Example11">Confirm Password</label>
                                        </div>
                                        <div class="text-center pt-1 mb-5 pb-1" style="margin-bottom: 20px !important;">
                                            <button class="btn btn-primary btn-block fa-lg gradient-custom-2 mb-3" type="submit" style="background-color: rgb(77, 77, 77); 
                                                    border: 1px solid #535353;
                                                    text-transform: none;">Reset password</button>
                                        </div>
                                        <p><?php if($errorNotMatched) echo $errorNotMatched; ?></p>
                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <p class="mb-0 me-2">Don't have an account?</p>
                                            <a href="../html/signUp.php">
                                                <button type="button" class="btn btn-outline-danger">Create new</button>
                                            </a>

                                        </div>
                                        <div class="d-flex align-items-center justify-content-center pb-4">
                                            <a href="../html/login.php" style="text-decoration: none;">
                                                <p class="mb-0 me-2">Already have an account? Login!</p>
                                            </a>
                                        </div>

                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>

</html>