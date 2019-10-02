//FORM CLEARING FUNTION
function clear_Form(form) {
    $("#" + form).trigger("reset");

    //get selector elements
    var nodes = $('#' + form).find(
        "select"
    ).val(0);

    //Reseting selector items
    nodes.map(function () {
        var node2 = $("#" + $(this).attr('id')).prev(); //get previous element of selector element
        node2.children().children().removeClass('selected'); //remove selected classes
        node2.children().children().first().addClass('selected'); //add selected class
        var selected = node2.children().children().first().children().children().first().html(); //get selected valus
        node2.prev().prop('title', selected); //set selected value as title
        node2.prev().children().first().html(selected); //set selected value as <li> element
    });
}

function default_Selector(node) {
    node.children().children().removeClass('selected'); //remove selected classes
    node.children().children().first().addClass('selected'); //add selected class
    var selected = node.children().children().first().children().children().first().html(); //get selected valus
    node.prev().prop('title', selected); //set selected value as title
    node.prev().children().first().html(selected); //set selected value as <li> element
}

//Set selected item in selector
//id - Selector ID <select></select>
//itm - Selected Item ID <option></option>
function set_select(id,itm) {
    $('#'+id).val(itm);
    var sltr = $('#'+id);       //Get Selector Element
    var prev = $('#'+id).prev();//Get Previous element (<div><ul><li></li></ul></div>)
    var sltr_chld = sltr.children(); //<option></option>
    sltr_chld.map(function () {
        //Get Index of value option
        if($(this).val()==itm){
           var index = $(this).index();
           var li = prev.children().children().removeClass('selected'); //<li></li>
           li.map(function () {
               //Get Selecting Index <li></li>
               if($(this).index()==index){
                   $(this).addClass('selected');
                   var sel_value = $(this).children().children().first().html(); //Selected value text
                   prev.prev().prop('title',sel_value);
                   prev.prev().children().first().html(sel_value)
               }
           });
        }
    });
}

//Selectors Red Indicating
function chckBtn(id, inpu) {
    if (id == 0) {
        $('#' + inpu).parent().css('border', '1px solid red');
        $('#' + inpu).parent().css('border-radius', '4px');
    } else {
        $('#' + inpu).parent().css('border', '0px');
    }
}

//Selectors Enables
//id - Selector ID
function enableSelct(id) {
    $('#'+id).prop('disabled',false);
    $('#'+id).parent().removeClass("disabled");
    $('#'+id).prev().prev().removeClass("disabled");
}

//Selectors Disable
//id - Selector ID
function disableSelct(id) {
    $('#'+id).prop('disabled',true);
    $('#'+id).parent().addClass("disabled");
    $('#'+id).prev().prev().addClass("disabled");
}

//Enable All selectors in <DIV>
// id - <DIV> id
function enableAllSelct(id) {
    sltr_chld = $('#'+id).find('select');
    sltr_chld.map(function () {
        var id2 = $(this).attr('id');
        $('#'+id2).prop('disabled',false);
        $('#'+id2).parent().removeClass("disabled");
        $('#'+id2).prev().prev().removeClass("disabled");
    });
}

//Desable All selectors in <DIV>
// id - <DIV> id
function disableAllSelct(id) {
    sltr_chld = $('#'+id).find('select');
    sltr_chld.map(function () {
        var id2 = $(this).attr('id');
        $('#'+id2).prop('disabled',true);
        $('#'+id2).parent().addClass("disabled");
        $('#'+id2).prev().prev().addClass("disabled");
    });
}

//Readonly OFF All selectors in <DIV>
// id - <DIV> id
function editAllSelct(id) {
    sltr_chld = $('#'+id).find('select');
    sltr_chld.map(function () {
        var id2 = $(this).attr('id');
        $('#'+id2).prop('readonly',false);
        $('#'+id2).parent().removeClass("disabled");
        $('#'+id2).prev().prev().removeClass("disabled");
    });
}

//Readonly ON All selectors in <DIV>
// id - <DIV> id
function readonlyAllSelct(id) {
    sltr_chld = $('#'+id).find('select');
    sltr_chld.map(function () {
        var id2 = $(this).attr('id');
        $('#'+id2).prop('readonly',true);
        $('#'+id2).parent().addClass("disabled");
        $('#'+id2).prev().prev().addClass("disabled");
    });
}

// NIC VALIDATION AND FIND DOB & GENDER USEING NIC

// nic - NIC no / vlid - passing value html id / htid - htmal id (disable enable button) / dob - DOB html id / gend - Gender html id / genDiv - gend parent div
function checkNic(nic, vlid, htid, dob, gend, genDiv) {

    //var nicNo = document.getElementById("nic").value;
    var nicNo = nic;
    var month = new Array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

    if (nicNo.length == 10 && nicNo.substr(9, 9) == 'V' || nicNo.substr(9, 9) == 'v' || nicNo.substr(9, 9) == 'X' || nicNo.substr(9, 9) == 'x') {

        var birthYear = nicNo.substr(0, 2);
        var x = nicNo.substr(2, 3);

        if (x.length == 2) {
            if (x < 10) {
                x = x.substr(1, 1);
            } else if (x < 100) {
                x = x.substr(0, 1);
            }
        } else if (x.length == 3) {
            if (x < 10) {
                x = x.substr(2, 2);
            } else if (x < 100) {
                x = x.substr(1, 2);
            }
        }

        if (x < 500) {
            //document.getElementById( gend).value = 1;
            set_select(gend,1);
        } else {
            //document.getElementById( gend).value = 2;
            set_select(gend,2);
            x = +x - +500;
        }

        var mo = 0;
        var da = 0;
        var days = x;

        // IF CHECK DECEMBER 31 BIRTHDAY
        if (days == 366) {
            var mo = 12;
            var da = 31;

        } else {
            for (i = 0; i < month.length; i++) {
                if (days < month[i]) {
                    mo = i + 1;
                    da = days;
                    if (da == 0) {
                        da = month[i - 1];
                        mo = mo - 1;
                    }
                    break;
                } else {
                    days = days - month[i];
                }
            }

            if (mo < 10) {
                mo = '0' + mo;
            }

            if (da < 10) {
                da = '0' + days;
            }
        }
        var today = +1900 + +birthYear + "-" + (mo) + "-" + (da);

        $('#' + dob).val(today);
        document.getElementById(vlid).style.borderColor = "";
        document.getElementById(htid).disabled = false;

    } else if (nicNo.length == 12 && /^\d+$/.test(nicNo)) {

        var birthYear = nicNo.substr(0, 4);
        var x = nicNo.substr(4, 3);

        if (x < 500) {
            //document.getElementById(gend).value = 1;
            set_select(gend,1);
        } else {
            //document.getElementById(gend).value = 2;
            set_select(gend,2);
            x = +x - +500;
        }

        if (x.length == 2) {
            if (x < 10) {
                x = x.substr(1, 1);
            } else if (x < 100) {
                x = x.substr(0, 1);
            }
        } else if (x.length == 3) {
            if (x < 10) {
                x = x.substr(2, 2);
            } else if (x < 100) {
                x = x.substr(1, 2);
            }
        }

        var mo = 0;
        var da = 0;
        var days = x;

        if (days == 366) {
            var mo = 12;
            var da = 31;

        } else {
            for (i = 0; i < month.length; i++) {
                if (days < month[i]) {
                    mo = i + 1;
                    da = days;
                    if (da == 0) {
                        da = month[i - 1];
                        mo = mo - 1;
                    }
                    break;
                } else {
                    days = days - month[i];
                }
            }

            if (mo < 10) {
                mo = '0' + mo;
            }

            if (da < 10) {
                da = '0' + days;
            }
        }

        var today = +birthYear + "-" + (mo) + "-" + (da);

        $('#' + dob).val(today);
        document.getElementById(vlid).style.borderColor = "";
        document.getElementById(htid).disabled = false;

    } else {
        document.getElementById(vlid).focus();
        document.getElementById(vlid).style.borderColor = "red";

        document.getElementById(htid).disabled = true;
    }

    // document.getElementById('msg_text').innerHTML = "<div></div>";
};

//SMART WIZARD RESET
//id - Wizard ID
//fst - First Step id
//sunmt - Submit button id
function resetSmWizard(id,fst,submt) {
    $('#'+id).children().first().children().children().removeClass('done');
    $('#'+id).children().first().children().children().removeClass('selected');
    $('#'+id).children().first().children().children().removeClass('active');
    $('#'+id).children().first().children().first().children().addClass('selected');

    $('#'+id).find('.stepContainer').children().css('display','none');
    $('#'+fst).css('display','block');
    $('#'+submt).css('display','none');

    $('.buttonNext').removeClass('buttonDisabled disabled');
    $('.buttonPrevious').addClass('buttonDisabled disabled');
}