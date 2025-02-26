<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login1.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Ticket - TrainDekho</title>
    <style>
        /* Copy your common styles from rose.php */
        
        .cancellation-container {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 30px;
            max-width: 600px;
            margin: 40px auto;
        }

        .cancellation-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-weight: bold;
            color: #003366;
        }

        .form-group input {
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 16px;
        }

        .form-group input:focus {
            border-color: #1a237e;
            outline: none;
        }

        .cancel-button {
            background-color: #dc3545;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .cancel-button:hover {
            background-color: #c82333;
        }

        .warning-text {
            color: #dc3545;
            font-size: 14px;
            margin-top: 20px;
            text-align: center;
        }

        .refund-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <!-- Copy your header from rose.php -->
    <header>
        <!-- Copy your existing header code here -->
    </header>

    <div class="booking-section">
        <div class="cancellation-container">
            <h1 style="color: #1a237e; text-align: center; margin-bottom: 30px;">Ticket Cancellation</h1>
            
            <form class="cancellation-form" onsubmit="return confirmCancellation(event)">
                <div class="form-group">
                    <label for="pnr">PNR Number</label>
                    <input type="text" id="pnr" name="pnr" required 
                           pattern="[0-9]{10}" 
                           title="Please enter a valid 10-digit PNR number">
                </div>

                <div class="form-group">
                    <label for="email">Email ID</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="refund-info">
                    <p><strong>Refund Policy:</strong></p>
                    <ul>
                        <li>Cancellation before 48 hours: 100% refund</li>
                        <li>Cancellation within 24-48 hours: 50% refund</li>
                        <li>Cancellation within 24 hours: 25% refund</li>
                    </ul>
                </div>

                <p class="warning-text">
                    Please note: Once cancelled, this action cannot be undone.
                </p>

                <button type="submit" class="cancel-button">
                    Cancel Ticket
                </button>
            </form>
        </div>
    </div>

    <!-- Copy your footer from rose.php -->
    <footer>
        <!-- Copy your existing footer code here -->
    </footer>

    <script>
        function confirmCancellation(event) {
            event.preventDefault();
            
            const pnr = document.getElementById('pnr').value;
            const email = document.getElementById('email').value;

            // Validate PNR format
            if (!/^[0-9]{10}$/.test(pnr)) {
                alert('Please enter a valid 10-digit PNR number');
                return false;
            }

            // Validate email format
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                alert('Please enter a valid email address');
                return false;
            }

            // Show confirmation dialog
            const confirmed = confirm(
                'Are you sure you want to cancel this ticket?\n\n' +
                'PNR: ' + pnr + '\n' +
                'Email: ' + email + '\n\n' +
                'This action cannot be undone.'
            );

            if (confirmed) {
                // Here you would typically submit the form to your backend
                alert('Ticket cancellation request submitted successfully. You will receive confirmation on your email.');
                // You can redirect to a confirmation page or handle the submission as needed
            }

            return false;
        }
    </script>
</body>
</html> 