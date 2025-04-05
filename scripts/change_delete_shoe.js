document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("click", function (e) {
        if (e.target.matches(".delete_shoe_btn")) {
            const shoeCard = e.target.closest(".shoe-card");
            let shoeId = shoeCard?.dataset.id;
            console.log("Delete clicked, shoeId:", shoeId);

            if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
                fetch("delete_shoe.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "id=" + encodeURIComponent(shoeId)
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Phản hồi từ server:", data);
                        if (data.success) {
                            shoeCard.remove();
                            alert("Sản phẩm đã được xóa thành công!");
                        } else {
                            alert("Xóa sản phẩm thất bại.");
                        }
                    })
                    .catch(error => console.error("Lỗi:", error));
            }
        }

        // Xử lý nút Change Product Information
        else if (e.target.matches(".change_shoe_btn")) {
            const shoeCard = e.target.closest(".shoe-card");
            const shoeId = shoeCard.getAttribute("data-id");
            console.log("Change Product Information clicked, shoeId:", shoeId);

            const currentName = shoeCard.querySelector("h2").textContent.trim();
            const genderP = shoeCard.querySelector("p:nth-of-type(1)");
            let currentGen = "";
            if (genderP && genderP.textContent.startsWith("Gender:")) {
                currentGen = genderP.textContent.replace("Gender:", "").trim();
            }

            const priceP = shoeCard.querySelector(".price");
            let currentPrice = "";
            if (priceP) {
                currentPrice = priceP.textContent.replace(/[^\d.]/g, '').trim();
            }

            const img = shoeCard.querySelector("img");
            const currentImage = img ? img.getAttribute("src") : "";

            let newName = prompt("Nhập tên sản phẩm mới:", currentName);
            if (newName === null) return;

            let newPrice = prompt("Nhập giá sản phẩm mới:", currentPrice);
            if (newPrice === null) return;

            let newGen = prompt("Nhập giới tính sản phẩm mới:", currentGen);
            if (newGen === null) return;

            let newImageLink = prompt("Nhập liên kết hình ảnh sản phẩm mới:", currentImage);
            if (newImageLink === null) return;

            if (confirm("Bạn có chắc chắn muốn cập nhật thông tin sản phẩm này?")) {
                fetch("change_product_inf.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "st_id=" + encodeURIComponent(shoeId) +
                        "&st_name=" + encodeURIComponent(newName) +
                        "&st_price=" + encodeURIComponent(newPrice) +
                        "&st_gen=" + encodeURIComponent(newGen) +
                        "&st_image_link=" + encodeURIComponent(newImageLink)
                })
                    .then(response => response.json())
                    .then(data => {
                        console.log("Phản hồi từ server:", data);
                        if (data.success) {
                            shoeCard.querySelector("h2").textContent = newName;
                            if (priceP) {
                                priceP.textContent = newPrice + "₫";
                            }
                            if (genderP) {
                                genderP.textContent = "Gender: " + newGen;
                            }
                            if (img) {
                                img.setAttribute("src", newImageLink);
                            }
                            alert("Thông tin sản phẩm đã được cập nhật thành công!");
                        } else {
                            alert("Cập nhật thông tin sản phẩm thất bại.");
                        }
                    })
                    .catch(error => {
                        console.error("Lỗi:", error);
                        alert("Đã xảy ra lỗi. Vui lòng thử lại.");
                    });
            }
        }
    });
});
