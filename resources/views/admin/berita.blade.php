@extends('admin.base')

@section('title')
    Data Berita
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
                <h5>Data Berita</h5>
                <button type="button" class="btn btn-primary btn-sm ms-auto" id="addData">Tambah Data
                </button>
            </div>


            <table class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Judul</th>
                    <th>Deskripsi</th>
                    <th>Gambar</th>
                    <th>Action</th>
                </tr>
                </thead>

                <tbody>
                @forelse ($data as $v)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>
                            {{ $v->judul }}
                        </td>
                        <td>
                            {{ $v->deskripsi }}
                        </td>
                        <td>
                            <a target="_blank" href="{{ asset($v->gambar) }}">
                                <img src="{{ asset($v->gambar) }}"
                                     style="width: 75px; height: 100px; object-fit: cover"/>
                            </a>
                        </td>
                        <td style="width: 150px">
                            <button type="button" class="btn btn-success btn-sm btn-edit" id="editData"
                                    data-id="{{$v->id}}"
                                    data-nama="{{$v->nama}}"
                            >Ubah</button>
                            <button type="button" class="btn btn-danger btn-sm btn-hapus" data-id="{{ $v->id }}">hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Belum Ada Data Berita</td></tr>
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
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Syarat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form" method="post">
                                @csrf
                                <input id="id" name="id" hidden>
                                <div class="mb-3">
                                    <label for="judul" class="form-label">Judul Berita</label>
                                    <input type="text" required class="form-control" id="judul" name="judul">
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsi" rows="3" name="deskripsi"></textarea>
                                </div>
                                <div class="mt-3 mb-2">
                                    <label for="gambar" class="form-label">Gambar</label>
                                    <input class="form-control" type="file" id="gambar" name="gambar">
                                </div>

                                <div class="mb-4"></div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Syarat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form-edit" method="post" action="/admin/syarat/patch">
                                @csrf
                                <input id="id-edit" name="id-edit" hidden>
                                <div class="mb-3">
                                    <label for="nama-edit" class="form-label">Nama Syarat</label>
                                    <input type="text" required class="form-control" id="nama-edit" name="nama-edit">
                                </div>

                                <div class="mb-4"></div>
                                <button type="submit" class="btn btn-primary btn-edit-save">Simpan</button>
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
            $('.btn-edit').on('click', function () {
                let id = this.dataset.id;
                let nama = this.dataset.nama;
                $('#id-edit').val(id);
                $('#nama-edit').val(nama);
                $('#modal-edit').modal('show')
            });

            $('.btn-hapus').on('click', function () {
                let id = this.dataset.id;
                hapus(id);
            })
        });

        $(document).on('click', '#addData', function() {
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

        async function destroy(id) {
            try {
                let response = await $.post('/admin/syarat/delete', {
                    _token: '{{ csrf_token() }}',
                    id: id
                });
                swal("Berhasil Menghapus data!", {
                    icon: "success",
                });
                window.location.reload();
                console.log(response)
            }catch(e) {
                console.log(e);
                alert('gagal')
            }
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
                        destroy(id);
                    } else {
                        swal("Data belum terhapus");
                    }
                });
        }
    </script>

@endsection
