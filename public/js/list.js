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
    sort = '';
    sd = '';
    query = '';
    page = 1;
    edit_url = '';

    constructor(id, map, url, edit_url) {
        this.id = id;
        this.map = map;
        this.url = url;
        this.edit_url = edit_url;

        var local = this;

        var location = window.location.href;
        var splits = location.split('?');
        if (splits[1]) {
            var params = {};
            var entries = (new URLSearchParams(splits[1])).entries();
            
            for(var entry of entries) {
                params[entry[0]] = entry[1];
                if (entry[0] == 'query') {
                    $('#' + this.id + ' input[name=query]').val(entry[1]);
                    this.query = entry[1];
                    $('#' + this.id + ' .search-clear').removeClass('hide');
                } else if (entry[0] == 'sort') {
                    this.sort = entry[1];
                } else if (entry[0] == 'sd') {
                    this.sd = entry[1];
                } else if (entry[0] == 'page') {
                    this.page = entry[1];
                }
            }
            url = this.appendUrl(this.url, params);

            $('#' + id + ' .list-sort').each(function (i, item) {
                var icon = $(item).children('i');
                icon.removeClass('fa-sort-up').removeClass('fa-sort-down').addClass('fa-sort');

                if ($(item).data('sort') == local.sort) {
                    if (local.sd == 'ASC') {
                        icon.addClass('fa-sort-up');
                    } else {
                        icon.addClass('fa-sort-down');
                    }
                }
            });
        }

        $('#' + id + ' button[name=search]').click(function () {
            local.search();
        });

        $('#' + id + ' button[name=clear]').click(function () {
            local.clearSearch();
        });

        $('#' + id + ' .list-sort').click(function () {
            local.sortList(this);
        });

        $('#' + id + ' input[name=query]').on('keypress', function(e) {
            if(e.which == 13) {
                local.search();
            }
        });

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
        var nothing = false;
        if (data == undefined || data == null || !data) {
            nothing = true;
        }

        if (!data.length || nothing) {
            $('#' + this.id + ' tbody').html('<tr><td colspan="' + this.map.length + '"><strong>No results</strong></td></tr>');
            $('#processing').hide();
            return;
        }

        var html = '';
        var local = this;

        var params = {};
        if (this.query) {
            params.query = this.query;
        }
        params.page = this.page;
        params.sort = this.sort;
        params.sd = this.sd;

        $.each(data, function (i, row) {
            html += '<tr>';
            $.each(local.map, function (i2, item) {
                html += '<td>';
                if (item.toLowerCase() == 'status') {
                    html += local.buildStatus(row[item]);
                } else if (item.search('icon=') > 0) {
                    var splits = item.split('|icon=');
                    if (splits[1]) {
                        var options = JSON.parse(splits[1]);
                        html += '&nbsp;<span class="h4"><i class="fas ';
                        html += options[row[splits[0]]];
                        html += '"></i></span>';
                    } else {
                        html += 'ERROR';
                    }
                } else {
                    html += row[item];
                }
                html += '</td>';
            });
            html += '<td><a href="' + local.appendUrl(local.edit_url + '/' + row.id, params) + '" title="Edit the entry"><span class="btn btn-primary"><i class="far fa-edit"></i></span></a></td>';
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
                    if (entry[0] == 'page') {
                        local.page = entry[1];
                    }
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
            case 'absent':
                return '<span class="badge badge-warning">Absent</span>';
            case 'active':
                return '<span class="badge badge-success">Active</span>';
            case 'inactive':
                return '<span class="badge badge-warning">Inactive</span>';
            case 'deleted':
                return '<span class="badge badge-danger">Deleted</span>';
            case 'left':
                return '<span class="badge badge-danger">Left</span>';
            case 'present':
                return '<span class="badge badge-success">Present</span>';
            default:
                return status;
        }
    }

    clearSearch() {
        $('#' + this.id + ' input[name=query]').val('');
        $('#' + this.id + ' .search-clear').hide();

        var params = {};
        params.query = this.query = '';

        var url = this.appendUrl(this.url, params);
        this.get(url);
        api.get(this.appendUrl('/stats/people', params), 'buildStats');
        
        if(history.pushState) {
            params.page = this.page = 1;
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
        params.query = this.query = query;
        params.page = this.page = 1;
        if (this.sort && this.sd) {
            params.sort = this.sort;
            params.sd = this.sd;
        }
        this.get(this.appendUrl(this.url, params));

        api.get(this.appendUrl('/stats/people', params), 'buildStats');
        
        if(history.pushState) {
            history.pushState(null, null, this.appendUrl(window.location.href, params));
        }

        $('#' + this.id + ' .search-clear').show();
    }

    sortList(button) {
        $('#' + this.id + ' .list-sort i').each(function (i, item) {
            $(item).removeClass('fa-sort-up').removeClass('fa-sort-down').addClass('fa-sort');
        });

        var icon = $(button).children('i');
        if (this.sort != $(button).data('sort')) {
            this.sd = '';
        }
        this.sort = $(button).data('sort');

        if (this.sd == 'ASC') {
            icon.removeClass('fa-sort-up').removeClass('fa-sort').addClass('fa-sort-down');
            this.sd = 'DESC';
        } else if (this.sd == 'DESC') {
            icon.removeClass('fa-sort-down').removeClass('fa-sort-up').addClass('fa-sort');
            this.sd = '';
            this.sort = '';
        } else {
            icon.removeClass('fa-sort-down').removeClass('fa-sort').addClass('fa-sort-up');
            this.sd = 'ASC';
        }

        var params = {};
        if (this.query) {
            params.query = this.query;
        }
        params.page = this.page;
        params.sort = this.sort;
        params.sd = this.sd;

        this.get(this.appendUrl(this.url, params));
        if(history.pushState) {
            history.pushState(null, null, this.appendUrl(window.location.href, params));
        }
    }
}