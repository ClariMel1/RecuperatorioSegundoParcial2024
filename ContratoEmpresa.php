<?php

class ContratoPorEmpresa extends Contrato {
    private $importeParcial;

    public function __construct($fechaInicio, $fechaVencimiento, $objPlan, $costo, $seRennueva, $objCliente, $importeParcial) {
        parent::__construct($fechaInicio, $fechaVencimiento, $objPlan, $costo, $seRennueva, $objCliente);
        $this->importeParcial = $importeParcial;
    }

    public function getImporteParcial() {
        return $this->importeParcial;
    }

    public function setImporteParcial($importeParcial) {
        $this->importeParcial = $importeParcial;
    }

    public function __toString(){
        $cadena = parent::__toString(); 
        $cadena .= "Importe Parcial: ".$this->getImporteParcial()."\n";

        return $cadena;
    }

    /**
     * Implementar y  redefinir  el método  calcularImporte  ()    que retorna el importe final correspondiente al
     *importe del contrato
    */

    public function calcularImporte() {
        $costoBase = parent::calcularImporte();
        $importeFinal = $costoBase + $this->getImporteParcial();
        return $importeFinal;
    }
}


?>