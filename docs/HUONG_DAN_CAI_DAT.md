# Hướng dẫn cài đặt và triển khai

## 1. Chuẩn bị Windows 11

Cài VS Code, PHP 8.2+ và Python 3.11+. Trong `php.ini`, bỏ dấu `;` trước `extension=pdo_sqlite`, `extension=sqlite3`, `extension=fileinfo`. Khởi động lại Terminal rồi kiểm tra `php -v` và `python --version`.

## 2. Chạy trong VS Code

Mở thư mục dự án, mở Terminal và chạy:

```powershell
php -S localhost:8080 -t public
```

Truy cập `http://localhost:8080`. Tài khoản trình diễn là `admin` / `Admin@123`.

## 3. Chạy bằng XAMPP

Chép dự án vào `C:\xampp\htdocs\qlts`, bật Apache, truy cập `http://localhost/qlts/public/`. Bảo đảm tài khoản Apache có quyền ghi thư mục `storage`.

## 4. Triển khai Linux qua MobaXterm

Kết nối SSH, kéo thư mục lên `/var/www/qlts` bằng SFTP bên trái. Cài `php`, `php-sqlite3`, cấu hình DocumentRoot trỏ tới `/var/www/qlts/public`, rồi cấp quyền ghi cho `storage`:

```bash
sudo chown -R www-data:www-data /var/www/qlts/storage
sudo chmod -R 750 /var/www/qlts/storage
```

Tạo VirtualHost Apache/Nginx, bật HTTPS bằng chứng thư của doanh nghiệp. Không đưa thư mục `database`, `docs`, `tools`, `storage` ra web root.

## 5. Cấu hình tên doanh nghiệp

Có thể đặt biến môi trường `COMPANY_NAME` và `APP_SUBTITLE`. Với Apache dùng `SetEnv`; với PHP-FPM dùng `env[...]` hoặc file cấu hình máy chủ.

## 6. Sao lưu

Dừng ghi dữ liệu trong lúc sao lưu, chép `storage/qlts.sqlite` và thư mục file đính kèm. Nên sao lưu hằng ngày, giữ tối thiểu 7 phiên bản và thử phục hồi định kỳ.
