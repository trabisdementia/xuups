<?php

/**
* $Id: modinfo.php,v 1.41 2006/03/22 14:04:51 malanciault Exp $
* Module: Publisher
* Author: The SmartFactory <www.smartfactory.ca>
* Licence: GNU
* Translated by irxoops.org till 2.13 & updated and edited in 2.13 by stranger <www.impresscms.ir>
*/

// Module Info
// The name of this module

global $xoopsModule;

define("_MI_PUB_ADMENU1", "صفحه اصلی");
define("_MI_PUB_ADMENU2", "شاخه ها");
define("_MI_PUB_ADMENU3", "مقالات");
define("_MI_PUB_ADMENU4", "دسترسی ها");
define("_MI_PUB_ADMENU5", "بلاک ها و گروه ها");
define("_MI_PUB_ADMENU6", "پسوند پرونده ها");
define("_MI_PUB_ADMENU7", "برو به ماژول");

define("_MI_PUB_ADMINHITS", "[گزینه های متن] بازدید های مدیر محاسبه شود؟");
define("_MI_PUB_ADMINHITSDSC", "بازدید های مدیر نیز به عنوان بازدید محسوب گردد؟");
define("_MI_PUB_ALLOWSUBMIT", "[دسترسی ها] کاربران بتوانند مقاله ارسال کنند؟");
define("_MI_PUB_ALLOWSUBMITDSC", "کاربران اجازه داشته باشند تا مقاله به سایت ارسال کنند");
define("_MI_PUB_ANONPOST", "[دسترسی ها] مهمان ها بتوانند مقاله ارسال کنند؟");
define("_MI_PUB_ANONPOSTDSC", "مهمان ها اجازه داشته باشند تا مقاله به سایت ارسال کنند؟");
define("_MI_PUB_AUTHOR_INFO", "توسعه دهندگان");
define("_MI_PUB_AUTHOR_WORD", "سخن سازنده ماژول");
define("_MI_PUB_AUTOAPP", "[دسترسی ها] تایید خودكار مقالات ارسال شده؟:");
define("_MI_PUB_AUTOAPPDSC", "مقاله های ارسال شده بدون تایید مدیر در سایت قرار بگیرند");
define("_MI_PUB_BCRUMB","[گزینه های چاپ] نام ماژول در صفحه سازگار با چاپ نمایش داده شود؟");
define("_MI_PUB_BCRUMBDSC","اگر بله انتخاب شود، در صفحه سازگار با چاپ\"اسمارت سکشن > نام شاخه > نام مقاله\". نوشته می شود <br>در غیر این صورت فقط \"نام شاخه > نام مقاله\" نوشته خواهد شد.");
define("_MI_PUB_BOTH_FOOTERS","هر دو پا صفحه ها");
define("_MI_PUB_BY", "توسط");
define('_MI_PUB_CATEGORY_ITEM_NOTIFY', 'مقالات شاخه ');
define('_MI_PUB_CATEGORY_ITEM_NOTIFY_DSC', 'گزینه های آگاهی رسانی که مرتبط به این شاخه می باشند.');
define('_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY', "قرار گرفتن مقاله جدید");
define('_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_CAP', "وقتی مقاله جدیدی در این شاخه قرار گرفت مرا با خبر كن");
define('_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_DSC', "دریافت گزارش، زمانی که مقاله جدیدی در این شاخه انتشار یافت.");
define('_MI_PUB_CATEGORY_ITEM_PUBLISHED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} آگهی رسانی خود کار : مقاله جدیدی در شاخه قرار گرفت");
define('_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY', "مقاله ارسال شده");
define('_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_CAP', "وقتی مقاله جدیدی در این شاخه ارسال شد مرا با خبر كن");
define('_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_DSC', "دریافت گزارش، زمانی که مقاله جدیدی در این شاخه ارسال شد.");
define('_MI_PUB_CATEGORY_ITEM_SUBMITTED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} آگهی رسانی خود کار : مقاله جدیدی برای این شاخه ارسال شد");
define("_MI_PUB_CATLIST_IMG_W", "[گزینه های فرمت] عرض تصویر  شاخه در فهرست"); 
define("_MI_PUB_CATLIST_IMG_WDSC", "عرض تصاویر شاخه را وقتی شاخه ها در فهرست نمایش داده میشوند مشخص میکند."); 
define("_MI_PUB_CATMAINIMG_W", "[گزینه های فرمت] عرض تصویر شاخه در صفحه اصلی"); 
define("_MI_PUB_CATMAINIMG_WDSC", "عرض تصویر شاخه را وقتی در صفحه اصلی قرار دارد مشخص میکند."); 
define("_MI_PUB_CATPERPAGE", "[گزینه های فرمت] حداکثر تعداد شاخه ها در هر صفحه (سمت کاربر)؟");
define("_MI_PUB_CATPERPAGEDSC", "حداکثر تعدادشاخه های اصلی را که در یک صفحه در سمت کاربر نمایش داده میشود مشخص میکند");
define("_MI_PUB_CLONE", "[دسترسی ها] اجازه برای ساختن نسخه دوم از مقاله؟");
define("_MI_PUB_CLONEDSC", "'بله' را انتخاب کنید تا به کاربران اجازه دهید بتوانند  از مقاله ها نسخه دوم تهیه کنند.");
define("_MI_PUB_COLLHEAD", "[گزینه های فرمت] نماش آیکن فشرده سازی");
define("_MI_PUB_COLLHEADDSC", "اکر این گزینه را روی  'بله' بگذارید، شرح مختصر شاخه در نوار جمع شده نشان داده خواهد شد، همینطور برای مقاله ها هم نشان داده خواهد شد.اگر 'نه' را انتخاب کنید، دکمه جمع شدن نمایش داده نخواهد شد.");
define("_MI_PUB_COMMENTS", "[دسترسی ها] کنترل روی نظر ها در سطح مقاله ها");
define("_MI_PUB_COMMENTSDSC", "اگر این گزینه را روی 'بله' بگذارید، فقط در مقاله هایی نظر ها را خواهید دید که داشتن نظر در مقاله تیک خورده باشد. <br /><br />'نه' را انتخاب کنید تا نظر ها را به صورت کلی مدیریت کنید (در زیر تگ 'قوانین نظر ها ' را ببینید.");
define("_MI_PUB_DATEFORMAT", "[گزینه های فرمت] فرمت تاریخ:");
define("_MI_PUB_DATEFORMATDSC", "قسمت آخر پرونده language/persian/global.php را ببینید تا بتوانید یک نوع نمایش تاریخ انتخاب کنید. مثال: \"d-M-Y H:i\" تبدیل میشود به  \" ۱۴-خرداد-۱۳۸۵ 22:35\"");
define("_MI_PUB_DEMO_SITE", "سایت نمایشی اسمارت فکتوری");
define("_MI_PUB_DEVELOPER_CONTRIBUTOR", "همکاران");
define("_MI_PUB_DEVELOPER_CREDITS", "عوامل سازنده");
define("_MI_PUB_DEVELOPER_EMAIL", "پست الکترونیکی");
define("_MI_PUB_DEVELOPER_LEAD", "توسعه دهنده اصلی");
define("_MI_PUB_DEVELOPER_WEBSITE", "وب سایت");
define("_MI_PUB_DISCOM", "[گزینه های متن] تعداد نظر ها نشان داده شود؟");
define("_MI_PUB_DISCOMDSC", " روی 'بله' قرار دهید تا تعداد نظر ها در هر مقاله نشان داده شود");
define("_MI_PUB_DISDATECOL", "[گزینه های متن] نمایش  ستون 'در سایت قرار گرفته در' ؟");
define("_MI_PUB_DISDATECOLDSC", "هنگامی که  نمایش به صورت'شرح خلاصه' انتخاب شده باشد، انتخاب 'بله' باعث خواهد شد ستون 'در سایت قرار گرفته در' در جدول موارد در صفحه اصلی و صفحه هر شاخه نمایش داده شود.");
define("_MI_PUB_DCS", "[گزینه های متن] نمایش خلاصه توضیح شاخه");
define("_MI_PUB_DCS_DSC", "'نه' را انتخاب کنید تا خلاصه توضیح شاخه در شاخه های که زیر شاخه ندارند نمایش داده نشود.");
define("_MI_PUB_DISPLAY_CATEGORY", "نمایش نام شاخه؟");
define("_MI_PUB_DISPLAY_CATEGORY_DSC", "روی 'بله' بگذارید تا لینک نام شاخه در هر مقاله نمایش داده شود");
define("_MI_PUB_DISPLAYTYPE_FULL", "نمایش کامل");
define("_MI_PUB_DISPLAYTYPE_LIST", "فهرست به صورت بالت");
define("_MI_PUB_DISPLAYTYPE_WFSECTION", "با استایل ماژول wfsection");
define("_MI_PUB_DISPLAYTYPE_SUMMARY", "نمایش خلاصه توضیح");
define("_MI_PUB_DISSBCATDSC", "[گزینه های متن] نمایش شرح زیر شاخه ها؟");
define("_MI_PUB_DISSBCATDSCDSC", "'بله' را انتخاب کنید تا شرح برای زیر شاخه ها در صفحه اصلی و در شاخه ها نمایش داده شود.");
define("_MI_PUB_DISTYPE", "[گزینه های متن] نوع نمایش مقاله ها:");
define("_MI_PUB_DISTYPEDSC", "اگر 'نمایش خلاصه توضیح' انتخاب شود، فقط نام، تاریخ و تعداد بازدید مقاله در شاخه انتخاب شده دیده خواهد شد. اگر 'نمایش کامل' انتخاب شود، هر مقاله به طور کامل در شاخه انتخاب شده نمایش داده خواهد شد.");
define("_MI_PUB_FILEUPLOADDIR", "شاخه بارگذاری پرونده های متصل شده:");
define("_MI_PUB_FILEUPLOADDIRDSC", "شاخه ای که پرونده های متصل شده به مقاله ها در آن ذخیره میشوند.لطفا در نوشتن مسیر دقت کنید.");
define("_MI_PUB_FOOTERPRINT","[گزینه های چاپ] پا صفحه صفحه چاپ");
define("_MI_PUB_FOOTERPRINTDSC","پا صفحه ای که برای هر مقاله در چاپ استفاده میشود");
define('_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY', 'شاخه جدید');
define('_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_CAP', 'وقتی شاخه جدیدی ساخته شد مرا با خبر كن');
define('_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_DSC', 'دریافت گزارش، زمانی که شاخه جدیدی ایجاد شد.');
define('_MI_PUB_GLOBAL_ITEM_CATEGORY_CREATED_NOTIFY_SBJ', '[{X_SITENAME}] {X_MODULE} آگهی رسانی خودکار : شاخه جدید');
define('_MI_PUB_GLOBAL_ITEM_NOTIFY', "مقالات كلی");
define('_MI_PUB_GLOBAL_ITEM_NOTIFY_DSC', "گزینه هایی که به متمام مقالات مربوط می شود.");
define('_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY', "قرار گرفتن مقاله جدید");
define('_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_CAP', "هر مقاله جدیدی كه در سایت قرار گرفت مرا با خبر كن.");
define('_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_DSC', "دریافت گزارش، زمانی که مقاله جدیدی انتشار یافت.");
define('_MI_PUB_GLOBAL_ITEM_PUBLISHED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} آگهی رسانی خود کار : یک مقاله جدید در سایت قرار گرفت");
define('_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY', "مقاله ارسال شده");
define('_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_CAP', "هر مقاله جدیدی كه در سایت ارسال شد و منتظر برای تایید قرار گرفت مرا با خبر كن");
define('_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_DSC', "دریافت گزارش، زمانی که مقاله جدیدی در ارسال شد و منتظر تایید بود");
define('_MI_PUB_GLOBAL_ITEM_SUBMITTED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} آگهی رسانی خودکار : یک مقاله جدید ارسال شد");
define("_MI_PUB_HEADERPRINT","[گزینه های چاپ] سر صفحه صفحه چاپ");
define("_MI_PUB_HEADERPRINTDSC","سر صفحه ای که برای هر مقاله در چاپ استفاده میشود");
define("_MI_PUB_HELP_CUSTOM", "مسیر دستی");
define("_MI_PUB_HELP_INSIDE", "درون ماژول");
define("_MI_PUB_HELP_PATH_CUSTOM", "مسیر دستی پرونده های کمکی ماژول اسمارت سکشن");
define("_MI_PUB_HELP_PATH_CUSTOM_DSC", "اگر در گزینه قبلی 'مسیر دستی' گزینه 'مسیر دستی پرونده های کمکی ماژول اسمارت سکشن' را  انتخاب کرده اید،  مسیر پرونده های کمکی را بنویسید، فرمت نوشتن مسیر به صورت مقابل است : http://www.yoursite.com/doc");
define("_MI_PUB_HELP_PATH_SELECT", "مسیر پرونده های کمکی ماژول اسمارت سکشن");
define("_MI_PUB_HELP_PATH_SELECT_DSC", "انتخاب کنید که از کجا میخواهید به پرونده های کمکی ماژول اسمتر سکشن دسترسی داشته باشید.اگر 'بسته پرونده های کمکی اسمارت سکشن' را دانلود کنید و سپس در شاخه 'modules/publisher/doc/'بارگذاری نمایید، میتوانید گزینه 'درون ماژول' را انتخاب کنید. به طور کلی، شما میتوانید به پرونده های کمکی ماژول به طور مستقیم در docs.xoops.org دسترسی داشته باشید. شما همچنین میتوانید 'مسیر دستی' را انتخاب کنید و برای خودتان مسیر پرونده های کمکی را بنویسید 'مسیر دستی پرونده های کمکی در اسمارت سکشن");
define("_MI_PUB_HITSCOL", "[گزینه های متن] نشان دادن ستون 'تعداد بازدید' ؟");
define("_MI_PUB_HITSCOLDSC", "هنگامی که نمایش به صورت 'خلاصه توضیح' انتخاب می شود،   'بله' را انتخاب کنید تا ستون 'تعداد بازدید' در جدول مقاله ها در صفحه اصلی و صفحه هر شاخه نشان داده شود.");
define("_MI_PUB_HLCOLOR", "[گزینه های فرمت] کلمات کلیدی های لایت شوند؟");
define("_MI_PUB_HLCOLORDSC", "کلمات کلیدی در هنگام جستجو های لایت میشوند");
define("_MI_PUB_IMAGENAV", "[گزینه های فرمت] استفاده از صفحه تصویری برای مرور صفحات:");
define("_MI_PUB_IMAGENAVDSC", "اگر این گزینه را روی \"بله\" قرار دهید، صفحه مرور صفحات با تصویر نمایش داده خواهد شد، در غیر این صورت صفحه مرور صفحات اولیه استفاده خواهد شد.");
define("_MI_PUB_INDEXFOOTER","[گزینه های متن] پا صفحه صفحه اصلی");
define("_MI_PUB_INDEXFOOTER_SEL","پا صفحه صفحه اصلی");
define("_MI_PUB_INDEXFOOTERDSC","پا صفحه ای که در صفحه اصلی ماژول نمایش داده می شود");
define("_MI_PUB_INDEXMSG", "[گزینه های متن] پیام خوش آمد گویی صفحه اصلی:");
define("_MI_PUB_INDEXMSGDEF", ""); 
define("_MI_PUB_INDEXMSGDSC", "پیام خوش آمد گویی که در صفحه اصلی ماژول نمایش داده می شود.");
define("_MI_PUB_ITEM_APPROVED_NOTIFY", "مقاله تایید شده");
define("_MI_PUB_ITEM_APPROVED_NOTIFY_CAP", "هنگامی که این مقاله تایید شد مرا با خبر کن");   
define("_MI_PUB_ITEM_APPROVED_NOTIFY_DSC", "آگاه شدن، زمانی که مقاله تایید شد.");      
define("_MI_PUB_ITEM_APPROVED_NOTIFY_SBJ", "[{X_SITENAME}] {X_MODULE} آگهی رسانی خودکار : مقاله تایید شده"); 
define('_MI_PUB_ITEM_NOTIFY', "مقاله");
define('_MI_PUB_ITEM_NOTIFY_DSC', "آگاه سازی هایی که مرتبط به مقاله فعلی هستند.");
define('_MI_PUB_ITEM_REJECTED_NOTIFY', "مقاله رد شده");
define('_MI_PUB_ITEM_REJECTED_NOTIFY_CAP', "هر مقاله ای كه تایید نشد و رد شد مرا با خبر كن");
define('_MI_PUB_ITEM_REJECTED_NOTIFY_DSC', "آگاه شدن، زمانی که مقاله تایید نشد.");
define('_MI_PUB_ITEM_REJECTED_NOTIFY_SBJ', "[{X_SITENAME}] {X_MODULE} آگهی رسانی خود کار : مقاله رد شده");
define("_MI_PUB_ITEM_TYPE", "نوع مورد:");
define("_MI_PUB_ITEM_TYPEDSC", "نوع موردی را که این ماژول باید مدیریت کند انتخاب کنید.");
define("_MI_PUB_ITEMFOOTER", "[گزینه های متن] پا صفحه مورد");
define("_MI_PUB_ITEMFOOTER_SEL", "پا صفحه مورد");
define("_MI_PUB_ITEMFOOTERDSC","پا صفحه ای که برای هر مقاله نمایش داده می شود");
define("_MI_PUB_ITEMSMENU", "بلاک منوی شاخه ها");
//bd tree block hack
define("_MI_PUB_ITEMSTREE", "بلاک درختی");
//--/bd
define("_MI_PUB_ITEMSNEW", "فهرست موارد جدید");
define("_MI_PUB_ITEMSPOT", "در اسپات لایت نمایش داده شود!");
define("_MI_PUB_ITEMSRANDOM_ITEM", "مورد به صورت تصادفی!");
define("_MI_PUB_LASTITEM", "[گزینه های متن] نمایش ستون آخرین مورد؟");
define("_MI_PUB_LASTITEMDSC", "'بله' را انتخاب کنید تا آخرین مورد مربوط به هر شاخه در صفحه اصلی و صفحه شاخه ها نمایش داده شود.");
define("_MI_PUB_LASTITEMS", "[گزینه های متن] نمایش فهرست جدیدترین مقالات قرار گرفته در سایت؟");
define("_MI_PUB_LASTITEMSDSC", "'بله' را انتخاب کنید تا فهرستی از آخرین مقالات در پایین صفحه اول ماژول داشته باشید");
define("_MI_PUB_LASTITSIZE", "[گزینه های فرمت] اندازه آخرین مورد :");
define("_MI_PUB_LASTITSIZEDSC", "حداکثر اندازه نام را برای ستون آخرین مورد تعیین کنید.");
define("_MI_PUB_LINKPATH", "[گزینه های فرمت] اجاز دادن به لینک ها در آدرس فعلی");
define("_MI_PUB_LINKPATHDSC", "این گزینه به کاربران اجازه می دهد که برای ترک-بک با کلیک برروی یکی از بخش ها آدرس فعلی در بالای صفحه نمایان شود");
define("_MI_PUB_MAX_HEIGHT", "[دسترسی ها] حداکثر طول مجاز برای بارگذاری تصویر");
define("_MI_PUB_MAX_HEIGHTDSC", "حداکثر اندازه طول پرونده تصویری که میتواند بارگذاری شود.");
define("_MI_PUB_MAX_SIZE", "[دسترسی ها] حداکثر اندازه پرونده");
define("_MI_PUB_MAX_SIZEDSC", "حداکثر اندازه (به صورت بایت) پرونده که می تواند بارگذاری شود.");
define("_MI_PUB_MAX_WIDTH", "[دسترسی ها] حداکثر عرض مجاز برای بارگذاری تصویر");
define("_MI_PUB_MAX_WIDTHDSC", "حداکثر اندازه عرض پرونده تصویری که میتواند بارگذاری شود.");
define("_MI_PUB_MD_DESC", "سیستم مدیریت مقاله ها برای سایت شما");
define("_MI_PUB_MD_NAME", "اسمارت سکشن");
define("_MI_PUB_MODULE_BUG", "ارسال یک خطا برای این ماژول");
define("_MI_PUB_MODULE_DEMO", "سایت نمایشی");
define("_MI_PUB_MODULE_DISCLAIMER", "شرایط");
define("_MI_PUB_MODULE_FEATURE", "پیشنهاد امکانات جدید برای این ماژول");
define("_MI_PUB_MODULE_INFO", "جزییات توسعه ماژول");
define("_MI_PUB_MODULE_RELEASE_DATE", "تاریخ انتشار");
define("_MI_PUB_MODULE_STATUS", "حالت");
define("_MI_PUB_MODULE_SUBMIT_BUG", "ارسال یک خطا");
define("_MI_PUB_MODULE_SUBMIT_FEATURE", "ارسال  پیشنهاد برای امکانات جدید");
define("_MI_PUB_MODULE_SUPPORT", "سایت رسمی پشتیبانی");
define("_MI_PUB_NO_FOOTERS","هیچ کدام");
define("_MI_PUB_ORDERBY", "[گزینه های فرمت] نحوه چینش");
define("_MI_PUB_ORDERBY_DATE", "تاریخ صعودی");
define("_MI_PUB_ORDERBY_TITLE", "نام صعودی");
define("_MI_PUB_ORDERBY_WEIGHT", "وزن صعودی");
define("_MI_PUB_ORDERBYDSC", "نحوه چینش موارد را در ماژول انتخاب کنید.");
define("_MI_PUB_OTHER_ITEMS_TYPE_ALL", "همه مقاله ها");
define("_MI_PUB_OTHER_ITEMS_TYPE_NONE", "هیچ کدام");
define("_MI_PUB_OTHER_ITEMS_TYPE_PREVIOUS_NEXT", "مقاله قبلی و بعدی");
define("_MI_PUB_OTHERITEMS", "[گزینه های فرمت] نوع نمایش سایر مقالات");
define("_MI_PUB_OTHERITEMSDSC", "انتخاب کنید که در هنگام دیدن یک مقاله  سایر مقالات در آن شاخه چگونه نشان داده شوند.");
define("_MI_PUB_PERPAGE", "[گزینه های فرمت] حداکثر تعداد مقالات در یک صفحه (سمت مدیر):");
define("_MI_PUB_PERPAGEDSC", "حداکثر تعداد مقالاتی که در یک صفحه در سمت مدیر نمایش داده می شود.");
define("_MI_PUB_PERPAGEINDEX", "[گزینه های فرمت] حداکثر تعداد مقالات در یک صفحه (سمت کاربر):");
define("_MI_PUB_PERPAGEINDEXDSC", "[گزینه های فرمت] حداکثر تعداد مقالاتی که در یک صفحه در سمت کاربر نمایش داده می شود.");
define("_MI_PUB_PRINTLOGOURL","[گزینه های چاپ] آدرس لوگو در هنگام چاپ");
define("_MI_PUB_PRINTLOGOURLDSC","آدرس لوگویی که در هنگام چاپ در بالای صفحه قرار میگیرد");
define("_MI_PUB_RECENTITEMS", "موارد اخیر (جزییات)");
define("_MI_PUB_SHOW_RSS","[گزینه های متن] لینک منبع تغذیه RSS نشان داده شود؟");
define("_MI_PUB_SHOW_RSSDSC","");
define("_MI_PUB_SHOW_SUBCATS", "[گزینه های متن] نمایش زیر شاخه ها");
define("_MI_PUB_SHOW_SUBCATS_ALL", "نمایش همه زیر شاخه ها");
define("_MI_PUB_SHOW_SUBCATS_DSC", "انتخاب که آیا میخواهید زیر شاخه ها را در فهرست شاخه ها در صفحه اصلی ماژول یا در یک شاخه ببینید");
define("_MI_PUB_SHOW_SUBCATS_NO", "زیر شاخه ها را نشان نده");
define("_MI_PUB_SHOW_SUBCATS_NOTEMPTY", "زیر  شاخه هایی را که خالی نیستند  نشان بده");
define("_MI_PUB_SUB_SMNAME1", "ارسال یک مقاله");
define("_MI_PUB_SUB_SMNAME2", "مقالات پر طرفدار");
define("_MI_PUB_SUBMITMSG", "[گزینه های متن] نمایش پیام معرفی در صفحه ارسال:");
define("_MI_PUB_SUBMITMSGDEF", "");
define("_MI_PUB_SUBMITMSGDSC", "پیام معرفی که در صفحه ارسال ماژول نمایش داده می شود.");
define("_MI_PUB_TITLE_SIZE", "[گزینه های فرمت] اندازه نام :");
define("_MI_PUB_TITLE_SIZEDSC", "حداکثر اندازه نام  برای مقالات در صفحه ای که یک مقاله نمایش داده می شود.");
define("_MI_PUB_UPLOAD", "[دسترسی ها] بارگذاری پرونده توسط کاربران؟");
define("_MI_PUB_UPLOADDSC", "آیا به کاربران این اجازه را می دهید که پرونده هایی را که به مقالات لینک می شوند در سایت بارگذاری کنند؟");
define("_MI_PUB_USEREALNAME", "[گزینه های فرمت] استفاده از نام واقعی");
define("_MI_PUB_USEREALNAMEDSC", "هنگامی که نمایش نام کاربری فعال است، اگر کاربر نام واقعی را نوشته باشد از نام واقعی کاربر استفاده میکند.");
define("_MI_PUB_VERSION_HISTORY", "تاریخچه نسخه");
define("_MI_PUB_WARNING_BETA", "This module comes as is, without any guarantees whatsoever. This module is BETA, meaning it is still under active development. This release is meant for <b>testing purposes only</b> and we <b>strongly</b> recommend that you do not use it on a live website or in a production environment.");
define("_MI_PUB_WARNING_FINAL", "This module comes as is, without any guarantees whatsoever. Although this module is not beta, it is still under active development. This release can be used in a live website or a production environment, but its use is under your own responsibility, which means the author is not responsible.");
define("_MI_PUB_WARNING_RC", "This module comes as is, without any guarantees whatsoever. This module is a Release Candidate and should not be used on a production web site. The module is still under active development and its use is under your own responsibility, which means the author is not responsible.");
define("_MI_PUB_WELCOME", "[گزینه های متن] نمایش نام و متن خوش آمد گویی:");
define("_MI_PUB_WELCOMEDSC", "اگر این گزینه روی 'بله' باشد، در صفحه اول ماژول پیامی با مطلع 'به ماژول اسمارت سکشن خوش آمدید'، نوشته می شود که در ادامه آن پیامی که در زیر مینویسید خواهد آمد.اگر روی 'نه' باشد، هیچ کدام از جمله ها نوشته نخواهند شد.");
define("_MI_PUB_WHOWHEN", "[گزینه های متن] نمایش ارسال کننده و تاریخ");
define("_MI_PUB_WHOWHENDSC", "روی 'بله' قرار دهید تا نام ارسال کننده مقاله و تاریخ ارسال آن در هر مقاله نوشته شود");
define("_MI_PUB_WYSIWYG", "[گزینه های متن] نوع ویرایشگر");
define("_MI_PUB_WYSIWYGDSC", "چه نوع ادیتوری را میخواهید استفاده کنید.لطفا توجه کنید که انتخاب هر ویرایشگری به غیر از ویرایشگر زوپس، مستلزم این است که ویرایشگر بر روی سایت شما نصب شده باشد.");

define("_MI_PUB_PV_TEXT", "پیام دیدن جزئی");
define("_MI_PUB_PV_TEXTDSC", "پیام برای مقالاتی که فقط قسمتی از آنها مشهود می باشد");
define("_MI_PUB_PV_TEXT_DEF", "برای دیدن کل مقاله باید عضو شوید");

define("_MI_PUB_SEOMODNAME", "استفاده از نام نگاری مجدد در آدرس");
define("_MI_PUB_SEOMODNAMEDSC", "اگر این گزینه برای ماژول فعال باشد, این نام ماژولی است که استفاده خواهد شد. برای مثال: http://yoursite.com/smartection/...");

define("_MI_PUB_ARTCOUNT", "نمایش شمارنده مقالات");
define("_MI_PUB_ARTCOUNTDSC", "بله را انتخاب کنید  تا شمارنده های بکار رفته در هر شاخه در جدول خلاصه های شاخه نمایان شود. توجه کنید که این ماژول فقط مقالاتی را محاسبه می کند که در شاخه ها می باشند و مقالاتی که در زیر شاخه ها قرار دارند حساب نمی شوند");

define("_MI_PUB_LATESTFILES", "آخرین پرونده های بارگذاری شده");

define("_MI_PUB_PATHSEARCH", "[گزینه های فرمت] نمایش آدرس شاخه در نتایج جست و جو");
define("_MI_PUB_PATHSEARCHDSC", "");
define("_MI_PUB_SHOW_SUBCATS_NOMAIN", "نمایش زیرشاخه ها فقط در صفحه فهرست‌ها");
define("_MI_PUB_RATING_ENABLED", "فعال کردن سیستم رای دهی");
define("_MI_PUB_RATING_ENABLEDDSC", "برای استفاده از قابلیت باید ماژول SmartObject را نصب کرده باشید");

define("_MI_PUB_DISPBREAD", "نمایش breadcrumb");
define("_MI_PUB_DISPBREADDSC", "");

define('_MI_PUB_DATE_TO_DATE', 'مقالات از تاریخ تا تاریخ')
?>