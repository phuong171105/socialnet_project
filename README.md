# 🌐 SocialNet – Social Networking Project

**SocialNet** là một ứng dụng mạng xã hội thu nhỏ được xây dựng bằng Native PHP, MySQL, và Nginx trên nền tảng Linux. Dự án tập trung vào tính bảo mật, trải nghiệm người dùng hiện đại và hiệu năng cao.

---

## 👤 Thông tin sinh viên
- **Họ và tên:** Nguyen Van Phuong
- **Mã số sinh viên:** 20225678
- **Lớp:** [Tên lớp của bạn]

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
- Hiển thị thông tin sinh viên và chi tiết về Tech Stack của dự án.

---

## 🛠️ Công nghệ sử dụng
- **Backend:** PHP 8.x (Native)
- **Database:** MySQL 8.0+
- **Web Server:** Nginx 1.2x
- **OS:** Ubuntu Linux
- **Frontend:** HTML5, CSS3 (Modern Dark Mode UI, Responsive Design)

---

## ⚙️ Hướng dẫn cài đặt (Installation Guide)

### 1. Cấu hình Database
Sử dụng MySQL CLI để tạo Database và các bảng cần thiết:
```bash
sudo mysql -u root -p < db.sql
```

### 2. Cấu hình kết nối PHP
Mở file `config/db.php` và cập nhật thông tin tài khoản MySQL của bạn:
```php
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root'); 
define('DB_PASS', 'Mật_khẩu_MySQL_của_bạn');
```

### 3. Triển khai lên Web Server (Nginx)
Copy toàn bộ project vào thư mục web của Nginx:
```bash
sudo cp -r socialnet_project /var/www/
sudo chown -R www-data:www-data /var/www/socialnet_project
```

### 4. Cấu hình Nginx Virtual Host
Sử dụng file `nginx.conf` có sẵn trong dự án để cấu hình cho Nginx:
```bash
sudo cp /var/www/socialnet_project/nginx.conf /etc/nginx/sites-available/socialnet
sudo ln -s /etc/nginx/sites-available/socialnet /etc/nginx/sites-enabled/
sudo nginx -t && sudo systemctl reload nginx
```

---

## ✨ Những điểm nổi bật (Bonus Features)
1. **Security:** Chống Session Fixation bằng cách regenerate ID khi login. Bảo vệ thư mục `/config/` không thể truy cập trực tiếp từ trình duyệt.
2. **UI/UX:** Giao diện Dark Mode chuyên nghiệp, sử dụng font Inter từ Google Fonts, hiệu ứng Glassmorphism và gradient mượt mà.
3. **Responsive:** Hoạt động hoàn hảo trên cả máy tính và thiết bị di động.
4. **News Feed:** Tính năng mở rộng cho phép tương tác bằng cách đăng bài viết.

---
© 2026 - Nguyen Van Phuong
