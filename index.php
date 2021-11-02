<?php $db = mysqli_connect('localhost','root','','crud_application');

if(isset($_POST['submit'])){

      $recaptcha = $_POST['g-recaptcha-response'];
      $res = reCaptcha($recaptcha);
       if(!$res['success']){
        echo "<script>alert('Invalid RECAPTCHA!Please Try Again...');</script>"; 
        }
   

    $name          = $_POST['name'];
    $email         = $_POST['email'];
    $date_of_birth = $_POST['date_of_birth'];
    $about         = $_POST['about'];
     
   
$insert = "INSERT INTO `aelum` (`name`,`email`,`date_of_birth`,`about`) VALUES ('$name','$email','$date_of_birth','$about')";

$query  = mysqli_query($db,$insert);
if($query){
  
    echo "<script>alert('Data Inserted Successfully Done');window.location.assign('index.php');</script>";
}else{
    echo "<script>alert('Data not Inserted Successfully Done');window.location.assign('index.php');</script>";
}
}

//function recaptcha
function reCaptcha($recaptcha){
    $secret = "6LfisAwdAAAAAHixIsSUGaddTmFmAHOnUMIzLtJK";
    $ip = $_SERVER['REMOTE_ADDR'];
  
    $postvars = array("secret"=>$secret, "response"=>$recaptcha, "remoteip"=>$ip);
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
    $data = curl_exec($ch);
    curl_close($ch);
  
    return json_decode($data, true);
  }

    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>AELUM CONSULTING Pvt. Ltd.</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="https://www.google.com/recaptcha/api.js"></script>
</head>
<body>
    <br>
    <div align="center">
    <label>Time Left</label>
    <h3 id="timer"></h3>
    </div>
<div class="row">
<div class="col-md-4"></div> 
    <div class="col-md-4">
        <div class="card">
            <div class="card-body bg-light">
                <form method="POST">
                    <div class="row my-1">
                        <div class="col-sm-12">
                            <label> Name: </label>
                            <input type="text" minlength="3" name="name" class="form-control" placeholder="Enter Your Name"
                                required="">
                        </div>
                    </div>
                    <div class="row my-1">
                        <div class="col-sm-12">
                            <label> Email: </label>
                            <input type="email" name="email" minlength="12" class="form-control" placeholder="Email"
                                required="">
                        </div>
                    </div>
                    <div class="row my-1">
                        <div class="col-sm-12">
                            <label> Date Of Birth: </label>
                            <input type="date" name="date_of_birth" class="form-control" placeholder="Date Of Birth"
                                required="">
                        </div>
                    </div>
                    
                    <div class="row my-1">
                        <div class="col-sm-12">
                            <label>About Your Self: </label>
                            <input type="text" name="about"  class="form-control" placeholder="About Your Self" required="">
                        </div>
                    </div>
                    <br>
                    <div class="row my-1">
                        <div class="col-sm-12">
                        <div class="g-recaptcha" data-sitekey="6LfisAwdAAAAAP5ntA2h2KCsqhgDX1LNMq60aJYU" required=""></div>   
                        </div>
                    </div>

                    <br>
                    <button class="btn btn-primary float-right" type="submit" name="submit" id="button"> Submit </button>

                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('timer').innerHTML =
    03 + ":" + 00;
    startTimer();


function startTimer() {
  var presentTime = document.getElementById('timer').innerHTML;
  var timeArray = presentTime.split(/[:]+/);
  var m = timeArray[0];
  var s = checkSecond((timeArray[1] - 1));
  if(s==59){m=m-1}
  if(m<0){
    return
  }
  if(s==0 && m==0){
      alert('Sorry ! Your Time is Over');
      document.getElementById('button').style.visibility = 'hidden';
  }
  
  document.getElementById('timer').innerHTML =
    m + ":" + s;
  console.log(m)
  setTimeout(startTimer, 1000);
  
}

function checkSecond(sec) {
  if (sec < 10 && sec >= 0) {sec = "0" + sec};
  if (sec < 0) {sec = "59"};
  return sec;
}

</script>
</body>
</html>