function gritter(pesan,type='danger'){
	$.bootstrapGrowl(pesan, {
		type: type,
		delay: 2500,
		allow_dismiss: true
	});
}

$('.input-datepicker').datepicker({
  format: "yyyy-mm-dd"
});
if(jQuery('#drTable').length>0){
	drTable = jQuery('#drTable')
	.on('preXhr.dt', function ( e, settings, data ){
		NProgress.start();
	}).DataTable({
			"order"					: [[ 0, "desc" ]],
			"responsive"	  : true,
			"bProcessing"		: true,
			"bServerSide"		: true,
			"sAjaxSource"		: "<?=base_url("api/user/")?>",
			"fnServerParams": function ( aoData ) {
				aoData.push(
          { "name": "scdate", "value": $("#fl_scdate").val() },
          { "name": "ecdate", "value": $("#fl_ecdate").val() },
					{ "name": "is_active", "value": $("#fl_is_active").val() }
				);
			},
			"fnServerData"	: function (sSource, aoData, fnCallback, oSettings) {
				oSettings.jqXHR = $.ajax({
					dataType: 'json',
					method: 'POST',
					url: sSource,
					data: aoData
				}).done(function (response, status, headers, config) {
					NProgress.done();
					fnCallback(response);
				}).fail(function (response, status, headers, config) {
					NProgress.done();
					gritter("<h4>Error</h4><p>Tidak dapat mengambil data dari server</p>",'warning');
				});
			},
	});
	$('.dataTables_filter input').attr('placeholder', 'Cari nama dan alamat');
	$("#fl_btn").on("click",function(e){
		e.preventDefault();
		drTable.ajax.reload();
	});
}

$("#fl_download_xls").on("click",function(e){
	e.preventDefault();
	NProgress.start();
	gritter('<h4>Silakan tunggu</h4><p>Memproses filter download</p>','info');

	var params = '';
	params += 'scdate='+encodeURIComponent($("#fl_scdate").val())+'&';
	params += 'ecdate='+encodeURIComponent($("#fl_ecdate").val())+'&';
	params += 'is_active='+encodeURIComponent($("#fl_is_active").val())+'&';

	params = params.slice(0, -1);
	setTimeout(function(){
    NProgress.done();
		window.location='<?=base_url('home/download_xls/?') ?>'+params;
	},333);
});


$("#fl_download_pdf").on("click",function(e){
	e.preventDefault();
	NProgress.start();
	gritter('<h4>Silakan tunggu</h4><p>Memproses filter download</p>','info');

	var params = '';
	params += 'scdate='+encodeURIComponent($("#fl_scdate").val())+'&';
	params += 'ecdate='+encodeURIComponent($("#fl_ecdate").val())+'&';
	params += 'is_active='+encodeURIComponent($("#fl_is_active").val())+'&';

	params = params.slice(0, -1);
	setTimeout(function(){
    NProgress.done();
		window.location='<?=base_url('home/download_pdf/?') ?>'+params;
	},333);
});
