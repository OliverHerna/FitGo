$('.client_code-dropdown').select2({
    placeholder: 'Selecciona los sectores de cliente para este usuario',
    width: '100%',
    theme: "bootstrap"
});

$(document).ready(function () {
    var _option_role2 = document.getElementById("role").value;
    var role_label_client = document.getElementById("role_label_client");
    if (_option_role2 == 3) {
        document.getElementById("company_name_field").style.display = "block";
        document.getElementById("email").readOnly = true;
        document.getElementById("role_label_user").style.display = "none";
        role_label_client.style.display = "block";
        document.getElementById("role_client").readOnly = true;
        document.getElementById("password").readOnly = true;
        document.getElementById("password_confirmation").readOnly = true;
    } else {
        role_label_client.style.display = "none";
    }
});

var _option_role1 = document.getElementById("role").value;
console.log(_option_role1);
function companyFunction() {
    var _option_role2 = document.getElementById("role").value;
    if (_option_role2 == 3) {
        document.getElementById("company_name_field").style.display = "block";
        var company_name = document.getElementById("company_name");
        company_name.value = "";
    }
    else {
        document.getElementById("company_name_field").style.display = "none";
        var company_name = document.getElementById("company_name");
        company_name.value = "Sin Company Name";
    }
}
