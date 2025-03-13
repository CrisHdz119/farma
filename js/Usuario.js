$(document).ready(function (){
    var funcion='';
    var id_usuario = $('#id_usuario').val();
    buscar_usuario(id_usuario);
    function buscar_usuario(dato){
        funcion='buscar_usuario';
        $.post('../controlador/UsuarioController.php',{dato,funcion},(Response)=>{
            let nombre = '';
            let apellidos = '';
            let edad = '';
            let usuario = '';
            let tipo = '';
            let telefono = '';
            let residencia = '';
            let correo = '';
            let sexo = '';
            let adicional = '';
            const user = JSON.parse(Response);
            nombre+=`${user.nombre}`;
            apellidos+=`${user.apellidos}`;
            edad+=`${user.edad}`;
            usuario+=`${user.usuario}`;
            tipo+=`${user.tipo}`;
            telefono+=`${user.telefono}`;
            residencia+=`${user.residencia}`;
            correo+=`${user.correo}`;
            sexo+=`${user.sexo}`;
            adicional+=`${user.adicional}`;
            $('#nombre_us').html(nombre);
            $('#apellidos_us').html(apellidos);
            $('#edad').html(edad);
            $('#usuario').html(usuario);
            $('#us_tipo').html(tipo);
            $('#telefono_us').html(telefono);
            $('#residencia_us').html(residencia);
            $('#correo_us').html(correo);
            $('#sexo_us').html(sexo);
            $('#adicional_us').html(adicional);

            $('#avatar1').attr('src',user.avatar);//editar_datos_personales.php
            $('#avatar2').attr('src',user.avatar);//editar_datos_personales.php
            $('#avatar3').attr('src',user.avatar);//editar_datos_personales.php
            $('#avatar4').attr('src',user.avatar);//nav.php
        })
    }
    $(document).on('click','.edit',(e)=>{
        funcion='capturar_datos';
        edit=true;
        $.post('../controlador/UsuarioController.php',{funcion,id_usuario},(response)=>{
            const user = JSON.parse(response);
            $('#telefono').val(user.telefono);
            $('#residencia').val(user.residencia);
            $('#correo').val(user.correo);
            $('#sexo').val(user.sexo);
            $('#adicional').val(user.adicional);
        })
    });
    $('#form-usuario').submit(e=>{
        if(edit==true){
            let telefono = $('#telefono').val();
            let residencia = $('#residencia').val();
            let correo = $('#correo').val();
            let sexo = $('#sexo').val();
            let adicional = $('#adicional').val();
            funcion='editar_usuario';
            $.post('../controlador/UsuarioController.php',{id_usuario,telefono,residencia,correo,sexo,adicional,funcion},(response)=>{
                if(response=='editado'){
                    $('#editado').hide('slow');
                    $('#editado').show(1000);
                    $('#editado').hide(2000);
                    $('#form-usuario').trigger('reset');
                }
                edit=false;
                buscar_usuario(id_usuario);
            })
        }
        else{
            $('#noeditado').hide('slow');
            $('#noeditado').show(1000);
            $('#noeditado').hide(2000);
            $('#form-usuario').trigger('reset');
        }
        e.preventDefault();
    });

    $('#form-pass').submit(e=>{
        let oldpass=$('#oldpass').val();
        let newpass=$('#newpass').val();
        funcion='cambiar_contra';
        $.post('../controlador/UsuarioController.php',{id_usuario,oldpass,newpass,funcion},(response)=>{
            if(response=='update'){
                $('#update').hide('slow');
                $('#update').show(1000);
                $('#update').hide(2000);
                $('#form-pass').trigger('reset');
            }
            else{
                $('#noupdate').hide('slow');
                $('#noupdate').show(1000);
                $('#noupdate').hide(2000);
                $('#form-pass').trigger('reset');
            }
        })
        e.preventDefault();
    })
    $('#form-photo').submit(e=>{
        let formData = new FormData($('#form-photo')[0]);
        $.ajax({
            url:'../controlador/UsuarioController.php',
            type:'POST',
            data:formData,
            cache:false,
            processData:false,
            contentType:false
        }).done(function(response){
            const json = JSON.parse(response);
            if(json.alert=='edit'){
                $('#avatar1').attr('src',json.ruta);
                $('#edit').hide('slow');
                $('#edit').show(1000);
                $('#edit').hide(2000);
                $('form-photo').trigger('reset');
                buscar_usuario(id_usuario);
            }
            else{
                $('#noedit').hide('slow');
                $('#noedit').show(1000);
                $('#noedit').hide(2000);
            }
        });
        e.preventDefault();
    })
})