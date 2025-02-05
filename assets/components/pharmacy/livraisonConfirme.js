$(document).ready(function () {
    var previousXhr = null;

    $('#scanInput').focus();

    $('#scanInput').on('keypress', async function (e) {
        e.preventDefault();
        if (e.key === 'Enter') {

            const inputValue = $('#scanInput').val().trim(); // Get input value
            if (!inputValue) {
                window.notyf.dismissAll();
                window.notyf.error("Merci de scanner le codebarre ou bien tappez le code Livraison.");
                return;
            }
            // const source = 'scan';
            $("#detailsModal #detailsBody").html("");
            $("#detailsModal #detailsBody").html(`<main class="d-flex justify-content-center align-items-center flex-wrap">
                <div class="spinner-grow" role="status"></div>
                <div class="spinner-grow" role="status"></div>
                <div class="spinner-grow" role="status"></div>
            </main>`);
            $('body #detailsModal').modal("show")
            try {
                const request = await axios.post(
                    Routing.generate('app_pharmacy_livraison_confirme_details', { codeLivraison: inputValue })
                );
                const response = await request.data;
                $("#detailsModal #detailsBody").html("");
                $("#detailsModal #detailsBody").html(response["detailLivraison"]);

                $("#list_details").DataTable();

            } catch (error) {
                window.notyf.dismissAll();
                console.log(error.response.data.error);
                if (error.response && error.response.data) {
                    const message = error.response.data.error;
                    window.notyf.error(message);
                } else {
                    window.notyf.error('Something went wrong!');
                }
                $('body #detailsModal').modal("hide")
            }
        }
    });

    $("select").select2();

    var livraison_array = [];

    if ($.fn.dataTable.isDataTable("#list_Livraison_confirme")) {
        $("#list_Livraison_confirme").DataTable().clear().destroy();
    }

    var table = $("#list_Livraison_confirme").DataTable({
        lengthMenu: [
            [10, 15, 25, 50, 100, 20000000000000],
            [10, 15, 25, 50, 100, "All"],
        ],
        order: [[0, "asc"]],
        ajax: {
            url: Routing.generate("app_pharmacy_livraison_confirme_list"),
            type: "get",
            data: function (d) {
                // d.filterDate = filterValue;
            },
            beforeSend: function (jqXHR) {
                if (previousXhr) {
                    previousXhr.abort();
                }
                previousXhr = jqXHR;
            },
            dataSrc: function (json) {
                // Store actions globally for dynamic rendering
                window.globalActions = Array.isArray(json.actions) ? json.actions : Object.values(json.actions);
                return json.data;
            },
        },
        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        columns: [
            { name: "livCab.id", data: "id" },
            { name: "demandeCab.code", data: "code_dem_cab" },
            { name: "demandeCab.date", data: "date_dem" },
            { name: "livCab.code", data: "code_liv_cab" },
            { name: "livCab.date", data: "date_liv" },
            { name: "demandeCab.patient", data: "patient" },
            { name: "demandeCab.dossierPatient", data: "dossierPatient" },
            { name: "status.designation", data: "statut_liv" },
            { name: 'actions', date: null, orderable: false, searchable: false, render: function (data,type, full) {
                var actionsHtml = `<div class="dropdown" style="">
                            <svg class="icon" fill="black" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <circle cx="12" cy="5" r="2"></circle>
                                <circle cx="12" cy="12" r="2"></circle>
                                <circle cx="12" cy="19" r="2"></circle>
                            </svg>
                            <div class="actions dropdown-menu dashboard-dropdown dropdown-menu-center mt-2 py-1">`;
                    window.globalActions.forEach(function (action) {
                        actionsHtml += `
                            <a href="#" data-id="${full.id}" class="dropdown-item ${action.className}"><i class="fa ${action.icon}"></i>&nbsp;${action.nom}</a>`;
                    });
                    actionsHtml += '</div>';
                    return actionsHtml;
            } },
        ],
        columnDefs: [
            {
                targets: 0,
                orderable: false,
                searchable: false,
                render: function (data, type, full, meta) {
                    var checked = livraison_array.includes(data) ? 'checked' : '';
                    return `<input type="checkbox" class="selectLivraison" data-id="${data}" ${checked}>`;
                }
            },
            {
                targets: 3,
                render: function (data, type, full, meta) {
                    if (data) {
                        return `<a href="#" data-id="${full.id}" class="detailsLiv">${data}</a>`;
                    }
                    return data;
                }
            },
            {
                targets: 5,
                render: function (data, type, full, meta) {
                    if (data) {
                        return `<span id="truncated-text" title="${data}">${data.length > 40 ? data.substring(0, 40) + "..." : data}</span>`;
                    }
                    return data;
                }
            },
            {
                targets: 2,
                render: function (data, type, full, meta) {
                    return window.moment(data.date).format('YYYY-MM-DD');
                    // console.log(data.date);
                },
            },
            {
                targets: 4,
                render: function (data, type, full, meta) {
                    return window.moment(data.date).format('YYYY-MM-DD');
                    // console.log(data.date);
                },
            },
        ],
        language: datatablesFrench,
        createdRow: function (row, data, dataIndex) {

            // var date = window.moment(data.date); // Adjust format if needed
            // var now = window.moment();

            // if (date.isBefore(now)) {
            //     $(row).addClass('date-passed');
            // }
        },
        initComplete: function () {
            $(".selectAllLivraisons").on("change", function () {
                var isChecked = $(this).prop('checked');
                $("input.selectLivraison").each(function() {
                    $(this).prop('checked', isChecked);
                    var id = $(this).data('id');
                    if (isChecked && !livraison_array.includes(id)) {
                        livraison_array.push(id);
                    } else if (!isChecked && livraison_array.includes(id)) {
                        livraison_array = livraison_array.filter(item => item !== id);
                    }
                });
            });

            $('#list_Livraison_confirme tbody').on('change', 'input.selectLivraison', function () {
                var id = $(this).data('id');
                if ($(this).prop('checked')) {
                    if (!livraison_array.includes(id)) {
                        livraison_array.push(id);
                    }
                } else {
                    livraison_array = livraison_array.filter(item => item !== id);
                }
                updateSelectAllCheckboxState();
            });
            // Prevent sorting when interacting with select in header
            $("thead .selection").on("click", function (e) {
                e.stopPropagation();
            });
        },
        drawCallback: function () {
            updateSelectAllCheckboxState();
        }
    });

    function updateSelectAllCheckboxState() {
        var allChecked = $("#list_Livraison_confirme tbody input.selectLivraison").length === $("#list_Livraison_confirme tbody input.selectLivraison:checked").length;
        $(".selectAllLivraisons").prop('checked', allChecked);
    }

    $('body').on('click', '.detailsLiv', async function (e) {
        e.preventDefault();
        let id_livraison = $(this).attr('data-id');
        $("#detailsModal #detailsBody").html("");
            $("#detailsModal #detailsBody").html(`<main class="d-flex justify-content-center align-items-center flex-wrap">
                <div class="spinner-grow" role="status"></div>
                <div class="spinner-grow" role="status"></div>
                <div class="spinner-grow" role="status"></div>
            </main>`);
        $('#detailsModal').modal("show")
        try {
            const request = await axios.post(
                Routing.generate('app_pharmacy_livraison_confirme_details', { idLivraison: id_livraison })
            );
            const response = await request.data;
            $("#detailsModal #detailsBody").html("");
            $("#detailsModal #detailsBody").html(response["detailLivraison"]);

            $("#list_details").DataTable();

        } catch (error) {
            window.notyf.dismissAll();
            console.log(error.response.data);
            if (error.response && error.response.data) {
                console.log("Attempting to hide modal after error...");
                const message = error.response.data.error;
                window.notyf.error(message);
                $('#detailsModal').modal("hide")
            } else {
                window.notyf.error('Something went wrong!');
            }
        }
    })


    const preterLivraison = async (id_livraison) => {
        try {
            window.notyf.open({
                type: "info",
                message: "En cours..",
                duration: 9000000,
            });
            const request = await axios.post(
                Routing.generate('app_pharmacy_livraison_confirme_preter',{
                    id_livraison: id_livraison,
                })
            );
            const response = await request.data;
            window.notyf.dismissAll();
            window.notyf.open({
                type: "success",
                message: response,
                duration: 3000,
            });

            table.ajax.reload();
            $('#detailsModal').modal("hide")
        } catch (error) {
            window.notyf.dismissAll();
            console.log(error);
            if (error.response && error.response.data) {
                const message = error.response.data.error;
                window.notyf.error(message);
            } else {
                window.notyf.error('Something went wrong!');
            }
        }
    }

    $('body').on('click', '.ModalPreterLiv', async function (e) {
        e.preventDefault();
        let id_livraison = $(this).attr('data-id');
        await preterLivraison(id_livraison);
    })

    $('body').on('click', '.PreteLiv', async function (e) {
        e.preventDefault();
        let id_livraison = $(this).attr('data-id');
        await preterLivraison(id_livraison);
    })

    $('body').on('click', '.ModalFutureLiv', async function (e) {
        e.preventDefault();
        $('#future_modal #date').attr("data-livraison", $(this).attr('data-id'));
        $('#future_modal').modal("show")
    })

    $('body').on('click', '.FutureLiv', async function (e) {
        e.preventDefault();
        $('#future_modal #date').attr("data-livraison", $(this).attr('data-id'));
        $('#future_modal').modal("show")
    })

    $('body').on('click', '#saveFuture', async function (e) {
        e.preventDefault();

        let date = $('#future_modal #date').val();
        let livraison_id = $('#future_modal #date').attr("data-livraison");

        try {
            window.notyf.open({
                type: "info",
                message: "En cours..",
                duration: 9000000,
            });
            const request = await axios.post(
                Routing.generate('app_pharmacy_livraison_confirme_future',{
                    livraison: livraison_id,
                    date: date,
                })
            );
            const response = await request.data;
            window.notyf.dismissAll();
            window.notyf.open({
                type: "success",
                message: response,
                duration: 3000,
            });

            $('#future_modal #date').val("");
            $('#future_modal #date').attr("data-livraison", "");
            $('#future_modal').modal("hide")
            table.ajax.reload();
        } catch (error) {
            window.notyf.dismissAll();
            console.log(error);
            if (error.response && error.response.data) {
                const message = error.response.data.error;
                window.notyf.error(message);
            } else {
                window.notyf.error('Something went wrong!');
            }
        }
    });



    $('body').on('click', '.observationMass', async function (e) {
        // alert("hi");
        e.preventDefault();
        if (livraison_array.length <= 0) {
            window.notyf.error("Merci de choisir une ou plusieurs livraisons.");
            return;
        }

        $('#observation_modal #observation').attr("data-livraisons", JSON.stringify(livraison_array));
        $('#observation_modal').modal("show")
    })

    $('body').on('click', '.observation', async function (e) {
        e.preventDefault();
        livraison = [$(this).attr('data-id')];
        $('#observation_modal #observation').attr("data-livraisons", JSON.stringify(livraison));
        $('#observation_modal').modal("show")
    })

    $('body').on('click', '#saveOBS', async function (e) {
        e.preventDefault();

        let observation = $('#observation_modal #observation').val();
        let livraison_array = $('#observation_modal #observation').attr("data-livraisons");

        try {
            window.notyf.open({
                type: "info",
                message: "En cours..",
                duration: 9000000,
            });
            const request = await axios.post(
                Routing.generate('app_pharmacy_livraison_confirme_observation',{
                    livraisons: JSON.parse(livraison_array),
                    observation: observation,
                })
            );
            const response = await request.data;
            window.notyf.dismissAll();
            window.notyf.open({
                type: "success",
                message: response,
                duration: 3000,
            });

            $('#observation_modal #observation').val("");
            $('#observation_modal #observation').attr("data-livraisons", "");
            $('#observation_modal').modal("hide")
            table.ajax.reload();
        } catch (error) {
            window.notyf.dismissAll();
            console.log(error);
            if (error.response && error.response.data) {
                const message = error.response.data.error;
                window.notyf.error(message);
            } else {
                window.notyf.error('Something went wrong!');
            }
        }
    });

    $('body').on('click', '#pdfLivraison', function (e) {
        e.preventDefault();
        livraison = $(this).attr('data-id');

        let url = Routing.generate('app_pharmacy_exports_export_pdf_livraison', {
            livraison: livraison
        });

        window.open(url, '_blank');
    })
});
