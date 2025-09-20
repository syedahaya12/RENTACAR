<?php
include 'db.php';
$location = $_GET['location'] ?? '';
$pickup = $_GET['pickup'] ?? '';
$return = $_GET['return'] ?? '';
$car_type = $_GET['car_type'] ?? '';
$fuel_type = $_GET['fuel_type'] ?? '';

$query = "SELECT * FROM cars WHERE availability = 1";
$params = [];
if ($car_type) {
    $query .= " AND car_type = :car_type";
    $params[':car_type'] = $car_type;
}
if ($fuel_type) {
    $query .= " AND fuel_type = :fuel_type";
    $params[':fuel_type'] = $fuel_type;
}
$stmt = $conn->prepare($query);
$stmt->execute($params);
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RentACar - Car Listings</title>
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
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 2rem auto;
        }
        .filters {
            display: flex;
            gap: 1rem;
            margin-bottom: 1rem;
        }
        .filters select {
            padding: 0.8rem;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
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
            height: 200px;
            object-fit: cover;
        }
        .car-card h3 {
            padding: 0.5rem;
            color: #2c3e50;
        }
        .car-card p {
            padding: 0 0.5rem;
            color: #7f8c8d;
        }
        .car-card button {
            width: 100%;
            padding: 0.8rem;
            background: #e74c3c;
            color: white;
            border: none;
            border-radius: 0 0 10px 10px;
            cursor: pointer;
            transition: background 0.3s;
        }
        .car-card button:hover {
            background: #c0392b;
        }
        @media (max-width: 600px) {
            .filters {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>RentACar - Available Cars</h1>
    </header>
    <div class="container">
        <div class="filters">
            <select id="sort-price" onchange="sortCars()">
                <option value="">Sort by Price</option>
                <option value="low-high">Low to High</option>
                <option value="high-low">High to Low</option>
            </select>
        </div>
        <div class="car-grid">
            <?php foreach ($cars as $car): ?>
                <div class="car-card">
                    <img src="<?= $car['image'] ?>" alt="<?= $car['brand'] ?> <?= $car['model'] ?>">
                    <h3><?= $car['brand'] ?> <?= $car['model'] ?></h3>
                    <p>$<?= $car['price_per_day'] ?>/day</p>
                    <p><?= $car['description'] ?></p>
                    <button onclick="bookCar(<?= $car['id'] ?>, '<?= $pickup ?>', '<?= $return ?>')">Book Now</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
        function sortCars() {
            const sort = document.getElementById('sort-price').value;
            const url = new URL(window.location.href);
            url.searchParams.set('sort', sort);
            window.location.href = url;
        }
        function bookCar(carId, pickup, returnDate) {
            window.location.href = `book.php?car_id=${carId}&pickup=${pickup}&return=${returnDate}`;
        }
        <?php if (isset($_GET['sort'])): ?>
            const cars = document.querySelectorAll('.car-card');
            const sortedCars = Array.from(cars).sort((a, b) => {
                const priceA = parseFloat(a.querySelector('p').textContent.replace('$', '').split('/')[0]);
                const priceB = parseFloat(b.querySelector('p').textContent.replace('$', '').split('/')[0]);
                return '<?php echo $_GET['sort']; ?>' === 'low-high' ? priceA - priceB : priceB - priceA;
            });
            const grid = document.querySelector('.car-grid');
            grid.innerHTML = '';
            sortedCars.forEach(car => grid.appendChild(car));
        <?php endif; ?>
    </script>
</body>
</html>
