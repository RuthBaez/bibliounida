<?php echo $helpers->getHeader('Registrar nueva solicitud', 'Solicitantes/Registro') ?>

<div class="alert alert-danger alert-dismissible fade show mt-3 d-none" id="alert" role="alert">
    <span></span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>

<div class="row mt-4">
    <div id="registerForm">
        <div class="col-md-12 col-sm-12 mb-4">
            <div class="d-flex mx-1 border shadow rounded bg-white text-center">
                <div class="border-end flex-fill p-2 p-md-3 bg-primary shadow text-light rounded-start" id="barDatePersonal">
                    Datos Personales
                </div>
                <div class="border-end flex-fill p-2 p-md-3" id="barContact">
                    Información de Contacto
                </div>
                <div class="flex-fill p-2 p-md-3" id="barOcupacion">
                    Lugar de estudio o trabajo
                </div>
            </div>
        </div>

        <!-- Sección de Datos Personales -->
        <div class="col-md-12 col-sm-12" id="datePersonalForm">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row p-2 mb-0 mb-sm-3">
                        <div class="col-md-4 col-sm-12 mb-3">
                            <label class="form-label" for="carnet">Nro. Matrícula:</label>
                            <input class="form-control" type="text" id="carnet" name="carnet">
                            <div class="text-danger pt-1 d-none" id="valid-carnet">
                                La Matrícula solo permite valores numéricos.
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 mb-3">
                            <label class="form-label" for="names">Nombres:</label>
                            <input class="form-control" type="text" id="names" name="names">
                            <div class="text-danger pt-1 d-none" id="valid-names">
                                El texto solo puede contener letras, espacios y debe tener al menos 3 caracteres.
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-12 mb-3">
                            <label class="form-label" for="lastNames">Apellidos:</label>
                            <input class="form-control" type="text" id="lastNames" name="lastNames">
                            <div class="text-danger pt-1 d-none" id="valid-lastNames">
                                El texto solo puede contener letras, espacios y debe tener al menos 3 caracteres.
                            </div>
                        </div>
                    </div>

                    <div class="p-2 text-end">
                        <button class="btn btn-primary" type="button" id="add-data-personal">Siguiente</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Información de Contacto -->
        <div class="col-md-12 col-sm-12 d-none" id="contactForm">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row p-2 mb-0 mb-sm-3">
                        <div class="col-md-6 col-sm-12 mb-3">
                            <label class="form-label" for="phone">Teléfono:</label>
                            <input class="form-control" type="tel" id="phone" name="phone">
                            <div class="text-danger pt-1 d-none" id="valid-phone">
                                Debe ingresar valores numéricos.
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3">
                            <label class="form-label" for="email">Correo electrónico:</label>
                            <input class="form-control" type="email" id="email" name="email">
                            <div class="text-danger pt-1 d-none" id="valid-email">
                                El correo debe tener un formato válido.
                            </div>
                        </div>
                    </div>

                    <div class="p-2 text-end">
                        <button class="btn btn-link" type="button" id="back-data-contact">Volver</button>
                        <button class="btn btn-primary" type="button" id="add-data-contact">Siguiente</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sección de Ocupación -->
        <div class="col-md-12 col-sm-12 d-none" id="ocupacionForm">
            <div class="card shadow">
                <div class="card-body">
                    <div class="row p-2 mb-0 mb-sm-3">
                        <div class="col-md-6 col-sm-12 mb-3">
                            <label class="form-label" for="ocupacion">Ocupación:</label>
                            <select class="form-select" name="ocupacion" id="ocupacion">
                                <option value="Ninguno">Ninguno</option>
                                <option value="Trabajador">Trabajador</option>
                                <option value="Estudiante">Estudiante</option>
                            </select>
                        </div>
                        <div class="col-md-6 col-sm-12 mb-3">
                            <label class="form-label" for="nameOcupacion">Lugar de estudio o trabajo:</label>
                            <input class="form-control" type="text" id="nameOcupacion" name="nameOcupacion">
                            <div class="text-danger pt-1 d-none" id="valid-nameOcupacion">
                                Este campo es requerido.
                            </div>
                        </div>
                    </div>

                    <div class="p-2 text-end">
                        <button class="btn btn-link" type="button" id="back-data-ocupacion">Volver</button>
                        <button class="btn btn-primary" type="button" id="add-solicitante">Finalizar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Registro Terminado -->
        <div class="col-md-12 col-sm-12 d-none" id="registroTerminado">
            <div class="card shadow">
                <div class="card-body">
                    <div class="text-center p-4 my-3">
                        <span class="fas fa-check fs-2 text-white bg-success p-4 rounded-circle shadow"></span>
                        <h4 class="card-title fw-normal mt-4">Registro completado exitosamente</h4>
                        <a class="link link-primary" href="<?php echo $helpers->generateUrl('solicitante', 'register') ?>">Registrar nuevo</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const personalForm = document.getElementById("datePersonalForm");
    const contactForm = document.getElementById("contactForm");
    const ocupacionForm = document.getElementById("ocupacionForm");
    const registroTerminado = document.getElementById("registroTerminado");

    const btnAddDataPersonal = document.getElementById("add-data-personal");
    const btnAddDataContact = document.getElementById("add-data-contact");
    const btnBackDataContact = document.getElementById("back-data-contact");
    const btnBackDataOcupacion = document.getElementById("back-data-ocupacion");
    const btnAddSolicitante = document.getElementById("add-solicitante");

    btnAddDataPersonal.addEventListener("click", () => {
        personalForm.classList.add("d-none");
        contactForm.classList.remove("d-none");
    });

    btnAddDataContact.addEventListener("click", () => {
        contactForm.classList.add("d-none");
        ocupacionForm.classList.remove("d-none");
    });

    btnBackDataContact.addEventListener("click", () => {
        contactForm.classList.add("d-none");
        personalForm.classList.remove("d-none");
    });

    btnBackDataOcupacion.addEventListener("click", () => {
        ocupacionForm.classList.add("d-none");
        contactForm.classList.remove("d-none");
    });

    btnAddSolicitante.addEventListener("click", () => {
        ocupacionForm.classList.add("d-none");
        registroTerminado.classList.remove("d-none");
    });
});
</script>
