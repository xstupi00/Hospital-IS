<?php
if(!isset($_SESSION)){
  session_start();
}

session_timeout();

include 'dbinit.php'; 
include 'web-content.php';
include 'arrays.php';

$errors = array();



if (isset($_POST['login'])) {
  $username = htmlspecialchars($_POST['username']);
  $password = htmlspecialchars($_POST['password']);

  $stmt = $dbconn->prepare("SELECT COUNT(User_ID) FROM User WHERE Username = '$username' AND Password = '$password'");
	$stmt->execute();
	$count = $stmt->fetchColumn();


  if($count == "1"){
    $_SESSION['username'] = $username;
    $_SESSION['timestamp'] = time();

    if($username == "admin" && $_GET['user']=="0"){
      $_SESSION['success'] = "You are now logged in as an admin";
      $_SESSION['usertype'] = "A";
      header('location: index.php');
    }
    else if($username != "admin" && $_GET['user']=="1"){
      $stmt = $dbconn->prepare("SELECT COUNT(Person_ID) FROM Person NATURAL JOIN Doctor NATURAL JOIN User WHERE Person.Person_ID = Doctor.Doctor_ID AND Person.Person_ID = User.Person_ID AND User.Username = '$username';");

      $stmt->execute();
      $count = $stmt->fetchColumn();

      if($count == "1"){
        $_SESSION['success'] = "You are now logged in as an doctor";
        $_SESSION['usertype'] = "D";
      }else{
        $_SESSION['success'] = "You are now logged in as an nurse";
        $_SESSION['usertype'] = "N";
      }
      header('location: index.php');
    }
    else{
      unset($_SESSION['username']);
      array_push($errors, "Wrong username/password combination. Try again.");
    }
	}else{
    unset($_SESSION['username']);
    array_push($errors, "Wrong username/password combination. Try again.");
	}
}

if(isset($_GET['logout'])){
  unset($_SESSION['username']);
  unset($_SESSION['usertype']);
  session_unset();
  session_destroy();
  $dbconn = null; 
  header('location: index.php');
}

function session_timeout(){
  if (isset($_SESSION['timestamp'])){
      if ((time() - $_SESSION['timestamp']) > 60*60){
        unset($_SESSION['username']);
        session_unset();
        session_destroy();
        header('location: index.php');
      }
  }
}

function format_date($date){
  $new = preg_split("/-/", $date);
  if(isset($new[1]))
  {
    return $new[2]."/".$new[1]."/".$new[0];
  }
  else
  {
    return $new[0];
  }

}




if(isset($_POST['add-doctor'])){
  $Name = htmlspecialchars($_POST['Name']);
  $Surname = htmlspecialchars($_POST['Surname']);
  $IDnumber = htmlspecialchars($_POST['IDnumber']);
  $Sex = htmlspecialchars($_POST['Sex']);
  $Dateofbirth = htmlspecialchars($_POST['Dateofbirth']);
  $Street = htmlspecialchars($_POST['Street']);
  $City = htmlspecialchars($_POST['City']);
  $Country = htmlspecialchars($_POST['Country']);
  $Zip = htmlspecialchars($_POST['Zip']);
  $Username = htmlspecialchars($_POST['Username']);
  $Email = htmlspecialchars($_POST['Email']);
  $Pwd1 = htmlspecialchars($_POST['Pwd1']);
  $Pwd2 = htmlspecialchars($_POST['Pwd2']);
  $Specialization = htmlspecialchars($_POST['Specialization']);
  $Degree = htmlspecialchars($_POST['Degree']);

  $errors = array();
  $errors['errorcount'] = 0;

   $stmt = $dbconn->prepare("SELECT COUNT(Person_ID) FROM Person NATURAL JOIN User WHERE 
    Person.Person_ID = User.Person_ID AND User.Username = '$Username'");
  $stmt->execute();
  $usernamecount = $stmt->fetchColumn();


  $stmt = $dbconn->prepare("SELECT COUNT(Person_ID) FROM Person WHERE `ID number` = '$IDnumber'");
  $stmt->execute();
  $idcount = $stmt->fetchColumn();


  if($idcount > 0){
    unset($IDnumber);
    $errors['IDnumber'] = 1;
    $errors['errorcount'] += 1;
  }

  if($usernamecount > 0){
    unset($Username);
    $errors['Username'] = 1;
    $errors['errorcount'] += 1;
  }

  if($Pwd1 != $Pwd2){
    unset($Pwd1);
    $errors['Pwd1'] = 1;
    $errors['errorcount'] += 1; 
  }


  if($errors['errorcount']==0){
  
    try {
      $dbconn->beginTransaction();
      $dbconn->exec("INSERT INTO Person (Name, Surname, `Date of birth`, Sex, `ID number`, Country, City, Street, Zip)    VALUES ('$Name', '$Surname', STR_TO_DATE('$Dateofbirth', '%d/%m/%Y'), '$Sex' ,'$IDnumber', '$Country', '$City', '$Street', '$Zip')");

      $stmt = $dbconn->prepare("SELECT `Person_ID` FROM `Person` WHERE  `Person_ID` = (SELECT MAX(`Person_ID`) FROM  `Person` )");
      $stmt->execute();
      $doctorid = $stmt->fetchColumn();

      $dbconn->exec("INSERT INTO Doctor (Doctor_ID, Specialization, Degree) VALUES ('$doctorid', '$Specialization', '$Degree')");
      $dbconn->exec("INSERT INTO User (Person_ID, Username, Password, Email) VALUES ('$doctorid', '$Username', '$Pwd1', '$Email')");

      $dbconn->commit();
      header('location: index.php?search=1');
    }
    catch(PDOException $e) {
      $dbconn->rollback();
      echo "Error: " . $e->getMessage();
    }
  }
}

if(isset($_POST['delete-doctor'])){
  if(isset($_POST['Person_ID_Delete']) && isset($_POST['User_ID_Delete'])){
    $person_id = htmlspecialchars($_POST['Person_ID_Delete']);
    $user_id = htmlspecialchars($_POST['User_ID_Delete']);
    try {
      $dbconn->beginTransaction();
        $dbconn->exec("DELETE FROM User WHERE User.User_ID = '$user_id'");
        $dbconn->exec("DELETE FROM Doctor WHERE Doctor.Doctor_ID = '$person_id'");
        $dbconn->exec("DELETE FROM Person WHERE Person.Person_ID = '$person_id'");
      $dbconn->commit();
    }
    catch(PDOException $e){
      $dbconn->rollback();
      header('location: index.php?search=1&delete=1');
    }
  }
}

if(isset($_POST['edit-doctor'])){
  $Person_ID = htmlspecialchars($_POST['Person_ID']);
  $Name = htmlspecialchars($_POST['Name']);
  $Surname = htmlspecialchars($_POST['Surname']);
  $Dateofbirth = htmlspecialchars($_POST['Dateofbirth']);
  $Sex = htmlspecialchars($_POST['Sex']);
  $IDnumber = htmlspecialchars($_POST['IDnumber']);
  $Country = htmlspecialchars($_POST['Country']);
  $City = htmlspecialchars($_POST['City']);
  $Street = htmlspecialchars($_POST['Street']);
  $Zip = htmlspecialchars($_POST['Zip']);
  $Specialization = htmlspecialchars($_POST['Specialization']);
  $Degree = htmlspecialchars($_POST['Degree']);
  //$Actualstate = htmlspecialchars($_POST['Actualstate']);
  $User_ID = htmlspecialchars($_POST['User_ID']);
  $Username = htmlspecialchars($_POST['Username']);
  $Email = htmlspecialchars($_POST['Email']);

    try {
    $dbconn->beginTransaction();
        $dbconn->exec("UPDATE Person 
        SET Name = '$Name', Surname = '$Surname', `Date of birth`= STR_TO_DATE('$Dateofbirth', '%d/%m/%Y'), 
        Sex = '$Sex', `ID number` = '$IDnumber', Country = '$Country', City = '$City', Street = '$Street', Zip = '$Zip'
        WHERE Person.Person_ID = '$Person_ID'");

        $dbconn->exec("UPDATE Doctor SET Specialization = '$Specialization', Degree = '$Degree',
        `Actual state` = 'active' WHERE Doctor.Doctor_ID = '$Person_ID' ");
        $dbconn->exec("UPDATE User 
        SET Username = '$Username', Email = '$Email' WHERE User.Person_ID = '$Person_ID'");

    $dbconn->commit();
    header('location: index.php?search=1');
  }
  catch(PDOException $e) {
    $dbconn->rollback();
    echo "Error: " . $e->getMessage();
  }
}


if(isset($_POST['add-nurse'])){
  $Name = htmlspecialchars($_POST['Name']);
  $Surname = htmlspecialchars($_POST['Surname']);
  $IDnumber = htmlspecialchars($_POST['IDnumber']);
  $Sex = htmlspecialchars($_POST['Sex']);
  $Dateofbirth = htmlspecialchars($_POST['Dateofbirth']);
  $Street = htmlspecialchars($_POST['Street']);
  $City = htmlspecialchars($_POST['City']);
  $Country = htmlspecialchars($_POST['Country']);
  $Zip = (isset($_POST['Zip'])) ? $_POST['Zip'] : false;
  $Username = htmlspecialchars($_POST['Username']);
  $Email = htmlspecialchars($_POST['Email']);
  $Pwd1 = htmlspecialchars($_POST['Pwd1']);
  $Pwd2 = htmlspecialchars($_POST['Pwd2']);
  $Competence = htmlspecialchars($_POST['Competence']);
  $Degree = htmlspecialchars($_POST['Degree']);

  $Department = htmlspecialchars($_POST['Department']);
  $stmt = $dbconn->prepare("SELECT Department_ID FROM Department WHERE Department.Name = '$Department' ");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);
  $Department_ID = $result['Department_ID'];

  $errors = array();
  $errors['errorcount'] = 0;

  $stmt = $dbconn->prepare("SELECT COUNT(Person_ID) FROM Person NATURAL JOIN User WHERE 
    Person.Person_ID = User.Person_ID AND User.Username = '$Username'");
  $stmt->execute();
  $usernamecount = $stmt->fetchColumn();


  $stmt = $dbconn->prepare("SELECT COUNT(Person_ID) FROM Person WHERE `ID number` = '$IDnumber'");
  $stmt->execute();
  $idcount = $stmt->fetchColumn();


  if($idcount > 0){
    unset($IDnumber);
    $errors['IDnumber'] = 1;
    $errors['errorcount'] += 1;
  }

  if($usernamecount > 0){
    unset($Username);
    $errors['Username'] = 1;
    $errors['errorcount'] += 1;
  }

  if($Pwd1 != $Pwd2){
    unset($Pwd1);
    $errors['Pwd1'] = 1;
    $errors['errorcount'] += 1; 
  }



  if($errors['errorcount']==0){
  
    try {
      $dbconn->beginTransaction();
      $dbconn->exec("INSERT INTO Person (Name, Surname, `Date of birth`, Sex, `ID number`, Country, City, Street, Zip)    VALUES ('$Name', '$Surname', STR_TO_DATE('$Dateofbirth', '%d/%m/%Y'), '$Sex' ,'$IDnumber', '$Country', '$City', '$Street', '$Zip')");

      $stmt = $dbconn->prepare("SELECT `Person_ID` FROM `Person` WHERE  `Person_ID` = (SELECT MAX(`Person_ID`) FROM  `Person` )");
      $stmt->execute();
      $nurseid = $stmt->fetchColumn();

      $dbconn->exec("INSERT INTO Nurse (Nurse_ID, Competence, Degree, Department_ID) VALUES ('$nurseid', '$Competence', '$Degree', '$Department_ID')");
      $dbconn->exec("INSERT INTO User (Person_ID, Username, Password, Email) VALUES ('$nurseid', '$Username', '$Pwd1', '$Email')");

      $dbconn->commit();
      header('location: index.php?search=2');
    }
    catch(PDOException $e) {
      $dbconn->rollback();
      echo "Error: " . $e->getMessage();
    }
  }
}

if(isset($_POST['delete-nurse'])){
  if(isset($_POST['Person_ID_Delete']) && isset($_POST['User_ID_Delete'])){
    $person_id = htmlspecialchars($_POST['Person_ID_Delete']);
    $user_id = htmlspecialchars($_POST['User_ID_Delete']);
    try {
      $dbconn->beginTransaction();
        $dbconn->exec("DELETE FROM User WHERE User.User_ID = '$user_id'");
        $dbconn->exec("DELETE FROM Nurse WHERE Nurse.Nurse_ID = '$person_id'");
        $dbconn->exec("DELETE FROM Person WHERE Person.Person_ID = '$person_id'");
      $dbconn->commit();
      header('location: index.php?search=2');
    }
    catch(PDOException $e){
      $dbconn->rollback();
      header('location: index.php?search=2&delete=1');
    }
  }
}



if(isset($_POST['dismiss-nurse'])){
  $Person_ID = htmlspecialchars($_POST['Person_ID_Dismiss']);
  $User_ID = htmlspecialchars($_POST['User_ID_Dismiss']);
  $Actualstate = htmlspecialchars($_POST['Actualstate']);
  $Turnoutdate = htmlspecialchars($_POST['Turnoutdate']);
  $Inactive = "inactive";

  try {
    $dbconn->beginTransaction();
    $dbconn->exec("UPDATE Nurse 
        SET `Actual state`='$Inactive', `Turn out date`= STR_TO_DATE('$Turnoutdate', '%d/%m/%Y')
        WHERE Nurse.Nurse_ID = '$Person_ID'");
    $dbconn->exec("DELETE FROM User WHERE User.User_ID = '$User_ID'");
        
    $dbconn->commit();
    //echo "serus nurse";
    header('location: index.php?search=2');
  }
  catch(PDOException $e) {
    $dbconn->rollback();
    echo "Error: " . $e->getMessage();
  }
}

if(isset($_POST['dismiss-doctor'])){
  echo $Person_ID = htmlspecialchars($_POST['Person_ID_Dismiss']);
  echo $User_ID = htmlspecialchars($_POST['User_ID_Dismiss']);
  echo $Actualstate = htmlspecialchars($_POST['Actualstate']);
  echo $Turnoutdate = htmlspecialchars($_POST['Turnoutdate']);

try {
    $dbconn->beginTransaction();
    $dbconn->exec("UPDATE Doctor 
        SET `Actual state`='inactive', `Turn out date`= STR_TO_DATE('$Turnoutdate', '%d/%m/%Y')
        WHERE Doctor.Doctor_ID = '$Person_ID'");
    $dbconn->exec("DELETE FROM User WHERE User.User_ID = '$User_ID'");
        
    $dbconn->commit();
    header('location: index.php?search=1');
  }
  catch(PDOException $e) {
    $dbconn->rollback();
    echo "Error: " . $e->getMessage();
  }
}





if(isset($_POST['edit-nurse'])){
  $Person_ID = htmlspecialchars($_POST['Person_ID']);
  $Name = htmlspecialchars($_POST['Name']);
  $Surname = htmlspecialchars($_POST['Surname']);
  $Dateofbirth = htmlspecialchars($_POST['Dateofbirth']);
  $Sex = htmlspecialchars($_POST['Sex']);
  $IDnumber = htmlspecialchars($_POST['IDnumber']);
  $Country = htmlspecialchars($_POST['Country']);
  $City = htmlspecialchars($_POST['City']);
  $Street = htmlspecialchars($_POST['Street']);
  $Zip = htmlspecialchars($_POST['Zip']);
  $Competence = htmlspecialchars($_POST['Competence']);
  $Degree = htmlspecialchars($_POST['Degree']);
  $Department_ID = htmlspecialchars($_POST['Department_ID']);
  $User_ID = htmlspecialchars($_POST['User_ID']);
  $Username = htmlspecialchars($_POST['Username']);
  $Email = htmlspecialchars($_POST['Email']);

    try {
    $dbconn->beginTransaction();
        $dbconn->exec("UPDATE Person 
        SET Name = '$Name', Surname = '$Surname', `Date of birth`= STR_TO_DATE('$Dateofbirth', '%d/%m/%Y'), 
        Sex = '$Sex', `ID number` = '$IDnumber', Country = '$Country', City = '$City', Street = '$Street', Zip = '$Zip'
        WHERE Person.Person_ID = '$Person_ID'");

        $dbconn->exec("UPDATE Nurse SET Competence = '$Competence', Degree = '$Degree' WHERE Nurse.Nurse_ID = '$Person_ID' ");
        $dbconn->exec("UPDATE User 
        SET Username = '$Username', Email = '$Email' WHERE User.Person_ID = '$Person_ID'");

    $dbconn->commit();
    header('location: index.php?search=2');
  }
  catch(PDOException $e) {
    $dbconn->rollback();
    echo "Error: " . $e->getMessage();
  }
}

if(isset($_POST['add-medication'])){
  $Name = htmlspecialchars($_POST['Name']);
  $Maximaldose = htmlspecialchars($_POST['Maximaldose']);
  $Form = htmlspecialchars($_POST['Form']);
  $Activesubstance = htmlspecialchars($_POST['Activesubstance']);
  $Sideeffect = htmlspecialchars($_POST['Sideeffect']);

  $errors = array();
  $errors['errorcount'] = 0;

  $stmt = $dbconn->prepare("SELECT Name FROM Medication");
  if ($stmt->execute()) 
  { 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if(strtolower($row['Name']) == strtolower($Name)){
        unset($Name);
        $errors['Name'] = 1;
        $errors['errorcount'] += 1;
        break;
      }
    }
  }

  if($errors['errorcount']==0){
    try {
        $dbconn->beginTransaction();
        $dbconn->exec("INSERT INTO Medication (Name, `Maximal dose`, Form, `Active substance`, `Side effect`)    VALUES ('$Name', '$Maximaldose', '$Form', '$Activesubstance', '$Sideeffect')");
        $dbconn->commit();
        header('location: index.php?search=3');
      }
      catch(PDOException $e) {
        $dbconn->rollback();
        echo "Error: " . $e->getMessage();
      }
  }
}

if(isset($_POST['delete-medication'])){
  $Medication_ID = htmlspecialchars($_POST['Medication_ID_Delete']);
  try {
      $dbconn->beginTransaction();
        $dbconn->exec("DELETE FROM Medication WHERE Medication.Medication_ID = '$Medication_ID'");
      $dbconn->commit();
      header('location: index.php?search=3');
    }
    catch(PDOException $e){
      $dbconn->rollback();
      header('location: index.php?search=3&delete=1');
    }
}

if(isset($_POST['edit-medication'])){
  $Medication_ID = htmlspecialchars($_POST['Medication_ID']);
  $Name = htmlspecialchars($_POST['Name']);
  $Maximaldose = htmlspecialchars($_POST['Maximaldose']);
  $Form = htmlspecialchars($_POST['Form']);
  $Activesubstance = htmlspecialchars($_POST['Activesubstance']);
  $Sideeffect = htmlspecialchars($_POST['Sideeffect']);
  try {
      $dbconn->beginTransaction();
      $dbconn->exec("UPDATE Medication SET Name = '$Name', `Maximal dose` = '$Maximaldose', Form = '$Form', `Active substance` = '$Activesubstance', `Side effect` = '$Sideeffect' WHERE Medication.Medication_ID = '$Medication_ID'");
      $dbconn->commit();
      header('location: index.php?search=3');
    }
    catch(PDOException $e) {
      $dbconn->rollback();
      echo "Error: " . $e->getMessage();
    }
}

if(isset($_POST['add-department'])){
  $Name = htmlspecialchars($_POST['Name']);
  $Numberofbeds = htmlspecialchars($_POST['Numberofbeds']);
  $Numberofrooms = htmlspecialchars($_POST['Numberofrooms']);
  $Visittimefrom = htmlspecialchars($_POST['Visittimefrom']);
  $Visittimeto = htmlspecialchars($_POST['Visittimeto']);
  $Floor = htmlspecialchars($_POST['Floor']);

  $errors = array();
  $errors['errorcount'] = 0;

  $stmt = $dbconn->prepare("SELECT Name FROM Department");
  if ($stmt->execute()) 
  { 
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
    {
      if(strtolower($row['Name']) == strtolower($Name)){
        unset($Name);
        $errors['Name'] = 1;
        $errors['errorcount'] += 1;
        break;
      }
    }
  }

  if($Visittimefrom >= $Visittimeto){
    unset($Visittimeto);
    $errors['Visittimeto'] = 1;
    $errors['errorcount'] += 1; 
  }

  if($errors['errorcount']==0){
    try {
        $dbconn->beginTransaction();
        $dbconn->exec("INSERT INTO Department (Name, `Number of beds`, `Number of rooms`, `Visit time from`, `Visit time to`, Floor)    VALUES ('$Name', '$Numberofbeds', '$Numberofrooms', '$Visittimefrom', '$Visittimeto', '$Floor')");
        $dbconn->commit();
        header('location: index.php?search=4');
      }
      catch(PDOException $e) {
        $dbconn->rollback();
        echo "Error: " . $e->getMessage();
      }
  }
}

if(isset($_POST['delete-department'])){
  $Department_ID = htmlspecialchars($_POST['Department_ID_Delete']);
  try {
      $dbconn->beginTransaction();
        $dbconn->exec("DELETE FROM Department WHERE Department.Department_ID = '$Department_ID'");
      $dbconn->commit();
      header('location: index.php?search=4');
    }
    catch(PDOException $e){
      $dbconn->rollback();
      header('location: index.php?search=4&delete=1');
    }
}

if(isset($_POST['edit-department'])){
  $Department_ID = htmlspecialchars($_POST['Department_ID']);
  $Name = htmlspecialchars($_POST['Name']);
  $Numberofbeds = htmlspecialchars($_POST['Numberofbeds']);
  $Numberofrooms = htmlspecialchars($_POST['Numberofrooms']);
  $Visittimefrom = htmlspecialchars($_POST['Visittimefrom']);
  $Visittimeto = htmlspecialchars($_POST['Visittimeto']);
  $Floor = htmlspecialchars($_POST['Floor']);
  try {
      $dbconn->beginTransaction();
      $dbconn->exec("UPDATE Department SET Name = '$Name', `Number of beds`='$Numberofbeds', `Number of rooms`='$Numberofrooms', `Visit time from`='$Visittimefrom', `Visit time to`='$Visittimeto' WHERE Department.Department_ID = '$Department_ID'");
      $dbconn->commit();
      header('location: index.php?search=4');
    }
    catch(PDOException $e) {
      $dbconn->rollback();
      echo "Error: " . $e->getMessage();
    }
}

function create_input($type, $class, $name, $placeholder, $pattern, $errorinputmsg, $value, $required, $errors, $errmsgs, $extra){
  echo "<input type=\"$type\" class=\"$class\" id=\"$name\" name=\"$name\" placeholder=\"$placeholder\" value=\"$value\" pattern=\"$pattern\" title='$errorinputmsg' $extra ";
  if($required == "false"){
    echo ">";
  }else{
    echo "required>";
  }
  if(isset($errors[$name])){
    echo "<span class=\"help-block\">$errmsgs[$name]</span>";
    unset($errors[$name]);
  }
}

function set_input_error_success($name, $errors){
  if(isset($errors[$name])){
    echo "has-error"; 
  }
  else if(!empty($errors)){ 
    echo "has-success";
  }
}

function create_unsuccessful_delete_modal($id, $searchindex, $msg){?>
  <?if(isset($_GET['delete'])){?>
    <script>
      $(document).ready(function(){
          showDeleteMsg("#<?echo $id;?>");

          $("#<?echo $id;?>").on("hidden.bs.modal", function () {
              window.location.href = "index.php?search=<?php echo $searchindex;?>";
           
        });
    </script>
  <?}?>
  <div id="<?echo $id;?>" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete unsuccessful</h4>
      </div>
      <div class="modal-body">
          <p class="modal-delete"><? echo $msg;?></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
 
<?}

function add_options_from_array($array, $selected){
  foreach ($array as $index => $option) {
    if (!empty($selected) && $selected == $option) {
      echo "<option selected>$option</option>";
    }
    else{
      echo "<option>$option</option>";
    }
  }
}

function add_options_from_array_selected($array){
 foreach ($array as $index => $option) {
      echo "<option>$option</option>";
  }
}

if(isset($_POST['add-patient'])){
  $Name = htmlspecialchars($_POST['Name']);
  $Surname = htmlspecialchars($_POST['Surname']);
  $IDnumber = htmlspecialchars($_POST['IDnumber']);
  $Sex = htmlspecialchars($_POST['Sex']);
  $Dateofbirth = htmlspecialchars($_POST['Dateofbirth']);
  $Street = htmlspecialchars($_POST['Street']);
  $City = htmlspecialchars($_POST['City']);
  $Country = htmlspecialchars($_POST['Country']);
  $Zip = (isset($_POST['Zip'])) ? $_POST['Zip'] : false;
  $Weight = htmlspecialchars($_POST['Weight']);
  $Height = htmlspecialchars($_POST['Height']);
  $Healthcondition = htmlspecialchars($_POST['Healthcondition']);
  $Dateofregistration = htmlspecialchars($_POST['Dateofregistration']);

  $errors = array();
  $errors['errorcount'] = 0;

  $stmt = $dbconn->prepare("SELECT COUNT(Person_ID) FROM Person WHERE `ID number` = '$IDnumber'");
  $stmt->execute();
  $count = $stmt->fetchColumn();


  if($count > 0){
    unset($IDnumber);
    $errors['IDnumber'] = 1;
    $errors['errorcount'] += 1;
  }


  if($errors['errorcount']==0){
  
    try {
      $dbconn->beginTransaction();
      $dbconn->exec("INSERT INTO Person (Name, Surname, `Date of birth`, Sex, `ID number`, Country, City, Street, Zip)    VALUES ('$Name', '$Surname', STR_TO_DATE('$Dateofbirth', '%d/%m/%Y'), '$Sex' ,'$IDnumber', '$Country', '$City', '$Street', '$Zip')");

      $stmt = $dbconn->prepare("SELECT `Person_ID` FROM `Person` WHERE  `Person_ID` = (SELECT MAX(`Person_ID`) FROM  `Person` )");
      $stmt->execute();
      $patientid = $stmt->fetchColumn();

      $dbconn->exec("INSERT INTO Patient (Patient_ID, Weight, Height, `Health condition`, `Date of registration`, `Date of death`) VALUES ('$patientid', '$Weight', '$Height', '$Healthcondition', STR_TO_DATE('$Dateofregistration', '%d/%m/%Y'), NULL)");
    
      $dbconn->commit();
      header('location: index.php?search=1');
    }
    catch(PDOException $e) {
      $dbconn->rollback();
      echo "Error: " . $e->getMessage();
    }
  }
}

if(isset($_POST['delete-patient'])){
  if(isset($_POST['Person_ID_Delete'])){
    $person_id = htmlspecialchars($_POST['Person_ID_Delete']);

    try {
      $dbconn->beginTransaction();
        $dbconn->exec("DELETE FROM Patient WHERE Patient.Patient_ID = '$person_id'");
        $dbconn->exec("DELETE FROM Person WHERE Person.Person_ID = '$person_id'");
      $dbconn->commit();
    }
    catch(PDOException $e){
      $dbconn->rollback();
      header('location: index.php?search=1&delete=1');

    }
  }
}


if(isset($_POST['edit-patient'])){
  $Person_ID = htmlspecialchars($_POST['Person_ID']);
  $Name = htmlspecialchars($_POST['Name']);
  $Surname = htmlspecialchars($_POST['Surname']);
  $IDnumber = htmlspecialchars($_POST['IDnumber']);
  $Sex = htmlspecialchars($_POST['Sex']);
  $Dateofbirth = htmlspecialchars($_POST['Dateofbirth']);
  $Street = htmlspecialchars($_POST['Street']);
  $City = htmlspecialchars($_POST['City']);
  $Country = htmlspecialchars($_POST['Country']);
  $Zip = (isset($_POST['Zip'])) ? $_POST['Zip'] : NULL;
  $Weight = htmlspecialchars($_POST['Weight']);
  $Height = htmlspecialchars($_POST['Height']);
  $Healthcondition = htmlspecialchars($_POST['Healthcondition']);
  $Dateofregistration = htmlspecialchars($_POST['Dateofregistration']);
  $Dateofdeath = htmlspecialchars($_POST['Dateofdeath']);

   try {
    $dbconn->beginTransaction();
        $dbconn->exec("UPDATE Person 
        SET Name = '$Name', Surname = '$Surname', `Date of birth`= STR_TO_DATE('$Dateofbirth', '%d/%m/%Y'), 
        Sex = '$Sex', `ID number` = '$IDnumber', Country = '$Country', City = '$City', Street = '$Street', Zip = '$Zip'
        WHERE Person.Person_ID = '$Person_ID'");

        if(empty($Dateofdeath)){
          $dbconn->exec("UPDATE Patient SET Weight = '$Weight', Height = '$Height',
        `Health condition` = '$Healthcondition', `Date of registration`= STR_TO_DATE('$Dateofregistration', '%d/%m/%Y'), `Date of death`= NULL  WHERE Patient.Patient_ID = '$Person_ID' ");
        }else{
          $dbconn->exec("UPDATE Patient SET Weight = '$Weight', Height = '$Height',
        `Health condition` = '$Healthcondition', `Date of registration`= STR_TO_DATE('$Dateofregistration', '%d/%m/%Y'), `Date of death`= STR_TO_DATE('$Dateofdeath', '%d/%m/%Y')  WHERE Patient.Patient_ID = '$Person_ID' ");
         
        }

    $dbconn->commit();
    header('location: index.php?search=1');
  }
  catch(PDOException $e) {
    $dbconn->rollback();
    echo "Error: " . $e->getMessage();
  }
}


if(isset($_POST['add-hospitalization'])){
  $Department = htmlspecialchars($_POST['Department']);
  $stmt = $dbconn->prepare("SELECT Department_ID FROM Department WHERE Department.Name = '$Department' ");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  $Doctor_ID = htmlspecialchars($_POST['Doctor_ID']);
  $Department_ID = $result['Department_ID'];
  $Patient_ID = htmlspecialchars($_POST['Patient_ID']);
  $Datehosp = htmlspecialchars($_POST['Datehosp']);
  $Rechosp = htmlspecialchars($_POST['Rechosp']);


  try {
      $dbconn->beginTransaction();
      $dbconn->exec("INSERT INTO Hospitalization (Doctor_ID, Department_ID, Patient_ID, `Date`, `Hospitalization record`)    VALUES ('$Doctor_ID', '$Department_ID', '$Patient_ID', STR_TO_DATE('$Datehosp', '%d/%m/%Y'), '$Rechosp')");
      $dbconn->commit();
      header("location: index.php?showprofile=0&patient_id=$Patient_ID#tab2");
    }
    catch(PDOException $e) {
      $dbconn->rollback();
      echo "Error: " . $e->getMessage();
    }
}

if(isset($_POST['add-examination'])){
  $Department = htmlspecialchars($_POST['Department']);
  $stmt = $dbconn->prepare("SELECT Department_ID FROM Department WHERE Department.Name = '$Department' ");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  $Doctor_ID = htmlspecialchars($_POST['Doctor_ID']);
  $Department_ID = $result['Department_ID'];
  $Patient_ID = htmlspecialchars($_POST['Patient_ID']);
  $Hospitalization_ID = htmlspecialchars($_POST['Hospitalization_ID']);
  $Type = htmlspecialchars($_POST['Type']);
  $Dateexam = htmlspecialchars($_POST['Dateexam']);
  $Recexam = htmlspecialchars($_POST['Recexam']);


  try {
      $dbconn->beginTransaction();
      $dbconn->exec("INSERT INTO Examination (Doctor_ID, Department_ID, Hospitalization_ID, Type,`Date`, `Medical record`)    VALUES ('$Doctor_ID', '$Department_ID', '$Hospitalization_ID', '$Type' ,STR_TO_DATE('$Dateexam', '%d/%m/%Y'), '$Recexam')");
      $dbconn->commit();
      header("location: index.php?showprofile=0&patient_id=$Patient_ID#tab3");
    }
    catch(PDOException $e) {
      $dbconn->rollback();
      echo "Error: " . $e->getMessage();
    }
}

if(isset($_POST['add-admofmeds'])){
  $Medication = htmlspecialchars($_POST['Medication']);
  $stmt = $dbconn->prepare("SELECT Medication_ID FROM Medication WHERE Medication.Name = '$Medication' ");
  $stmt->execute();
  $result = $stmt->fetch(PDO::FETCH_ASSOC);

  $Doctor_ID = htmlspecialchars($_POST['Doctor_ID']);
  $Medication_ID = $result['Medication_ID'];
  $Patient_ID = htmlspecialchars($_POST['Patient_ID']);
  $Hospitalization_ID = htmlspecialchars($_POST['Hospitalization_ID']);
  $Dateadm = htmlspecialchars($_POST['Dateadm']);
  $Procedure = htmlspecialchars($_POST['Procedure']);
  $Frequency = htmlspecialchars($_POST['Frequency']);
  $Wayofuse = htmlspecialchars($_POST['Wayofuse']);

  try {
      $dbconn->beginTransaction();

      $dbconn->exec("INSERT INTO Administration_Of_Medication (Doctor_ID, Medication_ID, Hospitalization_ID, `Procedure`, `Date`, Frequency, `Way of use`)    VALUES ('$Doctor_ID', '$Medication_ID', '$Hospitalization_ID', '$Procedure' , STR_TO_DATE('$Dateadm', '%d/%m/%Y'), '$Frequency', '$Wayofuse')");

      $dbconn->commit();
      header("location: index.php?showprofile=0&patient_id=$Patient_ID#tab4");
    }
    catch(PDOException $e) {
      $dbconn->rollback();
      echo "Error: " . $e->getMessage();
    }
}

?>
