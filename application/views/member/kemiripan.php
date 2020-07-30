<style type="text/css">
	.my-custom-scrollbar {
		position: relative;
		height: 300px;
		overflow: auto;
	}

	.table-wrapper-scroll-y {
		display: block;
	}
</style>

<div class="card" id="inputKemiripan">
	<div class="card-title">
		<h4>Uji Kemiripan</h4>
	</div>
	<div class="card-body">
		<div class="row">
			<?php
			if (!empty($error)) {
				echo '<p class="error_msg">' . $error . '</p>';
			}
			?>
			
			<div class="col-md-12">
				<label>Input Dokumen</label>
				<div class="border border-primary p-3">
					<?php echo form_open("member/kemiripan/tambah", array('enctype' => 'multipart/form-data')); ?>
					<div class="form-group">
						<label>Dokumen Asli</label>
						<div class="input-group mb-3">
							<div class="custom-file">
								<input type="file" name="file" class="custom-file-input" id="dokAsli">
								<label class="custom-file-label">Pilih Dokumen Asli</label>
							</div>
						</div>
					</div>
					<div class="form-group">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<div class="input-group-text">
									<input type="checkbox" id="sinonim">
								</div>
							</div>
							<label for="sinonim" class="ml-2 mt-1"> Sinonim</label>
						</div>
					</div>
					<div class="form-group">
						<button id="btnStart" type="button" class="btn btn-primary">Start</button>
						<button id="btnReset" type="button" class="btn btn-secondary">Reset</button>
					</div>

					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="card" id="hasilKemiripan">
	<div class="card-title">
		<h4>Hasil Kemiripan</h4>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-12" style="text-align: right;">
				<button id="btnCetak" class="btn btn-sm btn-primary">Cetak</button>
				<!-- <button id="btnHasilKemiripan" class="btn btn-sm btn-secondary">Batal</button> -->
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<label> Daftar urut teratas kemiripan dokumen</label>
				<div class="table-wrapper-scroll-y my-custom-scrollbar">
					<?php echo form_open("member/kemiripan/cetakDok", array('id' => 'FormCetak')); ?>
					<table class="table table-hover table-striped mb-0" id="tblHasil">
						<thead>
						<th>Nama Dokumen</th>
						<th>Waktu Proses</th>
						<th>Persentasi Kemiripan</th>
						</thead>
						<tbody>
						</tbody>
					</table>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="card" id="detailKemiripan">
	<div class="card-title">
		<h4>Detail Kemiripan</h4>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-md-12">
				<button id="btnDetailKemiripan" class="btn btn-sm btn-light"> <<</button>
				<label id="subtitleDetail">kemiripan dokumen 1</label>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<label>Dokumen Asli</label>
				<div class="form-group">
					<div id="viewDokAsli" class="border border-primary p-3"
						 style="height: 250px; overflow: auto;"></div>
				</div>
			</div>
			<div class="col-md-6">
				<label>Dokumen Uji</label>
				<div class="form-group">
					<div id="viewDokUji" class="border border-primary p-3" style="height: 250px; overflow: auto;"></div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<label>Dokumen Asli</label>
				<div class="border border-primary p-3">
					<div class="form-group row">
						<label class="col-sm-6 col-form-label">Nama dokumen</label>
						<label class="col-sm-6 col-form-label" id="nmDokAsli">-</label>
					</div>
					<div class="form-group row">
						<label class="col-sm-6 col-form-label">Jumlah kata sebelum diproses</label>
						<label class="col-sm-6 col-form-label" id="jmlKataSblmProsesAsli">-</label>
					</div>
					<div class="form-group row">
						<label class="col-sm-6 col-form-label">Jumlah kata setelah diproses</label>
						<label class="col-sm-6 col-form-label" id="jmlKataStlhProsesAsli">-</label>
					</div>
					<div class="form-group row">
						<label class="col-sm-6 col-form-label">Jumlah K-gram yang ditentukan</label>
						<label class="col-sm-6 col-form-label" id="jmlKgram">-</label>
					</div>
					<div class="form-group row">
						<label class="col-sm-6 col-form-label">Persentase kemiripan</label>
						<label class="col-sm-6 col-form-label" id="perKemiripan">-</label>
					</div>
					<div class="form-group row">
						<label class="col-sm-6 col-form-label">Waktu proses</label>
						<label class="col-sm-6 col-form-label" id="wktProses">-</label>
					</div>
					<div class="form-group row">
						<label class="col-sm-6 col-form-label">Jumlah sinonim ditemukan</label>
						<label class="col-sm-6 col-form-label" id="jmlSinonimAsli">-</label>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<label>Dokumen Uji</label>
				<div class="border border-primary p-3">
					<div class="form-group row">
						<label class="col-sm-6 col-form-label">Nama dokumen</label>
						<label class="col-sm-6 col-form-label" id="nmDokUji">-</label>
					</div>
					<div class="form-group row">
						<label class="col-sm-6 col-form-label">Jumlah kata sebelum diproses</label>
						<label class="col-sm-6 col-form-label" id="jmlKataSblmProsesUji">-</label>
					</div>
					<div class="form-group row">
						<label class="col-sm-6 col-form-label">Jumlah kata setelah diproses</label>
						<label class="col-sm-6 col-form-label" id="jmlKataStlhProsesUji">-</label>
					</div>
					<div class="form-group row">
						<label class="col-sm-6 col-form-label">Jumlah sinonim ditemukan</label>
						<label class="col-sm-6 col-form-label" id="jmlSinonimUji">-</label>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		toogleView('#hasilKemiripan', true);
		toogleView('#detailKemiripan', true);
		$('#dokAsli').on('change', function (e) {
			if ($(this).val() != null) {
				$('.custom-file-label').eq(0).text(e.target.files[0].name);
			}
		});

		$('#btnStart').on('click', function () {
			$(this).prop("disabled", true);
			$(this).html("<div class='loader'></div>");
			var form_data = new FormData();
			form_data.append('kGram', '4');
			form_data.append('isSinonim', $('#sinonim').is(":checked"));
			form_data.append('files[]', $("input[type='file']")[0].files[0]);
			var ajaxTime = '';
			if ($("input[type='file']")[0].files.length === 0) {
				alert('File tidak boleh kosong');
				$('#btnStart').prop("disabled", false);
				$('#btnStart').html("Start");
			} else {
				$.ajax({
					url: "<?php echo site_url('member/Kemiripan/getRabinKarp'); ?>",
					type: "POST",
					cache: false,
					data: form_data,
					contentType: false,
					cache: false,
					processData: false,
					dataType: "json",
					beforeSend: function () {
						ajaxTime = new Date();
					},
					complete: function () {
						$('#btnStart').prop("disabled", false);
						$('#btnStart').html("Start");
						var totalTime = (new Date().getTime() - ajaxTime) / 1000;
						$('#waktuProses').text(totalTime + ' S');
					},
					success: function (json) {
						if (json[0].out === '1') {
							toogleView('#inputKemiripan', true);
							toogleView('#hasilKemiripan', false);
							var newTr = '';
							json.data.sort(function (a, b) {
								var x = a.perKemiripan.toLowerCase(), y = b.perKemiripan.toLowerCase();
								return x > y ? -1 : x < y ? 1 : 0;
							});
							$.each(json.data, function (i, v) {
								newTr += "<tr>" +
									"<input type='hidden' name='idProposal[]' value='" + v.idDokUji + "' />" +
									"<input type='hidden' name='dokUji[]' value='" + v.fileDokUji + "' />" +
									"<input type='hidden' name='dokAsli[]' value='" + v.fileDokAsli + "' />" +
									"<input type='hidden' name='persentase[]' value='" + v.wktProses + "' />" +
									"<input type='hidden' name='lamaProses[]' value='" + v.perKemiripan + "' />" +
									"<td style='cursor: pointer'>" + v.fileDokUji + "</td>" +
									"<td>" + v.wktProses + "</td>" +
									"<td>" + v.perKemiripan + "</td>" +
									"</tr>";
							});
							$('#tblHasil tbody').html('');
							$('#tblHasil tbody').append(newTr);
							$('#tblHasil tbody').on('click', 'tr', function () {
								var idx = $(this).index();
								toogleView('#hasilKemiripan', true);
								toogleView('#detailKemiripan', false);
								$('#subtitleDetail').text('Kemiripan dokumen ' + (idx + 1));
								loadDetail(json.data[idx]);
							});
						} else {
							alert(json[0].msg);
						}
					}
				});
			}
		});
		$('#btnReset').on('click', function () {
			window.location.reload();
		});
		$('#btnHasilKemiripan').on('click', function () {
			toogleView('#hasilKemiripan', true);
			toogleView('#inputKemiripan', false);
		});
		$('#btnDetailKemiripan').on('click', function () {
			toogleView('#hasilKemiripan', false);
			toogleView('#detailKemiripan', true);
		});

		$('#btnCetak').on('click', function (e) {
			e.preventDefault();
			window.location.href = $('#FormCetak').attr('action') + '?' + $('#FormCetak').serialize();
			// $.ajax({
			//    url: $('#FormCetak').attr('action'),
			//    type: "POST",
			//    cache: false,
			//    data: {toRender: $('#hasilKemiripan').html()},
			//    dataType: 'json',
			//    success: function (json) {
			//          alert(json.data.message);
			//          $('#btnCetak').html('Cetak');
			//    }
			// });
		});

	});

	function loadDetail(json) {
		$('#viewDokAsli').text(json.dokAsli);
		$('#viewDokUji').text(json.dokUji);
		$('#kGram').text(json.kGram);
		$('#jmlPatternSama').text(json.jmlPatternSama);
		$('#perKemiripan').text(json.perKemiripan);
		$('#tingkatKemiripan').text(json.tingkatKemiripan);
		$('#nmDokAsli').text(json.fileDokAsli);
		$('#jmlKataSblmProsesAsli').text(json.jmlKataSblmProsesAsli);
		$('#jmlKataStlhProsesAsli').text(json.jmlKataStlhProsesAsli);
		$('#jmlPatternAsli').text(json.jmlPatternAsli);
		$('#jmlSinonimAsli').text(json.jmlSinonimAsli);
		$('#jmlKgram').text(json.kGram);
		$('#perKemiripan').text(json.perKemiripan);
		$('#wktProses').text(json.wktProses);
		$('#jmlSinonimUji').text(json.jmlSinonimUji);

		$('#nmDokUji').text(json.fileDokUji);
		$('#jmlKataSblmProsesUji').text(json.jmlKataSblmProsesUji);
		$('#jmlKataStlhProsesUji').text(json.jmlKataStlhProsesUji);
		$('#jmlPatternUji').text(json.jmlPatternUji);
	}

	function toogleView(separator, isHide) {
		if (isHide) {
			$(separator).hide();
		} else {
			$(separator).show();
		}
	}
</script>
