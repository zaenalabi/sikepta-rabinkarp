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

<div class="row">
	<div class="col-md-12">
		<div class="card">
			<div class="card-title">
				<h4>Dokumen Uji</h4>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<label>Input Dokumen</label>
						<div class="border border-primary p-3">
							<?php echo form_open("admin/kemiripan/tambah", array('enctype' => 'multipart/form-data')); ?>
							<div class="form-group">
								<label>Dokumen Untuk Pengujian</label>
								<div class="input-group mb-3">
									<div class="custom-file">
										<input type="file" name="file" class="custom-file-input" id="dokUji">
										<label class="custom-file-label">Pilih Dokumen Uji</label>
									</div>
								</div>
							</div>
							<div class="form-group">
								<button id="btnSimpan" type="button" class="btn btn-primary">Simpan</button>
							</div>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-12">
		<div class="card strpied-tabled-with-hover">
			<div class="card-header ">
				<h4 class="card-title">Data Dokumen</h4>
				<p class="card-category">Data dokumen pengujian</p>
			</div>
			<div class="table-wrapper-scroll-y my-custom-scrollbar">
				<table class="table table-hover table-striped mb-0" id="tblDokumen">
					<thead>
					<th>NO</th>
					<th>Judul</th>
					<th>Waktu Upload</th>
					<th>Opsi</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {
		loadData();

		$('#dokUji').on('change', function (e) {
			if ($(this).val() != null) {
				$('.custom-file-label').eq(0).text(e.target.files[0].name);
			}
		});

		$('#btnSimpan').on('click', function () {
			$(this).prop("disabled", true);
			$(this).html("<div class='loader'></div>");
			var form_data = new FormData();
			form_data.append('files[]', $("input[type='file']")[0].files[0]);
			$.ajax({
				url: "<?php echo site_url('admin/Kemiripan/tambah'); ?>",
				type: "POST",
				cache: false,
				data: form_data,
				contentType: false,
				cache: false,
				processData: false,
				dataType: "json",
				complete: function () {
					$('#btnSimpan').prop("disabled", false);
					$('#btnSimpan').html("Simpan");
				},
				success: function (json) {
					alert(json.data.message);
					loadData();
				}
			});
		});

		$(document).on('click', '#YesDelete', function (e) {
			e.preventDefault();
			$('#ModalMe').modal('hide');
			$.ajax({
				url: $(this).data('url'),
				type: "POST",
				cache: false,
				dataType: 'json',
				success: function (json) {
					$('input[name="idSinonim"]').val('');
					$('input[name="kata"]').val('');
					$('input[name="artikata"]').val('');
					alert(json.data.message);
					loadData();
					$('#btnTambah').html('Simpan');
				}
			});
		});

	});

	function loadData() {
		$.ajax({
			url: "<?php echo site_url('admin/dokumen/getDokumen'); ?>",
			type: "GET",
			contentType: false,
			cache: false,
			dataType: "json",
			success: function (json) {
				var newTr = '';
				$.each(json, function (i, v) {
					newTr += "<tr>" +
						"<td>" + (i + 1) + "</td>" +
						"<td>" + v.judul + "</td>" +
						"<td>" + v.waktu_upload + "</td>" +
						"<td><button class='btn btn-sm btn-danger' name='btnHapus'> Hapus</button></td>" +
						"</tr>";
				});
				$('#tblDokumen tbody').html('');
				$('#tblDokumen tbody').append(newTr);
				$('#tblDokumen tbody').on('click', 'button[name="btnHapus"]', function (e) {
					e.preventDefault();
					var idx = $(this).index('button[name="btnHapus"]');
					var Link = 'Dokumen/hapus_dokumen/' + json[idx].id_proposal + '/' + json[idx].judul;
					$('.modal-dialog').removeClass('modal-lg');
					$('.modal-dialog').addClass('modal-md');
					$('#ModalHeader').html('Konfirmasi');
					$('#ModalContent').html('Apakah anda yakin ingin menghapus data kode <b>' + json[idx].judul.substr(0,50) + '...</b> ?');
					$('#ModalFooter').html("<button type='button' class='btn btn-sm btn-primary' id='YesDelete' data-url='" + Link + "'>Ya, saya yakin</button><button type='button' class='btn btn-sm btn-outline-success' data-dismiss='modal'>Batal</button>");
					$('#ModalMe').modal('show');
				});
			}
		});
	}
</script>
