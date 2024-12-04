//email valudation
const validateEmail = (email) => {
    return email.match(
        /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    );
};

// register example
function gotosignup(page) {
    //ฝากไปทำ validate หน่อยนะ frontend
    var pass = true;
    if ($("#uName").val().length < 5) {
        pass = false;
        Swal.fire({
            icon: "error",
            title: "Username must be at least 5 characters!!",
            timer: 5000,
        });
    } else if (!validateEmail($("#email").val())) {
        pass = false;
        Swal.fire({
            icon: "error",
            title: "email is invalid!!",
            timer: 5000,
        });
    } else if ($("#rPassword").val().length < 8) {
        pass = false;
        Swal.fire({
            icon: "error",
            title: "Password must be at least 8 characters!!",
            timer: 5000,
        });
    } else if ($("#fName").val().length <= 0) {
        pass = false;
        Swal.fire({
            icon: "error",
            title: "First name can't be empty!!",
            timer: 5000,
        });
    } else if ($("#lName").val().length <= 0) {
        pass = false;
        Swal.fire({
            icon: "error",
            title: "Last name can't be empty!!",
            timer: 5000,
        });
    } else if ($("#phone").val().length <= 8) {
        pass = false;
        Swal.fire({
            icon: "error",
            title: "Phone must be at least 8 characters!!",
            timer: 5000,
        });
    } 
    else if ($("#home").val().length <= 0) {
        pass = false;
        Swal.fire({
            icon: "error",
            title: "Address can't be empty!!",
            timer: 5000,
        });
    }
    else if ($("#province").val().length <= 0) {
        pass = false;
        Swal.fire({
            icon: "error",
            title: "Address can't be empty!!",
            timer: 5000,
        });
    }
    else if ($("#district_1").val().length <= 0) {
        pass = false;
        Swal.fire({
            icon: "error",
            title: "Address can't be empty!!",
            timer: 5000,
        });
    }
    else if ($("#district_2").val().length <= 0) {
        pass = false;
        Swal.fire({
            icon: "error",
            title: "Address can't be empty!!",
            timer: 5000,
        });
    }
    else if ($("#postcode").val().length != 5) {
        pass = false;
        Swal.fire({
            icon: "error",
            title: "Postcode must be 5 characters!!",
            timer: 5000,
        });
    }

    if (pass) {
        $.ajax({
            method: "post",
            url: "./backend/api/signup.php",
            data: {
                username: $("#uName").val(),
                password: $("#rPassword").val(),
                email: $("#email").val(),
                firstname: $("#fName").val(),
                lastname: $("#lName").val(),
                phone: $("#phone").val(),
                home: $("#home").val(),
                province: $("#province").val(),
                district_1: $("#district_1").val(),
                district_2: $("#district_2").val(),
                postcode: $("#postcode").val(),
            },
            success: function (response) {
                console.log("good", response);
                try {
                    var responseObject = JSON.parse(response);
                    console.log(responseObject.RespCode);
                    if (responseObject.RespCode == 200) {

                        Swal.fire({
                            icon: "success",
                            title: "Signup success!!",
                            timer: 5000,
                        });
                        if (page == 'promotion') {
                            window.location.href = "./promotion.php";
                        } else if (page == 'menu') {
                            window.location.href = "./menu.php";
                        } else if (page == 'contractUs') {
                            window.location.href = "./contractUs.php";
                        } else if (page == 'index') {
                            window.location.href = "./index.php";
                        }

                    } else if (responseObject.RespCode == 400) {
                        Swal.fire({
                            icon: "error",
                            title: "Signup failed!!",
                            timer: 5000,
                        });
                    }
                } catch (error) {
                    Swal.fire({
                        icon: "error",
                        title: "Something went wrong!",
                        timer: 5000,
                    });
                }

            },
            error: function (err) {
                console.log("badmakmak", err);
            },
        });
    }
}

function gotologin(page) {
    var pass = true;
    if ($("#uNameOrEmail").val().length <= 0) {
        pass = false;
        Swal.fire({
            icon: "error",
            title: "Please insert username",
            timer: 5000,
        });
    } else if ($("#lPassword").val().length <= 0) {
        pass = false;
        Swal.fire({
            icon: "error",
            title: "Please insert username",
            timer: 5000,
        });
    }
    if (pass) {
        console.log("go to login...");
        $.ajax({
            method: "post",
            url: "./backend/api/login.php",
            data: {
                username: $("#uNameOrEmail").val(),
                password: $("#lPassword").val(),
            },
            success: (response) => {
                console.log("valid", response);
                console.log(response);
                try {
                    var responseObject = JSON.parse(response);
                    if (responseObject.RespCode == 200) {

                        localStorage.setItem("username", responseObject.RespUsername);
                        localStorage.setItem("uid", responseObject.RespUid);
                        Swal.fire({
                            icon: "success",
                            title: "Login success!!",
                            timer: 5000,
                        });
                        if (page == 'promotion') {
                            window.location.href = "./promotion.php";
                        } else if (page == 'menu') {
                            window.location.href = "./menu.php";
                        } else if (page == 'contractUs') {
                            window.location.href = "./contractUs.php";
                        } else if (page == 'index') {
                            window.location.href = "./index.php";
                        }
                    } else {
                        console.log('test1')
                        Swal.fire({
                            icon: "error",
                            title: "Something went wrong!",
                            timer: 5000,
                        });
                    }
                } catch (error) {
                    Swal.fire({
                        icon: "error",
                        title: "Something went wrong!",
                        timer: 5000,
                    });
                }

            },
            error: (err) => {
                console.log('test1')

                console.log("error", err);
            },
        });
    }
}

function gotologout(page) {
    console.log("go to logout");
    if (page == 'userProfile') {
        $.ajax({
            url: "./../backend/api/logout.php", // URL of the server-side script to handle the logout
            type: "POST",
            success: function (response) {
                // Redirect to the login page or perform any other actions after logout
                Swal.fire({
                    icon: "success",
                    title: "Logout success!!",
                    timer: 5000,
                });
                window.location.href = "./../index.php";
            },
            error: function (xhr, status, error) {
                // Handle error if AJAX request fails
                console.log("AJAX Error: " + error);
            }
        });
    }
    else if (page == 'staff' || page == 'manager') {
        $.ajax({
            url: "./backend/api/logout.php", // URL of the server-side script to handle the logout
            type: "POST",
            success: function (response) {
                // Redirect to the login page or perform any other actions after logout
                Swal.fire({
                    icon: "success",
                    title: "Logout success!!",
                    timer: 5000,
                });
                window.location.href = "./loginAdmin.html";
            },
            error: function (xhr, status, error) {
                // Handle error if AJAX request fails
                console.log("AJAX Error: " + error);
            }
        });
    }
    else {
        $.ajax({
            url: "./backend/api/logout.php", // URL of the server-side script to handle the logout
            type: "POST",
            success: function (response) {
                // Redirect to the login page or perform any other actions after logout
                Swal.fire({
                    icon: "success",
                    title: "Logout success!!",
                    timer: 5000,
                }).then((result) => {
                    if (result.isConfirmed || result.isDismissed) {
                        window.location.href = "./index.php";
                    }
                });
                
            },
            error: function (xhr, status, error) {
                // Handle error if AJAX request fails
                console.log("AJAX Error: " + error);
            }
        });
    }
}