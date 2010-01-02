/*

LiveSearch by Kastner <kastner@gmail.com>
started 4/22/05
version 0.1a

TODO:
    * Timeout based
    * Caching of results
    * Backspace (I think I got it)
    * Arrows (done?)
    * Allow multiple searches in one text box

*/
function LiveSearch(textbox, url) {
    this.textbox = textbox;
    this.url = url;
    this.real = "";
    this.hl = 0;
    this.terms = Array();

    this.init = function() {
        var oldThis = this;
        this.textbox.onblur = function(event) {
            oldThis.hide_box();
        }
        this.textbox.onkeyup = function(event) {
            switch (event.keyCode) {
                case 8:
                    oldThis.real = oldThis.real.substr(0,oldThis.real.length-1);
                    oldThis.textbox.value = oldThis.real;
                    if (oldThis.real == "") {
                        oldThis.hide_box();
                    }
                    break;
                case 40:    //Down arrow
                    oldThis.hl++;
                    if (oldThis.hl >= oldThis.terms.length) oldThis.hl = 0;
                    oldThis.show_box(oldThis.terms, oldThis.hl);
                    return;
                case 38:    //Up arrow
                    oldThis.hl--;
                    if (oldThis.hl < 0) oldThis.hl = oldThis.terms.length - 1; 
                    oldThis.show_box(oldThis.terms, oldThis.hl);
                    //event.preventDefault();
                    return;
                case 39:    //Right arrow
                    oldThis.hide_box();
                    oldThis.textbox.value += " ";
                    break;
                case 27:    //Escape
                    oldThis.hide_box();
                    oldThis.textbox.value = oldThis.real;
                    break;
                default:
                    break;
            }
            if (event.keyCode < 32 || (event.keyCode >= 33 && event.keyCode <= 46) || (event.keyCode >= 112 && event.keyCode <= 123)) {
                //alert(event.keyCode);
                return;
            }
            oldThis.real = oldThis.textbox.value;
            // Caching here!!!
            var req;
            /* set up the xmlhttpd object */
            if(!req) { req=new XMLHttpRequest(); }
            if (req) {
                req.open("GET", oldThis.url.replace(/%s/, oldThis.real), true);
                req.onreadystatechange = function() {
                    if (req.readyState == 4) {
                        /* Create the new element */
                        eval(req.responseText);
                    }
                }
                req.send(null);
            }
        }
    }

    this.select_range = function(iStart, iLength) {
        this.textbox.setSelectionRange(iStart, iLength)
        this.textbox.focus();
    }

    this.type_ahead = function(sug) {
        var oldLen = this.real.length;
        this.textbox.value = sug
        this.select_range(oldLen, sug.length);
    }

    this.create_box = function() {
        var list = document.createElement("DIV");
        list.id = "flickr_tags_div";
        list.style.width = "200";
        list.style.MozBoxSizing = "border-box";
        list.style.border = "1px solid black";
        list.position = "absolute";
        list.innerHTML = "";
        list.style.visibility = "hidden";

        // add the div into the page
        if (this.textbox.nextSibling) {
            this.textbox.parentNode.appendChild(list);
        }
        else {
            this.textbox.parentNode.insertAfter(list,this.textbox);
        }
        return(list);
    }

    this.hide_box = function() {
        this.box.style.visibility = "hidden";
        this.box.innerHTML = "";
    }

    this.show_box = function(terms, hl) {
        var newVal = "";
        this.box.style.visibility = "hidden";
        //this.box.innerHTML = "";
        this.type_ahead(terms[hl]);
        for (var i=0, l=terms.length; i<l; i++) {
            var id = "";
            if (i == hl) {
                id = "id='box_sel' style='background-color: #ccc; border: 1px solid #888;'";
            }
            newVal += "<div "+id+">" + terms[i].replace(this.real, "<strong>"+this.real+"</strong>") + "</div>";
        }
        this.box.innerHTML = newVal;
        this.box.style.visibility = "visible";
    }

    this.show_live = function(terms) {
        if (terms.length) {
            this.hl = 0;
            this.terms = terms;
            this.show_box(this.terms, 0);
            //Show the rest in a b ox.
        }
    }

    this.init();
    this.textbox.focus();
    this.box = this.create_box();
}

function sendRPCDone(a,b,c,d,e) {
    tag.show_live(c);
}
