<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "scholarsystem";

$connect = mysqli_connect($host, $username, $password, $database);

if (!$connect) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
<?php
$dsn = 'mysql:host=localhost;dbname=scholarsystem;charset=utf8';
$username = 'root';
$password = 'root';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
<?php
require_once("db_connect.php"); 

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["intentLetter"])) {

    $lastName = mysqli_real_escape_string($connect, $_POST["lastName"]);
    $firstName = mysqli_real_escape_string($connect, $_POST["firstName"]);
    $middleName = mysqli_real_escape_string($connect, $_POST["middleName"]);
    $email = mysqli_real_escape_string($connect, $_POST["email"]);
    $contactNumber = mysqli_real_escape_string($connect, $_POST["contactNumber"]);

    $intentLetterTmpName = $_FILES["intentLetter"]["tmp_name"];
    $intentLetterType = $_FILES["intentLetter"]["type"];
    $fileUniqueName = $_FILES["intentLetter"]["name"];

    $intentLetterData = file_get_contents($intentLetterTmpName);

    $query = "INSERT INTO userdetails (lastName, firstName, middleName, emailAddress, contactNumber, intentLetterData, intentLetterType, file_unique_name)
              VALUES ('$lastName', '$firstName', '$middleName', '$email', '$contactNumber', ?, '$intentLetterType', '$fileUniqueName')";

    $stmt = mysqli_prepare($connect, $query);
    mysqli_stmt_bind_param($stmt, "s", $intentLetterData);
}

?>

