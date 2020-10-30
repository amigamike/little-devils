/**
 * API class for javascript.
 *
 * @copyright   2020 Mike Welsh
 * @author      Mike Welsh (mike@amigamike.com)
 * @version     0.0.1
 */

class Api {
    /**
     * Peform a POST api call.
     * @param {*} url
     * @param {*} data
     * @param {*} success
     * @param {*} failed
     */
    post(url, data, success, failed) {
        return this.call('POST', url, data, success, failed);
    }

    /**
     * Perform a PUT api call.
     * @param {*} url
     * @param {*} data
     * @param {*} success
     * @param {*} failed
     */
    put(url, data, success, failed) {
        return this.call('PUT', url, data, success, failed);
    }

    /**
     * Perform a PATCH api call.
     * @param {*} url
     * @param {*} data
     * @param {*} success
     * @param {*} failed
     */
    patch(url, data, success, failed) {
        return this.call('PATCH', url, data, success, failed);
    }

    /**
     * Perform an api call.
     * @param {*} method
     * @param {*} url
     * @param {*} data
     * @param {*} success
     * @param {*} failed
     */
    call(method, url, data, success, failed) {
        $.ajax({
            method: method,
            contentType: 'application/json',
            headers: {"API-KEY": API_KEY},
            dataType: 'json',
            url: API_URL + url,
            data: JSON.stringify(data)
          })
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
        })
        .fail(function(response) {
            response = response.responseJSON;

            var message = 'Oh uh, something has gone wrong'
            if (!response.message) {
                message = response.message;
            }

            $.notify(
                message,
                {
                    allow_dismiss: true,
                    type: 'danger'
                }
            );
        });
    }
}

var api = new Api();