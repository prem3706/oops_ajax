<?php
include "header.php";
include "database.php";

$obj = new database();
$obj->select('student', '*', null, null, null, null);
$result = $obj->getResult();

?>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary add" data-bs-toggle="myModal" data-bs-target="#staticBackdrop">
  ADD DATA
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Student Data</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

      </div>
    </div>
  </div>
</div>
<div class="card-body">
  <table class="table table-responsive" id="DashexpenseList">
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
              <a class="btn btn-primary mx-2 update_data" data-id="<?php echo $row['id']; ?>">Update</a>
              <a class="btn btn-danger mx-2 delete_data" data-id="<?php echo $row['id']; ?>">Delete</a>
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
<?php include "footer.php" ?>