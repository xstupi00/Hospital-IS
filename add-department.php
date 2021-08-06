<?php include('server.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>TS Clinic IS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="https://www.stud.fit.vutbr.cz/~xzubri00/IIS/style.css"> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
 <?php include('nav-bar.php');?>

 <div class="container">
  <h2 >Add new department</h2>
  <form class="margin-bottom" method="post" action="add-department.php">
    <div class="container">
      <div class="form-group form-width <?php set_input_error_success("Name", $errors);?>">
        <label><span class="required-field">*&nbsp;</span>Department name:</label>
        <?php create_input("text", "form-control", "Name", "Enter Name", $arrayregex['Name'], $arrayinputerrormessages["Name"], isset($Name) ? $Name : "", "true", $errors, $arrayerrormessages, "");?>
      </div>

      <div class="form-row form-width">
        <div class="form-group col-md-6 <?php set_input_error_success("Numberofrooms", $errors);?>" style="padding-left: 0;">
          <label><span class="required-field">*&nbsp;</span>Number of rooms:</label>
          <?php create_input("text", "form-control", "Numberofrooms", "Enter number of rooms", $arrayregex['PosNum'], $arrayinputerrormessages["PosNum"], isset($Numberofrooms) ? $Numberofrooms : "", "true", $errors, $arrayerrormessages, "");?>
        </div>
        <div class="form-group col-md-6 <?php set_input_error_success("Numberofbeds", $errors);?>" style="padding-right: 0;">
          <label><span class="required-field">*&nbsp;</span>Number of beds:</label>
          <?php create_input("text", "form-control", "Numberofbeds", "Enter number of beds", $arrayregex['PosNum'], $arrayinputerrormessages["PosNum"], isset($Numberofbeds) ? $Numberofbeds : "", "true", $errors, $arrayerrormessages, "");?>
        </div>
      </div>

      <div class="form-row form-width">
        <div class="form-group col-md-6 <?php set_input_error_success("Visittimefrom", $errors);?>" style="padding-left: 0;">
          <label><span class="required-field">*&nbsp;</span>Visit time from:</label>
          <?php create_input("text", "form-control", "Visittimefrom", "Enter visit time from", $arrayregex['Visittime'], $arrayinputerrormessages["Visittime"], isset($Visittimefrom) ? $Visittimefrom : "", "true", $errors, $arrayerrormessages, "");?>
        </div>
        <div class="form-group col-md-6 <?php set_input_error_success("Visittimeto", $errors);?>" style="padding-right: 0;">
          <label><span class="required-field">*&nbsp;</span>Visit time to:</label>
          <?php create_input("text", "form-control", "Visittimeto", "Enter visit time to", $arrayregex['Visittime'], $arrayinputerrormessages["Visittime"], isset($Visittimeto) ? $Visittimeto : "", "true", $errors, $arrayerrormessages, "");?>
        </div>
      </div>

      <div class="form-group form-width <?php set_input_error_success("Floor", $errors);?>">
        <label><span class="required-field">*&nbsp;</span>Floor:</label>
        <select name="Floor" class="form-control">
          <?php add_options_from_array($arrayfloors, isset($Floor) ? $Floor : "")?>
        </select>
      </div>    
 
      <button type="submit" name="add-department" class="btn btn-default" style="margin-top:20px;">Submit</button>
      </div>
  </form>
  </div>
</body>
</html>
