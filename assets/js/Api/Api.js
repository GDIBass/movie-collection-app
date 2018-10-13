import $ from "jquery";

const apiCall = (url, method, data = null) => {
    const ajax = {
        url,
        method,
        crossDomain: false,
        xhrFields: {
            withCredentials: true
        }
    };
    if ( data ) {
        ajax.data = JSON.stringify(data);
        ajax.dataType = 'json';
    }
    return $.ajax(ajax);
};

const movieSearch = (query) => {
    return apiCall(
        '/api/v1/movies?q=' + encodeURI(query),
        'GET'
    );
};

const addRemoveFromCollection = (remove, movieId) => {
    return apiCall(
        '/api/v1/collection/' + movieId,
        remove ? 'DELETE' : 'PUT'
    );
};

export default {
    addRemoveFromCollection,
    movieSearch
};