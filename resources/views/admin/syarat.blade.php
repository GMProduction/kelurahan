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
                <h5>Data Syarat</h5>
                <button type="button" class="btn btn-primary btn-sm ms-auto" id="addData">Tambah Data
                </button>
            </div>


            <table class="table table-striped table-bordered ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Syarat</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($data as $v)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>
                            {{ $v->nama }}
                        </td>
                        <td style="width: 150px">
                            <button type="button" class="btn btn-success btn-sm" id="editData">Ubah</button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapus('id', 'nama') ">hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="3" class="text-center">Belum Ada Data Syarat</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
        <div>
            <!-- Modal Tambah-->
            <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Siswa</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form" method="post">
                                @csrf
                                <input id="id" name="id" hidden>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Syarat</label>
                                    <input type="text" required class="form-control" id="nama" name="nama">
                                </div>

                                <div class="mb-4"></div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
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
