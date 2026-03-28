$(document).ready(function () {

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
                            toastr.success("Data added successfully.");

                            $('#taskData').append(`<tr id="row_${data.data.id}">
                                    <td>${data.data.id}</td>
                                    <td>${data.data.name}</td>
                                    <td>${data.data.age}</td>
                                    <td>${data.data.sub}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm update_data" data-id="${data.data.id}">Edit</a>
                                        <a href="#" class="btn btn-danger btn-sm delete_data" data-id="${data.data.id}">Delete</a>
                                    </td>
                                </tr>`);
                        }
                        if (data.data.status === 'updated') {
                            toastr.success("Data updated successfully.");
                            var newRow = "";
                            var newRow = `<tr id="row_${data.data.id}">
                                    <td>${data.data.id}</td>
                                    <td>${data.data.name}</td>
                                    <td>${data.data.age}</td>
                                    <td>${data.data.sub}</td>
                                    <td>
                                        <a href="#" class="btn btn-primary btn-sm update_data" data-id="${data.data.id}">Edit</a>
                                        <a href="#" class="btn btn-danger btn-sm delete_data" data-id="${data.data.id}">Delete</a>
                                    </td>
                                </tr>`
                            $("#row_" + data.data.id).replaceWith(newRow);
                            
                            if (document.activeElement) {
                                document.activeElement.blur();
                            }
                            
                            $('#myModal').modal('hide');
                        }
                    }
                },
                error: function (response) {
                    toastr.error("Something went wrong on the server.");
                }


            })

        }
    });



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

    $(document).on("click", ".delete_data", function (e) {
        e.preventDefault();

        var deleteID = $(this).attr('data-id');
        var row = $(this).closest('tr');

        $.ajax({
            url: 'auth.php',
            method: "POST",
            data: { "delete_id": deleteID },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if (data.status === 'success') {
                    row.remove();
                    toastr.success('Data deleted successfully!');
                } else if (data.status === 'error') {
                    toastr.error(data.errors && data.errors.database ? data.errors.database : 'Error deleting data!');
                } else if (data.raw == '1') {
                    row.remove();
                    toastr.success('Data deleted successfully!');
                } else {
                    toastr.error('Error deleting data!');
                }
            },
            error: function () {
                toastr.error("Something went wrong on the server.");
            }
        });
    });
})