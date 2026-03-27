<?php
include "database.php";
$obj = new database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $age = $sub = "";
    if (isset($_POST['add'])) {
        //    print_r($_POST);
        //     exit();

        $name = $_POST['name'];
        $age = $_POST['age'];
        $sub = $_POST['sub'];

        if (empty($name)) $response['errors']['name'] = "Name is required.";
        if (empty($age))  $response['errors']['age'] = "Age is required.";
        if (empty($sub))  $response['errors']['sub'] = "Subject is required.";

        if (!empty($response['errors'])) {
            $response['status'] = 'error';
        } else {
            $obj->insert('student', ['name' => "$name", 'age' => "$age", 'sub' => "$sub"]);
            $addid = $obj->addNo;
            $responseData = [
                'data' => [
                    'status'=>'add',
                    'id' => $addid,
                    'name' => $name,
                    'age' => $age,
                    'sub' => $sub,
                ]
            ];


            echo json_encode($responseData);

            exit();
        }
    }

    if (isset($_POST['delete_id'])) {
        $id = $_POST['delete_id'];
        $obj->delete('student', "id='$id'");
        $response['raw'] = $obj->deleteNo;
        echo json_encode($response);
        exit();
    }

    if (isset($_POST['update'])) {
        $name = $age = $sub = "";
        //    print_r($_POST);
        //     exit();

        $name = $_POST['name'];
        $age = $_POST['age'];
        $sub = $_POST['sub'];
        $id = $_POST['id'];

        if (empty($name)) $response['errors']['name'] = "Name is required.";
        if (empty($age))  $response['errors']['age'] = "Age is required.";
        if (empty($sub))  $response['errors']['sub'] = "Subject is required.";

        if (!empty($response['errors'])) {
            $response['status'] = 'error';
        } else {
            $obj->update('student',['name' => "$name", 'age' => "$age", 'sub' => "$sub"],"id=$id");
            $responseData = [
                'data' => [
                    'status'=>'updated',
                    'id' => $id,
                    'name' => $name,
                    'age' => $age,
                    'sub' => $sub,
                ]
            ];


            echo json_encode($responseData);

            exit();
        }




    }
}
