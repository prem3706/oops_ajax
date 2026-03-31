<?php
include "header.php";
include "database.php";

?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4>Student Directory</h4>
        <button type="button" class="btn btn-primary add">ADD DATA</button>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered" id="DashexpenseList">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Age</th>
                    <th scope="col">Subject</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody id="taskData">
                
            </tbody>
        </table>
    </div>
</div>

<div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Student Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

            </div>
        </div>
    </div>
</div>
<?php include "footer.php" ?>