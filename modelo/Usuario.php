<?php
    include_once 'Conexion.php';
    class Usuario{
        var $objetos;
        public function __construct(){
            $db = new Conexion();
            $this->acceso = $db->pdo;
        }
        function Loguearse($dni,$pass){
            $sql = "SELECT * FROM usuario inner join tipo_us on us_tipo=id_tipo_us WHERE usuario=:dni and contrasena_us=:pass";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':dni'=>$dni,':pass'=>$pass));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }
        function obtener_datos($id){
            $sql = "SELECT * FROM usuario join tipo_us on us_tipo=id_tipo_us and id_usuario=:id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id));
            $this->objetos = $query->fetchall();
            return $this->objetos;
        }
        function editar($id_usuario,$telefono,$residencia,$correo,$sexo,$adicional){
            $sql = "UPDATE usuario SET telefono_us=:telefono,residencia_us=:residencia,correo_us=:correo,sexo_us=:sexo,adicional_us=:adicional WHERE id_usuario=:id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id_usuario,':telefono'=>$telefono,':residencia'=>$residencia,':correo'=>$correo,':sexo'=>$sexo,':adicional'=>$adicional));
        }
        function cambiar_contra($id_usuario,$oldpass,$newpass){
            $sql = "SELECT * FROM usuario WHERE id_usuario=:id and contrasena_us=:oldpass";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id_usuario,':oldpass'=>$oldpass));
            $this->objetos = $query->fetchall();
            if(!empty($this->objetos)){
                $sql = "UPDATE usuario SET contrasena_us=:newpass WHERE id_usuario=:id";
                $query = $this->acceso->prepare($sql);
                $query->execute(array(':id'=>$id_usuario,':newpass'=>$newpass));
                echo 'update';
            }
            else{
                echo 'noupdate';
            }
        }
        function cambiar_photo($id_usuario,$nombre){
            $sql = "SELECT avatar FROM usuario WHERE id_usuario=:id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id_usuario));
            $this->objetos = $query->fetchall();
            
            $sql = "UPDATE usuario SET avatar=:nombre WHERE id_usuario=:id";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':id'=>$id_usuario,':nombre'=>$nombre));
            return $this->objetos;
        }
        function buscar(){
            if(!empty($_POST['consulta'])){
                $consulta = $_POST['consulta'];
                $sql = "SELECT * FROM usuario join tipo_us on us_tipo=id_tipo_us WHERE nombre_us LIKE :consulta";
                $query = $this->acceso->prepare($sql);
                $query->execute(array(':consulta'=>"%$consulta%"));
                $this->objetos = $query->fetchall();
                return $this->objetos;
            }
            else{
                $sql = "SELECT * FROM usuario join tipo_us on us_tipo=id_tipo_us WHERE nombre_us NOT LIKE '' ORDER BY id_usuario LIMIT 25";
                $query = $this->acceso->prepare($sql);
                $query->execute();
                $this->objetos = $query->fetchall();
                return $this->objetos;
            }
        }
        function crear($nombre,$apellido,$edad,$usuario_nombre,$pass,$tipo,$avatar){
            $sql = "SELECT id_usuario FROM usuario WHERE usuario=:usuario";
            $query = $this->acceso->prepare($sql);
            $query->execute(array(':usuario'=>$usuario_nombre));
            $this->objetos = $query->fetchall();
            if(!empty($this->objetos)){
                echo 'noadd';
            }
            else{
                $sql = "INSERT INTO usuario(nombre_us,apellidos_us,edad,usuario,contrasena_us,us_tipo,avatar) VALUES(:nombre,:apellido,:edad,:usuario,:pass,:tipo,:avatar)";
                $query = $this->acceso->prepare($sql);
                $query->execute(array(':nombre'=>$nombre,':apellido'=>$apellido,':edad'=>$edad,':usuario'=>$usuario_nombre,':pass'=>$pass,':tipo'=>$tipo,':avatar'=>$avatar));
                echo 'add';
            }
        }
    }
?>