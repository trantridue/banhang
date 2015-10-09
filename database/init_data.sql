-- User

-- Config
truncate table `config`;

INSERT INTO `config` VALUES (1, 'nbr_row_import', '10', 'Số dòng nhập hàng ', 'number');
INSERT INTO `config` VALUES (2, 'nbr_row_export', '10', 'Số dòng xuất hàng ', 'number');
INSERT INTO `config` VALUES (3, 'nbr_row_return', '10', 'Số dòng trả hàng ', 'number');
INSERT INTO `config` VALUES (4, 'on_off_sale', '0', 'Khuyến mại ', 'button');
INSERT INTO `config` VALUES (5, 'sale_percent', '0', 'Phần trăm khuyến mại', 'number');
INSERT INTO `config` VALUES (6, 'welcome_msg', 'Kính chào quý khách', 'Thông điệp ', 'text');
INSERT INTO `config` VALUES (7, 'start_date', date_format(now(),'%Y-%m-%d'), 'Ngày mở hàng', 'date');
INSERT INTO `config` VALUES (8, 'end_date', now(), 'Ngày đóng hàng', 'datetime');