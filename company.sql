drop table if exists tbl_goods_category;

/*==============================================================*/
/* Table: tbl_product_category   ��Ʒ����                                 */
/*==============================================================*/
create table tbl_product_category
(
   id                   integer not null auto_increment,
   name                 varchar(20) not null,
   type                 tinyint(1) not null comment 'һ������=1����������=2����������=3',
   parent_id            integer not null default 0 comment 'һ�������ϼ�����=0,Ĭ��=0',
   is_show              tinyint(1) not null default 0 comment '�Ƿ���ʾ�÷��࣬1=��ʾ��0=���أ�Ĭ��1',
   order_num            integer not null comment '���������Ĭ��=1',
   create_time          datetime not null,
   update_time          datetime not null,
   primary key (id)
)

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
   is_show              tinyint(1) not null default 0 comment '1=�ϼܣ�0=�¼ܣ�Ĭ��1',
   summary              varchar(200) comment '��Ʒ��Ҫ',
   description          text not null comment '��Ʒ����',
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
   update_time          datetime not null,
   primary key (id)
); 

drop table if exists tbl_product_category_relation;

/*==============================================================*/
/* Table: tbl_product_category_relation   ��Ʒ���������                      */
/*==============================================================*/
create table tbl_product_category_relation
(
   id                   integer not null,
   category_id          integer not null comment '����id',
   product_id           integer not null comment '��Ʒid',
   create_time          datetime not null comment '����ʱ��',
   update_time          datetime not null comment '�޸�ʱ��',
   primary key (id)
);


