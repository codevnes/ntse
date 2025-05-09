# NTSE Theme

## Thông tin liên hệ

Tính năng mới: Quản lý thông tin liên hệ và mạng xã hội từ trang admin.

### Cách sử dụng

1. Truy cập **Nội dung > Thông tin liên hệ** trong menu admin
2. Nhập các thông tin liên hệ như số điện thoại, email, địa chỉ và các liên kết mạng xã hội
3. Lưu thông tin

### Hiển thị thông tin liên hệ

Có thể hiển thị thông tin liên hệ bằng các cách sau:

#### Sử dụng shortcode

```
[nts_contact_info type="phone"]
[nts_contact_info type="email"]
[nts_contact_info type="address"]
[nts_contact_info type="facebook" icon="false"]
```

#### Sử dụng code trong template

```php
<?php echo do_shortcode('[nts_contact_info type="phone"]'); ?>
```

hoặc

```php
<?php echo nts_get_contact_info('phone'); ?>
```

#### Sử dụng widget

Thêm widget "NTS - Mạng xã hội" vào khu vực widget để hiển thị các liên kết mạng xã hội.
