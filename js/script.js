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
            if (data) {
                itemlist = JSON.parse(data);
                ShowData(itemlist);
            }
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
                .append($('<td class="text-center">').html('<a class="btn btn-success" href="#" onclick="ShiftItem(' + index + ')"><i class="bi bi-cart-check"></i></a>'))
            );
        }
        else {
            bottomtable.append($('<tr>')
                .append($('<td>').html(CutString(element.name)))
                .append($('<td class="text-center">')
                    .html('<a class="btn btn-warning" href="#" onclick="ShiftItem(' + index + ')"><i class="bi bi-cart-plus"></i></i></a> <a class="btn btn-danger" href="#" onclick="RemoveItem(' + index + ')"><i class="bi bi-trash"></i></a>'))
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
    $.ajax({
        url: "api/add",
        type: "GET",
        data: {
            name: name
        },
        success: function (data) {
            if (data === "OK") {
                $('#adding').val('');
                itemlist.unshift(element);
                ShowData(itemlist);
            } else if (data === "warning: item already listed") {
                $('#adding').val('');
                console.log(data);
            } else {
                console.log(data);
                ShowError(data);
            }
        },
        error: function (err) {
            console.log(err);
        }
    });
}

function ShiftItem(index) {
    const url = itemlist[index].listed ? "api/buy" : "api/res";
    $.ajax({
        url: url,
        type: "GET",
        data: {
            name: itemlist[index].name
        },
        success: function (data) {
            if (data !== "OK") {
                console.log(data);
                ShowError(data);
            } else {
                // Preserve the element at the top of the switched list.
                // Update executed without requiring data retrieval from server.
                itemlist[index].listed = !itemlist[index].listed;
                var els = itemlist.splice(index, 1);
                itemlist.unshift(els[0]);
                ShowData(itemlist);
            }
        },
        error: function (err) {
            console.log(err);
        }
    });
}

function RemoveItem(index) {
    $.ajax({
        url: "api/del",
        type: "GET",
        data: {
            name: itemlist[index].name
        },
        success: function (data) {
            if (data !== "OK") {
                console.log(data);
                ShowError(data);
            } else {
                var els = itemlist.splice(index, 1);
                ShowData(itemlist);
            }
        },
        error: function (err) {
            console.log(err);
        }
    });
}

function CutString(str) {
    if (str !== undefined) {
        if (str.length >= MAXLEN)
            return (str.slice(0, MAXSTR) + "...");
        else return str;
    }
}

function ShowError(text) {
    $('#mymodal p').html(text);
    $('#mymodal').modal('show');
}