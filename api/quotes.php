<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

include_once '../config/database.php';
include_once '../models/Quote.php';

$database = new Database();
$db = $database->getConnection();
$quote = new Quote($db);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $quote->id = $_GET['id'];
            $stmt = $quote->read_single();
        } elseif (isset($_GET['author_id']) && isset($_GET['category_id'])) {
            $quote->author_id = $_GET['author_id'];
            $quote->category_id = $_GET['category_id'];
            $stmt = $quote->read_by_author_and_category();
        } elseif (isset($_GET['author_id'])) {
            $quote->author_id = $_GET['author_id'];
            $stmt = $quote->read_by_author();
        } elseif (isset($_GET['category_id'])) {
            $quote->category_id = $_GET['category_id'];
            $stmt = $quote->read_by_category();
        } elseif (isset($_GET['random']) && $_GET['random'] === "true") {
            $stmt = $quote->read_random();
        } else {
            $stmt = $quote->read();
        }
        $num = $stmt->rowCount();

        if ($num > 0) {
            $quotes_arr = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($quotes_arr, $row);
            }
            echo json_encode($quotes_arr);
        } else {
            echo json_encode(["message" => "No Quotes Found"]);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->quote) && !empty($data->author_id) && !empty($data->category_id)) {
            $quote->quote = $data->quote;
            $quote->author_id = $data->author_id;
            $quote->category_id = $data->category_id;
            if ($quote->create()) {
                echo json_encode(["message" => "Quote created successfully"]);
            } else {
                echo json_encode(["message" => "Failed to create quote"]);
            }
        } else {
            echo json_encode(["message" => "Missing Required Parameters"]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->id) && !empty($data->quote) && !empty($data->author_id) && !empty($data->category_id)) {
            $quote->id = $data->id;
            $quote->quote = $data->quote;
            $quote->author_id = $data->author_id;
            $quote->category_id = $data->category_id;
            if ($quote->update()) {
                echo json_encode(["message" => "Quote updated successfully"]);
            } else {
                echo json_encode(["message" => "Failed to update quote"]);
            }
        } else {
            echo json_encode(["message" => "Missing Required Parameters"]);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->id)) {
            $quote->id = $data->id;
            if ($quote->delete()) {
                echo json_encode(["message" => "Quote deleted successfully"]);
            } else {
                echo json_encode(["message" => "No Quotes Found"]);
            }
        } else {
            echo json_encode(["message" => "Missing Required Parameters"]);
        }
        break;

    default:
        echo json_encode(["message" => "Invalid Request Method"]);
        break;
}
?>
