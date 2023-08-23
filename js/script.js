var itemlist = Array();  // must be global
const REMOVEAPI = 'del'; // must match the backend API call for deletion
/* Editable parameters follow */
const MAXLEN = 30;
const MAXSTR = 27;

$('document').ready(function () {
    QueryData();
    setInterval(QueryData, 15000);
    $("form").on('submit', function (e) {
        e.preventDefault();
        AddItem();
    });
    $('#mymodal').modal();
});

function ShowData () {
    toptable = $('#toptable tbody');
    bottomtable = $('#bottomtable tbody');
    toptable.empty();
    bottomtable.empty();
    index = 0;
    itemlist.forEach(element => {
        if (element.listed) {
            toptable.append($('<tr>')
                .append($('<td>').html(CutString(element.name)))
                .append($('<td class="text-center">').html('<a class="btn btn-success" href="#" onclick="BuyRemove(' + index + ')"><i class="bi bi-cart-check"></i></a>'))
            );
        }
        else {
            bottomtable.append($('<tr>')
                .append($('<td>').html(CutString(element.name)))
                .append($('<td class="text-center">')
                    .html('<a class="btn btn-warning" href="#" onclick="CallAPI(\'api/add\', \'' + element.name + '\')"><i class="bi bi-cart-plus"></i></i></a> <a class="btn btn-danger" href="#" onclick="BuyRemove(' + index + ', ' + '\'' + REMOVEAPI + '\')"><i class="bi bi-trash"></i></a>'))
            );
        }
        index++;
    });
}

function RefreshData (data) {
    itemlist = data;
    ShowData();
}

function HandleResponse (data) {
    if (data.error) {
        if (data.error === "warning: item already listed") {
            $('#adding').val('');
            console.log(data);
        } else {
            ShowError(data.error);
        }
    } else if (data.response) {
        RefreshData(data.response);
        $('#adding').val('');
    }
}

/*************
 * API CALLS
 *************/

function QueryData () {
    CallAPI("api/get", undefined);
}

function AddItem () {
    var name = $('#adding').val();
    if (!name)
        return;
    url = "api/add";
    CallAPI(url, name);
}

function BuyRemove (index, action) {
    // Define action
    if (!action)
        action = "buy";
    const url = "api/" + action;
    const name = itemlist[index].name;
    CallAPI(url, name);
}

function CallAPI (url, name) {
    $.ajax({
        url: url,
        type: "GET",
        data: {
            name: name
        },
        success: function (data) {
            HandleResponse(data);
        },
        error: function (err) {
            console.log(err);
        }
    });
}

/*************
 * UTILITIES
 *************/

function CutString (str) {
    if (str !== undefined) {
        if (str.length >= MAXLEN)
            return (str.slice(0, MAXSTR) + "...");
        else return str;
    }
}

function ShowError (text) {
    $('#mymodal p').html(text);
    $('#mymodal').modal('show');
}