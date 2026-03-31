<?php
include "database.php";
$obj = new database();


// check empty error of post values
function errorCheck($data)
{
    $errors = [];
    if (empty($data['name'])) $errors['name'] = "Name is required.";
    if (empty($data['age']))  $errors['age'] = "Age is required.";
    if (empty($data['sub']))  $errors['sub'] = "Subject is required.";

    return $errors;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $response = [];

// create data action code

    if (isset($_POST['add'])) {
        $name = $_POST['name'] ?? '';
        $age = $_POST['age'] ?? '';
        $sub = $_POST['sub'] ?? '';

        $response['errors'] = errorCheck($_POST);


        if (!empty($response['errors'])) {
            $response['status'] = 'error';
            echo json_encode($response);
            exit();
        } else {
            if ($obj->insert('student', ['name' => $name, 'age' => $age, 'sub' => $sub])) {
                $addid = $obj->addNo;
                $response = [
                    'data' => [
                        'status' => 'add',
                        'message'=> 'Data added successfully.',
                        'id' => $addid,
                        'name' => $name,
                        'age' => $age,
                        'sub' => $sub,
                    ]
                ];
                echo json_encode($response);
            } else {
                $response['status'] = 'error';
                $response['errors']['database'] = $obj->getError();
                echo json_encode($response);
            }
            exit();
        }
    }


    // delete data action code

    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        if ($obj->delete('student', "id='$id'")) {
            $response['status'] = 'success';
            $response['message']='Data Deleted successfully.';
            $response['raw'] = $obj->deleteNo;
        } else {
            $response['status'] = 'error';
            $response['errors']['database'] = $obj->getError();
        }
        echo json_encode($response);
        exit();
    }

    // update data action code


    if (isset($_POST['update'])) {
        $name = $_POST['name'] ?? '';
        $age = $_POST['age'] ?? '';
        $sub = $_POST['sub'] ?? '';
        $id = $_POST['id'] ?? '';

        $response['errors'] = errorCheck($_POST);


        if (!empty($response['errors'])) {
            $response['status'] = 'error';
            echo json_encode($response);
            exit();
        } else {
            if ($obj->update('student', ['name' => $name, 'age' => $age, 'sub' => $sub], "id='$id'")) {
                $responseData = [
                    'data' => [
                        'status' => 'updated',
                        'message'=>'Data updated successfully.',
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

    // fetch data action code
    

    if (isset($_POST['action']) && $_POST['action'] == 'getData') {


        $obj->select('student', '*', null, null, null, null);
        $result = $obj->getResult();
        
        echo json_encode($result);
        exit();
    }
}
