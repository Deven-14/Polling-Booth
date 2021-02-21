function defaultDateToday(id) {
    var date = document.getElementById(id);
    var today = new Date().toISOString().split("T")[0];
    date.value = today;
}

function setMinDateToday(id) {
    var date = document.getElementById(id);
    var today = new Date().toISOString().split("T")[0];
    date.min = today;
}

function defaultDateTomorrow(id) {
    var date = document.getElementById(id);
    var today = new Date();
    var tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    date.value = tomorrow.toISOString().split("T")[0];
}

var menuStatus = false;

function menuDropdown() {
    if (menuStatus == false) {
        document.getElementsByClassName("nav-menu")[0].style.display = "block";
        menuStatus = true;
    } else if (menuStatus == true) {
        document.getElementsByClassName("nav-menu")[0].style.display = "none";
        menuStatus = false;
    }
}

function addField() {
    var options = document.getElementById("options").getElementsByTagName("li").length;
    if (options < 5) {
        var container = document.getElementById("options");
        // Create an <input> element, set its type and name attributes
        var node = document.createElement("li");
        var input = document.createElement("input");
        input.type = "text";
        input.placeholder = 'Choice ' + (options + 1);
        input.name = 'options[]';
        input.classList.add("input-text");
        input.classList.add("js-input");
        input.required = true;
        node.appendChild(input);
        container.appendChild(node);
    }
}

function removeField() {
    var options = document.getElementById("options").getElementsByTagName("li").length;
    if (options > 2) {
        var container = document.getElementById("options");
        container.removeChild(container.lastChild);
    }
}

function googleTranslateElementInit() {
    new google.translate.TranslateElement({ pageLanguage: 'en' }, 'google_translate_element');
}