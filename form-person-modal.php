        <div class="form-row ">
            <div class="form-group col-md-6" style="padding-left: 0px">
            <label>First Name:</label>
            <?php create_input("text", "form-control", "Name", "Enter Name", $arrayregex['Name'], $arrayinputerrormessages["Name"], isset($Name) ? $Name : "", "true", $errors, $arrayerrormessages, "");?>
          </div>
          <div class="form-group col-md-6 form-width" style="padding-right: 0px">
            <label>Surname:</label>
             <?php create_input("text", "form-control", "Surname", "Enter Surname", $arrayregex['Name'], $arrayinputerrormessages['Name'], isset($Surname) ? $Surname : "", "false", $errors, $arrayerrormessages, "");?>
          </div>
        </div>
        <div class="form-group">
            <label>Date of birth:</label>
            <?php create_input("text", "form-control", "Dateofbirth", "Set date in format 01/01/2018 (dd/mm/yyyy)", $arrayregex['Dateofbirth'], $arrayinputerrormessages["Dateofbirth"], isset($Dateofbirth) ? $Dateofbirth : "", "false", $errors, $arrayerrormessages, "");  ?>
        </div>
        <div class="form-group">
            <label>ID number:</label>
            <?php create_input("text", "form-control", "IDnumber", "Enter IDnumber", $arrayregex['IDnumber'], $arrayinputerrormessages["IDnumber"], isset($IDnumber) ? $IDnumber : "", "true", $errors, $arrayerrormessages, "readonly"); ?>
        </div>
        <div class="form-group form-width">
          <label>Sex:</label>
          <select id="Sex" name="Sex" class="form-control">
             <?php add_options_from_array($arraysexs, "");?>
          </select>
        </div>
        <div class="form-row form-width">
        <div class="form-group form-padding col-sm-4" style="padding-left: 0px;">
          <label>Street</label>
          <?php create_input("text", "form-control", "Street", "Enter Street", $arrayregex['Street'], $arrayinputerrormessages["Street"], isset($Street) ? $Street : "", "false", $errors, $arrayerrormessages, "");  ?>
        </div>
        <div class="form-group col-sm-3" style="padding-left: 0px;">
          <label>City</label>
          <?php create_input("text", "form-control", "City", "Enter City", $arrayregex['City'], $arrayinputerrormessages["City"], isset($City) ? $City : "", "false", $errors, $arrayerrormessages, "");  ?>
        </div>
        <div class="form-group col-sm-3" style="padding-left: 0px; padding-right: 0px;">
          <label>Country</label>
          <select id="Country" name="Country" class="form-control">
            <?php add_options_from_array($arraycountries, "");?>
          </select>
        </div>
        <div class="form-group form-padding col-sm-2" style="padding-right: 0px;" >
          <label>Zip</label>
          <?php create_input("text", "form-control", "Zip", "Enter Zip", $arrayregex['Zip'], $arrayinputerrormessages["Zip"], isset($Zip) ? $Zip : "", "false", $errors, $arrayerrormessages, "");  ?>
        </div>
      </div>