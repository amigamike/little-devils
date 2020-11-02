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
        });
    }
}

function buildPeopleSelect(data) {
    $('#select-child').html('<option value="0" disabled selected>Please select a child</option>');
    if (data) {
        $.each(data, function(i, item) {
            $('#select-child').append('<option value="' + item.id + '">' + item.first_name + ' ' + item.last_name + '</option>');
        });
    }
}

function loadPeopleSelect() {
    api.get(
        '/people/list',
        'buildPeopleSelect',
        'apiFailed'
    );
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
}

$(function() {
    if (loggedIn) {
        loadPeopleSelect();
    }

    $('#form-save').click(function() {
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

            api.post(
                '/people/' + $('#' + source + ' input[name=id]').val(),
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