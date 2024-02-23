<?php
include '../Conexion/conexion.php';

$index = $pdo->prepare("SELECT 
                            doc.*,
                            ti.ti_texto, 
                            CONCAT(doc.doc_primerApellido,' ', doc.doc_segundoApellido, ' ', doc.doc_primerNombre) as docente
                        FROM docente doc
                            INNER JOIN tipoidentificacion ti
                            ON doc.ti_id = ti.ti_id
                        WHERE doc.doc_estado = 1");
$index -> execute();
$listaDocentes = $index->fetchAll(PDO::FETCH_ASSOC);

$tipoIdentificacion = $pdo->prepare("SELECT * FROM tipoidentificacion");
$tipoIdentificacion -> execute();
$listaTipoIdentificacion = $tipoIdentificacion->fetchAll(PDO::FETCH_ASSOC);

if(isset($_GET['guardado'])) {
    if ($_GET['guardado'] == "true") {
        echo '  <script>
                    alert("La inserción fue exitosa.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    } elseif($_GET['guardado'] == "cdif"){
        echo '  <script>
                    alert("Las Contraseñas No coinciden o longitud menor a 6 carácteres.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    }else {
        echo '  <script>
                    alert("Hubo un error durante la inserción.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    }
}

if(isset($_GET['editado'])) {
    if ($_GET['editado'] == "true") {
        echo '  <script>
                    alert("Modificado Exitosamente.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    } else {
        echo '  <script>
                    alert("Hubo un error durante la Modificación del Registro.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    }
}

if(isset($_GET['eliminado'])) {
    if ($_GET['eliminado'] == "true") {
        echo '  <script>
                    alert("Eliminado Exitosamente.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    } else {
        echo '  <script>
                    alert("Hubo un error durante al Eliminar  el Registro.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    }
}
//print_r($listaDocentes);
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Basic -->
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- Mobile Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <!-- Site Metas -->
        <meta name="keywords" content="" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <title>ACME</title>

        <!-- slider stylesheet -->
        <link rel="stylesheet" type="text/css"
            href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.1.3/assets/owl.carousel.min.css" />

        <!-- bootstrap core css -->
        <link rel="stylesheet" type="text/css" href="../css/bootstrap.css" />

        <!-- fonts style -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Roboto:400,700&display=swap" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="../css/style.css" rel="stylesheet" />
        <!-- responsive style -->
        <link href="../css/responsive.css" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <script defer src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script defer src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
        <script defer src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.js"></script>
    </head>

    <body>
        <!-- Menu -->
        <div class="hero_area">
            <?php include 'header.html'; ?>
        </div>
        
        <div class="container pt-4">
            <!-- Boton -->
            <div class="row">
                <div class="col-8"></div>
                <div class="col-4">
                    <div class="d-flex justify-content-end service_container">
                        <div class="d-flex justify-content-center contact_section">
                            <button id="agregarDocenteBtn">
                                Agregar Docente
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tabla -->
            <div class="row pt-4">
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">Docente</th>
                            <th class="text-center align-middle">Tipo de Identificación</th>
                            <th class="text-center align-middle">Identificacion</th>
                            <th class="text-center align-middle">Correo</th>
                            <th class="text-center align-middle">Direccion</th>
                            <th class="text-center align-middle">Telefono</th>
                            <th class="text-center align-middle">Acciones</th>
                        </tr>
                    </thead>
                    <?php $idti_hidden = 0;
                    foreach($listaDocentes as $Docente){ ?>
                        <tr>
                            <td class="text-center align-middle"><?= $Docente['docente']; ?></td>
                            <td class="text-center align-middle"><?= $Docente['ti_texto']; ?></td>
                            <td class="text-center align-middle"><?= isset($Docente['doc_numIdentificacion']) ? $Docente['doc_numIdentificacion'] : "-"; ?></td>
                            <td class="text-center align-middle"><?= $Docente['doc_correo']; ?></td>
                            <td class="text-center align-middle"><?= $Docente['doc_direccion']; ?></td>
                            <td class="text-center align-middle"><?= $Docente['doc_telefono']; ?></td>
                            <td class="align-middle"> 
                                <div class="d-flex justify-content-center contact_crud">
                                    <input type="hidden" name="txt_docente_curso" value="<?= $Docente['doc_id']; ?>">
                                    <button class="editarDocenteBtn btn btn-primary mr-2"
                                            data-idti="<?= $Docente["ti_id"]; ?>"
                                            data-iddocente="<?= $Docente['doc_id'];?>"
                                            data-pnombre="<?= $Docente['doc_primerNombre'];?>"
                                            data-snombre="<?= $Docente['doc_segundoNombre'];?>"
                                            data-papellido="<?= $Docente['doc_primerApellido'];?>"
                                            data-sapellido="<?= $Docente['doc_segundoApellido'];?>"
                                            data-correo="<?= $Docente['doc_correo']; ?>"
                                            data-ruc="<?= isset($Docente['doc_numIdentificación']) ? $Docente['doc_numIdentificación'] : "" ;?>"
                                            data-telef="<?= $Docente['doc_telefono'];?>"
                                            data-dir="<?= $Docente['doc_direccion'];?>"
                                            >
                                        Editar
                                    </button>
                                    <button class="eliminarEmpresaBtn btn btn-primary mr-2"
                                            data-id="<?= $Docente['doc_id'];?>">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                            
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        
        <!-- footer section -->
        <section class="container-fluid footer_section">
            <p>
                Copyright &copy; 2019 All Rights Reserved By
                <a href="https://html.design/">Free Html Templates</a>
            </p>
        </section>

        <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Modales -->

        <!-- Modal Agregar -->
        <div class="modal" tabindex="-1" id="modalAdd">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Nuevo Docente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../Controladores/docenteController.php" method="post">
                            <div class="row">
                                <div class="col-3">
                                    <input type="hidden" name="txt_id">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="txt_pApellido" placeholder="" name="txt_pApellido" required>
                                        <label for="txt_pApellido">Primer Apellido</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" name="txt_sApellido" placeholder="" id="txt_sApellido">
                                        <label for="txt_sApellido">Segundo Apellido</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="txt_pNombre" placeholder="" name="txt_pNombre" required>
                                        <label for="txt_pNombre">Primer Nombre</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" name="txt_sNombre" placeholder="" id="txt_sNombre" required>
                                        <label for="txt_sNombre">Segundo Nombre</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="txt_correo" placeholder="" name="txt_correo" required>
                                        <label for="txt_correo">Correo</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="txt_password1" placeholder="Mínimo 6 Dígitos" name="txt_password1" required>
                                        <label for="txt_password1">Contraseña</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="txt_password" placeholder="" name="txt_password" required>
                                        <label for="txt_password">Confirmar Contraseña</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="floatingSelect" name="txt_idti" aria-label="Floating label select example" required>
                                            <?php foreach($listaTipoIdentificacion as $tipoIden){ ?>
                                            <option value="<?= $tipoIden["ti_id"]; ?>">
                                                <?= $tipoIden["ti_texto"]; ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                        <label for="floatingSelect">Tipo de Identificación</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" name="txt_numIdentif" placeholder="" id="txt_numIdentif" required>
                                        <label for="txt_numIdentif">Identificación</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="number" name="txt_telefono" placeholder="" id="txt_telefono" required>
                                        <label for="txt_telefono">Telefono</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" name="txt_direccion" placeholder="" id="txt_direccion" required>
                                        <label for="txt_direccion">Direccion</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Cerrar</button>
                                    <button value="btnAgregar" type="submit" name="accion" class="btn btn-primary">Agregar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar -->
        <div class="modal" tabindex="-1" id="modalEdit">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Empresa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../Controladores/docenteController.php" method="post">
                            <div class="row">
                                <input type="hidden" name="txt_iddocente" id="txt_iddocente">
                                <div class="col-3">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="txt_pApellido" placeholder="" name="txt_pApellido" required>
                                        <label for="txt_pApellido">Primer Apellido</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" name="txt_sApellido" placeholder="" id="txt_sApellido">
                                        <label for="txt_sApellido">Segundo Apellido</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="txt_pNombre" placeholder="" name="txt_pNombre" required>
                                        <label for="txt_pNombre">Primer Nombre</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" name="txt_sNombre" placeholder="" id="txt_sNombre" required>
                                        <label for="txt_sNombre">Segundo Nombre</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="txt_correo" placeholder="" name="txt_correo" required>
                                        <label for="txt_correo">Correo</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="txt_password1_edit" placeholder="Mínimo 6 Dígitos" name="txt_password1">
                                        <label for="txt_password1">Contraseña</label>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control" id="txt_password_edit" placeholder="" name="txt_password">
                                        <label for="txt_password">Confirmar Contraseña</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <input type="hidden" id="idti_hidden" name="idti_hidden" value="0">
                                <div class="col-3">
                                    <div class="form-floating">
                                        <select class="form-select" id="floatingSelect" name="txt_idti" aria-label="Floating label select example">
                                            <?php foreach($listaTipoIdentificacion as $tipoIden){ ?>
                                                <option value="<?= $tipoIden["ti_id"]; ?>" selected>
                                                    <?= $tipoIden["ti_texto"]; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                        <label for="floatingSelect">Tipo de Identificación</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" name="txt_numIdentificacion" placeholder="" id="txt_numIdentif" required>
                                        <label for="txt_numIdentif">Identificación</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="number" name="txt_telefono" placeholder="" id="txt_telefono" required>
                                        <label for="txt_telefono">Telefono</label>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" name="txt_direccion" placeholder="" id="txt_direccion" required>
                                        <label for="txt_direccion">Direccion</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Cerrar</button>
                                    <button value="btnModificar" type="submit" name="accion" class="btn btn-primary">Editar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Eliminar -->
        <div class="modal " tabindex="-1" id="modalDelete">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Eliminar Empresa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../Controladores/docenteController.php" method="post">
                            <input type="hidden" name="txt_id" id="txt_id">
                            <p>¿Está Seguro de Eliminar el Registro?</p>
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Cerrar</button>
                                    <button value="btnEliminar" type="submit" name="accion" class="btn btn-primary">Eliminar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Cursos -->
        <div class="modal " tabindex="-1" id="modalAsignarCursos">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Eliminar Empresa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../Controladores/docenteController.php" method="post">
                            <input type="hidden" name="txt_id" id="txt_id">
                            <p>¿Está Seguro de Eliminar el Registro?</p>
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Cerrar</button>
                                    <button value="btnEliminar" type="submit" name="accion" class="btn btn-primary">Eliminar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modales -->

        <!-- Scripts -->
        <script>
            $(document).ready(function() {

                $('#txt_password1, #txt_password').keyup(function() {
                    var password1 = $('#txt_password1').val();
                    var password2 = $('#txt_password').val();

                    if(password1.length > 5){
                        if (password1 == password2) {
                            $('#txt_password1, #txt_password').removeClass('is-invalid').addClass('is-valid');
                        } else {
                            $('#txt_password1, #txt_password').removeClass('is-valid').addClass('is-invalid');
                        }
                    }else{
                        $('#txt_password1, #txt_password').removeClass('is-valid').addClass('is-invalid');
                    }
                });
                
                $('#txt_password1_edit, #txt_password_edit').keyup(function() {
                    var password1 = $('#txt_password1_edit').val();
                    var password2 = $('#txt_password_edit').val();

                    if(password1.length > 5){
                        if (password1 == password2) {
                            $('#txt_password1_edit, #txt_password_edit').removeClass('is-invalid').addClass('is-valid');
                        } else {
                            $('#txt_password1_edit, #txt_password_edit').removeClass('is-valid').addClass('is-invalid');
                        }
                    }else{
                        $('#txt_password1_edit, #txt_password_edit').removeClass('is-valid').addClass('is-invalid');
                    }
                });

                // Inicializar DataTable
                $('#example').DataTable();

                //Abrir el Modal para Agregar
                $('#agregarDocenteBtn').click(function(){
                    $('#modalAdd').modal('show');
                });

                //Abrir el Modal Para Editar
                $('.editarDocenteBtn').click(function(){

                    console.log("clic editar")
                    // Obtener los datos del botón
                    var idTipoIdentif = $(this).data('idti');
                    var idDocente = $(this).data('iddocente');
                    var pnombre = $(this).data('pnombre');
                    var snombre = $(this).data('snombre');
                    var papellido = $(this).data('papellido');
                    var sapellido = $(this).data('sapellido');
                    var correo = $(this).data('correo');
                    var identificacion = $(this).data('ruc');
                    var telef = $(this).data('telef');
                    var dir = $(this).data('dir');

                    // Asignar los datos al formulario del modal
                    $('#modalEdit #floatingSelect').val(idTipoIdentif);
                    $('#modalEdit #txt_iddocente').val(idDocente);
                    $('#modalEdit #txt_pNombre').val(pnombre);
                    $('#modalEdit #txt_sNombre').val(snombre);
                    $('#modalEdit #txt_pApellido').val(papellido);
                    $('#modalEdit #txt_sApellido').val(sapellido);
                    $('#modalEdit #txt_correo').val(correo);
                    $('#modalEdit #txt_telefono').val(telef);
                    $('#modalEdit #txt_direccion').val(dir);
                    $('#modalEdit #txt_numIdentif').val(identificacion);

                    //Activar el Modal
                    $('#modalEdit').modal('show');
                });

                //Abrir el Modal Para Eliminar
                $('.eliminarEmpresaBtn').click(function(){
                    var idDocente = $(this).data('id');
                    $('#modalDelete #txt_id').val(idDocente);
                    $('#modalDelete').modal('show');
                });

                $('.asignarCursoBtn').click(function(){
                    var idDocente = $(this).data('id');
                    $('#modalDelete #txt_id').val(idDocente);
                    $('#modalDelete').modal('show');
                });
            });
        </script>
        <!-- Scripts -->
    </body>
</html>