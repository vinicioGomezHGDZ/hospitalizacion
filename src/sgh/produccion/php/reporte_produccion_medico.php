<?php
/**
 * Created by PhpStorm.
 * User: vinicio.gomez
 * Date: 2019-02-14
 * Time: 15:44
 */
//header('Content-Type: application/json;charset=utf-8');

require_once '../../../../php/conexion.php';
require_once '../../../../vendor/autoload.php';
require_once 'classProduccion.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Html;


try {

    $id_profesional = $_GET['id_profesional'];
    $fecha_desde = $_GET['fecha_desde'];
    $fecha_hasta = $_GET['fecha_hasta'];
    $data = [
        'id_profesional' => $id_profesional,
        'fecha_desde' => $fecha_desde,
        'fecha_hasta' => $fecha_hasta
    ];
    $evoluciones = getAllEvolucion($data);

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'HOSPITAL GENERAL DR. GUSTAVO DOMINGUEZ ZAMBRANO');
    $sheet->setCellValue('A2', 'HOSPITALIZACIÓN');
    $sheet->setCellValue('A3', 'REPORTE DE EVOLUCIONES');
    $sheet->setCellValue('A4', 'MÉDICO:');
    $sheet->setCellValue('A5', 'Fecha desde: ' . $fecha_desde . ' hasta ' . $fecha_hasta)->mergeCells('A5:G5');


    $encabezado = ['NRO','ASUNTO','FECHA','HORA','NOTA EVOLUCIÓN','PRESCRIPCIÓN'];
    $spreadsheet->getActiveSheet()->fromArray($encabezado,null,'A7');

    $spreadsheet->getActiveSheet()->fromArray($evoluciones,null,'A8');



    //$writer = new Xlsx($spreadsheet);
    //$writer->save("reporte_evoluciones${id_profesional}_${fecha_desde}-${fecha_hasta}.xlsx");

    $writer = new Html($spreadsheet);
    $writer->save("php://output");




} catch (Exception $e) {
    echo json_encode(array('Estado' => 3, 'Mensaje' => 'Error: ' . $e->getMessage()));
}

