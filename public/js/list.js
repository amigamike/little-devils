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
                html += '<td>' + row[item] + '</td>';
            });
            html += '</tr>';
        });

        $('#' + this.id + ' tbody').html(html);
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
        api.get(url, 'list.buildList', 'list.failedList');
    }
}