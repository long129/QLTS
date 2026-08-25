# QLTS Enterprise - Quản lý tài sản doanh nghiệp

Ứng dụng web mẫu được xây dựng từ 15 ảnh tham chiếu, giữ lại các luồng nghiệp vụ chính nhưng thay nội dung phòng khám bằng dữ liệu doanh nghiệp trung tính.

## Chạy nhanh trên Windows 11

1. Cài PHP 8.2+ (bật `pdo_sqlite`, `sqlite3`, `fileinfo`) hoặc XAMPP.
2. Trong VS Code mở thư mục này, chạy `php -S localhost:8080 -t public`.
3. Mở `http://localhost:8080`, đăng nhập `admin` / `Admin@123`.

Chạy trong mạng nội bộ bằng `powershell -ExecutionPolicy Bypass -File .\start-lan.ps1`, sau đó các máy cùng LAN mở `http://192.168.1.100:8080`.

Nếu dùng XAMPP, chép thư mục vào `C:\xampp\htdocs\qlts`, mở `http://localhost/qlts/public/`.

## Cấu trúc

- `public/index.php`: giao diện chính và điều hướng.
- `public/assets/`: CSS và JavaScript tương tác.
- `public/api.php`: API JSON CRUD sử dụng PDO.
- `database/schema.sql`: cấu trúc SQLite/MySQL tham chiếu.
- `database/qlts.drawio`: sơ đồ ERD mở trực tiếp bằng diagrams.net/draw.io.
- `tools/import_assets.py`: kiểm tra và chuyển CSV tài sản thành JSON.
- `docs/HUONG_DAN_CAI_DAT.md`: cài đặt Windows 11, VS Code, MobaXterm.
- `docs/HUONG_DAN_SU_DUNG.md`: hướng dẫn người dùng theo từng phân hệ.
- `docs/THAY_THE_NOI_DUNG.md`: vị trí thay logo, tên công ty, màu sắc và dữ liệu mẫu.

## Bảo mật trước khi dùng thật

Đổi mật khẩu mẫu, đặt `APP_ENV=production`, cấu hình HTTPS, giới hạn loại/kích thước file upload, sao lưu database và phân quyền thư mục `storage/`. Phiên bản mẫu dùng dữ liệu trình diễn trong trình duyệt; API PHP đã có nền tảng SQLite để nối dữ liệu thật.

## Triển khai từ GitHub

Clone repository, sao chép `.env.example` thành `.env`, tạo quyền ghi cho `storage/` và chạy `start-lan.ps1`. File database SQLite, file upload, mật khẩu môi trường và cấu hình máy cá nhân không được lưu trong Git.
