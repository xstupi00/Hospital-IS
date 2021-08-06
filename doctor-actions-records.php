<?php

$patient_id = $_GET['patient_id'];
$stmt = $dbconn->prepare("SELECT * FROM Person  NATURAL JOIN Patient WHERE Person.Person_ID = Patient.Patient_ID AND Patient.Patient_ID = $patient_id");

$patientdead = false;
$patients = array();
  if ($stmt->execute()) 
  {
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
      {
          $patientid = $row['Patient_ID'];

          $patients[$patientid]['Person_ID'] = $row['Person_ID'];
          $patients[$patientid]['Name'] = $row['Name'];
          $patients[$patientid]['Surname'] = $row['Surname'];
          $date = preg_split("/-/", $row['Date of birth']);
          $patients[$patientid]['Dateofbirth'] = $date[2]."/".$date[1]."/".$date[0];
          $patients[$patientid]['Sex'] = $row['Sex'];
          $patients[$patientid]['IDnumber'] = $row['ID number'];
          $patients[$patientid]['Country'] = $row['Country'];
          $patients[$patientid]['City'] = $row['City'];
          $patients[$patientid]['Street'] = $row['Street'];
          $patients[$patientid]['Zip'] = $row['Zip'];
          $patients[$patientid]['Weight'] = $row['Weight'];
          $patients[$patientid]['Height'] = $row['Height'];
          $patients[$patientid]['Healthcondition'] = $row['Health condition'];
          $date = preg_split("/-/", $row['Date of registration']);
          $patients[$patientid]['Dateofregistration'] = $date[2]."/".$date[1]."/".$date[0];
          $date = preg_split("/-/", $row['Date of death']);
          if(!isset($date[1])){
            $patients[$patientid]['Dateofdeath'] = $date[0];
          }
          else{
            $patients[$patientid]['Dateofdeath'] = $date[2]."/".$date[1]."/".$date[0];
            $patientdead = true;
          }
      }
  }
?>

   <div class="card hovercard" style="margin-top: 0">
        <div class="card-background">

        </div>
        <div class="useravatar">
            <img alt="" src="<?php 

            if($patients[$patientid]['Sex'] == "M"){
              if(!$patientdead){
                echo "images/male.png"; 
              }else{
                echo "images/maledead.png";
              }
            }
            else {
              if(!$patientdead){
                echo "images/female.png"; 
              }else{
                echo "images/femaledead.png";
              }
              
            }
            ?>">
            
        </div>
        <div class="card-info"> <span class="card-title"><?php  echo $patients[$patientid]['Name']." ".$patients[$patientid]['Surname'];?></span>

        </div>
    </div>



      <ul class="nav nav-tabs nav-justified" id="myTab">
        <li class="active"><a href="#tab1" role="button" class="btn btn-default">Patient information&nbsp;<span class="glyphicon glyphicon-user"></span></a></li>
        <li><a href="#tab2" role="button" class="btn btn-default">Hospitalizations&nbsp;<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a></li>
        <li><a href="#tab3" role="button" class="btn btn-default">Examinations&nbsp;<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a></li>
        <li><a href="#tab4" role="button" class="btn btn-default">Administrations of medications&nbsp;<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a></li>
      </ul>



        <div class="well" style="padding: 0">
      <div class="tab-content">
        <div class="tab-pane fade in active" id="tab1">
        <table class="table patient-info">
            <tbody>
                <tr>
                  <th>Full name</th>
                  <?php echo "<td>".$patients[$patientid]['Name']." ".$patients[$patientid]['Surname']."</td>";?>
                </tr>
                <tr>
                  <th>Date of birth</th>
                  <?php  echo "<td>".$patients[$patientid]['Dateofbirth']."</td>";?>
                </tr>
                <tr>
                  <th>ID number</th>
                  <?php  echo "<td>".$patients[$patientid]['IDnumber']."</td>";?>
                </tr>
                <tr>
                  <th>Sex</th>
                  <?php  
                    if($patients[$patientid]['Sex'] == "Male") echo "<td>Male</td>"; else echo "<td>Female</td>"?>
                </tr>
                <tr>
                  <th>Health condition</th>
                   <?php echo "<td>".$patients[$patientid]['Healthcondition']."</td>";?>
                </tr>
                <tr>
                  <th>Weight</th>
                  <?php echo "<td>".$patients[$patientid]['Weight']."</td>";?>
                </tr>
                <tr>
                  <th>Height</th>
                  <?php echo "<td>".$patients[$patientid]['Height']."</td>";?>
                </tr>
                <tr>
                  <th>Country</th>
                  <?php  echo "<td>".$patients[$patientid]['Country']."</td>";?>
                </tr>
                <tr>
                  <th>Address</th>
                  <?php echo "<td>".$patients[$patientid]['City'].", ".$patients[$patientid]['Street'].", ".$patients[$patientid]['Zip']."</td>";?>
                </tr>
                <tr>
                  <th>Date of registration</th>
                  <?php echo "<td>".$patients[$patientid]['Dateofregistration']."</td>";?>
                </tr>
                <tr>
                  <th>Date of death</th>
                  <?php echo "<td>".$patients[$patientid]['Dateofdeath']."</td>";?>
                </tr>
            </tbody>
        </table>
      </div>





<div class="tab-pane fade in" id="tab2">
    <div class="table-responsive">
      <div class="container" style="margin-top: 8px; margin-bottom: 8px;">
        <input class="form-control" id="hospInput" type="text" placeholder="Search by date, department or doctor...">
      </div>
   
      <?php

        $hosprecords = array();
        $hospattrs = array('Hospitalization_ID', 'Doctor_ID', 'Department_ID', 'Patient_ID', 'Date', 'Hospitalization record');

        $stmt = $dbconn->prepare("SELECT `Hospitalization_ID`, `Doctor_ID`, `Department_ID`, `Patient_ID`, `Date`, `Hospitalization record` FROM Hospitalization  NATURAL JOIN Patient WHERE  Patient.Patient_ID = $patient_id");

        if ($stmt->execute()) 
        { 
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
          {
            $hospid = $row['Hospitalization_ID'];

            foreach ($row as $key => $value) 
            {
              $hosprecords[$hospid][$key] = $value;
            }

            $depid = $hosprecords[$hospid]['Department_ID'];
            $dep = $dbconn->prepare("SELECT Name FROM Department WHERE Department.Department_ID = '$depid' ");
            $dep->execute();
            $result = $dep->fetch(PDO::FETCH_ASSOC);

            $hosprecords[$hospid]['Department'] = $result['Name'];

            $docid = $hosprecords[$hospid]['Doctor_ID'];
            $doc = $dbconn->prepare("SELECT Name, Surname, Degree FROM Person NATURAL JOIN Doctor WHERE Doctor.Doctor_ID = Person.Person_ID AND Doctor.Doctor_ID = '$docid' ");
            $doc->execute();
            $result = $doc->fetch(PDO::FETCH_ASSOC);
            $hosprecords[$hospid]['Doctor'] = $result['Degree']." ".$result['Name']." ".$result['Surname'];
          }   
        }
      ?>

    <table class="table-primary">     
      <thead>
      <tr class="header">
        <?php 
            echo "<th>Date</th>";
            echo "<th>Department</th>";
            echo "<th>Doctor</th>";
            echo "<th>Add examination</th>";
            echo "<th>Add prescription</th>";
            echo "<th>Details</th>";
        ?>
      </tr>
      </thead>


      <tbody id="hospTable">
      <?php 
        $order=1;
        foreach ($hosprecords as $hospid => $records) {
          echo "<tr>";
            echo "<td>".$records['Date']."</td>";
            echo "<td>".$records['Department']."</td>";
            echo "<td>".$records['Doctor']."</td>";
            
          $today = date("Y-m-d");
          $mydate = date('Y-m-d', (strtotime($records['Date'])+60*60*24*365*2));

          //echo "<td>$today</td>";
          //echo "<td>$mydate</td>";


          if($today <= $mydate && !$patientdead){

          echo "<td><a href=\"add-examination.php?patient_id=$patient_id&hospid=$hospid\" role=\"button\"  class=\"btn btn-info\"><span class=\"glyphicon glyphicon-plus\"></span></td>" ;
           echo "<td><a href=\"add-admofmeds.php?patient_id=$patient_id&hospid=$hospid\" role=\"button\"  class=\"btn btn-info\"><span title=\"A nice tooltip\" data-original-title=\"Tooltip on right\" class=\"glyphicon glyphicon-plus\"></span></td>" ;
          }else{
             echo "<td><span class=\"tool-tip\" data-toggle=\"tooltip\" data-placement=\"top\" title=\"Tooltip on top\"><a href=\"#\" role=\"button\"  class=\"btn btn-default disabled\"><span class=\"glyphicon glyphicon-ban-circle\"></span></span></td>" ;
           echo "<td><a href=\"#\" role=\"button\"  class=\"btn btn-default disabled\"><span class=\"glyphicon glyphicon-ban-circle\"></span></td>" ;
          }


          echo "<td><a href=\"javascript:void(0);\" role=\"button\"  class=\"btn btn-info\" data-toggle=\"collapse\" data-target=\"#div$hospid\" onclick=\"fun('td$hospid')\" \"><span class=\"glyphicon glyphicon-search\"></span></td>" ;
          echo "</tr>";


           echo "<tr>";
            echo "<td colspan=\"6\" style=\"display: none;\" class=\"tdscroll\" id=\"td$hospid\" >

            <div id=\"div$hospid\" class=\"collapse\">
                <div class=\"panel panel-info \">
                  <div class=\"panel-heading\" style=\"font-size: 16px; font-weight: bold;\"> Hospitalization record#$order details
                  </div>
                  <div class=\"panel-body\">"; $order+=1;?>
                    <table class="table thleft tdleft">
                      <tbody>
                         <tr>
                            <th>Hospitalization date</th>
                            <?php echo "<td>".$records['Date']."</td>";?>
                          </tr>
                           <tr>
                            <th>Doctor</th>
                            <?php echo "<td>".$records['Doctor']."</td>"?>
                          </tr>
                          <tr>
                            <th>Hospitalization record</th>
                            <?php  echo "<td><div class=\"container\" style=\"margin-left:0; padding-left:0;\">".$records['Hospitalization record']."</div></td>";?>
                          </tr>
                      </tbody>
                  </table> 
                  </div>
                </div>
              </div>
            </td>
           </tr>
          <?}?>

      <?if(!$patientdead){?>
        <tr>
          <td colspan="3">
            
          </td>
          <td colspan="2" style="text-align:right; font-size: 12px;">
            <strong>Add new hospitalization record</strong>
          </td>
          <td>
            <a href="add-hospitalization.php?patient_id=<?echo $patient_id?> " role="button"  class="btn btn-warning"><span class="glyphicon glyphicon-plus"></span></a>
          </td>

        </tr>
      <?}?>
      </tbody>
    </table>
  </div>
</div>
        
<div class="tab-pane fade in" id="tab3">
  <div class="container" style="margin-top: 8px; margin-bottom: 8px;">
      <input class="form-control" id="examInput" type="text" placeholder="Search by hosp.date, exam.date, department, doctor or type...">
  </div>

      <?php

        $exrecords = array();
        $exindexes = array('Examination_ID', 'Doctor_ID', 'Department_ID','Hospitalization_ID', 'Type','Date', 'Medical record');


        foreach ($hosprecords as $hospindex => $data) 
        {

          $stmt = $dbconn->prepare("SELECT `Examination_ID`, `Doctor_ID`, `Department_ID`,`Hospitalization_ID`, `Type`,`Date`, `Medical record` FROM Examination WHERE  Examination.Hospitalization_ID = '$hospindex'");

          if ($stmt->execute()) 
          { 
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
            {
              //print_r($row); echo "<br><br>";
              $exid = $row['Examination_ID'];

              foreach ($row as $key => $value) 
              {
                $exrecords[$exid][$key] = $value;
              }

              $hid = $exrecords[$exid]['Hospitalization_ID'];
              $hidst = $dbconn->prepare("SELECT `Date` FROM Hospitalization WHERE Hospitalization.Hospitalization_ID = '$hid' ");
              $hidst->execute();
              $hidres = $hidst->fetch(PDO::FETCH_ASSOC);
              
              $docid = $exrecords[$exid]['Doctor_ID'];
              $doc = $dbconn->prepare("SELECT Name, Surname, Degree FROM Person NATURAL JOIN Doctor WHERE Doctor.Doctor_ID = Person.Person_ID AND Doctor.Doctor_ID = '$docid' ");
              $doc->execute();
              $docres = $doc->fetch(PDO::FETCH_ASSOC);

              $depid = $exrecords[$exid]['Department_ID'];
              $dep = $dbconn->prepare("SELECT Name FROM Department WHERE Department.Department_ID = '$depid' ");
              $dep->execute();
              $depres = $dep->fetch(PDO::FETCH_ASSOC);


              $exrecords[$exid]['Department'] = $depres['Name'];             
              $exrecords[$exid]['Hospdate'] = $hidres['Date']; 
              $exrecords[$exid]['Doctor'] = $docres['Degree']." ".$docres['Name']." ".$docres['Surname'];

            }   
          }
        }
      ?>

   <div class="table-responsive">
    <table class="table-primary ">    
      <thead>
        <tr class="header">
          <?php 
              echo "<th>Hospitalization date</th>";
              echo "<th>Examination date</th>";
              echo "<th>Doctor</th>";
              echo "<th>Department</th>";
              echo "<th>Type</th>";
              echo "<th>Details</th>";
          ?>
        </tr>
      </thead>
      <tbody id="examTable">
        <?php 
          $order=1;
          foreach ($exrecords as $exid => $records) {
            echo "<tr>";
              echo "<td>".$records['Hospdate']."</td>";
              echo "<td>".$records['Date']."</td>";
              echo "<td>".$records['Doctor']."</td>";
              echo "<td>".$records['Department']."</td>";
              echo "<td>".$records['Type']."</td>";
              echo "<td><a href=\"javascript:void(0);\" role=\"button\"  class=\"btn btn-info\" data-toggle=\"collapse\" data-target=\"#divexid$exid\" onclick=\"fun('tdexid$exid')\" \"><span class=\"glyphicon glyphicon-search\"></span></td>" ;
            echo "</tr>";


            echo "<tr>";
            echo "<td colspan=\"6\" style=\"display: none;\" class=\"tdscroll\" id=\"tdexid$exid\" >

            <div id=\"divexid$exid\" class=\"collapse\">
                <div class=\"panel panel-info \">
                  <div class=\"panel-heading\" style=\"font-size: 16px; font-weight: bold;\"> Examination record #$order details
                  </div>
                  <div class=\"panel-body\">"; $order+=1;?>
                    <table class="table thleft tdleft">
                      <tbody>
                         <tr>
                            <th>Hospitalization date</th>
                            <?php echo "<td>".$records['Hospdate']."</td>";?>
                          </tr>
                           <tr>
                            <th>Doctor</th>
                            <?php echo "<td>".$records['Doctor']."</td>"?>
                          </tr>
                          <tr>
                            <th>Examination date</th>
                            <?php  echo "<td>".$records['Date']."</td>";?>
                          </tr>
                          <tr>
                            <th>Type</th>
                            <?php  echo "<td>".$records['Type']."</td>";?>
                          </tr>
                          <tr>
                            <th>Medical record</th>
                            <?php  echo "<td><div class=\"container\" style=\"margin-left:0; padding-left:0;\">".$records['Medical record']."</div></td>";?>
                          </tr>
                      </tbody>
                  </table> 
                  </div>
                </div>
              </div>
            </td>
           </tr>
          <?}?>
      </tbody>      
    </table>
  </div>       
</div>
        


<div class="tab-pane fade in" id="tab4">
  <div class="container" style="margin-top: 8px; margin-bottom: 8px;">
      <input class="form-control" id="admInput" type="text" placeholder="Search by hosp.date, adm.of med.date, department, doctor or next...">
  </div>
      <?php

        $admrecords = array();
        $admindexes = array('Adm_of_med_ID', 'Doctor_ID', 'Medication_ID','Hospitalization_ID', 'Procedure','Date', 'Frequency', 'Way of use');

        foreach ($hosprecords as $hospindex => $data) 
        {

          $stmt = $dbconn->prepare("SELECT `Adm_of_med_ID`, `Doctor_ID`, `Medication_ID`,`Hospitalization_ID`, `Procedure`,`Date`, `Frequency`, `Way of use` FROM Administration_Of_Medication WHERE  Administration_Of_Medication.Hospitalization_ID = '$hospindex'");

          if ($stmt->execute()) 
          { 
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) 
            {
              $admid = $row['Adm_of_med_ID'];

              foreach ($row as $key => $value) 
              {
                $admrecords[$admid][$key] = $value;
              }

              $hid = $admrecords[$admid]['Hospitalization_ID'];
              $hidst = $dbconn->prepare("SELECT `Date` FROM Hospitalization WHERE Hospitalization.Hospitalization_ID = '$hid' ");
              $hidst->execute();
              $hidres = $hidst->fetch(PDO::FETCH_ASSOC);
              
              $docid = $admrecords[$admid]['Doctor_ID'];
              $doc = $dbconn->prepare("SELECT Name, Surname, Degree FROM Person NATURAL JOIN Doctor WHERE Doctor.Doctor_ID = Person.Person_ID AND Doctor.Doctor_ID = '$docid' ");
              $doc->execute();
              $docres = $doc->fetch(PDO::FETCH_ASSOC);

              $medid = $admrecords[$admid]['Medication_ID'];
              $med = $dbconn->prepare("SELECT * FROM Medication WHERE Medication.Medication_ID = '$medid' ");
              $med->execute();
              $medres = $med->fetch(PDO::FETCH_ASSOC);


              $admrecords[$admid]['Medication'] = $medres['Name'];
              $admrecords[$admid]['MedMaximaldose'] = $medres['Maximal dose'];
              $admrecords[$admid]['MedForm'] = $medres['Form'];
              $admrecords[$admid]['MedActivesubstance'] = $medres['Active substance'];
              $admrecords[$admid]['MedSideeffect'] = $medres['Side effect'];

              $admrecords[$admid]['Hospdate'] = $hidres['Date']; 
              $admrecords[$admid]['Doctor'] = $docres['Degree']." ".$docres['Name']." ".$docres['Surname'];

            }   
          }
        }
      ?>

  <div class="table-responsive">
    <table class="table-primary ">    
      <thead>
      <tr class="header">
        <?php 
            echo "<th>Hospitalization date</th>";
            echo "<th>Adm.of medications date</th>";
            echo "<th>Doctor</th>";
            echo "<th>Medication</th>";
            echo "<th>Frequency</th>";
            echo "<th>Details</th>";
        ?>
      </tr>
      </thead>
      <tbody id="admTable">
        <?php 
          $order=1;
          foreach ($admrecords as $admid => $records) {
            echo "<tr>";
              echo "<td>".$records['Hospdate']."</td>";
              echo "<td>".$records['Date']."</td>";
              echo "<td>".$records['Doctor']."</td>";
              echo "<td>".$records['Medication']."</td>";
              echo "<td>".$records['Frequency']."</td>";
              echo "<td ><a href=\"javascript:void(0);\" role=\"button\"  class=\"btn btn-info\" data-toggle=\"collapse\" data-parent=\"#partd$admid\" data-target=\"#divadmid$admid\" onclick=\"fun('tdadmid$admid')\" \"><span class=\"glyphicon glyphicon-search\"></span></td>" ;
            echo "</tr>";


            //$rec = $records['Medical record'];


            echo "<tr>";
            echo "<td colspan=\"6\" style=\"display: none;\" class=\"tdscroll\" id=\"tdadmid$admid\" >

            <div id=\"divadmid$admid\" class=\"collapse\">
                <div class=\"panel panel-info \">
                  <div class=\"panel-heading\" style=\"font-size: 16px; font-weight: bold;\">Administration of medication#$order details
                  </div>
                  <div class=\"panel-body\">"; $order+=1;?>
                    <table class="table thleft tdleft">
                      <tbody>
                         <tr>
                            <th>Hospitalization date</th>
                            <?php echo "<td>".$records['Hospdate']."</td>";?>
                          </tr>
                           <tr>
                            <th>Doctor</th>
                            <?php echo "<td>".$records['Doctor']."</td>"?>
                          </tr>
                          <tr>
                            <th>Administration of medications date</th>
                            <?php  echo "<td>".$records['Date']."</td>";?>
                          </tr>
                          <tr>
                            <th>Procedure</th>
                            <?php  echo "<td>".$records['Procedure']."</td>";?>
                          </tr>
                          <tr>
                            <th>Frequency</th>
                             <?php echo "<td>".$records['Frequency']."</td>";?>
                          </tr>
                          <tr>
                            <th>Way of use</th>
                            <?php echo "<td>".$records['Way of use']."</td>";?>
                          </tr>
                          <tr>
                            <th>Medication name</th>
                            <?php echo "<td>".$records['Medication']."</td>";?>
                          </tr>
                          <tr>
                            <th>Maximal dose</th>
                            <?php  echo "<td>".$records['MedMaximaldose']."</td>";?>
                          </tr>
                          <tr>
                            <th>Form</th>
                            <?php echo "<td>".$records['MedForm']."</td>";?>
                          </tr>
                          <tr>
                            <th>Active substance</th>
                            <?php echo "<td>".$records['MedActivesubstance']."</td>";?>
                          </tr>
                          <tr>
                            <th>Side effect</th>
                            <?php echo "<td>".$records['MedSideeffect']."</td>";?>
                          </tr>
                      </tbody>
                  </table> 
                  </div>
                </div>
              </div>
            </td>
           </tr>
          <?}?>
        </tbody>
      </table>
     </div>  
   </div>
  </div>
 </div>
    <a style="margin-left: 20px;" href="index.php?search=1" role="button" class="btn btn-info">Back</a>
</div>

<script>
  function fun(element) {
  if( document.getElementById(element).style.display=='none' ){
   document.getElementById(element).style.display = 'table-cell'; 
 }else{
   document.getElementById(element).style.display = 'none';
 }
}
</script>

