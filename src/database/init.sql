DROP DATABASE IF EXISTS task_force;

CREATE DATABASE IF NOT EXISTS task_force;

CREATE TABLE task_force.categories(
    id int auto_increment,
    name varchar(255) not null,
    icon varchar(1000) not null,
    PRIMARY KEY (id)
);

CREATE TABLE task_force.cities(
    id int auto_increment,
    name varchar(255) not null,
    lat double not null,
    lng double not null,
    PRIMARY KEY (id)
);

CREATE TABLE task_force.users(
    id int auto_increment,
    name varchar(255) not null,
    email varchar(255) not null,
    password varchar(255) not null,
    birthday date not null,
    avatar varchar(1000),
    phone varchar(255),
    telegram varchar(255),
    role varchar(255),
    registration_date DATETIME not null,
    about text,
    status tinyint,
    city_id int not null,
    FOREIGN KEY (city_id) REFERENCES task_force.cities (id),
    PRIMARY KEY (id)
);

CREATE TABLE task_force.tasks(
    id int PRIMARY KEY auto_increment,
    client_id int not null,
    city_id int,
    performer_id int,
    title varchar(255) not null,
    created_at DATETIME not null,
    lat double,
    lng double,
    price double,
    win_response_id int,
    end_date datetime,
    category_id int not null,
    FOREIGN KEY (performer_id) REFERENCES task_force.users (id),
    FOREIGN KEY (client_id) REFERENCES task_force.users (id),
    FOREIGN KEY (city_id) REFERENCES task_force.cities (id),
    FOREIGN KEY (category_id) REFERENCES task_force.categories (id)
);

CREATE TABLE task_force.reviews(
    id int PRIMARY KEY auto_increment,
    user_id int not null,
    task_id int not null,
    rating tinyint default 0,
    FOREIGN KEY (user_id) REFERENCES task_force.users (id) ON DELETE CASCADE,
    FOREIGN KEY (task_id) REFERENCES task_force.tasks (id) ON DELETE CASCADE
);

CREATE TABLE task_force.responses (
    id int auto_increment,
    user_id int not null,
    task_id int not null,
    price double not null,
    created_at datetime,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES task_force.users (id) ON DELETE CASCADE,
    FOREIGN KEY (task_id) REFERENCES task_force.tasks (id) ON DELETE CASCADE
);

ALTER TABLE task_force.tasks ADD FOREIGN KEY (win_response_id) REFERENCES task_force.responses (id);

CREATE TABLE task_force.task_files (
    id int auto_increment,
    task_id int not null,
    name varchar(255),
    path varchar(1000),
    PRIMARY KEY (id),
    FOREIGN KEY (task_id) REFERENCES task_force.tasks (id) ON DELETE CASCADE
);
