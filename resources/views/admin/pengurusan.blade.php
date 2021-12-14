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
                <tbody>
                @forelse($data as $v)
                    <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $v->user->warga->nama }}</td>
                        <td>{{ $v->surat->nama }}</td>
                        <td>{{ ucfirst($v->status) }}</td>
                        <td>
                            <a target="_blank" href="{{ asset($v->user->warga->ktp) }}">
                                <img src="{{ asset($v->user->warga->ktp) }}"
                                     style="width: 75px; height: 100px; object-fit: cover"/>
                            </a>
                        </td>
                        <td style="width: 200px">
                            <button type="button" class="btn btn-success btn-sm mt-1 btn-cek" data-id="{{ $v->id }}">Cek
                                Syarat
                            </button>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm mt-1 dropdown-toggle" type="button"
                                        id="dropdownMenuButton1"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    Ubah Status
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                    <a class="dropdown-item btn-status" data-value="menunggu" href="#">Menunggu</a>
                                    <a class="dropdown-item btn-status" data-value="diterima" href="#">Diterima</a>
                                    <a class="dropdown-item btn-status" data-value="ditolak" href="#">Ditolak</a>
                                    <a class="dropdown-item btn-status" data-value="diambil" href="#">Diambil</a>
                                </ul>
                            </div>

                            <button type="button" class="btn btn-danger btn-sm mt-1"
                                    onclick="hapus('id', 'nama') ">hapus
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">Belum Ada Pengurusan Surat</td>
                    </tr>
                @endforelse
                </tbody>
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
                                <table class="table table-striped table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Syarat</th>
                                        <th>Gambar</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tb-kelengkapan">

                                    </tbody>
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

        function createKelengkapan(syarat, k, clear, status) {
            let element = '<p>' + status + '</p>';
            if (clear) {
                element = '<a target="_blank" href="' + status + '">' +
                    '<img src="' + status + '" style="width: 150px; height: 100px; object-fit: cover"/>' +
                    '</a>'
            }
            return '<tr>' +
                '<td>' + (k + 1) + '</td>' +
                '<td>' + syarat['nama'] + '</td>' +
                '<td>' + element + '</td>' +
                '</tr>';
        }

        async function getSyarats(id) {
            try {
                let el = $('#tb-kelengkapan');
                let response = await $.get('/admin/pengurusan/syarat?id=' + id);
                let syarat = response['payload']['surat']['syarat'];
                let kelengkapan = response['payload']['syarat'];

                el.empty();
                $.each(syarat, function (k, v) {
                    let item = kelengkapan.find(i => i['syarat_id'] === v.id);
                    let clear = false;
                    let status = 'Belum Mengumpulkan';
                    if (item !== undefined) {
                        clear = true;
                        if(item['foto'] !== null) {
                            status = item['foto'];
                        }else {
                            status = '/image/no-foto.png'
                        }
                    }
                    el.append(createKelengkapan(v, k, clear, status))
                });
                console.log(response);
                $('#modal').modal('show');
            } catch (e) {
                console.log(e)
                alert('Gagal Memuat Syarat');
            }
        }

        $(document).ready(function () {
            $('.btn-cek').on('click', function () {
                getSyarats(this.dataset.id);
            })
        });

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
