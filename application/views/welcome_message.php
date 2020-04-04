<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
	<title>Hello, world!</title>
</head>

<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12 mt-5">
				<h1 class="text-center"> CodeIgniter AJAX CRUD</h1>
				<hr style="background-color: black; color: black; height: 1px">
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 mt-2">
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-outline-primary btn-sm" data-toggle="modal" data-target="#exampleModal">
					<i class="fas fa-plus"></i>
				</button>

				<!-- Insert Modal -->
				<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Add Data</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<form action="post" method="post" id="form" enctype="multipart/form-data">
									<div class="form-group">
										<label for="name">Name</label>
										<input type="text" id="name" class="form-control">
									</div>
									<div class="form-group">
										<label for="email">Email</label>
										<input type="text" id="email" class="form-control">
									</div>
									<div class="form-group">
										<label for="gambar">Gambar</label>
										<input type="file" id="gambar" name="gambar" class="form-control" required>
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-primary" id="add">Add</button>
							</div>
						</div>
					</div>
				</div>
				<!-- Edit Modal -->
				<div class="modal fade" id="exampleModaledit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Edit Data </h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">

								<form action="post" method="post" id="edit_form">
									<input type="hidden" id="edit_id" value="">
									<div class="form-group">
										<label for="edit_name">Name</label>
										<input type="text" id="edit_name" class="form-control">
									</div>
									<div class="form-group">
										<label for="edit_email">Email</label>
										<input type="text" id="edit_email" class="form-control">
									</div>
								</form>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="button" class="btn btn-primary" id="update">Update</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12 mt-3">
				<table class="table">
					<thead>
						<tr>
							<th>ID</th>
							<th>Name</th>
							<th>Email</th>
							<th>Gambar</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody id="tbody">

					</tbody>
				</table>
			</div>
		</div>
	</div>

	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->

	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
	<script>
		$(document).on("click", "#add", function(e) {
			e.preventDefault();
			var fd = new FormData();
			var name = $('#name').val();
			var email = $('#email').val();
			var file = $('#gambar')[0].files[0];
			fd.append('gambar', file);
			fd.append('name', name);
			fd.append('email', email);
			$.ajax({
				url: "<?= base_url() ?>insert",
				type: "post",
				dataType: "json",
				data: fd,
				contentType: false,
				processData: false,
				// async: false,
				cache: false,
				success: function(data) {
					getAll();
					if (data.response == "success") {
						toastr["success"](data.message)
						toastr.options = {
							"closeButton": true,
							"debug": false,
							"newestOnTop": false,
							"progressBar": true,
							"positionClass": "toast-top-right",
							"preventDuplicates": false,
							"onclick": null,
							"showDuration": "300",
							"hideDuration": "1000",
							"timeOut": "5000",
							"extendedTimeOut": "1000",
							"showEasing": "swing",
							"hideEasing": "linear",
							"showMethod": "fadeIn",
							"hideMethod": "fadeOut"
						}
					} else {
						toastr["error"](data.message)
						toastr.options = {
							"closeButton": true,
							"debug": false,
							"newestOnTop": false,
							"progressBar": true,
							"positionClass": "toast-top-right",
							"preventDuplicates": false,
							"onclick": null,
							"showDuration": "300",
							"hideDuration": "1000",
							"timeOut": "5000",
							"extendedTimeOut": "1000",
							"showEasing": "swing",
							"hideEasing": "linear",
							"showMethod": "fadeIn",
							"hideMethod": "fadeOut"
						}
					}
					$("#exampleModal").modal('hide');

				}
			});
			$("#form")[0].reset();
		});

		function getAll() {
			$.ajax({
				url: "<?= base_url(); ?>getall",
				type: "get",
				dataType: "json",
				success: function(data) {
					var i = 1;
					var tbody = "";

					for (var key in data) {
						tbody += "<tr>";
						tbody += "<td>" + i++ + "</td>";
						tbody += "<td>" + data[key].nama + "</td>";
						tbody += "<td>" + data[key].email + "</td>";
						tbody += `<td> <img src="<?= base_url('upload/') ?>${data[key].gambar}" alt="" height="50px"  width="50px" ></td>`;
						tbody += `<td>
										<a href="#" id="edit" class="btn btn-sm btn-outline-info" value="${data[key]['id']}"><i class="fas fa-edit"></i></a>
										<a href="#" id="del" class="btn btn-sm btn-outline-danger" value="${data[key]['id']}"><i class="fas fa-trash-alt"></i></a>
							
									</td>`;
						tbody += "</tr>";
						$('#tbody').html(tbody);
					}
				}
			});
		}
		getAll();

		$(document).on("click", "#del", function(e) {
			e.preventDefault();
			var del_id = $(this).attr("value");
			if (del_id == "") {
				alert("delete Id required");
			} else {
				const swalWithBootstrapButtons = Swal.mixin({
					customClass: {
						confirmButton: 'btn btn-success',
						cancelButton: 'btn btn-danger mr-2'
					},
					buttonsStyling: false
				})

				swalWithBootstrapButtons.fire({
					title: 'Are you sure?',
					text: "You won't be able to revert this!",
					icon: 'warning',
					showCancelButton: true,
					confirmButtonText: 'Yes, delete it!',
					cancelButtonText: 'No, cancel!',
					reverseButtons: true
				}).then((result) => {
					if (result.value) {
						$.ajax({
							url: "<?= base_url(); ?>delete",
							type: "post",
							dataType: "json",
							data: {
								del_id: del_id
							},
							success: function(data) {

								if (data.response == "success") {
									swalWithBootstrapButtons.fire(
										'Deleted!',
										'Your file has been deleted.',
										'success'
									)
								}
								getAll();
							}
						});

					} else if (
						/* Read more about handling dismissals below */
						result.dismiss === Swal.DismissReason.cancel
					) {
						swalWithBootstrapButtons.fire(
							'Cancelled',
							'Your imaginary file is safe :)',
							'error'
						)
					}
				});
			}

		});

		$(document).on("click", "#edit", function(e) {
			var edit_id = $(this).attr("value");
			if (edit_id == "") {
				alert("Edit Id Required");
			} else {
				$.ajax({
					url: "<?= base_url(); ?>edit",
					type: "post",
					dataType: "json",
					data: {
						edit_id: edit_id
					},
					success: function(data) {
						if (data.response == "success") {
							$("#exampleModaledit").modal('show');
							$("#edit_id").val(data.post.id);
							$("#edit_name").val(data.post.nama);
							$("#edit_email").val(data.post.email);
						} else {
							toastr["error"](data.message)
							toastr.options = {
								"closeButton": true,
								"debug": false,
								"newestOnTop": false,
								"progressBar": true,
								"positionClass": "toast-top-right",
								"preventDuplicates": false,
								"onclick": null,
								"showDuration": "300",
								"hideDuration": "1000",
								"timeOut": "5000",
								"extendedTimeOut": "1000",
								"showEasing": "swing",
								"hideEasing": "linear",
								"showMethod": "fadeIn",
								"hideMethod": "fadeOut"
							}
						}
					}
				})
			}
		})

		$(document).on("click", "#update", function(e) {
			e.preventDefault();

			var edit_id = $("#edit_id").val();
			var edit_name = $("#edit_name").val();
			var edit_email = $("#edit_email").val();

			if (edit_id == "" || edit_name == "" || edit_email == "") {
				alert("All field is Required");
			} else {
				$.ajax({
					url: "<?= base_url(); ?>update",
					type: "post",
					dataType: "json",
					data: {
						edit_id: edit_id,
						edit_name: edit_name,
						edit_email: edit_email
					},
					success: function(data) {
						getAll();
						if (data.response == "success") {
							$("#exampleModaledit").modal('hide');
							toastr["success"](data.message)
							toastr.options = {
								"closeButton": true,
								"debug": false,
								"newestOnTop": false,
								"progressBar": true,
								"positionClass": "toast-top-right",
								"preventDuplicates": false,
								"onclick": null,
								"showDuration": "300",
								"hideDuration": "1000",
								"timeOut": "5000",
								"extendedTimeOut": "1000",
								"showEasing": "swing",
								"hideEasing": "linear",
								"showMethod": "fadeIn",
								"hideMethod": "fadeOut"
							}
						} else {
							toastr["error"](data.message)
							toastr.options = {
								"closeButton": true,
								"debug": false,
								"newestOnTop": false,
								"progressBar": true,
								"positionClass": "toast-top-right",
								"preventDuplicates": false,
								"onclick": null,
								"showDuration": "300",
								"hideDuration": "1000",
								"timeOut": "5000",
								"extendedTimeOut": "1000",
								"showEasing": "swing",
								"hideEasing": "linear",
								"showMethod": "fadeIn",
								"hideMethod": "fadeOut"
							}

						}
					}
				})
			}
		})
	</script>
</body>

</html>