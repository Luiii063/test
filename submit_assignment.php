<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Bootstrap demo</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css"
    rel="stylesheet"
    integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD"
    crossorigin="anonymous"
  />
  <link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
    integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e"
    crossorigin="anonymous"
  />
  <style>
    .step-icon {
      width: 4rem;
      height: 4rem;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #28a745;
      color: white;
      border-radius: 50%;
    }

    .step-label {
      text-align: center;
      margin-top: 1px;
    }

    .application-form-container {
  margin: 0 auto; /* Center the container */
  max-width: 900px; /* Adjust the maximum width as needed */
  padding: 30px; /* Add padding for spacing */
  background-color: #f7f7f7; /* Add a background color if desired */
}

.required {
  color: red;
  font-size: 20px;
  margin-left: 4px; /* Adjust the spacing between the label and asterisk */
}
  </style>
</head>
<body data-bs-theme="white">

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <div class="container-fluid p-2">
        <div class="d-flex justify-content-around">
          <button
            class="btn btn-sm rounded-pill"
            data-bs-toggle="collapse"
            data-bs-target="#applicationForm"
            aria-expanded="true"
            aria-controls="applicationForm"
            onclick="stepFunction(event)"
          >
            <span class="step-icon"><i class="bi bi-person"></i></span>
            <div class="step-label">Application Form</div>
          </button>
          <span
            class="bg-success w-25 rounded mt-auto mb-auto me-1 ms-1"
            style="height: 0.2rem"
          ></span>
          <button
            class="btn btn-sm rounded-pill"
            data-bs-toggle="collapse"
            data-bs-target="#id_indigency"
            aria-expanded="false"
            aria-controls="id_indigency"
            onclick="stepFunction(event)"
          >
            <span class="step-icon"><i class="bi bi-card-checklist"></i></span>
            <div class="step-label">School ID</div>
          </button>
          <span
            class="bg-success w-25 rounded mt-auto mb-auto me-1 ms-1"
            style="height: 0.2rem"
          ></span>
          <button
            class="btn btn-sm rounded-pill"
            data-bs-toggle="collapse"
            data-bs-target="#grades"
            aria-expanded="false"
            aria-controls="grades"
            onclick="stepFunction(event)"
          >
            <span class="step-icon"><i class="bi bi-file-earmark-text"></i></span>
            <div class="step-label">Grades</div>
          </button>
          <span
            class="bg-success w-25 rounded mt-auto mb-auto me-1 ms-1"
            style="height: 0.2rem"
          ></span>
          <button
            class="btn btn-sm rounded-pill"
            data-bs-toggle="collapse"
            data-bs-target="#enrollment"
            aria-expanded="false"
            aria-controls="enrollment"
            onclick="stepFunction(event)"
          >
            <span class="step-icon"><i class="bi bi-file-earmark-bar-graph"></i></span>
            <div class="step-label">Enrollment Assessment</div>
          </button>
        </div>
      </div>

      <div class="collapse show" id="applicationForm">
  <div class="container mt-4">
    <!-- Left top corner label -->
    <div class="border-left border-top p-2">
      <div class="display-4">Application Form</div>
    </div>

    <!-- Second container with subtle black border -->
    <div class="border p-4 mt-3">
      <h5>Part I: Personal Information</h5>
      <hr>
      <!-- Rest of the Application Form content goes here -->
      <!-- ... (previous code) ... -->
      <hr>
    <div class="row">
      <div class="col-md-6">
        <div class="mb-3">
          <label for="lastName" class="form-label">Last Name<span class="required">*</span></label>
          <input type="text" class="form-control" id="lastName" name="lastName">
        </div>
        <div class="mb-3">
          <label for="middleName" class="form-label">Middle Name<span class="required">*</span></label>
          <input type="text" class="form-control" id="middleName" name="middleName">
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label for="firstName" class="form-label">First Name<span class="required">*</span></label>
          <input type="text" class="form-control" id="firstName" name="firstName">
        </div>
      </div>
    </div>
    <hr>
    <div class="container mt-5">
    <h5>Home Address</h5>
    <div class="row">
      <div class="col-md-6">
        <div class="mb-3">
          <label for="houseNo" class="form-label">House No.<span class="required">*</span></label>
          <input type="text" class="form-control" id="houseNo" name="houseNo">
        </div>
        <div class="mb-3">
          <label for="sitio" class="form-label">Purok / Sitio<span class="required">*</span></label>
          <input type="text" class="form-control" id="sitio" name="sitio">
        </div>
        <div class="mb-3">
          <label for="province" class="form-label">Province<span class="required">*</span></label>
          <input type="text" class="form-control" id="province" name="province">
        </div>
    </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label for="barangay" class="form-label">Barangay<span class="required">*</span></label>
          <input type="text" class="form-control" id="barangay" name="barangay">
        </div>
        <div class="mb-3">
          <label for="municipality" class="form-label">Municipality<span class="required">*</span></label>
          <input type="text" class="form-control" id="municipality" name="municipality">
        </div>
      </div>
    </div>
    <hr>
  </div>
  <div class="container mt-5">
  <hr>
  <h5>Contact Number</h5>
  <div class="row">
    <div class="col-md-5">
      <div class="mb-3">
        <label for="mobileNumber" class="form-label">Mobile Number<span class="required">*</span></label>
        <input type="tel" class="form-control" id="mobileNumber" name="mobileNumber">
      </div>
      <div class="mb-5>
        <label for="mobileNumber2" class="form-label">Mobile Number 2<span class="required">*</span></label>
        <input type="tel" class="form-control" id="mobileNumber2" name="mobileNumber2">
      </div>
    </div>
    <div class="col-md-6">
      <div class="mb-3">
        <label for="emailAddress" class="form-label">Email Address<span class="required">*</span></label>
        <input type="email" class="form-control" id="emailAddress" name="emailAddress">
      </div>
      <div class="mb-6">
        <label for="parentMobileNumber" class="form-label">Parent/Guardian Mobile Number<span class="required">*</span></label>
        <input type="tel" class="form-control" id="parentMobileNumber" name="parentMobileNumber">
      </div>
    </div>
  </div>
  <hr>
  <h5>Education Information</h5>
  <div class="row">
    <div class="col-md-6">
      <div class="mb-3">
        <label for="schoolName" class="form-label">Name of School<span class="required">*</span></label>
        <input type="text" class="form-control" id="schoolName" name="schoolName">
      </div>
      <div class="mb-3">
        <label for="yearLevel" class="form-label">Year Level<span class="required">*</span></label>
        <input type="text" class="form-control" id="yearLevel" name="yearLevel">
      </div>
    </div>
    <div class="col-md-6">
      <div class="mb-3">
        <label for="course" class="form-label">Course<span class="required">*</span></label>
        <input type="text" class="form-control" id="course" name="course">
      </div>
      <div class="mb-3">
        <label for="major" class="form-label">Major<span class="required">*</span></label>
        <input type="text" class="form-control" id="major" name="major">
      </div>
    </div>
  </div>
  <hr>
<h5>Part II: Family Background</h5>
<div class="row">
  <div class="col-md-12">
    <table class="table">
      <thead>
        <tr>
          <th>Name of Household Member</th>
          <th>Relation to the Beneficiary</th>
          <th>Age</th>
          <th>Civil Status</th>
          <th>Job or Business</th>
          <th>Educational Attainment</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><input type="text" class="form-control" name="familyName1"></td>
          <td><input type="text" class="form-control" name="familyRelation1"></td>
          <td><input type="text" class="form-control" name="familyAge1"></td>
          <td><input type="text" class="form-control" name="familyCivilStatus1"></td>
          <td><input type="text" class="form-control" name="familyJob1"></td>
          <td><input type="text" class="form-control" name="familyEducation1"></td>
        </tr>
        <!-- Add more rows as needed -->
      </tbody>
    </table>
    <!-- Add buttons to add/remove rows dynamically if required -->
  </div>
</div>
    </div>
  </div>
</div>



        <!--END OF APPLICATION FORM CONTENT-->
      </div>
      <div class="collapse" id="id_indigency">
        <div class="display-4">School ID</div>
        <!-- Your content here -->
      </div>
      <div class="collapse" id="grades">
        <div class="display-4">Grades</div>
        <!-- Your content here -->
      </div>
      <div class="collapse" id="enrollment">
        <div class="display-4">Enrollment Assessment</div>
        <!-- Your content here -->
      </div>
    </div>
  </div>
</div>

<script>
  function myFunction() {
    var element = document.body;
    element.dataset.bsTheme =
      element.dataset.bsTheme == "light" ? "dark" : "light";
  }

  function stepFunction(event) {
    var element = document.getElementsByClassName("collapse");
    for (var i = 0; i < element.length; i++) {
      if (element[i] !== event.target.ariaControls) {
        element[i].classList.remove("show");
      }
    }
  }
</script>

<script
  src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
  integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3"
  crossorigin="anonymous"
></script>
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"
  integrity="sha384-mQ93GR66B00ZXjt0YO5KlohRA5SY2XofN4zfuZxLkoj1gXtW8ANNCe9d5Y3eG5eD"
  crossorigin="anonymous"
></script>
</body>
</html>
