<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ReportesDeptoInt extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_reportes');
		$this -> load -> model('Modelo_departamentos');
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {
           
			$data['titulo'] = 'Reportes';
			$data['infodepto'] = $this -> Modelo_departamentos-> getInfoDepartamento($this->session->userdata('id_area'));
			$this->load->view('plantilla/header', $data);
			$this->load->view('deptos/internos/reportes');
			$this->load->view('plantilla/footer');	 

		}
		else {
			$this->session->set_flashdata('invalido', 'La sesión ha expirado o no tienes acceso a este recurso');
			redirect('Login');
		} 
	}

	 function cellColor($cells,$color){
        global $objPHPExcel;

        $objPHPExcel->getActiveSheet()->getStyle($cells)->getFill()->applyFromArray(array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'startcolor' => array(
               'rgb' => $color
           )
        ));
    }

   function getDiasHabiles($fechainicio, $fechafin, $diasferiados = array()) {
        // Convirtiendo en timestamp las fechas
        $fechainicio = strtotime($fechainicio);
        $fechafin = strtotime($fechafin);

        // Incremento en 1 dia
        $diainc = 24*60*60;

        // Arreglo de dias habiles, inicianlizacion
        $diashabiles = array();

        // Se recorre desde la fecha de inicio a la fecha fin, incrementando en 1 dia
        for ($midia = $fechainicio; $midia <= $fechafin; $midia += $diainc) {
                // Si el dia indicado, no es sabado o domingo es habil
                if (!in_array(date('N', $midia), array(6,7))) { // DOC: http://www.php.net/manual/es/function.date.php
                        // Si no es un dia feriado entonces es habil
                  if (!in_array(date('Y-m-d', $midia), $diasferiados)) {
                    array_push($diashabiles, date('Y-m-d', $midia));
                }
            }
        }

        return $diashabiles;
    }

public function reporteAllPorDeptos()
{
   $this->load->library('Excel');
   $objPHPExcel = new PHPExcel();

   date_default_timezone_set('America/Mexico_City');
   $time = time();
   $hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

   $inicio = $this->input->post('date_inicio');
   $final = $this->input->post('date_final');
   $id_area= $this->session->userdata('id_area');

        // DIBUJANDO EL LOGO DEL CSEIIO
   $objDrawing = new PHPExcel_Worksheet_Drawing();
   $objDrawing->setName('Logo');
   $objDrawing->setDescription('Logo');
   $objDrawing->setPath('./assets/img/apple-touch-icon.png');

   $objDrawing->setCoordinates('A1');
   $objDrawing->setHeight(100);
   $objDrawing->setWidth(100);
   $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


        // DIBUJANDO EL LOGO DEL GOBIERNO DEL ESTADO
   $objDrawingGob = new PHPExcel_Worksheet_Drawing();
   $objDrawingGob->setName('LogoGob');
   $objDrawingGob->setDescription('Logo');
   $objDrawingGob->setPath('./assets/img/GobOaxacaLogo.png');

   $objDrawingGob->setCoordinates('F1');
   $objDrawingGob->setHeight(1000);
   $objDrawingGob->setWidth(306);
   $objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

   $objPHPExcel->getProperties()->setCreator("CSEIIO")
   ->setLastModifiedBy("CSEIIO")
   ->setTitle("Reporte del Total de Oficios Recepcionados-Modalidad Interna")
   ->setSubject("Reporte de Departamentos")
   ->setDescription("Reporte que contiene el total de oficios recepcionados por el Departamento, Modalidad Interna.")
   ->setKeywords("cseiio reporte oficios depto internos")
   ->setCategory("Reporte");

   $tituloReporte = "Reporte de oficios recepcionados, comprendido del periodo:  ".$inicio."  al ".$final."";
   $tituloCseiio = "Colegio Superior Para la Educación Integral e Intercultural de Oaxaca";
    $titulosColumnas = array('NÚMERO DE OFICIO', 'FECHA DE EMISIÓN', 'HORA DE EMISIÓN', 'ASUNTO', 'EMISOR', 'CARGO','FECHA DE TERMINO','ESTATUS','DIRECCIÓN DE DESTINO','OBSERVACIONES','N° DE OFICIO DE RESPUESTA', 'PERSONA QUE CONTESTO EL OFICIO','CÓDIGO ARCHIVISTICO','FECHA DE RESPUESTA','HORA DE RESPUESTA');

        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
   $objPHPExcel->setActiveSheetIndex(0)
   ->mergeCells('A1:O1');
// Se agregan los titulos del reporte
   $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('C3',  $tituloReporte) // Titulo del Reporte
    ->setCellValue('C4',  $tituloCseiio) // Titulo del Colegio
    ->setCellValue('A6',  $titulosColumnas[0])  //Titulo de las columnas
    ->setCellValue('B6',  $titulosColumnas[1])
    ->setCellValue('C6',  $titulosColumnas[2])
    ->setCellValue('D6',  $titulosColumnas[3])
    ->setCellValue('E6',  $titulosColumnas[4])
    ->setCellValue('F6',  $titulosColumnas[5])
    ->setCellValue('G6',  $titulosColumnas[6])
    ->setCellValue('H6',  $titulosColumnas[7])
    ->setCellValue('I6',  $titulosColumnas[8])
    ->setCellValue('J6',  $titulosColumnas[9])
    ->setCellValue('K6',  $titulosColumnas[10])
    ->setCellValue('L6',  $titulosColumnas[11])
    ->setCellValue('M6',  $titulosColumnas[12])
    ->setCellValue('N6',  $titulosColumnas[13])
    ->setCellValue('O6',  $titulosColumnas[14]);


    $objPHPExcel->getActiveSheet()->getStyle('A6:O6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');

        //ENTRADAS
      // $dato2 = $this->modelo_reportes->entradas($inicio,$final);
       // $dato = $this->modelo_reportes-> conteoAsistencias($inicio,$final);

    $oficios = $this->Modelo_reportes->getBuzonDeOficiosEntrantesDepto($id_area, $inicio, $final);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {
      if ($fila->status == 'Contestado' OR $fila->status == 'Fuera de Tiempo') {

        $infor_contestados = $this->Modelo_reportes->getAllOficiosDeptosIntByID($fila->id_recepcion_int);

        foreach ($infor_contestados  as $key) {

         $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('A'.$i, $key->num_oficio)
         ->setCellValue('B'.$i, $key->fecha_emision)
         ->setCellValue('C'.$i, $key->hora_emision)
         ->setCellValue('D'.$i, $key->asunto)
         ->setCellValue('E'.$i, $key->emisorexterno)
         ->setCellValue('F'.$i, $key->cargoexterno)
         ->setCellValue('G'.$i, $key->fecha_termino)
         ->setCellValue('H'.$i, $key->status)
         ->setCellValue('I'.$i, $key->nombre_area)
         ->setCellValue('J'.$i, $key->observaciones)
         ->setCellValue('K'.$i, $key->num_oficio_respuesta)
         ->setCellValue('L'.$i, $key->emisor)
         ->setCellValue('M'.$i, $key->codigo)
         ->setCellValue('N'.$i, $key->fecha_respuesta)
         ->setCellValue('O'.$i, $key->hora_respuesta);
       }
     }
     else
     {
       $objPHPExcel->setActiveSheetIndex(0)
       ->setCellValue('A'.$i, $fila->num_oficio)
       ->setCellValue('B'.$i, $fila->fecha_emision)
       ->setCellValue('C'.$i, $fila->hora_emision)
       ->setCellValue('D'.$i, $fila->asunto)
       ->setCellValue('E'.$i, $fila->emisor)
       ->setCellValue('F'.$i, $fila->cargo)
       ->setCellValue('G'.$i, $fila->fecha_termino)
       ->setCellValue('H'.$i, $fila->status)
       ->setCellValue('I'.$i, $fila->nombre_area)
       ->setCellValue('J'.$i, $fila->observaciones);
     }
     $i++;

   }

           // Se asigna el nombre a la hoja
 $objPHPExcel->getActiveSheet()->setTitle('Oficios Recepcionados');

 $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
 header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 header('Content-Disposition: attachment;filename="Reporte_de_oficios_RECEPCIONADOS:'.$hoy.'.xlsx"');
 header('Cache-Control: max-age=0');

 $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
 $objWriter->save('php://output');
 exit;

}


 public function reporteEmitidosDeptoInt()
{
   $this->load->library('Excel');
   $objPHPExcel = new PHPExcel();

   date_default_timezone_set('America/Mexico_City');
   $time = time();
   $hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

   $inicio = $this->input->post('date_inicio');
   $final = $this->input->post('date_final');
   $nombre = $this->session->userdata('nombre');

        // DIBUJANDO EL LOGO DEL CSEIIO
   $objDrawing = new PHPExcel_Worksheet_Drawing();
   $objDrawing->setName('Logo');
   $objDrawing->setDescription('Logo');
   $objDrawing->setPath('./assets/img/apple-touch-icon.png');

   $objDrawing->setCoordinates('A1');
   $objDrawing->setHeight(100);
   $objDrawing->setWidth(100);
   $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


        // DIBUJANDO EL LOGO DEL GOBIERNO DEL ESTADO
   $objDrawingGob = new PHPExcel_Worksheet_Drawing();
   $objDrawingGob->setName('LogoGob');
   $objDrawingGob->setDescription('Logo');
   $objDrawingGob->setPath('./assets/img/GobOaxacaLogo.png');

   $objDrawingGob->setCoordinates('F1');
   $objDrawingGob->setHeight(1000);
   $objDrawingGob->setWidth(306);
   $objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

   $objPHPExcel->getProperties()->setCreator("CSEIIO")
   ->setLastModifiedBy("CSEIIO")
   ->setTitle("Reporte del Total de Oficios Emitidos-Modalidad Interna")
   ->setSubject("Reporte de Departamento")
   ->setDescription("Reporte que contiene el total de oficios emitidos por el Departamento, Modalidad Interna.")
   ->setKeywords("cseiio reporte oficios depto internos")
   ->setCategory("Reporte");

   $tituloReporte = "Reporte de oficios emitidos, comprendido del periodo:  ".$inicio."  al ".$final."";
   $tituloCseiio = "Colegio Superior Para la Educación Integral e Intercultural de Oaxaca";
   $titulosColumnas = array('NÚMERO DE OFICIO', 'FECHA DE EMISIÓN', 'HORA DE EMISIÓN', 'ASUNTO', 'EMISOR', 'CARGO','FECHA DE TERMINO','ESTATUS','DIRECCIÓN DE DESTINO','OBSERVACIONES','N° DE OFICIO DE RESPUESTA', 'PERSONA QUE CONTESTO EL OFICIO','CÓDIGO ARCHIVISTICO','FECHA DE RESPUESTA','HORA DE RESPUESTA');

        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
   $objPHPExcel->setActiveSheetIndex(0)
   ->mergeCells('A1:O1');
// Se agregan los titulos del reporte
   $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('C3',  $tituloReporte) // Titulo del Reporte
    ->setCellValue('C4',  $tituloCseiio) // Titulo del Colegio
    ->setCellValue('A6',  $titulosColumnas[0])  //Titulo de las columnas
    ->setCellValue('B6',  $titulosColumnas[1])
    ->setCellValue('C6',  $titulosColumnas[2])
    ->setCellValue('D6',  $titulosColumnas[3])
    ->setCellValue('E6',  $titulosColumnas[4])
    ->setCellValue('F6',  $titulosColumnas[5])
    ->setCellValue('G6',  $titulosColumnas[6])
    ->setCellValue('H6',  $titulosColumnas[7])
    ->setCellValue('I6',  $titulosColumnas[8])
    ->setCellValue('J6',  $titulosColumnas[9])
    ->setCellValue('K6',  $titulosColumnas[10])
    ->setCellValue('L6',  $titulosColumnas[11])
    ->setCellValue('M6',  $titulosColumnas[12])
    ->setCellValue('N6',  $titulosColumnas[13])
    ->setCellValue('O6',  $titulosColumnas[14]);


    $objPHPExcel->getActiveSheet()->getStyle('A6:O6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');

        //ENTRADAS
      // $dato2 = $this->modelo_reportes->entradas($inicio,$final);
       // $dato = $this->modelo_reportes-> conteoAsistencias($inicio,$final);

    $oficios = $this->Modelo_reportes->getAllEntradasInternasDepto($nombre, $inicio, $final);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {
      if ($fila->status == 'Contestado' OR $fila->status == 'Fuera de Tiempo') {

        $infor_contestados = $this->Modelo_reportes->getAllOficiosDeptosIntByID($fila->id_recepcion_int);

        foreach ($infor_contestados  as $key) {

         $objPHPExcel->setActiveSheetIndex(0)
         ->setCellValue('A'.$i, $key->num_oficio)
         ->setCellValue('B'.$i, $key->fecha_emision)
         ->setCellValue('C'.$i, $key->hora_emision)
         ->setCellValue('D'.$i, $key->asunto)
         ->setCellValue('E'.$i, $key->emisorexterno)
         ->setCellValue('F'.$i, $key->cargoexterno)
         ->setCellValue('G'.$i, $key->fecha_termino)
         ->setCellValue('H'.$i, $key->status)
         ->setCellValue('I'.$i, $key->nombre_direccion)
         ->setCellValue('J'.$i, $key->observaciones)
         ->setCellValue('K'.$i, $key->num_oficio_respuesta)
         ->setCellValue('L'.$i, $key->emisor)
         ->setCellValue('M'.$i, $key->codigo)
         ->setCellValue('N'.$i, $key->fecha_respuesta)
         ->setCellValue('O'.$i, $key->hora_respuesta);
       }
     }
     else
     {
      $objPHPExcel->setActiveSheetIndex(0)
      ->setCellValue('A'.$i, $fila->num_oficio)
      ->setCellValue('B'.$i, $fila->fecha_emision)
      ->setCellValue('C'.$i, $fila->hora_emision)
      ->setCellValue('D'.$i, $fila->asunto)
      ->setCellValue('E'.$i, $fila->emisor)
      ->setCellValue('F'.$i, $fila->cargo)
      ->setCellValue('G'.$i, $fila->fecha_termino)
      ->setCellValue('H'.$i, $fila->status)
      ->setCellValue('I'.$i, $fila->nombre_direccion)
      ->setCellValue('J'.$i, $fila->observaciones);
    }
    $i++;

  }

           // Se asigna el nombre a la hoja
 $objPHPExcel->getActiveSheet()->setTitle('Oficio Emitidos');

 $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
 header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 header('Content-Disposition: attachment;filename="Reporte_de_oficios_EMITIDOS:'.$hoy.'.xlsx"');
 header('Cache-Control: max-age=0');

 $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
 $objWriter->save('php://output');
 exit;

}


public function reporteContestadosDeptoInt() {


    $this->load->library('Excel');
    $objPHPExcel = new PHPExcel();

    date_default_timezone_set('America/Mexico_City');
    $time = time();
    $hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

    $inicio = $this->input->post('date_inicio');
    $final = $this->input->post('date_final');
    $id_area = $this->session->userdata('id_area');

        // DIBUJANDO EL LOGO DEL CSEIIO
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo');
    $objDrawing->setDescription('Logo');
    $objDrawing->setPath('./assets/img/apple-touch-icon.png');

    $objDrawing->setCoordinates('A1');
    $objDrawing->setHeight(100);
    $objDrawing->setWidth(100);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


        // DIBUJANDO EL LOGO DEL GOBIERNO DEL ESTADO
    $objDrawingGob = new PHPExcel_Worksheet_Drawing();
    $objDrawingGob->setName('LogoGob');
    $objDrawingGob->setDescription('Logo');
    $objDrawingGob->setPath('./assets/img/GobOaxacaLogo.png');

    $objDrawingGob->setCoordinates('P1');
    $objDrawingGob->setHeight(1000);
    $objDrawingGob->setWidth(306);
    $objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

    $objPHPExcel->getProperties()->setCreator("CSEIIO")
    ->setLastModifiedBy("CSEIIO")
    ->setTitle("Reporte de oficios contestados-Modalidad Externa")
    ->setSubject("Reporte de Departamentos")
    ->setDescription("Reporte que contiene el total de oficios contestados por el Departamento - Modalidad Interna.")
    ->setKeywords("cseiio reporte oficios depto externos")
    ->setCategory("Reporte");

    $tituloReporte = "Reporte de oficios contestados, comprendido del periodo:  ".$inicio."  al ".$final."";
    $tituloCseiio = "Colegio Superior Para la Educación Integral e Intercultural de Oaxaca";
   $titulosColumnas = array('CÓDIGO ARCHIVISTICO', 'NÚMERO DE EXPEDIENTE', 'NÚMERO DE OFICIO', 'ASUNTO', 'TIPO DE RECEPCIÓN', 'EMISOR','DEPENDENCIA','CARGO','FECHA DE RECEPCIÓN','HORA DE RECEPCIÓN', 'FECHA DE TERMINO', 'ESTATUS', 'NÚMERO DE OFICIO DE RESPUESTA','FUNCIONARIO QUE REALIZÓ EL OFICIO','CARGO', 'FECHA DE RESPUESTA', 'HORA DE RESPUESTA');

        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
    $objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A1:Q1');
// Se agregan los titulos del reporte
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('F3',  $tituloReporte) // Titulo del Reporte
    ->setCellValue('F4',  $tituloCseiio) // Titulo del Colegio
  ->setCellValue('A6',  $titulosColumnas[0])  //Titulo de las columnas
    ->setCellValue('B6',  $titulosColumnas[1])
    ->setCellValue('C6',  $titulosColumnas[2])
    ->setCellValue('D6',  $titulosColumnas[3])
    ->setCellValue('E6',  $titulosColumnas[4])
    ->setCellValue('F6',  $titulosColumnas[5])
    ->setCellValue('G6',  $titulosColumnas[6])
    ->setCellValue('H6',  $titulosColumnas[7])
    ->setCellValue('I6',  $titulosColumnas[8])
    ->setCellValue('J6',  $titulosColumnas[9])
    ->setCellValue('K6',  $titulosColumnas[10])
    ->setCellValue('L6',  $titulosColumnas[11])
    ->setCellValue('M6',  $titulosColumnas[12])
    ->setCellValue('N6',  $titulosColumnas[13])
    ->setCellValue('O6',  $titulosColumnas[14])
    ->setCellValue('P6',  $titulosColumnas[15])
    ->setCellValue('Q6',  $titulosColumnas[16]);


    $objPHPExcel->getActiveSheet()->getStyle('A6:Q6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');

        //ENTRADAS
      // $dato2 = $this->modelo_reportes->entradas($inicio,$final);
       // $dato = $this->modelo_reportes-> conteoAsistencias($inicio,$final);

    $oficios = $this->Modelo_reportes->getAllContestadosInternosDepto($id_area,$inicio, $final);

    $i = 7;
    $j = 1;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {

     $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('A'.$i, $fila->codigo)
     ->setCellValue('B'.$i, $j)
     ->setCellValue('C'.$i, $fila->num_oficio)
     ->setCellValue('D'.$i, $fila->asunto)
     ->setCellValue('E'.$i, $fila->tipo_recepcion)
     ->setCellValue('F'.$i, $fila->emisorexterno)
     ->setCellValue('G'.$i, $fila->dependencia)
     ->setCellValue('H'.$i, $fila->cargoexterno)
     ->setCellValue('I'.$i, $fila->fecha_emision)
     ->setCellValue('J'.$i, $fila->hora_emision)
     ->setCellValue('K'.$i, $fila->fecha_termino)
     ->setCellValue('L'.$i, $fila->status)
     ->setCellValue('M'.$i, $fila->num_oficio_respuesta)
     ->setCellValue('N'.$i, $fila->emisor)
     ->setCellValue('O'.$i, $fila->cargo)
     ->setCellValue('P'.$i, $fila->hora_respuesta)
     ->setCellValue('Q'.$i, $fila->hora_respuesta);

     $i++;
     $j++;

 }

           // Se asigna el nombre a la hoja
 $objPHPExcel->getActiveSheet()->setTitle('Oficios Contestados');

 $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
 header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 header('Content-Disposition: attachment;filename="Reporte_de_oficios_CONTESTADOS:'.$hoy.'.xlsx"');
 header('Cache-Control: max-age=0');

 $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
 $objWriter->save('php://output');
 exit;


}


 public function reporteNoContestadosDeptoInt()
{
   $this->load->library('Excel');
   $objPHPExcel = new PHPExcel();

   date_default_timezone_set('America/Mexico_City');
   $time = time();
   $hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

   $inicio = $this->input->post('date_inicio');
   $final = $this->input->post('date_final');
   $id_area = $this->session->userdata('id_area');

        // DIBUJANDO EL LOGO DEL CSEIIO
   $objDrawing = new PHPExcel_Worksheet_Drawing();
   $objDrawing->setName('Logo');
   $objDrawing->setDescription('Logo');
   $objDrawing->setPath('./assets/img/apple-touch-icon.png');

   $objDrawing->setCoordinates('A1');
   $objDrawing->setHeight(100);
   $objDrawing->setWidth(100);
   $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


        // DIBUJANDO EL LOGO DEL GOBIERNO DEL ESTADO
   $objDrawingGob = new PHPExcel_Worksheet_Drawing();
   $objDrawingGob->setName('LogoGob');
   $objDrawingGob->setDescription('Logo');
   $objDrawingGob->setPath('./assets/img/GobOaxacaLogo.png');

   $objDrawingGob->setCoordinates('F1');
   $objDrawingGob->setHeight(1000);
   $objDrawingGob->setWidth(306);
   $objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

   $objPHPExcel->getProperties()->setCreator("CSEIIO")
   ->setLastModifiedBy("CSEIIO")
   ->setTitle("Reporte del Total de Oficios No Contestados-Modalidad Interna")
   ->setSubject("Reporte No Contestados")
   ->setDescription("Reporte que contiene el total de oficios no contestados por el Daepartamento, Modalidad Interna.")
   ->setKeywords("cseiio reporte oficios depto internos")
   ->setCategory("Reporte");

   $tituloReporte = "Reporte de oficios no contestados, comprendido del periodo:  ".$inicio."  al ".$final."";
   $tituloCseiio = "Colegio Superior Para la Educación Integral e Intercultural de Oaxaca";
   $titulosColumnas = array('NÚMERO DE OFICIO', 'FECHA DE EMISIÓN', 'HORA DE EMISIÓN', 'ASUNTO', 'EMISOR', 'CARGO','FECHA DE TERMINO','ESTATUS','DIRECCIÓN DE DESTINO','OBSERVACIONES');

        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
   $objPHPExcel->setActiveSheetIndex(0)
   ->mergeCells('A1:J1');
// Se agregan los titulos del reporte
   $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('C3',  $tituloReporte) // Titulo del Reporte
    ->setCellValue('C4',  $tituloCseiio) // Titulo del Colegio
    ->setCellValue('A6',  $titulosColumnas[0])  //Titulo de las columnas
    ->setCellValue('B6',  $titulosColumnas[1])
    ->setCellValue('C6',  $titulosColumnas[2])
    ->setCellValue('D6',  $titulosColumnas[3])
    ->setCellValue('E6',  $titulosColumnas[4])
    ->setCellValue('F6',  $titulosColumnas[5])
    ->setCellValue('G6',  $titulosColumnas[6])
    ->setCellValue('H6',  $titulosColumnas[7])
    ->setCellValue('I6',  $titulosColumnas[8])
    ->setCellValue('J6',  $titulosColumnas[9]);


    $objPHPExcel->getActiveSheet()->getStyle('A6:J6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');

        //ENTRADAS
      // $dato2 = $this->modelo_reportes->entradas($inicio,$final);
       // $dato = $this->modelo_reportes-> conteoAsistencias($inicio,$final);

    $oficios = $this->Modelo_reportes->getAllNoContestadosInternosDepto($id_area, $inicio, $final);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {

     $objPHPExcel->setActiveSheetIndex(0)
     ->setCellValue('A'.$i, $fila->num_oficio)
     ->setCellValue('B'.$i, $fila->fecha_emision)
     ->setCellValue('C'.$i, $fila->hora_emision)
     ->setCellValue('D'.$i, $fila->asunto)
     ->setCellValue('E'.$i, $fila->emisor)
     ->setCellValue('F'.$i, $fila->cargo)
     ->setCellValue('G'.$i, $fila->fecha_termino)
     ->setCellValue('H'.$i, $fila->status)
     ->setCellValue('I'.$i, $fila->nombre_direccion)
     ->setCellValue('J'.$i, $fila->observaciones);

     $i++;

 }

           // Se asigna el nombre a la hoja
 $objPHPExcel->getActiveSheet()->setTitle('Oficios No Contestados');

 $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
 header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 header('Content-Disposition: attachment;filename="Reporte_de_oficios_NO_CONTESTADOS:'.$hoy.'.xlsx"');
 header('Cache-Control: max-age=0');

 $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
 $objWriter->save('php://output');
 exit;

}


public function reportePendientesDireccionesInt()
 {
   $this->load->library('Excel');
   $objPHPExcel = new PHPExcel();

   date_default_timezone_set('America/Mexico_City');
   $time = time();
   $hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

   $inicio = $this->input->post('date_inicio');
   $final = $this->input->post('date_final');
   $id_area = $this->session->userdata('id_area');

        // DIBUJANDO EL LOGO DEL CSEIIO
   $objDrawing = new PHPExcel_Worksheet_Drawing();
   $objDrawing->setName('Logo');
   $objDrawing->setDescription('Logo');
   $objDrawing->setPath('./assets/img/apple-touch-icon.png');

   $objDrawing->setCoordinates('A1');
   $objDrawing->setHeight(100);
   $objDrawing->setWidth(100);
   $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


        // DIBUJANDO EL LOGO DEL GOBIERNO DEL ESTADO
   $objDrawingGob = new PHPExcel_Worksheet_Drawing();
   $objDrawingGob->setName('LogoGob');
   $objDrawingGob->setDescription('Logo');
   $objDrawingGob->setPath('./assets/img/GobOaxacaLogo.png');

   $objDrawingGob->setCoordinates('F1');
   $objDrawingGob->setHeight(1000);
   $objDrawingGob->setWidth(306);
   $objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

   $objPHPExcel->getProperties()->setCreator("CSEIIO")
   ->setLastModifiedBy("CSEIIO")
   ->setTitle("Reporte del Total de Oficios Pendientes-Modalidad Interna")
   ->setSubject("Reporte de Oficialia")
   ->setDescription("Reporte que contiene el total de oficios pendientes por responder del Departamento, Modalidad Interna.")
   ->setKeywords("cseiio reporte oficios depto internos")
   ->setCategory("Reporte");

   $tituloReporte = "Reporte de oficios pendientes por responder, comprendido del periodo:  ".$inicio."  al ".$final."";
   $tituloCseiio = "Colegio Superior Para la Educación Integral e Intercultural de Oaxaca";
   $titulosColumnas = array('NÚMERO DE OFICIO', 'FECHA DE EMISIÓN', 'HORA DE EMISIÓN', 'ASUNTO', 'EMISOR', 'CARGO','FECHA DE TERMINO','ESTATUS','DIRECCIÓN DE DESTINO','OBSERVACIONES','DÍAS RESTANTES');

        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
   $objPHPExcel->setActiveSheetIndex(0)
   ->mergeCells('A1:K1');
// Se agregan los titulos del reporte
   $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('C3',  $tituloReporte) // Titulo del Reporte
    ->setCellValue('C4',  $tituloCseiio) // Titulo del Colegio
    ->setCellValue('A6',  $titulosColumnas[0])  //Titulo de las columnas
    ->setCellValue('B6',  $titulosColumnas[1])
    ->setCellValue('C6',  $titulosColumnas[2])
    ->setCellValue('D6',  $titulosColumnas[3])
    ->setCellValue('E6',  $titulosColumnas[4])
    ->setCellValue('F6',  $titulosColumnas[5])
    ->setCellValue('G6',  $titulosColumnas[6])
    ->setCellValue('H6',  $titulosColumnas[7])
    ->setCellValue('I6',  $titulosColumnas[8])
    ->setCellValue('J6',  $titulosColumnas[9])
    ->setCellValue('K6',  $titulosColumnas[10]);


    $objPHPExcel->getActiveSheet()->getStyle('A6:K6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');

        //ENTRADAS
      // $dato2 = $this->modelo_reportes->entradas($inicio,$final);
       // $dato = $this->modelo_reportes-> conteoAsistencias($inicio,$final);

    $oficios = $this->Modelo_reportes->getAllPendientesInternosDepto($id_area, $inicio, $final);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {
      if ($fila->tipo_dias == 0) 
      {
           // DIAS NATURALES
        // Obteniendo dias naturales restantes entre la fecha de termino
        // y la fecha actual, si el oficio viene configurado con dias
        // naturales
        date_default_timezone_set('America/Mexico_City');
        $dia_actual = date('Y-m-d');

        $date1 = $dia_actual;
        $date2 = $fila->fecha_termino;
        $diff = abs(strtotime($date2) - strtotime($date1));

        $years = floor($diff / (365*60*60*24));
        $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));

        $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));

        if ($days != 0) 
        {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, $fila->num_oficio)
          ->setCellValue('B'.$i, $fila->fecha_emision)
          ->setCellValue('C'.$i, $fila->hora_emision)
          ->setCellValue('D'.$i, $fila->asunto)
          ->setCellValue('E'.$i, $fila->emisor)
          ->setCellValue('F'.$i, $fila->cargo)
          ->setCellValue('G'.$i, $fila->fecha_termino)
          ->setCellValue('H'.$i, $fila->status)
          ->setCellValue('I'.$i, $fila->nombre_direccion)
          ->setCellValue('J'.$i, $fila->observaciones)
          ->setCellValue('K'.$i, $days);

        }
        else
        {
          $objPHPExcel->setActiveSheetIndex(0)
          ->setCellValue('A'.$i, $fila->num_oficio)
          ->setCellValue('B'.$i, $fila->fecha_emision)
          ->setCellValue('C'.$i, $fila->hora_emision)
          ->setCellValue('D'.$i, $fila->asunto)
          ->setCellValue('E'.$i, $fila->emisor)
          ->setCellValue('F'.$i, $fila->cargo)
          ->setCellValue('G'.$i, $fila->fecha_termino)
          ->setCellValue('H'.$i, $fila->status)
          ->setCellValue('I'.$i, $fila->nombre_direccion)
          ->setCellValue('J'.$i, $fila->observaciones)
          ->setCellValue('K'.$i, '0');
        }
      }
      else
        if($fila->tipo_dias == 1)
        {
            // DIAS HÁBILES
          // Si el oficio viene configurado con días hábiles
          // entonces, llamar a la funcion  getDiasHabiles
          // si $dias_habiles = 0 
          // entonces imprimir : 0
          date_default_timezone_set('America/Mexico_City');
          $dia_actual = date('Y-m-d');
          $date1 = $dia_actual;
          $date2 = $fila->fecha_termino;
          $dias_habiles = $this->getDiasHabiles($date1 , $date2); 
          $num_dias = count($dias_habiles);

          if ($dias_habiles != 0) {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $fila->num_oficio)
            ->setCellValue('B'.$i, $fila->fecha_emision)
            ->setCellValue('C'.$i, $fila->hora_emision)
            ->setCellValue('D'.$i, $fila->asunto)
            ->setCellValue('E'.$i, $fila->emisor)
            ->setCellValue('F'.$i, $fila->cargo)
            ->setCellValue('G'.$i, $fila->fecha_termino)
            ->setCellValue('H'.$i, $fila->status)
            ->setCellValue('I'.$i, $fila->nombre_direccion)
            ->setCellValue('J'.$i, $fila->observaciones)
            ->setCellValue('K'.$i, $num_dias);
          }
          else
          {
            $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $fila->num_oficio)
            ->setCellValue('B'.$i, $fila->fecha_emision)
            ->setCellValue('C'.$i, $fila->hora_emision)
            ->setCellValue('D'.$i, $fila->asunto)
            ->setCellValue('E'.$i, $fila->emisor)
            ->setCellValue('F'.$i, $fila->cargo)
            ->setCellValue('G'.$i, $fila->fecha_termino)
            ->setCellValue('H'.$i, $fila->status)
            ->setCellValue('I'.$i, $fila->nombre_direccion)
            ->setCellValue('J'.$i, $fila->observaciones)
            ->setCellValue('K'.$i, '0');
          }
        }



        $i++;

      }

           // Se asigna el nombre a la hoja
      $objPHPExcel->getActiveSheet()->setTitle('Oficios Pendientes');

      $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="Reporte_de_oficios_PENDIENTES:'.$hoy.'.xlsx"');
      header('Cache-Control: max-age=0');

      $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
      $objWriter->save('php://output');
      exit;

    }




public function reporteContestadoFueraDeTiempoDepto() {


    $this->load->library('Excel');
    $objPHPExcel = new PHPExcel();

    date_default_timezone_set('America/Mexico_City');
    $time = time();
    $hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

    $inicio = $this->input->post('date_inicio');
    $final = $this->input->post('date_final');
       $id_area = $this->session->userdata('id_area');

        // DIBUJANDO EL LOGO DEL CSEIIO
    $objDrawing = new PHPExcel_Worksheet_Drawing();
    $objDrawing->setName('Logo');
    $objDrawing->setDescription('Logo');
    $objDrawing->setPath('./assets/img/apple-touch-icon.png');

    $objDrawing->setCoordinates('A1');
    $objDrawing->setHeight(100);
    $objDrawing->setWidth(100);
    $objDrawing->setWorksheet($objPHPExcel->getActiveSheet());


        // DIBUJANDO EL LOGO DEL GOBIERNO DEL ESTADO
    $objDrawingGob = new PHPExcel_Worksheet_Drawing();
    $objDrawingGob->setName('LogoGob');
    $objDrawingGob->setDescription('Logo');
    $objDrawingGob->setPath('./assets/img/GobOaxacaLogo.png');

    $objDrawingGob->setCoordinates('P1');
    $objDrawingGob->setHeight(1000);
    $objDrawingGob->setWidth(306);
    $objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

    $objPHPExcel->getProperties()->setCreator("CSEIIO")
    ->setLastModifiedBy("CSEIIO")
    ->setTitle("Reporte de oficios contestados fuera de tiempo-Modalidad Externa")
    ->setSubject("Reporte de Departamentos ")
    ->setDescription("Reporte que contiene el total de oficios contestados fuera de tiempo- Modalidad Externa.")
    ->setKeywords("cseiio reporte oficios oficialia externos")
    ->setCategory("Reporte");

    $tituloReporte = "Reporte de oficios contestados fuera de tiempo, comprendido del periodo:  ".$inicio."  al ".$final."";
    $tituloCseiio = "Colegio Superior Para la Educación Integral e Intercultural de Oaxaca";
    $titulosColumnas = array('CÓDIGO ARCHIVISTICO', 'NÚMERO DE EXPEDIENTE', 'NÚMERO DE OFICIO', 'ASUNTO', 'TIPO DE RECEPCIÓN', 'EMISOR','DEPENDENCIA','CARGO','FECHA DE RECEPCIÓN','HORA DE RECEPCIÓN', 'FECHA DE TERMINO', 'ESTATUS', 'NÚMERO DE OFICIO DE RESPUESTA','FUNCIONARIO QUE REALIZÓ EL OFICIO','CARGO', 'FECHA DE RESPUESTA', 'HORA DE RESPUESTA');

        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
    $objPHPExcel->setActiveSheetIndex(0)
    ->mergeCells('A1:Q1');
// Se agregan los titulos del reporte
    $objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('F3',  $tituloReporte) // Titulo del Reporte
    ->setCellValue('F4',  $tituloCseiio) // Titulo del Colegio
    ->setCellValue('A6',  $titulosColumnas[0])  //Titulo de las columnas
    ->setCellValue('B6',  $titulosColumnas[1])
    ->setCellValue('C6',  $titulosColumnas[2])
    ->setCellValue('D6',  $titulosColumnas[3])
    ->setCellValue('E6',  $titulosColumnas[4])
    ->setCellValue('F6',  $titulosColumnas[5])
    ->setCellValue('G6',  $titulosColumnas[6])
    ->setCellValue('H6',  $titulosColumnas[7])
    ->setCellValue('I6',  $titulosColumnas[8])
    ->setCellValue('J6',  $titulosColumnas[9])
    ->setCellValue('K6',  $titulosColumnas[10])
    ->setCellValue('L6',  $titulosColumnas[11])
    ->setCellValue('M6',  $titulosColumnas[12])
    ->setCellValue('N6',  $titulosColumnas[13])
    ->setCellValue('O6',  $titulosColumnas[14])
    ->setCellValue('P6',  $titulosColumnas[15])
    ->setCellValue('Q6',  $titulosColumnas[16]);


    $objPHPExcel->getActiveSheet()->getStyle('A6:Q6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');

        //ENTRADAS
      // $dato2 = $this->modelo_reportes->entradas($inicio,$final);
       // $dato = $this->modelo_reportes-> conteoAsistencias($inicio,$final);

    $oficios = $this->Modelo_reportes->getAllFueraTiempoInternosDepto($id_area,$inicio, $final);

    $i = 7;
    $j = 1;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {

     $objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A'.$i, $fila->codigo)
     ->setCellValue('B'.$i, $j)
     ->setCellValue('C'.$i, $fila->num_oficio)
     ->setCellValue('D'.$i, $fila->asunto)
     ->setCellValue('E'.$i, $fila->tipo_recepcion)
     ->setCellValue('F'.$i, $fila->emisorexterno)
     ->setCellValue('G'.$i, $fila->dependencia)
     ->setCellValue('H'.$i, $fila->cargoexterno)
     ->setCellValue('I'.$i, $fila->fecha_emision)
     ->setCellValue('J'.$i, $fila->hora_emision)
     ->setCellValue('K'.$i, $fila->fecha_termino)
     ->setCellValue('L'.$i, $fila->status)
     ->setCellValue('M'.$i, $fila->num_oficio_respuesta)
     ->setCellValue('N'.$i, $fila->emisor)
     ->setCellValue('O'.$i, $fila->cargo)
     ->setCellValue('P'.$i, $fila->hora_respuesta)
     ->setCellValue('Q'.$i, $fila->hora_respuesta);

     $i++;
     $j++;

 }

           // Se asigna el nombre a la hoja
 $objPHPExcel->getActiveSheet()->setTitle('Oficios Fuera de Tiempo');

 $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
 header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
 header('Content-Disposition: attachment;filename="Reporte_de_oficios_FUERADETIEMPO:'.$hoy.'.xlsx"');
 header('Cache-Control: max-age=0');

 $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
 $objWriter->save('php://output');
 exit;


}


}

/* End of file ReportesDeptoInt.php */
/* Location: ./application/controllers/ReportesDeptoInt.php */