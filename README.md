# 🎓 Website Học Tiếng Anh

Nền tảng học tiếng Anh trực tuyến hoàn chỉnh được xây dựng bằng Laravel với giao diện hiện đại và tính năng đầy đủ.

## ✨ Tính năng chính

### 👥 Hệ thống người dùng
- **3 vai trò**: Admin, Instructor (Giảng viên), Student (Học viên)
- Đăng ký, đăng nhập, quên mật khẩu
- Quản lý hồ sơ cá nhân

### 📚 Quản lý khóa học
- Danh sách khóa học với bộ lọc thông minh
- Chi tiết khóa học với thông tin đầy đủ
- Đăng ký khóa học trực tuyến
- Theo dõi tiến độ học tập

### 🎯 Admin Panel
- Dashboard với thống kê tổng quan
- Quản lý danh mục khóa học (CRUD)
- Quản lý khóa học (CRUD)
- Quản lý bài học (CRUD)
- Quản lý người dùng (CRUD)

### 🎨 Giao diện
- Responsive design tương thích mobile
- Bootstrap 5 với thiết kế hiện đại
- Animations và hover effects
- Toast notifications

## 🛠️ Công nghệ sử dụng

- **Backend**: Laravel 10+ với Laravel Breeze
- **Database**: MySQL
- **Frontend**: Bootstrap 5, Font Awesome
- **Authentication**: Laravel Breeze
- **Icons**: Font Awesome 6

## 📋 Yêu cầu hệ thống

- PHP 8.1+
- Composer
- MySQL/MariaDB
- Node.js & NPM (tùy chọn)

## 🚀 Cài đặt

### 1. Clone repository
```bash
git clone https://github.com/huydepzai121/hoctienganh.git
cd hoctienganh
```

### 2. Cài đặt dependencies
```bash
composer install
npm install # (tùy chọn)
```

### 3. Cấu hình môi trường
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Cấu hình database
Chỉnh sửa file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hoctienganh
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Tạo database và chạy migrations
```bash
# Tạo database
mysql -u root -p
CREATE DATABASE hoctienganh;
exit

# Chạy migrations và seeders
php artisan migrate --seed
```

### 6. Khởi động server
```bash
php artisan serve
```

Website sẽ chạy tại: http://localhost:8000

## 👤 Tài khoản demo

### Admin (Quản trị viên)
- **Email**: admin@hoctienganh.com
- **Password**: password
- **URL**: http://localhost:8000/admin

### Instructor (Giảng viên)
- **Email**: instructor@hoctienganh.com
- **Password**: password

### Student (Học viên)
- **Email**: student@hoctienganh.com
- **Password**: password

## 📱 Các trang chính

### Frontend
- **Trang chủ**: http://localhost:8000
- **Danh sách khóa học**: http://localhost:8000/courses
- **Đăng nhập**: http://localhost:8000/login
- **Đăng ký**: http://localhost:8000/register

### Admin Panel
- **Dashboard**: http://localhost:8000/admin
- **Quản lý danh mục**: http://localhost:8000/admin/categories
- **Quản lý khóa học**: http://localhost:8000/admin/courses
- **Quản lý bài học**: http://localhost:8000/admin/lessons
- **Quản lý người dùng**: http://localhost:8000/admin/users

## 📊 Dữ liệu mẫu

Hệ thống đã được tạo sẵn:
- ✅ **6 danh mục** khóa học (Giao tiếp, Thương mại, IELTS, TOEIC, Ngữ pháp, Từ vựng)
- ✅ **6 khóa học** hoàn chỉnh với mô tả chi tiết
- ✅ **18 bài học** mẫu (3 bài/khóa học)
- ✅ **3 tài khoản** với các vai trò khác nhau

## 🔧 Troubleshooting

### Lỗi permission
```bash
chmod -R 775 storage bootstrap/cache
```

### Lỗi database connection
```bash
php artisan config:clear
php artisan cache:clear
```

### Reset database
```bash
php artisan migrate:fresh --seed
```

## 📸 Screenshots

### Trang chủ
- Hero section với call-to-action
- Khóa học nổi bật
- Danh mục khóa học
- Thống kê và footer

### Admin Dashboard
- Thống kê tổng quan
- Danh sách đăng ký gần đây
- Khóa học phổ biến
- Quick actions

### Danh sách khóa học
- Bộ lọc theo danh mục, cấp độ, giá
- Tìm kiếm khóa học
- Cards responsive với thông tin đầy đủ

## 🤝 Đóng góp

1. Fork repository
2. Tạo feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Tạo Pull Request

## 📄 License

Dự án này được phân phối dưới MIT License. Xem file `LICENSE` để biết thêm chi tiết.

## 📞 Liên hệ

- **Email**: info@hoctienganh.com
- **GitHub**: https://github.com/huydepzai121/hoctienganh

---

⭐ Nếu dự án này hữu ích, hãy cho một star nhé!
