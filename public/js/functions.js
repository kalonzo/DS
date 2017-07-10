/**
 * 
 * @param {type} myVar
 * @returns {Boolean}
 */
isEmpty = function(myVar){
    var empty = true;
    if(myVar !== null && myVar != undefined && myVar !== ''){
        empty = false;
    }
    return empty;
}