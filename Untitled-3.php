<!-- dashboard.php -->
<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: login.php');
    exit();
}

// Include your connection script
include 'connection.php';

// Fetch user details from the database
$userId = $_SESSION['user_id'];
$userDetailsQuery = "SELECT username, email FROM users WHERE user_id = $userId";
$userDetailsResult = $connect->query($userDetailsQuery);

if ($userDetailsResult && $userDetailsResult->num_rows > 0) {
    $userDetails = $userDetailsResult->fetch_assoc();
    $username = $userDetails['username'];
    $email = $userDetails['email'];
} else {
    echo 'Error fetching user details: ' . $connect->error;
    exit();
}

// Fetch booked packages for the user
$bookingsQuery = "SELECT package_name, destination, duration, price FROM bookings WHERE user_id = $userId";
$bookingsResult = $connect->query($bookingsQuery);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <style>
        body {
            font-family: "Arial, sans-serif";
            background-color: #f5f5f5;
            margin: 0;
            padding: 20px;
        }

        .dashboard {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            margin-top: 20px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .welcome-container {
            background-color: #3498db;
            color: #fff;
            border-radius: 5px;
            padding: 15px;
            text-align: center;
        }

        h2 {
            margin-top: 0;
        }

        .user-info {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .booked-packages {
            margin-top: 20px;
        }

        .booked-package {
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 15px;
            padding: 15px;
        }

        .booked-package p {
            margin: 8px 0;
        }
    </style>
</head>

<body>
    <div class="dashboard">
        <div class="welcome-container">
            <h2>Welcome, <?php echo $username; ?>!</h2>
            <p>Your travel journey begins here.</p>
                <p><strong>Email:</strong> <?php echo $email; ?></p>
        </div>

        <div class="user-info">
            <div>
                <h2>Your Booked Packages</h2>
                <?php if ($bookingsResult && $bookingsResult->num_rows > 0) : ?>
                    <?php while ($booking = $bookingsResult->fetch_assoc()) : ?>
                        <div class="booked-package">
                            <p><strong>Package Name:</strong> <?php echo $booking['package_name']; ?></p>
                            <p><strong>Destination:</strong> <?php echo $booking['destination']; ?></p>
                            <p><strong>Duration:</strong> <?php echo $booking['duration']; ?></p>
                            <p><strong>Price:</strong> <?php echo $booking['price']; ?></p>
                        </div>
                    <?php endwhile; ?>
                <?php else : ?>
                    <p>No bookings found. Start your adventure now!</p>
                <?php endif; ?>
            </div>
            
        </div>
    </div>
</body>

</html>
