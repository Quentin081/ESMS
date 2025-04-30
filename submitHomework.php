<?php
include('connect.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['homework_id'])) {
    $homework_id = $_POST['homework_id'];
    $student_id = $_SESSION['user_id'];

    // Update homework status to 'Submitted'
    $sql = "UPDATE student_homework SET status = 'Submitted' 
            WHERE homework_id = ? AND student_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $homework_id, $student_id);

    if ($stmt->execute()) {
        $_SESSION['success_message'] = 'Your homework has been successfully submitted!';
        echo 'success';
    } else {
        echo 'error';
    }

    $stmt->close();
    $conn->close();
}
?>
