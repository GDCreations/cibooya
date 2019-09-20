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