DROP DATABASE IF EXISTS taskforce;

CREATE DATABASE taskforce
    DEFAULT CHARACTER SET utf8
    DEFAULT COLLATE utf8_general_ci;

USE taskforce;

CREATE TABLE cities
(
    id      int PRIMARY KEY AUTO_INCREMENT,
    city    varchar(64) NOT NULL,
    lt      float,
    lg      float
);

CREATE TABLE users
(
    id             int PRIMARY KEY AUTO_INCREMENT,

    email          varchar(64)  NOT NULL,
    name           varchar(128) NOT NULL,
    password       varchar(128) NOT NULL,
    dt_add         datetime,
    city           int          NOT NULL,

    full_address   varchar(256),
    birthday       date,
    about          text,
    avatar_src     varchar(128),
    phone          varchar(20),
    skype          varchar(128),
    over_messenger varchar(128),
    rating         int,
    role           int(1),

    FOREIGN KEY (city) REFERENCES cities (id)
);

CREATE TABLE profiles
(
  id             int PRIMARY KEY AUTO_INCREMENT,

  address        varchar(256),
  bd             date,
  about          text,
  phone          varchar(20),
  skype          varchar(128),
  user_id        int          NOT NULL,

  FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE categories
(
    id    int PRIMARY KEY AUTO_INCREMENT,
    name varchar(64) NOT NULL,
    icon varchar(64)
);

CREATE TABLE users_specialty
(
    id           int PRIMARY KEY AUTO_INCREMENT,
    user_id      int NOT NULL,
    category_id int NOT NULL,

    FOREIGN KEY (user_id) REFERENCES users (id),
    FOREIGN KEY (category_id) REFERENCES categories (id)
);

CREATE TABLE portfolio
(
    id      int PRIMARY KEY AUTO_INCREMENT,
    user_id int          NOT NULL,
    img_src varchar(256) NOT NULL,

    FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE user_settings
(
    id                        int PRIMARY KEY AUTO_INCREMENT,
    user_id                   int UNIQUE NOT NULL,
    is_message_ntf_enabled    bool       NOT NULL,
    is_action_ntf_enabled     bool       NOT NULL,
    is_new_review_ntf_enabled bool       NOT NULL,
    is_hidden                 bool       NOT NULL,
    is_active                 bool       NOT NULL,

    FOREIGN KEY (user_id) REFERENCES users (id)
);

CREATE TABLE tasks
(
    id              int PRIMARY KEY AUTO_INCREMENT,

    dt_add          datetime,
    category_id     int         NOT NULL,
    description     text,
    expire          datetime,
    name            varchar(64) NOT NULL,
    address         varchar(256),
    budget          int,
    lt              float,
    lg              float,

    customer_id     int         NOT NULL,
    executor_id     int,

    state           varchar(10),
    attachment_src  varchar(256),
    address_comment varchar(256),
    updated_at      datetime,

    FOREIGN KEY (customer_id) REFERENCES users (id),
    FOREIGN KEY (executor_id) REFERENCES users (id),
    FOREIGN KEY (category_id) REFERENCES categories (id)
);

CREATE TABLE task_attachments
(
    id        int PRIMARY KEY AUTO_INCREMENT,
    task_id   int          NOT NULL,
    file_type varchar(32)  NOT NULL,
    file_name varchar(64)  NOT NULL,
    file_src  varchar(256) NOT NULL,

    FOREIGN KEY (task_id) REFERENCES tasks (id)
);

CREATE TABLE messages
(
    id           int PRIMARY KEY AUTO_INCREMENT,
    sender_id    int  NOT NULL,
    addressee_id int  NOT NULL,
    content      text NOT NULL,
    created_at   datetime,

    FOREIGN KEY (sender_id) REFERENCES users (id),
    FOREIGN KEY (addressee_id) REFERENCES users (id)
);

CREATE TABLE opinions
(
    id           int PRIMARY KEY AUTO_INCREMENT,
    dt_add       datetime,
    rate         int        NOT NULL,
    description  text,
    sender_id    int        NOT NULL,
    receiver_id  int        NOT NULL,
    task_id      int UNIQUE NOT NULL,

    FOREIGN KEY (sender_id) REFERENCES users (id),
    FOREIGN KEY (receiver_id) REFERENCES users (id),
    FOREIGN KEY (task_id) REFERENCES tasks (id)
);

CREATE TABLE replies
(
    id           int PRIMARY KEY AUTO_INCREMENT,
    dt_add       datetime,
    rate         int        NOT NULL,
    description  text,
    sender_id    int        NOT NULL,
    receiver_id  int        NOT NULL,
    task_id      int UNIQUE NOT NULL,

    FOREIGN KEY (sender_id) REFERENCES users (id),
    FOREIGN KEY (receiver_id) REFERENCES users (id),
    FOREIGN KEY (task_id) REFERENCES tasks (id)
);
