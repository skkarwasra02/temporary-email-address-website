var app = new Vue({
    el: '#app',
    data: function() {
        var vue_data = {};
        vue_data.email = data.email;
        vue_data.inbox_size = data.inbox_size;
        vue_data.address_error = data.address_error;
        return vue_data;
    },
    computed: {
        username: {
            get: function() {
                var usr = this.email.split('@');
                return usr[0];
            },
            set: function(username) {
                if(username == this.username) return;
                // Open email
                var email = username + "@" + this.domain;
                axios
                    .get("/api/openemail?email=" + email)
                    .then(function(response) {
                        if(response.data.status == 'error') {
                            this.app.address_error = response.data.message;
                            return;
                        }
                        if(this.app.inbox_size == 0 && response.data.inbox_size > 0) {
                            window.location.href = "/inbox";
                        }
                        if(this.app.inbox_size > 0 && response.data.inbox_size == 0) {
                            window.location.href = "/";
                        }
                        this.app.email = email;
                        this.app.inbox_size = response.data.inbox_size;
                    });
            }
        },
        domain: {
            get: function() {
                var usr = this.email.split('@');
                return usr[1];
            },
            set: function(domain) {
                if(domain == this.domain) return;
                if(domain.length == 0) {
                    return;
                }
                // Open email
                var email = this.username + "@" + domain;
                axios
                    .get("/api/openemail?email=" + email)
                    .then(function(response) {
                        if(response.data.status == 'error') {
                            this.app.address_error = response.data.message;
                        } else {
                            this.app.address_error = "";
                        }
                        if(response.data.inbox_size > 0) {
                            window.location.href = "/inbox";
                        }
                        if(this.app.inbox_size > 0 && response.data.inbox_size == 0) {
                            window.location.href = "/";
                        }
                        this.app.email = email;
                        this.app.inbox_size = response.data.inbox_size;
                    });
            }
        }
    },
    methods: {
        updateInboxSize: function() {
            axios
                .get("/api/getinboxsize?email=" + this.email)
                .then(function(response) {
                    if(this.app.inbox_size == 0 && response.data.inbox_size > 0) {
                        window.location.href = "/inbox";
                    }
                    if(this.app.inbox_size > 0 && response.data.inbox_size == 0) {
                        window.location.href = "/";
                    }
                    if(this.app.inbox_size < response.data.inbox_size) {
                        window.location.href = window.location.href;
                    }
                });
        },
        openMail: function(mail) {
            window.location.href = "/inbox/" + mail;
        },
        refreshPage: function() {
            window.location.href = window.location.href;
        },
        copyEmail: function() {
            var inputBox = document.createElement("input");
            inputBox.value = this.email;
            inputBox.setAttribute('id', 'for-copy');
            inputBox.setAttribute('style', 'position:absolute;');
            document.body.appendChild(inputBox);
            var email = document.getElementById('for-copy');
            email.select();
            document.execCommand("copy");
            this.$toastr.success('', 'Email Copied', toastrOptions);
            $("#for-copy").remove();
        }
    },
    created: function() {
        // Set inbox_size update interval
        setInterval(this.updateInboxSize, 10000);

        // Domain name search autocomplete
        $("#domain-name").autocomplete({
            source: "/api/searchdomain"
        });
    }
});

function updateDomainsDropDownLocation() {
    $(".domains-dropdown .dropdown-menu").css({
        "left" : ($("#msg-icon-div").outerWidth() + $("#username").outerWidth()) + "px",
        "width" : "calc(100% - " + ($("#msg-icon-div").outerWidth() + $("#username").outerWidth()) + "px)"
    });
}

$(document).ready(function () {
    // Domains button js
    $(document).on("click", function(event) {
        var trigger = $(".domains-dropdown");
        if(trigger !== event.target && !trigger.has(event.target).length) {
            $(".domains-dropdown .dropdown-menu").hide();
        }
    });
    $(".dropdown-menu .dropdown-item").on('click', function() {
        $(".domains-dropdown .dropdown-menu").hide();
    });
    $("#dropdownMenuButton").on("click", function() {
        updateDomainsDropDownLocation();
        $(".domains-dropdown .dropdown-menu").toggle();
    });
});
