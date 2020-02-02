<?php

use Phinx\Migration\AbstractMigration;

class MyMigration extends AbstractMigration
{
    public function up()
    {
        $sql = 'create table admins
(
    id      int auto_increment
        primary key,
    login_a varchar(255)         not null,
    pass_a  varchar(255)         not null,
    email_a varchar(255)         not null,
    conf_a  tinyint(1) default 0 null,
    constraint admins_login_a_uindex
        unique (login_a)
);
INSERT 
create table followers
(
    id     int auto_increment
        primary key,
    name   varchar(255) not null,
    login  varchar(255) not null,
    pass   varchar(255) not null,
    email  varchar(255) null,
    follow varchar(500) null,
    constraint followers_login_uindex
        unique (login)
);

create table moderators
(
    id      int auto_increment
        primary key,
    login_m varchar(255)         not null,
    email_m varchar(255)         not null,
    conf_m  tinyint(1) default 0 null,
    pass_m  varchar(255)         not null
);

create table news
(
    news_id   int(10) auto_increment
        primary key,
    subj      varchar(255) not null,
    info      text         not null,
    author_id int          not null,
    public_date datetime not null 
)
    collate = utf8mb4_unicode_ci;

create table tags
(
    tag_id   int(10) auto_increment
        primary key,
    tag_name varchar(50) not null,
    constraint tag_name
        unique (tag_name)
)
    collate = utf8mb4_unicode_ci;

create table link_news_tag
(
    news_id int(10) not null,
    tag_id  int(10) not null,
    constraint post_id
        foreign key (news_id) references news (news_id)
            on update cascade on delete cascade,
    constraint tag_id
        foreign key (tag_id) references tags (tag_id)
            on update cascade on delete cascade
)
    collate = utf8mb4_unicode_ci;

create index news_id
    on link_news_tag (news_id);
    ';

        $this->execute($sql);
    }

    public function down()
    {

    }

    public function change()
    {

    }

}
