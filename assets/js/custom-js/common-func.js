//FORM CLEARING FUNTION
function clear_Form(form) {
    $("#" + form).trigger("reset");

    //get selector elements
    var nodes = $('#' + form).find(
        "select"
    ).val(0);

    //Reseting selector items
    nodes.map(function () {
        var node2 = $("#"+$(this).attr('id')).prev(); //get previous element of selector element
        node2.children().children().removeClass('selected'); //remove selected classes
        node2.children().children().first().addClass('selected'); //add selected class
        var selected = node2.children().children().first().children().children().first().html(); //get selected valus
        node2.prev().prop('title',selected); //set selected value as title
        node2.prev().children().first().html(selected); //set selected value as <li> element
    });
}

function default_Selector(node) {
    node.children().children().removeClass('selected'); //remove selected classes
    node.children().children().first().addClass('selected'); //add selected class
    var selected = node.children().children().first().children().children().first().html(); //get selected valus
    node.prev().prop('title',selected); //set selected value as title
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
        $('#'+inpu).parent().css('border','1px solid red');
        $('#'+inpu).parent().css('border-radius','4px');
    } else {
        $('#'+inpu).parent().css('border','0px');
    }
}