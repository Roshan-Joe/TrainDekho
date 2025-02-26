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

// Get search parameters
$from = isset($_GET['from']) ? $_GET['from'] : '';
$to = isset($_GET['to']) ? $_GET['to'] : '';

// Search for trains
$sql = "SELECT * FROM trains 
        WHERE source_station = ? 
        AND destination_station = ? 
        AND status = 'active'
        ORDER BY departure_time";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $from, $to);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - TrainDekho</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
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

        .search-summary {
            background: white;
            padding: 20px 30px;
            border-radius: 12px;
            margin: 30px auto;
            max-width: 1200px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .route {
            display: flex;
            align-items: center;
            gap: 20px;
            font-size: 20px;
            color: #2c3e50;
        }

        .route-arrow {
            color: #003366;
            font-size: 24px;
        }

        .results-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .train-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .train-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }

        .train-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eef2f7;
        }

        .train-name {
            font-size: 22px;
            font-weight: 600;
            color: #003366;
        }

        .train-number {
            color: #666;
            font-size: 15px;
            margin-top: 5px;
        }

        .running-days {
            background: #e8f4ff;
            padding: 8px 15px;
            border-radius: 20px;
            color: #003366;
            font-size: 14px;
        }

        .train-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            margin-bottom: 25px;
            padding: 15px 0;
        }

        .detail-group {
            padding: 0 20px;
            border-right: 2px solid #eef2f7;
        }

        .detail-group:last-child {
            border-right: none;
        }

        .detail-label {
            color: #666;
            font-size: 14px;
            margin-bottom: 8px;
        }

        .detail-value {
            font-size: 18px;
            font-weight: 500;
            color: #2c3e50;
        }

        .fare-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .fare-group {
            text-align: center;
            padding: 10px 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .fare-label {
            font-size: 14px;
            color: #666;
            margin-bottom: 5px;
        }

        .fare-value {
            font-size: 22px;
            font-weight: 600;
            color: #003366;
        }

        .book-btn {
            background: linear-gradient(135deg, #4CAF50 0%, #45a049 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .book-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(76,175,80,0.3);
        }

        .no-trains {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        }

        .no-trains h2 {
            color: #003366;
            font-size: 24px;
            margin-bottom: 15px;
        }

        .no-trains p {
            color: #666;
            margin: 10px 0;
            font-size: 16px;
        }

        .back-btn {
            display: inline-block;
            padding: 12px 30px;
            background: #003366;
            color: white;
            text-decoration: none;
            border-radius: 25px;
            margin-top: 25px;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: #004080;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,51,102,0.3);
        }

        @media (max-width: 768px) {
            .header-content {
                flex-direction: column;
                text-align: center;
                gap: 10px;
            }

            .train-header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .train-details {
                grid-template-columns: 1fr;
            }

            .detail-group {
                border-right: none;
                border-bottom: 2px solid #eef2f7;
                padding-bottom: 15px;
            }

            .fare-section {
                flex-direction: column;
                gap: 20px;
            }

            .fare-group {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-content">
            <div class="logo-section">
                <img src="images/TRAIN MANIA YOU TUBE CHANNEL LOGO.png" alt="TrainDekho Logo" class="logo">
                <span class="brand-name">TrainDekho</span>
            </div>
            <div class="search-date">
                <?php echo date('l, d M Y'); ?>
            </div>
        </div>
    </div>

    <div class="search-summary">
        <div class="route">
            <span class="source"><?php echo htmlspecialchars($from); ?></span>
            <span class="route-arrow">→</span>
            <span class="destination"><?php echo htmlspecialchars($to); ?></span>
        </div>
    </div>

    <div class="results-container">
        <?php if ($result->num_rows > 0): ?>
            <?php while($train = $result->fetch_assoc()): ?>
                <div class="train-card">
                    <div class="train-header">
                        <div>
                            <div class="train-name"><?php echo htmlspecialchars($train['train_name']); ?></div>
                            <div class="train-number">Train No: <?php echo htmlspecialchars($train['train_number']); ?></div>
                        </div>
                        <div class="running-days">
                            Runs on: <?php echo htmlspecialchars($train['running_days']); ?>
                        </div>
                    </div>

                    <div class="train-details">
                        <div class="detail-group">
                            <div class="detail-label">Departure</div>
                            <div class="detail-value"><?php echo date('h:i A', strtotime($train['departure_time'])); ?></div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Arrival</div>
                            <div class="detail-value"><?php echo date('h:i A', strtotime($train['arrival_time'])); ?></div>
                        </div>
                        <div class="detail-group">
                            <div class="detail-label">Duration</div>
                            <div class="detail-value"><?php echo htmlspecialchars($train['duration']); ?></div>
                        </div>
                    </div>

                    <div class="fare-section">
                        <div class="fare-group">
                            <div class="fare-label">AC Class</div>
                            <div class="fare-value">₹<?php echo htmlspecialchars($train['ac_fare']); ?></div>
                            <small>Available: <?php echo htmlspecialchars($train['ac_seats']); ?> seats</small>
                        </div>
                        <div class="fare-group">
                            <div class="fare-label">Sleeper Class</div>
                            <div class="fare-value">₹<?php echo htmlspecialchars($train['sleeper_fare']); ?></div>
                            <small>Available: <?php echo htmlspecialchars($train['sleeper_seats']); ?> seats</small>
                        </div>
                        <form action="booking.php" method="GET">
                            <input type="hidden" name="train_id" value="<?php echo $train['train_id']; ?>">
                            <button type="submit" class="book-btn">Book Now</button>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-trains">
                <h2>No Trains Available</h2>
                <p>Sorry, we couldn't find any trains between <?php echo htmlspecialchars($from); ?> and <?php echo htmlspecialchars($to); ?>.</p>
                <p>Try searching for a different route or date.</p>
                <a href="rose.php" class="back-btn">Back to Search</a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>

<?php
$conn->close();
?> 