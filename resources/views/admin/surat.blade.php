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

    <style>
        .form-check .form-check-input {
            float: none;
        }

        .my-container input {
            padding: 0;
        }

    </style>
    <section class="m-2">
        <div class="table-container">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5>Data Surat</h5>
                <button type="button" class="btn btn-primary btn-sm ms-auto" id="addData">Tambah Data
                </button>
            </div>
            <table class="table table-striped table-bordered ">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Surat</th>
                    <th>Syarat</th>
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
                        @php
                            $syarat = '';
                            foreach ($v->syarat as $s) {
                                $syarat .= $s->nama.', ';
                            }
                        @endphp
                        <td>
                            {{ count($v->syarat) > 0 ? $syarat : '-' }}
                        </td>

                        <td style="width: 150px">
                            <button type="button" class="btn btn-success btn-sm btn-edit" data-id="{{$v->id}}" data-nama="{{ $v->nama }}">Ubah
                            </button>
                            <button type="button" class="btn btn-danger btn-sm btn-hapus" data-id="{{$v->id}}">hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <p>No users</p>
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
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Surat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form" action="/admin/surat" method="post">
                                @csrf
                                <input id="id" name="id" hidden>
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Surat</label>
                                    <input type="text" required class="form-control" id="nama" name="nama">
                                </div>

                                <p class="fw-bold mb-0">Syarat-syarat</p>
                                @foreach($syarats as $v)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $v->id }}"
                                               id="flexCheckDefault-{{$loop->index}}" name="syarats[]">
                                        <label class="form-check-label" for="flexCheckDefault-{{$loop->index}}">
                                            {{ $v->nama }}
                                        </label>
                                    </div>
                                @endforeach
                                <div class="mb-4"></div>
                                <button type="submit" class="btn btn-primary btn-add-surat">Simpan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <div class="modal fade" id="modal-edit" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Surat</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="form" action="/admin/surat/patch" method="post">
                                @csrf
                                <input id="id-edit" name="id-edit" hidden>
                                <div class="mb-3">
                                    <label for="nama-edit" class="form-label">Nama Surat</label>
                                    <input type="text" required class="form-control" id="nama-edit" name="nama-edit">
                                </div>
                                <p class="fw-bold mb-0">Syarat-syarat</p>
                                @foreach($syarats as $v)
                                    <div class="form-check">
                                        <input class="form-check-input syarats-edit" type="checkbox"
                                               value="{{ $v->id }}"
                                               id="syarat-{{$v->id}}" name="syarats-edit[]">
                                        <label class="form-check-label" for="syarat-{{$v->id}}">
                                            {{ $v->nama }}
                                        </label>
                                    </div>
                                @endforeach
                                <div class="mb-4"></div>
                                <button type="submit" class="btn btn-primary btn-add-surat">Simpan</button>
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

        $(document).ready(function () {

            $('.btn-edit').on('click', function () {
                getSyarat(this.dataset.id, this.dataset.nama);
            })

            $('.btn-hapus').on('click', function () {
                let id = this.dataset.id;
                hapus(id);
            })
        });

        function setChecked(data) {
            let checkbox = $(".syarats-edit").map(function () {
                return $(this).attr('id');
            }).get();
            $('.syarats-edit').attr('checked', false);
            $.each(checkbox, function (k, v) {
                let tmpID = v.substring(7, v.length);
                let item = data.find(i => i.id === parseInt(tmpID));
                if (item !== undefined) {
                    $('#' + v).attr('checked', true);
                }
                console.log(item);
            });
            console.log(checkbox);
        }

        async function getSyarat(id, nama) {
            try {
                $('#id-edit').val(id);
                $('#nama-edit').val(nama);
                let response = await $.get('/admin/surat/syarat?id=' + id);
                let syarat = response['payload']['syarat'];
                console.log(syarat);
                setChecked(syarat);
                $('#modal-edit').modal('show');
            } catch (e) {
                alert('Gagal Mengambil Data Surat')
            }
        }

        $(document).on('click', '#editData, #addData', function () {
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
                let response = await $.post('/admin/surat/delete', {
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
