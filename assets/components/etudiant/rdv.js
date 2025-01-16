$(document).ready(function () {
    var previousXhr = null;

    $("select").select2();

    let selectedActes = [];

    if ($.fn.dataTable.isDataTable("#list_rendezvous")) {
        $("#list_rendezvous").DataTable().clear().destroy();
    }

    // fixing display issues
    $('#actSelect').select2({
        dropdownParent: $('#rdv_new')
    });

    $('#actSelect').on('select2:open', function () {
        $('.select2-container--open').css('z-index', '1050');
    });
    $('#patientSelect').select2({
        dropdownParent: $('#rdv_new')
    });

    $('#patientSelect').on('select2:open', function () {
        $('.select2-container--open').css('z-index', '1050');
    });

    $('body #actSelect').on('change', function () {
        const selectedOption = $(this).find('option:selected');
        const selectedText = selectedOption.text();
        const selectedValue = $(this).val();

        if (selectedValue == "") {
            return;
        }

        selectedActes.push($(this).val());

        // console.log(selectedActes);

        const newRow = `
          <tr data-value="${selectedValue}">
            <td>${selectedText}</td>
            <td><button class="removeAct" title="Supprimer"><i class="fa-solid fa-circle-xmark" style="color: #e70146;"></i></button></td>
          </tr>
        `;
        $('#placeholderRow').remove();
        $('#actTableBody').append(newRow);

        selectedOption.prop('disabled', true);
    });

    $("body").on('click', '.removeAct', function () {
        const row = $(this).closest('tr');
        const valueToEnable = row.data('value');
        const index = selectedActes.indexOf($(this).val());
        selectedActes.splice(index, 1);
        row.remove();
        if (selectedActes.length === 0) {
            $('#actTableBody').html('<tr id="placeholderRow"><td colspan="2" class="text-center"><p class="text-secondary small lh-base mb-0">Aucun acte n\'est sélectionné</p></td></tr>');
        }

        $('#actSelect').find(`option[value="${valueToEnable}"]`).prop('disabled', false);
    });


    $('body').on('click', '.ajouterRdv', async function (e) {
        e.preventDefault();
        $("#rdvForm")[0].reset();
        $('body #actTableBody').empty();
        $("#actSelect").val(null).trigger('change');
        $("#patientSelect option").prop('disabled', false);
        $("#patientSelect").val(null).trigger('change');

        PatientRadioValue = $('.patient-radio').val();
        let able = false
        let val = "";
        if (PatientRadioValue == "yes") {
            able = true
        }
        $("body #rdvForm #nom").val(val).prop('disabled', able);
        $("body #rdvForm #prenom").val(val).prop('disabled', able);
        $("body #rdvForm #cin").val(val).prop('disabled', able);
        $("body #rdvForm #tel").val(val);
        $("body #rdvForm #ipp").val(val);

        $('#rdv_new').modal("show")
    })

    $("body #rdvForm").on("submit", async function (e) {
        e.preventDefault();

        if (selectedActes.length === 0) {
            notyf.dismissAll();
            notyf.error("Veuillez choisir au moins un acte.");
            return;
        };

        const formData = new FormData(this);


        formData.append('actes', JSON.stringify(selectedActes));

        notyf.open({
            type: "info",
            message: "En cours...",
            duration: 90000,
        });
        try {
            const request = await axios.post(Routing.generate('app_etudiant_rdv_listing_new'), formData, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            });
            const response = request.data;
            await notyf.dismissAll();
            $("#rdvForm")[0].reset();
            $("#rdv_new").modal("hide")
            table.ajax.reload();
            notyf.success(response);
        } catch (error) {
            console.log(error);
            const message = error.response.data;
            notyf.dismissAll();
            notyf.error(message);
        }
    })
    let filterValue = "today";
    $('.filter-radio').on('change', function () {
        filterValue = $(this).val();
        table.ajax.reload();
    });

    var table = $("#list_rendezvous").DataTable({
        lengthMenu: [
            [10, 15, 25, 50, 100, 20000000000000],
            [10, 15, 25, 50, 100, "All"],
        ],
        order: [[0, "asc"]],
        ajax: {
            url: Routing.generate("app_etudiant_rdv_listing_list"),
            type: "get",
            data: function (d) {
                d.filterDate = filterValue;
            },
            beforeSend: function (jqXHR) {
                if (previousXhr) {
                    previousXhr.abort();
                }
                previousXhr = jqXHR;
            },
        },
        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        columns: [
            { name: "r.id", data: "id" },
            { name: "r.Code", data: "Code" },
            { name: "pat.nom", data: "nom" },
            { name: "pat.prenom", data: "prenom" },
            { name: "pat.cin", data: "cin" },
            { name: "pat.ipp", data: "ipp" },
            { name: "pat.tel", data: "tel" },
            { name: "acts", data: "acts" },
            { name: "r.date", data: "date" },
            { name: "r.created", data: "created" },
            { name: "r.valider", data: "valider" },
            { orderable: false, searchable: false, data: "id" },
        ],
        columnDefs: [
            {
                targets: 0,
                orderable: false,
                searchable: false,
                render: function (data, type, full, meta) {
                    return meta.row + 1; // Custom order starting from 1
                }
            },
            {
                targets: 7,
                orderable: false,
                render: function (data, type, full, meta) {
                    if (data) {
                        return `<span id="truncated-text" title="${data}">${data.length > 40 ? data.substring(0, 40) + "..." : data}</span>`;
                    }
                    return data;
                }
            },
            {
                targets: 8,
                render: function (data, type, full, meta) {
                    return window.moment(data.date).format('YYYY-MM-DD HH:mm:ss');
                },
            },
            {
                targets: 9,
                render: function (data, type, full, meta) {
                    return window.moment(data.date).format('YYYY-MM-DD HH:mm:ss');
                },
            },
            {
                targets: 10,
                render: function (data, type, full, meta) {
                    if (data == 1) {
                        return `Validé`;
                    } else {
                        return `En attente`;
                    }
                },
            },
            {
                targets: 11,
                render: function (data, type, full, meta) {
                    return `
                        <div class="dropdown" style="">
                            <svg class="icon" fill="black" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <circle cx="12" cy="5" r="2"></circle>
                                <circle cx="12" cy="12" r="2"></circle>
                                <circle cx="12" cy="19" r="2"></circle>
                            </svg>
                            <div class="actions dropdown-menu dashboard-dropdown dropdown-menu-center mt-2 py-1">
                                <a href="#" data-id="${full.id}" class="dropdown-item detailsRdv"><i class="fa fa-eye"></i>&nbsp; Détails</a>
                                <a href="#" data-id="${full.id}" class="dropdown-item validerRdv"><i class="fa fa-check"></i>&nbsp; Valider</a>
                                <a href="#" data-id="${full.id}" class="dropdown-item annulerRdv"><i class="fa-solid fa-xmark"></i>&nbsp; Annuler</a>
                            </div>
                        </div>
                    `;
                },
            },
        ],
        language: datatablesFrench,
        createdRow: function (row, data, dataIndex) {

            var date = window.moment(data.date.date); // Adjust format if needed
            var now = window.moment();

            if (date.isBefore(now)) {
                $(row).addClass('date-passed');
            }
        },
        initComplete: function () {
            // Prevent sorting when interacting with select in header
            $("thead .selection").on("click", function (e) {
                e.stopPropagation();
            });
        },
    });

    $('body').on('click', '.detailsRdv', async function (e) {
        e.preventDefault();
        let id_rdv = $(this).attr('data-id');
        $('#detailsModal').modal("show")
        try {
            const request = await axios.post(
                Routing.generate('app_etudiant_rdv_listing_details', { rendezvous: id_rdv })
            );
            const response = await request.data;
            $("#detailsModal #detailsBody").html("");
            $("#detailsModal #detailsBody").html(response["detailsRdv"]);

            const pieces = response.pieces;

        } catch (error) {
            window.notyf.dismissAll();
            console.log(error);
            if (error.response && error.response.data) {
                const message = error.response.data;
                window.notyf.error(message);
            } else {
                window.notyf.error('Something went wrong!');
            }
        }
    })

    $('body').on('click', '.annulerRdv', async function (e) {
        e.preventDefault();
        let id_rdv = $(this).attr('data-id');
        swalWithBootstrapButtons.fire({
            showClass: {
                popup: 'animatedSwal flipInX faster'
            },
            position: 'top',
            title: "Confirmation ?",
            text: "Voulez vous vraiment Annuler ce rendez-vous ?",
            type: "warning",
            showCancelButton: true,
            focusConfirm: true,
            showCloseButton: true,
            confirmButtonText: "<i class='fa fa-check'></i> Oui!",
            cancelButtonText: "<i class='fa fa-times'></i> Non, Annuler!",
        }).then(async (result) => {
            if (result.isConfirmed) {
                window.notyf.open({
                    type: "info",
                    message: "En cours...",
                    duration: 9000000,
                    dismissible: false
                });

                var formData = new FormData();
                formData.append('rendezvous', id_rdv);
                try {
                    const request = await axios.post(Routing.generate('app_etudiant_rdv_listing_annuler'), formData);
                    const response = request.data;

                    window.notyf.dismissAll();
                    window.notyf.success(response);
                    table.ajax.reload()

                } catch (error) {
                    // icon.addClass('fa-unlock').removeClass("fa-spinner fa-spin ");
                    console.log(error);
                    const message = error.response.data;
                    window.notyf.dismissAll();
                    window.notyf.error(message);
                }

            }
        })
    })
    $('body').on('click', '.validerRdv', async function (e) {
        e.preventDefault();
        let id_rdv = $(this).attr('data-id');
        swalWithBootstrapButtons.fire({
            showClass: {
                popup: 'animatedSwal flipInX faster'
            },
            position: 'top',
            title: "Confirmation ?",
            text: "Voulez vous vraiment valider ce rendez-vous ?",
            type: "warning",
            showCancelButton: true,
            focusConfirm: true,
            showCloseButton: true,
            confirmButtonText: "<i class='fa fa-check'></i> Oui!",
            cancelButtonText: "<i class='fa fa-times'></i> Non, Annuler!",
        }).then(async (result) => {
            if (result.isConfirmed) {
                window.notyf.open({
                    type: "info",
                    message: "En cours...",
                    duration: 9000000,
                    dismissible: false
                });

                var formData = new FormData();
                formData.append('rendezvous', id_rdv);
                try {
                    const request = await axios.post(Routing.generate('app_etudiant_rdv_listing_valider'), formData);
                    const response = request.data;

                    window.notyf.dismissAll();
                    window.notyf.success(response);
                    table.ajax.reload()

                } catch (error) {
                    // icon.addClass('fa-unlock').removeClass("fa-spinner fa-spin ");
                    console.log(error);
                    const message = error.response.data;
                    window.notyf.dismissAll();
                    window.notyf.error(message);
                }

            }
        })
    })

    $('.patient-radio').on('change', function () {
        PatientRadioValue = $(this).val();
        let able = false
        let val = "";
        if (PatientRadioValue == "yes") {
            able = true
        }
        $("body #rdvForm #nom").val(val).prop('disabled', able);
        $("body #rdvForm #prenom").val(val).prop('disabled', able);
        $("body #rdvForm #cin").val(val).prop('disabled', able);
        $("body #rdvForm #tel").val(val);
        $("body #rdvForm #ipp").val(val);
        // table.ajax.reload();
    });

    $("body #patientSelect").on('change', async function () {
        const patient = $(this).val();

        if (patient != "") {
            try {
                const request = await axios.post(
                    Routing.generate('app_etudiant_rdv_getPatientInfo', { patient: patient })
                );
                const response = await request.data;
                $("body #rdvForm #nom").val(response["nom"]).prop('disabled', true);
                $("body #rdvForm #prenom").val(response["prenom"]).prop('disabled', true);
                $("body #rdvForm #cin").val(response["cin"]).prop('disabled', true);
                $("body #rdvForm #tel").val(response["tel"]);
                $("body #rdvForm #ipp").val(response["ipp"]);

            } catch (error) {
                window.notyf.dismissAll();
                console.log(error);
                if (error.response && error.response.data) {
                    const message = error.response.data;
                    window.notyf.error(message);
                } else {
                    window.notyf.error('Something went wrong!');
                }
            }
        } else {
            $("body #rdvForm #nom").val("").prop('disabled', false);
            $("body #rdvForm #prenom").val("").prop('disabled', false);
            $("body #rdvForm #cin").val("").prop('disabled', false);
            $("body #rdvForm #tel").val("");
            $("body #rdvForm #ipp").val("");
        }
    })

});
