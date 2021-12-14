<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$database = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
if(count($_POST)>0) {
  // collect value of input field
  $fisrtName = mysqli_real_escape_string($conn, trim($_POST['firstname'], " "));
$lastName = mysqli_real_escape_string($conn, trim($_POST['lastname'], " "));
$hobbies = "";
$hobbies1=$_POST['hobbies'];
$gender = mysqli_real_escape_string($conn, trim($_POST['gender'], " "));
$image = $_FILES['profile']['name'];
foreach($hobbies1 as $chk1)
   {
      $hobbies .= $chk1.",";
   }
   $target = "img/".basename($image);

   if (move_uploaded_file($_FILES['profile']['tmp_name'], $target)) {
     $sql = "UPDATE users set first_name='" . $fisrtName . "', last_name='" . $lastName . "',
hobbies='" . $hobbies . "' ,gender='" . $gender . "' , profile='" . $image . "' WHERE id='" . $_POST['id'] . "'";
     if(!$result = $conn->query($sql)){
     die('There was an error running the query [' . $conn->error . ']');
     }
     else
     {
     $_SESSION["msg"] = '<div class="alert alert-primary" role="alert" id="alert">Record Added successfully</div>';
     }
  	}else{
  		$_SESSION["msg"] = '<div class="alert alert-primary" role="alert" id="alert">Fail To Upload</div>';
  	}
foreach($hobbies1 as $chk1)
 {
    $hobbies .= $chk1.",";
 }


}
$result = mysqli_query($conn,"SELECT * FROM users WHERE id='" . $_GET['id'] . "'");
$row= mysqli_fetch_array($result);
?>
<html>
<head>
  <meta charset="utf-8">
  <title>Test For Job</title>
  <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" ></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js" ></script>
<style media="screen">
form .error {
color: #ff0000;
}
form.cmxform label.error {
  display: none;
}
</style>
</head>
<body style="height:1500px">
  <div class="container">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Logo</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarScroll">
        <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="index.php">Form</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="table.php">Table</a>
          </li>

        </ul>

      </div>
    </div>
  </nav>
  <?php if(isset($_SESSION['msg']) && !empty($_SESSION['msg'])) {
     echo $_SESSION['msg'];
  } ?>
  <div class="container mt-3">
<form name="action" method="post" action="" enctype="multipart/form-data">

<div class="form-group mb-3 mt-3">
    <input type="hidden" class="form-control" name="id" value="<?php echo $row['id']; ?>">
  <label for="exampleFormControlInput1">First Name</label>
  <input type="text" class="form-control" name="firstname" value="<?php echo $row['first_name']; ?>">
</div>
<div class="form-group mb-3 mt-3">
  <label for="exampleFormControlInput1">Last Name</label>
  <input type="text" class="form-control" name="lastname" value="<?php echo $row['last_name']; ?>">
</div>
<div class="form-group mb-3">
  <fieldset>
    <label for="exampleFormControlSelect1">Hobbies: </label>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox"  value="Reading" name="hobbies[]" required minlength="2" >
  <label class="form-check-label" for="inlineCheckbox1">Reading</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox"   name="hobbies[]" value="Writing">
  <label class="form-check-label" for="inlineCheckbox2">Writing</label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="checkbox" name="hobbies[]" value="Watching Movies" >
  <label class="form-check-label" for="inlineCheckbox3">Watching Movies</label>
</div>
<label for="hobbies[]" class="error" style="display:none;">Please select at least two types of spam.</label>
  </fieldset>

</div>

<div class="form-group mb-3">
  <label for="gender">Gender</label>
  <select class="form-control"  name="gender" required>
    <option value="">--</option>
    <option value="male">Male</option>
    <option value="female">Female</option>
    <option value="other">Other</option>
  </select>
  <label for="gender" class="error" style="display:none;">Please select a your Gender</label>
</div>

<div class="form-group mb-3">
  <label for="exampleFormControlFile1">Profile Picture (Max 5MB)</label>
  <input type="file" class="form-control-file" name="profile" accept=".png"  onchange="validateFileType()">
  <script type="text/javascript">
  function validateFileType(){
         var fileName = document.getElementById("fileName").value;
         var idxDot = fileName.lastIndexOf(".") + 1;
         var extFile = fileName.substr(idxDot, fileName.length).toLowerCase();
         if (extFile=="png"){
             //TO DO
         }else{
             alert("Only png files are allowed!");
         }
     }
  </script>
</div>
<input type="submit" name="submit" value="Submit" class="buttom">

</form>
</div>
</div>
<script type="text/javascript">
// Wait for the DOM to be ready
$(function() {
// Initialize form validation on the registration form.
// It has the name attribute "registration"
$("form[name='action']").validate({
  // Specify validation rules
  rules: {
    // The key name on the left side is the name attribute
    // of an input field. Validation rules are defined
    // on the right side
    firstname: "required",
    lastname: "required",
    gender: "required",
    profile: "required"

  },
  // Specify validation error messages
  messages: {
    firstname: "Please enter your First Name",
    lastname: "Please enter your Last Name",
    gender: "Please Select your Gender",
    profile: "Please Upload a valid Profile Picture"
  },
  // Make sure the form is submitted to the destination defined
  // in the "action" attribute of the form when valid
  submitHandler: function(form) {
    form.submit();
  }
});
$("#form1").validate();

});



</script>
</body>
</html>
