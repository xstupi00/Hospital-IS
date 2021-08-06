<div class="section-caption">
      <h4>Personal information</h4>
    </div>
   <div class="container">

    <div class="form-group form-width <?php set_input_error_success("Name", $errors);?>">
      <label for="Name"><span class="required-field">*&nbsp;</span>First Name:</label>
      <?php create_input("text", "form-control", "Name", "Enter Name", $arrayregex['Name'], $arrayinputerrormessages["Name"], isset($Name) ? $Name : "", "true", $errors, $arrayerrormessages, "");?>
    </div>

    <div class="form-group form-width <?php set_input_error_success("Surname", $errors);?>">
      <label for="Surname"><span class="required-field">*&nbsp;</span>Surname:</label>
      <?php create_input("text", "form-control", "Surname", "Enter Surname", $arrayregex['Name'], $arrayinputerrormessages["Name"], isset($Surname) ? $Surname : "", "true", $errors, $arrayerrormessages, "");?>
    </div>

    <div class="form-group form-width <?php set_input_error_success("IDnumber", $errors);?>">
      <label for="IDnumber"><span class="required-field">*&nbsp;</span>ID Number:</label>
      <?php create_input("text", "form-control", "IDnumber", "Enter IDnumber", $arrayregex['IDnumber'], $arrayinputerrormessages["IDnumber"], isset($IDnumber) ? $IDnumber : "", "true", $errors, $arrayerrormessages, ""); ?>
    </div>

    <div class="form-group form-width <?php set_input_error_success("Sex", $errors);?>">
      <label><span class="required-field">*&nbsp;</span>Sex:</label>
      <select class="form-control" name="Sex">
        <?php add_options_from_array($arraysexs, isset($Sex) ? $Sex : "")?>
      </select>
    </div>

	<div class="form-group form-width <?php set_input_error_success("Dateofbirth", $errors);?>">
       	<label><span class="required-field">*&nbsp;</span>Date Of Birth</label>
        <?php create_input("text", "form-control", "Dateofbirth", "Set date in format 01/01/2018 (dd/mm/yyyy)", $arrayregex['Dateofbirth'], $arrayinputerrormessages["Dateofbirth"], isset($Dateofbirth) ? $Dateofbirth : "", "true", $errors, $arrayerrormessages, "");  ?>
    </div>

    <div class="form-row form-width">
      <div style="padding-left: 0px"; class="form-group col-sm-4  <?php set_input_error_success("Street", $errors);?>">
        <label for="Street">Street</label>
        <?php create_input("text", "form-control", "Street", "Enter Street", $arrayregex['Street'], $arrayinputerrormessages["Street"], isset($Street) ? $Street : "", "false", $errors, $arrayerrormessages, "");  ?>
      </div>

      <div class="form-group col-sm-3  <?php set_input_error_success("City", $errors);?>">
        <label for="City">City</label>
        <?php create_input("text", "form-control", "City", "Enter City", $arrayregex['Name'], $arrayinputerrormessages["Name"], isset($City) ? $City : "", "false", $errors, $arrayerrormessages, "");  ?>
      </div>

      <div class="form-group col-sm-3  <?php set_input_error_success("Country", $errors);?>" ">
        <label for="Country">Country</label>
        <select name="Country" class="form-control">
          <?php add_options_from_array($arraycountries, isset($Country) ? $Country : "")?>
        </select>
      </div>
      
      <div style="padding-right: 0px"; class="form-group col-sm-2  <?php set_input_error_success("Zip", $errors);?>">
        <label for="Zip">Zip</label>
        <?php create_input("text", "form-control", "Zip", "Enter Zip", $arrayregex['Zip'], $arrayinputerrormessages["Zip"], isset($Zip) ? $Zip : "", "false", $errors, $arrayerrormessages, "");  ?>
      </div>
    </div>
  </div>
