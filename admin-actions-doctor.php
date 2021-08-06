<?php
$stmt = $dbconn->prepare("SELECT * FROM Person  NATURAL JOIN Doctor WHERE Person.Person_ID = Doctor.Doctor_ID");

$doctors = array();
  if ($stmt->execute()) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $doctorid = $row['Doctor_ID'];

          $doctors[$doctorid]['Person_ID'] = $row['Person_ID'];
          $doctors[$doctorid]['Name'] = $row['Name'];
          $doctors[$doctorid]['Surname'] = $row['Surname'];
          $doctors[$doctorid]['Dateofbirth'] = $row['Date of birth'];
          $doctors[$doctorid]['Sex'] = $row['Sex'];
          $doctors[$doctorid]['IDnumber'] = $row['ID number'];
          $doctors[$doctorid]['Country'] = $row['Country'];
          $doctors[$doctorid]['City'] = $row['City'];
          $doctors[$doctorid]['Street'] = $row['Street'];
          $doctors[$doctorid]['Zip'] = $row['Zip'];
          $doctors[$doctorid]['Specialization'] = $row['Specialization'];
          $doctors[$doctorid]['Degree'] = $row['Degree'];
          $doctors[$doctorid]['Actualstate'] = $row['Actual state'];
          $doctors[$doctorid]['Turnoutdate'] = $row['Turn out date'];
          //$doctors[$doctorid]['User_ID'] = $row['User_ID'];
          //$doctors[$doctorid]['Username'] = $row['Username'];
          //$doctors[$doctorid]['Email'] = $row['Email'];
      }
  }


  $stmt = $dbconn->prepare("SELECT * FROM User");

  if ($stmt->execute()) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $personid = $row['Person_ID'];

        foreach ($doctors as $doctorid => $array) {
          if($personid == $doctorid){
            $doctors[$doctorid]['User_ID'] = $row['User_ID'];
            $doctors[$doctorid]['Username'] = $row['Username'];
            $doctors[$doctorid]['Email'] = $row['Email'];
          }
        }


      }
  }




 ?>




<div class="container" style="margin-top: 10px; padding-right: 200px; padding-left: 200px;">
  <div class="btn-group btn-group-justified">
    <a href="#" role="button" class="btn btn-info setfilter" id="setFilter">Set filter</a>
    <a href="index.php?search=1" role="button" class="btn btn-info setfilter" id="unsetFilter">Unset filter</a>
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
            echo "<th>Specialization</th>";
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
      
        foreach ($doctors as $doctorid => $doctordata) {
  		   echo "<tr>";				
  		 	echo "<td>".$doctordata['Degree']."</td>";
  		 	echo "<td>".$doctordata['Name']." ".$doctordata['Surname']."</td>";
  		 	echo "<td>".$doctordata['Specialization']."</td>";
  		 	if(isset($doctordata['Username']) && isset($doctordata['Email'])){
              echo "<td>".$doctordata['Username']."</td>";
              echo "<td>".$doctordata['Email']."</td>";
            }else{
              echo "<td></td>";
              echo "<td></td>";
            }
  		 	echo "<td>".$doctordata['Dateofbirth']."</td>";
  		 	echo "<td>".$doctordata['IDnumber']."</td>";
  		 	echo "<td>".$doctordata['Country']."</td>";
  		 	echo "<td>".$doctordata['City'].", ".$doctordata['Street'].", ".$doctordata['Zip']."</td>";
        echo "<td>".$doctordata['Actualstate']."</td>";
        echo "<td>".$doctordata['Turnoutdate']."</td>";

        $person_id = $doctordata['Person_ID'];
        $fired = $doctordata['Actualstate'];

        if($fired == "active"){
          echo "<td><a href=\"#\" onclick=\"transferPhpArray($person_id, 'Doctor')\" role=\"button\" data-toggle=\"modal\" data-target=\"#dismissDoctorModal\" class=\"btn btn-warning \"><span class=\"glyphicon glyphicon-log-out\"></span></td>";
          echo "<td><a href=\"#\" onclick=\"transferPhpArray($person_id, 'Doctor')\" role=\"button\" data-toggle=\"modal\" data-id=\"1\" data-target=\"#editDoctorModal\" class=\"btn btn-info \"><span class=\"glyphicon glyphicon-edit\"></span></td>";
        }else{
          echo "<td><a href=\"#\" role=\"button\"  class=\"btn btn-default disabled\"><span class=\"glyphicon glyphicon-ban-circle\"></span></td>" ;
          echo "<td><a href=\"#\" role=\"button\"  class=\"btn btn-default disabled\"><span class=\"glyphicon glyphicon-ban-circle\"></span></td>" ;
        }
  		    
  		    echo "<td><a href=\"#\" onclick=\"transferPhpArray($person_id, 'Doctor')\" role=\"button\" data-toggle=\"modal\" data-target=\"#deleteDoctorModal\" class=\"btn btn-danger \"><span class=\"glyphicon glyphicon-trash\"></span></td>";
  		    echo "</tr>";
  		  }
          ?>
        </tr>
      </tbody>
    </table>
  </div>
</div>


  <?create_unsuccessful_delete_modal("doctorDel", "1", "The doctor record you want to delete can't be deleted due to existence of hospitalization records created by this doctor. Sorry.")?>



  <div class="modal fade" id="editDoctorModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Edit doctor</h4>
        </div>
        <div class="modal-body">
		  <form method="post" action="index.php?search=1">
	    <?php include('form-person-modal.php');?>
      <?php include('form-user-modal.php');?>
      <div class="form-group form-width">
        <label>Specialization:</label>
        <select id="Specialization" name="Specialization" class="form-control">
          <?php add_options_from_array($arrayspecializations, isset($Specialization) ? $Specialization : "")?>
        </select>
      </div>
      <div class="form-group form-width">
        <label>Degree:</label>
        <select id="Degree" name="Degree" class="form-control">
           <?php add_options_from_array($arraydoctordegrees, isset($Degree) ? $Degree : "")?>
        </select>
      </div>
        
        <input class="hidden" name="Person_ID">
        <input class="hidden" name="User_ID">

			<button type="submit" name="edit-doctor" class="btn btn-primary">Save changes</button>
		  </form>
        </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="deleteDoctorModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Delete doctor</h4>
        </div>
        <div class="modal-body">
          <p class="modal-delete">Do you really want to delete doctor record?</p>
          <form method="post" action="index.php?search=1">
            <div class="form-group">
              <input class="hidden" name="Person_ID_Delete">
            </div>
            <div class="form-group">
              <input class="hidden" name="User_ID_Delete">
            </div>
            <button type="submit" name="delete-doctor" class="btn btn-danger">Confirm</button>
          </form>
          		
        </div>
        <div class="modal-footer">
          
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

    <div class="modal fade" id="dismissDoctorModal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Dismiss doctor</h4>
        </div>
        <div class="modal-body">
          <p class="modal-dismiss">Do you really want to dismiss the doctor? You can not change it later.</p>
          <form method="post" action="index.php?search=1">
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
            <button type="submit" name="dismiss-doctor" class="btn btn-warning">Confirm</button>
          </form>
              
        </div>
        <div class="modal-footer">
          
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <script>
      $("#dismissDoctorModal").on("shown.bs.modal", function () {
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