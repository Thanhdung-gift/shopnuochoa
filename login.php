<?php
// Cấu hình kết nối với cơ sở dữ liệu
$servername = "localhost"; // Thường là localhost trong cPanel
$username = "your_db_username"; // Tên người dùng cơ sở dữ liệu của bạn
$password = "your_db_password"; // Mật khẩu cơ sở dữ liệu của bạn
$dbname = "your_db_name"; // Tên cơ sở dữ liệu của bạn

// Kết nối đến cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Kết nối không thành công: " . $conn->connect_error);
}

// Nhận dữ liệu từ form đăng nhập
$username = $_POST['username']; // Lấy tên tài khoản từ form
$password = $_POST['password']; // Lấy mật khẩu từ form

// Truy vấn để kiểm tra người dùng có tồn tại không
$sql = "SELECT * FROM users WHERE username = ?"; // Sử dụng prepared statement để tránh SQL injection
$sql = $conn->prepare($sql); // Chuẩn bị câu lệnh SQL
$sql->bind_param("s", $username); // Ràng buộc tham số
$sql->execute(); // Thực thi câu lệnh
$result = $sql->get_result(); // Lấy kết quả truy vấn

if ($result->num_rows > 0) { // Kiểm tra xem có người dùng nào không
    // Nếu tìm thấy người dùng, kiểm tra mật khẩu
    $row = $result->fetch_assoc(); // Lấy thông tin người dùng
    if (password_verify($password, $row['password'])) { // So sánh mật khẩu đã mã hóa
        echo "Đăng nhập thành công!"; // Nếu mật khẩu đúng
        // Chuyển hướng người dùng đến trang chính
        header("Location: /index.html");
        exit();
    } else {
        echo "Mật khẩu không chính xác!"; // Nếu mật khẩu sai
    }
} else {
    echo "Không tìm thấy tài khoản với tên tài khoản này!"; // Nếu không tìm thấy tài khoản
}

// Đóng kết nối
$conn->close();
?>
