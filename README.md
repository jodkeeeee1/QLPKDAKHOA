# WEBSITE QUẢN LÝ BỆNH VIỆN PHÒNG KHÁM ĐẶT LỊCH KHÁM BỆNH


# Phạm vi dự án

-   Đề tài tập trung phát triển một hệ thống quản lý bệnh viện trực tuyến tích hợp khám
    bệnh từ xa (Telemedicine), bao gồm các chức năng chính sau:
-   Đặt lịch khám trực tuyến: Bệnh nhân có thể đăng nhập vào hệ thống và đặt lịch
    khám theo chuyên khoa mong muốn. Bệnh nhân có thể quản lý lịch hẹn, xác nhận thay
    đổi lịch hẹn nếu cần.
-   Quản lý hồ sơ bệnh án: Lưu và quản lý thông tin hồ sơ bệnh án của bệnh nhân bao
    gồm lịch sử bệnh án, các chuẩn đoán, kết quả dịch vụ cận lâm sàng và đơn thuốc nếu có.
-   Bệnh nhân có thể truy cập và xem lại bệnh án bất cứ lúc nào.
    Thanh toán trực tuyến: Hệ thống tích hợp phương thức thanh toán trực tuyến và an
    toàn như ví điện tử MoMoPay, ZaloPay, VNPay,.. Hóa đơn sẽ được gửi đến email sau khi
    thanh toán thành công
-   Telemedicine (Khám bệnh từ xa): Bệnh nhân và bác sĩ có thể thực hiện các cuộc
    goi video trực tuyến để tư vấn từ xa. Buổi tư vấn được ghi lại và lưu trữ, thông tin bệnh
    án được gửi về email của bệnh nhân sau khi khám.
-   Quản lí thông tin nhân sự: Quản lí thông tin bao gồm lịch làm việc, thông tin cá
    nhân của bác sĩ và nhân viên y tế

-   Công nghệ sử dụng
    HTML5/ CSS3, Javascript, PHP/Laravel, Ajax, MySQL

# Tài khoản

-   Admin: admin@gmail.com - admin123456
-   Bác sĩ: bacsi@gmail.com - admin123456
-   Nhân viên: staff@gmail.com - admin123456
-   Nười dùng: 0123456780 - admin123456
                0352569856 - vanhoa123

## Cài đặt

Để cài đặt dự án, bạn cần thực hiện các bước sau:

1. Clone repository

2. Cài đặt các phụ thuộc:

    ```bash
    composer install

    ```

3. Tạo file .env:

    ```bash
    cp .env.example .env

    ```

4. Cấu hình file .env:
   Mở file .env và cấu hình các thông số kết nối cơ sở dữ liệu, ứng dụng, và các thông tin khác cần thiết cho dự án.

5. Tạo khóa ứng dụng:

    ```bash
    php artisan key:generate

    ```

6. Chạy migration:

    ```bash
    php artisan migrate

    ```

7. Chạy seeder:

    ```bash
    php artisan db:seed

    ```

8. Run project:

    ```bash
    php artisan serve

    ```

9. Truy cập vào đường dẫn để xem ứng dụng:
    ```bash
    http://127.0.0.1:8000
    ```

Đóng góp
Nếu bạn muốn đóng góp cho dự án, vui lòng tạo pull request và tuân thủ các quy tắc đóng góp.

Giấy phép
Dự án này được cấp phép theo MIT License.

Số thẻ	9704 0000 0000 0018
Tên chủ thẻ	NGUYEN VAN A
Ngày phát hành	03/07

Nếu không được thì thử bộ khác:

Thông tin	Giá trị
Số thẻ	9704 0000 0000 0026
Tên chủ thẻ	NGUYEN VAN B
Ngày phát hành	03/07
Với sandbox của MoMo, OTP test thường là:

000000

Nếu không được thì thử:

123456

hoặc:

111111
Ngân hàng	Số thẻ	Tên chủ thẻ	Ngày phát hành
NCB	9704198526191432198	NGUYEN VAN A	07/15
NCB	9704198526191432198	NGUYEN VAN A	01/23
BIDV	9704188526191432198	NGUYEN VAN A	01/23

OTP:

123456