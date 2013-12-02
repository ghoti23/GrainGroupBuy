function getVolume(weight, mash) {
    var volume = Math.round(weight* (0.08 + mash / 4)*100)/100;
    return volume;
}

function getStrikeTemp(mt,sT,gT) {
    var strikeTemperature=sT + 0.192 * (sT - gT) /mt+3;
    return Math.round(strikeTemperature);
}