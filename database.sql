CREATE DATABASE playground;

CREATE TABLE Users (
    id UUID NOT NULL DEFAULT UUID() PRIMARY KEY,
    username  VARCHAR(400) NOT NULL UNIQUE,
    password VARCHAR(400) NOT NULL,
    email VARCHAR(400) NOT NULL,
    department ENUM('Engineering','IT','Help Desk','HR','PR') NOT NULL,
    role_user ENUM('Software Engineer','Security Architect','Help Desk manager','Employment manager','Campaign manager','Administrator') NOT NULL,
    date_created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO Users (username, password, email, department, role_user) VALUES
('jdoe', '$2y$10$4Oz09JspEnapL9GQJDnYremYCxmrakw3Hkz6KhyNgMhW4itT3kqW6', 'jdoe@playground.local', 'IT', 'Software Engineer'),
('msmith', '$2y$10$uKJwIl6R3zn9iNtMYONHG.9U2Pa5igCCHKoSMOZsB30UFPsQdsfTe', 'msmith@playground.local', 'Engineering', 'Software Engineer'),
('Admin', '$2y$10$pWToU3pYb/lu9IQTsJwAAOh8NocYhhY674xX5d4WZ.E8Z.Ck2CKqW', 'admin@playground.local', 'IT', 'Administrator'),
('kjansen', '$2y$10$xVSph39vuEDw1qwaHzqgfeJCxZwI1by0a5OKRuIBJZYoVEPSruFBy', 'kjansen@playground.local', 'Help Desk', 'Help Desk manager'),
('lverhoeven', '$2y$10$SbbcDlnV7rmz6wo.hlPO6.3RxUFHIJBDD/wQS0t1j5QHORqwV5DBy', 'lverhoeven@playground.local', 'HR', 'Employment manager'),
('tbakker', '$2y$10$0NZ4848in26VgKLECIcf.OBVydepprhMnVp7683yNZMRWUE2yasXm', 'tbakker@playground.local', 'PR', 'Campaign manager'),
('rvdberg', '$2y$10$bqHj138lPNaT9I1fPLuW8OjTLarVmugBjMaGy7WwKkuEyuefRoOuS', 'rvdberg@playground.local', 'Engineering', 'Software Engineer'),
('svisser', '$2y$10$Yk7Is6q6uyofqAEmzvI8pONZJJ8QCVpiFm5JEzIPphwrW.jRoH/KG', 'svisser@playground.local', 'IT', 'Security Architect'),
('pdejong', '$2y$10$ee.8R4y4CPYSOI.8NUf7/OqNJl.81mqRY3G08WfRT4xut5.Sh9Svu', 'pdejong@playground.local', 'HR', 'Employment manager'),
('ndekker', '$2y$10$E6xTZLvVXanodvnSKarESurJgEvEoTK9vSRIhqUdzEhnb6mK49z0W', 'ndekker@playground.local', 'PR', 'Campaign manager');