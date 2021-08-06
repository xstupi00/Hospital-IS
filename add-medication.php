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
  <h2 >Add new medication</h2>
  <form class="margin-bottom" method="post" action="add-medication.php">
   
    <div class="container">

      <div class="form-group form-width <?php set_input_error_success("Name", $errors);?>">
        <label><span class="required-field">*&nbsp;</span>Medication name:</label>
        <?php create_input("text", "form-control", "Name", "Enter name", $arrayregex['Name'], $arrayinputerrormessages["Name"], isset($Name) ? $Name : "", "true", $errors, $arrayerrormessages, "");?>
      </div>

      <div class="form-group form-width <?php set_input_error_success("Maximaldose", $errors);?>">
        <label><span class="required-field">*&nbsp;</span>Maximal dose:</label>
        <?php create_input("text", "form-control", "Maximaldose", "Set maximal dose", $arrayregex['PosNum'], $arrayinputerrormessages["PosNum"], isset($Maximaldose) ? $Maximaldose : "", "true", $errors, $arrayerrormessages, "");?>
      </div>

      <div class="form-group form-width <?php set_input_error_success("Form", $errors);?>">
        <label><span class="required-field">*&nbsp;</span>Form:</label>
        <select name="Form" class="form-control">
          <?php add_options_from_array($arrayforms, isset($Form) ? $Form : "")?>
        </select>
      </div>   

      <div class="form-group form-width  <?php set_input_error_success("Activesubstance", $errors);?>">
        <label><span class="required-field">*&nbsp;</span>Active substance:</label>
        <?php create_input("text", "form-control", "Activesubstance", "Set active substance", $arrayregex['Activesubstance'], $arrayinputerrormessages["Activesubstance"], isset($Activesubstance) ? $Activesubstance : "", "true", $errors, $arrayerrormessages, "");?>
      </div>
      <div class="form-group form-width <?php set_input_error_success("Sideeffect", $errors);?>">
        <label><span class="required-field">*&nbsp;</span>Side effect:</label>
        <?php create_input("text", "form-control", "Sideeffect", "Set side effect", $arrayregex['Sideeffect'], $arrayinputerrormessages["Sideeffect"], isset($Sideeffect) ? $Sideeffect : "", "true", $errors, $arrayerrormessages, "list=\"medsubs\"");?>
        <datalist id="medsubs">
            <?php add_options_from_array($arraysideeffects, isset($Sideeffect) ? $Sideeffect : "")?>
        </datalist>
      </div>
    
 
      <button type="submit" name="add-medication" class="btn btn-default" style="margin-top:20px;">Submit</button>
      </div>
  </form>
  </div>
</body>
</html>
