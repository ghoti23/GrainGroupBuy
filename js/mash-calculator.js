$(document).ready(function() {
    var mashForm = $('#mashForm'),
        fitForm =  $('#fitForm'),
        strikeForm = $('#strikeForm'),
        mashValue = $('#mashValue'),
        strikeTemp = $('#strikeTemp');

    fitForm.submit(function() {
        var data = fitForm.serializeObject();
        if (isNumber(data.weight) && isNumber(data.mash) ) {
           // var volume = Math.round(data.weight* (.08+data.mash/4)*100)/100;
            mashValue.html("It will take up " + getVolume(data.weight,data.mash) + " gallons in your mash tun.");
        }
        return false;
    });

    strikeForm.submit(function() {
        var data = strikeForm.serializeObject();
        if (isNumber(data.mT) && isNumber(data.sT) &&  isNumber(data.gT)) {
            var a = getStrikeTemp(parseFloat(data.mT), parseFloat(data.sT),parseFloat(data.gT));
            strikeTemp.html("Your strike temperature will be " + a +"F ");
        }
        return false;
    });
    var numberWithCommas = function(x) {
        return (x || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    function isNumber(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

});