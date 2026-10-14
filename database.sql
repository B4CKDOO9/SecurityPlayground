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

