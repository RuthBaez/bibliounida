<?php echo $helpers->getHeader('Servicio de préstamo circulante', 'Préstamos/Registro') ?>

<?php echo $helpers->getMessage($_GET) ?>

<div class="alert alert-danger alert-dismissible fade show mt-3 d-none" id="alert" role="alert">
    <span></span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<div class="card shadow mt-4" id="prestamoForm">
    <div class="card-body">
        <div class="container mt-2">
            <div class="row mb-3">

                <label class="form-label" for="solicitante_cedula">Solicitante:</label>

                <div class="col-md-4 col-4">
                    <input class="form-control" type="text" id="solicitante_cedula" name="solicitante_cedula">
                </div>
                <div class="col-md-6 col-5">
                    <input class="form-control d-none" type="text" id="solicitante_name" readonly>
                </div>
                <!-- <div class="col-md-2 col-2">
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#solicitantes-modal">
                        <span class="fas fa-user-plus"></span>
                    </button>
                </div> -->
            </div>

            <div class="row mb-3">

                <label class="form-label" for="libro">Libro:</label>

                <div class="col-md-4 col-4">
                    <input class="form-control" type="text" id="libro" name="libro">
                </div>
                <div class="col-md-6 col-5">
                    <input class="form-control d-none" type="text" id="libro_title" readonly>
                </div>
                <!-- <div class="col-md-2 col-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#libros-modal">
                        <span class="fas fa-book"></span>
                    </button>
                </div> -->
            </div>

            <div class="row mb-3">
                <div class="col-md-6 col-12 mb-3 mb-md-0">
                    <label class="form-label" for="fecha_entrega">Fecha de entrega:</label>
                    <input class="form-control" type="date" id="fecha_entrega" name="fecha_entrega" min="<?php echo $helpers->getCurrentDate() ?>" max="<?php echo $helpers->getCurrentDate() ?>" value="<?php echo $helpers->getCurrentDate() ?>" readonly>
                </div>
                <div class="col-md-6 col-12">
                    <label class="form-label" for="fecha_devolucion">Fecha de devolución:</label>
                    <input class="form-control" type="date" id="fecha_devolucion" name="fecha_devolucion" min="<?php echo $helpers->getCurrentDate(1) ?>" value="<?php echo $helpers->getCurrentDate(1) ?>">
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-12">
                    <label class="form-label" for="observaciones">Observaciones:</label>
                    <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-12 text-end">
                    <a class="btn btn-link" href="<?php echo $helpers->generateUrl('prestamos', 'index') ?>">Volver</a>
                    <button class="btn btn-primary" type="button" id="generate-prestamo">Generar Préstamo</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Solicitantes -->
<!-- <div class="modal modal-lg fade" id="solicitantes-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Solicitantes</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cédula</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($solicitantes as $solicitante): ?>
                        <tr>
                            <td><?php echo $solicitante->carnet ?></td>
                            <td><?php echo $solicitante->ced_sol ?></td>
                            <td><?php echo $solicitante->nom_sol ?></td>
                            <td><?php echo $solicitante->ape_sol ?></td>
                            <td>
                                <button class="btn btn-success adds-solicitante" type="button" data-bs-dismiss="modal" data-cedula="<?php echo $solicitante->ced_sol ?>" data-name="<?php echo "{$solicitante->nom_sol} - {$solicitante->ape_sol}" ?>">
                                    <span class="fas fa-check"></span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div> -->

<!-- Modal Libros -->
<!-- <div class="modal modal-lg fade" id="libros-modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Libros</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cota</th>
                        <th>Título</th>
                        <th>Categoría</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($libros as $libro): ?>
                        <tr>
                            <td><?php echo $libro->id_libro ?></td>
                            <td><?php echo $libro->cota ?></td>
                            <td><?php echo $libro->titulo ?></td>
                            <td><?php echo $libro->categoria->name ?></td>
                            <td>
                                <button class="btn btn-success adds-libro" type="button" data-bs-dismiss="modal" data-cota="<?php echo $libro->cota ?>" data-libro="<?php echo "{$libro->titulo} - {$libro->categoria->name}" ?>">
                                    <span class="fas fa-check"></span>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div> -->

<div class="card shadow d-none" id="prestamoChecked">
    <div class="card-body">
        <div class="text-center p-4 my-3">
            <span class="fas fa-check fs-2 text-white bg-success p-4 rounded-circle shadow"></span>
            <h4 class="card-title fw-normal mt-4">Préstamo Registrado Exitosamente</h4>
            <a class="link link-primary" href="<?php echo $helpers->generateUrl('prestamos', 'generateprestamo') ?>">Generar nuevo préstamo</a>
            <span>|</span>
            <a class="link link-primary" id="prestamoLink" href="">Visualizar nuevo registro</a>
        </div>
    </div>
</div>