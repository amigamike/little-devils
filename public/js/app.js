var saveCount = 0;
var sources = [
    'child-data',
    'parent-data-1',
    'parent-data-2',
];

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

function calPercent(total, value) {
    return ((value/total) * 100).toFixed(2);
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

function loadPeopleSelect() {
    api.get(
        '/people?type=child',
        'buildPeopleSelect',
        'apiFailed'
    );
}

function loadRoomsSelect() {
    api.get(
        '/rooms',
        'buildRoomsSelect',
        'apiFailed'
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

function renderContact(data) {
    var html = '<tr id="contact-' + data.id + '"><td>' + dateUk(data.created_at) + '</td>';
    html += '<td>' + data.title + ' ' + data.first_name + ' ' + data.last_name + '</td>';
    html += '<td>' + data.phone_no + '</td>';
    html += '<td>' + data.relationship + '</td>';
    html += '<td class="text-center">';
    html += '<button data-id="' + data.id + '" type="button" class="btn btn-danger btn-sm btn-delete-contact"><i class="fa fa-trash"></i></button>';
    html += '</td></tr>';
    return html;
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

function saveContact(data) {
    $('#contact input[name=first_name]').val('');
    $('#contact input[name=last_name]').val('');
    $('#contact input[name=phone_no]').val('');
    $('#contact input[name=relationship]').val('');
    $('#contacts').append(renderContact(data));

    $('.btn-delete-contact').unbind('click');
    $('.btn-delete-contact').bind('click', function () {
        deleteContact(this);
    });

    $.toast({
        heading: 'Contact added',
        text: data.message,
        icon: 'success',
        loader: true,
        position: 'bottom-right'
    });
}

function saveData(data) {
    saveCount += 1;

    if (saveCount == sources.length) {
        $.toast({
            heading: 'Save complete',
            text: data.message,
            icon: 'success',
            loader: true,
            position: 'bottom-right'
        });

        api.get(
            '/people/' + $('#child-data input[name=id]').val(),
            'buildPeopleEdit',
            'apiFailed'
        );
    }
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
    $('#logs textarea[name=info]').text('');
    $('#logs tbody').append(renderLog(data));

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
    if (loggedIn) {
        //loadPeopleSelect();
        //loadRoomsSelect();
    }

    $('#add-contact').click(function () {
        var data = {};
        var missing = false;
        data.title = $('#contact select[name=title]').val();

        data.first_name = $('#contact input[name=first_name]').val();
        $('#contact input[name=first_name]').removeClass('error');
        if (!data.first_name) {
            $('#contact input[name=first_name]').addClass('error');
            missing = true;
        }

        data.last_name = $('#contact input[name=last_name]').val();
        $('#contact input[name=last_name]').removeClass('error');
        if (!data.last_name) {
            $('#contact input[name=last_name]').addClass('error');
            missing = true;
        }

        data.phone_no = $('#contact input[name=phone_no]').val();
        $('#contact input[name=phone_no]').removeClass('error');
        if (!data.phone_no) {
            $('#contact input[name=phone_no]').addClass('error');
            missing = true;
        }

        data.relationship = $('#contact input[name=relationship]').val();
        $('#contact input[name=relationship]').removeClass('error');
        if (!data.relationship) {
            $('#contact input[name=relationship]').addClass('error');
            missing = true;
        }

        if (missing) {
            missingRequired();
            return;
        }

        api.post(
            '/contacts/' + $('#child-data input[name=id]').val(),
            data,
            'saveContact',
            'apiFailed'
        );
    });

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
        data.type = $('#logs select[name=type]').val();
        data.person_id = $('#child-data input[name=id]').val();

        data.info = $('#logs textarea[name=info]').val();
        $('#logs textarea[name=info]').removeClass('error');
        if (!data.info) {
            missingRequired();
            $('#logs textarea[name=info]').addClass('error');
            return;
        }

        api.post(
            '/logs/add',
            data,
            'saveLog',
            'apiFailed'
        );
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

        $('#form-save').hide();
        saveCount = 0;

        $.each(sources, function(i, source) {
            var data = {};
            data.id = $('#' + source + ' input[name=id]').val();
            data.first_name = $('#' + source + ' input[name=first_name]').val();
            data.last_name = $('#' + source + ' input[name=last_name]').val();
            data.dob = $('#' + source + ' input[name=dob]').val();
            data.address_line_1 = $('#' + source + ' input[name=address_line_1]').val();
            data.address_line_2 = $('#' + source + ' input[name=address_line_2]').val();
            data.city = $('#' + source + ' input[name=city]').val();
            data.county = $('#' + source + ' input[name=county]').val();
            data.postcode = $('#' + source + ' input[name=postcode]').val();
            data.type = $('#' + source + ' input[name=type]').val();
            
            if (data.type == 'parent') {
                data.phone_no = $('#' + source + ' input[name=phone_no]').val();
                data.email = $('#' + source + ' input[name=email]').val();
                data.title = $('#' + source + ' select[name=title]').val();
                data.relationship = $('#' + source + ' input[name=relationship]').val();
                data.child_id = $('#' + source + ' input[name=child_id]').val();
            } else {
                data.room_id = $('#' + source + ' select[name=room]').val();
            }

            var action = 'add';

            if (data.id) {
                action = $('#' + source + ' input[name=id]').val();
            }

            api.post(
                '/people/' + action,
                data,
                'saveData',
                'apiFailed'
            );
        });
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