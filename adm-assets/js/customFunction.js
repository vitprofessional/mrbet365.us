
    //Form reset function
    function cqFormReset(a) {
        document.getElementById("cqForm"+a).reset();
        document.getElementById("cqReturn"+a).innerHTML = "0.00";
    }
    function fqFormReset(a) {
        document.getElementById("fqForm"+a).reset();
        document.getElementById("fqReturn"+a).innerHTML = "0.00";
    }
    function scqFormReset(a) {
        document.getElementById("scqForm"+a).reset();
        document.getElementById("scqReturn"+a).innerHTML = "0.00";
    }
    function sfqFormReset(a) {
        document.getElementById("sfqForm"+a).reset();
        document.getElementById("sfqReturn"+a).innerHTML = "0.00";
    }
    
    //Est return function
    function cqestReturn(a) {
      var x = document.getElementById("cqansRate"+a).value;
      var y = document.getElementById("cqBetAmount"+a).value;
      document.getElementById("cqReturn"+a).innerHTML = parseFloat(x*y).toFixed(2);
    }
    
    function scqestReturn(a) {
      var x = document.getElementById("scqansRate"+a).value;
      var y = document.getElementById("scqBetAmount"+a).value;
      document.getElementById("scqReturn"+a).innerHTML = parseFloat(x*y).toFixed(2);
    }
    
    function fqestReturn(a) {
      var x = document.getElementById("fqansRate"+a).value;
      var y = document.getElementById("fqBetAmount"+a).value;
      document.getElementById("fqReturn"+a).innerHTML = parseFloat(x*y).toFixed(2);
    }
    
    function sfqestReturn(a) {
      var x = document.getElementById("sfqansRate"+a).value;
      var y = document.getElementById("sfqBetAmount"+a).value;
      document.getElementById("sfqReturn"+a).innerHTML = parseFloat(x*y).toFixed(2);
    }
    
    //Single Bet Data Bet Placed
    //Fixed Question Query
    function fqSubmit(e){
        console.log("#fqForm "+e+" submitted")
        var formValues= $("#fqForm"+e+">form").serialize();

        $.post("dashboard/fqBetPlace", formValues, function(data){
            // Display the returned data in browser
            //console.log(data.fieldIndex)
            $("#fqSuccess"+data.fieldIndex).html(data.message);
            $("form").trigger("reset");
            //$('#fqForm').replaceWith(data.message);
            if(data.currBalance>=0){
                $("#userBalanceMT").html(parseFloat(data.currBalance).toFixed(2));
                $("#userBalanceDT").html(parseFloat(data.currBalance).toFixed(2));
                $("#userBalance").html(parseFloat(data.currBalance).toFixed(2));                
            }
            window.setTimeout(function() {
                $("#message-alert").fadeTo(2000, 500).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
            document.getElementById("fqReturn"+e).innerHTML = "0.00";
        });
    }
    
    function cqSubmit(e){
        console.log("#cqForm "+e+" submitted")
        var formValues= $("#cqForm"+e+">form").serialize();
    
        $.post("dashboard/cqBetPlace", formValues, function(data){
            // Display the returned data in browser
            //console.log(data.message)
            $("#cqSuccess"+data.fieldIndex).html(data.message);
            $("form").trigger("reset");
            //$('#fqForm').replaceWith(data.message);
            if(data.currBalance>=0){
                $("#userBalanceMT").html(parseFloat(data.currBalance).toFixed(2));
                $("#userBalanceDT").html(parseFloat(data.currBalance).toFixed(2));
                $("#userBalance").html(parseFloat(data.currBalance).toFixed(2));
                
            }
            window.setTimeout(function() {
                $("#message-alert").fadeTo(2000, 500).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
            document.getElementById("cqReturn"+e).innerHTML = "0.00";
        });
    }

    function sfqSubmit(e){
        console.log("#sfqForm "+e+" submitted")
        var formValues= $("#sfqForm"+e+">form").serialize();

        $.post("dashboard/fqBetPlace", formValues, function(data){
            // Display the returned data in browser
            //console.log(data.fieldIndex)
            $("#sfqSuccess"+data.fieldIndex).html(data.message);
            $("form").trigger("reset");
            //$('#fqForm').replaceWith(data.message);
            if(data.currBalance>=0){
                $("#userBalanceMT").html(parseFloat(data.currBalance).toFixed(2));
                $("#userBalanceDT").html(parseFloat(data.currBalance).toFixed(2));
                $("#userBalance").html(parseFloat(data.currBalance).toFixed(2));                
            }
            window.setTimeout(function() {
                $("#message-alert").fadeTo(2000, 500).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
            document.getElementById("sfqReturn"+e).innerHTML = "0.00";
        });
    }
    
    function scqSubmit(e){
        console.log("#scqForm "+e+" submitted")
        var formValues= $("#scqForm"+e+">form").serialize();
    
        $.post("dashboard/cqBetPlace", formValues, function(data){
            // Display the returned data in browser
            //console.log(data.message)
            $("#scqSuccess"+data.fieldIndex).html(data.message);
            $("form").trigger("reset");
            //$('#fqForm').replaceWith(data.message);
            if(data.currBalance>=0){
                $("#userBalanceMT").html(parseFloat(data.currBalance).toFixed(2));
                $("#userBalanceDT").html(parseFloat(data.currBalance).toFixed(2));
                $("#userBalance").html(parseFloat(data.currBalance).toFixed(2));
                
            }
            window.setTimeout(function() {
                $("#message-alert").fadeTo(2000, 500).slideUp(500, function(){
                    $(this).remove(); 
                });
            }, 5000);
            document.getElementById("scqReturn"+e).innerHTML = "0.00";
        });

    }