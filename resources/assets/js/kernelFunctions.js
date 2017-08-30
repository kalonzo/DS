checkExist = function (selector) {
    if ($(selector).length > 0) {
        return true;
    } else {
        return false;
    }
};

isEmpty = function(myVar){
    var empty = true;
    if(myVar !== '' && myVar !== null && myVar !== undefined && myVar != null){
        empty = false;
    }
    return empty;
};

isEmptyArray = function(myArray){
    var empty = true;
    if (typeof myArray !== 'undefined' && myArray.length > 0) {
        empty = false;
    }
    return empty;
};

isPluginLoaded = function (pluginFn) {
    if ($.isFunction(pluginFn)) {
        return true;
    } else {
        return false;
    }

};

addListenerMulti = function(el, s, fn) {
    s.split(' ').forEach(e => el.addEventListener(e, fn, false));
};
