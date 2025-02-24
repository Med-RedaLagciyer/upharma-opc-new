$(document).ready(function () {
    var previousXhr = null;

    $("select").select2();

    var brd_array = [];

    if ($.fn.dataTable.isDataTable("#list_brd")) {
        $("#list_brd").DataTable().clear().destroy();
    }

    var table = $("#list_brd").DataTable({
        lengthMenu: [
            [10, 15, 25, 50, 100, 20000000000000],
            [10, 15, 25, 50, 100, "All"],
        ],
        order: [[0, "asc"]],
        ajax: {
            url: Routing.generate("app_pharmacy_brd_list"),
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
            { name: "brd.id", data: "id" },
            { name: "brd.code", data: "code_brd" },
            { name: "brd.created", data: "date" },
            { name: "COUNT(livs.id)", data: "livraison_count" },
            { name: "brd.observation", data: "observation" },
            // { name: 'actions', date: null, orderable: false, searchable: false, render: function (data,type, full) {
            //     var actionsHtml = `<div class="dropdown" style="">
            //                 <svg class="icon" fill="black" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            //                     <circle cx="12" cy="5" r="2"></circle>
            //                     <circle cx="12" cy="12" r="2"></circle>
            //                     <circle cx="12" cy="19" r="2"></circle>
            //                 </svg>
            //                 <div class="actions dropdown-menu dashboard-dropdown dropdown-menu-center mt-2 py-1">`;
            //         window.globalActions.forEach(function (action) {
            //             actionsHtml += `
            //                 <a href="#" data-id="${full.id}" class="dropdown-item ${action.className}"><i class="fa ${action.icon}"></i>&nbsp;${action.nom}</a>`;
            //         });
            //         actionsHtml += '</div>';
            //         return actionsHtml;
            // } },
        ],
        columnDefs: [
            {
                targets: 0,
                orderable: false,
                searchable: false,
                // render: function (data, type, full, meta) {
                //     var checked = brd_array.includes(data) ? 'checked' : '';
                //     return `<input type="checkbox" class="selectLBRD" data-id="${data}" ${checked}>`;
                // }
            },
            {
                targets: 1,
                render: function (data, type, full, meta) {
                    if (data) {
                        return `<a href="#" data-id="${full.id}" class="pdfBRD">${data}</a>`;
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
                    if (data) {
                        return `<span id="truncated-text" title="${data}">${data.length > 40 ? data.substring(0, 40) + "..." : data}</span>`;
                    }
                    return data;
                }
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
            $(".selectAllBRD").on("change", function () {
                var isChecked = $(this).prop('checked');
                $("input.selectLBRD").each(function() {
                    $(this).prop('checked', isChecked);
                    var id = $(this).data('id');
                    if (isChecked && !brd_array.includes(id)) {
                        brd_array.push(id);
                    } else if (!isChecked && brd_array.includes(id)) {
                        brd_array = brd_array.filter(item => item !== id);
                    }
                });
            });

            $('#list_brd tbody').on('change', 'input.selectLBRD', function () {
                var id = $(this).data('id');
                if ($(this).prop('checked')) {
                    if (!brd_array.includes(id)) {
                        brd_array.push(id);
                    }
                } else {
                    brd_array = brd_array.filter(item => item !== id);
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
        var allChecked = $("#list_brd tbody input.selectLBRD").length === $("#list_brd tbody input.selectLBRD:checked").length;
        $(".selectAllBRD").prop('checked', allChecked);
    }

    $('body').on('click', '.pdfBRD', function (e) {
        e.preventDefault();
        brd_id = $(this).attr('data-id');

        let url = Routing.generate('app_pharmacy_exports_export_pdf_brd', {
            brd_id: brd_id
        });

        window.open(url, '_blank');
    })

    $('body').on('click', '#extractionBRD', function (e) {
        e.preventDefault();

        let url = Routing.generate('app_pharmacy_exports_export_excel_brd');

        window.open(url, '_blank');
    })
});
