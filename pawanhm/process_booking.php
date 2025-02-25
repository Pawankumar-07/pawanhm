<?php
// Database connection
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['number'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $guests = $_POST['guests'];
    $room_type = $_POST['room_type'];
    $special_requests = $_POST['special_requests'];
    $payment_method = $_POST['payment_method'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];

    $sql = "INSERT INTO bookings (name, email, phone_number, address, city, state, zip, guests, room_type, special_requests, payment_method, checkin, checkout)
            VALUES ('$name', '$email', '$phone_number', '$address', '$city', '$state', '$zip', '$guests', '$room_type', '$special_requests', '$payment_method', '$checkin', '$checkout')";

    if ($conn->query($sql) === TRUE) {
        echo "Booking successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking</title>
    <link rel="stylesheet" href="booking.css">
    
</head>

<body>
    <div class="booking-container">
        <h2>Book Your Stay</h2>
        <form method="post">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="number" name="number" placeholder="Phone Number" required>
            <input type="text" name="address" placeholder="Street Address" required>
            <input type="text" name="city" placeholder="City" required>
            <input type="text" name="state" placeholder="State" required>
            <input type="text" name="zip" placeholder="ZIP Code" required>
            <input type="number" name="guests" placeholder="Number of Guests" required>
            <select name="room_type" required>
                <option value="" disabled selected>Room Type</option>
                <option value="single">Single</option>
                <option value="double">Double</option>
                <option value="suite">Suite</option>
            </select>
            <textarea name="special_requests" placeholder="Any special requests?" rows="3"></textarea>
            <select name="payment_method" required>
                <option value="" disabled selected>Payment Method</option>
                <option value="credit_card">Credit Card</option>
                <option value="debit_card">Debit Card</option>
                <option value="paypal">PayPal</option>
                <option value="cash">Cash</option>
            </select>
            <input type="date" name="checkin" required>
            <input type="date" name="checkout" required>
            <button type="submit" name="book">Book Now</button>
        </form>
        <div class="upi-qr-code">
            <h3>Scan to Pay via UPI</h3>
            <img src="qr.jpeg" alt="UPI QR Code" />
        </div>
    </div>
</body>

</html>
