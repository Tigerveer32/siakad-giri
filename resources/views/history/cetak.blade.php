<!DOCTYPE html>
<html>

<head>
    <title>Cetak Riwayat</title>
    <style>
        /* CSS untuk gaya cetak, Anda bisa menyesuaikan sesuai kebutuhan */
        body {
            font-family: Arial, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: cornflowerblue; /* Mengubah latar belakang menjadi biru */
            color: white; /* Mengubah warna teks menjadi putih agar lebih terlihat */
        }

        /* CSS untuk mengatur posisi tengah tulisan h1 */
        .center {
            text-align: center;
        }

        /* CSS untuk teks judul */
        .title {
            font-size: 26px;
            /* Menghapus teks "bold" */
            font-weight: bold;
            margin-bottom: 5px;
        }
        .lap {
            font-size: 17px;
            /* Menghapus teks "bold" */
            font-weight: bold;
            margin-bottom: 5px;
        }
        .jalan {
            font-size: 14px;
            /* Menghapus teks "bold" */
            /* font-weight: bold; */
            margin-bottom: 5px;
        }

        /* CSS untuk garis panjang */
        .line {
            border: none;
            border-top: 2px solid black;
            margin-bottom: 10px;
        }
    </style>
</head>



<body>
    <!-- Tambahkan jeda di atas judul -->
    <br><br>

    <div class="center title">SMA KYAI AGENG GIRI MRANGGEN</div>
    <!-- Menghapus teks "bold" pada teks berikut -->
    <div class="center jalan">Jl. Raya Girikusumo 04/03, Banyumeneng, Kec. Mranggen, Kode Pos 59567</div>
    <!-- Tambahkan garis panjang -->
    <div class="center line"></div>
    <br>

    <div class="center lap">Laporan Catatan Pengunggahan Materi oleh Guru</div>
    <!-- Tambahkan jeda setelah garis panjang
    <br><br> -->

    <div class="center">
        Tanggal: {{ date('d-m-Y') }}<br>
    </div>
    <br>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Mapel</th>
                <th>Nama Guru</th>
                <th>Judul Materi</th>
                <th>Kelas</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $no => $value)
            <tr>
                <td>{{ $no+1 }}</td>
                <td>{{ $value->nama_mapel }}</td>
                <td>{{ $value->nama_guru }}</td>
                <td>{{ $value->judul_materi }}</td>
                <td>{{ $value->nama_kelas }}</td>
                <td>{{ date('d-m-y', strtotime($value->created_at)) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
