INSERT INTO Products (product_name, product_price, 
					product_desc, product_stock)
VALUES
('Apple', 12, 'text about apples', 5),
('Pear', 21, 'text about pears', 8),
('Banana', 14, 'text about bananas', 6),
('Pineapple', 33, 'text about pineapples', 3),
('Kiwi', 25, 'edible.', 10);

insert into shopdb.LoginStaff
(staff_name, staff_password_sha2_512)
values ('admin', sha2('admin', 512));

