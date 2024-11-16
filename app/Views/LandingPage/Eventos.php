<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <meta name="description" content="Biblioteca Publica Agustin Codazzi de Maracay" />
        <meta name="keywords" content="Biblioteca, Maracay, Libros, Prestamo, Eventos">
        <meta name="author" content="Biblioteca Publica Agustin Codazzi de Maracay" />

        <!-- Css Libs -->
        <?php include_once './app/Views/LandingPage/partials/Head.php'; ?>

        <style>
            #mainNav {
                box-shadow: none;
                background-color: #161616 !important;
            }
        </style>
    </head>
    <body id="page-top">
        <!-- Navigation-->
        <?php include_once './app/Views/LandingPage/partials/Navigation.php'; ?>

        <!-- Events-->
        <section class="page-section" id="events">
            <div class="container px-4 px-lg-5">
                <h2 class="text-center mt-0">Próximos eventossss</h2>
                <hr class="divider divider-dark" />
                <div class="gx-4 gx-lg-5">
                    <div class="row mt-4">
                        <div class="col-md-6 col-sm-12">
                            <div class="card shadow mt-3">
                                <div class="card-body">
                                    <div id="calendar"></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-12">
                            <div class="card shadow mb-3 d-none mt-2" id="not-event">
                                <div class="card-body text-center">
                                    <h6 class="card-title">No hay ningun evento en esta fecha</h6>
                                    <button class="btn btn-link p-0" id="view-defaul-events">Ver los eventos disponibles</button>
                                </div>
                            </div>

                            <div class="card shadow mb-3 d-none mt-2" id="not-event-month">
                                <div class="card-body text-center">
                                    <h6 class="card-title">No hay ningún evento en este mes</h6>
                                </div>
                            </div>

                            <?php foreach($events_pendientes as $event): ?>
                                <div class="card shadow defaul-events mb-3" id="<?php echo $event->id_event ?>">
                                    <div class="card-body">
                                        <div class="row px-2">
                                            <div class="col-md-2 fw-bold">
                                                <h3 class="mb-0"><?php echo $helpers->getCustomDate($event->date_realized_event, 'd') ?></h3>
                                            </div>
                                            <div class="col-md-3">
                                                <p class="mb-0 text-secondary">Fecha:</p>
                                                <h6 class="mt-0 fw-bold"><?php echo $helpers->getCustomDate($event->date_realized_event, 'Y-m') ?></h6>

                                                <p class="mb-0 text-secondary">Hora:</p>
                                                <h6 class="mt-0 fw-bold"><?php echo $helpers->getCustomDate($event->time, 'h:s') ?></h6>
                                            </div>
                                            <div class="col">
                                                <h5 class="fw-bold"><?php echo $event->title_event ?></h5>
                                                <p><?php echo $event->place_event ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <?php include_once './app/Views/LandingPage/partials/Footer.php'; ?>

        <!-- Scripts -->
        <?php include_once './app/Views/LandingPage/partials/Scripts.php'; ?>

        <!-- AXIOS -->
        <script src="assets/libs/axios/axios.min.js"></script>

        <!-- Fullcalendar -->
        <script src="assets/libs/fullcalendar/index.global.min.js"></script>

        <script type="module">
            import ViewCalendar from './assets/js/pages/Participantes/Index/view.js'
            new ViewCalendar()
        </script>
    </body>
</html>
