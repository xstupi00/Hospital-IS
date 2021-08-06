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
  <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>
 <?php include('nav-bar.php');?>

 <div class="container">
  <h2 >Add new patient</h2>
  <form class="margin-bottom" method="post" action="add-patient.php">
    <?php include('form-person.php'); ?>
    <div class="section-caption">
      <h4 >Patient information</h4>
    </div>
    <div class="container">

      <div class="form-group form-width  <?php set_input_error_success("Weight", $errors);?>">
        <label for="Weight"><span class="required-field">*&nbsp;</span>Weight:</label>
        <?php  create_input("text", "form-control", "Weight", "Set Weight in kg", $arrayregex['Weight'], $arrayinputerrormessages["Weight"], isset($Weight) ? $Weight : "", "true", $errors, $arrayerrormessages, "");  ?>
      </div>

      <div class="form-group form-width  <?php set_input_error_success("Height", $errors);?>">
        <label for="Height"><span class="required-field">*&nbsp;</span>Height:</label>
        <?php  create_input("text", "form-control", "Height", "Set Height in cm", $arrayregex['Height'], $arrayinputerrormessages["Height"], isset($Height) ? $Height : "", "true", $errors, $arrayerrormessages, "");  ?>
      </div>

    <div class="form-group form-width  <?php set_input_error_success("Healthcondition", $errors);?>">
        <label for="Healthcondition"><span class="required-field">*&nbsp;</span>Health condition:</label>
        <?php create_input("text", "form-control", "Healthcondition", "Set Health condition as string", $arrayregex['Healthcondition'], $arrayinputerrormessages["Healthcondition"], isset($Healthcondition) ? $Healthcondition : "", "true", $errors, $arrayerrormessages, "");?>
      </div>

      <div class="form-group form-width  <?php set_input_error_success("Dateofregistration", $errors);?>">
        <label for="Dateofregistration"><span class="required-field">*&nbsp;</span>Date of registration:</label>
        <?php create_input("text", "form-control", "Dateofregistration", "Set date in format 01/01/2018 (dd/mm/yyyy)", $arrayregex['Dateofregistration'], $arrayinputerrormessages["Dateofregistration"], isset($Dateofregistration) ? $Dateofregistration : "", "false", $errors, $arrayerrormessages, "readonly");  ?>
      </div>

   </div>
      <button type="submit" name="add-patient" class="btn btn-default" style="margin-top:20px;">Submit</button>
    </div>
  </div>
  </form>

</body>
</html>
<script>
  $("#Dateofbirth").datepicker({
    dateFormat : 'dd/mm/yy',
    changeMonth : true,
    changeYear : true,
    yearRange: '-100y:c+nn',
    maxDate: '0d'
  });

  $("#Dateofregistration").datepicker({
    dateFormat : 'dd/mm/yy',
    changeMonth : true,
    changeYear : true,
    maxDate: '+0d',
    minDate: '+0d'
  });

  var today = new Date();
  var dd = today.getDate();
  var mm = today.getMonth() + 1; //January is 0!
  var yyyy = today.getFullYear();
  if (dd < 10) {
    dd = '0' + dd;
  } 
  if (mm < 10) {
    mm = '0' + mm;
  } 
  var today = dd + '/' + mm + '/' + yyyy;
  $( "#Dateofregistration" ).datepicker("setDate", today);
</script>

