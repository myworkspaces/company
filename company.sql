drop table if exists tbl_goods_category;

/*==============================================================*/
/* Table: tbl_product_category   ��Ʒ����                                 */
/*==============================================================*/
create table tbl_product_category
(
   id                   integer not null auto_increment,
   name                 varchar(20) not null,
   type                 tinyint(1) not null comment 'һ������=1����������=2����������=3',
   parent_id            integer not null comment 'һ�������ϼ�����=0',
   is_show              tinyint(1) not null default 0 comment '�Ƿ���ʾ�÷��࣬0=��ʾ��1=���أ�Ĭ��0',
   order_num            integer not null comment '���������Ĭ��=1',
   create_time          datetime not null,
   update_time          datetime not null,
   primary key (id)
)
type = InnoDB;

drop table if exists tbl_product;

/*==============================================================*/
/* Table: tbl_products   ��Ʒ��                                          */
/*==============================================================*/
create table tbl_product
(
   id                   integer not null,
   name                 varchar(50) not null,
   brand                varchar(50) not null,
   pic                  varchar(200) not null,
   onshow               tinyint(1) not null default 0 comment '0=�ϼܣ�1=�¼ܣ�Ĭ��0',
   summary              varchar(200) not null comment '��Ʒ��Ҫ',
   description          text not null comment '��Ʒ����',
   category_first       integer not null comment 'һ������',
   category_second      integer not null comment '��������',
   category_third       integer not null comment '��������',
   create_time          datetime not null,
   update_time          datetime not null,
   primary key (id)
);

drop table if exists tbl_company;

/*==============================================================*/
/* Table: tbl_company   ��˾��Ϣ                                        */
/*==============================================================*/
create table tbl_company
(
   id                   int not null auto_increment,
   description          text not null comment '������Ϣ',
   tel                  varchar(20) not null comment '�绰',
   contact              varchar(20) not null comment '��ϵ��',
   address              varchar(100) not null comment '��ַ',
   create_time          datetime not null,
   primary key (id)
);


