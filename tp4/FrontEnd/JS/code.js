$(document).ready(function () {
 
    $("#btnLogin").click(MetodoLogueo);   
    $("#btnAgregar").click(AgregarAuto);
    $("#btnPatente").click(VerificoPatente);
    //agregar un llamado a funcion que valide usuario

});

function MetodoLogueo()
{
    vMail = $("#mailStr").val();    
    vPass = $("#passStr").val();
       
    $.ajax({
      
        url: 'http://localhost/Est_III/API/empleado/login',
        data:{'mail':vMail ,'clave': vPass},
        method: 'post',
        dataType: 'json', 
        success: function (response) {

            if(response != false){

               // console.log(response);
                if(response.elEmpleado.perfil == "Administrador")
                {
                    console.log("Es administrador y nos falta codear eso!!");
                }
               localStorage.setItem("token",response.token);
               ingresoPatente.style.display = "block";
             
            }
            else{
                alert("el usuario y/o la contraseña son inválidos!!");
            }         
       }   
    })
    
}


function VerificoPatente()
{
    patenteStr = $("#patenteStr").val();   
   
    $.ajax({
        url: 'http://localhost/Est_III/API/auto/',
        data: {'patente':patenteStr},
        headers: {'token': localStorage.getItem('token')},
        method: 'get',
        dataType: 'json',
        success: function (response) {
            
         //   console.log(response);
            if(response != false){

                var answer = confirm("El auto ya existe, desea sacarlo?");
                if (answer)
                {
                    RetirarAuto(patenteStr);
                }
                else{
                    alert("Decidió no retirar el auto");
                }
            }
            else{

                var answer = confirm("El auto no existe, desea cargarlo?");
                if (answer)
                {
                    ingresoAutos.style.display = "block";
                    
                }
                else
                {
                  console.log('cancel');
                }

            }}

    })

}


function AgregarAuto() {
    
        var patenteStr = $("#patenteStr").val();
        var marcaStr = $("#marcaStr").val();
        var colorStr = $("#colorStr").val();
       
        info = 'patente=' + encodeURIComponent(patenteStr) + '&marca=' + encodeURIComponent(marcaStr) + '&color=' + encodeURIComponent(colorStr);
    
        $.ajax({
            url: 'http://localhost/Est_III/API/auto/',
            headers: {'token': localStorage.getItem('token')},
            data: info,
            method: 'post',
            dataType: 'json',  
            success: function (response) {
                
                if(response != false){
    
                    alert("El auto fue cargado!!");
                    ingresoAutos.style.display = "none";
                }
            }   
        })
        
    }
    
    function RetirarAuto(patenteStr) {
        
                        
            $.ajax({
                url: 'http://localhost/Est_III/API/auto/',
                data: {'patente':patenteStr},
                headers: {'token': localStorage.getItem('token')},
                method: 'delete',
                dataType: 'json',
                success: function (response) {
                    
                    if(response != false){
        
                        alert("El auto fue eliminado!!");
                        
                        console.log(response);
                        //ingresoAutos.style.display = "none";
                    }
                }   
            })
            
        }
    





//función que valida usuario y trae formulario para cagar autos

//https://www.youtube.com/watch?v=kvlBmon98xg   
function ManejadorBtn(index) {

    var botonActuar = $("#btnAgregar").val();

    if (botonActuar == "Modificar") {
        $("#btnAgregar").click(function () {
            ModificarPersona(index);
        });
    }
    else {
        AgregarAuto();
    }
}

    /*
function CargarLista() {
      
        var autos = [];
        var body = "";
    
        console.log('Dentro de cargar lista')
        $.ajax({
            //debería pegar a traer todos
            url: 'http://localhost/Estacionamiento_II/auto/',
            method: 'get',
            dataType: 'json',
            success: function (response) {
            
                autos = $(response);
                for (i = 0; i < autos.length; i++) {
    
                    if (autos[i] == null) continue;
                    var cadena = "<tr><td>" + autos[i].patente + "</td><td>" + autos[i].marca + "</td><td>" + autos[i].color + "</td><td>" + autos[i].hora + "</td><tr>";
                    body += cadena;
                }
                $("#contenido").html(body);
            }
        })
    }
    
    


/*

function ModificarPersona(index) {

    var apellidoStr = $("#apellidoStr").val();
    var nombreStr = $("#nombreStr").val();  

    varPersona = new Object();
    varPersona.nombre = nombreStr;
    varPersona.apellido = apellidoStr;

    info = 'indice=' + encodeURIComponent(index) + '&persona=' + encodeURIComponent(JSON.stringify(varPersona));

    $.ajax({

        url: 'http://localhost:3000/modificarpersona',
        data: info,
        method: 'post',
        dataType: 'json'        
    })
    $("#btnAgregar").attr('value', 'Agregar');
    CargarLista();

}

function ModificarJquery(index) {

    $("#btnAgregar").attr('value', 'Modificar');
    ManejadorBtn(index);
}


function CargarLista() {

    var personas = [];
    var body = "";

    $.ajax({
        url: 'http://localhost:3000/traerpersonas',
        method: 'get',
        dataType: 'json',
        success: function (response) {

            personas = $(response);
            for (i = 0; i < personas.length; i++) {

                if (personas[i] == null) continue;
                var cadena = "<tr><td>" + personas[i].nombre + "</td><td>" + personas[i].apellido + "</td><td><input type='button' onclick='BorrarJquery(" + i + ")' id='btnAgregar' value='Borrar'></td><td><input type='button' onclick='ModificarJquery(" + i + ")' id='btnAgregar' value='Modificar'></tr>";
                body += cadena;
            }
            $("#contenido").html(body);
        }
    })
}


function BorrarJquery(index) {

    info = 'indice=' + encodeURIComponent(index);
    $.ajax({
        url: 'http://localhost:3000/eliminarpersona',
        data: info,
        method: 'post',
        dataType: 'json',
    })
    CargarLista();
}


*/
