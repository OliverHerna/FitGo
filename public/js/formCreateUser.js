function clientComp() {
    //Identificador del Rol seleccionado
    var _option_role2 = document.getElementById("role").value;
    //Campos de Contraseñas
    var psw = document.getElementById('password');
    var pswConfirm = document.getElementById('password_confirmation');
    //Div de Contraseñas
    var psw_field = document.getElementById("password_field");
    var pswConfirm_field = document.getElementById("password_conf_field");
    //Div y campo Nombre la Compañia
    var company_name_field = document.getElementById("company_name_field");
    var cmp_name = document.getElementById("company_name");
    //Div y campo Paquete
    var paquete_field = document.getElementById('paquete_field');
    var paquete = document.getElementById('paquete')

    if (_option_role2 == 3) {
        //Mostrar y habilitar campo Nombre de la Compañia
        company_name_field.style.display = "block";
        cmp_name.disabled = false;
        //Mostrar y habilitar campo Paquete
        paquete_field.style.display = "block";
        paquete.disabled = false;
        //Ocultar, desabilitar y vaciar campos Contraseña y Confirmar Contraseña
        psw_field.style.display = "none";
        psw.disabled = true;
        psw.value = "";
        pswConfirm_field.style.display = "none";
        pswConfirm.disabled = true;
        pswConfirm.value = "";
    }
    else {
        //Ocultar,desabilitar y vaciar campo Nombre de la Compañia
        company_name_field.style.display = "none";
        cmp_name.disabled = true;
        cmp_name.value = "";
        //Ocultar,desabilitar y vaciar campo Paquete
        paquete_field.style.display = "none";
        paquete.disabled = true;
        paquete.value = "";
        //Habilitar campos Contraseña y Confirmar Contraseña
        psw_field.style.display = "block";
        psw.disabled = false;
        psw.value = "";
        pswConfirm_field.style.display = "block";
        pswConfirm.disabled = false;
        pswConfirm.value = "";
    }

}
