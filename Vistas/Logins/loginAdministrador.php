<?php
//include '../../Conexion/conexion.php';

if(isset($_GET['incorrecto'])) {
    if ($_GET['incorrecto'] == "true") {
        echo '  <script>
                    alert("Credenciales Incorrectas, Intente de nuevo.");
                    var url = window.location.href.split("?")[0]; // Obtiene la parte de la URL antes del "?"
                    window.history.replaceState({}, document.title, url);
                </script>';
    }
} 

?>

<!DOCTYPE html>
<html lang="es">
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
        <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />

        <!-- fonts style -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,700|Roboto:400,700&display=swap" rel="stylesheet">
        <!-- Custom styles for this template -->
        <link href="css/style.css" rel="stylesheet" />
        <!-- responsive style -->
        <link href="css/responsive.css" rel="stylesheet" />

        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.0/css/dataTables.bootstrap5.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <script defer src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script defer src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
        <script defer src="https://cdn.datatables.net/2.0.0/js/dataTables.js"></script>
        <script defer src="https://cdn.datatables.net/2.0.0/js/dataTables.bootstrap5.js"></script>
        <style>
            body {
                background-color: #007bff; /* Fondo azul para el área fuera del borde */
                /*color: #ffffff; Texto en blanco para contrastar */
            }
            .form-container {
                max-width: 400px;
                margin: auto; /* Centro horizontalmente */
                margin-top: 100px; /* Ajuste para centrar verticalmente */
                padding: 20px;
                border: 1px solid #007bff; /* Borde de 2px sólido con color primario */
                border-radius: 10px; /* Bordes redondeados */
            }
            .form-container {
                max-width: 400px;
                margin: auto; /* Centro horizontalmente */
                margin-top: 100px; /* Ajuste para centrar verticalmente */
                padding: 20px;
                border: 1px solid #007bff;
                border-radius: 10px; /* Bordes redondeados */
                background-color: #ffffff;
            }
        </style>
    </head>
    <body>
        <div class="hero_area">
            <header class="header_section">
                <div class="container-fluid">
                    <nav class="navbar navbar-expand-lg custom_nav-container ">
                        <a class="navbar-brand" href="#">
                            <span>
                            ACME Cia. Ltda.
                            </span>
                        </a>
                    </nav>
                </div>
            </header>
        </div>
        <div class="container pt-4">
            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-8 col-10 offset-lg-4 offset-md-3 offset-sm-2 offset-1 form-container">
                    <form action="./Controladores/loginController.php" method="post">
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Correo electrónico:</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" name="txt_user" aria-describedby="emailHelp">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Contraseña:</label>
                            <input type="password" class="form-control" name="txt_pass" id="exampleInputPassword1">
                        </div>
                        <button type="submit" name="accion" value="btnAdmin" class="btn btn-primary">Ingresar</button>
                    </form>
                </div>
            </div>
        </div>
        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
