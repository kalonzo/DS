$.fn.parentsInclude = function (selector) {
    var parent = $(this).parent(selector);
    if (checkExist(parent)) {
        return parent;
    }
    return $(this).parentsUntil(selector).parent(selector);
};
$.fn.nextInclude = function (selector) {
    var next = $(this).next(selector);
    if (checkExist(next)) {
        return next;
    }
    return $(this).nextUntil(selector).next(selector);
};
$.fn.dsToggleClass = function (classToToggle) {
    if ($(this).hasClass(classToToggle)) {
        $(this).removeClass(classToToggle);
    } else {
        $(this).addClass(classToToggle);
    }
};
$.fn.prevInclude = function (selector) {
    var prev = $(this).prev(selector);
    if (checkExist(prev)) {
        return prev;
    }
    return $(this).prevUntil(selector).prev(selector);
};
$.fn.nextIncluding = function (selector) {
    var next = $(this).next(selector);
    if (checkExist(next)) {
        return next;
    }
    var nextUntil = $(this).nextUntil(selector);
    return $(nextUntil).add($(nextUntil).next(selector));
};
$.fn.nextIgnore = function (selectorIgnored) {
    var foundNext = false;
    var cursor = this;
    while (!foundNext && checkExist(cursor)) {
        cursor = $(cursor).next();
        if (!$(cursor).is(selectorIgnored)) {
            foundNext = true;
        }
    }
    if (foundNext) {
        return cursor;
    } else {
        return $();
    }
};
$.fn.prevIncluding = function (selector) {
    var prev = $(this).prev(selector);
    if (checkExist(prev)) {
        return prev;
    }
    var prevUntil = $(this).prevUntil(selector);
    return $(prevUntil).add($(prevUntil).prev(selector));
};
$.fn.arrayVal = function () {
    var array = $(this).map(function () {
        return $(this).val();
    }).get();
    return array;
};
$.fn.selectVal = function () {
    if ($(this).prop("tagName") === 'LI') {
        var filterElement = $(this).find('#' + $(this).attr('id'));
        if (checkExist(filterElement)) {
            return $(filterElement).val();
        }
    }
    return $(this).val();
};
$.fn.valArrayForMultipleInput = function () {
    return $(this).map(function () {
        return $(this).val();
    }).get();
};
$.fn.valArrayForGroup = function () {
    var array = new Array();
    $(this).each(function () {
        if (!empty($(this).val(), true)) {
            array.push($(this).val());
        }
    });
    return array;
};
$.fn.valArrayForMultipleInputImploded = function () {
    var array = $(this).valArrayForMultipleInput();
    return array.join(";");
};

Math.radians = function (degrees) {
    return degrees * Math.PI / 180;
};

// Converts from radians to degrees.
Math.degrees = function (radians) {
    return radians * 180 / Math.PI;
};
