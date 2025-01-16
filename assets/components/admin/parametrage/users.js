$(document).ready(function () {
    var previousXhr = null;

    $("select").select2();

    if ($.fn.dataTable.isDataTable("#list_users")) {
        $("#list_users").DataTable().clear().destroy();
    }

    const checkInputIfAllChildAreChecked = () => {
        $(".sousModules").map(function () {
            if ($(this).parent().find('.inputOperation').not(':checked').length === 0) {
                $(this).find(".inputSousModule").prop("checked", true);
            }
        })

        $(".modules").map(function () {
            if ($(this).parent().find('.inputSousModule').not(':checked').length === 0) {
                $(this).find(".inputModule").prop("checked", true);
            }
        })

        if ($('.modules').find(".inputModule").not(':checked').length === 0) {
            $('.tous').prop("checked", true);
        }
    }

    var table = $("#list_users").DataTable({
        lengthMenu: [
            [10, 15, 25, 50, 100, 20000000000000],
            [10, 15, 25, 50, 100, "All"],
        ],
        order: [[0, "desc"]],
        ajax: {
            url: Routing.generate("app_admin_parametrage_users_list"),
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
        },
        processing: true,
        serverSide: true,
        deferRender: true,
        responsive: true,
        columns: [
            { name: "u.id", data: "id" },
            { name: "u.username", data: "username" },
            { name: "u.nom", data: "nom" },
            { name: "u.prenom", data: "prenom" },
            { name: "u.email", data: "email" },
            { name: "u.roles", data: "roles" },
            { name: "u.created", data: "created" },
            { name: "u.enable", data: "enable" },
            { orderable: false, searchable: false, data: "id" },
        ],
        columnDefs: [
            {
                targets: 5,
                render: function (data, type, full, meta) {
                    let roles = "";
                    data.forEach(function (role) {
                        if (role == "ROLE_ADMIN") color = "azure";
                        if (role == "ROLE_USER") color = "green";
                        if (role == "ROLE_SUPERADMIN") color = "red";
                        roles += `<span class="badge bg-${color}  text-white -fg mx-1">${role}</span>`;
                    });
                    return roles;
                },
            },
            {

                targets: 6,
                render: function (data, type, full, meta) {
                    if (data) {
                        return window.moment(data.date).format('YYYY-MM-DD HH:mm:ss');
                    } else {
                        return "NULL"
                    }
                },
            },
            {
                targets: 7,
                render: function (data, type, full, meta) {
                    if (data == 1) {
                        return `<i class="fa-solid fa-circle-check" style="color: #1fbe8e;"></i>`;
                    } else {
                        return `<i class="fa-solid fa-ban" style="color: #e70c53;"></i>`;
                    }
                },
            },

            {
                targets: 8,
                render: function (data, type, full, meta) {
                    return `
                        <div class="dropdown" style="">
                            <svg class="icon" fill="black" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <circle cx="12" cy="5" r="2"></circle>
                                <circle cx="12" cy="12" r="2"></circle>
                                <circle cx="12" cy="19" r="2"></circle>
                            </svg>
                            <div class="actions dropdown-menu dashboard-dropdown dropdown-menu-center mt-2 py-1">
                                <a href="#" data-id="${full.id}" class="dropdown-item toggleEnable">${full.enable == 1 ? "<i class='fa fa-ban'></i>&nbsp; Dévalider" : "<i class='fa fa-circle-check'></i>&nbsp; Valider"}</a>
                                <a href="#" data-id="${full.id}" class="dropdown-item privilegeBtn"><i class='fa fa-circle-plus'></i>&nbsp; Privilége</a>
                            </div>
                        </div>
                    `;
                },
            },
        ],
        language: datatablesFrench,
        initComplete: function () {
            // Prevent sorting when interacting with select in header
            $("thead .selection").on("click", function (e) {
                e.stopPropagation();
            });
        },
    });

    // privilege
    $('body').on('click', '.privilegeBtn', async function (e) {
        e.preventDefault();
        let id_user = $(this).attr('data-id');
        $(".privilege input:checkbox").prop("checked", false);
        try {
            const request = await axios.post(
                Routing.generate('app_admin_parametrage_users_operation', { user: id_user })
            );
            const response = await request.data;
            response.map(element => {
                console.log(element);
                $(".buttons ." + element.id).prop("checked", true);
            })
            checkInputIfAllChildAreChecked();
            $(".privilege input:checkbox").attr("data-user", id_user);
            $('#privilegeModal').modal("show")
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

    $(".Collapsable").on("click", function () {

        $(this).parent().children().toggle();
        $(this).toggle();

    });
    $(".inputSousModule").on('click', async function () {
        let url;
        let id_user = $(this).attr('data-user');

        let sous_module = $(this).attr("data-module");
        if ($(this).is(":checked")) {
            $(this).parent().parent().find(".inputOperation").prop("checked", true);
            url = "/admin/parametrage/users/sousmodule/" + sous_module + "/" + id_user + "/add";
        } else {
            $(this).parent().parent().find(".inputOperation").prop("checked", false);
            url = "/admin/parametrage/users/sousmodule/" + sous_module + "/" + id_user + "/remove";

        }
        checkInputIfAllChildAreChecked()
        try {
            const request = await axios.post(url);
            const response = request.data;
        } catch (error) {
            const message = error.response.data;
            Toast.fire({
                icon: 'error',
                title: message,
            })
        }
    })
    $(".inputModule").on('click', async function () {
        let url;
        let module = $(this).attr("data-id");
        let id_user = $(this).attr('data-user');
        if ($(this).is(":checked")) {
            $(this).parent().parent().find("input:checkbox").prop("checked", true);
            url = "/admin/parametrage/users/module/" + module + "/" + id_user + "/add";
        } else {
            $(this).parent().parent().find("input:checkbox").prop("checked", false);
            url = "/admin/parametrage/users/module/" + module + "/" + id_user + "/remove";

        }
        checkInputIfAllChildAreChecked();
        try {
            const request = await axios.post(url);
            const response = request.data;
        } catch (error) {
            const message = error.response.data;
            Toast.fire({
                icon: 'error',
                title: message,
            })
        }
    })
    $(".inputOperation").on('click', async function () {
        let url;
        let id_user = $(this).attr('data-user');
        let operation = $(this).attr("data-operation");
        if ($(this).is(":checked")) {
            url = "/admin/parametrage/users/operation/" + operation + "/" + id_user + "/add";
        } else {
            url = "/admin/parametrage/users/operation/" + operation + "/" + id_user + "/remove";

        }
        checkInputIfAllChildAreChecked();
        try {
            const request = await axios.post(url);
            const response = request.data;
        } catch (error) {
            const message = error.response.data;
            Toast.fire({
                icon: 'error',
                title: message,
            })
        }
    })
    $(".tous").on('click', async function () {
        let url;
        let id_user = $(this).attr('data-user');
        if ($(this).is(":checked")) {
            $(".tous").parent().parent().find("input:checkbox").prop("checked", true);
            url = "/admin/parametrage/users/all/" + id_user + "/add";
        } else {
            $(".tous").parent().parent().find("input:checkbox").prop("checked", false);
            url = "/admin/parametrage/users/all/" + id_user + "/remove";
        }
        checkInputIfAllChildAreChecked();
        try {
            const request = await axios.post(url);
            const response = request.data;
        } catch (error) {
            const message = error.response.data;
            Toast.fire({
                icon: 'error',
                title: message,
            })
        }
    })

    $('body').on('click', '.toggleEnable', async function (e) {
        e.preventDefault();
        try {
            let id = $(this).attr('data-id');
            window.notyf.open({
                type: "info",
                message: "En cours..",
                duration: 9000000,
            });
            const request = await axios.post(
                Routing.generate('app_parametrage_users_toggle_active', { user: id })
            );
            const response = await request.data;
            window.notyf.dismissAll();
            window.notyf.open({
                type: "success",
                message: "Succés",
                duration: 3000,
            });
            table.ajax.reload(false);
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
});
