import numeral from "numeral";

export default {
    install(Vue, options) {
        // 1. add global method or property
        Vue.mixin({
            methods: {
                numberWithCommas(x, code = null) {
                    if (x != null && x != "") {
                        var symbol = "";
                        if (code == "NGN") {
                            symbol = "₦";
                        }
                        if (code == "USD") {
                            symbol = "$";
                        }
                        return symbol + numeral(x).format("0,0");
                    } else {
                        return;
                    }
                },
                handleApiError(err) {
                    if (err.response) {
                        toastr.error(err.response.data.message);
                        if (err.response.data.errors) {
                            this.showErrorMsg(err.response.data.errors);
                        } else {
                            toastr.error(err.response.data.message);
                        }
                    } else {
                        toastr.error(err);
                    }
                },
                showErrorMsg(errors) {
                    var err = "";
                    Object.entries(errors).forEach(function (key, value) {
                        toastr.error(key);
                        err += key + "\r\n";
                    });
                    // if (errors.email) {
                    //     err = errors.email;
                    //     toastr.error(errors.email);
                    // }
                    // if (errors.username) {
                    //     err = errors.username;
                    //     toastr.error(errors.username);
                    // }
                    // if (errors.password) {
                    //     err = errors.password;
                    //     toastr.error(errors.password);
                    // }
                    // if (errors.name) {
                    //     err = errors.name;
                    //     toastr.error(errors.name);
                    // }
                    // if (errors.class_id) {
                    //     err = errors.class_id;
                    //     toastr.error(errors.class_id);
                    // }
                    // if (errors.phone) {
                    //     err = errors.phone;
                    //     toastr.error(errors.phone);
                    // }
                    return err;
                },
                returnErrorMsg(errors) {
                    var err = "";
                    Object.entries(errors).forEach(function (key, value) {
                        err +=
                            '<span class="text-danger block"> ' +
                            key[1][0] +
                            ' <i class="fas fa-exclamation-triangle"></i></span>';
                    });
                    // if (errors.email) {
                    //     err = err + '<span class="text-danger block"> ' + errors.email[0] +
                    //         ' <i class="fas fa-exclamation-triangle"></i></span>';
                    // }
                    // if (errors.username) {
                    //     err = err + '<span class="text-danger block"> ' + errors.username[0] +
                    //         ' <i class="fas fa-exclamation-triangle"></i></span>';
                    // }
                    // if (errors.password) {
                    //     err = err + '<span class="text-danger block"> ' + errors.password[0] +
                    //         ' <i class="fas fa-exclamation-triangle"></i></span>';
                    // }
                    // if (errors.name) {
                    //     err = err + '<span class="text-danger block"> ' + errors.name[0] +
                    //         ' <i class="fas fa-exclamation-triangle"></i></span>';
                    // }
                    // if (errors.class_id) {
                    //     err = err + '<span class="text-danger block"> ' + errors.class_id[0] +
                    //         ' <i class="fas fa-exclamation-triangle"></i></span>';
                    // }
                    // if (errors.phone) {
                    //     err = err + '<span class="text-danger block"> ' + errors.phone[0] +
                    //         ' <i class="fas fa-exclamation-triangle"></i></span>';
                    // }
                    return err;
                },
                back() {
                    window.history.back();
                },
                animate() {
                    window.addEventListener("scroll", () => {
                        var animate = document.querySelectorAll(".animate");

                        for (var i = 0; i < animate.length; i++) {
                            var windowheight = window.innerHeight;
                            var revealtop =
                                animate[i].getBoundingClientRect().top;
                            var revealpoint = 150;

                            if (revealtop < windowheight - revealpoint) {
                                animate[i].classList.add("active");
                            } else {
                                animate[i].classList.remove("active");
                            }
                        }
                    });
                },
                scrollTo(id) {
                    document.querySelector(id).scrollIntoView({
                        behavior: "smooth",
                    });
                },
                showPassword(id) {
                    const password = document.querySelector(id),
                        passwordLabel = document.querySelector(id + "label");

                    if (password.type === "password") {
                        password.type = "text";
                        passwordLabel.innerHTML = "hide";
                    } else {
                        password.type = "password";
                        passwordLabel.innerHTML = "show";
                    }

                    password.focus();
                },
            },
        });
    },
};
