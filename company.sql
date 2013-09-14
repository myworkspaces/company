drop table if exists tbl_goods_category;

/*==============================================================*/
/* Table: tbl_product_category   产品分类                                 */
/*==============================================================*/
create table tbl_product_category
(
   id                   integer not null auto_increment,
   name                 varchar(20) not null,
   type                 tinyint(1) not null comment '一级分类=1，二级分类=2，三级分类=3',
   parent_id            integer not null comment '一级分类上级分类=0',
   is_show              tinyint(1) not null default 0 comment '是否显示该分类，0=显示，1=隐藏，默认0',
   order_num            integer not null comment '分类的排序，默认=1',
   create_time          datetime not null,
   update_time          datetime not null,
   primary key (id)
)
type = InnoDB;

drop table if exists tbl_product;

/*==============================================================*/
/* Table: tbl_products   产品表                                          */
/*==============================================================*/
create table tbl_product
(
   id                   integer not null,
   name                 varchar(50) not null,
   brand                varchar(50) not null,
   pic                  varchar(200) not null,
   onshow               tinyint(1) not null default 0 comment '0=上架，1=下架，默认0',
   summary              varchar(200) not null comment '产品概要',
   description          text not null comment '产品详情',
   category_first       integer not null comment '一级分类',
   category_second      integer not null comment '二级分类',
   category_third       integer not null comment '三级分类',
   create_time          datetime not null,
   update_time          datetime not null,
   primary key (id)
);

drop table if exists tbl_company;

/*==============================================================*/
/* Table: tbl_company   公司信息                                        */
/*==============================================================*/
create table tbl_company
(
   id                   int not null auto_increment,
   description          text not null comment '介绍信息',
   tel                  varchar(20) not null comment '电话',
   contact              varchar(20) not null comment '联系人',
   address              varchar(100) not null comment '地址',
   create_time          datetime not null,
   primary key (id)
);


