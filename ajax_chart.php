<!DOCTYPE html>
<html>
<head>
	<title></title>

	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
</head>
<body>


  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  
   <script type="text/javascript">
   		google.load('visualization', '1', {packages: ['corechart', 'bar']});
google.setOnLoadCallback(my_ajax);

function drawRightY(y) {
	console.log("inside draw");
	console.log(y);
      var data = google.visualization.arrayToDataTable(
      	y);

      var options = {
        chart: {
          title: 'percentage of order in differnt category',
          subtitle: ''
        },
        hAxis: {
          title: 'Total Population',
          minValue: 0,
        },
        vAxis: {
          title: 'City'
        },
        bars: 'vertical',
        axes: {
          y: {
            0: {side: 'right'}
          }
        }
      };
      var material = new google.charts.Bar(document.getElementById('chart_div'));
      material.draw(data, options);
    }

       function graph(x){
    console.log("x is");
    console.log(x);
      var myData = new Array();
      myData[0] =   ['category', 'percentage'];
  for(var i=0; i<= x.length-1; i++){
    //console.log(myData);
    myData[i+1]=x[i];
    //myData[i-1]=  [i,x[i-1][1]];
  }
  console.log("my data");
  console.log(myData);
  drawRightY(myData);


   }

    function my_ajax(start,end){

      $.ajax({
        url: "dynamic.php",
         beforeSend: function() {
        $('#chart_div').html("<img src='ajax-loader.gif' />");
        }, 
        type: "GET",
        data: "start="+ start +"& end="+end,
        success: function(result){
          
       try {
         console.log("output of ajax ");
          result = $.parseJSON(result);
           var myData = new Array();
         myData[0] =   ['category', 'percentage'];
         var i = 1;
          $.each(result, function(key, val) {
            console.log(key, val);
             myData[i]=[key,val];
             i +=1;
          });
          console.log(myData);
          //var result = result;
          drawRightY(myData);
       // graph(result);
       my_ajax();
      }
      catch(err) {
         my_ajax();
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
       my_ajax();
    }       

  });

    }
   </script>
<div class="row">
    <div id="chart_div" style="height:400px; width: 800px; margin:0 auto; margin-top:200px"><div>
   </div>


   

   <script type="text/javascript">

   </script>
</body>
</html>