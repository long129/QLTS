# Hướng dẫn sử dụng

## Đăng nhập và tổng quan

Đăng nhập bằng tài khoản được quản trị viên cấp. Dashboard hiển thị tổng tài sản, trạng thái sử dụng, tài sản lưu kho/bảo trì, nguyên giá và hoạt động mới nhất.

## Tài sản

- Chọn **Tài sản** để tìm theo mã/tên hoặc lọc trạng thái.
- **Thêm tài sản** yêu cầu mã duy nhất, tên, nhóm, bộ phận và vị trí.
- Nút ✎ sửa thông tin; ⇄ tạo điều chuyển; 🗑 xóa sau khi xác nhận.
- **Xuất CSV** tải danh sách đang quản lý để mở bằng Excel.
- Khấu hao hiển thị theo đường thẳng từ ngày mua và số năm sử dụng hữu ích.

## Kho

Theo dõi vật tư, đơn vị tính, đơn giá, tồn kho và cảnh báo. **Nhập/Xuất** thay đổi số lượng; khi vận hành thật nên nhập số lượng, số chứng từ và người giao nhận trong phiếu kho.

## Luân chuyển

Chọn tài sản, bộ phận/vị trí nhận và nhập lý do. Hệ thống cập nhật vị trí hiện tại, lưu lịch sử và hỗ trợ in biên bản bàn giao bằng hộp thoại in của trình duyệt.

## Bảo trì

Chọn máy, ngày, nội dung hỏng hóc, đơn vị sửa, chi phí và tiến độ. Khi phiếu đang xử lý, trạng thái máy chuyển **Bảo trì**; khi hoàn tất chuyển lại **Đang sử dụng**.

## Danh mục, kiểm kê, tài khoản

- Danh mục quản lý loại tài sản, phòng ban và vị trí trước khi nhập dữ liệu.
- Kiểm kê chọn phạm vi và thành viên, sau đó tạo đợt đối chiếu.
- Tài khoản phân vai: quản trị, quản lý bộ phận, nhân viên kho, người xem.
- Nhật ký lưu đăng nhập và các hành động thêm/sửa/xóa/điều chuyển.

### Phân quyền tài khoản

- **Admin:** toàn quyền xem, thêm, sửa, xóa, phân quyền và quản lý tài khoản.
- **Thủ quỹ:** xem tài sản, xem mua sắm, duyệt chi, ký biên bản và xem nhật ký; không thêm/sửa/xóa tài sản.
- **Kế toán:** xem, thêm và sửa tài sản; quản lý mua sắm, phê duyệt, thanh lý; không xóa tài sản hoặc quản lý tài khoản.
- **Nhân sự:** xem tài sản, cập nhật người chịu trách nhiệm, ký biên bản và xem nhật ký; không thêm/xóa tài sản.

Tài khoản mẫu: `thuquy / Quy@123`, `ketoan / KT@12345`, `nhansu / NS@12345`.

## Các phân hệ quản trị mở rộng

- **Người chịu trách nhiệm:** khai báo người trực tiếp giữ/sử dụng và đầu mối quản lý trong hồ sơ tài sản.
- **Quy trình phê duyệt:** tạo đề xuất mua sắm, điều chuyển, sửa chữa, mang ra ngoài hoặc thanh lý; xử lý lần lượt qua trưởng bộ phận, kế toán và giám đốc.
- **Biên bản & chữ ký:** tạo biên bản gắn với tài sản, ký xác nhận theo từng bên và in/lưu PDF.
- **Hồ sơ vòng đời:** tại danh sách tài sản, chọn nút ◎ để xem toàn bộ sự kiện từ nhập, bàn giao, sửa đổi, điều chuyển, bảo trì tới thanh lý.
- **Mua sắm & nhà cung cấp:** lưu MST, liên hệ, đánh giá NCC; tạo đơn mua và tự động sinh đề xuất phê duyệt.
- **Tài sản CNTT:** lưu hostname, IP, MAC, CPU, RAM, ổ đĩa, hệ điều hành, license và trạng thái an toàn.
- **Thanh lý:** lập hồ sơ định giá, phương thức xử lý và xác nhận xóa dữ liệu an toàn đối với thiết bị CNTT.
- **Nhật ký bất biến:** mọi thay đổi quan trọng được ghi nối tiếp trong SQLite, có hash SHA-256 liên kết bản ghi và không có API sửa/xóa nhật ký.

## Dữ liệu demo

Dữ liệu giao diện được giữ trong Local Storage của trình duyệt để có thể trình diễn ngay. Xóa key `qlts_data` trong Developer Tools > Application > Local Storage để trở về dữ liệu mẫu. Khi đưa vào vận hành, nối các biểu mẫu với `public/api.php` và SQLite/MySQL theo `database/schema.sql`.
