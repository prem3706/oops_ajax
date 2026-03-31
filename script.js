$(document).ready(function () {

    // show data in table and fetch

    function getResult() {
        $.ajax({
            url: 'auth.php',
            method: 'POST',
            data: { action: 'getData' },
            dataType: 'json',
            success: function (response) {
                var html = '';
                if (response.length > 0) {
                    $.each(response, function (index, row) {
                        html += `<tr id="row_${row.id}">
                                    <td>${row.id}</td>
                                    <td>${row.name}</td>
                                    <td>${row.age}</td>
                                    <td>${row.sub}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm update_data" data-id="${row.id}">Edit</a>
                                        <a href="#" class="btn btn-danger btn-sm delete_data" data-id="${row.id}">Delete</a>
                                    </td>
                                </tr>`;
                    });
                } else {
                    html = '<tr><td colspan="5" class="text-center">No Data Found</td></tr>';
                }


                $('#taskData').html(html);
            }
        });
    }

    // show data while document run
    getResult();

    // create and update from submition

    $(document).on('submit', '#stuForm', function (e) {
        e.preventDefault();

        $('.text-danger').text("");

        let name = $('#name').val().trim();
        let age = $('#age').val().trim();
        let sub = $('#sub').val().trim();
        let isValid = true;

        if (name === "") {
            $('#nameError').text("Name is required.");
            isValid = false;
        }

        if (age === "") {
            $('#ageError').text("Age is required.");
            isValid = false;
        } else if (age < 1) {
            $('#ageError').text("Please enter a valid age.");
            isValid = false;
        }

        if (sub === "") {
            $('#subError').text("Subject is required.");
            isValid = false;
        }
        $(document).on('input', '#name', function () {
            if ($(this).val().trim() !== '') {
                $('#nameError').text('');
            }
        });
        $(document).on('input', '#age', function () {
            if ($(this).val().trim() !== '') {
                $('#ageError').text('');
            }
        });
        $(document).on('input', '#sub', function () {
            if ($(this).val().trim() !== '') {
                $('#subError').text('');
            }
        });

        if (isValid) {
            var form = document.getElementById('stuForm');
            var formData = new FormData(form);

            $.ajax({
                url: 'auth.php',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {

                    if (data.status === 'error') {
                        if (data.errors.name) $('#nameError').text(data.errors.name);
                        if (data.errors.age) $('#ageError').text(data.errors.age);
                        if (data.errors.sub) $('#subError').text(data.errors.sub);

                        if (data.errors.database) {
                            toastr.error(data.errors.database);
                        } else {
                            toastr.error("Please fix the validation errors.");
                        }
                    } else {
                        if (data.data.status === 'add') {
                            $('#stuForm')[0].reset();

                            if (document.activeElement) {
                                document.activeElement.blur();
                            }

                            $('#myModal').modal('hide');
                            toastr.success(data.data.message);
                            getResult();

                        }
                        if (data.data.status === 'updated') {
                            toastr.success(data.data.message);
                            getResult();


                            if (document.activeElement) {
                                document.activeElement.blur();
                            }

                            $('#myModal').modal('hide');
                        }
                    }
                }


            })

        }
    });


    // modal open when click on add button
    $(document).on("click", ".add", function () {
        $.ajax({
            url: "addData.php",
            type: "GET",

            success: function (data) {
                $('.modal-body').html(data);


                $('#myModal').modal('show');


            }
        })
    });

    // modal open when click on update button 


    $(document).on("click", ".update_data", function (e) {
        e.preventDefault();

        var updateID = $(this).attr('data-id');

        $.ajax({
            url: `update.php?id=${updateID}`,
            type: "GET",

            success: function (data) {
                $('.modal-body').html(data);

                $('#myModal').modal('show');

            }
        })
    })

    //delete data and fecth data

    $(document).on("click", ".delete_data", function (e) {
        e.preventDefault();

        var deleteID = $(this).attr('data-id');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                
                $.ajax({
                    url: 'auth.php',
                    method: "POST",
                    data: { "delete_id": deleteID },
                    dataType: 'json',
                    success: function (data) {
                        if (data.status === 'success' || data.raw == '1') {
                            getResult(); // Refresh your list
                            Swal.fire("Deleted!", data.message || "Your file has been deleted.", "success");
                        } else {
                            toastr.error(data.errors ? data.errors.database : 'Error deleting data!');
                        }
                    },
                    error: function () {
                        toastr.error("Server error. Please try again.");
                    }
                });
            }
        })
    
    })
})
