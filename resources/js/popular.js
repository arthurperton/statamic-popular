(function () {
    var formData = new FormData();

    formData.append('_token', csrfToken());
    formData.append('entry', window.location.href);

    navigator.sendBeacon('/!/popular/pageviews', formData);
})();
