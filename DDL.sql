create table images(
    id bigint auto_increment primary key,
    name varchar(256) not null comment '画像ファイルの名前',
    path varchar(1024) not null comment '画像保存している場所',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

