<?php include('server.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>TS Clinic IS</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php include('add-scripts-and-css.php');?>
  <style type="text/css">
  .ui-datepicker{ z-index:1151 !important; }
  </style>


  <script>
    $(document).ready(function() 
    {
      if (location.hash) 
      {
          $("a[href='" + location.hash + "']").tab("show");
      }

      $(document.body).on("click", "a[data-toggle]", function(event) 
      {
          location.hash = this.getAttribute("href");
      });
    });

    $(window).on("popstate", function() 
    {
        var anchor = location.hash || $("a[data-toggle='tab']").first().attr("href");
        $("a[href='" + anchor + "']").tab("show");
    });
  </script>

  <script>
  $(document).ready(function(){
    $("#hospInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#hospTable tr:not(:last-child):not(td div div div table tbody tr)").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });

  $(document).ready(function(){
    $("#examInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#examTable tr:not(td div div div table tbody tr)").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });

   $(document).ready(function(){
    $("#admInput").on("keyup", function() {
      var value = $(this).val().toLowerCase();
      $("#admTable tr:not(td div div div table tbody tr)").filter(function() {
        $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
      });
    });
  });



  $(document).ready(function() 
  {
    var table = $('.datatable').DataTable(
    {
          "paging":   false,
          "info":     false
    });

    $( "#setFilter" ).click(function() 
    {

        $('.datatable thead th').each( function () 
        {
            var title = $(this).text();
            if(title != "Edit" && title != "Delete" && title != "Show profile")
              $(this).html( '<input type="text" placeholder="'+title+'" />' );
        });
   

        table.columns().every( function () 
        {
            var that = this;
            $('input', this.header()).on('keyup change', function () 
            {
                if (that.search() !== this.value) 
                {
                    that.search(this.value).draw();
                }
            });
        });
    });
  });



$(document).ready(function() 
{
  $('.tdscroll').on('shown.bs.collapse', function () {
    
    var panel = $(this).find('.in');
    
    $('html, body').animate({
          scrollTop: panel.offset().top
    }, 550);
    
  });
});



 function showDeleteMsg(idmodal){ 
    $(idmodal).modal("show");  
  };

</script>
</head>
<body>

<?php 
	session_timeout(); //lougout after 30 mins
	if (isset($_SESSION['success'])){
		unset($_SESSION['success']);
		header('location: index.php?page=0');
	}
?>	

<?php if(!isset($_SESSION['username']))
	include('main-page.php');
?>

<?php if(isset($_SESSION['username']))
	include('nav-bar.php');
  if(isset($_GET['page']) && $_GET['page'] == "0"){
      load_home_page($dbconn);
    }

?>

<?php 
  if (isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'A'){
  	 if (isset($_GET['search'])){
  		switch($_GET['search']){
  			case 1: include('admin-actions-doctor.php'); break;
  			case 2: include('admin-actions-nurse.php'); break;
  			case 3: include('admin-actions-medication.php'); break;
  			case 4: include('admin-actions-department.php'); break;
  			default: break;
  		}
  	}
  }
  else if(isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'D'){
    if (isset($_GET['search'])){
      switch($_GET['search']){
        case 1: include('doctor-actions-patient.php'); break;
        case 3: include('admin-actions-medication.php'); break;
        case 4: include('admin-actions-department.php'); break;
        default: break;
      }
    }
    if(isset($_GET['showprofile'])){
      switch ($_GET['showprofile']) {
        case 0:
          include('doctor-actions-records.php');
          break;
        
        default: break;
      }
    }
  }
  else if(isset($_SESSION['usertype']) && $_SESSION['usertype'] == 'N'){
    if (isset($_GET['search'])){

      switch($_GET['search']){

        case 1: include('doctor-actions-patient.php'); break;
        case 4: include('admin-actions-department.php'); break;
        default: break;
      }
    }
  }
?>

</body>
</html>


<script type="text/javascript">
  function setSelectBoxByText(eid, etxt) {
    var eid = document.getElementById(eid);
    for (var i = 0; i < eid.options.length; ++i) {
        if (eid.options[i].text === etxt)
            eid.options[i].selected = true;
    }
  }

  function formatDate(date) {
    if(!date){
      return null;
    }

    var splitted = date.split('-');

    return splitted[2]+'/'+splitted[1]+'/'+splitted[0];
     
  }

  function transferPhpArray(array_id, array){
    var data = <?php 
    $null=null;
    if(isset($nurses)){
      echo json_encode($nurses); 
    }else if(isset($doctors)){
      echo json_encode($doctors);
    }else if(isset($meds)){
      echo json_encode($meds);
    }else if(isset($deps)){
      echo json_encode($deps);
    }else if(isset($patients)){
      echo json_encode($patients);
    }else{
      echo json_encode($null);
    }
    ?>;

    if(array == "Medication"){
      document.getElementsByName("Medication_ID")[0].value = data[array_id].Medication_ID;
      document.getElementsByName("Medication_ID_Delete")[0].value = data[array_id].Medication_ID;
      document.getElementsByName("Name")[0].value = data[array_id].Name;
     document.getElementsByName("Maximaldose")[0].value = data[array_id].Maximaldose;
      setSelectBoxByText('Form',data[array_id].Form);  
      document.getElementsByName("Activesubstance")[0].value = data[array_id].Activesubstance;
      document.getElementsByName("Sideeffect")[0].value = data[array_id].Sideeffect; 
    }
    else if(array == "Department"){
      document.getElementsByName("Department_ID")[0].value = data[array_id].Department_ID;
      document.getElementsByName("Department_ID_Delete")[0].value = data[array_id].Department_ID;
      document.getElementsByName("Name")[0].value = data[array_id].Name;
      document.getElementsByName("Numberofbeds")[0].value = data[array_id].Numberofbeds;
      document.getElementsByName("Numberofrooms")[0].value = data[array_id].Numberofrooms;
      document.getElementsByName("Visittimefrom")[0].value = data[array_id].Visittimefrom;
      document.getElementsByName("Visittimeto")[0].value = data[array_id].Visittimeto;
      document.getElementsByName("Floor")[0].value = data[array_id].Floor;
    }
    else{

      if(array == "Patient"){
        //setSelectBoxByText('PICA', data[array_id].Country);
        document.getElementsByName("Weight")[0].value = data[array_id].Weight;
        document.getElementsByName("Height")[0].value = data[array_id].Height;
        document.getElementsByName("Healthcondition")[0].value = data[array_id].Healthcondition;
        document.getElementsByName("Dateofregistration")[0].value = formatDate(data[array_id].Dateofregistration);
        document.getElementsByName("DateofregistrationUnused")[0].value = formatDate(data[array_id].Dateofregistration);
        document.getElementsByName("Dateofdeath")[0].value = formatDate(data[array_id].Dateofdeath);
      }

      //Doctor,Nurse,Patient
      document.getElementsByName("Person_ID")[0].value = data[array_id].Person_ID;
      document.getElementsByName("Person_ID_Delete")[0].value = data[array_id].Person_ID;
      
      document.getElementsByName("Name")[0].value = data[array_id].Name;
      document.getElementsByName("Surname")[0].value = data[array_id].Surname; 
      document.getElementsByName("Dateofbirth")[0].value = formatDate(data[array_id].Dateofbirth);
      document.getElementsByName("IDnumber")[0].value = data[array_id].IDnumber; 

      switch(data[array_id].Sex){
        case "M": setSelectBoxByText('Sex','Male'); break;
        case "F": setSelectBoxByText('Sex','Female'); break;
      }

      setSelectBoxByText('Country', data[array_id].Country);
      document.getElementsByName("City")[0].value = data[array_id].City; 
      document.getElementsByName("Street")[0].value = data[array_id].Street; 
      document.getElementsByName("Zip")[0].value = data[array_id].Zip; 


      if(array == "Doctor"){
        setSelectBoxByText('Specialization', data[array_id].Specialization);
        //setSelectBoxByText('Actualstate', data[array_id].Actualstate);
      }else if(array == "Nurse"){
        setSelectBoxByText('Competence', data[array_id].Competence);
        setSelectBoxByText('Department', data[array_id].Department);
      }

      if(array == "Doctor" || array == "Nurse"){
        setSelectBoxByText('Degree', data[array_id].Degree);
        document.getElementsByName("User_ID")[0].value = data[array_id].User_ID;
        document.getElementsByName("User_ID_Delete")[0].value = data[array_id].User_ID; 
        document.getElementsByName("User_ID_Dismiss")[0].value = data[array_id].User_ID;
        document.getElementsByName("Person_ID_Dismiss")[0].value = data[array_id].Person_ID;   
        document.getElementsByName("Username")[0].value = data[array_id].Username; 
        document.getElementsByName("Email")[0].value = data[array_id].Email;
        document.getElementsByName("Actualstate")[0].value = data[array_id].Actualstate;  
        document.getElementsByName("Turnoutdate")[0].value = formatDate(data[array_id].Turnoutdate);
      }
    }

  }

  if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
  }
</script>


<script>
  $("#Dateofbirth").datepicker({
    dateFormat : 'dd/mm/yy',
    changeMonth : true,
    changeYear : true,
    yearRange: '-100y:c+nn',
    maxDate: '0d'
  });
    $("#Dateofdeath").datepicker({
    dateFormat : 'dd/mm/yy',
    changeMonth : true,
    changeYear : true,
    yearRange: '-100y:c+nn',
    maxDate: '0d'
  });
    $("#Dateofregistration").datepicker({
    dateFormat : 'dd/mm/yy',
    changeMonth : true,
    changeYear : true,
    yearRange: '-100y:c+nn',
    maxDate: '0d'
  });

  $("#DateofregistrationUnused").datepicker({
    dateFormat : 'dd/mm/yy',
  }); 


  $("#Turnoutdate").datepicker({
    dateFormat : 'dd/mm/yy',
    yearRange: '-100y:c+nn',
    maxDate: '+0d',
    minDate: '+0d'
  });



   

  $(document).ready(function() {
$(".btn-pref .btn").click(function () {
    $(".btn-pref .btn").removeClass("btn-primary").addClass("btn-default");
    // $(".tab").addClass("active"); // instead of this do the below 
    $(this).removeClass("btn-default").addClass("btn-primary");   
});
});

</script>


