<?php 
include "header.php";
include "database.php";
$id = $_GET['id'];

$obj = new database();
$obj->select('student', '*', null, "id = $id", null, null);
$result = $obj->getResult();



?>
<form id="stuForm">
    <input type="hidden" name="update">
     <input type="hidden" name="id"
        value="<?php echo $id ?>">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" id="name" value="<?php echo $result[0]['name']?>" placeholder="Enter Your Name">
        <span id="nameError" class="text-danger small"></span>
    </div>

    <div class="mb-3">
        <label for="age" class="form-label">Age</label>
        <input type="number" name="age" class="form-control" id="age" value="<?php echo $result[0]['age']?>" placeholder="Enter Your Age">
        <span id="ageError" class="text-danger small"></span>
    </div>

    <div class="mb-3">
        <label for="sub" class="form-label">Subject</label>
        <input type="text" name="sub" class="form-control" id="sub" value="<?php echo $result[0]['sub']?>" placeholder="Enter Your Subject">
        <span id="subError" class="text-danger small"></span>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary"   id="addBtn">Submit</button>
    </div>
</form>
