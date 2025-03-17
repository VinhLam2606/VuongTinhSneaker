document.querySelector("#sign_up").addEventListener("click", async (event) => {
    event.preventDefault();
    
    let phonenumber = document.querySelector("#phonenumber").value.trim();
    let email = document.querySelector("#email").value.trim();
    let password = document.querySelector("#password").value;
    let firstname = document.querySelector("#first").value.trim();
    let lastname = document.querySelector("#last").value.trim();
    let birth = document.querySelector("#birth").value;
    let address = document.querySelector("#address").value.trim();
    let gender = document.querySelector("#gender");
    let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!phonenumber || !email || !password || !firstname || !lastname || !birth || !address) {
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
        address
    };

    try {
        let response = await fetch("/VUONGTINHSNEAKER/components/signup.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: new URLSearchParams(data)
        });

    } catch (error) {
        console.error("Error:", error);
        alert("An error occurred. Please try again later.");
    }
});
