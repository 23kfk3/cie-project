<?php
include('includes/config.php');

$seat_info = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $roll_id = $_POST['roll_id'];

    // Fetch the seat assignment for the given roll ID
    $sql = "SELECT s.seat_number, r.room_name
            FROM seating s
            JOIN rooms r ON s.room_id = r.id
            JOIN students st ON s.student_id = st.id
            WHERE st.roll_id = :roll_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':roll_id', $roll_id, PDO::PARAM_STR);
    $query->execute();
    $result = $query->fetch(PDO::FETCH_OBJ);

    if ($result) {
        $seat_info = "Your seat number is " . htmlentities($result->seat_number) . " in ROOM " . htmlentities($result->room_name);
    } else {
        $seat_info = "No seat assignment found for Roll ID: " . htmlentities($roll_id);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Check Seat Assignment</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            width: 100%;
            box-sizing: border-box;
            animation: fadeIn 0.8s ease-in-out;
        }

        label {
            font-weight: bold;
            color: #555;
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-bottom: 20px;
            font-size: 16px;
            box-sizing: border-box;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
            background-color: #0056b3;
        }

        .seat-info {
            margin-top: 20px;
            font-size: 18px;
            font-weight: bold;
            color: #333;
            text-align: center;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <h2>Check Your Seat</h2>
    <form action="check_seat.php" method="post">
        <label for="roll_id">Enter Roll ID:</label>
        <input type="text" name="roll_id" required>

        <button type="submit">Check Seat</button>
    </form>

    <?php if (!empty($seat_info)): ?>
        <div class="seat-info">
            <?php echo $seat_info; ?>
        </div>
    <?php endif; ?>
</body>
</html>
