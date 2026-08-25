# Hướng dẫn thay thế nội dung có sẵn

## Tên và nhận diện

- Tên mặc định và phụ đề: đầu file `public/index.php`, mảng `$config`.
- Logo chữ `ML`: phần `.brand-mark` trong `public/index.php`; thay bằng `<img src="assets/logo.png" alt="Logo công ty">` và chép logo vào `public/assets/`.
- Màu chính: các biến `--primary`, `--green`, `--nav` ở đầu `public/assets/style.css`.
- Tiêu đề từng trang: biến `titles` trong `public/assets/app.js`.

## Dữ liệu mẫu

Dữ liệu tài sản/vật tư/điều chuyển/bảo trì nằm trong biến `seed` ở đầu `public/assets/app.js`. Giữ nguyên tên thuộc tính khi thay nội dung. Có thể dùng `tools/assets-template.csv` làm mẫu và chạy:

```powershell
python tools/import_assets.py tools/assets-template.csv
```

## Trạng thái chuẩn

Nên giữ bốn trạng thái tài sản: `Đang sử dụng`, `Lưu kho`, `Bảo trì`, `Chờ thanh lý`. Nếu đổi, cập nhật đồng thời các bộ lọc, badge, dashboard và quy tắc nghiệp vụ.

## Từ demo sang dữ liệu thật

1. Tạo database từ `database/schema.sql`.
2. Thay các thao tác Local Storage trong `app.js` bằng `fetch('/api.php?resource=assets')`.
3. Xác thực bằng session PHP, dùng `password_hash()`/`password_verify()`, CSRF token và cookie `HttpOnly; Secure; SameSite=Lax`.
4. Kiểm tra quyền ở server cho mọi API; không chỉ ẩn nút trên giao diện.
5. Upload file ra ngoài `public`, đổi tên ngẫu nhiên, kiểm MIME/kích thước và phục vụ qua endpoint có phân quyền.

## Sơ đồ database

Mở `database/qlts.drawio` trên `https://app.diagrams.net` hoặc ứng dụng diagrams.net Desktop. Khi thêm bảng, tạo entity mới, đánh dấu PK/FK rồi nối quan hệ tương ứng; cập nhật `schema.sql` cùng lúc.
