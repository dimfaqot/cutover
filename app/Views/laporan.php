<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<div class="card mt-2">
    <div class="card-body shadow shadow-sm">
        <div class="row mb-3 g-2">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex gap-2 p-2">
                        <div class="bg_purple text-white text-center" style="width:50px;height:50px;font-size:xx-large"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                        <div>
                            <h6 class="text_dark" style="font-size: small;">Total Payments</h6>
                            <h6><?= rupiah($total_income); ?></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex gap-2 p-2">
                        <div class="bg_main text-white text-center" style="width:50px;height:50px;font-size:xx-large"><i class="fa-solid fa-receipt"></i></div>
                        <div>
                            <h6 class="text_dark" style="font-size: small;">Total Salaries</h6>
                            <h6><?= rupiah($total_salaries); ?></h6>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body d-flex gap-2 p-2">
                        <div class="bg_success text-white text-center" style="width:50px;height:50px;font-size:xx-large"><i class="fa-solid fa-sack-dollar"></i></div>
                        <div>
                            <h6 class="text_dark" style="font-size: small;">Total Income</h6>
                            <h6><?= rupiah($total); ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="input-group input-group-sm mb-3">

            <a class="nav-link dropdown-toggle btn_purple" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Tahun [<?= (url(4) == '' ? date('Y') : url(4)); ?>]
            </a>
            <ul class="dropdown-menu">
                <?php foreach ($tahun as $i) : ?>
                    <li style="font-size: small;"><a class="dropdown-item <?= (url(4) == '' && $i == date('Y') ? 'bg_main' : (url(4) !== '' && $i == url(4) ? 'bg_main' : '')); ?>" href="<?= base_url(menu()['controller']); ?>/<?= $i; ?>/<?= (url(5) == '' ? date('m') : url(5)); ?>"><?= $i; ?></a></li>
                <?php endforeach; ?>
                <li style="font-size: small;"><a class="dropdown-item <?= (url(4) == 'All' ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/All/<?= (url(5) == '' ? date('m') : url(5)); ?>">All</a></li>
            </ul>
            <a class="nav-link dropdown-toggle btn_save" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Bulan [<?= (url(5) == '' ? date('m') : url(5)); ?>]
            </a>
            <ul class="dropdown-menu">
                <?php foreach (bulan() as $i) : ?>
                    <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == '' && $i['angka'] == date('m') ? 'bg_main' : (url(5) !== '' && $i['angka'] == url(5) ? 'bg_main' : '')); ?>" href="<?= base_url(menu()['controller']); ?>/<?= (url(4) == '' ? date('Y') : url(4)); ?>/<?= $i['angka']; ?>"><?= $i['bulan']; ?></a></li>
                <?php endforeach; ?>
                <li style="font-size: small;"><a class="dropdown-item <?= (url(5) == 'All' ? 'bg_main' : ''); ?>" href="<?= base_url(menu()['controller']); ?>/<?= (url(4) == '' ? date('Y') : url(4)); ?>/All">All</a></li>
            </ul>

            <input data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cari daftar data di bawah." type="text" class="form-control cari_laporan" placeholder="Cari Laporan ...">
        </div>



        <?php if (count($data) == 0) : ?>
            <div class="mt-2 body_warning"><i class="fa-solid fa-circle-exclamation"></i> Data not found!.</div>
        <?php else : ?>
            <div class="d-flex justify-content-between gap-2 px-2 py-1 bg_main_light">
                <div style="font-style: italic;">
                    Total data <?= count($data); ?>
                </div>
                <div class="d-flex gap-2">
                    <a target="_blank" class="btn_act_purple" href="<?= base_url(menu()['controller']); ?>/cetak/pdf/<?= encode_jwt(['tahun' => (url(4) == '' ? date('Y') : url(4)), 'bulan' => (url(5) == '' ? date('m') : url(5))]); ?>"><i class="fa-regular fa-file-pdf text_purple"></i></a>
                    <a target="_blank" class="btn_act_success" href="<?= base_url(menu()['controller']); ?>/cetak/excel/<?= encode_jwt(['tahun' => (url(4) == '' ? date('Y') : url(4)), 'bulan' => (url(5) == '' ? date('m') : url(5))]); ?>"><i class="fa-regular fa-file-excel text_success"></i></a>
                </div>
            </div>
            <?php foreach ($data as $k => $i) : ?>
                <div data-search="<?= date('d', $i['job']['tgl']); ?> <?= bulan(date('m', $i['job']['tgl']))['bulan']; ?> <?= date('Y', $i['job']['tgl']); ?> <?= $i['job']['nama']; ?>" class="card search_laporan mt-2 <?= ($k % 2 == 0 ? 'bg_light' : 'bg-light'); ?> <?= $i['job']['nama']; ?>">
                    <div class="border border-bottom shadow shadow-sm gap-2">
                        <div class="d-flex justify-content-between">
                            <div class="d-flex gap-2">
                                <div class="no_laporan bg_primary text-white" style="border-radius: 3px 0px 0px 0px; font-weight:600"><?= ($k + 1); ?></div>
                                <div class="pt-1 text_primary" style="font-weight: 500;"><?= date('d/m/Y', $i['job']['tgl']); ?></div>
                                <div class="pt-1 text_primary" style="font-weight: 500;"><?= $i['job']['nama']; ?></div>

                            </div>
                            <div class="pe-2 pt-1" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Print invoice.">
                                <a target="_blank" href="<?= base_url(menu()['controller']); ?>/cetak/invoice/<?= encode_jwt(['id' => $i['job']['id']]); ?>" class="btn_act_primary"><i class="fa-solid fa-file-invoice text_primary"></i></a>
                            </div>
                        </div>


                    </div>
                    <div class="row p-3 g-2">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between gap-2 p-2">
                                    <div class="d-flex gap-2">
                                        <div class="bg_purple text-white text-center" style="width:50px;height:50px;font-size:xx-large"><i class="fa-solid fa-file-invoice-dollar"></i></div>
                                        <div>
                                            <h6 class="text_dark" style="font-size: small;">Payment</h6>
                                            <h6><?= rupiah($i['job']['harga_paket']); ?></h6>

                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <a data-bs-toggle="modal" data-bs-target="#payment_<?= $i['job']['id']; ?>" href="" class="btn_act_purple" style="font-size: medium;"><i class="fa-solid fa-circle-chevron-down text_purple"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body d-flex justify-content-between gap-2 p-2">
                                    <div class="d-flex gap-2">
                                        <div class="bg_main text-white text-center" style="width:50px;height:50px;font-size:xx-large"><i class="fa-solid fa-receipt"></i></div>
                                        <div>
                                            <h6 class="text_dark" style="font-size: small;">Salaries</h6>
                                            <h6><?= rupiah($i['salaries']); ?></h6>

                                        </div>
                                    </div>
                                    <div class="pt-3">
                                        <a data-bs-toggle="modal" data-bs-target="#salaries_<?= $i['job']['id']; ?>" href="" class="btn_act_main" style="font-size: medium;"><i class="fa-solid fa-circle-chevron-down text_main"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body d-flex gap-2 p-2">
                                    <div class="bg_success text-white text-center" style="width:50px;height:50px;font-size:xx-large"><i class="fa-solid fa-sack-dollar"></i></div>
                                    <div>
                                        <h6 class="text_dark" style="font-size: small;">Income</h6>
                                        <h6><?= rupiah($i['job']['harga_paket'] - $i['salaries']); ?></h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <!-- modal payment -->
                <div class="modal fade" id="payment_<?= $i['job']['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="d-flex justify-content-between px-4 py-3">
                                    <div class="judul_modal">
                                        <i class="fa-solid fa-file-invoice-dollar"></i> Payment
                                    </div>
                                    <a href="" type="button" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></a>
                                </div>
                                <div class="px-4 pb-3">
                                    <div class="input-group input-group-sm mb-2">
                                        <span style="width: 80px;" class="input-group-text bg_main_light">Tanggal</span>
                                        <input type="text" class="form-control" value="<?= date('d', $i['job']['tgl']); ?> <?= bulan(date('m', $i['job']['tgl']))['bulan']; ?> <?= date('Y', $i['job']['tgl']); ?>" placeholder="Tanggal" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-2">
                                        <span style="width: 80px;" class="input-group-text bg_main_light">Customer</span>
                                        <input type="text" class="form-control" value="<?= $i['job']['nama']; ?>" placeholder="Customer" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-2">
                                        <span style="width: 80px;" class="input-group-text bg_main_light">Lokasi</span>
                                        <input type="text" class="form-control" value="<?= $i['job']['lokasi']; ?>" placeholder="Lokasi" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-2">
                                        <span style="width: 80px;" class="input-group-text bg_main_light">Paket</span>
                                        <input type="text" class="form-control" value="<?= $i['job']['paket']; ?>" placeholder="Paket" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-2">
                                        <span style="width: 80px;" class="input-group-text bg_main_light">Acara</span>
                                        <input type="text" class="form-control" value="<?= $i['job']['acara']; ?>" placeholder="Acara" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-2">
                                        <span style="width: 80px;" class="input-group-text bg_main_light">Harga</span>
                                        <input type="text" class="form-control" value="<?= rupiah($i['job']['harga_paket']); ?>" placeholder="Harga" readonly>
                                    </div>
                                    <div class="input-group input-group-sm mb-2">
                                        <span style="width: 80px;" class="input-group-text bg_main_light">Ket</span>
                                        <input type="text" class="form-control" value="<?= $i['job']['ket']; ?>" placeholder="Ket" readonly>
                                    </div>

                                    <div class="input-group input-group-sm">
                                        <span style="width: 80px;" class="input-group-text bg_main_light">Catatan</span>
                                        <textarea class="form-control"><?= $i['job']['catatan']; ?></textarea>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal salaries -->
                <div class="modal fade" id="salaries_<?= $i['job']['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="d-flex justify-content-between px-4 py-3">
                                    <div class="judul_modal">
                                        <i class="fa-solid fa-receipt"></i> Salaries
                                    </div>
                                    <a href="" type="button" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></a>
                                </div>
                                <div class="px-4 pb-3">
                                    <table class="table table-sm table-bordered table-striped mt-1">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center;" scope="col">#</th>
                                                <th style="text-align: center;">Nama</th>
                                                <th style="text-align: center;">Tugas</th>
                                                <th style="text-align: center;">Fee</th>
                                            </tr>
                                        </thead>
                                        <tbody class="tabel_search">
                                            <?php foreach ($i['crew'] as $n => $c) : ?>
                                                <tr>
                                                    <td style="text-align: center;"><?= ($n + 1); ?></td>
                                                    <td><?= $c['crew']; ?></td>
                                                    <td><?= $c['tugas']; ?></td>
                                                    <td style="text-align: right;"><?= rupiah($c['fee']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                            <tr>
                                                <th style="text-align: center;" colspan="3">TOTAL</th>
                                                <th style="text-align: right;"><?= rupiah($i['salaries']); ?></th>
                                            </tr>
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
    </div>
<?php endif; ?>
</div>


</div>

<?= $this->endSection() ?>