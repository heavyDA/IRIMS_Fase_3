function InvokeCodeBehindWithoutUpOneFolder(ServicesName, methodName, parameter) {
    //debugger;
    var result;
    var dataPost = ''
    if (parameter != null) {
        dataPost = JSON.stringify(parameter);
    }
    //JSON.stringify(parameter);  

    $.ajax({
        cache: false,
        async: false,
        //url: "../WebService.asmx/" + methodName + "?" + parameter + "",
        url: ServicesName + '/' + methodName,
        data: dataPost,
        dataType: "json",
        type: "POST",
        contentType: "application/json; charset=utf-8",
        success: successFunc,
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            //debugger
            //w2alert(errorThrown)
        }
    });

    function successFunc(data, status) {
        //debugger;
        result = data;


    }


    return result;
}
function InvokeCodeBehind(ServicesName, methodName, parameter) {
    //debugger;
    var result;
    var dataPost = ''
    if (parameter != null) {
        dataPost = JSON.stringify(parameter);
    }
    //JSON.stringify(parameter);  

    $.ajax({
        cache: false,
        async: false,
        //url: "../WebService.asmx/" + methodName + "?" + parameter + "",
        url: '../' + ServicesName + '/' + methodName,
        data: parameter,
        //data: parameter,
        dataType: "json",
        type: "POST",
        contentType: false,
        processData: false,
        success: successFunc,
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            debugger
            //w2alert(errorThrown)
        }
    });

    function successFunc(data, status) {
        debugger;
        result = data;


    }


    return result;
}

function invokeWebServices(ServicesName, methodName, parameter) {
    // debugger;
    var result;

    $.ajax({
        cache: false,
        async: false,
        //url: "../WebService.asmx/" + methodName + "?" + parameter + "",
        url: '../api/' + ServicesName + '/' + methodName + '?' + parameter,
        // data: dataPost,
        dataType: "json",
        type: "GET",
        contentType: "application/json; charset=utf-8",
        success: successFunc,
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            //debugger
            //w2alert(errorThrown)
        }
    });

    function successFunc(data, status) {
        debugger;
        result = data;


    }


    return result;
}

function isServerSubDirMode() {
    return true;
}

function isByPassRemedy() {
    return false;
}
export{InvokeCodeBehind};