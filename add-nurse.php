<?php include('server.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>TS Clinic IS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include('add-scripts-and-css.php');?>
</head>
<body>
 <?php include('nav-bar.php');?>

 <div class="container">
  <h2 >Add new nurse</h2>
  <form class="margin-bottom" method="post" action="add-nurse.php">
    <?php include('form-person.php'); ?>
    <?php include('form-user.php'); ?>

    <?php
       $departments=array();
      $depname = $dbconn->prepare("SELECT Name FROM Department");
      if($depname->execute())
      {
        while ($row = $depname->fetch(PDO::FETCH_ASSOC)) 
        {
          $departments[] = $row['Name'];
        }
      }

    ?>

    <div class="section-caption">
      <h4 >Nurse information</h4>
    </div>
    <div class="container">
      <div class="form-group form-width <?php set_input_error_success("Department", $errors);?>">
        <label><span class="required-field">*&nbsp;</span>Department:</label>
        <select class="form-control" id="Department" name="Department">
        <?php add_options_from_array($departments, isset($Department) ? $Department : "")?>
        </select>
      </div>
      <div class="form-group form-width <?php set_input_error_success("Competence", $errors);?>">
        <label for="Competence"><span class="required-field">*&nbsp;</span>Competence:</label>
        <select name="Competence" id="Competence" class="form-control">
          <?php add_options_from_array($arraycompetences, isset($Competence) ? $Competence : "")?>
        </select>
      </div>
      <div class="form-group form-width <?php set_input_error_success("Degree", $errors);?>">
        <label for="Degree"><span class="required-field">*&nbsp;</span>Degree:</label>
        <select name="Degree" id="Degree" class="form-control">
           <?php add_options_from_array($arraynursedegrees, isset($Degree) ? $Degree : "")?>
        </select>
      </div>


      <button type="submit" name="add-nurse" class="btn btn-default" style="margin-top:20px;">Submit</button>
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
</script>
