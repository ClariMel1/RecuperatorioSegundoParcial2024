<?php

class EmpresaCable{
    private $planes;
    private $contratos;

    public function __construct() {
        $this->planes = [];
        $this->contratos = [];
    }

    public function getPlanes() {
        return $this->planes;
    }

    public function setPlanes($planes) {
        $this->planes = $planes;
    }

    public function getContratos() {
        return $this->contratos;
    }

    public function setContratos($contratos) {
        $this->contratos = $contratos;
    }

    public function recorrerPlanes() {
        $mostrar = " ";
        $plan = $this->getPlanes();
        for ($i = 0; $i < count($plan); $i++) {
            $mostrar = $mostrar . $plan[$i] . ":\n";
        }

        return $mostrar;
    }

    public function recorrerContratos() {
        $mostrar = " ";
        $contrato = $this->getContratos();
        for ($i = 0; $i < count($contrato); $i++) {
            $mostrar = $mostrar . $contrato[$i] . ":\n";
        }
        return $mostrar;
    }

    public function __toString() {
        $cadena = "Planes:\n";
        $cadena .= $this->recorrerPlanes();
        $cadena .= "Contratos:\n";
        $cadena .= $this->recorrerContratos();
        return $cadena;
    }

    /**
     * incorporarPlan($objPlan): que incorpora a la colección de planes un nuevo plan siempre y 
     * cuando no haya un plan con los mismos canales y los mismos MG (en caso de que el plan 
     * incluyera)
    */
    public function incorporarPlan($objPlan) {
        $numPlanes = count($this->planes);
        for ($i = 0; $i < $numPlanes; $i++) {
            if ($this->checkPlanIgual($objPlan, $this->planes[$i])) {
                return false;
            }
        }
        $this->planes[] = $objPlan;
        return true;
    }

    private function checkPlanIgual($plan1, $plan2) {
        $sonInguales = true;
        if ($plan1->getTipo() !== $plan2->getTipo()) {
            $sonInguales = false;
        }
    
        if ($plan1->getIncluyeMG() && $plan2->getIncluyeMG()) {
            if ($plan1->getMegabytes() !== $plan2->getMegabytes()) {
                $sonInguales = false;
            }
        } elseif ($plan1->getIncluyeMG() || $plan2->getIncluyeMG()) {
            $sonInguales = false;
        }
        return $sonInguales;
    }

    /**
     * incorporarContrato($objPlan,$objCliente,$fechaDesde,$fechaVenc,$esViaWeb)  : método 
     * que recibe por parámetro el plan, una referencia al cliente, la fecha de inicio y de vencimiento del
     * mismo y si se trata de un contrato realizado en la empresa o via web (si el valor del parámetro es
     * True se trata de un contrato realizado via web).
    */
    public function incorporarContrato($objPlan, $objCliente, $fechaDesde, $fechaVenc, $esViaWeb) {
        // Crear contrato y agregarlo a la colección

        if($esViaWeb == true){
            $porcentajeDescuento = 10;
            $costo = 0;
            $contrato = new ContratoViaWeb ($fechaDesde, $fechaVenc, $objPlan, $costo, $seRenueva, $objCliente, $porcentajeDescuento);
            $costoActualizado = $contrato->calcularImporte();
            $contrato->setCosto($costoActualizado);

        }else{
            $contrato = new ContratoPorEmpresa($fechaDesde, $fechaVenc,$objPlan,$costo,$seRenueva, $objCliente, $importeParcial);
        }

        $this->contratos[] = $contrato;
        return $contrato;
    }

    /**
     *  retornarImporteContratos($codigoPlan)  :   método que recibe por parámetro el código de un 
     * plan y retorna la suma de los importes de los contratos realizados usando ese plan.
     */

    public function retornarImporteContratos($codigoPlan) {
        $importeTotal = 0;
        $numContratos = count($this->contratos);
        for ($i = 0; $i < $numContratos; $i++) {
            if ($this->contratos[$i]->getPlan()->getCodigo() === $codigoPlan) {
                $importeTotal += $this->contratos[$i]->calcularImporte();
            }
        }
        return $importeTotal;
    }

    /**
     *   pagarContrato($objContrato)  : método recibe como parámetro un contrato, actualiza su estado 
     * y retorna el importe final que debe ser abonado por el cliente.
    */
    public function pagarContrato($objContrato) {
        $importeFinal = $objContrato->calcularImporte();
        $objContrato->actualizarEstadoContrato();
        return $importeFinal;
    }
}

?>