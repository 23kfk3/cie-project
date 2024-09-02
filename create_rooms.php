<?php
include('includes/config.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $room_name = $_POST['room_name'];
    $capacity = $_POST['capacity'];

    $sql = "INSERT INTO rooms (room_name, capacity) VALUES (:room_name, :capacity)";
    $query = $dbh->prepare($sql);
    $query->bindParam(':room_name', $room_name, PDO::PARAM_STR);
    $query->bindParam(':capacity', $capacity, PDO::PARAM_INT);
    $query->execute();

    echo "Room added successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Rooms</title>
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

        input[type="text"],
        input[type="number"] {
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
    <h2>Create Room</h2>
    <form action="create_rooms.php" method="post">
        <label for="room_name">Room Name:</label>
        <input type="text" name="room_name" required>

        <label for="capacity">Capacity:</label>
        <input type="number" name="capacity" required>

        <button type="submit">Add Room</button>
    </form>
</body>
</html>
