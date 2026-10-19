/*
  All passwords are 123 (md5).
  nu_admin2026 -> Admin (Lost & Found Staff) Full Access
  nu_staff2026 -> Staff (Utility / Guard) Limited access lang
*/

USE NUFinds;

INSERT INTO User_Credentials (username, fname, lname, password, role) VALUES 
('nu_admin2026', 'John',   'Doe',  '202cb962ac59075b964b07152d234b70', 'Admin'),
('nu_staff2026', 'Jane',   'Doe',  '202cb962ac59075b964b07152d234b70', 'Staff');

INSERT INTO found_items (found_id, item_name, category, description, location_found, date_found, status) VALUES
(1, 'Black Umbrella',          'Accessories',    'Black folding umbrella with a wooden handle.',         'LRC 2F',          '2026-10-01', 'Unclaimed'),
(2, 'Blue Water Bottle',       'Personal Items', 'Blue insulated tumbler with a dent near the cap.',     'Cafeteria',       '2026-09-30', 'Unclaimed'),
(3, 'Scientific Calculator',   'Electronics',    'Casio fx-991 with initials on the back.',              'HSSH 301',        '2026-09-28', 'Claimed'),
(4, 'Student ID Card',         'IDs & Cards',    'Student ID card in a clear plastic sleeve.',           'LRC 2F',          '2026-09-27', 'Claimed'),
(5, 'Black Wireless Earbuds',  'Electronics',    'Black charging case, no brand visible.',               'Cafeteria',       '2026-10-05', 'Unclaimed'),
(6, 'Brown Canvas Backpack',   'Bags',           'Brown canvas backpack with a keychain on the zipper.', 'Auditorium',      '2026-10-06', 'Unclaimed'),
(7, 'Prescription Eyeglasses', 'Accessories',    'Black rectangular frames in a gray case.',             'Auditorium',      '2026-09-29', 'Claimed'),
(8, 'USB Flash Drive',         'Electronics',    '32 GB flash drive with a red cap.',                    'Computer Lab 3',  '2026-10-07', 'Unclaimed');

INSERT INTO claim_item (found_id, student_id, student_name, email, claim_date) VALUES
(3, '2024-011230', 'Carlo Dizon',   'cdizon@students.nu-laguna.edu.ph',  '2026-09-29'),
(4, '2022-014520', 'Miguel Santos', 'msantos@students.nu-laguna.edu.ph', '2026-09-28'),
(7, '2023-006291', 'Paolo Reyes',   'preyes@students.nu-laguna.edu.ph',  '2026-09-30');

INSERT INTO lost_items (item_name, category, description, location_lost, date_lost, student_id, student_name, email, date_reported, status) VALUES
('Silver Laptop',         'Electronics',    'Silver 14-inch laptop with a sticker on the lid.', 'HSSH 204',      '2026-10-09',  '2024-018472',  'Julia Mendoza',    'jmendoza@students.nu-laguna.edu.ph',    '2026-10-09', 'Open'),
('Yellow School Lanyard', 'IDs & Cards',    'Yellow lanyard with an ID holder attached.',       'SHS Building',  '2026-10-09',  '2023-006291',  'Paolo Reyes',      'preyes@students.nu-laguna.edu.ph',      '2026-10-09', 'Open'),
('White Pencil Case',     'Personal Items', 'White zipper pencil case with a cat print.',       'LRC 2nd Floor', '2026-10-08',  '2025-001183',  'Anne Villanueva',  'avillanueva@students.nu-laguna.edu.ph', '2026-10-08', 'Open'),
('Car Keys with Blue Tag','Accessories',    'Two keys and a blue tag on a metal ring.',         'Sampaloc Lane', '2026-10-08',  '2024-014520',  'Miguel Santos',    'msantos@students.nu-laguna.edu.ph',     '2026-10-08', 'Open');
