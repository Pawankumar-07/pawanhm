<?php
session_start();

if (isset($_POST['book'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];

    $conn = new mysqli('localhost', 'root', '', 'hotel');

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO bookings (name, email, checkin, checkout) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $checkin, $checkout);

    if ($stmt->execute()) {
        echo "<script>alert('Booking successful!');</script>";
    } else {
        echo "<script>alert('Booking failed! Please try again.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
