# 🌐 SocialNet – Social Networking Project

**SocialNet** là một ứng dụng mạng được xây dựng bằng Native PHP, MySQL, và Nginx trên nền tảng Linux. 

---

## 👤 Thông tin sinh viên
- **Họ và tên:** (Tự động hiển thị theo Full Name của tài khoản)
- **Mã số sinh viên:** (Tạo ngẫu nhiên theo tài khoản)

---

## 🚀 Các tính năng chính

### 1. Trang Quản trị (Admin) - `/admin/newuser.php`
- Cho phép quản trị viên khởi tạo tài khoản người dùng mới.
- Kiểm tra tính hợp lệ của dữ liệu đầu vào (username duy nhất, độ dài mật khẩu...).

### 2. Hệ thống Xác thực (Auth) - `/socialnet/signin.php`
- Đăng nhập bảo mật sử dụng session.
- Mật khẩu được mã hóa chuẩn **bcrypt** (không lưu bản rõ).
- Tự động chuyển hướng về trang chủ nếu đã đăng nhập.

### 3. Bảng tin (News Feed) - `/socialnet/index.php`
- Người dùng có thể chia sẻ trạng thái mới.
- Xem danh sách bài đăng của mọi người trên hệ thống theo thời gian thực.
- Sidebar hiển thị danh sách người dùng khác để nhanh chóng xem Profile.

### 4. Trang cá nhân (Profile) - `/socialnet/profile.php`
- Hiển thị thông tin chi tiết và tiểu sử của người dùng.
- Hỗ trợ tham số `?owner=username` để xem profile của bất kỳ ai trên hệ thống.

### 5. Cấu hình tài khoản (Setting) - `/socialnet/setting.php`
- Chỉnh sửa họ tên, thông tin giới thiệu (Bio).
- **Tính năng mở rộng:** Cho phép đổi mật khẩu (yêu cầu xác nhận mật khẩu hiện tại).

### 6. Trang thông tin (About) - `/socialnet/about.php`
- Hiển thị thông tin động (dynamic) theo người dùng đăng nhập.
- Hiển thị chi tiết về Tech Stack của dự án.

---

## 🛠️ Công nghệ sử dụng
- **Backend:** PHP 8.x (Native)
- **Database:** MySQL 8.0+
- **Web Server:** Nginx 1.2x
- **OS:** Ubuntu Linux
- **Frontend:** HTML5, CSS3 (Modern Dark Mode UI, Responsive Design)

---

## ⚙️ Hướng dẫn cài đặt & Chạy dự án

Để chạy dự án này trên môi trường Local/Server mới, vui lòng thực hiện tuần tự các bước sau:

### Bước 1: Khởi tạo Cơ sở dữ liệu (Database)
Dự án đã đính kèm sẵn file `db.sql` bao gồm toàn bộ cấu trúc bảng (`account`, `post`). Chỉ cần import file này vào MySQL:

```bash
sudo mysql -u root -p < db.sql
```
*(Lệnh trên sẽ tự động tạo database `socialnet` và các bảng liên quan).*

### Bước 2: Cấu hình kết nối PHP tới MySQL
Mở file `config/db.php` và cập nhật thông tin tài khoản MySQL của môi trường chấm thi (User/Pass).

```php
define('DB_HOST', '127.0.0.1'); // Hoặc 'localhost'
define('DB_PORT', '3306');
define('DB_NAME', 'socialnet');
define('DB_USER', 'THAY_BANG_USER_CUA_THAY'); 
define('DB_PASS', 'THAY_BANG_PASS_CUA_THAY');
```

*Lưu ý:* Nếu sử dụng User `root` trên Ubuntu, có thể MySQL đang cấu hình `auth_socket`. Trong trường hợp đó, vui lòng tạo một user MySQL riêng rẽ (có mật khẩu) và cấp quyền truy cập vào database `socialnet` để PHP có thể kết nối được.

### Bước 3: Triển khai lên Web Server (Nginx)
Copy toàn bộ mã nguồn vào thư mục root của web server và cấp quyền cho Nginx (`www-data`):

```bash
sudo cp -r socialnet_project /var/www/
sudo chown -R www-data:www-data /var/www/socialnet_project
sudo chmod -R 755 /var/www/socialnet_project
```

### Bước 4: Cấu hình Virtual Host cho Nginx
Copy file cấu hình Nginx có sẵn trong dự án:

```bash
sudo cp /var/www/socialnet_project/nginx.conf /etc/nginx/sites-available/socialnet
sudo ln -s /etc/nginx/sites-available/socialnet /etc/nginx/sites-enabled/
# Xóa cấu hình default nếu bị xung đột port 80
sudo rm -f /etc/nginx/sites-enabled/default

# Kiểm tra và khởi động lại Nginx
sudo nginx -t
sudo systemctl restart nginx
```

### Bước 5: Chạy thử ứng dụng
1. Mở trình duyệt, truy cập `http://localhost/admin/newuser.php` để tạo một tài khoản đầu tiên.
2. Truy cập `http://localhost/socialnet/signin.php` để đăng nhập.
3. Trải nghiệm hệ thống mạng xã hội thu nhỏ!

---
© 2026 - Do Thi Thu Phuong
