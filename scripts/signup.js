document.querySelector("#sign_up").addEventListener("click", async (event) => {
    event.preventDefault();
    
    let phonenumber = document.querySelector("#phonenumber").value.trim();
    let email = document.querySelector("#email").value.trim();
    let password = document.querySelector("#password").value;
    let firstname = document.querySelector("#first").value.trim();
    let lastname = document.querySelector("#last").value.trim();
    let birth = document.querySelector("#birth").value;
    let address = document.querySelector("#address").value.trim();
    let gender = document.querySelector('input[name="gender"]:checked')?.value || "";

    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!phonenumber || !email || !password || !firstname || !lastname || !birth || !address || !gender) {
        alert("Please fill all fields");
        return;
    }

    if (phonenumber.length !== 10 || !/^\d+$/.test(phonenumber)) {
        alert("Phone number must be exactly 10 digits!");
        return;
    }

    if (!emailRegex.test(email)) {
        alert("An email must contain @ and a dot (.)");
        return;
    }

    let data = {
        phonenumber,
        email,
        password,
        firstname,
        lastname,
        birth,
        address,
        gender
    };

    console.log("Data being sent:", data);

    try {
        let response = await fetch("signup.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams(Object.entries(data)).toString()
        });

        let result = await response.text();
        console.log("Server response:", result);

        if (response.ok) {
            alert("Sign-up successful!");
            window.location.href = "login.php";
        } else {
            alert("Sign-up failed: " + result);
        }
    } catch (error) {
        console.error("Error:", error);
        alert("An error occurred. Please try again later.");
    }
});
