Important to know:

Links and images are relative to the root of your site:
modules/profile
search.php
uploads/blank.gif


You can use DECORATORS for links, title, and alt_title.
The decorators follow this sintax: 
{decorator|value}

There are 4 decorators available:
USER -> gets info for the user that is seing the page
OWNER -> gets info for the user that match uid on the url(if given)
URI -> gets info about the url arguments
MODULE -> gets dynamic menu from a module (Used in title field only)

Some sintax examples
{USER|UNAME} gets the username of this user, returns anonymous if not a user
{USER|UID} gets the uid of this user, returns 0 if not a user
{USER|REGDATE} gets the regdate of this user, returns empty if not a user
{USER|any other field of the user table} yes! You can get what you need!

Some special fields you may use
{USER|PM_NEW} Show number of private messages not readed
{USER|PM_READED}
{USER|PM_TOTAL}

The same is valid for OWNER:
{OWNER|UNAME}
{OWNER|UID}
etc..

And you can get any paramater on the uri with:
{URI|UID}
{URI|ID}
{URI|SEARCH}
{URI|ITEMID}
{URI|CATID}
etc...

Example of links using decorators:
modules/profile/userinfo.php?uid={USER|UID}
modules/yogurt/pictures.php?uid={OWNER|UID}

Example on titles using decorators:
{USER|UNAME}
{OWNER|UNAME} profile
You have searched for {URI|SEARCH}

Poupulating menus with modules information:
{MODULE|NEWS}
{MODULE|XHELP}
{MODULE|MYLINKS}
{MODULE|TDMDOWNLOADS}
