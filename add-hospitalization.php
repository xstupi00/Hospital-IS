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


 <?php

    if(isset($_GET['patient_id'])){

      $Patient_ID = $_GET['patient_id'];

      $patientname = $dbconn->prepare("SELECT Name, Surname, Sex FROM Person NATURAL JOIN Patient WHERE Person.Person_ID = Patient.Patient_ID AND Person.Person_ID = '$Patient_ID' ");
      $patientname->execute();
      $result = $patientname->fetch(PDO::FETCH_ASSOC);

      $patientfullname = $result['Name']." ".$result['Surname']; 
      $patientsex = $result['Sex'];


      $docusername = $_SESSION['username'];

      $docidstmt = $dbconn->prepare("SELECT Person_ID FROM Person NATURAL JOIN Doctor NATURAL JOIN User WHERE Person.Person_ID = Doctor.Doctor_ID AND Person.Person_ID = User.Person_ID AND User.Username = '$docusername';");
      $docidstmt->execute();
      $result = $docidstmt->fetch(PDO::FETCH_ASSOC);
      $Doctor_ID = $result['Person_ID'];

      $departments=array();
      $depname = $dbconn->prepare("SELECT Name FROM Department");
      if($depname->execute())
      {
        while ($row = $depname->fetch(PDO::FETCH_ASSOC)) 
        {
          $departments[] = $row['Name'];
        }
      }
    }


 ?>
    <div class="card hovercard" style="margin-top: 0">
        <div class="card-background">

        </div>
        <div class="useravatar">
            <img alt="" src="<?php if($patientsex == "M") echo "images/male.png"; else echo "images/female.png"?>">
        </div>
        <div class="card-info"> <span class="card-title"><?php  echo $patientfullname;?></span>

        </div>
    </div>

 <div class="container">
  <h2 >Add new hospitalization</h2>
  <form class="margin-bottom" method="post" action="add-hospitalization.php?patient_id=<?php echo $Patient_ID;?>">
    <div class="container">

      <div class="form-group form-width">
        <label><span class="required-field">*&nbsp;</span>Department:</label>
        <select class="form-control" name="Department">
        <?php add_options_from_array($departments, "")?>
        </select>
      </div>

      <div class="form-group form-width  <?php set_input_error_success("Datehosp", $errors);?>">
        <label for="Dateofregistration"><span class="required-field">*&nbsp;</span>Date:</label>
        <?php create_input("text", "form-control", "Datehosp", "Set date in format 01/01/2018 (dd/mm/yyyy)", $arrayregex['Dateofregistration'], $arrayinputerrormessages["Dateofregistration"], isset($Datehosp) ? $Datehosp : "", "false", $errors, $arrayerrormessages, "readonly");  ?>
      </div>

      <div class="form-group form-width">
        <label><span class="required-field">*&nbsp;</span>Hospitalization record:</label>
        <textarea id="Rechosp" name="Rechosp" class="form-control inputstl" rows="10" pattern="<?echo $arrayregex['Record'];?>"required=""></textarea>
      </div>

      <div style="display: none;">
        <input type="text" name="Doctor_ID" value="<?php echo $Doctor_ID; ?>">        
      </div>
      <div style="display: none;">
        <input type="text" name="Patient_ID" value="<?php echo $Patient_ID; ?>">        
      </div>
       

      <button type="submit" name="add-hospitalization" class="btn btn-default" style="margin-top:20px;">Submit</button>
      </div>
  </form>
  </div>
</body>
</html>

<script>

  $("#Datehosp").datepicker({
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
  $( "#Datehosp" ).datepicker("setDate", today);

</script>

