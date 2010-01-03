var hasAjax = false;
if (window.XMLHttpRequest) { hasAjax = true; }
if (window.ActiveXObject) { hasAjax = true; }
function newReq() {
    if (hasAjax) {
        if (window.XMLHttpRequest) {
            req = new XMLHttpRequest();
        }
        else if (window.ActiveXObject) {
            req = new ActiveXObject("Microsoft.XMLHTTP");
        }
        if (req) { return req; }
    }
    return false;
}

function conditionalReload(hash, checkUrl) {
    //function to reload page based on a hash.. if it changes, reload
    if (hasAjax) {

    }
}

function removeElement(id) {
    if (typeof id != "Object") {
        id = document.getElementById(id);
    }
    if (id) {
        if (id.parentNode) {
            id.parentNode.removeChild(id);
        }
    }
}

function subForm(form) {
    if (hasAjax) {
        //do stuff
        var values = "";
        for (var i=0, l=form.length; i<l; i++) {
            if (form[i].name) 
                values += form[i].name + "=" + escape(form[i].value) + "&";
        }
        values += "xml=1&from=" + page;

        var req = newReq();
        req.open("POST", form.action, true);
        req.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        req.onreadystatechange = function() {
            if (req.readyState == 4) {
                if (req.responseText.match(/^\(function/)) {
                    eval(req.responseText);
                }
                else {
                    alert('Error: ' + req.responseText);
                }
            }
        }
        req.send(values);
        var div = document.getElementById("inputDiv");
        div.parentNode.removeChild(div);
        return false;
    }
    return true;
}

function closeGraph() {
    removeElement("graph");
}

function showInput(varr) {
    removeElement("inputDiv");
    var div = document.createElement("DIV");
    div.id = "inputDiv";
    ih = "";
    ih += "<form action='/new_value.php' method='POST' onSubmit='return subForm(this);'>";
    if (!varr) {
        ih += "Variable: <input type='text' size='10' id='inputVar' name='var' /> Amount: ";
    }
    else {
        ih += "<input type='hidden' name='var' value='"+varr+"' /><label>" + varr + "</label> ";
    }
    ih += "  <input type='tel' id='inputValue' name='value' />";
    ih += "<input type='submit' value='Add' /></form>";
    div.innerHTML = ih;

    if (document.getElementById("newStuff")) {
        de = document.getElementById("newStuff");
    }
    else {
        de = document.getElementById("main");
    }
    de.appendChild(div);
    if (!varr) {
        document.getElementById("inputVar").focus();
    }
    else {
        document.getElementById("inputValue").focus();
    }
}
