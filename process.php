<?php
// Connect to your database (replace these parameters with your actual database credentials)

$servername = "localhost";
$username = "root";
$password = "";
$database="pwd";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    // Sanitize and validate input data
    $events = isset($_POST['events']) ? implode(', ', $_POST['events']) : '';
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '';
    $mobile_number = isset($_POST['mobile_number']) ? htmlspecialchars($_POST['mobile_number']) : '';
    $age = isset($_POST['age']) ? htmlspecialchars($_POST['age']) : '';
    $player_type = isset($_POST['player_type']) ? htmlspecialchars($_POST['player_type']) : '';
    $gender = isset($_POST['gender']) ? htmlspecialchars($_POST['gender']) : '';
    $division = isset($_POST['division']) ? htmlspecialchars($_POST['division']) : '';
    $district = isset($_POST['district']) ? htmlspecialchars($_POST['district']) : '';
    $amount = isset($_POST['amount']) ? htmlspecialchars($_POST['amount']) : '';



    // Handle file uploads
    $profile_pic_filename ="https://dscpwdele.co.in/registration/id-pic/". handleFileUpload("profile-pic", "id-pic", $mobile_number . "_id.jpg");
    $dl_pic_filename ="https://dscpwdele.co.in/registration/payment_pic-pic/". handleFileUpload("dl-pic", "payment-pic", $mobile_number . "_payment_pic.jpg");

    // Insert data into the database
    $sql = "
     INSERT INTO registrations (
        name,
        mobile_number,
        events,
        age,
        gender,
        category,
        district,
        division,
        id_photo,
        payment_receipt,
        amount
    ) VALUES (
       
        '$name',
        '$mobile_number',
        '$events',
        '$age',
        '$gender',
        '$player_type',
        '$district',
        '$division',
        '$profile_pic_filename',
        '$dl_pic_filename',
        '$amount'

    
    
    );
    
    
    
    
    
    ";

    if ($conn->query($sql) === TRUE) {
        // Redirect to success.php after successful registration
        header("Location: registration_success.php?name=".$name);
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Function to handle file uploads
function handleFileUpload($fileInputName, $uploadFolder, $filename) {
    $targetDir = $uploadFolder . "/";
    $targetFile = $targetDir . $filename;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

    // Check file size
    if ($_FILES[$fileInputName]["size"] > 50000000) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowedExtensions = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowedExtensions)) {
        echo "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
        $uploadOk = 0;
    }

    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES[$fileInputName]["tmp_name"], $targetFile)) {
            echo "The file " . htmlspecialchars(basename($_FILES[$fileInputName]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

    return $filename;
}

// Close the database connection
$conn->close();
?>
