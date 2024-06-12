<?php

include_once 'EmpresaCable.php';
include_once 'Canal.php';
include_once 'Cliente.php';
include_once 'Contrato.php';
include_once 'ContratoEmpresa.php';
include_once 'ContratoViaWeb.php';
include_once 'Plan.php';

// a) Crear una instancia de la clase EmpresaCable
$empresaCable = new EmpresaCable();

// b) Crear 3 instancias de la clase Canal
$canal1 = new Canal("noticias", 300, true, false);
$canal2 = new Canal("musical", 150, true , true );
$canal3 = new Canal("deportivo", 250, false, false);


// c) Crear 2 instancias de la clase Planes
$plan1 = new Plan(11, [$canal1, $canal2], 111);
$plan2 = new Plan(12, [$canal2, $canal3], 222);

// d) Crear una instancia de la clase Cliente
$cliente = new Cliente("abc", 23457899, "Belgrano 300");

// e) Crear 3 instancias de Contratos
$contratoEmpresa = new ContratoEmpresa("12-06-2023", "12-09-2024", $plan1, 1500,true,  $cliente, false);


// f) Invocar con cada instancia del inciso anterior al método calcularImporte y visualizar el resultado
echo "Importe Contrato Empresa: " . $contratoEmpresa->calcularImporte() . "\n";

// g) Invocar al método incorporaPlan con uno de los planes creados en c)
$empresaCable->incorporaPlan($plan1);

// h) Invocar nuevamente al método incorporaPlan de la empresa con el plan creado en c)
$empresaCable->incorporaPlan($plan1);

// i) Invocar al método incorporarContrato con los siguientes parámetros
$empresaCable->incorporarContrato($plan1, $cliente, "12-06-2023", "12-09-2024", false);

// k) Invocar al método pagarContrato que recibe como parámetro uno de los contratos creados en d)
$empresaCable->pagarContrato($contratoEmpresa);


// m) Invocar al método retornarImporteContratos con el código 111
echo "Importe Total Contratos con código 111: " . $empresaCable->retornarImporteContratos(111) . "\n";

?>





?>