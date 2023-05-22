function createCookie(name, value, days) {
    var expires;
    
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        expires = "; expires=" + date.toGMTString();
    }
    else {
        expires = "";
    }
    
    document.cookie = escape(name) + "=" + 
        escape(value) + expires + "; path=/";
}

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    }
}

function showPosition(position) {
    createCookie("lat", position.coords.latitude, "0.5");
    createCookie("long", position.coords.longitude, "0.5");
}