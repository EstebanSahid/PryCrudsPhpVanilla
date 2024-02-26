<?php
include '../Conexion/conexion.php';

if (isset($_GET["exec"]) and $_GET["exec"] == "mostrarDocente") {
    $sql = $pdo->prepare("SELECT 
	                        cxd.cxd_fechaCreacion,
	                        CONCAT(d.doc_primerApellido,' ', d.doc_segundoApellido, ' ', d.doc_primerNombre) as docente FROM cursoxdocente cxd
                        INNER JOIN docente d ON d.doc_id = cxd.doc_id
                        WHERE cxd.cu_id = :val1");
    $sql->bindParam(':val1', $_POST['id_curso']);
    $sql -> execute();
    $listado = $sql->fetchAll(PDO::FETCH_ASSOC);

    ?> 
    <ol class="list-group list-group-numbered">
        <?php foreach($listado as $lista){ ?>
            <li class="list-group-item d-flex justify-content-between align-items-start">
                <div class="ms-2 me-auto">
                    <div class="fw-bold"><?= $lista["docente"] ?></div>
                    <?= $lista["cxd_fechaCreacion"] ?>
                </div>
            </li>
        <?php } ?> 
    </ol>
    <?php
}

if (isset($_GET["exec"]) and $_GET["exec"] == "mostrarCurso") {
    $sql = $pdo->prepare("SELECT
                            cxd.cxd_fechaCreacion,
                            c.cu_nombre
                        FROM cursoxdocente cxd
                        INNER JOIN cursos c ON c.cu_id = cxd.cu_id
                        WHERE cxd.doc_id = :val1");
    $sql->bindParam(':val1', $_POST['id_doc']);
    $sql -> execute();
    $listado = $sql->fetchAll(PDO::FETCH_ASSOC);

    ?> 
    <ol class="list-group list-group-numbered">
        <?php 
        if(!empty($listado)){
            foreach($listado as $lista){ ?>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold"><?= $lista["cu_nombre"] ?></div>
                        <?= $lista["cxd_fechaCreacion"] ?>
                    </div>
                </li>
            <?php } 
        }else{ ?>
            <li class="d-flex justify-content-between align-items-start text-center">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">Sin Registros</div>
                    Por favor Asignar un Curso al Docente
                </div>
            </li>
        <?php } ?> 
    </ol>
    <?php
}

if (isset($_GET["exec"]) and $_GET["exec"] == "addDocente") {
    $select = $pdo->prepare("SELECT 
                                    CONCAT(d.doc_primerApellido,' ',d.doc_segundoApellido, ' ', d.doc_primerNombre) as docente,
                                    d.doc_id
                                FROM docente d
                                WHERE d.doc_id NOT IN (
                                    SELECT cxd.doc_id
                                    FROM cursoxdocente cxd
                                    WHERE cxd.cu_id = :val1
                                );");
    $select -> bindParam(':val1', $_POST['id']);
    $select -> execute();
    $indexSelect = $select->fetchAll(PDO::FETCH_ASSOC);
    ?> 
    <div class="form-floating">
        <select class="form-select" id="floatingSelect" name="txt_idti" aria-label="Floating label select example" required>
            <?php foreach($indexSelect as $ind){ ?>
            <option value="<?= $ind["doc_id"]; ?>">
                <?= $ind["docente"]; ?>
            </option>
            <?php } ?>
        </select>
        <label for="floatingSelect">Docente</label>
    </div>
    <?php
}

if (isset($_GET["exec"]) and $_GET["exec"] == "addCursos") {
    $select = $pdo->prepare("SELECT 
                                c.cu_nombre,
                                c.cu_id
                            FROM cursos c
                            WHERE c.cu_id NOT IN (
                                SELECT cxd.cu_id
                                FROM cursoxdocente cxd
                                WHERE cxd.doc_id = :val1
                            );");
    $select -> bindParam(':val1', $_POST['id']);
    $select -> execute();
    $indexSelect = $select->fetchAll(PDO::FETCH_ASSOC);
    ?> 
    <div class="form-floating">
        <select class="form-select" id="floatingSelect" name="txt_idti" aria-label="Floating label select example" required>
            <?php foreach($indexSelect as $ind){ ?>
            <option value="<?= $ind["cu_id"]; ?>">
                <?= $ind["cu_nombre"]; ?>
            </option>
            <?php } ?>
        </select>
        <label for="floatingSelect">Docente</label>
    </div>
    <?php
}

$accion = (isset($_POST['accion'])) ? $_POST['accion'] : "";

switch($accion){
    case "btnAgregarDocente":
        var_dump($_POST);
        break;
    case "btnAgregarCurso":
        var_dump($_POST);
        break;
}