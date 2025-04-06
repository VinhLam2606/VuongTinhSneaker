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
}   