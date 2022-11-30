(function () {
    var formData = new FormData();

    formData.append('_token', csrfToken());
    formData.append('url', window.location.href);

    navigator.sendBeacon('/!/popular/pageviews', formData);
})();
