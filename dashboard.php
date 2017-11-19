<?php

  // initialize session and check if user is logged in, if not then redirect to login page
  include('includes/core.inc.php');
  if(!loggedIn()){
    header('Location:index.php');
  }?>
  
<!DOCTYPE html>
<html lang="en">
<head>
	<title>BitBucket Interface</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <!--For Font style -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<body>

  <!-- full width for NavBar -->
<div class="container-fluid px-0">

  <!-- toggleable navbar -->
  <nav class="navbar navbar-toggleable-md navbar-inverse bg-primary">
    
	<!-- toggler, visible only on medium devices, toggles navbar -->
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#nav-content">
      <span class="navbar-toggler-icon"></span>
    </button><div class="navbar-brand">BitBucket Interface</div>
  <div class="collapse navbar-collapse" id="nav-content">
    <ul class="navbar-nav ml-auto">
      <li class="nav-item text-white">
        
		<!-- Showing bitbucket Name and Display Name of logged in user  -->
        <img class="rounded-circle py-0" src="<?php echo $_SESSION["data"]["user"]["avatar"];?>" height="40" width="40">
        <span class="my-2 mr-2"><?php echo $_SESSION["name"]; ?></span>
      </li>
      <li class="nav-item">
        <a class="nav-link" style="border-left:1px solid #ddd;" href="logout.php">Logout</a>
      </li>
    </ul>
  </div>
  </nav>
</div>

<!-- full width container for dashboard -->
<div class="container-fluid px-5">

  <!-- main container of repo table -->
	<div class="col-md-12 mx-auto mt-5" >
	
    <!-- bootstrap hoverable and responsive table -->
    <table class="table table-hover table-responsive">
  <thead>
    <tr>
      <th>Repository</th>
      <th>Created On</th>
      <th>Language</th>
      <th>Size</th>
      <th>Owner</th>
      <th>Visibility</th>
      <th>Updated On</th>
      <th>Link</th>
    </tr>
  </thead>
  <tbody>
  
    <?php
      $res = $_SESSION["data"];
	 
      //making a row of each repo in the table
      for($i=0;$i<count($res["links"]["repositories"]);$i++){ ?>
        <tr>
		
          <!-- repository -->
          <td scope="row"><img src="<?php echo $res["repositories"]["$i"]["logo"];?>" height="42" width="42"><?php echo "&nbsp;" . $res["repositories"]["$i"]["name"];?></td>
          <?php $date=date_create($res["repositories"]["$i"]["utc_created_on"]);?>
          <td scope="row"><?php echo date_format($date,"d-m-Y h:i:s a");?></td>
          <td scope="row"><?php echo $res["repositories"]["$i"]["language"];?></td>
          <td scope="row"><?php echo $res["repositories"]["$i"]["size"];?></td>
          <td scope="row"><?php echo $res["repositories"]["$i"]["owner"];?></td>
          <td scope="row"><?php if($res["repositories"]["$i"]["is_private"] == 1){echo "Private";}else{echo "Public";}?></td>
          <?php $date=date_create($res["repositories"]["$i"]["utc_last_updated"]);?>
          <td scope="row"><?php echo date_format($date,"d-m-Y h:i:s a");?></td>
		  
          <!-- putting a link for each repository   -->
          <td scope="row"><a class="btn btn-sm btn-outline-primary" href="https://bitbucket.org/<?php echo $_SESSION['user'] . '/' . $res["repositories"]["$i"]["name"];?>">Open</a>
        </tr>
    <?php  }
    ?>
  </tbody>
</table>
  </div>
  </div>
</body>
</html>
