<?php
//loading library
$vendorDirPath = (SEMEROOT.'kero/lib/phpoffice/vendor/');
$vendorDirPath = realpath($vendorDirPath);
require_once $vendorDirPath.'/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Home extends SENE_Controller
{
  public function __construct()
  {
    parent::__construct();
    $this->setTheme('front');
    $this->load('b_user_model','bum');
  }
  public function __dateIndonesia($datetime, $utype='hari_tanggal')
  {
    if (is_null($datetime) || empty($datetime)) {
      $datetime='now';
    }
    $stt = strtotime($datetime);
    $bulan_ke = date('n', $stt);
    $bulan = 'Desember';
    switch ($bulan_ke) {
      case '1':
      $bulan = 'Januari';
      break;
      case '2':
      $bulan = 'Februari';
      break;
      case '3':
      $bulan = 'Maret';
      break;
      case '4':
      $bulan = 'April';
      break;
      case '5':
      $bulan = 'Mei';
      break;
      case '6':
      $bulan = 'Juni';
      break;
      case '7':
      $bulan = 'Juli';
      break;
      case '8':
      $bulan = 'Agustus';
      break;
      case '9':
      $bulan = 'September';
      break;
      case '10':
      $bulan = 'Oktober';
      break;
      case '11':
      $bulan = 'November';
      break;
      default:
      $bulan = 'Desember';
    }
    $hari_ke = date('N', $stt);
    $hari = 'Minggu';
    switch ($hari_ke) {
      case '1':
      $hari = 'Senin';
      break;
      case '2':
      $hari = 'Selasa';
      break;
      case '3':
      $hari = 'Rabu';
      break;
      case '4':
      $hari = 'Kamis';
      break;
      case '5':
      $hari = 'Jumat';
      break;
      case '6':
      $hari = 'Sabtu';
      break;
      default:
      $hari = 'Minggu';
    }
    $utype == strtolower($utype);
    if ($utype=="hari") {
      return $hari;
    }
    if ($utype=="jam") {
      return date('H:i', $stt).' WIB';
    }
    if ($utype=="bulan") {
      return $bulan;
    }
    if ($utype=="tahun") {
      return date('Y', $stt);
    }
    if ($utype=="bulan_tahun") {
      return $bulan.' '.date('Y', $stt);
    }
    if ($utype=="tanggal") {
      return ''.date('d', $stt).' '.$bulan.' '.date('Y', $stt);
    }
    if ($utype=="tanggal_jam") {
      return ''.date('d', $stt).' '.$bulan.' '.date('Y H:i', $stt).' WIB';
    }
    if ($utype=="hari_tanggal") {
      return $hari.', '.date('d', $stt).' '.$bulan.' '.date('Y', $stt);
    }
    if ($utype=="hari_tanggal_jam") {
      return $hari.', '.date('d', $stt).' '.$bulan.' '.date('Y H:i', $stt).' WIB';
    }
  }

  private function __forceDownload($pathFile)
  {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($pathFile));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($pathFile));
    ob_clean();
    flush();
    readfile($pathFile);
    exit;
  }

  private function __checkDir($periode)
  {
    if (!is_dir(SEMEROOT.'media/')) {
      mkdir(SEMEROOT.'media/', 0777);
    }
    if (!is_dir(SEMEROOT.'media/laporan/')) {
      mkdir(SEMEROOT.'media/laporan/', 0777);
    }
    $str = $periode.'/01';
    $periode_y = date("Y", strtotime($str));
    $periode_m = date("m", strtotime($str));
    if (!is_dir(SEMEROOT.'media/laporan/'.$periode_y)) {
      mkdir(SEMEROOT.'media/laporan/'.$periode_y, 0777);
    }
    if (!is_dir(SEMEROOT.'media/laporan/'.$periode_y.'/'.$periode_m)) {
      mkdir(SEMEROOT.'media/laporan/'.$periode_y.'/'.$periode_m, 0777);
    }
    return SEMEROOT.'media/laporan/'.$periode_y.'/'.$periode_m;
  }

  public function index()
  {
    $data = array();
    $this->setTitle($this->config->semevar->site_title);
    $this->setDescription($this->config->semevar->site_description);
    $this->setKeyword($this->config->semevar->site_name);
    $this->setAuthor($this->config->semevar->site_name);
    $this->putJSReady('home/home_bottom',$data);
    $this->putThemeContent('home/home',$data);
    $this->loadLayout('col-1',$data);
    $this->render();
  }
  public function download_xls()
  {
    $is_active = $this->input->request("is_active");
    if(strlen($is_active)!=0) {
      if(!empty($is_active)){
        $is_active = 1;
      }else{
        $is_active = 0;
      }
    }else{
      $is_active = '';
    }
    $scdate = $this->input->request("scdate");
    if (strlen($scdate)==10) {
      $scdate = date("Y-m-d", strtotime($scdate));
    }else{
      $scdate = '';
    }

    $ecdate = $this->input->request("ecdate");
    if (strlen($ecdate)==10) {
      $ecdate = date("Y-m-d", strtotime($ecdate));
    }else{
      $ecdate = '';
    }
    $p = 'Periode: selama ini';
    if(strlen($scdate) && strlen($ecdate)){
      $p = 'Periode: '.$scdate.' - '.$ecdate;
    }elseif(strlen($scdate)==0 && strlen($ecdate)!=0){
      $p = 'Periode: sampai '.$ecdate;
    }elseif(strlen($scdate)!=0 && strlen($ecdate)==1){
      $p = 'Periode: mulai '.$ecdate;
    }elseif(strlen($scdate)!=0 && $scdate == $ecdate){
      $p = 'Tanggal: '.$scdate;
    }else{
      $p = '';
    }
    $data = $this->bum->xls($scdate,$ecdate,$is_active);

    //create object xls
    $objPHPExcel = new Spreadsheet();
    $objPHPExcel->setActiveSheetIndex(0);
    $objPHPExcel->getActiveSheet()->setTitle('User');

    //preset array gaya kolom
    $mt = array(
			'font'  => array(
				'bold'  => true,
				'size'  => 14,
				'name'  => 'Arial'
			)
		);
    $mt2 = array(
			'font'  => array(
				'bold'  => true,
				'size'  => 12,
				'name'  => 'Arial'
			)
		);
    $sb = array(
      'borders' => array(
        'allborders' => array(
          'style' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
        )
      )
    );
    $s = array('horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    //pengaturan lebar kolom
    $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(8);
    $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(55);
    $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(45);
    $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
    $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);


    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Laporan Pengguna')->mergeCells('A1:E1');
    $objPHPExcel->getActiveSheet()->getStyle('A1')->getAlignment()->applyFromArray($s);
    $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($mt);

    $objPHPExcel->getActiveSheet()->setCellValue('A2', $p)->mergeCells('A2:E2');
    $objPHPExcel->getActiveSheet()->getStyle('A2')->getAlignment()->applyFromArray($s);
    $objPHPExcel->getActiveSheet()->getStyle('A2:E2')->applyFromArray($mt2);


    //header table di excel
    $objPHPExcel
    ->getActiveSheet()
    ->setCellValue('A5', 'ID')
    ->setCellValue('B5', 'Nama')
    ->setCellValue('C5', 'Alamat')
    ->setCellValue('D5', 'Tgl Daftar')
    ->setCellValue('E5', 'Status');

    //apply border
    $objPHPExcel->getActiveSheet()->getStyle('A5')->applyFromArray($sb)->getAlignment()->applyFromArray($s);
    $objPHPExcel->getActiveSheet()->getStyle('B5')->applyFromArray($sb)->getAlignment()->applyFromArray($s);
    $objPHPExcel->getActiveSheet()->getStyle('C5')->applyFromArray($sb)->getAlignment()->applyFromArray($s);
    $objPHPExcel->getActiveSheet()->getStyle('D5')->applyFromArray($sb)->getAlignment()->applyFromArray($s);
    $objPHPExcel->getActiveSheet()->getStyle('E5')->applyFromArray($sb)->getAlignment()->applyFromArray($s);

    $i = 6;
    if (is_array($data) && count($data)) {
      //iterasikan data
      foreach ($data as $d) {
        $status = 'Aktif';
        if(empty($d->is_active)) $status = 'Non Aktif';
        if(isset($d->cdate)) $d->cdate = $this->__dateIndonesia($d->cdate,'hari_tanggal');

        //data tabel di excel
        $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, $d->id);
        $objPHPExcel->getActiveSheet()->setCellValue('B'.$i, $d->nama);
        $objPHPExcel->getActiveSheet()->setCellValue('C'.$i, $d->alamat);
        $objPHPExcel->getActiveSheet()->setCellValue('D'.$i, $d->cdate);
        $objPHPExcel->getActiveSheet()->setCellValue('E'.$i, $status);

        //apply border
        $objPHPExcel->getActiveSheet()->getStyle('A'.$i)->applyFromArray($sb);
        $objPHPExcel->getActiveSheet()->getStyle('B'.$i)->applyFromArray($sb);
        $objPHPExcel->getActiveSheet()->getStyle('C'.$i)->applyFromArray($sb);
        $objPHPExcel->getActiveSheet()->getStyle('D'.$i)->applyFromArray($sb);
        $objPHPExcel->getActiveSheet()->getStyle('E'.$i)->applyFromArray($sb);

        $i++;
      }
    }else{
      $objPHPExcel->getActiveSheet()->setCellValue('A'.$i, 'Tidak ada data')->mergeCells('A'.$i.':E'.$i);
      $objPHPExcel->getActiveSheet()->getStyle('A'.$i.':E'.$i)->applyFromArray($sb);
    }
    //save file
    $save_dir = $this->__checkDir(date("Y/m"));
    $save_file = 'laporan-user-'.str_replace(' ','-',str_replace('-','',strtolower($p)));

    $objWriter = new Xlsx($objPHPExcel);
    if (file_exists($save_dir.'/'.$save_file.'.xlsx')) {
      unlink($save_dir.'/'.$save_file.'.xlsx');
    }
    $objWriter->save($save_dir.'/'.$save_file.'.xlsx');

    $this->__forceDownload($save_dir.'/'.$save_file.'.xlsx');
  }

  public function download_pdf()
  {
    $is_active = $this->input->request("is_active");
    if(strlen($is_active)!=0) {
      if(!empty($is_active)){
        $is_active = 1;
      }else{
        $is_active = 0;
      }
    }else{
      $is_active = '';
    }
    $scdate = $this->input->request("scdate");
    if (strlen($scdate)==10) {
      $scdate = date("Y-m-d", strtotime($scdate));
    }else{
      $scdate = '';
    }

    $ecdate = $this->input->request("ecdate");
    if (strlen($ecdate)==10) {
      $ecdate = date("Y-m-d", strtotime($ecdate));
    }else{
      $ecdate = '';
    }
    $p = 'Periode: selama ini';
    if(strlen($scdate) && strlen($ecdate)){
      $p = 'Periode: '.$this->__dateIndonesia($scdate,'tanggal').' s.d. '.$this->__dateIndonesia($ecdate,'tanggal');
    }elseif(strlen($scdate)==0 && strlen($ecdate)!=0){
      $p = 'Periode: sampai '.$ecdate;
    }elseif(strlen($scdate)!=0 && strlen($ecdate)==1){
      $p = 'Periode: mulai '.$ecdate;
    }elseif(strlen($scdate)!=0 && $scdate == $ecdate){
      $p = 'Tanggal: '.$scdate;
    }else{
      $p = '';
    }

    $data = $this->bum->xls($scdate,$ecdate,$is_active);
    foreach($data as &$dr){
      if(isset($dr->is_active)){
        if(empty($dr->is_active)){
          $dr->is_active = 'Non Aktif';
        }else{
          $dr->is_active = 'Aktif';
        }
      }
      if(isset($dr->cdate)){
        if(strlen($dr->cdate)==10){
          $dr->cdate = $this->__dateIndonesia($dr->cdate, 'hari_tanggal');
        }else{
          $dr->cdate = '-';
        }
      }
    }

    $defObj = array();
    $i = 0;
    $defObj[$i] = new stdClass();
    $defObj[$i]->nama = 'ID';
    $defObj[$i]->width = '7';
    $defObj[$i]->align = 'C';
    $i++;
    $defObj[$i] = new stdClass();
    $defObj[$i]->nama = 'Nama';
    $defObj[$i]->width = '65';
    $defObj[$i]->align = 'L';
    $i++;
    $defObj[$i] = new stdClass();
    $defObj[$i]->nama = 'Alamat';
    $defObj[$i]->width = '45';
    $defObj[$i]->align = 'L';
    $i++;
    $defObj[$i] = new stdClass();
    $defObj[$i]->nama = 'Tgl Daftar';
    $defObj[$i]->width = '40';
    $defObj[$i]->align = 'L';
    $i++;
    $defObj[$i] = new stdClass();
    $defObj[$i]->nama = 'Status';
    $defObj[$i]->width = '18';
    $defObj[$i]->align = 'C';

    //create object pdf
    $judul = 'Laporan User';
    $this->lib('seme_page_fpdf');
    $pdf = new Seme_page_FPDF();
    $pdf->load_data($judul,$data,$defObj,$p);
    $filename = str_replace(' ','',strtolower($judul));
    $pdf->Output('I',$filename);
  }
  public function pdf(){
    $this->lib('seme_fpdf');
    $pdf = new Seme_FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,10,'Hello World!');
    $pdf->Output();
  }
}
