<!DOCTYPE html>
<html lang="en" dir="ltr">
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
<div class="alert alert-primary" role="alert" id="alert" style="display:none;">Record Added successfully</div>
<div class="container mt-3">
  <table class="table">
   <thead>
     <tr>
       <th>ID</th>
       <th>Firstname</th>
       <th>Lastname</th>
       <th>Hobbies</th>
       <th>GENDER</th>
       <th>PROFILE</th>
     </tr>
   </thead>
   <tbody>
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
     $query = $conn->query("SELECT * FROM users ORDER by id");
     while($row = $query->fetch_array()){
         echo "<tr>";
           echo "<td>".$row['id']."</td>";
         echo "<td>".$row['first_name']."</td>";
         echo "<td>".$row['last_name']."</td>";
         echo "<td>".$row['hobbies']."</td>";
         echo "<td>".$row['gender']."</td>";
   echo "<td><img src='img/".$row['profile']."' width='50px' ></td>";
   echo '<td><a href="update-process.php?id='.$row["id"].'" class="btn btn-warning">Edit</a></td>';
      echo '<td><a href="#" data-id="'.$row["id"].'" class="btn btn-danger" id="delete">Delete</td>';
         echo "</tr>";
     }
     ?>
   </tbody>
 </table>
<script type="text/javascript">
$(document).ready(function() {

	$(document).on("click", "#delete", function() {
		var $ele = $(this).parent().parent();
		$.ajax({
			url: "delete.php",
			type: "POST",
			cache: false,
			data:{
				id: $(this).attr("data-id")
			},
			success: function(dataResult){
      location.reload();
        document.getElementById('alert').style.display='block';
				var dataResult = JSON.parse(dataResult);
				if(dataResult.statusCode==200){
					$ele.fadeOut().remove();
				}
			}
		});
	});
});
</script>
</div>
</div>

  </body>
</html>
