document.addEventListener("DOMContentLoaded", function () {
    document.addEventListener("click", function (e) {
        if (e.target.matches(".delete_shoe_btn")) {
            const shoeCard = e.target.closest(".shoe-card");
            const shoeId = shoeCard?.dataset.id;

            if (confirm("Bạn có chắc chắn muốn xóa sản phẩm này?")) {
                fetch("delete_shoe.php", {
                    method: "POST",
                    headers: { "Content-Type": "application/x-www-form-urlencoded" },
                    body: "id=" + encodeURIComponent(shoeId)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        shoeCard.remove();
                        alert("Sản phẩm đã được xóa thành công!");
                    } else {
                        alert("Xóa sản phẩm thất bại.");
                    }
                })
                .catch(error => {
                    console.error("Lỗi:", error);
                    alert("Đã xảy ra lỗi khi xóa sản phẩm.");
                });
            }
        }

        // Nút CHỈNH SỬA
        else if (e.target.matches(".change_shoe_btn")) {
            const shoeCard = e.target.closest(".shoe-card");
            const stId = shoeCard?.dataset.id;

            if (stId) {
                // Chuyển hướng sang trang chỉnh sửa với st_id
                window.location.href = "change_product_inf.php?st_id=" + encodeURIComponent(stId);
            } else {
                alert("Không tìm thấy ID sản phẩm.");
            }
        }
        else if (e.target.matches(".show_shoe_inf_btn")) {
            const shoeCard = e.target.closest(".shoe-card");
            const stId = shoeCard?.dataset.id;

            if (stId) {
                window.location.href = "show_shoe_inf.php?st_id=" + encodeURIComponent(stId);
            } else {
                alert("Không tìm thấy ID sản phẩm.");
            }
        }
    });
});
