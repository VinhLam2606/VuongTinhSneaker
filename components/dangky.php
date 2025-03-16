<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="style/dangky.css">
    </head>
    <body>
        <div id="signup_box">
            <img src="images/logo.jpg" alt="logo" width="125">
            <h3>BECOME A VUONG TINH MEMBER</h3>
            <p>Create your Nike Member profile and get first
                    access to the very best of Nike products, inspiration
                    and community.
            </p>
            <div class="form">
                <form>
                     <input type="email" id = "phonenumber" placeholder="Phone number" autofocus  required minlength="5">
                    <input type="email" id = "email" placeholder="Email address" autofocus  required minlength="5">
                    <input type="password" id = "password" placeholder="Password" required minlength="3">
                    <input type="text" id = "first" placeholder="First Name" required minlength="1">
                    <input type="text" id = "last" placeholder="Last Name" required minlength="1">
                    <input type="text" id = "birth" placeholder="Date of Birth" onfocus="(this.type='date')" required>
                    <input type="text" id="address" value="Address">
                    <div class="gender">
                        <label>
                            <input type="radio" name="gender" value="male"> Male
                        </label>
                        <label>
                            <input type="radio" name="gender" value="female"> Female
                        </label>
                    </div>

                    <div id = "tick_box">
                        <div>
                            <input type="checkbox" name="" id="">
                            <p>Sign up fo emails to get updates from Vuong Tinh on
                                products,offer and your Member benefits
                            </p>
                        </div>
                        <p>By Creating an account, you agree to Vuong Tinh's <a href="https://agreementservice.svs.nike.com/rest/agreement?agreementType=privacyPolicy&country=IN&language=en&mobileStatus=false&requestType=redirect&uxId=com.nike.commerce.nikedotcom.web">Privacy Policy</a>
                            and 
                            <a href="https://agreementservice.svs.nike.com/rest/agreement?agreementType=termsOfUse&country=IN&language=en&mobileStatus=true&requestType=redirect&uxId=com.nike.commerce.nikedotcom.web">Terms of Use.</a></p>
                    </div>
                    <button id = "sign_up">SIGN UP</button>

                </form>
        </div>
    </body>
</html>