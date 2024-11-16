<?php

namespace App\Models;

use App\Core\baseModel;

class Prestamo extends baseModel
{
    private $id_p;
    private $numero_carnet2;
    private $id_libro2;
    private $fecha_entrega;
    private $fecha_devolucion;
    private $observaciones_p;
    private $pendiente;
    private $calificacion;
    protected $table = 'prestamo';

    public function __construct(array $prestamo = null)
    {
        if (is_array($prestamo)) {
            $this->id_p = $prestamo['id_p'];
            $this->numero_carnet2 = $prestamo['numero_carnet2'];
            $this->id_libro2 = $prestamo['id_libro2'];
            $this->fecha_entrega = $prestamo['fecha_entrega'];
            $this->fecha_devolucion = $prestamo['fecha_devolucion'];
            $this->observaciones_p = $prestamo['observaciones_p'];
            $this->pendiente = $prestamo['pendiente'];
            $this->calificacion = $prestamo['calificacion'];
        }

        parent::__construct($this->table);
    }

    public function save()
    {
        // Inserta un nuevo registro en la base de datos
        $query = "INSERT INTO {$this->table} (numero_carnet2, id_libro2, fecha_entrega, fecha_devolucion, observaciones_p, pendiente, calificacion) 
                  VALUES (:numero_carnet2, :id_libro2, :fecha_entrega, :fecha_devolucion, :observaciones_p, :pendiente, :calificacion)";

        $stmt = $this->database->prepare($query);

        // Asocia los parámetros con los valores correspondientes
        $stmt->bindParam(':numero_carnet2', $this->numero_carnet2);
        $stmt->bindParam(':id_libro2', $this->id_libro2);
        $stmt->bindParam(':fecha_entrega', $this->fecha_entrega);
        $stmt->bindParam(':fecha_devolucion', $this->fecha_devolucion);
        $stmt->bindParam(':observaciones_p', $this->observaciones_p);
        $stmt->bindParam(':pendiente', $this->pendiente);
        $stmt->bindParam(':calificacion', $this->calificacion);

        // Ejecuta la consulta
        return $stmt->execute();
    }

    public function update()
    {
        // Actualiza un registro existente
        $query = "UPDATE {$this->table} 
                  SET numero_carnet2 = :numero_carnet2, 
                      id_libro2 = :id_libro2, 
                      fecha_entrega = :fecha_entrega, 
                      fecha_devolucion = :fecha_devolucion, 
                      observaciones_p = :observaciones_p, 
                      pendiente = :pendiente, 
                      calificacion = :calificacion  
                  WHERE id_p = :id_p";

        $stmt = $this->database->prepare($query);

        // Asocia los parámetros con los valores correspondientes
        $stmt->bindParam(':id_p', $this->id_p);
        $stmt->bindParam(':numero_carnet2', $this->numero_carnet2);
        $stmt->bindParam(':id_libro2', $this->id_libro2);
        $stmt->bindParam(':fecha_entrega', $this->fecha_entrega);
        $stmt->bindParam(':fecha_devolucion', $this->fecha_devolucion);
        $stmt->bindParam(':observaciones_p', $this->observaciones_p);
        $stmt->bindParam(':pendiente', $this->pendiente);
        $stmt->bindParam(':calificacion', $this->calificacion);

        // Ejecuta la consulta
        return $stmt->execute();
    }
}
