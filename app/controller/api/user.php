<?php
class User extends SENE_Controller
{
  public $domain_email = '@m.calystaclinic.com';
  public $kode_pattern = '%06d';
  public $kode = '00';
  public $kode_min = 5;
  public $is_log = 1;

  public function __construct()
  {
    parent::__construct();
    $this->load("api/b_user_model", 'bum');
  }

  private function __jsonDataTable($data, $count, $another=array())
  {
    $this->lib('sene_json_engine', 'sene_json');
    $rdata = array();
    if (!is_array($data)) {
      $data = array();
    }
    $dt1 = array();
    $dt2 = array();
    if (!is_array($data)) {
      trigger_error('jsonDataTable first params need array!');
      die();
    }
    foreach ($data as $dat) {
      $dt2 = array();
      if (is_int($dat)) {
        trigger_error('[ERROR: '.$dat.'] Data table not well performed because a query execution error!');
      }
      foreach ($dat as $dt) {
        $dt2[] = $dt;
      }
      $dt1[] = $dt2;
    }

    if (is_array($another)) {
      $rdata = $another;
    }
    $rdata['data'] = $dt1;
    $rdata['recordsFiltered'] = $count;
    $rdata['recordsTotal'] = $count;
    $rdata['status'] = (int) $this->status;
    $rdata['message'] = $this->message;
    $this->sene_json->out($rdata);
    die();
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

  public function index()
  {
    $data = array();

    $draw = $this->input->post("draw");
    $sval = $this->input->post("search");
    $keyword = $this->input->post("sSearch");
    $sEcho = $this->input->post("sEcho");
    $page = $this->input->post("iDisplayStart");
    if (empty($page)) {
      $page=0;
    }
    $pagesize = $this->input->post("iDisplayLength");
    if (empty($pagesize)) {
      $pagesize=10;
    }

    $tbl_as = $this->bum->tbl_as;
    $sortCol = $this->input->post("iSortCol_0");
    switch ($sortCol) {
      case 0:
      $sortCol = "$tbl_as.id";
      break;
      case 1:
      $sortCol = "$tbl_as.nama";
      break;
      case 2:
      $sortCol = "$tbl_as.alamat";
      break;
      case 3:
      $sortCol = "$tbl_as.cdate";
      break;
      case 4:
      $sortCol = "$tbl_as.is_active";
      break;
      default:
      $sortCol = "$tbl_as.id";
    }

    $sortDir = strtoupper($this->input->post("sSortDir_0"));
    if (empty($sortDir)) {
      $sortDir = "DESC";
    }
    if (strtolower($sortDir) != "desc") {
      $sortDir = "ASC";
    }

    $is_active = $this->input->post("is_active");
    if(strlen($is_active)!=0) {
      if(!empty($is_active)){
        $is_active = 1;
      }else{
        $is_active = 0;
      }
    }else{
      $is_active = '';
    }

    $scdate = $this->input->post("scdate");
    if (strlen($scdate)==10) {
      $scdate = date("Y-m-d", strtotime($scdate));
    }else{
      $scdate = '';
    }

    $ecdate = $this->input->post("ecdate");
    if (strlen($ecdate)==10) {
      $ecdate = date("Y-m-d", strtotime($ecdate));
    }else{
      $ecdate = '';
    }


    $this->status = 200;
    $this->message = 'Berhasil';
    $dcount = $this->bum->countAll($keyword, $scdate, $ecdate, $is_active);
    $ddata = $this->bum->getAll($page, $pagesize, $sortCol, $sortDir, $keyword, $scdate, $ecdate, $is_active);

    foreach ($ddata as &$gd) {
      if (isset($gd->is_active)) {
        if (!empty($gd->is_active)) {
          $gd->is_active = '<span class="label label-success">Aktif</span>';
        } else {
          $gd->is_active = '<span class="label label-default">Tidak Aktif</span>';
        }
      }
      if (isset($gd->cdate)) {
        if ($gd->cdate == "0000-00-00") {
          $gd->cdate = "-";
        }
        if ($gd->cdate != "-") {
          $gd->cdate = $this->__dateIndonesia($gd->cdate, 'hari_tanggal');
        }
      }
    }
    $this->__jsonDataTable($ddata, $dcount);
  }
}
