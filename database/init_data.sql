﻿-- User

-- Config
truncate `config`;
truncate `module_sub_module`;
truncate `sub_module`;
truncate `user_module`;
truncate `module`;
truncate `user`;

INSERT INTO `user` (`id`, `shop_id`, `name`, `email`, `phone_number`, `username`, `password`, `confirmcode`, `status`, `start_date`, `end_date`, `description`, `salary_by_hour`, `work_from`, `work_to`, `is_admin`) VALUES 
(1, 1, 'Trần Trí Duệ', 'trantridue@gmail.com', '0979355285', 'admin', '4eae18cf9e54a0f62b44176d074cbe2f', 'y', 'y', '2014-01-01 10:00:00', '2020-12-31 22:00:00', 'Ông chủ', 8000, 8, 21, 1),
(2, 2, 'Lê Thị Châu', 'chau@gmail.com', '0966807709', 'chau', '4eae18cf9e54a0f62b44176d074cbe2f', 'y', 'y', '2014-01-01 10:00:00', '2020-12-31 22:00:00', 'Bà Chủ', 8000, 8, 21, 0);


INSERT INTO `config` (`id`, `key`, `value`, `label`, `type`, `description`, `sort_order`) VALUES
(1, 'nbr_row_import', '10', 'Số dòng nhập hàng ', 'number', 'Số dòng nhập hàng mặc định', 1),
(2, 'nbr_row_export', '10', 'Số dòng xuất hàng ', 'number', 'Số dòng xuất hàng mặc định', 2),
(3, 'nbr_row_return', '10', 'Số dòng trả hàng ', 'number', 'Số dòng trả hàng mặc định', 3),
(4, 'on_off_sale', '0', 'Khuyến mại ', 'button', 'Bật tắt chế độ sale', 5),
(5, 'sale_percent', '0', 'Phần trăm khuyến mại', 'number', 'Phần trăm sale', 6),
(6, 'welcome_msg', 'Kính chào quý khách', 'Thông điệp ', 'text', 'Thông điệp chào mừng khách', 4),
(7, 'start_date', '2015-10-15', 'Ngày mở hàng', 'date', 'Ngày khai trương shop', 7),
(8, 'end_date', '2015-10-15 14:29:17', 'Ngày đóng hàng', 'datetime', 'Ngày đóng shop', 8),
(9, 'policy', 'Chính sách cửa hàng', 'Zabuza shop policy ', 'textarea', 'Chính sách của cửa hàng', 11),
(10, 'is_maintain_mode', '1', 'Maintain mode ', 'checkbox', 'Maintain', 10),
(11, 'default_module', 'export', 'The Default Module ', 'text', 'DEFAULT MODULE', 9),
(12, 'timeout', '10', 'timeout ', 'number', 'TIME OUT', 12);


INSERT INTO `module` (`id`, `key`, `value`, `active_sub`) VALUES
(1, 'config', 'CẤU HÌNH', 1),
(2, 'user', 'NHÂN VIÊN', 2),
(3, 'import', 'NHẬP HÀNG', 3),
(4, 'export', 'XUẤT HÀNG', 4),
(5, 'customer', 'KHÁCH HÀNG', 2),
(6, 'provider', 'NHÀ CUNG CẤP', 2),
(7, 'fund', 'QUỸ', 3),
(8, 'spend', 'CHI PHÍ', 4),
(9, 'report', 'BÁO CÁO', 1),
(10, 'new', 'TIN TỨC', 2);


INSERT INTO `user_module` (`user_id`, `module_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(1, 7),
(1, 8),
(1, 9),
(1, 10),
(2, 1),
(2, 2),
(2, 3),
(2, 4),
(2, 5),
(2, 5),
(2, 6);

INSERT INTO `sub_module` (`id`, `key`, `value`) VALUES 
(1, 'search', 'TÌM KIẾM'),
(2, 'update', 'SỬA'),
(3, 'insert', 'THÊM'),
(4, 'return', 'TRẢ HÀNG');

INSERT INTO `module_sub_module` (`module_id`, `sub_module_id`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(2, 1),
(2, 2),
(2, 3),
(3, 1),
(3, 4),
(3, 3),
(4, 1),
(4, 4),
(5, 1),
(5, 2),
(5, 3)
;
commit;