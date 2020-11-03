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

function loadPeopleSelect() {
    api.get(
        '/people/list',
        'buildPeopleSelect',
        'apiFailed'
    );
}

function removeContact(data) {
    $('#contact-' + data.id).remove();

    $.toast({
        heading: 'Contact removed',
        text: data.message,
        icon: 'success',
        loader: true,
        position: 'bottom-right'
    });
}

function renderContact(data) {
    var html = '<tr id="contact-' + data.id + '"><td>' + dateUk(data.created_at) + '</td>';
    html += '<td>' + data.first_name + ' ' + data.last_name + '</td>';
    html += '<td>' + data.phone_no + '</td>';
    html += '<td class="text-center">';
    html += '<button data-id="' + data.id + '" type="button" class="btn btn-danger btn-sm btn-delete-contact"><i class="fa fa-trash"></i></button>';
    html += '</td></tr>';
    return html;
}

function saveContact(data) {
    $('#contact input[name=first_name]').val('');
    $('#contact input[name=last_name]').val('');
    $('#contact input[name=phone_no]').val('');
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
    }

    $('#form-save').show();
}

$(function() {
    if (loggedIn) {
        loadPeopleSelect();
    }

    $('#add-contact').click(function () {
        var data = {};
        data.first_name = $('#contact input[name=first_name]').val();
        data.last_name = $('#contact input[name=last_name]').val();
        data.phone_no = $('#contact input[name=phone_no]').val();

        api.post(
            '/contacts/' + $('#child-data input[name=id]').val(),
            data,
            'saveContact',
            'apiFailed'
        );
    });

    $('#form-save').click(function() {
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
                data.child_id = $('#' + source + ' input[name=child_id]').val();
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
});