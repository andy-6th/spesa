var itemlist = Array();
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

function QueryData() {
    $.ajax({
        url: "api/get",
        type: "GET",
        success: function (data) {
            itemlist = JSON.parse(data);
            ShowData(itemlist);
        },
        error: function (err) {
            console.log(err);
        }
    });
}

function ShowData(data) {
    toptable = $('#toptable tbody');
    bottomtable = $('#bottomtable tbody');
    toptable.empty();
    bottomtable.empty();
    index = 0;
    data.forEach(element => {
        if (element.listed) {
            toptable.append($('<tr>')
                .append($('<td>').html(CutString(element.name)))
                .append($('<td class="text-center">').html('<a class="btn btn-success" href="#" onclick="BuyItem(' + index + ')"><i class="bi bi-cart-check"></i></a>'))
            );
        }
        else {
            bottomtable.append($('<tr>')
                .append($('<td>').html(CutString(element.name)))
                .append($('<td class="text-center">')
                    .html('<a class="btn btn-warning" href="#" onclick="ResumeItem(' + index + ')"><i class="bi bi-cart-plus"></i></i></a> <a class="btn btn-danger" href="#" onclick="RemoveItem(' + index + ')"><i class="bi bi-trash"></i></a>'))
            );
        }
        index++;
    });
}

function WriterFunc() {
    ShowData(itemlist);
    $.ajax({
        url: "api/set",
        type: "GET",
        data: {
            jsonstring: JSON.stringify(itemlist)
        },
        success: function (data) {
            if (data !== "OK") {
                console.log(data);
                ShowError(data);
            }
        },
        error: function (err) {
            console.log(err);
        }
    });
}

function AddItem() {
    var name = $('#adding').val();
    if (!name)
        return;
    element = { name: name, listed: true };
    itemlist.unshift(element);
    $.ajax({
        url: "api/add",
        type: "GET",
        data: {
            name: name
        },
        success: function (data) {
            if (data === "OK") {
                $('#adding').val('');
                ShowData(itemlist);
            }
            else {
                console.log(data);
                ShowError(data);
            }
        },
        error: function (err) {
            console.log(err);
        }
    });
}

function BuyItem(index) {
    itemlist[index].listed = false;
    var els = itemlist.splice(index, 1);
    itemlist.unshift(els[0]);
    WriterFunc();
}


function ResumeItem(index) {
    itemlist[index].listed = true;
    var els = itemlist.splice(index, 1);
    itemlist.unshift(els[0]);
    WriterFunc();
}

function RemoveItem(index) {
    itemlist.splice(index, 1);
    WriterFunc();
}

function CutString(str) {
    if (str.length >= MAXLEN)
        return (str.slice(0, MAXSTR) + "...");
    else return str;
}

function ShowError(text) {
    $('#mymodal p').html(text);
    $('#mymodal').modal('show');
}