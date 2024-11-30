function estAmtCount(e){
    var amount = document.getElementById("betAmount"+e).value;
    var rate = document.getElementById("answerRate"+e).value;
    var returnAmount = amount*rate;
    document.getElementById("estReturn"+e).innerHTML = returnAmount.toFixed(2);
}
function sestAmtCount(e){
    var amount = document.getElementById("sbetAmount"+e).value;
    var rate = document.getElementById("sanswerRate"+e).value;
    var returnAmount = amount*rate;
    document.getElementById("sestReturn"+e).innerHTML = returnAmount.toFixed(2);
}    

//Single Bet Data Bet Placed
function fqReset(e){
    $("#fqSuccess"+e).hide();
    $("#estReturn").html("0.00");
    $("form").trigger("reset");
    $("#fqForm"+e).find("*").prop("disabled", false);
    $("#fqForm"+e).show();
}
function sfqReset(e){
    $('#sfqSuccess'+e).hide();
    $('#sestReturn').html("0.00");
    $("form").trigger("reset");
    $("#sfqForm"+e).find("*").prop("disabled", false);
    $("#sfqForm"+e).show();
}
function cqReset(e){
    $('#cqSuccess'+e).hide();
    $('#estReturn').html("0.00");
    $("form").trigger("reset");
    $("#cqForm"+e).find("*").prop("disabled", false);
    $("#cqForm"+e).show();
}
function scqReset(e){
    $('#scqSuccess'+e).hide();
    $('#sestReturn').html("0.00");
    $("form").trigger("reset");
    $("#scqForm"+e).find("*").prop("disabled", false);
    $("#scqForm"+e).show();
}
//Fixed Question Query
function fqSubmit(e){
    var formValues= $("#fqForm"+e+">form").serialize();
    // $("#fqSuccess"+e).html("<div class='alert alert-success'>Bet are processing. Please wait.....</div>");
    document.getElementById("fqProcess"+e).innerHTML = "<div class='alert alert-success'>Bet processing. Please wait.....</div>";
    $("#fqForm"+e).hide();
    $.post("/dashboard/fqBetPlace", formValues, function(data){
        // Display the returned data in browser
        //console.log(data.fieldIndex)
        document.getElementById("fqProcess"+e).innerHTML = "";
        $("#fqSuccess"+data.fieldIndex).show();
        $("#fqSuccess"+data.fieldIndex).html(data.message);
        $("#fqForm"+e).find("*").prop("disabled", true);
        // document.getElementById("estReturn"+e).innerHTML = "0.00";
        $('#estReturn').html("0.00");
        $("form").trigger("reset");
        //$('#fqForm').replaceWith(data.message);
        if(data.currBalance>=0){
            $("#userBalanceMT").html(parseFloat(data.currBalance).toFixed(2));
            $("#userBalanceDT").html(parseFloat(data.currBalance).toFixed(2));
            $("#userBalance").html(parseFloat(data.currBalance).toFixed(2));                
        }
        // window.setTimeout(function() {
        //     $("#message-alert").fadeTo(2000, 500).slideUp(500, function(){
        //         $(this).remove(); 
        //     });
        // }, 5000);
    });
}

function cqSubmit(e){
    console.log("#cqForm "+e+" submitted")
    var formValues= $("#cqForm"+e+">form").serialize();
    document.getElementById("cqBetProcess"+e).innerHTML = "<div class='alert alert-success'>Bet processing. Please wait.....</div>";
    $("#cqForm"+e).hide();

    $.post("/dashboard/cqBetPlace", formValues, function(data){
        // Display the returned data in browser
        //console.log(data.message)
        $("#cqSuccess"+data.fieldIndex).show();
        $("#cqSuccess"+data.fieldIndex).html(data.message);
        document.getElementById("cqBetProcess"+e).innerHTML = "";
        document.getElementById("estReturn"+e).innerHTML = "0.00";
        $("#cqForm"+e).find("*").prop("disabled", true);
        $("form").trigger("reset");
        //$('#fqForm').replaceWith(data.message);
        if(data.currBalance>=0){
            $("#userBalanceMT").html(parseFloat(data.currBalance).toFixed(2));
            $("#userBalanceDT").html(parseFloat(data.currBalance).toFixed(2));
            $("#userBalance").html(parseFloat(data.currBalance).toFixed(2));
            
        }
        // window.setTimeout(function() {
        //     $("#message-alert").fadeTo(2000, 500).slideUp(500, function(){
        //         $(this).remove(); 
        //     });
        // }, 5000);
    });

}

function sfqSubmit(e){
    console.log("#sfqForm "+e+" submitted")
    var formValues= $("#sfqForm"+e+">form").serialize();
    document.getElementById("sfqProcess"+e).innerHTML = "<div class='alert alert-success'>Bet processing. Please wait.....</div>";
    $("#sfqForm"+e).hide();

    $.post("/dashboard/fqBetPlace", formValues, function(data){
        // Display the returned data in browser
        //console.log(data.fieldIndex)
        $("#sfqSuccess"+data.fieldIndex).show();
        $("#sfqSuccess"+data.fieldIndex).html(data.message);
        $("#sfqForm"+e).hide();
        document.getElementById("sfqProcess"+e).innerHTML = "";
        $('#sestReturn').html("0.00");
        $("#sfqForm"+e).find("*").prop("disabled", true);
        $("form").trigger("reset");
        //$('#fqForm').replaceWith(data.message);
        if(data.currBalance>=0){
            $("#userBalanceMT").html(parseFloat(data.currBalance).toFixed(2));
            $("#userBalanceDT").html(parseFloat(data.currBalance).toFixed(2));
            $("#userBalance").html(parseFloat(data.currBalance).toFixed(2));                
        }
        // window.setTimeout(function() {
        //     $("#message-alert").fadeTo(2000, 500).slideUp(500, function(){
        //         $(this).remove(); 
        //     });
        // }, 5000);
    });
}

function scqSubmit(e){
    console.log("#scqForm "+e+" submitted")
    var formValues= $("#scqForm"+e+">form").serialize();
    document.getElementById("scqBetProcess"+e).innerHTML = "<div class='alert alert-success'>Bet processing. Please wait.....</div>";
    $("#scqForm"+e).hide();

    $.post("/dashboard/cqBetPlace", formValues, function(data){
        // Display the returned data in browser
        //console.log(data.message)
        $("#scqSuccess"+data.fieldIndex).show();
        $("#scqSuccess"+data.fieldIndex).html(data.message);
        document.getElementById("scqBetProcess"+e).innerHTML = "";
        $('#sestReturn').html("0.00");
        $("#scqForm"+e).find("*").prop("disabled", true);
        $("form").trigger("reset");
        //$('#fqForm').replaceWith(data.message);
        if(data.currBalance>=0){
            $("#userBalanceMT").html(parseFloat(data.currBalance).toFixed(2));
            $("#userBalanceDT").html(parseFloat(data.currBalance).toFixed(2));
            $("#userBalance").html(parseFloat(data.currBalance).toFixed(2));
            
        }
        // window.setTimeout(function() {
        //     $("#message-alert").fadeTo(2000, 500).slideUp(500, function(){
        //         $(this).remove(); 
        //     });
        // }, 5000);
    });

}
