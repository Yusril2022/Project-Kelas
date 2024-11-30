<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename={$title}.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<table border="1" width="100%">
    <thead>
        <tr>
            <th>NIM</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Tanggal Lahir</th>
            <th>Jenis Kelamin</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tbl_mahasiswa as $data): ?>
        <tr>
            <td><?= $data['nim']; ?></td>
            <td><?= $data['nama']; ?></td>
            <td><?= $data['alamat']; ?></td>
            <td><?= $data['tgl_lahir']; ?></td>
            <td><?= $data['jk']; ?></td>
            <td><?= $data['email']; ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
