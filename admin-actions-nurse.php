<?php
$stmt = $dbconn->prepare("SELECT * FROM Person  NATURAL JOIN Nurse WHERE Person.Person_ID = Nurse.Nurse_ID");

$nurses = array();
  if ($stmt->execute()) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $nurseid = $row['Nurse_ID'];

          $nurses[$nurseid]['Person_ID'] = $row['Person_ID'];
          $nurses[$nurseid]['Name'] = $row['Name'];
          $nurses[$nurseid]['Surname'] = $row['Surname'];
          $nurses[$nurseid]['Dateofbirth'] = $row['Date of birth'];
          $nurses[$nurseid]['Sex'] = $row['Sex'];
          $nurses[$nurseid]['IDnumber'] = $row['ID number'];
          $nurses[$nurseid]['Country'] = $row['Country'];
          $nurses[$nurseid]['City'] = $row['City'];
          $nurses[$nurseid]['Street'] = $row['Street'];
          $nurses[$nurseid]['Zip'] = $row['Zip'];
          $nurses[$nurseid]['Competence'] = $row['Competence'];

          $nurses[$nurseid]['Department_ID'] = $row['Department_ID'];

          $depid = $row['Department_ID'];
          $wtf = $dbconn->prepare("SELECT Name FROM Department WHERE Department.Department_ID = '$depid' ");
          $wtf->execute();
          $result = $wtf->fetch(PDO::FETCH_ASSOC);

          $nurses[$nurseid]['Department'] = $result['Name'];

          $nurses[$nurseid]['Degree'] = $row['Degree'];
          $nurses[$nurseid]['Actualstate'] = $row['Actual state'];
          $nurses[$nurseid]['Turnoutdate'] = $row['Turn out date'];
          //$nurses[$nurseid]['User_ID'] = $row['User_ID'];
          //$nurses[$nurseid]['Username'] = $row['Username'];
          //$nurses[$nurseid]['Email'] = $row['Email'];
      }
  }



  $stmt = $dbconn->prepare("SELECT * FROM User");

  if ($stmt->execute()) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $personid = $row['Person_ID'];

        foreach ($nurses as $nurseid => $array) {
          if($personid == $nurseid){
            $nurses[$nurseid]['User_ID'] = $row['User_ID'];
            $nurses[$nurseid]['Username'] = $row['Username'];
            $nurses[$nurseid]['Email'] = $row['Email'];
          }
        }


      }
  }

 ?>

<div class="container" style="margin-top: 10px; padding-right: 200px; padding-left: 200px;">
  <div class="btn-group btn-group-justified">
    <a href="#" role="button" class="btn btn-info setfilter" id="setFilter">Set filter</a>
    <a href="index.php?search=2" role="button" class="btn btn-info setfilter" id="unsetFilter">Unset filter</a>
  </div>
</div>

<div  style="margin: 10px;">
  <div class="table-responsive">
    <table class="table-primary datatable">
      <thead>  
        <tr class="header">
          <?php
            echo "<th>Degree</th>";
            echo "<th>Full name</th>";
            echo "<th>Competence</th>";
            echo "<th>Department</th>";
            echo "<th>Username</th>";
            echo "<th>Email</th>";
            echo "<th>Date of birth</th>";
            echo "<th>ID number</th>";
            echo "<th>Country</th>";
            echo "<th>Address</th>";
            echo "<th>Actual state</th>";
            echo "<th>Turn out date</th>";
            echo "<th>Dismiss</th>";
            echo "<th>Edit</th>";
            echo "<th>Delete</th>";
          echo "</tr>";
      echo"</thead>";

      echo"<tbody>";
          foreach ($nurses as $nurseid => $nursedata) 
          {
            echo "<tr>";       
            echo "<td>".$nursedata['Degree']."</td>";
            echo "<td>".$nursedata['Name']." ".$nursedata['Surname']."</td>";
            echo "<td>".$nursedata['Competence']."</td>";
            echo "<td>".$nursedata['Department']."</td>";
            
            if(isset($nursedata['Username']) && isset($nursedata['Email'])){
              echo "<td>".$nursedata['Username']."</td>";
              echo "<td>".$nursedata['Email']."</td>";
            }else{
              echo "<td></td>";
              echo "<td></td>";
            }
            
            echo "<td>".$nursedata['Dateofbirth']."</td>";
            echo "<td>".$nursedata['IDnumber']."</td>";
            echo "<td>".$nursedata['Country']."</td>";
            echo "<td>".$nursedata['City'].", ".$nursedata['Street'].", ".$nursedata['Zip']."</td>";
            echo "<td>".$nursedata['Actualstate']."</td>";
            echo "<td>".$nursedata['Turnoutdate']."</td>";


              $fired = $nursedata['Actualstate'];
              $person_id = $nursedata['Person_ID'];

              if($fired == "active"){
                echo "<td><a href=\"#\" onclick=\"transferPhpArray($person_id, 'Nurse')\" role=\"button\" data-toggle=\"modal\" data-target=\"#dismissNurseModal\" class=\"btn btn-warning \"><span class=\"glyphicon glyphicon-log-out\"></span></td>";
                echo "<td><a href=\"#\" onclick=\"transferPhpArray($person_id, 'Nurse')\" role=\"button\" data-toggle=\"modal\" data-id=\"1\" data-target=\"#editNurseModal\" class=\"btn btn-info \"><span class=\"glyphicon glyphicon-edit\"></span></td>";
              }else{
                echo "<td><a href=\"#\" role=\"button\"  class=\"btn btn-default disabled\"><span class=\"glyphicon glyphicon-ban-circle\"></span></td>" ;
                echo "<td><a href=\"#\" role=\"button\"  class=\"btn btn-default disabled\"><span class=\"glyphicon glyphicon-ban-circle\"></span></td>" ;
              }
              
              echo "<td><a href=\"#\" onclick=\"transferPhpArray($person_id, 'Nurse')\" role=\"button\" data-toggle=\"modal\" data-target=\"#deleteNurseModal\" class=\"btn btn-danger \"><span class=\"glyphicon glyphicon-trash\"></span></td>";
              echo "</tr>";
          }
          ?>
        </tr>
      </tbody>
    </table>
  </div>
</div>


 <?create_unsuccessful_delete_modal("nurseDel", "2", "The nurse record you want to delete can't be deleted due to existence of department assignment for her/him. Sorry.")?>

 <? $departments=array();
      $depname = $dbconn->prepare("SELECT Name FROM Department");
      if($depname->execute())
      {
        while ($row = $depname->fetch(PDO::FETCH_ASSOC)) 
        {
          $departments[] = $row['Name'];
        }
      }?>

  <div class="modal fade" id="editNurseModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit nurse</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="index.php?search=2">
          <?php include('form-person-modal.php');?>
          <?php include('form-user-modal.php');?>

          <div class="form-group form-width <?php set_input_error_success("Department", $errors);?>">
            <label>Department:</label>
            <select class="form-control" id="Department" name="Department">
            <?php add_options_from_array($departments, isset($Department) ? $Department : "")?>
            </select>
          </div>
          
          <div class="form-group form-width <?php set_input_error_success("Competence", $errors);?>">
            <label for="Competence">Competence:</label>
            <select name="Competence" id="Competence" class="form-control">
              <?php add_options_from_array($arraycompetences, isset($Competence) ? $Competence : "")?>
            </select>
          </div>
          <div class="form-group form-width <?php set_input_error_success("Degree", $errors);?>">
            <label for="Degree">Degree:</label>
            <select name="Degree" id="Degree" class="form-control">
               <?php add_options_from_array($arraynursedegrees, isset($Degree) ? $Degree : "")?>
            </select>
          </div>

            <input class="hidden" name="Person_ID">
            <input class="hidden" name="User_ID">

            <button type="submit" name="edit-nurse" class="btn btn-primary">Save changes</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="deleteNurseModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete nurse</h4>
        </div>
        <div class="modal-body">
          <p class="modal-delete">Do you really want to delete nurse record?</p>
          <form method="post" action="index.php?search=2">
            <div class="form-group">
              <input class="hidden" name="Person_ID_Delete">
            </div>
            <div class="form-group">
              <input class="hidden" name="User_ID_Delete">
            </div>
            <button type="submit" name="delete-nurse" class="btn btn-danger">Confirm</button>
          </form>
              
        </div>
        <div class="modal-footer">
          
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="dismissNurseModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Dismiss nurse</h4>
        </div>
        <div class="modal-body">
          <p class="modal-dismiss">Do you really want to dismiss the nurse? You can not change it later.</p>
          <form method="post" action="index.php?search=2">
            <div class="form-group">
              <input class="hidden" name="Person_ID_Dismiss">
            </div>
            <div class="form-group">
              <input class="hidden" name="User_ID_Dismiss">
            </div>
            <div class="form-group">
              <input class="hidden" name="Turnoutdate" id="Turnoutdate">
            </div>
            <div class="form-group">
              <input class="hidden" name="Actualstate">
            </div>

            <button type="submit" name="dismiss-nurse" class="btn btn-warning">Confirm</button>
          </form>
              
        </div>
        <div class="modal-footer">
          
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

    <script>
      $("#dismissNurseModal").on("shown.bs.modal", function () {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        if (dd < 10) {
          dd = '0' + dd;
        } 
        if (mm < 10) {
          mm = '0' + mm;
        } 
        var today = dd + '/' + mm + '/' + yyyy;
        
        $( "#Turnoutdate" ).datepicker("setDate", today);  
      });
  </script>