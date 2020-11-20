var saveCount = 0;
var sources = [
    'child-data',
    'parent-data-1',
    'parent-data-2',
];

function addContact() {    
    var validator = $("#contactModal form").validate();
    if (!validator.form()) {
        missingRequired();
        return;
    }

    var data = {};
    data.first_name = $('#contactModal input[name=first_name]').val();
    data.last_name = $('#contactModal input[name=last_name]').val();
    data.type = 'contact';
    data.phone_no = $('#contactModal input[name=phone_no]').val();
    data.email = $('#contactModal input[name=email]').val();
    data.title = $('#contactModal select[name=title]').val();
    data.relationship = $('#contactModal input[name=relationship]').val();
    data.child_id = $('#contactModal input[name=child_id]').val();

    api.post(
        '/contacts/' + $('#contactModal input[name=child_id]').val(),
        data,
        'contactSaved'
    );
}

function addParent() {    
    var validator = $("#parentModal form").validate();
    if (!validator.form()) {
        missingRequired();
        return;
    }

    var data = {};
    data.first_name = $('#parentModal input[name=first_name]').val();
    data.last_name = $('#parentModal input[name=last_name]').val();
    data.dob = $('#parentModal input[name=dob]').val();
    data.address_line_1 = $('#parentModal input[name=address_line_1]').val();
    data.address_line_2 = $('#parentModal input[name=address_line_2]').val();
    data.city = $('#parentModal input[name=city]').val();
    data.county = $('#parentModal input[name=county]').val();
    data.postcode = $('#parentModal input[name=postcode]').val();
    data.type = 'parent';
    data.phone_no = $('#parentModal input[name=phone_no]').val();
    data.email = $('#parentModal input[name=email]').val();
    data.title = $('#parentModal select[name=title]').val();
    data.relationship = $('#parentModal input[name=relationship]').val();
    data.child_id = $('#parentModal input[name=child_id]').val();

    api.post(
        '/people/add',
        data,
        'parentSaved'
    );
}

function buildPeopleEdit(data) {
    $('#child-data input[name=id]').val(data.id);
    $('#child-data input[name=first_name]').val(data.first_name);
    $('#child-data input[name=last_name]').val(data.last_name);
    $('#child-data input[name=dob]').val(data.dob);
    $('#child-data input[name=address_line_1]').val(data.address_line_1);
    $('#child-data input[name=address_line_2]').val(data.address_line_2);
    $('#child-data input[name=city]').val(data.city);
    $('#child-data input[name=county]').val(data.county);
    $('#child-data input[name=postcode]').val(data.postcode);
    $('#child-data select[name=room]').val(data.room_id);

    if (data.parents) {
        $.each(data.parents, function (i, parent) {
            $('#parent-data-' + (i + 1) + ' input[name=id]').val(parent.id);
            $('#parent-data-' + (i + 1) + ' input[name=first_name]').val(parent.first_name);
            $('#parent-data-' + (i + 1) + ' input[name=last_name]').val(parent.last_name);
            $('#parent-data-' + (i + 1) + ' input[name=dob]').val(parent.dob);
            $('#parent-data-' + (i + 1) + ' input[name=address_line_1]').val(parent.address_line_1);
            $('#parent-data-' + (i + 1) + ' input[name=address_line_2]').val(parent.address_line_2);
            $('#parent-data-' + (i + 1) + ' input[name=city]').val(parent.city);
            $('#parent-data-' + (i + 1) + ' input[name=county]').val(parent.county);
            $('#parent-data-' + (i + 1) + ' input[name=postcode]').val(parent.postcode);
            $('#parent-data-' + (i + 1) + ' input[name=child_id]').val(data.id);
            $('#parent-data-' + (i + 1) + ' input[name=email]').val(parent.email);
            $('#parent-data-' + (i + 1) + ' input[name=phone_no]').val(parent.phone_no);
            $('#parent-data-' + (i + 1) + ' input[name=relationship]').val(parent.relationship);
            $('#parent-data-' + (i + 1) + ' select[name=title]').val(parent.title);
        });
    }

    $('#contacts').html('');

    if (data.contacts) {
        $.each(data.contacts, function (i, contact) {
            $('#contacts').append(renderContact(contact));
        });

        $('.btn-delete-contact').unbind('click');
        $('.btn-delete-contact').bind('click', function () {
            deleteContact(this);
        });
    }

    if (data.logs) {
        $.each(data.logs, function (i, log) {
            $('#logs tbody').append(renderLog(log));
        });

        $('.btn-delete-log').unbind('click');
        $('.btn-delete-log').bind('click', function () {
            deleteLog(this);
        });
    }

    if (data.invoices) {
        $.each(data.invoices, function (i, invoice) {
            $('#invoices tbody').append(renderInvoice(invoice));
        });

        $('.btn-delete-invoice').unbind('click');
        $('.btn-delete-invoice').bind('click', function () {
            deleteInvoice(this);
        });

        $('.btn-paid-invoice').unbind('click');
        $('.btn-paid-invoice').bind('click', function () {
            payInvoice(this);
        });
    }

    $('.btn-form').prop('disabled', false);

    $.toast({
        heading: 'Load complete',
        text: data.message,
        icon: 'success',
        loader: true,
        position: 'bottom-right'
    });

    $('#form-save').show();
}

function buildPeopleSelect(data) {
    $('#select-child').html('<option value="0" disabled selected>Please select a child</option>');
    if (data) {
        $.each(data, function(i, item) {
            $('#select-child').append('<option value="' + item.id + '">' + item.first_name + ' ' + item.last_name + '</option>');
        });
    }
}

function buildReport(data) {
    if (!data[0]) {
        $.toast({
            heading: 'Oops',
            text: 'There is nothing to report',
            icon: 'info',
            loader: true,
            position: 'bottom-right'
        });
        return;
    }

    $('#report-name').html(data[0].room_name);

    var labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];
    var values = [];

    $('#report-details').html('');

    $.each(data, function (i, item) {
        values.push(item.total);
        $('#report-details').append(
            '<tr>' +
            '<td>' + (i + 1) + '</td>' +
            '<td>' + dateMonth(item.period) + '</td>' +
            '<td>' + item.room_fee + '&nbsp;<span class="percent">(' + calPercent(item.total, item.room_fee) + '%)</td>' +
            '<td>' + item.funding + '&nbsp;<span class="percent">(' + calPercent(item.total, item.funding) + '%)</td>' +
            '<td>' + item.total + '</td>' +
            '</tr>'
        );
    });

    var ctx = document.getElementById('report-chart');
    var lineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: [
                {
                    label: data[0].room_name,
                    data: values,
                    backgroundColor: "rgba(255, 99, 132, 0.2)",
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 1,
                    fill: false,
                    lineTension: 0
                }
            ]
        },
        options: {
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });

    $.toast({
        heading: 'Success',
        text: 'Generated the report',
        icon: 'success',
        loader: true,
        position: 'bottom-right'
    });
}

function buildRoomsSelect(data) {
    $('select[name=room]').html('<option value="0" disabled selected>Please select a room</option>');
    if (data) {
        $.each(data, function(i, item) {
            $('select[name=room]').append('<option value="' + item.id + '">' + item.name + '</option>');
        });
    }
}

function buildRoomsStats(data) {
    if (data == undefined || data == null) {
        return;
    }

    var html = '';

    $(data).each(function (i, room) {
        html += '<li class="c-sidebar-nav-item px-3 c-d-compact-none c-d-minimized-none pb-3">';
        html += '<div class="text-uppercase mb-1">';
        html += '<small>';
        html += '<strong>' + room.name + '</strong>';
        html += '</small>';
        html += '</div>';
        html += '<div class="progress progress-xs">';
        html += '<div class="progress-bar bg-warning" role="progressbar" style="width: ' + ((room.staff / room.capacity) * 100) + '%" aria-valuenow="' + ((room.staff / room.capacity) * 100) + '" aria-valuemin="0" aria-valuemax="100"></div>';
        html += '<div class="progress-bar bg-danger" role="progressbar" style="width: ' + ((room.children / room.capacity) * 100) + '%" aria-valuenow="' + ((room.children / room.capacity) * 100) + '" aria-valuemin="0" aria-valuemax="100"></div>';
        html += '<div class="progress-bar bg-primary" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>';           
        html += '</div>';
        html += '<small class="text-muted">';
        html += '<span class="c-sidebar-nav-title p-0">Staff</span> <span class="text-warning">' + room.staff + '</span> / ';
        html += '<span class="c-sidebar-nav-title p-0">Children</span> <span class="text-danger">' + room.children + '</span> / '; 
        html += '<span class="c-sidebar-nav-title p-0">Capacity</span> <span class="text-primary">' + room.capacity + '</span>';
        html += '</small>';
        html += '</li>';
    });

    $('#sidebar-menu').append(html);
}

function buildStats(data) {
    $('#people-present').html(data.present);
    $('#people-absent').html(data.absent);
    $('#people-left').html(data.left);
}

function calPercent(total, value) {
    return ((value/total) * 100).toFixed(2);
}

function contactSaved(data) {
    var html = '';
    html += '<tr id="contact-' + data.id +'">';
    html += '<td>';
    html += data.relationship;
    html += '</td>';
    html += '<td>';
    html += data.full_name;
    html += '</td>';
    html += '<td>';
    html += data.phone_no;
    if (data.email) {
        html += '</br>';
        html += '<a href="mailto:' + data.email + '" target="_blank">';
        html += data.email;
        html += '</a>';
    }
    html += '</td>';
    html += '<td class="text-right">';
    html += '<button class="delete-contact btn btn-danger" title="Delete the contact" type="button" data-id="' + data.id +'">'
    html += '<i class="fas fa-trash"></i>';
    html += '</button>';
    html += '</td>';
    html += '</tr>';
    $('#contacts-list tbody').append(html);

    $('.delete-contact').unbind('click');
    $('.delete-contact').bind('click', function () {
        deleteContact(this);
    });

    $('#contactModal button[data-dismiss=modal]').click();

    $.toast({
        heading: 'Contact added',
        text: data.message,
        icon: 'success',
        loader: true,
        position: 'bottom-right'
    });
}

function dateMonth(date) {
    var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
    date = new Date(date);
    return months[date.getMonth()] + ' ' + date.getFullYear();
}

function dateUk(date) {
    date = new Date(date);
    return ((date.getDate() < 10) ? '0' + date.getDate() : date.getDate())  + '/' + date.getMonth() + '/' + date.getFullYear();
}

function deleteContact(entry) {
    api.delete(
        '/contacts/' + $(entry).attr('data-id'),
        'removeContact',
        'apiFailed'
    );
}

function deleteInvoice(entry) {
    api.delete(
        '/invoices/' + $(entry).attr('data-id'),
        'removeInvoice',
        'apiFailed'
    );
}

function deleteLog(entry) {
    api.delete(
        '/logs/' + $(entry).attr('data-id'),
        'removeLog',
        'apiFailed'
    );
}

function deleteParent(entry) {
    api.delete(
        '/people/' + $(entry).attr('data-id'),
        'removeParent'
    );
}

function missingRequired(message = 'Please double check each of the forms') {
    $.toast({
        heading: 'Missing required fields',
        text: message,
        icon: 'error',
        loader: true,
        loaderBg: '#f97272',
        bgColor: '#e83c3c',
        position: 'bottom-right'
    });
}

function paidInvoice(data) {
    $('#invoice-' + data.id + ' .invoice-status').html(data.status);

    $.toast({
        heading: 'Invoice marked as paid',
        text: '',
        icon: 'success',
        loader: true,
        position: 'bottom-right'
    });
}

function parentSaved(data) {
    var html = '';
    html += '<tr id="parent-' + data.id +'">';
    html += '<td>';
    html += data.relationship;
    html += '</td>';
    html += '<td>';
    html += data.full_name;
    html += '</td>';
    html += '<td>';
    html += data.phone_no;
    if (data.email) {
        html += '</br>';
        html += '<a href="mailto:' + data.email + '" target="_blank">';
        html += data.email;
        html += '</a>';
    }
    html += '</td>';
    html += '<td class="text-right">';
    html += '<button class="delete-parent btn btn-danger" title="Delete the parent" type="button" data-id="' + data.id +'">'
    html += '<i class="fas fa-trash"></i>';
    html += '</button>';
    html += '</td>';
    html += '</tr>';
    $('#parents-list tbody').append(html);

    $('.delete-parent').unbind('click');
    $('.delete-parent').bind('click', function () {
        deleteParent(this);
    });

    $('#parentModal button[data-dismiss=modal]').click();

    $.toast({
        heading: 'Parent added',
        text: data.message,
        icon: 'success',
        loader: true,
        position: 'bottom-right'
    });
}

function payInvoice(entry) {
    api.patch(
        '/invoices/' + $(entry).attr('data-id'),
        null,
        'paidInvoice',
        'apiFailed'
    );
}

function removeContact(data) {
    $('#contact-' + data.id).remove();

    $.toast({
        heading: 'Contact removed',
        text: '',
        icon: 'success',
        loader: true,
        position: 'bottom-right'
    });
}

function removeInvoice(data) {
    $('#invoice-' + data.id).remove();

    $.toast({
        heading: 'Invoice removed',
        text: '',
        icon: 'success',
        loader: true,
        position: 'bottom-right'
    });
}

function removeLog(data) {
    $('#log-' + data.id).remove();

    $.toast({
        heading: 'Log removed',
        text: '',
        icon: 'success',
        loader: true,
        position: 'bottom-right'
    });
}

function removeParent(data) {
    $('#parent-' + data.id).remove();

    $.toast({
        heading: 'Parent removed',
        text: '',
        icon: 'success',
        loader: true,
        position: 'bottom-right'
    });
}

function renderInvoice(data) {
    var html = '<tr id="invoice-' + data.id + '"><td>' + dateUk(data.created_at) + '</td>';
    html += '<td>' + data.full_name + '</td>';
    html += '<td>' + data.type + '</td>';
    html += '<td>' + data.amount + '</td>';
    html += '<td class="invoice-status">' + data.status + '</td>';
    html += '<td>' + data.note + '</td>';
    html += '<td width="120px" class="text-center">';
    html += '<button data-id="' + data.id + '" type="button" class="btn btn-danger btn-sm btn-delete-invoice" title="Mark the invoice as deleted"><i class="fa fa-trash"></i></button>';
    html += '<button data-id="' + data.id + '" type="button" class="btn btn-success btn-sm btn-paid-invoice ml-2" title="Mark the invoice as paid"><i class="fas fa-check"></i></button>';
    html += '</td></tr>';
    return html;
}

function renderLog(data) {
    var html = '<tr id="log-' + data.id + '"><td>' + dateUk(data.created_at) + '</td>';
    html += '<td>' + ((data.group_name) ? data.group_name : 'Unknown') + '</td>';
    html += '<td>' + data.type + '</td>';
    html += '<td>' + data.info + '</td>';
    html += '<td class="text-center">';
    html += '<button data-id="' + data.id + '" type="button" class="btn btn-danger btn-sm btn-delete-log"><i class="fa fa-trash"></i></button>';
    html += '</td></tr>';
    return html;
}

function saveInvoice(data) {
    $('#invoices input[name=amount]').val('');
    $('#invoices textarea[name=note]').val('');
    $('#invoices tbody').append(renderInvoice(data));

    $('.btn-delete-invoice').unbind('click');
    $('.btn-delete-invoice').bind('click', function () {
        deleteInvoice(this);
    });

    $('.btn-paid-invoice').unbind('click');
    $('.btn-paid-invoice').bind('click', function () {
        paidInvoice(this);
    });

    $.toast({
        heading: 'Invoice added',
        text: data.message,
        icon: 'success',
        loader: true,
        position: 'bottom-right'
    });
}

function saveLog(data) {
    $('#tab-logs textarea[name=info]').text('');
    $('#tab-logs tbody').append(renderLog(data));

    $('.btn-delete-log').unbind('click');
    $('.btn-delete-log').bind('click', function () {
        deleteLog(this);
    });

    $.toast({
        heading: 'Log added',
        text: data.message,
        icon: 'success',
        loader: true,
        position: 'bottom-right'
    });
}

$(function() {
    $('#add-invoice').click(function () {
        var data = {};
        var missing = false;
        data.type = $('#invoices select[name=type]').val();
        data.person_id = $('#child-data input[name=id]').val();

        data.amount = $('#invoices input[name=amount]').val();
        $('#invoices input[name=amount]').removeClass('error');
        if (!data.amount) {
            $('#invoices input[name=amount]').addClass('error');
            missing = true;
        }

        data.note = $('#invoices textarea[name=note]').val();

        if (missing) {
            missingRequired();
            return;
        }

        api.post(
            '/invoices/add',
            data,
            'saveInvoice',
            'apiFailed'
        );
    });

    $('#add-log').click(function () {
        var data = {};
        data.type = $('#tab-logs select[name=log-type]').val();
        data.person_id = $('#tab-child input[name=id]').val();

        data.info = $('#tab-logs textarea[name=info]').val();
        $('#tab-logs textarea[name=info]').removeClass('error');
        if (!data.info) {
            missingRequired();
            $('#tab-logs textarea[name=info]').addClass('error');
            return;
        }

        api.post(
            '/logs/add',
            data,
            'saveLog',
            'apiFailed'
        );
    });

    $('#add-contact').click(function () {
        addContact();
    });

    $('.delete-contact').bind('click', function () {
        deleteContact(this);
    });

    $('.delete-log').bind('click', function () {
        deleteLog(this);
    });

    $('#add-parent').click(function () {
        addParent();
    });

    $('.delete-parent').bind('click', function () {
        deleteParent(this);
    });

    $('.datepicker').datepicker({
        format:'dd/mm/yyyy',
        autoclose: true
    });

    $('#generate-report').click(function () {
        api.get(
            '/revenue?room=' + $('#reports select[name=room]').val() + '&year=' + $('#reports select[name=year]').val(),
            'buildReport',
            'apiFailed'
        );
    });

    $('#form-save').click(function() {
        var validator = $("#form-data").validate();
        if (!validator.form()) {
            missingRequired();
            return;
        }

        $('#form-data').submit();
    });

    $('#save-biter').click(function() {
        var validator = $("#form-data").validate();
        if (!validator.form()) {
            missingRequired();
            return;
        }

        $('#form-data input[name=biter]').val($('#biterModal input[name=biter]:checked').val());

        $('#form-data').submit();
    });

    $('#save-toilet').click(function() {
        var validator = $("#form-data").validate();
        if (!validator.form()) {
            missingRequired();
            return;
        }

        $('#form-data input[name=toilet_trained]').val($('#toiletModal input[name=toilet_trained]:checked').val());

        $('#form-data').submit();
    });

    $('#select-child').change(
        function() {
            api.get(
                '/people/' + this.value,
                'buildPeopleEdit',
                'apiFailed'
            );
        }
    );

    $('#select-child').select2();
});