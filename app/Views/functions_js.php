<script>
    setTimeout(() => {
        $('.sukses').fadeOut();
    }, 1200);


    const loading = (req = true) => {
        if (req === true) {
            $('.waiting').show()
        } else {
            $('.waiting').fadeOut()
        }
    }

    const sukses = () => {
        $('.sukses').show();
        setTimeout(() => {
            $('.sukses').fadeOut();
        }, 1200);
    }

    const gagal = (alert) => {
        $('.textGagal').text(alert);
        $('.gagal').fadeIn();
    }

    const rupiah = (angka, prefix) => {

        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        // tambahkan titik jika yang di input sudah menjadi angka ribuan
        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;

        return prefix == undefined ? 'Rp. ' + rupiah : prefix + ' ' + rupiah;
    }

    async function post(url = '', data = {}) {
        loading(true);
        const response = await fetch("<?= base_url(); ?>" + url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(data),
        });
        loading(false);
        return response.json(); // parses JSON response into native JavaScript objects
    }
    const str_replace = (search, replace, subject) => {
        return subject.split(search).join(replace);
    }

    const upper_first = (str) => {
        let arr = str.split(" ");
        for (var i = 0; i < arr.length; i++) {
            arr[i] = arr[i].charAt(0).toUpperCase() + arr[i].slice(1);

        }

        let res = arr.join(" ");

        return res;
    }

    <?php if (settings()['panduan'] == 1) : ?>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    <?php endif; ?>


    const confirm = (controller, tabel, message, method, id, job_id) => {

        $('#' + controller + '_' + id).modal('hide');
        let html = '';
        html += '<div class="body_alert">';
        html += '<div class="d-flex justify-content-between gap-3">';
        html += message;
        html += '<section class="d-flex gap-1">';
        html += '<span class="btn_act_grey"><a href="" class="cancel_confirm"><i class="fa-solid fa-circle-minus text_grey"></i></a></span>';
        html += '<span class="btn_act_success"><a href="" class="delete" data-controller="' + controller + '" data-tabel="' + tabel + '" data-message="' + message + '" data-method="' + method + '" data-id="' + id + '" data-job_id="' + job_id + '"><i class="fa-solid fa-circle-check text_success"></i></a></span>';
        html += '</section>';
        html += '</div>';
        html += '</div>';
        $('.modal_confirm').html(html);
        $('.modal_confirm').show();
    }

    const get_crew_in_job = (data, job_id) => {

        let html = '';
        let crews = <?= json_encode(crew()); ?>;
        let tugas = <?= json_encode(tugas()); ?>;

        if (data.length == 0) {
            html += ' <div class="mt-2 body_warning"><i class="fa-solid fa-circle-exclamation"></i> Crew not set yet!.</div>';
        } else {
            for (let i = 0; i < data.length; i++) {
                html += '<div class="mb-2">';

                html += '<a data-bs-toggle="collapse" href="#detail_crew_' + data[i].id + '" data-i="' + i + '" role="button" aria-expanded="false" aria-controls="detail_crew_' + data[i].id + '" class="d-flex justify-content-between ' + (i % 2 == 0 ? 'accord_light' : 'accord_dark') + ' border_radius_sm body_accord">';
                html += '<div>' + data[i].crew + ' <span style="font-weight:bold;">-[' + data[i].tugas + ']-</span></div>';
                html += '<div>';
                html += '<i class="fa-solid fa-angle-down"></i>';
                html += '</div>';
                html += '</a>';

                html += '<div class="collapse bg_main_light pt-3 px-3" id="detail_crew_' + data[i].id + '">';
                html += '<div class="row">';
                html += '<div class="col-md-6">';
                html += '<div class="form-floating mb-3">';
                html += '<select class="form-select update update_crew_' + data[i].id + '" data-job_id="' + job_id + '" data-id="' + data[i].id + '" name="crew" required>';


                for (let c = 0; c < crews.length; c++) {
                    html += '<option ' + (crews[c].nama == data[i].crew ? 'selected' : '') + ' value="' + crews[c].nama + '">' + crews[c].nama + '</option>';
                }

                html += '</select>';
                html += '<label for="floatingSelect">Select Crew</label>';
                html += '</div>';
                html += '</div>';
                html += '<div class="col-md-6">';
                html += '<div class="form-floating mb-3">';
                html += '<select class="form-select update update_tugas_' + data[i].id + '" data-id="' + data[i].id + '" data-job_id="' + job_id + '" name="tugas" required>';

                for (let t = 0; t < tugas.length; t++) {
                    html += '<option ' + (tugas[t].tugas == data[i].tugas ? 'selected' : '') + ' value="' + tugas[t].fee + '">' + tugas[t].tugas + '</option>';
                }
                html += '</select>';
                html += '<label for="floatingSelect">Select Tugas</label>';
                html += '</div>';
                html += '</div>';
                html += '<div class="col">';
                html += '<div class="form-floating mb-3">';
                html += '<input type="text" name="fee" value="' + rupiah(data[i].fee.toString()) + '" class="form-control rupiah update_fee update_fee_' + data[i].id + '" data-id="' + data[i].id + '" data-job_id="' + job_id + '" placeholder="Fee" required>';
                html += '<label>Fee</label>';
                html += '</div>';
                html += '</div>';
                html += '<div data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete data" class="text-center mb-3">';
                html += '<button href="" class="confirm btn_danger" data-id="' + data[i].id + '" data-job_id="' + job_id + '" data-message="Are you sure?" data-controller="job" data-tabel="pengeluaran" data-method="delete_pengeluaran" style="font-size: small;"><span class="btn_act_danger"><i class="fa-solid fa-circle-xmark text_danger"></i></span> Delete</button>';
                html += '</div>';
                html += '</div>';

                html += '</div>';

                html += '</div>';
            }

        }

        $('.body_crews_' + job_id).html(html);
    }
    const hapus = (controller, method, tabel, id, job_id) => {

        post(controller + '/' + method, {
                id,
                job_id,
                tabel
            })
            .then(res => {
                if (res.status == '200') {
                    sukses();
                    if (method == 'delete_pengeluaran') {
                        get_crew_in_job(res.data, job_id);
                    } else {
                        setTimeout(() => {
                            location.reload();
                        }, 1000);

                    }

                } else {
                    gagal(res.message);
                }

            })
    }

    const update_check = (controller, method, tabel, col, id) => {
        post(controller + '/' + method, {
                id,
                tabel,
                col
            })
            .then(res => {
                if (res.status == '200') {
                    sukses();
                    setTimeout(() => {
                        location.reload();
                    }, 1000);

                } else {
                    gagal(res.message);
                }

            })
    }

    const add_crew = (id) => {
        let crew = $('.add_crew_' + id).val();
        let tugas = $('.add_tugas_' + id + ' option:selected').text();
        let fee = $('.add_fee_' + id).val();

        if (crew == '') {
            gagal('Crew harus dipilih!.');
            return false;
        }
        if (tugas == '') {
            gagal('Tugas harus dipilih!.');
            return false;
        }
        if (fee == '') {
            gagal('Fee harus dipilih!.');
            return false;
        }

        post('job/add_crew', {
                id,
                crew,
                tugas,
                fee
            })
            .then(res => {
                if (res.status == '200') {
                    sukses();
                    get_crew_in_job(res.data, id);

                } else {
                    gagal(res.message);
                }

            })

    }
    const update_crew = (id, job_id, val, col, fee) => {

        post('job/update_crew', {
                id,
                job_id,
                val,
                col,
                fee
            })
            .then(res => {
                if (res.status == '200') {
                    if (col == 'tugas') {
                        $('.update_fee_' + id).val(rupiah(fee));
                    }
                    sukses();

                } else {
                    gagal(res.message);
                }

            })

    }
    const update_fee = (id, job_id, val) => {

        post('job/update_fee', {
                id,
                job_id,
                val
            })
            .then(res => {
                if (res.status == '200') {
                    sukses();

                } else {
                    gagal(res.message);
                }

            })

    }
    const update_ket = (id, val) => {

        post('job/update_ket', {
                id,
                val
            })
            .then(res => {
                if (res.status == '200') {
                    sukses();
                    setTimeout(() => {
                        location.reload();
                    }, 1000);

                } else {
                    gagal(res.message);
                }

            })

    }
</script>