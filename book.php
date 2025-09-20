<?php
include 'db.php';
$car_id = $_GET['car_id'] ?? '';
$pickup = $_GET['pickup'] ?? '';
$return = $_GET['return'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $stmt = $conn->prepare("SELECT price_per_day FROM cars WHERE id = ?");
    $stmt->execute([$car_id]);
    $car = $stmt->fetch(PDO::FETCH_ASSOC);
    $days = (strtotime($return) - strtotime($pickup)) / (60 * 60 * 24);
    $total_price = $car['price_per_day'] * $days;
    
    $stmt = $conn->prepare("INSERT INTO bookings (car_id, user_name, user_email, pickup_date, return_date, total_price) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$car_id, $name, $email, $pickup, $return, $total_price]);
    $confirmation = "Booking confirmed! Total Price: $$total_price";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentACar - Book Car</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        header {
            background: #2c3e50;
            color: white;
            padding: 1rem;
            text-align: center;
        }
        .booking-form {
            background: white;
            width: 90%;
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .booking-form h2 {
            margin-bottom: 1rem;
            color: #2c3e50;
        }
        .booking-form label {
            display: block;
            margin: 0.5rem 0;
            color: #2c3e50;
        }
        .booking-form input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 1rem;
        }
        .booking-form button {
            width: 100%;
            padding: 0.8rem;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .booking-form button:hover {
            background: #c0392b;
        }
        .confirmation {
            text-align: center;
            color: #27ae60;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <header>
        <h1>RentACar - Book Your Car</h1>
    </header>
    <div class="booking-form">
        <h2>Complete Your Booking</h2>
        <form method="POST">
            <label for="name">Full Name</label>
            <input type="text" id="name" name="name" required>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <label for="pickup">Pickup Date</label>
            <input type="date" id="pickup" value="<?= $pickup ?>" readonly>
            <label for="return">Return Date</label>
            <input type="date" id="return" value="<?= $return ?>" readonly>
            <button type="submit">Confirm Booking</button>
        </form>
        <?php if (isset($confirmation)): ?>
            <p class="confirmation"><?= $confirmation ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
