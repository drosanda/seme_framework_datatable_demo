<?php
class B_User_Model extends SENE_Model
{
  public $tbl = 'b_user';
  public $tbl_as = 'bu';
  public function __construct()
  {
    parent::__construct();
    $this->db->from($this->tbl, $this->tbl_as);
  }

  public function getAll($page=0, $pagesize=10, $sortCol="id", $sortDir="ASC", $keyword='', $scdate="", $ecdate="", $is_active='')
  {

    $this->db->flushQuery();
    $this->db->select_as("$this->tbl_as.id",'id',0);
    $this->db->select_as("$this->tbl_as.nama",'nama',0);
    $this->db->select_as("$this->tbl_as.alamat",'alamat',0);
    $this->db->select_as("$this->tbl_as.cdate",'cdate',0);
    $this->db->select_as("$this->tbl_as.is_active",'is_active',0);
    $this->db->from($this->tbl, $this->tbl_as);

    if (strlen($is_active)>0) {
      $this->db->where_as("is_active", $this->db->esc($is_active));
    }

    if (strlen($scdate)==10 && strlen($ecdate)==10) {
      $this->db->between("DATE($this->tbl_as.cdate)", 'DATE("'.$scdate.'")', 'DATE("'.$ecdate.'")');
    }elseif(strlen($scdate)!=10 && strlen($ecdate)==10){
      $this->db->where_as("DATE($this->tbl_as.cdate)", 'DATE("'.$ecdate.'")', 'AND', '<=');
    }elseif(strlen($scdate)==10 && strlen($ecdate)!=10){
      $this->db->where_as("DATE($this->tbl_as.cdate)", 'DATE("'.$scdate.'")', 'AND', '>=');
    }

    if (strlen($keyword)>0) {
      $this->db->where("nama", $keyword, "OR", "%like%", 1, 0);
      $this->db->where("alamat", $keyword, "OR", "%like%", 0, 1);
    }
    $this->db->order_by($sortCol, $sortDir)->limit($page, $pagesize);
    return $this->db->get("object", 0);
  }
  public function countAll($keyword='', $scdate="", $ecdate="", $is_active='')
  {
    $this->db->flushQuery();
    $this->db->select_as("COUNT(*)", "jumlah", 0);
    $this->db->from($this->tbl, $this->tbl_as);
    $this->db->from($this->tbl, $this->tbl_as);

    if (strlen($is_active)>0) {
      $this->db->where_as("is_active", $this->db->esc($is_active));
    }

    if (strlen($scdate)==10 && strlen($ecdate)==10) {
      $this->db->between("DATE($this->tbl_as.cdate)", 'DATE("'.$scdate.'")', 'DATE("'.$ecdate.'")');
    }elseif(strlen($scdate)!=10 && strlen($ecdate)==10){
      $this->db->where_as("DATE($this->tbl_as.cdate)", 'DATE("'.$ecdate.'")', 'AND', '<=');
    }elseif(strlen($scdate)==10 && strlen($ecdate)!=10){
      $this->db->where_as("DATE($this->tbl_as.cdate)", 'DATE("'.$scdate.'")', 'AND', '>=');
    }

    if (strlen($keyword)>0) {
      $this->db->where("nama", $keyword, "OR", "%like%", 1, 0);
      $this->db->where("alamat", $keyword, "OR", "%like%", 0, 1);
    }
    $d = $this->db->get_first("object", 0);
    if (isset($d->jumlah)) {
      return $d->jumlah;
    }
    return 0;
  }
}
