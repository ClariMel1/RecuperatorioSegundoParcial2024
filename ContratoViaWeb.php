<?php

class ContratoViaWeb extends Contrato {
    private $porcentajeDescuento;

    public function __construct($fechaInicio, $fechaVencimiento, $objPlan, $costo, $seRennueva, $objCliente, $porcentajeDescuento) {
        parent::__construct($fechaInicio, $fechaVencimiento, $objPlan, $costo, $seRennueva, $objCliente);
        $this->porcentajeDescuento = $porcentajeDescuento;
    }

    public function getPorcentajeDescuento() {
        return $this->porcentajeDescuento;
    }

    public function setPorcentajeDescuento($porcentajeDescuento) {
        $this->porcentajeDescuento = $porcentajeDescuento;
    }

    public function __toString(){
        $cadena = parent::__toString();
        $cadena .= "Porcentaje Descuento: ".$this->getPorcentajeDescuento()."\n";
        return $cadena;
    }

    public function calcularImporte(){
        $costoBase = parent::calcularImporte();

        $descuento = $costoBase* ($this->getPorcentajeDescuento() / 100);
        $importeFinal = $costoBase - $descuento;
        $this->setCosto($importeFinal);
        return $importeFinal;
    }
}

?>