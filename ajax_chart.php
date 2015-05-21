<!DOCTYPE html>
<html>
<head>
	<title></title>

	<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
</head>
<body>


  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
  
   <script type="text/javascript">

   $( document ).ready(function() {
     var today = new Date();

      var mm = today.getMonth()+1; //January is 0!
      var yyyy = today.getFullYear();

     

      if(mm<10) {
          mm='0'+mm;
      } 
start1 = yyyy+'-'+mm+'-01';
    end  = yyyy+'-'+mm+'-31';
     // today = mm+'/'+dd+'/'+yyyy;

        my_ajax(start1,end);
});

   		google.load('visualization', '1', {packages: ['corechart', 'bar']});
//google.setOnLoadCallback(my_ajax);

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

       myFunction();
     // var nyX = 8175000;
      //var nyY = 8008000;

          function myFunction() {
            setTimeout(function(){
                //alert("Hello");
                    /*data = google.visualization.arrayToDataTable([
            ['Time(mins)', '2010 Population'],
            ['1-5', nyX],
            ['6-10', 3792000],
            ['11-15', 2695000]
            
          ]);
          material.draw(data, options);
          nyX += 1000000;
          nyY += 1000;*/
          

              var today = new Date();

      var mm = today.getMonth()+1; //January is 0!
      var yyyy = today.getFullYear();

     
      var dd = today.getDate();
      var from = dd -15;
      if(dd<10) {
          dd='0'+dd
      } 
      if(mm<10) {
          mm='0'+mm;
      } 
start1 = yyyy+'-'+mm+'-'+from;
    end  = yyyy+'-'+mm+'-'+dd;
     // today = mm+'/'+dd+'/'+yyyy;

        

        data = google.visualization.arrayToDataTable(my_ajax(start1,end));


          
                myFunction();
            }, 3000);
        }
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

    function my_ajax(start1,end){
      console.log("inside my ajax");
      
     

        console.log(start1);
      console.log(end); 

      $.ajax({
        url: "dynamic.php",
         beforeSend: function() {
        //$('#chart_div').html("<img src='ajax-loader.gif' />");
        }, 
        type: "GET",
        data: "start="+ start1 +"& end="+end,
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
       //my_ajax(start1,end);
       return myData;
      }
      catch(err) {
         //my_ajax(start,end);
      }
    },
    error: function(XMLHttpRequest, textStatus, errorThrown) { 
       my_ajax(start1,end);
    }       

  });

    }
   </script>
   <div class="row">
   <div class="container">

</div>
   </div>
<div class="row">
    <div id="chart_div" style="height:400px; width: 800px; margin:0 auto; margin-top:200px"><div>
   </div>


   

   <script type="text/javascript">
    $('#chart_div').html("<img src='ajax-loader.gif' />");
   </script>
</body>
</html>