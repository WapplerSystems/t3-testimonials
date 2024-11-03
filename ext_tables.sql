CREATE TABLE tt_content
(
    tx_wstestimonials_items   int(11)    DEFAULT '0' NOT NULL,
    tx_wstestimonials_columns tinyint(4) DEFAULT '1' NOT NULL
);

CREATE TABLE tx_wstestimonials_domain_model_item
(

    content_uid  int(11) unsigned    DEFAULT '0' NOT NULL,

    author_image int(11) unsigned    DEFAULT '0',
    title        text,
    content      text,
    stars        tinyint(4) unsigned DEFAULT '0'

);
