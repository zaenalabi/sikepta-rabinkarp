<div class="row">
	 <div class="col-md-12">
	<!--	<div class="card">
			<div class="card-title">
				<h4>Input Sinonim</h4>
			</div>
			<div class="card-body">
				<div class="row">
					<div class="col-md-12">
						<?php echo form_open("admin/Sinonim/tambah_sinonim", array('id' => 'FormTambah')); ?>
						<input type="hidden" name="idSinonim">
						<div class="form-group">
							<label>Kata</label>
							<input type="text" name="kata" class="form-control">
						</div>
						<div class="form-group">
							<label>Artikata</label>
							<input type="text" name="artikata" class="form-control">
						</div>
						<div class="form-group">
							<button id="btnTambah" type="button" class="btn btn-primary">Simpan</button>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div> -->
		<button class='btn btn-sm btn-primary' name='btnTambah' data-toggle="modal" data-target="#myModal">Tambah Sinonim</button><br/><br/>
	</div>


</div>
<div class="row">
	<div class="col-md-12">
		<div class="card strpied-tabled-with-hover">
			<div class="card-header ">
				<h4 class="card-title">Data Sinonim</h4>
			</div>
			<div class="card-body table-full-width table-responsive">
				<table class="table table-hover table-striped" id="tblData">
					<thead>
					<th>NO</th>
					<th>Kata</th>
					<th>Artikata</th>
					<th>Opsi</th>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>

	<!-- Modal Tambah -->
	<div id="myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			<!-- konten modal-->
			<div class="modal-content">
				<!-- heading modal -->
				<div class="modal-header">
					<strong>Form Input</strong>
				</div>
				<!-- body modal -->
				<div class="modal-body">
					<div class="col-md-12">
						<?php echo form_open("admin/Sinonim/tambah_sinonim", array('id' => 'FormTambah')); ?>
						<input type="hidden" name="idSinonim">
						<div class="form-group">
							<label>Kata</label>
							<input type="text" name="kata" class="form-control">
						</div>
						<div class="form-group">
							<label>Artikata</label>
							<input type="text" name="artikata" class="form-control">
						</div>
						<div class="form-group">
							<button id="btnTambah" type="button" class="btn btn-primary" >Simpan</button>
							<button id="btnBatal" type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
				<!-- footer modal -->
				
			</div>
		</div>
	</div>


<script type="text/javascript">
	$(document).ready(function () {
		loadData();

		$('#btnTambah').on('click', function (e) {
			e.preventDefault();
			if ($('#FormTambah').serialize() !== '') {
				$.ajax({
					url: $('input[name="idSinonim"]').val() === '' ? $('#FormTambah').attr('action') : 'Sinonim/update_sinonim/' + $('input[name="idSinonim"]').val(),
					type: "POST",
					cache: false,
					data: $('#FormTambah').serialize(),
					dataType: 'json',
					beforeSend: function () {
						$('#btnTambah').html("Menyimpan Data ...");
					},
					success: function (json) {
						$('input[name="idSinonim"]').val('');
						$('input[name="kata"]').val('');
						$('input[name="artikata"]').val('');
						$('#myModal').modal('hide');
						alert(json.data.message);
						loadData();
						$('#btnTambah').html('Simpan');
					}
				});
			}
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
			url: "<?php echo site_url('admin/Sinonim/list_sinonim'); ?>",
			type: "GET",
			contentType: false,
			cache: false,
			dataType: "json",
			success: function (json) {
				var newTr = '';
				$.each(json.data, function (i, v) {
					newTr += "<tr>" +
						"<td>" + (i + 1) + "</td>" +
						"<td>" + v.kata + "</td>" +
						"<td>" + v.artikata + "</td>" +
						"<td><button class='btn btn-sm btn-primary' name='btnEdit' data-toggle='modal' data-target='#myModal'>Edit </button>&nbsp;<button class='btn btn-sm btn-danger' name='btnHapus'> Hapus</button></td>" +
						"</tr>";
				});
				$('#tblData tbody').html('');
				$('#tblData tbody').append(newTr);
				$('#tblData tbody').on('click', 'button[name="btnEdit"] , button[name="btnHapus"]', function (e) {
					e.preventDefault();
					if ($(this).attr('name') == 'btnEdit') {
						var idx = $(this).index('button[name="btnEdit"]');
						$('input[name="idSinonim"]').val(json.data[idx].id_sinonim);
						$('input[name="kata"]').val(json.data[idx].kata);
						$('input[name="artikata"]').val(json.data[idx].artikata);
					}
					if ($(this).attr('name') == 'btnHapus') {
						var idx = $(this).index('button[name="btnHapus"]');
						var Link = 'Sinonim/hapus_sinonim/' + json.data[idx].id_sinonim;
						$('.modal-dialog').removeClass('modal-lg');
						$('.modal-dialog').addClass('modal-sm');
						$('#ModalHeader').html('Konfirmasi');
						$('#ModalContent').html('Apakah anda yakin ingin menghapus data kode <b>' + json.data[idx].kata + '</b> ?');
						$('#ModalFooter').html("<button type='button' class='btn btn-sm btn-primary' id='YesDelete' data-url='" + Link + "'>Ya, saya yakin</button><button type='button' class='btn btn-sm btn-outline-success' data-dismiss='modal'>Batal</button>");
						$('#ModalMe').modal('show');
					}
				});
			}
		});
	}
</script>
