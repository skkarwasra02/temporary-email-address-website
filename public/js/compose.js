var app = new Vue({
    el: '#app',
    data: function() {
        var vue_data = {};
        vue_data.email = data.email;
        vue_data.compose_token = data.compose_token;
        vue_data.address_error = "";
        vue_data.uploading_status = [
            /* Format
            {
                filename: "file",
                size: 100,
                percentage: 55
            }*/
        ]
        return vue_data;
    },
    computed: {
        username: {
            get: function() {
                var usr = this.email.split('@');
                return usr[0];
            },
            set: function(username) {
                this.address_error = "";
                if(username == this.username) return;
                // Open email
                var email = username + "@" + this.domain;
                axios
                    .get("/api/compose/openemail?email=" + email)
                    .then(function(response) {
                        if(response.data.status == 'error') {
                            this.app.address_error = response.data.message;
                            return;
                        }
                        this.app.email = email;
                    }).catch(function (error) {
                        if(error.response) {
                            this.app.address_error = "Invalid email address";
                        }
                    });
            }
        },
        domain: {
            get: function() {
                var usr = this.email.split('@');
                return usr[1];
            },
            set: function(domain) {
                this.address_error = "";
                if(domain == this.domain) return;
                // Open email
                var email = this.username + "@" + domain;
                axios
                    .get("/api/compose/openemail?email=" + email)
                    .then(function(response) {
                        if(response.data.status == 'error') {
                            this.app.address_error = response.data.message;
                            return;
                        }
                        this.app.email = email;
                    }).catch(function (error) {
                        if(error.response) {
                            this.app.address_error = "Invalid email address";
                        }
                    });
            }
        }
    },
    methods: {
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
        },
        uploadFile: function(event) {
            var attachment = event.target.files[0];

            if(attachment == undefined) {
                return;
            }

            document.getElementById("attachment").value = "";

            if(attachment.size > 25 * 1024 * 1024) {
                console.log("exceeded size limit");
                return;
            }

            var formData = new FormData();
            formData.append("compose_token", this.compose_token);
            formData.append("attachment", attachment);

            // Start uploading status
            var status_key = this.uploading_status.push({
                filename: attachment.name,
                size: attachment.size,
                percentage: 0,
                key: this.uploading_status.length,
                cancelAttachment: function() {
                    if(this.percentage < 100) {
                        this.cancel("Canceled")
                    } else {
                        // Delete from server
                        axios
                            .post('/compose/upload/delete', {
                                compose_token: app.compose_token,
                                attachment_name: this.filename
                            })
                            .then(function(response) {

                            })
                            .catch(function(error) {

                            });
                    }
                    app.uploading_status.splice(this.key, 1);
                }
            }) - 1;

            axios
                .post('/compose/upload', formData, {
                    headers: {
                      'Content-Type': 'multipart/form-data'
                  },
                  onUploadProgress: function(progressEvent) {
                      // Uploading progress event
                      var percentCompleted = Math.round( (progressEvent.loaded * 100) / progressEvent.total );
                      app.uploading_status[status_key].percentage = percentCompleted;
                  },
                  cancelToken: new axios.CancelToken(c => {
                    // this function will receive a cancel function as a parameter
                    app.uploading_status[status_key].cancel = c;
                  })
                })
                .then(function(response) {
                    console.log(response.data);
                })
                .catch(function(error) {
                    if (axios.isCancel(error)) {
                        //console.log(error.message);
                      } else {
                        // handle error
                      }
                    //console.log(error.response.data.errors.attachment[0]);
                });
        }
    },
    created: function() {
        document.getElementById("uploads-status").style.display = "block";
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
