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

  public function xls($scdate="", $ecdate="", $is_active='')
  {
    $this->db->flushQuery();
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
    $this->db->order_by('nama', 'asc');
    return $this->db->get("object", 0);
  }
}
