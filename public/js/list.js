/**
 * List class for javascript.
 *
 * @copyright   2020 Mike Welsh
 * @author      Mike Welsh (mike@amigamike.com)
 * @version     0.0.1
 */

class List {
    id = '';
    map = {};

    constructor(id, map) {
        this.id = id;
        this.map = map;
    }

    buildList(data) {
        var html = '';
        var local = this;
        $.each(data, function (i, row) {
            html += '<tr>';
            $.each(local.map, function (i2, item) {
                html += '<td>';
                if (item.toLowerCase() == 'status') {
                    html += local.buildStatus(row[item]);
                } else {
                    html += row[item];
                }
                html += '</td>';
            });
            html += '</tr>';
        });

        $('#' + this.id + ' tbody').html(html);
    }

    buildPagination(data) {
        var html = '<li class="page-item">';
        html += '<a class="page-link';
        if (data.current_page != 1) {
            html += '" href="' + window.location + '?page=' + (data.current_page - 1) + '"';
        } else {
            html += ' disabled" href="#"';
        }
        html += '>Prev</a>';
        html += '</li>';
        for(var iLoop = data.start; iLoop <= data.end; iLoop++) {
            html += '<li class="page-item';
            if (iLoop == data.current_page) {
                html += ' active';
            }
            html += '"><a class="page-link" href="';
            html += window.location + '?page=' + iLoop;
            html += '">' + iLoop + '</a></li>';
        }
        html += '<li class="page-item"><a class="page-link" href="#">Next</a></li>';

        $('#' + this.id + ' ul.pagination').html(html);
    }

    buildStatus(status) {
        switch (status.toLowerCase()) {
            case 'active':
                return '<span class="badge badge-success">Active</span>';
            case 'inactive':
                return '<span class="badge badge-warning">Inactive</span>';
            case 'deleted':
                return '<span class="badge badge-danger">Deleted</span>';
            default:
                return status;
        }
    }

    failedList(data) {
        $.toast({
            heading: 'Error',
            text: data.message,
            icon: 'error',
            loader: true,
            loaderBg: '#f97272',
            bgColor: '#e83c3c',
            position: 'bottom-right'
        });
    }

    get(url) {
        api.get(url, 'list.buildList', 'list.failedList', 'list.buildPagination');
    }
}