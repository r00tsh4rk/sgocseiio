<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this -> load -> model('Modelo_reportes');
	}

	public function index()
	{
		if ($this->session->userdata('nombre')) {

			$data['titulo'] = 'Reportes';
			$this->load->view('plantilla/header', $data);
			$this->load->view('recepcion/salidas/reportes');
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

  function getDiasHabiles($fechainicio, $fechafin, $diasferiados = array()) 
{
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


     //   reporteAllCapturadosSalidas
    
    public function reporteAllCapturadosSalidas()
    {
    	

    	$this->load->library('Excel');
    	$objPHPExcel = new PHPExcel();

    	date_default_timezone_set('America/Mexico_City');
    	$time = time();
    	$hoy = date("d-m-Y H:i:s", $time);
        //$hoy = date("F j, Y, g:i a");

    	$inicio = $this->input->post('date_inicio');
    	$final = $this->input->post('date_final');

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

    	$objDrawingGob->setCoordinates('O1');
    	$objDrawingGob->setHeight(1000);
    	$objDrawingGob->setWidth(306);
    	$objDrawingGob->setWorksheet($objPHPExcel->getActiveSheet());

    	$objPHPExcel->getProperties()->setCreator("CSEIIO")
    	->setLastModifiedBy("CSEIIO")
    	->setTitle("Reporte del Total de Oficios Recibidos-Modalidad Externa")
    	->setSubject("Reporte de Oficialia")
    	->setDescription("Reporte que contiene el total de oficios recibidos por Oficialia de Partes, Modalidad Externa.")
    	->setKeywords("cseiio reporte oficios oficialia externos")
    	->setCategory("Reporte");

    	$tituloReporte = "Reporte de oficios salientes, capturados por la Unidad, comprendido del periodo:  ".$inicio."  al ".$final."";
    	$tituloCseiio = "Colegio Superior Para la Educación Integral e Intercultural de Oaxaca";
    	$titulosColumnas = array('NÚMERO DE OFICIO', 'CÓDIGO ARCHIVISTICO', 'FECHA DE EMISIÓN', 'HORA DE EMISIÓN', 'ASUNTO', 'TIPO DE EMISIÓN','TIPO DE DOCUMENTO','EMISOR PRINCIPAL','TITULAR','FUNCIONARIO QUE REALIZÓ EL OFICIO','CARGO','REMITENTE','CARGO DEL REMITENTE','DEPENDENCIA DEL REMITENTE','OBSERVACIONES', '¿REQUIERE RESPUESTA?');

        // Se combinan las celdas A1 hasta F1, para colocar ahí el titulo del reporte
    	$objPHPExcel->setActiveSheetIndex(0)
    	->mergeCells('A1:P1');
// Se agregan los titulos del reporte
    	$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue('I3',  $tituloReporte) // Titulo del Reporte
    ->setCellValue('I4',  $tituloCseiio) // Titulo del Colegio
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
    ->setCellValue('P6',  $titulosColumnas[15]);


    $objPHPExcel->getActiveSheet()->getStyle('A6:P6')->getFill()
    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
    ->getStartColor()->setRGB('579A8D');

        //ENTRADAS
      // $dato2 = $this->modelo_reportes->entradas($inicio,$final);
       // $dato = $this->modelo_reportes-> conteoAsistencias($inicio,$final);

    $oficios = $this->Modelo_reportes->getAllOficiosSalida($inicio, $final);

    $i = 7;
    $j = 7;
        //Obteniendo todos los ID´s de enmpleados
    foreach($oficios as $fila)
    {
    	if ($fila->tieneRespuesta == 1) {
 	
    			$objPHPExcel->setActiveSheetIndex(0)
    			->setCellValue('A'.$i, $fila->num_oficio)
    			->setCellValue('B'.$i, $fila->codigo)
    			->setCellValue('C'.$i, $fila->fecha_emision)
    			->setCellValue('D'.$i, $fila->hora_emision)
    			->setCellValue('E'.$i, $fila->asunto)
    			->setCellValue('F'.$i, $fila->tipo_emision)
    			->setCellValue('G'.$i, $fila->tipo_documento)
    			->setCellValue('H'.$i, $fila->emisor_principal)
    			->setCellValue('I'.$i, $fila->titular)
    			->setCellValue('J'.$i, $fila->quien_realiza_oficio)
    			->setCellValue('K'.$i, $fila->cargo)
    			->setCellValue('L'.$i, $fila->remitente)
    			->setCellValue('M'.$i, $fila->cargo_remitente)
    			->setCellValue('N'.$i, $fila->observaciones)
    			->setCellValue('O'.$i, $fila->dependencia_remitente)
    			->setCellValue('P'.$i, 'Si');
    
    	}

    	else 
    		if($fila->tieneRespuesta == 0){

    		
    		$objPHPExcel->setActiveSheetIndex(0)
    	 		->setCellValue('A'.$i, $fila->num_oficio)
    			->setCellValue('B'.$i, $fila->codigo)
    			->setCellValue('C'.$i, $fila->fecha_emision)
    			->setCellValue('D'.$i, $fila->hora_emision)
    			->setCellValue('E'.$i, $fila->asunto)
    			->setCellValue('F'.$i, $fila->tipo_emision)
    			->setCellValue('G'.$i, $fila->tipo_documento)
    			->setCellValue('H'.$i, $fila->emisor_principal)
    			->setCellValue('I'.$i, $fila->titular)
    			->setCellValue('J'.$i, $fila->quien_realiza_oficio)
    			->setCellValue('K'.$i, $fila->cargo)
    			->setCellValue('L'.$i, $fila->remitente)
    			->setCellValue('M'.$i, $fila->cargo_remitente)
    			->setCellValue('N'.$i, $fila->observaciones)
    			->setCellValue('O'.$i, $fila->dependencia_remitente)
    			->setCellValue('P'.$i, 'No');
    	}
     //Contador de celdas
    	$i++;

    }

           // Se asigna el nombre a la hoja
    $objPHPExcel->getActiveSheet()->setTitle('Oficios Salientes Capturados');

    $objPHPExcel->setActiveSheetIndex(0);


            // Se manda el archivo al navegador web, con el nombre que se indica, en formato 2007
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="Reporte_de_oficios_SALIENTESCAPTURADOS:'.$hoy.'.xlsx"');
    header('Cache-Control: max-age=0');

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
    exit;


}

}

/* End of file Reportes.php */
/* Location: ./application/controllers/RecepcionGral/Salidas/Reportes.php */