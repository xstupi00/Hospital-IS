<div class="form-group">
    <label>Username:</label>
    <?php  create_input("text", "form-control", "Username", "Set Username", $arrayregex['Username'], $arrayinputerrormessages["Username"], isset($Username) ? $Username : "", "true", $errors, $arrayerrormessages, "readonly");  ?>
</div>
<div class="form-group">
    <label>Email:</label>
    <?php  create_input("email", "form-control", "Email", "Set Email", $arrayregex['Email'], $arrayinputerrormessages["Email"], isset($Email) ? $Email : "", "true", $errors, $arrayerrormessages, "");  ?>
</div>