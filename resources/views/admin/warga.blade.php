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
                <h5>Data User</h5>
                <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                        data-bs-target="#tambahsiswa">Tambah Data
                </button>
            </div>


            <table class="table table-striped table-bordered">
                <thead>
                <th>
                    #
                </th>
                <th>
                    Nama
                </th>
                <th>
                    Alamat
                </th>
                <th>
                    No Hp
                </th>

                <th>
                    KTP
                </th>

                <th>
                    Foto
                </th>

                <th>
                    Action
                </th>

                </thead>
                <tbody>
                @foreach($data as $v)
                    <tr>
                        <td>
                            {{ $loop->index + 1 }}
                        </td>
                        <td>
                            {{ $v->nama }}
                        </td>
                        <td>
                            {{ $v->alamat }}
                        </td>
                        <td>
                            {{ $v->no_hp }}
                        </td>
                        <td>
                            <a target="_blank" href="{{ asset($v->ktp) }}">
                                <img src="{{ asset($v->ktp) }}"
                                     style="width: 75px; height: 100px; object-fit: cover"/>
                            </a>
                        </td>

                        <td>
                            <a target="_blank" href="{{ asset($v->foto) }}">
                                <img src="{{ asset($v->foto) }}"
                                     style="width: 75px; height: 100px; object-fit: cover"/>
                            </a>
                        </td>
                        <td style="width: 150px">
                            <button type="button" class="btn btn-success btn-sm btn-edit" data-bs-toggle="modal"
                                    data-bs-target="#editwarga"
                                    data-id="{{ $v->id }}"
                                    data-nama="{{ $v->nama }}"
                                    data-alamat="{{ $v->alamat }}"
                                    data-nohp="{{ $v->no_hp }}"
                                    data-username="{{ $v->user->username }}"
                            >Ubah
                            </button>
                            <button type="button" class="btn btn-danger btn-sm btn-delete" data-id="{{ $v->id }}">hapus
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

        </div>


        <div>
            <!-- Modal Tambah-->
            <div class="modal fade" id="tambahsiswa" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Data Warga</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="/admin/warga" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" required class="form-control" id="nama" name="nama">
                                </div>

                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea class="form-control" id="alamat" rows="3" name="alamat"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="nphp" class="form-label">no. Hp</label>
                                    <input type="number" required class="form-control" id="nphp" name="no_hp">
                                </div>

                                <div class="mt-3 mb-2">
                                    <label for="ktp" class="form-label">KTP</label>
                                    <input class="form-control" type="file" id="ktp" name="ktp">
                                </div>

                                <div class="mt-3 mb-2">
                                    <label for="foto" class="form-label">Foto</label>
                                    <input class="form-control" type="file" id="foto" name="foto">
                                </div>

                                <hr>

                                <div class="mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" required class="form-control" id="username" name="username">
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="password" required class="form-control" id="password" name="password">
                                </div>

{{--                                <div class="mb-3">--}}
{{--                                    <label for="password-confirmation" class="form-label">Konfirmasi Password</label>--}}
{{--                                    <input type="password" required class="form-control" id="password-confirmation" name="nama">--}}
{{--                                </div>--}}


                                <div class="mb-4"></div>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="editwarga" tabindex="-1" aria-labelledby="exampleModalLabel"
                 aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ubah Data Warga</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="/admin/warga/patch" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" id="id-edit" name="id-edit" value="">
                                <div class="mb-3">
                                    <label for="nama-edit" class="form-label">Nama</label>
                                    <input type="text" required class="form-control" id="nama-edit" name="nama-edit">
                                </div>

                                <div class="form-group">
                                    <label for="alamat-edit">Alamat</label>
                                    <textarea class="form-control" id="alamat-edit" rows="3" name="alamat-edit"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="no_hp-edit" class="form-label">no. Hp</label>
                                    <input type="number" required class="form-control" id="no_hp-edit" name="no_hp-edit">
                                </div>

                                <div class="mt-3 mb-2">
                                    <label for="ktp-edit" class="form-label">KTP</label>
                                    <input class="form-control" type="file" id="ktp-edit" name="ktp-edit">
                                </div>

                                <div class="mt-3 mb-2">
                                    <label for="foto-edit" class="form-label">Foto</label>
                                    <input class="form-control" type="file" id="foto-edit" name="foto-edit">
                                </div>

                                <hr>

                                <div class="mb-3">
                                    <label for="username-edit" class="form-label">Username</label>
                                    <input type="text" required class="form-control" id="username-edit" name="username-edit">
                                </div>

                                <div class="mb-3">
                                    <label for="password-edit" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="password-edit" name="password-edit">
                                </div>

                                {{--                                <div class="mb-3">--}}
                                {{--                                    <label for="password-confirmation" class="form-label">Konfirmasi Password</label>--}}
                                {{--                                    <input type="password" required class="form-control" id="password-confirmation" name="nama">--}}
                                {{--                                </div>--}}


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
        $(document).ready(function () {
            $('.btn-delete').on('click', function () {
                let id = this.dataset.id;
                hapus(id);
            })
        });

        $(document).on('click', '.btn-edit', function() {
            $('#editwarga #id-edit').val($(this).data('id'))
            $('#editwarga #nama-edit').val($(this).data('nama'))
            $('#editwarga #no_hp-edit').val($(this).data('nohp'))
            $('#editwarga #alamat-edit').val($(this).data('alamat'))
            $('#editwarga #username-edit').val($(this).data('username'))
            $('#editwarga #password').val('')
            $('#editwarga').modal('show')
        });

        async function destroy(id) {
            try {
                let response = await $.post('/admin/warga/delete', {
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
