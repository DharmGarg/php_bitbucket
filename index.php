<?php
  include('includes/core.inc.php');
  if(loggedIn()){
	  
	// if already logged in, redirect to dashboard.php
    header('Location:dashboard.php');
  }?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>BitBucket</title>
<style>
.email
{
	width:360px;
	margin: 50px auto;
	font-family: cambria,"Hoefler Text","Liberation serif",Times,"Times New Roman",serif;
	color:#006;
	border-radius:10px;
	border: 2px solid #000;
	margin-top:70px;
	padding:10px 40px 25px;
}
input[type=text]
{
	width:99%;
	padding:10px;
	margin-top:8px;
	border:1px solid #cc;
	padding-left:5px;
	font-size:16px;
	font-family:cambria,"Hoefler Text","Liberation Serif",Times,"Times New Roman",serif;
}
input[type=submit]
{
	width:100%;
	background-color:#009;
	color:#fff;
	border:2px solid #06F;
	padding:10px;
	font-size:20px;
	cursor:pointer;
	border-radius:5px;
	margin-bottom:15px;
}
input[type=password]
{
	width:99%;
	padding:10px;
	margin-top:8px;
	border:1px solid #cc;
	padding-left:5px;
	font-size:16px;
	font-family:cambria,"Hoefler Text","Liberation Serif",Times,"Times New Roman",serif;
}
</style>	
	
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <!--For font style  -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
<body>
 <div class="email">
    <h1 align="center">BitBucket Interface</h1>
	<hr/>

<!-- container for input form -->
<div class="container">

        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?><?php echo $_SERVER["PHP_SELF"]; ?>">
          <div class="form-group">
            <label class="col-form-label" for="username">BitBucket Username</label>
            <input type="text" placeholder="Username" name="username" id="email"><br/>
          </div>
          <div class="form-group">
            <label class="col-form-label" for="pwd">BitBucket Password</label>
            <input type="password" Placeholder="Password" name="password" id="password"><br/>  
          </div>
		  
          <!--to alert user of errors-->
          <div id="loginAlert" class="alert alert-danger alert-dismissible fade show" role="alert">
            <button type="button" class="close" data-dismiss="alert">
               <span aria-hidden="true">&times;</span>
               </button>Please Login First
          </div>
          <div class="form-group">
          <div class="text-center">
            <button type="submit" class="btn btn-primary" name="loginSubmit">Login</button>
            <button type="reset" class="btn btn-danger ml-md-5">Reset</button>
          </div>
          </div>
        </form>
      </div>
  </div>
 
</body>
</html>
<?php
if(isset($_POST["loginSubmit"]))
	{
		
		//check if username and password set
		if(isset($_POST["username"]) && isset($_POST["password"])) 
		{
			$uname = $_POST["username"];
			$pass = $_POST["password"];
			
			//check whether the username or password are empty
			if (empty($uname) || empty($pass)) 
			{ ?>
				<script>
          jQuery("#loginAlert").html('<button type="button" class="close" data-dismiss="alert"><span> &times; </span> </button>Please Enter Details');
        </script>
			<?php }
			else
			{
				
        // since bitbucket provides RESTful API, we will use cURL for request
		//initialize cURL and set operation parameters
        $ch = curl_init(); 
       
		try{
			
			// REST bitbucket API url
			 curl_setopt($ch, CURLOPT_URL, "https://api.bitbucket.org/2.0/users/".$uname);

		//cURL return transfer
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		
		//HTTP verb
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
		
		//authentication
        curl_setopt($ch, CURLOPT_USERPWD, $uname . ":". $pass); 
		
		//execute cURL
        $result = curl_exec($ch); 
			if(FALSE === $result)
        throw new Exception(curl_error($ch), curl_errno($ch));
			
		}catch(Exception $e) {

    trigger_error(sprintf(
        'Curl failed with error #%d: %s',
        $e->getCode(), $e->getMessage()),
        E_USER_ERROR);

}
		
		if($result){
			
			//close cURL handler
			curl_close ($ch); 
		}else{
			echo "hello";
		}
        
        if (empty($result)) { 
		
		  //check for result, alert user if empty
          var_dump($result);
        }
        else{
          
		  //success, get data and decode it to associative array
		  $res = json_decode($result,true);
		  
          //set session variables
          $_SESSION["user"] = $uname;
          $_SESSION["name"] = $res["user"]["display_name"];
		  
		  //saving data in session var
          $_SESSION["data"] = $res; 
		  
		  //redirect to dashboard
          header('Location:dashboard.php'); 
        }
			}
		}
	}
?>
