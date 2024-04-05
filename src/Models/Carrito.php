<?php

namespace Models;
use Lib\BaseDatos;
use PDO;

class Carrito{
    private  $id;
    private  $nombre;
    private  $precio;
    private  $cantidad;


    public function __construct(){
        $this->db = new BaseDatos();
    }

    /**
     * Get the value of id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set the value of id
     */
    public function setId($id): self {
        $this->id = $id;
        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre() {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     */
    public function setNombre($nombre): self {
        $this->nombre = $nombre;
        return $this;
    }

    /**
     * Get the value of precio
     */
    public function getPrecio() {
        return $this->precio;
    }

    /**
     * Set the value of precio
     */
    public function setPrecio($precio): self {
        $this->precio = $precio;
        return $this;
    }

    /**
     * Get the value of cantidad
     */
    public function getCantidad() {
        return $this->cantidad;
    }

    /**
     * Set the value of cantidad
     */
    public function setCantidad($cantidad): self {
        $this->cantidad = $cantidad;
        return $this;
    }



}

?>