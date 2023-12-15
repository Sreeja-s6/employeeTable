<?php
//use App\Http\Helpers\EmployeeHelper;
use App\Http\Helpers\EmployeeHelpers;


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LARAVEL ASSIGNMENT</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <style>
    .button-container {
      display: flex;
      justify-content: space-between;
      /* Adjust as needed */
    }
  </style>

</head>

<body>
  <nav class="navbar navbar-expand-sm bg-dark">


    <ul class="navbar-nav">
      <li class="nav-item">
        <h3 class="nav-link text-light">Employees</h3>
      </li>
      </u>
  </nav>

  @if($message = Session::get('success'))
  <div class="alert alert-success alert-block">
    <strong>{{ $message }}</strong>
  </div>
  @endif

  <div class="container">
    <div class="text-right">
      <div class="success_message"></div>
      <!-- <a href="employees/create" class="btn btn-success mt-2">Add New Employee</a> -->
      <button type="button" class="btn btn-success btn-lg mt-2" data-toggle="modal" data-target="#myModal">Add Employee</button>
    </div>


    <table class="table table-hover mt-3">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Gender</th>
          <th>Date of Birth</th>
          <th>Address</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Department</th>
          <th>Designation</th>
          <th>Date of join</th>
          <!-- <th>Image</th> -->
          <th width="50%">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($employees as $employee)
        <tr>
          <td>{{ $loop->index+1 }}</td>
          <td>{{ $employee->name }}</td>
          <td>{{ $employee->gender }}</td>
          <td>{{ $employee->dob }}</td>
          <td>{{ $employee->address }}</td>
          <td>{{ $employee->email }}</td>
          <td>{{ $employee->phone }}</td>
          <td>{{ (EmployeeHelpers::getDepartment($employee->department_id)) }}</td>
          <td>{{ (EmployeeHelpers::getDesignation($employee->designation_id)) }}</td>
          <td>{{ $employee->doj }}</td>
          <!-- <td>
             <img src="employees/{{ $employee->image }}" class="rounded-circle" width="60" height="60">
                 @foreach ($employee->images as $image) 
                <img src="{{ asset($image->image_path) }}" alt="Employee Image">
                @endforeach 
          </td>  -->
          <td> 
            <!-- <a href="employees/{{ $employee->id }}/edit" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#editModal" >Edit</a>   -->
            <!-- <a href=" "></a> -->
            <button class="editButton btn btn-dark btn-sm" data-employee-id="{{ $employee->id }}" data-toggle="modal" data-target="#editModal">Edit</button>

            <form method="POST" action="employee/{{ $employee->id }}/delete" >
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
          </td>

        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@if($message = Session::get('success'))
<div class="alert alert-success alert-block">
  <strong>{{ $message }}</strong>
</div>
@endif

  <!-- Add Employee Modal -->
  <div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">New Employee</h4>
        </div>
        <div class="modal-body">
          <form method="POST" id="formId" action="/employees/store" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="form-group">
              <input type="text" name="name" class="form-control" placeholder="Enter Your Name" value="{{ old('name') }}" required />
              @if($errors->has('name'))
              <span class="text-danger">{{ $errors->first('name') }}</span>
              @endif
              <div id="errorContainer-name"></div>
            </div>

            <div class="form-group">
              <label>Gender</label>
              <select class="form-control" name="gender" required>
                <option>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
              @if($errors->has('gender'))
              <span class="text-danger">{{ $errors->first('gender') }}</span>
              @endif
              <div id="errorContainer-gender"></div>
            </div>

            <div class="form-group">
              <label>Date of Birth</label>
              <input type="date" name="dob" id="dateInput" class="form-control" value="{{ old('dob') }}" max="" required />
              @if($errors->has('dob'))
              <span class="text-danger">{{ $errors->first('dob') }}</span>
              @endif
              <div id="errorContainer-dateInput"></div>
            </div>

            <div class="form-group">
              <textarea class="form-control" name="address" cols="30" rows="4" placeholder="Enter Your address" required>{{ old('address') }}</textarea>
              @if($errors->has('address'))
              <span class="text-danger">{{ $errors->first('address') }}</span>
              @endif
              <div id="errorContainer-address"></div>
            </div>

            <div class="form-group">
              <input type="email" name="email" class="form-control" placeholder="Enter Your Email" value="{{ old('email') }}" required />
              @if($errors->has('email'))
              <span class="text-danger">{{ $errors->first('email') }}</span>
              @endif
              <div id="errorContainer-email"></div>
            </div>

            <div class="form-group">
              <input type="text" name="phone" class="form-control" placeholder="Enter Phone Number" value="{{ old('phone') }}" required />
              <!-- @if($errors->has('phone'))
              <span class="text-danger">{{ $errors->first('phone') }}</span>
              @endif -->
              <div id="errorContainer-phone"></div>
            </div>

            <div class="form-group">
              <select name="department_id" id="department_id" class="form-control" required>
                <option value="select department">Select Department</option>
                @foreach($departments as $department)
                <option value="{{ $department->id }}">{{ $department->depname }}</option>
                @endforeach
              </select>
            </div>

            <div class="form-group">
              <select name="designation_id" id="designation_id" class="form-control" required>
                <option value="">Select Designation</option>
              </select>
            </div>

            <div class="form-group">
              <label>Date of Join</label>
              <input type="date" name="doj" id="joinInput" min="" class="form-control" value="{{ old('doj') }}" required />
              @if($errors->has('doj'))
              <span class="text-danger">{{ $errors->first('doj') }}</span>
              @endif
              <div id="errorContainer-joinInput"></div>
            </div>

            <div class="form-group">
              <label>Image</label>
              <input type="file" name="image" class="form-control"  />
              @if($errors->has('image'))
              <span class="text-danger">{{ $errors->first('image') }}</span>
              @endif
              <!-- <label>Images</label>
               <input type="file" name="images[]" class="form-control" multiple />
                @if($errors->has('images'))
                  <span class="text-danger">{{ $errors->first('images') }}</span>
                @endif -->
            </div>


            <!-- Display errors inline -->
            @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            <div class="modal-footer">
              <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
              <button type="button" class="btn btn-default">Close</button>
              <button type="submit" class="btn btn-success">Save</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End Add Employee Modal -->

  <!-- Edit Employee Modal -->

  <div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Employee Edit</h4>
        </div>

        <ul id="update_errorList"></ul>
        <!-- <input type="text" id="edit_emp_id">  -->
        <div class="modal-body">
          <form id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('get')
            <input type="hidden" name="empid" id="empid" value="">

            <div class="form-group">
              <input type="text" name="name" id="Name" class="form-control" placeholder="Enter Your Name" value="{{ old('name') }}" required />
              @if($errors->has('name'))
              <span class="text-danger">{{ $errors->first('name') }}</span>
              @endif
            </div>

            <div class="form-group">
              <label>Gender</label>
              <select class="form-control" name="gender" id="Gender" required>
                <option>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
              </select>
              @if($errors->has('gender'))
              <span class="text-danger">{{ $errors->first('gender') }}</span>
              @endif
            </div>

            <div class="form-group">
              <label>Date of Birth</label>
              <input type="date" name="dob" id="Dob" class="form-control" value="{{ old('dob') }}" required />
              @if($errors->has('dob'))
              <span class="text-danger">{{ $errors->first('dob') }}</span>
              @endif
            </div>

            <div class="form-group">
              <textarea class="form-control" name="address" id="Address" cols="30" rows="4" placeholder="Enter Your address" required>{{ old('address') }}</textarea>
              @if($errors->has('address'))
              <span class="text-danger">{{ $errors->first('address') }}</span>
              @endif
            </div>

            <div class="form-group">
            <label>Email</label>
              <input type="email" name="email" id="Email" class="form-control" placeholder="Enter Your Email" value="{{ old('email') }}" required />
              @if($errors->has('email'))
              <span class="text-danger">{{ $errors->first('email') }}</span>
              @endif
            </div>

            <div class="form-group">
            <label>Phone Number</label>
              <input type="text" name="phone" id="Phone" class="form-control"  value="{{ old('phone') }}" required />
              @if($errors->has('phone'))
              <span class="text-danger">{{ $errors->first('phone') }}</span>
              @endif
            </div>

            <div class="form-group">
              <select name="department_id" id="editdepartment_id" class="form-control" required>
                <option value="select department">Select Department</option>
                @foreach($departments as $department)
                <option value="{{ $department->id }}">{{ $department->depname }}</option>
                @endforeach
              </select>
            </div>

            <!-- <select id="department" name="department" required>
        @foreach ($departments as $department)
            <option value="{{ $department->id }}" @if($department->id === $employee->department_id) selected @endif>
                {{ $department->name }}
            </option>
        @endforeach
    </select> -->

            <div class="form-group">
              <select name="designation_id" id="editdesignation_id" class="form-control" required>
                <option value="">Select Designation</option>
                </option>
              </select>
            </div>

            <!-- <select id="designation" name="designation" required>
        @foreach ($designations as $designation)
            <option value="{{ $designation->id }}" @if($designation->id === $employee->designation_id) selected @endif>
                {{ $designation->name }}
            </option>
        @endforeach
    </select> -->


            <div class="form-group">
              <label>Date of Join</label>
              <input type="date" name="doj" id="Doj" class="form-control" value="{{ old('doj') }}" required />
              @if($errors->has('doj'))
              <span class="text-danger">{{ $errors->first('doj') }}</span>
              @endif
            </div>

            <div class="form-group">
              <label>Image</label>
              <input type="file" name="image" id="Image" class="form-control" />
              @if($errors->has('image'))
              <span class="text-danger">{{ $errors->first('image') }}</span>
              @endif
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <!-- <button type="submit" class="btn btn-success update_employee">Update</button> -->
              <button type="button" class="btn btn-primary" id="updateButton" data-dismiss="modal">Update</button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End Edit Employee Modal -->
</body>

</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

 document.addEventListener('DOMContentLoaded', function () {
    var dobInput = document.getElementById('dateInput');
    var dojInput = document.getElementById('joinInput');
    var form = document.getElementById('formId');

    // Set max attribute for Date of Birth
    var today = new Date();
    var dd = today.getDate();
    var mm = today.getMonth() + 1; // January is 0!
    var yyyy = today.getFullYear();

    if (dd < 10) {
        dd = '0' + dd;
    }

    if (mm < 10) {
        mm = '0' + mm;
    }

    today = yyyy + '-' + mm + '-' + dd;
    dobInput.setAttribute('max', today);

    form.addEventListener('submit', function (event) {
        // Clear any existing error messages
        clearErrorMessages();

        // Get the selected date of birth and date of join
        var dobValue = dobInput.value;
        var dojValue = dojInput.value;

        // Parse the date of birth and date of join
        var dobDate = new Date(dobValue);
        var dojDate = new Date(dojValue);

        // Get the current year
        var currentYear = new Date().getFullYear();

        // Validate that date of join does not exceed current year
        if (dojDate.getFullYear() > currentYear) {
            displayErrorMessage('Please check the date of birth.Date of Join should not exceed current year', 'errorContainer-joinInput');
            event.preventDefault(); // Prevent form submission
            return;
        }

        // Validate that date of join is 18 years or more after date of birth
        var eighteenYearsAgo = new Date();
        eighteenYearsAgo.setFullYear(eighteenYearsAgo.getFullYear() - 18);

        if (dobDate > eighteenYearsAgo || dojDate < dobDate) {
            displayErrorMessage('Please check the date of birth and date of join.Date of join 18 years greater than date of birth', 'errorContainer-joinInput');
            event.preventDefault(); // Prevent form submission
        }
    });

    function displayErrorMessage(message, errorContainerId) {
        var errorContainer = document.getElementById(errorContainerId);
        errorContainer.textContent = message;
        errorContainer.style.color = 'red'; // Set the text color to red
    }

    function clearErrorMessages() {
        var errorContainers = document.querySelectorAll('[id^=errorContainer-]');
        errorContainers.forEach(function (container) {
            container.textContent = '';
        });
    }
});



        //add modal closing issue
        $(document).ready(function () {
        $('#formId').submit(function (e) {
            e.preventDefault();

            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function (response) {
                    // Handle success (e.g., close modal, update UI)
                    $('#myModal').modal('hide');
                },
                error: function (xhr, status, error) {
                    // Handle error (e.g., display error messages)
                    console.error('AJAX Error:', xhr.status, xhr.statusText);
                    console.error('Server Response:', xhr.responseText);

                    if (xhr.status === 422) {
                        // Handle Laravel validation errors
                        var errors = JSON.parse(xhr.responseText);

                        if (errors && errors.errors) {
                            // Display error messages in their respective containers
                            $.each(errors.errors, function (field, message) {
                                var errorContainerId = '#errorContainer-' + field;
                                $(errorContainerId).html('<div class="alert alert-danger">' + message + '</div>');
                            });
                        }

                        // Do not close the modal if there are validation errors
                    } else {
                        // Handle other types of errors
                        alert('An error occurred. Please try again.');
                    }
                }
            });
        });
    });
  $(document).ready(function() {

    $('#department_id').on('change', function() {
      var departmentID = $(this).val();

      if (departmentID) {
        $.ajax({
          type: 'GET',
          url: '/get-designations/' + departmentID,
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          },
          data: {
            'department_id': departmentID
          },
          success: function(data) {
            console.log(data);
            // Clear existing options
            $('#designation_id').empty();

            // Populate options based on the AJAX response
            $.each(data, function(key, value) {
              $('#designation_id').append('<option value="' + value.id + '">' + value.designation_name + '</option>');
            });
          },
          error: function(error) {
            console.log(error);
          }
        });

      } else {
        $('#designation_id').empty();
        $('#designation_id').prop('disabled', true);
      }
    });
  });


  // Example for fetching employee details

  $('.editButton').on('click', function() {
    var employeeId = $(this).data('employee-id');

    $.ajax({
      url: '/employees/' + employeeId,
      type: 'GET',
      // headers: {
      //   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      // },

      dataType: 'json',
      success: function(response) {
        // Populate the modal form with employee details
        $('#empid').val(response.id);
        $('#Name').val(response.name);
        $('#Gender').val(response.gender);
        $('#Dob').val(response.dob);
        $('#Address').val(response.address);
        $('#Email').val(response.email);
        $('#Phone').val(response.phone);
        $('#editdepartment_id').val(response.department_id);
        // $('#editdesignation_id').val(response.editdesignation_id);

        $('#Doj').val(response.doj);
        //$('#Image').val(response.image);
        $('#Image').val('');


        console.log(response);

      }
    });


  });

  $('#editdepartment_id').on('change', function() {
    // var selectedOption = getElementById("department_id");
    var designationID = $(this).val();


    $.ajax({
      type: 'GET',
      url: '/get-designations/' + designationID,
      dataType: 'JSON',
      // headers: {
      //   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      // },
      data: {
        'editdesignation_id': designationID
      },
      success: function(data) {
        console.log(data);

        $('#editdesignation_id').empty();

        $.each(data, function(key, value) {
          $('#editdesignation_id').append('<option value="' + value.id + '">' + value.designation_name + '</option>');
        });
      },
      error: function(error) {
        console.log(error);
      }
    });
  });
</script>
 
<!-- updating employee details -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  //$(document).on('submit','#updateButton',function(e){
  // $(document).ready(function(e) {
  $('#updateButton').on('click', function(e) {
    e.preventDefault();

    var id = $('#empid').val();
    let EditformData = new FormData($('#editForm')[0]);
    //console.log('Before AJAX call');
    $.ajax({
      type: 'POST',
      url: '/update-employee/' + id,
      data: EditformData,
      contentType: false,
      processData: false,
      success: function(response) {
        //console.log(response);

        if (response.status == 400) {
          $('#update_errorList').html("");
          $('#update_errorList').removeClass('d-none');

          $.each(response.errors, function(key, err_value) {
            // $('#update_errorList').append('<li>'+err_value+'</li>');
            $('#update_errorList').append('<option>' + err_value + '</option>');
          });
        } else if (response.status == 404) {
          alert(response.message);
        } else if (response.status == 200) {
          alert(response.message);
          $('#editModal').modal('hide');
          $('#update_errorList').html("");
          $('#update_errorList').addClass('d-none');




        }
      }
    });
  });
</script>
  