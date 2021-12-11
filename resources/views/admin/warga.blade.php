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
                <button type="button ms-auto" class="btn btn-primary btn-sm" data-bs-toggle="modal"
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
                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#tambahsiswa">Ubah
                            </button>
                            <button type="button" class="btn btn-danger btn-sm" onclick="hapus('id', 'nama') ">hapus
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

        </div>

    </section>

@endsection

@section('script')
    <script>
        $(document).ready(function () {

        })

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
