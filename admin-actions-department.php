<?php
$stmt = $dbconn->prepare("SELECT * FROM Department");

$deps = array();
  if ($stmt->execute()) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $depid = $row['Department_ID'];
          $deps[$depid]['Department_ID'] = $row['Department_ID'];
          $deps[$depid]['Name'] = $row['Name'];
          $deps[$depid]['Numberofbeds'] = $row['Number of beds'];
          $deps[$depid]['Numberofrooms'] = $row['Number of rooms'];
          $deps[$depid]['Visittimefrom'] = $row['Visit time from'];
          $deps[$depid]['Visittimeto'] = $row['Visit time to'];
          $deps[$depid]['Floor'] = $row['Floor'];
      }
  }
 ?>

<div class="container" style="margin-top: 10px; padding-right: 200px; padding-left: 200px;">
  <div class="btn-group btn-group-justified">
    <a href="#" role="button" class="btn btn-info setfilter" id="setFilter">Set filter</a>
    <a href="index.php?search=4" role="button" class="btn btn-info setfilter" id="unsetFilter">Unset filter</a>
  </div>
</div>


<div style="margin: 10px;">
  <div class="table-responsive">
    <table class="table-primary datatable">
      <thead>    
        <tr class="header">
          <?php
            echo "<th>Department name</th>";
            echo "<th>Number of beds</th>";
            echo "<th>Number of rooms</th>";
            echo "<th>Visit time</th>";
            echo "<th>Floor</th>";
            if(isset($_SESSION['usertype']) && $_SESSION['usertype'] == "A"){
              echo "<th>Edit</th>";
              echo "<th>Delete</th>";
            }
            echo "</tr>";
      echo"</thead>";

      echo"<tbody>";
        foreach ($deps as $depid => $depdata) 
        {
           echo "<tr>";       
          echo "<td>".$depdata['Name']."</td>";
          echo "<td>".$depdata['Numberofbeds']."</td>";
          echo "<td>".$depdata['Numberofrooms']."</td>";
          echo "<td>".$depdata['Visittimefrom']." - ".$depdata['Visittimeto']."</td>";
          echo "<td>".$depdata['Floor']."</td>";
            $med_id = $depdata['Department_ID'];

            if(isset($_SESSION['usertype']) && $_SESSION['usertype'] == "A"){
              echo "<td><a href=\"#\" onclick=\"transferPhpArray($med_id, 'Department')\" role=\"button\" data-toggle=\"modal\" data-id=\"1\" data-target=\"#editDepModal\" class=\"btn btn-info \"><span class=\"glyphicon glyphicon-edit\"></span></td>";
              echo "<td><a href=\"#\" onclick=\"transferPhpArray($med_id, 'Department')\" role=\"button\" data-toggle=\"modal\" data-target=\"#deleteDepModal\" class=\"btn btn-danger \"><span class=\"glyphicon glyphicon-trash\"></span></td>";
            }
            echo "</tr>";
        }
        ?>
          </tr>
      </tbody>
    </table>
  </div>
</div>


  <?create_unsuccessful_delete_modal("depDel", "4", "The department record you want to delete can't be deleted because of its assignment in hospitalization or examination record. Sorry.")?>


  <div class="modal fade" id="editDepModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit Department</h4>
        </div>
        <div class="modal-body">
      <form method="post" action="index.php?search=4">
     <div class="form-group form-width <?php set_input_error_success("Name", $errors);?>">
        <label><span class="required-field">*&nbsp;</span>Department name:</label>
        <?php create_input("text", "form-control", "Name", "Enter Name", $arrayregex['Name'], $arrayinputerrormessages["Name"], isset($Name) ? $Name : "", "true", $errors, $arrayerrormessages, "readonly");?>
      </div>

      <div class="form-row form-width">
        <div class="form-group col-md-6 <?php set_input_error_success("Numberofrooms", $errors);?>" style="padding-left: 0;">
          <label><span class="required-field">*&nbsp;</span>Number of rooms:</label>
          <?php create_input("text", "form-control", "Numberofrooms", "Enter number of rooms", $arrayregex['PosNum'], $arrayinputerrormessages["PosNum"], isset($Numberofrooms) ? $Numberofrooms : "", "true", $errors, $arrayerrormessages, "");?>
        </div>
        <div class="form-group col-md-6 <?php set_input_error_success("Numberofbeds", $errors);?>" style="padding-right: 0;">
          <label><span class="required-field">*&nbsp;</span>Number of beds:</label>
          <?php create_input("text", "form-control", "Numberofbeds", "Enter number of beds", $arrayregex['PosNum'], $arrayinputerrormessages["PosNum"], isset($Numberofbeds) ? $Numberofbeds : "", "true", $errors, $arrayerrormessages, "");?>
        </div>
      </div>

      <div class="form-row form-width">
        <div class="form-group col-md-6 <?php set_input_error_success("Visittimefrom", $errors);?>" style="padding-left: 0;">
          <label><span class="required-field">*&nbsp;</span>Visit time from:</label>
          <?php create_input("text", "form-control", "Visittimefrom", "Enter visit time from", $arrayregex['Visittime'], $arrayinputerrormessages["Visittime"], isset($Visittimefrom) ? $Visittimefrom : "", "true", $errors, $arrayerrormessages, "");?>
        </div>
        <div class="form-group col-md-6 <?php set_input_error_success("Visittimeto", $errors);?>" style="padding-right: 0;">
          <label><span class="required-field">*&nbsp;</span>Visit time to:</label>
          <?php create_input("text", "form-control", "Visittimeto", "Enter visit time to", $arrayregex['Visittime'], $arrayinputerrormessages["Visittime"], isset($Visittimeto) ? $Visittimeto : "", "true", $errors, $arrayerrormessages, "");?>
        </div>
      </div>

      <div class="form-group form-width <?php set_input_error_success("Floor", $errors);?>">
        <label><span class="required-field">*&nbsp;</span>Floor:</label>
        <select name="Floor" class="form-control">
          <?php add_options_from_array($arrayfloors, isset($Floor) ? $Floor : "")?>
        </select>
      </div>
      <div class="form-group">
              <input class="hidden" name="Department_ID">
            </div>
      <button type="submit" name="edit-department" class="btn btn-primary">Save changes</button>
      </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="deleteDepModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete department</h4>
        </div>
        <div class="modal-body">
          <p class="modal-delete">Do you really want to delete department record?</p>
          <form method="post" action="index.php?search=4">
            <div class="form-group">
              <input class="hidden" name="Department_ID_Delete">
            </div>
            <button type="submit" name="delete-department" class="btn btn-danger">Confirm</button>
          </form>
              
        </div>
        <div class="modal-footer">
          
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>