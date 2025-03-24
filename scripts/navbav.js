link_page()

function link_page() {
    document.querySelector("#sign_in_nav_bar").addEventListener("click",()=>
    {
        window.location.href = "/VUONGTINHSNEAKER/components/signup.php"
    })
}