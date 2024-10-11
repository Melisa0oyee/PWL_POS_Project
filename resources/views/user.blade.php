<!DOCTYPE html>
<html>
    <head>
        <title>Data User</title>
    </head>
    <body>
        <h1>Data User</h1>
        <a href="http://PWL_POS_Project.test/user/tambah">Tambah User</a>
        <table border="1" cellpadding="2" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>ID Level Pengguna</th> 
                <th>Aksi</th>
            </tr>
            @foreach ($data as $d)
            <tr>
                <td>{{ $d ->user_id }}</td>
                <td>{{ $d ->username }}</td>
                <td>{{ $d ->nama }}</td>
                <td>{{ $d ->level_id }}</td>
                <td>
                    <a href="http://PWL_POS_Project.test/user/ubah/{{ $d->user_id}}">Ubah</a> | 
                    <a href="http://PWL_POS_Project.test/user/hapus/{{ $d->user_id}}">Hapus</a>
                </td>
            </tr>
            @endforeach
        </table>
    </body>
</html>