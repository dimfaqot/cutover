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

    <p style="text-align: center;margin-top:-100px;"><?= $logo; ?></p>
    <div style="text-align: center;font-weight:bold;"><?= $judul; ?></div>

    <table style="width: 100%;">
        <tr>
            <th style="text-align: center;">No.</th>
            <th style="text-align: center;">Tgl.</th>
            <th style="text-align: center;">Customer</th>
            <th style="text-align: center;">Paket</th>
            <th style="text-align: center;">Acara</th>
            <th style="text-align: center;">Payment</th>
            <th style="text-align: center;">Salaries</th>
            <th style="text-align: center;width:110px;">Income</th>

        </tr>
        <?php foreach ($data['data'] as $k => $i) : ?>
            <tr style="background-color: #f6f6f6;">
                <td><?= ($k + 1); ?></td>
                <td><?= date('d/m/Y', $i['job']['tgl']); ?></td>
                <td><?= $i['job']['nama']; ?></td>
                <td><?= $i['job']['paket']; ?></td>
                <td><?= $i['job']['acara']; ?></td>
                <td style="text-align: right;"><?= rupiah($i['job']['harga_paket']); ?></td>
                <td style="text-align: right;"><?= rupiah($i['salaries']); ?></td>
                <td style="text-align: right;" rowspan="<?= count($i['crew']) + 2; ?>"><?= rupiah($i['job']['harga_paket'] - $i['salaries']); ?></td>
            </tr>
            <tr>
                <td style="text-align: center;font-weight:bold;" colspan="4" rowspan="<?= count($i['crew']) + 1; ?>">Details</td>
            </tr>
            <?php foreach ($i['crew'] as $n => $c) : ?>
                <tr>
                    <td><?= $c['crew']; ?></td>
                    <td><?= $c['tugas']; ?></td>
                    <td style="text-align: right;"><?= rupiah($c['fee']); ?></td>
                </tr>
            <?php endforeach; ?>

        <?php endforeach; ?>
        <tr>
            <td colspan="5" style="font-weight:bold;text-align:center;">TOTAL</td>
            <td style="text-align: right;font-weight:bold;"><?= rupiah($total_income); ?></td>
            <td style="text-align: right;font-weight:bold;"><?= rupiah($total_salaries); ?></td>
            <td style="text-align: right;font-weight:bold;"><?= rupiah($total); ?></td>
        </tr>
    </table>
    <br>
    <br>
    <div style="text-align: right;">Solo, <?= date('d'); ?> <?= bulan(date('m'))['bulan']; ?> <?= date('Y'); ?></div>
    <table style="border: 0px;">
        <tr style="background-color: transparent;border:0px;">
            <td rowspan="3" style="text-align: center;border:0px;"><img src="<?= set_qr_code(base_url('public/laporan/') . $jwt, 'logo', 'Laporan Keuangan'); ?>" alt="Laporan Djana"></td>
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