<?= $this->extend('logged') ?>

<?= $this->section('content') ?>

<div class="card mt-2">
    <div class="card-body shadow shadow-sm">


        <div class="input-group input-group-sm mb-3">
            <button data-bs-toggle="modal" data-bs-target="#add_<?= menu()['controller']; ?>" class="btn_add"><i class="fa-solid fa-circle-plus"></i> <?= menu()['menu']; ?></button>
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
        </div>


        <div class="modal fade" id="add_<?= menu()['controller']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-body">
                        <div class="d-flex justify-content-between px-4 py-3">
                            <div class="judul_modal">
                                <i class="<?= menu()['icon']; ?>"></i> <?= menu()['menu']; ?>
                            </div>
                            <a href="" type="button" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></a>
                        </div>
                        <div class="px-4 pb-3">
                            <form action="<?= base_url(menu()['controller']); ?>/add" method="post">
                                <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= (url(4) == '' ? date('Y') : url(4)); ?>/<?= (url(5) == '' ? date('m') : url(5)); ?>">
                                <div class="input-group input-group-sm  mb-2">
                                    <label style="width: 120px;" class="input-group-text">Tgl.</label>
                                    <input type="date" data-date="" class="form-control input_date" style="padding-bottom: 25px;" name="tgl" data-date-format="DD/MM/YYYY" value="<?= date('Y-m-d'); ?>">
                                </div>
                                <div class="form-floating mb-3">
                                    <select class="form-select" name="paket" required>
                                        <option value="">Select</option>
                                        <?php foreach (paket() as $p) : ?>
                                            <option value="<?= $p['id']; ?>"><?= $p['paket']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Select Paket</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" name="nama" class="form-control" placeholder="Nama Customer" required>
                                    <label>Customer</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="lokasi" class="form-control" placeholder="Lokasi acara" required>
                                    <label>Lokasi</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <select class="form-select" name="acara" required>
                                        <option value="">Select</option>
                                        <?php foreach (options('Acara') as $p) : ?>
                                            <option value="<?= $p['value']; ?>"><?= $p['value']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <label>Select Acara</label>
                                </div>

                                <div class="form-floating">
                                    <textarea class="form-control" name="catatan" placeholder="Catatan" style="height: 100px"></textarea>
                                    <label>Catatan</label>
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" href="" class="btn_save"><i class="fa-solid fa-circle-check"></i> Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if (count($data) == 0) : ?>
            <div class="mt-2 body_warning"><i class="fa-solid fa-circle-exclamation"></i> Data not found!.</div>
        <?php else : ?>
            <div class="input-group input-group-sm">
                <span style="width: 92px;" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cari daftar data di bawah." class="input-group-text">Cari <?= menu()['menu']; ?></span>
                <input data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Cari daftar data di bawah." type="text" class="form-control cari" placeholder="...">
            </div>
            <table class="table table-sm table-bordered table-striped mt-1">
                <thead>
                    <tr>
                        <th style="text-align: center;" scope="col">#</th>
                        <th style="text-align: center;" scope="col">Tgl</th>
                        <th style="text-align: center;" class="d-none d-md-table-cell">Nama</th>
                        <th style="text-align: center;" class="d-none d-md-table-cell">Paket</th>
                        <th style="text-align: center;" class="d-none d-md-table-cell">Acara</th>
                        <th style="text-align: center;" class="d-none d-md-table-cell">Harga</th>
                        <th style="text-align: center;" scope="col">Lokasi</th>
                        <th style="text-align: center;" scope="col">Ket</th>
                        <th style="text-align: center;" scope="col">Act</th>
                    </tr>
                </thead>
                <tbody class="tabel_search">
                    <?php foreach ($data as $k => $i) : ?>
                        <tr>
                            <td style="text-align: center;"><?= ($k + 1); ?></td>
                            <td><?= date('d/m/Y', $i['job']['tgl']); ?></td>
                            <td class="d-none d-md-table-cell"><?= $i['job']['nama']; ?></td>
                            <td class="d-none d-md-table-cell"><?= $i['job']['paket']; ?></td>
                            <td class="d-none d-md-table-cell"><?= $i['job']['acara']; ?></td>
                            <td class="d-none d-md-table-cell" style="text-align: right;"><?= rupiah($i['job']['harga_paket']); ?></td>
                            <td><?= $i['job']['lokasi']; ?></td>
                            <td style="text-align: center;"><a href="" data-id="<?= $i['job']['id']; ?>" data-bs-toggle="modal" data-bs-target="#ket_<?= $i['job']['id']; ?>"><i class="fa-solid fa-circle <?= ($i['job']['ket'] == 'Waiting' ? 'text_dark' : ($i['job']['ket'] == 'Processing' ? 'text_warning' : ($i['job']['ket'] == 'Done' ? 'text_success' : ''))); ?>"></i></a></td>
                            <td style="text-align: center;">
                                <div class="d-flex justify-content-center gap-2">
                                    <div class="btn_act_main" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit data."><a href="" data-bs-toggle="modal" data-bs-target="#job_<?= $i['job']['id']; ?>" style="font-size: medium;"><i class="fa-solid fa-circle-info text_main"></i></a></div>
                                    <div class="btn_act_success" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Edit crew."><a href="" data-bs-toggle="modal" data-bs-target="#crew_<?= $i['job']['id']; ?>" style="font-size: medium;"><i class="fa-solid fa-circle-user text_success"></i></i></a></div>
                                    <div class="btn_act_danger" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete data"><a href="" class="confirm" data-id="<?= $i['job']['id']; ?>" data-message="Are you sure?" data-controller="<?= menu()['controller']; ?>" data-tabel="<?= menu()['tabel']; ?>" data-method="delete" style="font-size: medium;"><i class="fa-solid fa-circle-xmark text_danger"></i></a></div>

                                </div>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>

            <?php foreach ($data as $i) : ?>
                <!-- modal job -->
                <div class="modal fade" id="job_<?= $i['job']['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="d-flex justify-content-between px-4 py-3">
                                    <div class="judul_modal">
                                        <i class="<?= menu()['icon']; ?>"></i> <?= $i['job']['paket']; ?>
                                    </div>
                                    <a href="" type="button" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></a>
                                </div>
                                <div class="px-4 pb-3">
                                    <form action="<?= base_url(menu()['controller']); ?>/update" method="post">
                                        <input type="hidden" name="id" value="<?= $i['job']['id']; ?>">
                                        <input type="hidden" name="url" value="<?= base_url(menu()['controller']); ?>/<?= (url(4) == '' ? date('Y') : url(4)); ?>/<?= (url(5) == '' ? date('m') : url(5)); ?>">
                                        <div class="input-group input-group-sm  mb-2">
                                            <label style="width: 120px;" class="input-group-text">Tgl.</label>
                                            <input type="date" data-date="" class="form-control input_date" style="padding-bottom: 25px;" name="tgl" data-date-format="DD/MM/YYYY" value="<?= date('Y-m-d', $i['job']['tgl']); ?>">
                                        </div>
                                        <div class="form-floating mb-3">
                                            <select class="form-select" name="paket" required>
                                                <?php foreach (paket() as $p) : ?>
                                                    <option <?= ($p['paket'] == $i['job']['paket'] ? 'selected' : ''); ?> value="<?= $p['id']; ?>"><?= $p['paket']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Select Paket</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" name="harga_paket" value="<?= rupiah($i['job']['harga_paket']); ?>" class="form-control rupiah" placeholder="Harga paket" required>
                                            <label>Harga</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <input type="text" name="nama" value="<?= $i['job']['nama']; ?>" class="form-control" placeholder="Nama Customer" required>
                                            <label>Customer</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" name="lokasi" value="<?= $i['job']['lokasi']; ?>" class="form-control" placeholder="Lokasi acara" required>
                                            <label>Lokasi</label>
                                        </div>

                                        <div class="form-floating mb-3">
                                            <select class="form-select" name="acara" required>
                                                <?php foreach (options('Acara') as $p) : ?>
                                                    <option <?= ($p['value'] == $i['job']['acara'] ? 'selected' : ''); ?> value="<?= $p['value']; ?>"><?= $p['value']; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                            <label>Select Acara</label>
                                        </div>

                                        <div class="form-floating">
                                            <textarea class="form-control" name="catatan" placeholder="Catatan" style="height: 100px"><?= $i['job']['catatan']; ?></textarea>
                                            <label>Catatan</label>
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" href="" class="btn_save"><i class="fa-solid fa-circle-check"></i> Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal crew -->
                <div class="modal fade" id="crew_<?= $i['job']['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="d-flex justify-content-between px-4 py-3">
                                    <div class="judul_modal">
                                        <i class="fa-solid fa-user-group"></i> Add Crew
                                    </div>
                                    <a href="" type="button" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></a>
                                </div>
                                <div class="px-4 pb-3">
                                    <div class="card mt-2">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <select class="form-select add_crew_<?= $i['job']['id']; ?>" name="crew" required>
                                                            <option value="">Select</option>
                                                            <?php foreach (crew() as $p) : ?>
                                                                <option value="<?= $p['nama']; ?>"><?= $p['nama']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <label>Select Crew</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-floating mb-3">
                                                        <select class="form-select add_tugas add_tugas_<?= $i['job']['id']; ?>" data-id="<?= $i['job']['id']; ?>" name="tugas" required>
                                                            <option value="">Select</option>
                                                            <?php foreach (tugas() as $p) : ?>
                                                                <option value="<?= $p['fee']; ?>"><?= $p['tugas']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <label>Select Tugas</label>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <div class="form-floating mb-3">
                                                        <input type="text" name="fee" value="" class="form-control rupiah add_fee_<?= $i['job']['id']; ?>" placeholder="Fee" required>
                                                        <label>Fee</label>
                                                    </div>
                                                </div>
                                                <div class="text-center mt-2">
                                                    <button type="submit" href="" class="btn_save add_crew" data-id="<?= $i['job']['id']; ?>"><i class="fa-solid fa-circle-check"></i> Add Crew</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="body_crews_<?= $i['job']['id']; ?> mt-3">
                                        <?php if (count($i['crew']) == 0) : ?>
                                            <div class="mt-2 body_warning"><i class="fa-solid fa-circle-exclamation"></i> Crew not set yet!.</div>
                                        <?php else : ?>


                                            <?php foreach ($i['crew'] as $n => $c) : ?>
                                                <div class="mb-2">

                                                    <a data-bs-toggle="collapse" href="#detail_crew_<?= $c['id']; ?>" data-i="<?= $n; ?>" role="button" aria-expanded="false" aria-controls="detail_crew_<?= $c['id']; ?>" class="d-flex justify-content-between <?= ($n % 2 == 0 ? 'accord_light' : 'accord_dark'); ?> border_radius_sm body_accord">
                                                        <div><?= $c['crew']; ?> <span style="font-weight: bold;">-[<?= $c['tugas']; ?>]-</span></div>
                                                        <div>
                                                            <i class="fa-solid fa-angle-down"></i>
                                                        </div>
                                                    </a>

                                                    <div class="collapse bg_main_light pt-3 px-3" id="detail_crew_<?= $c['id']; ?>">
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3">
                                                                    <select class="form-select update update_crew_<?= $c['id']; ?>" data-job_id="<?= $i['job']['id']; ?>" data-id="<?= $c['id']; ?>" name="crew" required>

                                                                        <?php foreach (crew() as $p) : ?>
                                                                            <option <?= ($p['nama'] == $c['crew'] ? 'selected' : ''); ?> value="<?= $p['nama']; ?>"><?= $p['nama']; ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    <label>Select Crew</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-floating mb-3">
                                                                    <select class="form-select update update_tugas_<?= $c['id']; ?>" data-id="<?= $c['id']; ?>" data-job_id="<?= $i['job']['id']; ?>" name="tugas" required>

                                                                        <?php foreach (tugas() as $p) : ?>
                                                                            <option <?= ($p['tugas'] == $c['tugas'] ? 'selected' : ''); ?> value="<?= $p['fee']; ?>"><?= $p['tugas']; ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                    <label>Select Tugas</label>
                                                                </div>
                                                            </div>
                                                            <div class="col">
                                                                <div class="form-floating mb-3">
                                                                    <input type="text" name="fee" value="<?= rupiah($c['fee']); ?>" class="form-control rupiah update_fee update_fee_<?= $c['id']; ?>" data-id="<?= $c['id']; ?>" data-job_id="<?= $i['job']['id']; ?>" placeholder="Fee" required>
                                                                    <label>Fee</label>
                                                                </div>
                                                            </div>

                                                            <div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete data" class="text-center mb-3">
                                                                <button href="" class="confirm btn_danger" data-job_id="<?= $i['job']['id']; ?>" data-id="<?= $c['id']; ?>" data-message="Are you sure?" data-controller="<?= menu()['controller']; ?>" data-tabel="pengeluaran" data-method="delete_pengeluaran" style="font-size: small;"><span class="btn_act_danger"><i class="fa-solid fa-circle-xmark text_danger"></i></span> Delete</button>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div>
                                            <?php endforeach; ?>

                                    </div>

                                <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- modal ket -->
                <div class="modal fade" id="ket_<?= $i['job']['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="d-flex justify-content-between px-4 py-3">
                                    <div class="judul_modal">
                                        <i class="fa-solid fa-clock"></i> Progress
                                    </div>
                                    <a href="" type="button" data-bs-dismiss="modal"><i class="fa-solid fa-xmark"></i></a>
                                </div>
                                <div class="px-4 pb-3">
                                    <div class="d-flex justify-content-center bg_light border_radius gap-1">
                                        <?php $ket = $i['job']['ket']; ?>

                                        <?php foreach (options('Ket') as $k) : ?>

                                            <div class="<?= ($k['value'] == $ket ? ($k['value'] == 'Processing' ? 'text_warning' : ($k['value'] == 'Done' ? 'text_success' : 'text_dark')) : 'text_grey'); ?>"><i class="fa-solid fa-circle"></i> <?= $k['value']; ?></div>
                                            <?php if ($k['value'] !== 'Done') : ?>
                                                <div class="text_grey" style="border-top: 1px solid;width:10%;margin-top:11px;"></div>
                                            <?php endif; ?>

                                        <?php endforeach; ?>
                                    </div>

                                    <div class="card mt-3">
                                        <div class="card-body d-flex justify-content-center gap-3">
                                            <?php foreach (options('Ket') as $k) : ?>
                                                <div class="form-check form-switch">
                                                    <input <?= ($k['value'] == $ket ? 'checked' : ''); ?> class="form-check-input update_ket" value="<?= $k['value']; ?>" data-id="<?= $i['job']['id']; ?>" type="radio" name="ket_<?= $i['job']['id']; ?>" role="switch">
                                                    <label class="form-check-label"><?= $k['value']; ?></label>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <?php endforeach; ?>

        <?php endif; ?>
    </div>


</div>

<?= $this->endSection() ?>