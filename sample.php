<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <html lang="en">

        <head>

            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <meta name="description" content="GRIDER is a tech-powered on-demand, hyperlocal delivery service that delivers anything from anywhere in your city within 90 minutes">
            <meta name="keywords" content=" On demand delivery, express delivery, hyperlocal, delivery technology, last mile logistics, last mile delivery, 90 minute delivery, emerging markets">
             <meta name="author" content="">
            
            <title>Gray Routes Innovative Distribution</title>
            <link rel="icon" 
      type="image/png" 
      href="img/griderit_logo.png" />
            <!-- Bootstrap Core CSS -->
            <link href="css/bootstrap.css" rel="stylesheet">

            <!-- Custom CSS -->
            <link rel="stylesheet" href="css/main.css">
            <link href="css/custom.css" rel="stylesheet">

            <script src="//use.edgefonts.net/bebas-neue.js"></script>

            <!-- Custom Fonts & Icons -->
            <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,600,800' rel='stylesheet' type='text/css'>
            <link rel="stylesheet" href="css/icomoon-social.css">
            <link rel="stylesheet" href="css/font-awesome.min.css">
<link rel="stylesheet" href="build/css/demo1.css">
            <script src="js/modernizr-2.6.2-respond-1.1.0.min.js"></script>

            <link rel="stylesheet" href="animate.css">
            <link rel="stylesheet" href="build/css/intlTelInput.css">
            <link rel="stylesheet" href="build/css/isValidNumber.css">
            <link rel="stylesheet" href="build/css/prism.css">
     
          
              
    
            <!--link rel="icon" 
      type="image/png" 
      href="img/logo.png" sizes="5x5"-->
              <style>
                  .breadcrumb > li + li::before {
                    //color: #ccc;
                    content: " ";
                    //padding: 0 5px;
                }
              </style>

        </head>

        <body>
            
            <!--[if lt IE 7]>
                <p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
            <![endif]-->

            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
            <ol class="breadcrumb">
                <li></li>
                <li></li>
                <li></li>
                <li><image class="logo" style="width: 50px;height: 50px;" src="img/griderit_logo.png"/></li>
                </ol>
            <div class='container'>
                
    <div class="row">
        
        <div class="col-md-6">
            <h1 style="font-size: 30px;font-weight: normal;line-height: 1;">Download the app</h1>
            <p>Get GRIDER on your iPhone or Android device. It's easy. Just send yourself a text message to download.</p>
       
             
            <input id="phone" type="text">
            <span style='font-size: 12px' id="valid-msg" class="hide">✓ Valid</span>
<span style='font-size: 12px' id="error-msg" class="hide">Invalid number</span>
<button disabled id="send_btn" class="btn btn-blue" type="submit" onclick="sendMessage();">Send</button>
          <br><br>
          <div id="ack"></div>
          
            <h5>Standard SMS fees may apply.</h5>
<div>
<a href="home.php">Don’t have an iPhone or Android device?</a>
</div>
        </div>         
            
        <div class="col-md-6">
            <img src="img/GRIDER_IT.png" alt="image1">
              </div>
            </div>
   
    </div>
            <script src="build/js/intlTelInput.js"></script>
            <script src="build/js/intlTelInput.min.js"></script>
            <!--script src="build/js/isValidNumber.js"></script-->
            <script src="build/js/prism.js"></script>
            
            
            <script>
                 /*
      $("#phone").intlTelInput({
        //allowExtensions: true,
        //autoFormat: false,
        //autoHideDialCode: false,
       //autoPlaceholder: true,
        //defaultCountry: "auto",
        //ipinfoToken: "yolo",
        nationalMode: false,
        //numberType: "MOBILE",
        //onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
        preferredCountries: ['in'],
       utilsScript: "lib/libphonenumber/build/utils.js"
     });
     
     $("#phone").click(function () {
       //var ackmsg = $("#ack");       
         //ackmsg.addClass("hide");
         //alert('okk');
         document.getElementById('ack').innerHTML = '';
   });
   
     */
    var telInput = $("#phone"),
  errorMsg = $("#error-msg"),
  validMsg = $("#valid-msg");

      $("#phone").intlTelInput({
        //allowExtensions: true,
        //autoFormat: false,
        //autoHideDialCode: false,
       //autoPlaceholder: true,
        //defaultCountry: "auto",
        //ipinfoToken: "yolo",
        nationalMode: false,
        //numberType: "MOBILE",
        //onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
        preferredCountries: ['in'],
       utilsScript: "lib/libphonenumber/build/utils.js"
     });
     
     $("#phone").click(function () {
       //var ackmsg = $("#ack");       
         //ackmsg.addClass("hide");
         //alert('okk');
         document.getElementById('ack').innerHTML = '';
   
   });
// on blur: validate
telInput.blur(function() {
  if ($.trim(telInput.val())) {
    if (telInput.intlTelInput("isValidNumber")) {
      validMsg.removeClass("hide");
      document.getElementById('send_btn').disabled = false;
    } else {
      telInput.addClass("error");
      errorMsg.removeClass("hide");
      validMsg.addClass("hide");
      
    }
  }
});

// on keydown: reset
telInput.keydown(function() {
  telInput.removeClass("error");
  errorMsg.addClass("hide");
  validMsg.addClass("hide");
});
     function sendMessage()
     {
          var ackmsg = $("#ack");       
         ackmsg.addClass("show");
        var phone = $('#phone').val();
        
        $.ajax({
				url: "sendSms.php",
				type: 'POST',
				data: {
                                    phone : phone
                                    
                                },
				success: function (result) {
					try
                                        {
                                            if(result.trim()=='true')
                                            {
                                           $('#ack').css('color','green');
        document.getElementById('ack').innerHTML="Success! We just sent you a link to download.";
    }
    else
    {
        $('#ack').css('color','red');
        document.getElementById('ack').innerHTML="Please try again!";
    }
                                                                      
        }
                                        catch (e) {
                                           $('#ack').css('color','red');
        document.getElementById('ack').innerHTML="Please try again!";
                                        }
				},
                                 error: function(jq,status,message) {
                                     $('#ack').css('color','red');
        document.getElementById('ack').innerHTML="Please try again!";
                                }
                            });
        
     }
  
    </script>    
        </body>
        
    </html>