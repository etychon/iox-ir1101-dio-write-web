<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cisco IR1101 Digital IO Controller</title>
    
    <script src="external/jquery/jquery.js" type="text/javascript"></script>
    
    <script src="lc_switch.js" type="text/javascript"></script>
    <link rel="stylesheet" href="lc_switch.css">
    
    <style type="text/css">
    body * {
        font-family: Arial, Helvetica, sans-serif;
        box-sizing: border-box;
        -moz-box-sizing: border-box;	
    }
    h1 {
        margin-bottom: 10px;
        padding-left: 35px;	
    }
    a {
        color: #888;
        text-decoration: none;	
    }
    small {
        font-size: 13px;	
        font-weight: normal;
        padding-left: 10px;
    }
    
    #first_div {
        width: 90%; 
        max-width: 600px;
         min-width: 340px; 
         margin: 70px auto 0; 
         color: #444;
    }
    #second_div{
        width: 90%; 
        max-width: 600px; 
        min-width: 340px; 
        margin: 50px auto 0; 
        background: #f3f3f3; 
        border: 6px solid #eaeaea;
        padding: 20px 40px 40px; 
        text-align: center; 
        border-radius: 2px;
    }
    #third_div {
        width: 90%; 
        max-width: 600px; 
        min-width: 340px; 
        margin: 30px auto 0;	
    }
	#third_div small {
		float: right;
		color: #aaa;
		cursor: pointer;
		padding-top: 5px;	
	}
	#third_div ul {
		padding-left: 12px;	
		max-height: 200px;
		overflow: auto;
	}
	#third_div li {
		color: #777;
		font-size: 14px;
		line-height: normal;
		margin: 7px 0;	
	}
	#third_div li em {
		display: inline-block;
		width: 130px;
		color: #555;
		font-style: normal;	
	}
    </style>

</head>
<body>

	<div id="first_div">
        <h1>
        	IR1101 Digital IO Controller
            <small><a href="https://github.com/etychon" target="_blank">&copy; Emmanuel Tychon</a></small>
        </h1>
        <span>Toggle on/off the Digital IO ports below</span>
	</div>
    
    <div id="second_div">
        <form>
        
        <div style="float: left; width: 50%;">
            <p style="padding-bottom: 13px;"><em>Digital IO</em></p>
            
            <p>dio1   <input type="checkbox" name="dio1" value="1" class="lcs_check" autocomplete="off" " /></p>
            
            <p>dio2   <input type="checkbox" name="dio2" value="2" class="lcs_check" autocomplete="off" " /></p>
            
            <p>dio3   <input type="checkbox" name="dio3" value="3" class="lcs_check" autocomplete="off" " /></p>

            <p>dio4   <input type="checkbox" name="dio4" value="4" class="lcs_check" autocomplete="off" " /></p>
        </div>
        
        <div>
        </div>

        </form>
        <div style=" clear: both;"></div>
    </div>
	
    
    <div id="third_div">
    	<h3>
        	Events log: 
        	<small>(clean)</small>
        </h3>
        <ul></ul>
    </div>    
    <p></p>
    

    
    <script type="text/javascript">

    $(document).ready(function(e) {
        $('input').lc_switch();
    
        // triggered each time a field changes status
        $(document).on('lcs-statuschange', '.lcs_check', function() {
            var status 	= ($(this).is(':checked')) ? '1' : '0',
				subj 	= ($(this).attr('type') == 'radio') ? 'radio #' : 'checkbox #',
				num		= $(this).val(); 
				var name = $(this).attr('name');
            
			$('#third_div ul').prepend('<li><em>Change DIO'+ num +' to '+ status +' name='+name+'</li>');

			$('#third_div ul').prepend('echo '+ status +' > /dev/dio-' + num);

			var QB = {status : status, num: num};

			request = $.ajax({
			    url: "update.php",
			    method: "POST",
			    data: {
			        insert: JSON.stringify(QB)
                            },
                            success: function(data) {
                                $('#result').html(data);
                            }
                        });

                        request.done(function (response, textStatus, jqXHR){
                            // Log a message to the console
                            // console.log("Hooray, it worked! >> " + JSON.stringify(QB) + response);
                            // alert(response);
                        });


			// <?php
			//     echo "$('#third_div ul').prepend('Ran on server side!');";
			//    shell_exec('echo out > /dev/dio-'+num);
			//     shell_exec('echo '+ status +' > /dev/dio-' + num);
                        // ?>
                        
			// <input type="checkbox" name="dio1" value="1" class="lcs_check" autocomplete="off">
			//$(".lcs_check[name=dio4]").trigger('click');
                        // $('.lcs_check[name=dio4]').attr('checked', true);
                        // $('.lcs_check[name=dio4]').change();

        });

    });
		
    // clean events log
    $('#third_div small').click(function() {
        $('#third_div ul').empty();
    });
    </script>

</body>
</html>
