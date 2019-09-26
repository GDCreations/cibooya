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

//Selectors Red Indicating
function chckBtn(id, inpu) {
    if (id == 0) {
        $('#' + inpu).parent().css('border', '1px solid red');
        $('#' + inpu).parent().css('border-radius', '4px');
    } else {
        $('#' + inpu).parent().css('border', '0px');
    }
}

// NIC VALIDATION AND FIND DOB & GENDER USEING NIC

// nic - NIC no / vlid - passing value html id / htid - htmal id (disable enable button) / dob - DOB html id / gend - Gender html id / genDiv - gend parent div
function checkNic(nic, vlid, htid, dob, gend, genDiv) {

    console.log(dob + ' ** ' + gend + ' - ' + genDiv);

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
            //document.getElementById("gend").value = 1;
            document.getElementById( gend).value = 1;
        } else {
            //document.getElementById("gend").value = 2;
            document.getElementById( gend).value = 2;
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
            //document.getElementById("gend").value = 1;
            document.getElementById(gend).value = 1;
        } else {
            //document.getElementById("gend").value = 2;
            document.getElementById(gend).value = 2;
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