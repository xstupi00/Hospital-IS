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
  <h2 >Add new doctor</h2>
  <form class="margin-bottom" method="post" action="add-doctor.php">
    <?php include('form-person.php'); ?>
    <?php include('form-user.php'); ?>

    <div class="section-caption">
      <h4 >Doctor information</h4>
    </div>
    <div class="container">
      <div class="form-group form-width <?php set_input_error_success("Specialization", $errors);?>">
        <label for="Specialization"><span class="required-field">*&nbsp;</span>Specialization:</label>
        <select name="Specialization" class="form-control">
          <?php add_options_from_array($arrayspecializations, isset($Specialization) ? $Specialization : "")?>
        </select>
      </div>
      <div class="form-group form-width <?php set_input_error_success("Degree", $errors);?>">
        <label for="Degree"><span class="required-field">*&nbsp;</span>Degree:</label>
        <select name="Degree" class="form-control">
           <?php add_options_from_array($arraydoctordegrees, isset($Degree) ? $Degree : "")?>
        </select>
      </div>
      <button type="submit" name="add-doctor" class="btn btn-default" style="margin-top:20px;">Submit</button>
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
