<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $judul; ?></title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide|Sofia|Trirong">
    <link rel="icon" type="image/png" href="<?= base_url(); ?>berkas/menu/karyawan.png" sizes="16x16">

    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td,
        th {
            border: 1px solid #E5E5E5;
            text-align: left;
            padding: 8px;
        }
    </style>

</head>

<body style="font-size: 12px;">
    <div style="position:absolute;top:110px;left:520px;">
        <h1 style="font-size:50px;color:green;border:1px solid green;border-radius:10px;">LUNAS</h1>
    </div>
    <p style="text-align: center;"><?= $logo; ?></p>
    <table style="border: 0px;">
        <tr style="background-color: transparent;border:0px;padding:0px;">
            <td style="border:0px;padding:2px;width:70px;">No. Nota</td>
            <td style="border:0px;padding:2px;width:5px;">:</td>
            <td style="border:0px;padding:2px;"><?= $data['no']; ?></td>
        </tr>
        <tr style="background-color: transparent;border:0px;padding:2px;">
            <td style="border:0px;padding:2px;width:70px;">Tanggal</td>
            <td style="border:0px;padding:2px;width:5px;">:</td>
            <td style="border:0px;padding:2px;"><?= date('d/m/Y', $data['tgl']); ?></td>
        </tr>
        <tr style="background-color: transparent;border:0px;padding:2px;">
            <td style="border:0px;padding:2px;width:70px;">Customer</td>
            <td style="border:0px;padding:2px;width:5px;">:</td>
            <td style="border:0px;padding:2px;"><?= $data['nama']; ?></td>
        </tr>
    </table>
    <hr>
    <table>
        <tr style="background-color: transparent;">
            <td style="width:70px;">Paket</td>
            <td><?= $data['paket']; ?></td>
        </tr>
        <tr style="background-color: transparent;">
            <td style="width:70px;">Acara</td>
            <td><?= $data['acara']; ?></td>
        </tr>
        <tr style="background-color: transparent;">
            <td style="width:70px;">Lokasi</td>
            <td><?= $data['lokasi']; ?></td>
        </tr>
        <tr style="background-color: transparent;">
            <td style="width:70px;">Biaya</td>
            <td><?= rupiah($data['harga_paket']); ?></td>
        </tr>
    </table>
    <br>
    <div style="text-align: right;">Solo, <?= date('d', $data['tgl']); ?> <?= bulan(date('m', $data['tgl']))['bulan']; ?> <?= date('Y', $data['tgl']); ?></div>
    <table style="border: 0px;">
        <tr style="background-color: transparent;border:0px;">
            <td rowspan="3" style="text-align: center;border:0px;"><img src="<?= set_qr_code(base_url('public/invoive/') . $jwt, 'logo', 'Invoice'); ?>" alt="Laporan"></td>
            <td style="text-align: center;border:0px;width:50%;">Admin</td>
        </tr>
        <tr style="background-color: transparent;border:0px;">
            <td style="text-align: center;border:0px;"></td>
        </tr>
        <tr style="background-color: transparent;border:0px;">
            <td style="text-align: center;border:0px;">__________________</td>
        </tr>
    </table>

</body>

</html>