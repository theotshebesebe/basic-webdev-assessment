<?php
try {
    require_once("todo.controller.php");
    require_once("todo.class.php");
   
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $path = explode( '/', $uri);
    $requestType = $_SERVER['REQUEST_METHOD'];
    $body = file_get_contents('php://input');
    $pathCount = count($path);

    $controller = new TodoController();
   
    switch($requestType) {
        case 'GET':
            if ($path[$pathCount - 2] == 'todo' && isset($path[$pathCount - 1]) && strlen($path[$pathCount - 1])) {
                $id = $path[$pathCount - 1];
                $todo = $controller->load($id);
                if ($todo) {
                    http_response_code(200);
                    die(json_encode($todo));
                }
                http_response_code(404);
                die();
            } else {
                http_response_code(200);
                die(json_encode($controller->loadAll()));
            }
            break;

       case 'POST':
    $data = json_decode($body);
    if ($data) {
        $newTodo = new Todo($data->id, $data->title, $data->description, $data->done);
        $success = $controller->create($newTodo);
        if ($success) {
            http_response_code(201);
            die();
        }
    }
    http_response_code(400);
    die();
    break;
       
case 'PUT':
    if ($path[$pathCount - 2] == 'todo' && isset($path[$pathCount - 1]) && strlen($path[$pathCount - 1])) {
        $id = $path[$pathCount - 1];
        $data = json_decode($body);
        if ($data) {
            $existingTodo = $controller->load($id);
            if ($existingTodo) {
                $existingTodo->title = $data->title;
                $existingTodo->description = $data->description;
                $existingTodo->done = $data->done;
                $success = $controller->update($id, $existingTodo);
                if ($success) {
                    http_response_code(200);
                    die();
                }
            }
        }
    }
    http_response_code(400);
    die();
    break;

       case 'DELETE':
    if ($path[$pathCount - 2] == 'todo' && isset($path[$pathCount - 1]) && strlen($path[$pathCount - 1])) {
        $id = $path[$pathCount - 1];
        $existingTodo = $controller->load($id);
        if ($existingTodo) {
            $success = $controller->delete($id);
            if ($success) {
                http_response_code(204);
                die();
            }
        }
    }
    http_response_code(400);
    die();
    break;
        default:
            http_response_code(501);
            die();
            break;
    }
} catch(Throwable $e) {
    error_log($e->getMessage());
    http_response_code(500);
    die();
}
