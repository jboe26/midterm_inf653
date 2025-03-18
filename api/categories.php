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
include_once '../models/Category.php';

$database = new Database();
$db = $database->getConnection();
$category = new Category($db);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $category->id = $_GET['id'];
            $stmt = $category->read_single();
        } else {
            $stmt = $category->read();
        }
        $num = $stmt->rowCount();

        if ($num > 0) {
            $categories_arr = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                array_push($categories_arr, $row);
            }
            echo json_encode($categories_arr);
        } else {
            echo json_encode(["message" => "No Categories Found"]);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->category)) {
            $category->category = $data->category;
            if ($category->create()) {
                echo json_encode(["message" => "Category created successfully"]);
            } else {
                echo json_encode(["message" => "Failed to create category"]);
            }
        } else {
            echo json_encode(["message" => "Missing Required Parameters"]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->id) && !empty($data->category)) {
            $category->id = $data->id;
            $category->category = $data->category;
            if ($category->update()) {
                echo json_encode(["message" => "Category updated successfully"]);
            } else {
                echo json_encode(["message" => "Failed to update category"]);
            }
        } else {
            echo json_encode(["message" => "Missing Required Parameters"]);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));
        if (!empty($data->id)) {
            $category->id = $data->id;
            if ($category->delete()) {
                echo json_encode(["message" => "Category deleted successfully"]);
            } else {
                echo json_encode(["message" => "No Categories Found"]);
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
