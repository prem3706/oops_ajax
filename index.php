<?php
include "header.php";
include "database.php";

$obj = new database();
$obj->select('student', '*', null, null, null, null);
$result = $obj->getResult();
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
                <?php
                if (!empty($result)) {
                    foreach ($result as $row) { ?>
                        <tr id="row_<?php echo $row['id']; ?>">
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['age']; ?></td>
                            <td><?php echo $row['sub']; ?></td>
                            <td>
                                <a href="#" class="btn btn-primary btn-sm update_data" data-id="<?php echo $row['id']; ?>">Edit</a>
                                <a href="#" class="btn btn-danger btn-sm delete_data" data-id="<?php echo $row['id']; ?>">Delete</a>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="5" class="text-center">No Record Found</td>
                    </tr>
                <?php } ?>
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