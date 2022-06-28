function formDataToJson(id) {
    var $form = $(`#${id}`);
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function (n) {
        if (n['name'].indexOf("[]") != -1) {// é um multiselect
            let field = n['name'].replace("[]", "");
            if (indexed_array[field] == undefined) {
                indexed_array[field] = [];
            }
            indexed_array[field].push(n['value']);
        } else {
            indexed_array[n['name']] = n['value'];
        }
    });
    return indexed_array;
}

function formatMoney(n) {
    n = parseFloat(n);
    return "R$ " + n.toFixed(2).replace('.', ',').replace(/(\d)(?=(\d{3})+\,)/g, "$1.");
}

function validateCpf(cpf) {
    cpf = cpf.replace(/[^\d]+/g,'');
    if(cpf == '') return false;
    // Elimina CPFs invalidos conhecidos
    if (cpf.length != 11 ||
        cpf == "00000000000" ||
        cpf == "11111111111" ||
        cpf == "22222222222" ||
        cpf == "33333333333" ||
        cpf == "44444444444" ||
        cpf == "55555555555" ||
        cpf == "66666666666" ||
        cpf == "77777777777" ||
        cpf == "88888888888" ||
        cpf == "99999999999")
        return false;
    // Valida 1o digito
    add = 0;
    for (i=0; i < 9; i ++)
        add += parseInt(cpf.charAt(i)) * (10 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(9)))
        return false;
    // Valida 2o digito
    add = 0;
    for (i = 0; i < 10; i ++)
        add += parseInt(cpf.charAt(i)) * (11 - i);
    rev = 11 - (add % 11);
    if (rev == 10 || rev == 11)
        rev = 0;
    if (rev != parseInt(cpf.charAt(10)))
        return false;
    return true;
}

function showLoading() {
    $("#showLoading").modal({
        backdrop: "static", //remove abilidfsaty to close modal with click
        keyboard: false, //remove option to close with keyboard
        show: true //Display loader!
    });
}

function closeLoading(anotherModal = false) {
    setTimeout(function () {
        $("#showLoading").modal("hide");
        if (anotherModal){
            setTimeout(function () {
                $("body").addClass("modal-open");
            }, 400);
        }
    }, 500);
}

function maskCpf(cpf) {
    return cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/g, "\$1.\$2.\$3\-\$4");
}

function rmElement(id) {
    const field = $("#" + id);
    field.hide(200);
    document.getElementById(id).remove();
}
