<?php
    require_once("cabezera.html");
?>

<body class="menuAmigos">
    <!-- Cambiar título en función de si se le pasa por la url el valor del nombre del amigo a modificar o no -->
    <h1 class="text-center"><?php if(isset($_REQUEST["idAmigo"])){echo "Modificar";}else{echo "Nuevo";}?> Amigo</h1>

<div class="contenedor d-flex justify-content-center">
    <div class="tableContainer d-flex flex-column mx-5 justify-content-center rounded p-5 mt-4 text-center w-25">
        <form action="../Controlador/index.php" method="POST">
            <!-- Si se le pasa el valor de un id de amigo a modificar por la url, se almacena en un campo oculto, así al enviar el formulario se podrá utilizar el valor en la función de modificarAmigo() -->
            <?php if(isset($_REQUEST["idAmigo"])) echo "<input type='hidden' name='idAmigo' value='".htmlspecialchars($_REQUEST["idAmigo"])."'>";?>
            

            <label for="nombre">Nombre</label><br>
        <!-- Establecer los datos del array para rellenar los campos automáticamente-->
            <!-- Utilizo htmlspecialchars como una medida de seguridad para evitar ataques de inyección de código, convierte los caracteres especiales de HTML en su representación segura -->
            <input type="text" class="mb-2" name="nombre" value="<?php if(isset($datos[0])) echo $datos[0];?>" required ><br>
            <label for="ape">Apellidos</label><br>
            <input type="text" class="mb-2" name="ape" value="<?php if(isset($datos[1])) echo $datos[1];?>" required ><br>
            <!-- Al enviar el formulario hay que comprobar que la fecha no sea futura ni que el amigo haya nacido hace dos días, para ello he establecido un mínimo de 10 años para que se pueda insertar al amigo -->
            <label for="nac">Fecha Nacimiento</label><br>
            <input type="date" class="mb-2" name="nac" value="<?php if(isset($datos[2])) echo $datos[2];?>" min="1927-01-01" max="<?php echo (date("Y")-10)."-12-31";?>" required><br>
            <!-- Añadir un campo más en caso de que el usuario sea administrador -->
            <?php   
                if(isset($usuarios)) {
                    echo "<label for='duenio'>Dueño</label><br>";
                    echo "<select class='mb-5' name='duenio' required>";
                    foreach ($usuarios as $key => $value) {
                        echo "<option value='$key'";
                        if(isset($duenio)){
                            if($duenio==$key){
                                echo "selected";
                            }
                        }
                        
                        echo ">$value[0]</option>";
                    }
                    echo "</select><br> ";
                }
            ?>

                <!-- AHORA ESTO YA NO HARÍA FALTA AL COMPROBAR LAS FECHAS DIRECTAMENTE EN EL INPUT -->
            <!-- Cambiar botón en función de si se le pasa el valor del id del amigo a modificar o no, se usa $_REQUEST porque el id puede venir desde dos vías, como parámetro por la url al cargar la página inicialmente, o por un parámetro que se le pasa a la función para ir a esta vista si la página se recarga porque la fecha es incorrecta (para que no se pierdan los datos)-->
            <input type="submit" value="<?php if(isset($_REQUEST["idAmigo"])){echo "Modificar amigo";}else{echo "Enviar";} ?>" name="action" class="btn btn-primary btn-lg rounded-pill shadow-sm hover-shadow-lg neon-effect" style="background-color: #fada4b; border-color: #f5a52c; color: black;">
        </form>
        <?php
            if(isset($mensaje)) echo "<p>$mensaje</p>";
        ?>
    </div>
</div>
</body>



<?php
    require_once("pie.html");
?>