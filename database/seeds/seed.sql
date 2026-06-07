SET FOREIGN_KEY_CHECKS = 0;

INSERT INTO users (role, name, email, phone, password, avatar, status, email_verified_at, email_verification_token, last_login_at, created_at, updated_at) VALUES
('admin', 'Admin User', 'admin@example.com', '+8801000000000', '$2y$12$iDTQKatdWuDST9WFlcBkg.sZeBsLO.m293f/iva4Lg6TVqnO0ZYDK', NULL, 'active', NOW(), NULL, NULL, NOW(), NOW()),
('vendor', 'Vendor User', 'vendor@example.com', '+8801000000001', '$2y$12$iDTQKatdWuDST9WFlcBkg.sZeBsLO.m293f/iva4Lg6TVqnO0ZYDK', NULL, 'active', NOW(), NULL, NULL, NOW(), NOW()),
('customer', 'Customer User', 'customer@example.com', '+8801000000002', '$2y$12$iDTQKatdWuDST9WFlcBkg.sZeBsLO.m293f/iva4Lg6TVqnO0ZYDK', NULL, 'active', NOW(), NULL, NULL, NOW(), NOW());

INSERT INTO categories (parent_id, name, slug, description, image, status, sort_order, created_at, updated_at) VALUES
(NULL, 'Electronics', 'electronics', 'Devices, accessories, and gadgets.', NULL, 'active', 1, NOW(), NOW()),
(NULL, 'Fashion', 'fashion', 'Apparel and lifestyle products.', NULL, 'active', 2, NOW(), NOW()),
(NULL, 'Home & Kitchen', 'home-kitchen', 'Daily essentials for home and kitchen.', NULL, 'active', 3, NOW(), NOW());

INSERT INTO pages (slug, title, content, meta_title, meta_description, status, created_at, updated_at) VALUES
('about', 'About Us', 'About page content goes here.', 'About Us', 'Learn more about our company.', 'published', NOW(), NOW()),
('contact', 'Contact Us', 'Contact page content goes here.', 'Contact Us', 'Get in touch with us.', 'published', NOW(), NOW()),
('faq', 'FAQ', 'Frequently asked questions content goes here.', 'FAQ', 'Common customer questions.', 'published', NOW(), NOW()),
('privacy-policy', 'Privacy Policy', 'Privacy policy content goes here.', 'Privacy Policy', 'How we handle your data.', 'published', NOW(), NOW()),
('terms-conditions', 'Terms & Conditions', 'Terms and conditions content goes here.', 'Terms & Conditions', 'Terms for using our service.', 'published', NOW(), NOW());

INSERT INTO settings (setting_key, setting_value, created_at, updated_at) VALUES
('currency_code', 'INR', NOW(), NOW()),
('currency_symbol', '₹', NOW(), NOW())
ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value), updated_at = VALUES(updated_at);

INSERT INTO products (vendor_id, category_id, brand_id, name, slug, sku, barcode, thumbnail, short_description, description, tags, price, sale_price, cost_price, stock_quantity, stock_status, product_type, weight, length, width, height, is_featured, is_flash_sale, is_best_seller, status, published_at, created_at, updated_at) VALUES
(2, 1, NULL, 'Smartphone Pro X', 'smartphone-pro-x', 'SPX-001', '1234567890001', NULL, 'Flagship smartphone with premium performance.', 'Detailed description for Smartphone Pro X.', 'phone,smartphone,android', 699.00, 649.00, 500.00, 100, 'in_stock', 'physical', 0.200, 15.000, 7.500, 0.800, 1, 0, 1, 'active', NOW(), NOW(), NOW()),
(2, 1, NULL, 'Wireless Headphones', 'wireless-headphones', 'WH-002', '1234567890002', NULL, 'Noise cancelling wireless headphones.', 'Detailed description for Wireless Headphones.', 'audio,headphones,wireless', 149.00, 129.00, 90.00, 150, 'in_stock', 'physical', 0.300, 18.000, 17.000, 6.000, 1, 1, 1, 'active', NOW(), NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;