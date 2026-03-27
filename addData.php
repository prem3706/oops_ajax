<?php include "header.php"?>
<form id="stuForm">
    <input type="hidden" name="add">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" name="name" class="form-control" id="name" placeholder="Enter Your Name">
        <span id="nameError" class="text-danger small"></span>
    </div>

    <div class="mb-3">
        <label for="age" class="form-label">Age</label>
        <input type="number" name="age" class="form-control" id="age" placeholder="Enter Your Age">
        <span id="ageError" class="text-danger small"></span>
    </div>

    <div class="mb-3">
        <label for="sub" class="form-label">Subject</label>
        <input type="text" name="sub" class="form-control" id="sub" placeholder="Enter Your Subject">
        <span id="subError" class="text-danger small"></span>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary" name="add" id="addBtn">Submit</button>
    </div>
</form>
