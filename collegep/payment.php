<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: rose.php");
    exit();
}

// Get booking details from POST
$train_id = $_POST['train_id'];
$passenger_name = $_POST['passenger_name'];
$total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - TrainDekho</title>
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
            padding: 1rem;
        }

        .container {
            max-width: 800px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .payment-card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .amount-display {
            text-align: center;
            padding: 20px;
            margin: 20px 0;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .amount {
            font-size: 32px;
            font-weight: 600;
            color: #003366;
        }

        .payment-methods {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .payment-method {
            border: 2px solid #eef2f7;
            border-radius: 8px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .payment-method:hover {
            border-color: #003366;
            transform: translateY(-2px);
        }

        .payment-method.selected {
            border-color: #4CAF50;
            background: #f1f8e9;
        }

        .payment-method img {
            width: 60px;
            height: 60px;
            object-fit: contain;
            margin-bottom: 10px;
        }

        .payment-details {
            margin-top: 30px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #666;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
        }

        .card-row {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 15px;
        }

        .pay-btn {
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

        .pay-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(76,175,80,0.3);
        }

        .secure-badge {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }

        .secure-badge i {
            color: #4CAF50;
            margin-right: 5px;
        }

        @media (max-width: 768px) {
            .card-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 style="text-align: center;">Complete Your Payment</h1>
    </div>

    <div class="container">
        <div class="payment-card">
            <div class="amount-display">
                <p>Total Amount to Pay</p>
                <div class="amount">₹<?php echo number_format($total_amount, 2); ?></div>
            </div>

            <div class="payment-methods">
                <div class="payment-method" onclick="selectPaymentMethod('card')">
                    <img src="images/credit-card.png" alt="Credit Card">
                    <h3>Credit/Debit Card</h3>
                </div>
                <div class="payment-method" onclick="selectPaymentMethod('upi')">
                    <img src="images/upi.png" alt="UPI">
                    <h3>UPI Payment</h3>
                </div>
                <div class="payment-method" onclick="selectPaymentMethod('netbanking')">
                    <img src="images/netbanking.png" alt="Net Banking">
                    <h3>Net Banking</h3>
                </div>
            </div>

            <form id="paymentForm" action="process_payment.php" method="POST">
                <input type="hidden" name="train_id" value="<?php echo htmlspecialchars($train_id); ?>">
                <input type="hidden" name="amount" value="<?php echo htmlspecialchars($total_amount); ?>">
                
                <!-- Card Payment Details -->
                <div id="cardDetails" class="payment-details">
                    <div class="form-group">
                        <label>Card Number</label>
                        <input type="text" id="cardNumber" placeholder="1234 5678 9012 3456" maxlength="19">
                    </div>
                    <div class="card-row">
                        <div class="form-group">
                            <label>Card Holder Name</label>
                            <input type="text" placeholder="Name on card">
                        </div>
                        <div class="form-group">
                            <label>Expiry</label>
                            <input type="text" placeholder="MM/YY" maxlength="5">
                        </div>
                        <div class="form-group">
                            <label>CVV</label>
                            <input type="password" placeholder="***" maxlength="3">
                        </div>
                    </div>
                </div>

                <!-- UPI Payment Details -->
                <div id="upiDetails" class="payment-details" style="display: none;">
                    <div class="form-group">
                        <label>UPI ID</label>
                        <input type="text" placeholder="username@upi">
                    </div>
                </div>

                <!-- Net Banking Details -->
                <div id="netbankingDetails" class="payment-details" style="display: none;">
                    <div class="form-group">
                        <label>Select Bank</label>
                        <select class="form-control">
                            <option value="">Choose your bank</option>
                            <option value="sbi">State Bank of India</option>
                            <option value="hdfc">HDFC Bank</option>
                            <option value="icici">ICICI Bank</option>
                            <option value="axis">Axis Bank</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="pay-btn">Pay Now</button>
            </form>

            <div class="secure-badge">
                <i class="fas fa-lock"></i> Your payment is secure and encrypted
            </div>
        </div>
    </div>

    <script>
        function selectPaymentMethod(method) {
            // Hide all payment details sections
            document.getElementById('cardDetails').style.display = 'none';
            document.getElementById('upiDetails').style.display = 'none';
            document.getElementById('netbankingDetails').style.display = 'none';

            // Show selected payment method details
            document.getElementById(method + 'Details').style.display = 'block';

            // Update selected payment method styling
            document.querySelectorAll('.payment-method').forEach(el => {
                el.classList.remove('selected');
            });
            event.currentTarget.classList.add('selected');
        }

        // Format card number with spaces
        document.getElementById('cardNumber').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
            let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
            e.target.value = formattedValue;
        });
    </script>
</body>
</html> 