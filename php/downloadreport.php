<?php
include 'db_connection.php';
session_start();

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access. Please log in."]);
    exit();
}

$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST["action"];

    if ($action == "add") {
        if (!isset($_POST["date"]) || !isset($_POST["details"])) {
            echo json_encode(["status" => "error", "message" => "Missing parameters."]);
            exit();
        }

        $date = $_POST["date"];
        $details = $_POST["details"];

        $stmt = $conn->prepare("INSERT INTO medical_history (date, details, user_id) VALUES (?, ?, ?)");
        if (!$stmt) {
            echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
            exit();
        }
        $stmt->bind_param("ssi", $date, $details, $user_id);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Record added."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Insert failed: " . $stmt->error]);
        }
    } 

    elseif ($action == "edit") {
        if (!isset($_POST["id"]) || !isset($_POST["details"])) {
            echo json_encode(["status" => "error", "message" => "Missing parameters."]);
            exit();
        }

        $id = $_POST["id"];
        $details = $_POST["details"];

        $stmt = $conn->prepare("UPDATE medical_history SET details = ? WHERE id = ? AND user_id = ?");
        if (!$stmt) {
            echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
            exit();
        }
        $stmt->bind_param("sii", $details, $id, $user_id);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Record updated."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Update failed: " . $stmt->error]);
        }
    } 

    elseif ($action == "delete") {
        if (!isset($_POST["id"])) {
            echo json_encode(["status" => "error", "message" => "Missing parameters."]);
            exit();
        }

        $id = $_POST["id"];

        $stmt = $conn->prepare("DELETE FROM medical_history WHERE id = ? AND user_id = ?");
        if (!$stmt) {
            echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
            exit();
        }
        $stmt->bind_param("ii", $id, $user_id);
        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "Record deleted."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Delete failed: " . $stmt->error]);
        }
    }
} 

elseif ($_SERVER["REQUEST_METHOD"] == "GET") {
    $stmt = $conn->prepare("SELECT id, date, details FROM medical_history WHERE user_id = ?");
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => "Prepare failed: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode($data);
}
?>
