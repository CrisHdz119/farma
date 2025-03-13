<?php
class Conexion{
    private $Servidor = "localhost";
    private $db = "farmacia_sistema";
    private $puerto = 3306;
    private $charset = "utf8";
    private $usuario = "root";
    private $contrasena = "";
    public $pdo = null;
    private $atributos = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
    ];

    function __construct(){
        try{
            $this->pdo = new PDO("mysql:host={$this->Servidor};dbname={$this->db};port={$this->puerto};charset={$this->charset}", $this->usuario, $this->contrasena, $this->atributos);
        }catch(PDOException $e){
            echo 'Error de conexión: ' . $e->getMessage();
        }
    }
}
?>