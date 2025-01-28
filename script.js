function toggleForms(formType) {
    document.getElementById("login-form").style.display = formType === "login" ? "block" : "none";
    document.getElementById("register-form").style.display = formType === "register" ? "block" : "none";
}
