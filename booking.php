<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "collegep";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get train details
if (isset($_GET['train_id'])) {
    $train_id = $_GET['train_id'];
    $sql = "SELECT * FROM trains WHERE train_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $train_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $train = $result->fetch_assoc();
} else {
    header("Location: rose.php");
    exit();
}

// Update the food items array with descriptions and image paths
$food_items = [
    [
        'id' => 1, 
        'name' => 'Veg Thali', 
        'description' => 'Complete Indian meal with dal, curry, naan bread, rice, and fresh salad',
        'price' => 120, 
        'type' => 'veg',
        'image' => 'veg thali.webp'
    ],
    [
        'id' => 2, 
        'name' => 'Non-Veg Thali', 
        'description' => 'Delicious non-vegetarian thali with chicken curry, dal, rice, and naan',
        'price' => 150, 
        'type' => 'non-veg',
        'image' => 'non veg thali.webp'
    ],
    [
        'id' => 3, 
        'name' => 'Sandwich', 
        'description' => 'Fresh vegetable sandwich with cheese and special sauce',
        'price' => 60, 
        'type' => 'veg',
        'image' => 'sandwich.webp'
    ],
    [
        'id' => 4, 
        'name' => 'Biryani', 
        'description' => 'Aromatic rice dish with spices and tender meat',
        'price' => 130, 
        'type' => 'non-veg',
        'image' => 'Biriyani.webp'
    ],
    [
        'id' => 5, 
        'name' => 'Fruit Plate', 
        'description' => 'Assorted fresh seasonal fruits',
        'price' => 80, 
        'type' => 'veg',
        'image' => 'Fruit Plate.webp'
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Ticket - TrainDekho</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        /* Add your existing header and common styles here */
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f7fa;
            color: #333;
        }
        .header {
    background: linear-gradient(135deg, #003366 0%, #004080 100%);
    color: white;
    padding: 15px 30px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.header-content {
    max-width: 1200px;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.logo-section {
    display: flex;
    align-items: center;
    gap: 15px;
}

.logo {
    width: 50px;
    height: 50px;
    object-fit: contain;
}

.brand-name {
    font-size: 24px;
    font-weight: 600;
    color: white;
}

.header-right {
    color: white;
    font-size: 16px;
}

.input-hint {
    color: #666;
    font-size: 12px;
    margin-top: 4px;
    display: block;
}
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .booking-section {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 30px;
        }

        .section-title {
            color: #003366;
            font-size: 24px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eef2f7;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #666;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }

        .passenger-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .food-menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .food-item {
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .food-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
            border-radius: 6px;
        }

        .food-type {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
        }

        .veg {
            background: #e8f5e9;
            color: #2e7d32;
        }

        .non-veg {
            background: #ffebee;
            color: #c62828;
        }

        .food-price {
            font-weight: 600;
            color: #003366;
        }

        .quantity-input {
            width: 60px;
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .fare-summary {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            margin-top: 30px;
        }

        .fare-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .total-fare {
            font-size: 20px;
            font-weight: 600;
            color: #003366;
        }

        .submit-btn {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 25px;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(76,175,80,0.3);
        }

        .food-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 12px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .food-image:hover {
            transform: scale(1.05);
        }

        .food-description {
            color: #666;
            font-size: 14px;
            margin: 8px 0;
            line-height: 1.4;
        }

        .food-item {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .food-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }

        .food-section {
            background: linear-gradient(to bottom, #ffffff 0%, #f8f9fa 100%);
        }

        .food-categories {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 30px;
        }

        .category-btn {
            padding: 10px 20px;
            border: none;
            border-radius: 25px;
            background: #f0f2f5;
            color: #666;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .category-btn.active {
            background: #003366;
            color: white;
            box-shadow: 0 4px 8px rgba(0,51,102,0.2);
        }

        .food-menu {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            padding: 10px;
        }

        .food-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .food-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .food-image-wrapper {
            position: relative;
            height: 200px;
            overflow: hidden;
        }

        .food-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .food-card:hover .food-image {
            transform: scale(1.1);
        }

        .food-badge {
            position: absolute;
            top: 15px;
            right: 15px;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .food-badge.veg {
            background: rgba(255, 255, 255, 0.9);
            color: #2e7d32;
        }

        .food-badge .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #2e7d32;
        }

        .food-details {
            padding: 20px;
        }

        .food-details h3 {
            margin: 0 0 10px;
            color: #003366;
            font-size: 18px;
        }

        .food-description {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .food-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 15px;
        }

        .food-price {
            font-size: 20px;
            font-weight: 600;
            color: #003366;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #f8f9fa;
            padding: 5px;
            border-radius: 25px;
        }

        .qty-btn {
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 50%;
            background: white;
            color: #003366;
            font-size: 18px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .qty-btn:hover {
            background: #003366;
            color: white;
        }

        .quantity-input {
            width: 40px;
            text-align: center;
            border: none;
            background: transparent;
            font-size: 16px;
            font-weight: 500;
            color: #003366;
        }

        .quantity-input::-webkit-inner-spin-button,
        .quantity-input::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        @media (max-width: 768px) {
            .food-categories {
                flex-wrap: wrap;
            }
            
            .food-menu {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Add your header here -->
    <div class="header">
    <div class="header-content">
        <div class="logo-section">
            <img src="images/TRAIN MANIA YOU TUBE CHANNEL LOGO.png" alt="TrainDekho Logo" class="logo">
            <span class="brand-name">TrainDekho</span>
        </div>
        <div class="header-right">
            <div class="date"><?php echo date('l, d M Y'); ?></div>
        </div>
    </div>
</div>
    <div class="container">
        <form action="payment.php" method="POST" id="bookingForm">
            <input type="hidden" name="train_id" value="<?php echo $train_id; ?>">
            <input type="hidden" name="total_amount" id="totalAmountInput" value="0">
            
            <div class="booking-section">
                <h2 class="section-title">Train Details</h2>
                <div class="train-info">
                    <h3><?php echo htmlspecialchars($train['train_name']); ?> (<?php echo htmlspecialchars($train['train_number']); ?>)</h3>
                    <p><?php echo htmlspecialchars($train['source_station']); ?> → <?php echo htmlspecialchars($train['destination_station']); ?></p>
                    <p>Departure: <?php echo date('h:i A', strtotime($train['departure_time'])); ?></p>
                </div>
            </div>

            <div class="booking-section">
    <h2 class="section-title">Passenger Details</h2>
    <div class="form-grid">
        <div class="form-group">
            <label>Name</label>
            <input type="text" name="passenger_name" required placeholder="Enter full name">
        </div>
        <div class="form-group">
            <label>Age</label>
            <input type="number" name="age" required min="1" max="120" placeholder="Enter age">
        </div>
        <div class="form-group">
            <label>Gender</label>
            <select name="gender" required>
                <option value="">Select Gender</option>
                <option value="M">Male</option>
                <option value="F">Female</option>
                <option value="O">Other</option>
            </select>
        </div>
        <div class="form-group">
            <label>Aadhaar Number</label>
            <input type="text" name="aadhaar" required 
                   pattern="[0-9]{12}" 
                   maxlength="12" 
                   placeholder="Enter 12-digit Aadhaar number"
                   oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                   onkeyup="formatAadhaar(this)">
            <small class="input-hint">Format: XXXX XXXX XXXX</small>
        </div>
        <div class="form-group">
            <label>Class</label>
            <select name="class" required onchange="updateFare()">
                <option value="">Select Class</option>
                <option value="AC">AC (₹<?php echo htmlspecialchars($train['ac_fare']); ?>)</option>
                <option value="SL">Sleeper (₹<?php echo htmlspecialchars($train['sleeper_fare']); ?>)</option>
            </select>
        </div>
    </div>
</div>
            <div class="booking-section food-section">
                <h2 class="section-title">Food Order (Optional)</h2>
                <div class="food-categories">
                    <button class="category-btn active" data-category="all">All Items</button>
                    <button class="category-btn" data-category="veg">Vegetarian</button>
                    <button class="category-btn" data-category="non-veg">Non-Vegetarian</button>
                </div>

                <div class="food-menu">
                    <?php foreach($food_items as $item): ?>
                    <div class="food-item" data-category="<?php echo $item['type']; ?>">
                        <div class="food-card">
                            <div class="food-image-wrapper">
                                <img src="images/food/<?php echo $item['image']; ?>" 
                                     alt="<?php echo htmlspecialchars($item['name']); ?>">
                                <?php if($item['type'] == 'veg'): ?>
                                <div class="food-badge veg">
                                    <span class="dot"></span> Pure Veg
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="food-details">
                                <h3><?php echo htmlspecialchars($item['name']); ?></h3>
                                <p class="food-description">
                                    <?php echo htmlspecialchars($item['description']); ?>
                                </p>
                                <div class="food-meta">
                                    <span class="food-price">₹<?php echo htmlspecialchars($item['price']); ?></span>
                                    <div class="quantity-control">
                                        <button type="button" class="qty-btn minus" onclick="updateQuantity(this, -1)">−</button>
                                        <input type="number" name="food[<?php echo $item['id']; ?>]" 
                                               class="quantity-input" value="0" min="0" max="5"
                                               onchange="updateTotal()">
                                        <button type="button" class="qty-btn plus" onclick="updateQuantity(this, 1)">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="booking-section">
                <h2 class="section-title">Fare Summary</h2>
                <div class="fare-summary">
                    <div class="fare-row">
                        <span>Base Fare</span>
                        <span id="baseFare">₹0</span>
                    </div>
                    <div class="fare-row">
                        <span>Food Charges</span>
                        <span id="foodCharges">₹0</span>
                    </div>
                    <div class="fare-row">
                        <span>Service Charge</span>
                        <span>₹20</span>
                    </div>
                    <div class="fare-row total-fare">
                        <span>Total Amount</span>
                        <span id="totalFare">₹20</span>
                    </div>
                </div>

                <button type="submit" class="submit-btn">Proceed to Payment</button>
            </div>
        </form>
    </div>

    <script>
        function updateFare() {
            const classSelect = document.querySelector('select[name="class"]');
            const baseFare = classSelect.value === 'AC' ? 
                <?php echo $train['ac_fare']; ?> : 
                (classSelect.value === 'SL' ? <?php echo $train['sleeper_fare']; ?> : 0);
            
            document.getElementById('baseFare').textContent = '₹' + baseFare;
            updateTotal();
        }

        function updateTotal() {
            const baseFare = parseInt(document.getElementById('baseFare').textContent.replace('₹', '')) || 0;
            let foodTotal = 0;
            
            const foodPrices = <?php echo json_encode(array_column($food_items, 'price', 'id')); ?>;
            const quantities = document.querySelectorAll('.quantity-input');
            
            quantities.forEach(input => {
                const foodId = input.name.match(/\d+/)[0];
                foodTotal += (parseInt(input.value) || 0) * foodPrices[foodId];
            });

            document.getElementById('foodCharges').textContent = '₹' + foodTotal;
            const totalAmount = baseFare + foodTotal + 20;
            document.getElementById('totalFare').textContent = '₹' + totalAmount;
            document.getElementById('totalAmountInput').value = totalAmount;
        }

        function updateQuantity(btn, change) {
            const input = btn.parentElement.querySelector('.quantity-input');
            let value = parseInt(input.value) + change;
            value = Math.max(0, Math.min(5, value)); // Limit between 0 and 5
            input.value = value;
            updateTotal();
        }

        document.querySelectorAll('.category-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                // Remove active class from all buttons
                document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                // Add active class to clicked button
                btn.classList.add('active');
                
                const category = btn.dataset.category;
                document.querySelectorAll('.food-item').forEach(item => {
                    if (category === 'all' || item.dataset.category === category) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    </script>
</body>
</html>

<?php
$conn->close();
?> 