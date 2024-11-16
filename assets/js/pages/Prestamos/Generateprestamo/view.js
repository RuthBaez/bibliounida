import AddLibro from "./components/add-libro.js";
import AddSolicitante from "./components/add-solicitante.js";
import SearchSolicitante from "./components/search-solicitante.js";
import SearchLibro from "./components/search-libro.js";
import GeneratePrestamo from "./components/generate-prestamo.js";
import Alert from "../../Solicitante/Register/components/alert.js";

export default class View {
    constructor() {
        this.model = null;

        // Elementos del formulario
        this.inputSolicitanteCedula = document.getElementById('solicitante_cedula');
        this.inputSolicitanteName = document.getElementById('solicitante_name');
        this.inputLibro = document.getElementById('libro');
        this.inputLibroTitle = document.getElementById('libro_title');
        this.btnGeneratePrestamo = document.getElementById('generate-prestamo');
        this.alert = new Alert('alert');

        // Componentes
        this.addSolicitante = new AddSolicitante();
        this.addLibro = new AddLibro();
        this.searchSolicitante = new SearchSolicitante();
        this.searchLibro = new SearchLibro();
        this.generatePrestamo = new GeneratePrestamo();

        // Manejo de eventos
        this.addSolicitante.onClick((solicitante) => this.setInputSolicitante(solicitante));
        this.addLibro.onClick((libro) => this.setInputLibro(libro));
        this.searchSolicitante.onKeyup((cedula) => this.searchSolicitanteByCedula(cedula));
        this.searchLibro.onKeyup((cota) => this.searchLibroByCota(cota));
        this.generatePrestamo.onClick((prestamo) => this.addPrestamo(prestamo));

        // Elementos para mostrar el estado del préstamo
        this.prestamoForm = document.getElementById('prestamoForm');
        this.prestamoChecked = document.getElementById('prestamoChecked');
        this.prestamoLink = document.getElementById('prestamoLink');
    }

    setModel(model) {
        this.model = model;

        // Verificar si el modelo está cargado antes de continuar
        if (this.model && this.model.isLoaded) {
            console.log('Modelo cargado correctamente');
        } else {
            console.error('El modelo no se ha cargado correctamente.');
            this.alert.show("Error al cargar los datos.");
        }
    }

    setInputSolicitante(solicitante) {
        if (solicitante) {
            this.inputSolicitanteCedula.value = solicitante.cedula;
            this.inputSolicitanteName.classList.remove('d-none');
            this.inputSolicitanteName.value = solicitante.name;
        } else {
            console.error('Solicitante no encontrado.');
        }
    }

    setInputLibro(libro) {
        if (libro) {
            this.inputLibro.value = libro.cota;
            this.inputLibroTitle.classList.remove('d-none');
            this.inputLibroTitle.value = libro.libro;
        } else {
            console.error('Libro no encontrado.');
        }
    }

    searchSolicitanteByCedula(cedula) {
        const solicitante = this.model.solicitantes.find(s => String(s.ced_sol) === cedula);

        if (solicitante) {
            this.inputSolicitanteName.classList.remove('d-none');
            this.inputSolicitanteName.value = `${solicitante.nom_sol} - ${solicitante.ape_sol}`;
        } else {
            this.inputSolicitanteName.classList.remove('d-none');
            this.inputSolicitanteName.value = 'No encontrado';
        }
    }

    searchLibroByCota(cota) {
        const libro = this.model.libros.find(l => l.cota === cota);

        if (libro) {
            this.inputLibroTitle.classList.remove('d-none');
            this.inputLibroTitle.value = `${libro.titulo} - ${libro.categoria.name}`;
        } else {
            this.inputLibroTitle.classList.remove('d-none');
            this.inputLibroTitle.value = 'No encontrado';
        }
    }

    async addPrestamo(prestamo) {
        // Verificar si el modelo está cargado antes de proceder
        if (!this.model || !this.model.isLoaded) {
            console.error('El modelo no está cargado.');
            this.alert.show("El modelo no está cargado. Intenta de nuevo.");
            return;
        }

        try {
            const { data } = await this.model.addPrestamo(prestamo);

            if (!data.status) {
                this.alert.show(data.message);
                return;
            }

            this.alert.hide();
            this.prestamoForm.classList.add('d-none');
            this.prestamoChecked.classList.remove('d-none');
            this.prestamoLink.href = `?controller=prestamos&action=details&id=${data.data.id_prestamo}`;
        } catch (error) {
            console.error('Error al agregar el préstamo:', error);
            this.alert.show("Ocurrió un error al agregar el préstamo.");
        }
    }
}
