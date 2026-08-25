# Triển khai QLTS trong mạng nội bộ

## Máy chủ

Máy Windows 11 chạy website phải luôn bật, kết nối cùng router/switch với người dùng và nên được đặt IP tĩnh hoặc DHCP reservation. IP hiện tại là `192.168.1.100`.

Mở PowerShell tại dự án và chạy:

```powershell
powershell -ExecutionPolicy Bypass -File "D:\My Project\QLTS\start-lan.ps1"
```

## Máy người dùng

Các máy cùng Wi-Fi/LAN truy cập:

```text
http://192.168.1.100:8080
```

Không cần cài PHP, Python hoặc Node trên máy người dùng.

## Điều kiện mạng

- Profile mạng Windows của máy chủ nên là **Private**.
- Windows Firewall chỉ mở TCP 8080 cho subnet nội bộ `192.168.1.0/24`.
- Router phải bật chế độ cho các máy LAN giao tiếp với nhau; tắt AP/client isolation nếu có.
- Không cấu hình port forwarding cổng 8080 ra Internet.

## Vận hành ổn định

Nên đặt DHCP reservation cho MAC của máy chủ để giữ IP `192.168.1.100`. Sao lưu thư mục `storage` hằng ngày. Khi sử dụng chính thức với nhiều người đồng thời, nên chuyển từ PHP development server sang Apache/Nginx và HTTPS nội bộ.
