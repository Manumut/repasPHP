<?php
    // USUARIOS
    // INICIAR SESION

    function iniciar(){
        require_once("../modelo/class_user.php");
        $usuario = new Usuario();


        // conprobar si el usu esta en la bd
        if($usuario->comprobarNombre($_POST["nom"])){
            // comporbar q la contrasenia esta correcta
            if($usuario->comprobarContr($_POST["nom"], $_POST["contr"])){
                // tipo de usu
                $tipo=$usuario->comprobarTipo($_POST["nom"],[$_POST["contr"]]);
                // sacar id del usu
                $id=$usuario->get_id($_POST["nom"], $_POST["contr"]);


                // si ha marcado el boton de recordar, generamos cookie
                if(isset($_POST["rec"])){
                    require_once("../modelo/cookies_sesiones.php");
                    set_cookie("usuario",$_POST["nom"]);
                }

                //Se abren dos sesiones, una guarda el nombre del usuario y otra el id.
                require_once("../modelo/cookies_sesiones.php");
                set_session("usu",$_POST["nom"], "id", $id, "tipo", $tipo);

                // guardamos el nombre del usuario e la sesion
                $nUdu=$_SESSION["usu"];

                // redirecciones segun usuario
                if($_SESSION["tipo"]=="usuario"){
                    $tipo="usuario";
                    require_once("../modelo/class_amigo.php");

                    $amigo=new Amigo();
                    $datosAmigo=$amigo->get_Amigos([$_SESSION["id"]]);
                    require_once("../vista/menu_amigos.php");
                }


            }
        }
    }

    function irVistaAmigos($toast=null){
        require_once("../modelos/cookies_sesiones.php");
        start_session();

        if($_SESSION["tipo"]=="admin"){
            require_once("../modelo/class_amigo.php");
            $amigo = new Amigo();
            $datosAmigo=$amigo->get_AllAmigos();
            require_once("../vista/menu_amigos.php");
        }else{
            require_once("../modelo/class_amigo.php");
            $amigo = new Amigo();
            $datosAmigo=$amigo->get_Amigos($_SESSION["id"]);//Buscamos amigo a traves del id del usuario
            require_once("../vista/menu_amigos.php");
        }
    }

    function iniSesion(){
        require_once("../vista/login.php");
    }

    function salir(){
        require_once("../modelo/cookies_sesiones.php");
        unset_session();

        iniSesion();
    }

    function vistaInsertAmigos(String $mensaje=null, $idUsu=null){
        require_once("../modelo/cookies_sesiones.php");
        start_session();

        // Sacamos el tipo para saber si es admin o usuario para la hora de mostrar el menu
        $tipo=$_SESSION["tipo"];

        if(isset($_REQUEST["idAmigo"])){
            $id=$_REQUEST["idAmigo"];

            require_once("../modelo/class_amigo.php");
            $amigo=new Amigo();
            $datos=$amigo;
        }

        require_once("../vista/insertar_amigos.php");

    }


     function insertar(){
        //Se necesita start_session para abrir una sesión y poder utilizar el valor de la sesión id como parámetro
        require_once("../Modelo/cookies_sesiones.php");
        start_session();
        $tipo=$_SESSION["tipo"];

        require_once("../Modelo/class_amigo.php");
        $amigo=new Amigo();

        //Si el tipo es usuario, el usuario al que se le inserta el amigo es a ese usuario identificado, si es admin, se elige al usuario al que se quiere insertar el amigo
        if(strcmp($tipo,"usuario") == 0){
            //Antes de insertar hay que comprobar que la fecha no sea futura
                if($amigo->insertarAmigo($_POST["nombre"],$_POST["ape"],$_POST["nac"],$_SESSION["id"])){
                    //Si se ha insertado correctamente, mostrar mensaje y redirigir al menu de amigos
                    $toast=true;
                    irVistaAmigos($toast);
                }else{
                    //Si no se ha insertado correctamente mostrar un mensaje
                    $mensaje="Error. No se ha podido realizar la inserción";
                    vistaInsertAmigos($mensaje);
                }
            }
        }
        
    
        function modificarAmigo(){
            require_once("../Modelo/cookies_sesiones.php");
            start_session();
            $tipo=$_SESSION["tipo"];
    
            require_once("../Modelo/class_amigo.php");
            $amigo=new Amigo();
    
            //Si el tipo es usuario se modifica sin indicarle el dueño, si es admin hay que indicarle el dueño
            if(strcmp($tipo,"usuario")==0){
                //Antes de modificar hay que comprobar que las fechas no sean futuras
                    $modificado=$amigo->modificar_amigo($_POST["nombre"],$_POST["ape"],$_POST["nac"],$_POST["idAmigo"]);
                    if($modificado){
                        //Redirigir al menu de amigos y mostrar toast de Exito
                        irVistaAmigos();
                    }
            }
        }


        function vistaBuscarAmigos(){
            require_once("../Modelo/cookies_sesiones.php");
            start_session();
    
            //Sacar el tipo cada vez que se muestra una vista para saber que menú se tiene que mostrar en ese momento
            $tipo=$_SESSION['tipo'];
    
            //Si el tipo de usuario es usuario, se redirige al buscador de amigos, si es admin, se redirige al buscador de amigos del administrador
            if(strcmp($tipo,"usuario")==0){
                require_once("../Vista/buscador_amigos.php");
            }else{
                require_once("../Vista/buscador_contactos.php");
            }
        }

        function buscar(){
            require_once("../Modelo/cookies_sesiones.php");
            start_session();
    
            //Sacar el tipo cada vez que se muestra una vista para saber que menú se tiene que mostrar en ese momento
            $tipo=$_SESSION['tipo'];
    
            //Formatear el valor de búsqueda
            $busqueda=ucfirst(trim($_POST["busqueda"])); //lo q viene de la busqueda se pasa a mayusculas (con ucfirst) y se quitan espacios en blanco al principio y al final

        //Si el campo no se ha enviado vacío, se muestran los resultados
        if(!empty($busqueda)){
            if($tipo==="usuario"){
                
                switch ($_POST["tipoBusq"]) {
                    case 'amigos':
                        require_once("../Modelo/class_amigo.php");
                        $amigo=new Amigo();
                        $resultadosBusqueda=$amigo->buscarAmigo($_SESSION["id"],$busqueda);
                        require_once("../Vista/buscador_amigos.php");
                        break;
                    
                    // case 'juegos':
                    //     require_once("../Modelo/class_juego.php");
                    //     $juego=new Juego();
                    //     $resultadosBusqueda=$juego->buscarJuego($busqueda, $_SESSION['id']);
                    //     require_once("../Vista/cabecera.php");
                    //     require_once("../Vista/buscador_juegos.php");
                    //     require_once("../Vista/pie.html");
                    //     break;
                    
                    // case 'prestamos':
                    //     require_once("../Modelo/class_prestamo.php");
                    //     $prestamo=new Prestamo();
                    //     $resultadosBusqueda=$prestamo->buscarPrestamo($busqueda,$_SESSION['id']);
                    //     require_once("../Vista/cabecera.php");
                    //     require_once("../Vista/buscador_prestamos.php");
                    //     require_once("../Vista/pie.html");
                    //     break;
                }

            // }else if($tipo==="admin"){
            //     switch ($_POST["tipoBusq"]) {
            //         case 'amigos':
            //             require_once("../Modelo/class_amigo.php");
            //             $amigo=new Amigo();
            //             $resultadosBusqueda=$amigo->buscarContacto($busqueda);
            //             require_once("../Vista/cabecera.php");
            //             require_once("../Vista/buscador_contactos.php");
            //             require_once("../Vista/pie.html");
            //             break;

            //         case 'usuarios':
            //             require_once("../Modelo/class_user.php");
            //             $usuario=new Usuario();
            //             $resultadosBusqueda=$usuario->buscarUsuario($busqueda);
            //             require_once("../Vista/cabecera.php");
            //             require_once("../Vista/buscador_usuarios.php");
            //             require_once("../Vista/pie.html");
            //             break;
            //     }
            // }
            
        }else{
            $msj="El campo está vacío, rellenalo para buscar";
            
            if($tipo==="usuario"){
                
                switch ($_POST["tipoBusq"]) {
                    case 'amigos':
                        
                        require_once("../Vista/cabecera.php");
                        require_once("../Vista/buscador_amigos.php");
                        require_once("../Vista/pie.html");
                        break;
                    
                    // case 'juegos':
        
                    //     require_once("../Vista/cabecera.php");
                    //     require_once("../Vista/buscador_juegos.php");
                    //     require_once("../Vista/pie.html");
                    //     break;
                    
                    // case 'prestamos':
                        
                    //     require_once("../Vista/cabecera.php");
                    //     require_once("../Vista/buscador_prestamos.php");
                    //     require_once("../Vista/pie.html");
                    //     break;
                }

            // }else if($tipo==="admin"){
            //     switch ($_POST["tipoBusq"]) {
            //         case 'amigos':
                        
            //             require_once("../Vista/cabecera.php");
            //             require_once("../Vista/buscador_contactos.php");
            //             require_once("../Vista/pie.html");
            //             break;

            //         case 'usuarios':
                        
            //             require_once("../Vista/cabecera.php");
            //             require_once("../Vista/buscador_usuarios.php");
            //             require_once("../Vista/pie.html");
            //             break;
            //     }
            // }
            }


        
            }
        }
    }


    //Función para ordenar amigos por nombre
    function ordenarNombre($idUsu=null){
        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        require_once("../Modelo/class_amigo.php");
        $amigo=new Amigo();
        $datosAmigo=$amigo->ordenarNombre($_SESSION["id"]);

        //Sacar el tipo cada vez que se muestra una vista para saber que menú se tiene que mostrar en ese momento
        $tipo=$_SESSION['tipo'];


        require_once("../Vista/menu_amigos.php");

    }


    function ordenarFecha($idUsu=null){
        require_once("../Modelo/cookies_sesiones.php");
        start_session();

        require_once("../Modelo/class_amigo.php");
        $amigo=new Amigo();
        $datosAmigo=$amigo->ordenarFecha($_SESSION["id"]);

        //Sacar el tipo cada vez que se muestra una vista para saber que menú se tiene que mostrar en ese momento
        $tipo=$_SESSION['tipo'];


        require_once("../Vista/menu_amigos.php");

    }


    if(isset($_REQUEST["action"])){
        $action=strtolower($_REQUEST["action"]);
        //Para juntar los strings si el valor del action tiene un espacio entre medio
        $action = str_replace(' ', '', $action);

        //Estos if sirven para que en función del value del input submit, se llame a la función correspondiente si esta tiene otro nombre diferente
        if($action=="insertaramigos") $action="vistaInsertAmigos";
        
        if($action=="insertarjuego") $action="vistaInsertarJuego";
        if($action=="añadirjuego") $action="insertarJuego";
        if($action=="modificaramigo") $action="modificarAmigo";
        if($action=="modificarjuego") $action="modificarJuego";
        if($action=="insertarprestamo") $action="verInsertarPrestamo";
        if($action=="insertar") $action="insertarPrestamo";
        if($action=="enviar") $action="insertar";
        if($action=="buscarprestamos") $action="vistaBuscarPrestamos";
        if($action=="buscarjuegos") $action="vistaBuscarJuegos";
        if($action=="buscaramigos") $action="vistaBuscarAmigos";
        if($action=="buscarusuarios") $action="vistaBuscarUsuarios";
        

        $action();
    }else{
        //Se comprueba si existe ya una sesión
        require_once("../Modelo/cookies_sesiones.php");
        if(is_session("usu")){
            //Si la sesión ya está abierta, se guarda el nombre del usuario, que está en la sesión
            irVistaAmigos();
        }else{
            //Si no hay sesión, se redirige al login
            iniSesion();
        }

        // "'^(?=(.*[0-9]){2,})(?=.*[A-Z])(?=(.*[\W_]){3,}).{8,20}$'";
        // if(preg_match($patron, $cadena2)){
        //     echo "<p>Válida</p>";
        // }else{
        //     echo "<p>error</p>";
        // }
        // ALTER TABLE <nombre_tabla> DROP COLUMN <nombre_columna>
        // DELETE FROM <nombre_tabla> WHERE condición;
        // Borrar todas las filas de la tabla clientes.
        // DELETE FROM clientes;
    }
?>
