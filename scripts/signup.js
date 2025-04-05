document.addEventListener("DOMContentLoaded", function () {
    const emailInput = document.querySelector('input[name="email"]');
    const phoneInput = document.querySelector('input[name="phonenumber"]');
    const passwordInput = document.querySelector('input[name="password"]');
    const firstnameInput = document.querySelector('input[name="firstname"]');
    const lastnameInput = document.querySelector('input[name="lastname"]');
    const birthInput = document.querySelector('input[name="birth"]');
    const addressInput = document.querySelector('input[name="address"]');
    const genderInputs = document.querySelectorAll('input[name="gender"]');
    const signupForm = document.querySelector('form');
    const signUpButton = document.querySelector("#sign_up");
    const tickbox = document.querySelector('input[name="confirm"]'); 

    if (!emailInput || !phoneInput || !passwordInput || !firstnameInput || !lastnameInput || !birthInput || !signupForm || !signUpButton || !tickbox) {
        console.error("Không tìm thấy các phần tử cần thiết trong DOM!");
        return;
    }

    signUpButton.addEventListener("click", function (e) {
        let valid = true;
        const email = emailInput.value.trim();
        const phone = phoneInput.value.trim();
        const password = passwordInput.value.trim();
        const firstname = firstnameInput.value.trim();
        const lastname = lastnameInput.value.trim();
        const birth = birthInput.value.trim();
        const address = addressInput.value.trim();
        const genderChecked = [...genderInputs].some(input => input.checked);
        const isTickboxChecked = tickbox.checked; // Kiểm tra checkbox đã được tick chưa

        if (!validateEmail(email)) {
            alert("Email không hợp lệ!");
            valid = false;
        }

        if (!/^\d{10}$/.test(phone)) {
            alert("Số điện thoại phải có đúng 10 chữ số!");
            valid = false;
        }

        if (!validateFormFields(password, firstname, lastname, birth, address, genderChecked, isTickboxChecked)) {
            valid = false;
        }

        if (!valid) {
            e.preventDefault(); // Ngăn form gửi nếu có lỗi
        }
    });

    function validateEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    function validateFormFields(password, firstname, lastname, birth, address, genderChecked, isTickboxChecked) {
        if (!password) {
            alert("Vui lòng nhập mật khẩu!");
            return false;
        }
        if (!firstname) {
            alert("Vui lòng nhập họ!");
            return false;
        }
        if (!lastname) {
            alert("Vui lòng nhập tên!");
            return false;
        }
        if (!birth) {
            alert("Vui lòng chọn ngày sinh!");
            return false;
        }
        if (!address) {
            alert("Vui lòng nhập địa chỉ!");
            return false;
        }
        if (!genderChecked) {
            alert("Vui lòng chọn giới tính!");
            return false;
        }
        if (!isTickboxChecked) { // Kiểm tra checkbox đã được tick chưa
            alert("Vui lòng xác nhận điều khoản dịch vụ!");
            return false;
        }
        return true;
    }
});
