<?php
include '../Conexion/conexion.php';

$index = $pdo->prepare("SELECT * FROM empresa WHERE emp_estado = 1");
$index -> execute();
$listaEmpresas = $index->fetchAll(PDO::FETCH_ASSOC);


if(isset($_GET['guardado'])) {
    if ($_GET['guardado'] == "true") {
        echo '  <script>
                    alert("La inserción fue exitosa.");
                    window.history.replaceState({}, document.title, window.location.pathname);
                </script>';
    } else {
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
//print_r($listaEmpresas);
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
        <div class="hero_area">
            <!-- Menu -->
            <header class="header_section">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-lg custom_nav-container ">
                    <a class="navbar-brand" href="../index.php">
                        <span>
                        ACME Cia. Ltda.
                        </span>
                    </a>
                    <button class="navbar-toggler ml-auto" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                        aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <div class="d-flex mx-auto flex-column flex-lg-row align-items-center">
                        <ul class="navbar-nav  ">
                            <li class="nav-item">
                                <a class="nav-link" href="./empresaView.php">Empresas <span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./docenteView.php"> Docentes </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./cursoView.php"> Cursos </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./alumnoView.php">Alumnos</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./planifView.php">Planificacion</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="./evaluacionView.php">Evaluación</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Login</a>
                            </li>
                        </ul>
                        </div>
                    </div>
                    <form class="form-inline my-2 my-lg-0 ml-0 ml-lg-4 mb-3 mb-lg-0">
                        <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit"></button>
                    </form>
                    </nav>
                </div>
            </header>
            <!-- Menu -->

            <!-- slider section 
            <section class=" slider_section position-relative">
                <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <div class="slider_item-box layout_padding2">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="img-box">
                                            <div>
                                                <img src="images/slider-img.jpg" alt="" class="" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="detail-box">
                                            <div>
                                                <h1>
                                                    ACME <br>
                                                    Cia. <br>
                                                    <span>
                                                    Ltda
                                                    </span>
                                                </h1>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>-->
        </div>

        <!-- Tabla -->
        <div class="container pt-4">
            <div class="row">
                <div class="col-8"></div>
                <div class="col-4 d-flex justify-content-end service_container">
                    <div class="d-flex justify-content-center contact_section">
                        <button id="agregarEmpresaBtn">
                            Agregar Empresa
                        </button>
                    </div>
                </div>
            </div>

            <div class="row pt-4">
                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center">Empresa</th>
                            <th class="text-center">RUC</th>
                            <th class="text-center">Telefono</th>
                            <th class="text-center">Direccion</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <?php foreach($listaEmpresas as $empresa){ ?>
                        <tr>
                            <td class="text-center"><?= $empresa['emp_nombre']; ?></td>
                            <td class="text-center"><?= $empresa['emp_RUC']; ?></td>
                            <td class="text-center"><?= $empresa['emp_telefono']; ?></td>
                            <td class="text-center"><?= $empresa['emp_direccion']; ?></td>
                            <td> 
                                <div class="d-flex justify-content-center align-middle contact_crud">
                                    <button class="editarEmpresaBtn btn btn-primary mr-2"
                                            data-id="<?= $empresa['emp_id'];?>"
                                            data-nombre="<?= $empresa['emp_nombre'];?>"
                                            data-ruc="<?= $empresa['emp_RUC'];?>"
                                            data-telef="<?= $empresa['emp_telefono'];?>"
                                            data-dir="<?= $empresa['emp_direccion'];?>">
                                        Editar
                                    </button>
                                    <button class="eliminarEmpresaBtn btn btn-primary mr-2"
                                            data-id="<?= $empresa['emp_id'];?>">
                                        Eliminar
                                    </button>
                                </div>
                            </td>
                            
                        </tr>
                    <?php } ?>
                </table>
            </div>
        </div>
        <!-- Tabla -->

        <!-- footer section -->
        <section class="container-fluid footer_section">
            <p>
                Copyright &copy; 2019 All Rights Reserved By
                <a href="https://html.design/">Free Html Templates</a>
            </p>
        </section>
        <!-- footer section -->

        <script type="text/javascript" src="../js/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="../js/bootstrap.js"></script>

        <!-- Modales -->

        <!-- Modal Agregar -->
        <div class="modal" tabindex="-1" id="modalAdd">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Agregar Nueva Empresa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../Controladores/empresaController.php" method="post">
                            <div class="row">
                                <input type="hidden" name="txt_id">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="txt_nombre" placeholder="" name="txt_nombre" required>
                                        <label for="txt_nombre">Empresa</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="number" name="txt_RUC" placeholder="" id="txt_RUC" required>
                                        <label for="txt_RUC">RUC</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="number" name="txt_telef" placeholder="" id="txt_telef" required>
                                        <label for="txt_telef">Telefono</label>
                                        
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" name="txt_dir" placeholder="" id="txt_dir" required><br> 
                                        <label for="txt_dir">Dirección</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Cerrar</button>
                                    <button value="btnAgregar" type="submit" name="accion" class="btn btn-primary">Agregar</button>
                                </div>
                            </div>
                            
                            <!--
                            <button value="btnModificar" type="submit" name="accion">Modificar</button>
                            <button value="btnEliminar" type="submit" name="accion">Eliminar</button>
                            <button value="btnCancelar" type="submit" name="accion">Cancelar</button>
                            -->
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar -->
        <div class="modal" tabindex="-1" id="modalEdit">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Empresa</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../Controladores/empresaController.php" method="post">
                            <div class="row">
                                <input type="hidden" name="txt_id" id="txt_id">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="txt_nombre" placeholder="" name="txt_nombre" required>
                                        <label for="txt_nombre">Empresa</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="number" name="txt_RUC" placeholder="" id="txt_RUC" required>
                                        <label for="txt_RUC">RUC</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="number" name="txt_telef" placeholder="" id="txt_telef" required>
                                        <label for="txt_telef">Telefono</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" name="txt_dir" placeholder="" id="txt_dir" required><br> 
                                        <label for="txt_dir">Dirección</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-secondary mr-2" data-bs-dismiss="modal">Cerrar</button>
                                    <button value="btnModificar" type="submit" name="accion" class="btn btn-primary">Editar</button>
                                </div>
                            </div>
                            
                            <!--
                            <button value="btnModificar" type="submit" name="accion">Modificar</button>
                            <button value="btnEliminar" type="submit" name="accion">Eliminar</button>
                            <button value="btnCancelar" type="submit" name="accion">Cancelar</button>
                            -->
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
                        <form action="../Controladores/empresaController.php" method="post">
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
                // Inicializar DataTable
                $('#example').DataTable();

                //Abrir el Modal para Agregar
                $('#agregarEmpresaBtn').click(function(){
                    console.log("click aqui")
                    $('#modalAdd').modal('show');
                });

                //Abrir el Modal Para Editar
                $('.editarEmpresaBtn').click(function(){

                    // Obtener los datos del botón
                    var idEmpresa = $(this).data('id');
                    var nombreEmpresa = $(this).data('nombre');
                    var rucEmpresa = $(this).data('ruc');
                    var telefEmpresa = $(this).data('telef');
                    var dirEmpresa = $(this).data('dir');
                    console.log(idEmpresa);

                    // Asignar los datos al formulario del modal
                    $('#modalEdit #txt_id').val(idEmpresa);
                    $('#modalEdit #txt_nombre').val(nombreEmpresa);
                    $('#modalEdit #txt_RUC').val(rucEmpresa);
                    $('#modalEdit #txt_telef').val(telefEmpresa);
                    $('#modalEdit #txt_dir').val(dirEmpresa);

                    //Activar el Modal
                    $('#modalEdit').modal('show');
                });

                //Abrir el Modal Para Eliminar
                $('.eliminarEmpresaBtn').click(function(){
                    var idEmpresa = $(this).data('id');
                    $('#modalDelete #txt_id').val(idEmpresa);
                    $('#modalDelete').modal('show');
                });
            });
        </script>
        <!-- Scripts -->
    </body>
</html>