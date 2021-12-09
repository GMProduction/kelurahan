@extends('admin.base')

@section('title')
    Data Siswa
@endsection

@section('content')

    @if (\Illuminate\Support\Facades\Session::has('success'))
        <script>
            swal("Berhasil!", "Berhasil Menambah data!", "success");
        </script>
    @endif

    <section class="m-2">


        <div class="table-container">


            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Pengurusan Surat</h5>
                {{-- <button type="button" class="btn btn-primary btn-sm ms-auto" id="addData">Tambah Data --}}
                </button>
            </div>


            <table class="table table-striped table-bordered ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Warga</th>
                        <th>Surat</th>
                        <th>Status</th>
                        <th>Foto Ktp</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tr>
                    <td>1</td>
                    <td>Andi</td>
                    <td>Surat Kematian</td>
                    <td>Diambil</td>

                    <td>
                        <a target="_blank" href="https://portal.bone.go.id/wp-content/uploads/2019/08/ktp.jpeg">
                            <img src="https://portal.bone.go.id/wp-content/uploads/2019/08/ktp.jpeg"
                                style="width: 75px; height: 100px; object-fit: cover" />
                        </a>
                    </td>
                    <td style="width: 200px">
                        <button type="button" class="btn btn-success btn-sm mt-1" id="editData">Cek Syarat</button>

                        <div class="dropdown">
                            <button class="btn btn-primary btn-sm mt-1 dropdown-toggle" type="button" id="dropdownMenuButton1"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                Ubah Status
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <a class="dropdown-item" href="#">Menunggu</a>
                                <a class="dropdown-item" href="#">Diterima</a>
                                <a class="dropdown-item" href="#">Ditolak</a>
                                <a class="dropdown-item" href="#">Diambil</a>
                            </ul>
                        </div>

                        <button type="button" class="btn btn-danger btn-sm mt-1"
                            onclick="hapus('id', 'nama') ">hapus</button>
                    </td>
                </tr>


            </table>

        </div>


        <div>


            <!-- Modal Tambah-->
            <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Cek Kelengkapan Syarat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form" onsubmit="return save()">
                                @csrf
                                <input id="id" name="id" hidden>
                                <table class="table table-striped table-bordered ">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Syarat</th>
                                            <th>Gambar</th>
                                        </tr>
                                    </thead>

                                    <tr>
                                        <td>1</td>
                                        <td>KTP (meninggal)</td>

                                        <td>
                                            <a target="_blank"
                                                href="https://portal.bone.go.id/wp-content/uploads/2019/08/ktp.jpeg">
                                                <img src="https://portal.bone.go.id/wp-content/uploads/2019/08/ktp.jpeg"
                                                    style="width: 150px; height: 100px; object-fit: cover" />
                                            </a>
                                        </td>
                                    </tr>


                                </table>
                                <div class="mb-4"></div>
                                <div class="d-flex">
                                    <a class="btn btn-primary">Terima</a>
                                    <a class="btn btn-danger ms-2">Tolak</a>
                                    <a class="btn btn-success ms-auto">Whatsapp Pemohon</a>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </section>

@endsection

@section('script')
    <script>
        $(document).ready(function() {

        })

        $(document).on('click', '#editData, #addData', function() {
            $('#modal #id').val($(this).data('id'))
            $('#modal #nama').val($(this).data('nama'))
            $('#modal #nphp').val($(this).data('hp'))
            $('#modal #alamat').val($(this).data('alamat'))
            $('#modal #no_ktp').val($(this).data('ktp'))
            $('#modal #username').val($(this).data('username'))
            $('#modal #password').val('')
            $('#modal #password-confirmation').val('')
            $('#showFoto').empty();
            if ($(this).data('id')) {
                $('#modal #password').val('**********')
                $('#modal #password-confirmation').val('**********')
            }
            if ($(this).data('foto')) {
                $('#showFoto').html('<img src="' + $(this).data('foto') + '" height="50">')
            }
            $('#modal').modal('show')
        })

        function save() {
            saveData('Simpan Data', 'form');
            return false;
        }

        function after() {

        }

        function hapus(id, name) {
            swal({
                    title: "Menghapus data?",
                    text: "Apa kamu yakin, ingin menghapus data ?!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Berhasil Menghapus data!", {
                            icon: "success",
                        });
                    } else {
                        swal("Data belum terhapus");
                    }
                });
        }
    </script>

@endsection
