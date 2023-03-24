<?php echo $helpers->getHeader('Préstamo circulante', 'Prestamo/Inicio') ?>

<?php echo $helpers->getMessage($_GET) ?>

<div class="card shadow mt-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Número de carnet</th>
                        <th>Fecha de Entrega</th>
                        <th>Fecha de Devolucion</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($prestamos as $prestamo): ?>
                        <tr>
                            <th><?php echo $prestamo->numero_carnet2->id_sol ?></th>
                            <td><?php echo $prestamo->fecha_entrega ?></td>
                            <td><?php echo $prestamo->fecha_devolucion ?></td>
                            <td>
                                <?php echo $helpers->generateStatePrestamo($prestamo->pendiente) ?>
                            </td>
                            <td>
                                <a class="btn btn-primary" href="<?php echo $helpers->generateUrl('prestamos', 'details', [ 'id' => $prestamo->id_p ]) ?>">
                                    <span class="fas fa-eye"></span>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>