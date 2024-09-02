<?php
include('includes/config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_id = $_POST['room_id'];

    // Fetch room capacity
    $sql = "SELECT capacity FROM rooms WHERE id = :room_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':room_id', $room_id, PDO::PARAM_INT);
    $query->execute();
    $room = $query->fetch(PDO::FETCH_OBJ);
    $capacity = $room->capacity;

    // Fetch all students
    $sql = "SELECT id FROM students";
    $query = $dbh->prepare($sql);
    $query->execute();
    $students = $query->fetchAll(PDO::FETCH_OBJ);

    $seat_number = 1;

    // Clear existing seating arrangement for the room
    $sql = "DELETE FROM seating WHERE room_id = :room_id";
    $query = $dbh->prepare($sql);
    $query->bindParam(':room_id', $room_id, PDO::PARAM_INT);
    $query->execute();

    // Assign seats to students
    foreach ($students as $student) {
        if ($seat_number > $capacity) {
            break;
        }

        $sql = "INSERT INTO seating (student_id, room_id, seat_number) VALUES (:student_id, :room_id, :seat_number)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':student_id', $student->id, PDO::PARAM_INT);
        $query->bindParam(':room_id', $room_id, PDO::PARAM_INT);
        $query->bindParam(':seat_number', $seat_number, PDO::PARAM_INT);
        $query->execute();

        $seat_number++;
    }

    echo "<script>alert('Seats have been assigned successfully');</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Arrange Seats</title>
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

        select {
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
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        button:hover {
            background-color: #218838;
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
    <h2>Arrange Exam Seats</h2>
    <form action="arrange_seats.php" method="post">
        <label for="room_id">Select Room:</label>
        <select name="room_id" required>
            <option value="">Select Room</option>
            <?php
            // Fetch rooms
            $sql = "SELECT * FROM rooms";
            $query = $dbh->prepare($sql);
            $query->execute();
            $rooms = $query->fetchAll(PDO::FETCH_OBJ);

            foreach ($rooms as $room) {
                echo "<option value='" . htmlentities($room->id) . "'>" . htmlentities($room->room_name) . " (Capacity: " . htmlentities($room->capacity) . ")</option>";
            }
            ?>
        </select>

        <button type="submit">Assign Seats</button>
    </form>
</body>
</html>
