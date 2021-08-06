
<?php function load_home_page($dbconn){?>
  <div class="container">
      <div>
         <h2>Basic information and tutorial</h2>
      </div>
      <p>
        TS Clinic Information System is information for hospital or clinic. User can search, add, edit or delete entries.
      </p>
  </div>
<?php } ?>

<?php function load_page($dbconn){?>
 <h2>My Customers</h2>

  <div class="inner-addon left-addon">
    <i class="glyphicon glyphicon-search"></i>  
    <input class="form-control" type="text" id="myInput" onkeyup="myFunction()" placeholder="Search for names.." title="Type in a name">
  </div>

  <div class="table-responsive">          
  <table class="table-primary">
    <tr class="header">
      <th style="width:60%;">Name</th>
      <th style="width:40%;">Country</th>
    </tr>
    <tr>
      <td>Alfreds Futterkiste</td>
      <td>Germany</td>
    </tr>
    <tr>
      <td>Alfreds snabbkop</td>
      <td>Sweden</td>
    </tr>
    <tr>
      <td>Island Trading</td>
      <td>UK</td>
    </tr>
    <tr>
      <td>Koniglich Essen</td>
      <td>Germany</td>
    </tr>
    <tr>
      <td>Laughing Bacchus Winecellars</td>
      <td>Canada</td>
    </tr>
    <tr>
      <td>Magazzini Alimentari Riuniti</td>
      <td>Italy</td>
    </tr>
    <tr>
      <td>North/South</td>
      <td>UK</td>
    </tr>
    <tr>
      <td>Paris specialites</td>
      <td>France</td>
    </tr>
  </table>
  </div>
<?php } ?>


<?php function select_one ($gotvalue, $value, $strclass, $strelse){ 
  if($gotvalue == $value){
    echo $strclass;
  }else{
    echo $strelse;
  }
}?>


<?php function load_doctor_entries($dbconn, $entries){?>
<?php
  
  $stmt = $dbconn->prepare("SELECT * FROM Person  NATURAL JOIN Doctor WHERE Person.Person_ID = Doctor.Doctor_ID ");

  if ($stmt->execute()) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $entries[] = $row;
      }
  }
  $tattributes = array();
  $tdata = array();

  if(!empty($entries)){
    foreach ($entries[0] as $attr => $data) {
      $tattributes[] = $attr;
    }
  }

?>

  <div>
    <h2>
      List of all doctors
    </h2>
  </div>

  <div class="table-responsive">
    <table class="table-primary">    
      <tr class="header">
        <?php
          foreach ($tattributes as $index => $attr) {
            echo "<th>$attr</th>";
          }

          foreach ($entries as $entry_num => $entry_info) {
            echo "<tr>";
            foreach ($entries[$entry_num] as $attr => $data) {
              echo "<td>$data</td>";
            }
            echo "</tr>";
          }
        ?>
      </tr>
      
    </table>
  </div>

<?php } ?>




<?php function load_all_entries($dbconn, $tablename){?>
<?php
  if($tablename == 'Doctor'){
    $stmt = $dbconn->prepare("SELECT * FROM Doctor NATURAL JOIN Person WHERE Person.Person_ID = Doctor.Doctor_ID");
  }else if($tablename == 'Nurse'){
    $stmt = $dbconn->prepare("SELECT * FROM Nurse NATURAL JOIN Person WHERE Person.Person_ID = Nurse.Nurse_ID");
  }else{
    $stmt = $dbconn->prepare("SELECT * FROM $tablename");
  }

  $entries = array();
  if ($stmt->execute()) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $entries[] = $row;
      }
  }
  $tattributes = array();
  $tdata = array();

  if(!empty($entries)){
    foreach ($entries[0] as $attr => $data) {
      $tattributes[] = $attr;
    }
  }
?>

  <div>
    <h2>
      List of all <?php echo "$tablename";?>
    </h2>
  </div>

  <div class="table-responsive">
    <table class="table-primary">    
      <tr class="header">
        <?php
          foreach ($tattributes as $index => $attr) {
            echo "<th>$attr</th>";
          }

          foreach ($entries as $entry_num => $entry_info) {
            echo "<tr>";
            foreach ($entries[$entry_num] as $attr => $data) {
              echo "<td>$data</td>";
            }
            echo "</tr>";
          }
        ?>
      </tr>
      
    </table>
  </div>

<?php } ?>



<?php function load_all_doctors($dbconn){?>
<?php 
  $stmt = $dbconn->prepare("SELECT * FROM Doctor WHERE Doctor_ID >= :doctor_id_val");

  $stmt->bindValue(":doctor_id_val", 1);
  $doctor_entries = array();
  if ($stmt->execute()) {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          $doctor_entries[] = $row;
      }
  }
  $tattributes = array();
  $tdata = array();

  if(!empty($doctor_entries)){
    foreach ($doctor_entries[0] as $attr => $data) {
      $tattributes[] = $attr;
    }
  }
?>


<div class="content-wrapper">
  <div>
    <h2>
      List of all doctors
    </h2>
  </div>

  <div class="table-wrapper">
    <table id="t1">    
      <tr>
        <?php
          foreach ($tattributes as $index => $attr) {
            echo "<th>$attr</th>";
          }

          echo "<th class=\"action\">Action</th>";

          foreach ($doctor_entries as $entry_num => $entry_info) {
            echo "<tr>";
            foreach ($doctor_entries[$entry_num] as $attr => $data) {
              echo "<td>$data</td>";
            }

              echo "<td><a class=\"action-link\" href=\"#edit\">edit</a><br><a class=\"action-link\" href=\"#delete\">delete</a></td>";
            echo "</tr>";
          }
        ?>
      </tr>
      
    </table>
  </div>
</div>
<?php } ?>

<?php function select_class ($getvalue, $order) { 
  if($getvalue == $order){
    echo 'active';
  }else{
    echo 'inactive';
  }
}?>












