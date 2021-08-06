<?php

$arrayregex = array(

	"Username"=>"^(([A-Za-z0-9_])){1,50}$",
	"Password"=>"^(([A-Za-z0-9_])){6,50}$",
	"Name"=>"^(([A-Za-z])){1,50}$",
	"Namenotreq"=> "(^$|^(([A-Za-z])){1,50}$)",
	"Street"=>"(^$|^(([A-Za-z0-9 \.])){1,50}$)",
	"City"=>"^(([A-Za-z ])){1,50}$",

	"Email"=>"^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$",

	"Weight"=>"^[1-9]\d{0,2}(?:[.]\d{1,2})?$",
	"Height"=>"^[1-9]\d{0,2}(?:[.]\d{1,2})?$",
	"Healthcondition"=>"^(([A-Za-z \.])){1,50}$",

	"Visittime"=>"^((1[4-6]):[0-5][0-9])|([1][7]:[0][0])$",


	"Zip"=>"^[0-9]{4,5}$",
	//"Name"=>"\p{L}+$",
	"Number"=>"^[1-9][0-9]{0,7}$",
	"PosNum"=>"^[1-9][0-9]{0,7}$",
	"IDnumber"=>"[0-9]{10}$",
	"Dateofbirth"=>"(^$|^(((0[1-9]|1[0-9]|2[0-8])[\/](0[1-9]|1[012]))|((29|30|31)[\/](0[13578]|1[02]))|((29|30)[\/](0[4,6,9]|11)))[\/](19|[2-9][0-9])\d\d$)|(^29[\/]02[\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)",
	"Dateofregistration"=>"(^$|^(((0[1-9]|1[0-9]|2[0-8])[\/](0[1-9]|1[012]))|((29|30|31)[\/](0[13578]|1[02]))|((29|30)[\/](0[4,6,9]|11)))[\/](19|[2-9][0-9])\d\d$)|(^29[\/]02[\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)\2(?:31))|(?:(?:0?[13-9]|1[0-2])\2(?:29|30))|(?:(?:0?[1-9])|(?:1[0-2]))\2(?:0?[1-9]|1\d|2[0-8])))))$",
	"Dateofdeath"=>"(^$|^(((0[1-9]|1[0-9]|2[0-8])[\/](0[1-9]|1[012]))|((29|30|31)[\/](0[13578]|1[02]))|((29|30)[\/](0[4,6,9]|11)))[\/](19|[2-9][0-9])\d\d$)|(^29[\/]02[\/](19|[2-9][0-9])(00|04|08|12|16|20|24|28|32|36|40|44|48|52|56|60|64|68|72|76|80|84|88|92|96)$)",
	

	"Sideeffect"=>"(^$|^(([A-Za-z0-9 \.])){1,50}$)",
	"Activesubstance"=>"(^$|^(([A-Za-z0-9 \.])){1,50}$)",
	"Type"=>"^(^$|^(([A-Za-z0-9 \.])){1,50}$)",
	"Record"=>"^.{1,1000}$"
);

$arrayerrormessages = array(
	"IDnumber"=>"ID number already exists in database!",
	"Username"=>"Username already exists in database!",
	"Pwd1"=>"Passwords don't match!",
	"Name"=>"Entry with such name already exists!", 
	"Visittimeto"=>"Has to be greater than time from!"
);

$arrayinputerrormessages = array(
	"Name" => "Has to contain only letters! (max.50)", 
	"Number" => "Has to contain only numbers! (max.8)",
	"PosNum" => "Has to contain only numbers and be greater than zero! (max.8)",
	"Street"=> "Has to contain letters, numbers and dots! (max.50)",
	"City"=> "Has to contain only letters and spaces! (max.50)",

	"Username"=> "Username has to contain letters, numbers, special '_' and '-'!",
	"Password"=> "Password has to have at least 6 characters! (max.50)",
	"Email"=> "Has to be in valid format (example@gmail.com)! ",

	"Weight"=>"Weight has to contain only max 3-digit number and 2-digit decimals separated by dot!",
	"Height"=>"Height has to contain only max 3-digit number and 2-digit decimals separated by dot!",
	"Healthcondition"=>"Health condition has to contain only letters, spaces and dots",


	"Zip"=> "Has to contain 4-digit or 5-digit number!",
	"IDnumber"=>"Has to contain 10-digit unique number!",
	"Dateofbirth"=> "Has to have format 01/01/1900 (dd/mm/yyyy) and be real existed date!",
	"Dateofregistration"=> "Has to have format 01/01/1900 (dd/mm/yyyy) and be real existed date!",
	"Dateofdeath"=> "Has to have format 01/01/1900 (dd/mm/yyyy) and be real existed date!",

	"Visittime"=>"Has to be in 24hr time format in range 14:00 - 17:00!",


	//medication
	"Activesubstance"=>"Has to contain only letters, numbers, spaces and dots!",
	"Sideeffect"=>"Has to contain only letters, numbers, spaces and dots!",

	//examination
	"Type"=>"Has to contain only letters, numbers, spaces and dots!"

);

$arraysideeffects = array("anxiety","cold","constipation","drowsiness","dizziness","dry mouth","decreased sex drive","ejaculatory disorder","headaches","heart palpitations","impotence","increase in appetite","insomnia","itching","loss of appetite","nervousness","nausea","rash","sneezing", "sore throat","stuffy nose", "upset stomach","weight changes","yellow skin");

$arrayspecializations = array("Allergist", "Anesthesiologist", "Cardiologist", "Dermatologist", "Hematologist", "Neurologist", "Oncologist");

$arraydoctordegrees = array("MUDr.","MUDr., Csc.","MUDr., DrSc.","MUDr., prof.","MUDr., doc.");

$arrayprocedures =array("buccal","oral","rectal","sublingual","urethal");

$arrayforms = array("capsule", 	"drops", "injection", "tablet", "liquid");

$arraysexs = array("Male", "Female");

$arraycompetences = array("full", "limited");

$arraynursedegrees = array("Bc.", "Mgr.");

$arrayfloors = array("1", "2", "3", "4", "5", "6", "7", "8", "9", "10", "11");
	
$arraycountries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");




?>