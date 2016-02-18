<?php


/******************* Server *****************/
/**
* @const server home path.
*/
define('SERVER_HOME', '/home/ubuntu');




/******************* Amazon S3 *****************/
/**
* @const S3 region.
*/
define('AWS_S3_REGION', 'us-east-1');
/**
* @const S3 profile.
*/
define('AWS_S3_PROFILE', 'default');
/**
* @const S3 user content bucket name.
*/
define('USER_CONTENT_BUCKET_NAME', 'com.photomyne.usercontent'); 
/**
* @const S3 user content bucket http address
*/
define('AWS_S3_URL', 'https://s3.amazonaws.com'); 
/**
* @const S3 ACL Public-Read permission name.
*/
define('S3_ACL_PUBLIC_READ', 'public-read'); 
/**
 * @const S3 presigned urls time to live.
 */
define('S3_PRESIGNED_URL_TTL', '+180 minutes');




/******************* DynamoDB *****************/
/**
* @const DynamoDB region.
*/
define('DB_REGION', 'us-east-1');
/**
* @const DynamoDB version.
*/
define('DB_VERSION','latest');
/**
* @const DynamoDB profile.
*/
define('DB_PROFILE', 'default');
/**
* @const DynamoDB photomyne users table name.
*/
define('DB_USERS_TABLE','PhotomyneUsers');
/**
* @const DynamoDB photomyne albums table name.
*/
define('DB_ALBUMS_TABLE','PhotomyneAlbums');
/**
* @const DynamoDB photomyne extracted photos table name.
*/
define('DB_EXTRACTED_PHOTOS_TABLE','PhotomyneExtractedPhotos');
/**
* @const DynamoDB photomyne users table FbID index name.
*/
define('DB_USERS_FB_BUSINESS_TOKEN_INDEX','FBBusinessToken-index');
/**
* @const DynamoDB photomyne users table email index name.
*/
define('DB_USERS_USER_MAIL_INDEX','UserMail-index');
/**
* @const DynamoDB photomyne extracted photos table album ID index name.
*/
define('DB_EXTRACTED_PHOTOS_USERID_ALBUMID_INDEX', 'UserId-AlbumId-index');




/******************* Session variables *****************/
/**
 * @const credentials login status.
 */
define('CREDENTIALS_LOGIN', 'Clogin'); // Session only
/**
 * @const Facebook access token.
*/
define('FB_ACCESS_TOKEN', 'fb_access_token'); // Session only
/**
 * @const user Facebook ID.
 */
define('MEMBER_FB_ID', 'FBId'); // Session var
/**
 * @const user Facebook email.
 */
define('MEMBER_FB_EMAIL', 'FBemail'); // Session var


/******************* Database table attributes names *****************/
/* 
* NOTE - We will also assign the same DB attributes names to 
* required session variables holding their values
*/
/**
* @const user ID.
*/
define('MEMBER_USER_ID', 'UserId'); // DB attribute & Session var
/**
* @const user password.
*/
define('MEMBER_PASSWORD', 'Password'); // DB attribute & Session var
/**
* @const user Facebook name.
*/
define('MEMBER_FB_NAME', 'FBName'); // DB attribute & Session var
/**
* @const user Facebook ID.
*/
define('MEMBER_FB_BUSINESS_TOKEN', 'FBBusinessToken'); // DB attribute 
/**
* @const premium member.
*/
define('MEMBER_IS_PREMIUM_USER', 'BackupPlan'); // DB attribute & Session var
/**
* @const user email.
*/
define('MEMBER_USER_EMAIL', 'UserMail'); // DB attribute & Session var
/**
* @const user first name.
*/
define('MEMBER_FIRST_NAME', 'FirstName'); // DB attribute & Session var
/**
* @const user sur name.
*/
define('MEMBER_LAST_NAME', 'LastName'); // DB attribute & Session var
/**
* @const album ID.
*/
define('MEMBER_ALBUM_ID', 'AlbumId'); // DB attribute & Session var
/**
* @const album title.
*/
define('MEMBER_ALBUM_TITLE', 'Title'); // DB attribute only
/**
* @const album year.
*/
define('MEMBER_ALBUM_YEAR', 'Year'); // DB attribute only
/**
 * @const album year.
 */
define('MEMBER_ALBUM_PLACE', 'PlaceName'); // DB attribute only
/**
* @const extracted photo Id.
*/
define('MEMBER_EXTRACTED_PHOTO_ID', 'ExtractedPhotoId'); // DB attribute only
/**
* @const extracted photo year.
*/
define('MEMBER_EXTRACTED_PHOTO_YEAR', 'Year'); // DB attribute only
/**
* @const extracted photo title.
*/
define('MEMBER_EXTRACTED_PHOTO_TITLE', 'Title'); // DB attribute only
/**
* @const album extracted photos.
*/
define('MEMBER_ALBUM_EXTRACTED_PHOTOS', 'AlbumExtractedPhotos'); // DB attribute only
/**
 * @const premium user backupPlan.
 */
define('PREMIUM_TIER_MEMBER', 'PREMIUM_TIER'); // DB attribute only




/******************* additional data attributes *****************/
/**
 * @const extracted shot url.
 */
define('PHOTO_URL', 'img_url');
/**
 * @const extracted shot thumbnail url.
*/
define('PHOTO_THUMB_URL', 'img_thumb_url');




/******************* Facebook App login *****************/
/**
* @const Facebook app ID.
*/
define('FB_APP_ID', '1507583979547821');
/**
* @const Facebook app secret.
*/
define('FB_APP_SECRET', 'dbd72bae7d99a5cb44f787f0d71c7118');
/**
* @const Facebook graph version.
*/
define('FB_DEFAULT_GRAPH_VER', 'v2.5');


/******************* User msessage strings *****************/
/**
 * @const generic system error message.
 */
define('GENERIC_SYSTEM_ERR_MSG', 'Server hiccup... Try again');
/**
 * @const message for Facebook member trying to login with credentials .
 */
define('SEND_TO_LOGIN_WITH_FACEBOOK_MSG', 'Please login with your facebook account');
/**
 * @const message for wrong credentials login attempt .
 */
define('WRONG_CREDENTIALS_LOGIN_ATTMEPT_MSG', "The email and password don't match. Try again");




/******************* Photomyne website *****************/
/**
* @const base url for photomyne website.
*/
define('PUBLIC_BASE_URL', 'http://www.photomyne.com/');
/**
* @const public login url.
*/
define('PUBLIC_LOGIN_URL', PUBLIC_BASE_URL . 'login.php');
/**
* @const members only base url for logged in users.
*/
define('MEMBERS_BASE_URL', PUBLIC_BASE_URL . 'my-albums.php');
/**
 * @const members only base url for logged in users.
 */
define('PUBLIC_GET_PREMIUM_URL', PUBLIC_BASE_URL . 'get-premium.php');
/**
 * @const members only base url for logged in users.
 */
define('PUBLIC_GET_APP_URL', PUBLIC_BASE_URL . 'get-the-app.php');
/**
 * @const 404 page.
 */
define('PUBLIC_404_URL', PUBLIC_BASE_URL . '404.php');
/**
 * @const system error page.
 */
define('PUBLIC_SYSTEM_ERROR_URL', PUBLIC_BASE_URL . 'server-hiccup.php');
/**
* @const Facebook login callback url.
*/
define('FACEBOOK_CALLBACK_URL', PUBLIC_BASE_URL . 'facebook_callback.php');
/**
* @const Log out url.
*/
define('LOGOUT_URL', PUBLIC_BASE_URL . 'logout.php');
/**
 * @const contact support email address.
 */
define('CONTACT_SUPPORT_MAILTO_ADDRESS', 'support@photomyne.com');
/**
 * @const mail 'From' name.
 */
define('CONTACT_SUPPORT_MAILTO_HEADER', 'From: webApp@photomyne.com');
