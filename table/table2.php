<?php
session_start();
require '../authenticate.php';


	$ch = curl_init();
	$url = "http://quip-data:9099/services/Camicroscope_DataLoader/DataLoader/query/getAll?api_key=226fa1f5-6476-4123-8cf5-fa1ec5ce1d83";
	// Disable SSL verification
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// Will return the response, if false it print the response
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// Set the url
	curl_setopt($ch, CURLOPT_URL,$url);
	// Execute
	$result=curl_exec($ch);
	// Closing
	curl_close($ch);

	// Will dump a beauty json :3
	//var_dump(json_decode($result, true));
?>

<html>

	<head>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" type="text/css"/>

        <link rel="stylesheet" href="style.css" type="text/css"/>
	<title>SEER VTR</title>
        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/d3/4.11.0/d3.min.js"> </script>
</head>
	<body>
		<h1 id="heading">SEER VTR</h1>
		<div id="s_search">
			<input type="text" id="search" placeholder="Search" onkeyup="search()"/>
		</div>
		<div id="table">
	</div>

		<script type="text/javascript" src="json-to-table.js"></script>
		<script type="text/javascript">
//			var data = JSON.parse('<?php echo $result; ?>');

function containsObject(obj, list) {
    var i;
    for (i = 0; i < list.length; i++) {
        if (list[i] === obj) {
            return true;
        }
    }

    return false;
}

function search(){
  // Declare variables
  var input, filter, table, tr, td, i;
  input = document.getElementById("search");
  filter = input.value.toUpperCase();
  table = document.getElementById("table");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
	var t = tr[i].getElementsByTagName("td");
	var td = tr[i].getElementsByTagName("td")[0];
	var key = "";
	for(var j=0; j<t.length; j++){
		var col = t[j].innerHTML.toUpperCase();
		key += " ";
		key += col;
	}
	//console.log(key);
	if(td){
	if(key.indexOf(filter) > -1){
		tr[i].style.display = "";
	} else {
		tr[i].style.display = "none";
	}
	}
    /*
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
    */
  }
}
var intersect2 = ['17033062', '17039870', '17039872', '17039876', '17039878', 'BC_056_0_1', 'PC_063_0_1', 'BC_519_1_1', 'BC_527_1_1', 'PC_052_0_1', 'PC_067_0_1', '17039806', '17039808', 'PC_061_0_2', 'PC_061_0_1', 'PC_055_0_1', 'PC_066_0_1', '17039816', '17039814', '17039812', '17039810', 'PC_054_1_2', '17039818', 'BC_346_1_2', 'PC_067_2_1', 'BC_346_1_1', '17033773', '17039888', '17039884', 'BC_201_1_1', 'BC_201_1_2', '17039880', 'BC_062_0_2', '17039828', 'BC_062_0_1', 'BC_514_1_1', '17044738', 'PC_054_1_1', 'BC_057_0_2', '17039826', 'BC_057_0_1', '17044732', 'PC_058_0_1', 'BC_264_1_1', 'BC_065_0_1', '17039824', 'BC_065_0_2', 'PC_064_0_1', 'BC_060_1_1', '17039894', '17039892', '17039890', '17043254', '17039836', '17039830', '17039832', 'PC_136_1_1', 'BC_096_1_1', 'BC_388_1_1', 'BC_388_1_2', 'BC_378_1_1', 'BC_519_1_2', 'BC_070_0_2', 'BC_070_0_1', 'PC_058_2_1', '17039917', '17039848', '17039925', '17039921', '17039840', '17039842', '17039844', 'PC_191_2_1', 'BC_184_1_2', 'BC_184_1_1', 'PC_227_2_1', 'BC_066_1_2', 'BC_066_1_1', 'BC_069_0_1', '17039910', 'PC_057_0_1', '17039858', 'BC_059_0_2', '17039852', '17039850', '17043484', 'PC_058_1_2', 'PC_058_1_1', 'BC_061_0_1', 'PC_062_0_1', 'BC_061_0_2', 'BC_068_0_1', '17039794', 'PC_054_0_1', '17039904', '17039902', '17039866', '17039860', 'BC_277_2_1', 'BC_277_2_2', 'BC_060_1_2', '17039788', 'BC_067_0_2', 'BC_067_0_1'];


var intersect = ['PC_055_0_1', 'PC_227_2_1', 'PC_058_2_1', 'BC_057_0_1', 'BC_096_1_1', 'BC_184_1_2', 'PC_062_0_1', 'BC_268_1_1', 'BC_059_0_1', 'BC_378_1_1', 'PC_058_1_2', 'BC_264_1_1', 'BC_067_0_2', 'BC_066_1_1', 'BC_068_0_1', 'BC_070_0_1', 'BC_065_0_1', 'BC_277_2_1', 'PC_054_0_1', 'PC_066_0_1', 'PC_052_0_1', 'BC_201_1_1', 'BC_057_0_2', 'PC_191_2_1', 'PC_061_0_1', 'PC_058_1_1', 'BC_065_0_2', 'BC_056_0_1', 'BC_062_0_2', 'BC_066_1_2', 'BC_527_1_1', 'PC_067_2_1', 'BC_519_1_2', 'BC_388_1_1', 'PC_050_0_1', 'BC_514_1_1', 'BC_346_1_2', 'BC_070_0_2', 'PC_136_1_1', 'BC_060_1_2', 'BC_346_1_1', 'PC_054_1_1', 'BC_277_2_2', 'BC_067_0_1', 'PC_064_0_1', 'BC_388_1_2', 'BC_061_0_1', 'BC_062_0_1', 'BC_201_1_2', 'BC_060_1_1', 'PC_054_1_2', 'BC_184_1_1', 'BC_061_0_2', 'BC_069_0_1', 'BC_059_0_2', 'PC_057_0_1', 'BC_519_1_1', 'PC_063_0_1', 'PC_061_0_2', 'PC_051_0_1', 'PC_067_0_1', 'PC_058_0_1', 'BC_184_1_2', '17039900', '17039882', '17039874', '17039788', '17039814', '17039812', '17039866', '17043252', '17039886', '17039820', '17039828', 'BC_066_1_2', '17039838', '17039868', '17039834', '17039852', 'BC_388_1_2', '17039927', '17043254', 'BC_059_0_2', 'PC_061_0_2', 'BC_061_0_2', '17039842', '17039921', 'PC_058_1_2', 'BC_067_0_2', '17039890', '17033062', '17039906', '17039846', '17039802', '17039888', '17039854', 'BC_062_0_2', '17039908', 'BC_070_0_2', '17039844', '17033773', '17039915', '17039790', '17039796', 'BC_277_2_2', '17039876', 'PC_054_1_2', '17039902', '17039816', '17039894', '17044738', '17044736', '17039923', 'BC_057_0_2', '17039848', 'BC_065_0_2', '17039794', '17039892', '17039806', '17039898', 'BC_346_1_2', 'BC_060_1_2', '17039830', '17039798', '17039904', '17039836', '17039858', '17039832', '17039917', '17039919', '17039884', 'BC_201_1_2', '17039896', '17044734', '17039840', '17039872', '17039808', '17043347', '17039860', '17039824', '17039818', '17043250', '17039870', '17039826', '17039862', '17039925', '17043485', 'BC_519_1_2', '17043259', '17039856', '17044732', '17039864', '17039822', '17039910', '17039804', '17043484', '17039800', '17039810', '17039878', '17039850', '17039792', '17039880']

var SEER_VTR_image_list =['17039922','17039789','17039920','17039897','17039875','17039876','17039871','17039872','17044732','17039787','17039788','17043254','17044738','17039823','17039824','17039895','17039825','17039826','17039833','17039861','17039877','17039878','17039891','17039892','17039889','17039890','17039885','17039873','17039880','17039869','17039870','17039840','17039827','17039828','17039836','17039829','17039830','17039841','17039842','17043436','17043484','17039831','17039832','17039843','17039844','BC_056_0_1','BC_057_0_1','BC_057_0_2','BC_059_0_2','BC_060_1_1','BC_060_1_2','BC_061_0_1','BC_061_0_2','BC_062_0_1','BC_062_0_2','BC_065_0_1','BC_065_0_2','BC_066_1_1','BC_066_1_2','BC_067_0_1','BC_067_0_2','BC_068_0_1','BC_069_0_1','BC_070_0_1','BC_070_0_2','BC_096_1_1','BC_184_1_1','BC_184_1_2','BC_201_1_1','BC_201_1_2','BC_264_1_1','BC_277_2_1','BC_277_2_2','BC_346_1_1','BC_346_1_2','BC_378_1_1','BC_388_1_1','BC_388_1_2','BC_514_1_1','BC_519_1_1','BC_519_1_2','BC_527_1_1','17032555','17032556','17032557','17032558','17032559','17033361','17032560','17032561','17032562','17032563','17032564','17033080','17033042','17032565','17035672','17032597','17033044','17033045','17033079','17035673','17033046','17033047','17033048','17035674','17032566','17032567','17032568','17032569','17032570','17032571','17033362','17032596','17033050','17032572','17035679','17033051','17032573','17033052','17033772','17033773','17033040','17032574','17032575','17032576','17033055','17033057','17032577','17032578','17033056','17033058','17032579','17033059','17032580','17032581','17032582','17032583','17032584','17032585','17032586','17032587','17032595','17032588','17033060','17032589','17032590','17032591','17033061','17035678','17032592','17033063','17033062','17033064','17032593','17033065','17033081','17032594','17039925','17039813','17039814','17039858','17039910','17039816','17039818','17039859','17039860','17039801','17039806','17039807','17039808','17039809','17039810','17039811','17039812','17039853','17039883','17039884','17039887','17039888','17039917','17039819','17039821','17039850','17039894','17039914','17039863','17039926','17039845','17039851','17039852','17039865','17039866','17039902','17039848','17039904','PC_052_0_1','PC_054_0_1','PC_054_1_1','PC_054_1_2','PC_055_0_1','PC_057_0_1','PC_058_0_1','PC_058_1_1','PC_058_1_2','PC_058_2_1','PC_061_0_1','PC_061_0_2','PC_062_0_1','PC_063_0_1','PC_064_0_1','PC_066_0_1','PC_067_0_1','PC_067_2_1','PC_136_1_1','PC_191_2_1','PC_227_2_1','17032547','17032548','17032549','17033066','17035671','17033067','17032550','17033068','17033069','17033070','17033071','17033072','17032551','17033073','17035676','17033074','17032599','17032553','17033075','17033076','17033077','17035677','17033078','17039927', '17039924', '17039879', '17039862', '17039901', '17039921', '17039817','17039794', '17039802', '17039805', '17039820', '17039791', '17039835', '17039893', '17043251', '17043259', '17039796', '17039790', '17043249', '17039815', '17039792','17039868', '17044735', '17039916', '17039798', '17039799', '17039905', '17043485','17039838', '17039855', '17039919', '17039797', '17039856', '17044733', '17043250','17039846', '17039795', '17043366', '17039793', '17044737','PC_050_0_1', 'PC_051_0_1', '17044731', '17039804', '17039915', '17039918', '17039923', '17039864','17039822', '17039847', '17039839', '17043255', '17039803', '17039900', '17043252', '17039882', '17043347', '17039834', '17043253','17044734', '17039857', '17039909', '17039886', '17039849', '17039908', '17039854', '17039837', '17039800', '17039874','17039906','17039903','17039907','BC_268_1_1','17043486','17044736']

var whole_slide_list=['17032547','17033063','17039825','17039895','17044736','17032548','17033064','17039826','17039896','17044737','17032549','17033065','17039827','17039897','17044738','17032550','17033066','17039828','17039898','BC_056_0_1','17032551','17033068','17039829','17039899','BC_057_0_1','17032553','17033069','17039830','17039900','BC_057_0_2','17032554','17033070','17039831','17039901','BC_059_0_1','17032555','17033071','17039832','17039902','BC_059_0_2','17032556','17033072','17039833','17039903','BC_060_1_1','17032557','17033073','17039834','17039904','BC_060_1_2','17032558','17033074','17039835','17039905','BC_061_0_1','17032559','17033075','17039836','17039906','BC_061_0_2','17032560','17033076','17039837','17039907','BC_062_0_1','17032561','17033077','17039838','17039908','BC_062_0_2','17032562','17033078','17039839','17039909','BC_063_0_1','17032563','17033079','17039840','17039910','BC_063_0_2','17032564','17033080','17039841','17039911','BC_065_0_1','17032565','17033081','17039842','17039914','BC_065_0_2','17032566','17033361','17039843','17039915','BC_066_1_1','17032567','17033362','17039844','17039916','BC_066_1_2','17032568','17033772','17039845','17039917','BC_067_0_1','17032569','17033773','17039846','17039918','BC_067_0_2','17032570','17035671','17039847','17039919','BC_068_0_1','17032571','17035672','17039848','17039920','BC_069_0_1','17032572','17035673','17039849','17039921','BC_070_0_1','17032573','17035674','17039850','17039922','BC_070_0_2','17032574','17035675','17039851','17039923','BC_096_1_1','17032575','17035676','17039852','17039924','BC_184_1_1','17032576','17035677','17039853','17039925','BC_184_1_2','17032577','17035678','17039854','17039926','BC_201_1_1','17032578','17035679','17039855','17039927','BC_201_1_2','17032579','17039787','17039856','17040239','BC_264_1_1','17032580','17039788','17039857','17040241','BC_268_1_1','17032581','17039789','17039858','17040242','BC_277_2_1','17032582','17039790','17039859','17040245','BC_277_2_2','17032583','17039791','17039860','17040246','BC_346_1_1','17032584','17039792','17039861','17040253','BC_346_1_2','17032585','17039793','17039862','17040257','BC_378_1_1','17032586','17039794','17039863','17040259','BC_388_1_1','17032587','17039795','17039864','17040278','BC_388_1_2','17032588','17039796','17039865','17040279','BC_514_1_1','17032589','17039797','17039866','17040280','BC_519_1_1','17032590','17039798','17039868','17040281','BC_519_1_2','17032591','17039799','17039869','17040282','BC_527_1_1','17032592','17039800','17039870','17040283','PC_050_0_1','17032593','17039801','17039871','17040285','PC_051_0_1','17032594','17039802','17039872','17040384','PC_052_0_1','17032595','17039803','17039873','17042092','PC_054_0_1','17032596','17039804','17039874','17042094','PC_054_1_1','17032597','17039805','17039875','17042095','PC_054_1_2','17032599','17039806','17039876','17043249','PC_055_0_1','17033040','17039807','17039877','17043250','PC_057_0_1','17033042','17039808','17039878','17043251','PC_058_0_1','17033044','17039809','17039879','17043252','PC_058_1_1','17033045','17039810','17039880','17043253','PC_058_1_2','17033046','17039811','17039881','17043254','PC_058_2_1','17033047','17039812','17039882','17043255','PC_061_0_1','17033048','17039813','17039883','17043259','PC_061_0_2','17033050','17039814','17039884','17043347','PC_062_0_1','17033051','17039815','17039885','17043366','PC_063_0_1','17033052','17039816','17039886','17043436','PC_064_0_1','17033055','17039817','17039887','17043484','PC_065_0_1','17033056','17039818','17039888','17043485','PC_065_0_2','17033057','17039819','17039889','17043486','PC_066_0_1','17033058','17039820','17039890','17044731','PC_067_0_1','17033059','17039821','17039891','17044732','PC_067_2_1','17033060','17039822','17039892','17044733','PC_136_1_1','17033061','17039823','17039893','17044734','PC_191_2_1','17033062','17039824','17039894','17044735','PC_227_2_1']

var tumor_region_only=['17032547','17033044','17039796','17040245','BC_201_1_1','17032548','17033045','17039798','17040246','BC_264_1_1','17032549','17033046','17039800','17040253','BC_268_1_1','17032550','17033047','17039802','17040257','BC_277_2_1','17032551','17033048','17039808','17043249','BC_277_2_2','17032555','17033050','17039814','17043250','BC_346_1_1','17032556','17033052','17039816','17043251','BC_346_1_2','17032557','17033055','17039818',  '17043252','BC_388_1_1','17032558','17033056','17039819','17043253','BC_388_1_2','17032559','17033057','17039825','17043254','BC_519_1_2','17032560','17033058','17039826','17043486','BC_527_1_1','17032561','17033059','17039833',  '17044731','PC_050_0_1','17032562','17033066','17039834','17044732','PC_051_0_1','17032563','17033067','17039849','17044737','PC_052_0_1','17032564','17033068','17039856','17044738','PC_054_0_1','17032565','17033069','17039858',  'BC_056_0_1','PC_054_1_1','17032566','17033070','17039860','BC_057_0_1','PC_054_1_2','17032567','17033071','17039877','BC_057_0_2','PC_055_0_1','17032568','17033072','17039883','BC_059_0_1','PC_057_0_1','17032569','17033079', '17039895','BC_059_0_2','PC_058_0_1','17032570','17033080','17039896','BC_060_1_1','PC_058_1_1','17032571','17033361','17039897','BC_060_1_2','PC_058_1_2','17032572','17033362','17039898','BC_061_0_1','PC_058_2_1','17032573',  '17033772','17039899','BC_061_0_2','PC_061_0_1','17032574','17033773','17039900','BC_062_0_1','PC_061_0_2','17032575','17035671','17039906','BC_062_0_2','PC_062_0_1','17032576','17035672','17039910','BC_063_0_1','PC_063_0_1','17032577','17035673','17039915','BC_063_0_2','PC_064_0_1','17032578','17035674','17039916','BC_065_0_1','PC_065_0_2','17032579','17035676','17039919','BC_066_1_1','PC_066_0_1','17032580','17035679','17039920','BC_067_0_1', 'PC_067_0_1','17032582','17039789','17039921','BC_067_0_2','PC_067_2_1','17032596','17039790','17039922','BC_068_0_1','PC_136_1_1','17032597','17039791','17039923','BC_069_0_1','PC_191_2_1','17032599','17039792','17040239',  'BC_096_1_1','PC_227_2_1','17033040','17039793','17040241','BC_184_1_1','17033042','17039794','17040242','BC_184_1_2']

var tumor_20um=['17032547','17032582','17035671','17039895','17044737','BC_388_1_1','17032548','17032596','17035672','17039896','17044738',  'BC_388_1_2','17032549','17032597','17035673','17039897','BC_056_0_1','BC_519_1_2',
'17032550','17032599','17035674','17039898','BC_057_0_1','BC_527_1_1','17032551','17033040','17035676','17039899','BC_057_0_2','PC_050_0_1','17032555','17033042','17035679','17039900','BC_059_0_1','PC_051_0_1','17032556','17033044','17039789','17039906','BC_059_0_2','PC_052_0_1','17032557','17033045','17039790','17039910','BC_060_1_1','PC_054_0_1','17032558','17033046','17039791','17039915','BC_060_1_2','PC_054_1_1','17032559','17033047','17039792','17039916','BC_061_0_1','PC_054_1_2','17032560','17033048','17039793','17039919','BC_061_0_2','PC_055_0_1','17032561','17033050','17039794','17039920','BC_062_0_1','PC_057_0_1','17032562','17033052','17039796','17039921','BC_062_0_2','PC_058_0_1','17032563','17033055','17039798','17039922','BC_063_0_1','PC_058_1_1','17032564','17033056','17039800','17039923','BC_063_0_2','PC_058_1_2','17032565','17033057','17039802','17040239','BC_065_0_1','PC_058_2_1','17032566','17033058','17039808','17040241','BC_066_1_1','PC_061_0_1','17032567','17033059','17039814','17040242','BC_067_0_1','PC_061_0_2','17032568','17033066','17039816','17040245','BC_067_0_2','PC_062_0_1',
'17032569','17033067','17039818','17040246','BC_068_0_1','PC_063_0_1','17032570','17033068','17039819','17040253','BC_069_0_1','PC_064_0_1','17032571','17033069','17039825','17040257','BC_096_1_1','PC_065_0_2','17032572','17033070','17039826','17043249','BC_184_1_1','PC_066_0_1','17032573','17033071','17039833','17043250','BC_184_1_2','PC_067_0_1','17032574','17033072','17039834','17043251','BC_201_1_1','PC_067_2_1','17032575','17033079','17039849','17043252','BC_264_1_1','PC_136_1_1','17032576','17033080','17039856','17043253','BC_268_1_1','PC_191_2_1','17032577','17033361','17039858','17043254','BC_277_2_1','PC_227_2_1','17032578','17033362','17039860','17043486','BC_277_2_2','17032579','17033772','17039877','17044731','BC_346_1_1','17032580','17033773','17039883','17044732','BC_346_1_2'];

//	console.log(intersect.length);
			var newData = [];
			d3.csv("data.csv", function(data){
				for(var i in data){
					data[i]['Subject ID'] = data[i]['Display_ID'];
					data[i]['Cancer Type'] = data[i]['Cancer_Type'];
					delete data[i]['Cancer_Type'];
					delete data[i]['Subject_ID'];
					delete data[i]['Display_ID'];
					data[i]['r'] = data[i]['Registry'];
					delete data[i]['Registry'];
					data[i]['Registry'] = data[i]['r'];
					delete data[i]['r'];
					delete data[i]['width']; delete data[i]['height'];
					delete data[i]['SetId']; //delete data[i]['Subject_ID'];
					if(data[i]['Registry'] == "Iowa" || data[i]['Registry'] == "Connecticut"){
						data[i]['case_id'] = data[i]['DxSlide1_FileName'];
					} else {
						data[i]['case_id'] = data[i]['Reformatted_DxSlide1_BarcodeID'];
					}
					data[i]['Case/Control'] = data[i]['Case_Control_Description'];
					delete data[i]['Case_Control_Description'];
					data[i]['Registry2'] = data[i]['Registry'];
					delete data[i]['Registry'];
					data[i]['Registry'] = data[i]['Registry2'];
					delete data[i]['Registry2'];
					var registry = data[i]['Registry'];
					if(registry == 'Iowa'){
						registry= 'R1';
					} else if(registry == 'Connecticut') {
						registry = 'R2';
					} else if(registry == 'Hawaii'){
						registry = 'R3';
					}
					data[i]['Registry'] = registry;
					data[i]['View Image'] =  "<a href='../camicroscope/osdCamicroscope.php?db_name=quip_comp&tissueId="+ data[i]['case_id']+"'>"+ data[i]['Reformatted_DxSlide1_BarcodeID'] + "</a>"
					data[i]['Loading Date/Time']=data[i]['loading_date_time'];
                                        delete data[i]['loading_date_time'];
					data[i]['Link to TIL heatmaps'] = "<a href='http://quip3.bmi.stonybrook.edu/camicroscope/osdCamicroscope_Lymph.php?tissueId="+data[i]['case_id']+"'>TIL heatmaps</a>";
					data[i]['Link to Download Nuclear Curated Features'] = "<a href='../featurescapeapps/featurescape/u24Preview.php?db_name=quip_comp&case_id="+ data[i]['case_id']+"'>View Features</a>";
					data[i]['Link to curated CSV'] = "<a href='../composite_results/"+data[i]['case_id']+".zip'>Download</a>";

					if(whole_slide_list.indexOf(data[i]['case_id']+"") >=0 ){
                                           whole_slide_file_path="/cluster_indices/whole_slide/whole_slide_"+data[i]['case_id']+".zip";
                                           data[i]['Link to whole_slide zip file'] = "<a href='http://quip3.bmi.stonybrook.edu"+whole_slide_file_path+"'>Download</a>";
                                        } else {
                                          data[i]['Link to whole_slide zip file'] = "";
                                        }

                                        if(tumor_region_only.indexOf(data[i]['case_id']+"") >=0 ){
                                          tumor_region_only_file_path="/cluster_indices/tumor_region_only/tumor_region_only_"+data[i]['case_id']+".zip";
                                          data[i]['Link to tumor_region_only zip file'] = "<a href='http://quip3.bmi.stonybrook.edu"+tumor_region_only_file_path+"'>Download</a>";
                                        } else {
                                          data[i]['Link to tumor_region_only zip file'] = "";
                                        }

                                        if(tumor_20um.indexOf(data[i]['case_id']+"") >=0 ){
                                           tumor_20um_file_path="/cluster_indices/tumor_20um/tumor_20um_"+data[i]['case_id']+".zip";
                                           data[i]['Link to tumor_20um zip file'] = "<a href='http://quip3.bmi.stonybrook.edu"+tumor_20um_file_path+"'>Download</a>";
                                        } else {
                                           data[i]['Link to tumor_20um zip file'] = "";
                                        }

					delete data[i]['Images'];
					delete data[i]['Original_DxSlide1_BarcodeID'];
					delete data[i]['Reformatted_DxSlide1_BarcodeID'];
					delete data[i]['DxSlide1_FileName'];

					//console.log(intersect2);
					if(SEER_VTR_image_list.indexOf(data[i]['case_id']+"") >=0 ){
						delete data[i]['case_id'];
						newData.push(data[i]);
					}
					//newData = data;

				}
				var table =ConvertJsonToTable(newData, 'tbl' ,null, "Download");

				$("#table").append(table);

			});
		</script>
	</body>
</html>
