<?php
include "database.php";
$obj = new database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = [];

    if (isset($_POST['add'])) {
        $name = $_POST['name'] ?? '';
        $age = $_POST['age'] ?? '';
        $sub = $_POST['sub'] ?? '';

        if (empty($name)) $response['errors']['name'] = "Name is required.";
        if (empty($age))  $response['errors']['age'] = "Age is required.";
        if (empty($sub))  $response['errors']['sub'] = "Subject is required.";

        if (!empty($response['errors'])) {
            $response['status'] = 'error';
            echo json_encode($response);
            exit();
        } else {
            if ($obj->insert('student', ['name' => $name, 'age' => $age, 'sub' => $sub])) {
                $addid = $obj->addNo;
                $responseData = [
                    'data' => [
                        'status' => 'add',
                        'id' => $addid,
                        'name' => $name,
                        'age' => $age,
                        'sub' => $sub,
                    ]
                ];
                echo json_encode($responseData);
            } else {
                $response['status'] = 'error';
                $response['errors']['database'] = $obj->getError();
                echo json_encode($response);
            }
            exit();
        }
    }

    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        if ($obj->delete('student', "id='$id'")) {
            $response['status'] = 'success';
            $response['raw'] = $obj->deleteNo;
        } else {
            $response['status'] = 'error';
            $response['errors']['database'] = $obj->getError();
        }
        echo json_encode($response);
        exit();
    }

    if (isset($_POST['update'])) {
        $name = $_POST['name'] ?? '';
        $age = $_POST['age'] ?? '';
        $sub = $_POST['sub'] ?? '';
        $id = $_POST['id'] ?? '';

        if (empty($name)) $response['errors']['name'] = "Name is required.";
        if (empty($age))  $response['errors']['age'] = "Age is required.";
        if (empty($sub))  $response['errors']['sub'] = "Subject is required.";

        if (!empty($response['errors'])) {
            $response['status'] = 'error';
            echo json_encode($response);
            exit();
        } else {
            if ($obj->update('student', ['name' => $name, 'age' => $age, 'sub' => $sub], "id='$id'")) {
                $responseData = [
                    'data' => [
                        'status' => 'updated',
                        'id' => $id,
                        'name' => $name,
                        'age' => $age,
                        'sub' => $sub,
                    ]
                ];
                echo json_encode($responseData);
            } else {
                $response['status'] = 'error';
                $response['errors']['database'] = $obj->getError();
                echo json_encode($response);
            }
            exit();
        }
    }
}
