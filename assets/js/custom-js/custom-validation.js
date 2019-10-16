// **********************************************
//          jQuery customeiz validation
// **********************************************
// jquery validation not equel method
jQuery.validator.addMethod("notEqual",
    function (value, element, param) {
        return this.optional(element) || value != param;
    }, "Please specify a different (non-default) value");

jQuery.validator.addMethod("notEqualTo",
    function (value, element, param) {
        var notEqual = true;
        value = $.trim(value);
        for (i = 0; i < param.length; i++) {
            if (value == $.trim($(param[i]).val())) {
                notEqual = false;
            }
        }
        return this.optional(element) || notEqual;
    },
    "Please enter a different value."
);
// end jquery validation not equel method

$.validator.addMethod("greaterThan",
    function (value, element, param) {
        var $otherElement = $(param);
        return parseInt(value, 10) < parseInt($otherElement.val(), 10);
    },
    "This value greater than other value."
);
$.validator.addMethod("lessThan",
    function (value, element, param) {
        var $otherElement = $(param);
        return parseInt(value, 10) > parseInt($otherElement.val(), 10);
    },
    "This value less than other value."
);

// lessThanOrEqual
$.validator.addMethod("lessThanOrEqual",
    function (value, element, param) {
        var $otherElement = $(param);
        return parseInt(value, 10) >= parseInt($otherElement.val(), 10);
    },
    "This value less than other value."
);

// greaterThanOrEqual
$.validator.addMethod("greaterThanOrEqual",
    function (value, element, param) {
        var $otherElement = $(param);
        return parseInt(value, 10) <= parseInt($otherElement.val(), 10);
    },
    "This value greater than other value."
);

// LESS THAN AND GREATER THAN ARRAY MODE --gemu--
jQuery.validator.addMethod("lessThanTo",
    function (value, element, param) {
        var lessThan = true;
        value = $.trim(value);
        for (i = 0; i < param.length; i++) {
            if (parseInt(value, 10) < parseInt($.trim($(param[i]).val(), 10))) {
                lessThan = false;
            }
        }
        return this.optional(element) || lessThan;
    },
    "This value less than other value(s)."
);

// Validation method for currency
/* https://gist.github.com/jonkemp/9094324#file-validate-currency-js */
$.validator.addMethod("currency", function (value, element) {
    //return this.optional(element) || /^(\d{1,3}(\,\d{3})*|(\d+))(\.\d{2})?/.test(value);
    return this.optional(element) || /^((\d+(\\.\d{0,2})?)|((\d*(\.\d{1,2}))))$/.test(value);
}, "Please enter a correct currency, format 0.00");

/*
 validate useing by class
 https://jqueryvalidation.org/jQuery.validator.addClassRules/#namerules
 jQuery.validator.addClassRules("name", {
 required: true,
 minlength: 2
 });*/

// // Validation method for MAX DATE TODAY
/* https://stackoverflow.com/questions/17310431/max-date-using-jquery-validation?utm_medium=organic&utm_source=google_rich_qa&utm_campaign=google_rich_qa */
$.validator.addMethod("maxDate", function (value, element) {
    var curDate = new Date();
    var inputDate = new Date(value);
    if (inputDate < curDate)
        return true;
    return false;
}, "Invalid Date!");   // error message

$.validator.addMethod("minDate", function (value, element) {
    var curDate = new Date();
    var inputDate = new Date(value);
    //console.log( curDate + '**' + inputDate);
    if (inputDate > curDate)
        return true;
    return false;
}, "Invalid Date!");   // error message

// VALIDATE 24 HOURSE TIME
$.validator.addMethod("time24", function (value, element) {
    if (!/^\d{1 || 2}:\d{2}:\d{2}$/.test(value)) return false;
    var parts = value.split(':');
    if (parts[0] > 23 || parts[1] > 59 || parts[2] > 59) return false;
    return true;
}, "Invalid time format.");


// jQuery validation of multiple not equal inputs
/* https://stackoverflow.com/questions/16964288/jquery-validation-of-multiple-not-equal-inputs */

$.validator.addMethod("notEqualToGroup", function (value, element, options) {
    // get all the elements passed here with the same class
    var elems = $(element).parents('form').find(options[0]);
    // the value of the current element
    var valueToCompare = value;
    // count
    var matchesFound = 0;
    // loop each element and compare its value with the current value
    // and increase the count every time we find one
    jQuery.each(elems, function () {
        thisVal = $(this).val();
        if (thisVal == valueToCompare) {
            matchesFound++;
        }
    });
    // count should be either 0 or 1 max
    if (this.optional(element) || matchesFound <= 1) {
        //elems.removeClass('error');
        return true;
    } else {
        //elems.addClass('error');
    }
}, "Please enter a Unique Value.");

//jQuery Validation for Decimal numbers
//https://stackoverflow.com/questions/36024257/jquery-validate-only-decimal-number?rq=1
$.validator.addMethod('decimal', function (value, element) {
    return this.optional(element) || /^((\d+(\\.\d{0,2})?)|((\d*(\.\d{1,2}))))$/.test(value);
}, "Please enter a correct number, format 0.00");


$.validator.addMethod("maxAge", function (value, element, max) {
    var today = new Date();
    var birthDate = new Date(value);
    var age = today.getFullYear() - birthDate.getFullYear();

    if (age < max + 1) {
        return true;
    }
    var m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age <= max;
}, "You are old enough, Cannot register!");

//Validation table array elements max value
$.validator.addMethod("tblar_max",function (value, element, options) {
    // get all the elements passed here by name
    var node = $(element).parent().parent().find('input[name="'+options+'"]');
    // the value of the current element
    var valueToCompare = value;
    // the max value
    var maxValue = (node.val()=='')?0:node.val();
    if(+valueToCompare <= +maxValue){
        return true;
    }else{

    }
},function (options, element) {
    var node = $(element).parent().parent().find('input[name="'+options+'"]');
    var maxValue = (node.val()=='')?0:node.val();
    return "Can't enter more than "+maxValue;
});

//Validation table array elements min value
$.validator.addMethod("tblar_min",function (value, element, options) {
    // get all the elements passed here by name
    var node = $(element).parent().parent().find('input[name="'+options+'"]');
    // the value of the current element
    var valueToCompare = value;
    // the max value
    var maxValue = (node.val()=='')?0:node.val();
    if(+valueToCompare >= +maxValue){
        return true;
    }else{

    }
},function (options, element) {
    var node = $(element).parent().parent().find('input[name="'+options+'"]');
    var maxValue = (node.val()=='')?0:node.val();
    return "Can't enter less than "+maxValue;
});

//Validation min time in current day
$.validator.addMethod("time_min",function (value, element, options) {
    var maxValue = $('#'+options).val().split(":");
    var curvalue = value.split(":");

    if((curvalue[0]*3600)+curvalue[1]*60 >= (maxValue[0]*3600)+maxValue[1]*60){
        return true;
    }else{

    }
},"Enter time after 'Start time'");
// *********************************************
//      END jQuery customeiz validation
// **********************************************