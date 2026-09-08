# Kế hoạch hoàn thiện movieON

## Phase 1 — Nền tảng và dữ liệu (hoàn thành trong mã nguồn)

- Chuẩn hóa mapping Eloquent với các bảng `tbl_*`, khóa chính và quan hệ.
- Chuẩn hóa schema phim/tập, slug, trạng thái, metadata và khóa ngoại.
- Thêm dữ liệu demo có thể chạy lặp lại bằng seeder.
- Nâng Laravel lên phiên bản còn được hỗ trợ là việc cần làm trước khi production.

Tiêu chí nghiệm thu: migrate và seed thành công; phim demo có genre, country và một episode.

## Phase 2 — Luồng xem phim MVP (hoàn thành trong mã nguồn)

- Trang chủ lấy dữ liệu động.
- Kho phim có tìm kiếm, lọc thể loại/quốc gia và phân trang.
- Trang chi tiết dùng slug, có phim liên quan và danh sách tập.
- Trang xem kiểm tra tập thuộc phim, hỗ trợ iframe và responsive.

Tiêu chí nghiệm thu: từ trang chủ mở được chi tiết và phát tập; URL sai trả 404.

## Phase 3 — Quản trị nội dung (đã có lõi, còn mở rộng taxonomy/upload)

- Đã có middleware admin và CRUD phim/tập với validation.
- Tiếp theo: CRUD thể loại/quốc gia/danh mục, upload ảnh vào storage, xử lý báo nguồn hỏng.
- Bổ sung audit log và soft delete trước khi nhiều quản trị viên cùng sử dụng.

Tiêu chí nghiệm thu: user thường nhận 403; admin tạo/sửa/ẩn/xóa phim và tập được.

## Phase 4 — Tài khoản và vận hành (chưa triển khai)

- Danh sách xem sau, yêu thích, lịch sử và lưu tiến độ phát.
- Phụ đề WebVTT, nhiều server/chất lượng, tự chuyển tập và báo lỗi.
- SEO, sitemap, cache, queue, thống kê, backup/restore và giám sát.
- Feature test cho catalog, phân quyền, CRUD và ràng buộc episode; kiểm thử trình duyệt/mobile.

Tiêu chí nghiệm thu: các luồng chính có test tự động; có backup khôi phục thử; lỗi player được ghi nhận.

## Khởi chạy cục bộ

1. Cài PHP/Composer/Node phù hợp, tạo `.env` từ `.env.example` và cấu hình database.
2. Đặt `ADMIN_EMAIL` và `ADMIN_PASSWORD` trong `.env` để seeder tạo tài khoản quản trị.
3. Chạy `composer install`, `php artisan key:generate`, `php artisan migrate:fresh --seed`.
4. Chạy `npm install`, `npm run dev`, rồi `php artisan serve`.

Lưu ý: `migrate:fresh` xóa dữ liệu hiện có; chỉ dùng cho môi trường phát triển mới.
