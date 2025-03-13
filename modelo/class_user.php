<?php

require_once("class_bd.php");


    class Usuario{
        private $conn;
        private $id;
        private $nombre;
        private $contrasenia;
        private $tipo;

        public function __construct(){
            $this->conn= new bd();
            $this->id="";
            $this->nombre="";
            $this->contrasenia="";
        }

        public function get_id($nom, $contra){
            $sentencia="SELECT id FROM usuario WHERE nombre=? AND contrasenia=?;";

            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("ss", $nom, $contra);
            $consulta->bind_result($id);
            
            $consulta->execute();
            $consulta->fetch();
            $consulta->close();
            return $id;
        }

        public function comprobarTipo($nom, $contra){
            $sentencia="SELECT tipo FROM usuario WHERE nombre=? AND contrasenia=?;";

            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("ss", $nom, $contra);
            $consulta->bind_result($tipo);

            $consulta->execute();
            $consulta->fetch();
            $consulta->close();

            return $tipo;
        }

        public function comprobarContr($nom, $contra){
            // comprobar q la contraseña es la correcta con el usuario
            $sentencia="SELECT count(contrasenia) FROM usuario WHERE nombre=? AND contrasenia=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("ss", $nom, $contra);
            $consulta->bind_result($count);
            $consulta->execute();

            $consulta->fetch();
            $correc=false;
            if($count==1){
                $correc=true;
            }
            $consulta->close();
            return $correc;
        }

        // compruebo q el usu esta en la bd
        public function comprobarNombre($nom){
            $sentencia="SELECT count(id) FROM usuario WHERE nombre=?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("s", $nom);
            $consulta->bind_result($count);
            $consulta->execute();            

            $consulta->fetch();
            $correc=false;
            if($count==1){
                $correc=true;
            }
            $consulta->close();            
            return $correc;
        }

        public function get_usuarios(){
            $sentencia="SELECT id, nombre, contrasenia FROM usuario WHERE nombre!='admin';";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_result($id, $nom, $contra);
            $consulta->execute();

            $datos=[];
            while($consulta->fetch()){
                $datos[$id]=[$nom, $contra];
            }
            $consulta->close();
            return $datos;
        }


        public function insertar_usuario($nom, $contr){
            $sentencia="INSERT INTO usuario (nombre,contrasenia) VALUES (?,?);";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $consulta->bind_param("ss", $nom, $contr);
            $consulta->execute();

            $insertado=false;
            while($consulta->affected_rows==1){
                $insertado=true;

            }
            $consulta->close();
            return $insertado;
        }

        public function buscarUsuario($busqueda){
            $sentencia="SELECT id, nombre, contrsasenia FROM usuario WHERE nombre LIKE ?;";
            $consulta=$this->conn->getConection()->prepare($sentencia);
            $param=$busqueda."%";
            $consulta->bind_param("s", $param);

            $consulta->bind_result($id,$nom,$contrasenia);
            $consulta->execute();

            $datos=[];
            while($consulta->fetch()){
                $datos[$id]=[$nom, $contrasenia];
            }
            $consulta->close();
            return $datos;
        }
    }
?>