<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Data Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body class="bg-light">
    <main class="container">
        <!-- START FORM -->
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $item)
                        <p class="m-0">{{ $item }}</p>
                    @endforeach
                </div>
            @endif
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            <form action='' method='post'>
                @csrf

                @if (Route::current()->uri == 'buku/{id}')
                    @method('PUT')
                @endif

                <div class="mb-3 row">
                    <label for="judul" class="col-sm-2 col-form-label">Judul Buku</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{ isset($data['judul']) ? $data['judul'] : old('judul') }}" class="form-control" name='judul' id="judul">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="nama" class="col-sm-2 col-form-label">Pengarang</label>
                    <div class="col-sm-10">
                        <input type="text" value="{{ isset($data['pengarang']) ? $data['pengarang'] : old('pengarang') }}" class="form-control" name='pengarang' id="pengarang">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="tanggal_publikasi" class="col-sm-2 col-form-label">Tanggal Publikasi</label>
                    <div class="col-sm-10">
                        <input type="date" value="{{ isset($data['tanggal_publikasi']) ? $data['tanggal_publikasi'] : old('tanggal_publikasi') }}" class="form-control w-50" name='tanggal_publikasi' id="tanggal_publikasi">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label"></label>
                    <div class="col-sm-10"><button type="submit" class="btn btn-primary" name="submit">{{ (Route::current()->uri == 'buku') ? 'SIMPAN' : 'PERBARUI' }}</button>
                    </div>
                </div>
            </form>
        </div>
        <!-- AKHIR FORM -->

        @if (Route::current()->uri == 'buku')
        <!-- START DATA -->
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="col-md-1">No</th>
                        <th class="col-md-4">Judul</th>
                        <th class="col-md-3">Pengarang</th>
                        <th class="col-md-2">Tanggal Publikasi</th>
                        <th class="col-md-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @php $i=1; @endphp
                    @foreach ($data as $item)
                        <tr>
                            <td>{{ $i++ }}</td>
                            <td>{{ $item['judul'] }}</td>
                            <td>{{ $item['pengarang'] }}</td>
                            <td>{{ date('d-m-Y', strtotime($item['tanggal_publikasi'])) }}</td>
                            <td>
                                <a href="{{ url('buku/'.$item['id']) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ url('buku/'.$item['id']) }}" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus buku {{ $item['judul'] }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Del</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td>NULL</td>
                            <td>NULL</td>
                            <td>NULL</td>
                            <td>NULL</td>
                            <td>
                                <a href="buku/999999" class="btn btn-warning btn-sm">Edit</a>
                                <form action="buku/999999" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus buku NULL?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Del</button>
                                </form>
                            </td>
                        </tr>
                </tbody>
            </table>

        </div>
        <!-- AKHIR DATA -->
        @endif
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>

</body>

</html>