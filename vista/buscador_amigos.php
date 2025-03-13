<?php
    require_once("cabezera.html");
?>

<body class="menuAmigos">
    <h1 class="text-center">Buscar Amigo</h1>

<div class="contenedor d-flex justify-content-center">
    <div class="tableContainer d-flex flex-column mx-5 justify-content-center rounded p-5 mt-4 text-center w-50">
        <form action="" method="post">
            <label for="busqueda">Nombre / Apellidos del amigo</label><br>
            <input type="search" name="busqueda" id=""><br>
            <!-- Mediante un campo oculto indico de qué es la busqueda para saber dentro de una función en el controlador a qué clase y método llamar -->
            <input type="hidden" name="tipoBusq" value="amigos">

            <input type="submit" value="Buscar" name="action" class="btn btn-primary btn-lg rounded-pill shadow-sm hover-shadow-lg neon-effect mb-5 mt-3" style="background-color: #fada4b; border-color: #f5a52c; color: black;">
        </form>

        <?php
        //Se comprueba si se ha enviado el formulario, si es así, si hat resultados compatibles con la búsqueda se muestran, sino, aparece un mensaje
        if (isset($_POST['busqueda']) && !empty($_POST['busqueda'])) {
                if(isset($resultadosBusqueda) && !empty($resultadosBusqueda)){
                    echo "<table><tr><th>Nombre</th><th>Apellidos</th><th>Nacimiento</th></tr>";
                    
                    foreach ($resultadosBusqueda as $key => $value) {
                        echo "<tr><td>$value[0]</td><td>$value[1]</td><td>$value[2]</td><td><a href='../Controlador/index_usuarios.php?action=Insertar amigos&idAmigo=".urldecode($key)."'>Modificar</a></td></tr>";
                    }

                    echo "</table>";
                }else if(empty($resultadosBusqueda)){
                    echo "<p>No hay resultados compatibles con tu búsqueda</p>";
                }
        }


                if(isset($msj)){
                    echo $msj;
                }
        ?>
    </div>
</div>
</body>



<?php
    require_once("pie.html");
?>