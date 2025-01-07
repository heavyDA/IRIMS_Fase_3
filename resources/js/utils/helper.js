function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}
function getLastUrlSegment(url) {
    return new URL(url).pathname.split('/').filter(Boolean).pop();
}

function showSpinner(displayText, callback) {
    w2popup.lockScreen();
    if (!displayText || displayText == '') displayText = 'Loading..';
    $('<div id="spinner" class="w2ui-lock-msg" style="display: block; position:fixed;width:350px"><div class="w2ui-spinner"></div>' + displayText + '</div> ').appendTo($('body'));

    setTimeout(function () { callback(); hideSpinner() }, 500);

    return true;
};
function showLoading(displayText, callback) {
    w2popup.lock();
    //w2popup.lockScreen();
    if (!displayText || displayText == '') displayText = 'Loading..';
    $('<div id="spinner" class="w2ui-lock-msg" style="display: block; position:fixed;z-index: 10003;width:350px"><div class="w2ui-spinner"></div>' + displayText + '</div> ').appendTo($('body'));

    setTimeout(function () { callback(); hideSpinnerLoading() }, 500);

    return true;
};

function hideSpinnerLoading() {
    $('#spinner').remove();
    //w2popup.unlockScreen();
    w2popup.unlock();
    return true;
}

function hideSpinner() {
    $('#spinner').remove();
    w2popup.unlockScreen();
    return true;
}

function setDDLbyText(ddlID, text) {
    $("#" + ddlID + " option").each(function () {
        if ($(this).text() == text) {
            $(this).prop('selected', 'selected').trigger('change');
            return false;
        }
    });
}

function setDDLbyValueContainText(ddlID, text) {

    $("#" + ddlID + " option").each(function () {
        if ($(this).val().indexOf(text) != -1) {
            $(this).prop('selected', 'selected').trigger('change');
            return false;
        }
    });
}


function lockPopUp(displayText, callback) {
    w2popup.lock(displayText, true);

    setTimeout(function () { callback(); hidePopUpSpinner() }, 500);

    return true;
};
function hidePopUpSpinner() {

    w2popup.unlock();
    return true;
}


function numberWithCommas(x) {
    x = x.toString();
    var pattern = /(-?\d+)(\d{3})/;
    while (pattern.test(x))
        x = x.replace(pattern, "$1.$2");
    return x;
}

function showvalidation(type, ctrl, text) {

    $('#' + ctrl).w2overlay({
        align: 'left',
        html: '<div  style="padding: 10px;color:#C62828;line-height: 150%">' +
            text +
            '</div>'
    });

    if (type == '1')// type dropdown
    {
        $("#w2ui-overlay").css({ "margin-top": "30px" });
    }

}
function showvalidationclass(type, ctrl, text) {

    $('.' + ctrl).w2overlay({
        align: 'left',
        html: '<div  style="padding: 10px;color:#C62828;line-height: 150%">' +
            text +
            '</div>'
    });

    if (type == '1')// type dropdown
    {
        $("#w2ui-overlay").css({ "margin-top": "30px" });
    }

}
function Simplevalidation(ctrl, text) {
    $('#' + ctrl + '').w2tag(text)
}



function ReplaceNonBreakingSpace(StrXml) {
    return StrXml.replace(/[<>&'"]/g, function (c) {
        switch (c) {
            case '&nbsp;': return ' ';
        }
    });
}

function CharacterToEntity(StrXml) {
    return StrXml.replace(/[<>&'"]/g, function (c) {
        switch (c) {
            case '<': return '&lt;';
            case '>': return '&gt;';
            case '&': return '&amp;';
            case '\'': return '&apos;';
            case '"': return '&quot;';
            case '&nbsp;': return '&#160;';
        }
    });
}

function EntityToCharacter(StrXml) {
    return StrXml.replace(/[<>&'"]/g, function (c) {
        switch (c) {
            case '&lt;': return '<';
            case '&gt;': return '>';
            case '&amp;': return '&';
            case '&apos;': return '\'';
            case '&quot;': return '"';
            case '&#160;': return '&nbsp;';
        }
    });
}

function pad(str, max) {
    str = str.toString();
    return str.length < max ? pad("0" + str, max) : str;
}

function DownloadExcell(HtmlData, FileName) {
    //window.open('data:application/vnd.ms-excel,' + encodeURIComponent(html));
    //debugger;
    var uri = 'data:application/vnd.ms-excel;base64,';
    var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>';
    var base64 = function (s) {
        return window.btoa(unescape(encodeURIComponent(s)))
    };

    var format = function (s, c) {
        return s.replace(/{(\w+)}/g, function (m, p) {
            return c[p];
        })
    };

    var ctx = {
        worksheet: 'Worksheet',
        table: HtmlData
    }

    var link = document.createElement("a");
    link.download = FileName + ".xls";
    link.href = uri + base64(format(template, ctx));
    link.click();

}



function replaceCharacter(String) {
    debugger;
    return String.replace(/[<>&'"]/g, function (c) {
        switch (c) {
            case '<': return '#60;';
            case '>': return '#62;';
            case '&': return '#38;';
            case '\'': return '#39;';
            case '"': return '#34;';

        }
    });
}


function replaceEntity(String) {
    debugger;
    return String.replace(/&amp;/g, '#38;').replace(/&lt;/g, '#60;').replace(/&gt;/g, '#62;').replace(/&nbsp;/g, '#160;')
}

function CharacterEndToEntity(StrXml) {
    return StrXml.replace(/[<>&'"]/g, function (c) {
        switch (c) {
            case '<': return '&lt;';
            case '>': return '&gt;';
            case '&': return '#38;';
            case '\'': return '#39;';
            case '"': return '&quot;';
            case '&nbsp;': return '&#160;';
        }
    });
}


function SearchTable(controlName, tableName) {
    // Declare variables 
    var input, filter, table, tr, td, i;
    input = document.getElementById(controlName);
    filter = input.value.toUpperCase();
    table = document.getElementById(tableName);
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those who don't match the search query
    for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[0];
        if (td) {
            if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
                tr[i].style.display = "";
            } else {
                tr[i].style.display = "none";
            }
        }
    }
}


function Select2DataTable(DataTable, ParamID, ParamText, ParamFlag) {
    ///debugger;
    var Dt = []

    for (i = 0; i < DataTable.length; i++) {

        Dt.push({
            id: DataTable[i][ParamID]
            , text: DataTable[i][ParamText]
            , disabled: DataTable[i][ParamFlag]
        });
    }

    return Dt
}
function Select2DataTablewithValue(DataTable, ParamID, ParamText, title) {
    debugger;
    var Dt = []

    for (i = 0; i < DataTable.length; i++) {

        Dt.push({
            id: DataTable[i][ParamID]
            , text: DataTable[i][ParamText]
            , title: DataTable[i][title]
        });
    }

    return Dt
}

function Resetwysihtml5(ID, value) {
    debugger
    var content = $('#' + ID);
    var contentPar = content.parent()
    contentPar.find('.wysihtml5-toolbar').remove()
    contentPar.find('iframe').remove()
    contentPar.find('input[name*="wysihtml5"]').remove()
    content.show()
    $('#' + ID).val(value)
    $('#' + ID).wysihtml5()

}
function Resetwysihtml5CEA(ID, value) {
    debugger
    var content = $('#' + ID);
    var contentPar = content.parent()
    contentPar.find('.wysihtml5-toolbar').remove()
    contentPar.find('iframe').remove()
    contentPar.find('input[name*="wysihtml5"]').remove()
    content.show()
    $('#' + ID).val(value)
    $('#' + ID).wysihtml5({
        toolbar: {
            "font-styles": false, // Font styling, e.g. h1, h2, etc.
            "emphasis": true, // Italics, bold, etc.
            "lists": true, // (Un)ordered lists, e.g. Bullets, Numbers.
            "html": false, // Button which allows you to edit the generated HTML.
            "link": false, // Button to insert a link.
            "image": false, // Button to insert an image.
            "color": false, // Button to change color of font
            "blockquote": true, // Blockquote
        }
    })

}

function Focus(ID, delay) {
    $('html, body').animate({
        scrollTop: $('#' + ID).offset().top
    }, (delay == 'undefined') ? 500 : delay);
}
function Focusclass(ID, delay) {
    $('html, body').animate({
        scrollTop:  $('.' + ID).offset().top
    }, (delay == 'undefined') ? 500 : delay);

}

function RedeclareboxWidget() {
    $('.box').boxWidget({
        animationSpeed: 500,
        collapseTrigger: '.btn',
        collapseIcon: 'fa-minus',
        expandIcon: 'fa-plus'
    })
}

var DateConfiguration = {
    ConvertSAPToDDMMYYYY: function (SAPTIME) {
        return SAPTIME.substr(6, 2) + '-' + SAPTIME.substr(4, 2) + '-' + SAPTIME.substr(0, 4);
    }
}

var CheckBoxConfiguration = {
    CheckBoxAllBulk: function (a, className) {
        if (a.checked) {
            CheckBoxConfiguration.SelectAllBulk(className);
        }
        else {
            CheckBoxConfiguration.UnselectAllBulk(className);
        }
    },
    SelectAllBulk: function (className) {
        $('.' + className).prop('checked', true);
    },
    UnselectAllBulk: function (className) {
        $('.' + className).prop('checked', false);
    },
    CheckBoxAllInsideDataTable: function (a, dataTablesName) {
        if (a.checked) {
            CheckBoxConfiguration.SelectAllInsideDataTable(dataTablesName);
        }
        else {
            CheckBoxConfiguration.UnSelectAllInsideDataTable(dataTablesName);
        }
    },
    SelectAllInsideDataTable: function (dataTablesName) {
        $('#' + dataTablesName).DataTable().rows().nodes().to$().find('input[type="checkbox"]').each(function () {
            $(this).prop('checked', true)
        })
    },
    UnSelectAllInsideDataTable: function (dataTablesName) {
        $('#' + dataTablesName).DataTable().rows().nodes().to$().find('input[type="checkbox"]').each(function () {
            $(this).prop('checked', false)
        })
    }
}

function capitalize(str, force) {
    str = force ? str.toLowerCase() : str;
    return str.replace(/(\b)([a-zA-Z])/,
        function (firstLetter) {
            return firstLetter.toUpperCase();
        });
}


function isvalidationemail(email) {
    debugger;
    
    let retval = true;

    const _emailall = email.split(';')
    var _countError = 0;

    for (let i = 0; i < _emailall.length; i++) {
        var regex = /^([a-za-z0-9_.+-])+\@(([a-za-z0-9-])+\.)+([a-za-z0-9]{2,4})+$/;
        var returndt = regex.test(_emailall[i])
        if (returndt == false) {
            _countError += 1;
        }       

    }
    debugger;
    if (_countError > 0) {
        retval = false;
    }


   
    return retval
}

function validateForm(id) {
    var isvalid;
    var errorcount = 0;
    var form = $('#' + id);
    if (form.valid() === false) {
        errorcount++;
    }
    $("form#" + id + " :input").each(function () {
        var input = $(this);

        isvalid = input.valid();
        if (isvalid === false) {
            console.log(input);
            errorcount++;
        }
    });
    if (errorcount > 0) {
        console.log(errorcount);
        return false;
    }
    console.log(errorcount);
    return false;
}
function dbDatetoStringDate(strdate)
{
    
    var _Date = new Date(strdate);
    var dateObj = moment(_Date, 'MM-DD-YYYY');
    var retdate = dateObj.format('L');

   return retdate;
}
function StringDatetodbDate(strdate)
{
    var _Date = strdate;
    var dateObj = moment(_Date, 'MM-DD-YYYY');
    var retdate = dateObj.format('YYYY-MM-DD');

    return retdate;
}
function dbDatetoStringFormat(strdate,format)
{
    
    var _Date = new Date(strdate);
    var dateObj = moment(_Date, 'MM-DD-YYYY');
    var retdate = dateObj.format(format);

   return retdate;
}
//function isEmail(e) {
//    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
//    var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
//    if (regex.test(str)) {
//        return true;
//    }
//    e.preventDefault();
//    return false;
//}