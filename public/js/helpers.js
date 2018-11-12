
function showNotify(type, title, message) {

	var stack = {
        "dir1": "up",
        "dir2": "left",
        "firstpos1": 5,
        "firstpos2": 5,
        "spacing1": 0
    };

    var opts = {
        title: title,
        text: message,
        textTrusted: true,
        type: type,
        delay: 5000,
        styling: "material",
        icons: "material",
        stack: stack
    };

    PNotify.alert(opts);
}

 function formatErrors(list) {

    var errors = "<ul>";
    var results = $.parseJSON(list);

    for(var k in results.errors) {
        errors += "<li>"+ results.errors[k] +"</li>" ;
    }
    errors += "</ul>";
    return errors;
}