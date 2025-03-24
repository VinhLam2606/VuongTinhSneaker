document.addEventListener("DOMContentLoaded", () => {
    link_page();
});

function link_page() {
    document.querySelector("#sign_up_nav_bar").addEventListener("click", () => {
        window.location.href = "components/signup.php";
    });
    document.querySelector("#join_us_nav_bar").addEventListener("click", () => {
        window.location.href = "components/join_us.php";
    });
    document.querySelector("#sign_in_nav_bar").addEventListener("click", () => {
        window.location.href = "components/login.php";
    });
    document.querySelector("#men_page_nav_bar").addEventListener("click", () => {
        window.location.href = "components/men.php";
    });
    document.querySelector("#women_page_nav_bar").addEventListener("click", () => {
        window.location.href = "components/women.php";
    });
    document.querySelector("#kid_page_nav_bar").addEventListener("click", () => {
        window.location.href = "components/kid.php";
    });
    document.querySelector("#customize_page_nav_bar").addEventListener("click", () => {
        window.location.href = "components/customize.php";
    });
    document.querySelector("#sale_page_nav_bar").addEventListener("click", () => {
        window.location.href = "components/sales.php";
    });
    document.querySelector("#snkrs_page_nav_bar").addEventListener("click", () => {
        window.location.href = "components/sneakersfeed.php";
    });
}

// Phone responsiveness
var phone = window.matchMedia("(max-width: 414px)");
navbar(phone);
phone.addListener(navbar);

function navbar(phone) {
    if (phone.matches) {
        var phone_div = document.querySelector(".center");
        if (phone_div) phone_div.style.display = "none";

        var body = document.querySelector("#center_phone");
        if (!body) return;

        body.innerHTML = null;

        var sel = document.createElement("select");
        sel.setAttribute("style", "-webkit-appearance: none;");

        const options = [
            "|||",
            "Favorite",
            "Cart",
            "Men",
            "Women",
            "Kids",
            "Customise",
            "Sales",
            "SNKRS"
        ];

        options.forEach(text => {
            const op = document.createElement("option");
            op.text = text;
            sel.add(op);
        });

        body.append(sel);

        sel.addEventListener("change", (event) => {
            let sel_value = event.target.value;

            switch (sel_value) {
                case "Favorite":
                    window.location.href = "components/favorite.php";
                    break;
                case "Cart":
                    window.location.href = "components/cart.php";
                    break;
                case "Men":
                    window.location.href = "components/men.php";
                    break;
                case "Women":
                    window.location.href = "components/women.php";
                    break;
                case "Kids":
                    window.location.href = "components/kid.php";
                    break;
                case "Customise":
                    window.location.href = "components/customize.php";
                    break;
                case "Sales":
                    window.location.href = "components/sales.php";
                    break;
                case "SNKRS":
                    window.location.href = "components/sneakersfeed.php";
                    break;
                default:
                    break;
            }
        });

    } else {
        var centerDiv = document.querySelector(".center");
        if (centerDiv) centerDiv.style.display = "flex";
    }
}
