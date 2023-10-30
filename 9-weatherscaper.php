<?php
error_reporting(E_ERROR|E_PARSE); //to not to show errors in webpage
$err='';
if($_GET['city'])
{
    $apidata=file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=".$_GET['city'].",uk&APPID=8bb6373c5ea4d157926eabf6e6ccc238");
    $weatherarray=json_decode($apidata,true);
    if($weatherarray['cod']==200)
    {
    $tempC=$weatherarray['main']['temp']-273.15;
    $weather="<b>".$weatherarray['name'].",".$weatherarray['sys']['country']." ".$tempC."&deg;</b><br>";
    $weather.="<b>Weather Condition:</b>".$weatherarray['weather']['0']['description'];
    $weather.="<br><b>Atmospheric Pressure:</b>".$weatherarray['main']['pressure']."hPa<br>";
    $weather.="<b>Wind:</b>".$weatherarray['wind']['speed']."m/sec<br>";
    $weather.="<b>Cloudness:</b>".$weatherarray['clouds']['all']."%<br>";
    date_default_timezone_set('Asia/kolkata');
    $sunrise=$weatherarray['sys']['sunrise'];
    $weather.="<b>SunRise:</b>".date("g:i a",$sunrise)."<br>";
    $weather.="<b>CurrentTime:</b>".date("F j,Y,g:i a");
    }
    else
    {
        $err='Couldnot process';
    }
}
else
{
    $err.='Sorry,Please Enter the city Name!';
}


?>
<!DOCTYPE html>
<html>

<head>
    <title>WeatherScaraper</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <style>
        html {
            background: url(backgorund.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }
        body
        {
            background: none;
        }
        .container
        {
            text-align: center;
            margin-top: 200px;
            width:450px;
        }
        input
        {
            margin:20px;
        }
        button
        {
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2><ion-icon name="cloudy-night"></ion-icon> What's The Weather?</h2>
		<form action="">
			<div class="form-group">
				<label for="city">Enter the name of the City,Country</label>
					<input type="text" class="form-control" id="city" name="city" placeholder="Eg: London,UK" >
			</div>
			<button type="submit" class="btn btn-primary">Submit</button>
            <div class='output mt-3'>
                <?php 
                if($weather)
                {
                    echo "<div  id='a' class=' alert-success'>".$weather."</div>";

                }
                else
                {
                echo "<div id='a' class='alert-danger'>".$err."</div>";
                }
                 ?>
            </div>
		</form>
    </div>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script>
        $('button').click(function()
        {
            $('#a').animate({
                width:'200px',
                height:'400px',
  }, 5000, function() {
    // Animation complete.
  });
        })
    </script>
</body>

</html>