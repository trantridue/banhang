-- User

-- Config
truncate table `config`;
truncate `user_module`;
truncate `module`;

INSERT INTO `config` VALUES (1, 'nbr_row_import', '10', 'Số dòng nhập hàng ', 'number','Số dòng nhập hàng mặc định',1);
INSERT INTO `config` VALUES (2, 'nbr_row_export', '10', 'Số dòng xuất hàng ', 'number','Số dòng xuất hàng mặc định',2);
INSERT INTO `config` VALUES (3, 'nbr_row_return', '10', 'Số dòng trả hàng ', 'number','Số dòng trả hàng mặc định',3);
INSERT INTO `config` VALUES (4, 'on_off_sale', '0', 'Khuyến mại ', 'button','Bật tắt chế độ sale',5);
INSERT INTO `config` VALUES (5, 'sale_percent', '0', 'Phần trăm khuyến mại', 'number','Phần trăm sale',6);
INSERT INTO `config` VALUES (6, 'welcome_msg', 'Kính chào quý khách', 'Thông điệp ', 'text','Thông điệp chào mừng khách',4);
INSERT INTO `config` VALUES (7, 'start_date', date_format(now(),'%Y-%m-%d'), 'Ngày mở hàng', 'date','Ngày khai trương shop',7);
INSERT INTO `config` VALUES (8, 'end_date', now(), 'Ngày đóng hàng', 'datetime','Ngày đóng shop',8);
INSERT INTO `config` VALUES (9, 'policy', 'Chính sách cửa hàng', 'Zabuza shop policy ', 'textarea','Chính sách của cửa hàng',11);
INSERT INTO `config` VALUES (10, 'is_maintain_mode', '1', 'Maintain mode ', 'checkbox','Maintain',10);
INSERT INTO `config` VALUES (11, 'default_module', 'config', 'The Default Module ', 'text','DEFAULT MODULE',9);



INSERT INTO `module` VALUES (1, 'config', 'CẤU HÌNH');
INSERT INTO `module` VALUES (2, 'user', 'NHÂN VIÊN');
INSERT INTO `module` VALUES (3, 'import', 'NHẬP HÀNG');
INSERT INTO `module` VALUES (4, 'export', 'XUẤT HÀNG');


INSERT INTO `user_module` VALUES (1, 1, 1);
INSERT INTO `user_module` VALUES (2, 1, 2);
INSERT INTO `user_module` VALUES (3, 1, 3);
INSERT INTO `user_module` VALUES (4, 1, 4);
INSERT INTO `user_module` VALUES (5, 2, 4);