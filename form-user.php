<div class="section-caption">
  <h4 >User information</h4>
</div>
<div class="container">
  <div class="form-group form-width <?php set_input_error_success("Username", $errors);?>">
    <label for="Username"><span class="required-field ">*&nbsp;</span>Username:</label>
    <?php  create_input("Username", "form-control", "Username", "Enter Username", $arrayregex['Username'], $arrayinputerrormessages["Username"], isset($Username) ? $Username : "", "true", $errors, $arrayerrormessages, "");  ?>
  </div>
  <div class="form-group form-width <?php set_input_error_success("Email", $errors);?>">
    <label for="Email"><span class="required-field ">*&nbsp;</span>Email:</label>
    <input type="Email" class="form-control" name="Email" placeholder="Enter Email" value="<?php if ( isset($Email) ) echo $Email; ?>" required>
  </div>
  <div class="form-group form-width <?php set_input_error_success("Pwd1", $errors);?>">
    <label for="Pwd1 "><span class="required-field">*&nbsp;</span>Password:</label>
    <?php  create_input("password", "form-control", "Pwd1", "Enter password", $arrayregex['Password'], $arrayinputerrormessages["Password"], "", "true", $errors, $arrayerrormessages, "");  ?>
  </div>
  <div class="form-group form-width <?php set_input_error_success("Pwd1", $errors);?>">
    <label for="Pwd2"><span class="required-field">*&nbsp;</span>Confirm password:</label>
    <input type="password" class="form-control" name="Pwd2" placeholder="Enter password to confirm" required>
  </div>
</div>