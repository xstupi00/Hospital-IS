<?php
$stmt = $dbconn->prepare("SELECT * FROM Medication");

$meds = array();
  if ($stmt->execute()) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $medid = $row['Medication_ID'];
          $meds[$medid]['Medication_ID'] = $row['Medication_ID'];
          $meds[$medid]['Name'] = $row['Name'];
          $meds[$medid]['Maximaldose'] = $row['Maximal dose'];
          $meds[$medid]['Form'] = $row['Form'];
          $meds[$medid]['Activesubstance'] = $row['Active substance'];
          $meds[$medid]['Sideeffect'] = $row['Side effect'];
      }
  }
 ?>

<div class="container" style="margin-top: 10px; padding-right: 200px; padding-left: 200px;">
  <div class="btn-group btn-group-justified">
    <a href="#" role="button" class="btn btn-info setfilter" id="setFilter">Set filter</a>
    <a href="index.php?search=3" role="button" class="btn btn-info setfilter" id="unsetFilter">Unset filter</a>
  </div>
</div>


<div style="margin: 10px;">
  <div class="table-responsive">
    <table class="table-primary datatable">
      <thead>    
      <tr class="header">
        <?php
          echo "<th>Medication name</th>";
          echo "<th>Maximal dose</th>";
          echo "<th>Form</th>";
          echo "<th>Active substance</th>";
          echo "<th>Side effect</th>";

          if(isset($_SESSION['usertype']) && $_SESSION['usertype'] == "A"){
            echo "<th>Edit</th>";
            echo "<th>Delete</th>";
          }
          echo "</tr>";
      echo"</thead>";

      echo"<tbody>";        
        foreach ($meds as $medid => $meddata) {
         echo "<tr>";       
        echo "<td>".$meddata['Name']."</td>";
        echo "<td>".$meddata['Maximaldose']."</td>";
        echo "<td>".$meddata['Form']."</td>";
        echo "<td>".$meddata['Activesubstance']."</td>";
        echo "<td>".$meddata['Sideeffect']."</td>";
          $med_id = $meddata['Medication_ID'];

          if(isset($_SESSION['usertype']) && $_SESSION['usertype'] == "A"){

            echo "<td><a href=\"#\" onclick=\"transferPhpArray($med_id, 'Medication')\" role=\"button\" data-toggle=\"modal\" data-id=\"1\" data-target=\"#editMedModal\" class=\"btn btn-info \"><span class=\"glyphicon glyphicon-edit\"></span></td>";
            echo "<td><a href=\"#\" onclick=\"transferPhpArray($med_id, 'Medication')\" role=\"button\" data-toggle=\"modal\" data-target=\"#deleteMedModal\" class=\"btn btn-danger \"><span class=\"glyphicon glyphicon-trash\"></span></td>";
          }
          
        }
          ?>
        </tr>
      </tbody>
    </table>
  </div>
</div>

<?create_unsuccessful_delete_modal("medDel", "3", "The medication record you want to delete can't be deleted because of its assignment in administration of medications. Sorry.")?>

  <div class="modal fade" id="editMedModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit medication</h4>
        </div>
        <div class="modal-body">
      <form method="post" action="index.php?search=3">
      <div class="form-row ">
          <div class="form-group col-md-6" style="padding-left: 0px">
          <label>Medication Name:</label>
          <?php create_input("text", "form-control", "Name", "Enter Name", $arrayregex['Name'], $arrayinputerrormessages["Name"], isset($Name) ? $Name : "", "true", $errors, $arrayerrormessages, "readonly");?>
        </div>
        <div class="form-group col-md-6 form-width" style="padding-right: 0px">
          <label>Maximal dose:</label>
          <?php create_input("text", "form-control", "Maximaldose", "Enter maximal dose", $arrayregex['PosNum'], $arrayinputerrormessages["PosNum"], isset($Maximaldose) ? $Maximaldose : "", "true", $errors, $arrayerrormessages, "");?>
        </div>
      </div>

      <div class="form-group">
        <label>Form:</label>
        <select id="Form" name="Form" class="form-control">
          <?php add_options_from_array($arrayforms, "");?>
        </select>
      </div>
      <div class="form-group">
          <label>Active substance:</label>
          <?php create_input("text", "form-control", "Activesubstance", "Enter active substance", $arrayregex['Activesubstance'], $arrayinputerrormessages["Activesubstance"], isset($Activesubstance) ? $Activesubstance : "", "true", $errors, $arrayerrormessages, "");?>
      </div>
      <div class="form-group">
          <label>Side effect:</label>
          <?php create_input("text", "form-control", "Sideeffect", "Set side effect", $arrayregex['Sideeffect'], $arrayinputerrormessages["Sideeffect"], isset($Sideeffect) ? $Sideeffect : "", "true", $errors, $arrayerrormessages, "list=\"medsubs\"");?>
          <datalist id="medsubs">
              <?php add_options_from_array($arraysideeffects, isset($Sideeffect) ? $Sideeffect : "")?>
          </datalist>
      </div>
      <div class="form-group">
          <input class="hidden" name="Medication_ID">
      </div>
      <button type="submit" name="edit-medication" class="btn btn-primary">Save changes</button>
      </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="deleteMedModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete medication</h4>
        </div>
        <div class="modal-body">
          <p class="modal-delete">Do you really want to delete medication record?</p>
          <form method="post" action="index.php?search=3">
            <div class="form-group">
              <input class="hidden" name="Medication_ID_Delete">
            </div>
            <button type="submit" name="delete-medication" class="btn btn-danger">Confirm</button>
          </form>
              
        </div>
        <div class="modal-footer">
          
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>