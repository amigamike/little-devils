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

        $('#' + id + ' input[name=query]').on('keypress', function(e) {
            if(e.which == 13) {
                local.search();
            }
        });

        var location = window.location.href;
        var splits = location.split('?');
        if (splits[1]) {
            var params = {};
            var entries = (new URLSearchParams(splits[1])).entries();
            
            for(var entry of entries) {
                params[entry[0]] = entry[1];
            }
            url = this.appendUrl(this.url, params);
        }
        
        this.get(url);
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
            if (appends[key] == undefined) {
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
        if (hasParams == false) {
            url = url.replace(/\?+$/,'');
        }

        return url;
    }

    buildList(data) {
        if (data == undefined || data == null) {
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
        if (data == undefined || data == null) {
            $('#' + this.id + ' ul.pagination').html('');
            return;
        }

        var local = this;
        var params = {};
        params.page = '';

        var html = '<li class="page-item">';
        html += '<span class="btn-pagination page-link';
        if (data.current_page != 1) {
            params.page = data.current_page - 1;
            html += '" data-href="' + this.appendUrl(window.location.href, params) + '"';
        } else {
            html += ' disabled"';
        }
        html += '>Prev</span>';
        html += '</li>';
        for(var iLoop = data.start; iLoop <= data.end; iLoop++) {
            html += '<li class="page-item';
            if (iLoop == data.current_page) {
                html += ' active';
            }
            html += '"><span class="btn-pagination page-link" data-href="';
            params.page = iLoop;
            html += this.appendUrl(window.location.href, params);
            html += '">' + iLoop + '</span></li>';
        }
        html += '<li class="page-item">';
        html += '<span class="btn-pagination page-link';
        if (data.current_page != data.end) {
            params.page = data.current_page + 1;
            html += '" data-href="' + this.appendUrl(window.location.href, params) + '"';
        } else {
            html += ' disabled"';
        }
        html += '>Next</span></li>';

        $('#' + this.id + ' ul.pagination').html(html);

        $('.btn-pagination').unbind('click');
        $('.btn-pagination').bind('click', function() {
            var location = $(this).data('href');
            if (location == null || location == undefined) {
                return;
            }

            var splits = location.split('?');
            if (splits[1]) {
                var params = {};
                var entries = (new URLSearchParams(splits[1])).entries();
                
                for(var entry of entries) {
                    params[entry[0]] = entry[1];
                }

                if(history.pushState) {
                    history.pushState(null, null, local.appendUrl(window.location.href, params));
                }

                local.get(local.appendUrl(local.url, params));
            }
        });
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

        var url = this.appendUrl(this.url, params);
        this.get(url);
        
        if(history.pushState) {
            params.page = 1;
            url = this.appendUrl(window.location.href, params);
            history.pushState(null, null, url);
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
        params.page = 1;
        this.get(this.appendUrl(this.url, params));
        
        if(history.pushState) {
            history.pushState(null, null, this.appendUrl(window.location.href, params));
        }

        $('#' + this.id + ' .search-clear').show();
    }
}