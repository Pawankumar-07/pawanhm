<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel";

$conn = new mysqli('localhost', 'root', '', 'hotel');

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
    $price = $_POST['price'];
    $total_price = $_POST['total_price'];

    $sql = "INSERT INTO bookings (name, email, phone_number, address, city, state, zip, guests, room_type, special_requests, payment_method, checkin, checkout, price, total_price)
            VALUES ('$name', '$email', '$phone_number', '$address', '$city', '$state', '$zip', '$guests', '$room_type', '$special_requests', '$payment_method', '$checkin', '$checkout', '$price', '$total_price')";

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
    <title>Rooms</title>
    <link rel="stylesheet" href="rooms.css">
    <script>
        function updatePrice() {
            var roomType = document.querySelector('select[name="room_type"]').value;
            var specialRequests = document.querySelector('textarea[name="special_requests"]').value;
            var priceField = document.querySelector('input[name="price"]');
            var totalPriceField = document.querySelector('input[name="total_price"]');
            var paymentMethodField = document.querySelector('select[name="payment_method"]');
            var qrCodeDiv = document.querySelector('.upi-qr-code');

            var price = 0;
            if (roomType === 'single') {
                price = 1000; 
            } else if (roomType === 'double') {
                price = 2000; 
            } else if (roomType === 'suite') {
                price = 5000; 
            }

            var specialRequestCharges = 0;
            if (specialRequests.includes('extra bed')) {
                specialRequestCharges += 50; 
            }
            if (specialRequests.includes('breakfast')) {
                specialRequestCharges += 20; 
            }

            var gst = (price + specialRequestCharges) * 0.18;
            var totalPrice = price + specialRequestCharges + gst;

            priceField.value = price;
            totalPriceField.value = totalPrice.toFixed(2);

            if (totalPrice > 0) {
                paymentMethodField.style.display = 'block';
                qrCodeDiv.style.display = 'block';
            } else {
                paymentMethodField.style.display = 'none';
                qrCodeDiv.style.display = 'none';
            }
        }

        function showQRCode() {
            var paymentMethod = document.querySelector('select[name="payment_method"]').value;
            if (paymentMethod === 'upi_qr') {
                document.querySelector('.upi-qr-code').style.display = 'block';
            } else {
                document.querySelector('.upi-qr-code').style.display = 'none';
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector('select[name="room_type"]').addEventListener("change", updatePrice);
            document.querySelector('textarea[name="special_requests"]').addEventListener("input", updatePrice);
        });
    </script>
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
            <input type="number" name="price" placeholder="Price" readonly>
            <input type="number" name="total_price" placeholder="Total Price" readonly>
            <select name="payment_method" onchange="showQRCode()" style="display: none;" required>
                <option value="" disabled selected>Payment Method</option>
                <option value="cash">Cash</option>
                <option value="upi_qr">UPI QR</option>
            </select>
            <input type="date" name="checkin" required>
            <input type="date" name="checkout" required>
            <button type="submit" name="book">Book Now</button>
        </form>
        <div class="upi-qr-code" style="display:none;">
            <h3>Scan to Pay via UPI</h3>
            <img src="sahil.jpeg" alt="UPI QR Code" />
        </div>
    </div>
</body>

</html>
