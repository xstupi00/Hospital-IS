<?php

$stmt = $dbconn->prepare("SELECT * FROM Person  NATURAL JOIN Patient WHERE Person.Person_ID = Patient.Patient_ID");

$patients = array();
  if ($stmt->execute()) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $patientid = $row['Patient_ID'];

          $patients[$patientid]['Person_ID'] = $row['Person_ID'];
          $patients[$patientid]['Name'] = $row['Name'];
          $patients[$patientid]['Surname'] = $row['Surname'];
          $patients[$patientid]['Dateofbirth'] = $row['Date of birth'];
          $patients[$patientid]['Sex'] = $row['Sex'];
          $patients[$patientid]['IDnumber'] = $row['ID number'];
          $patients[$patientid]['Country'] = $row['Country'];
          $patients[$patientid]['City'] = $row['City'];
          $patients[$patientid]['Street'] = $row['Street'];
          $patients[$patientid]['Zip'] = $row['Zip'];
          $patients[$patientid]['Weight'] = $row['Weight'];
          $patients[$patientid]['Height'] = $row['Height'];
          $patients[$patientid]['Healthcondition'] = $row['Health condition'];
          $patients[$patientid]['Dateofregistration'] = $row['Date of registration'];
          $patients[$patientid]['Dateofdeath'] = $row['Date of death'];
      }
  }
 ?>

<div class="container" style="margin-top: 10px; padding-right: 200px; padding-left: 200px;">
  <div class="btn-group btn-group-justified">
    <a href="#" role="button" class="btn btn-info setfilter" id="setFilter">Set filter</a>
    <a href="index.php?search=1" role="button" class="btn btn-info setfilter" id="unsetFilter">Unset filter</a>
  </div>
</div>


<div style="margin: 10px;">
  <div class="table-responsive">
    <table class="table-primary datatable">
      <thead>  
          <tr class="header">
          <?php
            echo "<th>Full name</th>";
            echo "<th>Date of birth</th>";
            echo "<th>ID number</th>";
            echo "<th>Health condition</th>";
            echo "<th>Country</th>";
            echo "<th>Address</th>";
            echo "<th>Date of registration</th>";
            echo "<th>Date of death</th>";
            if($_SESSION['usertype'] == "D" ){
              echo "<th>Show profile</th>";
            }
            echo "<th>Edit</th>";
            echo "<th>Delete</th>";
          echo "</tr>";
      echo"</thead>";

      echo"<tbody>"; 
        foreach ($patients as $patientid => $patientdata) {
         echo "<tr>";       
        echo "<td>".$patientdata['Name']." ".$patientdata['Surname']."</td>";
        echo "<td>".$patientdata['Dateofbirth']."</td>";
        echo "<td>".$patientdata['IDnumber']."</td>";
        echo "<td>".$patientdata['Healthcondition']."</td>";
        echo "<td>".$patientdata['Country']."</td>";
        echo "<td>".$patientdata['City'].", ".$patientdata['Street'].", ".$patientdata['Zip']."</td>";
        echo "<td>".$patientdata['Dateofregistration']."</td>";
        echo "<td>".$patientdata['Dateofdeath']."</td>";

        $person_id = $patientdata['Person_ID'];

          if($_SESSION['usertype'] == "D"){
           echo "<td><a href=\"index.php?showprofile=0&patient_id=$person_id\" onclick=\"transferPhpArray($person_id, 'Patient')\" role=\"button\" class=\"btn btn-warning \"><span class=\"glyphicon glyphicon-user\"></span></td>";
          }
          echo "<td><a href=\"#\" onclick=\"transferPhpArray($person_id, 'Patient')\" role=\"button\" data-toggle=\"modal\" data-id=\"1\" data-target=\"#editPatientModal\" class=\"btn btn-info \"><span class=\"glyphicon glyphicon-edit\"></span></td>";
           echo "<td><a href=\"#\" onclick=\"transferPhpArray($person_id, 'Patient')\" role=\"button\" data-toggle=\"modal\" data-target=\"#deletePatientModal\" class=\"btn btn-danger \"><span class=\"glyphicon glyphicon-trash\"></span></td>";
          echo "</tr>";
        }
          ?>
        </tr>
      </tbody> 
    </table>
  </div>
</div>
 
<?create_unsuccessful_delete_modal("patientDel", "1", "The patient record you want to delete can't be deleted due to existence of patient hospitalization records. Sorry.")?>

  <div class="modal fade" id="editPatientModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Patient</h4>
        </div>
        <div class="modal-body">
      <form method="post" action="index.php?search=1">
            <?php include('form-person-modal.php');?>
        <div class="form-group">
            <label>Weight:</label>
            <?php  create_input("text", "form-control", "Weight", "Set Weight in cm", $arrayregex['Weight'], $arrayinputerrormessages["Weight"], isset($Weight) ? $Weight : "", "true", $errors, $arrayerrormessages, "");  ?>
        </div>
        <div class="form-group">
            <label>Height:</label>
            <?php  create_input("text", "form-control", "Height", "Set Height in cm", $arrayregex['Height'], $arrayinputerrormessages["Height"], isset($Height) ? $Height : "", "true", $errors, $arrayerrormessages, "");  ?>
        </div>
        <div class="form-group">
            <label>Health condition:</label>
            <?php create_input("text", "form-control", "Healthcondition", "Set Health condition as string", $arrayregex['Healthcondition'], $arrayinputerrormessages["Healthcondition"], isset($Healthcondition) ? $Healthcondition : "", "true", $errors, $arrayerrormessages, "");?>
        </div>
        <div class="form-group form-width">
          <label for="Dateofregistration">Date of registration:</label>
          <?php create_input("text", "form-control", "DateofregistrationUnused", "Set date in format 01/01/2018 (dd/mm/yyyy)", $arrayregex['Dateofregistration'], $arrayinputerrormessages["Dateofregistration"], isset($Dateofregistration) ? $Dateofregistration : "", "false", $errors, $arrayerrormessages, "disabled");  ?>
          <input type="text" name="Dateofregistration" id="Dateofregistration" hidden="true">
        </div>
        <div class="form-group">
            <label>Date of death:</label>
            <?php create_input("text", "form-control", "Dateofdeath", "Set date in format 01/01/2018 (dd/mm/yyyy)", $arrayregex['Dateofdeath'], $arrayinputerrormessages["Dateofdeath"], isset($Dateofdeath) ? $Dateofdeath : "", "false", $errors, $arrayerrormessages, "");  ?>
        </div>
        <div class="form-group">
            <input class="hidden" name="Person_ID">
        </div>
        <button type="submit" name="edit-patient" class="btn btn-primary">Save changes</button>
      </form>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>


  <div class="modal fade" id="deletePatientModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete Patient</h4>
        </div>
        <div class="modal-body">
          <p class="modal-delete">Do you really want to delete Patient record?</p>
          <form method="post" action="index.php?search=1">
            <div class="form-group">
              <input class="hidden" name="Person_ID_Delete">
            </div>
            <button type="submit" name="delete-patient" class="btn btn-danger">Confirm</button>
          </form>
              
        </div>
        <div class="modal-footer">
          
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>