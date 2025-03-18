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
include_once '../models/Author.php';

$database = new Database();
$db = $database->getConnection();
$author = new Author($db);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $author->id = $_GET['id'];
            $stmt = $author->read_single();
        } else {
            $stmt = $author->read();
        }
        $num = $stmt->rowCount();

        if ($num > 0) {
            $authors_arr = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($authors_arr, $row);
            }
            echo json_encode($authors_arr);
        } else {
            echo json_encode(["message" => "No Authors Found"]);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->author)) {
            $author->author = $data->author;
            if ($author->create()) {
                echo json_encode(["message" => "Author created successfully"]);
            } else {
                echo json_encode(["message" => "Failed to create author"]);
            }
        } else {
            echo json_encode(["message" => "Missing Required Parameters"]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->id) && !empty($data->author)) {
            $author->id = $data->id;
            $author->author = $data->author;
            if ($author->update()) {
                echo json_encode(["message" => "Author updated successfully"]);
            } else {
                echo json_encode(["message" => "Failed to update author"]);
            }
        } else {
            echo json_encode(["message" => "Missing Required Parameters"]);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->id)) {
            $author->id = $data->id;
            if ($author->delete()) {
                echo json_encode(["message" => "Author deleted successfully"]);
            } else {
                echo json_encode(["message" => "No Authors Found"]);
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
