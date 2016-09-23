<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title></title>
</head>
<body>
<script>
    var API = {
        appCredentials: {
            grant_type: "password",
            username: "TestRail",
            password: "TestRail01",
            client_id: "de29d102-53a7-4ae3-a47d-3821cd56d6f1",
            client_secret: "6b30e841-f106-47bc-b019-972697fb902b"
        },

        appUrl: {
            axosoftApiVersion: "v5",
            baseUrl: "http://ontime01/ontimeweb",
            axosoftApiBaseUrl: "http://ontime01/ontimeweb" + "/api/" + "v5/"
        },

        token: {},

        init: function (username, password, client_id, client_secret) {
            API.appCredentials.username = username;
            API.appCredentials.password = password;
            API.appCredentials.client_id = client_id;
            API.appCredentials.client_secret = client_secret;
        },

        setScope: function(scope) {
            API.appCredentials.scope = scope;
        },

        authenticateCredentails: function(callback) {
            if (!API.token.access_token) {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    if (this.readyState === 4 && this.status === 200) {
                        API.token = JSON.parse(xhttp.response);
                        //todo display error.
                        callback(null);
                    }
                };

                var credential = "?";

                for (var item in API.appCredentials) {
                    if (!API.appCredentials.hasOwnProperty(item)) continue;
                    credential += item + "=" + API.appCredentials[item] + "%26";
                }

                credential = "params=" + credential.substring(0, credential.length - 3);

                xhttp.open("GET", "Proxy/?URL=" + API.appUrl.baseUrl + "/api/oauth2/token" + "&" + credential, true);
                xhttp.send();
            } else {
                callback(null);
            }
        },

        restRequest:function(url, data, callback) {
            API.authenticateCredentails(function () {
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function () {
                    if (this.readyState === 4 && this.status === 200) {
                        //todo display error.
                        if (callback === undefined || callback === null)
                            return JSON.parse(xhttp.response);
                        else
                            return callback(JSON.parse(xhttp.response));
                    }
                };

                xhttp.open("POST", "Proxy/?URL=" + API.appUrl.axosoftApiBaseUrl + url + "?access_token=" + API.token.access_token, true);
                if (data !== undefined && data !== null) {
                    var formData = new FormData();
                    formData.append("data", data);
                    xhttp.send(formData);
                } else {
                    xhttp.send();
                }
            });
        }
    };

    var app = {
        users: null,

        createWorkLog: function () {
            API.restRequest(
                "work_logs/",
                '{"user":{"id":"37"},"work_done":{"time_unit":{"id":1},"duration":2},"date_time":"2016-09-22T16:05:00.000Z","work_log_type":{"id":"0"},"description":"desd","item":{"id":1627,"item_type":"tasks"},"update_remaining_time":true,"remaining_time":{"duration":0,"time_unit":{"id":2}}}');
        },

        getAllUsers: function () {
            this.users = API.restRequest("users/");
        }
    };
</script>
</body>
</html>