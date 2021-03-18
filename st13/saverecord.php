<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
  	<meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="css/form.css">
    <style>
    	.navbar
    	{
    		padding: 15px;
    		padding-left: 100px;
    	}
    </style>
  </head>
  <body >
  	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	  <a class="navbar-brand" href="#">
	    	<img src="https://getbootstrap.com/docs/4.5/assets/brand/bootstrap-solid.svg" width="80" height="30" class="d-inline-block align-top" alt="" loading="lazy">
	  </a>
	  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
	    <span class="navbar-toggler-icon"></span>
	  </button>
	  <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
	    <div class="navbar-nav">
	      <a class="nav-item nav-link " href="index.php">Predict</a>
	      <a class="nav-item nav-link active" href="saveRecord.php">Save Record</a>
	      <a class="nav-item nav-link" href="#">View Records</a>
	    </div>
	  </div>
	</nav><br />

  	<form method="post">
  		<div class="form-group">
  			<input type="text" id="drawNumber" class="form-control" placeholder="Enter Draw Number"/>
  		</div><br />
  		<div class="form-group">
  			<input type="text" id="correctPlay" class="form-control" placeholder="Enter Correct Plays" />
  		</div><br />
  		<div class="form-group">
  			<input type="text" id="payOut" class="form-control" placeholder="Pay Out" />
  		</div><br />
  		<div class="form-group">
  			<input type="text" id="betAmt" class="form-control" placeholder="Bet Amount"/>
  		</div><br />
  		<div class="form-group row">
  			<label for="resultsFile">Results File</label>
  			<input type="file" id="resultsFile" class="form-control-file" accept="image/*"/>
  		</div><br />
  		<div class="form-group row">
  			<label for="userPlay">User Play</label>
  			<input type="file" id="userPlay" name="user" class="form-control-file" accept="image/*"/>
  		</div><br />
  		<input type="submit" name="submit" value="Predict" class="btn btn-primary" class="btn btn-primary" onclick="saveRecord(event); "/>
  		<input type="reset" value="Reset" class="btn btn-danger" />
  	</form>






  	<script type="text/javascript">
    function saveRecord(e) 
    {
    	e.preventDefault();
        let drawNumber = $('#drawNumber').val();
        let correctPlay = $('#correctPlay').val();
        let payOut = $('#payOut').val();
        let betAmt = $("#betAmt").val();
        let fileOne = $('#resultsFile');
        let resultsFile = fileOne.prop('files')[0];
        let fileTwo = $('#userPlay');
        let userPlay = fileTwo.prop('files')[0];


        let formData = new FormData();
        formData.append('userPlay', userPlay);
        formData.append('resultsFile', resultsFile);
        formData.append('drawNumber', drawNumber);
        formData.append('correctPlay', correctPlay);
        formData.append('payOut', payOut);
        formData.append('betAmt', betAmt);
        $.ajax({
            url: "./Controller/records.controller.php",
            type: "POST",
            data: formData,
            contentType:false,
            cache: false,
            processData: false,
            success: function(data){
                 alert(data);
            }
        });
    }

  </script>
  
  </body>
</html>