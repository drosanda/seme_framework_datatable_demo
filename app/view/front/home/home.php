<div class="container-fluid">
  <div class="row">
    <div class="col-md-12" style="">
      <h4>Filter</h4>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4" style="">&nbsp;</div>
    <div class="col-md-2" style="">
      <input id="fl_scdate" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="daftar dari tgl">
    </div>
    <div class="col-md-2" style="">
      <input id="fl_ecdate" class="form-control input-datepicker" data-date-format="yyyy-mm-dd" placeholder="daftar s.d. tgl">
    </div>
    <div class="col-md-2" style="">
      <select id="fl_is_active" class="form-control">
        <option value="">-- Semua --</option>
        <option value="1">Aktif</option>
        <option value="0">Tidak Aktif</option>
      </select>
    </div>
    <div class="col-md-2" style="">
      <div class="btn-group pull-right">
        <button type="button" id="fl_download_xls" class="btn btn-default"><i class="fa fa-download"></i> XLS</button>
        <button type="button" id="fl_download_pdf" class="btn btn-default"><i class="fa fa-download"></i> PDF</button>
        <button type="button" id="fl_btn" class="btn btn-default"><i class="fa fa-filter"></i></button>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12" style="">
      <hr>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12" style="">
      <div class="table-responsive">
        <table id="drTable" class="table table-bordered">
          <thead>
            <tr>
              <th>ID</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Tgl Daftar</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>
    </div>
  </div>
</div>
