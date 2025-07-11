# 🎓 Hướng Dẫn Cài Đặt Website Học Tiếng Anh

## 📋 Yêu Cầu Hệ Thống

- PHP >= 8.1
- Composer
- Node.js >= 16
- MySQL >= 8.0
- Git

## 🚀 Cài Đặt Nhanh

### 1. Clone Repository
```bash
git clone https://github.com/huydepzai121/hoctienganh.git
cd hoctienganh
```

### 2. Cài Đặt Dependencies
```bash
# PHP dependencies
composer install

# JavaScript dependencies
npm install
```

### 3. Cấu Hình Environment
```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Cấu Hình Database
Chỉnh sửa file `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hoctienganh
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Tạo Database và Chạy Migration
```bash
# Tạo database (nếu chưa có)
mysql -u root -p -e "CREATE DATABASE hoctienganh CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# Chạy migration và seeder
php artisan migrate --seed

# Nếu gặp lỗi duplicate entry, chạy:
php artisan migrate:fresh --seed
```

### 6. Build Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### 7. Khởi Động Server
```bash
# Development server
php artisan serve

# Website sẽ chạy tại: http://localhost:8000
```

## 🔑 Tài Khoản Mặc Định

### Admin Panel
- **URL**: http://localhost:8000/admin
- **Email**: admin@hoctienganh.com
- **Password**: password

### Student Account
- **Email**: student@hoctienganh.com
- **Password**: password

### Instructor Account
- **Email**: instructor@hoctienganh.com
- **Password**: password

## 📊 Cấu Trúc Database

### Bảng Chính
- `users` - Người dùng (admin, instructor, student)
- `categories` - Danh mục khóa học
- `courses` - Khóa học
- `lessons` - Bài học
- `enrollments` - Đăng ký khóa học
- `lesson_user` - Tiến độ hoàn thành bài học

### Migration Status
Kiểm tra trạng thái migration:
```bash
php artisan migrate:status
```

## 🎯 Tính Năng Chính

### Frontend (Học Viên)
- ✅ Trang chủ với khóa học nổi bật
- ✅ Danh sách khóa học với filter/search
- ✅ Chi tiết khóa học và đăng ký
- ✅ Học bài với progress tracking
- ✅ Responsive design

### Admin Panel
- ✅ Dashboard với thống kê
- ✅ Quản lý danh mục (CRUD)
- ✅ Quản lý khóa học (CRUD)
- ✅ Quản lý bài học (CRUD)
- ✅ Quản lý người dùng (CRUD)
- ✅ AdminLTE professional design

## 🔧 Troubleshooting

### Lỗi Permission
```bash
sudo chmod -R 775 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Reset Database
```bash
# Xóa toàn bộ và tạo lại database
php artisan migrate:fresh --seed

# Hoặc chỉ chạy seeder lại (an toàn hơn)
php artisan db:seed
```

## 🌐 URLs Quan Trọng

- **Website**: http://localhost:8000
- **Admin Panel**: http://localhost:8000/admin
- **Courses**: http://localhost:8000/courses
- **Login**: http://localhost:8000/login
- **Register**: http://localhost:8000/register

## 📱 Responsive Design

Website được thiết kế responsive, hoạt động tốt trên:
- Desktop (1200px+)
- Tablet (768px - 1199px)
- Mobile (< 768px)

## 🔒 Bảo Mật

- CSRF Protection
- Authentication & Authorization
- Role-based Access Control
- Input Validation
- SQL Injection Prevention

## 📞 Hỗ Trợ

Nếu gặp vấn đề, vui lòng:
1. Kiểm tra log: `storage/logs/laravel.log`
2. Chạy `php artisan config:cache`
3. Đảm bảo database đã được tạo và migration đã chạy

---

**🎉 Chúc bạn sử dụng website học tiếng Anh thành công!**
