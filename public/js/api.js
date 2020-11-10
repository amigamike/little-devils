/**
 * API class for javascript.
 *
 * @copyright   2020 Mike Welsh
 * @author      Mike Welsh (mike@amigamike.com)
 * @version     0.0.1
 */

class Api {
    /**
     * Peform a DELETE api call.
     * @param {*} url
     * @param {*} success
     * @param {*} failed
     */
    delete(url, success, failed, pagination) {
        return this.call('DELETE', url, null, success, failed, pagination);
    }

    /**
     * Peform a GET api call.
     * @param {*} url
     * @param {*} success
     * @param {*} failed
     */
    get(url, success, failed, pagination) {
        return this.call('GET', url, null, success, failed, pagination);
    }

    /**
     * Peform a POST api call.
     * @param {*} url
     * @param {*} data
     * @param {*} success
     * @param {*} failed
     */
    post(url, data, success, failed, pagination) {
        return this.call('POST', url, data, success, failed, pagination);
    }

    /**
     * Perform a PUT api call.
     * @param {*} url
     * @param {*} data
     * @param {*} success
     * @param {*} failed
     */
    put(url, data, success, failed, pagination) {
        return this.call('PUT', url, data, success, failed, pagination);
    }

    /**
     * Perform a PATCH api call.
     * @param {*} url
     * @param {*} data
     * @param {*} success
     * @param {*} failed
     */
    patch(url, data, success, failed, pagination) {
        return this.call('PATCH', url, data, success, failed, pagination);
    }

    /**
     * Perform an api call.
     * @param {*} method
     * @param {*} url
     * @param {*} data
     * @param {*} success
     * @param {*} failed
     */
    call(method, url, data, success, failed, pagination) {
        var options = {
            method: method,
            contentType: 'application/json',
            headers: {"X-API-KEY": API_KEY},
            dataType: 'json',
            url: API_URL + url
        };

        if (data) {
            options.data = JSON.stringify(data);
        }

        $.ajax(options)
        .done(function(response) {
            var func = null;
            if (typeof(response.data) == 'undefined') {
                var message = 'An error has occurred';
                if (typeof(response.message) != 'undefined') {
                    message += '<br/> "' + response.message + '"';
                }

                if (failed) {
                    func = failed + "(response.data);";
                }
            } else if (success) {
                func = success + "(response.data);";
            }

            if (func) {
                eval(func);
            }

            if (pagination) {
                func = pagination + "(response.pagination);";
                eval(func);
            }
        })
        .fail(function(response) {
            response = response.responseJSON;

            if (!response) {
                response = {};
                response.message = '';
            }
            
            if (!response.message) {
                response.message = 'Oh uh, something has gone wrong';
            }

            apiFailed(response);
        });
    }
}

var api = new Api();

function apiFailed(data)
{
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