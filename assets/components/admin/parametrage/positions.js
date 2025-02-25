$(document).ready(function () {
    var previousXhr = null;

    $("select").select2();

    var position_array = [];

    if ($.fn.dataTable.isDataTable("#list_positions")) {
        $("#list_positions").DataTable().clear().destroy();
    }

    var table = $("#list_positions").DataTable({
        lengthMenu: [
            [10, 15, 25, 50, 100, 20000000000000],
            [10, 15, 25, 50, 100, "All"],
        ],
        order: [[0, "asc"]],
        ajax: {
            url: Routing.generate("app_admin_parametrage_positions_list"),
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
            { name: "p.id", data: "id" },
            { name: "p.position", data: "position" },
            { name: "p.isReserved", data: "isReserved" },
            { name: "p.vip", data: "vip" },
            { name: "COUNT(livs.id)", data: "count_livs" },
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
                    var checked = position_array.includes(data) ? 'checked' : '';
                    return `<input type="checkbox" class="selectPosition" data-id="${data}" ${checked}>`;
                }
            },
            {
                targets: 2,
                render: function (data, type, full, meta) {
                    if (data) {
                        return `<i class="fa-solid fa-circle-check" style="color: #63E6BE;"></i>`;
                    }else{
                        return `<i class="fa-solid fa-circle-xmark" style="color: #f87c95;"></i>`;
                    }
                }
            },
            {
                targets: 3,
                render: function (data, type, full, meta) {
                    if (data) {
                        return `<i class="fa-solid fa-circle-check" style="color: #63E6BE;"></i>`;
                    }else{
                        return `<i class="fa-solid fa-circle-xmark" style="color: #f87c95;"></i>`;
                    }
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
            $(".selectAllPosition").on("change", function () {
                var isChecked = $(this).prop('checked');
                $("input.selectPosition").each(function() {
                    $(this).prop('checked', isChecked);
                    var id = $(this).data('id');
                    if (isChecked && !position_array.includes(id)) {
                        position_array.push(id);
                    } else if (!isChecked && position_array.includes(id)) {
                        position_array = position_array.filter(item => item !== id);
                    }
                });
            });

            $('#list_positions tbody').on('change', 'input.selectPosition', function () {
                var id = $(this).data('id');
                if ($(this).prop('checked')) {
                    if (!position_array.includes(id)) {
                        position_array.push(id);
                    }
                } else {
                    position_array = position_array.filter(item => item !== id);
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
        var allChecked = $("#list_positions tbody input.selectPosition").length === $("#list_positions tbody input.selectLivraison:checked").length;
        $(".selectAllPosition").prop('checked', allChecked);
    }

    $('body').on('click', '#extractionExcel', function (e) {
        e.preventDefault();

        let url = Routing.generate('app_pharmacy_exports_export_excel_positions');

        window.open(url, '_blank');
    })

});
