import LibroApi from "../../Book/api/libro-api.js";
import SolicitanteApi from "../../Solicitante/api/solicitante-api.js";
import PrestamoApi from "../api/prestamo-api.js";

export default class Model {
    constructor() {
        this.libroApi = new LibroApi();
        this.solicitanteApi = new SolicitanteApi();
        this.prestamoApi = new PrestamoApi();  // Se crea una sola instancia

        this.solicitantes = [];
        this.libros = [];
        this.isLoaded = false;  // Indicador para verificar si el modelo está cargado

        this.reload();
    }

    async reload() {
        try {
            const solicitantes = await this.solicitanteApi.getAll();
            const libros = await this.libroApi.getAll();
            
            this.solicitantes = [...solicitantes.data];
            this.libros = [...libros.data];

            // Marcar el modelo como cargado
            this.isLoaded = true;
        } catch (error) {
            console.error('Error al cargar los datos:', error);
            // Puedes mostrar un mensaje o manejar el error de manera más amigable
        }
    }

    async addPrestamo(prestamo) {
        try {
            const newPrestamo = {
                solicitante: prestamo.solicitante,
                libro: prestamo.libro,
                observaciones: prestamo.observaciones,
                fecha_devolucion: prestamo.fechaDevolucion,
            };

            const response = await this.prestamoApi.add(newPrestamo);
            return response;
        } catch (error) {
            console.error('Error al agregar el préstamo:', error);
            // Maneja el error apropiadamente (por ejemplo, mostrar una alerta)
        }
    }
}
