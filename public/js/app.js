function buildPeopleEdit(data) {
    $('input[name=child_id]').val(data.id);
    $('input[name=child_first_name]').val(data.first_name);
    $('input[name=child_last_name]').val(data.last_name);
    $('input[name=child_dob]').val(data.dob);
    $('input[name=child_address_line_1]').val(data.address_line_1);
    $('input[name=child_address_line_2]').val(data.address_line_2);
    $('input[name=child_city]').val(data.city);
    $('input[name=child_county]').val(data.county);
    $('input[name=child_postcode]').val(data.postcode);
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

$(function() {
    if (loggedIn) {
        loadPeopleSelect();
    }

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