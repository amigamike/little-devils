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
    url = '';

    constructor(id, map, url) {
        this.id = id;
        this.map = map;
        this.url = url;

        var local = this;
        $('#' + id + ' button[name=search]').click(function () {
            local.search();
        });

        $('#' + id + ' button[name=clear]').click(function () {
            local.clearSearch();
        });

        this.get();
    }

    appendUrl(url, appends) {
        var hasParams = false;
        var splits = url.split('?');
        if (!splits[1]) {
            url += '?';
            $.each(appends, function(key, value) {
                if (value != '') {
                    url += key + '=' + value + '&';
                    hasParams = true;
                }
            });

            return url.replace(/&+$/,'');
        }

        var params = new URLSearchParams(splits[1]);
        url = splits[0] + '?';

        params.forEach(function(value, key) {
            if (appends[key] != '') {
                url += key + '=' + value + '&';
                hasParams = true;
            }
        });

        $.each(appends, function(key, value) {
            if (value != '') {
                url += key + '=' + value + '&';
                hasParams = true;
            }
        });

        url = url.replace(/&+$/,'');
        if (!hasParams) {
            url = url.replace(/\?+$/,'');
        }

        return url;
    }

    buildList(data) {
        if (!data.length) {
            $('#' + this.id + ' tbody').html('<tr><td colspan="' + this.map.length + '"><strong>No results</strong></td></tr>');
            $('#processing').hide();
            return;
        }

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

        $('#processing').hide();
    }

    buildPagination(data) {
        if (!data.total) {
            $('#' + this.id + ' ul.pagination').html('');
            return;
        }

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
        html += '<li class="page-item">';
        html += '<a class="page-link';
        if (data.current_page != data.end) {
            html += '" href="' + window.location + '?page=' + (data.current_page + 1) + '"';
        } else {
            html += ' disabled" href="#"';
        }
        html += '>Next</a></li>';

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

    clearSearch() {
        $('#' + this.id + ' input[name=query]').val('');
        $('#' + this.id + ' .search-clear').hide();

        var params = {};
        params.query = '';

        this.get(this.appendUrl(this.url, params));
        
        if(history.pushState) {
            history.pushState(null, null, this.appendUrl(window.location.href, params));
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

    get(url = '') {
        $('#processing').show();
        if (!url) {
            url = this.url;
        }
        api.get(url, 'list.buildList', 'list.failedList', 'list.buildPagination');
    }

    search() {
        var query = $('#' + this.id + ' input[name=query]').val();

        if (!query) {
            $.toast({
                heading: 'Missing required',
                text: 'Please enter a search query',
                icon: 'error',
                loader: true,
                loaderBg: '#f97272',
                bgColor: '#e83c3c',
                position: 'bottom-right'
            });
            return;
        }

        var params = {};
        params.query = query;
        this.get(this.appendUrl(this.url, params));
        
        if(history.pushState) {
            history.pushState(null, null, this.appendUrl(window.location.href, params));
        }

        $('#' + this.id + ' .search-clear').show();
    }
}