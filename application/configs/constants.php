<?php
define('PAGE_LIST_COUNT', 15);
define('PER_PAGE', 10);
define('PAGE_RANGE', 10);
define('PLEASE_SELECT', 'Please select item');
/**
 * english language
 * 
 * 0: disable
 * 1: enable
 */
define('ENGLISH', 1);
define('VIETNAM', 1);

/**
 * format date of mysql
 *
 */
define ( 'DATETIME_FORMAT_DB', 'Y-m-d H:s:i' );

/**
 * format view html
 *
 */
define ( 'DATETIME_FORMAT_DISPLAY', 'd-m-Y H:s:i A' );

/**
 * message when update, add, delete info
 */
/* define ( 'MESS_ADD', 'Thêm thông tin thành công!' );
define ( 'MESS_UPDATE', 'Cập nhật thông tin thành công!' );
define ( 'MESS_DELETE', 'Thông tin đã được xoá!' ); */

define ( 'MESS_ADD', 'Thêm thông tin thành công!' );
define ( 'MESS_UPDATE', 'Cập nhật thông tin thành công!' );
define ( 'MESS_DELETE', 'Xóa thông tin thành công!' );
//define ( 'MESS_SEND', 'Send Success!' );

/**
 * upload image product
 */
/* define ( 'UPLOAD_PRODUCT_PATH', '/uploads/products' );
define ( 'UPLOAD_PRODUCT_EXTENSION', 'jpg, png, gif' );
define ( 'UPLOAD_PRODUCT_SIZE', 10240000 );
define('PRODUCT_WIDTH_SMALL', 168);
define('PRODUCT_WIDTH_THUMBS', 75); */

define ( 'UPLOAD_ARTICLE_PATH', '/uploads/articles' );
define ( 'UPLOAD_ARTICLE_EXTENSION', 'jpg, png, gif' );
define ( 'UPLOAD_ARTICLE_SIZE', 10240000 );
define('ARTICLE_WIDTH_SMALL', 198);
define('ARTICLE_HEIGHT_SMALL', 144);
define('ARTICLE_WIDTH_THUMBS', 75);
define('ARTICLE_HEIGHT_THUMBS', 75);

define('DATA_UPDATING', 'Dữ liệu đang cập nhật...');

define('PRODUCT_WIDTH_SMALL', 198);
define('PRODUCT_HEIGHT_SMALL', 144);
define('PRODUCT_WIDTH_THUMBS', 75);
define('PRODUCT_HEIGHT_THUMBS', 75);