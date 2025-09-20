<?php
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentACar - Home</title>
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
        .search-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 2rem;
            margin: 2rem auto;
            width: 90%;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .search-container h2 {
            margin-bottom: 1rem;
            color: #2c3e50;
        }
        .search-form {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .search-form input, .search-form select {
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 5px;
            flex: 1;
            min-width: 150px;
        }
        .search-form button {
            padding: 0.8rem 1.5rem;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .search-form button:hover {
            background: #c0392b;
        }
        .featured {
            margin: 2rem auto;
            width: 90%;
            max-width: 1200px;
        }
        .featured h2 {
            text-align: center;
            margin-bottom: 1rem;
        }
        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1rem;
        }
        .car-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .car-card:hover {
            transform: translateY(-5px);
        }
        .car-card img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        .car-card h3 {
            padding: 0.5rem;
            color: #2c3e50;
        }
        .car-card p {
            padding: 0 0.5rem 1rem;
            color: #7f8c8d;
        }
        @media (max-width: 600px) {
            .search-form {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>RentACar</h1>
    </header>
    <div class="search-container">
        <h2>Find Your Perfect Car</h2>
        <form class="search-form" onsubmit="searchCars(event)">
            <input type="text" id="location" placeholder="Pickup Location" required>
            <input type="date" id="pickup-date" required>
            <input type="date" id="return-date" required>
            <select id="car-type">
                <option value="">All Car Types</option>
                <option value="Sedan">Sedan</option>
                <option value="SUV">SUV</option>
            </select>
            <select id="fuel-type">
                <option value="">All Fuel Types</option>
                <option value="Petrol">Petrol</option>
                <option value="Diesel">Diesel</option>
            </select>
            <button type="submit">Search</button>
        </form>
    </div>
    <div class="featured">
        <h2>Featured Cars</h2>
        <div class="car-grid">
            <?php
            $stmt = $conn->query("SELECT * FROM cars WHERE availability = 1 LIMIT 4");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<div class='car-card'>";
                echo "<img src='{$row['image']}' alt='{$row['brand']} {$row['model']}'>";
                echo "<h3>{$row['brand']} {$row['model']}</h3>";
                echo "<p>\${$row['price_per_day']}/day</p>";
                echo "</div>";
            }
            ?>
        </div>
    </div>
    <script>
        function searchCars(event) {
            event.preventDefault();
            const location = document.getElementById('location').value;
            const pickupDate = document.getElementById('pickup-date').value;
            const returnDate = document.getElementById('return-date').value;
            const carType = document.getElementById('car-type').value;
            const fuelType = document.getElementById('fuel-type').value;
            const url = `cars.php?location=${location}&pickup=${pickupDate}&return=${returnDate}&car_type=${carType}&fuel_type=${fuelType}`;
            window.location.href = url;
        }
    </script>
</body>
</html>
